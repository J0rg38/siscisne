<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsCuentaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoProveedorFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPagoProveedor.css');
</style>

<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}


$GET_id = $_GET['Id'];
$Edito = false;

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

if (isset($_SESSION['InsPagoProveedorComprobante'.$Identificador])){	
	$_SESSION['InsPagoProveedorComprobante'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPagoProveedorComprobante'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc('PagoProveedor').'AccPagoProveedorEditar.php');

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,NULL);
$ArrBancos = $ResBanco['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonNombre","ASC",NULL,NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsPagoProveedor->MonId);
$ArrCuentas = $ResCuenta['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];
?>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
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
        PAGO A PROVEEDOR</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPagoProveedor->PovTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPagoProveedor->PovTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
         <br />
        
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
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
                  <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsPagoProveedor->PovFecha)){ echo date("d/m/Y");}else{ echo $InsPagoProveedor->PovFecha; }?>" size="15" maxlength="10" />                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
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
                  <td align="left" valign="top"><?php
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
      </table>
      
      
        </td>
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
