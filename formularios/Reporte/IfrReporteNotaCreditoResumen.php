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
	header("Content-Disposition:  filename=\"RESUMEN_NOTA_CREDITO_".date('d-m-Y').".xls\";");
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

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"NcrFechaEmision";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ClienteNombre = ($_POST['CmpClienteNombre']);
$POST_ClienteNumeroDocumento = ($_POST['CmpClienteNumeroDocumento']);
$POST_ClienteId = ($_POST['CmpClienteId']);

$POST_CondicionPago = ($_POST['CmpCondicionPago']);
$POST_Personal = ($_POST['CmpPersonal']);




require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');

$InsPago = new ClsPago();
$InsNotaCredito = new ClsNotaCredito();
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


//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL)
$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,$POST_Moneda,NULL,NULL,NULL,$POST_ClienteId);
$ArrNotaCreditos = $ResNotaCredito['Datos'];


//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL)
///$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos("cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,ncr.NcrId","contiene",$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$_SESSION['SesionSucursal'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,$POST_Moneda,NULL,NULL,$POST_Sucursal);
//$ArrNotaCreditos = $ResNotaCredito['Datos'];


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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE NOTAS DE CREDITO DEL
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

    <img src="../../imagenes/logos/logo_reporte.png" width="243" height="59" />

  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE NOTAS DE CREDITO DEL
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
          <th width="2%" rowspan="2">#</th>
          <th width="10%" rowspan="2">SERIE</th>
          <th width="10%" rowspan="2">CORRELATIVO</th>
          <th width="5%" rowspan="2">FECHA</th>
          <th width="31%" rowspan="2">TIPO DOC.</th>
          <th width="31%" rowspan="2">NUM. DOC.</th>
          <th width="31%" rowspan="2">CLIENTE</th>
          <th width="7%" rowspan="2">MONEDA</th>
          <th width="3%" rowspan="2">T.C.</th>
          <th width="6%" rowspan="2">MOTIVO</th>
          <th colspan="3">DOC. AFECTADO</th>
          <th width="6%" rowspan="2">SUNAT</th>
          <th width="6%" rowspan="2">RPTA.</th>
          <th width="6%" rowspan="2">ESTADO</th>
          <th width="9%" rowspan="2">SUB TOTAL</th>
          <th width="9%" rowspan="2">IMPUESTO</th>
          <th width="8%" rowspan="2">TOTAL</th>
        </tr>
        <tr>
          <th width="6%">SERIE</th>
          <th width="6%">CORRELATIVO</th>
          <th width="6%">FECHA</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$NotaCreditoTotal = 0;
		$NotaCreditoAmortizadoTotal = 0;
		$NotaCreditoSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalNotaCreditoNoCancelada = 0;
		
        foreach($ArrNotaCreditos as $DatNotaCredito){
			
			
			$DatNotaCredito->NcrTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrTotal:($DatNotaCredito->NcrTotal/$DatNotaCredito->NcrTipoCambio));
			$DatNotaCredito->NcrSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrSubTotal:($DatNotaCredito->NcrSubTotal/$DatNotaCredito->NcrTipoCambio));
			$DatNotaCredito->NcrImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrImpuesto:($DatNotaCredito->NcrImpuesto/$DatNotaCredito->NcrTipoCambio));
				
			$DatNotaCredito->NcrTotal = round($DatNotaCredito->NcrTotal,2);
			$DatNotaCredito->NcrSubTotal = round($DatNotaCredito->NcrSubTotal,2);
			$DatNotaCredito->NcrImpuesto = round($DatNotaCredito->NcrImpuesto,2);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NctNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->TdoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->CliNombreCompleto;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->MonSimbolo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrTipoCambio;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrMotivo;  ?></td>
          
          
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DtaNumero;  ?></td>
          
          
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DocId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DocFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          
          <?php echo  $DatNotaCredito->NcrEstadoDescripcion;?>
				
		  </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaCredito->NcrSubTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaCredito->NcrImpuesto,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
            
            
            <?php echo number_format($DatNotaCredito->NcrTotal,2);?>
            
          </td>
          </tr>
        <?php	
			
			$NotaCreditoSubTotal += $DatNotaCredito->NcrSubTotal;
			$NotaCreditoImpuesto += $DatNotaCredito->NcrImpuesto;
			$NotaCreditoTotal += $DatNotaCredito->NcrTotal;
			$NotaCreditoAmortizadoTotal += $ClientePagoMontoTotal;
			$NotaCreditoSaldoTotal += $NotaCreditoSaldo;
			
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
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">TOTALES:</td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($NotaCreditoSubTotal,2);  ?></span></td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($NotaCreditoImpuesto,2);  ?></span></td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($NotaCreditoTotal,2);  ?></span></td>
          </tr>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>