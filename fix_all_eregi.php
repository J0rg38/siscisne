<?php
/**
 * Script para reemplazar todas las funciones eregi_replace con preg_replace
 * Autor: Sistema de Migración PHP
 * Fecha: 2024-12-01
 */

echo "=== SCRIPT DE MIGRACIÓN eregi_replace -> preg_replace ===\n";
echo "Buscando archivos con eregi_replace...\n\n";

// Directorio base
$baseDir = __DIR__;

// Función para procesar un archivo
function processFile($filePath) {
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Patrones de reemplazo para eregi_replace
    $patterns = [
        // eregi_replace("'", "\"", $variable)
        '/eregi_replace\s*\(\s*["\x27]([^"\x27]+)["\x27]\s*,\s*["\x27]([^"\x27]*)["\x27]\s*,\s*([^)]+)\s*\)/' => 'preg_replace("/$1/", "$2", $3)',
        
        // eregi_replace("'","\"",$variable) (sin espacios)
        '/eregi_replace\s*\(\s*["\x27]([^"\x27]+)["\x27],["\x27]([^"\x27]*)["\x27],([^)]+)\)/' => 'preg_replace("/$1/", "$2", $3)',
        
        // preg_replace("/[\n|\r|\n\r]/", " ", $variable)
        '/eregi_replace\s*\(\s*["\x27](\[[^"\x27]+\])["\x27]\s*,\s*[\x27]([^\x27]+)[\x27]\s*,\s*([^)]+)\s*\)/' => 'preg_replace("/$1/", "$2", $3)',
    ];
    
    // Aplicar reemplazos
    foreach ($patterns as $pattern => $replacement) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    // Si hubo cambios, guardar el archivo
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        return true;
    }
    
    return false;
}

// Buscar archivos PHP que contengan eregi_replace
$files = [];
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'eregi_replace') !== false) {
            $files[] = $file->getPathname();
        }
    }
}

echo "Archivos encontrados: " . count($files) . "\n\n";

$processedCount = 0;
$errorCount = 0;

foreach ($files as $file) {
    $relativePath = str_replace($baseDir . '/', '', $file);
    echo "Procesando: $relativePath\n";
    
    try {
        if (processFile($file)) {
            echo "  ✓ Actualizado\n";
            $processedCount++;
        } else {
            echo "  - Sin cambios\n";
        }
    } catch (Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
        $errorCount++;
    }
}

echo "\n=== RESUMEN ===\n";
echo "Archivos procesados: $processedCount\n";
echo "Errores: $errorCount\n";
echo "Total de archivos: " . count($files) . "\n";

if ($processedCount > 0) {
    echo "\n¡Migración completada! Las funciones eregi_replace han sido reemplazadas.\n";
    echo "Recomendación: Ejecuta las pruebas para verificar que todo funciona correctamente.\n";
} else {
    echo "\nNo se encontraron archivos que requieran actualización.\n";
}
?>
