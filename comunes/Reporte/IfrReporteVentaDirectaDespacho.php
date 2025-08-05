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
	header("Content-Disposition:  filename=\"REPORTE_VENTA_DIRECTA_DESPACHO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 



<script type="text/javascript" src="js/JsReporteVentaDirectaDespacho.js"></script>
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
//$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

//$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno";
$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"OcoId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

//$POST_ConOrdenCompra = isset($_POST['CmpConOrdenCompra'])?$_POST['CmpConOrdenCompra']:1;
//$POST_OrdenCompraId = $_POST['CmpOrdenCompraId'];
//$POST_Seleccionados = $_POST['CmpSeleccionados'];

//deb($_POST);
$ArrSeleccionados = explode("#",$POST_Seleccionados);
$ArrSeleccionados = array_filter($ArrSeleccionados);

//deb($POST_AgregarSeleccionado);

require_once($InsPoo->MtdPaqReporte().'ClsReporteVentaDirectaDespacho.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsReporteVentaDirectaDespacho = new ClsReporteVentaDirectaDespacho();
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

//MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RvdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL)


//deb($POST_ClienteId);

																								//($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFecha=NULL,$oCliente=NULL) {
$ResReporteVentaDirectaDespacho = $InsReporteVentaDirectaDespacho->MtdObtenerReporteVentaDirectaDespachos(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),$POST_ClienteId);
$ArrReporteVentaDirectaDespachos = $ResReporteVentaDirectaDespacho['Datos'];


deb($POST_finicio);


	
	
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ORDENES DE VENTA/DESPACHO    DEL

      <?php echo $POST_finicio; ?>
 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>

<?php
//deb($ArrSeleccionados);
?>

        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="3%">
<?php
if($_GET['P']<>2){
?>      
<input onClick="FncReporteVentaDirectaDespachoSeleccionarTodos();" type="checkbox" name="CmpAgregarSeleccionados" id="CmpAgregarSeleccionados"  value="1"  />
<?php
}
?>
</th>
          <th width="5%">ORD. VEN.</th>
          <th width="6%">ORD. VEN. FECHA</th>
          <th width="8%" align="center">ORDEN GM.</th>
          <th width="31%" align="center">CLIENTE</th>
          <th width="4%">REF.</th>
          <th width="6%">REF. FECHA</th>
          <th width="9%">COD. ORIGINAL</th>
          <th width="17%">PRODUCTO</th>
          <th width="9%" align="center">DESPACHO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteVentaDirectaDespachos as $DatReporteVentaDirectaDespacho){
        ?>
        
        	<?php
			if( (!empty($ArrSeleccionados) and in_array($DatReporteVentaDirectaDespacho->RvdId,$ArrSeleccionados)) or empty($ArrSeleccionados)){
			?>
            
        
                <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
<?php
if($_GET['P']<>2){
?>
    

<input <?php echo (in_array($DatReporteVentaDirectaDespacho->RvdId,$ArrSeleccionados)?'checked':'')?> onClick="FncReporteVentaDirectaDespachoSeleccionar();" type="checkbox" name="CmpAgregarSeleccionado[]" id="CmpAgregarSeleccionado_<?php echo $c;?>"  value="<?php echo $DatReporteVentaDirectaDespacho->RvdId; ?>"  />
<?php
}
?>
                </td>
                <td  align="right" valign="top"   >

				<a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=Ver&Id=<?php echo ($DatReporteVentaDirectaDespacho->VdiId);?>">
				<?php echo ($DatReporteVentaDirectaDespacho->VdiId);?>
                </a>

                </td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteVentaDirectaDespacho->VdiFecha);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVentaDirectaDespacho->OcoId);?></td>
                <td align="right" valign="top"  >&nbsp;<?php echo ($DatReporteVentaDirectaDespacho->CliNombre);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteVentaDirectaDespacho->VdiOrdenCompraNumero);?></td>
                <td  align="right" valign="top"   >
                
               
               
                <?php echo ($DatReporteVentaDirectaDespacho->VdiOrdenCompraFecha);?>
               
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteVentaDirectaDespacho->ProCodigoOriginal);?></td>
<td  align="right" valign="top"   ><?php echo ($DatReporteVentaDirectaDespacho->ProNombre);?></td>
                <td align="right" valign="top"   >&nbsp;<?php echo ($DatReporteVentaDirectaDespacho->RvdDespacho);?>
                
               
                </td>
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
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>