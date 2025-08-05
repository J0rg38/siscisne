<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsCuentaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoProveedorComprobanteFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss('PagoProveedor');?>CssPagoProveedor.css');
</style>
<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$Registro = false;

include($InsProyecto->MtdFormulariosMsj('PagoProveedor').'MsjPagoProveedor.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPagoProveedor.php');



require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

$InsPagoProveedor = new ClsPagoProveedor();
$InsMoneda = new ClsMoneda();
$InsBanco = new ClsBanco();

$InsCuenta = new ClsCuenta();

$InsTipoDocumento = new ClsTipoDocumento();

if (!isset($_SESSION['InsPagoProveedorComprobante'.$Identificador])){	
	$_SESSION['InsPagoProveedorComprobante'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsPagoProveedorComprobante'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPagoProveedorComprobante'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc('PagoProveedor').'AccPagoProveedorRegistrar.php');

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,NULL);
$ArrBancos = $ResBanco['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonNombre","ASC",NULL,NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsPagoProveedor->MonId);
$ArrCuentas = $ResCuenta['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">

var Contador = 1;
var PagoProveedorComprobanteEditar = 1;
var PagoProveedorComprobanteEliminar = 1;

</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        PAGO A PROVEEDOR</span></td>
      </tr>
      <tr>
        
        <td colspan="2">
        
        
            
            <div class="EstFormularioArea">
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Pago a Proveedor</span>
                    <input type="hidden" name="Guardar" id="Guardar"   />
                  <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo Interno:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPagoProveedor->PovId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td align="left" valign="top">Fecha de Pago: <br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsPagoProveedor->PovFecha; ?>" size="15" maxlength="10" />                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Proveedor:
                  <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsPagoProveedor->PrvId;?>" size="3" /></td>
                  <td colspan="3" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>Tipo Doc.: </td>
                      <td><select disabled="disabled" class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
                        <option value="">Escoja una opcion</option>
                        <?php
                foreach($ArrTipoDocumentos as $DatTipoDocumento){
                ?>
                        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsPagoProveedor->TdoIdProveedor)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                        <?php
                }
                ?>
                      </select></td>
                      <td>Num. Doc: </td>
                      <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsPagoProveedor->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                      <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                      <td><input <?php echo (!empty($InsPagoProveedor->PrvId)?'readonly="readonly"':'');?>  class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsPagoProveedor->PrvNombre;?>" size="45" maxlength="255"  /></td>
                      <td><a id="BtnProveedorRegistrar" href="javascript:FncProveedorCargarFormulario('Registrar','','');" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" href="javascript:FncProveedorCargarFormulario('Editar','','');"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrMonedas as $DatMoneda){
			?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsPagoProveedor->MonId==$DatMoneda->MonId){ echo 'selected="selected"';} ?> ><?php echo $DatMoneda->MonNombre?> <?php echo $DatMoneda->MonSimbolo?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td align="left" valign="top">Tipo de Cambio: <br />
                    <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                  <td align="left" valign="top"><table>
                    <tr>
                      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsPagoProveedor->PovTipoCambio)){ echo "";}else{ echo $InsPagoProveedor->PovTipoCambio; } ?>" size="10" maxlength="10" /></td>
                      <td><a href="javascript:FncPagoFacturaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                    </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Cuenta Afecta:</td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpCuenta" id="CmpCuenta">
                    <option value="">Escoja una opcion</option>
                    <?php
				foreach($ArrCuentas as $DatCuenta){
				?>
                    <option <?php echo ($InsPagoProveedor->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueId?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?> - <?php echo $DatCuenta->MonNombre; ?></option>
                    <?php
				}
				?>
                  </select></td>
                  <td align="left" valign="top">Numero Operacion:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNumeroOperacion" type="text" id="CmpNumeroOperacion" value="<?php echo $InsPagoProveedor->PovNumeroOperacion;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Monto:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpMonto" type="text" id="CmpMonto" value="<?php echo number_format($InsPagoProveedor->PovMonto,2);?>" size="10" maxlength="10" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Observacion Interna:</td>
                  <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpObservacion" id="CmpObservacion" cols="45" rows="4"><?php echo addslashes($InsPagoProveedor->PovObservacion);?></textarea></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top">
	<?php
    switch($InsPagoProveedor->PovEstado){
		case 1:
		 $OpcEstado1 = 'selected="selected"';
		break;
		
		case 3:
			$OpcEstado3 = 'selected="selected"';
		break;
		
			  
		case 6:
			$OpcEstado6 = 'selected="selected"';
		break;
    }
    ?>
                    
                    <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                      <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                      <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                      <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                      
                      </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2">OPCIONES ADICIONALES:</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><input <?php echo (($InsPagoProveedor->PovNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                  Notificar via email</td>
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
                </tr>
                </table>
              
              
              </div>
            
        
        
        
        </td>
      </tr>
      
      
      
      <?php
/*	  
	  ?>
      <tr>
        <td colspan="2" align="center"><div class="EstFormularioArea">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="98%"><table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="9"><span class="EstFormularioSubTitulo">COMPROBANTES </span><span class="EstFormularioSubTitulo">
                    <input type="hidden" name="CmpGastoId"    id="CmpGastoId"   />
                    <input type="hidden" name="CmpGastoItem" id="CmpGastoItem" />
                    <input type="hidden" name="CmpGastoUnidadMedida" id="CmpGastoUnidadMedida" />
                    <input type="hidden" name="CmpGastoUnidadMedidaEquivalente"   id="CmpGastoUnidadMedidaEquivalente"  />
                    <input type="hidden" name="CmpGastoCostoAux"    id="CmpGastoCostoAux"    />
                  </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><div id="CapGastoBuscar"></div></td>
                  <td>Proveedor:</td>
                  <td>&nbsp;</td>
                  <td>Num. Comprob.:</td>
                  <td>&nbsp;</td>
                  <td>Moneda:</td>
                  <td> Total:</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><a href="javascript:FncPagoProveedorComprobanteNuevo('');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  <td><input name="CmpGastoNombre" type="text" class="EstFormularioCaja" id="CmpGastoNombre" size="40" /></td>
                  <td><a href="javascript:FncGastoBuscar('CodigoOriginal','');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  <td><input name="CmpGastoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpGastoCodigoOriginal" size="10" maxlength="20" /></td>
                  <td><a id="BtnGastoRegistrar" onclick="FncGastoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnGastoEditar" onclick="FncGastoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a><a href="javascript:FncGastoBuscar('CodigoOriginal','');"></a></td>
                  <td><select  class="EstFormularioCombo" name="CmpGastoUnidadMedidaConvertir" id="CmpGastoUnidadMedidaConvertir">
                  </select></td>
                  <td><input name="CmpGastoImporte" type="text" class="EstFormularioCaja" id="CmpGastoImporte" size="10" maxlength="10"  /></td>
                  <td><a href="javascript:FncPagoProveedorComprobanteGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                  <td><a href="comunes/Gasto/FrmGastoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><div class="EstFormularioArea" >
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
            <tr>
              <td>&nbsp;</td>
              <td><input type="hidden" name="CmpPagoProveedorComprobanteAccion2" id="CmpPagoProveedorComprobanteAccion2" value="AccPagoProveedorComprobanteRegistrar.php" /></td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="1%">&nbsp;</td>
              <td width="49%"><div class="EstFormularioAccion" id="CapGastoAccion2">Listo
                para registrar elementos</div></td>
              <td width="49%" align="right"><a href="javascript:FncPagoProveedorComprobanteListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                <?php
if($InsPagoProveedor->VdiOrigen <> "CPR"){
?>
                <a href="javascript:FncPagoProveedorComprobanteEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                <?php
}
?></td>
              <td width="1%"><div id="CapPagoProveedorComprobantesResultado2"> </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2"><div id="CapPagoProveedorComprobantes2" class="EstCapPagoProveedorComprobantes" > </div></td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
      </tr>
        <?php
	  */
	  ?>
      
      
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>
	

	
    

</form>


     
<script type="text/javascript">

var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}


?>

