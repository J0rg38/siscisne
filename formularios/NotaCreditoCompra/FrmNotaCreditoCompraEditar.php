<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaCreditoCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaCreditoCompraDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssNotaCreditoCompra.css');
</style>

<?php
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjNotaCreditoCompra.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsNotaCreditoCompra = new ClsNotaCreditoCompra();
$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsNotaCreditoCompraDetalle'.$Identificador])){	
	$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaCreditoCompraEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<?php
//if($InsNotaCreditoCompra->NccCierre==1){
?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
//var ArticuloValidarStock = "1,2";
var ArticuloTipo = "1,2"; 

var Formulario = "FrmEditar";

var NotaCreditoCompraDetalleEditar = 1;
var NotaCreditoCompraDetalleEliminar = 1;

var NotaCreditoCompraAlmacenMovimientoEliminar = 1;

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/	
	$('#CmpFechaEmision').focus();
	
	FncNotaCreditoCompraDetalleListar();
	
});

</script>





<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsNotaCreditoCompra->NccCierre;?>" />
	
    
<div class="EstCapMenu">
<?php
if($Edito){
?>
	
    
	
<?php
}
?>    

<?php
if($PrivilegioAuditoriaVer){
?>
	<div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsNotaCreditoCompra->NccId;?>&Ta=<?php echo $InsNotaCreditoCompra->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>
<?php
}
?>     

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
        <td><span class="EstFormularioTitulo">EDITAR
        NOTA DE CREDITO DE COMPRA</span></td>
      </tr>
      <tr>
        <td width="961">		

 		<div class="EstFormularioArea">
         
                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaCreditoCompra->NccTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaCreditoCompra->NccTiempoModificacion;?></span></td>
            <td>&nbsp;</td>
            <td>Creado por: </td>
            <td>
			
			  <span class="EstFormularioDatoRegistro"><?php echo $InsNotaCreditoCompra->UsuUsuario;?></span>			</td>
          </tr>
        </table>
        
        </div>   
         <br /> 
		          
<ul class="tabs">
	<li><a href="#tab1">Nota de Credito</a></li>


  
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
        

 

	    <table width="100%" border="0" cellpadding="2" cellspacing="2">
                                                          <tr>
                                                            <td width="100%" colspan="2" valign="top"><div class="EstFormularioArea" >
                                                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                  <td width="4">&nbsp;</td>
                                                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Nota de Credito 
                                                                    <input type="hidden" name="Guardar" id="Guardar"  value="" />
                                                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                                                  </span></td>
                                                                  <td width="5">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td width="133" align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td colspan="2" align="center" valign="top">&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Codigo Interno:</td>
                                                                  <td width="1" align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsNotaCreditoCompra->NccId;?>" size="20" maxlength="20" readonly="readonly"  /></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Se&ntilde;ores: </td>
                                                                  <td align="left" valign="top"><input name="CmpProveedorNombre" type="text"class="EstFormularioCajaDeshabilitada" id="CmpProveedorNombre"  tabindex="2" value="<?php echo $InsNotaCreditoCompra->PrvNombre;?> <?php echo $InsNotaCreditoCompra->PrvApellidoPaterno;?> <?php echo $InsNotaCreditoCompra->PrvApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" <?php echo !empty($InsNotaCreditoCompra->PrvId)?'readonly="readonly"':'';?>/></td>
                                                                  <td align="left" valign="top">Fecha de Emisi&oacute;n:<br />
                                                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td align="left" valign="top"><span id="sprytextfield1">
                                                                    <label>
                                                                      <input tabindex="6" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsNotaCreditoCompra->NccFechaEmision)){ echo date("d/m/Y");}else{ echo $InsNotaCreditoCompra->NccFechaEmision; }?>" size="10" maxlength="10" />
                                                                  </label>
                                                                    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEmision" name="BtnFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">R.U.C. N&deg;:
                                                                    <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" value="<?php echo $InsNotaCreditoCompra->PrvId;?>" size="3" />
                                                                  <input size="3" type="hidden" name="CmpProveedorTipoDocumentoId" id="CmpProveedorTipoDocumentoId" value="<?php echo $InsNotaCreditoCompra->TdoId?>" /></td>
                                                                  <td align="left" valign="top"><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProveedorNumeroDocumento" tabindex="4" value="<?php echo $InsNotaCreditoCompra->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" <?php echo !empty($InsNotaCreditoCompra->PrvId)?'readonly="readonly"':'';?>  /></td>
                                                                  <td align="left" valign="top">Direccion:</td>
                                                                  <td align="left" valign="top"><input name="CmpProveedorDireccion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProveedorDireccion" tabindex="5" value="<?php echo $InsNotaCreditoCompra->NccDireccion;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Numero de Comprobante:</td>
                                                                  <td align="left" valign="top"><span id="sprytextfield20">
                                                                    <input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsNotaCreditoCompra->NccComprobanteNumeroSerie;?>" size="10" maxlength="50" />
                                                                    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> - <span id="sprytextfield9">
                                                                      <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsNotaCreditoCompra->NccComprobanteNumeroNumero;?>" size="20" maxlength="50" />
                                                                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                                                                  <td align="left" valign="top">Fecha de Comprobante: <br />
                                                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td align="left" valign="top"><span id="sprytextfield7">
                                                                    <label>
                                                                      <input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsNotaCreditoCompra->NccComprobanteFecha;?>" size="15" maxlength="10" />
                                                                    </label>
                                                                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Incluye Impuesto:</td>
                                                                  <td align="left" valign="top"><?php
switch($InsNotaCreditoCompra->NccIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
                                                                    <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  disabled="disabled"  >
                                                                      <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                                                                      <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                                                                    </select></td>
                                                                  <td align="left" valign="top">Impuesto:</td>
                                                                  <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncNotaCreditoCompraDetalleListar();" value="<?php if(empty($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsNotaCreditoCompra->NccPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" readonly="readonly" />
                                                                    %</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Moneda:</td>
                                                                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                                                                    <option value="">Escoja una opcion</option>
                                                                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                                                                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsNotaCreditoCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                                                                    <?php
			  }
			  ?>
                                                                  </select></td>
                                                                  <td align="left" valign="top">Tipo de Cambio:<br />
                                                                    <span class="EstFormularioSubEtiqueta">(0.000)</span></td>
                                                                  <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncNotaCreditoCompraDetalleListar();" value="<?php if (empty($InsNotaCreditoCompra->NccTipoCambio)){ echo "";}else{ echo $InsNotaCreditoCompra->NccTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Doc. Escaneado:</td>
                                                                  <td colspan="3" align="left" valign="top"><iframe src="formularios/NotaCreditoCompra/acc/AccNotaCreditoCompraSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrNotaCreditoCompraSubirArchivo" name="IfrNotaCreditoCompraSubirArchivo" scrolling="Auto"  frameborder="0" width="100%" height="200"></iframe></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                                                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsNotaCreditoCompra->NccObservacion);?></textarea></td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                                                  <td align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsNotaCreditoCompra->NccObservacionImpresa;?></textarea></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Estado:</td>
                                                                  <td align="left" valign="top"><?php
			switch($InsNotaCreditoCompra->NccEstado){

				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;

				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;

			}
			?>
                                                                    <select tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                                                                      <option value="" >Escoja una opcion</option>
                                                                      <option <?php echo $OpcEstado3;?> value="3">Recibido</option>
                                                                      <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                                                                    </select></td>
                                                                  <td align="left" valign="top">Almacen de Salida:</td>
                                                                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                                                                    <option value="">Escoja una opcion</option>
                                                                    <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                                                                    <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsNotaCreditoCompra->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                                                                    <?php
			}
			?>
                                                                  </select></td>
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
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top"><div class="EstFormularioArea" >
                                                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                  <td width="4">&nbsp;</td>
                                                                  <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Mov. Entrada/Almacen: Documentos relacionados </span></td>
                                                                  <td width="5">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Mov. Entrada:</td>
                                                                  <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaId"  tabindex="3" value="<?php  echo $InsNotaCreditoCompra->AmoIdOrigen;?>" size="10" maxlength="20" readonly="readonly" /></td>
                                                                  <td align="left" valign="top">Num. Comprob.</td>
                                                                  <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaComprobanteNumero" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaComprobanteNumero"  tabindex="3" value="<?php  echo $InsNotaCreditoCompra->AmoComprobanteNumeroOrigen;?>" size="10" maxlength="20" readonly="readonly" /></td>
                                                                  <td align="left" valign="top">Fecha Comprob.</td>
                                                                  <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaComprobanteFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaComprobanteFecha"  tabindex="3" value="<?php  echo $InsNotaCreditoCompra->AmoComprobanteFechaOrigen;?>" size="10" maxlength="20" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td width="4">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td width="5">&nbsp;</td>
                                                                  <td width="5">&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top">
                                                            
                                                            <div class="EstFormularioArea">
                                                          
                                                                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="8"><span class="EstFormularioSubTitulo">items
                                                                      que componen la NOTA DE CREDITO DE COMPRA</span>
                                                                        <input type="hidden" name="CmpNotaCreditoCompraDetalleItem" id="CmpNotaCreditoCompraDetalleItem" />
                                                                        <input type="hidden" name="CmpNotaCreditoCompraDetalleId" id="CmpNotaCreditoCompraDetalleId" />
                                                                       
                                                                      <input type="hidden" name="CmpProductoId" id="CmpProductoId" /></td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td>&nbsp;</td>
                                                                      <td>Estado:</td>
                                                                      <td>C&oacute;digo Orig.</td>
                                                                      <td>Nombre : </td>
                                                                      <td>U.M. </td>
                                                                      <td>Cantidad:</td>
                                                                      <td> Valor Unit.:</td>
                                                                      <td> Valor Total:</td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td><a href="javascript:FncNotaCreditoCompraDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td>
                                                                      
              <select  class="EstFormularioCombo" name="CmpNotaCreditoCompraDetalleEstado" id="CmpNotaCreditoCompraDetalleEstado">
                <option value="">-</option>
                <option value="3">Devolucion</option>
                <option value="1">Rectificacion Costo</option>
              </select>
                                                                      
                                                                      </td>
                                                                      <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                                                                      <td><input name="CmpProductoNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoNombre" size="40" /></td>
                                                                      <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir" disabled="disabled">
                                                                      </select></td>
                                                                      <td><input name="CmpNotaCreditoCompraDetalleCantidad" type="text" class="EstFormularioCaja" id="CmpNotaCreditoCompraDetalleCantidad" size="10" maxlength="10" /></td>
                                                                      <td><input name="CmpNotaCreditoCompraDetallePrecio" type="text" class="EstFormularioCaja" id="CmpNotaCreditoCompraDetallePrecio" size="10" maxlength="10" readonly="readonly" /></td>
                                                                      <td><input name="CmpNotaCreditoCompraDetalleImporte" type="text" class="EstFormularioCaja" id="CmpNotaCreditoCompraDetalleImporte" size="10" maxlength="10" /></td>
                                                                      <td><a href="javascript:FncNotaCreditoCompraDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                    </tr>
                                                                  </table>
                                                            </div>                                                            </td>
                                                           </tr>

                                                          <tr>
                                                            <td colspan="2" valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="2%"><input type="hidden" name="CmpNotaCreditoCompraDetalleAccion" id="CmpNotaCreditoCompraDetalleAccion" value="AccNotaCreditoCompraDetalleRegistrar.php" /></td>
                                                                    <td width="48%"><div class="EstFormularioAccion" id="CapNotaCreditoCompraDetalleAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="49%" align="right"><a href="javascript:FncNotaCreditoCompraDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncNotaCreditoCompraDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                                                                    <td width="1%"><div id="CapNotaCreditoCompraDetallesResultado"> </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2"><div id="CapNotaCreditoCompraDetalles" class="EstCapNotaCreditoCompraDetalles" > </div></td>
                                                                    <td>&nbsp;</td>
                                                                  </tr>
                                                                </table>
                                                            </div></td>
                                                           </tr>
                                                          
                                                          <tr>
                                                            <td colspan="2" valign="top"><!--<div class="EstFormularioArea" >
                                                              <table width="62%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                <tr>
                                                                  <td width="3%">&nbsp;</td>
                                                                  <td width="97%" align="left"><span class="EstFormularioSubTitulo">Notas de Entrega</span></td>
                                                                </tr>
                                                                <tr>
                                                                  <td height="100">&nbsp;</td>
                                                                  <td align="left" valign="top"><div id="CapNotaEntregas"></div></td>
                                                                </tr>
                                                              </table>
                                                            </div>--></td>
                                                           </tr>
        </table>
 	
    </div>
    
    

    

    
</div>       
        
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
    </table>


</div>	
      

</form>
<script type="text/javascript"> 

	Calendar.setup({ 
	inputField : "CmpFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEmision"// el id del bot&oacute;n que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "CmpComprobanteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteFecha"// el id del botón que  

	});
	
</script>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var sprytextfield20 = new Spry.Widget.ValidationTextField("sprytextfield20");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});
</script>
<?php
//}elseif(($InsNotaCreditoCompra->NccCierre==2)){
//	echo ERR_NCC_401;
//}else{
//	echo ERR_NCC_403;
//}

?>
<?php
}else{
	echo ERR_GEN_101;
}

if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}
?>
