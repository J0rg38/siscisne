<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReclamoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReclamoFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReclamoDetalleFunciones.js" ></script>
</script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssReclamo.css');
</style>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjReclamo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamo.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamoFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsReclamo = new ClsReclamo();
$InsTipoDocumento = new ClsTipoDocumento();
$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsPersonal = new ClsPersonal();
$InsMoneda = new ClsMoneda();

if (!isset($_SESSION['InsReclamoFoto'.$Identificador])){	
	$_SESSION['InsReclamoFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsReclamoFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsReclamoFoto'.$Identificador]);
}

if (!isset($_SESSION['InsReclamoDetalle'.$Identificador])){	
	$_SESSION['InsReclamoDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsReclamoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsReclamoDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccReclamoEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){
	
	$("#CmpFecha").focus();
	
	FncReclamoDetalleListar();
	
	FncReclamoFotoListar();

});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";

var ReclamoFotoEditar = 1;
var ReclamoFotoEliminar = 1;

var ReclamoDetalleEditar = 1;
var ReclamoDetalleEliminar = 1;
</script>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();">

<div class="EstCapMenu">

           
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	



<?php
if($Registro){
?>    

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
        <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    <?php
    if($PrivilegioImprimir){
    ?>
        <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
  
<?php
}
?>            

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR RECLAMO</span></td>
      </tr>
      <tr>
        <td colspan="2">

              


     
<ul class="tabs">

	<li><a href="#tab1">Reclamo</a></li>

</ul>
	
<div class="tab_container">





    
    
<div id="tab1" class="tab_content">
    
 
 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td align="left"><div class="EstFormularioArea" >
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del Reclamo
                                    <input type="hidden" name="Guardar" id="Guardar"   />
                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                  </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Codigo Interno:</td>
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsReclamo->RecId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Reclamo:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><span id="sprytextfield7">
                                    <label>
                                      <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsReclamo->RecFechaEmision; ?>" size="15" maxlength="10" />
                                    </label>
                                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span> <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td align="left" valign="top">Codigo de Reclamo:</td>
                                  <td align="left" valign="top"><?php
			switch($InsReclamo->RecCodigoReclamo){
				case "F":
					$OpcCodigoReclamo1 = 'selected="selected"';
				break;
	
				case "S":
					$OpcCodigoReclamo2 = 'selected="selected"';
				break;
				
				case "D":
					$OpcCodigoReclamo3 = 'selected="selected"';
				break;
				
				case "E":
					$OpcCodigoReclamo4 = 'selected="selected"';
				break;

				
				
			
			}
			?>
                                    <select tabindex="9" class="EstFormularioCombo" id="CmpCodigoReclamo" name="CmpCodigoReclamo">
                                      <option <?php echo $OpcCodigoReclamo1;?> value="F">F - Numero de Parte Faltante</option>
                                      <option <?php echo $OpcCodigoReclamo2;?> value="S">S - Numero de Parte Sobrante</option>
                                      <option <?php echo $OpcCodigoReclamo3;?> value="D">D -  Numero de Parte Da&ntilde;ado</option>
                                      <option <?php echo $OpcCodigoReclamo4;?> value="E">E - Numero de Parte Equivocado</option>
                                    </select></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Proveedor: </td>
                                  <td align="left" valign="top"><table>
                                    <tr>
                                      <td><a href="javascript:FncNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                      <td><span id="sprytextfield2">
                                        <label>
                                          <input  tabindex="2" class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" size="45" maxlength="255" value="<?php echo $InsReclamo->PrvNombre;?>"  />
                                        </label>
                                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <a href="comunes/Proveedor/FrmBuscar.php?height=440&amp;width=850" class="thickbox" title="">[...]</a></td>
                                      <td><a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a></td>
                                      <td>&nbsp;</td>
                                    </tr>
</table></td>
                                  <td align="left" valign="top">Tipo Doc.:
                                    <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" value="<?php echo $InsReclamo->PrvId;?>" size="3" /></td>
                                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
                                    <option value="">Escoja una opcion</option>
                                    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                                    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsReclamo->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                                    <?php
			}
			?>
                                  </select></td>
                                  <td align="left" valign="top">Num. Doc.:</td>
                                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td><a href="javascript:FncNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                      <td><span id="sprytextfield5">
                                        <input tabindex="4" class="EstFormularioCaja" name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsReclamo->PrvNumeroDocumento;?>"   />
                                        <span class="textfieldRequiredMsg"> <img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldMinCharsMsg"> <img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe haber almenos 11 digitos"  /></span></span></td>
                                      <td><a href="javascript:FncBuscar('NumeroDocumento');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
                                      <td></td>
                                      <td><div id="CapBuscar"></div></td>
                                    </tr>
                                  </table></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Cliente:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpCliente" type="text" id="CmpCliente" size="45" maxlength="255" value="<?php echo $InsReclamo->RecCliente;?>"  /></td>
                                  <td align="left" valign="top">Sucursal:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpSucursal" type="text" id="CmpSucursal" size="30" maxlength="45" value="<?php echo $InsReclamo->RecSucursal;?>"  /></td>
                                  <td align="left" valign="top">Pais:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpPais" type="text" id="CmpPais" size="30" maxlength="45" value="<?php echo $InsReclamo->RecPais;?>"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Moneda:</td>
                                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
                                        <option value="">Escoja una opcion</option>
                                        <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                                        <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsReclamo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                                        <?php
			  }
			  ?>
                                      </select></td>
                                      <td><div id="CapMonedaBuscar"></div></td>
                                    </tr>
                                    <tr> </tr>
                                    <tr> </tr>
                                  </table></td>
                                  <td align="left" valign="top">Tipo de Cambio: <br />
                                    <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                                  <td align="left" valign="top"><table>
                                    <tr>
                                      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsReclamo->RecTipoCambio)){ echo "";}else{ echo $InsReclamo->RecTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                                      <td><a href="javascript:FncVentaDirectaEstablecerMoneda();"></a></td>
                                    </tr>
                                  </table></td>
                                  <td align="left" valign="top">Ref.:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCajaDeshabilitada" name="CmpAlmacenMovimientoEntradaId" type="text" id="CmpAlmacenMovimientoEntradaId" size="20" maxlength="20" value="<?php echo $InsReclamo->AmoId;?>"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Num.  Respuesta:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpRespuestaNumero" type="text" id="CmpRespuestaNumero" size="20" maxlength="45" value="<?php echo $InsReclamo->RecRespuestaNumero;?>"  /></td>
                                  <td align="left" valign="top">Fecha Respuesta:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><span id="sprytextfield">
                                    <label>
                                      <input class="EstFormularioCajaFecha" name="CmpRespuestaFecha" type="text" id="CmpRespuestaFecha" value="<?php  echo $InsReclamo->RecRespuestaFecha; ?>" size="15" maxlength="10" />
                                    </label>
                                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnRespuestaFecha" name="BtnRespuestaFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsReclamo->RecObservacion);?></textarea></td>
                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                  <td align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsReclamo->RecObservacionImpresa);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Estado:</td>
                                  <td align="left" valign="top"><?php
			switch($InsReclamo->RecEstado){
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

				case 8:
					$OpcEstado8 = 'selected="selected"';
				break;
				
				case 9:
					$OpcEstado9 = 'selected="selected"';
				break;
				
			
			}
			?>
            
<select tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
<option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
<option <?php echo $OpcEstado5;?> value="5">Enviado</option>
<option <?php echo $OpcEstado7;?> value="7">Recepcionado</option>
<option <?php echo $OpcEstado8;?> value="8">Atendido</option>
<option <?php echo $OpcEstado9;?> value="9">C/ Nota Credito</option>                                       
<option <?php echo $OpcEstado6;?> value="6">Anulado</option>
</select></td>
                                  <td align="left" valign="top">Responsable:</td>
                                  <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                                    <option value="">Escoja una opcion</option>
                                    <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                                    <option <?php echo ($DatPersonal->PerId==$InsReclamo->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                                    <?php
					}
					?>
                                  </select></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="hidden" id="CmpPorcentajeImpuestoVenta" value="<?php echo $InsReclamo->RecPorcentajeImpuestoVenta;?>" size="3" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                              
                            </div></td>
                </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="9"><span class="EstFormularioSubTitulo">REPUESTOS</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                                    <input type="hidden" name="CmpReclamoDetalleItem" id="CmpReclamoDetalleItem" value="" />
                                    <input type="hidden" name="CmpReclamoDetalleId"  class="EstFormularioCaja" id="CmpReclamoDetalleId" value=""  />
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpReclamoDetalleAccion" id="CmpReclamoDetalleAccion" value="AccReclamoDetalleRegistrar.php" />
                                  </span></td>
                                  <td>Num. Parte:</td>
                                  <td>Nombre:</td>
                                  <td>Cant. Recibida:</td>
                                  <td>Precio Un.:</td>
                                  <td align="center">Monto Rec.:</td>
                                  <td>Observacion</td>
                                  <td><div id="CapReclamoDetalleBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncReclamoDetalleNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="CmpReclamoDetalleCodigo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpReclamoDetalleCodigo" size="10" maxlength="20" readonly="readonly" /></td>
                                  <td><input name="CmpReclamoDetalleDescripcion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpReclamoDetalleDescripcion" size="45" maxlength="500" readonly="readonly" /></td>
                                  <td align="center"><input name="CmpReclamoDetalleCantidad" type="text" class="EstFormularioCaja" id="CmpReclamoDetalleCantidad" size="7" maxlength="10"  /></td>
                                  <td align="center"><input name="CmpReclamoDetallePrecioUnitario" type="text" class="EstFormularioCajaDeshabilitada" id="CmpReclamoDetallePrecioUnitario" size="7" maxlength="10" readonly="readonly"  /></td>
                                  <td align="center"><input name="CmpReclamoDetalleImporte" type="text" class="EstFormularioCajaDeshabilitada" id="CmpReclamoDetalleImporte" size="7" maxlength="10" readonly="readonly"  /></td>
                                  <td><input name="CmpReclamoDetalleObservacion" type="text" class="EstFormularioCaja" id="CmpReclamoDetalleObservacion" size="45" maxlength="500" /></td>
                                  <td><a href="javascript:FncReclamoDetalleGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="CapReclamoDetalleAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncReclamoDetalleListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncReclamoDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
                                  <td width="1%"><div id="CapReclamoDetallesResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapReclamoDetalles" class="EstCapReclamoDetalles" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="9"><span class="EstFormularioSubTitulo">FOTOS</span></td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left"><div class="EstFormularioArea">
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="13%"><div id="CapReclamoFotoAccion"></div>
                                    <a href="javascript:FncReclamoFotoListar();"></a></td>
                                  <td width="85%" align="right"><a href="javascript:FncReclamoFotoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a></td>
                                  <td width="1%" colspan="9">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="fileuploader">Escoger Archivos</div>
                                    <script type="text/javascript">
		$(document).ready(function(){

			
				$("#fileuploader").uploadFile({
					
				allowedTypes:"png,gif,jpg,jpeg",
				url:"formularios/Reclamo/acc/AccReclamoFotoRegistrar.php",
				formData: {"Identificador":"<?php echo $Identificador;?>"},
				multiple:true,
				autoSubmit:true,
				fileName:"Filedata",
				showStatusAfterSuccess:false,
				
				dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
				abortStr:"Abortar",
				cancelStr:"Cancelar",
				doneStr:"Hecho",
				multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
				extErrorStr:"Extension de archivo no permitido",
				sizeErrorStr:"Tama&ntilde;o no permitido",
				uploadErrorStr:"No se pudo subir el archivo",
				dragdropWidth: 400,
				
				onSuccess:function(files,data,xhr){
					FncReclamoFotoListar();
				}
	
	});
});
              
                              </script></td>
                                  <td colspan="9">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div class="EstCapReclamoFotos" id="CapReclamoFotos"></div></td>
                                  <td colspan="9">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioNota">* Fotos del repuesto</span></td>
                                  <td colspan="9">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left">&nbsp;</td>
                          </tr>
                        </table>
                        
                        
       
    
    </div>

 
 

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
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
</script>
	<script type="text/javascript">
Calendar.setup({ 
inputField : "CmpRespuestaFecha",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnRespuestaFecha"// el id del botón que  
});
</script>

<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>

<?php
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

?>


