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

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$POST_Filtro = $_POST['Filtro'];

$InsCliente = new ClsCliente();

// MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oClienteTipo=NULL,$oClasificacion=NULL) 
$ResCliente = $InsCliente->MtdObtenerClientes("CliNombreCompleto,CliNumeroDocumento,CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_Filtro ,"CliNombre","ASC","1",NULL,"1",NULL,NULL,NULL);
$ArrClientes = $ResCliente['Datos'];
$ClientesTotal = $ResCliente['Total'];

?>





<?php
if(empty($ArrClientes)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $ClientesTotal;?> elemento(s)
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstTablaListado">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="9%" align="center">Tipo Doc.</th>
  <th width="7%" align="center">Num. Doc.</th>
  <th width="18%" align="center">Tipo Cli.</th>
  <th width="58%" align="center">
    Nombre</th>
  <th width="6%" align="center"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrClientes as $DatCliente){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatCliente->TdoNombre;?></td>
<td align="right"><?php echo $DatCliente->CliNumeroDocumento;?></td>
<td align="right">

<?php echo (empty($DatCliente->LtiAbreviatura)?$DatCliente->LtiNombre:$DatCliente->LtiAbreviatura)//FncCortarTexto($dat->LtiNombre,15);?>


</td>
<td align="right">
  
  <a  href="javascript:FncClienteListadorEscoger('<?php echo $DatCliente->CliId;?>');">
    <?php echo $DatCliente->CliNombre;?> <?php echo $DatCliente->CliApellidoPaterno;?> <?php echo $DatCliente->CliApellidoMaterno;?>
      </a>
</td>
<td align="center">
  
  
  
  <a  href="javascript:FncClienteListadorEscoger('<?php echo $DatCliente->CliId;?>');">
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

