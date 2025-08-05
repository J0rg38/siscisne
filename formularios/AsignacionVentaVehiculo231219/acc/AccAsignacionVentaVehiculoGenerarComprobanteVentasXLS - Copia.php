<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"COMPROBANTE_VENTAS_VEHICULOS_".date('d-m-Y').".xls\";");
}

$POST_FechaInicio = empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio'];
$POST_FechaFin = empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin'];

$POST_Sucursal = (($_GET['Sucursal']));
$POST_C = (($_GET['C']));
//Sdeb($POST_C);
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqReporte().'ClsReporteComprobanteVenta.php');

$InsFactura = new ClsFactura();
$InsBoleta = new ClsBoleta();
$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
$InsReporteComprobanteVenta = new ClsReporteComprobanteVenta();

//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oSucursal=NULL,$oTipoFecha="avv.AvvFecha")
$ResAsignacionVentaVehiculo = $InsReporteComprobanteVenta->MtdObtenerAsignacionVentaVehiculos(NULL,NULL,NULL,"RcvSerie ASC, RcvFecha ASC","",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,false,NULL,"Comprobante");
$ArrAsignacionVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>COMPROBANTES DE VENTA DE VEHICULOS</title>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssAsignacionVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAsignacionVentaVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	

	
});
</script>

<?php
}
?>
</head>
<body>


<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >SERIE</th>
                <th width="3%" >CORRELATIVO</th>
                <th width="3%" >FECHA FACTURACION</th>
                <th width="4%" >OBS.</th>
                <th width="4%" >NUM. DOC.</th>
                <th width="4%" >CLIENTE</th>
                <th width="4%" >VIN</th>
                <th width="19%" >MARCA</th>
                <th width="4%" >MODELO</th>
                <th width="4%" >VERSION</th>
                <th width="5%" >COLOR</th>
                <th width="5%" >MOTOR</th>
                <th width="5%" >AÑO FAB.</th>
                <th width="5%" >AÑO MOD.</th>
                <th width="6%" >MONEDA</th>
                <th width="7%" >TOTAL</th>
                <th width="8%" >ASESOR DE VENTAS</th>
                <th width="8%" >SUCURSAL</th>
                <th width="8%" >FECHA PEDIDO</th>
                <th width="8%" >FECHA ENVIO</th>
                <th width="8%" >NC</th>
                <th width="8%" >NC MOTIVO</th>
                <th width="8%" >ID</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
<?php

	$pagina = explode(",",$POST_pag);
	$f=$pagina[0]+1;

	foreach($ArrAsignacionVentaVehiculos as $dat){


			$ComprobanteSerie = "";
			$ComprobanteCorrelativo = "";
			$ComprobanteFecha = "";
			$ComprobanteMoneda = "";
			$ComprobanteTotal = 0;
			$ComprobanteObservado = 0;
			
			if(!empty($dat->BolId) and !empty($dat->BtaId)){
		
				$InsBoleta = new ClsBoleta();
				$InsBoleta->BolId = $dat->BolId;
				$InsBoleta->BtaId = $dat->BtaId;
				$InsBoleta = $InsBoleta->MtdObtenerBoleta();
				$InsBoleta->BolTotal = (($InsBoleta->BolTotal/(empty($InsBoleta->BolTipoCambio)?1:$InsBoleta->BolTipoCambio)));
				
				
				$ComprobanteSerie = $InsBoleta->BtaNumero;
				$ComprobanteCorrelativo =  $InsBoleta->BolId;
				$ComprobanteFecha = $InsBoleta->BolFechaEmision;
				$ComprobanteMoneda = $InsBoleta->MonSimbolo;
				$ComprobanteTotal = $InsBoleta->BolTotal;
				$ComprobanteObservado = $InsBoleta->BolObservado;
				
			}else{
				
				if(!empty($dat->FacId) and !empty($dat->FtaId)){
			
					$InsFactura = new ClsFactura();
					$InsFactura->FacId = $dat->FacId;
					$InsFactura->FtaId = $dat->FtaId;
					$InsFactura = $InsFactura->MtdObtenerFactura();
					$InsFactura->FacTotal = (($InsFactura->FacTotal/(empty($InsFactura->FacTipoCambio)?1:$InsFactura->FacTipoCambio)));
				
					$ComprobanteSerie = $InsFactura->FtaNumero;
					$ComprobanteCorrelativo =  $InsFactura->FacId;
					$ComprobanteFecha = $InsFactura->FacFechaEmision;
					$ComprobanteMoneda = $InsFactura->MonSimbolo;
					$ComprobanteTotal = $InsFactura->FacTotal;
					$ComprobanteObservado = $InsFactura->FacObservado;
					
				}
			
			}
			
			
			
			if(!empty($dat->NcrId) and !empty($dat->NctId)){
		
				$InsNotaCredito = new ClsNotaCredito();
				$InsNotaCredito->NcrId = $dat->NcrId;
				$InsNotaCredito->NctId = $dat->NctId;
				$InsNotaCredito = $InsNotaCredito->MtdObtenerNotaCredito();
				$InsNotaCredito->NcrTotal = (($InsNotaCredito->NcrTotal/(empty($InsNotaCredito->NcrTipoCambio)?1:$InsNotaCredito->NcrTipoCambio)));
			
				$ComprobanteNotaCreditoSerie = $InsNotaCredito->NctNumero;
				$ComprobanteNotaCreditoCorrelativo =  $InsNotaCredito->NcrId;
				$ComprobanteNotaCreditoMotivo =  $InsNotaCredito->NcrMotivo;
				
			}
			
			
			
		//if($dat->AvvCancelado == "Si" || $dat->AvvCancelado2 == "Si"|| $POST_C == "1"){
		if($dat->AvvCancelado == "Si" || $POST_C == "1"){
			
		
			if(!empty($ComprobanteTotal)){
				
			
		?>
        <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   >
                  
                 
                  <?php echo $ComprobanteSerie;  ?>
               
                </td>
                <td  width="3%" align="right" >  <?php echo $ComprobanteCorrelativo;  ?></td>
                <td  width="3%" align="right" ><?php echo $ComprobanteFecha;  ?></td>
                <td  width="4%" align="right" >
				
				
			<?php
			if($ComprobanteObservado==1){
			?>
            Si
            <?php	
			}else if($ComprobanteObservado==2){
			?>
            No
            <?php	
			}else{
			?>
            -
            <?php	
			}
			?>
                
                
                </td>
                <td  width="4%" align="right" ><?php echo $dat->CliNumeroDocumento;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliNombre;  ?> <?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->EinVIN;  ?></td>
                <td  width="19%" align="left" ><?php echo $dat->VmaNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->VmoNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->EinColor);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->EinNumeroMotor);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->EinAnoFabricacion);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->EinAnoModelo);?></td>
                <td  width="6%" align="right" > <?php echo ($ComprobanteMoneda);?></td>
                <td  width="7%" align="right" >
				
				
				
                  <?php echo number_format($ComprobanteTotal,2);?></td>
                <td  width="8%" align="right" ><?php echo $dat->PerNombreVendedor;?> <?php echo $dat->PerApellidoPaternoVendedor;?> <?php echo $dat->PerApellidoMaternoVendedor;?></td>
                <td  width="8%" align="right" ><?php echo $dat->SucNombre;  ?></td>
                <td  width="8%" align="right" ><?php echo $dat->OvvFecha;  ?></td>
                <td  width="8%" align="right" ><?php echo $dat->OvvTiempoSolicitudEnvio;  ?></td>
                <td  width="8%" align="right" >
                
                <?php echo $ComprobanteNotaCreditoSerie;  ?>-<?php echo $ComprobanteNotaCreditoCorrelativo;  ?>
              
                </td>
                <td  width="8%" align="right" >
                
                 <?php echo $ComprobanteNotaCreditoMotivo;  ?>
                
                
              </td>
                <td  width="8%" align="right" ><?php echo $dat->OvvId;  ?></td>
    </tr>
        <?php
		$f++;
			
			}
			
		}



								?>

           

              

              <?php		

									
								
									

									}
									

									?>
            </tbody>
      </table>
 
</body>
</html>