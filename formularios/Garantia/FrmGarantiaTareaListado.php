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
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsGarantiaTarea'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsGarantiaTarea'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

//		SesionObjeto-FichaAccionTarea
//		Parametro1 = FatId
//		Parametro2 =
//		Parametro3 = FatDescripcion
//		Parametro4 = FatVerificar1
//		Parametro5 = FatVerificar2
//		Parametro6 = FatAccion
//		Parametro7 = FatTiempoCreacion
//		Parametro8 = FatTiempoModificacion
//		Parametro9 = FatEstado



$RepSesionObjetos = $_SESSION['InsGarantiaTarea'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//deb($ArrSesionObjetos);

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
  <th width="2%" align="center">#</th>
  <th width="76%" align="center"> Descripcion
</th>
<th width="11%" align="center">
  Actividad
  
  
</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
//$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	if($DatSesionObjeto->Parametro9==1){
		
//	  if(!empty($ArrSesionObjetos)){	
//		  foreach($ArrSesionObjetos as $DatSesionObjeto1){
//			  $aux = '';			 
			  //if($DatSesionObjeto->Parametro4==1){
				//	 $aux = 'checked="checked"';
//				  break;
			 // }					
//		  }
//	  }		
?>
<tr>
<td align="right"><?php echo $c;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right">
  
  <?php
  switch($DatSesionObjeto->Parametro6){
	case "I":
?>
  Inspeccionar
  <?php	
	break;
	
	case "R":
?>
  Realizar
  <?php
	break;
	default:
?>
  -
  <?php
	break;
  }
  ?>
  
</td>
</tr>
<?php

//		$TotalItems++;
		$c++;
//	$aux = '';
	}
}
?>
</tbody>
</table>

<?php
}
?>
