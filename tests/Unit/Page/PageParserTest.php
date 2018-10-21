<?php

namespace Tests\Unit\Page;

use App\Page\PageLoader;
use App\Page\PageLoaderResult;
use App\Page\PageParser;
use Tests\TestCase;

class PageParserTest extends TestCase
{

    public function testShouldLoadPlainText()
    {
        $stub = $this->createMock(PageLoader::class);
        $stub->method('load')->willReturn(new PageLoaderResult('Some test data 123,   test - Test123 777 '));

        $parser = PageParser::create($stub);

        $this->assertEquals([
            'Test',
            'test',
            'data',
            'Some'
            ], $parser->getWords('test'), 'Return result is wrong!', 0, 10, true);
    }

    public function testShouldTestEmptyResult()
    {
        $stub = $this->createMock(PageLoader::class);
        $stub->method('load')->willReturn(new PageLoaderResult(''));

        $parser = PageParser::create($stub);

        $this->assertEquals([], $parser->getWords(''));
    }

    public function testShouldLoadHTMLDocument()
    {
        $stub = $this->createMock(PageLoader::class);
        $stub->method('load')->willReturn(new PageLoaderResult('
            <html>
                <header></header>
                <body>
                    <h1>Test page!</h1>
                    <p>Some test <b>text</b></p>
                    <a href="/">link</a>              
                </body>
            </html>
        ', 'text/html'));

        $parser = PageParser::create($stub);

        $this->assertEquals([
            'Test',
            'page',
            'Some',
            'test',
            'text',
            'link',
        ], $parser->getWords(''), 'Return result is wrong!', 0, 10, true);
    }
}
