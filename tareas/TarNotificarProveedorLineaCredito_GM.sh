#!/bin/sh

# chromium-browser_starter
#
# Schedules /usr/bin/chromium-browser to run every 15 seconds for a minute.
# Intended to be called every minute through crond(8).

/usr/bin/wget -q -O /var/www/html/sistema/tareas/log/TarNotificarProveedorLineaCredito_GM.log http://localhost:8080/sistema/tareas/TarNotificarProveedorLineaCredito_GM.php