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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_COMPRA_LLEGADA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 



<script type="text/javascript" src="js/JsReporteOrdenCompraLlegada.js"></script>
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

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_ConOrdenCompra = isset($_POST['CmpConOrdenCompra'])?$_POST['CmpConOrdenCompra']:1;
$POST_OrdenCompraId = $_POST['CmpOrdenCompraId'];
$POST_Seleccionados = $_POST['CmpSeleccionados'];

$ArrSeleccionados = explode("#",$POST_Seleccionados);
$ArrSeleccionados = array_filter($ArrSeleccionados);

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
$InsCliente = new ClsCliente();


if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}


if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}
//MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha")

$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,$POST_ord,$POST_sen,NULL,NULL,3,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_OrdenCompraId,$POST_ClienteId,NULL,NULL,NULL,"PcdBOTiempoCarga");
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE BACK ORDER DE ORDENES DE COMPRA  DEL
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
          <th width="5%">COD. PED.</th>
          <th width="8%">ORD. COMP.</th>
          <th width="6%">COD. ORIG.</th>
          <th width="16%">NOMBRE</th>
          <th width="6%">CANT.</th>
          <th width="4%" align="center">AÑO</th>
          <th width="8%" align="center">MODELO</th>
          <th width="20%" align="center">CLIENTE</th>
          <th width="5%" align="center">ORD. VEN.</th>
          <th width="4%" align="center">REF.</th>
          <th width="7%" align="center">STATUS</th>
          <th width="9%" align="center">FECHA LLEGADA APROX.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
        ?>	<?php
			if( (!empty($ArrSeleccionados) and in_array($DatPedidoCompraDetalle->PcdId,$ArrSeleccionados)) or empty($ArrSeleccionados)){
			?>
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
                  
  <a target="_blank" href="../../principal.php?Mod=PedidoCompra&Form=Ver&Id=<?php echo ($DatPedidoCompraDetalle->PcoId);?>"><?php echo ($DatPedidoCompraDetalle->PcoId);?></a>
                  
                  
                  
                </td>
                <td  align="right" valign="top"   >
				
				<a target="_blank" href="../../principal.php?Mod=OrdenCompra&Form=Ver&Id=<?php echo ($DatPedidoCompraDetalle->OcoId);?>">
				<?php echo ($DatPedidoCompraDetalle->OcoId);?></a></td>
                <td  align="right" valign="top"   >
                
               
               
                <?php echo ($DatPedidoCompraDetalle->ProCodigoOriginal);?>
               
                </td>
<td  align="right" valign="top"   >
  
  <?php echo ($DatPedidoCompraDetalle->ProNombre);?>
  
  
</td>
<td  align="right" valign="top"   ><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
<td align="right" valign="top"  >&nbsp;<?php echo ($DatPedidoCompraDetalle->PcdAno);?></td>
                <td align="right" valign="top"   >&nbsp;<?php echo ($DatPedidoCompraDetalle->PcdModelo);?>
                
               
                </td>
                <td align="right" valign="top"  ><?php echo ($DatPedidoCompraDetalle->CliNombre);?> <?php echo ($DatPedidoCompraDetalle->CliApellidoPaterno);?> <?php echo ($DatPedidoCompraDetalle->CliApellidoMaterno);?></td>
                <td align="right" valign="top"  >
				
				<a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=Ver&Id=<?php echo ($DatPedidoCompraDetalle->VdiId);?>">
				<?php echo ($DatPedidoCompraDetalle->VdiId);?>
                </a>
                &nbsp;</td>
                <td align="right" valign="top"  ><?php echo ($DatPedidoCompraDetalle->VdiOrdenCompraNumero);?>&nbsp;</td>
                <td align="right" valign="top"  ><?php echo ($DatPedidoCompraDetalle->PcdBOEstado);?></td>
                <td align="right" valign="top"  ><?php echo ($DatPedidoCompraDetalle->PcdBOFecha);?>&nbsp;</td>
                </tr>
         <?php	
		
        }
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