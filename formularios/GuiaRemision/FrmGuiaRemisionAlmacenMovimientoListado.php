<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

session_start();
if (!isset($_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador])){
	$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();	
}


	//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = 
	//Parametro3 = 
	//Parametro4 = AmoId
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = VmvFecha
	//Parametro10 = AmoFecha
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo

$RepSesionObjetos = $_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


?>





<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->





<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="19">#</th>
  <th width="115">Fecha</th>
  <th width="606"> Num. Ficha</th>
  <th width="258"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
$CantidadTotal = 0;
$TotalItems = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){

//$DescuentoUnitario = $DatSesionObjeto->Parametro4 * $_POST['Descuento'];
//$PrecioNeto = $DatSesionObjeto->Parametro4 - $DescuentoUnitario;
//$ImporteNeto = $DatSesionObjeto->Parametro5 * $PrecioNeto;
?>


<tr>
<td align="center" valign="top">
  <span title="<?php echo $DatSesionObjeto->Parametro1;?>">
  <?php echo $c;?></span></td>
<td align="right" valign="top">

<?php echo ($DatSesionObjeto->Parametro9);?>
<?php echo ($DatSesionObjeto->Parametro10);?>

</td>
<td align="right" valign="top"><?php //echo utf8_encode($DatSesionObjeto->Parametro2);?>
 
 <?php
 if(!empty($DatSesionObjeto->Parametro4)){
?>


  <?php

switch($DatSesionObjeto->Parametro11){
		  case "3"://VCO
	  ?>
  <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro4;?>');"> <?php echo $DatSesionObjeto->Parametro4;?></a>
  <?php		
		  break;
		  
		  case "2"://AMS
	  ?>
  <a href="javascript:FncTallerPedidoVistaPreliminar('<?php echo $DatSesionObjeto->Parametro4;?>');"> <?php echo $DatSesionObjeto->Parametro4;?></a>
  <?php		
		  break;
		  
		  
		  case "1"://AMS
	  ?>
  <a href="javascript:FncAlmacenMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro4;?>');"> <?php echo $DatSesionObjeto->Parametro4;?></a>
  <?php		
		  break;
		  
		  default:
	  ?>
  <?php echo $DatSesionObjeto->Parametro4;?> *
  <?php	
		  break;
	  }
	  
?>

<?php 
 }else{
	?>
    
    
  <?php

switch($DatSesionObjeto->Parametro12){
		  
		  case "2"://AMS
	  ?>
			<a href="javascript:FncVehiculoMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro8;?>');"> <?php echo $DatSesionObjeto->Parametro8;?></a>
  <?php		
		  break;
		  
		  
		  case "1"://AMS
	  ?>
			<a href="javascript:FncVehiculoMovimientoSalidaSimpleVistaPreliminar('<?php echo $DatSesionObjeto->Parametro8;?>');"> <?php echo $DatSesionObjeto->Parametro8;?></a>
  <?php		
		  break;
		  
		  default:
	  ?>
		<?php echo $DatSesionObjeto->Parametro8;?> *
  <?php	
		  break;
	  }
	  
?>
    
    <?php 
 }
 ?>
 
 </td>
<td width="258" align="center" valign="top">


 <?php
 if(!empty($DatSesionObjeto->Parametro4)){
?>


  <?php

switch($DatSesionObjeto->Parametro11){
		  case "3"://VCO
	  ?>
  <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro4;?>');"><img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  case "2"://AMS
	  ?>
  <a href="javascript:FncTallerPedidoVistaPreliminar('<?php echo $DatSesionObjeto->Parametro4;?>');"><img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  
		  case "1"://AMS
	  ?>
  <a href="javascript:FncAlmacenMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro4;?>');"> <img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  default:
	  ?>
  -
  <?php	
		  break;
	  }
	  
?>

<?php 
 }else{
	?>
    
    
  <?php

switch($DatSesionObjeto->Parametro12){
		  
		  case "2"://AMS
	  ?>
			<a href="javascript:FncVehiculoMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro8;?>');"> <img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  
		  case "1"://AMS
	  ?>
			<a href="javascript:FncVehiculoMovimientoSalidaSimpleVistaPreliminar('<?php echo $DatSesionObjeto->Parametro8;?>');"><img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  default:
	  ?>
		-
  <?php	
		  break;
	  }
	  
?>
    
    <?php 
 }
 ?>
 
 
 
 
<?php
/*
switch($DatSesionObjeto->Parametro11){
		  case "3"://VCO
	  ?>
  <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro2;?>');"><img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  case "2"://AMS
	  ?>
  <a href="javascript:FncTallerPedidoVistaPreliminar('<?php echo $DatSesionObjeto->Parametro2;?>');"> <img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  
		  case "1"://AMS
	  ?>
  <a href="javascript:FncAlmacenMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro2;?>');"> <img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
  <?php		
		  break;
		  
		  default:
	  ?>
  <?php echo $DatSesionObjeto->Parametro2;?> *
  <?php	
		  break;
	  }
	  */
?>
  <?php
if($POST_Eliminar==1){
?>
  <a href="javascript:FncBoletaAlmacenMovimientoEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
</tr>
<?php
	$TotalItems++;

$c++;
}


?>




</tbody>
</table>



<?php
}
?>


