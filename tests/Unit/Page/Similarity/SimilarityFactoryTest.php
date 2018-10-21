<?php

namespace Tests\Unit\Page\Similarity;

use App\Page\Similarity\SimilarityFactory;
use Tests\TestCase;

class SimilarityFactoryTest extends TestCase
{

    public function testShouldGetClass()
    {
        $this->assertInstanceOf('App\Page\Similarity\Postgres', SimilarityFactory::get(SimilarityFactory::TYPE_POSTGRES));
        $this->assertInstanceOf('App\Page\Similarity\PhpLevenshtein', SimilarityFactory::get(SimilarityFactory::TYPE_PHP_LEVENSHTEIN));
        $this->assertInstanceOf('App\Page\Similarity\PhpSimilarText', SimilarityFactory::get(SimilarityFactory::TYPE_PHP_SIMILAR_TEXT));
    }

    public function testShouldGetEnvDefinedClass()
    {
        config()->set('services.similarity.engine', SimilarityFactory::TYPE_POSTGRES);
        $this->assertInstanceOf('App\Page\Similarity\Postgres', SimilarityFactory::get());

        config()->set('services.similarity.engine', SimilarityFactory::TYPE_PHP_LEVENSHTEIN);
        $this->assertInstanceOf('App\Page\Similarity\PhpLevenshtein', SimilarityFactory::get());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Similarity engine is not defined!
     */
    public function testShouldThrowIfNoEnvVariableDefined()
    {
        config()->set('services.similarity.engine', null);
        SimilarityFactory::get();
    }
}
