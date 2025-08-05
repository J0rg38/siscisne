<?php
require_once('../../proyecto/ClsProyecto.php');
$InsProyecto->Ruta = '../../';

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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsGarantiaProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsGarantiaProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}


	
//SesionObjeto-FichaAccionProducto
//Parametro1 = FapId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = FapVerificar1
//Parametro5 = FapVerificar2
//Parametro6 = UmeId
//Parametro7 = FapTiempoCreacion
//Parametro8 = FapTiempoModificacion
//Parametro9 = FapCantidad
//Parametro10 = FapCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
//Parametro14 = FapEstado
	
$RepSesionObjetos = $_SESSION['InsGarantiaProducto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="1%" align="center">#</th>
  <th width="78%" align="center"> Nombre
</th>
  <th width="8%" align="center">U.M.</th>
  <th width="8%" align="center">Cant.</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;

foreach($ArrSesionObjetos as $DatSesionObjeto){
	if($DatSesionObjeto->Parametro14==1){
		
//			  $aux = '';			 
//			  if($DatSesionObjeto->Parametro4==1){
//					 $aux = 'checked="checked"';
//			  }	
?>


<tr>
<td align="right"><?php echo $c;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="center"><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="center"><?php echo number_format($DatSesionObjeto->Parametro9,2,'.','');?></td>
</tr>
<?php
		
		$c++;
		// $aux = '';
	}
}




?>
</tbody>
</table>
<br />
<?php
}
?>




