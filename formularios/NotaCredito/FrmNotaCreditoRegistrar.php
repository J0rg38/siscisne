<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarEspecial"))?true:false;?>
<?php $PrivilegioRegistrarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"RegistrarEspecial"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaCreditoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaCreditoDetalleFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsDocumentoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsDocumentoFunciones.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletarv2.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdRutFormularios();?>NotaCredito/css/CssNotaCredito.css');
</style>
<?php

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_ori = $_GET['Ori'];


$GET_id = $_GET['FacId'];
$GET_ta = $_GET['FtaId'];
$POST_seleccionados = $_POST['CmpSeleccionados'];
//$POST_do = isset($_POST['CmpDocumento'])?$_POST['CmpDocumento']:$_POST['CmpDocumento2'];

//deb($_POST);
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjNotaCredito.php');
include($InsProyecto->MtdFormulariosMsj("Cliente").'MsjCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsSunatCatalogo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$InsNotaCredito = new ClsNotaCredito();
$InsNotaCreditoTalonario = new ClsNotaCreditoTalonario();
$InsFactura = new ClsFactura();
$InsSunatCatalogo = new ClsSunatCatalogo();
$InsUnidadMedida = new ClsUnidadMedida();

if (!isset($_SESSION['InsNotaCreditoDetalle'.$Identificador])){	
	$_SESSION['InsNotaCreditoDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsNotaCreditoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsNotaCreditoDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaCreditoRegistrar.php');


//MtdObtenerNotaCreditoTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NctId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oMultisucursal=false)
$ResNotaCreditoTalonario = $InsNotaCreditoTalonario->MtdObtenerNotaCreditoTalonarios(NULL,NULL,"NctNumero","DESC",NULL,$InsNotaCredito->SucId,true);
$ArrNotaCreditoTalonarios = $ResNotaCreditoTalonario['Datos'];


$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos(NULL,NULL,'ScaCodigo','ASC',NULL,"CATALOGO9");
$ArrSunatCatalogos = $ResSunatCatalogo['Datos'];

$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos(NULL,NULL,'ScaCodigo','ASC',NULL,"CATALOGO12");
$ArrSunatCatalogos2 = $ResSunatCatalogo['Datos'];


//MtdObtenerUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'UmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,NULL);	
$ArrUnidadMedidas = $ResUnidadMedida['Datos'];
//deb($Resultado);
?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
var Formulario = "FrmRegistrar";

var NotaCreditoDetalleEditar = 1;
var NotaCreditoDetalleEliminar = 1;
//var DocumentoAutocompletarVariables = '&NotaCredito=Si';
//var DocumentoAutocompletarFuncion = "FncNotaCreditoDetalleDocumentoGuardar";

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/			
	$('#CmpClienteNombre').focus();
	
	FncNotaCreditoDetalleListar();	
	
	<?php
	if(!empty($_SESSION['SisNctId']) and empty($GET_id) or !empty($POST_do) ){
	?>
		FncGenerarNotaCreditoId('<?php echo $_SESSION['SisNctId'];?>');
	<?php
	}
	?>
		
	
	<?php
	if($Edito or $Registro){
	?>
		/*if(confirm("Desea imprimir ahora?")){

			FncPopUp('formularios/NotaCredito/FrmNotaCreditoImprimir.php?Id=<?php echo $InsNotaCredito->NcrId;?>&Ta=<?php echo $InsNotaCredito->NctId;?>&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
			
		}*/
		
		dhtmlx.confirm("Desea imprimir ahora?", function(result){
			if(result==true){
				
				FncImprmir("<?php echo $InsNotaCredito->NcrId;?>","<?php echo $InsNotaCredito->NctId;?>");
			   
			}else{
				
				window.location.href = 'principal.php?Mod=NotaCredito&Form=Listado';
				
			}
		});
	
	<?php	
	}
	?>
	
});

</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsNotaCredito->NcrCierre;?>" />
	
    
<div class="EstCapMenu">
<?php
if($Registro){
?>
            
	<?php
	if($PrivilegioVistaPreliminar){
	?>
      	<div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsNotaCredito->NcrId;?>','<?php echo $InsNotaCredito->NctId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
	<?php
	}
	?>
            
	<?php
	if($PrivilegioImprimir){
	?>
		<div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsNotaCredito->NcrId;?>','<?php echo $InsNotaCredito->NctId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        <td><span class="EstFormularioTitulo">REGISTRAR
        NOTA DE CREDITO</span></td>
      </tr>
      <tr>
        <td width="961">		
        
        
                                                 
          
<ul class="tabs">
	<li><a href="#tab1">Nota de Credito</a></li>

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td colspan="2" valign="top">
         
		<div class="EstFormularioArea" >
		
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="4">&nbsp;</td>
            <td colspan="6"><span class="EstFormularioSubTitulo">Datos de la Nota de Credito</span>
              <input type="hidden" name="Guardar" id="Guardar"  value="" />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td width="6">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="right">
              
              <table>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                  
                <select  onchange="FncGenerarNotaCreditoId(this.value);"  class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
                    <option value="">-</option>
                    <?php
                    foreach($ArrNotaCreditoTalonarios as $DatNotaCreditoTalonario){
                    ?>
                    <option <?php if(!empty($InsNotaCredito->NctId)){ if($InsNotaCredito->NctId==$DatNotaCreditoTalonario->NctId){ echo 'selected="selected"';}}elseif($_SESSION['SisNctId']==$DatNotaCreditoTalonario->NctId){ 	echo 'selected="selected"';}?> 			  value="<?php echo $DatNotaCreditoTalonario->NctId;?>" ><?php echo $DatNotaCreditoTalonario->NctNumero;?> (<?php echo $DatNotaCreditoTalonario->NctDescripcion;?>)</option>
                    <?php
                    }
                    ?>
                </select>
                
                    </td>
                  <td>N°.
                    <input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" tabindex="1" value="<?php echo $InsNotaCredito->NcrId;?>" size="10" maxlength="20" <?php echo (($PrivilegioRegistrarEspecial)?'':'readonly="readonly"');?> /></td>
                  <td><a href="javascript:FncGenerarNotaCreditoId(document.getElementById('CmpTalonario').value);"><img border="0" src="imagenes/recargar.jpg" alt="[Recargar]" title="Recargar" width="18" height="18" align="absmiddle"  /></a></td>
                  <td>
                    <div id="CapNotaCredito"></div>
                    </td>
                  </tr>
                </table>            </td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td width="138" align="left" valign="top">Cliente:</td>
            <td colspan="5" align="left" valign="top"><table>
                   <tr>
                     <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsNotaCredito->CliId;?>" size="3" />
                       <input size="3" type="hidden" name="CmpClienteTipoDocumentoId" id="CmpClienteTipoDocumentoId" value="<?php echo $InsNotaCredito->TdoId?>" /></td>
                     <td>
                     <?php
			//if(empty($InsNotaCredito->DocId) and empty($InsNotaCredito->DtaId)){
				
			?>
                     <a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                     
                     <?php
			//}
					 ?>
                     </td>
                     <td><span id="sprytextfield5">
                       <input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsNotaCredito->CliNumeroDocumento;?>"  <?php echo !empty($InsNotaCredito->CliId)?'readonly="readonly"':'';?>  />
                       <span class="textfieldRequiredMsg"> <img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldMinCharsMsg"> <img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe haber almenos 11 digitos"  /> </span></span></td>
                     <td>
                     <?php
			//if(empty($InsNotaCredito->DocId) and empty($InsNotaCredito->DtaId)){
			?>
                     <a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                     
                     <?php
			//}
					 ?>
                     </td>
                     <td>
                       <label>
                         <input  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsNotaCredito->CliNombre;?> <?php echo $InsNotaCredito->CliApellidoPaterno;?> <?php echo $InsNotaCredito->CliApellidoMaterno;?>"  <?php echo !empty($InsNotaCredito->CliId)?'readonly="readonly"':'';?> />
                         </label>
                         
                         <input name="CmpClienteNombre" type="hidden" id="CmpClienteNombre" value="<?php echo $InsNotaCredito->CliNombre;?>" size="45" maxlength="255" xname="CmpClienteNombre"   />
                         <input name="CmpClienteApellidoPaterno" type="hidden" id="CmpClienteNombre2" value="<?php echo $InsNotaCredito->CliApellidoPaterno;?>" size="45" maxlength="255" xname="CmpClienteNombre"   />
                         <input name="CmpClienteApellidoMaterno" type="hidden" id="CmpClienteNombre3" value="<?php echo $InsNotaCredito->CliApellidoMaterno;?>" size="45" maxlength="255" xname="CmpClienteNombre"   /></td>
                     <td>
                     
                         <?php
			//if(empty($InsNotaCredito->DocId) and empty($InsNotaCredito->DtaId)){
				
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
            <td align="left" valign="top">Direccion:</td>
            <td width="369" align="left" valign="top"><input name="CmpClienteDireccion" type="text" class="EstFormularioCaja" id="CmpClienteDireccion" tabindex="5" value="<?php echo $InsNotaCredito->NcrDireccion;?>" size="45" maxlength="255" readonly="readonly"  /></td>
            <td width="9" align="left" valign="top">&nbsp;</td>
            <td width="197" align="left" valign="top">Fecha de Emisi&oacute;n:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td colspan="2" align="left" valign="top"><input name="CmpFechaEmision" type="text" class="EstFormularioCajaFecha" id="CmpFechaEmision" tabindex="6" value="<?php if(empty($InsNotaCredito->NcrFechaEmision)){ echo date("d/m/Y");}else{ echo $InsNotaCredito->NcrFechaEmision; }?>" size="15" maxlength="10" <?php echo (($PrivilegioRegistrarEspecial)?'':'readonly="readonly"');?> />              <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEmision" name="BtnFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observaci&oacute;n Interna:</td>
            <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsNotaCredito->NcrObservacion);?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
            <td colspan="2" align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsNotaCredito->NcrObservacionImpresa);?></textarea></td>
            <td>&nbsp;</td>
          </tr>
		  
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Incluye Impuesto:</td>
            <td align="left" valign="top"><?php
switch($InsNotaCredito->NcrIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
              <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  <?php echo ((!empty($InsNotaCredito->DocId) and !empty($InsNotaCredito->DtaId))?'disabled="disabled"':'');?>  >
                <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">IGV:<br />
              (%)</td>
            <td colspan="2" align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncNotaCreditoDetalleListar();" value="<?php if(empty($InsNotaCredito->NcrPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsNotaCredito->NcrPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">ISC:<br />
              (%)</td>
            <td colspan="2" align="left" valign="top"><input name="CmpPorcentajeImpuestoSelectivo" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoSelectivo" onchange="FncNotaCreditoDetalleListar();" value="<?php echo $InsNotaCredito->NcrPorcentajeImpuestoSelectivo;?>" size="10" maxlength="10" readonly="readonly" /></td>
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
              <option value="<?php echo $DatSunatCatalogo->ScaCodigo?>" <?php if($InsNotaCredito->NcrMotivoCodigo==$DatSunatCatalogo->ScaCodigo){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatSunatCatalogo->ScaNombre?> ( <?php echo $DatSunatCatalogo->ScaCodigo;?>)</option>
              <?php
			  }
			  ?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Motivo:</td>
            <td colspan="2" align="left" valign="top"><textarea tabindex="8" name="CmpMotivo" cols="45" rows="2" class="EstFormularioCaja" id="CmpMotivo"><?php echo stripslashes($InsNotaCredito->NcrMotivo);?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId"  <?php echo ((!empty($InsNotaCredito->DocId) and !empty($InsNotaCredito->DtaId))?'disabled="disabled"':'');?>>
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsNotaCredito->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Tipo de Cambio:<br />
              <span class="EstFormularioSubEtiqueta">(0.000)</span></td>
            <td colspan="2" align="left" valign="top"><table>
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncNotaCreditoDetalleListar();" value="<?php if (empty($InsNotaCredito->NcrTipoCambio)){ echo "";}else{ echo $InsNotaCredito->NcrTipoCambio; } ?>" size="10" maxlength="10" <?php echo (($PrivilegioRegistrarEspecial)?'':'readonly="readonly"');?> /></td>
                <td><a href="javascript:FncNotaCreditoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
              </tr>
              <tr> </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsNotaCredito->NcrEstado){
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
              <select tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS Y OTRAS REFERENCIA</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo Documento:</td>
            <td align="left" valign="top"><?php 
			switch($InsNotaCredito->NcrTipo){
				case 2:
					$OpcTipo1 = 'selected="selected"';
				break;
				
				case 3:
					$OpcTipo2 = 'selected="selected"';
				break;				
				
			}
			?>
              <select onchange="FncDocumentoAutocompletarCargar(this.value);" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo"  <?php echo ((!empty($InsNotaCredito->DocId) and !empty($InsNotaCredito->DtaId))?'disabled="disabled"':'');?>  >
                <option  value="0">-</option>
                <option <?php echo $OpcTipo1;?> value="2">Factura</option>
                <option <?php echo $OpcTipo2;?> value="3">Boleta</option>
              </select>
              
              </td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Doc.:</td>
            <td colspan="2" align="left" valign="top">
            
            
            <table>
            <tr>
            <td>
            
              <input name="CmpDocumentoId" type="hidden" id="CmpDocumentoId" value="<?php echo $InsNotaCredito->DocId;?>" />
              <input name="CmpDocumentoTalonario" type="hidden" id="CmpDocumentoTalonario" value="<?php echo $InsNotaCredito->DtaId;?>" />
              <input name="CmpDocumentoTalonarioNumero" type="hidden" id="CmpDocumentoTalonarioNumero" value="<?php echo $InsNotaCredito->DtaNumero;?>" />
              
            </td>
            <td>
            
            <?php
			if(empty($InsNotaCredito->DocId) and empty($InsNotaCredito->DtaId)){
			?>

				<a href="javascript:FncDocumentoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>

            <?php
			}
			?>
            
            
            
            
            </td>
            <td>
            
            <input name="CmpDocumento" type="text" class="EstFormularioCaja" id="CmpDocumento" value="<?php if(!empty($InsNotaCredito->DtaNumero) and !empty($InsNotaCredito->DocId)){ echo $InsNotaCredito->DtaNumero." - ".$InsNotaCredito->DocId; }?>" size="20" maxlength="20" readonly="readonly" <?php echo ((empty($InsNotaCredito->DocId) and empty($InsNotaCredito->DtaId))?'readonly="readonly"':'');?>    />
            
            </td>
            </tr>
            </table>
            
            
     
              
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Orden Venta Vehiculo:</td>
            <td colspan="2" align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsNotaCredito->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2" align="left" valign="top">
            
            <!--<input <?php echo (($InsNotaCredito->NcrNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
Notificar via email <br />-->
<input <?php echo (($InsNotaCredito->NcrProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" />
Procesar comprobante <br />
<!--<input <?php echo (($InsNotaCredito->NcrEnviarSUNAT==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpEnviarSUNAT" id="CmpEnviarSUNAT" />
Enviar a SUNAT <br />--></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table>
		
        </div>
        
        </td>
       </tr>
       <tr>
         <td colspan="2" valign="top">
           <div class="EstFormularioArea">

                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="7"><span class="EstFormularioSubTitulo">Items</span>
                         <input type="hidden" name="CmpNotaCreditoDetalleItem" id="CmpNotaCreditoDetalleItem" />
                         <input type="hidden" name="CmpNotaCreditoDetalleId" id="CmpNotaCreditoDetalleId" />
                         <!--           <input readonly="readonly" name="CmpNotaCreditoDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpNotaCreditoDetalleProductoId" size="20" maxlength="10" />
                 -->
                         <input readonly="readonly" name="CmpNotaCreditoDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpNotaCreditoDetalleTiempoCreacion" size="20" maxlength="10" />
                         <input readonly="readonly" name="CmpNotaCreditoDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpNotaCreditoDetalleVentaDetalleId" size="20" maxlength="10" /></td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>Codigo:</td>
                       <td>Descripcion:</td>
                       <td>U.M.</td>
                       <td align="left">Precio:</td>
                       <td align="left">Cant.:</td>
                       <td align="left">Desc.:</td>
                       <td align="left">Importe:</td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncNotaCreditoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input tabindex="11" class="EstFormularioCaja" name="CmpNotaCreditoDetalleCodigo" type="text" id="CmpNotaCreditoDetalleCodigo" size="10" maxlength="10"   /></td>
                       <td><input tabindex="11" class="EstFormularioCaja" name="CmpNotaCreditoDetalleDescripcion" type="text" id="CmpNotaCreditoDetalleDescripcion" size="45" maxlength="500"  /></td>
                       <td><input tabindex="10" class="EstFormularioCaja" name="CmpNotaCreditoDetalleUnidadMedida" type="text" id="CmpNotaCreditoDetalleUnidadMedida" size="10" maxlength="10"  /></td>
                       <td><input tabindex="10" class="EstFormularioCaja" name="CmpNotaCreditoDetallePrecio" type="text" id="CmpNotaCreditoDetallePrecio" size="5" maxlength="10"  /></td>
                       <td><input tabindex="10" class="EstFormularioCaja" name="CmpNotaCreditoDetalleCantidad" type="text" id="CmpNotaCreditoDetalleCantidad" size="5" maxlength="10"  /></td>
                       <td><input name="CmpNotaCreditoDetalleDescuento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpNotaCreditoDetalleDescuento" tabindex="12" size="5" maxlength="10"  /></td>
                       <td><input tabindex="12" class="EstFormularioCaja" name="CmpNotaCreditoDetalleImporte" type="text" id="CmpNotaCreditoDetalleImporte" size="5" maxlength="10"  /></td>
                       <td><a href="javascript:FncNotaCreditoDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><a href="javascript:FncNotaCreditoDetalleNuevo();"></a></td>
                       <td colspan="7" align="right"><input type="checkbox" name="CmpNotaCreditoDetalleGratuito" id="CmpNotaCreditoDetalleGratuito" value="1" />
                         Transf. Grat.
                         <input type="checkbox" name="CmpNotaCreditoDetalleExonerado" id="CmpNotaCreditoDetalleExonerado" value="1" />
                         Exon. Imp.
                         <input type="checkbox" name="CmpNotaCreditoDetalleIncluyeSelectivo" id="CmpNotaCreditoDetalleIncluyeSelectivo" value="1" />
                         Inc. Select. </td>
                       <td><a href="javascript:FncNotaCreditoDetalleGuardar();"></a></td>
                       </tr>
                     </table>
             </div>                                 </td>
         </tr>
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
             <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
               <tr>
                 <td width="1%">&nbsp;</td>
                 <td width="48%"><div class="EstFormularioAccion" id="CapNotaCreditoDetalleAccion">Listo
                   para registrar elementos</div></td>
                 <td width="50%" align="right"><a href="javascript:FncNotaCreditoDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncNotaCreditoDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/> Eliminar Todo</a>
                   <input type="hidden" name="CmpNotaCreditoDetalleAccion" id="CmpNotaCreditoDetalleAccion" value="AccNotaCreditoDetalleRegistrar.php" /></td>
                 <td width="1%">&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2"><div id="CapNotaCreditoDetalles" class="EstCapNotaCreditoDetalles" > </div></td>
                 <td><div id="CapNotaCreditoDetallesResultado"> </div></td>
               </tr>
               </table>
            </div></td>
         </tr>
       <?php
	   
	   ?>
       <?php
	   
	   ?>
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
	if($PrivilegioRegistrarEspecial){
	?>

		Calendar.setup({ 
	inputField : "CmpFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEmision"// el id del botón que  
	});

	<?php	
	}
	?>
	
	
</script>
<?php
}else{
echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>