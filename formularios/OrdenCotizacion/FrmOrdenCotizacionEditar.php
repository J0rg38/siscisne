<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCotizacionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCotizacionDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCotizacion.css');
</style>

   
<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCotizacion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacionDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsOrdenCotizacion = new ClsOrdenCotizacion();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsOrdenCotizacionDetalle'.$Identificador])){	
	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCotizacionDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCotizacionEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];



//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL) {
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,$_SESSION['SesionSucursal'],1);
$ArrPersonales = $ResPersonal['Datos'];

?>


<?php
//if($InsOrdenCotizacion->OotFactura=="No"){
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

	$('#CmpProductoCodigoOriginal').focus();

	FncOrdenCotizacionDetalleListar();
	
});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var OrdenCotizacionDetalleEditar = 1;
var OrdenCotizacionDetalleEliminar = 1;
var OrdenCotizacionDetalleVerEstado = 2;

var UnidadMedidaTipo = 2;
</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();"> 


<div class="EstCapMenu">

           
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div> 
<?php	
}
?>
	



<?php
if($Edito){
?>

	<?php
  /*  if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsOrdenCotizacion->OotId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsOrdenCotizacion->OotId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        SOLICITUD DE COTIZACION</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCotizacion->OotTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCotizacion->OotTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1"> Solicitud de Cotizacion</a></li>
 

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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Cotizacion 
                 
                 
                 
                 
                 
                 
                 
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
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenCotizacion->OotId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proveedor:
                 <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsOrdenCotizacion->PrvId;?>" size="3" /></td>
               <td colspan="3" align="left" valign="top"><table>
                 <tr>
                   <td><select <?php if(!empty($InsOrdenCotizacion->PrvId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsOrdenCotizacion->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                     </select></td>
                   <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input <?php if(!empty($InsOrdenCotizacion->PrvId)){ echo 'readonly="readonly"';} ?> name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsOrdenCotizacion->PrvNumeroDocumento;?>" size="15" maxlength="50" /></td>
                   <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input <?php if(!empty($InsOrdenCotizacion->PrvId)){ echo 'readonly="readonly"';} ?> class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsOrdenCotizacion->PrvNombreCompleto;?>" size="35" maxlength="255"  />
                     <a href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a></td>
                   <td><a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsOrdenCotizacion->OotFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCotizacion->OotFecha; }?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">Hora:<br />
                 <span class="EstFormularioSubEtiqueta">(00:00:00)</span></td>
               <td align="left" valign="top"><input  class="EstFormularioCajaHora" name="CmpHora" type="text" id="CmpHora" value="<?php if (empty($InsOrdenCotizacion->OotHora)){ echo "";}else{ echo $InsOrdenCotizacion->OotHora; } ?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha Respuesta<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaRespuesta" type="text" id="CmpFechaRespuesta" value="<?php  echo $InsOrdenCotizacion->OotFechaRespuesta;?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaRespuesta" name="BtnFechaRespuesta" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Solicitante:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsOrdenCotizacion->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
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
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenCotizacion->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                       <?php
			  }
			  ?>
                       </select>
                     <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
               </table></td>
               <td align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncOrdenCotizacionDetalleListar();" value="<?php if (empty($InsOrdenCotizacion->OotTipoCambio)){ echo "";}else{ echo $InsOrdenCotizacion->OotTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                   <td><a href="javascript:FncOrdenCotizacionEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Incluye Impuesto:</td>
               <td align="left" valign="top"><?php
switch($InsOrdenCotizacion->OotIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
                 <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"   >
                   <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                   <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                   </select></td>
               <td align="left" valign="top">Impuesto (%):</td>
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncFacturaDetalleListar();" value="<?php echo $InsOrdenCotizacion->OotPorcentajeImpuestoVenta;?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenCotizacion->OotObservacion;?></textarea></td>
               <td align="left" valign="top">Referencia:</td>
               <td align="left" valign="top"><input  class="EstFormularioCaja" name="CmpCodigoReferencia" type="text" id="CmpCodigoReferencia" value="<?php echo $InsOrdenCotizacion->OotCodigoReferencia;?>" size="20" maxlength="30" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsOrdenCotizacion->OotEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 31:
							$OpcEstado31 = 'selected = "selected"';						
						break;
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled" >
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   <option <?php echo $OpcEstado31;?> value="31">Enviado/Correo</option>
                   <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
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
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">
           
                               <?php
					//if($InsOrdenCotizacion->OotOrigen<>"VDI"){
					?>
           <div class="EstFormularioArea">
             
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="98%">
                   
                   
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="12"><span class="EstFormularioSubTitulo">PRODUCTOS</span>
                         <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpOrdenCotizacionDetalleId"  class="EstFormularioCaja" id="CmpOrdenCotizacionDetalleId"  />
                      
                       
                       <input type="hidden" name="CmpPeddoCompraDetalleEstado" id="CmpPeddoCompraDetalleEstado" value="1" /></td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><div id="CapProductoBuscar"></div></td>
                       <td>C&oacute;digo Orig.</td>
                       <td>&nbsp;</td>
                       <td>Nombre : </td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>U.M.</td>
                       <td>A&ntilde;o:</td>
                       <td>Modelo:</td>
                       <td>Precio Cotizado:</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                  
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncOrdenCotizacionDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                       <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                       <td>
                        <?php
							if(empty($InsOrdenCotizacion->VdiId)){
							?> 
                       <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                       
                       
                       
                         <?php
							}
					   ?>
                       
                       
                       </td>
                       <td><a id="BtnProductoConsulta" onclick="FncProductoCargarFormulario('Consulta');" href="javascript:void(0)"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" /> </a></td>
                       <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                       </select></td>
                       <td><input name="CmpOrdenCotizacionDetalleAno" type="text" class="EstFormularioCaja" id="CmpOrdenCotizacionDetalleAno" size="5" maxlength="4"  /></td>
                       <td><input name="CmpOrdenCotizacionDetalleModelo" type="text" class="EstFormularioCaja" id="CmpOrdenCotizacionDetalleModelo" size="15" maxlength="45"  /></td>
                       <td><input name="CmpOrdenCotizacionDetallePrecio" type="text" class="EstFormularioCaja" id="CmpOrdenCotizacionDetallePrecio" size="10" maxlength="10"  /></td>
                       <td><a href="javascript:FncOrdenCotizacionDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                       <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                     </tr>   <tr>
                       <td>&nbsp;</td>
                       <td colspan="11"><input type="checkbox" name="CmpOrdenCotizacionDetalleEstatico" id="CmpOrdenCotizacionDetalleEstatico" value="1" />
                         Mantener estatico A&ntilde;o y Modelo</td>
                       <td>&nbsp;</td>
                     </tr>
                     </table>             </td>
                 </tr>
               </table>
             </div>        
             <?php
				//	}
			 ?>
             
              </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncOrdenCotizacionDetalleListar();">
                 <input type="hidden" name="CmpOrdenCotizacionDetalleAccion" id="CmpOrdenCotizacionDetalleAccion" value="AccOrdenCotizacionDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 
  <?php
					if($InsOrdenCotizacion->OotOrigen<>"VDI" and empty($InsOrdenCotizacion->OcoId)){
					?>
                 <a href="javascript:FncOrdenCotizacionDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                 <?php
					}
					?>
                 </td>
               <td width="1%"><div id="CapOrdenCotizacionDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapOrdenCotizacionDetalles" class="EstCapOrdenCotizacionDetalles" > </div></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
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
Calendar.setup({ 
	inputField : "CmpFechaRespuesta",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaRespuesta"// el id del botón que  
	});
</script>
<script type="text/javascript">
//Calendar.setup({ 
//	inputField : "CmpFecha",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFecha"// el id del botón que  
//	});
//
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<?php
//}else{
//	echo ERR_OOT_601;
//}
?>


<?php
}else{
	echo ERR_GEN_101;
}



if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}
?>
