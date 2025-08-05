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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_COMPRA_NO_ATENDIDO_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ProveedorId = $_POST['CmpProveedorId'];
$POST_ProveedorNombre = $_POST['CmpProveedorNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"PcoFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_ConOrdenCompra = isset($_POST['CmpConOrdenCompra'])?$_POST['CmpConOrdenCompra']:1;
$POST_OrdenCompraId = $_POST['CmpOrdenCompraId'];
$POST_Moneda = $_POST['CmpMoneda'];

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompraPendiente.php');

$InsReporteOrdenCompraPendiente = new ClsReporteOrdenCompraPendiente();
$InsProveedor = new ClsProveedor();


if(empty($POST_ProveedorId) and !empty($POST_ProveedorNombre)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedors("PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno","contiene",$POST_ProveedorNombre,"PrvId","ASC",1,"1",NULL,NULL);
	$ArrProveedors = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedors)){
		foreach($ArrProveedors as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->PrvId;
		}
	}

}


if(empty($POST_ProveedorId) and !empty($POST_ProveedorNumeroDocumento)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedors("PrvNumeroDocumento","contiene",$POST_ProveedorNumeroDocumento,"PrvId","ASC",1,"1",NULL,NULL);
	$ArrProveedors = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedors)){
		foreach($ArrProveedors as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->PrvId;
		}
	}

}



//MtdObtenerReporteOrdenCompraPendientes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oProveedor=NULL,$oDiaTranscurrido=NULL,$oVentaDirectaDetalleEstado=NULL) {
$ResReporteOrdenCompraPendiente = $InsReporteOrdenCompraPendiente->MtdObtenerReporteOrdenCompraPendientes(NULL,NULL,$POST_ord,$POST_sen,NULL,NULL,3,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_OrdenCompraId,NULL,$POST_ConOrdenCompra,NULL,NULL,"PcoFecha",true,false,$POST_ProveedorId,NULL,1);
$ArrReporteOrdenCompraPendientes = $ResReporteOrdenCompraPendiente['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ORDENES DE COMPRA NO ATENDIDOS DEL
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
          <th width="7%">ORD. COMPRA</th>
          <th width="5%">FECHA</th>
          <th width="8%">FECHA LLEGADA APROX.</th>
          <th width="6%">DIAS TRANSC.</th>
          <th width="4%">COD. ORI.</th>
          <th width="5%">CANT. SOLIC.</th>
          <th width="5%">CANT. PEND.</th>
          <th width="3%">IMP.</th>
          <th width="10%">ESTADO O.V.</th>
          <th width="26%">NOMBRE</th>
          <th width="3%">REF</th>
          <th width="16%">ESTADO O.C.</th>
          <th width="16%">CLIENTE</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteOrdenCompraPendientes as $DatReporteOrdenCompraPendiente){
        ?>
        
           <?php
			//$Pendiente = $DatReporteOrdenCompraPendiente->PcdCantidad - $DatReporteOrdenCompraPendiente->AmdCantidad;
			?>
			<?php //echo number_format($DatReporteOrdenCompraPendiente->PcdCantidad,2);?>
            <?php //echo number_format($DatReporteOrdenCompraPendiente->AmdCantidad,2);?>
            
            <?php
//			if($DatReporteOrdenCompraPendiente->PcdCantidadNoRecibida>0){
				if(1 == 1){
			?>
            
			<tr>
            	<td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
       
            <a target="_blank" href="../../principal.php?Mod=OrdenCompra&Form=VerEstado&Id=<?php echo $DatReporteOrdenCompraPendiente->OcoId; ?>">
            <?php echo ($DatReporteOrdenCompraPendiente->OcoId);?>
            </a>
            
            </td>
            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteOrdenCompraPendiente->OcoFecha);?></td>
            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteOrdenCompraPendiente->OcoFechaLlegadaEstimada);?></td>
            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteOrdenCompraPendiente->OcoDiaTranscurrido);?> dias</td>
            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteOrdenCompraPendiente->ProCodigoOriginal);?></td>
            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo number_format($DatReporteOrdenCompraPendiente->PcdCantidad,2);?>
            
            
            </td>
            <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo number_format($DatReporteOrdenCompraPendiente->PcdCantidadNoRecibida,2);?></td>
            <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
			
			
			<?php $DatReporteOrdenCompraPendiente->PcdImporte = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatReporteOrdenCompraPendiente->PcdImporte:($DatReporteOrdenCompraPendiente->PcdImporte/$DatReporteOrdenCompraPendiente->PcoTipoCambio));?>
			
			<?php echo number_format($DatReporteOrdenCompraPendiente->PcdImporte,2);?>
            
            </td>
            <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php
switch($DatReporteOrdenCompraPendiente->VddEstado){
	case 1:
?>
              CONSIDERAR
              <?php
	break;
	
	case 2:
?>
              <span style="color:#F00"> ANULADO</span>
              <?php
	break;


	case 3:
?>
              <span style="color:#F00"> INTERNO</span>
              <?php
	break;
	
	
	case 4:
?>
              <span style="color:#F00">DEVOLUCION</span>
              <?php
	break;

	case 5:
?>
              <span style="color:#F00"> DAÑADO</span>
              <?php
	break;
		
	default:
?>
              -
  <?php
	break;
}
?></td>
            <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatReporteOrdenCompraPendiente->ProNombre);?></td>
            <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
              
              
              
              
              
  <a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=VerEstado&Id=<?php echo ($DatReporteOrdenCompraPendiente->VdiId);?>">
  <?php echo ($DatReporteOrdenCompraPendiente->VdiOrdenCompraNumero);?>
  </a>
              
              
              
</td>
            <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
            
<?php 
switch($DatReporteOrdenCompraPendiente->PcdEstado){

	case "3":
?>
		Considerar
<?php	
	break;
	
	case "7":
?>
		Descontinuado / Concluido
<?php	
	break;
	
	case "8":
?>
		Descontinuado / Pedir Reemplazo
<?php	
	break;
	
	
	case "9":
?>
		Solicito Fuente
<?php	
	break;
	
	
	case "10":
?>
		Stock/Pedir Denuevo
<?php	
	break;
	
	case "6":
?>
		Anulado
<?php	
	break;
}
?>
           

&nbsp;</td>
            <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
			
			<?php echo $DatReporteOrdenCompraPendiente->CliNombre;?>
            <?php echo $DatReporteOrdenCompraPendiente->CliApellidoPaterno;?>
            <?php echo $DatReporteOrdenCompraPendiente->CliApellidoMaterno;?>
            
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