<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoProducto",$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoProducto","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoProducto","Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Producto');?>JsListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoProductoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoProductoFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTrasladoProducto.css');
</style>
   
<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrasladoProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProductoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');

$InsTrasladoProducto = new ClsTrasladoProducto();
$InsTipoOperacion = new ClsTipoOperacion();

$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();

$InsClienteTipo = new ClsClienteTipo();
$InsProducto = new ClsProducto();

$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsComprobanteTipo = new ClsComprobanteTipo();


if (isset($_SESSION['InsTrasladoProductoDetalle'.$Identificador])){	
	$_SESSION['InsTrasladoProductoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrasladoProductoDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrasladoProductoEditar.php');

// MtdObtenerTipoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TopId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"4");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,"PmaNombre","ASC",1,NULL);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];


$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];


//MtdObtenerComprobanteTipos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CtiId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oUso=NULL)
$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL,NULL,1);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

?>


<?php
//if($InsTrasladoProducto->TptFactura=="No"){
if(1 == 1){	
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

	FncTrasladoProductoDetalleListar();
	
	FncTrasladoProductoFotoListar();
	
});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var TrasladoProductoDetalleEditar = 1;
var TrasladoProductoDetalleEliminar = 1;

var TrasladoProductoFotoEditar = 1;
var TrasladoProductoFotoEliminar = 1;

var UnidadMedidaTipo = 2;
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
	



<?php
if($Edito){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsTrasladoProducto->TptId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsTrasladoProducto->TptId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>

<?php	
}
?>
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        TRASLADO DE PRODUCTO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoProducto->TptTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoProducto->TptTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1">Traslado de Producto</a></li>
 

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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Traslado de Producto
                 
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
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTrasladoProducto->TptId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Responsable</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsTrasladoProducto->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha de Salida:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsTrasladoProducto->TptFecha)){ echo date("d/m/Y");}else{ echo $InsTrasladoProducto->TptFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Llegada: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFechaLlegada" type="text" class="EstFormularioCajaFecha" id="CmpFechaLlegada" value="<?php if(empty($InsTrasladoProducto->TptFechaLlegada)){ echo date("d/m/Y");}else{ echo $InsTrasladoProducto->TptFechaLlegada; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsTrasladoProducto->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Comprobante:</td>
               <td colspan="3" align="left" valign="top"><select class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                 <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsTrasladoProducto->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Referencia:</td>
               <td align="left" valign="top"><input name="CmpReferenciaSerie" type="text" class="EstFormularioCaja" id="CmpReferenciaSerie" value="<?php echo $InsTrasladoProducto->TptReferenciaSerie;?>" size="10" maxlength="50" />
                 -
                 <input name="CmpTransferenciaNumero" type="text" class="EstFormularioCaja" id="CmpTransferenciaNumero" value="<?php echo $InsTrasladoProducto->TptReferenciaNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top"><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpClienteId" id="CmpClienteId"  value="<?php echo $InsTrasladoProducto->CliId;?>" />
               </span><span class="EstFormularioSubTitulo">
               <input type="hidden" name="CmpProveedorId" id="CmpProveedorId"  value="<?php echo $InsTrasladoProducto->PrvId;?>" />
               <input type="hidden" name="CmpMonedaId" id="CmpMonedaId"  value="<?php echo $InsTrasladoProducto->MonId;?>" />
               <input type="hidden" name="CmpIncluyeImpuesto2" id="CmpIncluyeImpuesto2"  value="<?php echo $InsTrasladoProducto->TptIncluyeImpuesto;?>" />
               </span><span class="EstFormularioSubTitulo">
               <input type="hidden" name="CmpPorcentajeImpuestoVenta2" id="CmpPorcentajeImpuestoVenta2"  value="<?php echo $InsTrasladoProducto->TptPorcentajeImpuestoVenta;?>" />
               </span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Sucursal Origen:</td>
               <td align="left" valign="top"><select  disabled="disabled"  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                 <option value="">Escoja una opcion</option>
                 <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                 <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsTrasladoProducto->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                 <?php
    }
    ?>
               </select></td>
               <td align="left" valign="top">Sucursal Destino:</td>
               <td align="left" valign="top"><!--<select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoProducto->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpSucursalDestino" id="CmpSucursalDestino">
                   <option value="">Escoja una opcion</option>
                   <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                   <?php
//	if($DatSucursal->SucId<>$_SESSION['SesionSucursal']){
	?>
                   <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsTrasladoProducto->SucIdDestino==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                   <?php	
	//}
	?>
                   <?php
   }
    ?>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observaciones:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsTrasladoProducto->TptObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: <span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  value="<?php echo $InsTrasladoProducto->TptIncluyeImpuesto;?>" />
                 <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsTrasladoProducto->TptPorcentajeImpuestoVenta;?>" />
                 <input type="hidden" name="CmpDescuento" id="CmpDescuento"  value="<?php echo $InsTrasladoProducto->TptDescuento;?>" />
               </span></td>
               <td align="left" valign="top"><?php
					switch($InsTrasladoProducto->TptEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">No Realizado</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Doc. Ref.:</td>
               <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                 <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="48%"><a href="javascript:FncTrasladoProductoFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrasladoProductoFotoEliminarTodo();"></a></td>
                     <td width="50%" align="right"><div class="EstFormularioAccion" id="CapTrasladoProductoFotosAccion">Listo
                       para registrar elementos</div></td>
                     <td width="1%">&nbsp;</td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                       <tr>
                         <td width="275" colspan="2" align="left" valign="top"><div id="fileUploadTrasladoProductoFoto">Escoger Archivo</div>
                           <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadTrasladoProductoFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/TrasladoProducto/acc/AccTrasladoProductoFotoSubir.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:false,
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
												FncTrasladoProductoFotoListar ();
											}
							
										});
									});
									  
									</script></td>
                         <td width="4" align="left" valign="top">&nbsp;</td>
                       </tr>
                       <tr>
                         <td colspan="2" align="left" valign="top"><div class="EstCapTrasladoProductoFotos" id="CapTrasladoProductoFotos"></div></td>
                         <td align="left" valign="top">&nbsp;</td>
                       </tr>
                     </table></td>
                     <td><div id="CapTrasladoProductoFotosResultado"> </div></td>
                   </tr>
                 </table>
               </div></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales:</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top"><input <?php echo (!empty($InsTrasladoProducto->OcoId)?'checked="checked"':'');?>  type="checkbox" name="CmpNotificar" id="CmpNotificar" value="1"  />
                 Notificar via email</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
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
                       <td colspan="11"><span class="EstFormularioSubTitulo">PRODUCTOS
                         
                         
                           <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpTrasladoProductoDetalleId"  class="EstFormularioCaja" id="CmpTrasladoProductoDetalleId"  />
                       </span></td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><div id="CapProductoBuscar"></div></td>
                       <td>C&oacute;digo Orig.</td>
                       <td>&nbsp;</td>
                       <td>C&oacute;digo Alt.</td>
                       <td>&nbsp;</td>
                       <td>Nombre : </td>
                       <td>&nbsp;</td>
                       <td>U.M.</td>
                       <td>Cantidad:</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncTrasladoProductoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                       <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                       <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                       <td>
                       <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                       
                       </td>
                       <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                       </select></td>
                       <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10"  /></td>
                       <td><a href="javascript:FncTrasladoProductoDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                       <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a></td>
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
               <td width="1%"><input type="hidden" name="CmpTrasladoProductoDetalleAccion" id="CmpTrasladoProductoDetalleAccion" value="AccTrasladoProductoDetalleRegistrar.php" /></td>
               <td width="50%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="47%" align="right"><a href="javascript:FncTrasladoProductoDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrasladoProductoDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="2%"><div id="CapTrasladoProductoDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapTrasladoProductoDetalles" class="EstCapTrasladoProductoDetalles" > </div></td>
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
//Calendar.setup({ 
//	inputField : "CmpFecha",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFecha"// el id del botón que  
//	});
</script>
<?php
}else{
	echo ERR_TPT_601;
}
?>


<?php


}else{
	echo ERR_GEN_101;
}
if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();?>
