<?php

declare(strict_types=1);

namespace App\Page;

class PageLoaderResult
{
    /**
     * @var string
     */
    private $content = '';

    /**
     * @var null|string
     */
    private $type;

    /**
     * PageLoaderResult constructor.
     *
     * @param string $content
     * @param null|string $type source content type
     */
    public function __construct(string $content, ?string $type = null)
    {
        $this->content = $content;
        $this->type = $type;
    }

    /**
     * Return page content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Return page content type
     *
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
