<?php

# Copyright (c) 2017 David Drake
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#
# journal-down.php
# https://github.com/randomdrake/journal-down
#
# Written by David Drake
# https://randomdrake.com
# https://twitter.com/randomdrake

$heroPages = $heroes = [];

$startTime = microtime(true);

// Open our CSV file
$cheatSheet = fopen('./cheat-sheet.csv', 'w');

// Allow for UTF8 for names like Lúcio
fprintf($cheatSheet, chr(0xEF).chr(0xBB).chr(0xBF));

// Print our header
fputcsv($cheatSheet, [
    'Hero',
    'Build',
    'Level 1',
    'Level 4',
    'Level 7',
    'Level 10',
    'Level 13',
    'Level 16',
    'Level 20',
]);

// Grab the hero class page
$html = file_get_contents('https://www.icy-veins.com/heroes/');

// Load up in DOMDocument, squelching errors
$dom = new DOMDocument();
$internalErrors = libxml_use_internal_errors(true);
$dom->loadHtml($html);
libxml_use_internal_errors($internalErrors);

// Grab our container via XPath from the Navigation
$xpath = new DOMXpath($dom);
$containers = $xpath->query('//div[@class="nav_content_block_entry_heroes_hero"]');
foreach ($containers as $container) {
    $links = $container->getElementsByTagName('a');
    // Go through and grab the link for this hero
    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        $heroName = $link->getElementsByTagName('span')->item(0)->nodeValue;

        // Grab link if hero not already there for heroes in two classes like Varian
        if (strpos($href, 'www.icy-veins.com/heroes/') !== false && !in_array($heroName, $heroes)) {
            $heroPages[] = [
                'href' => $href,
                'name' => $heroName,
            ];
            $heroes[] = $heroName;
        }
    }
}

// Sort out heroes by name
sort($heroPages);

// Now that we have all of our individual hero pages, we can start our CSV
foreach ($heroPages as $hero) {
    $talents = $tiers = $builds = [];

    // Grab the individual hero page
    $html = file_get_contents(sprintf('https:%s', $hero['href']));

    // Load up in DOMDocument, squelching errors
    $dom = new DOMDocument();
    $internalErrors = libxml_use_internal_errors(true);
    $dom->loadHtml($html);
    libxml_use_internal_errors($internalErrors);

    // Grab the container for our builds
    $xpath = new DOMXpath($dom);
    $container = $xpath->query('//div[@class="heroes_tldr"]')->item(0);

    // Get the various names of builds
    $buildNames = $container->getElementsByTagName('h4');
    foreach ($buildNames as $buildName) {
        $buildName = substr($buildName->nodeValue, 0, strpos($buildName->nodeValue, ' Build'));
        if (strlen($buildName)) {
            $builds[] = $buildName;
        }
    }

    // Get the visual markers to indicate which talent number it is
    $xpath = new DOMXpath($dom);
    $talentContainers = $xpath->query('//span[@class="heroes_tldr_talent_tier_visual"]');
    $count = 1;
    foreach ($talentContainers as $talentContainer) {
        $tierMarkers = $talentContainer->getElementsByTagName('span');
        $talentNum = 1;
        foreach ($tierMarkers as $tierMarker) {
            if (strpos($tierMarker->getAttribute('class'), 'yes') !== false) {
                $talents[] = $talentNum;
                break;
            }
            $talentNum++;
        }
        if ($count == 7) {
            $tiers[] = $talents;
            $talents = [];
            $count = 1;
        } else {
            $count++;
        }
    }

    // Write our builds and talents for this hero to the CSV
    foreach ($builds as $count => $buildName) {
        $data = [
            $hero['name'],
            $buildName,
            $tiers[$count][0],
            $tiers[$count][1],
            $tiers[$count][2],
            $tiers[$count][3],
            $tiers[$count][4],
            $tiers[$count][5],
            $tiers[$count][6],
        ];
        fputcsv($cheatSheet, $data);
        echo implode(", ", $data), ' - ' . round(microtime(true) - $startTime, 1) . "s\n";
    }
}

fclose($cheatSheet);

echo "\nFinished in " . round(microtime(true) - $startTime, 1) . "s\n\n";
