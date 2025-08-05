<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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


//require_once('../librerias/nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
//require_once('../librerias/JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$client = new nusoap_client('http://50.62.8.123/ventas/webservice/WsProducto.php?wsdl','wsdl');

$err = $client->getError();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>

<body>
<?php

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL) {
$InsProducto = new ClsProducto();
$ResProducto = $InsProducto->MtdObtenerProductos("","","","ProCodigoOriginal","DESC","","1","RTI-10000",1,NULL,NULL,NULL,NULL,false,"SAIL");
$ArrProductos = $ResProducto['Datos'];

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

?>

<?php
$TotalProductos = count($ArrProductos);

$fila = 1;
if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
		
		$Respuesta = "";
?>

        [Fila <?php echo $fila;?>]>
        Codigo : <?php	echo $DatProducto->ProCodigoOriginal;?><br />
        <?php
        if(!empty($DatProducto->ProCodigoOriginal)){
    
            $param = array(
            'oCodigoOriginal' => $DatProducto->ProCodigoOriginal,
            'oStock' => $DatProducto->ProStockReal
          );
    
            $Respuesta = $client->call('MtdActualizarProductoStock', $param);
    
            switch($Respuesta){
                
                case "1":
            ?>
                 Se actualizo el stock correctamente.<br />
            <?php	
                break;
                
                case "2":
            ?>
                    No se pudo actualizar el stock. <br />
            <?php	
                break;
                
                case "3":
            ?>
                    El codigo no existe en servidor remoto.<br />
            <?php	
                break;
                
				case "4":
            ?>
                   Codigo llego vacio a remoto <br />
            <?php	
                break;
				
                case "":
            ?>		No se ha realizado ninguna accion.<br />
            <?php
                break;
                
                default:
            ?>
                    Ha ocurrido un error interno<br />
            <?php	
                break;
            }
        }else{
        ?>
            Codigo original vacio <br />
        <?php	
        }
        ?>
    
<br />
    
<?php	
$fila++;
	}
}else{
?>
	No se encontraron ordenes<br />
<?php	
}
?>
------------------------------------------<br />
Total de Productos: <?php echo $TotalProductos;?><br />
------------------------------------------<br />
Proceso Terminado<br />
<?php echo date("d/m/Y H:i:s")?><br />
------------------------------------------<br />


</body>
</html>