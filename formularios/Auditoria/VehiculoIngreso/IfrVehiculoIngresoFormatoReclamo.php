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
	header("Content-Disposition:  filename=\"CONSULTA_PRODUCTO_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();

//MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinRecepcionFecha",$oFechaInicio=NULL,$oFechaFin=NULL) {
$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,'EinRecepcionFecha','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"EinRecepcionFecha",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

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
            <th align="center">VIN</th>
            <th align="center">MODELO</th>
            <th align="center">COLOR</th>
            <th align="center">ZONA COMPROMETIA</th>
            <th align="center">REPUESTO DETALLE</th>
            <th align="center">FECHA DE RECEPCION</th>
            <th align="center">NRO. GUIA</th>
            <th align="center">¿REGISTRO EN GUIA?</th>
            <th align="center">SOLUCION</th>
            <th align="center">OBSERVACIONES</th>
            <th align="center">FOTOS</th>
          </tr>
          
        </thead>

        <tbody class="EstTablaReporteBody">
        	<?php
			$i = 1;
			if(!empty($ArrVehiculoIngresos)){
				foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
			?>
          <tr>
            <td width="2%" align="right"><?php echo $i;?></td>
            <td width="3%" align="center"><?php echo $DatVehiculoIngreso->EinVIN;?></td>
            <td width="7%" align="center"><?php echo $DatVehiculoIngreso->VmoNombre;?></td>
            <td width="7%" align="center"><?php echo $DatVehiculoIngreso->EinColor;?></td>
            <td width="24%" align="center"><?php echo $DatVehiculoIngreso->EinRecepcionZonaComprometida;?>
            
            
            
            </td>
            <td width="8%" align="right"><?php echo $DatVehiculoIngreso->EinRecepcionRepuestoDetalle;?></td>
            <td width="9%" align="right"><?php echo $DatVehiculoIngreso->EinRecepcionFecha;?></td>
            <td width="5%" align="right"><?php echo $DatVehiculoIngreso->EinGuiaRemision;?></td>
            <td width="9%" align="right">-</td>
            <td width="8%" align="right"><?php echo $DatVehiculoIngreso->EinRecepcionSolucion;?></td>
            <td width="13%" align="right"><?php echo $DatVehiculoIngreso->EinRecepcionObservacion;?></td>
            <td width="5%" align="right">

<?php
$InsVehiculoIngresoFoto = new ClsVehiculoIngresoFoto();
$ResVehiculoIngresoFoto = $InsVehiculoIngresoFoto->MtdObtenerVehiculoIngresoFotos(NULL,NULL,'VifId','ASC',NULL,$DatVehiculoIngreso->EinId);
$ArrVehiculoIngresoFotos = $ResVehiculoIngresoFoto['Datos'];

?>

<?php
if(!empty($ArrVehiculoIngresoFotos)){
?>

		<?php
			foreach($ArrVehiculoIngresoFotos as $DatVehiculoIngresoFoto){
		?>
        	<div  style="display:table-cell">
        	<img src="../../subidos/vehiculo_ingreso_archivos/<?php echo $DatVehiculoIngresoFoto->VifArchivo?>" width="50" height="50">
        	</div>
        <?php	
			}
		?>
<?php
}else{
?>
No hay fotos
<?php	
}
?>
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