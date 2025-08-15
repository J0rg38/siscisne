#!/bin/bash

# MySQL Query Monitor - Script de Monitoreo en Tiempo Real
# 
# Este script monitorea en tiempo real:
# - Queries activas
# - Queries lentas
# - Deadlocks
# - Estadísticas de rendimiento
# - Procesos bloqueados
# 
# Uso: ./mysql_monitor.sh [intervalo_segundos]
# Ejemplo: ./mysql_monitor.sh 2

# Configuración por defecto
MYSQL_HOST="localhost"
MYSQL_USER="root"
MYSQL_PASS="ServBay.dev"
MYSQL_PORT="3306"
INTERVAL=${1:-1}  # Intervalo por defecto: 1 segundo
LOG_FILE="mysql_monitor.log"
TEMP_DIR="/tmp/mysql_monitor"
PID_FILE="$TEMP_DIR/monitor.pid"

# Colores para la salida
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Función para mostrar ayuda
show_help() {
    echo -e "${CYAN}MySQL Query Monitor - Script de Monitoreo${NC}"
    echo "================================================"
    echo ""
    echo "Uso: $0 [opciones] [intervalo_segundos]"
    echo ""
    echo "Opciones:"
    echo "  -h, --host HOST      Host de MySQL (default: localhost)"
    echo "  -u, --user USER      Usuario de MySQL (default: root)"
    echo "  -p, --password PASS  Contraseña de MySQL"
    echo "  -P, --port PORT      Puerto de MySQL (default: 3306)"
    echo "  -i, --interval SEC   Intervalo de actualización en segundos (default: 1)"
    echo "  -l, --log FILE       Archivo de log (default: mysql_monitor.log)"
    echo "  -d, --daemon         Ejecutar en modo daemon"
    echo "  --help               Mostrar esta ayuda"
    echo ""
    echo "Ejemplos:"
    echo "  $0                    # Monitoreo con configuración por defecto"
    echo "  $0 5                 # Actualizar cada 5 segundos"
    echo "  $0 -h 192.168.1.100 -u admin -p secret 2"
    echo ""
}

# Función para procesar argumentos de línea de comandos
parse_arguments() {
    while [[ $# -gt 0 ]]; do
        case $1 in
            -h|--host)
                MYSQL_HOST="$2"
                shift 2
                ;;
            -u|--user)
                MYSQL_USER="$2"
                shift 2
                ;;
            -p|--password)
                MYSQL_PASS="$2"
                shift 2
                ;;
            -P|--port)
                MYSQL_PORT="$2"
                shift 2
                ;;
            -i|--interval)
                INTERVAL="$2"
                shift 2
                ;;
            -l|--log)
                LOG_FILE="$2"
                shift 2
                ;;
            -d|--daemon)
                DAEMON_MODE=true
                shift
                ;;
            --help)
                show_help
                exit 0
                ;;
            *)
                if [[ "$1" =~ ^[0-9]+$ ]]; then
                    INTERVAL="$1"
                else
                    echo -e "${RED}Error: Argumento desconocido: $1${NC}"
                    show_help
                    exit 1
                fi
                shift
                ;;
        esac
    done
}

# Función para inicializar el entorno
init_environment() {
    # Crear directorio temporal
    mkdir -p "$TEMP_DIR"
    
    # Verificar si MySQL está disponible
    if ! command -v mysql &> /dev/null; then
        echo -e "${RED}Error: El cliente MySQL no está instalado${NC}"
        exit 1
    fi
    
    # Verificar conexión a MySQL
    if ! mysql -h"$MYSQL_HOST" -u"$MYSQL_USER" -p"$MYSQL_PASS" -P"$MYSQL_PORT" -e "SELECT 1;" &> /dev/null; then
        echo -e "${RED}Error: No se puede conectar a MySQL${NC}"
        echo "Host: $MYSQL_HOST"
        echo "Usuario: $MYSQL_USER"
        echo "Puerto: $MYSQL_PORT"
        exit 1
    fi
    
    echo -e "${GREEN}✅ Conectado a MySQL exitosamente${NC}"
}

# Función para ejecutar query MySQL
mysql_query() {
    local query="$1"
    mysql -h"$MYSQL_HOST" -u"$MYSQL_USER" -p"$MYSQL_PASS" -P"$MYSQL_PORT" -N -e "$query" 2>/dev/null
}

# Función para obtener procesos activos
get_active_processes() {
    mysql_query "
        SELECT 
            ID,
            USER,
            HOST,
            DB,
            COMMAND,
            TIME,
            STATE,
            LEFT(INFO, 100) as QUERY
        FROM information_schema.PROCESSLIST 
        WHERE COMMAND != 'Sleep' 
        ORDER BY TIME DESC
        LIMIT 20
    "
}

# Función para obtener queries lentas
get_slow_queries() {
    mysql_query "
        SELECT 
            ID,
            USER,
            HOST,
            DB,
            COMMAND,
            TIME,
            STATE,
            LEFT(INFO, 100) as QUERY
        FROM information_schema.PROCESSLIST 
        WHERE TIME > 5 AND COMMAND != 'Sleep'
        ORDER BY TIME DESC
        LIMIT 10
    "
}

# Función para obtener estadísticas de rendimiento
get_performance_stats() {
    mysql_query "
        SHOW GLOBAL STATUS 
        WHERE Variable_name IN (
            'Questions', 'Slow_queries', 'Threads_connected', 
            'Max_used_connections', 'Uptime', 'Bytes_received', 'Bytes_sent'
        )
    "
}

# Función para obtener información de conexiones
get_connection_stats() {
    mysql_query "
        SELECT 
            COUNT(*) as total_connections,
            COUNT(CASE WHEN COMMAND != 'Sleep' THEN 1 END) as active_connections,
            COUNT(CASE WHEN COMMAND = 'Sleep' THEN 1 END) as idle_connections
        FROM information_schema.PROCESSLIST
    "
}

# Función para obtener información de deadlocks
get_deadlock_info() {
    local status=$(mysql_query "SHOW ENGINE INNODB STATUS")
    if [[ -n "$status" ]]; then
        echo "$status" | grep -A 20 "LATEST DETECTED DEADLOCK" || echo "No deadlocks detected"
    fi
}

# Función para limpiar pantalla
clear_screen() {
    if [[ "$OSTYPE" == "linux-gnu"* ]] || [[ "$OSTYPE" == "darwin"* ]]; then
        clear
    elif [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "cygwin" ]]; then
        cls
    fi
}

# Función para mostrar estadísticas
display_stats() {
    clear_screen
    
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${CYAN}�� $timestamp - MySQL Query Monitor${NC}"
    echo "=================================================="
    echo -e "Host: ${BLUE}$MYSQL_HOST:$MYSQL_PORT${NC} | Usuario: ${BLUE}$MYSQL_USER${NC} | Intervalo: ${BLUE}${INTERVAL}s${NC}"
    echo ""
    
    # Procesos activos
    echo -e "${YELLOW}�� PROCESOS ACTIVOS${NC}"
    echo "----------------------------------------"
    local processes=$(get_active_processes)
    if [[ -z "$processes" ]]; then
        echo -e "${GREEN}✅ No hay procesos activos${NC}"
    else
        echo -e "${BLUE}ID     | Usuario    | Tiempo | DB              | Query${NC}"
        echo "--------|------------|--------|------------------|----------------------------------------"
        echo "$processes" | while IFS=$'\t' read -r id user host db command time state query; do
            printf "%-7s | %-11s | %-6s | %-16s | %s\n" "$id" "$user" "$time" "${db:-N/A}" "${query:-N/A}"
        done
    fi
    echo ""
    
    # Queries lentas
    local slow_queries=$(get_slow_queries)
    if [[ -n "$slow_queries" ]]; then
        echo -e "${RED}�� QUERIES LENTAS (>5s)${NC}"
        echo "----------------------------------------"
        echo "$slow_queries" | while IFS=$'\t' read -r id user host db command time state query; do
            printf "%-7s | %-11s | %-6s | %s\n" "$id" "$user" "$time" "${query:-N/A}"
        done
        echo ""
    fi
    
    # Estadísticas de conexiones
    echo -e "${PURPLE}🔗 ESTADÍSTICAS DE CONEXIONES${NC}"
    echo "----------------------------------------"
    local conn_stats=$(get_connection_stats)
    if [[ -n "$conn_stats" ]]; then
        echo "$conn_stats" | while IFS=$'\t' read -r total active idle; do
            echo -e "Total: ${BLUE}$total${NC} | Activas: ${YELLOW}$active${NC} | Inactivas: ${GREEN}$idle${NC}"
        done
    fi
    echo ""
    
    # Estadísticas de rendimiento
    echo -e "${GREEN}⚡ ESTADÍSTICAS DE RENDIMIENTO${NC}"
    echo "----------------------------------------"
    local perf_stats=$(get_performance_stats)
    if [[ -n "$perf_stats" ]]; then
        echo "$perf_stats" | while IFS=$'\t' read -r variable value; do
            case $variable in
                "Questions")
                    echo -e "Queries totales: ${BLUE}$value${NC}"
                    ;;
                "Slow_queries")
                    echo -e "Queries lentas: ${RED}$value${NC}"
                    ;;
                "Threads_connected")
                    echo -e "Conexiones activas: ${YELLOW}$value${NC}"
                    ;;
                "Uptime")
                    local uptime_seconds=$value
                    local days=$((uptime_seconds / 86400))
                    local hours=$(( (uptime_seconds % 86400) / 3600 ))
                    local minutes=$(( (uptime_seconds % 3600) / 60 ))
                    echo -e "Uptime: ${GREEN}${days}d ${hours}h ${minutes}m${NC}"
                    ;;
            esac
        done
    fi
    echo ""
    
    # Información de deadlocks
    echo -e "${RED}⚠️  INFORMACIÓN DE DEADLOCKS${NC}"
    echo "----------------------------------------"
    local deadlock_info=$(get_deadlock_info)
    if [[ -n "$deadlock_info" ]]; then
        echo "$deadlock_info" | head -10
    else
        echo -e "${GREEN}✅ No se detectaron deadlocks${NC}"
    fi
    echo ""
    
    echo -e "${CYAN}Presiona Ctrl+C para detener el monitoreo${NC}"
}

# Función para log
log_message() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[$timestamp] $message" >> "$LOG_FILE"
}

# Función para manejar señales
cleanup() {
    echo -e "\n${YELLOW}🛑 Deteniendo monitoreo...${NC}"
    log_message "Monitoreo detenido por el usuario"
    
    # Limpiar archivos temporales
    rm -f "$PID_FILE"
    
    echo -e "${GREEN}✅ Monitoreo detenido${NC}"
    exit 0
}

# Función para modo daemon
run_as_daemon() {
    echo -e "${YELLOW}🔄 Iniciando en modo daemon...${NC}"
    echo "PID: $$"
    echo "Log: $LOG_FILE"
    
    # Guardar PID
    echo $$ > "$PID_FILE"
    
    # Redirigir salida al log
    exec 1>>"$LOG_FILE" 2>&1
    
    # Ejecutar monitoreo
    run_monitoring
}

# Función principal de monitoreo
run_monitoring() {
    echo -e "${GREEN}�� Iniciando monitoreo MySQL...${NC}"
    log_message "Iniciando monitoreo MySQL"
    
    # Configurar manejo de señales
    trap cleanup SIGINT SIGTERM
    
    # Bucle principal
    while true; do
        display_stats
        sleep "$INTERVAL"
    done
}

# Función para mostrar estado del daemon
show_daemon_status() {
    if [[ -f "$PID_FILE" ]]; then
        local pid=$(cat "$PID_FILE")
        if kill -0 "$pid" 2>/dev/null; then
            echo -e "${GREEN}✅ Daemon ejecutándose (PID: $pid)${NC}"
            echo "Log: $LOG_FILE"
            echo "Para detener: kill $pid"
        else
            echo -e "${RED}❌ Daemon no está ejecutándose${NC}"
            rm -f "$PID_FILE"
        fi
    else
        echo -e "${YELLOW}⚠️  No hay daemon ejecutándose${NC}"
    fi
}

# Función para detener daemon
stop_daemon() {
    if [[ -f "$PID_FILE" ]]; then
        local pid=$(cat "$PID_FILE")
        if kill -0 "$pid" 2>/dev/null; then
            kill "$pid"
            echo -e "${GREEN}✅ Daemon detenido (PID: $pid)${NC}"
        else
            echo -e "${RED}❌ Daemon no está ejecutándose${NC}"
        fi
        rm -f "$PID_FILE"
    else
        echo -e "${YELLOW}⚠️  No hay daemon ejecutándose${NC}"
    fi
}

# Función principal
main() {
    # Procesar argumentos
    parse_arguments "$@"
    
    # Mostrar información de configuración
    echo -e "${CYAN}MySQL Query Monitor - Configuración${NC}"
    echo "=========================================="
    echo "Host: $MYSQL_HOST"
    echo "Usuario: $MYSQL_USER"
    echo "Puerto: $MYSQL_PORT"
    echo "Intervalo: ${INTERVAL}s"
    echo "Log: $LOG_FILE"
    echo ""
    
    # Inicializar entorno
    init_environment
    
    # Ejecutar según el modo
    if [[ "$DAEMON_MODE" == true ]]; then
        run_as_daemon
    else
        run_monitoring
    fi
}

# Verificar argumentos especiales
case "${1:-}" in
    "status")
        show_daemon_status
        exit 0
        ;;
    "stop")
        stop_daemon
        exit 0
        ;;
    "start")
        DAEMON_MODE=true
        shift
        main "$@"
        ;;
    *)
        main "$@"
        ;;
esac