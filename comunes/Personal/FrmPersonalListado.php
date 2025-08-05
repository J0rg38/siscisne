<?php
session_start();
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

require_once($InsPoo->MtdPaqLogistica().'ClsPersonal.php');

$InsPersonal = new ClsPersonal();

$ResPersonal = $InsPersonal->MtdObtenerPersonales("PerNombreCompleto,PerNumeroDocumento,PerNombre,PerApellidoPaterno,PerApellidoMaterno","contiene",$_POST['Filtro'],"PerNombreCompleto,PerNumeroDocumento,PerNombre,PerApellidoPaterno,PerApellidoMaterno","ASC",1,NULL,NULL,$_POST['Categoria'],true);

$ArrPersonales = $ResPersonal['Datos'];
$PersonalesTotal = $ResPersonal['Total'];

?>





<?php
if(empty($ArrPersonales)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $PersonalesTotal;?> elemento(s)
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstTablaListado">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="8%">Tipo Doc.</th>
  <th width="9%">Num. Doc.</th>
  <th width="8%">Tipo Per.</th>
  <th width="33%">
    Nombre</th>
  <th width="15%">Apellido Paterno</th>
  <th width="20%">Apellido Materno</th>
  <th width="5%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrPersonales as $DatPersonal){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatPersonal->TdoNombre;?></td>
<td align="right"><?php echo $DatPersonal->PerNumeroDocumento;?></td>
<td align="right">

<?php echo (empty($DatPersonal->LtiAbreviatura)?$DatPersonal->LtiNombre:$DatPersonal->LtiAbreviatura)//FncCortarTexto($dat->LtiNombre,15);?>


</td>
<td align="right">

<a  href="javascript:FncPersonalListadorEscoger('<?php echo $DatPersonal->PerId;?>');">
  <?php echo $DatPersonal->PerNombre;?>
  </a>
  </td>
<td align="right">
<a  href="javascript:FncPersonalListadorEscoger('<?php echo $DatPersonal->PerId;?>');">
<?php echo $DatPersonal->PerApellidoPaterno;?></a></td>
<td align="right">
<a  href="javascript:FncPersonalListadorEscoger('<?php echo $DatPersonal->PerId;?>');">
<?php echo $DatPersonal->PerApellidoMaterno;?>
</a>
</td>
<td align="center">
  
  
  
<a  href="javascript:FncPersonalListadorEscoger('<?php echo $DatPersonal->PerId;?>');">
<img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  />
</a>
  
  
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

