<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Producto');?>JsListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaTareaFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVentaDirecta.css');
</style>

<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVentaDirecta.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
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

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsTipoOperacion = new ClsTipoOperacion();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsCotizacionProducto = new ClsCotizacionProducto();


$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsMoneda = new ClsMoneda();

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



include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVentaDirectaEditar.php');

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];


$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


//deb($InsVentaDirecta->VdiPedidoCompra);
///deb($InsVentaDirecta->VdiVentaConcretada);
?>

<?php
//if($InsVentaDirecta->VdiPedidoCompra == "No" and $InsVentaDirecta->VdiVentaConcretada == "No"){
if(1 == 1){	
?>


<script type="text/javascript">
/*
//Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
//Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpClienteNombre').focus();

	FncVentaDirectaDetalleListar();
	
	FncVentaDirectaPlanchadoListar();
	
	FncVentaDirectaPintadoListar();
	
	FncVentaDirectaCentradoListar();
	
	FncVentaDirectaTareaListar();

});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var VentaDirectaDetalleEditar = 1;
var VentaDirectaDetalleEliminar = 1;

var VentaDirectaPlanchadoEditar = 1;
var VentaDirectaPlanchadoEliminar = 1;

var VentaDirectaPintadoEditar = 1;
var VentaDirectaPintadoEliminar = 1;

var VentaDirectaCentradoEditar = 1;
var VentaDirectaCentradoEliminar = 1;

var VentaDirectaTareaEditar = 1;
var VentaDirectaTareaEliminar = 1;

var UnidadMedidaTipo = 2;
</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();">

<input type="hidden" name="CmpPedidoCompra" id="CmpPedidoCompra" value="<?php echo $InsVentaDirecta->VdiPedidoCompra;?>" />
<input type="hidden" name="CmpVentaConcretada" id="CmpVentaConcretada" value="<?php echo $InsVentaDirecta->VdiVentaConcretada;?>" />


<div class="EstCapMenu">

           
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	



<?php
if($Edito){
?>

	<?php
/*    if($PrivilegioVistaPreliminar){
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
    }*/
    ?>

<?php	
}
?>
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        ORDEN DE VENTA  </span></td>
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
     <li><a href="#tab2">Archivo  </a></li>
 

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
               <td>&nbsp;</td>
               <td>&nbsp;</td>
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
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVentaDirecta->VdiId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Emision:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsVentaDirecta->VdiFecha)){ echo date("d/m/Y");}else{ echo $InsVentaDirecta->VdiFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsVentaDirecta->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente: </td>
               <td align="left" valign="top">
               
               
               <table>
               <tr>
               <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td>
               
                              <span id="sprytextfield2">
                 <label>
                   <input <?php if(!empty($InsVentaDirecta->CliId)){ echo 'readonly="readonly"';} ?>  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsVentaDirecta->CliNombre;?>"  />
                   </label>
                 <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span>
                 <label></label>
                 </span>
                 <label></label>
                 <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title="">[...]</a>
                 
                 
               
               </td>
               <td>
               <a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /> </a>
               </td>
               </tr>
               </table>

                 </td>
               <td align="left" valign="top">Tipo Doc.:
                 <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsVentaDirecta->CliId;?>" size="3" />
                 <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsVentaDirecta->EinId;?>" size="3" /></td>
               <td align="left" valign="top">
               
               
               <select <?php if(!empty($InsVentaDirecta->CliId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                 <option value="">Escoja una opcion</option>
                 <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                 <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsVentaDirecta->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                 <?php
	}
	?>
                 </select></td>
               <td align="left" valign="top">Num. Doc.:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input <?php if(!empty($InsVentaDirecta->CliId)){ echo 'readonly="readonly"';} ?>  tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsVentaDirecta->CliNumeroDocumento;?>"   />
                     <span class="textfieldRequiredMsg"> <img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldMinCharsMsg"> <img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe haber almenos 11 digitos"  /></span></td>
                   <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"> <img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
                   <td></td>
                   <td><div id="CapClienteBuscar"></div></td>
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
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">VIN:
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVentaDirecta->EinId;?>" size="3" />
                 <input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsVentaDirecta->CliId;?>" size="3" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncVehiculoIngresoSimpleNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVentaDirecta->EinVIN;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
                   <td><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a></td>
                 </tr>
                 <tr> </tr>
               </table></td>
               <td align="left" valign="top">Marca:
                 <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsVentaDirecta->VmaId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" value="<?php echo $InsVentaDirecta->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsVentaDirecta->VmoId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoModelo" value="<?php echo $InsVentaDirecta->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Placa:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsVentaDirecta->EinPlaca;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select <?php echo ($InsVentaDirecta->VdiOrigen=="CPR")?'disabled="disabled"':'';?> class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVentaDirecta->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
               <td align="left" valign="top">
               
               <table>
               <tr>
               <td>
               
               <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVentaDirectaDetalleListar();" value="<?php if (empty($InsVentaDirecta->VdiTipoCambio)){ echo "";}else{ echo $InsVentaDirecta->VdiTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
               
               </td>
               <td>
               
                 <a href="javascript:FncVentaDirectaEstablecerMoneda();"><img src="imagenes/recargar.jpg" width="20" height="20" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                 
                 
               </td>
               </tr>
               </table>
               
               </td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
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
                 <select  onchange="FncVentaDirectaDetalleListar();" class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto" <?php echo !empty($InsVentaDirecta->CprId)?'disabled="disabled"':'';?>>
                   <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                   <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                 </select></td>
               <td align="left" valign="top">Impuesto:<br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncVentaDirectaDetalleListar();" value="<?php echo number_format($InsVentaDirecta->VdiPorcentajeImpuestoVenta,2);?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Descuento:</td>
               <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpDescuento" type="text" id="CmpDescuento" value="<?php echo number_format($InsVentaDirecta->VdiDescuento,2);?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">Mano de Obra:</td>
               <td align="left" valign="top"><input name="CmpManoObra" type="text" class="EstFormularioCajaDeshabilitada" id="CmpManoObra" value="<?php echo number_format($InsVentaDirecta->VdiManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cotizacion:</td>
               <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsVentaDirecta->CprId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Ord. Compra/Referencia:</td>
               <td align="left" valign="top"><input name="CmpOrdenCompraNumero" type="text" class="EstFormularioCaja" id="CmpOrdenCompraNumero"  tabindex="3" value="<?php  echo $InsVentaDirecta->VdiOrdenCompraNumero;?>" size="25" maxlength="25" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVentaDirecta->VdiObservacion;?></textarea></td>
               <td align="left" valign="top">Observacion Impresa:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsVentaDirecta->VdiObservacionImpresa;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
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
					}
					?>
                 
                 
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   </select>
                 
                 </td>
               <td align="left" valign="top">OPCIONES:</td>
               <td align="left" valign="top">
                <input <?php echo (($InsVentaDirecta->VdiNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
				Notificar via email (*)
               </td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">
         
			<?php
			//if($InsVentaDirecta->VdiOrigen <> "CPR"){
			?>
            
           <div class="EstFormularioArea">
             
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="98%">
                   
                   
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="16"><span class="EstFormularioSubTitulo">PRODUCTOS
                         <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpProductoValorVenta"    id="CmpProductoValorVenta"    />
<input type="hidden" name="CmpVentaDirectaDetalleId"  class="EstFormularioCaja" id="CmpVentaDirectaDetalleId"  />
                       </span></td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td><div id="CapProductoBuscar"></div></td>
                       <td>C&oacute;digo Orig.</td>
                       <td>&nbsp;</td>
                       <td>C&oacute;digo Alt.</td>
                       <td>&nbsp;</td>
                       <td>Nombre : </td>
                       <td>&nbsp;</td>
                       <td>U.M.</td>
                       <td>Costo:</td>
                       <td>Cantidad:</td>
                       <td> Valor Unit.:</td>
                       <td>&nbsp;</td>
                       <td>Valor Total:</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><input class="EstFormularioCasilla" title="Activar/Desactivar uso de lector" type="checkbox" value="1" id="CmpProductoLector" name="CmpProductoLector"  /></td>
                       <td>
                       <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                       <a href="javascript:FncVentaDirectaDetalleNuevo('');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                       <?php
							}
					   ?>
                       </td>
                       <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                       <td>
                       
                                              <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                       <a href="javascript:FncProductoBuscar('CodigoOriginal','');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                         <?php
							}
					   ?>
                       </td>
                       <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                       <td>
                       
                                                                     <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                       <a href="javascript:FncProductoBuscar('CodigoAlternativo','');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                          <?php
							}
					   ?>
                       </td>
                       <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                       <td>
                       
                       
                                                                                            <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                       <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a>
                       
                       <?php
							}
					   ?>
                       </td>
                       <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                         </select></td>
                       <td><input name="CmpProductoCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoCosto" size="10" maxlength="10" readonly="readonly"  /></td>
                       <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10"  /></td>
                       <td><input name="CmpProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoPrecio" size="10" maxlength="10" readonly="readonly"  /></td>
                       <td>
                                                                                    <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                            
                       <a id="BtnListaPrecioEditar" onclick="FncListaPrecioCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a>
                       <?php
							}
                       ?>
                       </td>
                       <td><input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="10" maxlength="10"  />                   </td>
                       <td><a href="javascript:FncVentaDirectaDetalleGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                       <td>
                       
                                                <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                            <a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title="">[...]</a>
                            
                                                   <?php
							}
                       ?>
                            </td>
                     </tr>
                     </table>             </td>
                 </tr>
               </table>
             </div>         
             
            <?php
			//}
			?>
            
            
             </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaDetalleAccion" id="CmpVentaDirectaDetalleAccion" value="AccVentaDirectaDetalleRegistrar.php" /></td>
               <td align="right">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="50%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVentaDirectaDetalleListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a>
               
			<?php
			if($InsVentaDirecta->VdiOrigen <> "CPR"){
			?>
            
<a href="javascript:FncVentaDirectaDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a>

            <?php
			}
			?>
            
</td>
               <td width="0%"><div id="CapVentaDirectaDetallesResultado"> </div></td>
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
         <td valign="top"><table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
           <tr>
             <td><img src="imagenes/advertencia.png" alt="Producto si stock" width="20" height="20" border="0" title="Producto sin stock" /></td>
             <td> Producto sin stock suficiente </td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5"><span class="EstFormularioSubTitulo">PLANCHADO </span><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaPlanchadoItem" id="CmpVentaDirectaPlanchadoItem" />
                 <input type="hidden" name="CmpVentaDirectaPlanchadoId"  class="EstFormularioCaja" id="CmpVentaDirectaPlanchadoId"  />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaPlanchadoAccion" id="CmpVentaDirectaPlanchadoAccion" value="AccVentaDirectaPlanchadoRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaPlanchadoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaPlanchadoDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPlanchadoDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaPlanchadoImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPlanchadoImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaPlanchadoGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaPlanchadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaPlanchadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncVentaDirectaPlanchadoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
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
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5">PINTADO<span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaPintadoItem" id="CmpVentaDirectaPintadoItem" />
                 <input type="hidden" name="CmpVentaDirectaPintadoId"  class="EstFormularioCaja" id="CmpVentaDirectaPintadoId"  />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaPintadoAccion" id="CmpVentaDirectaPintadoAccion" value="AccVentaDirectaPintadoRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaPintadoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaPintadoDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPintadoDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaPintadoImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPintadoImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaPintadoGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaPintadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaPintadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncVentaDirectaPintadoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
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
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5">CENTRADO<span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaCentradoItem" id="CmpVentaDirectaCentradoItem" />
                 <input type="hidden" name="CmpVentaDirectaCentradoId"  class="EstFormularioCaja" id="CmpVentaDirectaCentradoId"  />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaCentradoAccion" id="CmpVentaDirectaCentradoAccion" value="AccVentaDirectaCentradoRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaCentradoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaCentradoDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaCentradoDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaCentradoImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaCentradoImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaCentradoGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaCentradoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaCentradoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncVentaDirectaCentradoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
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
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5">TAREAS<span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaTareaItem" id="CmpVentaDirectaTareaItem" />
                 <input type="hidden" name="CmpVentaDirectaTareaId"  class="EstFormularioCaja" id="CmpVentaDirectaTareaId"  />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaTareaAccion" id="CmpVentaDirectaTareaAccion" value="AccVentaDirectaTareaRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaTareaNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaTareaDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaTareaDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaTareaImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaTareaImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaTareaGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaTareaAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaTareaListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncVentaDirectaTareaEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
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
		<td width="97%" valign="top">
        
    <div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Archivo de Referencia</span></td>
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
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><iframe src="formularios/VentaDirecta/acc/AccVentaDirectaSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrVentaDirectaSubirArchivo" name="IfrVentaDirectaSubirArchivo" scrolling="Auto"  frameborder="0" width="100%" height="500"></iframe></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div>
    
    </td>
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

var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<?php
}else{
	echo ERR_VDI_601;
}
?>


<?php
}else{
	echo ERR_GEN_101;
}
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

?>
