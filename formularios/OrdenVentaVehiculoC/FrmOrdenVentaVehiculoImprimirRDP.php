<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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

$GET_id = $_GET['Id'];


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');


$InsPago = new ClsPago();
$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(true);


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,NULL,NULL);
$ArrPagos = $ResPago['Datos'];


$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId', 'Desc',NULL,$InsOrdenVentaVehiculo->OvvId,NULL);
$ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Venta de Vehiculo No. <?php echo $InsOrdenVentaVehiculo->OvvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsOrdenVentaVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsOrdenVentaVehiculo->OvvId)){?> 
FncOrdenVentaVehiculoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>



<table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><!--<img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  />-->
      
  
     <img src="../../imagenes/membretes/cabecera_chevrolet.png" width="100%"  />

      
      
      
      </td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="34%" align="left" valign="top">&nbsp;</td>
      <td width="28%" align="center" valign="top">&nbsp;</td>
      <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
        <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="0%" align="right" valign="top">&nbsp;</td>
    </tr>
    </table>


<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td width="1" align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> <br /><?php echo $EmpresaCodigo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">AUTORIZACIÓN PARA TRATAMIENTO DE DATOS PERSONALES</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php //echo $InsOrdenVentaVehiculo->OvvId;?></span>
        
        </td>
      <td width="1" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
      
      <span class="EstOrdenVentaVehiculoImprimirContenido">
      
      
      <p align="justify">EL CLIENTE declara que conoce y autoriza que sus datos personales proporcionados a <?php echo $EmpresaNombre;?> quedan incorporados en el banco de datos de clientes de <?php echo $EmpresaNombre;?> y de General Motors Perú S.A., en adelante General Motors, en calidad de proveedor de los vehículos. <?php echo $EmpresaNombre;?>y General Motors utilizarán dicha información para efectos de la gestión de los productos y/o servicios solicitados y/o contratados, la misma que podrá ser realizada a través de terceros.</p>
        <p align="justify">Por el presente documento, EL CLIENTE autoriza a <?php echo $EmpresaNombre;?> y a General Motors para que, directamente o a través de un tercero autorizado por estos indistintamente, realicen cualquier operación o procedimiento técnico, automatizado o no, que le permita la recopilación, registro, organización, almacenamiento, conservación, elaboración, modificación, extracción, consulta, utilización, bloqueo, supresión, comunicación por transferencia o por difusión o cualquier otra forma de procesamiento que facilite el acceso, correlación o interconexión de sus datos personales, en las condiciones que se señalan en el siguiente párrafo, dentro o fuera del país, para que sean utilizados a efectos del desarrollo de acciones comerciales de <?php echo $EmpresaNombre;?> y General Motors, para el cumplimiento de las obligaciones legales pertinentes, ejecución de garantías, incluyendo encuestas sobre satisfacción de los vehículos y servicios, la remisión de publicidad, información u ofertas de productos y/o servicios de <?php echo $EmpresaNombre;?> y/o de General Motors.</p>
        <p align="justify">EL CLIENTE autoriza la transferencia de sus datos personales recopilados por <?php echo $EmpresaNombre;?> a General Motors en un primer momento y luego por estas a un tercero autorizado por cualquiera de ellas. Asimismo, EL CLIENTE autoriza a <?php echo $EmpresaNombre;?>, General Motors y al tercero a transmitir sus datos personales (i) a las personas encargadas de las áreas de venta y post-venta de estas que requieren conocer dicha información para el ejercicio de sus funciones, (ii) a terceras personas y/o empresas contratadas por <?php echo $EmpresaNombre;?> y/o General Motors que requieran conocer dicha información para la prestación de sus servicios y/o (iii) a sus empresas vinculadas, domiciliadas o no en el Perú, para la consolidación de datos, preparación de estadísticas, manejo integral de información, etc.; autorizando además EL CLIENTE a que su voz sea grabada por <?php echo $EmpresaNombre;?> a General Motors o por el tercero autorizado de ser el caso, para efectos del tratamiento de su información personal, incluyendo sus datos personales o sensibles.</p>
        <p align="justify">Con la firma y huella digital al final del presente documento, EL CLIENTE reconoce y declara expresamente que ha sido debida y suficientemente informado sobre los alcances y efectos de la presente autorización, facultando a <?php echo $EmpresaNombre;?>, a General Motors Perú S.A., o al tercero autorizado por estos de ser el caso, a utilizar y disponer de sus datos personales y sensibles, según lo establecido en los párrafos precedentes, de conformidad con lo exigido por Ley N° 29733, Ley de Protección de Datos Personales, y su Reglamento, aprobado por Decreto Supremo N° 003-2013-JUS.<br />
          </p>
          </span>
          </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="2" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="745" rowspan="2" align="left" valign="top" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->
        
        <table width="100%">
          <tr>
   
            
            
            <td width="78%" height="48" align="left" valign="bottom">
              
              <span class="EstOrdenVentaVehiculoImprimirNota3"><span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php
	  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvFecha);;
	  ?>
                Tacna, <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?></span><br />
                </span>    
              
              
              </td>
    
            </tr>
          <tr>
            <td height="48" align="left" valign="bottom">
                     <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
            <span class="EstOrdenVentaVehiculoImprimirNota3">
			
			<?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
              <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?></span>
              
                        <?php
	}
	?>
          
              
              </td>
            </tr>
          </table>
        
        

        
      </td>
      <td width="102" align="left" valign="top" >
      
      <div style="width:100px;
	height:120px;
	border:1px solid #333;">
      
      </div>
      </td>
      <td rowspan="2" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" >
      
        <span class="EstOrdenVentaVehiculoImprimirContenido">Huella Digital<br />
      Indice Derecho
      </span>
      </td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>




 
 
</body>
</html>
