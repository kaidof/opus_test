<?php

declare(strict_types=1);

namespace App\Page\Similarity;

use App\Word;

class PhpLevenshtein extends SimilarityBase implements SimilarityInterface
{

    /**
     * PhpLevenshtein constructor.
     *
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        parent::__construct($limit);
    }

    /**
     * @param string $word
     *
     * @return array
     */
    public function getList(string $word): array
    {
        $all = Word::select('word')->get()->toArray();
        $words = array_column($all, 'word');

        $arr = [];
        foreach ($words as $item) {
            $arr[$item] = levenshtein($word, $item);
        }

        asort($arr);

        return array_keys(array_slice($arr, 0 , $this->limit));
    }
}
