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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Imprimir"))?true:false;?>

<?php $PrivilegioGenerarVentaConcretada = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Registrar"))?true:false;?>
<?php $PrivilegioGenerarPedidoCompra = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Registrar"))?true:false;?>

<?php

$GET_CprId = $_GET['CprId'];


require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$GET_CprId = $_GET['CprId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsCotizacionProducto = new ClsCotizacionProducto();
$InsCotizacionProducto->CprId = $GET_CprId;
$InsCotizacionProducto->MtdObtenerCotizacionProducto();

	if(!empty($InsCotizacionProducto->CotizacionProductoFoto)){
		foreach($InsCotizacionProducto->CotizacionProductoFoto as $DatCotizacionProductoFoto){
			
			$_SESSION['InsCotizacionProductoFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoFoto->CpfId,
			NULL,
			$DatCotizacionProductoFoto->CpfArchivo,			
			$DatCotizacionProductoFoto->CpfEstado,
			($DatCotizacionProductoFoto->CpfTiempoCreacion),
			($DatCotizacionProductoFoto->CpfTiempoModificacion),
			$DatCotizacionProductoFoto->CpfTipo
			);
	
		}
	}
?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de DOCUMENTOS ADJUNTOS de la COTIZACION
        </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
<?php
if(!empty($InsCotizacionProducto->CotizacionProductoFoto)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="2%" align="center">#</th>
        <th width="91%" align="center">Ord. Venta</th>
        <th width="7%" align="center">Acciones</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
	<?php
    $i=1;
   foreach($InsCotizacionProducto->CotizacionProductoFoto as $DatCotizacionProductoFoto){
    ?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
          
          <?php echo $DatCotizacionProductoFoto->CpfArchivo;?>
          
        </td>
        <td align="center">
          
          <?php
			if($PrivilegioVer){
			?>
          <a target="_blank" href="subidos/cotizacion_producto_fotos/<?php echo $DatCotizacionProductoFoto->CpfArchivo;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
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
No se encontraron DOCUMENTACION ADJUNTA
<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   