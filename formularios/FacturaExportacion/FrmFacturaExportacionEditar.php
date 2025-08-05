<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioRegistrarPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>
<?php $PrivilegioListadoPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>

<?php //$PrivilegioRegistrarPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>
<?php //$PrivilegioListadoPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Regimen");?>JsRegimenFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaExportacionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaExportacionDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaExportacionAlmacenMovimientoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFacturaExportacion.css');
</style>
<?php
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFacturaExportacion.php');
include($InsProyecto->MtdFormulariosMsj("Cliente").'MsjCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');


$InsFacturaExportacion = new ClsFacturaExportacion();
$InsFacturaExportacionTalonario = new ClsFacturaExportacionTalonario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();

if (isset($_SESSION['InsFacturaExportacionDetalle'.$Identificador])){	
	$_SESSION['InsFacturaExportacionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaExportacionDetalle'.$Identificador]);
}
	
if (isset($_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador])){	
	$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFacturaExportacionEditar.php');

$ResFacturaExportacionTalonario = $InsFacturaExportacionTalonario->MtdObtenerFacturaExportacionTalonarios(NULL,NULL,"FetNumero","DESC",NULL);
$ArrFacturaExportacionTalonarios = $ResFacturaExportacionTalonario['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",NULL);
$ArrRegimenes = $ResRegimen['Datos'];

?>

<?php
if($InsFacturaExportacion->FexCierre==1){
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
var FacturaExportacionDetalleEditar = 1;
var FacturaExportacionDetalleEliminar = 1;



$().ready(function() {

/*
Configuracion carga de datos y animacion
*/		

	$('#CmpClienteNombre').focus();
	
	FncFacturaExportacionEstablecerMoneda();
	FncFacturaExportacionEstablecerCondicionPago();
	FncFacturaExportacionEstablecerRegimen();		
		
	FncFacturaExportacionDetalleListar();
	
	FncFacturaExportacionAlmacenMovimientoListar();
		
	//FncClienteEscoger("<?php echo $InsFacturaExportacion->CliId;?>","<?php echo $InsFacturaExportacion->CliNumeroDocumento;?>","<?php echo $InsFacturaExportacion->CliNombre;?>","<?php echo $InsFacturaExportacion->TdoId;?>");

	<?php
	if($Edito or $Registro){
	?>
		
		if(confirm("Desea imprimir ahora?")){
			
			FncImprmir("<?php echo $InsFacturaExportacion->FexId;?>","<?php echo $InsFacturaExportacion->FetId;?>","<?php echo ($InsFacturaExportacion->FetNumero=="200")?'2':'1';?>");
			
		}
		
	<?php	
	}
	?>

});
</script>







<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsFacturaExportacion->FexCierre;?>" />
	
<div class="EstCapMenu">
			<?php
			if($Edito){
			?>
            
			<?php
			if($PrivilegioVistaPreliminar){
			?>
 
  <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFacturaExportacion->FexId;?>','<?php echo $InsFacturaExportacion->FetId;?>','<?php echo ($InsFacturaExportacion->FetNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>


        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
  
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFacturaExportacion->FexId;?>','<?php echo $InsFacturaExportacion->FetId;?>','<?php echo ($InsFacturaExportacion->FetNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>


   
   
              
			<?php
			}
			?>    
			<?php
			}
			?>   
            
 
<?php
/*if($PrivilegioRegistrarPago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>FacturaExportacion/FrmFacturaExportacionPagar.php?Id=<?php echo $InsFacturaExportacion->FexId;?>&Ta=<?php echo $InsFacturaExportacion->FetId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagar.png" alt="[Pagar]" title="Registrar Pago"  />Pagar</a></div>           
<?php
}*/
?>
      
      
      <?php
/*if($PrivilegioListadoPago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>FacturaExportacion/FrmFacturaExportacionPagoListado.php?Id=<?php echo $InsFacturaExportacion->FexId;?>&Ta=<?php echo $InsFacturaExportacion->FetId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
<?php
}*/
?>   
<?php
if($PrivilegioRegistrarPago){
?>
	
<div class="EstSubMenuBoton"><a href="javascript:FncPagoFacturaExportacionCargarFormulario('Registrar','<?php echo $InsFacturaExportacion->FexId;?>','<?php echo $InsFacturaExportacion->FetId;?>');" ><img src="imagenes/iconos/pagar.png" alt="[Pagar]" title="Registrar Pago"  />Pagar</a></div>    
<?php
}
?>

<?php
if($PrivilegioListadoPago){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncPagoFacturaExportacionCargarFormulario('Listado','<?php echo $InsFacturaExportacion->FexId;?>','<?php echo $InsFacturaExportacion->FetId;?>');" ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>   

<?php
}
?>

<?php
if($PrivilegioAuditoriaVer){
?>
<div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsFacturaExportacion->FexId;?>&Ta=<?php echo $InsFacturaExportacion->FetId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>  
<?php
}
?>   
            
            <input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" onsubmit="FncGuardar();" >

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
        <td width="961" height="25"><span class="EstFormularioTitulo">EDITAR FACTURA DE EXPORTACION</span></td>
      </tr>
      <tr>
        <td>	
        
                     
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFacturaExportacion->FexTiempoCreacion;?></span></td>
            <td></td>
			<td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFacturaExportacion->FexTiempoModificacion;?></span></td>
			<td></td>
			<td>Creado por:</td>
			<td><span class="EstFormularioDatoRegistro"><?php echo $InsFacturaExportacion->UsuUsuario;?></span></td>
          </tr>
        </table>
		</div>                                
        
        
 <br />
 
 
 <ul class="tabs">
	<li><a href="#tab1">Factura</a></li>
  
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->   
	
       
<table width="100%" border="0" cellpadding="2" cellspacing="2">
                                                          <tr>
                                                            <td width="1096" colspan="2" valign="top"><div class="EstFormularioArea" >
                                                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5"><span class="EstFormularioSubTitulo"> Datos de la factura</span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2" align="center" valign="bottom">
                                                                  
                                                                  <table border="0" cellpadding="0" cellspacing="0">
                                                                  <tr>
                                                                    <td><input type="hidden" name="Guardar" id="Guardar"  value="" />
                                                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                                                                  <td>
                                                                  
                                                                  <input name="CmpTalonario" id="CmpTalonario" type="hidden" value="<?php echo $InsFacturaExportacion->FetId;?>" />
                                                                    <select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario2" id="CmpTalonario2">
                                                                      <?php

			  foreach($ArrFacturaExportacionTalonarios as $DatFacturaExportacionTalonario){
			  ?>
                                                                      <option <?php if($InsFacturaExportacion->FetId==$DatFacturaExportacionTalonario->FetId){ echo 'selected="selected"';}?> value="<?php echo $DatFacturaExportacionTalonario->FetId;?>" ><?php echo $DatFacturaExportacionTalonario->FetNumero;?></option>
                                                                      <?php
			  }
			  ?>
                                                                  </select>
                                                                  
                                                                  </td>
                                                                  <td>
                                                                  
                                                                  N&deg;.
                                                                  <input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsFacturaExportacion->FexId;?>" size="20" maxlength="20" readonly="readonly"  />
                                                                  
                                                                  </td>
                                                                  <td>
                                                                  
                                                                  
                                                                  </td>
                                                                  </tr>
                                                                  </table>
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Se&ntilde;ores:
                                                                    <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsFacturaExportacion->CliId;?>" />
                                                                      
                                                                                                                                      
                                                                      
                                                                      </td>
                                                                  <td colspan="4" align="left" valign="top"><table>
                                                                    <tr>
                                                                      <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" <?php echo !empty($InsFacturaExportacion->CliId)?'disabled="disabled"':'';?> >
                                                                        <option value="">Escoja una opcion</option>
                                                                        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
                                                                        <option <?php if($InsFacturaExportacion->TdoId==$DatTipoDocumento->TdoId){ echo 'selected="selected"';}?> value="<?php echo $DatTipoDocumento->TdoId; ?>">[<?php echo $DatTipoDocumento->TdoCodigo; ?>] <?php echo $DatTipoDocumento->TdoNombre; ?></option>
                                                                        <?php
			}			
			?>
                                                                      </select></td>
                                                                      <td><input tabindex="3" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsFacturaExportacion->CliNumeroDocumento;?>" <?php echo !empty($InsFacturaExportacion->CliId)?'readonly="readonly"':'';?>   /></td>
                                                                      <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td><span id="sprytextfield2">
                                                                        <label>
                                                                          <input tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsFacturaExportacion->CliNombre;?> <?php echo $InsFacturaExportacion->CliApellidoPaterno;?> <?php echo $InsFacturaExportacion->CliApellidoMaterno;?>" <?php echo !empty($InsFacturaExportacion->CliId)?'readonly="readonly"':'';?>  />
                                                                        </label>
                                                                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                                                                      <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                                                                      <td><div id="CapClienteBuscar"></div></td>
                                                                    </tr>
                                                                    <tr> </tr>
                                                                  </table></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Direcci&oacute;n:</td>
                                                                  <td align="left" valign="top"><input tabindex="4" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsFacturaExportacion->FexDireccion;?>"  /></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td align="left" valign="top"><span id="sprytextfield1">
                                                                    <label>
                                                                    <input tabindex="5" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsFacturaExportacion->FexFechaEmision)){ echo date("d/m/Y");}else{ echo $InsFacturaExportacion->FexFechaEmision; }?>" size="15" maxlength="10" />
                                                                    </label>
                                                                    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEmision" name="BtnFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                                                                  <td align="left" valign="top"><textarea  tabindex="6" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsFacturaExportacion->FexObservacion;?></textarea></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsFacturaExportacion->FexObservacionImpresa;?></textarea></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Impuesto: <br />
                                                                    <span class="EstFormularioSubEtiqueta">(%)</span></td>
                                                                  <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsFacturaExportacion->FexPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsFacturaExportacion->FexPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Moneda:</td>
                                                                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                      <td><span id="spryselect3">
                                                                        <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                                                                          <option value="">Escoja una opcion</option>
                                                                          <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                                                                          <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsFacturaExportacion->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                                                                          <?php
			  }
			  ?>
                                                                        </select>
                                                                        <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                                                                      <td><div id="CapMonedaBuscar"></div></td>
                                                                    </tr>
                                                                    <tr> </tr>
                                                                  </table></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
                                                                  <td align="left" valign="top">
                                                                  

<table>
<tr>
<td>
                                                                  <span id="sprytextfield6">
                                                                  <label for="CmpTipoCambio"></label>
                                                                  <input  class="EstFormularioCaja" name="CmpTipoCambio" type="text" id="CmpTipoCambio" value="<?php if (empty($InsFacturaExportacion->FexTipoCambio)){ echo "";}else{ echo $InsFacturaExportacion->FexTipoCambio; } ?>" size="10" maxlength="10" onchange="FncFacturaExportacionDetalleListar();" />
                                                                  </span>
</td>
<td>

<a href="javascript:FncFacturaExportacionEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>

</td>
</tr>
</table>                                                              
                                                                  
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Condicion de Pago:</td>
                                                                  <td align="left" valign="top"><span id="spryselect2">
                                                                  <select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                                                                    <option value="">Escoja una opcion</option>
                                                                    <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                                                                    <option <?php if($InsFacturaExportacion->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                                                                    <?php  
					}
					?>
                                                                  </select>
                                                                  <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Cantidad de Dias:</td>
                                                                  <td align="left" valign="top"><span id="sprytextfield11">
                                                                  <input class="EstFormularioCaja" name="CmpCantidadDia" type="text" id="CmpCantidadDia" size="10" maxlength="3" value="<?php echo $InsFacturaExportacion->FexCantidadDia;?>" />
                                                                  <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Estado:</td>
                                                                  <td align="left" valign="top"><?php
			switch($InsFacturaExportacion->FexEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;

				case 5:
					$OpcEstado5 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;
			
				case 7:
					$OpcEstado7 = 'selected="selected"';
				break;
			}
			?>
                                                                      <select tabindex="8" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                                                                        <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                                                                        <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                                                                        <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                                                                        <option <?php echo $OpcEstado7;?> value="7">Reservado</option>
                                                                      </select>                                                                  </td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Obsequio:</td>
                                                                  <td align="left" valign="top"><?php
			switch($InsFacturaExportacion->FexObsequio){
			case 1:
					$OpcObsequio1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcObsequio2 = 'selected="selected"';
				break;
				
			
			}
			?>
                                                                    <select tabindex="9" class="EstFormularioCombo" id="CmpObsequio" name="CmpObsequio">
                                                                      <option <?php echo $OpcObsequio1;?> value="1">Si</option>
                                                                      <option <?php echo $OpcObsequio2;?> value="2">No</option>
                                                                    </select></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
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
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS RELACIONADOS</span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td width="4">&nbsp;</td>
                                                                  <td colspan="8" align="left" valign="top">Almacen/Taller</td>
                                                                  <td width="5">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Ord. Trabajo:</td>
                                                                  <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->FinId;?>" size="20" maxlength="20" readonly="readonly" />
                                                                    <input type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php echo $InsFacturaExportacion->FccId;?>" /></td>
                                                                  <td align="left" valign="top">Cotizacion:</td>
                                                                  <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->CprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                  <td align="left" valign="top">Orden Venta:</td>
                                                                  <td width="5" align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->VdiId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                  <td width="5" align="left" valign="top">Ficha Salida:</td>
                                                                  <td width="5" align="left" valign="top"><input name="CmpAlmacenMovimientoSalidaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoSalidaId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->AmoId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Otras Fichas:</td>
                                                                  <td colspan="7" align="left" valign="top"><div id="CapFacturaExportacionAlmacenMovimientos" class="EstCapFacturaExportacionAlmacenMovimientos" ></div></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top"><div class="EstFormularioArea"> 
                                                                  
                                                                    
                                 
                                                                    
                                                                     
                                                                     
                                                                      <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                        <tr>
                                                                          <td>&nbsp;</td>
                                                                          <td colspan="8"><span class="EstFormularioSubTitulo">items</span>
                                                                            <input type="hidden" name="CmpFacturaExportacionDetalleItem" id="CmpFacturaExportacionDetalleItem" />
                                                                            <input type="hidden" name="CmpFacturaExportacionDetalleId" id="CmpFacturaExportacionDetalleId" />
                                                                            <!--           <input readonly="readonly" name="CmpFacturaExportacionDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpFacturaExportacionDetalleProductoId" size="20" maxlength="10" />
                 -->
                                                                            <input readonly="readonly" name="CmpFacturaExportacionDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpFacturaExportacionDetalleTiempoCreacion" size="20" maxlength="10" />
                                                                            <input readonly="readonly" name="CmpFacturaExportacionDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpFacturaExportacionDetalleVentaDetalleId" size="20" maxlength="10" />
                                                                          <input type="hidden" name="CmpArticuloId" id="CmpArticuloId" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>&nbsp;</td>
                                                                          <td>&nbsp;</td>
                                                                          <td>Tipo:</td>
                                                                          <td>Descripcion:</td>
                                                                          <td>U.M.</td>
                                                                          <td>Precio  (<span class="EstMonedaSimbolo"><span id="CapMonedaArticuloPrecio"></span></span>):</td>
                                                                          <td>Cantidad:</td>
                                                                          <td>Importe  (<span class="EstMonedaSimbolo"><span id="CapMonedaArticuloImporte"></span></span>):</td>
                                                                          <td>&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>&nbsp;</td>
                                                                          <td><a href="javascript:FncFacturaExportacionDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                          <td><select  class="EstFormularioCombo" name="CmpFacturaExportacionDetalleTipo" id="CmpFacturaExportacionDetalleTipo">
                                                                           
                                                                            <option value="">-</option>
                                                                            <option value="R">Repuesto</option>
                                                                            <option value="S">Servicio</option>
                                                                            <option value="M">Material</option>
                                                                            </option>
                                                                          </select></td>
                                                                          <td><input tabindex="10" class="EstFormularioCaja" name="CmpArticuloDescripcion" type="text" id="CmpArticuloDescripcion" size="45"   /></td>
                                                                          <td><input tabindex="10" class="EstFormularioCaja" name="CmpFacturaExportacionDetalleUnidadMedida" type="text" id="CmpFacturaExportacionDetalleUnidadMedida" size="10" maxlength="10"  /></td>
                                                                          <td><input tabindex="11" class="EstFormularioCaja" name="CmpFacturaExportacionDetallePrecio" type="text" id="CmpFacturaExportacionDetallePrecio" size="10" maxlength="10"   /></td>
                                                                          <td><input tabindex="9" class="EstFormularioCaja" name="CmpFacturaExportacionDetalleCantidad" type="text" id="CmpFacturaExportacionDetalleCantidad" size="10" maxlength="10"    /></td>
                                                                          <td><input tabindex="11" class="EstFormularioCaja" name="CmpFacturaExportacionDetalleImporte" type="text" id="CmpFacturaExportacionDetalleImporte" size="15" maxlength="10"    /></td>
                                                                          <td><a href="javascript:FncFacturaExportacionDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                        </tr>
                                                                      </table>
																	                                                                
                                                                      
                                                                    
                                                            </div></td>
                                                          </tr>
                                                          
                                                          <tr>
                                                            <td colspan="2" valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="2%">&nbsp;</td>
                                                                    <td width="48%"><div class="EstFormularioAccion" id="CapFacturaExportacionDetalleAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="49%" align="right"><a href="javascript:FncFacturaExportacionDetalleListar();">
                                                                      <input type="hidden" name="CmpFacturaExportacionDetalleAccion" id="CmpFacturaExportacionDetalleAccion" value="AccFacturaExportacionDetalleRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFacturaExportacionDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                                                                    <td width="1%"><div id="CapFacturaExportacionDetallesResultado"> </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2"><div id="CapFacturaExportacionDetalles" class="EstCapFacturaExportacionDetalles" > </div></td>
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
	

</script>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "integer");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
<?php
}elseif(!empty($InsFacturaExportacion->FexCierre)){
echo ERR_FEX_401;
}
?>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
