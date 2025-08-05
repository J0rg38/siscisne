<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaOperacionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaDetalleFunciones.js" ></script>
</script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssGarantia.css');
</style>


<?php
$GET_Id = $_GET['Id'];

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjGarantia.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');




require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantia.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaOperacion.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaLlamada.php');


require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

$InsGarantia = new ClsGarantia();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCuenta = new ClsCuenta();

if (!isset($_SESSION['InsGarantiaOperacion'.$Identificador])){	
	$_SESSION['InsGarantiaOperacion'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGarantiaOperacion'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaOperacion'.$Identificador]);
}

if (!isset($_SESSION['InsGarantiaDetalle'.$Identificador])){	
	$_SESSION['InsGarantiaDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGarantiaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaDetalle'.$Identificador]);
}

if (!isset($_SESSION['InsGarantiaFoto'.$Identificador])){	
	$_SESSION['InsGarantiaFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGarantiaFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaFoto'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccGarantiaEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];



$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsGarantia->MonId);
$ArrCuentas = $ResCuenta['Datos'];

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

FncGarantiaOperacionListar();
	
	FncGarantiaDetalleListar();


});

/*
Configuracion Formulario
*/

var GarantiaOperacionEditar = 2;
var GarantiaOperacionEliminar = 2;

var GarantiaDetalleEditar = 2;
var GarantiaDetalleEliminar =2;
</script>

<div class="EstCapMenu">

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsGarantia->GarId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsGarantia->GarId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
              	<?php
			if($PrivilegioEditar ){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsGarantia->GarId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
                        
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER  GARANTIA</span></td>
      </tr>
      <tr>
        <td colspan="2"><br />

          
<ul class="tabs">


 

	<li><a href="#tab1">Garantia</a></li>
    <li><a href="#tab2">Fotos</a></li>
   
 
</ul>
	
<div class="tab_container">

    





<div id="tab1" class="tab_content">
    
 
 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la garantia
                                    <input type="hidden" name="Guardar" id="Guardar"   />
                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                  </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Codigo Interno:</td>
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsGarantia->GarId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Garantia:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsGarantia->GarFechaEmision; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Fecha de Venta:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFechaVenta" type="text" class="EstFormularioCajaFecha" id="CmpFechaVenta" value="<?php  echo $InsGarantia->GarFechaVenta; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">Total Autorizada:</td>
                                  <td align="left" valign="top"><input name="CmpTarifaAutorizada" type="text" class="EstFormularioCaja" id="CmpTarifaAutorizada" value="<?php  echo number_format($InsGarantia->GarTarifaAutorizada,2);
									?>" size="10" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Cliente:</td>
                                  <td colspan="3" align="left" valign="top"><table>
                                    <tr>
                                      <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsGarantia->CliId;?>" size="3" /></td>
                                      <td><select class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" disabled="disabled">
                                        <option value="">Escoja una opcion</option>
                                        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                                        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsGarantia->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                                        <?php
			}
			?>
                                      </select></td>
                                      <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" tabindex="4" value="<?php echo $InsGarantia->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly"   /></td>
                                      <td><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsGarantia->CliNombre;?> <?php echo $InsGarantia->CliApellidoPaterno;?> <?php echo $InsGarantia->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
</table></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Direccion:</td>
                                  <td align="left" valign="top"><input name="CmpClienteDireccion" type="text" class="EstFormularioCaja" id="CmpClienteDireccion" tabindex="5" value="<?php echo $InsGarantia->GarDireccion;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Ciudad:</td>
                                  <td align="left" valign="top"><input name="CmpClienteCiudad" type="text" class="EstFormularioCaja" id="CmpClienteCiudad" tabindex="5" value="<?php echo $InsGarantia->GarCiudad;?>" size="30" maxlength="45" readonly="readonly"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Telefono:</td>
                                  <td align="left" valign="top"><input name="CmpClienteTelefono" type="text" class="EstFormularioCaja" id="CmpClienteTelefono" tabindex="5" value="<?php echo $InsGarantia->GarTelefono;?>" size="30" maxlength="45" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Celular:</td>
                                  <td align="left" valign="top"><input name="CmpClienteCelular" type="text" class="EstFormularioCaja" id="CmpClienteCelular" tabindex="5" value="<?php echo $InsGarantia->GarCelular;?>" size="30" maxlength="45" readonly="readonly"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del vehiculo</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">VIN:
                                    <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsGarantia->EinId;?>" size="3" />
                                    <input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsGarantia->CliId;?>" size="3" /></td>
                                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td><a href="javascript:FncVehiculoIngresoNuevo();"></a></td>
                                      <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsGarantia->EinVIN;?>" size="20" maxlength="50" readonly="readonly" /></td>
                                      <td><a href="javascript:FncVehiculoIngresoBuscar('VIN');"></a></td>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr> </tr>
                                  </table></td>
                                  <td align="left" valign="top">Marca:
                                    <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsGarantia->VmaId;?>" size="3" /></td>
                                  <td align="left" valign="top"><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" value="<?php echo $InsGarantia->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Modelo:
                                    <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsGarantia->VmoId;?>" size="3" /></td>
                                  <td align="left" valign="top"><textarea name="CmpVehiculoIngresoModelo" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpVehiculoIngresoModelo" tabindex="7"><?php echo stripslashes($InsGarantia->GarModelo);?></textarea></td>
                                  <td align="left" valign="top">Placa:</td>
                                  <td align="left" valign="top"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsGarantia->EinPlaca;?>" size="30" maxlength="50" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Orden de Trabajo</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Orden de Trabajo:
                                    <input name="CmpFichaIngresoId" type="hidden" id="CmpFichaIngresoId" value="<?php echo $InsGarantia->FinId;?>" size="3" /></td>
                                  <td align="left" valign="top"><input  name="CmpFichaIngresoId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId" value="<?php echo $InsGarantia->FinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Kilometraje:</td>
                                  <td align="left" valign="top"><input  name="CmpFichaIngresoVehiculoKilometraje" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoVehiculoKilometraje" value="<?php echo $InsGarantia->FinVehiculoKilometraje;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Causa que origino el problema:</td>
                                  <td align="left" valign="top">
                                  
                                  
                                  
                                  <div class="EstFormularioCajaObservacion"><?php echo stripslashes($InsGarantia->GarCausa);?></div>
                                  
</td>
                                  <td align="left" valign="top">Solucion al problema:</td>
                                  <td align="left" valign="top">
                                    
                                    
                                    <div class="EstFormularioCajaObservacion"><?php echo stripslashes($InsGarantia->GarSolucion);?></div>
                                    
                                    
</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                                  <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion" tabindex="7"><?php echo stripslashes($InsGarantia->GarObservacion);?></textarea></td>
                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                  <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionImpresa" tabindex="8"><?php echo stripslashes($InsGarantia->GarObservacionImpresa);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Estado:</td>
                                  <td align="left" valign="top"><?php
			switch($InsGarantia->GarEstado){
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
                                    <select disabled="disabled" tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                                      <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                                      <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                                      <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                                      <option <?php echo $OpcEstado7;?> value="7">C/ Transaccion</option>
                                      <option <?php echo $OpcEstado8;?> value="8">Pagado</option>
                                      <option <?php echo $OpcEstado9;?> value="9">Facturado</option>
                                    </select></td>
                                  <td align="left" valign="top"><input name="CmpMonedaId" type="hidden" id="CmpMonedaId" value="<?php echo $InsGarantia->MonId;?>" size="3" />
                                    <input name="CmTipoCambio" type="hidden" id="CmTipoCambio" value="<?php echo $InsGarantia->GarTipoCambio;?>" size="3" />
                                    <input name="CmpPorcentajeImpuestoVenta" type="hidden" id="CmpPorcentajeImpuestoVenta" value="<?php echo $InsGarantia->GarPorcentajeImpuestoVenta;?>" size="3" />
                                    <input name="CmpFichaAccionId" type="hidden" id="CmpFichaAccionId" value="<?php echo $InsGarantia->FccId;?>" size="3" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la transaccion</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Num. Transaccion:</td>
                                  <td align="left" valign="top"><input  name="CmpTransaccionNumero" type="text"  class="EstFormularioCaja" id="CmpTransaccionNumero" value="<?php echo $InsGarantia->GarTransaccionNumero;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Transaccion:<br />
                                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpTransaccionFecha" type="text" class="EstFormularioCajaFecha" id="CmpTransaccionFecha" value="<?php  echo $InsGarantia->GarTransaccionFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Fecha de Pago:<br />
                                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFechaPago" type="text" class="EstFormularioCajaFecha" id="CmpFechaPago" value="<?php  echo $InsGarantia->GarFechaPago; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">Cuenta Bancaria:</td>
                                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpCuenta" id="CmpCuenta">
                                    <option value="">Escoja una opcion</option>
                                    <?php
				foreach($ArrCuentas as $DatCuenta){
				?>
                                    <option <?php echo ($InsGarantia->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueId?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?> - <?php echo $DatCuenta->MonNombre; ?></option>
                                    <?php
				}
				?>
                                  </select></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Observaci&oacute;n Final:</td>
                                  <td align="left" valign="top"><textarea name="CmpObservacionFinal" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionFinal" tabindex="7"><?php echo stripslashes($InsGarantia->GarObservacionFinal);?></textarea></td>
                                  <td align="left" valign="top">Num. Comprobante CYC:<br />
                                    <span class="EstFormularioSubEtiqueta">(000-00000)</span></td>
                                  <td align="left" valign="top"><input  name="CmpNumeroComprobante" type="text"  class="EstFormularioCaja" id="CmpNumeroComprobante" value="<?php echo $InsGarantia->GarNumeroComprobante;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
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
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="CapGarantiaOperacionAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncGarantiaOperacionListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncGarantiaOperacionEliminarTodo();"></a></td>
                                  <td width="1%"><div id="CapGarantiaOperacionesResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapGarantiaOperaciones" class="EstCapGarantiaOperaciones" ></div></td>
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
                           
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="CapGarantiaDetalleAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncGarantiaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncGarantiaDetalleEliminarTodo();"></a></td>
                                  <td width="1%"><div id="CapGarantiaDetallesResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapGarantiaDetalles" class="EstCapGarantiaDetalles" ></div></td>
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
                        </table>
                        
                        
       
    
    </div>
    
    
      
    <div id="tab2" class="tab_content">
    <!--Content-->
    
    
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
    
    <tr>
    <td width="53%" valign="top">
    
    
    <div class="EstFormularioArea">
    
    <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto VIN</span></td>
                      </tr>
                    <tr>
                      <td>
                        
                        
                        
                        
                        
                        <div class="EstFormularioArea" >
                          <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                            <tr>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                              <td width="261" colspan="2" align="left" valign="top">
                                
                                
                                <?php              
              
if(!empty($_SESSION['SesGarFotoVIN'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesGarFotoVIN'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesGarFotoVIN'.$Identificador], '.'.$extension);  
?>
                                
                                Vista Previa:<br />
                                <a target="_blank" href="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>">
                                  <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" height="150" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
                                
                                
                                <?php	
}else{
?>
                                No hay FOTO
                                <?php	
}
?>
                                
                                
                                
                                
                                
                                
                                
                                </td>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td colspan="2" align="left" valign="top">
                                
                                <span class="EstFormularioNota">* Fotos del VIN del vehiculo </span>
                                
                                </td>
                              <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table>
                          </div>
                        
                        
                        <!--<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/FichaAccion/acc/AccFichaAccionSubirFotoVIN.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoVin" name="IfrFichaAccionSubirFotoVin" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>--></td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Frontal</span></td>
                    </tr>
                    <tr>
                      <td>
                        
                        
                        
                        <div class="EstFormularioArea" >
                          <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                            <tr>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                              <td width="261" colspan="2" align="left" valign="top">
                                
                                
                                
                                <?php              
              
if(!empty($_SESSION['SesGarFotoFrontal'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesGarFotoFrontal'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesGarFotoFrontal'.$Identificador], '.'.$extension);  
?>
                                
                                Vista Previa:<br />
                                
                                <a target="_blank" href="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>"> <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" height="150" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
                                <?php	
}else{
?>
                                No hay FOTO
                                <?php	
}
?>
                                
                                
                                
                                
                                </td>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td colspan="2" align="left" valign="top">
                                
                                <span class="EstFormularioNota">* Fotos de la Delantera del vehiculo </span>
                                
                                </td>
                              <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table>
                          </div>
                        
                        
                        
                      
                        </td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Cupon</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            <td width="275" colspan="2" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesGarFotoCupon'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesGarFotoCupon'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesGarFotoCupon'.$Identificador], '.'.$extension);  
?>
                              
                              Vista Previa:<br />
                              
                              <a target="_blank" href="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>"> <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" height="150" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
                              <?php	
}else{
?>
                              No hay FOTO
                              <?php	
}
?>
                              </td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    </table>
                    
                    
    </div>
    
    
    </td>
    <td width="47%" valign="top">
    <div class="EstFormularioArea">
    <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="261" colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Otras Fotos</span></td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapInformeTecnicoATS3Fotos" id="CapInformeTecnicoATS3<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos">

<?php

//session_start();
if (!isset($_SESSION['InsGarantiaFoto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsGarantiaFoto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

$RepSesionObjetos = $_SESSION['InsGarantiaFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];

?>

<table class="EstTablaListado" cellpadding="0" cellspacing="0" border="0">
   
    <tbody class="EstTablaListadoBody">
    <tr>
    <?php
    $c = 1;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
    ?>
    
    <td align="left" valign="top">
      
	<a target="_blank" href="subidos/ficha_accion_fotos/<?php echo $DatSesionObjeto->Parametro3;?>">
      <img src="subidos/ficha_accion_fotos/<?php echo $DatSesionObjeto->Parametro3;?>" alt="<?php echo $DatSesionObjeto->Parametro3;?>" title="<?php echo $DatSesionObjeto->Parametro3;?>" width="50" height="50" border="0" /></a>
   
    </td>
    
    <?php
	if($c%5==0){
	?>
    </tr><tr>
    <?php
	}
	?>
   
    <?php
            $c++;
  
       
    }
    ?> </tr>
    </tbody>
    </table>
    
    
                                  </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
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
