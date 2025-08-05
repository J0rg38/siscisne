<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoCostoVinculadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoAutocompletar.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCompraVehiculo.css');
</style>


<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCompraVehiculo.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');











require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');









require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');



$InsCompraVehiculo = new ClsCompraVehiculo();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsCompraVehiculoDetalle'.$Identificador])){	
	$_SESSION['InsCompraVehiculoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCompraVehiculoDetalle'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCompraVehiculoEditar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"1,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];


?>

<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
	
	FncCompraVehiculoEstablecerDocumentoOrigen();

	FncCompraVehiculoEstablecerMoneda();
	
	FncCompraVehiculoDetalleListar();
		
	FncCompraVehiculoCostoVinculadoListar();
		
});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncCompraVehiculoDetalleListar";

var CompraVehiculoDetalleEditar = 1;
//var CompraVehiculoDetalleEliminar = <?php echo (empty($InsCompraVehiculo->OcoId)?1:2);?>;
var CompraVehiculoDetalleEliminar = 1;
</script>














<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">


<div class="EstCapMenu">

           
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        COMPRA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Compra de Vehiculo</a></li>
	<li><a href="#tab2">Comprobante de Pago</a></li>
	
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCompraVehiculo->CvhTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCompraVehiculo->CvhTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Compra de Vehiculo
                 
                 
                 
                 
                 
                 
                 
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
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCompraVehiculo->CvhId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Ingreso: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsCompraVehiculo->CvhFecha)){ echo date("d/m/Y");}else{ echo $InsCompraVehiculo->CvhFecha; }?>" size="10" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsCompraVehiculo->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">Ord. Compra:</td>
               <td align="left" valign="top"><input name="CmpOrdenCompra" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpOrdenCompra" value="<?php  echo $InsCompraVehiculo->OcoId;  ?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero Guia de Remisi&oacute;n:</td>
               <td align="left" valign="top"><input name="CmpGuiaRemisionNumeroSerie" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroSerie" value="<?php echo $InsCompraVehiculo->CvhGuiaRemisionNumeroSerie;?>" size="10" maxlength="50" />
                 -
                 <input name="CmpGuiaRemisionNumeroNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroNumero" value="<?php echo $InsCompraVehiculo->CvhGuiaRemisionNumeroNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top">Fecha de Guia de Remision: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpGuiaRemisionFecha" type="text" id="CmpGuiaRemisionFecha" value="<?php echo $InsCompraVehiculo->CvhGuiaRemisionFecha; ?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnGuiaRemisionFecha" name="BtnGuiaRemisionFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Guia Remision Escaneada:</td>
               <td colspan="3"><iframe src="formularios/CompraVehiculo/acc/AccCompraVehiculoGuiaRemisionFotoSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrCompraVehiculoGuiaRemisionFotoSubirArchivo" name="IfrCompraVehiculoGuiaRemisionFotoSubirArchivo" scrolling="auto"  frameborder="0"  width="400" height="200"></iframe></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Observacion:</td>
               <td><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsCompraVehiculo->CvhObservacion;?></textarea></td>
               <td align="left" valign="top">Almacen Destino:</td>
               <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsCompraVehiculo->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Estado: </td>
               <td><?php
					switch($InsCompraVehiculo->CvhEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
		
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">No Realizado</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                 </select></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales:</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top"><input type="checkbox" name="CmpNotificar" id="CmpNotificar" value="1"  />
                 Notificar via email</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">
           <div class="EstFormularioArea">
             
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="98%">
                   
                   
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="19"><span class="EstFormularioSubTitulo">VEHICULOS</span>
                         <input name="CmpVehiculoId"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoId" size="10" maxlength="20" />
                         <input type="hidden" name="CmpVehiculoItem" id="CmpVehiculoItem" />
                         <input type="hidden" name="CmpVehiculoCostoAnterior" id="CmpVehiculoCostoAnterior" />
                         <input type="hidden" name="CmpVehiculoUnidadMedida" id="CmpVehiculoUnidadMedida" />
                         <input name="CmpVehiculoUnidadMedidaEquivalente"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoUnidadMedidaEquivalente" size="3" maxlength="20"  />
                         <input name="CmpCompraVehiculoDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpCompraVehiculoDetalleId" size="3" maxlength="20"  /></td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><div id="CapVehiculoIngresoBuscar2"></div></td>
                       <td>VIN:</td>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">Codigo Unico:</td>
                       <td align="left" valign="top">Marca:</td>
                       <td align="left" valign="top">Modelo:
                         <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsCotizacionVehiculo->VmoId;?>" size="3" /></td>
                       <td align="left" valign="top">Version:
                         <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsCotizacionVehiculo->VveId;?>" size="3" /></td>
                       <td>Color Exterior:</td>
                       <td>Color Interior:</td>
                       <td align="left" valign="top">A&ntilde;o /Fab.</td>
                       <td align="left">A&ntilde;o/Mod.</td>
                       <td>U.M.</td>
                       <td>Cantidad:</td>
                       <td>Valor Unit. :</td>
                       <td>Valor Total</td>
                       <td>Estado:</td>
                       <td><div id="CapVehiculoIngresoBuscar"></div></td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncVehiculoIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td valign="middle"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="" size="20" maxlength="30" /></td>
                       <td valign="middle"><a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td align="left" valign="middle"><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                       <td align="left" valign="middle"><input class="EstFormularioCaja" name="CmpVehiculoCodigo" type="text" id="CmpVehiculoCodigo" size="8" maxlength="30" /></td>
                       <td align="left" valign="middle"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                         <option value="">Escoja una opcion</option>
                         <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                         <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsCotizacionVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                         <?php
			}
			?>
                       </select></td>
                       <td align="left" valign="middle"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                       </select></td>
                       <td align="left" valign="middle"><select  disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                       </select></td>
                       <td valign="middle"><input name="CmpVehiculoColor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoColor" size="8" maxlength="30" readonly="readonly" /></td>
                       <td valign="middle"><input name="CmpVehiculoColorInterior" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoColorInterior" size="8" maxlength="30" readonly="readonly" /></td>
                       <td align="left" valign="middle"><input name="CmpAnoFabricacion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAnoFabricacion" size="7" maxlength="4" readonly="readonly" /></td>
                       <td align="left" valign="middle"><input name="CmpAnoModelo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAnoModelo" size="7" maxlength="4" readonly="readonly" /></td>
                       <td><select  class="EstFormularioCombo" name="CmpVehiculoUnidadMedidaConvertir" id="CmpVehiculoUnidadMedidaConvertir" disabled="disabled">
                       </select></td>
                       <td><input name="CmpVehiculoCantidad" type="text" class="EstFormularioCaja" id="CmpVehiculoCantidad" size="10" maxlength="10" />                   </td>
                       <td><input name="CmpVehiculoCostoIngresoNeto" type="text" class="EstFormularioCaja" id="CmpVehiculoCostoIngresoNeto"  size="10" maxlength="10" readonly="readonly" />                   </td>
                       <td><input name="CmpVehiculoImporte" type="text" class="EstFormularioCaja" id="CmpVehiculoImporte" size="10" maxlength="10" />                   </td>
                       <td><select  class="EstFormularioCombo" name="CmpCompraVehiculoDetalleEstado" id="CmpCompraVehiculoDetalleEstado">
                         <option value="0">-</option>
                         <option value="1">No Llego</option>
                         <option value="2">Da&ntilde;ado</option>
                         <option selected="selected" value="3">Conforme</option>
                       </select></td>
                       <td><a href="javascript:FncCompraVehiculoDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                       <td><!--<a href="comunes/Vehiculo/FrmVehiculoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>--></td>
                     </tr>
                     </table>             </td>
                 </tr>
               </table>
             </div>         </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapVehiculoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncCompraVehiculoDetalleListar();">
                 <input type="hidden" name="CmpCompraVehiculoDetalleAccion" id="CmpCompraVehiculoDetalleAccion" value="AccCompraVehiculoDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
               
               <!--<a href="javascript:FncCompraVehiculoDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>-->
               
               
               </td>
               <td width="1%"><div id="CapCompraVehiculoDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCompraVehiculoDetalles" class="EstCapCompraVehiculoDetalles" > </div></td>
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
    

    <div id="tab2" class="tab_content">
      <!--Content-->
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
    <div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago</span></td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top">Proveedor:</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">
                 <select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                   <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCompraVehiculo->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                   <?php
			}
			?>
                 </select>
:
<input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsCompraVehiculo->PrvId;?>" size="3" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></a></td>
                   <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsCompraVehiculo->PrvNumeroDocumento;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td> <a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar','','');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar','','');" href="javascript:void(0)"   title="">
                     <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> 
                     </a>
                     
                     </td>
                   <td><div id="CapProveedorBuscar"></div></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">Proveedor:</td>
               <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsCompraVehiculo->PrvNombreCompleto;?>" size="45" maxlength="255"  />                 <a href="formularios/CompraVehiculo/FrmProveedorBuscar.php?height=440&width=850" class="thickbox" title="">
                   <img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                 
                 </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top">Comporbante:</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Comprobante:</td>
               <td align="left" valign="top"><span id="spryselect3">
                 <select class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                   <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsCompraVehiculo->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                   <?php
			}
			?>
                   </select>
                 <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero de Comprobante:</td>
               <td align="left" valign="top">
           <input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsCompraVehiculo->CvhComprobanteNumeroSerie;?>" size="10" maxlength="50" />
-
<input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsCompraVehiculo->CvhComprobanteNumeroNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top">Fecha de Comprobante: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsCompraVehiculo->CvhComprobanteFecha;?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Condicion de Pago:</td>
               <td align="left" valign="top"><select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                 <option <?php if($InsCompraVehiculo->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                 <?php  
					}
					?>
               </select></td>
               <td align="left" valign="top">Cantidad de Dias:</td>
               <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCantidadDia" type="text" id="CmpCantidadDia" size="10" maxlength="3" value="<?php echo $InsCompraVehiculo->CvhCantidadDia;?>" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:                 </td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCompraVehiculo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                       <?php
			  }
			  ?>
                       </select>
                     <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de 
                 
                 Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top">
                 <?php
//	deb($InsCompraVehiculo);
			   ?>
                 
                 <table>
                 <tr>
                 <td>
                 
                 <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCompraVehiculoDetalleListar();" value="<?php if (empty($InsCompraVehiculo->CvhTipoCambio)){ echo "";}else{ echo $InsCompraVehiculo->CvhTipoCambio; } ?>" size="10" maxlength="10" />
                 
                 <input name="CmpTipoCambioComercial" type="hidden"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambioComercial" value="<?php if (empty($InsCompraVehiculo->CvhTipoCambioComercial)){ echo "";}else{ echo $InsCompraVehiculo->CvhTipoCambioComercial; } ?>" size="10" maxlength="10" />
                 
                 
                 </td>
                 <td>
                 
                  <a href="javascript:FncCompraVehiculoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                 </td>
                 </tr>
                 </table>
                 
                 </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" valign="top">Adjuntos:</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Comprobante escaneado:</td>
               <td colspan="3"><iframe src="formularios/CompraVehiculo/acc/AccCompraVehiculoSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrCompraVehiculoSubirArchivo" name="IfrCompraVehiculoSubirArchivo" scrolling="auto"  frameborder="0"  width="400" height="200"></iframe></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
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
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
	
Calendar.setup({ 
	inputField : "CmpComprobanteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteFecha",// el id del botón que  
onUpdate       :    FncTipoCambioCargarAux
	});
	
Calendar.setup({ 
	inputField : "CmpGuiaRemisionFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnGuiaRemisionFecha"// el id del botón que  
	});
	

	

	
</script>



<?php


}else{
	echo ERR_GEN_101;
}


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}
?>
