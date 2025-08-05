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
	header("Content-Disposition:  filename=\"REPORTE_PEDIDO_PRODUCTO_DETALLADO_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['CmpOrden'])?$_GET['CmpOrden']:"PcoFecha";
$POST_sen = isset($_GET['CmpSentido'])?$_GET['CmpSentido']:"DESC";

$POST_Sucursal = ($_GET['CmpSucursal']);


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqReporte().'ClsReportePedidoCompra.php');


$InsFichaAccion = new ClsFichaAccion();

$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();
$InsReportePedidoCompra = new ClsReportePedidoCompra();

//MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oOrdenCompraEstado=NULL,$oSucursal=NULL) {
$ResReportePedidoCompra = $InsReportePedidoCompra->MtdObtenerPedidoCompraDetalles(NULL,NULL,$POST_ord,$POST_sen,$POST_pag,NULL,3,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,"PcoFecha",false,false,NULL,$POST_Sucursal);
$ArrReportePedidoCompras = $ResReportePedidoCompra['Datos'];

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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE PEDIDOS DE REPUESTOS DETALLADO DEL
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
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE PEDIDOS DE REPUESTSO DETALLADO DEL
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
          <th width="9%">SUCURSAL</th>
          <th width="5%">FECHA</th>
          <th width="11%">A SOLICITUD DE</th>
          <th width="6%">VIN</th>
          <th width="6%">PLACA</th>
          <th width="8%">COD. ORIGINAL</th>
          <th width="24%">DESCRIPCION</th>
          <th width="7%">MONEDA</th>
          <th width="7%">COSTO</th>
          <th width="8%">CANTIDAD</th>
          <th width="7%">COSTO TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$FacturaTotal = 0;

		
        foreach($ArrReportePedidoCompras as $DatReportePedidoCompra){
			
			if($DatReportePedidoCompra->MonId<>$EmpresaMonedaId){
				$DatReportePedidoCompra->PcdPrecio = $DatReportePedidoCompra->PcdPrecio / $DatReportePedidoCompra->PcoTipoCambio;
			}else{
				$DatReportePedidoCompra->PcdPrecio = $DatReportePedidoCompra->PcdPrecio;
			}

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$DatReportePedidoCompra->PcdImporte = $DatReportePedidoCompra->PcdImporte / $DatReportePedidoCompra->PcoTipoCambio;
			}else{
				$DatReportePedidoCompra->PcdImporte = $DatReportePedidoCompra->PcdImporte;
			}
			
        ?>
        
        
      
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReportePedidoCompra->SucNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReportePedidoCompra->PcoFecha);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReportePedidoCompra->PerNombre);?> <?php echo ($DatReportePedidoCompra->PerApellidoPaterno);?>  <?php echo ($DatReportePedidoCompra->PerApellidoMaterno);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReportePedidoCompra->EinVIN);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReportePedidoCompra->EinPlaca);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReportePedidoCompra->ProCodigoOriginal);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReportePedidoCompra->ProNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReportePedidoCompra->MonSimbolo);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatReportePedidoCompra->PcdPrecio,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatReportePedidoCompra->PcdCantidad,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatReportePedidoCompra->PcdImporte,2);?></td>
          </tr>
        <?php	
		
			$FacturaTotal += $DatReportePedidoCompra->PcdImporte;
		
		$c++;
        }
        ?>
        
        
        
         
       
          </tbody>
		<tfoot class="EstTablaReporteFoot">
        
          <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >TOTAL:</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          <?php echo number_format($FacturaTotal,2); ?>
          </td>
        </tr>
        
		</tfoot>
		</table>





</body>
</html>