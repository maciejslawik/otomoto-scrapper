<?php
/**
 * File: CocurSlugifyAdapterTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Slugify;

use MSlwk\Otomoto\Middleware\Slugify\CocurSlugifyAdapter;
use PHPUnit\Framework\TestCase;

/**
 * Class CocurSlugifyAdapterTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Slugify
 */
class CocurSlugifyAdapterTest extends TestCase
{
    /**
     * @return array
     */
    public function slugifyDataProvider()
    {
        return [
            [
                'Alfa Romeo',
                'alfa-romeo'
            ],
            [
                'BMW',
                'bmw'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider slugifyDataProvider
     */
    public function testSlugifierReturnsCorrectlySlugifiedString($toSlugify, $slugified)
    {
        $slugifier = new CocurSlugifyAdapter();
        $this->assertEquals($slugified, $slugifier->slugify($toSlugify));
    }
}
