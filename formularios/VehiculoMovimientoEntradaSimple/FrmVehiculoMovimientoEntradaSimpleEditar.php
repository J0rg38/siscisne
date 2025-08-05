<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoEntrada",$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletarv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaSimpleDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaSimpleAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaSimpleFotoFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoMovimientoEntradaSimple.css');
</style>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoMovimientoEntradaSimple.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntradaDetalle.php');
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
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsVehiculoMovimientoEntrada = new ClsVehiculoMovimientoEntrada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();
$InsUnidadMedida = new ClsUnidadMedida();

if (isset($_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador])){	
	$_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoMovimientoEntradaSimpleEditar.php');

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


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,NULL);	
$ArrUnidadMedidas = $ResUnidadMedida['Datos'];

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
	
	$('#CmpComprobanteNumeroSerie').focus();	


	FncVehiculoMovimientoEntradaEstablecerMoneda();
	
	FncVehiculoMovimientoEntradaSimpleDetalleListar();
		
	
	
	
	FncVehiculoMovimientoEntradaSimpleFotoListar();
	
});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncVehiculoMovimientoEntradaSimpleDetalleListar";

var VehiculoMovimientoEntradaSimpleDetalleEditar = 1;
var VehiculoMovimientoEntradaSimpleDetalleEliminar = 1;

var VehiculoMovimientoEntradaSimpleGuiaRemisionFotoEditar = 1;
var VehiculoMovimientoEntradaSimpleGuiaRemisionFotoEliminar = 1;

var VehiculoMovimientoEntradaSimpleFotoEditar = 1;
var VehiculoMovimientoEntradaSimpleFotoEliminar = 1;

</script>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" >


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
        INGRESO DE UNIDAD VEHICULAR</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Ingreso de Unidad Vehicular</a></li>
	
	
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoMovimientoEntrada->VmvTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoMovimientoEntrada->VmvTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Ingreso de Unidad Vehicular
                 
                 
                 
                 
                 
                 
                 
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoMovimientoEntrada->VmvId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Ingreso: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsVehiculoMovimientoEntrada->VmvFecha)){ echo date("d/m/Y");}else{ echo $InsVehiculoMovimientoEntrada->VmvFecha; }?>" size="10" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsVehiculoMovimientoEntrada->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proveedor:</td>
               <td colspan="3" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsVehiculoMovimientoEntrada->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                     </select>
                     :
  <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsVehiculoMovimientoEntrada->PrvId;?>" size="3" /></td>
                   <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></a></td>
                   <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsVehiculoMovimientoEntrada->PrvNumeroDocumento;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar','','');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar','','');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a></td>
                   <td><input class="EstFormularioCaja" name="CmpProveedorNombreCompleto" type="text" id="CmpProveedorNombreCompleto" value="<?php echo $InsVehiculoMovimientoEntrada->PrvNombreCompleto;?>" size="45" maxlength="255"  />
                     <input name="CmpProveedorNombre" type="hidden" id="CmpProveedorNombre" value="<?php echo $InsVehiculoMovimientoEntrada->PrvNombre;?>" size="3" />
                     <input name="CmpProveedorApellidoPaterno" type="hidden" id="CmpProveedorApellidoPaterno" value="<?php echo $InsVehiculoMovimientoEntrada->PrvApellidoPaterno;?>" size="3" />
<a href="formularios/VehiculoMovimientoEntradaSimple/FrmProveedorBuscar.php?height=440&amp;width=850" class="thickbox" title=""> <img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a></td>
                   </tr>
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
                   <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsVehiculoMovimientoEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
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
               <td align="left" valign="top">Numero Doc. Entrada:</td>
               <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteNumeroSerie;?>" size="10" maxlength="50" />
                 -
                 <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteNumeroNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top">Fecha Doc. Entrada: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteFecha;?>" size="15" maxlength="10" />
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
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
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoMovimientoEntrada->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
                 <table>
                   <tr>
                     <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVehiculoMovimientoEntradaSimpleDetalleListar();" value="<?php if (empty($InsVehiculoMovimientoEntrada->VmvTipoCambio)){ echo "";}else{ echo $InsVehiculoMovimientoEntrada->VmvTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
                       <input name="CmpTipoCambioComercial" type="hidden"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambioComercial" value="<?php if (empty($InsVehiculoMovimientoEntrada->VmvTipoCambioComercial)){ echo "";}else{ echo $InsVehiculoMovimientoEntrada->VmvTipoCambioComercial; } ?>" size="10" maxlength="10" /></td>
                     <td><a href="javascript:FncVehiculoMovimientoEntradaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                   </tr>
                 </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Docuemnto Escaneado:</td>
               <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                 <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="48%"><a href="javascript:FncVehiculoMovimientoEntradaSimpleFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoMovimientoEntradaSimpleFotoEliminarTodo();"></a></td>
                     <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoMovimientoEntradaSimpleFotosAccion">Listo
                       para registrar elementos</div></td>
                     <td width="1%">&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                       <tr>
                         <td width="275" colspan="2" align="left" valign="top"><div id="fileUploadVehiculoMovimientoEntradaSimpleFoto">Escoger Archivo</div>
                           <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoMovimientoEntradaSimpleFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/VehiculoMovimientoEntradaSimple/acc/AccVehiculoMovimientoEntradaSimpleFotoSubir.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tama&ntilde;o no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncVehiculoMovimientoEntradaSimpleFotoListar ();
											}
							
										});
									});
									  
									</script></td>
                         <td width="4" align="left" valign="top">&nbsp;</td>
                         </tr>
                       <tr>
                         <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoMovimientoEntradaSimpleFotos" id="CapVehiculoMovimientoEntradaSimpleFotos"></div></td>
                         <td align="left" valign="top">&nbsp;</td>
                         </tr>
                       </table></td>
                     <td><div id="CapVehiculoMovimientoEntradaSimpleFotosResultado"> </div></td>
                     </tr>
                   </table>
               </div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Observacion:</td>
               <td><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVehiculoMovimientoEntrada->VmvObservacion;?></textarea></td>
               <td align="left" valign="top">Sucursal Destino:</td>
               <td align="left" valign="top"><!--<select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsVehiculoMovimientoEntrada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                   <option value="">Escoja una opcion</option>
                   <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                   <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsVehiculoMovimientoEntrada->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
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
					switch($InsVehiculoMovimientoEntrada->VmvEstado){
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
                         <input name="CmpVehiculoMovimientoEntradaSimpleDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoMovimientoEntradaSimpleDetalleId" size="3" maxlength="20"  />
                         
                           <input name="CmpVehiculoMovimientoEntradaSimpleDetalleCostoIngreso"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoMovimientoEntradaSimpleDetalleCostoIngreso" size="3" maxlength="20"  /> 
                           
                           </td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td valign="top"><div id="CapVehiculoIngresoBuscar"></div></td>
                       <td valign="top">VIN:
                         <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="" size="3" /></td>
                       <td valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">Codigo Unico:
                         <input name="CmpVehiculoId" type="hidden" id="CmpVehiculoId" size="3" /></td>
                       <td align="left" valign="top">Marca:
                         <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" size="3" /></td>
                       <td align="left" valign="top">Modelo:
                         <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" size="3" /></td>
                       <td align="left" valign="top">Version:
                         <input name="CmpVehiculoIngresoVersionId" type="hidden" id="CmpVehiculoIngresoVersionId" size="3" /></td>
                       <td valign="top">Color Exterior:</td>
                       <td valign="top">Color Interior:</td>
                       <td align="left" valign="top">A&ntilde;o /Fab.</td>
                       <td align="left" valign="top">A&ntilde;o/Mod.</td>
                       <td valign="top">U.M.</td>
                       <td valign="top">Cantidad:</td>
                       <td valign="top"> Valor Unit.:</td>
                       <td valign="top"> Valor Total:</td>
                       <td valign="top">Observaciones:</td>
                       <td valign="top">&nbsp;</td>
                       <td valign="top">&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncVehiculoMovimientoEntradaSimpleDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td valign="middle"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="" size="15" maxlength="30" /></td>
                       <td valign="middle"><a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td align="left" valign="middle"><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                       <td align="left" valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoCodigoIdentificador" type="text" id="CmpVehiculoCodigoIdentificador" size="8" maxlength="30" /></td>
                       <td align="left" valign="middle"><input name="CmpVehiculoIngresoMarca" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" size="10" maxlength="30" readonly="readonly" /></td>
                       <td align="left" valign="middle"><input name="CmpVehiculoIngresoModelo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoModelo" size="10" maxlength="30" readonly="readonly" /></td>
                       <td align="left" valign="middle"><input name="CmpVehiculoIngresoVersion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVersion" size="10" maxlength="30" readonly="readonly" /></td>
                       <td valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoColor" type="text" id="CmpVehiculoIngresoColor" size="8" maxlength="30" /></td>
                       <td valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoColorInterior" type="text" id="CmpVehiculoIngresoColorInterior" size="8" maxlength="30" /></td>
                       <td align="left" valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoAnoFabricacion" type="text" id="CmpVehiculoIngresoAnoFabricacion" size="7" maxlength="4" /></td>
                       <td align="left" valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoAnoModelo" type="text" id="CmpVehiculoIngresoAnoModelo" size="7" maxlength="4" /></td>
                       <td valign="middle"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoMovimientoEntradaSimpleDetalleUnidadMedida" id="CmpVehiculoMovimientoEntradaSimpleDetalleUnidadMedida">
                         <option value="">Escoja una opcion</option>
                         <?php
			foreach($ArrUnidadMedidas as $DatUnidadMedida){
			?>
                         <option  value="<?php echo $DatUnidadMedida->UmeId?>"><?php echo $DatUnidadMedida->UmeNombre?></option>
                         <?php
			}
			?>
                       </select></td>
                       <td valign="middle"><input name="CmpVehiculoMovimientoEntradaSimpleDetalleCantidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoMovimientoEntradaSimpleDetalleCantidad" value="1" size="8" maxlength="10" readonly="readonly" /></td>
                       <td valign="middle"><input name="CmpVehiculoMovimientoEntradaSimpleDetalleCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoMovimientoEntradaSimpleDetalleCosto" size="8" maxlength="10" readonly="readonly" /></td>
                       <td valign="middle"><input name="CmpVehiculoMovimientoEntradaSimpleDetalleImporte" type="text" class="EstFormularioCaja" id="CmpVehiculoMovimientoEntradaSimpleDetalleImporte" size="8" maxlength="10" /></td>
                       <td valign="middle"><input class="EstFormularioCaja" name="CmpVehiculoMovimientoEntradaSimpleDetalleObservacion" type="text" id="CmpVehiculoMovimientoEntradaSimpleDetalleObservacion" size="25" maxlength="30" /></td>
                       <td><a href="javascript:FncVehiculoMovimientoEntradaSimpleDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="49%" align="right"><a href="javascript:FncVehiculoMovimientoEntradaSimpleDetalleListar();">
                 <input type="hidden" name="CmpVehiculoMovimientoEntradaSimpleDetalleAccion" id="CmpVehiculoMovimientoEntradaSimpleDetalleAccion" value="AccVehiculoMovimientoEntradaSimpleDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
               
               <!--<a href="javascript:FncVehiculoMovimientoEntradaSimpleDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>-->
               
               
               </td>
               <td width="1%"><div id="CapVehiculoMovimientoEntradaSimpleDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVehiculoMovimientoEntradaSimpleDetalles" class="EstCapVehiculoMovimientoEntradaSimpleDetalles" > </div></td>
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



<?php


}else{
	echo ERR_GEN_101;
}


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}
?>
