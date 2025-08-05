<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsAlmacenMovimientoSalidaAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsVehiculoMovimientoSalidaAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGuiaRemisionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGuiaRemisionDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGuiaRemisionAlmacenMovimientoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Ubigeo");?>JsDepartamentoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Ubigeo");?>JsProvinciaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Ubigeo");?>JsDistritoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssGuiaRemision.css');
</style>

<?php

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_ori = $_GET['Ori'];
$GET_VcoId = $_GET['VcoId'];
$GET_AmoId = $_GET['AmoId'];
$GET_OvvId = $_GET['OvvId'];
$GET_FccId = $_GET['FccId'];
$GET_AmoId = $_GET['AmoId'];

$GET_TalId = $_GET['TalId'];
$GET_TasId = $_GET['TasId'];
$GET_VmvId = $_GET['VmvId'];
$GET_TptId = $_GET['TptId'];



include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjGuiaRemision.php');
include($InsProyecto->MtdFormulariosMsj("Cliente").'MsjCliente.php');
include($InsProyecto->MtdFormulariosMsj("Proveedor").'MsjProveedor.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionTalonario.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTrasladoAlmacen.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTrasladoAlmacenDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenSalidaDetalle.php');



require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsSunatCatalogo.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProductoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');


$InsGuiaRemision = new ClsGuiaRemision();
$InsGuiaRemisionTalonario = new ClsGuiaRemisionTalonario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsSunatCatalogo = new ClsSunatCatalogo();

if (!isset($_SESSION['InsGuiaRemisionDetalle'.$Identificador])){	
	$_SESSION['InsGuiaRemisionDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGuiaRemisionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGuiaRemisionDetalle'.$Identificador]);
}

if (!isset($_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador])){	
	$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccGuiaRemisionRegistrar.php');

$ResGuiaRemisionTalonario = $InsGuiaRemisionTalonario->MtdObtenerGuiaRemisionTalonarios(NULL,NULL,"GrtNumero","DESC",NULL,$InsGuiaRemision->SucId,true);
$ArrGuiaRemisionTalonarios = $ResGuiaRemisionTalonario['Datos'];


$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos(NULL,NULL,'ScaCodigo','ASC',NULL,"CATALOGO20");
$ArrSunatCatalogos = $ResSunatCatalogo['Datos'];



?>
<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
//var ArticuloFuncion = "FncGuiaRemisionDetalle";
//var ArticuloEnfoque = "CmpArticuloCantidad";

var Formulario = "FrmRegistrar";

var GuiaRemisionDetalleEditar = 1;
var GuiaRemisionDetalleEliminar = 1;

var PuntoPartidaDepartamentoHabilitado = 1;
var PuntoPartidaProvinciaHabilitado = 1;
var PuntoPartidaDistritoHabilitado = 1;

var PuntoLlegadaDepartamentoHabilitado = 1;
var PuntoLlegadaProvinciaHabilitado = 1;
var PuntoLlegadaDistritoHabilitado = 1;

var GuiaRemisionAlmacenMovimientoEliminar = 1;


$().ready(function() {
/*
Configuracion carga de datos y animacion
*/		

	$('#CmpClienteNombre').focus();
	
	FncGuiaRemisionDetalleListar();
	
	FncGuiaRemisionAlmacenMovimientoListar();
	
	<?php
	if(!empty($_SESSION['SisGrtId']) and empty($POST_id) or !empty($POST_do)){
	?>
		FncGenerarGuiaRemisionId('<?php echo $_SESSION['SisGrtId'];?>');
	<?php
	}
	?>
	
	<?php
	if($Edito or $Registro){
	?>
		if(confirm("Desea imprimir ahora?")){
			
			FncImprmir("<?php echo $InsGuiaRemision->GreId;?>","<?php echo $InsGuiaRemision->GrtId;?>");
			//FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>GuiaRemision/FrmGuiaRemisionImprimir.php?Id=<?php echo $InsGuiaRemision->GreId;?>&Ta=<?php echo $InsGuiaRemision->GrtId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);
			
		}
	<?php	
	}
	?>
	
	FncPuntoPartidaDepartamentosCargar();

	FncPuntoLlegadaDepartamentosCargar();
	
	
});

</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">


<div class="EstCapMenu">


  <?php
			if($Registro){
			?>
            
			<?php
			if($PrivilegioVistaPreliminar){
			?>
            <div class="EstSubMenuBoton"><a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>GuiaRemision/FrmGuiaRemisionImprimir.php?Id=<?php echo $InsGuiaRemision->GreId;?>&Ta=<?php echo $InsGuiaRemision->GrtId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     		 <div class="EstSubMenuBoton"><a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>GuiaRemision/FrmGuiaRemisionImprimir.php?Id=<?php echo $InsGuiaRemision->GreId;?>&Ta=<?php echo $InsGuiaRemision->GrtId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR GUIA DE REMISION</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
                   
        <table width="100%" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td colspan="2" valign="top"><div class="EstFormularioArea">
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td colspan="6"><span class="EstFormularioSubTitulo">Datos de la Guia de Remision - Remitente</span></td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="6" align="right" valign="top"><table border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td><input type="hidden" name="Guardar" id="Guardar"  value="" />
                          <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                        
                        <td><select onchange="FncGenerarGuiaRemisionId(this.value);" class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
                          <option value="">-</option>
                          <?php
				foreach($ArrGuiaRemisionTalonarios as $DatGuiaRemisionTalonario){
				?>
                          <option value="<?php echo $DatGuiaRemisionTalonario->GrtId;?>" 
<?php if(!empty($InsGuiaRemision->GrtId)){ if($InsGuiaRemision->GrtId==$DatGuiaRemisionTalonario->GrtId){ echo 'selected="selected"';}}elseif($_SESSION['SisGrtId']==$DatGuiaRemisionTalonario->GrtId){ 	echo 'selected="selected"';}?> 				 ><?php echo $DatGuiaRemisionTalonario->GrtNumero;?></option>
                          <?php
				}
				?>
                        </select></td>
                        <td>N&deg;.</td>
                        <td>
                          <input name="CmpId" type="text"  class="EstFormularioCaja" id="CmpId" value="<?php echo $InsGuiaRemision->GreId;?>" size="20" maxlength="20" />
                          
                        </td>
                        <td><a href="javascript:FncGenerarGuiaRemisionId(document.getElementById('CmpTalonario').value);"><img border="0" src="imagenes/recargar.jpg" alt="[Recargar]" title="Recargar" width="18" height="18" align="absmiddle"  /></a></td>
                        <td><div id="CapGuiaRemision"></div>                        
                          </td>
                        
                        </tr>
                    </table></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="6" align="left" valign="top">
                    
                    <fieldset title="">
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td colspan="3" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DE LA GUIA DE REMISION</span></td>
                        </tr>
                      <tr>
                        <td width="14%" align="left" valign="top">Fecha de Emision: <br />
                          <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                        <td width="36%" align="left" valign="top"><input class="EstFormularioCajaFecha"  name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php echo $InsGuiaRemision->GreFechaEmision;?>" size="15" maxlength="10" />
                          <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEmision" name="BtnFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td width="50%" align="left" valign="top">&nbsp;</td>
                        </tr>
                    </table></fieldset></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="49%" align="left" valign="top"><fieldset title="">
                      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL DESTINATARIO</span></td>
                          </tr>
                        <tr>
                          <td width="18%" align="left" valign="top">Señor (es):
                            <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsGuiaRemision->CliId;?>" /></td>
                          <td align="left" valign="top"><table>
                            <tr>
                              <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                              <td><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre" value="<?php echo $InsGuiaRemision->CliNombre;?> <?php echo $InsGuiaRemision->CliApellidoPaterno;?> <?php echo $InsGuiaRemision->CliApellidoMaterno;?>" size="40" maxlength="255"  
                       />
                                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                              <td><a id="EnlBuscarCliente" href="comunes/Destino/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                              <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                              </tr>
                            </table></td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">Ruc Nro.: </td>
                          <td width="82%" align="left" valign="top"><table>
                            <tr>
                              <td><a href="javascript:FncDestinoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                              <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" value="<?php echo $InsGuiaRemision->CliNumeroDocumento;?>" size="20" maxlength="50"  /></td>
                              <td><a href="javascript:FncDestinoBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                              <td><div id="CapDestinoBuscar"></div></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                      </fieldset></td>
                    <td colspan="5" align="left" valign="top"><fieldset title="">
                      <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL ESTABLECIMIENTO DEL TERCERO</span></td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">Señor (es):</td>
                          <td align="left" valign="top"><input name="CmpDestinatarioNombre" type="text" class="EstFormularioCaja" id="CmpDestinatarioNombre" value="<?php echo $InsGuiaRemision->GreDestinatarioNombre;?>" size="40" maxlength="255" /></td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">Doc. Ident.:</td>
                          <td align="left" valign="top"><input name="CmpDestinatarioNumeroDocumento1" type="text" class="EstFormularioCaja" id="CmpDestinatarioNumeroDocumento1" value="<?php echo $InsGuiaRemision->GreDestinatarioNumeroDocumento1;?>" size="20" maxlength="20" /></td>
                          </tr>
                        </table>
                      </fieldset></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="6" align="left" valign="top">
                      
                      
                      <fieldset title="">
                        
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          
                          <tr>
                            <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">UNIDAD DE TRANSPORTE Y CONDUCTOR</span></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">Razon Social:
                              <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" value="<?php echo $InsGuiaRemision->PrvId;?>" /></td>
                            <td align="left" valign="top">
                              
                              
                              
                              <table>
                                <tr>
                                  <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></a></td>
                                  <td>
                                    <input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsGuiaRemision->PrvNombre;?>" size="40" maxlength="255" />
                                    </td>
                                  <td> <a id="EnlBuscarProveedor" href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>  </td>
                                  <td> <a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar','','');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar','','');" href="javascript:void(0)"   title="">
                                    <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" />
                                    </a>
                                    
                                    </td>
                                  </tr>
                                </table>
                              
                              
                              
                              
                              
                              </td>
                            <td width="16%" align="left" valign="top">Chofer:</td>
                            <td width="34%" align="left" valign="top"><input name="CmpChofer" type="text" class="EstFormularioCaja" id="CmpChofer" value="<?php echo $InsGuiaRemision->GreChofer;?>" size="40" maxlength="255" /></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">RUC N°: </td>
                            <td align="left" valign="top"><table>
                              <tr>
                                <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento" value="<?php echo $InsGuiaRemision->PrvNumeroDocumento;?>" size="20" maxlength="20" /></td>
                                <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                <td><div id="CapProveedorBuscar"></div></td>
                                </tr>
                              </table></td>
                            <td align="left" valign="top">Num. Doc. Chofer:</td>
                            <td align="left" valign="top"><input name="CmpChoferNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpChoferNumeroDocumento" value="<?php echo $InsGuiaRemision->GreChoferNumeroDocumento;?>" size="20" maxlength="45" /></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">Nro. de Placa</td>
                            <td align="left" valign="top"><input name="CmpPlaca" type="text" class="EstFormularioCaja" id="CmpPlaca" value="<?php echo $InsGuiaRemision->GrePlaca;?>" size="20" maxlength="45" /></td>
                            </tr>
                          </table>
                        </fieldset>
                      
                      
                      </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="6" align="left" valign="top">
                      
                      
                      
                      <fieldset title="">
                        
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          
                          <tr>
                            <td width="15%" align="left" valign="top">Fecha de inicio de traslado: <br />
                              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                            <td colspan="3" align="left" valign="top"><input class="EstFormularioCajaFecha"  name="CmpFechaInicioTraslado" type="text" id="CmpFechaInicioTraslado" value="<?php  echo $InsGuiaRemision->GreFechaInicioTraslado;?>" size="15" maxlength="10" />                              <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicioTraslado" name="BtnFechaInicioTraslado" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">Motivo de Traslado:</td>
                            <td colspan="3" align="left" valign="top">
                            
                            <select class="EstFormularioCombo" name="GreMotivoTrasladoCodigo" id="GreMotivoTrasladoCodigo">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrSunatCatalogos as $DatSunatCatalogo){
			  ?>
              <option value="<?php echo $DatSunatCatalogo->ScaCodigo?>" <?php if($InsGuiaRemision->GreMotivoTrasladoCodigo==$DatSunatCatalogo->ScaCodigo){ echo 'selected="selected"';}?> ><?php echo $DatSunatCatalogo->ScaCodigo;?> - <?php echo $DatSunatCatalogo->ScaNombre?></option>
              <?php
			  }
			  ?>
            </select>
            
            
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">Punto de Partida:</td>
                            <td colspan="3" align="left" valign="top"><input name="CmpPuntoPartida" type="text" class="EstFormularioCaja" id="CmpPuntoPartida" value="<?php echo $InsGuiaRemision->GrePuntoPartida;?>" size="60" maxlength="255" /></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">Ubigeo:</td>
                            <td colspan="3" align="left" valign="top"><input name="CmpPuntoPartidaDepartamentoAux" type="hidden" class="EstFormularioCaja" id="CmpPuntoPartidaDepartamentoAux" value="<?php echo $InsGuiaRemision->GrePuntoPartidaDepartamento;?>" size="20" maxlength="10" readonly="readonly" />
                              <select class="EstFormularioCombo" id="CmpPuntoPartidaDepartamento" name="CmpPuntoPartidaDepartamento">
                              </select>
                              <input name="CmpPuntoPartidaProvinciaAux" type="hidden" class="EstFormularioCaja" id="CmpPuntoPartidaProvinciaAux" value="<?php echo $InsGuiaRemision->GrePuntoPartidaProvincia;?>" size="20" maxlength="10" readonly="readonly" />
                              <select class="EstFormularioCombo" id="CmpPuntoPartidaProvincia" name="CmpPuntoPartidaProvincia">
                              </select>
                              <input name="CmpPuntoPartidaDistritoAux" type="hidden" class="EstFormularioCaja" id="CmpPuntoPartidaDistritoAux" value="<?php echo $InsGuiaRemision->GrePuntoPartidaDistrito;?>" size="20" maxlength="10" readonly="readonly" />
                              <select class="EstFormularioCombo" id="CmpPuntoPartidaDistrito" name="CmpPuntoPartidaDistrito">
                              </select>
                              <input name="CmpPuntoPartidaCodigoUbigeo" type="text" class="EstFormularioCaja" id="CmpPuntoPartidaCodigoUbigeo" value="<?php echo $InsGuiaRemision->GrePuntoPartidaCodigoUbigeo;?>" size="10" maxlength="6" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">Punto de Llegada:</td>
                            <td colspan="3" align="left" valign="top"><input name="CmpPuntoLlegada" type="text" class="EstFormularioCaja" id="CmpPuntoLlegada" value="<?php echo $InsGuiaRemision->GrePuntoLlegada;?>" size="60" maxlength="255" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">Ubigeo:</td>
                            <td colspan="3" align="left" valign="top"><input name="CmpPuntoLlegadaDepartamentoAux" type="hidden" class="EstFormularioCaja" id="CmpPuntoLlegadaDepartamentoAux" value="<?php echo $InsGuiaRemision->GrePuntoLlegadaDepartamento;?>" size="20" maxlength="10" readonly="readonly" />
                              <select class="EstFormularioCombo" id="CmpPuntoLlegadaDepartamento" name="CmpPuntoLlegadaDepartamento">
                              </select>
                              <input name="CmpPuntoLlegadaProvinciaAux" type="hidden" class="EstFormularioCaja" id="CmpPuntoLlegadaProvinciaAux" value="<?php echo $InsGuiaRemision->GrePuntoLlegadaProvincia;?>" size="20" maxlength="10" readonly="readonly" />
                              <select class="EstFormularioCombo" id="CmpPuntoLlegadaProvincia" name="CmpPuntoLlegadaProvincia">
                              </select>
                              <input name="CmpPuntoLlegadaDistritoAux" type="hidden" class="EstFormularioCaja" id="CmpPuntoLlegadaDistritoAux" value="<?php echo $InsGuiaRemision->GrePuntoLlegadaDistrito;?>" size="20" maxlength="10" readonly="readonly" />
                              <select class="EstFormularioCombo" id="CmpPuntoLlegadaDistrito" name="CmpPuntoLlegadaDistrito">
                              </select>
                              <input name="CmpPuntoLlegadaCodigoUbigeo" type="text" class="EstFormularioCaja" id="CmpPuntoLlegadaCodigoUbigeo" value="<?php echo $InsGuiaRemision->GrePuntoLlegadaCodigoUbigeo;?>" size="10" maxlength="6" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">PesoTotal: <br />
                              <span class="EstFormularioSubEtiqueta">(KG)</span></td>
                            <td width="35%" align="left" valign="top"><input name="CmpPesoTotal" type="text" class="EstFormularioCaja" id="CmpPesoTotal" value="<?php echo number_format($InsGuiaRemision->GrePesoTotal,2);?>" size="20" maxlength="20" /></td>
                            <td width="16%" align="left" valign="top">Cant. Paquetes:</td>
                            <td width="34%" align="left" valign="top"><input name="CmpTotalPaquetes" type="text" class="EstFormularioCaja" id="CmpTotalPaquetes" value="<?php echo number_format($InsGuiaRemision->GreTotalPaquetes,2);?>" size="20" maxlength="20" /></td>
                          </tr>
                          </table>
                        </fieldset>
                      
                      </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="6" align="left" valign="top">
                      
                      
                      <fieldset title="">
                        
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          
                          <tr>
                            <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">OBSERVACIONES Y OTRAS REFERENCIAS</span></td>
                            </tr>
                          <tr>
                            <td height="63" align="left" valign="top">Orden Venta de Vehiculo:</td>
                            <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId" value="<?php echo $InsGuiaRemision->OvvId;?>" size="20" maxlength="45" readonly="readonly" /></td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="5" align="left" valign="top">&nbsp;</td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">Traslado de Productos:</td>
                            <td align="left" valign="top"><input name="CmpTrasladoProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpTrasladoProductoId" value="<?php echo $InsGuiaRemision->TptId;?>" size="20" maxlength="45" readonly="readonly" /></td>
                            <td align="left" valign="top">Traslado de Vehiculos:</td>
                            <td colspan="5" align="left" valign="top"><input name="CmpTrasladoVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpTrasladoVehiculoId" value="<?php echo $InsGuiaRemision->TveId;?>" size="20" maxlength="45" readonly="readonly" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">Observación Interna:</td>
                            <td align="left" valign="top"><textarea name="CmpObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsGuiaRemision->GreObservacion;?></textarea></td>
                            <td align="left" valign="top">Observación Impresa:</td>
                            <td colspan="5" align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsGuiaRemision->GreObservacionImpresa;?></textarea></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">Estado:</td>
                            <td align="left" valign="top"><?php
			switch($InsGuiaRemision->GreEstado){
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
                              <select class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                                <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                                <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                              </select></td>
                            <td align="left" valign="top"><input readonly="readonly" name="CmpGuiaRemisionDetalleId" type="hidden" class="EstFormularioCaja" id="CmpGuiaRemisionDetalleId" size="20" maxlength="10" /></td>
                            <td colspan="5" align="left" valign="top">&nbsp;</td>
                            </tr>
                          </table>
                        </fieldset>
                      
                      </td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
            </div></td>
          </tr>
          <tr>
            <td width="75%" valign="top">
            <div class="EstFormularioArea">
            
			
			
			
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><!--<input readonly="readonly" name="CmpGuiaRemisionDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpGuiaRemisionDetalleTiempoCreacion" size="20" maxlength="10" />
                          
                          <input readonly="readonly" name="CmpGuiaRemisionDetalleOrigenId" type="hidden" class="EstFormularioCaja" id="CmpGuiaRemisionDetalleOrigenId" size="20" maxlength="10" />
                          
                          <input readonly="readonly" name="CmpGuiaRemisionDetalleTipo" type="hidden" class="EstFormularioCaja" id="CmpGuiaRemisionDetalleTipo" size="20" maxlength="10" />-->                          </td>
                      <td colspan="8"><span class="EstFormularioSubTitulo">DETALLE</span>
                        <input type="hidden" name="CmpGuiaRemisionDetalleItem" id="CmpGuiaRemisionDetalleItem" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>C&oacute;digo:</td>
                      <td>Descripcion:
                      <input name="CmpTrasladoAlmacenId" type="hidden" class="EstFormularioCaja" id="CmpTrasladoAlmacenId" value="<?php echo $InsGuiaRemision->TalId;?>" size="20" maxlength="45" /></td>
                      <td>Cantidad:</td>
                      <td>Uni. Medida:</td>
                      <td>Peso Neto:</td>
                      <td>Peso Total:</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><a href="javascript:FncGuiaRemisionDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                      <td>
                      
                        <input tabindex="7" name="CmpGuiaRemisionDetalleCodigo"  type="text" class="EstFormularioCaja" id="CmpGuiaRemisionDetalleCodigo" size="10" maxlength="20"    />                        </td>
                      <td>
                      
                        <input name="CmpGuiaRemisionDetalleDescripcion" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionDetalleDescripcion" tabindex="8" size="45" /></td>
                      <td>
                      
                        <input tabindex="12" name="CmpGuiaRemisionDetalleCantidad" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionDetalleCantidad" size="10" maxlength="10"  /></td>
                      <td><input class="EstFormularioCaja" name="CmpGuiaRemisionDetalleUnidadMedida" type="text" id="CmpGuiaRemisionDetalleUnidadMedida" size="10" maxlength="50"   />                        </td>
                      <td><input class="EstFormularioCaja" name="CmpGuiaRemisionDetallePesoNeto" type="text" id="CmpGuiaRemisionDetallePesoNeto" size="15" maxlength="10"   /></td>
                      <td><input class="EstFormularioCaja" name="CmpGuiaRemisionDetallePesoTotal" type="text" id="CmpGuiaRemisionDetallePesoTotal" size="15" maxlength="10"   /></td>
                      <td><a href="javascript:FncGuiaRemisionDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                    </tr>
                  </table>
                
				
            </div>
            
            </td>
            <td width="25%" valign="top">
            
            
            <div id="CapFacturaDetalle" class="EstFormularioArea">
                                                          
                                                                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="3"><span class="EstFormularioSubTitulo">Fichas
                                                                      </span>
                                                                        <input type="hidden" name="CmpGuiaRemisionAlmacenMovimientoItem" id="CmpGuiaRemisionAlmacenMovimientoItem" />
                                                                        <input type="hidden" name="CmpGuiaRemisionAlmacenMovimientoId" id="CmpGuiaRemisionAlmacenMovimientoId" />
                                                                        <input type="hidden" name="CmpGuiaRemisionAlmacenMovimientoSubTipo" id="CmpGuiaRemisionAlmacenMovimientoSubTipo" />
                                                                        
                                                                        
                                                                        <input type="hidden" name="CmpAlmacenMovimientoId" id="CmpAlmacenMovimientoId" />
                                                                           <input type="hidden" name="CmpVehiculoMovimientoId" id="CmpVehiculoMovimientoId" />
                                                                        
                                                                      </td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="2">Ficha de Salida:</td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td><a href="javascript:FncGuiaRemisionAlmacenMovimientoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td>R:
                                                                        <input name="CmpAlmacenMovimiento" type="text" class="EstFormularioCaja" id="CmpAlmacenMovimiento" tabindex="11" size="10" maxlength="20"  /></td>
                                                                      <td>V:
                                                                        <input name="CmpVehiculoMovimiento" type="text" class="EstFormularioCaja" id="CmpVehiculoMovimiento" tabindex="11" size="010" maxlength="20"  /></td>
                                                                      <td><a href="javascript:FncGuiaRemisionAlmacenMovimientoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                    </tr>
                                                                  </table>
                                                            </div>
                                                            
                                                            
             </td>
            </tr>
          
          <tr>
            <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td colspan="2"><div class="EstFormularioAccion" id="CapGuiaRemisionDetalleAccion">Listo
                      para registrar elementos</div></td>
                    <td width="0%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="52%"><span class="EstFormularioSubTitulo"> Items
                      que componen la guia de remision</span> </td>
                    <td width="47%" align="right">
                    
                 
                 
                    
                    <a href="javascript:FncGuiaRemisionDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncGuiaRemisionDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>
                    
                    
                    
                    
                    
                      <input type="hidden" name="CmpGuiaRemisionDetalleAccion" id="CmpGuiaRemisionDetalleAccion" value="AccGuiaRemisionDetalleRegistrar.php" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapGuiaRemisionDetalles" class="EstCapGuiaRemisionDetalles" > </div></td>
                    <td><div id="CapGuiaRemisionDetallesResultado"> </div></td>
                  </tr>
                </table>
            </div></td>
            <td valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="1%">&nbsp;</td>
                                                                    <td width="48%"><div class="EstFormularioAccion" id="CapGuiaRemisionAlmacenMovimientoAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="50%" align="right"><a href="javascript:FncGuiaRemisionAlmacenMovimientoListar();">
                                                                      <input type="hidden" name="CmpGuiaRemisionAlmacenMovimientoAccion" id="CmpGuiaRemisionAlmacenMovimientoAccion" value="AccGuiaRemisionAlmacenMovimientoRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> 
                                                                    
                                                                    
                                                                   <!-- <a href="javascript:FncGuiaRemisionAlmacenMovimientoEliminarTodo();">
                                                                    
                                                                    
                                                                    <img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>-->
                                                                    
                                                                    
                                                                    </td>
                                                                    <td width="1%"><div id="CapGuiaRemisionAlmacenMovimientosResultado"> </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2"><div id="CapGuiaRemisionAlmacenMovimientos" class="EstCapGuiaRemisionAlmacenMovimientos" > </div></td>
                                                                    <td>&nbsp;</td>
                                                                  </tr>
                                                                </table>
                                                            </div></td>
            </tr>
         
          </table>        
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
	inputField : "CmpFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEmision"// el id del bot&oacute;n que  
	}); 
	
		Calendar.setup({ 
	inputField : "CmpFechaInicioTraslado",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicioTraslado"// el id del bot&oacute;n que  
	}); 
	
	
</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

