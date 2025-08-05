<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaDebitoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaDebitoDetalleFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdRutFormularios();?>NotaDebito/css/CssNotaDebito.css');
</style>
<?php

$GET_ori = $_GET['Ori'];
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}


include($InsProyecto->MtdFormulariosMsj("NotaDebito").'MsjNotaDebito.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsSunatCatalogo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


$InsNotaDebito = new ClsNotaDebito();
$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();
$InsFactura = new ClsFactura();
$InsSunatCatalogo = new ClsSunatCatalogo();

if (isset($_SESSION['InsNotaDebitoDetalle'.$Identificador])){	
	$_SESSION['InsNotaDebitoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsNotaDebitoDetalle'.$Identificador]);
}
	
include($InsProyecto->MtdRutFormularios().'NotaDebito/acc/AccNotaDebitoEditar.php');

$ResNotaDebitoTalonario = $InsNotaDebitoTalonario->MtdObtenerNotaDebitoTalonarios(NULL,NULL,"NdtNumero","DESC",NULL,$InsNotaDebito->SucId);
$ArrNotaDebitoTalonarios = $ResNotaDebitoTalonario['Datos'];


$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos(NULL,NULL,'ScaCodigo','ASC',NULL,"CATALOGO10");
$ArrSunatCatalogos = $ResSunatCatalogo['Datos'];

$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos(NULL,NULL,'ScaCodigo','ASC',NULL,"CATALOGO12");
$ArrSunatCatalogos2 = $ResSunatCatalogo['Datos'];
?>


<script type="text/javascript">
/*
Configuracion Formulario
*/
var NotaDebitoDetalleEditar = 2;
var NotaDebitoDetalleEliminar = 2;


$().ready(function() {
/*
Configuracion carga de datos y animacion
*/
	FncNotaDebitoDetalleListar();

});
</script>


<div class="EstCapMenu">
  <?php
			if($PrivilegioVistaPreliminar){
			?>
            
           <!-- <div class="EstSubMenuBoton"><a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>NotaDebito/FrmNotaDebitoImprimir.php?Id=<?php echo $InsNotaDebito->NdbId;?>&Ta=<?php echo $InsNotaDebito->NdtId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>-->
           
           <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsNotaDebito->NdbId;?>','<?php echo $InsNotaDebito->NdtId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
           
           
  <?php
			}
			?>
  <?php
			if($PrivilegioImprimir){
			?>
           <!-- <div class="EstSubMenuBoton"><a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>NotaDebito/FrmNotaDebitoImprimir.php?Id=<?php echo $InsNotaDebito->NdbId;?>&Ta=<?php echo $InsNotaDebito->NdtId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>-->
           
           <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsNotaDebito->NdbId;?>','<?php echo $InsNotaDebito->NdtId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
           
           
  <?php
			}
			?>
            
            
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsNotaDebito->NdbId;?>&Ta=<?php echo $InsNotaDebito->NdtId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   

        

</div>

<div class="EstCapContenido">

	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td><span class="EstFormularioTitulo">VER
        NOTA DE DEBITO</span></td>
      </tr>
      <tr>
        <td width="961">		
        

<ul class="tabs">
	<li><a href="#tab1">Nota de Debito</a></li>

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
        
              
                    <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaDebito->NdbTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaDebito->NdbTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
         <br />
       
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td width="4">&nbsp;</td>
               <td colspan="5"><span class="EstFormularioSubTitulo">Datos de la Nota de Debito 
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td width="5">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="right">
                 
                 <table>
                 <tr>
                   <td align="left">Serie:</td>
                   <td align="left"><select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
                     <option value="">-</option>
                     <?php
			  foreach($ArrNotaDebitoTalonarios as $DatNotaDebitoTalonario){
			  ?>
                     <option <?php if($InsNotaDebito->NdtId == $DatNotaDebitoTalonario->NdtId){ echo 'selected="selected"';}?> value="<?php echo $DatNotaDebitoTalonario->NdtId;?>" ><?php echo $DatNotaDebitoTalonario->NdtNumero;?> (<?php echo $DatNotaDebitoTalonario->NdtDescripcion;?>)</option>
                     <?php
			  }
			  ?>
                   </select></td>
                   <td align="center">Numero:</td>
                 <td align="left"><input readonly="readonly" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsNotaDebito->NdbId;?>" size="20" maxlength="20" /></td>
                 </tr>
                 </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="91" align="left" valign="top">Se&ntilde;ores:                 </td>
               <td width="377" align="left" valign="top"><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsNotaDebito->CliNombre;?>" />
                 <!--       <br /><br />
        <a href="javascript:void(0);" onclick="popupCssShow('default.php?page=pagina-2', 460);" title="Abrir PopUp 1">Abrir PopUp 2</a>-->               </td>
               <td width="4" align="left" valign="top">&nbsp;</td>
               <td width="98" align="left" valign="top">&nbsp;</td>
               <td width="377" align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">R.U.C. N&deg;:                 </td>
               <td align="left" valign="top"><label>
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsNotaDebito->CliNumeroDocumento;?>" />
               </label></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><label>
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsNotaDebito->NdbDireccion;?>" />
                 </label></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Fecha de Emisi&oacute;n:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input readonly="readonly" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsNotaDebito->NdbFechaEmision)){ echo date("d/m/Y");}else{ echo $InsNotaDebito->NdbFechaEmision; }?>" size="15" maxlength="10" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observac&oacute;n Interna:</td>
               <td align="left" valign="top"><textarea readonly="readonly" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsNotaDebito->NdbObservacion);?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Observac&oacute;n Impresa:</td>
               <td align="left" valign="top"><textarea readonly="readonly" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsNotaDebito->NdbObservacionImpresa);?></textarea></td>
               <td>&nbsp;</td>
             </tr>
			 
			 <tr>
			   <td>&nbsp;</td>
			   <td align="left" valign="top">Codigo Motivo:</td>
			   <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpMotivoCodigo" id="CmpMotivoCodigo">
			     <option value="">Escoja una opcion</option>
			     <?php
			  foreach($ArrSunatCatalogos as $DatSunatCatalogo){
			  ?>
			     <option value="<?php echo $DatSunatCatalogo->ScaCodigo?>" <?php if($InsNotaDebito->NdbMotivoCodigo==$DatSunatCatalogo->ScaCodigo){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatSunatCatalogo->ScaNombre?> ( <?php echo $DatSunatCatalogo->ScaCodigo;?>)</option>
			     <?php
			  }
			  ?>
			     </select></td>
			   <td align="left" valign="top">&nbsp;</td>
			   <td align="left" valign="top">Motivo:</td>
			   <td align="left" valign="top"><textarea name="CmpMotivo" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpMotivo"><?php echo $InsNotaDebito->NdbMotivo;?></textarea></td>
			   <td>&nbsp;</td>
			   </tr>
			 <tr>
			   <td>&nbsp;</td>
			   <td>Incluye Impuesto:</td>
			   <td><?php
switch($InsNotaDebito->NdbIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
			     <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  disabled="disabled" >
			       <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
			       <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
			       </select></td>
			   <td align="left" valign="top">&nbsp;</td>
			   <td align="left" valign="top">IGV:<br />
			     (%)</td>
			   <td colspan="2" align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncNotaCreditoDetalleListar();" value="<?php if(empty($InsNotaDebito->NdbPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsNotaDebito->NdbPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" readonly="readonly" /></td>
			   </tr>
			 <tr>
			   <td>&nbsp;</td>
			   <td align="left" valign="top">&nbsp;</td>
			   <td align="left" valign="top">&nbsp;</td>
			   <td align="left" valign="top">&nbsp;</td>
			   <td align="left" valign="top">ISC:<br />
			     (%)</td>
			   <td colspan="2" align="left" valign="top"><input name="CmpPorcentajeImpuestoSelectivo" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoSelectivo" onchange="FncNotaCreditoDetalleListar();" value="<?php echo $InsNotaDebito->NdbPorcentajeImpuestoSelectivo;?>" size="10" maxlength="10" readonly="readonly" /></td>
			   </tr>
			 <tr>
			   <td>&nbsp;</td>
			   <td align="left" valign="top">Moneda:</td>
			   <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId"  disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsNotaDebito->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select></td>
			   <td align="left" valign="top">&nbsp;</td>
			   <td align="left" valign="top">Tipo de Cambio:<br />
			     <span class="EstFormularioSubEtiqueta">(0.000)</span></td>
			   <td valign="top"><table>
			     <tr>
			       <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncNotaDebitoDetalleListar();" value="<?php if (empty($InsNotaDebito->NdbTipoCambio)){ echo "";}else{ echo $InsNotaDebito->NdbTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
			       <td><a href="javascript:FncNotaDebitoEstablecerMoneda();"></a></td>
			       </tr>
			     <tr> </tr>
			     </table></td>
			   <td>&nbsp;</td>
			   </tr>
			 <tr>
			   <td>&nbsp;</td>
			   <td align="left" valign="top">Orden Venta Vehiculo:</td>
			   <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsNotaDebito->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
			   <td align="left" valign="top">&nbsp;</td>
			   <td align="left" valign="top">Estado:</td>
			   <td align="left" valign="top"><?php
			switch($InsNotaDebito->NdbEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;

				case 5:
					$OpcEstado5 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;
			
			}
			?>
                 <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                   <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                 </select></td>
			   <td>&nbsp;</td>
			   </tr>
			 
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS Y OTRAS REFERENCIA</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo Documento:</td>
               <td align="left" valign="top"><?php 
			switch($InsNotaDebito->NdbTipo){
				case 2:
					$OpcTipo1 = 'selected="selected"';
				break;
				
				case 3:
					$OpcTipo2 = 'selected="selected"';
				break;			
				
				case 4:
					$OpcTipo4 = 'selected="selected"';
				break;				
				
			}
			?>
                 <select disabled="disabled" onchange="FncDocumentoAutocompletarCargar(this.value);" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo"  <?php echo ((!empty($InsNotaDebito->DocId) and !empty($InsNotaDebito->DtaId))?'disabled="disabled"':'');?>  >
                   <option  value="0">-</option>
                   <option <?php echo $OpcTipo1;?> value="2">Factura</option>
                   <option <?php echo $OpcTipo2;?> value="3">Boleta</option>
                   <option <?php echo $OpcTipo4;?> value="4">Nota de Credito</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"> Doc.:</td>
               <td align="left" valign="top"><input name="CmpDocumentoId" type="hidden" id="CmpDocumentoId" value="<?php echo $InsNotaDebito->DocId;?>" />
                 <input name="CmpDocumentoTalonario" type="hidden" id="CmpDocumentoTalonario" value="<?php echo $InsNotaDebito->DtaId;?>" />
                 <input name="CmpDocumentoTalonarioNumero" type="hidden" id="CmpDocumentoTalonarioNumero" value="<?php echo $InsNotaDebito->DtaNumero;?>" />
                 <input name="CmpDocumento" type="text" class="EstFormularioCaja" id="CmpDocumento" value="<?php if(!empty($InsNotaDebito->DtaNumero) and !empty($InsNotaDebito->DocId)){ echo $InsNotaDebito->DtaNumero." - ".$InsNotaDebito->DocId; }?>" size="20" maxlength="20" readonly="readonly"  /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2" align="left" valign="top"><input <?php echo (($InsNotaDebito->NdbProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" disabled="disabled" />
                 Procesar comprobante</td>
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
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div class="EstFormularioAccion" id="CapNotaDebitoDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo"> Items
                 que componen la nota de credito</span> </td>
               <td align="right"> 
                 <a href="javascript:FncNotaDebitoDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 <input type="hidden" name="CmpNotaDebitoDetalleAccion" id="CmpNotaDebitoDetalleAccion" value="AccNotaDebitoDetalleRegistrar.php" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapNotaDebitoDetalles" class="EstCapNotaDebitoDetalles" > </div></td>
               <td><div id="CapNotaDebitoDetallesResultado"> </div></td>
               </tr>
             </table>
           </div></td>
       </tr>
       
              <tr>
                <td colspan="2" valign="top">
                  
                  
                <!--<div class="EstFormularioArea" >
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
         </div>-->         </td>
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


<?php
}else{
echo ERR_GEN_101;
}

$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();

?>