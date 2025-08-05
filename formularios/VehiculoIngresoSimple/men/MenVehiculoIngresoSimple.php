<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Registrar") and empty($GET_dia)){
?>
<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
<?php
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Listado") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Listado"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>
<?php
}
?>



<?php
/*if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=StockSucursal"><img src="imagenes/submenu/stock_vehiculos.png" alt="[Stock de Vehiculos]"  title="Ir a formulario de Stock de Vehiculos" />Stock</a></div>
<?php
}*/
?>


<?php
/*if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Importar") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Importar"><img src="imagenes/submenu/importar.png" alt="[Importar]"  title="Ir a formulario de Importacion" />Importar</a></div>
<?php
}*/
?>