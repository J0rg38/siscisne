
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Registrar")){
?>
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Registrar&ses=<?php echo $Identificador;?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
<?php
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado")){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Listado&ses=<?php echo $Identificador;?>"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>
<?php
}
?>
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"ImportarExcel")){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Importar&ses=<?php echo $Identificador;?>"><img src="imagenes/iconos/importar.png" alt="[Importar]"  title="Ir a formulario de listado" /></a></div>
<?php
}
?>
