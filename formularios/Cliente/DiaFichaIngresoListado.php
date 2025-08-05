<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}



////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';




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
/*
*Control de Lista de Acceso
*/
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();

/*
*Variables GET
*/
$GET_mod = $_GET['Mod'];
$GET_form = $_GET['Form'];

?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Imprimir"))?true:false;?>



<?php
$GET_CliId = $_GET['CliId'];

if(empty($GET_CliId)){
	exit("No se encontro cliente");
}

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

$InsFichaIngreso = new ClsFichaIngreso();

//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL) {
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinId","DESC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,$GET_CliId,NULL,0,NULL,NULL,1,NULL,NULL);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];

?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de ORDENES DE TRABAJO del CLIENTE
        </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrFichaIngresos)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="10%" align="center">Id</th>
        <th width="10%" align="center">Fecha</th>
        <th width="10%" align="center">Modalidades</th>
        <th width="10%" align="center">VIN</th>
        <th width="15%" align="center">Marca</th>
        <th width="13%" align="center">Modelo</th>
        <th width="12%" align="center">Version</th>
        <th width="9%" align="center">Placa</th>
        <th width="9%" align="center">Estado</th>
        <th width="11%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrFichaIngresos as $DatFichaIngreso){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="left">
		<a target="_blank"  href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatFichaIngreso->FinId;?>">
		<?php echo $DatFichaIngreso->FinId;?>
        </a>
        </td>
        <td align="left"><?php echo $DatFichaIngreso->FinFecha;?></td>
        <td align="left"><?php
		  $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
		  
		  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
		  $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatFichaIngreso->FinId,NULL);
		  $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
		  ?>
          <?php
		foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
		?>
-<?php echo $DatFichaIngresoModalidad->MinNombre?><br />
<?php
		}
		?></td>
        <td align="left"><?php echo $DatFichaIngreso->EinVIN;?></td>
        <td align="left"><?php echo $DatFichaIngreso->VmaNombre;?></td>
        <td align="left"><?php echo $DatFichaIngreso->VmoNombre;?></td>
        <td align="left"><?php echo $DatFichaIngreso->VveNombre;?></td>
        <td align="left"><?php echo $DatFichaIngreso->EinPlaca;?></td>
        <td align="center"><?php echo $DatFichaIngreso->EinEstadoDescripcion;?></td>
        <td align="center">
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_blank"  href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatFichaIngreso->FinId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
		  if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id=<?php echo $DatFichaIngreso->FinId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
		  ?>
          <?php
			/*
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id=<?php echo $DatFichaIngreso->EinId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
          <?php
			}*/
			?> 
          
          
          
        </td>
        </tr>
        
<?php
$i++;
}
?>
      
      </tbody>
      </table>

<?php
}else{
?>
No se encontraron ORDENES DE TRABAJO para este CLIENTE
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
   </div>
   