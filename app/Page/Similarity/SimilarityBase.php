<?php

declare(strict_types=1);

namespace App\Page\Similarity;

class SimilarityBase
{
    /**
     * How many words to return
     *
     * @var int
     */
    protected $limit = 10;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }
}
