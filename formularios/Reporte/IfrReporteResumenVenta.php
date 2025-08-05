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

$POST_Sucursal = (($_GET['Sucursal']));
$POST_VehiculoMarca = (($_GET['VehiculoMarca']));

require_once($InsPoo->MtdPaqReporte().'ClsReporteResumenVenta.php');

$InsReporteResumenVenta = new ClsReporteResumenVenta();
//MtdObtenerReporteResumenVentas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
$ResReporteResumenVenta = $InsReporteResumenVenta->MtdObtenerReporteResumenVentas(NULL,NULL,NULL,"RvrFecha","ASC",NULL,NULL,NULL,$POST_Sucursal,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin));
$ArrReporteResumenVentas = $ResReporteResumenVenta['Datos'];



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
  <td width="54%" rowspan="2" align="center" valign="top">REPORTE DE POST VENTA DETALLADO</td>
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
                      <td width="100%" colspan="2" align="center" valign="top"><span class="EstFormularioSubTitulo"></span></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top">
             
                        
<?php


if(!empty($ArrReporteResumenVentas)){
?>
                        
                        
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#
                                
                              </th>
                              <th width="4%">Doc.</th>
                              <th width="3%">Fecha</th>
                              <th width="3%">Tipo Moneda</th>
                              <th width="16%">O.T.</th>
                              <th width="16%">Cliente</th>
                              <th width="16%">Local</th>
                              <th width="16%">Marca</th>
                              <!-- <th width="16%">Resumen</th>
                              <th width="16%">Tipo</th>
                              <th width="16%">Servicios</th>
                              <th width="16%">Tipo Detalle</th> -->
                              <th width="16%">Vendedor</th>
                              <th width="16%">Asesor Accesorio</th>
                              <th width="16%">Codigo</th>
                              <th width="16%">Descripcion</th>
                              <th width="16%">Cant.</th>
                              <th width="34%">Costo $USD</th>
                              <th width="5%">Costo + IGV</th>
                              <th width="5%">Tipo Cambio</th>
                              <!-- <th width="5%">Costo Total 1</th>
                              <th width="5%">Costo + IGV Soles</th>
                              <th width="5%">Costo Total 2</th>
                              <th width="5%">Costo General</th>
                              <th width="5%">Precio USD$</th>
                              <th width="5%">Precio S/.</th>
                              <th width="5%">Precio Unitario</th>
                              <th width="5%">Precio Cliente</th>
                              <th width="5%">Ganancia</th>
                              <th width="5%">Margen</th> -->
                              <th width="5%">Unidad Medida</th>
                              <th width="5%">Precio S/.</th>
                              <th width="5%">Desc. Uni. S/.</th>
                              <th width="5%">Precio c/ Desc. S/.</th>
                              <th width="5%">Importe S/.</th>
                              <th width="5%">Importe c/ Desc. S/.</th>
                              <th width="5%">Precio. US$</th>
                              <th width="5%">Desc. Uni. US$</th>
                              <th width="5%">Precio c/ Desc. US$</th>
                              <th width="5%">Importe US$</th>
                              <th width="5%">Importe c/ Desc. US$</th>
                              <th width="5%">Modalidad</th>
                              <th width="5%">Nota Credito</th>
                              <th width="5%">Importe</th>
                              <th width="5%">Marca</th>
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

	foreach($ArrReporteResumenVentas as $DatReporteResumenVenta){
		
		//$DatReporteResumenVenta->CdiMonto = (($EmpresaMonedaId==$DatReporteResumenVenta->MonId or empty($POST_Moneda))?$DatReporteResumenVenta->CdiMonto:($DatReporteResumenVenta->CdiMonto/$DatReporteResumenVenta->CdiTipoCambio));
		
		if($i%2==0){
			$Color = "CCCCCC";
		}else{
			$Color = "FFFFFF";
		}
		
		//if($DatReporteResumenVenta->RvrFecha==$UltimaFecha){
//			
//			if($Flag == 1){
//				$Color = "";
//				$Flag  = 2;
//			}
//		}else{
//			
//			if($Flag == 2){
//				$Color = "CCCCCC";
//				$Flag  = 1;
//			}
//
//		}
//	
		
?>
                            
                         <!--
                         
                         
"RvrId",
"RvrDoc",
"RvrFecha",
"RvrTipoMoneda",
"RvrOrdenTrabajo",
"RvrCliente",
"RvrLocal",
"RvrMarca",
"RvrResumen",
"RvrTipo",
"RvrServicios",
"RvrTipoDetalle",
"RvrVendedor",
"RvrAsesorAccesorio",
"RvrCodigo",
"RvrDescripcion",
"RvrCantidad",
"RvrCostoUs",
"RvrCostoIgv",
"RvrTipoCambio",
"RvrCostoTotal1",
"RvrCostoIGVSoles",
"RvrCostoTotal2",
"RvrCostoGeneral",
"RvrPrecioUs",
"RvvrPrecioS",
"RvrPrecioUnitario",
"RvrPrecioCliente",
"RvrGanancia",
"RvrMargen"
                         --->
                            <tr>
                              <td bgcolor="<?php echo $Color;?>">
                                <?php echo $i;?>
                              </td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrDoc;?></td>
                             <td bgcolor="<?php echo $Color;?>"> <?php echo $DatReporteResumenVenta->RvrFecha;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrTipoMoneda;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrOrdenTrabajo;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrCliente;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrLocal;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrMarca;?></td>
                            
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrVendedor;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrAsesorAccesorio;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrCodigo;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrDescripcion;?></td>
                              <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrCantidad;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrCostoUs;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrCostoIgv;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrTipoCambio;?></td>
                             
                             <td bgcolor="<?php echo $Color;?>"><?php echo $DatReporteResumenVenta->RvrUnidadMedida;?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrPrecioSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrDescuentoSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrPrecioDescuentoSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrImporteSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrImporteDescuentoSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrPrecioUSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrDescuentoUSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrPrecioDescuentoUSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrImporteUSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo number_format($DatReporteResumenVenta->RvrImporteDescuentoUSFinal,2);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo ($DatReporteResumenVenta->RvrModalidad);?></td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo ($DatReporteResumenVenta->RvrNotaCredito);?></td>
                             <td bgcolor="<?php echo $Color;?>">
                             
                             
                             <?php echo number_format($DatReporteResumenVenta->RvrNotaCreditoTotal,2);?>
                             
                             </td>
                             <td bgcolor="<?php echo $Color;?>"><?php echo ($DatReporteResumenVenta->VmaNombre);?></td>
                            </tr>
                            
                            
                            
  <?php	
		
	
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
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                            </tr>
                            
                          </tfoot>
                        </table>     
                        
                        <hr /> 
  <?php
}
?>
                        
                        
                        <?php
  $TotalEgresos = $TotalReporteResumenVentas;
  ?>
                        
                        
                        
                      </td>
                    </tr>
        </table>



         

                             
  