#!/bin/bash

# Script directo para reemplazar eregi_replace
# Autor: Sistema de Migración PHP
# Fecha: 2024-12-01

echo "=== SCRIPT DIRECTO DE MIGRACIÓN eregi_replace -> preg_replace ==="
echo ""

# Contador
PROCESSED_COUNT=0

echo "Reemplazando eregi_replace en archivos PHP..."
echo ""

# Lista de archivos específicos que sabemos que tienen el problema
FILES=(
    "formularios/Boleta/acc/AccBoletaFirmarXMLv2.php"
    "formularios/Boleta/acc/AccBoletaProcesarBajaXMLv2.php"
    "formularios/Boleta/acc/AccBoletaProcesarResumenDiarioXML.php"
    "formularios/Boleta/acc/AccBoletaConsultarEstadoTicket.php"
    "formularios/ComprobanteRetencion/acc/AccComprobanteRetencionProcesarXMLv2.php"
    "formularios/ComprobanteRetencion/acc/AccComprobanteRetencionProcesarBajaXMLv2.php"
    "formularios/ComprobanteRetencion/acc/AccComprobanteRetencionConsultarEstadoTicket.php"
    "formularios/Factura-retencion/acc/AccFacturaProcesarXMLv2.php"
    "formularios/Factura-retencion/acc/AccFacturaConsultarEstadoCDR.php"
    "formularios/Factura-retencion/acc/AccFacturaFirmarXMLv2.php"
    "formularios/Factura-retencion/acc/AccFacturaConsultarEstadoTicket.php"
    "formularios/Factura-retencion/acc/AccFacturaConsultarCDR.php"
    "formularios/Factura-retencion/acc/AccFacturaProcesarBajaResumenXML.php"
    "formularios/Factura-retencion/acc/AccFacturaProcesarBajaXMLv2.php"
    "formularios/FacturaTalonario/acc/AccFacturaConsultarEstadoCDR.php"
    "formularios/NotaDebito/acc/AccNotaDebitoProcesarBajaXMLv2.php"
    "formularios/NotaDebito/acc/AccNotaDebitoProcesarXMLv2.php"
    "formularios/NotaDebito/acc/AccNotaDebitoConsultarCDR.php"
    "formularios/NotaDebito/acc/AccNotaDebitoConsultarEstadoTicket.php"
    "formularios/Factura/acc/AccFacturaProcesarBajaResumenXML.php"
    "formularios/Factura/acc/AccFacturaProcesarBajaXMLv2.php"
    "formularios/NotaCredito/acc/AccNotaCreditoFirmarXMLv2.php"
    "formularios/NotaCredito/acc/AccNotaCreditoConsultarEstadoCDR.php"
    "formularios/NotaCredito/acc/AccNotaCreditoProcesarXMLv2.php"
    "formularios/NotaCredito/acc/AccNotaCreditoProcesarBajaXMLv2.php"
    "formularios/NotaCredito/acc/AccNotaCreditoConsultarEstadoTicket.php"
    "formularios/NotaCredito/acc/AccNotaCreditoConsultarCDR.php"
    "formularios/GuiaRemision/acc/AccGuiaRemisionProcesarBajaXMLv2.php"
    "formularios/GuiaRemision/acc/AccGuiaRemisionConsultarEstadoTicket.php"
    "formularios/GuiaRemision/acc/AccGuiaRemisionProcesarXMLv2.php"
    "tareas/TarProcesarSUNATFacturas.php"
    "tareas/TarProcesarSUNATBoletas.php"
    "tareas/TarProcesarSUNATNotaDebitos.php"
    "tareas/TarProcesarSUNATNotaCreditos.php"
)

for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
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
    else
        echo "Archivo no encontrado: $file"
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
