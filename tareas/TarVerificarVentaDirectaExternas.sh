#!/bin/sh

# chromium-browser_starter
#
# Schedules /usr/bin/chromium-browser to run every 15 seconds for a minute.
# Intended to be called every minute through crond(8).

for ((secs=0; secs<46; secs+=15)); do
    (sleep $secs; /usr/bin/wget -q -O /var/www/html/sistema/tareas/log/TarVerificarVentaDirectaExternas.log http://localhost:8080/sistema/tareas/TarVerificarVentaDirectaExternas.php "$@") &
done

wait