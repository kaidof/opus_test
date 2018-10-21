<?php

declare(strict_types=1);

namespace App\Page;

/**
 * @codeCoverageIgnore
 */
class PageLoader implements PageLoaderInterface
{
    /**
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Loads web content
     *
     * @param string $url
     *
     * @return PageLoaderResult
     */
    public function load(string $url): PageLoaderResult
    {
        try {
            $result = @file_get_contents($url);
            if ($result) {
                $contentType = null;

                // What content type?
                foreach ($http_response_header as $header) {
                    if (preg_match('/^Content-Type:/i', $header)) {
                        $contentType = trim(explode(':', $header, 2)[1]);
                        break;
                    }
                }

                return new PageLoaderResult($result, $contentType);
            }
        } catch (\Exception $e) {}

        return new PageLoaderResult('');
    }
}
