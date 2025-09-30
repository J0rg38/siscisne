#!/bin/bash

# Script final para reemplazar eregi_replace con preg_replace
# Autor: Sistema de Migración PHP
# Fecha: 2024-12-01

echo "=== SCRIPT FINAL DE MIGRACIÓN eregi_replace -> preg_replace ==="
echo ""

# Contador
PROCESSED_COUNT=0

echo "Reemplazando eregi_replace en archivos PHP..."
echo ""

# Buscar archivos PHP que contengan eregi_replace
find . -name "*.php" -type f -exec grep -l "eregi_replace" {} \; | while read -r file; do
    echo "Procesando: $file"
    
    # Crear backup
    cp "$file" "$file.backup"
    
    # Reemplazar eregi_replace("'","\"",$variable) con preg_replace("/'/", "\"", $variable)
    sed -i '' 's/eregi_replace("'"'"'","\\"",\([^)]*\))/preg_replace("\/'"'"'\/", "\\"", \1)/g' "$file"
    
    # Reemplazar eregi_replace("'", "\"", $variable) con preg_replace("/'/", "\"", $variable)
    sed -i '' 's/eregi_replace("'"'"'", "\\"", \([^)]*\))/preg_replace("\/'"'"'\/", "\\"", \1)/g' "$file"
    
    # Verificar si hubo cambios
    if ! diff -q "$file" "$file.backup" > /dev/null; then
        echo "  ✓ Actualizado"
        PROCESSED_COUNT=$((PROCESSED_COUNT + 1))
    else
        echo "  - Sin cambios"
        rm "$file.backup"
    fi
done

echo ""
echo "=== RESUMEN ==="
echo "Archivos procesados: $PROCESSED_COUNT"

if [ $PROCESSED_COUNT -gt 0 ]; then
    echo ""
    echo "¡Migración completada!"
    echo "Los archivos .backup contienen las versiones originales."
else
    echo ""
    echo "No se encontraron archivos que requieran actualización."
fi
