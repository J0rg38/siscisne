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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","Imprimir"))?true:false;?>



<?php
$GET_GreId = $_GET['GreId'];
$GET_GrtId = $_GET['GrtId'];

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');

$InsGuiaRemisionAlmacenMovimiento = new ClsGuiaRemisionAlmacenMovimiento();

//MtdObtenerGuiaRemisionAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGuiaRemision=NULL,$oTalonario=NULL,$oTipo=NULL) 

$ResGuiaRemisionAlmaceMovimiento = $InsGuiaRemisionAlmacenMovimiento->MtdObtenerGuiaRemisionAlmacenMovimientos(NULL,NULL,"VmvFecha","DESC",NULL,$GET_GreId,$GET_GrtId,2);
$ArrGuiaRemisionAlmacenMovimientos = $ResGuiaRemisionAlmaceMovimiento['Datos'];
?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de Fichas de Salida de la GUIA DE REMISION</span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrGuiaRemisionAlmacenMovimientos)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="11%" align="center">Ficha</th>
        <th width="14%" align="center">Fecha</th>
        <th width="60%" align="center">Ref.</th>
        <th width="13%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrGuiaRemisionAlmacenMovimientos as $DatGuiaRemisionAlmacenMovimientoSalida){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="left"><a target="_self"  href="principal.php?Mod=VehiculoMovimientoSalida&amp;Form=Ver&amp;Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?>"><?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?></a></td>
        <td align="left">
         
            <?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvFecha;?>
            
        </td>
        <td align="left"><?php echo $DatGuiaRemisionAlmacenMovimientoSalida->CliNombre;?>
        <?php echo $DatGuiaRemisionAlmacenMovimientoSalida->CliApellidPaterno;?>
        <?php echo $DatGuiaRemisionAlmacenMovimientoSalida->CliApellidoMaterno;?>
        </td>
        <td align="center">
          
          
          <?php
		  switch($DatGuiaRemisionAlmacenMovimientoSalida->VmvSubTipo){
			  
			  case 1:
			?>
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_self"  href="principal.php?Mod=VehiculoMovimientoSalida&Form=Ver&Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
			if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/VehiculoMovimientoSalida/FrmVehiculoMovimientoSalidaImprimir.php?Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/VehiculoMovimientoSalida/FrmVehiculoMovimientoSalidaImprimir.php?Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
          <?php
			}
			?> 
          <?php
			  break;
			  
			    case 2:
			?>
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_self"  href="principal.php?Mod=VehiculoMovimientoSalidaSimple&Form=Ver&Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
			if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/VehiculoMovimientoSalidaSimple/FrmVehiculoMovimientoSalidaSimpleImprimir.php?Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/VehiculoMovimientoSalidaSimple/FrmVehiculoMovimientoSalidaSimpleImprimir.php?Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->VmvId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
          <?php
			}
			?> 
          <?php
			  break;
			  
			     default:
			?>
          
          <?php
			  break;
			  
			  
		  }
		  
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
No se encontraron FICHAS DE SALIDA para esta GUIA DE REMISION
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
   