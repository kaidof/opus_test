<?php

namespace Tests\Unit\Page\Similarity;

use App\Page\Similarity\Postgres;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostgresTest extends TestCase
{

    public function testShouldSetLimit()
    {
        $similarity = new Postgres(2);
        $similarity->setLimit(99);

        $this->assertInstanceOf('App\Page\Similarity\Postgres', $similarity);

        $reflection = new \ReflectionObject($similarity);
        $refProperty = $reflection->getProperty('limit');
        $refProperty->setAccessible(true);

        $this->assertEquals(99, $refProperty->getValue($similarity));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Database is not PostgreSQL!
     */
    public function testShouldThrowIfDbIsNotPostgres()
    {
        config()->set('database.default', 'mysql');

        new Postgres(2);
    }

    public function testShouldGetList()
    {
        $returnList = [
            ['word' => 'bb'],
            ['word' => 'aa'],
            ['word' => 'cc'],
        ];

        DB::shouldReceive('select')->andReturn($returnList);

        $similarity = new Postgres(2);

        $this->assertEquals([
            'bb',
            'aa',
            'cc',
        ], $similarity->getList('aa'));

    }

}
