<?php
// Script to rename migrations and update class names

$migrationsDir = __DIR__ . '/database/migrations';
$files = scandir($migrationsDir);

// Migration ordering by table (smaller number = earlier execution)
$tableOrder = [
    'users' => 10,
    'posts' => 20,
    'products' => 30,
    'buys' => 40,
    'favorites' => 50,
    'reviews' => 60,
    'carts' => 70,
    'cart_items' => 80,
    'shops' => 90,
    'orders' => 100,
    'order_items' => 110,
    'admins' => 120,
    'buy_responses' => 130,
];

// Files to delete (duplicates)
$filesToDelete = [
    // Orders table duplicates
    '2023_03_22_000000_add_receipt_image_to_orders_table.php',
    '2023_10_20_000001_create_orders_table.php',
    '2023_10_22_000000_ensure_total_amount_in_orders_table.php',
    '2024_03_18_000000_add_status_and_total_amount_to_orders_table.php',
    '2024_12_06_204351_create_orders_table.php',
    '2024_12_06_205607_add_quantity_to_orders_table.php',
    '2025_03_19_082857_add_status_column_to_orders_table.php', 
    '2025_03_22_030730_add_receipt_image_to_orders_table.php',
    
    // Posts table duplicates 
    '2024_11_24_145731_create_posts_table.php',
    
    // Favorites table duplicates
    '2023_10_10_000003_create_favorites_table.php',
];

// Process deletions
foreach ($files as $file) {
    if (in_array($file, $filesToDelete)) {
        if (file_exists("$migrationsDir/$file")) {
            echo "Deleting duplicate migration: $file\n";
            unlink("$migrationsDir/$file");
        }
    }
}

// Keep these creation migrations (will be renamed)
$keepMigrations = [
    '2023_05_23_000000_create_posts_table.php',
    '2023_05_25_000000_create_favorites_table.php',
    '2023_05_24_000000_create_products_table.php',
    '2023_05_25_000000_create_carts_table.php',
    '2023_05_25_000001_create_cart_items_table.php',
    '2023_10_10_000000_create_buys_table.php',
    '2023_10_10_000000_create_reviews_table.php',
    '2023_10_15_000000_create_orders_table.php',
    '2023_10_20_000000_create_admins_table.php',
    '2023_10_20_100000_create_order_items_table.php',
    '2023_11_01_000000_create_shops_table.php',
    '2023_06_01_000000_create_buy_responses_table.php',
];

// Function to generate class name from filename
function generateClassName($filename) {
    // Extract the descriptive part (e.g., "create_posts_table" becomes "CreatePostsTable")
    if (preg_match('/(create|add)_(.+)_table/', $filename, $matches)) {
        $action = ucfirst($matches[1]);  // Create or Add
        $tableName = $matches[2];
        
        // Convert snake_case to CamelCase
        $tableParts = explode('_', $tableName);
        $camelCaseTable = '';
        foreach ($tableParts as $part) {
            $camelCaseTable .= ucfirst($part);
        }
        
        // Add timestamp prefix to make it unique
        $timestamp = substr(str_replace(['-', '_'], '', microtime(true)), 0, 6);
        return "Migration{$timestamp}{$action}{$camelCaseTable}Table";
    }
    
    return "Migration" . substr(md5($filename), 0, 10);
}

// Standard prefix for new timestamps
$baseTimestamp = '2023_05_';

// Rename migrations based on table order
foreach ($keepMigrations as $file) {
    if (preg_match('/_create_(.+)_table\.php$/', $file, $matches)) {
        $tableName = $matches[1];
        
        if (isset($tableOrder[$tableName])) {
            $newOrder = $tableOrder[$tableName];
            // Format with leading zeros for proper sorting
            $orderSuffix = str_pad($newOrder, 2, '0', STR_PAD_LEFT);
            $newFilename = "{$baseTimestamp}{$orderSuffix}_create_{$tableName}_table.php";
            
            if (file_exists("$migrationsDir/$file")) {
                echo "Renaming: $file -> $newFilename\n";
                
                // Update class name inside the file
                $content = file_get_contents("$migrationsDir/$file");
                $newClassName = generateClassName($newFilename);
                
                // Find the class declaration pattern
                if (preg_match('/class\s+([a-zA-Z0-9_]+)\s+extends\s+Migration/i', $content, $classMatches)) {
                    $oldClassName = $classMatches[1];
                    $content = str_replace(
                        "class {$oldClassName} extends Migration",
                        "class {$newClassName} extends Migration", 
                        $content
                    );
                    
                    // Save with new class name
                    file_put_contents("$migrationsDir/$file", $content);
                }
                
                // Rename the file
                rename("$migrationsDir/$file", "$migrationsDir/$newFilename");
            }
        }
    }
}

// Process modification migrations - make sure they come after table creations
$files = scandir($migrationsDir); // Re-scan after deletions and renames
foreach ($files as $file) {
    if ($file === '.' || $file === '..' || !preg_match('/\.php$/', $file)) {
        continue;
    }
    
    if (preg_match('/add_.+_to_(.+)_table\.php$/', $file, $matches)) {
        $tableName = $matches[1];
        
        if (isset($tableOrder[$tableName])) {
            $tablePrefix = $tableOrder[$tableName];
            // Modifications come after table creation, add 50 to ensure they're after
            $newOrder = $tablePrefix + 50;
            $orderSuffix = str_pad($newOrder, 2, '0', STR_PAD_LEFT);
            
            // Extract the original descriptive part
            preg_match('/add_(.+)_to_/', $file, $descMatches);
            $description = $descMatches[1] ?? 'field';
            
            $newFilename = "{$baseTimestamp}{$orderSuffix}_add_{$description}_to_{$tableName}_table.php";
            
            // Update class name inside the file
            $content = file_get_contents("$migrationsDir/$file");
            $newClassName = generateClassName($newFilename);
            
            // Find the class declaration pattern
            if (preg_match('/class\s+([a-zA-Z0-9_]+)\s+extends\s+Migration/i', $content, $classMatches)) {
                $oldClassName = $classMatches[1];
                $content = str_replace(
                    "class {$oldClassName} extends Migration",
                    "class {$newClassName} extends Migration", 
                    $content
                );
                
                // Save with new class name
                file_put_contents("$migrationsDir/$file", $content);
            }
            
            echo "Renaming modification: $file -> $newFilename\n";
            rename("$migrationsDir/$file", "$migrationsDir/$newFilename");
        }
    }
}

echo "Migration files have been reorganized with unique class names.\n";
echo "Now run: php artisan migrate:fresh\n";
