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
	header("Content-Disposition:  filename=\"SEGUIMIENTO_ORDEN_TRABAJO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link rel="stylesheet" type="text/css" href="css/CssFichaIngreso.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

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

//$POST_ClienteNombre = $_POST['CmpClienteNombre'];
//$POST_ClienteId = $_POST['CmpClienteId'];
//$POST_VehiculoIngresoVIN = $_POST['CmpVehiculoIngresoVIN'];
//$POST_FichaIngresoId = $_POST['CmpFichaIngresoId'];
$POST_Filtro = $_POST['CmpFiltro'];


$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"CprFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

require_once($InsPoo->MtdPaqReporte().'ClsFichaIngresoCotizacionProductoSeguimiento.php');

$InsFichaIngresoCotizacionProductoSeguimiento = new ClsFichaIngresoCotizacionProductoSeguimiento();

//MtdObtenerCotizacionProductoNoPedidos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oVehiculoIngreso=NULL,$oPersonal=NULL,$oCliente=NULL,$oTieneFichaIngreso=NULL)

$ResFichaIngresoCotizacionProductoSeguimiento = $InsFichaIngresoCotizacionProductoSeguimiento->MtdObtenerCotizacionProductoNoPedidos("CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,ProNombre,fin.FinId,cpr.CprId","contiene",$POST_Filtro,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,NULL);
$ArrFichaIngresoCotizacionProductoSeguimientos = $ResFichaIngresoCotizacionProductoSeguimiento['Datos'];




?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">SEGUIMIENTO DE ORDENES DE TRABAJO C/ COTIZACION NO PEDIDO 
  
  DEL
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
          <th width="15%">COT.</th>
          <th width="13%">FECHA</th>
          <th width="32%">CLIENTE.</th>
          <th width="12%">MARCA</th>
          <th width="13%">MODELO</th>
          <th width="12%">O.T.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;
        foreach($ArrFichaIngresoCotizacionProductoSeguimientos as $DatFichaIngresoCotizacionProductoSeguimiento){
        ?>
        <tr   >
          <td  class="<?php echo (($c%2==0)?'EstTablaReporteActivo':'EstTablaReporteInactivo');?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td  class="<?php echo (($c%2==0)?'EstTablaReporteActivo':'EstTablaReporteInactivo');?>"  align="right" valign="middle"   >
		  
            <a href="javascript:FncPopUp('../../formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id=<?php echo $DatFichaIngresoCotizacionProductoSeguimiento->CprId;?>&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);"><?php echo $DatFichaIngresoCotizacionProductoSeguimiento->CprId;  ?>   </a>
			 
             
			</td>
          <td class="<?php echo (($c%2==0)?'EstTablaReporteActivo':'EstTablaReporteInactivo');?>"  align="right" ><?php echo $DatFichaIngresoCotizacionProductoSeguimiento->CprFecha;  ?></td>
          <td  class="<?php echo (($c%2==0)?'EstTablaReporteActivo':'EstTablaReporteInactivo');?>"  align="right" ><?php echo $DatFichaIngresoCotizacionProductoSeguimiento->CliNombre;  ?> <?php echo $DatFichaIngresoCotizacionProductoSeguimiento->CliApellidoPaterno;  ?> <?php echo $DatFichaIngresoCotizacionProductoSeguimiento->CliApellidoMaterno;  ?></td>
          <td class="<?php echo (($c%2==0)?'EstTablaReporteActivo':'EstTablaReporteInactivo');?>"  align="right" ><?php echo $DatFichaIngresoCotizacionProductoSeguimiento->VmaNombre;  ?></td>
          <td class="<?php echo (($c%2==0)?'EstTablaReporteActivo':'EstTablaReporteInactivo');?>"  align="right" ><?php echo $DatFichaIngresoCotizacionProductoSeguimiento->VmoNombre;  ?></td>
          <td class="<?php echo (($c%2==0)?'EstTablaReporteActivo':'EstTablaReporteInactivo');?>" align="right" >
		  
		  
		  
         <a href="javascript:FncPopUp('../../formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id=<?php echo $DatFichaIngresoCotizacionProductoSeguimiento->FinId;?>&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);"><?php echo $DatFichaIngresoCotizacionProductoSeguimiento->FinId;  ?>  </a>
			    
				
				
				</td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="6" align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>