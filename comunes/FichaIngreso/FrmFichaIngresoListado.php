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

//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

$InsACL = new ClsACL();

$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","AccesoTotal"))?true:false;

$POST_Filtro = $_POST['Filtro'];
$POST_Sucursal = $_POST['Sucursal'];


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');
$InsFichaIngreso = new ClsFichaIngreso();

//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oVehiculoMarca=NULL,$oCodigoOriginal=NULL,$oSucursal=NULL,$oMigrado=true)
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId,EinVIN,EinPlaca,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,FinConductor,VmaNombre,VmoNombre,VveNombre","contiene",$POST_Filtro,"FinFecha","DESC",$POST_pag,FncCambiaFechaAMysql($POST_finicio,true),FncCambiaFechaAMysql($POST_ffin,true),$POST_estado,$POST_Prioridad,$POST_Modalidad,NULL,NULL,$POST_Personal,0,NULL,NULL,1,0,$POST_ConCampana,NULL,0,NULL,$POST_Asesor,$POST_VehiculoMarca,$POST_CodigoOriginal,$POST_Sucursal,false);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];
?>





<?php
if(empty($ArrFichaIngresos)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $FichaIngresosTotal;?> elemento(s)
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstTablaListado">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="7%" align="center">Sucursal</th>
  <th width="7%" align="center">Orden de Venta</th>
  <th width="6%" align="center">Num. Doc.</th>
  <th width="38%" align="center">
    Nombre</th>
  <th width="8%" align="center">Telef.</th>
  <th width="8%" align="center">Cel.</th>
  <th width="7%" align="center">VIN</th>
  <th width="6%" align="center">Placa</th>
  <th width="5%" align="center">Vehiculo</th>
  <th width="6%" align="center"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrFichaIngresos as $DatFichaIngreso){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatFichaIngreso->SucNombre;?></td>
<td align="right"><?php echo $DatFichaIngreso->FinId;?></td>
<td align="right"><?php echo $DatFichaIngreso->CliNumeroDocumento;?></td>
<td align="right">
  
    <?php echo $DatFichaIngreso->CliNombre;?> <?php echo $DatFichaIngreso->CliApellidoPaterno;?> <?php echo $DatFichaIngreso->CliApellidoMaterno;?>
    
</td>
<td align="center"><?php echo $DatFichaIngreso->CliTelefono;?></td>
<td align="center"><?php echo $DatFichaIngreso->CliCelular;?></td>
<td align="center"><?php echo $DatFichaIngreso->EinVIN;?></td>
<td align="center"><?php echo $DatFichaIngreso->EinPlaca;?></td>
<td align="center"><?php echo $DatFichaIngreso->VmaNombre;?><?php echo $DatFichaIngreso->VmoNombre;?><?php echo $DatFichaIngreso->VveNombre;?></td>
<td align="center">
  
  
  
  <a  href="javascript:FncFichaIngresoListadoEscoger('<?php echo $DatFichaIngreso->FinId;?>');">
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

