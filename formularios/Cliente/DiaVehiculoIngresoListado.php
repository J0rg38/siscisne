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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Imprimir"))?true:false;?>



<?php
$GET_CliId = $_GET['CliId'];

if(empty($GET_CliId)){
	exit("No se encontro cliente");
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();

//$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinVIN","ASC",NULL,NULL,NULL,$GET_CliId);
//$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','Desc',NULL,NULL,$GET_CliId);
$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];



?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de VEHICULOS del CLIENTE
        </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrVehiculoIngresoClientes)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="10%" align="center">Cod. Interno</th>
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
foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="left">
		<a target="_blank"  href="principal.php?Mod=VehiculoIngreso&Form=Ver&Id=<?php echo $DatVehiculoIngresoCliente->EinId;?>">
		<?php echo $DatVehiculoIngresoCliente->EinId;?>
        </a>
        </td>
        <td align="left"><?php echo $DatVehiculoIngresoCliente->EinVIN;?></td>
        <td align="left"><?php echo $DatVehiculoIngresoCliente->VmaNombre;?></td>
        <td align="left"><?php echo $DatVehiculoIngresoCliente->VmoNombre;?></td>
        <td align="left"><?php echo $DatVehiculoIngresoCliente->VveNombre;?></td>
        <td align="left"> <?php echo $DatVehiculoIngresoCliente->EinPlaca;?></td>
        <td align="center"><?php echo $DatVehiculoIngresoCliente->EinEstadoDescripcion;?></td>
        <td align="center">
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_self"  href="principal.php?Mod=VehiculoIngreso&Form=Ver&Id=<?php echo $DatVehiculoIngresoCliente->EinId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
			/*if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id=<?php echo $DatVehiculoIngresoCliente->EinId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id=<?php echo $DatVehiculoIngresoCliente->EinId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron VEHICULOS para este CLIENTE
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
   