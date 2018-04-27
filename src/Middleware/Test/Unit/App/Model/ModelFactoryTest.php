<?php
/**
 * File: ModelFactoryTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Model;

use MSlwk\Otomoto\Middleware\App\Model\Model;
use MSlwk\Otomoto\Middleware\App\Model\ModelFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelFactoryTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Model
 */
class ModelFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testFactoryCreatesCorrectInstance()
    {
        $modelFactory = new ModelFactory();
        $model = $modelFactory->create();

        $expectedType = Model::class;
        $this->assertInstanceOf($expectedType, $model);
    }
}