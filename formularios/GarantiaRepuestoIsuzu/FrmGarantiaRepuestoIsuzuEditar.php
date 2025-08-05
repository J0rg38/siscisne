<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaRepuestoIsuzuFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaRepuestoIsuzuManoObraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaRepuestoIsuzuDetalleFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssGarantiaRepuestoIsuzu.css');
</style>


<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjGarantiaRepuestoIsuzu.php');

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
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzu.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzuDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzuManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzuLlamada.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

$InsGarantiaRepuestoIsuzu = new ClsGarantiaRepuestoIsuzu();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCuenta = new ClsCuenta();

if (!isset($_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador])){	
	$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]);
}

if (!isset($_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador])){	
	$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]);
}

if (!isset($_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador])){	
	$_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccGarantiaRepuestoIsuzuEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];


$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsGarantiaRepuestoIsuzu->MonId);
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
	
	FncGarantiaRepuestoIsuzuManoObraListar();
	
	FncGarantiaRepuestoIsuzuDetalleListar();

});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";

var GarantiaRepuestoIsuzuManoObraEditar = 1;
var GarantiaRepuestoIsuzuManoObraEliminar = 1;

var GarantiaRepuestoIsuzuDetalleEditar = 1;
var GarantiaRepuestoIsuzuDetalleEliminar = 1;
</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR FORMULARIO DE RECLAMACION ISUZU</span></td>
      </tr>
      <tr>
        <td colspan="2">

              


     
<ul class="tabs">

	<li><a href="#tab1">Formulario de Reclamacion</a></li>
	<li><a href="#tab2">Fotos</a></li>

</ul>
	
<div class="tab_container">





    
    
<div id="tab1" class="tab_content">
    
 
 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td colspan="2" align="left"><div class="EstFormularioArea" >
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del formulario de reclamacion
                                    <input type="hidden" name="Guardar" id="Guardar"   />
                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                  </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Codigo Interno:</td>
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsGarantiaRepuestoIsuzu->GriId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Emision:<br />
                                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsGarantiaRepuestoIsuzu->GriFechaEmision; ?>" size="15" maxlength="10" />                                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del Cliente</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Cliente: </td>
                                  <td colspan="3" align="left" valign="top"><table>
                                    <tr>
                                      <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsGarantiaRepuestoIsuzu->CliId;?>" size="3" />
                                        <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsGarantiaRepuestoIsuzu->EinId;?>" size="3" />
                                        <input name="CmpClienteNombre" type="hidden" id="CmpClienteNombre" value="<?php echo $InsGarantiaRepuestoIsuzu->CliNombre;?>" size="3" />
                                        <input name="CmpClienteApellidoPaterno" type="hidden" id="CmpClienteApellidoPaterno" value="<?php echo $InsGarantiaRepuestoIsuzu->CliApellidoPaterno;?>" size="3" />
                                        <input name="CmpClienteApellidoMaterno" type="hidden" id="CmpClienteApellidoMaterno" value="<?php echo $InsGarantiaRepuestoIsuzu->CliApellidoMaterno;?>" size="3" /></td>
                                      <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento"  >
                                        <option value="">Escoja una opcion</option>
                                        <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                                        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsGarantiaRepuestoIsuzu->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                                        <?php
	}
	?>
                                      </select></td>
                                      <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                      <td><input <?php if(!empty($InsGarantiaRepuestoIsuzu->CliId)){ echo 'readonly="readonly"';} ?>  tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsGarantiaRepuestoIsuzu->CliNumeroDocumento;?>"   /></td>
                                      <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                      <td><input <?php if(!empty($InsGarantiaRepuestoIsuzu->CliId)){ echo 'readonly="readonly"';} ?>   tabindex="2" class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsGarantiaRepuestoIsuzu->CliNombre;?> <?php echo $InsGarantiaRepuestoIsuzu->CliApellidoPaterno;?> <?php echo $InsGarantiaRepuestoIsuzu->CliApellidoMaterno;?>"  /></td>
                                      <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a> <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a></td>
                                      <td></td>
                                    </tr>
                                  </table></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Direccion:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsGarantiaRepuestoIsuzu->GriDireccion;?>"  /></td>
                                  <td align="left" valign="top">Ciudad:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteCiudad" type="text" id="CmpClienteCiudad" size="30" maxlength="45" value="<?php echo $InsGarantiaRepuestoIsuzu->GriCiudad;?>"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Telefono:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteTelefono" type="text" id="CmpClienteTelefono" size="30" maxlength="45" value="<?php echo $InsGarantiaRepuestoIsuzu->GriTelefono;?>"  /></td>
                                  <td align="left" valign="top">Celular:</td>
                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteCelular" type="text" id="CmpClienteCelular" size="30" maxlength="45" value="<?php echo $InsGarantiaRepuestoIsuzu->GriCelular;?>"  /></td>
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
                                    <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsGarantiaRepuestoIsuzu->EinId;?>" size="3" />
                                    <input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsGarantiaRepuestoIsuzu->CliId;?>" size="3" /></td>
                                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td><a href="javascript:FncVehiculoIngresoNuevo();"></a></td>
                                      <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsGarantiaRepuestoIsuzu->EinVIN;?>" size="20" maxlength="50" readonly="readonly" /></td>
                                      <td><a href="javascript:FncVehiculoIngresoBuscar('VIN');"></a></td>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr> </tr>
                                  </table></td>
                                  <td align="left" valign="top">Modelo:
                                    <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsGarantiaRepuestoIsuzu->VmoId;?>" size="3" /></td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpVehiculoIngresoModelo" cols="45" rows="2" class="EstFormularioCaja" id="CmpVehiculoIngresoModelo"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriModelo);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Fecha de Entrega:</td>
                                  <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaEntrega" type="text" id="CmpFechaEntrega" value="<?php  echo $InsGarantiaRepuestoIsuzu->GriFechaEntrega; ?>" size="15" maxlength="10" /></td>
                                  <td align="left" valign="top">Kilometraje:</td>
                                  <td align="left" valign="top"><input  name="CmpKilometraje" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpKilometraje" value="<?php echo $InsGarantiaRepuestoIsuzu->FinKilometraje;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Placa:</td>
                                  <td align="left" valign="top"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsGarantiaRepuestoIsuzu->EinPlaca;?>" size="30" maxlength="50" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Reclamacion</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Orden de Trabajo:
                                    <input name="CmpFichaIngresoId" type="hidden" id="CmpFichaIngresoId" value="<?php echo $InsGarantiaRepuestoIsuzu->FinId;?>" size="3" /></td>
                                  <td align="left" valign="top"><input  name="CmpFichaIngresoId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId" value="<?php echo $InsGarantiaRepuestoIsuzu->FinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Ingreso:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFichaIngresoFecha" type="text" class="EstFormularioCajaFecha" id="CmpFichaIngresoFecha" value="<?php  echo $InsGarantiaRepuestoIsuzu->GriFichaIngresoFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Fecha de Salida:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFichaIngresoFechaSalida" type="text" class="EstFormularioCajaFecha" id="CmpFichaIngresoFechaSalida" value="<?php  echo $InsGarantiaRepuestoIsuzu->GriFichaIngresoFechaSalida; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Resumen de Costos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Repuestos:</td>
                                  <td align="left" valign="top"><input name="CmpRepuestos" type="text" class="EstFormularioCajaDeshabilitada" id="CmpRepuestos" value="<?php echo number_format($InsGarantiaRepuestoIsuzu->GriRepuestos,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">Mano de Obra</td>
                                  <td align="left" valign="top"><input name="CmpManoObra" type="text" class="EstFormularioCajaDeshabilitada" id="CmpManoObra" value="<?php echo number_format($InsGarantiaRepuestoIsuzu->GriManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Materiales</td>
                                  <td align="left" valign="top"><input name="CmpMateriales" type="text" class="EstFormularioCajaDeshabilitada" id="CmpMateriales" value="<?php echo number_format($InsGarantiaRepuestoIsuzu->GriMateriales,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">Tercerizacion:</td>
                                  <td align="left" valign="top"><input name="CmpTercerizacion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpTercerizacion" value="<?php echo number_format($InsGarantiaRepuestoIsuzu->GriTercerizacion,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Informe Tecnico</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Queja o S&iacute;ntomas reportados:</td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpSintomas" cols="45" rows="2" class="EstFormularioCaja" id="CmpSintomas"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriSintomas);?></textarea></td>
                                  <td align="left" valign="top">Historial de servicio</td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpHistorialServicio" cols="45" rows="2" class="EstFormularioCaja" id="CmpHistorialServicio"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriHistorialServicio);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Diagn&oacute;stico del Concesionario</td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpDiagnostico" cols="45" rows="2" class="EstFormularioCaja" id="CmpDiagnostico"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriDiagnostico);?></textarea></td>
                                  <td align="left" valign="top">Causa de la falla</td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpCausaFalla" cols="45" rows="2" class="EstFormularioCaja" id="CmpCausaFalla"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriCausaFalla);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Detalle de la reparaci&oacute;n</td>
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpDetalleReparacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpDetalleReparacion"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriDetalleReparacion);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
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
                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriObservacion);?></textarea></td>
                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                  <td align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsGarantiaRepuestoIsuzu->GriObservacionImpresa);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Estado:</td>
                                  <td align="left" valign="top"><?php
			switch($InsGarantiaRepuestoIsuzu->GriEstado){
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
                                  <td align="left" valign="top"><input name="CmpMonedaId" type="hidden" id="CmpMonedaId" value="<?php echo $InsGarantiaRepuestoIsuzu->MonId;?>" size="3" />
                                    <input name="CmTipoCambio" type="hidden" id="CmTipoCambio" value="<?php echo $InsGarantiaRepuestoIsuzu->GriTipoCambio;?>" size="3" />
                                    <input name="CmpPorcentajeImpuestoVenta" type="hidden" id="CmpPorcentajeImpuestoVenta" value="<?php echo $InsGarantiaRepuestoIsuzu->GriPorcentajeImpuestoVenta;?>" size="3" />
                                    <input name="CmpFichaAccionId" type="hidden" id="CmpFichaAccionId" value="<?php echo $InsGarantiaRepuestoIsuzu->FccId;?>" size="3" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                              
                            </div></td>
                </tr>
                          <tr>
                            <td width="36%" align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="5"><span class="EstFormularioSubTitulo">OPERACIONES</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                                    <input type="hidden" name="CmpGarantiaRepuestoIsuzuManoObraItem" id="CmpGarantiaRepuestoIsuzuManoObraItem" value="" />
                                    <input type="hidden" name="CmpGarantiaRepuestoIsuzuManoObraId"  class="EstFormularioCaja" id="CmpGarantiaRepuestoIsuzuManoObraId" value=""  />
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpGarantiaRepuestoIsuzuManoObraAccion" id="CmpGarantiaRepuestoIsuzuManoObraAccion" value="AccGarantiaRepuestoIsuzuManoObraRegistrar.php" />
                                  </span></td>
                                  <td>Numero:</td>
                                  <td>Tiempo: </td>
                                  <td><div id="CapGarantiaRepuestoIsuzuManoObraBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncGarantiaRepuestoIsuzuManoObraNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="CmpGarantiaRepuestoIsuzuManoObraNumero" type="text" class="EstFormularioCaja" id="CmpGarantiaRepuestoIsuzuManoObraNumero" size="20" maxlength="20" /></td>
                                  <td><input name="CmpGarantiaRepuestoIsuzuManoObraTiempo" type="text" class="EstFormularioCaja EstFormularioSoloNumero" id="CmpGarantiaRepuestoIsuzuManoObraTiempo" size="7" maxlength="10" /></td>
                                  <td><a href="javascript:FncGarantiaRepuestoIsuzuManoObraGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td width="64%" align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="7"><span class="EstFormularioSubTitulo">REPUESTOS</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                                    <input type="hidden" name="CmpGarantiaRepuestoIsuzuDetalleItem" id="CmpGarantiaRepuestoIsuzuDetalleItem" value="" />
                                    <input type="hidden" name="CmpGarantiaRepuestoIsuzuDetalleId"  class="EstFormularioCaja" id="CmpGarantiaRepuestoIsuzuDetalleId" value=""  />
                                    
                                    <input type="hidden" name="CmpProductoId" id="CmpProductoId" value="" />
                                    <input type="hidden" name="CmpUnidadMedidaId" id="CmpUnidadMedidaId" value="" />
                                    
                                    
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpGarantiaRepuestoIsuzuDetalleAccion" id="CmpGarantiaRepuestoIsuzuDetalleAccion" value="AccGarantiaRepuestoIsuzuDetalleRegistrar.php" />
                                  </span></td>
                                  <td>Codigo:</td>
                                  <td>Descripcion: </td>
                                  <td>Cantidad:</td>
                                  <td>Costo:</td>
                                  <td><div id="CapGarantiaRepuestoIsuzuDetalleBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncGarantiaRepuestoIsuzuDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="CmpProductoCodigoOriginal" type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                                  <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="45" maxlength="500" /></td>
                                  <td><input name="CmpGarantiaRepuestoIsuzuDetalleCantidad" type="text" class="EstFormularioCaja" id="CmpGarantiaRepuestoIsuzuDetalleCantidad" size="7" maxlength="10"  /></td>
                                  <td><input name="CmpGarantiaRepuestoIsuzuDetalleCostoTotal" type="text" class="EstFormularioCaja" id="CmpGarantiaRepuestoIsuzuDetalleCostoTotal" size="7" maxlength="10"  /></td>
                                  <td><a href="javascript:FncGarantiaRepuestoIsuzuDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                                  <td width="49%"><div class="EstFormularioAccion" id="CapGarantiaRepuestoIsuzuManoObraAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncGarantiaRepuestoIsuzuManoObraListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncGarantiaRepuestoIsuzuManoObraEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapGarantiaRepuestoIsuzuManoObraesResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapGarantiaRepuestoIsuzuManoObraes" class="EstCapGarantiaRepuestoIsuzuManoObraes" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="CapGarantiaRepuestoIsuzuDetalleAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncGarantiaRepuestoIsuzuDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncGarantiaRepuestoIsuzuDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapGarantiaRepuestoIsuzuDetallesResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapGarantiaRepuestoIsuzuDetalles" class="EstCapGarantiaRepuestoIsuzuDetalles" ></div></td>
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
    <td width="50%" valign="top">
    
    
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
              
if(!empty($_SESSION['SesGriFotoVIN'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesGriFotoVIN'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesGriFotoVIN'.$Identificador], '.'.$extension);  
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
              
if(!empty($_SESSION['SesGriFotoFrontal'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesGriFotoFrontal'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesGriFotoFrontal'.$Identificador], '.'.$extension);  
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
              
if(!empty($_SESSION['SesGriFotoCupon'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesGriFotoCupon'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesGriFotoCupon'.$Identificador], '.'.$extension);  
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
    <td width="50%" valign="top">
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
if (!isset($_SESSION['InsGarantiaRepuestoIsuzuFoto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsGarantiaRepuestoIsuzuFoto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

$RepSesionObjetos = $_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
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
//		inputField : "CmpGarantiaRepuestoIsuzuManoObraTransaccionFecha",  // id del campo de texto 
//		ifFormat   : "%d/%m/%Y",  //  
//		button     : "BtnGarantiaRepuestoIsuzuManoObraTransaccionFecha"// el id del botón que  
//	});
//	
//	
//	
//			Calendar.setup({ 
//		inputField : "CmpGarantiaRepuestoIsuzuManoObraFechaAprobacion",  // id del campo de texto 
//		ifFormat   : "%d/%m/%Y",  //  
//		button     : "BtnGarantiaRepuestoIsuzuManoObraFechaAprobacion"// el id del botón que  
//	});
//	
//	
//	
//			Calendar.setup({ 
//		inputField : "CmpGarantiaRepuestoIsuzuManoObraFechaPago",  // id del campo de texto 
//		ifFormat   : "%d/%m/%Y",  //  
//		button     : "BtnGarantiaRepuestoIsuzuManoObraFechaPago"// el id del botón que  
//	});
//
</script>

<?php
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

?>


