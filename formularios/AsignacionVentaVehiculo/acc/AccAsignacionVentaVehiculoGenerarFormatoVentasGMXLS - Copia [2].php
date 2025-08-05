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
	header("Content-Disposition:  filename=\"FORMATO_VENTAS_GM_".date('d-m-Y').".xls\";");
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





$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,$POST_ord,$POST_sen,(($GET_F=="1")?"":$POST_pag),NULL,5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$POST_Cancelado);
$ArrFacturas = $ResFactura['Datos'];


$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,$POST_ord,$POST_sen,(($GET_F=="1")?"":$POST_pag),5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$POST_Cancelado);
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
                <th width="2%" >FECHA FACT.</th>
                <th width="2%" >B/F</th>
                <th width="4%" >LOCAL</th>
                <th width="4%" >MARCA</th>
                <th width="4%" >MODELO</th>
                <th width="4%" >VIN</th>
                <th width="4%" >COLOR</th>
                <th width="4%" >FAB</th>
                <th width="4%" >MOD</th>
                <th width="4%" >PRECIO. V</th>
                <th width="4%" >ASESOR</th>
                <th width="4%" >NOMBRE CLIENTE</th>
                <th width="4%" >APELLIDOS CLIENTE</th>
                <th width="4%" >DNI/RUC</th>
                <th width="4%" >TELEFONO</th>
                <th width="4%" >EMAIL</th>
                <th width="4%" >DIRECCION</th>
                <th width="4%" >CIUDAD</th>
                <th width="4%" >DISTRITO</th>
                <th width="4%" >DEPARTAMENTO</th>
                <th width="4%" >OBS.</th>
                <th width="4%" >NOTA CREDITO</th>
                <th width="4%" >MOTIVO</th>
                <th width="4%" >TOTAL</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
				
								foreach($ArrAsignacionVentaVehiculos as $dat){



$dat->RcvNotaCreditoTotal = (($dat->RcvNotaCreditoTotal/(empty($dat->RcvNotaCreditoTipoCambio)?1:$dat->RcvNotaCreditoTotal)));
				


			$ComprobanteSerie = "";
			$ComprobanteCorrelativo = "";
			$ComprobanteFecha = "";
			$ComprobanteMoneda = "";
			$ComprobanteTotal = 0;
			$ComprobanteObservado = 0;
			
			if(!empty($dat->BolIdS) and !empty($dat->BtaIdS)){
		
				$InsBoleta = new ClsBoleta();
				$InsBoleta->BolId = $dat->BolIdS;
				$InsBoleta->BtaId = $dat->BtaIdS;
				$InsBoleta = $InsBoleta->MtdObtenerBoleta();
				$InsBoleta->BolTotal = (($InsBoleta->BolTotal/(empty($InsBoleta->BolTipoCambio)?1:$InsBoleta->BolTipoCambio)));
				
				
				$ComprobanteSerie = $InsBoleta->BtaNumero;
				$ComprobanteCorrelativo =  $InsBoleta->BolId;
				$ComprobanteFecha = $InsBoleta->BolFechaEmision;
				$ComprobanteMoneda = $InsBoleta->MonSimbolo;
				$ComprobanteTotal = $InsBoleta->BolTotal;
				$ComprobanteObservado = $InsBoleta->BolObservado;
				
				//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL,$oNoProcesdado=false)
				$InsNotaCredito = new ClsNotaCredito();
				$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,'NcrFechaEmision','Desc',1,'1',NULL,"1,5",NULL,NULL,NULL,NULL,$InsBoleta->BolId,$InsBoleta->BtaId,NULL,NULL,false);
				$ArrNotaCreditos = $ResNotaCredito['Datos'];
				
				$NotaCreditoSerie = "";
				$NotaCreditoCorrelativo = "";
				$NotaCreditoMotivo = "";
				$NotaCreditoTotal = 0;
				
				if(!empty($ArrNotaCreditos)){
					foreach($ArrNotaCreditos as $DatNotaCredito){
						
						
						$DatNotaCredito->NcrTotal = (($DatNotaCredito->NcrTotal/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio)));
				
						$NotaCreditoSerie = $DatNotaCredito->NctNumero;
						$NotaCreditoCorrelativo = $DatNotaCredito->NcrId;
						$NotaCreditoMotivo = $DatNotaCredito->NcrMotivo;
						$NotaCreditoTotal = $DatNotaCredito->NcrTotal;
						
					}
				}
				
			}else{
				
				if(!empty($dat->FacIdS) and !empty($dat->FtaIdS)){
			
					$InsFactura = new ClsFactura();
					$InsFactura->FacId = $dat->FacIdS;
					$InsFactura->FtaId = $dat->FtaIdS;
					$InsFactura = $InsFactura->MtdObtenerFactura();
					$InsFactura->FacTotal = (($InsFactura->FacTotal/(empty($InsFactura->FacTipoCambio)?1:$InsFactura->FacTipoCambio)));
				
					$ComprobanteSerie = $InsFactura->FtaNumero;
					$ComprobanteCorrelativo =  $InsFactura->FacId;
					$ComprobanteFecha = $InsFactura->FacFechaEmision;
					$ComprobanteMoneda = $InsFactura->MonSimbolo;
					$ComprobanteTotal = $InsFactura->FacTotal;
					$ComprobanteObservado = $InsFactura->FacObservado;
					
					
					//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL,$oNoProcesdado=false)
					$InsNotaCredito = new ClsNotaCredito();
					$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,'NcrFechaEmision','Desc',1,'1',NULL,"1,5",NULL,NULL,NULL,NULL,$InsFactura->FacId,$InsFactura->FtaId,NULL,NULL,false);
					$ArrNotaCreditos = $ResNotaCredito['Datos'];
					
					$NotaCreditoSerie = "";
					$NotaCreditoCorrelativo = "";
					$NotaCreditoMotivo = "";
					$NotaCreditoTotal = 0;
					
					if(!empty($ArrNotaCreditos)){
						foreach($ArrNotaCreditos as $DatNotaCredito){
							
							
							$DatNotaCredito->NcrTotal = (($DatNotaCredito->NcrTotal/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio)));
					
							$NotaCreditoSerie = $DatNotaCredito->NctNumero;
							$NotaCreditoCorrelativo = $DatNotaCredito->NcrId;
							$NotaCreditoMotivo = $DatNotaCredito->NcrMotivo;
							$NotaCreditoTotal = $DatNotaCredito->NcrTotal;
							
						}
					}
					
					
					
				}
			
			}
			

		//if($dat->AvvCancelado == "Si" || $dat->AvvCancelado2 == "Si"|| $POST_C == "1"){
		//if($dat->AvvCancelado == "Si" || $POST_C == "1"){
		
			
		
			//if(!empty($ComprobanteTotal)){
				
			
			
		?>
        <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   ><?php echo $ComprobanteFecha;  ?></td>
                <td align="right" valign="middle" width="2%"   ><?php echo $ComprobanteSerie;  ?>-<?php echo $ComprobanteCorrelativo;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->SucNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->VmaNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->VmoNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->EinVIN;  ?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinColor);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinAnoFabricacion);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinAnoModelo);?></td>
                <td  width="4%" align="right" ><?php echo round($ComprobanteTotal,2);?></td>
                <td  width="4%" align="right" ><?php echo $dat->PerNombreVendedor;?> <?php echo $dat->PerApellidoPaternoVendedor;?> <?php echo $dat->PerApellidoMaternoVendedor;?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliNumeroDocumento;  ?></td>
                <td  width="4%" align="right" >
				
                <?php
				if(!empty( $dat->CliCelular)){
				?>
                <?php echo  $dat->CliCelular;?>
                <?php
				}
				?>
                
                
                <?php
				if(!empty( $dat->CliTelefono)){
				?>
					<?php echo  $dat->CliTelefono;?>
                <?php
				}
				?>
             
                </td>
                <td  width="4%" align="right" ><?php echo $dat->CliEmail;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliDireccion;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliProvincia;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliDistrito;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliDepartamento;  ?></td>
                <td  width="4%" align="right" ><?php
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
			?></td>
                <td  width="4%" align="right" ><?php echo $NotaCreditoSerie;  ?>-<?php echo $NotaCreditoCorrelativo;  ?></td>
                <td  width="4%" align="right" ><?php echo $NotaCreditoMotivo;  ?></td>
                <td  width="4%" align="right" ><?php echo number_format($NotaCreditoTotal,2);;  ?></td>
    </tr>
        <?php
		$f++;
			
			//}
			
		//}



								?>

           

              

              <?php		

									
								
									

									}
									

									?>
            </tbody>
      </table>
 
</body>
</html>