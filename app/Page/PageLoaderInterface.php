<?php

declare(strict_types=1);

namespace App\Page;

interface PageLoaderInterface
{
    public static function create();

    public function load(string $url): PageLoaderResult;
}
