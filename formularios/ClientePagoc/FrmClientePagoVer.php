<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsDocumentoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClientePagoFunciones.js" ></script>

<script type="text/javascript">

$(document).ready(function (){
	
	//FncMonedaBuscar('Id');		
	FncClientePagoEstablecerMoneda();	
	//FncEstablecerClientePagoFormaPago();			
	
});

//var MonedaFuncion = "FncClientePagoEstablecerMoneda";
////var MonedaFuncion = "FncEstablecerClientePagoFormaPago";

var FormaPagoEditar = 2;

</script>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php

$GET_id = $_GET['Id'];
include($InsProyecto->MtdFormulariosMsj("ClientePago").'MsjClientePago.php');


require_once($InsPoo->MtdPaqActividad().'ClsVenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsClientePago = new ClsClientePago();
$InsFormaPago = new ClsFormaPago();

$InsMoneda = new ClsMoneda();

include($InsProyecto->MtdFormulariosAcc("ClientePago").'AccClientePagoEditar.php');



$RepFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaNombre","ASC",1,NULL,1);
$ArrFormaPagos = $RepFormaPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>
<!-- 


-->
<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $InsClientePago->CpaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td height="25" colspan="2"><span class="EstFormularioTitulo">VER
        PAGO DE CLIENTE</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
 <ul class="tabs">
	<li><a href="#tab1">Pago</a></li>
	<li><a href="#tab2">Comprobante de Pago</a></li>
</ul>
<div class="tab_container">
	<div id="tab1" class="tab_content">
	<!--Content-->           
               
 
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
            <td colspan="2"><span class="EstFormularioSubTitulo">Datos del Pago de Cliente</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo:</td>
            <td>
              
              <input class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" size="15" maxlength="20" value="<?php echo $InsClientePago->CpaId;?>" readonly="readonly" />                </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Documento:</td>
            <td><?php 
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
              <select disabled="disabled" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
                <option <?php echo $OpcTipo1;?> value="1">Venta</option>
                <option <?php echo $OpcTipo2;?> value="2">Factura</option>
                <option <?php echo $OpcTipo3;?> value="3">Boleta</option>
                <option <?php echo $OpcTipo4;?> value="4">Nota de Entrega</option>
                </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Numero:
              <input name="CmpDocumentoId" type="hidden" id="CmpDocumentoId" value="<?php echo $InsClientePago->DocId;?>" />
              <input name="CmpDocumentoTalonario" type="hidden" id="CmpDocumentoTalonario" value="<?php echo $InsClientePago->DtaId;?>" />
              <input name="CmpDocumentoTalonarioNumero" type="hidden" id="CmpDocumentoTalonarioNumero" value="<?php echo $InsClientePago->DtaNumero;?>" /></td>
            <td><input class="EstFormularioCaja" name="CmpDocumento" type="text" id="CmpDocumento" value="<?php echo $InsClientePago->DtaNumero;?> - <?php echo $InsClientePago->DocId;?>" size="20" maxlength="20" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cliente:</td>
            <td><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre" value="<?php echo $InsClientePago->CliNombre;?>" size="45" maxlength="255" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Descripcion:</td>
            <td><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="40" rows="3" readonly="readonly" ><?php echo  $InsClientePago->CpaDescripcion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Forma de Pago:</td>
            <td>
              <select disabled="disabled" name="CmpFormaPago" id="CmpFormaPago" class="EstFormularioCombo" >
                <option value="">Escoja una opcion</option>
                <?php
					foreach($ArrFormaPagos as $DatFormaPago){
					?>
                <option <?php if($InsClientePago->FpaId==$DatFormaPago->FpaId){ echo 'selected="selected"';}?> value="<?php echo $DatFormaPago->FpaId;?>"><?php echo $DatFormaPago->FpaNombre;?></option>
                <?php  
					}
					?>
                </select>              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsClientePago->CpaFecha)){ echo date("d/m/Y");}else{ echo $InsClientePago->CpaFecha; }?>" size="15" maxlength="10" readonly="readonly" />
              dd/mm/yyyy</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Moneda:</td>
            <td><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsClientePago->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
              </select></td>
            <td><div id="CapMonedaBuscar"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tipo de Cambio:<br />
            <span class="EstFormularioSubEtiqueta">(0.000)</span>
            </td>
            <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncCompraDetalleListar();" value="<?php if (empty($InsClientePago->CpaTipoCambio)){ echo "";}else{ echo $InsClientePago->CpaTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Monto (<span class="EstMonedaSimbolo"> <span id="CapMonedaMonto"></span></span>):</td>
            <td><input readonly="readonly" class="EstFormularioCaja" name="CmpMonto" type="text" id="CmpMonto" value="<?php if(empty($InsClientePago->CpaMonto)){ echo "0.00";}else{ echo number_format($InsClientePago->CpaMonto,2); }?>" size="10" maxlength="10" />              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Considerar en:</td>
            <td><?php
			switch($InsClientePago->CpaDestino){
				case 1:
					$OpcDestino1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcDestino2 = 'selected="selected"';				
				break;
			}
			?>
              <select  disabled="disabled" name="CmpDestino" id="CmpDestino" class="EstFormularioCombo">
                <option value="1" <?php echo $OpcDestino1;?> >Caja Diaria</option>
                <option value="2" <?php echo $OpcDestino2;?> >Caja General</option>
                </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td><?php
					switch($InsClientePago->CpaEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
              <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
              </select></td>
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
            <td colspan="2"><div id="CapFormaPago"></div></td>
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
        
        
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td></td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td>
               
               <?php              
              
if(!empty($_SESSION['SesCpaFoto'.$Identificador])){

	$extension = strtolower(pathinfo($_SESSION['SesCpaFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesCpaFoto'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

	<img  src="subidos/clientepago_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />

<?php	
}else{
?>
No hay FOTO
<?php	
}
?>


               
               </td>
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


	
	
	
    


<?php
}else{
echo ERR_GEN_101;
}
?>

