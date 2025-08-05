<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Listado") or $InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Boleta","Listado")){
?>  
<!--<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoAlmacenMovimientoSalida"><img src="imagenes/iconos/monitoreo.png" alt="[Monitoreo Mov. Almacen de Salida]"  title="Ir a formulario de monitoreo de Mov. de Almacen de Salida" />Mov. Almacen Salida</a></div>-->

<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoFichaIngreso"><img src="imagenes/iconos/orden_trabajo.png" alt="[Monitoreo Ord. Trab. p/ Facturar]"  title="Ir a formulario de monitoreo de Ord. Trab. p/ Facturar" />O.T.</a></div>

<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoVentaConcretada"><img src="imagenes/iconos/venta_directa.png" alt="[Monitoreo Ord. Venta]"  title="Ir a formulario de monitoreo de Ord. Venta" />O.V.</a></div>

<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoOrdenVentaVehiculo"><img src="imagenes/iconos/orden_venta_vehiculo.png" alt="[Monitoreo Ord. Venta de Repuesto]"  title="Ir a formulario de monitoreo de Ord. Venta Vehiculo" />O.V.V.</a></div>
<?php
}
?>
