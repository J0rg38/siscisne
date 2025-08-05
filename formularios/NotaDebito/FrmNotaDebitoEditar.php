<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarEspecial"))?true:false;?>
<?php $PrivilegioRegistrarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"RegistrarEspecial"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaDebitoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaDebitoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdRutFormularios();?>NotaDebito/css/CssNotaDebito.css');
</style>

<?php
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

include($InsProyecto->MtdFormulariosMsj("NotaDebito").'MsjNotaDebito.php');
include($InsProyecto->MtdFormulariosMsj("Cliente").'MsjCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsSunatCatalogo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$InsNotaDebito = new ClsNotaDebito();
$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();
$InsFactura = new ClsFactura();
$InsSunatCatalogo = new ClsSunatCatalogo();
$InsUnidadMedida = new ClsUnidadMedida();

if (isset($_SESSION['InsNotaDebitoDetalle'.$Identificador])){	
	$_SESSION['InsNotaDebitoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsNotaDebitoDetalle'.$Identificador]);
}

//include($InsProyecto->MtdRutFormularios().'NotaDebito/acc/AccNotaDebitoEditar.php');
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaDebitoEditar.php');

$ResNotaDebitoTalonario = $InsNotaDebitoTalonario->MtdObtenerNotaDebitoTalonarios(NULL,NULL,"NdtNumero","DESC",NULL,$InsNotaDebito->SucId);
$ArrNotaDebitoTalonarios = $ResNotaDebitoTalonario['Datos'];


$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos(NULL,NULL,'ScaCodigo','ASC',NULL,"CATALOGO10");
$ArrSunatCatalogos = $ResSunatCatalogo['Datos'];

$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos(NULL,NULL,'ScaCodigo','ASC',NULL,"CATALOGO12");
$ArrSunatCatalogos2 = $ResSunatCatalogo['Datos'];


//MtdObtenerUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'UmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,NULL);	
$ArrUnidadMedidas = $ResUnidadMedida['Datos'];
//deb($Resultado);
?>

<?php
if($InsNotaDebito->NdbCierre==2){
?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";
var NotaDebitoDetalleEditar = 1;
var NotaDebitoDetalleEliminar = 1;


$().ready(function() {
/*
Configuracion carga de datos y animacion
*/	

	$('#CmpClienteNombre').focus();
				
	FncNotaDebitoDetalleListar();
	
	<?php
	if($Edito or $Registro){
	?>
		if(confirm("Desea imprimir ahora?")){

			FncPopUp('formularios/NotaDebito/FrmNotaDebitoImprimir.php?Id=<?php echo $InsNotaDebito->NdbId;?>&Ta=<?php echo $InsNotaDebito->NdtId;?>&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

		}
	
	<?php	
	}
	?>
	
});

</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsNotaDebito->NdbCierre;?>" />
	
    
<div class="EstCapMenu">
			<?php
			if($Edito){
			?>
            
			<?php
			if($PrivilegioVistaPreliminar){
			?>
            
            <!--<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>NotaDebito/FrmNotaDebitoImprimir.php?Id=<?php echo $InsNotaDebito->NdbId;?>&Ta=<?php echo $InsNotaDebito->NdtId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>-->
            
             <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsNotaDebito->NdbId;?>','<?php echo $InsNotaDebito->NdtId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
            
            
            
  <?php
			}
			?>
  <?php
			if($PrivilegioImprimir){
			?>
            <!--<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>NotaDebito/FrmNotaDebitoImprimir.php?Id=<?php echo $InsNotaDebito->NdbId;?>&Ta=<?php echo $InsNotaDebito->NdtId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>-->
            
            
            <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsNotaDebito->NdbId;?>','<?php echo $InsNotaDebito->NdtId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
            
            
            
            
			<?php
			}
			?>
            
 
            
                        
			<?php
			}
			?>    

        

<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>
    
</div>
<div class="EstCapContenido">


	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td><span class="EstFormularioTitulo">EDITAR
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
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5"><span class="EstFormularioSubTitulo">Datos de la Nota de Debito 
                                                                  <input type="hidden" name="Guardar" id="Guardar"  value="" />
                                                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                                                  </span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="right">
                                                                    
<table>
<tr>
  <td>Serie:</td>
  <td><input type="hidden" value="<?php echo $InsNotaDebito->NdtId; ?>" name="CmpTalonario" id="CmpTalonario" />
    <select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario2" id="CmpTalonario2">
      <?php
			  foreach($ArrNotaDebitoTalonarios as $DatNotaDebitoTalonario){
			  ?>
      <option <?php if($InsNotaDebito->NdtId==$DatNotaDebitoTalonario->NdtId){ echo 'selected="selected"';}?> value="<?php echo $DatNotaDebitoTalonario->NdtId;?>" ><?php echo $DatNotaDebitoTalonario->NdtNumero;?>  (<?php echo $DatNotaDebitoTalonario->NdtDescripcion;?>)</option>
      <?php
			  }
			  ?>
    </select></td>
<td align="right">Numero:

</td>
<td><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsNotaDebito->NdbId;?>" size="20" maxlength="20" readonly="readonly"  />

</td>
</tr>
</table></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td>Cliente:</td>
                                                                  <td colspan="4"><table>
                   <tr>
                     <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsNotaDebito->CliId;?>" size="3" />
                       <input size="3" type="hidden" name="CmpClienteTipoDocumentoId" id="CmpClienteTipoDocumentoId" value="<?php echo $InsNotaDebito->TdoId?>" /></td>
                     <td>
                     <?php
///			if(empty($InsNotaDebito->DocId) and empty($InsNotaDebito->DtaId)){
				
			?>
                     <a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                     
                     <?php
	//		}
					 ?>
                     </td>
                     <td><span id="sprytextfield5">
                       <input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsNotaDebito->CliNumeroDocumento;?>"  <?php echo !empty($InsNotaDebito->CliId)?'readonly="readonly"':'';?>  />
                       <span class="textfieldRequiredMsg"> <img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldMinCharsMsg"> <img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe haber almenos 11 digitos"  /> </span></span></td>
                     <td>
                     <?php
	//		if(empty($InsNotaDebito->DocId) and empty($InsNotaDebito->DtaId)){
			?>
                     <a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                     
                     <?php
//			}
					 ?>
                     </td>
                     <td>
                       <label>
                         <input  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsNotaDebito->CliNombre;?> <?php echo $InsNotaDebito->CliApellidoPaterno;?> <?php echo $InsNotaDebito->CliApellidoMaterno;?>"  <?php echo !empty($InsNotaDebito->CliId)?'readonly="readonly"':'';?> />
                         </label>
                         
                         <input name="CmpClienteNombre" type="hidden" id="CmpClienteNombre" value="<?php echo $InsNotaDebito->CliNombre;?>" size="45" maxlength="255" xname="CmpClienteNombre"   />
                         <input name="CmpClienteApellidoPaterno" type="hidden" id="CmpClienteNombre2" value="<?php echo $InsNotaDebito->CliApellidoPaterno;?>" size="45" maxlength="255" xname="CmpClienteNombre"   />
                         <input name="CmpClienteApellidoMaterno" type="hidden" id="CmpClienteNombre3" value="<?php echo $InsNotaDebito->CliApellidoMaterno;?>" size="45" maxlength="255" xname="CmpClienteNombre"   /></td>
                     <td>
                     
                         <?php
			//if(empty($InsNotaDebito->DocId) and empty($InsNotaDebito->DtaId)){
				
			?>
                     <a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a><a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a>
              <?php
			//}
			  ?>       
                     </td>
                     </tr>
                   </table></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td>Direccion:</td>
                                                                  <td><input name="CmpClienteDireccion" type="text" class="EstFormularioCaja" id="CmpClienteDireccion" tabindex="5" value="<?php echo $InsNotaDebito->NdbDireccion;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                                                  <td>&nbsp;</td>
                                                                  <td>Fecha de Emisi&oacute;n:<br />
                                                                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td><span id="sprytextfield1">
                                                                    <label>
                                                                    <input tabindex="6" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsNotaDebito->NdbFechaEmision)){ echo date("d/m/Y");}else{ echo $InsNotaDebito->NdbFechaEmision; }?>" size="15" maxlength="10" <?php echo (($PrivilegioEditarEspecial)?'':'readonly="readonly"');?>  />
                                                                    </label>
                                                                    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEmision" name="BtnFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td valign="top">Observaci&oacute;n Interna:</td>
                                                                  <td><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsNotaDebito->NdbObservacion);?></textarea></td>
                                                                  <td>&nbsp;</td>
                                                                  <td valign="top">Observaci&oacute;n Impresa:</td>
                                                                  <td><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsNotaDebito->NdbObservacionImpresa);?></textarea></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
																
																<tr>
																  <td>&nbsp;</td>
																  <td align="left" valign="top">Codigo Motivo:</td>
																  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMotivoCodigo" id="CmpMotivoCodigo">
																    <option value="">Escoja una opcion</option>
																    <?php
			  foreach($ArrSunatCatalogos as $DatSunatCatalogo){
			  ?>
																    <option value="<?php echo $DatSunatCatalogo->ScaCodigo?>" <?php if($InsNotaDebito->NdbMotivoCodigo==$DatSunatCatalogo->ScaCodigo){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatSunatCatalogo->ScaNombre?> ( <?php echo $DatSunatCatalogo->ScaCodigo;?>)</option>
																    <?php
			  }
			  ?>
																    </select></td>
																  <td valign="top">&nbsp;</td>
																  <td valign="top">Motivo:</td>
																  <td valign="top"><textarea tabindex="8" name="CmpMotivo" cols="45" rows="2" class="EstFormularioCaja" id="CmpMotivo"><?php echo stripslashes($InsNotaDebito->NdbMotivo);?></textarea></td>
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
                                                                    <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto" <?php echo ((!empty($InsNotaDebito->DocId) and !empty($InsNotaDebito->DtaId))?'disabled="disabled"':'');?>  >
                                                                      <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                                                                      <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                                                                  </select></td>
																  <td valign="top">&nbsp;</td>
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
																  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId"  <?php echo ((!empty($InsNotaDebito->DocId) and !empty($InsNotaDebito->DtaId))?'disabled="disabled"':'');?>>
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
																      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncNotaDebitoDetalleListar();" value="<?php if (empty($InsNotaDebito->NdbTipoCambio)){ echo "";}else{ echo $InsNotaDebito->NdbTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" <?php echo (($PrivilegioEditarEspecial)?'':'readonly="readonly"');?>  /></td>
																      <td><a href="javascript:FncNotaDebitoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
															        </tr>
																    <tr> </tr>
															      </table></td>
																  <td>&nbsp;</td>
															    </tr>
																<tr>
																  <td>&nbsp;</td>
																  <td valign="top">Estado:</td>
																  <td valign="top"><?php
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
																    <select  tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
																      <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
																      <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
																      <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
															        </select></td>
																  <td valign="top">&nbsp;</td>
																  <td valign="top">&nbsp;</td>
																  <td valign="top">&nbsp;</td>
																  <td>&nbsp;</td>
															    </tr>
																<tr>
																  <td>&nbsp;</td>
																  <td colspan="5" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS Y OTRAS REFERENCIA</span></td>
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
																  <td>&nbsp;</td>
																  <td valign="top"> Doc.:</td>
																  <td><table>
            <tr>
            <td>
            
              <input name="CmpDocumentoId" type="hidden" id="CmpDocumentoId" value="<?php echo $InsNotaDebito->DocId;?>" />
              <input name="CmpDocumentoTalonario" type="hidden" id="CmpDocumentoTalonario" value="<?php echo $InsNotaDebito->DtaId;?>" />
              <input name="CmpDocumentoTalonarioNumero" type="hidden" id="CmpDocumentoTalonarioNumero" value="<?php echo $InsNotaDebito->DtaNumero;?>" />
              
            </td>
            <td>
            
            <?php
			if(empty($InsNotaDebito->DocId) and empty($InsNotaDebito->DtaId)){
			?>

				<a href="javascript:FncDocumentoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>

            <?php
			}
			?>
            
            
            
            
            </td>
            <td>
            
            <input name="CmpDocumento" type="text" class="EstFormularioCaja" id="CmpDocumento" value="<?php if(!empty($InsNotaDebito->DtaNumero) and !empty($InsNotaDebito->DocId)){ echo $InsNotaDebito->DtaNumero." - ".$InsNotaDebito->DocId; }?>" size="20" maxlength="20" readonly="readonly" <?php echo ((empty($InsNotaDebito->DocId) and empty($InsNotaDebito->DtaId))?'readonly="readonly"':'');?>    />
            
            </td>
            </tr>
            </table></td>
																  <td>&nbsp;</td>
															    </tr>
																<tr>
																  <td>&nbsp;</td>
																  <td valign="top">Orden Venta Vehiculo:</td>
																  <td><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsNotaDebito->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
																  <td>&nbsp;</td>
																  <td align="left" valign="top">&nbsp;</td>
																  <td align="left" valign="top">&nbsp;</td>
																  <td>&nbsp;</td>
															    </tr>
																<tr>
																  <td>&nbsp;</td>
																  <td colspan="2" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
																  <td>&nbsp;</td>
																  <td valign="top">&nbsp;</td>
																  <td>&nbsp;</td>
																  <td>&nbsp;</td>
															    </tr>
																<tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2" valign="top"><input <?php echo (($InsNotaDebito->NdbProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" disabled="disabled" />
                                                                    Procesar comprobante </td>
                                                                  <td>&nbsp;</td>
                                                                  <td valign="top">&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                  <td>&nbsp;</td>
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
                                                                      <td colspan="7"><span class="EstFormularioSubTitulo">Items</span>
                                                                        <input type="hidden" name="CmpNotaDebitoDetalleItem" id="CmpNotaDebitoDetalleItem" />
                                                                        <input type="hidden" name="CmpNotaDebitoDetalleId" id="CmpNotaDebitoDetalleId" />
                                                                        <!--           <input readonly="readonly" name="CmpNotaDebitoDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpNotaDebitoDetalleProductoId" size="20" maxlength="10" />
                 -->
                                                                        <input readonly="readonly" name="CmpNotaDebitoDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpNotaDebitoDetalleTiempoCreacion" size="20" maxlength="10" />
                                                                      <input readonly="readonly" name="CmpNotaDebitoDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpNotaDebitoDetalleVentaDetalleId" size="20" maxlength="10" /></td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td>&nbsp;</td>
                                                                      <td>Codigo:</td>
                                                                      <td>Descripcion:</td>
                                                                      <td>U.M.</td>
                                                                      <td>Precio:</td>
                                                                      <td>Cantidad:</td>
                                                                      <td>Importe:</td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td><a href="javascript:FncNotaDebitoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td><input tabindex="11" class="EstFormularioCaja" name="CmpNotaDebitoDetalleCodigo" type="text" id="CmpNotaDebitoDetalleCodigo" size="10" maxlength="10"   /></td>
                                                                      <td><input tabindex="11" class="EstFormularioCaja" name="CmpNotaDebitoDetalleDescripcion" type="text" id="CmpNotaDebitoDetalleDescripcion" size="45" maxlength="500"  /></td>
                                                                      <td><input tabindex="10" class="EstFormularioCaja" name="CmpNotaDebitoDetalleUnidadMedida" type="text" id="CmpNotaDebitoDetalleUnidadMedida" size="10" maxlength="10"  /></td>
                                                                      <td><input tabindex="10" class="EstFormularioCaja" name="CmpNotaDebitoDetallePrecio" type="text" id="CmpNotaDebitoDetallePrecio" size="10" maxlength="10"  /></td>
                                                                      <td><input tabindex="10" class="EstFormularioCaja" name="CmpNotaDebitoDetalleCantidad" type="text" id="CmpNotaDebitoDetalleCantidad" size="10" maxlength="10"  /></td>
                                                                      <td><input tabindex="12" class="EstFormularioCaja" name="CmpNotaDebitoDetalleImporte" type="text" id="CmpNotaDebitoDetalleImporte" size="10" maxlength="10"  /></td>
                                                                      <td><a href="javascript:FncNotaDebitoDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="7" align="right"><input type="checkbox" name="CmpNotaDebitoDetalleGratuito" id="CmpNotaDebitoDetalleGratuito" value="1" />
                                                                        Transf. Grat.
                                                                        <input type="checkbox" name="CmpNotaDebitoDetalleExonerado" id="CmpNotaDebitoDetalleExonerado" value="1" />
                                                                      Exon. Imp.</td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                  </table>
                                                            </div>                                                            </td>
                                                           </tr>

                                                          <tr>
                                                            <td colspan="2" valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="1%">&nbsp;</td>
                                                                    <td colspan="2"><div class="EstFormularioAccion" id="CapNotaDebitoDetalleAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="2%">&nbsp;</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td width="51%"><span class="EstFormularioSubTitulo"> Items
                                                                      que componen la nota de credito</span> </td>
                                                                    <td width="46%" align="right"> 
                                                                        <a href="javascript:FncNotaDebitoDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncNotaDebitoDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/> Eliminar Todo</a>
  
                                                                        
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
	
	
		<?php
	if($PrivilegioEditarEspecial){
	?>
	
		Calendar.setup({ 
	inputField : "CmpFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEmision"// el id del bot&oacute;n que  
	}); 
	
		
<?php
	}
?>

</script>

<script type="text/javascript">


var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
</script>
<?php
}elseif(!empty($InsNotaDebito->NdbCierre)){
echo ERR_NDB_401;
}
?>
<?php
}else{
echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
