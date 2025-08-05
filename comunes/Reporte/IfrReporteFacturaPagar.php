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
	header("Content-Disposition:  filename=\"REPORTE_FACTURA_COBRAR_".date('d-m-Y').".xls\";");
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

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"AmoFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ProveedorNombre = ($_POST['CmpProveedorNombre']);
$POST_ProveedorNumeroDocumento = ($_POST['CmpProveedorNumeroDocumento']);
$POST_ProveedorId = ($_POST['CmpProveedorId']);

$POST_CondicionPago = ($_POST['CmpCondicionPago']);


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

if(empty($POST_ProveedorId) and !empty($POST_ProveedorNombre)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedors("PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno","contiene",$POST_ProveedorNombre,"PrvId","ASC",1,"1",NULL,NULL);
	$ArrProveedors = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedors)){
		foreach($ArrProveedors as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->PrvId;
		}
	}

}


if(empty($POST_ProveedorId) and !empty($POST_ProveedorNumeroDocumento)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedors("PrvNumeroDocumento","contiene",$POST_ProveedorNumeroDocumento,"PrvId","ASC",1,"1",NULL,NULL);
	$ArrProveedors = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedors)){
		foreach($ArrProveedors as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->PrvId;
		}
	}

}


//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL)
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,0,$POST_ProveedorId,NULL,$POST_CondicionPago);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE FACTURAS POR PAGAR DEL
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE FACTURAS POR COBRAR DEL
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
          <th width="5%">COND. PAGO</th>
          <th width="5%">NUM. COMPROB.</th>
          <th width="5%">FECHA COMPROB.</th>
          <th width="5%">NUM. DOC.</th>
          <th width="12%">PROVEEDOR</th>
          <th width="7%">MONEDA</th>
          <th width="3%">T.C.</th>
          <th width="5%">ORD. COMPRA</th>
          <th width="5%">CRED. CANT. DIAS</th>
          <th width="8%">FECHA VENC.</th>
          <th width="6%">TOTAL</th>
          <th width="6%">AMORT.</th>
          <th width="5%">SALDO</th>
          <th width="9%">VENCIMIENTO</th>
          <th width="9%">ESTADO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$AlmacenMovimientoEntradaTotal = 0;
		$AlmacenMovimientoEntradaAmortizadoTotal = 0;
		$AlmacenMovimientoEntradaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalAlmacenMovimientoEntradaNoCancelada = 0;
		
        foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
			
			
			$DatAlmacenMovimientoEntrada->AmoTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatAlmacenMovimientoEntrada->AmoTotal:($DatAlmacenMovimientoEntrada->AmoTotal/$DatAlmacenMovimientoEntrada->AmoTipoCambio));
				
			$DatAlmacenMovimientoEntrada->AmoTotal = round($DatAlmacenMovimientoEntrada->AmoTotal,2);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          <a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>">
		<?php echo $DatAlmacenMovimientoEntrada->AmoId;  ?>
          </a>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->NpaNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->AmoComprobanteNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->AmoComprobanteFecha;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->PrvNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->PrvNombreCompleto;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->MonSimbolo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->AmoTipoCambio;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->OcoId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="center" >
		  <?php
		  if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){
			?>
			
				<?php echo $DatAlmacenMovimientoEntrada->AmoCantidadDia;  ?>            
          
				<?php
				if($DatAlmacenMovimientoEntrada->AmoCantidadDia <=30){
					$TotalCredito30 += $DatAlmacenMovimientoEntrada->AmoTotal;
				}else{
					$TotalCredito30Mas += $DatAlmacenMovimientoEntrada->AmoTotal;
				}
              ?>
			<?php
		  }else{
			$TotalContado += $DatAlmacenMovimientoEntrada->AmoTotal;
		  }
		  ?>
&nbsp;
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenMovimientoEntrada->AmoFechaVencimiento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
					

                
		  <?php echo number_format($DatAlmacenMovimientoEntrada->AmoTotal,2);  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >



<?php
$ProveedorPagoMontoTotal = 0;

				switch($DatAlmacenMovimientoEntrada->AmoCancelado){
					
						case 1:
				$ProveedorPagoMontoTotal = $DatAlmacenMovimientoEntrada->AmoTotal;
					
						break;
					
						case 2:
				?>
               
                  <?php							
						break;	

					}
				?>

<?php
echo number_format($ProveedorPagoMontoTotal,2);
?>

<?php
//deb($DatAlmacenMovimientoEntrada->AmoTotal." - ".$ProveedorPagoMontoTotal);

settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
settype($ProveedorPagoMontoTotal ,"float");

$AlmacenMovimientoEntradaSaldo = round($DatAlmacenMovimientoEntrada->AmoTotal,2) - round($ProveedorPagoMontoTotal,2);
?>



          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
<?php
echo number_format($AlmacenMovimientoEntradaSaldo,2);
//echo ($AlmacenMovimientoEntradaSaldo);
?>

          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          
            <?php
	
	if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){
		
		settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
		settype($ProveedorPagoMontoTotal ,"float");
		
		
		if(($ProveedorPagoMontoTotal+1000) < ($DatAlmacenMovimientoEntrada->AmoTotal+1000)){
			if($DatAlmacenMovimientoEntrada->AmoCantidadDia<$DatAlmacenMovimientoEntrada->AmoDiaTranscurrido){
?>
            VENCIDO
            
            <?php
			echo $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido - $DatAlmacenMovimientoEntrada->AmoCantidadDia;		
			?> dias
             
  <?php		
			}else if ( ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) >= 1 and ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) <=3 ){
?>
				POR VENCER <?php echo ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido);?> dias
<?php	
			}else{
?>
VIGENTE
<?php				
			}
		}
		
	}
	?>
    
    
    
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          

<?php
//deb($ProveedorPagoMontoTotal." - ".$DatAlmacenMovimientoEntrada->AmoTotal);

settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
settype($ProveedorPagoMontoTotal ,"float");


if(($ProveedorPagoMontoTotal+1000) >= ($DatAlmacenMovimientoEntrada->AmoTotal+1000)){
?>
CANCELADO
<?php	
}else{
	
	$TotalAlmacenMovimientoEntradaNoCancelada += $DatAlmacenMovimientoEntrada->AmoTotal;
?>

SIN CANCELAR


 

 
 
<?php
}
?>



          </td>
          </tr>
        <?php	
		
			$AlmacenMovimientoEntradaTotal += $DatAlmacenMovimientoEntrada->AmoTotal;
			$AlmacenMovimientoEntradaAmortizadoTotal += $ProveedorPagoMontoTotal;
			$AlmacenMovimientoEntradaSaldoTotal += $AlmacenMovimientoEntradaSaldo;
			
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
            <td align="right">&nbsp;</td>
            <td align="right">TOTALES:</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($AlmacenMovimientoEntradaTotal,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($AlmacenMovimientoEntradaSaldoTotal,2);  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>