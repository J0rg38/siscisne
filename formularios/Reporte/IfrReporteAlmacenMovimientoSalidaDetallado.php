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
	header("Content-Disposition:  filename=\"REPORTE_SALIDA_REPUESTOS_DETALLADO_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:date("d/m/Y");
$POST_ffin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

//$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"ProNombre";
//$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";

$POST_Moneda = ($_GET['Moneda']);
$POST_ProductoTipo = ($_GET['ProductoTipo']);
$POST_TipoSalida = ($_GET['TipoSalida']);
$POST_Sucursal = ($_GET['Sucursal']);



require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$InsReporteAlmacenMovimiento = new ClsReporteAlmacenMovimiento();

//MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL,$oFichaAccion=NULL,$oSucursal=NULL)
$ResTallerPedidoDetalle = $InsReporteAlmacenMovimiento->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,$POST_ProductoTipo,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,$POST_Sucursal);
$ArrTallerPedidoDetalles = $ResTallerPedidoDetalle['Datos'];


//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL)
$ResVentaConcretadaDetalle = $InsReporteAlmacenMovimiento->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,NULL,$POST_ProductoTipo,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Sucursal);
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
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE SALIDAS DE REPUESTOS DETALLADO DEL
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
          <th width="11%">SUCURSAL</th>
          <th width="6%">NUM. FICHA</th>
          <th width="7%">FECHA</th>
          <th width="7%">ORDEN</th>
          <th width="10%">OPERACION</th>
          <th width="10%">COMPROB. VENTA.</th>
          <th width="6%">TIPO PRODUCTO</th>
          <th width="6%">COD. ORIG.</th>
          <th width="23%">NOMBRE</th>
          <th width="9%">U.M.</th>
          <th width="9%">COSTO</th>
          <th width="9%">CANT.</th>
          <th width="9%">PRECIO</th>
          <th width="9%">IMPORTE</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;
?>

<?php
        foreach($ArrTallerPedidoDetalles as $DatTallerPedidoDetalle){
			

        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>" >
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="middle"   ><?php echo $c;?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatTallerPedidoDetalle->SucNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatTallerPedidoDetalle->AmoId);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatTallerPedidoDetalle->AmoFecha);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatTallerPedidoDetalle->FinId);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
                

                
               
                  
                <?php
				if(empty($DatTallerPedidoDetalle->TopNombre)){
				?>
                 ORDEN DE TRABAJO       
                <?php	
				}else{
				?>
                	<?php echo $DatTallerPedidoDetalle->TopNombre;?>
				<?php
				}
				?>
                
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
                
              
                <?php echo ($DatTallerPedidoDetalle->AmdBoleta);?>
                <?php echo ($DatTallerPedidoDetalle->AmdFactura);?>
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatTallerPedidoDetalle->RtiNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatTallerPedidoDetalle->ProCodigoOriginal);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
				
                <?php echo ($DatTallerPedidoDetalle->ProNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; 
				
				
				
				
				<?php echo ($DatTallerPedidoDetalle->UmeNombre);?>
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo number_format($DatTallerPedidoDetalle->ProCosto,2);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   > <?php echo number_format($DatTallerPedidoDetalle->AmdCantidad,2);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo number_format($DatTallerPedidoDetalle->AmdPrecioVenta,2);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo number_format($DatTallerPedidoDetalle->AmdImporte,2);?></td>
            </tr>
		<?php		
		
		 $c++;
		}
		?>
  
      
             
               <?php

		

        foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
			

        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>" >
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="middle"   ><?php echo $c;?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->SucNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->VcoId);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->VcoFecha);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatVentaConcretadaDetalle->VdiId);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
                
				<?php
				if(!empty($DatVentaConcretadaDetalle->VdiTipo)){
				?>
                	<?php echo $DatVentaConcretadaDetalle->VdiTipo;?>
                <?php
				}elseif(!empty($DatVentaConcretadaDetalle->TopNombre)){
				?>
                	<?php echo $DatVentaConcretadaDetalle->TopNombre;?>
                <?php	
				}else{
				?>
                	 VENTA X MOSTRADOR  
				<?php
				}
				?>
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->VcdBoleta);?> <?php echo ($DatVentaConcretadaDetalle->VcdFactura);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->RtiNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatVentaConcretadaDetalle->ProCodigoOriginal);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
				
                <?php echo ($DatVentaConcretadaDetalle->ProNombre);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >&nbsp; 
				
				
				
				
				<?php echo ($DatVentaConcretadaDetalle->UmeNombre);?>
                
                
                </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   >
                
                <?php echo number_format($DatVentaConcretadaDetalle->ProCosto,2);?>
                
                
               </td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo number_format($DatVentaConcretadaDetalle->VcdCantidad,2);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo number_format($DatVentaConcretadaDetalle->VcdPrecioVenta,2);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo number_format($DatVentaConcretadaDetalle->VcdImporte,2);?></td>
            </tr>
            
            
		<?php	
			 $c++;
		}
		?>
  
  
  
  
   
        <?php
		
       
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