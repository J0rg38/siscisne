<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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
if (!isset($_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador])){
	$_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador] = new ClsSesionObjeto();	
}

	
	//SesionObjeto-InsOrdenVentaVehiculoLlamada
	//Parametro1 = OvlId
	//Parametro2 = OvlNumero
	//Parametro3 = OvlFecha
	//Parametro4 = OvlValor
	//Parametro5 = OvlObservacion
	//Parametro6 = OvlEstado
	//Parametro7 = OvlTiempoCreacion
	//Parametro8 = OvlTiempoModificacion
	
$RepSesionObjetos = $_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="3%" align="center">#</th>
  <th width="15%" align="center">Fecha</th>
  <th width="69%" align="center"> Nota</th>
  <th width="13%" align="center">Acc.</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$OrdenVentaVehiculoLlamadaTotal = 0;
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>


<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right">
  <?php echo ($DatSesionObjeto->Parametro5);?></td>
<td align="center">
  
  <?php
if($_POST['Editar']==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncOrdenVentaVehiculoLlamadaEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncOrdenVentaVehiculoLlamadaEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
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




