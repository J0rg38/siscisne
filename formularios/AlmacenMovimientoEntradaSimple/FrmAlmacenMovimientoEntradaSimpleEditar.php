<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada",$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaSimpleDetalleFunciones.js" ></script>



<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenMovimientoEntradaSimple.css');
</style>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenMovimientoEntradaSimple.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');



require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');


$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador])){	
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]);
}



include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenMovimientoEntradaSimpleEditar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"1,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsAlmacenMovimientoEntrada->SucId);
$ArrAlmacenes = $RepAlmacen['Datos'];


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
	
	FncAlmacenMovimientoEntradaSimpleEstablecerMoneda();
	
	FncAlmacenMovimientoEntradaSimpleDetalleListar();
		
	
		
});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncAlmacenMovimientoEntradaSimpleDetalleListar";

var AlmacenMovimientoEntradaSimpleDetalleEditar = 1;
var AlmacenMovimientoEntradaSimpleDetalleEliminar = <?php echo (empty($InsAlmacenMovimientoEntrada->OcoId)?1:2);?>;
</script>




















<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">


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
	



    
      
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        INGRESO A ALMACEN X OTRO CONCEPTO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Entrada a Almacen</a></li>
	
	
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoEntrada->AmoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoEntrada->AmoTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Entrada a Almacen
                 
                 
                 
                 
                 
                 
                 
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
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacenMovimientoEntrada->AmoId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Ingreso: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield1">
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoFecha)){ echo date("d/m/Y");}else{ echo $InsAlmacenMovimientoEntrada->AmoFecha; }?>" size="10" maxlength="10" />
                 </label>
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top"><span id="spryselect">
                 <select class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                   <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsAlmacenMovimientoEntrada->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                   <?php
			}
			?>
                   </select>
                 <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
               <td align="left" valign="top">Almacen Destino:</td>
               <td align="left" valign="top"><span id="spryselect4">
                 <select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                   <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsAlmacenMovimientoEntrada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                   <?php
			}
			?>
                 </select>
                 <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Entrada a Almacen</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proveedor:</td>
               <td colspan="3" align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsAlmacenMovimientoEntrada->PrvId;?>" size="3" /></td>
                   <td><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                   </select></td>
                   <td> <a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a> </td>
                   <td><span id="sprytextfield21">
                     <input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;?>" size="20" maxlength="50" />
                     <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                   <td><span id="sprytextfield5">
                     <label>
                       <input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreCompleto;?>" size="45" maxlength="255"  />
                     </label>
                     <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                   <td>
                   
                   
                   
                   
                             <a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar','','');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar','','');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                            
                            
                            <a href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&width=850" class="thickbox" title="">
                            <img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                     
                     
                     </td>
                 </tr>
                 <tr> </tr>
               </table></td>
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
                   <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsAlmacenMovimientoEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
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
               <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroSerie;?>" size="10" maxlength="50" /> 
                 -
                   <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top">Fecha de Comprobante: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;?>" size="10" maxlength="10" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda: </td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
               <td align="left" valign="top"><?php
//	deb($InsAlmacenMovimientoEntrada);
			   ?>
                 <table>
                   <tr>
                     <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncAlmacenMovimientoEntradaSimpleDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoEntrada->AmoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                     <td>
                     
                     
                     
                     
                     <a href="javascript:FncAlmacenMovimientoEntradaSimpleEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                   
                     
                     
                     </td>
                     </tr>
                   </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Observacion:</td>
               <td><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAlmacenMovimientoEntrada->AmoObservacion;?></textarea></td>
               <td valign="top">Estado: </td>
               <td><?php
					switch($InsAlmacenMovimientoEntrada->AmoEstado){
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
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Comprobante escaneado:</td>
               <td><iframe src="formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrAlmacenMovimientoEntradaSubirArchivo" name="IfrAlmacenMovimientoEntradaSubirArchivo" scrolling="Auto"  frameborder="0"  width="400" height="200"></iframe></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">&nbsp;</td>
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
                       <td colspan="14"><span class="EstFormularioSubTitulo">PRODUCTOS</span>
                         <input name="CmpProductoId"  type="hidden" class="EstFormularioCaja" id="CmpProductoId" size="10" maxlength="20" />
                         <input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
                         <input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />
                         <input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
                         <input name="CmpProductoUnidadMedidaEquivalente"  type="hidden" class="EstFormularioCaja" id="CmpProductoUnidadMedidaEquivalente" size="3" maxlength="20"  />
                         <input name="CmpProductoAlmacenMovimientoDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpProductoAlmacenMovimientoDetalleId" size="3" maxlength="20"  /></td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>Estado:</td>
                       <td><div id="CapProductoBuscar2"></div></td>
                       <td>C&oacute;digo Orig.</td>
                       <td>&nbsp;</td>
                       <td>C&oacute;digo Alt.</td>
                       <td>&nbsp;</td>
                       <td>Nombre : </td>
                       <td>&nbsp;</td>
                       <td>U.M.</td>
                       <td>Cantidad:</td>
                       <td>Valor Unitario :</td>
                       <td>Valor Total</td>
                       <td><div id="CapProductoBuscar"></div></td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><select  class="EstFormularioCombo" name="CmpAlmacenMovimientoDetalleEstado" id="CmpAlmacenMovimientoDetalleEstado">
                         <option value="0">-</option>
                         <option value="1">No Llego</option>
                         <option value="2">Da&ntilde;ado</option>
                         <option selected="selected" value="3">Conforme</option>
                       </select></td>
                       <td><a href="javascript:FncAlmacenMovimientoEntradaSimpleDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a> </td>
                       <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                       <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                       <td> <a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a> </td>
                       <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                       <td>
                       
                       
                        
                           <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a>
                              <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                         
                         
                         </td>
                       <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir" disabled="disabled">
                       </select></td>
                       <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10" />                   </td>
                       <td><input name="CmpProductoCostoIngresoNeto" type="text" class="EstFormularioCaja" id="CmpProductoCostoIngresoNeto"  size="10" maxlength="10" readonly="readonly" />                   </td>
                       <td><input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="10" maxlength="10" />                   </td>
                       <td>  <a href="javascript:FncAlmacenMovimientoEntradaSimpleDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a>
                       </td>
                       <td><!--<a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>--></td>
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
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncAlmacenMovimientoEntradaSimpleDetalleListar();">
                 <input type="hidden" name="CmpAlmacenMovimientoEntradaSimpleDetalleAccion" id="CmpAlmacenMovimientoEntradaSimpleDetalleAccion" value="AccAlmacenMovimientoEntradaSimpleDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncAlmacenMovimientoEntradaSimpleDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
               
               
               </td>
               <td width="1%"><div id="CapAlmacenMovimientoEntradaSimpleDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapAlmacenMovimientoEntradaSimpleDetalles" class="EstCapAlmacenMovimientoEntradaSimpleDetalles" > </div></td>
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
	
	
Calendar.setup({ 
	inputField : "CmpComprobanteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteFecha",// el id del botón que  
onUpdate       :    FncTipoCambioCargarAux
	});

</script>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect = new Spry.Widget.ValidationSelect("spryselect");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield21 = new Spry.Widget.ValidationTextField("sprytextfield21");
</script>


<?php


}else{
	echo ERR_GEN_101;
}


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}
?>
