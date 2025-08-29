#!/bin/sh

# Script de sincronización de archivos de desarrollo a producción
# Versión compatible con sh (shell estándar de Unix)
# Autor: John Doe
# Fecha: 29/08/2025 10:00 AM

# Configuración
ORIGEN="/var/www/html/desarrollo/siscisne"
DESTINO="/var/www/html/siscisnev2"
LOG_FILE="/var/www/html/logsscripts/sincronizacion_desarrollo.log"
EXTENSIONES="php js css"

# Función para escribir en el log
escribir_log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

# Función para mostrar ayuda
mostrar_ayuda() {
    echo "Uso: $0 [OPCIONES]"
    echo ""
    echo "Opciones:"
    echo "  -h, --help     Mostrar esta ayuda"
    echo "  -d, --dry-run  Simular sincronización sin copiar archivos"
    echo "  -v, --verbose  Mostrar información detallada"
    echo "  -f, --force    Forzar sincronización sin confirmación"
    echo ""
    echo "Ejemplos:"
    echo "  $0                    # Sincronización normal"
    echo "  $0 --dry-run         # Simular sincronización"
    echo "  $0 --verbose         # Sincronización con información detallada"
    echo "  $0 --force           # Sincronización forzada"
}

# Variables de control
DRY_RUN=false
VERBOSE=false
FORCE=false

# Procesar argumentos de línea de comandos
while [ $# -gt 0 ]; do
    case $1 in
        -h|--help)
            mostrar_ayuda
            exit 0
            ;;
        -d|--dry-run)
            DRY_RUN=true
            shift
            ;;
        -v|--verbose)
            VERBOSE=true
            shift
            ;;
        -f|--force)
            FORCE=true
            shift
            ;;
        *)
            echo "Opción desconocida: $1"
            mostrar_ayuda
            exit 1
            ;;
    esac
done

# Inicializar log
echo "=== INICIO DE SINCRONIZACIÓN ===" > "$LOG_FILE"
escribir_log "Iniciando sincronización de archivos de desarrollo a producción"

# Verificar que existe la carpeta origen
if [ ! -d "$ORIGEN" ]; then
    escribir_log "ERROR: La carpeta origen $ORIGEN no existe"
    echo "ERROR: La carpeta origen $ORIGEN no existe"
    exit 1
fi

# Verificar que existe la carpeta destino
if [ ! -d "$DESTINO" ]; then
    escribir_log "Creando carpeta destino: $DESTINO"
    mkdir -p "$DESTINO"
fi

# Verificar permisos de escritura en el destino
if [ ! -w "$DESTINO" ]; then
    escribir_log "ERROR: No hay permisos de escritura en $DESTINO"
    echo "ERROR: No hay permisos de escritura en $DESTINO"
    exit 1
fi

# Contadores
TOTAL_ARCHIVOS=0
ARCHIVOS_COPIADOS=0
ARCHIVOS_REEMPLAZADOS=0
ARCHIVOS_NUEVOS=0
ERRORES=0

escribir_log "Configuración:"
escribir_log "  Origen: $ORIGEN"
escribir_log "  Destino: $DESTINO"
escribir_log "  Log: $LOG_FILE"
escribir_log "  Modo dry-run: $DRY_RUN"
escribir_log "  Verbose: $VERBOSE"

echo "Iniciando sincronización..."
echo "Origen: $ORIGEN"
echo "Destino: $DESTINO"
echo "Log: $LOG_FILE"
echo "Modo dry-run: $DRY_RUN"
echo "----------------------------------------"

# Confirmación del usuario (si no es forzado)
if [ "$FORCE" = false ] && [ "$DRY_RUN" = false ]; then
    echo "¿Estás seguro de que quieres sincronizar los archivos? (y/n)"
    read respuesta
    if [ "$respuesta" != "y" ] && [ "$respuesta" != "Y" ]; then
        escribir_log "Sincronización cancelada por el usuario"
        echo "Sincronización cancelada"
        exit 0
    fi
fi

# Función para procesar archivos
procesar_archivo() {
    archivo_origen="$1"
    archivo_destino="$2"
    ruta_relativa="$3"
    
    TOTAL_ARCHIVOS=$(($TOTAL_ARCHIVOS + 1))
    
    if [ "$VERBOSE" = true ]; then
        echo "Procesando: $ruta_relativa"
    fi
    
    # Verificar si el archivo destino existe
    if [ -f "$archivo_destino" ]; then
        # Verificar si el archivo origen es más reciente
        if [ "$archivo_origen" -nt "$archivo_destino" ]; then
            if [ "$DRY_RUN" = false ]; then
                cp "$archivo_origen" "$archivo_destino"
                if [ $? -eq 0 ]; then
                    ARCHIVOS_REEMPLAZADOS=$(($ARCHIVOS_REEMPLAZADOS + 1))
                    escribir_log "REEMPLAZADO: $ruta_relativa"
                    echo "  ✓ Reemplazado: $ruta_relativa"
                else
                    ERRORES=$(($ERRORES + 1))
                    escribir_log "ERROR al reemplazar: $ruta_relativa"
                    echo "  ✗ ERROR al reemplazar: $ruta_relativa"
                fi
            else
                ARCHIVOS_REEMPLAZADOS=$(($ARCHIVOS_REEMPLAZADOS + 1))
                echo "  [DRY-RUN] Se reemplazaría: $ruta_relativa"
            fi
        else
            if [ "$VERBOSE" = true ]; then
                echo "  - Sin cambios: $ruta_relativa"
            fi
        fi
    else
        # Crear directorio destino si no existe
        dir_destino=$(dirname "$archivo_destino")
        if [ ! -d "$dir_destino" ]; then
            if [ "$DRY_RUN" = false ]; then
                mkdir -p "$dir_destino"
            fi
        fi
        
        if [ "$DRY_RUN" = false ]; then
            cp "$archivo_origen" "$archivo_destino"
            if [ $? -eq 0 ]; then
                ARCHIVOS_NUEVOS=$(($ARCHIVOS_NUEVOS + 1))
                escribir_log "NUEVO: $ruta_relativa"
                echo "  ✓ Nuevo: $ruta_relativa"
            else
                ERRORES=$(($ERRORES + 1))
                escribir_log "ERROR al copiar: $ruta_relativa"
                echo "  ✗ ERROR al copiar: $ruta_relativa"
            fi
        else
            ARCHIVOS_NUEVOS=$(($ARCHIVOS_NUEVOS + 1))
            echo "  [DRY-RUN] Se copiaría: $ruta_relativa"
        fi
    fi
}

# Función para buscar archivos por extensión (compatible con sh)
buscar_archivos() {
    extension="$1"
    patron="*.$extension"
    
    if [ "$VERBOSE" = true ]; then
        echo "Buscando archivos .$extension..."
    fi
    
    # Buscar archivos recursivamente usando find y while read (compatible con sh)
    find "$ORIGEN" -type f -name "$patron" | while read archivo; do
        # Obtener ruta relativa
        ruta_relativa=$(echo "$archivo" | sed "s|^$ORIGEN/||")
        archivo_destino="$DESTINO/$ruta_relativa"
        
        procesar_archivo "$archivo" "$archivo_destino" "$ruta_relativa"
    done
}

# Procesar cada extensión
for extension in $EXTENSIONES; do
    buscar_archivos "$extension"
done

# Resumen final
echo "----------------------------------------"
echo "RESUMEN DE SINCRONIZACIÓN:"
echo "  Total de archivos procesados: $TOTAL_ARCHIVOS"
echo "  Archivos nuevos: $ARCHIVOS_NUEVOS"
echo "  Archivos reemplazados: $ARCHIVOS_REEMPLAZADOS"
echo "  Errores: $ERRORES"

if [ "$DRY_RUN" = true ]; then
    echo "  MODO DRY-RUN: No se copiaron archivos"
fi

# Escribir resumen en el log
escribir_log "RESUMEN: Total=$TOTAL_ARCHIVOS, Nuevos=$ARCHIVOS_NUEVOS, Reemplazados=$ARCHIVOS_REEMPLAZADOS, Errores=$ERRORES"
escribir_log "Sincronización completada"

echo ""
echo "Log guardado en: $LOG_FILE"
echo "Sincronización completada: $(date)"
