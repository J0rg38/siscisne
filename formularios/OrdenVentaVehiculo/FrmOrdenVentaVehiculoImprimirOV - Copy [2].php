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






<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="8" align="left" valign="top">
        
        <img src="../../imagenes/membretes/cabecera_simple.png" align="[Cabecera]" title="Cabecera"  />
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="8" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">HOJA DE PEDIDO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsOrdenVentaVehiculo->OvvId;?></span>
        
        </td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="2%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Comprobante a Emitir:</span></td>
      <td colspan="3" align="left" valign="top" >
        
        <span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvComprobanteVenta;?></span> </td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Fecha:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DATOS DEL CLIENTE</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DNI / RUC:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Estado Civil:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliEstadoCivil;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="11%" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Nombre / Razon Social :</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliNombre;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoMaterno;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoPaterno;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Conyuge :</span></td>
      <td colspan="7" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Domicilio :</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliDireccion;?> <?php echo $InsOrdenVentaVehiculo->CliDistrito;?> <?php echo $InsOrdenVentaVehiculo->CliProvincia;?> <?php echo $InsOrdenVentaVehiculo->CliDepartamento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Celular :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliCelular;?></span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Telefono :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliTelefono;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Email :</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliEmail;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Representante Legal :</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliRepresentanteLegal;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="center" valign="top" ><hr /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="29" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DATOS DEL VEHICULO</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Marca :</span></td>
      <td width="12%" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VmaNombre;?></span></td>
      <td width="7%" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Modelo :</span></td>
      <td width="16%" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VmoNombre;?></span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Version :</span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VveNombre;?></span></td>
      <td width="12%" align="left" valign="top" >&nbsp;</td>
      <td width="13%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Chasis/VIN :</span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinVIN;?></span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Motor :</span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinVIN;?></span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Año Fab. :</span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinAnoFabricacion;?></span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Año Mod. :</span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinAnoModelo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Color :</span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinVIN;?></span></td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Observaciones :</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvObservacionImpresa;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" ><hr /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">FORMA DE VENTA</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">ORDENANTE :</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
        <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno?> /
        <?php		
	}
}
?>
        <!--<br />-->
        <?php
/*if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>

		 <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> / 

<?php		
	}
}*/
?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $InsOrdenVentaVehiculo->TdoNombre;?> :</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
        <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> /
        <?php		
	}
}
?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Notas :</span></td>
      <td colspan="7" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" ><hr /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" ><p>&nbsp;</p></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->
        
        <table width="100%">
          <tr>
            <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
            
            
            <td height="100" align="center" valign="bottom">
              
              <span class="EstOrdenVentaVehiculoImprimirNota3"> 
			  
			  _________________________________<br>
			  <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>:  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?><br />
                </span>    
              
              
              </td>
            <?php
	}
	?>
            
            </tr>
          </table>
        
        
        
        
        
        
      </td>
      <td colspan="4" align="center" valign="top" >
      
      
      
              <span class="EstOrdenVentaVehiculoImprimirNota3"> 
			  
			  _________________________________<br />
			  <?php echo $InsOrdenVentaVehiculo->PerNombre;?> <?php echo $InsOrdenVentaVehiculo->PerApellidoPaterno;?> <?php echo $InsOrdenVentaVehiculo->PerApellidoMaterno;?> <br />
                
                <?php echo $InsOrdenVentaVehiculo->TdoNombrePersonal;?>:  <?php echo $InsOrdenVentaVehiculo->PerNumeroDocumento;?><br />
                </span>    
              
              
              
              </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>




 
 
</body>
</html>
