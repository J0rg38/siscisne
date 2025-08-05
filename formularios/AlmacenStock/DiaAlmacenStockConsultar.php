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
$GET_Ano = (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);
$GET_Sucursal = (empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal']);


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsAlmacenStock = new ClsAlmacenStock();
$InsAlmacen = new ClsAlmacen();
$InsProducto = new ClsProducto();
$InsSucursal = new ClsSucursal();


$InsProducto->ProId = $GET_ProductoId;
$InsProducto->MtdObtenerProducto(false);


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$GET_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];



$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >



  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td colspan="3"><span class="EstFormularioSubTitulo"> Stock de Producto</span></td>
      <td width="14%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="35%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="17%">Cod. Original</td>
      <td width="1%">:</td>
      <td width="31%"><?php echo $InsProducto->ProCodigoOriginal?></td>
      <td>Nombre:</td>
      <td>:</td>
      <td><?php echo $InsProducto->ProNombre?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Referencia</td>
      <td>:</td>
      <td><?php echo $InsProducto->ProReferencia?></td>
      <td>Ubicacion</td>
      <td>:</td>
      <td><?php echo $InsProducto->ProUbicacion?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Sucursal</td>
      <td>:</td>
      <td colspan="4">
        
        
        
        
        
        <select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
          <option value="">Escoja una opcion</option>
          <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
          <option value="<?php echo $DatSucursal->SucId?>" <?php if($GET_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
          <?php
    }
    ?>
          </select>
        
      </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6">Disponibilidad en Almacenes:</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6">
        
        <table width="100%" class="EstTablaListado">
        <thead class="EstTablaListadoHead">
          <tr>
			<?php
			if(!empty($ArrAlmacenes)){
				foreach($ArrAlmacenes as $DatAlmacen){
			?>
            
           
            <th width="50" align="center" valign="top"><?php echo $DatAlmacen->AlmNombre;?></th>
            <?php		
				}
			}
			?>
            </tr>
            
		</thead>	
        <tbody class="EstTablaListadoBody">
          <tr>
          <?php
			if(!empty($ArrAlmacenes)){
				foreach($ArrAlmacenes as $DatAlmacen){
			?>
            <td width="50" align="left" valign="top">
 
 <?php
 $InsAlmacenStock = new ClsAlmacenStock();
//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno)
 $ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"ProId","ASC",1,"1",NULL,$GET_Ano."-01-01",$GET_Ano."".date("-m-d"),NULL,NULL,NULL,$InsProducto->ProId,NULL,$DatAlmacen->AlmId,false,$_SESSION['SesionSucursal'],$GET_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

 ?>
 
 <?php
 $Stock = 0;
 if(!empty($ArrAlmacenStocks)){
	 foreach($ArrAlmacenStocks as $DatAlmacenStock){
		 $Stock = $DatAlmacenStock->AstStockReal;
	 }
 }
 ?>
 
 <?php
 	echo number_format($Stock,2);
 ?>
 
              </td>
            <?php		
				}
			}
			?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   