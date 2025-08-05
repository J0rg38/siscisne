<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago",$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClientePagoFacturaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>


<?php
$GET_FacId = $_GET['FacId'];
$GET_FtaId = $_GET['FtaId'];

$Registro = false;
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjClientePagoFactura.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');

//INSTANCIAS
$InsClientePago = new ClsClientePago();
$InsFormaPago = new ClsFormaPago();
$InsCuenta = new ClsCuenta();
$InsMoneda = new ClsMoneda();
$InsFactura = new ClsFactura();


$InsFactura->FacId = $GET_FacId;
$InsFactura->FtaId = $GET_FtaId;
$InsFactura->MtdObtenerFactura(false);

//ACCIONES

$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaTalonarioNumero = "";
	
	
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClientePagoFacturaRegistrar.php');

$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,1);
$ArrFormaPagos = $ResFormaPago['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL);
$ArrCuentas = $ResCuenta['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>


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
        PAGO DE CLIENTE</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        <div class="EstFormularioArea">
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:
              <input name="CmpTipo" type="hidden" id="CmpTipo" value="FAC" />
              <input name="CmpFacturaId" type="hidden" id="CmpFacturaId" value="<?php echo $FacturaId;?>" />
              <input name="CmpFacturaTalonarioId" type="hidden" id="CmpFacturaTalonarioId" value="<?php echo $FacturaTalonarioId;?>" />
              <input name="CmpFacturaTalonarioNumero" type="hidden" id="CmpFacturaTalonarioNumero" value="<?php echo $FacturaTalonarioNumero;?>" /></td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsClientePago->CpaId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Comprobante de Venta/Referencia:</td>
            <td align="left" valign="top"><input name="CmpFactura" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFactura" value="<?php echo $FacturaTalonarioNumero;?> - <?php echo $FacturaId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield7">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsClientePago->CpaFecha;?>" size="15" maxlength="10" />
              </label>
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Forma de Pago:</td>
            <td><span id="spryselect1">
            
              <select class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrFormaPagos as $DatFormaPago){
				?>
				<option <?php echo ($InsClientePago->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
				<?php
			  }
			  
			  ?>
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Num. de Transaccion:</td>
            <td><input name="CmpTransaccionNumero" type="text"  class="EstFormularioCaja" id="CmpTransaccionNumero" value="<?php echo $InsClientePago->CpaTransaccionNumero;?>" size="30" maxlength="45" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cuenta:</td>
            <td>
            	<span id="spryselect2">
				<select class="EstFormularioCombo" name="CmpCuentaId" id="CmpCuentaId">
				<option value="">Escoja una opcion</option>
				<?php
				foreach($ArrCuentas as $DatCuenta){
				?>
				<option <?php echo ($InsClientePago->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueId?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?> - <?php echo $DatCuenta->MonNombre; ?></option>
				<?php
				}
				?>
				</select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>
                  <span id="spryselect3">
                  <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsClientePago->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                  </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                  
                 
                 </td>
                <td><div id="CapMonedaBuscar"></div></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo de Cambio: <br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table>
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsClientePago->CpaTipoCambio)){ echo "";}else{ echo $InsClientePago->CpaTipoCambio; } ?>" size="10" maxlength="10" /></td>
                <td><a href="javascript:FncClientePagoFacturaEstablecerMoneda();"><img src="imagenes/recargar.jpg" width="20" height="20" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Monto:</td>
            <td align="left" valign="top"><span id="sprytextfield4">
              <input class="EstFormularioCaja" name="CmpMonto" type="text" id="CmpMonto" value="<?php echo number_format($InsClientePago->CpaMonto,2);?>" size="10" maxlength="10" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Observacion:</td>
            <td><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="45" rows="4"><?php echo $InsClientePago->CpaObservacion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
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
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
//-->
</script>


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
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
		
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
