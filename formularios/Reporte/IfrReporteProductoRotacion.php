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
	header("Content-Disposition:  filename=\"REPORTE_PRODUCTO_ROTACION_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01".date("/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"RprStock";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";
$POST_Ano = isset($_POST['CmpAno'])?$_POST['CmpAno']:date("Y");

$POST_Sucursal = $_POST['CmpSucursal'];

list($Dia,$Mes,$Ano) = explode("/",$POST_finicio);

$POST_Ano = $Ano;

//deb($_POST);

require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsReporteProducto = new ClsReporteProducto();
$InsAlmacenStock = new ClsAlmacenStock();

//MtdObtenerReporteProductoVentasPromedio($oProductoId,$oFecha=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oDiasAtras=365,$oSucursal=NULL,$oAno)
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentasPromedio(NULL,NULL,$POST_ord,$POST_sen,NULL,NULL,365,$POST_Sucursal,$POST_Ano);
$ArrReporteProductos = $ResReporteProducto['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ROTACION DE PRODUCTOS 
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
          <th width="8%">COD. ORIGINAL</th>
          <th width="20%">NOMBRE</th>
          <th width="7%">MARCA</th>
          <th width="20%">REF.</th>
          <th width="6%">UND. MED.</th>
          <th width="10%">TIPO</th>
          <th width="9%">PROM. MENSUAL (ULT. 365 DIAS)</th>
          <th width="9%">INVENTARIO</th>
          <th width="9%">VENTAS</th>
          <th width="9%">ROTACION</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
		<?php
        $c=1;

        foreach($ArrReporteProductos as $DatReporteProducto){
			

			$InsAlmacenStock = new ClsAlmacenStock();
			//MtdObtenerAlmacenStockProductoStock($oSucursal=NULL,$oAlmacen=NULL,$oAno,$oProductoId)
			$ProductoStock = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStock($POST_Sucursal,NULL,$POST_Ano,$DatReporteProducto->ProId,false);
			
			$TotalVentas = $InsReporteProducto->MtdObtenerReporteProductoVentasMensual($DatReporteProducto->ProId,$POST_Ano,NULL,$POST_VehiculoMarca,$POST_Sucursal);
			
			$RotacionInventario = 0;
			
			if($ProductoStock>0){
	
				$RotacionInventario = $TotalVentas/$ProductoStock;
				$RotacionInventario = round($RotacionInventario ,2);
				
			}
			
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		<?php echo $DatReporteProducto->ProCodigoOriginal;?>
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteProducto->ProNombre;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteProducto->ProMarca;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteProducto->ProReferencia;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php echo $DatReporteProducto->UmeAbreviacion;?>
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteProducto->RtiNombre; ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo round($DatReporteProducto->RprPromedioMensual,2); ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php echo round($ProductoStock,2); ?><!-- /   <?php echo round($DatReporteProducto->RprStock,2); ?>-->
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo round($TotalVentas,2); ?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo round($RotacionInventario,2); ?>
          
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>