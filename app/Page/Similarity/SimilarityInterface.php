<?php

declare(strict_types=1);

namespace App\Page\Similarity;

interface SimilarityInterface
{
    public function __construct(int $limit);

    public function getList(string $word): array;
}
