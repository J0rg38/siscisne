<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReclamoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReclamoFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReclamoDetalleFunciones.js" ></script>
</script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssReclamo.css');
</style>


<?php
$GET_Id = $_GET['Id'];

$Registro = false;

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

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	
	FncReclamoDetalleListar();
	
	FncReclamoFotoListar();
	

});

/*
Configuracion Formulario
*/

var ReclamoFotoEditar = 2;
var ReclamoFotoEliminar = 2;

var ReclamoDetalleEditar = 2;
var ReclamoDetalleEliminar =2;
</script>

<div class="EstCapMenu">

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsReclamo->GarId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsReclamo->GarId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
              	<?php
			if($PrivilegioEditar ){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsReclamo->GarId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
                        
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER  RECLAMO</span></td>
      </tr>
      <tr>
        <td colspan="2"><br />

          
<ul class="tabs">


 

	<li><a href="#tab1">Reclamo</a></li>
   
 
</ul>
	
<div class="tab_container">

    





<div id="tab1" class="tab_content">
    
 
 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea" >
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
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsReclamo->GarId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Reclamo:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsReclamo->GarFechaEmision; ?>" size="15" maxlength="10" readonly="readonly" /></td>
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
                                      <td>&nbsp;</td>
                                      <td><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre"  tabindex="2" value="<?php echo $InsReclamo->PrvNombre;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
</table></td>
                                  <td align="left" valign="top">Tipo Doc.:
                                    <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsReclamo->PrvId;?>" size="3" /></td>
                                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" disabled="disabled">
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
                                      <td><a href="javascript:FncClienteNuevo();"></a></td>
                                      <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" tabindex="4" value="<?php echo $InsReclamo->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly"   /></td>
                                      <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"></a></td>
                                      <td></td>
                                      <td><div id="CapClienteBuscar"></div></td>
                                    </tr>
                                  </table></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Cliente:</td>
                                  <td align="left" valign="top"><input name="CmpCliente" type="text" class="EstFormularioCaja" id="CmpCliente" tabindex="5" value="<?php echo $InsReclamo->RecCliente;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Sucursal:</td>
                                  <td align="left" valign="top"><input name="CmpSucursal" type="text" class="EstFormularioCaja" id="CmpSucursal" tabindex="5" value="<?php echo $InsReclamo->RecSucursal;?>" size="30" maxlength="45" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Pais:</td>
                                  <td align="left" valign="top"><input name="CmpPais" type="text" class="EstFormularioCaja" id="CmpPais" tabindex="5" value="<?php echo $InsReclamo->RecPais;?>" size="30" maxlength="45" readonly="readonly"  /></td>
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
                                  <td align="left" valign="top"><input name="CmpRespuestaFecha" type="text" class="EstFormularioCajaFecha" id="CmpRespuestaFecha" value="<?php  echo $InsReclamo->RecRespuestaFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                                  <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion" tabindex="7"><?php echo stripslashes($InsReclamo->RecObservacion);?></textarea></td>
                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                  <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionImpresa" tabindex="8"><?php echo stripslashes($InsReclamo->RecObservacionImpresa);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Estado:</td>
                                  <td align="left" valign="top"><?php
			switch($InsReclamo->GarEstado){
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
				
			
			}
			?>
                                    <select disabled="disabled" tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                                      <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                                      <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                                      <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                                      <option <?php echo $OpcEstado7;?> value="7">C/ Transaccion</option>
                                      <option <?php echo $OpcEstado8;?> value="8">Pagado</option>
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
                                  <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="hidden" id="CmpPorcentajeImpuestoVenta" value="<?php echo $InsReclamo->GarPorcentajeImpuestoVenta;?>" size="3" /></td>
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
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="9"><span class="EstFormularioSubTitulo">REPUESTOS</span></td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea" >
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
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="9"><span class="EstFormularioSubTitulo">FOTOS</span></td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td width="38%" align="left" valign="top"><div class="EstFormularioArea">
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
                                  <td colspan="2"><script type="text/javascript">
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
                            <td width="62%" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                           
                            <td colspan="2" align="left" valign="top"></td>
                          </tr>
                        </table>
                        
                        
       
    
    </div>
    
    
      
     <div id="tab2" class="tab_content"></div>
 
	<div id="tab<?php echo $c;?>" class="tab_content">
		 <div class="EstFormularioArea"></div>
        
        
	</div>
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



<?php
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
