
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoEntrada","Registrar") and empty($GET_dia)){
?>
<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
<?php
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoEntrada","Listado") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Listado"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>
<?php
}
?>



<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoEntrada","Listado") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Monitoreo"><img src="imagenes/submenu/monitoreo.png" alt="[En Transito]"  title="Ir a formulario de listado" />En Transito</a></div>
<?php
}
?>
