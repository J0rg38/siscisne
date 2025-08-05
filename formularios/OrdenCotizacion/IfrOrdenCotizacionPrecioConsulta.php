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
	header("Content-Disposition:  filename=\"CONSULTA_PRECIO_COTIZADO_".date('d-m-Y').".xls\";");
}


$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
$POST_ProductoId = ($_POST['CmpProductoId']);
$POST_Moneda = ($_POST['CmpMoneda']);

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacionDetalle.php');

$InsOrdenCotizacionDetalle = new ClsOrdenCotizacionDetalle();
//MtdObtenerOrdenCotizacionDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenCotizacion=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oProveedor=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oOrdenCotizacionEstado=NULL,$oFecha="OotFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oProductoId=NULL)
$ResOrdenCotizacionDetalle = $InsOrdenCotizacionDetalle->MtdObtenerOrdenCotizacionDetalles(NULL,NULL,'OodId','Desc',NULL,NULL,3,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,"OotFecha",false,false,$POST_ProductoId);
$ArrOrdenCotizacionDetalles = $ResOrdenCotizacionDetalle['Datos'];



?>


<html>
<head>
<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php }?>
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
//
//$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
//$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
//
//require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacion.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacionDetalle.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacionDetalleFoto.php');
//
//$InsOrdenCotizacionDetalle = new ClsOrdenCotizacionDetalle();
//
////MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinRecepcionFecha",$oFechaInicio=NULL,$oFechaFin=NULL) {
///*$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,'EinRecepcionFecha','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"EinRecepcionFecha",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
//$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];*/
//
//
////MtdObtenerOrdenCotizacionDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oOrdenCotizacion=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)}}}}
//
//$ResOrdenCotizacionDetalle = $InsOrdenCotizacionDetalle->MtdObtenerOrdenCotizacionDetalles(NULL,NULL,NULL,'OodId','Desc',NULL,3,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
//$ArrOrdenCotizacionDetalles = $ResOrdenCotizacionDetalle['Datos'];


?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CONSULTA DE PRODUCTO


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
            <th align="center">#</th>
            <th align="center">COTIZACION</th>
            <th align="center">FECHA</th>
            <th align="center">FECHA RPTA.</th>
            <th align="center">CODIGO</th>
            <th align="center">NOMBRE</th>
            <th align="center">AÑO</th>
            <th align="center">MODELO</th>
            <th align="center">PRECIO</th>
          </tr>
          
        </thead>

        <tbody class="EstTablaReporteBody">
        	<?php
			$i = 1;
			if(!empty($ArrOrdenCotizacionDetalles)){
				foreach($ArrOrdenCotizacionDetalles as $DatOrdenCotizacionDetalle){
			?>
          <tr>
            <td width="2%" align="right"><?php echo $i;?></td>
            <td width="10%" align="right"><?php echo $DatOrdenCotizacionDetalle->OotId;?></td>
            <td width="5%" align="right"><?php echo $DatOrdenCotizacionDetalle->OotFecha;?></td>
            <td width="12%" align="right"><?php echo $DatOrdenCotizacionDetalle->OotFechaRespuesta;?></td>
            <td width="7%" align="right"><?php echo $DatOrdenCotizacionDetalle->ProCodigoOriginal;?></td>
            <td width="26%" align="right"><?php echo $DatOrdenCotizacionDetalle->ProNombre;?></td>
            <td width="9%" align="right"><?php echo $DatOrdenCotizacionDetalle->OodAno;?></td>
            <td width="14%" align="right"><?php echo $DatOrdenCotizacionDetalle->OodModelo;?></td>
            <td width="15%" align="right">
			
			<?php $DatOrdenCotizacionDetalle->OodPrecio = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatOrdenCotizacionDetalle->OodPrecio:($DatOrdenCotizacionDetalle->OodPrecio/$DatOrdenCotizacionDetalle->OotTipoCambio));?>
                   
                   
				<?php echo number_format($DatOrdenCotizacionDetalle->OodPrecio,2);?>
				
			
            
            
            </td>
          </tr>
          
          <?php
		  			$i++;
				}
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





</body>
</html>