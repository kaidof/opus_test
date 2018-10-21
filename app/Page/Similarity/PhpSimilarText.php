<?php

declare(strict_types=1);

namespace App\Page\Similarity;

use App\Word;

class PhpSimilarText extends SimilarityBase implements SimilarityInterface
{

    /**
     * PhpSimilarText constructor.
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
            similar_text($word, $item, $perc);
            $arr[$item] = $perc;
        }

        arsort($arr);

        return array_keys(array_slice($arr, 0 , $this->limit));
    }
}
