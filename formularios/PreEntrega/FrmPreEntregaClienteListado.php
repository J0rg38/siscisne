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

//deb($Identificador);
session_start();
if (!isset($_SESSION['InsPreEntregaCliente'.$Identificador])){
	$_SESSION['InsPreEntregaCliente'.$Identificador] = new ClsSesionObjeto();	
}


			
/*
SesionObjeto-FichaIngresoCliente
Parametro1 = 
Parametro2 = CliId
Parametro3 = CliNombre
Parametro4 = CliNumeroDocumento
Parametro5 = CliApellidoPaterno
Parametro6 = CliApellidoMaterno
Parametro7 = 
Parametro8 = 
*/
		
$RepSesionObjetos = $_SESSION['InsPreEntregaCliente'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="2%" align="center">#</th>
  <th width="21%" align="center">Num. Doc.</th>
  <th width="77%" align="center"> Nombre
</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>
<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro4;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro3;?>
  <?php echo $DatSesionObjeto->Parametro5;?>
  <?php echo $DatSesionObjeto->Parametro6;?>
</td>
</tr>
<?php
	$TotalItems++;
$c++;
}




?>
</tbody>
</table>
<br />
<?php
}
?>




