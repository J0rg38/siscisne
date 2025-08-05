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


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCliente = new ClsCliente();

//$ResCliente = $InsCliente->MtdObtenerClientees($_POST['Campo'],$_POST['Condicion'],$_POST['Filtro'],$_POST['Campo'],"ASC",NULL,NULL);
$ResCliente = $InsCliente->MtdObtenerClientees("CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento","contiene",$_POST['Filtro'],"CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento","ASC",NULL,NULL);
$ArrClientees = $ResCliente['Datos'];
$ClienteesTotal = $ResCliente['Total'];

?>





<?php
if(empty($ArrClientees)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $ClienteesTotal;?> elemento(s)
<table class="EstTablaListado" width="100%" cellpadding="2" cellspacing="1" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="8%">Tipo Doc.</th>
  <th width="9%">Num. Doc.</th>
  <th width="34%">
Nombre</th>
  <th width="22%">Apellido Paterno</th>
  <th width="17%">Apellido Materno</th>
  <th width="8%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrClientees as $DatCliente){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatCliente->TdoNombre;?></td>
<td align="right"><?php echo $DatCliente->CliNumeroDocumento;?></td>
<td align="right">
<?php echo $DatCliente->CliNombre;?></td>
<td align="right"><?php echo $DatCliente->CliApellidoPaterno;?></td>
<td align="right"><?php echo $DatCliente->CliApellidoMaterno;?></td>
<td align="right">
  
  <!--<a  href="javascript:FncVehiculoMovimientoSalidaClienteEscoger('<?php echo $_POST['Tipo']?>','<?php echo $_POST['Ruta']?>','<?php echo $DatCliente->CliId;?>','<?php echo $DatCliente->CliNumeroDocumento;?>','<?php echo $DatCliente->CliNombre;?>','<?php echo $DatCliente->CliDireccion;?>','<?php echo $DatCliente->TdoId;?>');">
<img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  /></a>
-->
  
  <a  href="javascript:FncClienteListadorEscoger('<?php echo $_POST['Tipo']?>','<?php echo $_POST['Ruta']?>','<?php echo $DatCliente->CliId;?>');"><img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  /></a>
  
  
  
  
</td>
</tr>
<?php
$c++;
}
?>
</tbody>
</table>

<?php
}
?>

