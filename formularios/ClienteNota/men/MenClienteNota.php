
<?php
//deb($_GET['CliId']);
//if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClienteNota","Registrar") and empty($GET_dia)){
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClienteNota","Registrar")){
?>
	
    <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&CliId=<?php echo $_GET['CliId'];?>"><img src="imagenes/submenu/nuevo.png" alt="[Nuevo]" title="Ir a formulario de registro"   />Nuevo</a></div>
    
<?php
}
?>
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClienteNota","Listado") ){
?>  

	<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Listado<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&CliId=<?php echo $_GET['CliId'];?>"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" />Listado</a></div>

<?php
}
?>