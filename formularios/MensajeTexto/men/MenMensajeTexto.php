
<?php
//deb($_GET['CmtId']);
//if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"MensajeTexto","Registrar") and empty($GET_dia)){
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"MensajeTexto","Registrar")){
?>
	
    <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&CmtId=<?php echo $_GET['CmtId'];?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
    
<?php
}
?>
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"MensajeTexto","Listado") ){
?>  

	<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Listado<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&CmtId=<?php echo $_GET['CmtId'];?>"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>

<?php
}
?>