<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-12-28
 * Time: 13:28
 */

require dirname(__DIR__) . '/tests/boot.php';

$startMem = memory_get_usage();
$router = new \Inhere\Route\CachedRouter([
    'cacheFile' => __DIR__ . '/cached/bench-routes-cache-bak.php',
    'cacheEnable' => 1,
    'cacheOnMatching' => 0,
    // 'tmpCacheNumber' => 100,
    // 'notAllowedAsNotFound' => 1,
]);

/**
 * match first route
 */

// $r = $requests[0];
$r = [
    'url' => '/mxbyr/nm/ycvrac/{name}',
    'method' => 'GET'
];
$uri = str_replace(['{', '}'], '', $r['url']);

$start = microtime(true);
$ret['first'] = $router->match($uri, $r['method']);
$end = microtime(true);
$matchTimeF = $end - $start;
echo 'Match time (first route):  ',
pretty_echo(number_format($matchTimeF, 6)),
" s.\n - URI: {$uri}, will match: {$r['url']}\n";
// echo "Match result: \n" . pretty_match_result($ret) . "\n\n";

/**
 * match random route
 */

// pick random route to match
// $r = $requests[random_int(0, $n)];
$r = [
    'url' => '/clltmniuuyv/{name}',
    'method' => 'POST'
];

$uri = str_replace(['{', '}'], '', $r['url']);

$start = microtime(true);
$ret['random'] = $router->match($uri, $r['method']);
$end = microtime(true);
$matchTimeR = $end - $start;
echo 'Match time (random route): ',
pretty_echo(number_format($matchTimeR, 6)),
" s.\n - URI: {$uri}, will match: {$r['url']}\n";
// echo "Match result: \n" . pretty_match_result($ret) . "\n\n";

/**
 * match last route
 */
// $r = $requests[$n - 1];
$r = [
    'url' => '/bsv/bbtqubcd/optbod/{name}',
    'method' => 'PUT'
];

$uri = str_replace(['{', '}'], '', $r['url']);

$start = microtime(true);
$ret['last'] = $router->match($uri, $r['method']);
$end = microtime(true);
$matchTimeE = $end - $start;
echo 'Match time (last route):   ',
pretty_echo(number_format($matchTimeE, 6)),
" s.\n - URI: {$uri}, will match: {$r['url']}\n";
// echo "Match result: \n" . pretty_match_result($ret) . "\n\n";

/**
 * match unknown route
 */
$start = microtime(true);
$ret['unknown'] = $router->match('/55-foo-bar', 'GET');
$end = microtime(true);
$matchTimeU = $end - $start;
echo 'Match time (unknown route): ', pretty_echo(number_format($matchTimeU, 6)), " s\n";
// echo "Match result: \n" . pretty_match_result($ret) . "\n\n";

// print totals
$totalTime = number_format($matchTimeF + $matchTimeR + $matchTimeU, 5);
echo PHP_EOL . 'Total time: ' . $totalTime . ' s' . PHP_EOL;
echo 'Memory usage: ' . round((memory_get_usage() - $startMem) / 1024) . ' KB' . PHP_EOL;
echo 'Peak memory usage: ' . round(memory_get_peak_usage(true) / 1024) . ' KB' . PHP_EOL;
echo "Match result: \n" . pretty_match_result($ret) . "\n";