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
	header("Content-Disposition:  filename=\"SEGUIMIENTO_VENTA_DIRECTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>tbox/thickbox.js"></script>
<script type="text/javascript" src="js/JsVentaDirectaSeguimiento.js"></script> 
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

$POST_VentaDirectaId = $_POST['CmpVentaDirectaId'];
$POST_VentaDirectaOrdenCompraNumero = $_POST['CmpVentaDirectaOrdenCompraNumero'];



$POST_ClienteNombre = $_POST['CmpClienteNombre'];
$POST_ClienteNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
$POST_ClienteId = $_POST['CmpClienteId'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

//$POST_Moneda = isset($_POST['CmpMoneda'])?$_POST['CmpMoneda']:"MON-10001";
$POST_Moneda = $_POST['CmpMoneda'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsPedidoCompra = new ClsPedidoCompra();
$InsVentaDirecta = new ClsVentaDirecta();
$InsVentaConcretada = new ClsVentaConcretada();
$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

$InsCliente = new ClsCliente();




if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	
//MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL)
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	//deb($ArrClientes);
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}


if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	echo "fdsfads";
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}



//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL)
$ResVentaDirecta = $InsVentaDirecta->MtdSeguimientoVentaDirectas("VdiId,VdiOrdenCompraNumero","contiene",$POST_VentaDirectaId.$POST_VentaDirectaOrdenCompraNumero,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,0,NULL,NULL,$POST_Moneda,$POST_ClienteId);
$ArrVentaDirectas = $ResVentaDirecta['Datos'];


//$POST_ClienteId
//$InsMoneda = new ClsMoneda();
//$InsMoneda->MonId = $POST_Moneda;
//$InsMoneda->MtdObtenerMoneda();
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">SEGUIMIENTO DE ORDENES DE VENTA
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
          <th width="5%">ORD. VEN.</th>
          <th width="6%">FECHA</th>
          <th width="5%">NUM. DOC.</th>
          <th width="7%">CLIENTE</th>
          <th width="8%">O.C. REF.</th>
          <th width="8%">O.C. REF. FECHA</th>
          <th width="8%">MONEDA</th>
          <th width="3%">T.C.</th>
          <th width="9%">TOTAL</th>
          <th width="8%">PEDIDOS</th>
          <th width="8%">ORD. COMPRA</th>
          <th width="10%">INGRESO</th>
          <th width="12%">CONCRETADA</th>
          <th width="1%">&nbsp;</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        <?php
		
		$c=1;
        foreach($ArrVentaDirectas as $DatVentaDirecta){
        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?></td>
          <td align="right" valign="middle"   >
		  
			<a href="../../principal.php?Mod=VentaDirecta&Form=Ver&Id=<?php echo $DatVentaDirecta->VdiId;?>" target="_parent">
			<?php echo $DatVentaDirecta->VdiId;  ?>
            </a>          
				</td>
              <td align="right" ><?php echo ($DatVentaDirecta->VdiFecha);?></td>
              <td align="right" ><?php echo $DatVentaDirecta->CliNumeroDocumento;  ?></td>
              <td align="right" ><?php echo $DatVentaDirecta->CliNombre;  ?> </td>
              <td align="right" >&nbsp;<?php echo $DatVentaDirecta->VdiOrdenCompraNumero;  ?></td>
              <td align="right" >&nbsp;<?php echo $DatVentaDirecta->VdiOrdenCompraFecha;  ?></td>
              <td align="right" ><?php echo $DatVentaDirecta->MonNombre;  ?></td>
              <td align="right" ><?php echo $DatVentaDirecta->VdiTipoCambio;  ?></td>
              <td align="right" >
			  
				<?php $DatVentaDirecta->VdiTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatVentaDirecta->VdiTotal:($DatVentaDirecta->VdiTotal/$DatVentaDirecta->VdiTipoCambio));?>    

			  <?php echo number_format($DatVentaDirecta->VdiTotal,2);  ?>


              </td>
              <td align="right" >


<?php
$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoFecha","ASC",NULL,NULL,NULL,NULL,NULL,0,$DatVentaDirecta->VdiId);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];
?>

<?php
if(!empty($ArrPedidoCompras)){
	foreach($ArrPedidoCompras as $DatPedidoCompra){

?>

<a href="principal.php?Mod=PedidoCompra&Form=Listado&Fil=<?php echo $DatPedidoCompra->PcoId;?>"><?php echo $DatPedidoCompra->PcoId ?></a>

<?php
if($_GET['P']<>2){
?>
<a href="javascript:FncPedidoCompraVistaPreliminar('<?php echo $DatPedidoCompra->PcoId;?>')"><img src="../../imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>
<br>
<?php
}
?>

<?php
		
	}
}else{
?>
-
<?php	
}
?>
              
              </td>
              <td align="right" >


<?php
$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoFecha","ASC",NULL,NULL,NULL,NULL,NULL,0,$DatVentaDirecta->VdiId);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];
?>

<?php
if(!empty($ArrPedidoCompras)){
	foreach($ArrPedidoCompras as $DatPedidoCompra){

?>

<a href="../../principal.php?Mod=OrdenCompra&Form=Listado&Fil=<?php echo $DatPedidoCompra->OcoId;?>"><?php echo $DatPedidoCompra->OcoId ?></a>

	<?php
if($_GET['P']<>2){
?>
    <a href="javascript:FncOrdenCompraVistaPreliminar('<?php echo $DatPedidoCompra->OcoId;?>')"><img src="../../imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>
    <?php
}
	?>
    
    <br>
    
<?php
		
	}
}else{
?>
-
<?php	
}
?>
              
              </td>
              <td align="right" >

&nbsp;
<?php
if(!empty($ArrPedidoCompras)){
	foreach($ArrPedidoCompras as $DatPedidoCompra){

?>


        
<?php
// MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0)
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"AmoFecha","ASC",NULL,NULL,NULL,3,NULL,NULL,$DatPedidoCompra->OcoId,NULL,NULL,NULL,NULL,0);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];
?>	
<?php
if(!empty($ArrAlmacenMovimientoEntradas)){
	foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
?>

<a href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Listado&Fil=<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>"><?php echo $DatAlmacenMovimientoEntrada->AmoComprobanteNumero ?></a>

	
    <?php
if($_GET['P']<>2){
?>
    <a href="javascript:FncAlmacenMovimientoEntradaVistaPreliminar('<?php echo $DatAlmacenMovimientoEntrada->AmoId;?>')"><img src="../../imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>
  <?php
}
  ?>  
    
<?php
	}
}else{
?>
-
<?php	
}
?>

    
<?php
		
	}
}
?>

 

              </td>
              <td align="right" >
&nbsp;       
<?php

$ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas("AmoId,CliNombre,CliNumeroDocumento,amo.CprId,amo.VdiId",NULL,NULL,"AmoFecha","ASC",NULL,NULL,NULL,NULL,0,0,0,$DatVentaDirecta->VdiId);
$ArrVentaConcretadas = $ResVentaConcretada['Datos'];
?>
<?php
if(!empty($ArrVentaConcretadas)){
	foreach($ArrVentaConcretadas as $DatVentaConcretada){
?>





<a href="principal.php?Mod=VentaConcretada&Form=Listado&Fil=<?php echo $DatVentaConcretada->VcoId;?>"><?php echo $DatVentaConcretada->VcoId ?></a>

	
    <?php
if($_GET['P']<>2){
?>
    <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $DatVentaConcretada->VcoId;?>')"><img src="../../imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>
  <?php
}
  ?>  
    	<br>
<?php
	}
}else{
?>
-
<?php	
}
?>



              </td>
              <td align="right" >&nbsp;</td>
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