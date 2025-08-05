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
$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
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

$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,'VddId','Desc',NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];


//
//$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,0,NULL,NULL,$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra);
//$ArrVentaDirectas = $ResVentaDirecta['Datos'];

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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE ORDENES DE VENTA DE CLIENTES PENDIENTEDEL
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
          <th width="3%">#</th>
          <th width="6%">ORD. VEN.</th>
          <th width="6%">REF.</th>
          <th width="6%">FECHA</th>
          <th width="6%">COTIZ.</th>
          <th width="9%">COD. ORIG.</th>
          <th width="15%">DESCRIPCION</th>
          <th width="21%">CLIENTE</th>
          <th width="9%">TELEFONO</th>
          <th width="8%">CELULAR</th>
          <th width="6%">EMAIL</th>
          <th width="5%">NOTA</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
	
		$c=1;
        foreach($ArrVentaDirectaDetalles as $DatVentaDirecta){
			
        ?>
        
    <tr id="Fila_<?php echo $c;?>">
    
                    <td  align="right" valign="middle"   ><?php echo $c;?></td>
                    <td  align="right" valign="top"   >
                    <a target="_blank" href="../../principal.php?Mod=VentaDirecta&Form=VerEstado&Id=<?php echo ($DatVentaDirecta->VdiId);?>">
                    <?php echo ($DatVentaDirecta->VdiId);?>
                    </a>
                    </td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->VdiOrdenCompraNumero);?>&nbsp;</td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->VdiFecha);?></td>
                    <td  align="right" valign="top"   >&nbsp; <?php echo ($DatVentaDirecta->CprId);?></td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->ProCodigoOriginal);?></td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->ProNombre);?></td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->CliNombre);?> <?php echo ($DatVentaDirecta->CliApellidoPaterno);?> <?php echo ($DatVentaDirecta->CliApellidoMaterno);?></td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->CliTelefono);?>&nbsp;</td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->CliCelular);?>&nbsp;</td>
                    <td  align="right" valign="top"   ><?php echo ($DatVentaDirecta->CliEmail);?>&nbsp;</td>
                    <td  align="right" valign="top"   >-</td>
    
    </tr>
              <?php	
               
                
        ?>
<?php
	 $c++;

?>

    
    
    
    <?php
		
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
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>