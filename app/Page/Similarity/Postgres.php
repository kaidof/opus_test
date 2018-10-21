<?php

declare(strict_types=1);

namespace App\Page\Similarity;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Postgres extends SimilarityBase implements SimilarityInterface
{

    /**
     * Postgres constructor.
     *
     * @param int $limit
     *
     * @throws \Exception
     */
    public function __construct(int $limit)
    {
        parent::__construct($limit);

        if (Config::get('database.default') !== 'pgsql') {
            throw new \Exception('Database is not PostgreSQL!');
        }
    }

    /**
     * @param string $word
     *
     * @return array
     */
    public function getList(string $word): array
    {
        $res = DB::select('SELECT * FROM
            (SELECT word, levenshtein(:item, word) FROM words) x
            ORDER BY 2
            LIMIT :limit', ['item' => $word, 'limit' => $this->limit]);

        return array_column($res, 'word');
    }
}
