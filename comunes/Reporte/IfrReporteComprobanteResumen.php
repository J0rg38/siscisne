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

require_once($InsProyecto->MtdRutLibrerias().'libchart/classes/libchart.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_COMPROBANTE_RESUMEN_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReporteComprobanteResumen.js"></script>

<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = (empty($_POST['CmpMoneda'])?$EmpresaMonedaId:$_POST['CmpMoneda']);

$POST_ConOrdenCompra = ($_POST['CmpConOrdenCompra']);
$POST_Clasificacion = $_POST['CmpClasificacion'];
$POST_Ano = $_POST['CmpAno'];

$POST_Origen = $_POST['CmpOrigen'];
$POST_Personal = $_POST['CmpPersonal'];



require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');


$InsBoleta = new ClsBoleta();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsFacturaTalonario = new ClsFacturaTalonario();
$InsBoletaTalonario = new ClsBoletaTalonario();


$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

$ResFacturaTalonario = $InsFacturaTalonario->MtdObtenerFacturaTalonarios(NULL,NULL,"FtaNumero","DESC",NULL,NULL);
$ArrFacturaTalonarios = $ResFacturaTalonario['Datos'];

$ResBoletaTalonario = $InsBoletaTalonario->MtdObtenerBoletaTalonarios(NULL,NULL,"BtaNumero","DESC",NULL,NULL);
$ArrBoletaTalonarios = $ResBoletaTalonario['Datos'];

	
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE COMPROBANTES
      <?php
  if($POST_finicio == $POST_ffin){
?>
      <?php echo $POST_finicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
      <?php  
  }
?>
  </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
    
    


<table width="100%">
<tr>
  <td align="center" valign="middle">RESUMEN DE COMPROBANTES</td>
  <td colspan="2" align="center" valign="middle">GRAFICO</td>
</tr>
<tr>
  <td align="center" valign="top">
  
  
  
  
  
  <table width="365" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
    <thead class="EstTablaReporteHead">
      <tr>
        <th colspan="2"><?php echo $POST_finicio?> - <?php echo $POST_ffin?></th>
        </tr>
      <tr>
        <th width="100">Serie</th>
       
			<?php
            if(!empty($ArrMonedas)){
                foreach($ArrMonedas as $DatMoneda){
					$SumaTotalFacturaMoneda[$DatMoneda->MonId] = 0;
            ?>
				<?php
				if($POST_Moneda==$DatMoneda->MonId){
				?>
                
                <th width="100" align="center"><?php echo $DatMoneda->MonSimbolo;?></th>
                
                <?php	
				}
				?>
                
            <?php		
                }
            }
            ?>
        
        
        </tr>
      </thead>
    <tbody class="EstTablaReporteBody">
      <?php

	if(!empty($ArrFacturaTalonarios)){
		foreach($ArrFacturaTalonarios as $DatFacturaTalonario){
			
			$Mostrar = false;
			
			if(!empty($ArrMonedas)){
                foreach($ArrMonedas as $DatMoneda){
					
					if($POST_Moneda==$DatMoneda->MonId){
						$InsFactura = new ClsFactura();																											// MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL)  {
						$FacturaMonedaTotal[$DatFacturaTalonario->FtaId] = $InsFactura->MtdObtenerFacturasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$DatMoneda->MonId."' AND '".$DatMoneda->MonId."' <> '' , (fac.FacTotal/IFNULL(fac.FacTipoCambio,fac.FacTotal)) , fac.FacTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,5,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$DatFacturaTalonario->FtaId,NULL,NULL,NULL,$DatMoneda->MonId,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
						
						if($FacturaMonedaTotal[$DatFacturaTalonario->FtaId] >0){
							$Mostrar = true;
						}
					}
					
				}
			}

		?>
        <?php
		if($Mostrar){
		?>
          <tr >
        <td width="100"  align="left" valign="top"   >
		<?php echo $DatFacturaTalonario->FtaNumero;?><br>
        (<?php echo $DatFacturaTalonario->FtaDescripcion;?>)
        </td>
        			<?php
            if(!empty($ArrMonedas)){
                foreach($ArrMonedas as $DatMoneda){
            ?>
            
            <?php
				if($POST_Moneda==$DatMoneda->MonId){
				?>
            <td width="100" align="right" valign="top"  >
            
<?php

$InsFactura = new ClsFactura();																											// MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL)  {
$FacturaMonedaTotal[$DatFacturaTalonario->FtaId] = $InsFactura->MtdObtenerFacturasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$DatMoneda->MonId."' AND '".$DatMoneda->MonId."' <> '' , (fac.FacTotal/IFNULL(fac.FacTipoCambio,fac.FacTotal)) , fac.FacTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,5,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$DatFacturaTalonario->FtaId,NULL,NULL,NULL,$DatMoneda->MonId,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

$SumaTotalFacturaMoneda[$DatMoneda->MonId] += $FacturaMonedaTotal[$DatFacturaTalonario->FtaId];

?>

<?php
echo number_format($FacturaMonedaTotal[$DatFacturaTalonario->FtaId],2);
?>
            </td>
             <?php	
            }
            ?>
            
            <?php		
                }
            }
            ?>

     
        </tr>
        <?php	
		}
		?>
    
     <?php
		}
	}
	 ?>
      <tr>
        <td width="100" align="right">TOTAL ANUAL:</td>
       
       
       	<?php
            if(!empty($ArrMonedas)){
                foreach($ArrMonedas as $DatMoneda){
					
            ?>
            	
                <?php
				if($POST_Moneda==$DatMoneda->MonId){
				?>
                
                 <td width="100" align="right">
                 
                 <?php echo number_format($SumaTotalFacturaMoneda[$DatMoneda->MonId],2);?>
                 
                 </td>
             
				<?php	
                }
                ?>
             
            <?php		
                }
            }
            ?>
            
        </tr>
      </tbody>
    <tfoot class="EstTablaReporteFoot">
      </tfoot>
    </table>
    
    
    
    
    </td>
  <td colspan="2" align="center" valign="top"><?php
  
	$chart = new PieChart();
	$chart = new PieChart(670, 370);
	
	$dataSet = new XYDataSet();
	
	if(!empty($ArrFacturaTalonarios)){
		foreach($ArrFacturaTalonarios as $DatFacturaTalonario){
				
			if($FacturaMonedaTotal[$DatFacturaTalonario->FtaId]>0){
				$dataSet->addPoint(new Point($DatFacturaTalonario->FtaNumero, $FacturaMonedaTotal[$DatFacturaTalonario->FtaId]));
			}
			
			
		}
	}

	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(10, 35, 90, 35));
	
	$chart->setTitle("RESUMEN DE COMPROBANTES X FECHA - ".$POST_finicio." AL ".$POST_ffin." - ".$InsMoneda->MonNombre);
	$chart->render("../../generados/reportes/resumen_comprobantes_".FncCambiaFechaAMysql($POST_finicio)."_".FncCambiaFechaAMysql($POST_ffin).".png");
	
?>

<img alt="RESUMEN DE COMPROBANTES X FECHA"  src="../../generados/reportes/resumen_comprobantes_<?php echo FncCambiaFechaAMysql($POST_finicio);?>_<?php echo FncCambiaFechaAMysql($POST_ffin);?>.png" style="border: 1px solid gray;"/>

</td>
</tr>
</table>    
      
        





</body>
</html>