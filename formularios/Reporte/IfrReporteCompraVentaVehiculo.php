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
	header("Content-Disposition:  filename=\"REPORTE_COMPRA_VENTA_VEHICULAR_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:"15/".date("m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"OvvFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL) {
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE COMPRA VENTA VEHICULAR DEL
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
          <th width="1%" rowspan="3">No.</th>
          <th width="1%" rowspan="3">DIA</th>
          <th width="1%" rowspan="3">MES</th>
          <th width="1%" rowspan="3">A&Ntilde;O</th>
          <th width="3%" rowspan="3">TIPO DE PERSONA *</th>
          <th colspan="2">DOCUMENTO DE IDENTIDAD</th>
          <th colspan="7">DATOS DE CLIENTES</th>
          <th colspan="13">DETALLE DE OPERACI&Oacute;N</th>
          <th colspan="6">REPRESENTANTE LEGAL (LLENAR SI EL TIPO DE CLIENTE ES PERSONA JURIDICA)</th>
          </tr>
        <tr>
          <th width="3%" rowspan="2">TIPO **</th>
          <th width="4%" rowspan="2">NUMERO</th>
          <th width="6%" rowspan="2">PERSONA NATURAL:NOMBRES Y APELLIDOS</th>
          <th width="4%" rowspan="2">NACIONALIDAD</th>
          <th width="3%" rowspan="2">DIRECCI&Oacute;N</th>
          <th width="3%" rowspan="2">DISTRITO</th>
          <th width="3%" rowspan="2">PROVINCIA</th>
          <th width="5%" rowspan="2">DEPARTAMENTO</th>
          <th width="4%" rowspan="2">ACTIVIDAD ECON&Oacute;MICA / PROFESI&Oacute;N / OCUPACI&Oacute;N </th>
          <th width="3%" rowspan="2">MODELO DE VEHÍCULO</th>
          <th width="3%" rowspan="2">TIPO DE OPERACI&Oacute;N ***</th>
          <th width="2%" rowspan="2">FORMA DE PAGO ****</th>
          <th width="3%" rowspan="2">MONEDA</th>
          <th width="3%" rowspan="2">TIPO COMPROB.</th>
          <th width="5%" rowspan="2">N° DE COMPROBANTE DE PAGO</th>
          <th width="2%" rowspan="2">MONTO INICIAL</th>
          <th width="3%" rowspan="2">MONTO RESTANTE</th>
          <th width="3%" rowspan="2">IMPORTE TOTAL DEL VEHICULO</th>
          <th width="2%" rowspan="2">TIPO DE CAMBIO</th>
          <th width="4%" rowspan="2">MONTO EQUIVALENTE EN USD DEL IMPORTE TOTAL</th>
          <th width="2%" rowspan="2">MEDIO DE PAGO *****</th>
          <th width="5%" rowspan="2">OBSERVACIONES</th>
          <th colspan="2">DOCUMENTO DE IDENTIDAD</th>
          <th width="3%" rowspan="2">NOMBRES Y APELLIDOS</th>
          <th width="4%" rowspan="2">NACIONALIDAD</th>
          <th width="4%" rowspan="2">PROFESION / OCUPACI&Oacute;N</th>
          <th width="4%" rowspan="2">VENDEDOR</th>
        </tr>
        <tr>
          <th width="4%">TIPO</th>
          <th width="3%">N&Uacute;MERO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){
			
			$MontoRestante = 0;
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          
          <?php
		  list($Dia,$Mes,$Ano) = explode("/",$DatOrdenVentaVehiculo->OvvFecha);
		  ?>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
          <?php echo $Dia;?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
          <?php echo $Mes;?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
          <?php echo $Ano;?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >

<?php
switch($DatOrdenVentaVehiculo->TdoId){
	
	case "TDO-10001":
?>
PN
<?php
	break;
	
	case "TDO-10003":
?>
PJ
<?php
	break;
	
	default:
?>
-
<?php
	break;
}
?>		  




</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		  
		  <?php
switch($DatOrdenVentaVehiculo->TdoId){
	
	case "TDO-10001"://DNI
?>
DNI
  <?php
	break;
	
	case "TDO-10003"://RUC
?>
RUC
<?php
	break;
	
	case "TDO-10002"://CARNET
?>
CE
<?php
	break;

	case "TDO-10004"://PASAPORTE
?>
P
<?php
	break;

	
	
	default:
?>
-
<?php
	break;
}
?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliNumeroDocumento;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		  <?php echo $DatOrdenVentaVehiculo->CliNombre;  ?>
          <?php echo $DatOrdenVentaVehiculo->CliApellidoPaterno;  ?>
          <?php echo $DatOrdenVentaVehiculo->CliApellidoMaterno;  ?>
          
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliPais;  ?>&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliDireccion;  ?>&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliDistrito;  ?>&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliProvincia;  ?>&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliDepartamento;  ?>&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliActividadEconomica;  ?>&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->VmaNombre;  ?> <?php echo $DatOrdenVentaVehiculo->VmoNombre;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          
          
          V</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
           FpaId<?php echo $DatOrdenVentaVehiculo->MpaAbreviatura?>
           
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->MonSimbolo;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          <?php
				switch($DatOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>
                FACTURA
                <?php	
					break;
					
					case "B":
				?>
                BOLETA
                <?php	
					break;
					
					default:
				?>-
                <?php	
					break;
				}
				?>
                
                
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
            <?php
				switch($DatOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>
                  <?php echo $DatOrdenVentaVehiculo->OvvFacturaNumero?>
                  <?php	
					break;
					
					case "B":
				?>
                  <?php echo $DatOrdenVentaVehiculo->OvvBoletaNumero?>
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
                
                
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >



		<?php echo number_format($DatOrdenVentaVehiculo->OvvAbonoInicial,2);?>  
          



          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          
          <?php
		  $MontoRestante = $DatOrdenVentaVehiculo->OvvTotal - $DatOrdenVentaVehiculo->OvvAbonoInicial;
		  ?>
          <?php
		  echo number_format($MontoRestante,2);
		  ?>
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
           <?php echo number_format($DatOrdenVentaVehiculo->OvvTotal,2);?>
           
           
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
           <?php echo $DatOrdenVentaVehiculo->OvvTipoCambio;?>
           
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		  <?php $DatOrdenVentaVehiculo->OvvTotal = (($EmpresaMonedaId==$DatOrdenVentaVehiculo->MonId or empty($DatOrdenVentaVehiculo->MonId))?$DatOrdenVentaVehiculo->OvvTotal:($DatOrdenVentaVehiculo->OvvTotal/$DatOrdenVentaVehiculo->OvvTipoCambio));?>
		  
		  
		  <?php echo number_format($DatOrdenVentaVehiculo->OvvTotal,2);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          <?php echo $DatOrdenVentaVehiculo->FpaAbreviatura;?>
          
          
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >- <?php //echo $DatOrdenVentaVehiculo->OvvObservacion;?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >-</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          			 <?php echo $DatOrdenVentaVehiculo->CliRepresentanteNumeroDocumento;?>	
				
                
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliRepresentanteNombre;?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliRepresentanteNacionalidad;?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatOrdenVentaVehiculo->CliRepresentanteActividadEconomica;?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		  <?php echo $DatOrdenVentaVehiculo->PerNombre;?>
          <?php echo $DatOrdenVentaVehiculo->PerApellidoPaterno;?>
          <?php echo $DatOrdenVentaVehiculo->PerApellidoMaterno;?>
          
          </td>
          </tr>
        <?php	
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
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
<br>
        <table class="EstTablaReporte" cellspacing="0" cellpadding="0">
        <tbody class="EstTablaReporteBody">
          <tr>
            <td colspan="6" width="304">* Tipo de Persona: Persona Natural (PN), Persona    Jur&iacute;dica (PJ)</td>
            <td width="65">&nbsp;</td>
            <td width="272">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="8">**    Tipo de Documento de Identidad: DNI, CE (Carn&eacute; de Extranjeria), Pasaporte    (P), Registro Unico de Contribuyentes (RUC)</td>
          </tr>
          <tr>
            <td colspan="5">***    Tipo de Operaci&oacute;n: Venta (V), Compra (C).</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="8">****    Forma de Pago: CPSO: Cr&eacute;dito Propio del SO, CBV: Cr&eacute;dito Bancario Veh&iacute;cular,    CP: Cr&eacute;dito Personal, L: Leasing, C: Contado.</td>
          </tr>
          <tr>
            <td colspan="8">*****    Medio de Pago: E: Efectivo, DC: Deposito en Cuenta, TB: Transferencia    Interbancaria.</td>
          </tr>
          </tbody>
        </table>

</body>
</html>