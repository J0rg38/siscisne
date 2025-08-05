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
	header("Content-Disposition:  filename=\"REPORTE_MOVIMIENTO_ENTRADA_".date('d-m-Y').".xls\";");
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
//$POST_OrdenCompraId = $_POST['CmpOrdenCompraId'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"AmoFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";


$POST_Moneda = isset($_POST['CmpMoneda'])?$_POST['CmpMoneda']:"MON-10001";

$POST_ConOrdenCompra = isset($_POST['CmpConOrdenCompra'])?$_POST['CmpConOrdenCompra']:1;


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
//$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();

//if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
//	
//	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","esigual",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
//	$ArrClientes = $ResCliente['Datos'];
//	
//	if(!empty($ArrClientes)){
//		foreach($ArrClientes as $DatCliente){
//			$POST_ClienteId = $DatCliente->CliId;
//		}
//	}
//
//}
//
//
//if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
//	
//	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","esigual",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
//	$ArrClientes = $ResCliente['Datos'];
//	
//	if(!empty($ArrClientes)){
//		foreach($ArrClientes as $DatCliente){
//			$POST_ClienteId = $DatCliente->CliId;
//		}
//	}
//
//}

//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL)



//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL)
//$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,$POST_Moneda,NULL,NULL,NULL,$POST_ClienteId);



//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0)
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",$POST_ConOrdenCompra);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];


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
          <th width="3%">&nbsp;</th>
          <th width="7%">COD. MOV.</th>
          <th width="10%">NRO. FACTURA GM</th>
          <th width="8%">FECHA FACT.</th>
          <th width="15%">TIPO DE PEDIDO</th>
          <th width="8%">MONEDA</th>
          <th width="8%">TOTAL</th>
          <th width="39%">CLIENTE</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
        ?>
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >

<input onClick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]"  value="<?php echo $dat->AmoId; ?>"  />
                
                </td>
                <td  align="right" valign="top"   >
				
<a href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo ($DatAlmacenMovimientoEntrada->AmoId);?>"><?php echo ($DatAlmacenMovimientoEntrada->AmoId);?></a>

				
                
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

						<?php echo $DatOrdenCompraPedido->CliNombre;?> 
                        <?php echo $DatOrdenCompraPedido->CliApellidoPaterno;?>
                        <?php echo $DatOrdenCompraPedido->CliApellidoMaterno;?><br>
                    
                    <?php	
					}
					?>
                    
				<?php
					$ClienteIdAnterior = $DatOrdenCompraPedido->CliId;
                
                    }
					
                }
                    
                ?>
                
                
                
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
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>