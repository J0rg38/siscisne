<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago",$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClientePagoBoletaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>


<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Editar"))?true:false;?>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$GET_BolId = $_GET['BolId'];
$GET_BtaId = $_GET['BtaId'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjClientePagoBoleta.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
//INSTANCIAS
$InsClientePago = new ClsClientePago();
$InsFormaPago = new ClsFormaPago();
$InsCuenta = new ClsCuenta();
$InsMoneda = new ClsMoneda();
$InsBoleta = new ClsBoleta();

	$BoletaId = "";
	$BoletaTalonarioId = "";
	$BoletaTalonarioNumero = "";
	
	
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClientePagoBoletaEditar.php');

$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,1);
$ArrFormaPagos = $ResFormaPago['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL);
$ArrCuentas = $ResCuenta['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];





?><div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsClientePago->CpaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        PAGO DE CLIENTE</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsClientePago->CpaTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsClientePago->CpaTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
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
              <input name="CmpBoletaId" type="hidden" id="CmpBoletaId" value="<?php echo $BoletaId;?>" />
              <input name="CmpBoletaTalonarioId" type="hidden" id="CmpBoletaTalonarioId" value="<?php echo $BoletaTalonarioId;?>" />
              <input name="CmpBoletaTalonarioNumero" type="hidden" id="CmpBoletaTalonarioNumero" value="<?php echo $BoletaTalonarioNumero;?>" /></td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsClientePago->CpaId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Comprobante de Venta/Referencia:</td>
            <td align="left" valign="top"><input name="CmpBoleta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpBoleta" value="<?php echo $BoletaTalonarioNumero;?> - <?php echo $BoletaId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsClientePago->CpaFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Forma de Pago:</td>
            <td><select class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrFormaPagos as $DatFormaPago){
				?>
              <option <?php echo ($InsClientePago->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?> value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
              <?php
			  }
			  
			  ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Num. de Transaccion:</td>
            <td><input name="CmpTransaccionNumero" type="text"  class="EstFormularioCaja" id="CmpTransaccionNumero" value="<?php echo $InsClientePago->CpaTransaccionNumero;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cuenta:</td>
            <td><select class="EstFormularioCombo" name="CmpCuentaId" id="CmpCuentaId" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrCuentas as $DatCuenta){
				?>
              <option  <?php echo ($InsClientePago->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueIds?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?></option>
              <?php
			  }
			  
			  ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled" >
                  <option value="">Escoja una opcion</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsClientePago->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                </select></td>
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
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncClientePagoDetalleListar();" value="<?php if (empty($InsClientePago->CpaTipoCambio)){ echo "";}else{ echo $InsClientePago->CpaTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                <td><a href="javascript:FncClientePagoBoletaEstablecerMoneda();"></a></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Monto:</td>
            <td align="left" valign="top"><input name="CmpMonto" type="text" class="EstFormularioCaja" id="CmpMonto" value="<?php echo number_format($InsClientePago->CpaMonto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Observacion:</td>
            <td><textarea name="CmpDescripcion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsClientePago->CpaObservacion;?></textarea></td>
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


	
	
	
    <?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>


