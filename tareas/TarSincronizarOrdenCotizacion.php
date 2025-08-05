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

$client = new nusoap_client('http://50.62.8.123/ventas/webservice/WsOrdenCotizacion.php?wsdl','wsdl');

$err = $client->getError();

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacionDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//$TotalProductos = count($ArrOrdenCotizacions);

$param = array(
'oEstado' => "1",
'oOrden' => "OotTiempoCreacion",
'oSentido' => "DESC",
'oPaginacion' => "10"
);
    
$ResOrdenCotizaciones = $client->call('MtdObtenerOrdenCotizaciones', $param);
$ArrOrdenCotizaciones = json_decode($ResOrdenCotizaciones);
			
$fila = 1;
if(!empty($ArrOrdenCotizaciones)){
	foreach($ArrOrdenCotizaciones as $DatOrdenCotizacion){
		
		$Respuesta = "[Fila".$fila."]>";
		echo "<br>";
		
		echo "Cotizacion :";
		echo $DatOrdenCotizacion->OotId;
		echo "<br>";
		
		echo "Codigo :";
		echo $DatOrdenCotizacion->ProCodigoOriginal;
		echo "<br>";
		
		echo "Acciones: ";
		echo "<br>";
		
		if(!empty($DatOrdenCotizacion->ProCodigoOriginal)){
			
			$InsOrdenCotizacion = new ClsOrdenCotizacion();
			$InsOrdenCotizacion->OotEstado = 1;
			$InsOrdenCotizacion->OotOrigen = "OOT";
			$InsOrdenCotizacion->MonId = "MON-10001";
			$InsOrdenCotizacion->OotFecha = date("d/m/Y");
			$InsOrdenCotizacion->OotHora = date("H:i:s");
			$InsOrdenCotizacion->OotPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
			list($InsOrdenCotizacion->OotAno,$Mes,$Dia) = explode("-",$InsOrdenCotizacion->OotFecha);
		$InsOrdenCotizacion->OotIncluyeImpuesto = 0;	
		
			$InsProveedor = new ClsProveedor();
			$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC","1","1","CYC");
			$ArrProveedores = $ResProveedor['Datos'];
		
			if(!empty($ArrProveedores)){
				foreach($ArrProveedores as $DatProveedor){
				
					$InsOrdenCotizacion->PrvId = $DatProveedor->PrvId;
					$InsOrdenCotizacion->PrvNombreCompleto = $DatProveedor->PrvNombreCompleto;
					$InsOrdenCotizacion->PrvNombre = $DatProveedor->PrvNombre;
					$InsOrdenCotizacion->PrvApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
					$InsOrdenCotizacion->PrvApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
					$InsOrdenCotizacion->PrvNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
					$InsOrdenCotizacion->TdoId = $DatProveedor->TdoId;
				}
			}
		
			$InsTipoCambio = new ClsTipoCambio();
			$InsTipoCambio->MonId = "MON-10001";
			$InsTipoCambio->TcaFecha = date("Y-m-d");
			
			$InsTipoCambio->MtdObtenerTipoCambioActual();
			
			if(empty($InsTipoCambio->TcaId)){
				$InsTipoCambio->MtdObtenerTipoCambioUltimo();
			}
				
			$InsOrdenCotizacion->OotTipoCambio = $InsTipoCambio->TcaMontoCompra;
			
			$InsOrdenCotizacion->OotObservacion = "Orden de cotizacion autogenerado ".date("d/m/Y H:i:s");
			$InsOrdenCotizacion->OotTiempoCreacion = date("Y-m-d H:i:s");
			$InsOrdenCotizacion->OotTiempoModificacion = date("Y-m-d H:i:s");
					
			$InsOrdenCotizacion->OotSubTotal = 0;
			$InsOrdenCotizacion->OotImpuesto = 0;
			$InsOrdenCotizacion->OotTotal = 0;
				
				
				$ProductoId = "";
				$InsProducto = new ClsProducto();
				$ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$DatOrdenCotizacion->ProCodigoOriginal);
					
				if(empty($ProductoId)){	
						
					$InsProducto = new ClsProducto();
					$InsProducto->UsuId = NULL;
					$InsProducto->ProCodigoAlternativo = "";
					$InsProducto->ProCodigoOriginal = $DatOrdenCotizacion->ProCodigoOriginal;
					$InsProducto->ProNombre = $DatOrdenCotizacion->ProNombre;
					$InsProducto->ProUbicacion = "-";
					$InsProducto->ProReferencia = "Producto registrado automaticamente por orden de cotizacion ".date("d/m/Y");
					$InsProducto->ProEspecificacion = "";
					
					$InsProducto->UmeId = "UME-10007";
					$InsProducto->UmeIdIngreso = "UME-10007";
					
					$InsProducto->ProCodigoBarra = $DatOrdenCotizacion->ProCodigoOriginal;
					$InsProducto->ProStockMinimo = 1;
					$InsProducto->ProValidarUso = 1;
					
					$InsProducto->ProPeso = 0;
					$InsProducto->ProLargo= 0;
					$InsProducto->ProAncho = 0;
					$InsProducto->ProAlto = 0;
					$InsProducto->ProVolumen = 0;
					
					$InsProducto->RtiId = "RTI-10000";	
					$InsProducto->ProFoto = "";
					$InsProducto->ProValidarStock = 1;	
					$InsProducto->ProTienePromocion = 2;	
					$InsProducto->ProCalcularPrecio = 2;	
					
							$InsProducto->ProCritico = 2;		
		$InsProducto->ProDescontinuado = 2;
					$InsProducto->ProEstado = 1;	
					$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
					$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
					$InsProducto->ProEliminado = 1;
					
					if($InsProducto->MtdRegistrarProducto()){
						$ProductoId = $InsProducto->ProId;
					}else{
						$ProductoId = "";
					}
									  
				}

			$InsOrdenCotizacionDetalle1 = new ClsOrdenCotizacionDetalle();
			$InsOrdenCotizacionDetalle1->ProId = $ProductoId;
			$InsOrdenCotizacionDetalle1->UmeId = "UME-10007";						
			$InsOrdenCotizacionDetalle1->OodAno =  $DatOrdenCotizacion->OotAno;
			$InsOrdenCotizacionDetalle1->OodModelo =  $DatOrdenCotizacion->OotModelo;
			$InsOrdenCotizacionDetalle1->OodPrecio = 0;		
			
			$InsOrdenCotizacionDetalle1->OodEstado = 1;
			$InsOrdenCotizacionDetalle1->OodTiempoCreacion = date("d/m/Y H:i:s");
			$InsOrdenCotizacionDetalle1->OodTiempoModificacion =  date("d/m/Y H:i:s");

			$InsOrdenCotizacionDetalle1->OodEliminado = 1;				
			$InsOrdenCotizacionDetalle1->InsMysql = NULL;

			$InsOrdenCotizacion->OrdenCotizacionDetalle[] = $InsOrdenCotizacionDetalle1;	
			
			if($InsOrdenCotizacion->MtdRegistrarOrdenCotizacion()){
				echo "Orden registrada localmente";	
				echo "<br>";
			}else{
				echo "No se pudo registrar localmente";
				echo "<br>";
			}		
			
				
			$param = array(
			'oOrdenCotizacionId' => $DatOrdenCotizacion->OotId,
			'oEstado' => 2
			);
    
            $Respuesta = $client->call('MtdActualizarOrdenCotizacionEstado', $param);
    
            switch($Respuesta){
                
                case "1":
        			echo "Registro actualizado remotamente";
					echo "<br>";
                break;
				
				case "2":
				echo "Registro no pudo ser actualizado remotamente";
					echo "<br>";
				break;
              
                default:
          
                break;
            }
    
	
		}else{
			echo "Codigo original no encontrado";
			echo "<br>";
		}
		
		

		$fila++;
		echo "<br>";
	}
}else{
	echo "No se encontraron ordenes";
	echo "<br>";
}

echo "------------------------------------------";
echo "<br>";
echo "Total de Productos: ";
echo $TotalProductos;
echo "<br>";
echo "------------------------------------------";
echo "<br>";
echo "Proceso Terminado: ";
echo date("d/m/Y H:i:s");
echo "<br>";

?>
