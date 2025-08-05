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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_BOLETA_COBRAR_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"BolFechaEmision";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ClienteNombre = ($_POST['CmpClienteNombre']);
$POST_ClienteNumeroDocumento = ($_POST['CmpClienteNumeroDocumento']);
$POST_ClienteId = ($_POST['CmpClienteId']);

$POST_CondicionPago = ($_POST['CmpCondicionPago']);
$POST_Personal = ($_POST['CmpPersonal']);




require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');

$InsPago = new ClsPago();
$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();


if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}


if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}


// MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL) {
$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,5,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,"NPA-10001",$POST_Moneda,NULL,$POST_ClienteId,NULL,NULL,$POST_Personal);
$ArrBoletas = $ResBoleta['Datos'];

?>

<?php
if($_GET['P']==2){
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">&nbsp;</td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE BOLETAS POR COBRAR DEL
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
  <td width="23%" align="right" valign="top">&nbsp;</td>
</tr>
</table>
<?php	
}
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE BOLETAS POR COBRAR DEL
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
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="6%">CODIGO</th>
          <th width="5%">FECHA</th>
          <th width="12%">CLIENTE</th>
          <th width="7%">MONEDA</th>
          <th width="3%">T.C.</th>
          <th width="5%">REF.</th>
          <th width="5%">ORD. TRAB.</th>
          <th width="5%">MOV. ALM.</th>
          <th width="5%">CRED. CANT. DIAS</th>
          <th width="8%">FECHA VENC.</th>
          <th width="6%">TOTAL</th>
          <th width="6%">N. CRED.</th>
          <th width="6%">AMORT.</th>
          <th width="5%">SALDO</th>
          <th width="9%">VENCIMIENTO</th>
          <th width="9%">ESTADO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$BoletaTotal = 0;
		$BoletaAmortizadoTotal = 0;
		$BoletaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalBoletaNoCancelada = 0;
		
        foreach($ArrBoletas as $DatBoleta){
			
			
			$DatBoleta->BolTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatBoleta->BolTotal:($DatBoleta->BolTotal/$DatBoleta->BolTipoCambio));
				
			$DatBoleta->BolTotal = round($DatBoleta->BolTotal,2);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          <a target="_blank" href="../../principal.php?Mod=Boleta&Form=Ver&Id=<?php echo $DatBoleta->BolId;?>&Ta=<?php echo $DatBoleta->BtaId;?>">
		  <?php echo $DatBoleta->BtaNumero;  ?>-<?php echo $DatBoleta->BolId;  ?>
          </a>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->CliNombreCompleto;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->MonSimbolo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolTipoCambio;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->VdiOrdenCompraNumero;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->FinId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
           <a target="_blank" href="../../principal.php?Mod=VentaConcretada&Form=Ver&Id=<?php echo $DatBoleta->AmoId;?>">
           
		  <?php echo $DatBoleta->AmoId;  ?>
          </a>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="center" >
		  <?php
		  if($DatBoleta->NpaId == "NPA-10001"){
			?>
		  <?php echo $DatBoleta->BolCantidadDia;  ?>            
          
			  <?php
              if($DatBoleta->BolCantidadDia <=30){
                  $TotalCredito30 += $DatBoleta->BolTotal;
              }else{
                  $TotalCredito30Mas += $DatBoleta->BolTotal;
              }
              ?>
            <?php
		  }else{
			$TotalContado += $DatBoleta->BolTotal;
		  }
		  ?>

          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolFechaVencimiento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
					
	<?php echo number_format($DatBoleta->BolTotal,2);?>
                
		  </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
<?php
$TotalNotaCredito = 0;
$InsNotaCredito = new ClsNotaCredito();
//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {
	
$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrId","ASC",1,NULL,$_SESSION['SisSucId'],5,NULL,NULL,NULL,$DatBoleta->MonId,$DatBoleta->BolId,$DatBoleta->BtaId);
$ArrNotaCreditos = $ResNotaCredito['Datos'];

if(!empty($ArrNotaCreditos)){
	foreach($ArrNotaCreditos as $DatNotaCredito){
		
		//deb($DatNotaCredito->NcrTipoCambio);
		$DatNotaCredito->NcrTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrTotal:($DatNotaCredito->NcrTotal/$DatNotaCredito->NcrTipoCambio));
		
		$TotalNotaCredito += $DatNotaCredito->NcrTotal;
		
	}
}
?>
<?php
echo number_format($TotalNotaCredito,2);
?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >

<?php
$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL) {
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatBoleta->BolId,$DatBoleta->BtaId);
$ArrPagos = $ResPago['Datos'];
?>
                 
<?php
$ClientePagoMontoTotal = 0;
if(!empty($ArrPagos)){
	foreach($ArrPagos as $DatPago){
		
		
		//deb($DatPago->PagTipoCambio);
$DatPago->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));


		$ClientePagoMontoTotal += $DatPago->PagMonto;
	}
}
?>

<?php
echo number_format($ClientePagoMontoTotal,2);
?>

<?php
//deb($DatBoleta->BolTotal." - ".$ClientePagoMontoTotal);
$ClientePagoMontoTotal = round($ClientePagoMontoTotal,2);
$TotalNotaCredito = round($TotalNotaCredito,2);
$DatBoleta->BolTotal = round($DatBoleta->BolTotal,2);

settype($DatBoleta->BolTotal ,"float");
settype($ClientePagoMontoTotal ,"float");
settype($TotalNotaCredito ,"float");

$BoletaSaldo = round($DatBoleta->BolTotal,2) - round($ClientePagoMontoTotal,2) - round($TotalNotaCredito,2);
?>

          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
<?php
echo number_format($BoletaSaldo,2);
//echo ($BoletaSaldo);
?>

          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          <?php
		//echo  $DatBoleta->BolDiaVencido;
		  ?> 
            <?php
	
		settype($DatBoleta->BolTotal ,"float");
		settype($ClientePagoMontoTotal ,"float");
		settype($TotalNotaCredito ,"float");
		
		if( (($ClientePagoMontoTotal+500) + ($TotalNotaCredito+500)) < ($DatBoleta->BolTotal+1000)){
?>
			<?php
			if($DatBoleta->BolDiaVencido == -3){
			?>
            	VENCE EN 3 DIAS
            <?php	
			}else if($DatBoleta->BolDiaVencido == -2){
			?>
				VENCE EN 2 DIAS
            <?php	
			}else if($DatBoleta->BolDiaVencido == -1){
			?>
				VENCE EN 1 DIA
            <?php
			}else if($DatBoleta->BolDiaVencido == 0){
			?>
				VENCIO HOY     
            <?php	
			}else if($DatBoleta->BolDiaVencido > 0){
			?>
            VENCIDO <?php echo $DatBoleta->BolDiaVencido?> DIAS
            <?php	
			}else{
			?>
            PENDIENTE
            <?php	
			}
			?>

<?php		
		}else{
?>
			-
<?php		
		}
	
	?>
    
    
    
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          

<?php
//deb($ClientePagoMontoTotal." - ".$DatBoleta->BolTotal);

settype($DatBoleta->BolTotal ,"float");
settype($ClientePagoMontoTotal ,"float");
settype($TotalNotaCredito ,"float");



//echo $ClientePagoMontoTotal+1000;
//echo "<br>";
//echo $TotalNotaCredito+1000;
//echo "<br>";
//echo $DatBoleta->BolTotal+1000;
//echo "<br>";

if( (($ClientePagoMontoTotal+500) + ($TotalNotaCredito+500) )>= ($DatBoleta->BolTotal+1000)){
?>
<span class="EstImportante2">
CANCELADO
</span>
<?php	
}else{
	
	$TotalBoletaNoCancelada += $DatBoleta->BolTotal;
?>

<span class="EstImportante1">
SIN CANCELAR
</span>

 

 
 
<?php
}
?>



          </td>
          </tr>
        <?php	
		
			$BoletaTotal += $DatBoleta->BolTotal;
			$BoletaAmortizadoTotal += $ClientePagoMontoTotal;
			$BoletaSaldoTotal += $BoletaSaldo;
			
		$c++;
        }
        ?>
          <tr>
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
            <td align="right">TOTALES:</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($BoletaTotal,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($BoletaAmortizadoTotal,2);  ?></span></td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($BoletaSaldoTotal,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>