#!/bin/sh

# chromium-browser_starter
#
# Schedules /usr/bin/chromium-browser to run every 15 seconds for a minute.
# Intended to be called every minute through crond(8).

/usr/bin/wget -q -O /var/www/html/siscisne/tareas/log/TarActualizarVehiculoIngresoPromedioDiaMantenimiento.log http://192.168.0.3:81/siscisne/tareas/TarActualizarVehiculoIngresoPromedioDiaMantenimiento.php