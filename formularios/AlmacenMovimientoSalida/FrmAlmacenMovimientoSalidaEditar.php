<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Producto');?>JsListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoSalidaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoSalidaDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenMovimientoSalida.css');
</style>
   
<?php
 $GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenMovimientoSalida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
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
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
$InsTipoOperacion = new ClsTipoOperacion();

$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();

$InsClienteTipo = new ClsClienteTipo();
$InsProducto = new ClsProducto();

$InsAlmacen = new ClsAlmacen();
$InsMoneda = new ClsMoneda();

if (isset($_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador])){	
	$_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenMovimientoSalidaEditar.php');

// MtdObtenerTipoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TopId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"2,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,"PmaNombre","ASC",1,NULL);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];


$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsAlmacenMovimientoSalida->SucId );
$ArrAlmacenes = $RepAlmacen['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

?>


<?php
//if($InsAlmacenMovimientoSalida->AmoFactura=="No"){
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

	FncAlmacenMovimientoSalidaDetalleListar();

});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var AlmacenMovimientoSalidaDetalleEditar = 1;
var AlmacenMovimientoSalidaDetalleEliminar = 1;

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
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsAlmacenMovimientoSalida->AmoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsAlmacenMovimientoSalida->AmoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        SALIDA DE ALMACEN X ORD. TRABAJO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoSalida->AmoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoSalida->AmoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1">Salida de Almacen</a></li>
 

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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Salida de Almacen
                 
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
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacenMovimientoSalida->AmoId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Salida:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><span id="sprytextfield1">
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsAlmacenMovimientoSalida->AmoFecha)){ echo date("d/m/Y");}else{ echo $InsAlmacenMovimientoSalida->AmoFecha; }?>" size="10" maxlength="10" />
                   </label>
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span>
                 
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                 
               </td>
               <td align="left" valign="top">&nbsp;</td>
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
                   <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsAlmacenMovimientoSalida->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                   <?php
			}
			?>
                   </select>
                 <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">
               
               
               <input type="hidden" name="CmpAlmacen" id="CmpAlmacen" value="<?php echo $InsAlmacenMovimientoSalida->AlmId;?>" />
               
                <input type="hidden" name="CmpSucursalId" id="CmpSucursalId" value="<?php echo $InsAlmacenMovimientoSalida->SucId;?>" />
               
               
               
               
               </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda: </td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select   class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoSalida->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                       <?php
			  }
			  ?>
                     </select>
                   </span></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncAlmacenMovimientoSalidaDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoSalida->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoSalida->AmoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                   <td><a href="javascript:FncAlmacenMovimientoSalidaEstablecerMoneda();"></a></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Descuento:</td>
               <td align="left" valign="top"><input name="CmpDescuento" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpDescuento" onchange="FncAlmacenMovimientoSalidaDetalleListar();" value="<?php echo number_format($InsAlmacenMovimientoSalida->AmoDescuento,2);?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">Tipo de Cliente:</td>
               <td align="left" valign="top"><select  <?php echo ( (!empty($InsAlmacenMovimientoSalida->FinId) or !empty($InsAlmacenMovimientoSalida->VdiId) )?'disabled="disabled"':'');?>    class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                 <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsAlmacenMovimientoSalida->LtiId == $DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
                 <?php
			}
			?>
               </select>
                 <!--<input type="hidden" name="CmpClienteTipo" id="CmpClienteTipo" value="<?php echo $InsAlmacenMovimientoSalida->LtiId;?>" />
            --></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAlmacenMovimientoSalida->AmoObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsAlmacenMovimientoSalida->AmoEstado){
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
               <td align="left" valign="top"><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  value="<?php echo $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;?>" />
                 
                 <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta;?>" />
               
                <input type="hidden" name="CmpDescuento" id="CmpDescuento"  value="<?php echo $InsAlmacenMovimientoSalida->AmoDescuento;?>" />
                
                
               </span></td>
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
           <div class="EstFormularioArea">
             
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="98%">
                   
                   
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="15"><span class="EstFormularioSubTitulo">PRODUCTOS
                         
                         
                           <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpAlmacenMovimientoSalidaDetalleId"  class="EstFormularioCaja" id="CmpAlmacenMovimientoSalidaDetalleId"  />
                       <input name="CmpProductoCosto" type="hidden" class="EstFormularioCajaDeshabilitada" id="CmpProductoCosto" size="8" maxlength="10" readonly="readonly"  />
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
                       <td> Precio:</td>
                       <td>Importe:</td>
                       <td>Fecha:</td>
                       <td>Almacen:</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                    
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncAlmacenMovimientoSalidaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                       <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                       <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="35" /></td>
                       <td>
                         <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                         
                         </td>
                       <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                         </select></td>
                       <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="8" maxlength="10"  /></td>
                       <td><input name="CmpProductoPrecio" type="text" class="EstFormularioCaja" id="CmpProductoPrecio" size="8" maxlength="10"  /></td>
                       <td><input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="8" maxlength="10"  />                   </td>
                       <td>
                       
                       <input name="CmpAlmacenMovimientoSalidaDetalleFecha"  type="text" class="EstFormularioCajaFecha" id="CmpAlmacenMovimientoSalidaDetalleFecha" size="10" maxlength="20" readonly="readonly" />
                                  
                                  
                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnAlmacenMovimientoSalidaDetalleFecha" name="BtnAlmacenMovimientoSalidaDetalleFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                    



</td>
                       <td>
                       
                       <select   class="EstFormularioCombo" name="CmpAlmacenId" id="CmpAlmacenId">
                                      <option value="">Escoja una opcion</option>
                                      <?php
    foreach($ArrAlmacenes as $DatAlmacen){
    ?>
                                      <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsAlmacenMovimientoSalida->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                                      <?php
    }
    ?>
  </select>
  
  
  </td>
                       <td><a href="javascript:FncAlmacenMovimientoSalidaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="1%"><input type="hidden" name="CmpAlmacenMovimientoSalidaDetalleAccion" id="CmpAlmacenMovimientoSalidaDetalleAccion" value="AccAlmacenMovimientoSalidaDetalleRegistrar.php" /></td>
               <td width="50%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="47%" align="right"><a href="javascript:FncAlmacenMovimientoSalidaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncAlmacenMovimientoSalidaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="2%"><div id="CapAlmacenMovimientoSalidaDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapAlmacenMovimientoSalidaDetalles" class="EstCapAlmacenMovimientoSalidaDetalles" > </div></td>
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

var spryselect = new Spry.Widget.ValidationSelect("spryselect");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
</script>

             <script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpAlmacenMovimientoSalidaDetalleFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnAlmacenMovimientoSalidaDetalleFecha"// el id del botón que  
	});

</script>    
<?php
}else{
	echo ERR_AMO_601;
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
