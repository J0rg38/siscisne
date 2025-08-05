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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoSalida","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoSalida","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoSalida","Imprimir"))?true:false;?>



<?php
$GET_GreId = $_GET['GreId'];
$GET_GrtId = $_GET['GrtId'];

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');

$InsGuiaRemisionAlmacenMovimiento = new ClsGuiaRemisionAlmacenMovimiento();

//MtdObtenerGuiaRemisionAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGuiaRemision=NULL,$oTalonario=NULL)

$ResGuiaRemisionAlmaceMovimiento = $InsGuiaRemisionAlmacenMovimiento->MtdObtenerGuiaRemisionAlmacenMovimientos(NULL,NULL,"AmoFecha","DESC",NULL,$GET_GreId,$GET_GrtId,1);
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
        <th width="15%" align="center">Ord. Ven.</th>
        <th width="18%" align="center">Fecha</th>
        <th width="52%" align="center">Observacion</th>
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
        <td align="left"><a target="_self"  href="principal.php?Mod=AlmacenMovimientoSalida&amp;Form=Ver&amp;Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->AmoId;?>"><?php echo $DatGuiaRemisionAlmacenMovimientoSalida->AmoId;?></a></td>
        <td align="left">
         
            <?php echo $DatGuiaRemisionAlmacenMovimientoSalida->AmoFecha;?>
            
        </td>
        <td align="left"><?php echo $DatGuiaRemisionAlmacenMovimientoSalida->AmoObservacion;?></td>
        <td align="center">
          
          <?php
		  switch($DatGuiaRemisionAlmacenMovimientoSalida->AmoSubTipo){
			  
			  case 1:
			?>
            
            <?php
			  break;
			  
			    case 2:
			?>
            
            <?php
			  break;
			  
			     case 2:
			?>
            
            <?php
			  break;
			  
			  
		  }
		  
		  ?>
          <?php
			if($PrivilegioVer){
			?>
          <a target="_self"  href="principal.php?Mod=AlmacenMovimientoSalida&Form=Ver&Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->AmoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
			if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->AmoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id=<?php echo $DatGuiaRemisionAlmacenMovimientoSalida->AmoId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
          <?php
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
   