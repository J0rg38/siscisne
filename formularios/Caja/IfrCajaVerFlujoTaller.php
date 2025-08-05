<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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

//if($_GET['P']==2){
//	header("Content-type: application/vnd.ms-excel");
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_KPI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_FechaInicio = empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio'];
$POST_FechaFin = empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin'];
$POST_Moneda = (empty($_GET['Moneda'])?$EmpresaMonedaId:$_GET['Moneda']);

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCajaDiaria.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
?>

<?php
if($_GET['P']<>2 and !empty($_GET['P'])){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

<?php if($_GET['P']==1){?> 
<script type="text/javascript">

$().ready(function() {
	setTimeout("window.close();",2500);	
	window.print(); 
});

</script>
<?php }?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" rowspan="2" align="left" valign="top">
  
  
  <?php
        if(!empty($InsVehiculoMarca->VmaFoto)){
        ?>
    <img src="../../subidos/vehiculo_marca/<?php echo $InsVehiculoMarca->VmaFoto;?>" width="271" height="92" />
    <?php
        }else{
        ?>
-
<?php	
        }
        ?></td>
  <td width="54%" rowspan="2" align="center" valign="top">REPORTE DE FLUJO DE TALLER</td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
<tr>
  <td align="right" valign="top">A&ntilde;o: <?php echo $POST_Ano;?></td>
</tr>
</table>

<hr class="EstReporteLinea">

<?php }?>
                

                     
  
                    


<table class="EstTablaReporte" width="100%">
                    <tr>
                      <td colspan="2" align="center" valign="top"><span class="EstFormularioSubTitulo">Movimientos</span></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top">
                        
                  
                        
                        
                        
                        
  <?php
$InsCajaDiaria = new ClsCajaDiaria();
//MtdObtenerCajaDiarias($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL) {
$ResCajaDiaria = $InsCajaDiaria->MtdObtenerCajaDiarias(NULL,NULL,NULL,"CdiFecha,CdiId","ASC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"CdiFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal);
$ArrCajaDiarias = $ResCajaDiaria['Datos'];

?>
                        
<?php
$TotalCajaDiarias = 0;

if(!empty($ArrCajaDiarias)){
?>
                        CajaDiarias
                        
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#
                                
                              </th>
                              <th width="4%">Fecha</th>
                              <th width="3%">Ref.</th>
                              <th width="3%">Doc..</th>
                              <th width="16%">Afectado</th>
                              <th width="34%">Detalle</th>
                              <th width="5%">Obs.</th>
                              <th width="11%">Ingreso</th>
                              <th width="11%">Egreso</th>
                              <th width="14%">Saldo</th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaListadoBody">
  <?php
$i=1;
$TotalEntradas = 0;
$TotalSalidas = 0;
$TotalSaldos = 0;
$Color = "FFFFFF";

$UltimaFecha = "";
$Flag = 2;

	foreach($ArrCajaDiarias as $DatCajaDiaria){
		
		$DatCajaDiaria->CdiMonto = (($EmpresaMonedaId==$DatCajaDiaria->MonId or empty($POST_Moneda))?$DatCajaDiaria->CdiMonto:($DatCajaDiaria->CdiMonto/$DatCajaDiaria->CdiTipoCambio));
		
		if($DatCajaDiaria->CdiFecha==$UltimaFecha){
			
			if($Flag == 1){
				$Color = "";
				$Flag  = 2;
			}
		}else{
			
			if($Flag == 2){
				$Color = "CCCCCC";
				$Flag  = 1;
			}

		}
	
		
?>
                            
                         
                            <tr>
                              <td bgcolor="<?php echo $Color;?>">
                                <?php echo $i;?>
                              </td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatCajaDiaria->CdiFecha;?></td>
                             <td bgcolor="<?php echo $Color;?>"> <?php echo $DatCajaDiaria->CdiId;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatCajaDiaria->CdiReferencia;?></td>
                              <td bgcolor="<?php echo $Color;?>">
                              
                                         <?php echo $DatCajaDiaria->PerNombre;?>
                                <?php echo $DatCajaDiaria->PerApellidoPaterno;?>
                                <?php echo $DatCajaDiaria->PerApellidoMaterno;?> 
                                
                                <?php echo $DatCajaDiaria->CliNombre;?>
                                <?php echo $DatCajaDiaria->CliApellidoPaterno;?>
                                <?php echo $DatCajaDiaria->CliApellidoMaterno;?> 
                                
                                
                                <?php echo $DatCajaDiaria->PrvNombre;?>
                                <?php echo $DatCajaDiaria->PrvApellidoPaterno;?>
                                <?php echo $DatCajaDiaria->PrvApellidoMaterno;?> 
                                
                                
                                </td>
                             <td bgcolor="<?php echo $Color;?>"> <?php echo $DatCajaDiaria->CdiConcepto;?>/ O.T.: <?php echo $DatCajaDiaria->FinId;?> / V.D.: <?php echo $DatCajaDiaria->VdiId;?> / O.V.V.: <?php echo $DatCajaDiaria->OvvId;?>
                                
                     
                                
                                
                              </td>
                              <td bgcolor="<?php echo $Color;?>"><?php echo $DatCajaDiaria->CdiObservacionCaja;?></td>
                             <td bgcolor="<?php echo $Color;?>">
							 
							 <?php
							  if($DatCajaDiaria->CdiTipoCajaDiaria=="Entrada"){
								  $TotalEntradas += $DatCajaDiaria->CdiMonto;
								?>
                                <?php echo number_format($DatCajaDiaria->CdiMonto,2)?>
                              <?php 
							  }
							  ?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php
							  if($DatCajaDiaria->CdiTipoCajaDiaria=="Salida"){
								    $TotalSalidas += $DatCajaDiaria->CdiMonto;
									
								?>
                                <?php echo number_format($DatCajaDiaria->CdiMonto,2)?>
                              <?php 
							  }
							  ?></td>
                            <td bgcolor="<?php echo $Color;?>">
                           
                              <?php
							  $Saldo = $TotalEntradas - $TotalSalidas;
							  ?>
                              <?php echo number_format($Saldo,2)?>
                              
                                 <?php
							  $TotalSaldos += $Saldo;
							  ?>
                              </td>
                            </tr>
                            
                            
                            
  <?php	
		$TotalCajaDiarias += $DatCajaDiaria->CdiMonto;
		$UltimaFecha = $DatCajaDiaria->CdiFecha;
		$i++;
	}
	
?>
                          </tbody>
                          <tfoot class="EstTablaListadoFoot">
                          
                             <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right"><?php echo number_format($TotalEntradas,2);?></td>
                              <td align="right"><?php echo number_format($TotalSalidas,2);?></td>
                              <td align="right"><?php //echo number_format($TotalSaldos,2);?></td>
                            </tr>
                            
                          </tfoot>
                        </table>     
                        
                        <hr /> 
  <?php
}
?>
                        
                        
                        <?php
  $TotalEgresos = $TotalCajaDiarias;
  ?>
                        
                        
                        
                      </td>
                    </tr>
                    <tr>
                      <td width="86%" align="right">Total Gastos: </td>
                      <td width="14%" align="right"><?php echo number_format($Saldo,2);?></td>
                    </tr>
        </table>



         

                             
  