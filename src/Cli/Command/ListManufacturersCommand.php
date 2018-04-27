<?php
/**
 * File: ListManufacturersCommand.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Cli\Command;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\Middleware\App\Manufacturer\ManufacturerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListManufacturersCommand
 * @package MSlwk\Otomoto\Cli\Command
 */
class ListManufacturersCommand extends Command
{
    const COMMAND_NAME = 'app:manufacturer-list';
    const COMMAND_DESC = 'List all available manufacturers';

    /**
     * @var ManufacturerFactory
     */
    private $manufacturerMiddlewareFactory;

    /**
     * ListManufacturersCommand constructor.
     * @param ManufacturerFactory|null $manufacturerFactory
     * @param null $name
     */
    public function __construct(ManufacturerFactory $manufacturerFactory = null, $name = null)
    {
        parent::__construct($name);
        $this->manufacturerMiddlewareFactory = $manufacturerFactory ?? new ManufacturerFactory();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESC);

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manufacturerMiddleware = $this->manufacturerMiddlewareFactory->create();
        $manufacturers = $manufacturerMiddleware->getManufacturers();

        foreach ($this->groupManufacturersByFirstLetter($manufacturers) as $manufacturerLine) {
            $output->writeln("<info>{$manufacturerLine}</info>");
        }
    }

    /**
     * @param ManufacturerDTOArray $manufacturerDTOArray
     * @return array
     */
    private function groupManufacturersByFirstLetter(ManufacturerDTOArray $manufacturerDTOArray): array
    {
        $manufacturersNames = [];
        foreach ($manufacturerDTOArray as $manufacturerDTO) {
            $firstLetter = substr($manufacturerDTO->getName(), 0, 1);
            if (!isset($manufacturersNames[$firstLetter])) {
                $manufacturersNames[$firstLetter] = "{$firstLetter}: {$manufacturerDTO->getName()}";
            } else {
                $manufacturersNames[$firstLetter] .= ", {$manufacturerDTO->getName()}";
            }
        }

        ksort($manufacturersNames);
        return $manufacturersNames;
    }
}
