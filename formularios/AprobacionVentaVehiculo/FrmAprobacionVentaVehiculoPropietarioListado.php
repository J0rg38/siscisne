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

session_start();
if (!isset($_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador])){
	$_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();	
}


//
//SesionObjeto-AprobacionVentaVehiculoPropietario
//Parametro1 = CviId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = CviTiempoCreacion
//Parametro8 = CviTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = CliTelefono
//Parametro11 = CliCelular
//Parametro12 = CliEmail


$RepSesionObjetos = $_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="26">#</th>
  <th width="87">Tipo Doc.</th>
  <th width="137"> Num. Documento</th>
  <th width="382">Cliente</th>
  <th width="129">Telefono</th>
  <th width="163">Celular</th>
  <th width="99">Email</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro4;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro3;?></td>
<td width="129" align="right"><?php echo $DatSesionObjeto->Parametro10;?></td>
<td width="163" align="right"><?php echo $DatSesionObjeto->Parametro11;?></td>
<td width="99" align="right"><?php echo $DatSesionObjeto->Parametro12;?></td>
</tr>
<?php
	

$c++;
}



?>





</tbody>
</table>
<br />
<?php
}
?>
