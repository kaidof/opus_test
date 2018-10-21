<?php

declare(strict_types=1);

namespace App\Page;

class PageParser
{
    /**
     * @var PageLoaderInterface
     */
    private $loader;

    /**
     * @param \App\Page\PageLoaderInterface $loader
     *
     * @return self
     */
    public static function create(PageLoaderInterface $loader)
    {
        return new self($loader);
    }

    /**
     * PageParser constructor.
     *
     * @param \App\Page\PageLoaderInterface $loader
     */
    public function __construct(PageLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Return unique words array from web
     *
     * @param string $url
     *
     * @return array
     */
    public function getWords(string $url): array
    {
        $content = $this->loadPageContent($url);

        $wordsArray = array_map(function($str) {
            // Ignore numbers
            if (is_numeric($str)) {
                return null;
            }

            // Allow only normal text
            $strClean = preg_replace('/\PL/u', '', $str);
            if ($strClean !== $str) {
                $str = $strClean;
            }

            // No empty string
            if (!trim($str)) {
                return null;
            }

            return $str;
        }, preg_split('/\s/', $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE));

        // Remove duplicates and NULL values
        return array_unique(array_filter($wordsArray));
    }

    /**
     * Loads text from web and filter unnecessary gibberish
     *
     * @param string $url
     *
     * @return string
     */
    private function loadPageContent(string $url): string
    {
        $loadResult = $this->loader->load($url);

        if ($loadResult->getContent()) {
            if ($loadResult->getType() && preg_match('/^text\/html/i', $loadResult->getType())) {
                // HTML document
                $dom = new \DOMDocument;
                @$dom->loadHTML($loadResult->getContent());
                $body = $dom->getElementsByTagName('body')->item(0);

                $content = $dom->saveHTML($body);

                // Cleanup from tags
                $content = preg_replace("/<script.*?\/script>/s", '', $content);
                $content = preg_replace("/<style.*?\/style>/s", '', $content);
                $content = strip_tags($content);

                return $content;
            }

            // Text document
            return $loadResult->getContent();
        }

        // No result
        return '';
    }

}
