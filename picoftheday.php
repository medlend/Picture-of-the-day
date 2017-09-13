<?php

$url = 'http://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Image_du_jour/mars_2015';
$cacheDir = '.cache';
$cacheFile = $cacheDir.'/'.sha1($url);

/**
 * Turn off XML errors
 */
$internalErrors = libxml_use_internal_errors(true);

/**
 * Load file and cache it
 */
if (!file_exists($cacheDir)) {
    mkdir($cacheDir);
}

if (file_exists($cacheFile)) {
    $content = file_get_contents($cacheFile);
} else {
    $content = file_get_contents($url);
    file_put_contents($cacheFile, $content);
}


/**
 * Read HTML
 */
$doc = new DOMDocument();
$doc->loadHTML($content);

/**
 * Filter document
 */
$xpath = new DOMXpath($doc);
//$elements = $xpath->query('//*[@id="mw-content-text"]/table');
$elements = $xpath->query('//*[@class="mw-parser-output"]/table');

$table = new DOMDocument();
foreach ($elements as $elt) {

    $copy = $table->importNode($elt, true);
    $table->appendChild($copy);
}

/**
 * Transform to CSV
 */
$xsldoc = new DOMDocument();
$xsldoc->load('pic2csv.xsl');

$xsl = new XSLTProcessor();
$xsl->importStyleSheet($xsldoc);

echo $xsl->transformToXML($table);

// output to file
file_put_contents('pics.csv', $xsl->transformToXML($table));

/**
 * Restore previous mode for XML errors
 */
libxml_use_internal_errors($internalErrors);