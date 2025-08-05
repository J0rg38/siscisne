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
	header("Content-Disposition:  filename=\"REPORTE_INGRESO_PRODUCTO_OBSERVADOS_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 



<script type="text/javascript" src="js/JsReporteAlmacenMovimientoEntradaReclamo.js"></script>
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

//$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];
//$POST_OrdenCompraId = $_POST['CmpOrdenCompraId'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"AmoFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = isset($_POST['CmpMoneda'])?$_POST['CmpMoneda']:"MON-10001";

$POST_ConReclamo = isset($_POST['CmpConReclamo'])?$_POST['CmpConReclamo']:1;


require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimientoEntradaReclamo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');

$InsReporteAlmacenMovimientoEntradaReclamo = new ClsReporteAlmacenMovimientoEntradaReclamo();
$InsMoneda = new ClsMoneda();

//MtdObtenerReporteAlmacenMovimientoEntradaReclamos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oConReclamo=0) 
$ResReporteAlmacenMovimientoEntradaReclamo = $InsReporteAlmacenMovimientoEntradaReclamo->MtdObtenerReporteAlmacenMovimientoEntradaReclamos(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),0);
$ArrReporteAlmacenMovimientoEntradaReclamos = $ResReporteAlmacenMovimientoEntradaReclamo['Datos'];


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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE INGRESO DE PRODUCTOS OBSERVADOSDEL
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
          <th width="3%" rowspan="2">&nbsp;</th>
          <th width="5%" rowspan="2">COD. MOV.</th>
          <th width="5%" rowspan="2">NRO. FAC. GM</th>
          <th width="7%" rowspan="2">FECHA FAC.</th>
          <th width="8%" rowspan="2">TIPO  PEDIDO</th>
          <th width="12%" rowspan="2">CLIENTE</th>
          <th width="5%" rowspan="2">COD. ORIG.</th>
          <th width="18%" rowspan="2">NOMBRE</th>
          <th colspan="2">RECIBIDO</th>
          <th colspan="3">RECLAMO</th>
          </tr>
        <tr>
          <th width="80"> ESTADO</th>
          <th width="80">CANT.</th>
          <th width="80">COD.</th>
          <th width="80">FECHA</th>
          <th width="80">CANT.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteAlmacenMovimientoEntradaReclamos as $DatReporteAlmacenMovimientoEntradaReclamo){
        ?>
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >

<input onClick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]"  value="<?php echo $dat->AmoId; ?>"  />
                
                </td>
                <td  align="right" valign="top"   >
				
<a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->AmoId);?>"><?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->AmoId);?></a>

				
                
                </td>
                <td  align="right" valign="top"   >

				<?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->AmoComprobanteNumero);?>
                
                </td>
                <td  align="right" valign="top"   >
				
				<?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->AmoComprobanteFecha);?>
                
                </td>
                <td  align="right" valign="top"   >
                
                 <a target="_blank" href="../../principal.php?Mod=OrdenCompra&Form=VerEstado&Id=<?php echo $DatReporteAlmacenMovimientoEntradaReclamo->OcoId; ?>">
                 
                <?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->OcoId);?>
                </a>
                </td>
                <td  align="right" valign="top"   ><?php
                $ClienteIdAnterior  = "";
				
                $InsOrdenCompra = new ClsOrdenCompra();
                $InsOrdenCompra->OcoId = $DatReporteAlmacenMovimientoEntradaReclamo->OcoId;
                $InsOrdenCompra->MtdObtenerOrdenCompra();
				
				//deb($InsOrdenCompra->OrdenCompraPedido);
                if(!empty($InsOrdenCompra->OrdenCompraPedido)){
                    foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
				?>
                  <?php
					
					//deb($DatOrdenCompraPedido->CliId." - ".$ClienteIdAnterior);
					if($DatOrdenCompraPedido->CliId<>$ClienteIdAnterior){
					?>
                  <?php echo $DatOrdenCompraPedido->CliNombre;?> <?php echo $DatOrdenCompraPedido->CliApellidoPaterno;?> <?php echo $DatOrdenCompraPedido->CliApellidoMaterno;?><br>
                  <?php	
					}
					?>
                  <?php
					$ClienteIdAnterior = $DatOrdenCompraPedido->CliId;
                
                    }
					
                }
                    
                ?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->ProCodigoOriginal);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->ProNombre);?></td>
                <td width="80"  align="right" valign="top"   ><?php
			//	deb($DatReporteAlmacenMovimientoEntradaReclamo->AmdEstado);
				switch($DatReporteAlmacenMovimientoEntradaReclamo->AmdEstado){
					case "1":
				?>
                  No Llego
                  <?php	
					break;
					
					case "2":
				?>
                  Da&ntilde;ado
  <?php	
					break;
					
					
					case "1":
				?>
                  Conforme
  <?php	
					break;
					
					default:
				?>
                  -
  <?php	
					break;
				}
				?>
  <?php //echo ($DatReporteAlmacenMovimientoEntradaReclamo->AmdEstado);?></td>
                <td width="80"  align="right" valign="top"   ><?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->AmdCantidad);?></td>
                <td width="80"  align="right" valign="top"   >
				
				 <a target="_blank" href="../../principal.php?Mod=Reclamo&Form=Ver&Id=<?php echo $DatReporteAlmacenMovimientoEntradaReclamo->RecId; ?>">
                 
                <?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->RecId);?>
                </a>
				
				</td>
                <td width="80"  align="right" valign="top"   ><?php echo ($DatReporteAlmacenMovimientoEntradaReclamo->RecFechaEmision);?></td>
                <td width="80"  align="right" valign="top"   ><?php echo number_format($DatReporteAlmacenMovimientoEntradaReclamo->RdeCantidad,2);?></td>
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
            <td width="80" align="right">&nbsp;</td>
            <td width="80" align="right">&nbsp;</td>
            <td width="80" align="right">&nbsp;</td>
            <td width="80" align="right">&nbsp;</td>
            <td width="80" align="right">&nbsp;</td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>