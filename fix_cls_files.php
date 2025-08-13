<?php
/**
 * Script to fix all Cls*.php files in the paquetes folder
 * Applies the same formatting and linting corrections
 */

$paquetes_dir = 'paquetes';
$total_files = 0;
$total_fixes = 0;

function fix_cls_file($file_path) {
    global $total_fixes;
    
    if (!file_exists($file_path)) {
        return false;
    }
    
    $content = file_get_contents($file_path);
    $original_content = $content;
    $changes = 0;
    
    // 1. Fix class declaration formatting
    $content = preg_replace('/class\s+(\w+)\s*\{/', "class $1\n{", $content);
    
    // 2. Fix function declaration formatting
    $content = preg_replace('/public\s+function\s+(\w+)\s*\(/', "public function $1(", $content);
    $content = preg_replace('/private\s+function\s+(\w+)\s*\(/', "private function $1(", $content);
    $content = preg_replace('/protected\s+function\s+(\w+)\s*\(/', "protected function $1(", $content);
    
    // 3. Fix if/else/foreach/while statement formatting
    $content = preg_replace('/if\s*\(/', "if (", $content);
    $content = preg_replace('/else\s*\{/', "else {", $content);
    $content = preg_replace('/foreach\s*\(/', "foreach (", $content);
    $content = preg_replace('/while\s*\(/', "while (", $content);
    $content = preg_replace('/switch\s*\(/', "switch (", $content);
    
    // 4. Fix spacing around operators
    $content = preg_replace('/\s*([=+\-*\/<>!&|])\s*/', ' $1 ', $content);
    
    // 5. Fix array access spacing
    $content = preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)\s*\[\s*([^\]]+)\s*\]/', '$$1[$2]', $content);
    
    // 6. Fix string concatenation spacing
    $content = preg_replace('/\s*\.\s*\$/', ' . $', $content);
    $content = preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)\s*\.\s*/', '$$1 . ', $content);
    
    // 7. Fix empty destructor
    $content = preg_replace('/public\s+function\s+__destruct\(\)\s*\{\s*\}/', "public function __destruct() {}", $content);
    
    // 8. Fix empty lines and spacing
    $content = preg_replace('/\n\s*\n\s*\n/', "\n\n", $content);
    
    // 9. Fix variable initialization patterns (common undefined variable issues)
    // Look for patterns where variables are used in SQL concatenation without initialization
    
    // 10. Fix missing class properties (common pattern)
    // This is more complex and would need specific analysis per file
    
    if ($content !== $original_content) {
        $changes = substr_count($content, "\n") - substr_count($original_content, "\n");
        $total_fixes += abs($changes);
        
        if (file_put_contents($file_path, $content)) {
            echo "Fixed formatting in $file_path ($changes changes)\n";
            return true;
        } else {
            echo "Error writing to $file_path\n";
            return false;
        }
    }
    
    return false;
}

function process_directory($dir) {
    global $total_files;
    
    if (!is_dir($dir)) {
        return;
    }
    
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            process_directory($path);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php' && strpos($file, 'Cls') === 0) {
            $total_files++;
            fix_cls_file($path);
        }
    }
}

echo "Starting to fix Cls*.php files in paquetes folder...\n";
echo "Directory: $paquetes_dir\n\n";

process_directory($paquetes_dir);

echo "\nCompleted!\n";
echo "Total Cls*.php files processed: $total_files\n";
echo "Total formatting changes made: $total_fixes\n";
echo "\nNote: This script focuses on basic formatting fixes.\n";
echo "For complex linting issues (undefined variables, missing properties),\n";
echo "each file may need individual analysis and correction.\n";
?> 