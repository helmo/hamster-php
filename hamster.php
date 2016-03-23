#!/usr/bin/php
<?php

/**
 * @file
 * Export for hamster time tracker
 *
 * Copy/paste CSV output to LibreOffice, to detect date columns
 * Then copy/paste to GoogleSheets
 *
 */

// Open database.
$db = new SQLite3($_SERVER['HOME'] . '/.local/share/hamster-applet/hamster.db');

// Select data.
$results = $db->query("SELECT *, (SELECT GROUP_CONCAT(name, '#') from fact_tags ft LEFT JOIN tags t ON (ft.tag_id=t.id) WHERE fact_id=f.id GROUP BY ft.fact_id) as tags
  FROM facts f
    LEFT JOIN activities a ON (a.id=f.activity_id)
    WHERE start_time LIKE  '2016-03-%'
    ORDER BY start_time");


// Output as CSV.
while ($row = $results->fetchArray()) {
  //var_dump($row);
  echo "$row[name],$row[tags],$row[start_time],$row[end_time],$row[description]\n";
}
