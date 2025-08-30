#!/bin/bash

# Script de backup para SISCISNE
# Autor: John Doe
# Fecha: 29/08/2025 10:00 AM

# Configuración
ORIGEN="/var/www/html/siscisnev2"
DESTINO="/var/www/html/backups"
NOMBRE_CARPETA="siscisnev2"
FECHA_HORA=$(date +%Y%m%d_%H%M%S)
ARCHIVO_BACKUP="${NOMBRE_CARPETA}_${FECHA_HORA}.tar.gz"

# Verificar que existe la carpeta origen
if [ ! -d "$ORIGEN" ]; then
    echo "ERROR: La carpeta origen $ORIGEN no existe"
    exit 1
fi

# Crear directorio de destino si no existe
if [ ! -d "$DESTINO" ]; then
    echo "Creando directorio de destino: $DESTINO"
    mkdir -p "$DESTINO"
fi

# Verificar permisos de escritura en el destino
if [ ! -w "$DESTINO" ]; then
    echo "ERROR: No hay permisos de escritura en $DESTINO"
    exit 1
fi

echo "Iniciando backup de SISCISNE..."
echo "Origen: $ORIGEN"
echo "Destino: $DESTINO"
echo "Archivo: $ARCHIVO_BACKUP"
echo "Fecha y hora: $(date)"
echo "----------------------------------------"

# Realizar el backup
cd "$(dirname "$ORIGEN")"
tar -czf "$DESTINO/$ARCHIVO_BACKUP" "$(basename "$ORIGEN")"

# Verificar si el backup fue exitoso
if [ $? -eq 0 ]; then
    echo "Backup completado exitosamente!"
    echo "Archivo creado: $DESTINO/$ARCHIVO_BACKUP"
    
    # Mostrar información del archivo creado
    TAMANO=$(du -h "$DESTINO/$ARCHIVO_BACKUP" | cut -f1)
    echo "Tamaño del archivo: $TAMANO"
    
    # Limpiar backups antiguos (mantener solo los últimos 10)
    echo "Limpiando backups antiguos..."
    cd "$DESTINO"
    ls -t ${NOMBRE_CARPETA}_*.tar.gz | tail -n +11 | xargs -r rm -f
    echo "Backups antiguos eliminados"
    
else
    echo "ERROR: El backup falló"
    exit 1
fi

echo "----------------------------------------"
echo "Backup finalizado: $(date)"
