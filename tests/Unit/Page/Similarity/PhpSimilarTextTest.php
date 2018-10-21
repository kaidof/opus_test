<?php

namespace Tests\Unit\Page\Similarity;

use App\Page\Similarity\PhpSimilarText;
use Tests\TestCase;

class PhpSimilarTextTest extends TestCase
{

    public function testShouldCreateClass()
    {
        $similarity = new PhpSimilarText(1);

        $this->assertInstanceOf('App\Page\Similarity\PhpSimilarText', $similarity);
    }
}
