<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
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
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsOrdenVentaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsOrdenVentaVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsOrdenVentaVehiculoPropietarioFunciones.js" ></script>
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


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsObsequio.php');



$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal = new ClsPersonal();

$InsCondicionVenta = new ClsCondicionVenta();
$InsObsequio = new ClsObsequio();

$ResCondicionVenta = $InsCondicionVenta->MtdObtenerCondicionVentas(NULL,NULL,'CovId','DESC',NULL,1);
$ArrCondicionVentas = $ResCondicionVenta['Datos'];

$ResObsequio = $InsObsequio->MtdObtenerObsequios(NULL,NULL,'ObsId','DESC',NULL,1);
$ArrObsequios = $ResObsequio['Datos'];

if (isset($_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador])){	
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenVentaVehiculoEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

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

var OrdenVentaVehiculoDetalleEditar = 1;
var OrdenVentaVehiculoDetalleEliminar = 1;

var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;
var VehiculoColorHabilitado = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;

var OrdenVentaVehiculoPropietarioEditar = 1;
var OrdenVentaVehiculoPropietarioEliminar = 1;

</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">


<div class="EstCapMenu">

           <?php
if($Edito){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsOrdenVentaVehiculo->OvvId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsOrdenVentaVehiculo->OvvId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            

<?php
}
?>    

<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	



    
      
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        ORDEN DE VENTA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Orden de Venta</a></li>

</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenVentaVehiculo->OvvTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenVentaVehiculo->OvvTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
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
               <td align="left" valign="top"><span id="sprytextfield10">
                 <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsOrdenVentaVehiculo->OvvFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenVentaVehiculo->OvvFecha; }?>" size="15" maxlength="10" />
                 <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenVentaVehiculo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                       <?php
			  }
			  ?>
                       </select>
                     <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCotizacionProductoDetalleListar();" value="<?php if (empty($InsOrdenVentaVehiculo->OvvTipoCambio)){ echo "";}else{ echo $InsOrdenVentaVehiculo->OvvTipoCambio; } ?>" size="10" maxlength="10" /></td>
                   <td><a href="javascript:FncOrdenVentaVehiculoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                   </tr>
                 </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Impuesto:<br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta"  value="<?php if(empty($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta;}?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top">
			   
			   
			   <?php
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
					}
					?>
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">En transito</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   <option <?php echo $OpcEstado4;?> value="4">Por Facturar</option>
                 </select>
                 
                 
                 </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenVentaVehiculo->OvvObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cotizacion:</td>
               <td align="left" valign="top"><input name="CmpCotizacionVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId"  tabindex="3" value="<?php  echo $InsOrdenVentaVehiculo->CveId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td>Asesor de Ventas:</td>
               <td><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
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
               <td align="left" valign="top">Condicion de Venta:</td>
               <td align="left" valign="top"><?php
foreach($ArrCondicionVentas as $DatCondicionVenta){
?>
	
	<?php
				 
	$OrdenVentaVehiculoCondicionVentaId = "";
	
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta ){
			$aux = '';
			if($DatOrdenVentaVehiculoCondicionVenta->CovId==$DatCondicionVenta->CovId){
				$aux = 'checked="checked"';		
				$OrdenVentaVehiculoCondicionVentaId = $DatOrdenVentaVehiculoCondicionVenta->OvnId;				
				break;
			}					
		}
	}				
	?>
                 <input <?php echo $aux;?> type="checkbox" value="<?php echo $DatCondicionVenta->CovId;?>" name="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>" id="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>" />
                 
          <input type="hidden" value="<?php echo $OrdenVentaVehiculoCondicionVentaId;?>" name="CmpOrdenVentaVehiculoCondicionVentaId_<?php echo $DatCondicionVenta->CovId;?>" id="CmpOrdenVentaVehiculoCondicionVentaId_<?php echo $DatCondicionVenta->CovId;?>" />       
                 
                 <?php echo $DatCondicionVenta->CovNombre;?><br />
                 <?php	
}
?>
                 <input name="CmpCondicionVentaOtro" type="text" class="EstFormularioCaja" id="CmpCondicionVentaOtro" value="<?php echo $InsOrdenVentaVehiculo->OvvCondicionVentaOtro;?>" size="20" maxlength="255"  /></td>
               <td align="left" valign="top">Obsequios:</td>
               <td align="left" valign="top"><?php
foreach($ArrObsequios as $DatObsequio){
?>
                 <?php
				 
	$OrdenVentaVehiculoObsequioId = "";
	
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio ){
			$aux = '';
			if($DatOrdenVentaVehiculoObsequio->ObsId==$DatObsequio->ObsId){
				$aux = 'checked="checked"';		
				$OrdenVentaVehiculoObsequioId = $DatOrdenVentaVehiculoObsequio->OvoId;				
				break;
			}					
		}
	}				
	?>
                 <input <?php echo $aux;?> type="checkbox" value="<?php echo $DatObsequio->ObsId;?>" name="CmpObsequio_<?php echo $DatObsequio->ObsId;?>" id="CmpObsequio_<?php echo $DatObsequio->ObsId;?>" />
                 
                 
                 <input type="hidden" value="<?php echo $OrdenVentaVehiculoObsequioId;?>" name="CmpOrdenVentaVehiculoObsequioId_<?php echo $DatObsequio->ObsId;?>" id="CmpOrdenVentaVehiculoObsequioId_<?php echo $DatObsequio->ObsId;?>" />     
                 
                 
                 <?php echo $DatObsequio->ObsNombre;?><br />
                 <?php	
}
?>
                 <input name="CmpObsequioOtro" type="text" class="EstFormularioCaja" id="CmpObsequioOtro" value="<?php echo $InsOrdenVentaVehiculo->OvvObsequioOtro;?>" size="20" maxlength="255"  /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td></td>
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
               <td colspan="6"><span class="EstFormularioSubTitulo">Datos del Propietario</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Tipo Doc.</td>
               <td>Num. Documento</td>
               <td>Nombre:</td>
               <td>Telefono</td>
               <td>Celular</td>
               <td>Email</td>
               <td><input type="hidden" name="CmpOrdenVentaVehiculoPropietarioItem" id="CmpOrdenVentaVehiculoPropietarioItem" />
                 <input type="hidden" name="CmpPropietarioId" id="CmpPropietarioId" /></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><select class="EstFormularioCombo" name="CmpPropietarioTipoDocumento" id="CmpPropietarioTipoDocumento">
                 <option value="">Escoja una opcion</option>
                 <?php
foreach($ArrTipoDocumentos as $DatTipoDocumento){
?>
                 <option <?php echo $DatTipoDocumento->TdoId;?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                 <?php
}
?>
               </select></td>
               <td><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a id="BtnPropietarioNuevo" href="javascript:FncPropietarioNuevo();"> <img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input tabindex="4" class="EstFormularioCaja" name="CmpPropietarioNumeroDocumento" type="text" id="CmpPropietarioNumeroDocumento" size="20" maxlength="50"   /></td>
                   <td><a id="BtnPropietarioBuscarNumeroDocumento" href="javascript:FncPropietarioBuscar('NumeroDocumento');"> <img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><a id="BtnPropietarioRegistrar" onclick="FncPropietarioCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnPropietarioEditar" onclick="FncPropietarioCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                   <td><div id="CapPropietarioBuscar"></div></td>
                 </tr>
                 <tr> </tr>
               </table></td>
               <td><input  tabindex="2" class="EstFormularioCaja" name="CmpPropietarioNombre" type="text" id="CmpPropietarioNombre" size="45" maxlength="255"  /></td>
               <td><input name="CmpPropietarioTelefono" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPropietarioTelefono"  tabindex="2" size="20" maxlength="255" readonly="readonly"  /></td>
               <td><input name="CmpPropietarioCelular" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPropietarioCelular"  tabindex="2" size="20" maxlength="255" readonly="readonly"  /></td>
               <td><input name="CmpPropietarioEmail" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPropietarioEmail"  tabindex="2" size="20" maxlength="255" readonly="readonly"  /></td>
               <td><a href="javascript:FncOrdenVentaVehiculoPropietarioGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%" align="right"><a href="javascript:FncOrdenVentaVehiculoPropietarioListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenVentaVehiculoPropietarioEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
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
               <td colspan="12"><span class="EstFormularioSubTitulo">Datos del Vehiculo </span></td>
               <td colspan="2" align="right">TOTAL PACTADO:</td>
               <td><input name="CmpCotizacionTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionTotal" value="<?php echo number_format($InsOrdenVentaVehiculo->CveTotal,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">VIN:</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Marca:</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsOrdenVentaVehiculo->VmoId;?>" size="3" /></td>
               <td align="left" valign="top">Version:
                 <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsOrdenVentaVehiculo->VveId;?>" size="3" /></td>
               <td align="left" valign="top">Color:</td>
               <td align="left" valign="top">A&ntilde;o/Modelo</td>
               <td align="left" valign="top">Precio: </td>
               <td align="left" valign="top">Descuento:</td>
               <td valign="top">Bono GM </td>
               <td valign="top">Bono Dealer</td>
               <td valign="top">Desc. Gerencia</td>
               <td align="left" valign="top">Total:</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td align="left" valign="top"><a href="javascript:FncOrdenVentaVehiculoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoIngresoVIN" type="text" id="CmpVehiculoIngresoVIN" value="<?php echo ($InsOrdenVentaVehiculo->EinVIN);?>" size="20" maxlength="30" /></td>
               <td align="left" valign="top"><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td align="left" valign="top">
               
   <a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title="">
<img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title="">
<img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" />
</a>
            
               
               </td>
               <td align="left" valign="top"><span id="spryselect1">
                 <select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                   <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsOrdenVentaVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                   <?php
			}
			?>
                   </select>
                 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
               <td align="left" valign="top"><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td align="left" valign="top"><span id="spryselect3">
                 <select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                 </select>
                 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
               <td align="left" valign="top"><span id="spryselect4">
                 <select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                 </select>
                 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
               <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoColor" type="text" id="CmpVehiculoColor" value="<?php echo ($InsOrdenVentaVehiculo->OvvColor);?>" size="20" maxlength="30" /></td>
               <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoAnoModelo" type="text" id="CmpVehiculoAnoModelo" value="<?php echo ($InsOrdenVentaVehiculo->OvvAnoModelo);?>" size="7" maxlength="4" /></td>
               <td align="left" valign="top"><span id="sprytextfield">
                 <label for="CmpPrecio2"></label>
                 <input name="CmpPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPrecio" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvPrecio,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top"><span id="sprytextfield6">
                 <label for="CmpPrecio3"></label>
                 <input class="EstFormularioCaja" name="CmpDescuento" type="text" id="CmpDescuento" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvDescuento,2);?>" size="5" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top"><p><span id="sprytextfield8">
                 <label for="CmpPrecio4"></label>
               </span><span id="sprytextfield7">
               <label for="CmpPrecio7"></label>
               <input class="EstFormularioCaja" name="CmpBonoGM" type="text" id="CmpBonoGM" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvBonoGM,2);?>" size="5" maxlength="10" />
               <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></p></td>
               <td align="left" valign="top"><span id="sprytextfield9">
                 <label for="CmpPrecio5"></label>
               </span><span id="sprytextfield11">
               <label for="CmpPrecio8"></label>
               <input class="EstFormularioCaja" name="CmpBonoDealer" type="text" id="CmpBonoDealer" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvBonoDealer,2);?>" size="5" maxlength="10" />
               <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top"><span id="sprytextfield10">
                 <label for="CmpPrecio6"></label>
               </span><span id="sprytextfield12">
               <label for="CmpPrecio9"></label>
               <input class="EstFormularioCaja" name="CmpDescuentoGerencia" type="text" id="CmpDescuentoGerencia" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvDescuentoGerencia,2);?>" size="5" maxlength="10" />
               <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top"><span id="sprytextfield4">
                 <label for="CmpPrecio"></label>
               </span><span id="sprytextfield13">
               <label for="CmpPrecio10"></label>
               <input name="CmpTotal" type="text" class="EstFormularioCaja" id="CmpTotal" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?>" size="10" maxlength="10" />
               <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsOrdenVentaVehiculo->EinId;?>" size="3" />
                 <input name="CmpPrecioLista" type="hidden" id="CmpPrecioLista" size="3" />
                 <input name="CmpPrecioCierre" type="hidden" id="CmpPrecioCierre" size="3" />
                 <input name="CmpPrecioMinimo" type="hidden" id="CmpPrecioMinimo" size="3" />
                 </td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table>
           
         </div></td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="67%"><span class="EstFormularioSubTitulo">Disponibilidad/Lista de Precios</span></td>
               <td width="31%" align="right"><a href="javascript:FncVehiculoIngresoListar();"> <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVehiculoIngreso" class="EstCapVehiculoIngreso"></div></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVehiculoListaPrecio" class="EstCapVehiculoListaPrecio"></div></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
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
    


        

       
    
</div>    		 
		
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>

	
	
	
    
       


     
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	

	

	
</script>

<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "date", {isRequired:false, format:"dd/mm/yyyy"});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13");
</script>


<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principalC.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
