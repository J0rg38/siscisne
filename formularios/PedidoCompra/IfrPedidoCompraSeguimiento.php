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
	header("Content-Disposition:  filename=\"SEGUIMIENTO_PEDIDO_CLIENTE_".date('d-m-Y').".xls\";");
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

$POST_ConFichaIngreso = isset($_POST['CmpConFichaIngreso'])?$_POST['CmpConFichaIngreso']:"1";

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

$InsPedidoCompra = new ClsPedidoCompra();
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();

if($POST_ConFichaIngreso == "1"){
	$POST_ConFichaIngreso = true;
}else{
	$POST_ConFichaIngreso = false;	
}
											//    public function MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false) 
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,"PcdTiempoCreacion","DESC",NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,$POST_Cliente,NULL,NULL,NULL,"PcoFecha",false,$POST_ConFichaIngreso);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">SEGUIMIENTO DE PEDIDOS DE CLENTE</span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">

        <thead class="EstTablaReporteHead">
        <tr>
          <th rowspan="2" align="center">#</th>
          <th rowspan="2" align="center">PED. COMP.</th>
          <th rowspan="2" align="center">ORD. TRAB.</th>
          <th rowspan="2" align="center">ORD. TRAB. FECHA</th>
          <th rowspan="2" align="center">CLIENTE</th>
          <th rowspan="2" align="center">ORD. COMP.</th>
          <th rowspan="2" align="center">FECHA ORD. COMP.</th>
          <th rowspan="2" align="center">FECHA ESTIMADA LLEGADA</th>
          <th colspan="2" align="center">BACK ORDER</th>
          <th colspan="2" align="center">DESPACHO</th>
          <th align="center">&nbsp;</th>
        </tr>
        <tr>
            <th align="center">FECHA </th>
            <th align="center">STATUS</th>
            <th width="7%" align="center">FECHA</th>
            <th width="8%" align="center">CANT.</th>
            <th align="center">&nbsp;</th>
          </tr>
          
        </thead>

        <tbody class="EstTablaReporteBody">
        	<?php
			$i = 1;
			if(!empty($ArrPedidoCompraDetalles)){
				foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
			?>
          <tr>
            <td width="2%" align="right"><?php echo $i;?></td>
            <td width="6%" align="center"><?php echo $DatPedidoCompraDetalle->PcoId;?></td>
            <td width="5%" align="center"><?php echo $DatPedidoCompraDetalle->FinId;?></td>
            <td width="6%" align="center"><?php echo $DatPedidoCompraDetalle->FinFecha;?></td>
            <td width="21%" align="center"><?php echo $DatPedidoCompraDetalle->CliNombre;?> <?php echo $DatPedidoCompraDetalle->CliApellidoPaterno;?> <?php echo $DatPedidoCompraDetalle->CliApellidoMaterno;?></td>
            <td width="13%" align="right"><?php echo $DatPedidoCompraDetalle->OcoId;?></td>
            <td width="8%" align="right"><?php echo $DatPedidoCompraDetalle->OcoFecha;?></td>
            <td width="10%" align="right"><?php echo $DatPedidoCompraDetalle->OcoFechaLlegadaEstimada;?></td>
            <td width="6%" align="right">
            
            <?php echo $DatPedidoCompraDetalle->PcdBOFecha;?>

            </td>
            <td width="7%" align="right"><?php echo $DatPedidoCompraDetalle->PcdBOEstado;?></td>
            <td align="right"><?php echo $DatPedidoCompraDetalle->PleFecha;?></td>
            <td align="right"><?php echo number_format($DatPedidoCompraDetalle->PldCantidad,2);?></td>
            <td width="1%" align="right">&nbsp;</td>
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
            <td colspan="2" align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
        
        
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>