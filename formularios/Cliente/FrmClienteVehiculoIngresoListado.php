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

session_start();
if (!isset($_SESSION['InsClienteVehiculoIngreso'.$Identificador])){
	$_SESSION['InsClienteVehiculoIngreso'.$Identificador] = new ClsSesionObjeto();	
}



//SesionObjeto-ClienteVehiculoIngreso
//Parametro1 = 
//Parametro2 = EinVIN
//Parametro3 = VmaNombre
//Parametro4 = VmoNombre
//Parametro5 = VveNombre
//Parametro6 = EinPlaca
//Parametro7 = EinTiempoCreacion
//Parametro8 = EinTiempoModificacion
//Parametro9 = EinColor

$RepSesionObjetos = $_SESSION['InsClienteVehiculoIngreso'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//
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
  <th width="92">VIN</th>
  <th width="92">Marca</th>
  <th width="153"> Modelo</th>
  <th width="562">Version</th>
  <th width="101">Placa</th>
  <th width="72">Color</th>
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
<td align="right"><?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro4;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro5;?></td>
<td width="101" align="right"><?php echo $DatSesionObjeto->Parametro6;?></td>
<td width="72" align="right"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td width="90" align="center">
  <?php
  
if($_POST['Editar']==1){
?>
 
  <a class="EstSesionObjetosItem" href="javascript:FncClienteVehiculoIngresoEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncClienteVehiculoIngresoEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
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
