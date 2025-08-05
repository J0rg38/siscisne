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


require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsProveedor = new ClsProveedor();

//$ResProveedor = $InsProveedor->MtdObtenerProveedores($_POST['Campo'],$_POST['Condicion'],$_POST['Filtro'],$_POST['Campo'],"ASC",NULL,NULL);
$ResProveedor = $InsProveedor->MtdObtenerProveedores("PrvNombreCompleto,PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno,PrvNumeroDocumento","contiene",$_POST['Filtro'],"PrvNombreCompleto,PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno,PrvNumeroDocumento","ASC",NULL,NULL);
$ArrProveedores = $ResProveedor['Datos'];
$ProveedoresTotal = $ResProveedor['Total'];

?>





<?php
if(empty($ArrProveedores)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $ProveedoresTotal;?> elemento(s)
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
foreach($ArrProveedores as $DatProveedor){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatProveedor->TdoNombre;?></td>
<td align="right"><?php echo $DatProveedor->PrvNumeroDocumento;?></td>
<td align="right">
<?php echo $DatProveedor->PrvNombre;?></td>
<td align="right"><?php echo $DatProveedor->PrvApellidoPaterno;?></td>
<td align="right"><?php echo $DatProveedor->PrvApellidoMaterno;?></td>
<td align="right">
  
  <!--<a  href="javascript:FncCompraVehiculoProveedorEscoger('<?php echo $_POST['Tipo']?>','<?php echo $_POST['Ruta']?>','<?php echo $DatProveedor->PrvId;?>','<?php echo $DatProveedor->PrvNumeroDocumento;?>','<?php echo $DatProveedor->PrvNombre;?>','<?php echo $DatProveedor->PrvDireccion;?>','<?php echo $DatProveedor->TdoId;?>');">
<img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  /></a>
-->
  
  <a  href="javascript:FncProveedorListadorEscoger('<?php echo $_POST['Tipo']?>','<?php echo $_POST['Ruta']?>','<?php echo $DatProveedor->PrvId;?>');"><img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  /></a>
  
  
  
  
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

