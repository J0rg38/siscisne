<?php
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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');


$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsComprobanteRetencion->CrnId = $GET_id;
$InsComprobanteRetencion->CrtId = $GET_ta;
$InsComprobanteRetencion = $InsComprobanteRetencion->MtdObtenerComprobanteRetencion();


if(file_exists("ImpComprobanteRetencionImprimir".$InsComprobanteRetencion->CrtNumero.".php")){
	
	include("ImpComprobanteRetencionImprimir".$InsComprobanteRetencion->CrtNumero.".php");
		
}else{
	
	$InsComprobanteRetencionTalonario = new ClsComprobanteRetencionTalonario();
	$InsComprobanteRetencionTalonario->CrtId = $InsComprobanteRetencion->CrtId;
	$InsComprobanteRetencionTalonario->MtdObtenerComprobanteRetencionTalonario();		
	
	if(substr($InsComprobanteRetencionTalonario->CrtNumero,0,1)=="R"){
		
		header("Location: FrmComprobanteRetencionGenerarPDF.php?Id=".$InsComprobanteRetencion->CrnId."&Ta=".$InsComprobanteRetencion->CrtId."&ImprimirCodigo=1");
		die();
/*?>

	<script type="text/javascript">
    
    $(function(){
    
    setTimeout(function(){ window.location = "<?php echo $oUrl;?>"; },<?php echo $oTiempo;?>);
    
    //$(location).attr('href','<?php echo $oUrl;?>'); 
    });
    
    
    </script>
            
<?php */
	}else{
		echo "No se encontro formato para esta serie";		
	}

}
?>