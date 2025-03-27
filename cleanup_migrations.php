<?php
// This script helps identify and list duplicate migrations

$migrationsDir = __DIR__ . '/database/migrations';
$files = scandir($migrationsDir);

$tableCreations = [];
$tableModifications = [];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    // Extract table name from filename
    if (preg_match('/_create_(.+)_table/', $file, $matches)) {
        $tableName = $matches[1];
        if (!isset($tableCreations[$tableName])) {
            $tableCreations[$tableName] = [];
        }
        $tableCreations[$tableName][] = $file;
    }
    
    // Extract modifications
    if (preg_match('/add_.+_to_(.+)_table/', $file, $matches)) {
        $tableName = $matches[1];
        if (!isset($tableModifications[$tableName])) {
            $tableModifications[$tableName] = [];
        }
        $tableModifications[$tableName][] = $file;
    }
}

echo "=== Tables with multiple creation migrations ===\n";
foreach ($tableCreations as $table => $files) {
    if (count($files) > 1) {
        echo "Table: $table\n";
        foreach ($files as $file) {
            echo "  - $file\n";
        }
        echo "\n";
    }
}

echo "=== Tables with modification migrations ===\n";
foreach ($tableModifications as $table => $files) {
    echo "Table: $table\n";
    foreach ($files as $file) {
        echo "  - $file\n";
    }
    echo "\n";
}
