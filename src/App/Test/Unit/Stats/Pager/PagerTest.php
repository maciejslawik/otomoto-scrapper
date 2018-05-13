<?php
declare(strict_types=1);

/**
 * File:PagerTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Pager;

use MSlwk\Otomoto\App\Stats\Pager\Pager;
use PHPUnit\Framework\TestCase;

/**
 * Class PagerTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Pager
 */
class PagerTest extends TestCase
{
    /**
     * @test
     */
    public function testPagerReturnsCorrectParam()
    {
        $pager = new Pager();

        $expectedParameter = 'page=4';
        $result = $pager->getPagerParameter(4);

        $this->assertEquals($expectedParameter, $result);
    }
}
