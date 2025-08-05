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
if (!isset($_SESSION['InsVehiculoIngresoCliente'.$Identificador])){
	$_SESSION['InsVehiculoIngresoCliente'.$Identificador] = new ClsSesionObjeto();	
}



//SesionObjeto-VehiculoIngresoCliente
//Parametro1 = VicId
//Parametro2 = CliId
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = VicTiempoCreacion
//Parametro8 = VicTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = VicEstado
//Parametro11 = VicFecha

$RepSesionObjetos = $_SESSION['InsVehiculoIngresoCliente'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="29">#</th>
  <th width="92">Id</th>
  <th width="92">Tipo Doc.</th>
  <th width="153"> Num. Documento</th>
  <th width="562">Cliente</th>
  <th width="101">Fecha Vigencia</th>
  <th width="72">Vigencia</th>
  <th width="90"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro4;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro3;?></td>
<td width="101" align="center"><?php echo $DatSesionObjeto->Parametro11;?></td>
<td width="72" align="center">

<?php
switch($DatSesionObjeto->Parametro10){
	
	case 1:
?>
		Vigente
<?php	
	break;
	
	case 2:
?>
		Antiguo
<?php	
	break;
}
?>
<?php //echo $DatSesionObjeto->Parametro10;?>

</td>
<td width="90" align="center">
  <?php
  
if($_POST['Editar']==1){
?>
 
  <a class="EstSesionObjetosItem" href="javascript:FncVehiculoIngresoClienteEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncVehiculoIngresoClienteEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
  <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  
  
  <?php
}
?>
</td>
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
