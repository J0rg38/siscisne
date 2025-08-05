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
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$POST_ProductoUnidadMedidaIngreso = $_POST['ProductoUnidadMedidaIngreso'];
$POST_ProductoUnidadMedidaBase = $_POST['ProductoUnidadMedidaBase'];


$POST_ProductoTipo = $_POST['ProductoTipo'];

$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,2,$POST_ProductoTipo);
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
$ProductoTipoUnidadMedidasTotal = $ResProductoTipoUnidadMedida['Total'];

//deb($ArrProductoTipoUnidadMedidas);
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
		foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUnidadMedida){
		?>
      
			<?php
            $UnidadMedidaEquivalente = 0;
			
			//if($POST_ProductoUnidadMedidaIngreso == $DatProductoTipoUnidadMedida->UmeId){
			if($POST_ProductoUnidadMedidaBase == $DatProductoTipoUnidadMedida->UmeId){
                $UnidadMedidaEquivalente = 1;
            }else{
                $RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$DatProductoTipoUnidadMedida->UmeId,$POST_ProductoUnidadMedidaBase);
				
				//deb($DatProductoTipoUnidadMedida->UmeId." - ".$POST_ProductoUnidadMedidaBase);
				
                $ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
                
                foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
                    $UnidadMedidaEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
                }
            }
            
            ?>
        
			<?php
            if(!empty($UnidadMedidaEquivalente)){
			?>
				- <?php echo $DatProductoTipoUnidadMedida->UmeNombre?> [<?php echo $DatProductoTipoUnidadMedida->UmeAbreviacion?>]<br />
			<?php
			}
			?>
            
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
