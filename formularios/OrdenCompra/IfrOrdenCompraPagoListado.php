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
	header("Content-Disposition:  filename=\"ACTUALIZAR_ORDEN_COMPRA_PAGO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>


<?php if($_GET['P']==1){?> 
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("OrdenCompra");?>JsOrdenCompraPagoListado.js"></script>
<?php }?>

</head>
<body>

<?php if($_GET['P']==1){?> 
<script type="text/javascript">

$().ready(function() {

<?php //if($_GET['P']==1){?> 
FncOrdenCompraPagoImprimirAccion(); 
<?php //}?>

<?php //if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php //}?>

});
</script>
<?php }?>

<?php

if($_POST){
	
	$POST_ProveedorId = $_POST['CmpProveedorId'];
	$POST_ProveedorNombre = $_POST['CmpProveedorNombre'];
	$POST_ProveedorNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$POST_finicio = (isset($_POST['CmpFechaInicio']) and $_POST['CmpFechaInicio']<> "undefined")?$_POST['CmpFechaInicio']:"01/01/".date("Y");
	$POST_ffin = (isset($_POST['CmpFechaFin']) and $_POST['CmpFechaFin']<> "undefined")?$_POST['CmpFechaFin']:date("d/m/Y");
	//$POST_ffin = (($_POST['CmpFechaFin'])<>"undefined")?$_POST['CmpFechaFin']:'';
	
	$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"AmoComprobanteNumero";
	$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"ASC";
	
	$POST_Moneda = $_POST['CmpMoneda'];
	$POST_Cancelado = $_POST['CmpCancelado'];
	$POST_Seleccionados = $_POST['CmpSeleccionados'];
	
}else{

	$POST_ProveedorId = $_GET['CmpProveedorId'];
	$POST_ProveedorNombre = $_GET['CmpProveedorNombre'];
	$POST_ProveedorNumeroDocumento = $_GET['CmpProveedorNumeroDocumento'];
	
	$POST_finicio = (isset($_GET['CmpFechaInicio']) and $_POST['CmpFechaInicio']<> "undefined")?$_GET['CmpFechaInicio']:"01/01/".date("Y");
	$POST_ffin = (isset($_GET['CmpFechaFin']) and $_POST['CmpFechaFin']<> "undefined")?$_GET['CmpFechaFin']:date("d/m/Y");
	//$POST_ffin = (($_POST['CmpFechaFin'])<>"undefined")?$_POST['CmpFechaFin']:'';
	
	$POST_ord = isset($_GET['CmpOrden'])?$_GET['CmpOrden']:"AmoComprobanteNumero";
	$POST_sen = isset($_GET['CmpSentido'])?$_GET['CmpSentido']:"DESC";
	
	$POST_Moneda = $_GET['CmpMoneda'];
	$POST_Cancelado = $_GET['CmpCancelado'];
	$POST_Seleccionados = $_POST['CmpSeleccionados'];
	
}

$ArrSeleccionados = explode("#",$POST_Seleccionados);
$ArrSeleccionados = array_filter($ArrSeleccionados);

//deb($POST_ffin);
//deb($POST_finicio);

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
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

//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL)
//AmoComprobanteNumero ASC, 
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"".$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin,true),NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,$POST_Cancelado,$POST_ProveedorId);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

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
    <img src="../../imagenes/<?php echo $SistemaLogo;?>"  width="228" height="55" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="228" height="55" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">ACTUALIZAR PAGO DE ORDENES DE COMPRA DEL
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
if($_GET['P']<>2){
?>
<input type="checkbox" name="CmpOrdenCompraPedidoCancelado" id="CmpOrdenCompraPedidoCancelado" value="1"  > Marcar como cancelado todas las facturas
<?php
}
?>  
        
        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">


<?php 
if($_GET['C']==1){
?>



        <tr>
          <td colspan="11" align="center">
          FORMULARIO DE REPUESTOS CANCELADOS<br>
          REPUESTOS
          </td>
          </tr>
<?php
}
?>
        <thead class="EstTablaReporteHead">
          <tr>
          <th>#</th>
          <th>&nbsp;</th>
          <th>NRO. FACTURA GM</th>
          <th>FECHA DE FACT.</th>
          <th>TIPO DE PEDIDO</th>
          <th>PRECIO</th>
          <th>MONEDA</th>
          <th>CLIENTE</th>
          <th>FECHA CANC.</th>
          <th>
          
			CANC.

			
         
          </th>
          <th>-</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">


        <?php
		$Total = 0;
		$c=1;
        foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
        ?>


        	<?php
			if( (!empty($ArrSeleccionados) and in_array($DatAlmacenMovimientoEntrada->AmoId,$ArrSeleccionados)) or empty($ArrSeleccionados)){
			?>
                    <tr id="Fila_<?php echo $c;?>"  >
        
          <td class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
          

<?php
if($_GET['P']<>2){
?>
<input type="checkbox" name="CmpAgregarSeleccionado[]" id="CmpAgregarSeleccionado_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" value="<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>"  etiqueta="movimiento_entrada"  onChange="FncOrdenCompraPagoSeleccionar();" >
<?php
}
?>

          
          </td>
          <td class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
		  
		  <?php echo ($DatAlmacenMovimientoEntrada->AmoComprobanteNumero);?>
          
          </td>
          <td class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatAlmacenMovimientoEntrada->AmoComprobanteFecha);?></td>
          <td class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatAlmacenMovimientoEntrada->OcoId);?></td>
          <td align="right" valign="top" class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
          <?php $DatAlmacenMovimientoEntrada->AmoTotal = round((($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatAlmacenMovimientoEntrada->AmoTotal:($DatAlmacenMovimientoEntrada->AmoTotal/$DatAlmacenMovimientoEntrada->AmoTipoCambio)),2);?>
          
          
		  <?php echo number_format($DatAlmacenMovimientoEntrada->AmoTotal,2);?></td>
          <td align="right" valign="top" class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          <?php echo $DatAlmacenMovimientoEntrada->MonSimbolo;  ?>
      
          
         

          </td>
          <td align="right" valign="top" class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >-
          
<?php

if(!empty($DatAlmacenMovimientoEntrada->OcoId)){
	
	$InsOrdenCompra = new ClsOrdenCompra();
	$InsOrdenCompra->OcoId = $DatAlmacenMovimientoEntrada->OcoId;
	$InsOrdenCompra->MtdObtenerOrdenCompra();
	
	$ClienteId = "";
	if(!empty($InsOrdenCompra->OrdenCompraPedido)){
		foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido) {
	
			$InsPedidoCompra = new ClsPedidoCompra();
			$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
			$InsPedidoCompra->MTdObtenerPedidoCompra();
?>
			<?php
            if($InsPedidoCompra->CliId <> $ClienteId){
			?>

<?php	echo $InsPedidoCompra->CliNombre;?> 
<?php	echo $InsPedidoCompra->CliApellidoPaterno;?> 
<?php echo $InsPedidoCompra->CliApellidoMaterno;?>


            
            <?php
			}
            ?>
<?php
			$ClienteId = $InsPedidoCompra->CliId;
		}
	}

	
}

?>

<?php //echo $DatAlmacenMovimientoEntrada->CliNombre;?>
<?php //echo $DatAlmacenMovimientoEntrada->CliApellidoPaterno;?>
<?php //echo $DatAlmacenMovimientoEntrada->CliApellidoMaterno;?>
          
          
          
          
          </td>
          <td align="right" valign="top" class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          
		  <?php echo date("d/m/Y")?>
		
          </td>
          <td align="center" valign="top" class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >

<?php
if($_GET['P']==2){
?>
	<?php echo (($DatAlmacenMovimientoEntrada->AmoCancelado==1)?'PAGADO':'PENDIENTE')?>
<?php	
}else{
?>
<!--<input  <?php echo (($DatAlmacenMovimientoEntrada->AmoCancelado==1)?'checked="checked"':'')?>  type="checkbox" name="CmpAlmacenMovimientoEntradaCancelado_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" id="CmpAlmacenMovimientoEntradaCancelado_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" value="<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" onChange="FncOrdenCompraPagoAccion('<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>');" etiqueta="movimiento_entrada" >
-->
<?php
switch($DatAlmacenMovimientoEntrada->AmoCancelado){
	 case 1:
	 	  $DatAlmacenMovimientoEntradaCancelado1 = 'selected="selected"';
	 break;
	 
	 case 2:
	 	  $DatAlmacenMovimientoEntradaCancelado2 = 'selected="selected"';
	 break;
	 default:
	 
	 break;
}
?>
<select name="CmpAlmacenMovimientoEntradaCancelado_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" id="CmpAlmacenMovimientoEntradaCancelado_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" onChange="FncOrdenCompraPagoAccion('<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>');" >
<option value="">-</option>
<option <?php echo $DatAlmacenMovimientoEntradaCancelado1;?> value="1">Si</option>
<option  <?php echo $DatAlmacenMovimientoEntradaCancelado2;?> value="2">No</option>
</select>

<input type="hidden" name="CmpAlmacenMovimientoEntradaTotal_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" id="CmpAlmacenMovimientoEntradaTotal_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>" value="<?php echo $DatAlmacenMovimientoEntrada->AmoTotal; ?>">

<?php
}
?>
   
          </td>
<td align="center" valign="top" class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >

<div id="CapOrdenCompraPagoAccion_<?php echo $DatAlmacenMovimientoEntrada->AmoId; ?>"></div>


          </td>
          </tr>


<?php
$Total  += $DatAlmacenMovimientoEntrada->AmoTotal;
?>

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
            <td align="right"><span class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($Total,2);?></span></td>
            <td align="right"><span class="<?php //echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatAlmacenMovimientoEntrada->MonSimbolo;  ?></span></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
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
          
          
<?php 
if($_GET['C']==1){
?>
          <tr>
            <td colspan="11" align="center">
            ______________________________________________________________________<br>
            Firma del Representante Legal
            </td>
          </tr>
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
          <tr>
            <td colspan="5" align="center"><?php echo $EmpresaNombre; ?></td>
            <td colspan="6" align="center"><?php echo $EmpresaCodigo;?></td>
          </tr>
          <tr>
            <td colspan="5" align="center">____________________________________________</td>
            <td colspan="6" align="center">____________________________________________</td>
          </tr>
          <tr>
            <td colspan="5" align="center">            Nombres/Razon Social </td>
            <td colspan="6" align="center">            RUC</td>
          </tr>
          <tr>
            <td colspan="5" align="center">&nbsp;</td>
            <td colspan="6" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" align="center">____________________________________________</td>
            <td colspan="6" align="center">____________________________________________</td>
          </tr>
          <tr>
            <td colspan="5" align="center">   Nombre del representante    </td>
            <td colspan="6" align="center">   DOI </td>
          </tr>
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
          <tr>
            <td colspan="11" align="center">____________________________________________</td>
          </tr>
          <tr>
            <td colspan="11" align="center">Firma del Concesionario</td>
          </tr>
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
<?php
}
?>
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>