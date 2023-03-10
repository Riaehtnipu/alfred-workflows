<?php
use Alfred\Workflows\Workflow;

require_once('vendor/joetannenbaum/alfred-workflow/Workflow.php');
require_once('vendor/joetannenbaum/alfred-workflow/Result.php');
require_once('util/request.php');

const ICON = '63F60794-BB56-4415-9372-BAF974C3A7E1.png';

$wf = new Workflow;

$xml = request('https://suggestqueries.google.com/complete/search?output=toolbar&q='.urlencode($query), $opt);
$xml = simplexml_load_string(mb_convert_encoding($xml, 'UTF-8', 'ISO-8859-1'));

foreach ($xml as $sugg) {
    $data = (string) $sugg->suggestion->attributes()->data;
    $wf->result()
        ->title($data)
        ->subtitle('Search Google for '.$data)
        ->arg($data)
        ->icon(ICON)
        ->autocomplete($data);
}

echo $wf->output();
