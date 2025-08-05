
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Registrar") and empty($GET_dia)){
?>
<div class="EstSubMenuBoton"><a href="<?php echo $_SERVER['PHP_SELF'];?>?Mod=<?php echo $GET_mod;?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
<?php
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="<?php echo $_SERVER['PHP_SELF'];?>?Mod=<?php echo $GET_mod;?>&Form=Listado"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>
<?php
}
?>


<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="<?php echo $_SERVER['PHP_SELF'];?>?Mod=<?php echo $GET_mod;?>&Form=Formato"><img src="imagenes/iconos/freclamo.png" alt="[F. Reclamo]"  title="Ir a Formato de Reclamo" />Reclamo</a></div>
<?php
}
?>
