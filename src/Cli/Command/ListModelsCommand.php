<?php
/**
 * File: ListModelsCommand.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Cli\Command;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use MSlwk\Otomoto\Middleware\App\Model\ModelFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListModelsCommand
 * @package MSlwk\Otomoto\Cli\Command
 */
class ListModelsCommand extends Command
{
    const COMMAND_NAME = 'app:manufacturer-models';
    const COMMAND_DESC = 'List all available models for a manufacturer';

    const MANUFACTURER_ARG_NAME = 'manufacturer';
    const MANUFACTURER_ARG_DESC = 'Full manufacturer name';

    /**
     * @var ModelFactory
     */
    private $modelMiddlewareFactory;

    /**
     * ListModelsCommand constructor.
     * @param ModelFactory|null $modelMiddlewareFactory
     * @param null $name
     */
    public function __construct(ModelFactory $modelMiddlewareFactory = null, $name = null)
    {
        parent::__construct($name);
        $this->modelMiddlewareFactory = $modelMiddlewareFactory ?? new ModelFactory();
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
        $manufacturer = new ManufacturerDTO($input->getArgument(self::MANUFACTURER_ARG_NAME));
        $modelMiddleware = $this->modelMiddlewareFactory->create();
        $models = $modelMiddleware->getModels($manufacturer);

        foreach ($this->groupModelsByFirstLetter($models) as $model) {
            $output->writeln("<info>{$model}</info>");
        }
    }

    /**
     * @param ModelDTOArray $modelDTOArray
     * @return array
     */
    private function groupModelsByFirstLetter(ModelDTOArray $modelDTOArray): array
    {
        $modelsNames = [];
        foreach ($modelDTOArray as $modelDTO) {
            $firstLetter = substr($modelDTO->getName(), 0, 1);
            if (!isset($modelsNames[$firstLetter])) {
                $modelsNames[$firstLetter] = "{$firstLetter}: {$modelDTO->getName()}";
            } else {
                $modelsNames[$firstLetter] .= ", {$modelDTO->getName()}";
            }
        }

        ksort($modelsNames);
        return $modelsNames;
    }
}
