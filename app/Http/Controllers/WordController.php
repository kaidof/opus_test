<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Page\PageLoader;
use App\Page\PageParser;
use App\Page\Similarity\SimilarityFactory;
use App\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * Processing URL
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $url = $request->input('url');

        if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
            $list = PageParser::create(new PageLoader())->getWords($url);

            // Clear old data
            Word::query()->truncate();

            // Prepare data to DB insert
            $insertList = array_map(function($item) {
                return ['word' => $item];
            }, $list);

            Word::insert($insertList);
        } else {
            return response()->json(['error' => 'Not valid URL'], 400);
        }

        return response()->make(null,201);
    }

    /**
     * Return similar words
     *
     * @param string $word
     *
     * @return \Illuminate\Http\Response
     */
    public function similar($word)
    {
        try {
            return response()->json(SimilarityFactory::get()->getList($word));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
