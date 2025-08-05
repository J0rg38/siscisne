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
	header("Content-Disposition:  filename=\"REPORTE_MOVIMIENTO_ENTRADA_DETALLE_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ProveedorId = $_POST['CmpProveedorId'];
$POST_ProveedorNombre = $_POST['CmpProveedorNombre'];
$POST_ProveedorNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"AmoComprobanteNumero";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"ASC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ConOrdenCompra = $_POST['CmpConOrdenCompra'];
//$POST_Cancelado = isset($_POST['CmpCancelado'])?$_POST['CmpCancelado']:2;
$POST_Cancelado = $_POST['CmpCancelado'];

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsMoneda = new ClsMoneda();
$InsProveedor = new ClsProveedor();

if(empty($POST_ProveedorId) and !empty($POST_ProveedorNombre)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedores("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ProveedorNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->CliId;
		}
	}
}

if(empty($POST_ProveedorId) and !empty($POST_ProveedorNumeroDocumento)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedores("CliNumeroDocumento","contiene",$POST_ProveedorNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->CliId;
		}
	}

}

//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0)
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",$POST_ConOrdenCompra,$POST_Cancelado,$POST_ProveedorId);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

//$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"".$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin,true),NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,$POST_Cancelado,$POST_ProveedorId);
//$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

//deb($POST_Moned//a);
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE MOVIMIENTOS ENTRADA DEL
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
          <th width="5%">COD. MOV.</th>
          <th width="6%">NRO. FACT. GM</th>
          <th width="6%">FECHA FACT.</th>
          <th width="14%">TIPO DE PEDIDO</th>
          <th width="6%">MON.</th>
          <th width="5%">TOTAL</th>
          <th width="18%">CLIENTE</th>
          <th width="38%">DETALLE</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$Total = 0;
        foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
        ?>
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
                  
  <a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo ($DatAlmacenMovimientoEntrada->AmoId);?>"><?php echo ($DatAlmacenMovimientoEntrada->AmoId);?></a>
                  
                  
                  
                </td>
                <td  align="right" valign="top"   >

				<?php echo ($DatAlmacenMovimientoEntrada->AmoComprobanteNumero);?>
                
                </td>
                <td  align="right" valign="top"   >
				
				<?php echo ($DatAlmacenMovimientoEntrada->AmoComprobanteFecha);?>
                
                </td>
                <td  align="right" valign="top"   >
                
                 <a target="_blank" href="../../principal.php?Mod=OrdenCompra&Form=VerEstado&Id=<?php echo $DatAlmacenMovimientoEntrada->OcoId; ?>">
                 
                <?php echo ($DatAlmacenMovimientoEntrada->OcoId);?>
                </a>
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatAlmacenMovimientoEntrada->MonSimbolo);?></td>
                <td  align="right" valign="top"   >
				
                   <?php $DatAlmacenMovimientoEntrada->AmoTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatAlmacenMovimientoEntrada->AmoTotal:($DatAlmacenMovimientoEntrada->AmoTotal/$DatAlmacenMovimientoEntrada->AmoTipoCambio));?>
                   
                   
				<?php echo number_format($DatAlmacenMovimientoEntrada->AmoTotal,2);?></td>
                <td  align="right" valign="top"   >
				
				
				<?php
                $ClienteIdAnterior  = "";
				
                $InsOrdenCompra = new ClsOrdenCompra();
                $InsOrdenCompra->OcoId = $DatAlmacenMovimientoEntrada->OcoId;
                $InsOrdenCompra->MtdObtenerOrdenCompra();
				
				//deb($InsOrdenCompra->OrdenCompraPedido);
                if(!empty($InsOrdenCompra->OrdenCompraPedido)){
                    foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
				?>
                  <?php
					
					//deb($DatOrdenCompraPedido->CliId." - ".$ClienteIdAnterior);
					if($DatOrdenCompraPedido->CliId<>$ClienteIdAnterior){
					?>
                  <?php echo $DatOrdenCompraPedido->CliNombre;?> <?php echo $DatOrdenCompraPedido->CliApellidoPaterno;?> <?php echo $DatOrdenCompraPedido->CliApellidoMaterno;?><br>
                  <?php	
					}
					?>
                  <?php
					$ClienteIdAnterior = $DatOrdenCompraPedido->CliId;
                
                    }
					
                }
                    
                ?></td>
                <td  align="left" valign="top"   >

<?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$ResAlmacenMovimientoEntradaDetalle =  $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,NULL,NULL,1,NULL,$DatAlmacenMovimientoEntrada->AmoId);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];


?>                

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientEntradaDetalle){

?>
	- <?php echo $DatAlmacenMovimientEntradaDetalle->ProCodigoOriginal?> <?php echo $DatAlmacenMovimientEntradaDetalle->ProNombre?><br>
<?php
		
	}
}
?>

                </td>
                </tr>
      

        <?php	
		
		$Total += $DatAlmacenMovimientoEntrada->AmoTotal;
		 $c++;
        }
        ?>
        
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">
            TOTAL:
            </td>
            <td align="right"><?php echo number_format($Total,2);?></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>