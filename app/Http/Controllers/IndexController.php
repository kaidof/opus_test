<?php

namespace App\Http\Controllers;

/**
 * @codeCoverageIgnore
 */
class IndexController extends Controller
{
    public function main()
    {
        $commit = trim(exec('git log --pretty="%h|%cI" -n1 HEAD'));

        $timeStr = 'never';
        if ($commit) {
            list($hash, $time) = explode('|', $commit);

            $commitDate = new \DateTime($time);
            $commitDate->setTimezone(new \DateTimeZone('UTC'));
            $timeStr = $commitDate->format('Y-m-d\TH:i:s\Z');
        } else {
            $hash = 'none';
        }

        return view('api', [
            'hash' => $hash,
            'time' => $timeStr,
        ]);
    }
}
