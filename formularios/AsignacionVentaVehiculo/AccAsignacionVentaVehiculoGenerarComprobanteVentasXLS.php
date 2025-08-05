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

//$POST_Sucursal = (($_GET['Sucursal']));
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

////MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oSucursal=NULL,$oTipoFecha="avv.AvvFecha")
//$ResAsignacionVentaVehiculo = $InsReporteComprobanteVenta->MtdObtenerAsignacionVentaVehiculos(NULL,NULL,NULL,"RcvSerie ASC, RcvFecha ASC","",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,false,NULL,"Comprobante");
//$ArrAsignacionVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];

$Cancelado = "";

//TODOS
if($POST_C == 1){

	$Cancelado = "";
	
//SOLO CANCELADOS
}else if($POST_C == 2){
	
	$Cancelado = "Si";
	
}


//MtdObtenerFacturaVentaVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL)
$ResFactura = $InsReporteComprobanteVenta->MtdObtenerFacturaVentaVehiculos(NULL,NULL,NULL,"FtaNumero ASC, FacFechaEmision ASC","","3500",NULL,5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$Cancelado);
$ArrFacturas = $ResFactura['Datos'];


//MtdObtenerBoletaVentaVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
$ResBoleta = $InsReporteComprobanteVenta->MtdObtenerBoletaVentaVehiculos(NULL,NULL,NULL,"BtaNumero ASC, BolFechaEmision ASC","","3500",5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$Cancelado);
$ArrBoletas = $ResBoleta['Datos'];

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
                <th width="5%" >AÑO MOD.</th>
                <th width="6%" >CANCELADO</th>
                <th width="6%" >MONEDA</th>
                <th width="7%" >TOTAL</th>
                <th width="8%" >ASESOR DE VENTAS</th>
                <th width="8%" >SUCURSAL</th>
                <th width="8%" >FECHA PEDIDO</th>
                <th width="8%" >FECHA ENVIO</th>
                <th width="8%" >NC</th>
                <th width="8%" >NC MOTIVO</th>
                <th width="8%" >TOTAL</th>
                <th width="8%" >ANULADO</th>
                <th width="8%" >ID</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
<?php

	$f = 1;
	foreach($ArrFacturas as $DatFactura){

			
		?>     
        
           <?php $DatFactura->FacTotal = (($DatFactura->FacTotal/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio)));?>
          <?php $DatFactura->NcrTotal = (($DatFactura->NcrTotal/(empty($DatFactura->NcrTipoCambio)?1:$DatFactura->NcrTipoCambio)));?>
         
         <?php
		 $Anulado = "";
		 
		 if($DatFactura->FacTotal <= $DatFactura->NcrTotal and $DatFactura->NcrTotal >0){
			 		 $Anulado = "Si";
		 }else{
			 		 $Anulado = "No"; 
		 }
		 ?>
<tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   ><?php echo $DatFactura->FtaNumero;  ?></td>
                <td  width="3%" align="right" ><?php echo $DatFactura->FacId;  ?></td>
                <td  width="3%" align="right" ><?php echo $DatFactura->FacFechaEmision;  ?></td>
                <td  width="4%" align="right" ><?php
			if($DatFactura->FacObservado==1){
			?>
Si
  <?php	
			}else if($DatFactura->FacObservado==2){
			?>
No
<?php	
			}else{
			?>
-
<?php	
			}
			?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliNumeroDocumento;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliNombre;  ?><?php echo $DatFactura->CliApellidoPaterno;  ?> <?php echo $DatFactura->CliApellidoMaterno;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->FacDatoAdicional13;  ?></td>
                <td  width="19%" align="left" ><?php echo $DatFactura->FacDatoAdicional1;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->FacDatoAdicional3;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->VveNombre;  ?></td>
                <td  width="5%" align="right" ><?php echo ($DatFactura->FacDatoAdicional15);?></td>
                <td  width="5%" align="right" ><?php echo ($DatFactura->FacDatoAdicional7);?></td>
                <td  width="5%" align="right" ><?php echo ($DatFactura->FacDatoAdicional27);?></td>
                <td  width="6%" align="right" ><?php
			if($DatFactura->FacCancelado==1){
			?>
Si
  <?php	
			}else if($DatFactura->FacCancelado==2){
			?>
No
<?php	
			}else{
			?>
-
<?php	
			}
			?></td>
                <td  width="6%" align="right" > <?php echo ($DatFactura->MonNombre);?></td>
                <td  width="7%" align="right" >
				
				
				
                  <?php echo number_format($DatFactura->FacTotal,2);?></td>
                <td  width="8%" align="right" ><?php echo $DatFactura->FacAsesorVenta;?></td>
                <td  width="8%" align="right" ><?php echo $DatFactura->SucNombre;  ?></td>
                <td  width="8%" align="right" ><?php echo $DatFactura->OvvFecha;  ?></td>
                <td  width="8%" align="right" ><?php echo $DatFactura->OvvTiempoSolicitudEnvio;  ?></td>
                <td  width="8%" align="right" ><?php echo $DatFactura->NctNumero;  ?>-<?php echo  $DatFactura->NcrId;  ?></td>
                <td  width="8%" align="right" ><?php echo  $DatFactura->NcrMotivo;  ?></td>
                <td  width="8%" align="right" ><?php echo  $DatFactura->NcrTotal;  ?></td>
                <td  width="8%" align="right" >
                
                <?php echo  $Anulado;  ?>
                
                </td>
                <td  width="8%" align="right" ><?php echo $DatFactura->OvvId;  ?></td>
    </tr>
        <?php
		$f++;
			
	}
									
	foreach($ArrBoletas as $DatBoleta){

			
		?>
        
 
           <?php $DatBoleta->BolTotal = (($DatBoleta->BolTotal/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio)));?>
          <?php $DatBoleta->NcrTotal = (($DatBoleta->NcrTotal/(empty($DatBoleta->NcrTipoCambio)?1:$DatBoleta->NcrTipoCambio)));?>
         
         
         
         <?php
		 $Anulado = "";
		 
		 if($DatBoleta->BolTotal <= $DatBoleta->NcrTotal and $DatBoleta->NcrTotal>0){
			 		 $Anulado = "Si";
		 }else{
			 		 $Anulado = "No"; 
		 }
		 ?>
         
         
        <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $DatBoleta->BtaNumero;  ?></td>
                <td align="right" ><?php echo $DatBoleta->BolId;  ?></td>
                <td align="right" ><?php echo $DatBoleta->BolFechaEmision;  ?></td>
                <td align="right" ><?php
			if($DatBoleta->BolObservado==1){
			?>
                  Si
                  <?php	
			}else if($DatBoleta->BolObservado==2){
			?>
                  No
  <?php	
			}else{
			?>
                  -
  <?php	
			}
			?></td>
                <td align="right" ><?php echo $DatBoleta->CliNumeroDocumento;  ?></td>
                <td align="right" ><?php echo $DatBoleta->CliNombre;  ?><?php echo $DatBoleta->CliApellidoPaterno;  ?> <?php echo $DatBoleta->CliApellidoMaterno;  ?></td>
                <td align="right" ><?php echo $DatBoleta->BolDatoAdicional13;  ?></td>
                <td align="left" ><?php echo $DatBoleta->BolDatoAdicional1;  ?></td>
                <td align="right" ><?php echo $DatBoleta->BolDatoAdicional3;  ?></td>
                <td align="right" ><?php echo $DatBoleta->VveNombre;  ?></td>
                <td align="right" ><?php echo ($DatBoleta->BolDatoAdicional15);?></td>
                <td align="right" ><?php echo ($DatBoleta->BolDatoAdicional7);?></td>
                <td align="right" ><?php echo ($DatBoleta->BolDatoAdicional27);?></td>
                <td align="right" ><?php
			if($DatBoleta->BolCancelado==1){
			?>
                  Si
                  <?php	
			}else if($DatBoleta->BolCancelado==2){
			?>
                  No
  <?php	
			}else{
			?>
                  -
  <?php	
			}
			?></td>
                <td align="right" ><?php echo ($DatBoleta->MonNombre);?></td>
                <td align="right" ><?php echo number_format($DatBoleta->BolTotal,2);?></td>
                <td align="right" ><?php echo $DatBoleta->BolAsesorVenta;?></td>
                <td align="right" ><?php echo $DatBoleta->SucNombre;  ?></td>
                <td align="right" ><?php echo $DatBoleta->OvvFecha;  ?></td>
                <td align="right" ><?php echo $DatBoleta->OvvTiempoSolicitudEnvio;  ?></td>
                <td align="right" ><?php echo $DatBoleta->NctNumero;  ?>-<?php echo  $DatBoleta->NcrId;  ?></td>
                <td align="right" ><?php echo  $DatBoleta->NcrMotivo;  ?></td>
                <td align="right" ><?php echo  $DatBoleta->NcrTotal;  ?></td>


                <td align="right" ><?php echo  $Anulado;  ?></td>
                
                <td align="right" ><?php echo $DatBoleta->OvvId;  ?></td>
    </tr>
        <?php
		$f++;
			
	}
		
?>
            </tbody>
      </table>
 
</body>
</html>