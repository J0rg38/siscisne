<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaOperacionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaDetalleFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssGarantia.css');
</style>


<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjGarantia.php');

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
	
	$("#CmpFecha").focus();
	
	FncGarantiaOperacionListar();
	
	FncGarantiaDetalleListar();

});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";

var GarantiaOperacionEditar = 1;
var GarantiaOperacionEliminar = 1;

var GarantiaDetalleEditar = 1;
var GarantiaDetalleEliminar = 1;
</script>





<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">

           
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR GARANTIA</span></td>
      </tr>
      <tr>
        <td colspan="2">

              


     
<ul class="tabs">

	<li><a href="#tab1">Garantia</a></li>
	<li><a href="#tab2">Fotos</a></li>

</ul>
	
<div class="tab_container">





    
    
<div id="tab1" class="tab_content">
    
 
 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td align="left"><div class="EstFormularioArea" >
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
                                  <td align="left" valign="top"><span id="sprytextfield7">
                                    <label>
                                      <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsGarantia->GarFechaEmision; ?>" size="15" maxlength="10" />
                                    </label>
                                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Fecha de Venta:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><span id="sprytextfield">
                                    <label>
                                      <input class="EstFormularioCajaFecha" name="CmpFechaVenta" type="text" id="CmpFechaVenta" value="<?php  echo $InsGarantia->GarFechaVenta; ?>" size="15" maxlength="10" />
                                    </label>
                                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaVenta" name="BtnFechaVenta" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td align="left" valign="top">Total Autorizada:</td>
                                  <td align="left" valign="top"><span id="sprytextfield4">
                                    <label>
                                      <input name="CmpTarifaAutorizada" type="text" class="EstFormularioCaja" id="CmpTarifaAutorizada" value="<?php  echo number_format($InsGarantia->GarTarifaAutorizada,2);
									?>" size="10" maxlength="10" />
                                    </label>
                                    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Cliente: </td>
                                  <td colspan="3" align="left" valign="top"><table>
                                    <tr>
                                      <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsGarantia->CliId;?>" size="3" /></td>
                                      <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                                        <option value="">Escoja una opcion</option>
                                        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                                        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsGarantia->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                                        <?php
			}
			?>
                                      </select></td>
                                      <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                      <td><input <?php echo (!empty($InsGarantia->CliId)?'readonly="readonly"':'');?> tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsGarantia->CliNumeroDocumento;?>"   /></td>
                                      <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                      <td><span id="sprytextfield2">
                                        <label>
                                          <input  <?php echo (!empty($InsGarantia->CliId)?'readonly="readonly"':'');?>  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsGarantia->CliNombre;?> <?php echo $InsGarantia->CliApellidoPaterno;?> <?php echo $InsGarantia->CliApellidoMaterno;?>"  />
                                        </label>
                                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                                      <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                                      <td>&nbsp;</td>
                                    </tr>
</table></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Direccion:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsGarantia->GarDireccion;?>"  /></td>
                                  <td align="left" valign="top">Ciudad:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteCiudad" type="text" id="CmpClienteCiudad" size="30" maxlength="45" value="<?php echo $InsGarantia->GarCiudad;?>"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Telefono:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteTelefono" type="text" id="CmpClienteTelefono" size="30" maxlength="45" value="<?php echo $InsGarantia->GarTelefono;?>"  /></td>
                                  <td align="left" valign="top">Celular:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteCelular" type="text" id="CmpClienteCelular" size="30" maxlength="45" value="<?php echo $InsGarantia->GarCelular;?>"  /></td>
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
                                      <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsGarantia->EinVIN;?>" size="20" maxlength="50" readonly="readonly" /></td>
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
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpVehiculoIngresoModelo" cols="45" rows="2" class="EstFormularioCaja" id="CmpVehiculoIngresoModelo"><?php echo stripslashes($InsGarantia->GarModelo);?></textarea></td>
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


<script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpCausa",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 300,
	height : 100
});

                            </script>
                            
                                  <textarea tabindex="7" name="CmpCausa" cols="45" rows="2" class="EstFormularioCaja" id="CmpCausa"><?php echo stripslashes($InsGarantia->GarCausa);?></textarea></td>
                                  <td align="left" valign="top">Solucion al problema:</td>
                                  <td align="left" valign="top">
                                    
                                    
                                    <script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpSolucion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 300,
	height : 100
});

                            </script>
                                  <textarea tabindex="7" name="CmpSolucion" cols="45" rows="2" class="EstFormularioCaja" id="CmpSolucion"><?php echo stripslashes($InsGarantia->GarSolucion);?></textarea></td>
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
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsGarantia->GarObservacion);?></textarea></td>
                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                  <td align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsGarantia->GarObservacionImpresa);?></textarea></td>
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
                                    <select tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
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
                                  <td align="left" valign="top"><input  name="CmpTransaccionNumero" type="text"  class="EstFormularioCaja" id="CmpTransaccionNumero" value="<?php echo $InsGarantia->GarTransaccionNumero;?>" size="20" maxlength="255" /></td>
                                  <td align="left" valign="top">Fecha de Transaccion:<br />
                                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><span id="sprytextfield3">

                                    <input class="EstFormularioCajaFecha" name="CmpTransaccionFecha" type="text" id="CmpTransaccionFecha" value="<?php  echo $InsGarantia->GarTransaccionFecha; ?>" size="15" maxlength="10" />

                                  <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span>
                                  
                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnTransaccionFecha" name="BtnTransaccionFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                                  
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Fecha de Pago:<br />
                                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><span id="sprytextfield6">
                                  <input class="EstFormularioCajaFecha" name="CmpFechaPago" type="text" id="CmpFechaPago" value="<?php  echo $InsGarantia->GarFechaPago; ?>" size="15" maxlength="10" />
                                  <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaPago" name="BtnFechaPago" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td align="left" valign="top">Cuenta Bancaria:</td>
                                  <td align="left" valign="top">
                                  
                                  <select class="EstFormularioCombo" name="CmpCuenta" id="CmpCuenta">
                    <option value="">Escoja una opcion</option>
                    <?php
				foreach($ArrCuentas as $DatCuenta){
				?>
                    <option <?php echo ($InsGarantia->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueId?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?> - <?php echo $DatCuenta->MonNombre; ?></option>
                    <?php
				}
				?>
                  </select>
                  
                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Observaci&oacute;n Final:</td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacionFinal" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionFinal"><?php echo stripslashes($InsGarantia->GarObservacionFinal);?></textarea></td>
                                  <td align="left" valign="top">Num. Comprobante CYC:<br />
                                  <span class="EstFormularioSubEtiqueta">(000-00000)</span></td>
                                  <td align="left" valign="top"><input  name="CmpNumeroComprobante" type="text"  class="EstFormularioCaja" id="CmpNumeroComprobante" value="<?php echo $InsGarantia->GarNumeroComprobante;?>" size="20" maxlength="20" /></td>
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
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="7"><span class="EstFormularioSubTitulo">OPERACIONES</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                                    <input type="hidden" name="CmpGarantiaOperacionItem" id="CmpGarantiaOperacionItem" value="" />
                                    <input type="hidden" name="CmpGarantiaOperacionId"  class="EstFormularioCaja" id="CmpGarantiaOperacionId" value=""  />
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpGarantiaOperacionAccion" id="CmpGarantiaOperacionAccion" value="AccGarantiaOperacionRegistrar.php" />
                                  </span></td>
                                  <td>Numero:</td>
                                  <td>Tiempo: </td>
                                  <td>Valor:</td>
                                  <td>Costo:</td>
                                  <td><div id="CapGarantiaOperacionBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncGarantiaOperacionNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="CmpGarantiaOperacionNumero" type="text" class="EstFormularioCaja" id="CmpGarantiaOperacionNumero" size="20" maxlength="20" /></td>
                                  <td><input name="CmpGarantiaOperacionTiempo" type="text" class="EstFormularioCaja EstFormularioSoloNumero" id="CmpGarantiaOperacionTiempo" size="7" maxlength="10" /></td>
                                  <td><input name="CmpGarantiaOperacionValor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpGarantiaOperacionValor" size="7" maxlength="10"  /></td>
                                  <td><input name="CmpGarantiaOperacionCosto" type="text" class="EstFormularioCaja" id="CmpGarantiaOperacionCosto" size="7" maxlength="10"  /></td>
                                  <td><a href="javascript:FncGarantiaOperacionGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                                  <td width="49%"><div class="EstFormularioAccion" id="CapGarantiaOperacionAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncGarantiaOperacionListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncGarantiaOperacionEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
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
                            <td align="left"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="8"><span class="EstFormularioSubTitulo">REPUESTOS</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                                    <input type="hidden" name="CmpGarantiaDetalleItem" id="CmpGarantiaDetalleItem" value="" />
                                    <input type="hidden" name="CmpGarantiaDetalleId"  class="EstFormularioCaja" id="CmpGarantiaDetalleId" value=""  />
                                    
                                    <input type="hidden" name="CmpProductoId" id="CmpProductoId" value="" />
                                    <input type="hidden" name="CmpUnidadMedidaId" id="CmpUnidadMedidaId" value="" />
                                    
                                    
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpGarantiaDetalleAccion" id="CmpGarantiaDetalleAccion" value="AccGarantiaDetalleRegistrar.php" />
                                  </span></td>
                                  <td>Codigo:</td>
                                  <td>&nbsp;</td>
                                  <td>Descripcion: </td>
                                  <td>Cantidad:</td>
                                  <td>Costo:</td>
                                  <td><div id="CapGarantiaDetalleBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncGarantiaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="CmpProductoCodigoOriginal" type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                                  <td>
                                  
                                  
                                  
                                   <a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" />
                                   </a>
                                   
                                   
                                   </td>
                                  <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="45" maxlength="500" /></td>
                                  <td><input name="CmpGarantiaDetalleCantidad" type="text" class="EstFormularioCaja" id="CmpGarantiaDetalleCantidad" size="7" maxlength="10"  /></td>
                                  <td><input name="CmpGarantiaDetalleCostoTotal" type="text" class="EstFormularioCaja" id="CmpGarantiaDetalleCostoTotal" size="7" maxlength="10"  /></td>
                                  <td><a href="javascript:FncGarantiaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                                  <td width="49%"><div class="EstFormularioAccion" id="CapGarantiaDetalleAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncGarantiaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncGarantiaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
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
                          <tr>
                            <td align="left">&nbsp;</td>
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

	
	
	
    
       


     
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});

	Calendar.setup({ 
		inputField : "CmpFechaVenta",  // id del campo de texto 
		ifFormat   : "%d/%m/%Y",  //  
		button     : "BtnFechaVenta"// el id del botón que  
	});

	Calendar.setup({ 
		inputField : "CmpTransaccionFecha",  // id del campo de texto 
		ifFormat   : "%d/%m/%Y",  //  
		button     : "BtnTransaccionFecha"// el id del botón que  
	});
	
	
		Calendar.setup({ 
		inputField : "CmpFechaPago",  // id del campo de texto 
		ifFormat   : "%d/%m/%Y",  //  
		button     : "BtnFechaPago"// el id del botón que  
	});








//
//		Calendar.setup({ 
//		inputField : "CmpGarantiaOperacionTransaccionFecha",  // id del campo de texto 
//		ifFormat   : "%d/%m/%Y",  //  
//		button     : "BtnGarantiaOperacionTransaccionFecha"// el id del botón que  
//	});
//	
//	
//	
//			Calendar.setup({ 
//		inputField : "CmpGarantiaOperacionFechaAprobacion",  // id del campo de texto 
//		ifFormat   : "%d/%m/%Y",  //  
//		button     : "BtnGarantiaOperacionFechaAprobacion"// el id del botón que  
//	});
//	
//	
//	
//			Calendar.setup({ 
//		inputField : "CmpGarantiaOperacionFechaPago",  // id del campo de texto 
//		ifFormat   : "%d/%m/%Y",  //  
//		button     : "BtnGarantiaOperacionFechaPago"// el id del botón que  
//	});
//		
	
	
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "currency");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>

<?php
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

?>


