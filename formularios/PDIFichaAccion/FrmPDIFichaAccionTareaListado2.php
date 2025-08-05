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
$ModalidadIngresoId = $_POST['ModalidadIngresoId'];

session_start();
if (!isset($_SESSION['InsFichaAccionTarea'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionTarea'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
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

$RepSesionObjetos = $_SESSION['InsFichaAccionTarea'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//deb($ArrSesionObjetos);
?>

<?php
if(empty($ArrSesionObjetos)){
?>
<!--No se encontraron elementos-->
<?php
}else{
?>

<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="81%" align="center"> Descripcion
</th>
<th width="15%" align="center">
  Actividad
  
  
</th>
<th width="2%" align="center">&nbsp;</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;

foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	if($DatSesionObjeto->Parametro9==2 ){
			 
			  if($DatSesionObjeto->Parametro4=="1"){
					 $aux = 'checked="checked"';

			  }					

?>
<tr>
<td align="left" valign="top"><?php echo $c;?></td>
<td align="left" valign="top">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="left" valign="top">
  
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
<td align="left" valign="top">
  
  
  <input <?php if($_POST['Editar']==3){?> disabled="disabled"  <?php }?> type="checkbox" <?php echo $aux;?>  name="CmpFichaAccionTarea_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpFichaAccionTarea_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="1" />
  
  
</td>
</tr>
<?php
	
$c++;
$aux = '';
	}
}
?>
</tbody>
</table>


<?php
}
?>
