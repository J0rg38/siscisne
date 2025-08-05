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
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();

$POST_UnidadMedidaBase = $_POST['UnidadMedidaBase'];
$POST_ProductoTipo = $_POST['ProductoTipo'];
$POST_ProductoTipoUnidadMedidaBaseHabilitado = $_POST['ProductoTipoUnidadMedidaBaseHabilitado'];

//MtdObtenerProductoTipoUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PtuId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTipo=NULL,$oProductoTipo=NULL)
//MtdObtenerProductoTipoUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PtuId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTipo=NULL,$oProductoTipo=NULL,$oUso=NULL)
$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,3,$POST_ProductoTipo,null);
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
$ProductoTipoUnidadMedidasTotal = $ResProductoTipoUnidadMedida['Total'];


//$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,'PtuId','Desc',NULL,1,$DatProductoTipo->RtiId);
//$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];

?>

<?php
if(!empty($POST_ProductoTipo)){
?>

	<?php
    if(empty($ArrProductoTipoUnidadMedidas)){
    ?>
    No se encontraron elementos
    <?php
    }else{
    ?>
    
        <?php
			foreach($ArrProductoTipoUnidadMedidas as $ProductoTipoUnidadMedida){
			?>
    
    <input etiqueta="unidad_medida_base" <?php echo ($POST_ProductoTipoUnidadMedidaBaseHabilitado==2)?'disabled="disabled"':'';?> <?php echo ($ProductoTipoUnidadMedida->UmeId == $POST_UnidadMedidaBase)?'checked="checked"':'';?>  type="radio" name="CmpUnidadMedidaBase" id="CmpUnidadMedidaBase_<?php echo $ProductoTipoUnidadMedida->UmeId?>" value="<?php echo $ProductoTipoUnidadMedida->UmeId?>" />
    <?php echo $ProductoTipoUnidadMedida->UmeNombre?> [<?php echo $ProductoTipoUnidadMedida->UmeAbreviacion?>]<br />
    
    
    <?php
			}
			?>
    <?php
    }
    ?>

<?php	
}else{
?>
No ha escogido un TIPO DE PRODUCTO
<?php	
}
?>
