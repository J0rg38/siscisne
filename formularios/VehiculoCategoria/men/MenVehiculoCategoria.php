
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Registrar") and empty($GET_dia)){
?>
<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
<?php
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>  
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Listado"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>
<?php
}
?>



<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],eregi_replace("Categoria","",$GET_mod),"Listado")){
?> 
<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo eregi_replace("Categoria","",$GET_mod);?>&Form=Listado"><img src="imagenes/iconos/elementos.png" alt="[Elementos]" title="Ir a formulario de elementos de categorias"  />Elementos</a></div>

<?php
}
?>


