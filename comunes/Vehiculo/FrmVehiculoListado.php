<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');

$InsVehiculo = new ClsVehiculo();
$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos($_POST['Campo'],$_POST['Condicion'],$_POST['Filtro'],$_POST['Campo'],"ASC",NULL,NULL,NULL,NULL,NULL,1);
$ArrVehiculos = $ResVehiculo['Datos'];
$VehiculosTotal = $ResVehiculo['Total'];
?>

<?php
if(empty($ArrVehiculos)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $VehiculosTotal;?> elemento(s)
<table class="EstTablaListado" width="800" cellpadding="2" cellspacing="1" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="5%">#</th>
  <th width="17%">
    Marca</th>
  <th width="20%">Modelo</th>
  <th width="27%">Version</th>
  <th width="12%">Color</th>
  <th width="10%">Tipo</th>
  <th width="9%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrVehiculos as $DatVehiculo){
?>
<tr>
<td align="right"><?php echo $c;?></td>
<td align="right">
  <?php echo $DatVehiculo->VmaNombre;?></td>
<td align="right"><?php echo $DatVehiculo->VmoNombre;?></td>
<td align="right"><?php echo $DatVehiculo->VveNombre;?></td>
<td align="right"><?php echo $DatVehiculo->VehColor;?></td>
<td align="right"><?php echo $DatVehiculo->VtiNombre;?></td>
<td align="center">
  
  <a  href="javascript:FncVehiculoEscoger('<?php echo $DatVehiculo->VehId;?>','<?php echo $DatVehiculo->VehNumeroDocumento;?>','<?php echo $DatVehiculo->EinVIN;?>');">
    <img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  /></a></td>
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

