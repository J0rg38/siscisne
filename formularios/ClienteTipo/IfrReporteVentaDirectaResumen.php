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
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_VENTA_DIRECTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReporteVentaDirectaResumen.js"></script>

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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ConOrdenCompra = ($_POST['CmpConOrdenCompra']);


require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();


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

// MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL)

$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,0,NULL,NULL,$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra);
$ArrVentaDirectas = $ResVentaDirecta['Datos'];

//$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,$POST_ord,$POST_sen,1,NULL,NULL,3,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ClienteId,$POST_ConOrdenCompra,$POST_OrdenCompraId);
//$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];

$POST_Moneda = (empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda);

//deb($POST_Moneda);

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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE ORDENES DE VENTA   DEL
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
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th width="10%" rowspan="2">ORD. VEN.</th>
          <th colspan="7" align="center">ESTADO GENERAL</th>
          <th colspan="4">DATOS DEL CLIENTE</th>
          <th colspan="2">ORDEN DE COMPRA</th>
          <th align="center">ALMACEN</th>
          <th colspan="3" align="center">FACTURACION</th>
          </tr>
        <tr>
          <th width="2%">#</th>
          <th width="2%">&nbsp;</th>
          <th width="8%">&nbsp;</th>
          <th width="8%">O.C. REF.</th>
          <th width="9%">O.C. REF / FECHA</th>
          <th width="11%" align="center">ESTADO</th>
          <th width="11%" align="center">MONEDA</th>
          <th width="11%" align="center">T.C.</th>
          <th width="11%" align="center">TOTAL</th>
          <th width="8%">TIPO CLI.</th>
          <th width="8%">TIPO DOC.</th>
          <th width="8%">NUM. DOC.</th>
          <th width="25%">CLIENTE</th>
          <th width="14%">ORD. COMPRA</th>
          <th width="11%" align="center">FECHA </th>
          <th width="11%" align="center">DOC. SALIDA</th>
          <th width="5%" align="center">COMPROB. EMITIDO</th>
          <th width="6%" align="center">FECHA</th>
          <th width="6%" align="center">TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$VentaDirectaSumaTotal = 0;
		$c=1;
        foreach($ArrVentaDirectas as $DatVentaDirecta){



			
        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
                  <?php
				  if($_GET['P']<>2){
			 ?>
             <input onClick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]"  value="<?php echo $dat->AmoId; ?>"  />
             <?php 
				  }
				  ?>
                  
                  
                </td>
                <td  align="right" valign="top"   >
				<a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=VerEstado&Id=<?php echo ($DatVentaDirecta->VdiId);?>">
				<?php echo ($DatVentaDirecta->VdiId);?>
                </a>
                </td>
                <td  align="right" valign="top"   >
                
                <?php            
if(!empty($DatVentaDirecta->VdiArchivo)){
	
	$extension = strtolower(pathinfo($DatVentaDirecta->VdiArchivo, PATHINFO_EXTENSION));
	$nombre_base = basename($DatVentaDirecta->VdiArchivo, '.'.$extension);  
?>
                 
                  
<a href="../../subidos/venta_directa/<?php echo $DatVentaDirecta->VdiArchivo;?>" target="_blank" title="">Ver</a>
              
                  
<?php	
}
?>



</td>
                <td  align="right" valign="top"   >&nbsp; <?php echo ($DatVentaDirecta->VdiOrdenCompraNumero);?></td>
                <td  align="right" valign="top"   >&nbsp; <?php echo ($DatVentaDirecta->VdiOrdenCompraFecha);?></td>
                <td align="right" valign="top"  >
				
<?php
$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$ResVentaDirectaDetalle =  $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,NULL,NULL,$DatVentaDirecta->VdiId);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
?>
                 
                  <?php

$Situacion = 0;

$Pendiente = 0;
$Incompleto = 0;
$Completo = 0;

foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
?>


	<?php	

		if($DatVentaDirectaDetalle->VddEstado == 1){

			if(empty($DatVentaDirectaDetalle->VddCantidadLlegada) and empty($DatVentaDirectaDetalle->AmdCantidad)){
				//$fondo = "#F30";//ROJO - NO LLEGO
				$Pendiente = 1;

			}else if( ($DatVentaDirectaDetalle->VddCantidadLlegada >= $DatVentaDirectaDetalle->VddPrecioVenta) or ($DatVentaDirectaDetalle->AmdCantidad >= $DatVentaDirectaDetalle->VddCantidad)  ){
				//$fondo = "#6F3"; // VERDE
				$Completo = 1;

			}else if($DatVentaDirectaDetalle->VddCantidadLlegada < $DatVentaDirectaDetalle->VddCantidad){
				//$fondo = "#FC0";//NARAJA - LLEGADA PARCIAL	
				$Incompleto = 1;

			}

		}
        
    ?>
                  <?php	
}
?>



<?php
//deb($Pendiente." - ".$Incompleto." - ".$Completo);
	if($Pendiente == 1){
		
		if($Completo == 1){
			
			$Situacion = 2;
			
		}else{
			
			if($Incompleto == 1){
				
				$Situacion = 2;
				
			}else{
				
				$Situacion = 1;
				
			}
		
		}
		
		
	}else{
		
		if($Incompleto == 1){
			
			$Situacion = 2;
			
		}else{
			$Situacion = 3;
		}
		
	}
?>

<?php
	switch($Situacion){
		case 1:
?>
                  PENDIENTE
  <?php
		break;
		
		case 2:
?>
                 INCOMPLETO
  <?php	
		break;
		
		case 3:
?>
	COMPLETADO
<?php
		break;
	}
?>

			</td>
                <td align="right" valign="top"  ><?php echo ($DatVentaDirecta->MonNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatVentaDirecta->VdiTipoCambio);?></td>
                <td align="right" valign="top"  >
				
				
				<?php $DatVentaDirecta->VdiTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatVentaDirecta->VdiTotal:($DatVentaDirecta->VdiTotal/$DatVentaDirecta->VdiTipoCambio));?>
                  <?php echo number_format($DatVentaDirecta->VdiTotal,2);?>
                  
                  
                  </td>
                <td  align="right" valign="top"   >
				
				<?php echo (empty($DatVentaDirecta->LtiAbreviatura)?$DatVentaDirecta->LtiNombre:$DatVentaDirecta->LtiAbreviatura)//FncCortarTexto($dat->LtiNombre,15);?>
				<?php //echo ($DatVentaDirecta->LtiNombre);;?></td>
                <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->TdoNombre);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->CliNumeroDocumento);?></td>
                <td  align="right" valign="top"   >
                
               
               
                <?php echo ($DatVentaDirecta->CliNombre);?>
                <?php echo ($DatVentaDirecta->CliApellidoPaterno);?>
                <?php echo ($DatVentaDirecta->CliApellidoMaterno);?>
               
                </td>
<td  align="right" valign="top"   >
  
  
  
<?php

$InsPedidoCompra = new ClsPedidoCompra();
$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoFecha","ASC",NULL,NULL,NULL,NULL,NULL,0,$DatVentaDirecta->VdiId);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];
?>
  
  <?php
//deb();
if(!empty($ArrPedidoCompras)){
	foreach($ArrPedidoCompras as $DatPedidoCompra){
?>
  <a target="_blank" href="../../principal.php?Mod=OrdenCompra&Form=Ver&Id=<?php echo ($DatPedidoCompra->OcoId);?>">
    <?php echo $DatPedidoCompra->OcoId?>
    </a>
  <?php
	}
}
?>
  
  &nbsp;
  
</td>
<td align="center" valign="top"  >
  
  <?php
$InsPedidoCompra = new ClsPedidoCompra();
$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoFecha","ASC",NULL,NULL,NULL,NULL,NULL,0,$DatVentaDirecta->VdiId);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];
?>
  
  <?php
if(!empty($ArrPedidoCompras)){
	foreach($ArrPedidoCompras as $DatPedidoCompra){
?>
  
  <?php echo $DatPedidoCompra->OcoFecha?>
  
  <?php
	}
}
?>
  
  
  &nbsp;
</td>
<td align="right" valign="top"  >
  
  
  <?php
//$ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL,$oIgnorarTotalVacio=false);
$InsVentaConcretada = new ClsVentaConcretada();
$ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas(NULL,NULL,NULL,'AmoId','Desc',NULL,NULL,NULL,3,0,0,0,$DatVentaDirecta->VdiId,NULL,false);
$ArrVentaConcretadas = $ResVentaConcretada['Datos'];

?>
  
  <?php
if(!empty($ArrVentaConcretadas)){
	foreach($ArrVentaConcretadas as $DatVentaConcretada){
?>
  
  <a target="_blank" href="../../principal.php?Mod=VentaConcretada&Form=Ver&Id=<?php echo ($DatVentaConcretada->VcoId);?>"><?php echo ($DatVentaConcretada->VcoId);?></a><br>
  
  <?php		
	}
}
?>
  
  &nbsp;
  
</td>
<td align="right" valign="top"  >

<?php
$InsBoleta = new ClsBoleta();

$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,'BolId','Desc',NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirecta->VdiId);
$ArrBoletas = $ResBoleta['Datos'];
?>

<?php
if(!empty($ArrBoletas)){
	foreach($ArrBoletas as $DatBoleta){
?>
	<a target="_blank" href="../../principal.php?Mod=Boleta&Form=Ver&Id=<?php echo ($DatBoleta->BolId);?>&Ta=<?php echo ($DatBoleta->BtaId);?>"><?php echo ($DatBoleta->BtaNumero);?>-<?php echo ($DatBoleta->BolId);?></a><br>
<?php		
	}
}
?>



<?php
$InsFactura = new ClsFactura();
//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL)
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,'FacId','Desc',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirecta->VdiId);
$ArrFacturas = $ResFactura['Datos'];
?>


<?php
if(!empty($ArrFacturas)){
	foreach($ArrFacturas as $DatFactura){
?>
	<a target="_blank" href="../../principal.php?Mod=Factura&Form=Ver&Id=<?php echo ($DatFactura->FacId);?>&Ta=<?php echo ($DatFactura->FtaId);?>"><?php echo ($DatFactura->FtaNumero);?>-<?php echo ($DatFactura->FacId);?></a><br>
<?php	
	}	
}
?>&nbsp;
</td>
<td align="right" valign="top"  >

<?php
$InsBoleta = new ClsBoleta();

$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,'BolId','Desc',NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirecta->VdiId);
$ArrBoletas = $ResBoleta['Datos'];
?>

<?php
if(!empty($ArrBoletas)){
	foreach($ArrBoletas as $DatBoleta){
?>
	<?php echo ($DatBoleta->BolFechaEmision);?><br>
<?php		
	}
}
?>



<?php
$InsFactura = new ClsFactura();
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,'FacId','Desc',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirecta->VdiId);
$ArrFacturas = $ResFactura['Datos'];
?>
  <?php
if(!empty($ArrFacturas)){
	foreach($ArrFacturas as $DatFactura){
?>
		<?php echo ($DatFactura->FacFechaEmision);?><br>
  <?php	
	}	
}

?>


&nbsp;</td>
<td align="right" valign="top"  >
  
  <?php
$InsBoleta = new ClsBoleta();

$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,'BolId','Desc',NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirecta->VdiId);
$ArrBoletas = $ResBoleta['Datos'];
?>
  
  <?php
if(!empty($ArrBoletas)){
	foreach($ArrBoletas as $DatBoleta){
?>
  <?php $DatBoleta->BolTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatBoleta->BolTotal:($DatBoleta->BolTotal/$DatBoleta->BolTipoCambio));?>
  <?php echo number_format($DatBoleta->BolTotal,2);?><br>
  <?php		
	}
}
?>
  
  
  
  
  <?php
$InsFactura = new ClsFactura();
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,'FacId','Desc',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirecta->VdiId);
$ArrFacturas = $ResFactura['Datos'];
?>
  <?php
if(!empty($ArrFacturas)){
	foreach($ArrFacturas as $DatFactura){
?>
  
  <?php $DatFactura->FacTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacTotal:($DatFactura->FacTotal/$DatFactura->FacTipoCambio));?>
  <?php echo number_format($DatFactura->FacTotal,2);?><br>
  <?php	
	}	
}
?>
  &nbsp;
  
</td>
</tr>
		<?php	
			$VentaDirectaSumaTotal += $DatVentaDirecta->VdiTotal;
		?>
  		
      
      
              
        <?php
		 $c++;
        }
        ?>
        
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="6" align="right">SUMA TOTAL:</td>
            <td align="right"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($VentaDirectaSumaTotal,2);?></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="3" align="right">TOTAL FACTURACION:</td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>