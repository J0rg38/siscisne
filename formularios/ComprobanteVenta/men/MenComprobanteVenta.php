<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Listado") or $InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Boleta","Listado")){
?>  
<!--<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoAlmacenMovimientoSalida"><img src="imagenes/iconos/monitoreo.png" alt="[Monitoreo Mov. Almacen de Salida]"  title="Ir a formulario de monitoreo de Mov. de Almacen de Salida" />Mov. Almacen Salida</a></div>-->

<div class="EstSubMenuBoton"><a title="O.T." href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoFichaIngreso"><img src="imagenes/iconos/taller.png" alt="[Monitoreo de Ord. Trab. p/ Facturar]"  title="Ir a formulario de Monitoreo de Ord. Trab. p/ Facturar" />Taller</a></div>

<div class="EstSubMenuBoton"><a title="O.V." href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoVentaConcretada"><img src="imagenes/iconos/venta.png" alt="[Monitoreo Ord. Venta p/ Facturar]"  title="Ir a formulario de Monitoreo Ord. Venta p/ Facturar" />V.Mostrador</a></div>

<div class="EstSubMenuBoton"><a title="O.V.V." href="principal.php?Mod=<?php echo $GET_mod;?>&Form=MonitoreoVehiculoMovimientoSalida"><img src="imagenes/iconos/autos.png" alt="[Monitoreo Ord. Venta de Repuesto]"  title="Ir a formulario de Monitoreo de Ord. Venta Vehiculo" />Vehiculos</a></div>
<?php
}
?>
