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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"CIERRE_DIARIO_".date('d-m-Y').".xls\";");
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

$POST_finicio = $_POST['CmpFechaInicio'];
$POST_ffin = $_POST['CmpFechaFin'];
$POST_Moneda = ($_POST['CmpMoneda']);

$POST_FormaPago = ($_POST['CmpFormaPago']);
$POST_Origen = ($_POST['CmpOrigen']);

if(empty($POST_finicio)){
	$POST_finicio = date("d/m/Y");
}

if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsPago = new ClsPago();
$InsMoneda = new ClsMoneda();

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL)
$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,VdiId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,3,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,$POST_Area,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"PagFecha",$POST_Origen,$POST_FormaPago);
$ArrPagos = $ResPago['Datos'];


$POST_Moneda = (empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda);

//deb($POST_Moneda);

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CIERRE DIARIO</span><span class="EstReporteTitulo">
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
          <th width="3%">#</th>
          <th width="8%">CODIGO</th>
          <th width="7%">FORMA PAGO</th>
          <th width="7%">ORIGEN</th>
          <th width="7%">RECIBO</th>
          <th width="6%">FECHA</th>
          <th width="13%">ORD. VEN.</th>
          <th width="11%">ORD. VEN. VEH.</th>
          <th width="19%">CLIENTE</th>
          <th width="24%">CONCEPTO</th>
          <th width="9%">TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$PagoTotal = 0;

		
        foreach($ArrPagos as $DatPago){
			
			
			$DatPago->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));
				
			$DatPago->PagMonto = round($DatPago->PagMonto,2);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          <a target="_blank" href="../../principal.php?Mod=Pago&Form=Ver&Id=<?php echo $DatPago->PagId;?>"><?php echo $DatPago->PagId;  ?>
          </a>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->FpaNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          <?php
		  
		  switch($DatPago->PagTipo){
			   case "VDI":
		?>
        Repuesto
        <?php	   
			   break;
		
				case "OVV":
			?>
            Vehiculo
            <?php	
				break;
		
		  }
          
          ?>
		  
		  
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->PagNumeroRecibo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->PagFecha;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->VdiId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->OvvId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->CliNombre;  ?>
          <?php echo $DatPago->CliApellidoPaterno;  ?>
          <?php echo $DatPago->CliApellidoMaterno;  ?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->PagConcepto;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
					

                
		  <?php echo number_format($DatPago->PagMonto,2);  ?></td>
          </tr>
        <?php	
		
			$PagoTotal += $DatPago->PagMonto;
		
			
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
            <td align="right"><span class="EstTablaReporteEtiquetaTotal">TOTAL CIERRE</span></td>
            <td align="right"><span class="EstTablaReporteTotal"><?php echo number_format($PagoTotal,2);  ?></span></td>
          </tr>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>