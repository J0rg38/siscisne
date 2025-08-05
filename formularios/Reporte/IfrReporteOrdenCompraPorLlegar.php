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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_COMPRA_POR_LLEGAR_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 



<script type="text/javascript" src="js/JsReporteOrdenCompraPorLlegar.js"></script>
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

//$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno";
$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"OcoId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

//$POST_ConOrdenCompra = isset($_POST['CmpConOrdenCompra'])?$_POST['CmpConOrdenCompra']:1;
$POST_OrdenCompraId = $_POST['CmpOrdenCompraId'];
$POST_Seleccionados = $_POST['CmpSeleccionados'];

//deb($_POST);
$ArrSeleccionados = explode("#",$POST_Seleccionados);
$ArrSeleccionados = array_filter($ArrSeleccionados);

//deb($POST_AgregarSeleccionado);

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompraPorLlegar.php');

$InsReporteOrdenCompraPorLlegar = new ClsReporteOrdenCompraPorLlegar();
$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();
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

//MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL)


//deb($POST_ClienteId);

																			//MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oPedidoCompraDetalle=NULL,$oPedidoCompra//LlegadaEstado =NULL) {
//$ResPedidoCompraLlegadaDetalle = $InsPedidoCompraLlegadaDetalle->MtdObtenerPedidoCompraLlegadaDetalles(NULL,NULL,"PcdTiempoCreacion DESC, ".$POST_ord,$POST_sen,1,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_OrdenCompraId,$POST_ClienteId,1);
//$ArrPedidoCompraLlegadaDetalles = $ResPedidoCompraLlegadaDetalle['Datos'];

$ResReporteOrdenCompraPorLlegar = $InsReporteOrdenCompraPorLlegar->MtdObtenerOrdenCompraPorLLegar(NULL,NULL,"PcdTiempoCreacion DESC, ".$POST_ord,$POST_sen,1,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_OrdenCompraId,$POST_ClienteId,1);
$ArrReporteOrdenCompraPorLlegar = $ResReporteOrdenCompraPorLlegar['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ORDENES DE COMPRA POR LLEGAR   DEL
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
<input onClick="FncReporteOrdenCompraPorLlegarSeleccionarTodos();" type="checkbox" name="CmpAgregarSeleccionados" id="CmpAgregarSeleccionados"  value="1"  />
<?php
}
?>
</th>
          <th width="5%">COD. MOV.</th>
          <th width="8%">FEC. DESPACHO</th>
          <th width="8%">ORD. COMPRA</th>
          <th width="9%">FACT. </th>
          <th width="9%">GUIA REM.</th>
          <th width="9%">COD. ORIG.</th>
          <th width="5%">COD. REEMP.</th>
          <th width="5%">CANT.</th>
          <th width="18%">NOMBRE</th>
          <th width="4%" align="center">A&Ntilde;O</th>
          <th width="8%" align="center">MODELO</th>
          <th width="28%" align="center">CLIENTE</th>
          <th width="5%" align="center">ORD .VEN.</th>
          <th width="5%" align="center">REF.</th>
          <th width="5%" align="center">OBS. GM</th>
          <th width="5%" align="center">ESTADO O.V.</th>
          <th width="5%" align="center">RESPONSABLE</th>
          <th width="5%" align="center">CONF.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteOrdenCompraPorLlegar as $DatReporteOrdenCompraPorLlegar){
        ?>
        
        	<?php
			if( (!empty($ArrSeleccionados) and in_array($DatReporteOrdenCompraPorLlegar->PldId,$ArrSeleccionados)) or empty($ArrSeleccionados)){
			?>
            
        
                <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
<?php
if($_GET['P']<>2){
?>
    

<input <?php echo (in_array($DatReporteOrdenCompraPorLlegar->PldId,$ArrSeleccionados)?'checked':'')?> onClick="FncReporteOrdenCompraPorLlegarSeleccionar();" type="checkbox" name="CmpAgregarSeleccionado[]" id="CmpAgregarSeleccionado_<?php echo $c;?>"  value="<?php echo $DatReporteOrdenCompraPorLlegar->PldId; ?>"  />
<?php
}
?>
                </td>
                <td  align="right" valign="top"   >

				<a href="../../principal.php?Mod=PedidoCompraLlegada&Form=Ver&Id=<?php echo ($DatReporteOrdenCompraPorLlegar->PleId);?>">
				<?php echo ($DatReporteOrdenCompraPorLlegar->PldId);?>
                </a>

                </td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteOrdenCompraPorLlegar->PleFecha);?></td>
                <td  align="right" valign="top"   >
				
                <?php
				if(empty($DatReporteOrdenCompraPorLlegar->PcdId)){
				?>
                	<?php echo ($DatReporteOrdenCompraPorLlegar->PcdOrdenCompraId);?>
                <?php	
				}else{
				?>
               	 	<a target="_blank" href="../../principal.php?Mod=OrdenCompra&Form=Ver&Id=<?php echo ($DatReporteOrdenCompraPorLlegar->OcoId);?>">
					<?php echo ($DatReporteOrdenCompraPorLlegar->OcoId);?></a>
                <?php	
				}				
				?>
                
				
                
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteOrdenCompraPorLlegar->PldComprobanteNumero);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteOrdenCompraPorLlegar->PldGuiaRemisionNumero);?></td>
                <td  align="right" valign="top"   >
                
               
               
                <?php echo ($DatReporteOrdenCompraPorLlegar->ProCodigoOriginal);?>
               
                </td>
                <td  align="right" valign="top"   >
				
                <?php
				if($DatReporteOrdenCompraPorLlegar->PldReemplazo == "Si"){
				?>
                <?php echo ($DatReporteOrdenCompraPorLlegar->ProCodigoReemplazado);?>
                <?php
				}
				?>
				<?php
				
				//echo $DatReporteOrdenCompraPorLlegar->PldReemplazo
				?>&nbsp;
				
                
                
                </td>
<td  align="right" valign="top"   >
				
				<?php echo number_format($DatReporteOrdenCompraPorLlegar->PldCantidad,2);?>
                
                </td>
                <td  align="right" valign="top"   >
                <?php echo ($DatReporteOrdenCompraPorLlegar->ProNombre);?>
                </td>
                                
                
                <td align="right" valign="top"  >&nbsp;<?php echo ($DatReporteOrdenCompraPorLlegar->PcdAno);?></td>
                <td align="right" valign="top"   >&nbsp;<?php echo ($DatReporteOrdenCompraPorLlegar->PcdModelo);?>
                
               
                </td>
                <td align="right" valign="top"  ><?php echo ($DatReporteOrdenCompraPorLlegar->CliNombre);?> <?php echo ($DatReporteOrdenCompraPorLlegar->CliApellidoPaterno);?> <?php echo ($DatReporteOrdenCompraPorLlegar->CliApellidoMaterno);?></td>
                <td align="right" valign="top"  >
                <?php echo ($DatReporteOrdenCompraPorLlegar->VdiId);?> &nbsp;
                
                </td>
                <td align="right" valign="top"  ><?php echo ($DatReporteOrdenCompraPorLlegar->VdiOrdenCompraNumero);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteOrdenCompraPorLlegar->PldObservacion);?></td>
                <td align="right" valign="top"  ><?php
switch($DatReporteOrdenCompraPorLlegar->VddEstado){
	case 1:
?>
                  CONSIDERAR
                  <?php
	break;
	
	case 2:
?>
                  ANULADO
  <?php
	break;


	case 3:
?>
                  INTERNO
  <?php
	break;
	
	
	case 4:
?>
                  DEVOLUCION
  <?php
	break;
	
	case 5:
?>
                  DAÑADO
  <?php
	break;
	
	default:
?>
                  -
  <?php
	break;
}
?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteOrdenCompraPorLlegar->PerNombre);?> <?php echo ($DatReporteOrdenCompraPorLlegar->PerApellidoPaterno);?> <?php echo ($DatReporteOrdenCompraPorLlegar->PerApellidoMaterno);?></td>
                <td align="right" valign="top"  >&nbsp;</td>
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