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
if (!isset($_SESSION['InsFacturaAlmacenMovimiento'.$Identificador])){
	$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();	
}

//SesionObjeto-FacturaAlmacenMovimiento
//Parametro1 = FamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = FamEstado
//Parametro6 = FamTiempoCreacion
//Parametro7 = FamTiempoModificacion

$RepSesionObjetos = $_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="22">#</th>
  <th width="95">Fecha</th>
  <th width="299"> Num. Ficha</th>
  <th width="788"> Acc.</th>
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

<?php echo ($DatSesionObjeto->Parametro10);?>
<?php echo ($DatSesionObjeto->Parametro12);?>
</td>
<td align="right" valign="top">
  <?php //echo utf8_encode($DatSesionObjeto->Parametro2);?>
  
<?php

switch($DatSesionObjeto->Parametro11){
		  case "3"://VCO
	  ?>
<a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro2;?>');"> <?php echo $DatSesionObjeto->Parametro2;?></a>
<?php		
		  break;
		  
		  case "2"://AMS
	  ?>
<a href="javascript:FncTallerPedidoVistaPreliminar('<?php echo $DatSesionObjeto->Parametro2;?>');"> <?php echo $DatSesionObjeto->Parametro2;?></a>
<?php		
		  break;
		  
		  
		  case "1"://AMS
	  ?>
<a href="javascript:FncAlmacenMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro2;?>');"> <?php echo $DatSesionObjeto->Parametro2;?></a>
<?php		
		  break;
		  
		  default:
	  ?>
<?php //echo $DatSesionObjeto->Parametro2;?> 
<?php	
		  break;
	  }
	  
?>



<?php

switch($DatSesionObjeto->Parametro14){

		  case "1"://VMS
	  ?>
<a href="javascript:FncVehiculoMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro12;?>');"> <?php echo $DatSesionObjeto->Parametro12;?></a>
<?php		
		  break;
		  
		  case "2"://AMS
	  ?>
<a href="javascript:FncVehiculoMovimientoSalidaSimpleVistaPreliminar('<?php echo $DatSesionObjeto->Parametro12;?>');"> <?php echo $DatSesionObjeto->Parametro12;?></a>
<?php		
		  break;
		  
		  default:
	  ?>
<?php //echo $DatSesionObjeto->Parametro12;?> 
<?php	
		  break;
	  }
	  
?>
  
</td>
<td width="788" align="center" valign="top">

<?php

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
<?php //echo $DatSesionObjeto->Parametro2;?> 
<?php	
		  break;
	  }
	  
?>


<?php
//deb($DatSesionObjeto->Parametro14);
switch($DatSesionObjeto->Parametro14){

		  case "1"://VMS
	  ?>
<a href="javascript:FncVehiculoMovimientoSalidaVistaPreliminar('<?php echo $DatSesionObjeto->Parametro12;?>');"> <img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>
<?php		
		  break;
		  
		  case "2"://AMS
	  ?>
<a href="javascript:FncVehiculoMovimientoSalidaSimpleVistaPreliminar('<?php echo $DatSesionObjeto->Parametro12;?>');"> <img align="absmiddle" src="imagenes/acciones/listado_ver.png" alt="[Ver]" title="Ver" width="25" height="25" border="0" /></a>




<?php		
		  break;
		  
		  default:
	  ?>
<?php //echo $DatSesionObjeto->Parametro12;?> 
<?php	
		  break;
	  }
	  
?>
  
  <?php
if($POST_Eliminar==1){
?>
  
  <a href="javascript:FncBoletaAlmacenMovimientoEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
  <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  
  <?php
}
?>
</td>
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


