#!/bin/bash
# Uso: ./borrar_contenido_logs.sh carpeta_base

CARPETA_BASE="$1"

if [ -z "$CARPETA_BASE" ]; then
  echo "Debes indicar la carpeta base donde buscar."
  exit 1
fi

find "$CARPETA_BASE" -type d -name "log" | while read logdir; do
  echo "Limpiando contenido de: $logdir"
  rm -rf "$logdir"/*
done

echo "Contenido de todas las carpetas 'log' dentro de '$CARPETA_BASE' eliminado."