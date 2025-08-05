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


if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		
		$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			
	}	
	
	
if(strtoupper($InsOrdenVentaVehiculo->CliEmail)=="NOTIENE@gmail.com"){
	$InsOrdenVentaVehiculo->CliEmail = "";
}
if(strtoupper($InsOrdenVentaVehiculo->CliEmail)=="NOTIENE@hotmail.com"){
	$InsOrdenVentaVehiculo->CliEmail = "";
}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Venta de Vehiculo No. <?php echo $InsOrdenVentaVehiculo->OvvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssOrdenVentaVehiculoImprimirOV.css" rel="stylesheet" type="text/css" />

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
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td colspan="3" align="left" valign="top" >&nbsp;</td>
      <td width="15%" align="left" valign="top" >&nbsp;</td>
      <td colspan="3" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="3%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Comprobante a Emitir:</span></td>
      <td colspan="3" align="left" valign="top" >
        
        <span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvComprobanteVentaDescripcion;?></span>
         </td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Fecha:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="bottom" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="bottom" >
      
      <div class="EstOrdenVentaVehiculoImprimirCapaSubTitulo">
      <span class="EstOrdenVentaVehiculoImprimirSubTitulo">DATOS DEL CLIENTE</span>
      </div>
      
      <!--  <hr />-->
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DNI / RUC:</span></td>
      <td height="35" colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliNumeroDocumento;?></span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Estado Civil:</span></td>
      <td height="35" colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliEstadoCivil;?></span></td>
      <td height="35" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="12%" height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Nombre / Razon Social :</span></td>
      <td height="35" colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliNombre;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoMaterno;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoPaterno;?></span></td>
      <td height="35" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Conyuge :</span></td>
      <td colspan="7" align="left" valign="top" >
      
      <span class="EstOrdenVentaVehiculoImprimirContenido">
            <?php
			if(!empty($ArrOrdenVentaVehiculoPropietarios)){
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
     			
                <?php
				if($DatOrdenVentaVehiculoPropietario->CliId <> $InsOrdenVentaVehiculo->CliId){
				?>
                
              
        	  <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>:  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?><br />
                <?php	
				}
				?>       
            
              
            <?php
	}
	}
	?>
      </span>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Domicilio :</span></td>
      <td height="35" colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliDireccion;?> <?php echo $InsOrdenVentaVehiculo->CliDistrito;?> <?php echo $InsOrdenVentaVehiculo->CliProvincia;?> <?php echo $InsOrdenVentaVehiculo->CliDepartamento;?></span></td>
      <td height="35" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Celular :</span></td>
      <td height="35" colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliCelular;?></span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Telefono :</span></td>
      <td height="35" colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliTelefono;?></span></td>
      <td height="35" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Email :</span></td>
      <td height="35" colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliEmail;?></span></td>
      <td height="35" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Representante Legal :</span></td>
      <td height="35" colspan="7" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->CliRepresentanteLegal;?></span></td>
      <td height="35" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="29" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="29" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" >
      
      <div class="EstOrdenVentaVehiculoImprimirCapaSubTitulo">
      <span class="EstOrdenVentaVehiculoImprimirSubTitulo">DATOS DEL VEHICULO</span>
      </div>
      <!--
        <hr />
        -->
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Marca :</span></td>
      <td width="9%" height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VmaNombre;?></span></td>
      <td width="10%" height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Modelo :</span></td>
      <td width="13%" height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VmoNombre;?></span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Version :</span></td>
      <td height="35" colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VveNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Chasis/VIN :</span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinVIN;?></span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Motor :</span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinNumeroMotor;?></span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Año Fab. :</span></td>
      <td width="10%" height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinAnoFabricacion;?></span></td>
      <td width="12%" height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Año Mod. :</span></td>
      <td width="13%" height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinAnoModelo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Color :</span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinColor;?></span></td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="35" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">GLP :</span></td>
      <td height="35" align="left" valign="top" >
        <span class="EstOrdenVentaVehiculoImprimirContenido">
          <?php echo $InsOrdenVentaVehiculo->OvvGLP;?>
          </span>
        
        &nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Modelo de Tanque:</span></td>
      <td height="35" align="left" valign="top" >
        <span class="EstOrdenVentaVehiculoImprimirContenido">
          <?php echo $InsOrdenVentaVehiculo->OvvGLPModeloTanque;?>
          </span>
        </td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Tipo de Placa:</span></td>
      <td height="35" align="left" valign="top" >  <span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvTipoPlaca;?></span></td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" >
      
      <div class="EstOrdenVentaVehiculoImprimirCapaSubTitulo">
      <span class="EstOrdenVentaVehiculoImprimirSubTitulo">FORMA DE VENTA</span>
        </div>
        <!--
        <hr />-->
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Forma de Pago :</span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->NpaNombre;?></span></td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Precio de Unidad:</span></td>
      <td height="35" align="left" valign="top" >
      
      <span class="EstOrdenVentaVehiculoImprimirPrecio"><?php echo $InsOrdenVentaVehiculo->MonSimbolo;?></span> <span class="EstOrdenVentaVehiculoImprimirPrecio"><?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?></span>
      
      </td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">T.C.:</span></td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td height="35" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Analista :</span></td>
      <td height="35" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="200" colspan="8" align="left" valign="top" >
      
      
<?php
$InsPago = new ClsPago();
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,NULL,NULL);

$ArrPagos = $ResPago['Datos'];

?>
      <table width="100%" class="EstOrdenVentaVehiculoImprimirTabla">
      <thead class="EstOrdenVentaVehiculoImprimirTablaHead">
      <tr>
        <th width="4%">#</th>
        <th width="8%">Fecha</th>
        <th width="15%">Banco</th>
        <th width="21%">Nro. Operacion</th>
        <th width="19%">Moneda</th>
        <th width="17%">Tipo Cambio</th>
        <th width="16%">Monto</th>
        </tr>
     </thead>
     <tbody class="EstOrdenVentaVehiculoImprimirTablaBody"> 
      <?php
	  $i=1;
	  if(!empty($ArrPagos)){
		  foreach($ArrPagos as $DatPago){
	?>
    
    <?php $DatPago->PagMonto = (($EmpresaMonedaId==$InsOrdenVentaVehiculo->MonId or empty($InsOrdenVentaVehiculo->MonId))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));?>


      <tr>
        <td><?php echo $i;?>.-</td>
        <td align="center"><?php echo $DatPago->PagFechaTransaccion;?></td>
        <td><?php echo $DatPago->BanNombre;?></td>
        <td><?php echo $DatPago->PagNumeroTransaccion;?></td>
        <td align="center"><?php echo $DatPago->MonSimbolo;?></td>
        <td align="right"><?php echo $DatPago->PagTipoCambio;?></td>
        <td align="right">
		<?php echo number_format($DatPago->PagMonto,2);?></td>
        </tr>
    
    <?php
			$i++;
		  }
	  }
	  ?>  
      </tbody>
      </table>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Notas :</span></td>
      <td colspan="7" align="left" valign="top" >
      
      
        <?php
			  	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta)){	
					foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta ){
				?>
              - <?php echo $DatOrdenVentaVehiculoCondicionVenta->CovNombre;?><br />
              <?php						
					}
				}else{
				?>
                
                <?php	
				}
				?>
              <?php
if(!empty($InsOrdenVentaVehiculo->OvvCondicionVentaOtro)){
?>
              - <?php echo $InsOrdenVentaVehiculo->OvvCondicionVentaOtro;?><br />
              <?php	
}
?>


<?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){	
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio ){
?>
                -  <?php echo $DatOrdenVentaVehiculoObsequio->ObsNombre;?><br />
                <?php						
	}
}				
?></span>
              
              
              
              <?php
if(!empty($InsOrdenVentaVehiculo->OvvObsequioOtro)){
?>
              - <?php echo $InsOrdenVentaVehiculo->OvvObsequioOtro;?>
              <?php	
}
?>	

</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" >
      
      <div class="EstOrdenVentaVehiculoImprimirCapaSubTitulo">
      
      <span class="EstOrdenVentaVehiculoImprimirSubTitulo">OBSERVACIONES</span>
      </div>
      
      <!--  <hr />--></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="100" colspan="8" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvObservacionImpresa;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="8" align="left" valign="top" ><hr />        <p>&nbsp;</p></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->
        
            <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
            
            
              
              <span class="EstOrdenVentaVehiculoImprimirFirma">
			  
			  _________________________________<br>
			  <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>:  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?><br />
            </span>    
      <br />        
              
            <?php
	}
	?>
            
        
        
        
        
        
        
      </td>
      <td colspan="4" align="left" valign="top" >
      
      
      
                <span class="EstOrdenVentaVehiculoImprimirFirma">
			  
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
