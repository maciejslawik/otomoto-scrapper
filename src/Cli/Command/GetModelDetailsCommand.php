<?php
/**
 * File: GetModelDetailsCommand.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Cli\Command;

use MSlwk\Otomoto\App\Exception\NoSuchFilterException;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;
use MSlwk\Otomoto\App\Stats\Filter\FilterArray;
use MSlwk\Otomoto\App\Stats\Filter\FilterFactory;
use MSlwk\Otomoto\Middleware\App\Stats\StatsFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GetModelDetailsCommand
 * @package MSlwk\Otomoto\Cli\Command
 */
class GetModelDetailsCommand extends Command
{
    const COMMAND_NAME = 'app:model-details';
    const COMMAND_DESC = 'Retrieve stats for car model';

    const MANUFACTURER_ARG_NAME = 'manufacturer';
    const MANUFACTURER_ARG_DESC = 'Full manufacturer name';

    const MODEL_ARG_NAME = 'model';
    const MODEL_ARG_DESC = 'Full model name';

    const FROM_YEAR_OPTION_NAME = 'from';
    const FROM_YEAR_OPTION_DESC = 'From year of production';
    const FROM_YEAR_OPTION_SHORTCUT = 'f';

    const TO_YEAR_OPTION_NAME = 'to';
    const TO_YEAR_OPTION_DESC = 'To year of production';
    const TO_YEAR_OPTION_SHORTCUT = 't';

    /**
     * @var StatsFactory
     */
    private $statsFactory;

    /**
     * @var FilterFactory
     */
    private $filterFactory;

    /**
     * GetModelDetailsCommand constructor.
     * @param StatsFactory|null $statsFactory
     * @param FilterFactory|null $filterFactory
     * @param null $name
     */
    public function __construct(
        StatsFactory $statsFactory = null,
        FilterFactory $filterFactory = null,
        $name = null
    ) {
        parent::__construct($name);
        $this->statsFactory = $statsFactory ?? new StatsFactory();
        $this->filterFactory = $filterFactory ?? new FilterFactory();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESC)
            ->addArgument(
                self::MANUFACTURER_ARG_NAME,
                InputArgument::REQUIRED,
                self::MANUFACTURER_ARG_DESC
            )->addArgument(
                self::MODEL_ARG_NAME,
                InputArgument::REQUIRED,
                self::MODEL_ARG_DESC
            )->addOption(
                self::FROM_YEAR_OPTION_NAME,
                self::FROM_YEAR_OPTION_SHORTCUT,
                InputOption::VALUE_OPTIONAL,
                self::FROM_YEAR_OPTION_DESC
            )->addOption(
                self::TO_YEAR_OPTION_NAME,
                self::TO_YEAR_OPTION_SHORTCUT,
                InputOption::VALUE_OPTIONAL,
                self::TO_YEAR_OPTION_DESC
            );

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manufacturerName = $input->getArgument(self::MANUFACTURER_ARG_NAME);
        $modelName = $input->getArgument(self::MODEL_ARG_NAME);
        $options = $input->getOptions();

        $manufacturer = new ManufacturerDTO($manufacturerName);
        $model = new ModelDTO($modelName);
        $filters = $this->transformOptionsToFilters($options);

        $this->displaySearchParams($manufacturer, $model, $filters, $output);

        $statsMiddleware = $this->statsFactory->create();
        $stats = $statsMiddleware->getStats($manufacturer, $model, $filters);

        $this->displayStats($stats, $output);
    }

    /**
     * @param array $options
     * @return FilterArray
     */
    private function transformOptionsToFilters(array $options): FilterArray
    {
        $filterArray = new FilterArray();
        foreach ($options as $name => $value) {
            try {
                if ($value) {
                    $filter = $this->filterFactory->create($name, $value);
                    $filterArray->add($filter);
                }
            } catch (NoSuchFilterException $e) {

            }
        }
        return $filterArray;
    }

    /**
     * @param float $average
     * @return float
     */
    private function formatStatsData(float $average): float
    {
        return round($average);
    }

    /**
     * @param ManufacturerDTOInterface $manufacturer
     * @param ModelDTOInterface $model
     * @param FilterArray $filters
     * @param OutputInterface $output
     * @return void
     */
    private function displaySearchParams(
        ManufacturerDTOInterface $manufacturer,
        ModelDTOInterface $model,
        FilterArray $filters,
        OutputInterface $output
    ): void {
        $output->writeln(
            "<info>Manufacturer: {$manufacturer->getName()}</info>"
        );
        $output->writeln(
            "<info>Model: {$model->getName()}</info>"
        );
        foreach ($filters as $filter) {
            $output->writeln(
                "<info>{$filter->getDescription()}: {$filter->getValue()}</info>"
            );
        }
    }

    /**
     * @param StatsDTOInterface $stats
     * @param OutputInterface $output
     * @return void
     */
    private function displayStats(StatsDTOInterface $stats, OutputInterface $output): void
    {
        $output->writeln(
            "<comment>Average mileage: {$this->formatStatsData($stats->getAverageMileage())} km</comment>"
        );
        $output->writeln(
            "<comment>Average price: {$this->formatStatsData($stats->getAveragePrice())} PLN</comment>"
        );
        $output->writeln(
            "<comment>Average year: {$this->formatStatsData($stats->getAverageYear())}</comment>"
        );
    }
}
