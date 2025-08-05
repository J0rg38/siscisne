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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Imprimir"))?true:false;?>



<?php

$GET_ProductoId = $_GET['ProductoId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

$InsProducto = new ClsProducto();
$InsProducto->ProId = $GET_ProductoId;
$InsProducto->MtdObtenerProducto();

$InsVehiculoMarca = new ClsVehiculoMarca();
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >



  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td colspan="3"><span class="EstFormularioSubTitulo"> Informacion de Producto</span></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="25%">Cod. Original</td>
      <td width="1%">:</td>
      <td width="73%"><?php echo $InsProducto->ProCodigoOriginal?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nombre:</td>
      <td>:</td>
      <td><?php echo $InsProducto->ProNombre?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Unidad Medida</td>
      <td>:</td>
      <td><?php echo $InsProducto->UmeNombre;?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Referencia:</td>
      <td>:</td>
      <td><?php echo $InsProducto->ProReferencia?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Uso</td>
      <td>:</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3" align="center">
        
        <table class="EstTablaListado">
        <thead class="EstTablaListadoHead">
          <tr>
            <th width="300" align="center" valign="top"><span class="CapVehiculoUso">Marcas y Modelos </span></th>
            <th width="150" align="center" valign="top"><span class="CapVehiculoUso">Años </span></th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
          <tr>
            <td width="300" align="left" valign="top">
              
              <?php
    if(!empty($InsProducto->ProductoVehiculoVersion)){	
        foreach($InsProducto->ProductoVehiculoVersion as $DatProductoVehiculoVersion ){
	?>
              - <?php echo $DatProductoVehiculoVersion->VmaNombre;?> 
              <?php echo $DatProductoVehiculoVersion->VmoNombre;?> 
              <?php echo $DatProductoVehiculoVersion->VveNombre;?> <br />
              
              <?php           
        }
    }else{
	?>
    No se encontraron marcas y modelos asociados
    <?php	
	}
    ?>
              </td>
            <td width="150" align="left" valign="top">
              
              
              
              <?php
			  	if(!empty($InsProducto->ProductoAno)){	
					foreach($InsProducto->ProductoAno as $DatProductoAno ){
				?>
              - <?php echo $DatProductoAno->PanAno;?><br />
              <?php			
					}
				}else{
				?>
                No se encontraron a&ntilde;os asociados
                <?php	
				}
				?>
              
              
              </td>
            </tr>
            </tbody>
          </table>
        
      </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>

  </table>
</div>
   </div>
   