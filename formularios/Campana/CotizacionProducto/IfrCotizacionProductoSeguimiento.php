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
	header("Content-Disposition:  filename=\"SEGUIMIENTO_COTIZACION_REPUESTO_".date('d-m-Y').".xls\";");
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

$POST_CotizacionProductoId = $_POST['CmpCotizacionProductoId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];
$POST_ClienteId = $_POST['CmpClienteId'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"CprFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');

$InsCotizacionProducto = new ClsCotizacionProducto();

//MtdObtenerCotizacionProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL) {
$ResCotizacionProducto = $InsCotizacionProducto->MtdObtenerCotizacionProductos("CprId","contiene",$POST_CotizacionProductoId,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL);
$ArrCotizacionProductos = $ResCotizacionProducto['Datos'];
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">SEGUIMIENTO DE COTIZACIONES DE REPUESTO
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
          <th width="1%">#</th>
          <th width="11%">COD. COT. REP.</th>
          <th width="8%">FECHA</th>
          <th width="9%">NUM. DOC.</th>
          <th width="9%">CLIENTE</th>
          <th width="9%">MONEDA</th>
          <th width="6%">T.C.</th>
          <th width="11%">SUBTOTAL</th>
          <th width="9%">IMPUESTO</th>
          <th width="9%">TOTAL</th>
          <th width="18%">ESTADO</th>
       
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        <?php
		
		$c=1;
        foreach($ArrCotizacionProductos as $DatCotizacionProducto){
        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?></td>
          <td align="right" valign="middle"   >
		  
			<a href="../../principal.php?Mod=Compra&Form=Ver&Id=<?php echo $DatCotizacionProducto->CprId;?>" target="_parent">
			<?php echo $DatCotizacionProducto->CprId;  ?>
            </a>          
				</td>
              <td align="right" ><?php echo ($DatCotizacionProducto->CprFecha);?></td>
              <td align="right" ><?php echo $DatCotizacionProducto->CliNumeroDocumento;  ?></td>
              <td align="right" ><?php echo $DatCotizacionProducto->CliNombre;  ?> </td>
              <td align="right" ><?php echo $DatCotizacionProducto->MonNombre;  ?></td>
              <td align="right" ><?php echo $DatCotizacionProducto->CprTipoCambio;  ?></td>
              <td align="right" ><?php echo $DatCotizacionProducto->CprSubTotal;  ?></td>
              <td align="right" ><?php echo $DatCotizacionProducto->CprImpuesto;  ?></td>
              <td align="right" ><?php echo $DatCotizacionProducto->CprTotal;  ?></td>
              <td align="right" ><?php echo strtoupper($DatCotizacionProducto->CprEstadoDescripcion);?></td>
        
            
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
           
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>