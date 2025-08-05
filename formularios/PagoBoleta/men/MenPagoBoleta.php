
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar") and empty($GET_dia)){
?>
	
    <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo (!empty($GET_NMod)?$GET_NMod:$GET_mod);?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
    
<?php
}
?>
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado") ){
?>  

	<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo (!empty($GET_NMod)?$GET_NMod:$GET_mod);?>&Form=Listado<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&BolId=<?php echo $_GET['BolId'];?>&BtaId=<?php echo $_GET['BtaId'];?>"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>

<?php
}
?>