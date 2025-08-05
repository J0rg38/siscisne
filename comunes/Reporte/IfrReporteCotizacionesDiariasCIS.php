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
	header("Content-Disposition:  filename=\"REPORTE_COTIZACIONES_VEHICULO_DIARIO_".date('d-m-Y').".xls\";");
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
$POST_Personal = ($_POST['CmpPersonal']);


$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);
$POST_Sucursal = ($_POST['CmpSucursal']);


require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,$POST_Personal,NULL,$POST_Sucursal);
$ArrCotizacionVehiculos = $ResCotizacionVehiculo['Datos'];

$POST_Moneda = (empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda);

//deb($POST_Moneda);

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();


//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
//$ArrPersonales = $ResPersonal['Datos'];


?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
 <img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE COTIZACIONES DE VEHICULOS DIARIO DEL
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
        
        
      
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th>#</th>
          <th>Hora de Cotizacion</th>
          <th>Dia de la Cotizacion</th>
          <th>Nombre de Cliente</th>
          <th>Modelo Cotizado</th>
          <th>Condicion de compra (cont -Cred)</th>
          <th>Telefono</th>
          <th>Medio por el cual se entero de  nuestras promociones </th>
          <th>Cotizo en otro consesionario de la Red (Cisne)</th>
          <th>Comentarios -Observaciones </th>
          <th>Vendedor</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        


    
<?php
$i = 1;
foreach($ArrCotizacionVehiculos as $DatCotizacionVehiculo){
?>
       
                  <tr>
                    <td  align="right" valign="middle"   ><?php echo $i;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveHora;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveFecha;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliNombre;?> <?php echo $DatCotizacionVehiculo->CliApellidoPaterno;?> <?php echo $DatCotizacionVehiculo->CliApellidoMaterno;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->VmaNombre;?> <?php echo $DatCotizacionVehiculo->VmoNombre;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->NpaNombre;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliTelefono;?> <?php echo $DatCotizacionVehiculo->CliCelular;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->TrfNombre;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveCotizoOtroLugar;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveObservacionReporte;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->PerNombre;?> <?php echo $DatCotizacionVehiculo->PerApellidoPaterno;?> <?php echo $DatCotizacionVehiculo->PerApellidoMaterno;?></td>
                  </tr>
         
<?php
$i++;
}
?>
      
              
  
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>