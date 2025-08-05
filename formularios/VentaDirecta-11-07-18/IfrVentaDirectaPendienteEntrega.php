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
	header("Content-Disposition:  filename=\"PENDIENTE_ENTREGA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

</head>
<body>

<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Personal = isset($_POST['CmpPesonal'])?$_POST['CmpPesonal']:"";

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoVenta.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();
$InsReporteProductoVenta = new ClsReporteProductoVenta();


//MtdObtenerVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oConDespacho=NULL,$oConPendiente=false) 
$ResProductoVenta = $InsReporteProductoVenta->MtdObtenerReporteProductoVentaPendienteEntregas(NULL,NULL,NULL,'VddId','Desc',NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra,NULL,true);
$ArrProductoVentas = $ResProductoVenta['Datos'];


$POST_Personal

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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPUESTOS PENDIENTES DE ENTREGA
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
          <th width="5%">ORD. VEN.</th>
          <th width="5%">FECHA</th>
          <th width="5%">COD. ORIG.</th>
          <th width="10%">NOMBRE</th>
          <th width="5%">OC </th>
          <th width="5%">FECHA OC</th>
          <th width="5%">DIAS TRANS.</th>
          <th width="5%">CANT.</th>
          <th width="5%">PEND.</th>
          <th width="7%">STOCK </th>
          <th width="28%">CLIENTE</th>
          <th width="9%">CONTACTO</th>
          <th width="13%">NOTA</th>
          <th width="6%">AT.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrProductoVentas as $DatProductoVenta){
        ?>
        <tr  >
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo $c;?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   >
		  
		 <?php echo ($DatProductoVenta->VdiId);?>
          
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo ($DatProductoVenta->VdiFecha);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo ($DatProductoVenta->ProCodigoOriginal);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo ($DatProductoVenta->ProNombre);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo ($DatProductoVenta->OcoId);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo ($DatProductoVenta->OcoFecha);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo ($DatProductoVenta->OcoDiaTranscurrido);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php echo number_format($DatProductoVenta->VddCantidad,2);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo number_format($DatProductoVenta->VddCantidadPendiente2,2);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo number_format($DatProductoVenta->ProStockReal,2);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatProductoVenta->CliNombre);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatProductoVenta->CliTelefono);?>/<?php echo ($DatProductoVenta->CliCelular);?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
			
            
            <input type="button" name="BtnVentaDirectaDetalleMostrarFormulario_<?php echo ($DatProductoVenta->VddId);?>" id="BtnVentaDirectaDetalleMostrarFormulario_<?php echo ($DatProductoVenta->VddId);?>"     value="Ver Notas"      >
            
            <!--<input type="button" name="BtnVentaDirectaDetalleOcultarFormulario_<?php echo ($DatProductoVenta->VddId);?>" id="BtnVentaDirectaDetalleOcultarFormulario_<?php echo ($DatProductoVenta->VddId);?>"     value="Ocultar Notas"      >-->
            
          <div id="CapVentaDirectaDetalleFormulario_<?php echo ($DatProductoVenta->VddId);?>">
         	<?php //echo ($DatProductoVenta->VddNotaResumen);?>
          </div>
          <div id="CapVentaDirectaDetalleEstado_<?php echo ($DatProductoVenta->VddId);?>"></div>
          
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          <?php //echo ($DatProductoVenta->VddAtendido)?>
         
    <!--      <input type="image" src="imagenes/estado/pendiente.png" name="BtnVentaDirectaDetalleAtendidoPendiente_<?php echo $DatProductoVenta->VddId; ?>" id="BtnVentaDirectaDetalleAtendidoPendiente_<?php echo $DatProductoVenta->VddId; ?>" width="25" height="25"  style="visibility:<?php echo ($DatProductoVenta->VddAtendido==2)?"visible":"hidden";?>">
          
          <input type="image" src="imagenes/estado/realizado.png" name="BtnVentaDirectaDetalleAtendidoRealizado_<?php echo $DatProductoVenta->VddId; ?>" id="BtnVentaDirectaDetalleAtendidoRealizado_<?php echo $DatProductoVenta->VddId; ?>" width="25" height="25"  style="visibility:<?php echo ($DatProductoVenta->VddAtendido==1)?"visible":"hidden";?>">-->
       <!-- 
       SEPARACION
       -->     
          
          <input type="checkbox" id="ChkVentaDirectaDetalleAtendido_<?php echo $DatProductoVenta->VddId; ?>" name="ChkVentaDirectaDetalleAtendido_<?php echo $DatProductoVenta->VddId; ?>" value="1" <?php echo ($DatProductoVenta->VddAtendido==1)?'checked="checked"':'';?> >
          
          
          
          <input  style="visibility:hidden;"  type="checkbox" name="CmpVentaDirectaDetalle_<?php echo $DatProductoVenta->VddId; ?>" id="CmpVentaDirectaDetalle_<?php echo $DatProductoVenta->VddId; ?>" value="<?php echo $DatProductoVenta->VddId; ?>"  etiqueta="vddetalle" >
          
          
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>