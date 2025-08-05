<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoVehiculoFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTrasladoVehiculo.css');
</style>


<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrasladoVehiculo.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculoDetalle.php');
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
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');


$InsTrasladoVehiculo = new ClsTrasladoVehiculo();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsTrasladoVehiculoDetalle'.$Identificador])){	
	$_SESSION['InsTrasladoVehiculoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrasladoVehiculoDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrasladoVehiculoEditar.php');

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"2,3,4");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];


$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

//deb($InsTrasladoVehiculo);
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

	
	FncTrasladoVehiculoDetalleListar();
		
	FncTrasladoVehiculoFotoListar();
	
});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncTrasladoVehiculoDetalleListar";
var TrasladoVehiculoDetalleEditar = 1;
var TrasladoVehiculoDetalleEliminar = 1;


var TrasladoVehiculoFotoEditar = 1;
var TrasladoVehiculoFotoEliminar = 1;
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
        TRASLADO DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Traslado de Vehiculo</a></li>
	
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoVehiculo->TveTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoVehiculo->TveTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Traslado de Vehiculo
                 
                 
                 
                 
                 
                 
                 
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
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTrasladoVehiculo->TveId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Responsable:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsTrasladoVehiculo->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha de Traslado: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsTrasladoVehiculo->TveFecha)){ echo date("d/m/Y");}else{ echo $InsTrasladoVehiculo->TveFecha; }?>" size="10" maxlength="10" />
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">Fecha de Llegada: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaLlegada" type="text" id="CmpFechaLlegada" value="<?php if(empty($InsTrasladoVehiculo->TveFechaLlegada)){ echo date("d/m/Y");}else{ echo $InsTrasladoVehiculo->TveFechaLlegada; }?>" size="10" maxlength="10" />
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaLlegada" name="BtnFechaLlegada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsTrasladoVehiculo->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Comprobante:</td>
               <td colspan="3" align="left" valign="top"><select class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                 <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsTrasladoVehiculo->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Referencia:</td>
               <td align="left" valign="top"><input name="CmpReferenciaSerie" type="text" class="EstFormularioCaja" id="CmpReferenciaSerie" value="<?php echo $InsTrasladoVehiculo->TveReferenciaSerie;?>" size="10" maxlength="50" />
                 -
                 <input name="CmpReferenciaNumero" type="text" class="EstFormularioCaja" id="CmpReferenciaNumero" value="<?php echo $InsTrasladoVehiculo->TveReferenciaNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top"><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpClienteId" id="CmpClienteId"  value="<?php echo $InsTrasladoVehiculo->CliId;?>" />
                 </span><span class="EstFormularioSubTitulo">
                   <input type="hidden" name="CmpProveedorId" id="CmpProveedorId"  value="<?php echo $InsTrasladoVehiculo->PrvId;?>" />
                   <input type="hidden" name="CmpMonedaId" id="CmpMonedaId"  value="<?php echo $InsTrasladoVehiculo->MonId;?>" />
                   <input type="hidden" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  value="<?php echo $InsTrasladoVehiculo->TveIncluyeImpuesto;?>" />
                 </span><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsTrasladoVehiculo->TvePorcentajeImpuestoVenta;?>" />
                 </span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Sucursal Origen:</td>
               <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                 <option value="">Escoja una opcion</option>
                 <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                 <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsTrasladoVehiculo->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
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
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoVehiculo->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpSucursalDestino" id="CmpSucursalDestino">
                   <option value="">Escoja una opcion</option>
                   <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                   <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsTrasladoVehiculo->SucIdDestino==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                   <?php
    }
    ?>
                   </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionInterna" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionInterna"><?php echo $InsTrasladoVehiculo->TveObservacionInterna;?></textarea></td>
               <td align="left" valign="top">Observacion Impresa:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsTrasladoVehiculo->TveObservacionImpresa;?></textarea></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Estado: </td>
               <td><?php
					switch($InsTrasladoVehiculo->TveEstado){
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
               <td align="left" valign="top">Doc. Ref.:</td>
               <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                 <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="48%"><a href="javascript:FncTrasladoVehiculoFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrasladoVehiculoFotoEliminarTodo();"></a></td>
                     <td width="50%" align="right"><div class="EstFormularioAccion" id="CapTrasladoVehiculoFotosAccion">Listo
                       para registrar elementos</div></td>
                     <td width="1%">&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                       <tr>
                         <td width="275" colspan="2" align="left" valign="top"><div id="fileUploadTrasladoVehiculoFoto">Escoger Archivo</div>
                           <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadTrasladoVehiculoFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/TrasladoVehiculo/acc/AccTrasladoVehiculoFotoSubir.php",
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
												FncTrasladoVehiculoFotoListar ();
											}
							
										});
									});
									  
									</script></td>
                         <td width="4" align="left" valign="top">&nbsp;</td>
                         </tr>
                       <tr>
                         <td colspan="2" align="left" valign="top"><div class="EstCapTrasladoVehiculoFotos" id="CapTrasladoVehiculoFotos"></div></td>
                         <td align="left" valign="top">&nbsp;</td>
                         </tr>
                       </table></td>
                     <td><div id="CapTrasladoVehiculoFotosResultado"> </div></td>
                     </tr>
                   </table>
                 </div></td>
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
                       <td colspan="17"><span class="EstFormularioSubTitulo">VEHICULOS</span>
                         <input name="CmpVehiculoId"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoId" size="10" maxlength="20" />
                         <input type="hidden" name="CmpVehiculoItem" id="CmpVehiculoItem" />
                         <input type="hidden" name="CmpVehiculoCostoAnterior" id="CmpVehiculoCostoAnterior" />
                         <input type="hidden" name="CmpVehiculoUnidadMedida" id="CmpVehiculoUnidadMedida" />
                         <input name="CmpVehiculoUnidadMedidaEquivalente"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoUnidadMedidaEquivalente" size="3" maxlength="20"  />
                         <input name="CmpTrasladoVehiculoDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpTrasladoVehiculoDetalleId" size="3" maxlength="20"  /></td>
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
                       <td valign="top">Cant.</td>
                       <td valign="top">Observaciones:</td>
                       <td valign="top">Estado:</td>
                       <td valign="top">&nbsp;</td>
                       <td valign="top">&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncTrasladoVehiculoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
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
                       <td valign="middle"><input name="CmpTrasladoVehiculoDetalleCantidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpTrasladoVehiculoDetalleCantidad" value="1" size="7" maxlength="4" readonly="readonly" /></td>
                       <td valign="middle"><input class="EstFormularioCaja" name="CmpTrasladoVehiculoDetalleObservacion" type="text" id="CmpTrasladoVehiculoDetalleObservacion" size="25" maxlength="30" /></td>
                       <td valign="middle"><select  class="EstFormularioCombo" name="CmpTrasladoVehiculoDetalleEstado" id="CmpTrasladoVehiculoDetalleEstado">
                         <option value="0">-</option>
                       <!--  <option value="1">No Llego</option>
                         <option value="2">Da&ntilde;ado</option>-->
                         <option selected="selected" value="3">Conforme</option>
                       </select></td>
                       <td><a href="javascript:FncTrasladoVehiculoDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="49%" align="right"><a href="javascript:FncTrasladoVehiculoDetalleListar();">
                 <input type="hidden" name="CmpTrasladoVehiculoDetalleAccion" id="CmpTrasladoVehiculoDetalleAccion" value="AccTrasladoVehiculoDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
               
               <!--<a href="javascript:FncTrasladoVehiculoDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>-->
               
               
               </td>
               <td width="1%"><div id="CapTrasladoVehiculoDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapTrasladoVehiculoDetalles" class="EstCapTrasladoVehiculoDetalles" > </div></td>
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
	inputField : "CmpFechaLlegada",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaLlegada"// el id del botón que  
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
