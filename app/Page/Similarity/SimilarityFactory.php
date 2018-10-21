<?php

declare(strict_types=1);

namespace App\Page\Similarity;

use Illuminate\Support\Facades\Config;

class SimilarityFactory
{
    public const TYPE_POSTGRES = 'postgres';
    public const TYPE_PHP_LEVENSHTEIN = 'php-levenshtein';
    public const TYPE_PHP_SIMILAR_TEXT = 'php-similar-text';

    /**
     * @param null|string $type
     * @param int|null $limit how many words to return
     *
     * @return \App\Page\Similarity\SimilarityInterface
     * @throws \Exception
     */
    public static function get(?string $type = null, int $limit = null): SimilarityInterface
    {
        if ($type === null) {
            // Set type if not provided
            $type = Config::get('services.similarity.engine');
        }

        if ($limit === null) {
            // Set limit if not provided
            $limit = Config::get('services.similarity.limit', 10);
        }

        switch ($type) {
            case self::TYPE_POSTGRES:
                return new Postgres($limit);
            case self::TYPE_PHP_LEVENSHTEIN:
                return new PhpLevenshtein($limit);
            case self::TYPE_PHP_SIMILAR_TEXT:
                return new PhpSimilarText($limit);
            default:
                throw new \Exception('Similarity engine is not defined!');
        }
    }
}
