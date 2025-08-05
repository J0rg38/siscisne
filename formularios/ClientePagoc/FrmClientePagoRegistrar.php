<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsDocumentoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("FormaPago");?>JsFormaPagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClientePagoFunciones.js" ></script>

<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj("ClientePago").'MsjClientePago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCajaCierre.php');
require_once($InsPoo->MtdPaqActividad().'ClsVenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTarjetaEntidad.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTarjetaMarca.php');


$InsClientePago = new ClsClientePago();
$InsFormaPago = new ClsFormaPago();
$InsMoneda = new ClsMoneda();

include($InsProyecto->MtdFormulariosAcc("ClientePago").'AccClientePagoRegistrar.php');

$RepFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaNombre","ASC",1,NULL,1);
$ArrFormaPagos = $RepFormaPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();

$(document).ready(function (){	
	FncClientePagoEstablecerMoneda();
});
/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncEstablecerClientePagoFormaPago";
var FormaPagoEditar = 1;

</script>




<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">
<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR PAGO DE CLIENTE</span></td>
      </tr>
      <tr>
        <td colspan="2">
   
   
<ul class="tabs">
	<li><a href="#tab1">Pago de Cliente</a></li>
	<li><a href="#tab2">Comprobante de Pago</a></li>
</ul>
<div class="tab_container">
	<div id="tab1" class="tab_content">
	<!--Content-->

        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">Datos del Pago de Cliente</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Documento:</td>
            <td>
            
            
            <?php 
			switch($InsClientePago->CpaTipo){
				case 1:
					$OpcTipo1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcTipo2 = 'selected="selected"';
				break;
				
				case 3:
					$OpcTipo3 = 'selected="selected"';			
				break;
				
				case 4:
					$OpcTipo4 = 'selected="selected"';
				break;
			}
			?>
            <select onchange="FncDocumentoAutocompletarCargar(this.value);" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
                <option <?php echo $OpcTipo1;?> value="1">Venta</option>
                <option <?php echo $OpcTipo2;?> value="2">Factura</option>
                <option <?php echo $OpcTipo3;?> value="3">Boleta</option>
                <option <?php echo $OpcTipo4;?> value="4">Nota de Entrega</option>
            </select>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Numero:

<input name="CmpDocumentoSucursalId" type="hidden" id="CmpDocumentoSucursalId" value="<?php echo $InsClientePago->SucId;?>" />

<input name="CmpDocumentoId" type="hidden" id="CmpDocumentoId" value="<?php echo $InsClientePago->DocId;?>" />
<input name="CmpDocumentoTalonario" type="hidden" id="CmpDocumentoTalonario" value="<?php echo $InsClientePago->DtaId;?>" />
<input name="CmpDocumentoTalonarioNumero" type="hidden" id="CmpDocumentoTalonarioNumero" value="<?php echo $InsClientePago->DtaNumero;?>" />


</td>
            <td>
            
            <input class="EstFormularioCaja" name="CmpDocumento" type="text" id="CmpDocumento" value="<?php if(!empty($InsClientePago->DtaNumero) and !empty($InsClientePago->DocId)){ echo $InsClientePago->DtaNumero." - ".$InsClientePago->DocId; }?>" size="20" maxlength="20"  />            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cliente:</td>
            <td>
              
              <input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre" value="<?php echo $InsClientePago->CliNombre;?>" size="45" maxlength="255" readonly="readonly"  />            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Descripcion:</td>
            <td><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="40" rows="3" ><?php echo  $InsClientePago->CpaDescripcion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Forma de Pago:</td>
            <td>
              
              
              <span id="spryselect1">
                
                <select  name="CmpFormaPago" id="CmpFormaPago" class="EstFormularioCombo" >
                  <option value="">Escoja una opcion</option>
                  <?php
					foreach($ArrFormaPagos as $DatFormaPago){
					?>
                  <option <?php if($InsClientePago->FpaId==$DatFormaPago->FpaId){ echo 'selected="selected"';}?> value="<?php echo $DatFormaPago->FpaId;?>"><?php echo $DatFormaPago->FpaNombre;?></option>
                  <?php  
					}
					?>
                  </select>
                <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td><span id="sprytextfield1">
             
                <input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsClientePago->CpaFecha)){ echo date("d/m/Y");}else{ echo $InsClientePago->CpaFecha; }?>" size="15" maxlength="10" />
             
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span> <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /> dd/mm/yyyy</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Moneda:</td>
            <td>
            <input type="hidden" name="CmpMonedaId" id="CmpMonedaId" value="<?php echo $EmpresaMonedaId;?>" />
            
            <select disabled="disabled"  onchange="FncMonedaBuscar('Id');" class="EstFormularioCombo" name="CmpMonedaId2" id="CmpMonedaId2">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsClientePago->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select>
            
            </td>
            <td><div id="CapMonedaBuscar"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tipo de Cambio :<br />
            <span class="EstFormularioSubEtiqueta">(0.000)</span>
            </td>
            <td><span id="sprytextfield2">
            <label for="CmpTipoCambio"></label>
            <input  class="EstFormularioCaja" name="CmpTipoCambio" type="text" id="CmpTipoCambio" value="<?php if (empty($InsClientePago->CpaTipoCambio)){ echo "";}else{ echo $InsClientePago->CpaTipoCambio; } ?>" size="10" maxlength="10"  />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Monto (<span class="EstMonedaSimbolo"> <span id="CapMonedaMonto"></span></span>):</td>
            <td><label> <span id="sprytextfield3">
              <input class="EstFormularioCaja" name="CmpMonto" type="text" id="CmpMonto" value="<?php if(empty($InsClientePago->CpaMonto)){ echo "0.00";}else{ echo number_format($InsClientePago->CpaMonto,2); }?>" size="10" maxlength="10" />
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></label></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Considerar en:</td>
            <td>
              <?php
			switch($InsClientePago->CpaDestino){
				case 1:
					$OpcDestino1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcDestino2 = 'selected="selected"';				
				break;
			}
			?>
              <select name="CmpDestino" id="CmpDestino" class="EstFormularioCombo">
                <option value="1" <?php echo $OpcDestino1;?> >Caja Diaria</option>
                <option value="2" <?php echo $OpcDestino2;?> >Caja General</option>
                </select>            
                
			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td>
            
            <?php
					switch($InsClientePago->CpaEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
              <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
              </select>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
            
         	<input type="hidden" name="CmpChequeNumeroAux" id="CmpChequeNumeroAux"  value="<?php echo $InsClientePago->CpaChequeNumero;?>"/>
			<input type="hidden" name="CmpTarjetaMarcaAux" id="CmpTarjetaMarcaAux" value="<?php echo $InsClientePago->TmaNombre;?>" />
			<input type="hidden" name="CmpTarjetaMarcaIdAux" id="CmpTarjetaMarcaIdAux" value="<?php echo $InsClientePago->TmaId;?>" />

			<input type="hidden" name="CmpTarjetaEntidadAux" id="CmpTarjetaEntidadAux" value="<?php echo $InsClientePago->TenNombre;?>" />
			<input type="hidden" name="CmpTarjetaEntidadIdAux" id="CmpTarjetaEntidadIdAux" value="<?php echo $InsClientePago->TenId;?>" />
              
			<input type="hidden" name="CmpBancoAux" id="CmpBancoAux"  value="<?php echo $InsClientePago->BanNombre;?>"/>
			<input type="hidden" name="CmpBancoIdAux" id="CmpBancoIdAux"  value="<?php echo $InsClientePago->BanId;?>"/>
              
			<input type="hidden" name="CmpBancoDepositarAux" id="CmpBancoDepositarAux"  value="<?php echo $InsClientePago->BanNombreDepositar;?>"/>
			<input type="hidden" name="CmpBancoDepositarIdAux" id="CmpBancoDepositarIdAux"  value="<?php echo $InsClientePago->BanIdDepositar;?>"/>
              
			<input type="hidden" name="CmpTransaccionNumeroAux" id="CmpTransaccionNumeroAux" value="<?php echo $InsClientePago->CpaTransaccionNumero;?>" />

			<input type="hidden" name="CmpTarjetaNumeroAux" id="CmpTarjetaNumeroAux" value="<?php echo $InsClientePago->CpaTarjetaNumero;?>" />
			<input type="hidden" name="CmpTarjetaTipoAux" id="CmpTarjetaTipoAux" value="<?php echo $InsClientePago->CpaTarjetaTipo;?>" />
              
			<input type="hidden" name="CmpNumeroReferenciaAux" id="CmpNumeroReferenciaAux" value="<?php echo $InsClientePago->CpaNumeroReferencia;?>" />
			<input type="hidden" name="CmpRetencionPorcentajeAux" id="CmpRetencionPorcentajeAux" value="<?php echo $InsClientePago->CpaRetencionPorcentaje;?>" />

			<input type="hidden" name="CmpTransaccionSituacionAux" id="CmpTransaccionSituacionAux" value="<?php echo $InsClientePago->CpaTransaccionSituacion;?>" />


</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
            <div id="CapFormaPago"></div>            </td>
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
        
	</div>
    
<div id="tab2" class="tab_content">
	<!--Content-->
    
    
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td><iframe src="formularios/ClientePago/acc/AccClientePagoSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrClientePagoSubirArchivo" name="IfrClientePagoSubirArchivo" scrolling="Auto"  frameborder="0" width="100%" height="500"></iframe></td>
               <td>&nbsp;</td>
             </tr>           
             </table>
             
        
	
    
		</div>
	
        
    </td>
    </tr>
    </table>	
        
        
        
</div>
	</div>
    
    
    
    
        </td>
      </tr>
      <tr>
        <td width="150">&nbsp;</td>
        <td width="811">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
    
    
    
    
    
</div>


	
	
	
    

</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");

//-->
</script>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {isRequired:false});
</script>
<?php
}else{
echo ERR_GEN_101;
}
?>
