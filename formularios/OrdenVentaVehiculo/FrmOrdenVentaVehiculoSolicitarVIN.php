<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
         
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoColorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoPropietarioFunciones.js" ></script>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenVentaVehiculo.css');
</style>


<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenVentaVehiculo.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsModalidadPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');


$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal = new ClsPersonal();

$InsCondicionVenta = new ClsCondicionVenta();
$InsObsequio = new ClsObsequio();
$InsModalidadPago = new ClsModalidadPago();
$InsPlanMantenimiento = new ClsPlanMantenimiento();

$ResCondicionVenta = $InsCondicionVenta->MtdObtenerCondicionVentas(NULL,NULL,'CovId','DESC',NULL,1);
$ArrCondicionVentas = $ResCondicionVenta['Datos'];

$ResObsequio = $InsObsequio->MtdObtenerObsequios(NULL,NULL,'ObsId','DESC',NULL,1);
$ArrObsequios = $ResObsequio['Datos'];

$ResAccesorio = $InsObsequio->MtdObtenerObsequios(NULL,NULL,'ObsId','DESC',NULL,2);
$ArrAccesorios = $ResAccesorio['Datos'];


if (isset($_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador])){	
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenVentaVehiculoSolicitarVIN.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

$ResModalidadPago = $InsModalidadPago->MtdObtenerModalidadPagos(NULL,NULL,"MpaNombre","ASC",NULL,1);
$ArrModalidadPagos = $ResModalidadPago['Datos'];



?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){
	
	$('#CmpFecha').focus();	

	//FncOrdenVentaVehiculoDetalleListar();
	
	FncOrdenVentaVehiculoEstablecerMoneda();
	
	FncVehiculoModelosCargar();
	
	FncOrdenVentaVehiculoPropietarioListar();
		
	//FncVehiculoIngresoListar();
	
});

/*
Configuracion Formulario
*/

var OrdenVentaVehiculoDetalleEditar = 2;
var OrdenVentaVehiculoDetalleEliminar = 1;

var VehiculoModeloHabilitado = 2;
var VehiculoVersionHabilitado = 2;
var VehiculoColorHabilitado = 2;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;

var OrdenVentaVehiculoPropietarioEditar = 2;
var OrdenVentaVehiculoPropietarioEliminar = 2;


</script>

<form id="FrmEnviarCorreo" name="FrmEnviarCorreo" method="post" action="#" enctype="multipart/form-data" >


<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsPedidoCompra->PcoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsPedidoCompra->PcoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsPedidoCompra->PcoId;?>&Su=<?php echo $InsPedidoCompra->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

<input name="BtnEnviarCorreo"   id="BtnEnviarCorreo" type="image" border="0" src="imagenes/acc_enviar_correo.gif" alt="[Enviar Correo]" title="Enviar Correo" />

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">ENVIAR CORREO DE SOLICITUD DE VIN</span></td>
      </tr>
      <tr>
        <td colspan="2">
 
 
                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPedidoCompra->PcoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPedidoCompra->PcoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Orden de Venta</a></li>

</ul>        

<div class="tab_container">

    <div id="tab1" class="tab_content">
        <!--Content-->     
		<table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">

<div class="EstFormularioArea">
          <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="2"><span class="EstFormularioSubTitulo">Datos del correo electronico
		       
		        </span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Destinatario:</td>
            <td align="left" valign="top"><textarea name="CmpDestinatarios" cols="100" rows="3" class="EstFormularioCaja" id="CmpDestinatarios"><?php echo $InsOrdenVentaVehiculo->OvvDestinatarios;?></textarea></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Observaciones:</td>
		      <td align="left" valign="top"><textarea name="CmpObservacionCorreo" cols="100" rows="3" class="EstFormularioCaja" id="CmpObservacionCorreo"><?php echo $InsOrdenVentaVehiculo->OvvObservacionCorreo;?></textarea></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
              
              </table>
              </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           
           
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Orden de Venta de Vehiculos
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
               </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenVentaVehiculo->OvvId;?>" size="20" maxlength="20" /></td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsOrdenVentaVehiculo->OvvFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenVentaVehiculo->OvvFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Condicion de Venta:</td>
               <td align="left" valign="top">
			   
			   <?php
foreach($ArrCondicionVentas as $DatCondicionVenta){
?>
                       <?php
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta ){
			$aux = '';
			if($DatOrdenVentaVehiculoCondicionVenta->CovId==$DatCondicionVenta->CovId){
				$aux = 'checked="checked"';						
				break;
			}					
		}
	}				
	?>
                       <input disabled="disabled" <?php echo $aux;?> type="checkbox" value="<?php echo $DatCondicionVenta->CovId;?>" name="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>" id="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>" />
                       <?php echo $DatCondicionVenta->CovNombre;?><br />
                       <?php	
}
?>
                       <input name="CmpCondicionVentaOtro" type="text" class="EstFormularioCaja" id="CmpCondicionVentaOtro" value="<?php echo $InsOrdenVentaVehiculo->OvvCondicionVentaOtro;?>" size="20" maxlength="255" readonly="readonly"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de facturacion</span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Comprobante a emitir:</td>
               <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvComprobanteVenta){
						case "F":
							$OpcComprobanteVenta1 = 'selected = "selected"';
						break;

						case "B":
							$OpcComprobanteVenta2 = 'selected = "selected"';						
						break;
						
						default:
						
						break;
					}
					?>
                 <select disabled="disabled"   class="EstFormularioCombo" name="CmpComprobanteVenta" id="CmpComprobanteVenta">
                   <option value="">Escoja una opcion</option>
                   <option <?php echo $OpcComprobanteVenta1;?> value="F">Factura</option>
                   <option <?php echo $OpcComprobanteVenta2;?> value="B">Boleta</option>
                   </select></td>
               <td align="left" valign="top">Modalidad de Pago del Cliente:</td>
               <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpModalidadPago" id="CmpModalidadPago" >
                 <option value="">Escoja una opcion</option>
                 <?php
                foreach($ArrModalidadPagos as $DatModalidadPago){
                ?>
                 <option <?php echo ($DatModalidadPago->MpaId == $InsOrdenVentaVehiculo->MpaId)?'selected="selected"':'';?>  value="<?php echo $DatModalidadPago->MpaId;?>"><?php echo $DatModalidadPago->MpaAbreviatura ?> - <?php echo $DatModalidadPago->MpaNombre ?></option>
                 <?php
                }
                ?>
                 </select></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenVentaVehiculo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCotizacionProductoDetalleListar();" value="<?php if (empty($InsOrdenVentaVehiculo->OvvTipoCambio)){ echo "";}else{ echo $InsOrdenVentaVehiculo->OvvTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                   <td><a href="javascript:FncOrdenVentaVehiculoEstablecerMoneda();"></a></td>
                   </tr>
                 </table></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Impuesto:<br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta"  value="<?php if(empty($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta;}?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Orden de Venta:</td>
               <td align="left" valign="top"><input name="CmpCotizacionVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId"  tabindex="3" value="<?php  echo $InsOrdenVentaVehiculo->CveId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td>Asesor de Ventas:</td>
               <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsOrdenVentaVehiculo->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
                 </select></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenVentaVehiculo->OvvObservacion;?></textarea></td>
               <td align="left" valign="top">Fecha Estimada de Entrega:</td>
               <td align="left" valign="top"><input name="CmpFechaEntrega" type="text" class="EstFormularioCajaFecha" id="CmpFechaEntrega" value="<?php echo $InsOrdenVentaVehiculo->OvvFechaEntrega; ?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
						$OpcEstado4 = 'selected = "selected"';		
						break;
						
						case 5:
						$OpcEstado5 = 'selected = "selected"';		
						break;
						
							case 6:
						$OpcEstado6 = 'selected = "selected"';		
						break;
					}
					?>
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Listo</option>
                   <option <?php echo $OpcEstado4;?> value="4">Por Facturar</option>
                   <option <?php echo $OpcEstado5;?> value="5">Facturado</option>
                    <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             </table>
           
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">PROPIETARIOS </span></td>
               <td><input type="hidden" name="CmpOrdenVentaVehiculoPropietarioAccion" id="CmpOrdenVentaVehiculoPropietarioAccion" value="AccOrdenVentaVehiculoPropietarioRegistrar.php" /></td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapOrdenVentaVehiculoPropietarioAccion">Listo
                 para registrar elementos</div></td>
               <td width="48%" align="right"><a href="javascript:FncOrdenVentaVehiculoPropietarioListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenVentaVehiculoPropietarioEliminarTodo();"></a></td>
               <td width="3%"><div id="CapOrdenVentaVehiculoPropietariosResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapOrdenVentaVehiculoPropietarios" class="EstCapOrdenVentaVehiculoPropietarios" > </div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="9"><span class="EstFormularioSubTitulo">Datos del Vehiculo
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsOrdenVentaVehiculo->EinId;?>" size="3" />
                 <input name="CmpPrecioLista" type="hidden" id="CmpPrecioLista" size="3" />
                 <input name="CmpPrecioCierre" type="hidden" id="CmpPrecioCierre" size="3" />
                 <input name="CmpPrecioMinimo" type="hidden" id="CmpPrecioMinimo" size="3" />
                 <input name="CmpBonoGM" type="hidden" id="CmpBonoGM" size="3" />
                 <input name="CmpBonoDealer" type="hidden" id="CmpBonoDealer" size="3" />
               </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Marca:</td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsOrdenVentaVehiculo->VmoId;?>" size="3" /></td>
               <td align="left" valign="top">Version:
                 <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsOrdenVentaVehiculo->VveId;?>" size="3" /></td>
               <td align="left" valign="top">VIN:</td>
               <td align="left" valign="top">GLP</td>
               <td align="left" valign="top">Motor:</td>
               <td align="left" valign="top">Color:</td>
               <td align="left" valign="top">A&ntilde;o/Fab.</td>
               <td align="left" valign="top">A&ntilde;o/Mod.</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td align="left" valign="top"><a href="javascript:FncOrdenVentaVehiculoDetalleNuevo();"></a></td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                 <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsOrdenVentaVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
               </select></td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
               </select></td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="<?php echo ($InsOrdenVentaVehiculo->EinVIN);?>" size="20" maxlength="30" readonly="readonly" /></td>
               <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvGLP){
						case "Si":
							$OpcGLP1 = 'selected = "selected"';
						break;

						case "No":
							$OpcGLP3 = 'selected = "selected"';						
						break;
					
					}
					?>
                 <select disabled="disabled" class="EstFormularioCombo" name="CmpGLP" id="CmpGLP">
                   <option <?php echo $OpcGLP1;?> value="Si">Si</option>
                   <option <?php echo $OpcGLP3;?> value="No">No</option>
                 </select></td>
               <td align="left" valign="top"><input name="CmpVehiculoMotor" type="text" class="EstFormularioCaja" id="CmpVehiculoMotor" value="<?php echo ($InsOrdenVentaVehiculo->OvvMotor);?>" size="8" maxlength="30" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpVehiculoColor" type="text" class="EstFormularioCaja" id="CmpVehiculoColor" value="<?php echo ($InsOrdenVentaVehiculo->OvvColor);?>" size="8" maxlength="30" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpVehiculoAnoFabricacion" type="text" class="EstFormularioCaja" id="CmpVehiculoAnoFabricacion" value="<?php echo ($InsOrdenVentaVehiculo->OvvAnoFabricacion);?>" size="8" maxlength="4" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpVehiculoAnoModelo" type="text" class="EstFormularioCaja" id="CmpVehiculoAnoModelo" value="<?php echo ($InsOrdenVentaVehiculo->OvvAnoModelo);?>" size="8" maxlength="4" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Precio Prof.:</td>
               <td align="left" valign="top">Precio: </td>
               <td align="left" valign="top">Desc.:</td>
               <td align="left" valign="top">Desc. Ger.</td>
               <td align="left" valign="top">Total:</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="right">&nbsp;</td>
               <td align="right">&nbsp;</td>
               <td align="right">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"><input name="CmpCotizacionTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionTotal" value="<?php echo number_format($InsOrdenVentaVehiculo->CveTotal,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpPrecio" type="text" class="EstFormularioCaja" id="CmpPrecio" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvPrecio,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpDescuento" type="text" class="EstFormularioCaja" id="CmpDescuento" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvDescuento,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top"><span id="sprytextfield10">
                 <label for="CmpPrecio6"></label>
                 </span>
                 <input name="CmpDescuentoGerencia" type="text" class="EstFormularioCajaDeshabilitada" id="CmpDescuentoGerencia" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvDescuentoGerencia,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top"><span id="sprytextfield4">
                 <label for="CmpPrecio"></label>
                 </span>
                 <input name="CmpTotal" type="text" class="EstFormularioCaja" id="CmpTotal" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
       </tr>
       </table>
    </div>    
    
<div>		
 
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>

</form>	
	
	
        

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".(!empty($GET_mod)?$GET_mod:$GET_NMod)."&Form=Listado",$Edito,1500);
	}
		
}

?>
