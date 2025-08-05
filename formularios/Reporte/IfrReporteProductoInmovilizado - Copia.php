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
	header("Content-Disposition:  filename=\"REPORTE_PRODUCTO_INMOVILIZADO_".date('d-m-Y').".xls\";");
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

//$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"AmoUltimaSalidaDiaTranscurridos";
$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"AmoUltimaSalidaDiaTranscurridos";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";


$POST_ProductoTipo = ($_POST['CmpProductoTipo']);
$POST_ConStock = ($_POST['CmpConStock']);
$POST_Clasificacion = ($_POST['CmpClasificacion']);

require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');


$InsReporteAlmacenMovimientoEntrada = new ClsReporteAlmacenMovimientoEntrada();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();


//MtdObtenerReporteAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmoFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oConStock=NULL,$oClienteClasificacion=NULL) 
$ResReporteAlmacenMovimientoEntrada = $InsReporteAlmacenMovimientoEntrada->MtdObtenerReporteAlmacenMovimientoEntradas(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ProductoTipo,$POST_ConStock,$POST_Clasificacion);
$ArrReporteAlmacenMovimientoEntradas = $ResReporteAlmacenMovimientoEntrada['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE INMOVILIZADOS DEL
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
          <th width="2%" rowspan="3">#</th>
          <th width="5%" rowspan="3">COD. ORIG. PROD.</th>
          <th width="4%" rowspan="3">TIPO</th>
          <th width="9%" rowspan="3">NOMBRE PRODUCTO</th>
          <th width="13%" rowspan="3">REFERENCIA</th>
          <th width="4%" rowspan="3">U.M.</th>
          <th colspan="3">INGRESO</th>
          <th colspan="3">&nbsp;</th>
          <th width="5%" rowspan="3">PROM. VEN.</th>
          <th width="5%" rowspan="3">COSTO</th>
          <th width="5%" rowspan="3">SALDO</th>
          <th width="6%" rowspan="3">COSTO TOTAL</th>
          </tr>
        <tr>
          <th colspan="2">MOVIMIENTO</th>
          <th>COMPROBANTE </th>
          <th colspan="3">ULTIMO MOVIMIENTO</th>
          </tr>
        <tr>
          <th width="6%">FECHA</th>
          <th width="10%">CANT.</th>
          <th width="12%">NUMERO</th>
          <th width="5%">FECHA</th>
          <th width="5%">CANT.</th>
          <th width="9%">DIAS</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$SumaCostoTotal = 0;
        foreach($ArrReporteAlmacenMovimientoEntradas as $DatReporteAlmacenMovimientoEntrada){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          <a target="_blank" href="../../principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatReporteAlmacenMovimientoEntrada->ProId;?>">
		  <?php echo $DatReporteAlmacenMovimientoEntrada->ProCodigoOriginal;  ?>
          </a>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		  
		  <?php echo $DatReporteAlmacenMovimientoEntrada->RtiNombre;  ?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteAlmacenMovimientoEntrada->ProNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteAlmacenMovimientoEntrada->ProReferencia;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		<!--   <a target="_blank" href="../../principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatReporteAlmacenMovimientoEntrada->ProId;?>">--><!--  </a>-->
          <?php echo $DatReporteAlmacenMovimientoEntrada->UmeAbreviacion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		  
		<?php echo $DatReporteAlmacenMovimientoEntrada->AmoFecha;  ?>
                  
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		  
		  <?php echo number_format($DatReporteAlmacenMovimientoEntrada->AmoTotalIngreso,2);  ?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		  
           <a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatReporteAlmacenMovimientoEntrada->AmoId;?>">
		 
			 <?php echo $DatReporteAlmacenMovimientoEntrada->AmoComprobanteNumero;  ?>
         </a>    
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php
		  if(!empty($DatReporteAlmacenMovimientoEntrada->AmoFechaUltimaSalida)){
			  ?>
            <?php echo ($DatReporteAlmacenMovimientoEntrada->AmoFechaUltimaSalida);?>
            <?php
		  }else{
			?>
-
<?php  
		  }
		  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          
		  
		  <?php
		  if(!empty($DatReporteAlmacenMovimientoEntrada->AmoCantidadUltimaSalida)){
			  ?>
          <?php echo number_format($DatReporteAlmacenMovimientoEntrada->AmoCantidadUltimaSalida,2);?>              
              <?php
		  }else{
			?>
			-
			<?php  
		  }
		  ?>

          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
             <?php echo ($DatReporteAlmacenMovimientoEntrada->AmoUltimaSalidaDiaTranscurridos);?> dias
           <?php
                  /*if(!empty($DatReporteAlmacenMovimientoEntrada->AmoUltimaSalidaDiaTranscurridos)){
                      ?>
            <?php echo ($DatReporteAlmacenMovimientoEntrada->AmoUltimaSalidaDiaTranscurridos);?> dias
            <?php
                  }else{
                    ?>
            --
  <?php  
                  }*/
                  ?>
                  
		  <?php
		  /*if(!empty($DatReporteAlmacenMovimientoEntrada->AmoFechaUltimaSalida)){
			  ?>
            <?php
                  if(!empty($DatReporteAlmacenMovimientoEntrada->AmoUltimaSalidaDiaTranscurridos)){
                      ?>
            <?php echo ($DatReporteAlmacenMovimientoEntrada->AmoUltimaSalidaDiaTranscurridos);?> dias
            <?php
                  }else{
                    ?>
            -
  <?php  
                  }
                  ?>
  <?php
		  }else{
			?>
  <?php
                 //// if(!empty($DatReporteAlmacenMovimientoEntrada->AmoInicialDiaTranscurridos)){
                      ?>
  <?php echo ($DatReporteAlmacenMovimientoEntrada->AmoInicialDiaTranscurridos);?>_dias
  <?php
                 // }else{
                    ?>
            -
  <?php  
                  ///}
                  ?>
                  
  <?php  
		  }*/
		  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php
		//  deb($DatReporteAlmacenMovimientoEntrada->AmoPromedioVenta);
		  
		  ?>
		  <?php  echo number_format( ($DatReporteAlmacenMovimientoEntrada->AmoPromedioVentaMensual),2)?>
          



          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          <?php  echo number_format($DatReporteAlmacenMovimientoEntrada->AmdCostoCalculado,2)?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatReporteAlmacenMovimientoEntrada->AmoTotalSaldo,2);  ?>
            <?php //echo ($DatReporteAlmacenMovimientoEntrada->AmoTotalSaldo);  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          <?php
		  $CostoTotal = 0;
		  $CostoTotal = ($DatReporteAlmacenMovimientoEntrada->AmdCostoCalculado * $DatReporteAlmacenMovimientoEntrada->AmoTotalSaldo);
		  
		  $SumaCostoTotal += $CostoTotal;
		  ?>
          
          <?PHP echo number_format($CostoTotal,2);?>
          </td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="14" align="right">SUMA TOTAL:</td>
            <td align="right">
            
               <?PHP echo number_format($SumaCostoTotal,2);?>
            </td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>