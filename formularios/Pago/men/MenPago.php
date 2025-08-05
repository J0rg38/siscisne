
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Registrar") and empty($GET_dia)){
?>
<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
<?php
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") ){
?>  

<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Listado&Area=<?php echo $_GET['Area'];?>&Moneda=<?php echo $_GET['Moneda']?>&Origen=<?php echo $_GET['Origen'];?>"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" /> Listado</a></div>

<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Monitoreo&Area=<?php echo $_GET['Area'];?>&Moneda=<?php echo $_GET['Moneda']?>&Origen=<?php echo $_GET['Origen'];?>"><img src="imagenes/iconos/monitoreo.png" alt="[Mon. Ord. Cobro]"  title="Ir a formulario de monitoreo de ordenes de cobro" />Cobros</a></div>


<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=CierreDia&Area=<?php echo $_GET['Area'];?>&Moneda=<?php echo $_GET['Moneda']?>&Origen=<?php echo $_GET['Origen'];?>"><img src="imagenes/iconos/cierre.png" alt="[Cierre Diario]"  title="Ir a formulario de Cierre Diario" />Cierre Diario</a></div>


<?php
}
?>
