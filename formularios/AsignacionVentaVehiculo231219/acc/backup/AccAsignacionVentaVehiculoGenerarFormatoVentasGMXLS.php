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
//




$ResFactura = $InsReporteComprobanteVenta->MtdObtenerFacturaVentaVehiculos(NULL,NULL,NULL,"FtaNumero ASC, FacFechaEmision ASC","","500",NULL,5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$POST_Cancelado);
$ArrFacturas = $ResFactura['Datos'];


$ResBoleta = $InsReporteComprobanteVenta->MtdObtenerBoletaVentaVehiculos(NULL,NULL,NULL,"BtaNumero ASC, BolFechaEmision ASC","","500",5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$POST_Cancelado);
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
                <th width="4%" >ANULADO</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php

								$f=1;
				
							foreach($ArrFacturas as $DatFactura){

  
			
		?><?php
		 $Anulado = "";
		 
		 if($DatFactura->FacTotal <= $DatFactura->NcrTotal and $DatFactura->NcrTotal >0){
			 		 $Anulado = "Si";
		 }else{
			 		 $Anulado = "No"; 
		 }
		 ?>
        
         <?php $DatFactura->FacTotal = (($DatFactura->FacTotal/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio)));?>
          <?php $DatFactura->NcrTotal = (($DatFactura->NcrTotal/(empty($DatFactura->NcrTipoCambio)?1:$DatFactura->NcrTipoCambio)));?>
         
         
        <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   ><?php echo $DatFactura->FacFechaEmision;  ?></td>
                <td align="right" valign="middle" width="2%"   ><?php echo $DatFactura->FtaNumero;  ?>-<?php echo $DatFactura->FacId;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->SucNombre;  ?></td>
                <td  width="19%" align="left" ><?php echo $DatFactura->FacDatoAdicional1;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->FacDatoAdicional3;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->FacDatoAdicional13;  ?></td>
                <td  width="5%" align="right" ><?php echo ($DatFactura->FacDatoAdicional15);?></td>
                <td  width="4%" align="right" ><?php echo ($DatFactura->EinAnoFabricacion);?></td>
                <td  width="5%" align="right" ><?php echo ($DatFactura->FacDatoAdicional27);?></td>
                <td  width="4%" align="right" ><?php echo round( $DatFactura->FacTotal,2);?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->FacAsesorVenta;?> </td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliApellidoPaterno;  ?> <?php echo $DatFactura->CliApellidoMaterno;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliNumeroDocumento;  ?></td>
                <td  width="4%" align="right" >
				
                <?php
				if(!empty( $DatFactura->CliCelular)){
				?>
                <?php echo  $DatFactura->CliCelular;?>
                <?php
				}
				?>
                
                
                <?php
				if(!empty( $DatFactura->CliTelefono)){
				?>
					<?php echo  $DatFactura->CliTelefono;?>
                <?php
				}
				?>
             
                </td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliEmail;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliDireccion;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliProvincia;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliDistrito;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatFactura->CliDepartamento;  ?></td>
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
                <td  width="4%" align="right" ><?php echo $DatFactura->NctNumero;  ?>-<?php echo  $DatFactura->NcrId;  ?></td>
                <td  width="4%" align="right" ><?php echo  $DatFactura->NcrMotivo;  ?></td>
                <td  width="4%" align="right" ><?php echo number_format( $DatFactura->NcrTotal,2);;  ?></td>
                <td  width="4%" align="right" ><?php echo  $Anulado;  ?></td>
    </tr>
        <?php
		$f++;
			
			//}
			
		//}



								?>

           

              

              <?php		

									
								
									

									}
									

									?>
                                    
                                    
                                    
                                     <?php




								//$pagina = explode(",",$POST_pag);
//								$f=$pagina[0]+1;
//				
								
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
                <td align="right" valign="middle" width="2%"   ><?php echo $DatBoleta->BolFechaEmision;  ?></td>
                <td align="right" valign="middle" width="2%"   ><?php echo $DatBoleta->BtaNumero;  ?>-<?php echo $DatBoleta->BolId;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->SucNombre;  ?></td>
                <td align="left" ><?php echo $DatBoleta->BolDatoAdicional1;  ?></td>
                <td align="right" ><?php echo $DatBoleta->BolDatoAdicional3;  ?></td>
                <td align="right" ><?php echo $DatBoleta->BolDatoAdicional13;  ?></td>
                <td align="right" ><?php echo ($DatBoleta->BolDatoAdicional15);?></td>
                <td  width="4%" align="right" ><?php echo ($DatBoleta->EinAnoFabricacion);?></td>
                <td align="right" ><?php echo ($DatBoleta->BolDatoAdicional27);?></td>
                <td  width="4%" align="right" ><?php echo round($DatBoleta->BolTotal,2);?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->BolAsesorVenta;?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliApellidoPaterno;  ?> <?php echo $DatBoleta->CliApellidoMaterno;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliNumeroDocumento;  ?></td>
                <td  width="4%" align="right" >
				
                <?php
				if(!empty( $DatBoleta->CliCelular)){
				?>
                <?php echo  $DatBoleta->CliCelular;?>
                <?php
				}
				?>
                
                
                <?php
				if(!empty( $DatBoleta->CliTelefono)){
				?>
					<?php echo  $DatBoleta->CliTelefono;?>
                <?php
				}
				?>
             
                </td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliEmail;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliDireccion;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliProvincia;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliDistrito;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->CliDepartamento;  ?></td>
                <td  width="4%" align="right" ><?php
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
                <td  width="4%" align="right" ><?php echo $DatBoleta->NctNumero;  ?>-<?php echo $DatBoleta->NcrId;  ?></td>
                <td  width="4%" align="right" ><?php echo $DatBoleta->NcrMotivo;  ?></td>
                <td  width="4%" align="right" ><?php echo number_format($DatBoleta->NcrTotal,2);  ?></td>
                <td  width="4%" align="right" ><?php echo  $Anulado;  ?></td>
    </tr>
        <?php
		$f++;
	 

								?>

           

              

              <?php		

									
								
									

									}
									

									?>
                                    
                                    
            </tbody>
      </table>
 
</body>
</html>