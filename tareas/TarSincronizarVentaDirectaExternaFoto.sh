#!/bin/sh

# chromium-browser_starter
#
# Schedules /usr/bin/chromium-browser to run every 15 seconds for a minute.
# Intended to be called every minute through crond(8).

/usr/bin/wget -q -O /home/web/www/html/sistema/tareas/TarSincronizarVentaDirectaExternaFoto.log http://localhost:8080/sistema/tareas/TarSincronizarVentaDirectaExternaFoto.php