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
	header("Content-Disposition:  filename=\"REPORTE_STOCK_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"ProNombre";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"ASC";


$POST_ProductoTipo = $_GET['ProductoTipo'];
$POST_VehiculoMarca = $_GET['VehiculoMarca'];
$POST_ProductoCategoria = $_GET['ProductoCategoria'];
$POST_Sucursal = $_GET['Sucursal'];
$POST_Ano = date("Y");

//deb($_GET);
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();
$InsAlmacenStock = new ClsAlmacenStock();

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();

//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno) 
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,$POST_ord,$POST_sen,1,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ProductoTipo,$POST_VehiculoMarca,NULL,NULL,$POST_ProductoCategoria,NULL,false,$POST_Sucursal,$POST_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

//$POST_ProductoTipo
//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaFin=NULL,$oFechaFin=NULL)
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE STOCK DE PRODUCTOS 
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
          <th width="10%">CODIGO</th>
          <th width="27%">NOMBRE</th>
          <th width="11%">U.M.</th>
          <th width="11%">CLASIFICACION</th>
          <th width="6%">TIPO</th>
          <th width="6%">MARCA</th>
          <th width="8%">COSTO</th>
          <th width="9%">STOCK</th>
          <th width="10%">COSTO TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
		<?php
        $c=1;
		$SumaCostoTotal = 0;
		$CantidadTotal = 0;
        foreach($ArrAlmacenStocks as $DatAlmacenStock){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		  <!-- <a target="_blank" href="../../principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatAlmacenStock->ProId;  ?>">-->
		   <?php echo $DatAlmacenStock->ProCodigoOriginal;?>
           
          <!-- </a>-->
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenStock->ProNombre;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenStock->UmeNombre;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenStock->PcaNombre; ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenStock->RtiNombre; ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatAlmacenStock->VmaNombre; ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php echo number_format($DatAlmacenStock->AstCostoCalculado,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >

		  <?php //echo number_format($DatAlmacenStock->AstStockReal,2);?>
          <?php echo number_format($DatAlmacenStock->AstStockCalculadoReal,2);?>

          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          <?php
			//$CostoTotal = $DatAlmacenStock->AstCostoCalculado * $DatAlmacenStock->AstStockReal;
			$CostoTotal = 0;
			$CostoTotal = $DatAlmacenStock->AstCostoCalculado * $DatAlmacenStock->AstStockCalculadoReal;
			
		  ?>
          <?php
		  echo number_format($CostoTotal,2);
		  ?>
          </td>
          </tr>
        <?php	
			
			$SumaCostoTotal += $CostoTotal;
			$CantidadTotal +=  $DatAlmacenStock->AstStockCalculadoReal;
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
            <td align="right">TOTAL</td>
            <td align="right">
            
            <?php
           echo number_format($CantidadTotal,2);
			?></td>
            <td align="right"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
              <?php
		  echo number_format($SumaCostoTotal,2);
		  ?>
            </span></td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>