#!/bin/sh

# chromium-browser_starter
#
# Schedules /usr/bin/chromium-browser to run every 15 seconds for a minute.
# Intended to be called every minute through crond(8).

/usr/bin/wget -q -O /var/www/html/siscisne/tareas/log/TarOdenVentaVehiculoSinConfirmarEntregaTodosPT.log "http://190.119.207.171:81/siscisne/tareas/TarOdenVentaVehiculoSinConfirmarEntregaTodos.php?Sucursal=SUC-10014"