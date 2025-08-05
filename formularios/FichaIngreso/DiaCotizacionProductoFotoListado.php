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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","Imprimir"))?true:false;?>



<?php
$GET_FinId = $_GET['FinId'];

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');

$InsCotizacionProducto = new ClsCotizacionProducto();

//MtdObtenerCotizacionProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL)
$ResCotizacionProducto = $InsCotizacionProducto->MtdObtenerCotizacionProductos(NULL,NULL,NULL,"CprFecha","ASC",NULL,NULL,NULL,NULL,NULL,$GET_FinId);
$ArrCotizacionProductos = $ResCotizacionProducto['Datos'];
?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de COTIZACIONES de la ORDEN DE TRABAJO
        </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($ArrCotizacionProductos)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="12%" align="center">Cod. Cot.</th>
        <th width="13%" align="center">Num. Doc.</th>
        <th width="31%" align="center">Cliente</th>
        <th width="16%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
foreach($ArrCotizacionProductos as $DatCotizacionProducto){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="left">
		<a target="_self"  href="principal.php?Mod=CotizacionProducto&Form=Ver&Id=<?php echo $DatCotizacionProducto->CprId;?>">
		<?php echo $DatCotizacionProducto->CprId;?>
        </a>
        </td>
        <td align="left"><?php echo $DatCotizacionProducto->CprFecha;?></td>
        <td align="left">
          
          <?php echo $DatCotizacionProducto->CliNombre;?>
          <?php echo $DatCotizacionProducto->CliApellidoPaterno;?>
          <?php echo $DatCotizacionProducto->CliApellidoMaterno;?>
          
        </td>
        <td align="center">
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_self"  href="principal.php?Mod=CotizacionProducto&Form=Ver&Id=<?php echo $DatCotizacionProducto->CprId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
          <?php
			}
			?>
          
          <?php
			if($PrivilegioVistaPreliminar){
			?>
          <a href="javascript:FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id=<?php echo $DatCotizacionProducto->CprId;?>&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
          <?php
			}
			?>
          
          <?php
			if($PrivilegioImprimir){
			?>        
          
          <a href="javascript:FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id=<?php echo $DatCotizacionProducto->CprId;?>&P=1&ImprimirCodigo=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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
No se encontraron COTIZACIONES para esta ORDEN DE TRABAJO
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
   