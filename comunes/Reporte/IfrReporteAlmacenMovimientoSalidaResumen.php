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
	header("Content-Disposition:  filename=\"RESUMEN_SALIDA_REPUESTOS_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReporteVentaDirectaResumen.js"></script>

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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"ProNombre";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

//MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL)

$ResTallerPedidoDetalle = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,$oProductoTipo,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL);
$ArrTallerPedidoDetalles = $ResTallerPedidoDetalle['Datos'];


//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)

$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,NULL,$oProductoTipo,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];



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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE SALIDAS DE REPUESTOS DEL
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

<!--<style type="text/css">
tbody.EstTablaReporteBody td{
white-space: nowrap;
}
</style>-->
<?php }?>
        
      <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        </thead>
        <tbody class="EstTablaReporteBody">
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td align="center">&nbsp;</td>
       </tr>
       <tr>
         <td width="1%">&nbsp;</td>
         <td width="98%">
         
         <span class="EstTablaReporteTitulo">
         ORDENES DE TRABAJO
         </span>
         
        </td>
         <td width="1%" align="center">&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>
         
         
         <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="7%">NUM. FICHA</th>
          <th width="9%">FECHA</th>
          <th width="9%">O.T.</th>
          <th width="12%">COMPROB. VENTA.</th>
          <th width="9%">COD. ORIG.</th>
          <th width="28%">NOMBRE</th>
          <th width="9%">U.M.</th>
          <th width="15%">CANT.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;

        foreach($ArrTallerPedidoDetalles as $DatTallerPedidoDetalle){
			

        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>" >
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="middle"   ><?php echo $c;?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoSalida&Form=Ver&Id=<?php echo ($DatTallerPedidoDetalle->AmoId);?>"><?php echo ($DatTallerPedidoDetalle->AmoId);?></a></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatTallerPedidoDetalle->AmoFecha);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatTallerPedidoDetalle->FinId);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
                
              
                <?php echo ($DatTallerPedidoDetalle->AmdBoleta);?>
                <?php echo ($DatTallerPedidoDetalle->AmdFactura);?>
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatTallerPedidoDetalle->ProCodigoOriginal);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
				
                <?php echo ($DatTallerPedidoDetalle->ProNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; 
				
				
				
				
				<?php echo ($DatTallerPedidoDetalle->UmeNombre);?>
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; 
				
				
				
				
				<?php echo number_format($DatTallerPedidoDetalle->AmdCantidad,2);?>
                
                
                
                </td>
            </tr>
		<?php	
			
		?>
  
      
              
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
            </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
        </td>
         <td align="center">&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td align="center">&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td> <span class="EstTablaReporteTitulo">ORDENES DE VENTA</span></td>
         <td align="center">&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>
         
         <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="7%">NUM. FICHA</th>
          <th width="9%">FECHA</th>
          <th width="9%">ORD. VEN.</th>
          <th width="12%">COMPROB. VENTA.</th>
          <th width="10%">COD. ORIG.</th>
          <th width="27%">NOMBRE</th>
          <th width="9%">U.M.</th>
          <th width="15%">CANT.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;

        foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
			

        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>" >
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="middle"   ><?php echo $c;?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><a target="_blank" href="../../principal.php?Mod=VentaConcretada&Form=Ver&Id=<?php echo ($DatVentaConcretadaDetalle->VcoId);?>"><?php echo ($DatVentaConcretadaDetalle->VcoId);?></a></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->VcoFecha);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatVentaConcretadaDetalle->VdiId);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->VcdBoleta);?> <?php echo ($DatVentaConcretadaDetalle->VcdFactura);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->ProCodigoOriginal);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
				
                <?php echo ($DatVentaConcretadaDetalle->ProNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; 
				
				
				
				
				<?php echo ($DatVentaConcretadaDetalle->UmeNombre);?>
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; 
				
				
				
				
				<?php echo number_format($DatVentaConcretadaDetalle->VcdCantidad,2);?>
                
                
                
                </td>
            </tr>
		<?php	
			
		?>
  
      
              
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
            </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
        </td>
         <td align="center">&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td align="center">&nbsp;</td>
       </tr>
       </tbody>
        </table>
        
             
      
        





</body>
</html>