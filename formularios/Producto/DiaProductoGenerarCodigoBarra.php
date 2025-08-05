<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta      = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');

$GET_id = $_POST['CmpId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCategoria.php');

$InsProducto = new ClsProducto();

$InsProducto->ProId = $GET_id;
$InsProducto->MtdObtenerProducto();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title</title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link rel="stylesheet" type="text/css" href="css/CssProducto.css">

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="js/JsProductoFunciones.js"></script>

<script type="text/javascript">

$().ready(function() {
	
	<?php
	if ($_GET['P'] == 1) {
	?> 
		FncImprimir(); 
	<?php
	}
	?>
	
	<?php
	if ($_GET['P'] == 1) {
	?>
		setTimeout("window.close();",1500);
	<?php
	}
	?>
	
});
</script>

</head>
<body>

<?php

$POST_cnt = $_POST['CmpCantidad'];
$POST_arr =  $_POST['CmpArriba'];
$POST_der =  $_POST['CmpDerecha'];
$POST_izq =  $_POST['CmpIzquierda'];


$POST_Cantidad =  $_POST['CmpCantidad'];

if(empty($POST_Cantidad)){
	$POST_Cantidad = 1;
}

if(empty($POST_arr)){
	$POST_arr = "C & C S.A.C.";
}

if(empty($POST_der)){
	$POST_der = "-";
}

if(empty($POST_izq)){
	$POST_izq = "-";
}

?>


<table cellpadding="0" cellspacing="8" border="0" >
<tr>

<?php
for($i=1;$i<=$POST_Cantidad;$i++){
?>

<td>

<div class="EstCodigoBarra">


<div class="EstCodigoBarraArriba"><?php echo $POST_arr;?></div>
    <div class="EstCodigoBarraLateral1"><?php echo $POST_izq?></div>    
    <div class="EstCodigoBarraMedio">
      
      <img src="cb.php?o=1&t=30&r=1&text=<?php echo urlencode($InsProducto->ProCodigoOriginal);?>&f=2&a1=1&a2=" alt="[Error]"    />  
      
    </div>   
    
    
    <div class="EstCodigoBarraLateral2"><?php echo $POST_der?></div>
   <!-- <div class="EstCodigoBarraSeparacion">-</div>-->
    
  
</div>  
    </td>


 </td> 
<?php
if($i%3==0){
?>
</tr><tr>
<?php	
}
?> 

   
<?php	
}
?>


</tr>  
</table>

</body>
</html>
