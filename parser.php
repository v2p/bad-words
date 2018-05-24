<?php

libxml_use_internal_errors(true);

function parseFile($fileName)
{
    $tidy = new \tidy();
    $document = new \DOMDocument();

    $document->loadHTML($tidy->repairFile($fileName));
    $xpath = new \DOMXPath($document);

    $items = $xpath->query('//table[@width=650]/tr/td[1]');

    /** @var \DOMElement $item */
    foreach ($items as $item) {
        $htmlPart = $item->ownerDocument->saveHTML($item);

        // quick fix for medicine words markup differences:
        $htmlPart = str_replace('</abbr>', '', $htmlPart);

        preg_match_all('#<b>(.*?)<\/b>\s-\s(.*?)<br>#', $htmlPart, $matches);

        foreach ($matches[1] as $index => $match) {
            echo "[$match]", ' ', $matches[2][$index], "\r\n";
        }
    }
}

foreach (array('swearing', 'medicine') as $dirName) {
    $effectiveDir = __DIR__ . '/raw-pages/' . $dirName;
    $files = scandir($effectiveDir);
    foreach ($files as $file) {
        if ($file[0] == '.') {
            continue;
        }

        parseFile($effectiveDir . '/' . $file);
    }
}