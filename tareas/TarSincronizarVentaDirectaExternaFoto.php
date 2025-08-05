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


require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');

//50.62.8.12
$client = new nusoap_client('http://50.62.8.123/ventas/webservice/WsVentaDirecta.php?wsdl','wsdl');

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

$GET_Accion = $_GET['Accion'];

//$GET_GenerarPedidoCompra = (empty($_GET['GenerarPedidoCompra'])?1:2);
//$GET_GenerarOrdenCompra = (empty($_GET['GenerarOrdenCompra'])?1:2);
$GET_GenerarPedidoCompra = 2;
$GET_GenerarOrdenCompra = 2;

include($InsProyecto->MtdFormulariosMsj("VentaDirecta").'MsjVentaDirecta.php');
include($InsProyecto->MtdFormulariosMsj("Producto").'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqExterno().'ClsVentaDirectaExterno.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$FechaInicio = "01/01/".date("Y");
$FechaFin = date("d/m/Y");

$client = new nusoap_client('http://50.62.8.123/ventas/webservice/WsVentaDirecta.php?wsdl','wsdl');

$err = $client->getError();

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$InsVentaDirecta = new ClsVentaDirecta();
//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oFichaIngreso=NULL,$oTieneGenerarVentaConcretada=false,$oPersonal=NULL,$oConCodigoExterno=0) {

$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,"VdiFecha","DESC",NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,NULL,NULL,NULL,NULL,false,$POST_Personal,1);
$ArrVentaDirectas = $ResVentaDirecta['Datos'];

$TotalOrdenes = 0;
$TotalVentaDirectaFotoNoRegistradas = 0;
$TotalVentaDirectaFotoNuevas = 0;
$TotalVentaDirectaFotoRepetidas = 0;

$fila = 1;
if(!empty($ArrVentaDirectas)){
	foreach($ArrVentaDirectas as $DatVentaDirecta){
		
		echo "<br>";
		echo "<br>";
		
		echo "[Fila ".$fila."]>";		
		echo "Id: ".$DatVentaDirecta->VdiId."<br />";
		echo "Fecha: ".$DatVentaDirecta->VdiFecha."<br />";
		echo "Cliente: ".$DatVentaDirecta->CliNombre." ".$DatVentaDirecta->CliApellidoPaterno." ".$DatVentaDirecta->CliApellidoMaterno."<br />";
		echo "<br>";
		
			$param = array(	
				'oId' => $DatVentaDirecta->VdiCodigoExterno			
			);
			
			$VentaDirectaExterna = $client->call('MtdObtenerVentaDirecta', $param);
			
			$json = new Services_JSON();
			$VentaDirectaExterna = $json->decode($VentaDirectaExterna);
			
			echo "Foto: ".$VentaDirectaExterna->VdiArchivo."<br />";
			
			
			
			$VentaDirectaArchivo = "";
				
			if(!empty($VentaDirectaExterna->VdiArchivo)){
				
				//$Subido = file_put_contents("../subidos/venta_directa/".$DatVentaDirectaExterna->VdiArchivo, fopen("http://50.62.8.123/ventas/subidos/venta_directa_fotos/".$DatVentaDirectaExterna->VdiArchivo, 'r'));
				$ArchivoRemoto = file_url("http://50.62.8.123/ventas/subidos/venta_directa_fotos/".($VentaDirectaExterna->VdiArchivo));
				$ArchivoLocal = "../subidos/venta_directa/".str_replace(' ', '_', $VentaDirectaExterna->VdiArchivo);
				$ArchivoDescargado = file_get_contents($ArchivoRemoto);							
	
				$Subido = file_put_contents($ArchivoLocal, $ArchivoDescargado);
							
				if($Subido){
					$VentaDirectaArchivo = str_replace(' ', '_', $VentaDirectaExterna->VdiArchivo);
				}
				
			}
			
			if(!empty($VentaDirectaArchivo)){
				
				$InsVentaDirecta->MtdEditarVentaDirectaDato("VdiArchivo",$VentaDirectaArchivo,$DatVentaDirecta->VdiId);
				
			}
		
			
			
		if(!empty($DatVentaDirecta->VdiCodigoExterno)){
			
			echo "Fotos:<br />";
			
			$param = array(	
				'oId' => $DatVentaDirecta->VdiCodigoExterno			
			);
			
			$ArrVentaDirectaFotoExternas = $client->call('MtdObtenerVentaDirectaFotos', $param);
			
			$json = new Services_JSON();
			$ArrVentaDirectaFotoExternas = $json->decode($ArrVentaDirectaFotoExternas);
			
			
			
			if(!empty($ArrVentaDirectaFotoExternas)){
				foreach($ArrVentaDirectaFotoExternas as $DatVentaDirectaFotoExterna){
					
					echo "Foto Id Externo: ".$DatVentaDirectaFotoExterna->VdfId."<br />";
					echo "Foto Archivo Externo: ".$DatVentaDirectaFotoExterna->VdfArchivo."<br />";
					echo "<br>";
					
					$InsVentaDirectaFoto = new ClsVentaDirectaFoto();
					//MtdObtenerVentaDirectaFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {
					$ResVentaDirectaFoto = $InsVentaDirectaFoto->MtdObtenerVentaDirectaFotos("VdfCodigoExterno",$DatVentaDirectaFotoExterna->VdfId,"VdfId","ASC",NULL,$DatVentaDirecta->VdiId,3,NULL);
					$ArrVentaDirectaFotos = $ResVentaDirectaFoto['Datos'];
					
					if(empty($ArrVentaDirectaFotos)){

						$VentaDirectaFotoArchivo = "";
						
						if(!empty($DatVentaDirectaFotoExterna->VdfArchivo)){

							$ArchivoRemoto = file_url("http://50.62.8.123/ventas/subidos/venta_directa_fotos/".($DatVentaDirectaFotoExterna->VdfArchivo));
							$ArchivoLocal = "../subidos/venta_directa/".str_replace(' ', '_', $DatVentaDirectaFotoExterna->VdfArchivo);
							$ArchivoDescargado = file_get_contents($ArchivoRemoto);							

							$Subido = file_put_contents($ArchivoLocal, $ArchivoDescargado);

							//file_put_contents("../subidos/venta_directa/".$DatVentaDirectaExterna->VdiArchivo, fopen("http://50.62.8.123/ventas/subidos/venta_directa_fotos/".$DatVentaDirectaExterna->VdiArchivo, 'r'));
							if($Subido){
								//$VentaDirectaFotoArchivo = $DatVentaDirectaFotoExterna->VdfArchivo;

								$InsVentaDirectaFoto = new ClsVentaDirectaFoto();
								$InsVentaDirectaFoto->VdiId = $DatVentaDirecta->VdiId;
								$InsVentaDirectaFoto->VdfArchivo = str_replace(' ', '_', $DatVentaDirectaFotoExterna->VdfArchivo);
								$InsVentaDirectaFoto->VdfTipo = $DatVentaDirectaFotoExterna->VdfTipo;
								$InsVentaDirectaFoto->VdfEstado = $DatVentaDirectaFotoExterna->VdfEstado;
								$InsVentaDirectaFoto->VdfCodigoExterno = $DatVentaDirectaFotoExterna->VdfId;					
								$InsVentaDirectaFoto->VdfTiempoCreacion = date("Y-m-d H:i:s");
								$InsVentaDirectaFoto->VdfTiempoModificacion = date("Y-m-d H:i:s");

								if($InsVentaDirectaFoto->MtdRegistrarVentaDirectaFoto()){
									echo "Foto registrada correctamente<br />";
								}else{
									echo "Foto no se pudo a registrar<br />";
									$TotalVentaDirectaFotoNoRegistradas++;
								}

							}else{
								echo "Foto no se pudo descargar. PROCESO CANCELADO<br />";
							}
							
							$TotalVentaDirectaFotoNuevas++;
							
						}
						
					}else{
						$TotalVentaDirectaFotoRepetidas++;
						echo "Foto ya registrada<br />";
						
					}
					
				}
			}else{
				
				echo "No se encontraron fotos<br />";
				
			}
			
			
		}
		$fila++;
		$TotalOrdenes++;
	}
	

}else{
?>
No se encontraron ordenes<br />
<?php	
}
?>




------------------------------------------<br />
Ordenes de Venta: <?php echo $TotalOrdenes;?><br />
<br />
Fotos Nuevas: <?php echo $TotalVentaDirectaFotoNuevas;?><br />
Fotos Nuevas No Registradas: <?php echo $TotalVentaDirectaFotoNoRegistradas;?><br />
<br />
Fotos Repetidas: <?php echo $TotalVentaDirectaFotoRepetidas;?><br />
------------------------------------------<br />
Proceso Terminado<br />
<?php echo date("d/m/Y H:i:s")?><br />
------------------------------------------<br />


</body>
</html>