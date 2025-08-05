<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaTotalFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVentaDirecta.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVentaDirecta.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');


require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

//INSTANCIAS
$InsVentaDirecta = new ClsVentaDirecta();
$InsTipoOperacion = new ClsTipoOperacion();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsCotizacionProducto = new ClsCotizacionProducto();


$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsMoneda = new ClsMoneda();
$InsCondicionPago = new ClsCondicionPago();
$InsPersonal = new ClsPersonal();

$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsVentaDirectaDetalle'.$Identificador])){	
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaDetalle'.$Identificador]);
}



if (isset($_SESSION['InsVentaDirectaPlanchado'.$Identificador])){	
	$_SESSION['InsVentaDirectaPlanchado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaPlanchado'.$Identificador]);
}


if (isset($_SESSION['InsVentaDirectaPintado'.$Identificador])){	
	$_SESSION['InsVentaDirectaPintado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaPintado'.$Identificador]);
}


if (isset($_SESSION['InsVentaDirectaCentrado'.$Identificador])){	
	$_SESSION['InsVentaDirectaCentrado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaCentrado'.$Identificador]);
}


if (isset($_SESSION['InsVentaDirectaTarea'.$Identificador])){	
	$_SESSION['InsVentaDirectaTarea'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaTarea'.$Identificador]);
}

if (!isset($_SESSION['InsVentaDirectaFoto'.$Identificador])){	
	$_SESSION['InsVentaDirectaFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsVentaDirectaFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaFoto'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVentaDirectaEditar.php');

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];
?>

<script type="text/javascript">
///*
//Configuracion carga de datos y animacion
//*/
//
$(document).ready(function (){
	
	FncVentaDirectaDetalleListar();
	
		FncVentaDirectaPlanchadoListar();
	
	FncVentaDirectaPintadoListar();
	
	FncVentaDirectaCentradoListar();
	
	FncVentaDirectaTareaListar();
	
	FncVentaDirectaFotoListar("A");
	
	FncVentaDirectaFotoListar("G");
	
		
});

var VentaDirectaDetalleEditar = 2;
var VentaDirectaDetalleEliminar = 2;
var VentaDirectaDetalleVerEstado = 2;

var VentaDirectaDetalleEditar = 2;
var VentaDirectaDetalleEliminar = 2;

var VentaDirectaPlanchadoEditar = 2;
var VentaDirectaPlanchadoEliminar = 2;

var VentaDirectaPintadoEditar = 2;
var VentaDirectaPintadoEliminar = 2;

var VentaDirectaCentradoEditar = 2;
var VentaDirectaCentradoEliminar = 2;

var VentaDirectaTareaEditar = 2;
var VentaDirectaTareaEliminar = 2;


var VentaDirectaFotoEditar = 2;
var VentaDirectaFotoEliminar = 2;
</script>

<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsVentaDirecta->VdiId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsVentaDirecta->VdiId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVentaDirecta->VdiId;?>&Su=<?php echo $InsVentaDirecta->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
           <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=VentaDirecta&Form=VerEstado<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVentaDirecta->VdiId;?>"><img src="imagenes/acciones/ver_estado.png" alt="[O.V. Estado]" title="Generar" />  Estado</a></div> 
            
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER ORDEN DE VENTA  </span></td>
      </tr>
      <tr>
        <td colspan="2">
 
 
                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVentaDirecta->VdiTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVentaDirecta->VdiTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Orden de Venta  </a></li>
 <li><a href="#tab2">Archivos de Referencia  </a></li>
</ul>        

<div class="tab_container">

    <div id="tab1" class="tab_content">
        <!--Content-->     
		             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Orden de Venta  
                 
                 
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="center">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVentaDirecta->VdiId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Emision:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsVentaDirecta->VdiFecha)){ echo date("d/m/Y");}else{ echo $InsVentaDirecta->VdiFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del cliente</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente: </td>
               <td colspan="3" align="left" valign="top">
                 
                 
                 <table>
                   <tr>
                     <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsVentaDirecta->CliId;?>" size="3" />
                       <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsVentaDirecta->EinId;?>" size="3" /></td>
                     <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                       <option value="">Escoja una opcion</option>
                       <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                       <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsVentaDirecta->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                       <?php
	}
	?>
                       </select></td>
                     <td><input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsVentaDirecta->CliNumeroDocumento;?>"   /></td>
                     <td><input  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsVentaDirecta->CliNombre;?> <?php echo $InsVentaDirecta->CliApellidoPaterno;?> <?php echo $InsVentaDirecta->CliApellidoMaterno;?>"  /></td>
                     <td>&nbsp;</td>
                     </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsVentaDirecta->VdiDireccion;?>"  /></td>
               <td align="left" valign="top">Tipo de Cliente:</td>
               <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                 <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsVentaDirecta->LtiId==$DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
                 <?php
			}
			?>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del vehiculo</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">VIN:
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVentaDirecta->EinId;?>" size="3" />
                 <input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsVentaDirecta->CliId;?>" size="3" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncVehiculoIngresoNuevo();"></a></td>
                   <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVentaDirecta->EinVIN;?>" size="20" maxlength="50" readonly="readonly" /></td>
                   <td><a href="javascript:FncVehiculoIngresoBuscar('VIN');"></a></td>
                   <td>&nbsp;</td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Marca:
                 <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsVentaDirecta->VmaId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoMarca" value="<?php echo $InsVentaDirecta->VdiMarca;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsVentaDirecta->VmoId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoModelo" value="<?php echo $InsVentaDirecta->VdiModelo;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Placa:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsVentaDirecta->VdiPlaca;?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">A&ntilde;o:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoAnoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoAnoModelo" value="<?php echo $InsVentaDirecta->VdiAnoModelo;?>" size="10" maxlength="4" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Facturacion</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Condicion de Pago:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpCondicionPago" id="CmpCondicionPago">
                 <option value="">Escoja una opcion</option>
                 <?php
			  foreach($ArrCondicionPagos as $DatCondicionPago){
				?>
                 <option <?php echo ($InsVentaDirecta->NpaId == $DatCondicionPago->NpaId)?'selected="selected"':''; ?> value="<?php echo $DatCondicionPago->NpaId?>"><?php echo $DatCondicionPago->NpaNombre ?></option>
                 <?php
			  }
			  
			  ?>
               </select></td>
               <td align="left" valign="top">Dias de Credito:</td>
               <td align="left" valign="top"><span id="sprytextfield5">
                 <label for="CmpCreditoDias"></label>
                 <input name="CmpCreditoDias" type="text" class="EstFormularioCaja" id="CmpCreditoDias" value="<?php echo number_format($InsVentaDirecta->VdiCantidadDias,2);?>" size="10" maxlength="10" readonly="readonly" />
               </span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled" >
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVentaDirecta->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVentaDirectaDetalleListar();" value="<?php if (empty($InsVentaDirecta->VdiTipoCambio)){ echo "";}else{ echo $InsVentaDirecta->VdiTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Margen de Utilidad: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input name="CmpClienteMargenUtilidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteMargenUtilidad" value="<?php echo number_format($InsVentaDirecta->VdiMargenUtilidad,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Otros Costos: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input name="CmpFletePorcentaje" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFletePorcentaje" value="<?php echo number_format($InsVentaDirecta->VdiFlete,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mantenimiento: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield9">
                 <label for="CmpMantenimientoPorcentaje"></label>
                 <input name="CmpMantenimientoPorcentaje" type="text" class="EstFormularioCajaDeshabilitada" id="CmpMantenimientoPorcentaje" value="<?php echo number_format($InsVentaDirecta->VdiMantenimiento,2);?>" size="10" maxlength="10" readonly="readonly" />
               </span></td>
               <td align="left" valign="top">Descuento: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input name="CmpPorcentajeDescuento" type="text" class="EstFormularioCaja" id="CmpPorcentajeDescuento" value="<?php echo number_format($InsVentaDirecta->VdiPorcentajeDescuento,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Incluye Impuesto:</td>
               <td align="left" valign="top"><?php
					switch($InsVentaDirecta->VdiIncluyeImpuesto){
						case 1:
							$OpcIncluyeImpuesto1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcIncluyeImpuesto2 = 'selected = "selected"';						
						break;

					}
					?>
                 <select disabled="disabled"  onchange="FncVentaDirectaDetalleListar();" class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto">
                   <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                   <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                 </select></td>
               <td align="left" valign="top">Impuesto:<br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" onchange="FncVentaDirectaDetalleListar();" value="<?php echo number_format($InsVentaDirecta->VdiPorcentajeImpuestoVenta,2);?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mano de Obra:</td>
               <td align="left" valign="top"><input name="CmpManoObra" type="text" class="EstFormularioCaja" id="CmpManoObra" value="<?php echo number_format($InsVentaDirecta->VdiManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Asesor de Ventas:</td>
               <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsVentaDirecta->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Ord. Compra/Referencia:</td>
               <td align="left" valign="top"><input name="CmpOrdenCompraNumero" type="text" class="EstFormularioCaja" id="CmpOrdenCompraNumero"  tabindex="3" value="<?php  echo $InsVentaDirecta->VdiOrdenCompraNumero?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha Ord. Compra/Referencia:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpOrdenCompraFecha" type="text" class="EstFormularioCajaFecha" id="CmpOrdenCompraFecha" value="<?php  echo $InsVentaDirecta->VdiOrdenCompraFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cotizacion:</td>
               <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsVentaDirecta->CprId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Seguro:</td>
               <td align="left" valign="top"><input class="EstFormularioCajaDeshabilitada" name="CmpSeguroNombre" type="text" id="CmpSeguroNombre" size="45" maxlength="255" value="<?php echo $InsVentaDirecta->CliNombreSeguro;?> <?php echo $InsVentaDirecta->CliApellidoPaternoSeguro;?> <?php echo $InsVentaDirecta->CliApellidoMaternoSeguro;?>"  /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top"><?php
				if(!empty($InsVentaDirecta->CprId)){
				?>
                 Orden de Trabajo:
                 <?php
				}
				 ?></td>
               <td align="left" valign="top"><?php
				if(!empty($InsVentaDirecta->CprId)){
				?>
                 <table>
                   <tr>
                     <td><a href="javascript:FncFichaIngresoNuevo();"></a></td>
                     <td><input name="CmpFichaIngresoId" id="CmpFichaIngresoId" type="hidden"    value="<?php  echo $InsVentaDirecta->FinId;?>" size="20" maxlength="20" />
                       <input name="CmpFichaIngreso" type="text" class="EstFormularioCaja" id="CmpFichaIngreso"  tabindex="3" value="<?php  echo $InsVentaDirecta->FinId;?>" size="25" maxlength="25" readonly="readonly" <?php echo (!empty($InsVentaDirecta->FinId)?'readonly="readonly"':'')?>  /></td>
                     <td></td>
                     <td><a href="javascript:FncFichaIngresoBuscar('Id');"></a></td>
                     <td></td>
                     </tr>
                   </table>
                 <?php
				}
				 ?></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVentaDirecta->VdiObservacion;?></textarea></td>
               <td align="left" valign="top">Observacion Impresa:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsVentaDirecta->VdiObservacionImpresa;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsVentaDirecta->VdiEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 7:
							$OpcEstado7 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   <option <?php echo $OpcEstado7;?> value="7">Completado</option>
                   </select>
                 <!--<select  class="EstFormularioCombo" name="CmpEstadoAux" id="CmpEstadoAux" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                 </select>
                 <input type="hidden" name="CmpEstado" id="CmpEstado" value="<?php echo $InsVentaDirecta->VdiEstado;?>" />--></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales</span></td>
               <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Orden de Cobro</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top"><input <?php echo (($InsVentaDirecta->VdiNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" disabled="disabled" />
                 Notificar via email <br />
  <input value="1" checked="checked"  type="checkbox" name="CmpRedondear" id="CmpRedondear" disabled="disabled" />
                 Redondear los precios </td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top" bgcolor="#CCFFCC">Monto a Cobrar:</td>
               <td align="left" valign="top"><input name="CmpAbono" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAbono" value="<?php echo number_format($InsVentaDirecta->VdiAbono,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS	</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVentaDirectaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td width="1%"><div id="CapVentaDirectaDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaDetalles" class="EstCapVentaDirectaDetalles" > </div></td>
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
               <td colspan="2"><span class="EstFormularioSubTitulo">PLANCHADO</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapVentaDirectaPlanchadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVentaDirectaPlanchadoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaPlanchadoEliminarTodo();"></a></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaPlanchados" class="EstCapVentaDirectaPlanchados" > </div></td>
               <td><div id="CapVentaDirectaPlanchadosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2">PINTADO</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapVentaDirectaPintadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVentaDirectaPintadoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaPintadoEliminarTodo();"></a></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaPintados" class="EstCapVentaDirectaPintados" > </div></td>
               <td><div id="CapVentaDirectaPintadosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2">CENTRADO</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapVentaDirectaCentradoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVentaDirectaCentradoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaCentradoEliminarTodo();"></a></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaCentrados" class="EstCapVentaDirectaCentrados" > </div></td>
               <td><div id="CapVentaDirectaCentradosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2">TAREAS</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapVentaDirectaTareaAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVentaDirectaTareaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaTareaEliminarTodo();"></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaTareas" class="EstCapVentaDirectaTareas" > </div></td>
               <td><div id="CapVentaDirectaTareasResultado"> </div></td>
               </tr>
             </table>
           </div></td>
       </tr>
       </table>
    </div>    
    

    
       <div id="tab2" class="tab_content">
      <!--Content-->
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top"><div class="EstFormularioArea">
		  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Archivo de Referencia</span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4" align="left" valign="top">Archivo Ord. Compra Ref.:</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4">
			  
			  
			    <div class="EstFormularioArea" >
                
                <div class="EstCapVentaDirectaFotos">
                
                
			  <?php              
              
if(!empty($_SESSION['SesVdiArchivo'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesVdiArchivo'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesVdiArchivo'.$Identificador], '.'.$extension);  
?>
Archivo Adjunto:<br />
<a target="_blank" href="subidos/venta_directa/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>
<?php	
}else{
?>
No hay ARCHIVO ADJUNTO
<?php	
}
?>
</div>

</div>
</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de Actas de Entrega</span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><div class="EstFormularioArea" >
                       <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                         <tr>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           <td width="139" align="left" valign="top">&nbsp;</td>
                           <td width="136" align="right" valign="top">
                             
                             <a href="javascript:FncVentaDirectaFotoListar('A');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                             
                             </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVentaDirectaFotos" id="CapVentaDirectaFotosA"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">
                             
                             <div id="CapVentaDirectaFotosAccionA"></div>
                             </td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table>
                     </div></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de Guias de Remision</span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><div class="EstFormularioArea" >
                 <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="4" align="left" valign="top">&nbsp;</td>
                     <td width="139" align="left" valign="top">&nbsp;</td>
                     <td width="136" align="right" valign="top">
                       
                       <a href="javascript:FncVentaDirectaFotoListar('G');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                       
                       </td>
                     <td width="4" align="left" valign="top">&nbsp;</td>
                   </tr>
                   <tr>
                     <td align="left" valign="top">&nbsp;</td>
                     <td colspan="2" align="left" valign="top"><div class="EstCapVentaDirectaFotos" id="CapVentaDirectaFotosG"></div></td>
                     <td align="left" valign="top">&nbsp;</td>
                   </tr>
                   <tr>
                     <td align="left" valign="top">&nbsp;</td>
                     <td colspan="2" align="left" valign="top">
                       
                       <div id="CapVentaDirectaFotosAccionG"></div>
                       </td>
                     <td align="left" valign="top">&nbsp;</td>
                     </tr>
                   </table>
                 </div></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    </table>
		  </div>
        
        
        </td>
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

	
	
	
        

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>
