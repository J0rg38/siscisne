<?php
// Verificar que las variables de sesión estén disponibles
if (!isset($_SESSION['SesionRol']) || !isset($_SESSION['SesionId'])) {
    die('Error: Sesión no válida. Por favor, inicie sesión nuevamente.');
}

if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>


<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletarv2.js" ></script>-->


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleAutocompletar.js" ></script>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoBuscarClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletarv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteNotaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFunciones.js" ></script>

<?php
//if($_GET['t']=="1"){
/*
if($_SESSION['MysqlDeb']){
	
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFuncionesv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoTotalFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFotoFunciones.js" ></script>

<?php	
}else{*/
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoTotalFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFotoFunciones.js" ></script>

<?php	
//}
?>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCotizacionProducto.css');
</style>

<?php
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_FinId = $_GET['FinId'] ?? '';
$GET_EinId = $_GET['EinId'] ?? '';
$GET_Origen = $_GET['Origen'] ?? '';

$GET_CprId = $_GET['CprId'] ?? '';
$GET_ProId = $_GET['ProId'] ?? '';

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCotizacionProducto.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsCotizacionProducto = new ClsCotizacionProducto();
$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();

$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();

$InsPersonal = new ClsPersonal();
$InsCliente = new ClsCliente();

$InsCotizacionProducto->UsuId = $_SESSION['SesionId'];	

if (!isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){	
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoDetalle'.$Identificador]);
}

if (!isset($_SESSION['InsCotizacionProductoPintado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPintado'.$Identificador]);
}

if (!isset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]);
}

if (!isset($_SESSION['InsCotizacionProductoCentrado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoCentrado'.$Identificador]);
}

if (!isset($_SESSION['InsCotizacionProductoTarea'.$Identificador])){	
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoTarea'.$Identificador]);
}

if (!isset($_SESSION['InsCotizacionProductoFoto'.$Identificador])){	
	$_SESSION['InsCotizacionProductoFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsCotizacionProductoFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoFoto'.$Identificador]);
}



include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCotizacionProductoRegistrar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL) {
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,($_SESSION['SesionSucursal'] ?? ''),1,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];


//MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oClienteTipo=NULL)

$ResSeguro = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,'CliId','Desc',1,NULL,NULL,NULL,"LTI-10016");
$ArrSeguros = $ResSeguro['Datos'];

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

	$('#CmpClienteNombre').focus();

	FncCotizacionProductoEstablecerMoneda();

	FncCotizacionProductoFotoListar('A');

/*	dhtmlx.confirm("�Es una cotizacion de mantenimiento?. Se recargara "+EmpresaMantenimientoPorcentajeManoObra+" %", function(result){
		if(result==false){
			$("#CmpPorcentajeManoObra").val("0");
		}else{
			//alert("asdf");
		}
	});*/
		
		FncCotizacionProductoDetalleListar();
	
});
/*
Configuracion Formulario
*/
var CotizacionProductoDetalleEditar = 1;
var CotizacionProductoDetalleEliminar = 1;

var CotizacionProductoPlanchadoEditar = 1;
var CotizacionProductoPlanchadoEliminar = 1;

var CotizacionProductoPintadoEditar = 1;
var CotizacionProductoPintadoEliminar = 1;

var CotizacionProductoCentradoEditar = 1;
var CotizacionProductoCentradoEliminar = 1;

var CotizacionProductoTareaEditar = 1;
var CotizacionProductoTareaEliminar = 1;


var CotizacionProductoFotoEditar = 1;
var CotizacionProductoFotoEliminar = 1;

var UnidadMedidaTipo = 2;
</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" >

<div class="EstCapMenu">


<?php
/*if($Registro){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsCotizacionProducto->CprId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsCotizacionProducto->CprId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            

<?php
}*/
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        COTIZACION DE REPUESTOS Y SERVICIOS</span>
<?php
//echo round(3.469,1);
?>
        </td>
      </tr>
      <tr>
        <td colspan="2">

          
	<ul class="tabs">
        <li><a href="#tab1">Cotizacion</a></li>
        <li><a href="#tab2">Documentacion</a></li>
	</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

		<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                
                
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Cotizacion </span><span class="EstFormularioSubTitulo">
                        <input type="hidden" name="Guardar" id="Guardar"   />
                        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                        </span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCotizacionProducto->CprId;?>" size="20" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo $InsCotizacionProducto->CprFecha;?>" size="15" maxlength="10" />                        <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Cotizador:</td>
                      <td><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                        <option <?php echo ($DatPersonal->PerId==$InsCotizacionProducto->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                        <?php
					}
					?>
                      </select></td>
                      <td align="left" valign="top">Hora:<br />
                        <span class="EstFormularioSubEtiqueta">(HH:mm)</span></td>
                      <td><input class="EstFormularioCajaHora" name="CmpHora" type="text" id="CmpHora" value="<?php echo $InsCotizacionProducto->CprHora;?>" size="15" maxlength="10" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Nivel de Interes:</td>
                      <td align="left" valign="top"><?php
					// Inicializar variables para evitar warnings
					$OpcNivelInteres1 = '';
					$OpcNivelInteres2 = '';
					$OpcNivelInteres3 = '';
					$OpcNivelInteres4 = '';
					
					switch($InsCotizacionProducto->CprNivelInteres){
						case 1:
							$OpcNivelInteres1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcNivelInteres2 = 'selected = "selected"';						
						break;
						
						case 3:
							$OpcNivelInteres3 = 'selected = "selected"';						
						break;
						
						case 4:
							$OpcNivelInteres4 = 'selected = "selected"';						
						break;
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpNivelInteres" id="CmpNivelInteres">
                          <option <?php echo $OpcNivelInteres1;?> value="1">Normal</option>
                          <option <?php echo $OpcNivelInteres2;?> value="2">Interesado</option>
                          <option <?php echo $OpcNivelInteres3;?> value="3">Muy Interesado</option>
                          <option <?php echo $OpcNivelInteres4;?> value="4">Venta Concluida</option>
                        </select></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4"><span class="EstFormularioSubTitulo">Datos del cliente</span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Cliente:</td>
                      <td colspan="3"><table>
                        
                        <tr>
                          <td><input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsCotizacionProducto->EinId;?>" size="3" />
                            <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsCotizacionProducto->CliId;?>" size="3" />
                            
                            
                            
                            <input name="CmpClienteNombre" type="hidden" id="CmpClienteNombre" value="<?php echo $InsCotizacionProducto->CliNombre;?>" size="3" />
                            <input name="CmpClienteApellidoPaterno" type="hidden" id="CmpClienteApellidoPaterno" value="<?php echo $InsCotizacionProducto->CliApellidoPaterno;?>" size="3" />
                            <input name="CmpClienteApellidoMaterno" type="hidden" id="CmpClienteApellidoMaterno" value="<?php echo $InsCotizacionProducto->CliApellidoMaterno;?>" size="3" />
                            
                            </td>
                          <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                            <option value="">Escoja una opcion</option>
                            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCotizacionProducto->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                            <?php
			}
			?>
                            </select></td>
                          <td><a href="javascript:FncClienteSimpleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  value="<?php echo $InsCotizacionProducto->CliNumeroDocumento;?>" size="20" maxlength="50" /></td>
                          <td><a href="javascript:FncClienteSimpleBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" value="<?php echo $InsCotizacionProducto->CliNombre;?> <?php echo $InsCotizacionProducto->CliApellidoPaterno;?> <?php echo $InsCotizacionProducto->CliApellidoMaterno;?>" size="45" maxlength="255"  />                        
                            
                            
                          <!-- <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a>-->
                            
                            </td>
                          <td>
                            
                            <a id="BtnClienteRegistrar" onclick="FncClienteSimpleCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> 
                            
                            
                            <a id="BtnClienteEditar" onclick="FncClienteSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>            
                            
                            
                             <a href="javascript:void(0);"  id="BtnCargarClienteBuscador" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                             
                             
                             
                         <!--   <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a>-->
                            
                            
                            
                            </td>
                          </tr>
                        </table></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Representante:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpRepresentante" type="text" id="CmpRepresentante" value="<?php echo $InsCotizacionProducto->CprRepresentante;?>" size="45" maxlength="100"  /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Direccion:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" value="<?php echo $InsCotizacionProducto->CprDireccion;?>" size="45" maxlength="255"  /></td>
                      <td align="left" valign="top">Celular:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpClienteCelular" type="text" id="CmpClienteCelular" value="<?php echo $InsCotizacionProducto->CprTelefono;?>" size="20" maxlength="255"  /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Email:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpClienteEmail" type="text" id="CmpClienteEmail" value="<?php echo $InsCotizacionProducto->CprEmail;?>" size="45" maxlength="255"  /></td>
                      <td align="left" valign="top">Tipo de Cliente:</td>
                      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                        <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsCotizacionProducto->LtiId==$DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
                        <?php
			}
			?>
                        </select></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Seguro:</td>
                      <td><select class="EstFormularioCombo" name="CmpSeguro" id="CmpSeguro">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrSeguros as $DatSeguro){
			?>
                        <option  <?php echo ($DatSeguro->CliId==$InsCotizacionProducto->CliIdSeguro)?'selected="selected"':"";?> value="<?php echo $DatSeguro->CliId?>"><?php echo $DatSeguro->CliNombre?> <?php echo $DatSeguro->CliApellidoPaterno?> <?php echo $DatSeguro->CliApellidoMaterno?></option>
                        <?php
			}
			?>
                        </select></td>
                      <td>Asegurado:</td>
                      <td><input name="CmpAsegurado" type="text" class="EstFormularioCaja" id="CmpAsegurado" value="<?php echo $InsCotizacionProducto->CprAsegurado;?>" size="30" maxlength="100" readonly="readonly"  /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Vehiculo </span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>VIN:
                        <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsCotizacionProducto->EinId;?>" size="3" />
                        <input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsCotizacionProducto->CliId;?>" size="3" /></td>
                      <td><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><a href="javascript:FncVehiculoIngresoSimpleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsCotizacionProducto->CprVIN;?>" size="20" maxlength="50" /></td>
                          <td><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                          </tr>
                        <tr> </tr>
                        </table></td>
                      <td align="left" valign="top">Marca:
                        <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsCotizacionProducto->VmaId;?>" size="3" /></td>
                      <td><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoMarca" value="<?php echo $InsCotizacionProducto->CprMarca;?>" size="30" maxlength="50" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Modelo:
                        <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsCotizacionProducto->VmoId;?>" size="3" /></td>
                      <td><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoModelo" value="<?php echo $InsCotizacionProducto->CprModelo;?>" size="30" maxlength="50" /></td>
                      <td align="left" valign="top">A&ntilde;o:</td>
                      <td><input  name="CmpVehiculoIngresoAnoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoAnoModelo" value="<?php echo $InsCotizacionProducto->CprAnoModelo;?>" size="10" maxlength="4" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Placa:</td>
                      <td><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsCotizacionProducto->CprPlaca;?>" size="30" maxlength="50" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4"><span class="EstFormularioSubTitulo">Facturacion</span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Moneda: <span class="EstFormularioSubTitulo">
                        <input type="hidden" name="CmpMonedaIdAnterior" id="CmpMonedaIdAnterior"  value="<?php echo $InsCotizacionProducto->MonIdAnterior;?>" />
                        </span></td>
                      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
                            <option value="">Escoja una opcion</option>
                            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCotizacionProducto->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                            <?php
			  }
			  ?>
                          </select></td>
                          <td><div id="CapMonedaBuscar"></div></td>
                          </tr>
                        </table></td>
                      <td align="left" valign="top">Tipo de Cambio: <br />
                        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                      <td align="left" valign="top"><table>
                        <tr>
                          <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCotizacionProductoDetalleListar();" value="<?php if (empty($InsCotizacionProducto->CprTipoCambio)){ echo "";}else{ echo $InsCotizacionProducto->CprTipoCambio; } ?>" size="10" maxlength="10" /></td>
                          <td><a href="javascript:FncCotizacionProductoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                          </tr>
                      </table></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Incluye Impuesto:</td>
                      <td align="left" valign="top"><?php
					switch($InsCotizacionProducto->CprIncluyeImpuesto){
						case 1:
							$OpcIncluyeImpuesto1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcIncluyeImpuesto2 = 'selected = "selected"';						
						break;

					}
					?>
                        <select  onchange="FncCotizacionProductoDetalleListar();" class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  >
                          <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                          <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                          </select></td>
                      <td align="left" valign="top">Impuesto:<br />
                        <span class="EstFormularioSubEtiqueta">(%)</span></td>
                      <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncCotizacionProductoDetalleListar();" value="<?php if(empty($InsCotizacionProducto->CprPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsCotizacionProducto->CprPorcentajeImpuestoVenta;}?>" size="10" maxlength="5" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Margen de Utilidad: <br />
                        <span class="EstFormularioSubEtiqueta">(%)</span></td>
                      <td align="left" valign="top"><input name="CmpClienteMargenUtilidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteMargenUtilidad" value="<?php echo number_format($InsCotizacionProducto->CprPorcentajeMargenUtilidad,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td align="left" valign="top">Otros Costos: <br />
                        <span class="EstFormularioSubEtiqueta">(%)</span></td>
                      <td align="left" valign="top"><input name="CmpPorcentajeOtroCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeOtroCosto" value="<?php echo number_format($InsCotizacionProducto->CprPorcentajeOtroCosto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Adicionales: <br />
                        <span class="EstFormularioSubEtiqueta">(%)</span></td>
                      <td align="left" valign="top"><input name="CmpPorcentajeManoObra" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeManoObra" value="<?php echo number_format($InsCotizacionProducto->CprPorcentajeManoObra,2);?>" size="10" maxlength="10" readonly="readonly" />                        <!--<input type="checkbox" name="CmpTieneMantenimiento" id="CmpTieneMantenimiento" value="1" <?php echo (($InsCotizacionProducto->CprPorcentajeManoObra>0)?'checked="checked"':'');?>  />-->
                        
                        
                        <!--<input type="button" name="BtnMantenimientoVerificar" id="BtnMantenimientoVerificar" value="Adicionales" class="EstFormularioBoton" />-->
                        
                        </td>
                      <td align="left" valign="top">Descuento: <br />
                        <span class="EstFormularioSubEtiqueta">(%)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpPorcentajeDescuento" type="text" id="CmpPorcentajeDescuento" value="<?php echo number_format($InsCotizacionProducto->CprPorcentajeDescuento,2);?>" size="10" maxlength="10" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Vigencia: <br />
                        <span class="EstFormularioSubEtiqueta"> (dias)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVigencia" type="text" id="CmpVigencia" value="<?php echo $InsCotizacionProducto->CprVigencia;?>" size="10" maxlength="4" /></td>
                      <td align="left" valign="top">Tiempo de Entrega: <br />
                        <span class="EstFormularioSubEtiqueta"> (dias)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpTiempoEntrega" type="text" id="CmpTiempoEntrega" value="<?php echo $InsCotizacionProducto->CprTiempoEntrega;?>" size="10" maxlength="4" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Mano de Obra:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpManoObra" type="text" id="CmpManoObra" value="<?php echo number_format($InsCotizacionProducto->CprManoObra,2);?>" size="10" maxlength="10" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion Interna:</td>
                      <td align="left" valign="top"><script type="text/javascript">


/*tinymce.init({
	selector: "textarea#CmpObservacion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic",
	width : 400,
	height : 80
});*/

                      </script>
                        <textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsCotizacionProducto->CprObservacion;?></textarea></td>
                      <td align="left" valign="top">Observacion Impresa:</td>
                      <td align="left" valign="top"><script type="text/javascript">


/*tinymce.init({
	selector: "textarea#CmpObservacion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic",
	width : 400,
	height : 80
});*/

                      </script>
                        <textarea name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsCotizacionProducto->CprObservacionImpresa;?></textarea></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsCotizacionProducto->CprEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
							$OpcEstado4 = 'selected = "selected"';						
						break;
						
						case 5:
							$OpcEstado5 = 'selected = "selected"';						
						break;
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                          <option <?php echo $OpcEstado1;?> value="1">Emitido</option>
                          <option <?php echo $OpcEstado2;?> value="2">Almacen [Enviado]</option>
                          <option <?php echo $OpcEstado3;?> value="3">Almacen [Revisando]</option>
                          <option <?php echo $OpcEstado4;?> value="4">Almacen [Por Facturar]</option>
                          <option <?php echo $OpcEstado5;?> value="5">Contabilidad [Facturado]</option>
                          <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                          </select>
                        <!--<select  class="EstFormularioCombo" name="CmpEstadoAux" id="CmpEstadoAux" disabled="disabled">
                        <option <?php echo $OpcEstado1;?> value="1">Emitido</option>
                        <option <?php echo $OpcEstado2;?> value="2">Almacen [Enviado]</option>
                        <option <?php echo $OpcEstado3;?> value="3">Almacen [Revisando]</option>
                        <option <?php echo $OpcEstado4;?> value="4">Almacen [Por Facturar]</option>
                        <option <?php echo $OpcEstado5;?> value="5">Contabilidad [Facturado]</option>
                      </select>
                      <input type="hidden" name="CmpEstado" id="CmpEstado" value="1" />--></td>
                      <td align="left" valign="top">Orden de Trabajo:</td>
                      <td align="left" valign="top"><table>
                        <tr>
                          <td><a href="javascript:FncFichaIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpFichaIngresoId" id="CmpFichaIngresoId" type="hidden"    value="<?php  echo $InsCotizacionProducto->FinId;?>" size="20" maxlength="20" />
                            <input name="CmpFichaIngreso" type="text" class="EstFormularioCaja" id="CmpFichaIngreso"  tabindex="3" value="<?php  echo $InsCotizacionProducto->FinId;?>" size="15" maxlength="25" <?php echo (!empty($InsCotizacionProducto->FinId)?'readonly="readonly"':'')?>  /></td>
                          <td><a href="javascript:FncFichaIngresoBuscar('Id');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td></td>
                          </tr>
                        </table></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales</span></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td rowspan="2">&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><!--<input <?php echo (($InsCotizacionProducto->CprVerificar==1)?'checked="checked"':'');?>  type="checkbox" name="CmpVerificar" id="CmpVerificar" value="1" />
                        Requiere ser verificado <span class="EstFormularioSubEtiqueta">(Seguros)</span><br />-->
                        <input <?php echo (($InsCotizacionProducto->CprFirmaDigital==1)?'checked="checked"':'');?>  type="checkbox" name="CmpFirmaDigital" id="CmpFirmaDigital" value="1" />
                        Imprimir Firma Digital del Cotizador <br />
                        <!--<input <?php echo (($InsCotizacionProducto->CprPlanchado=="Si")?'checked="checked"':'');?> value="Si"   type="checkbox" name="CmpPlanchado" id="CmpPlanchado" />
                        Incluir Planchado<br />
                        <input <?php echo (($InsCotizacionProducto->CprPintado=="Si")?'checked="checked"':'');?> value="Si"  type="checkbox" name="CmpPintado" id="CmpPintado" />
                        Incluir Pintado <br />
                        <input <?php echo (($InsCotizacionProducto->CprCentrado=="Si")?'checked="checked"':'');?> value="Si"  type="checkbox" name="CmpCentrado" id="CmpCentrado" />
                        Incluir Centrado <br />-->
                        <input <?php echo (($InsCotizacionProducto->CprNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                        Notificar via email (*)<br />
                        <input value="1" checked="checked"  type="checkbox" name="CmpRedondear" id="CmpRedondear" />
                        Calcular precios redondeados <br />
                       
                         <input style="visibility:hidden;" value="1" checked="checked"  type="checkbox" name="CmpIncrementar" id="CmpIncrementar" />
                      <!--  Venta por mostrador--></td>
                      <td rowspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="4" align="center" valign="top"><input type="radio" name="CmpListaPrecio" id="CmpListaPrecio1"  value="LOCAL" />
Lista de Precios Local (Se ignorara el margen ingresado)
  <input type="radio" name="CmpListaPrecio" id="CmpListaPrecio2" value="PROVEEDOR" checked="checked" />
Lista de Precios de Proveedor </td>
                    </tr>
                    </table>
                  
                  </div>
                
                </td>
            </tr>
            <tr>
              <td valign="top">
                <div class="EstFormularioArea">
                  
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="15"><span class="EstFormularioSubTitulo">PRODUCTOS</span><span class="EstFormularioSubTitulo">
                        
<input type="hidden" name="CmpCotizacionProductoDetalleId"    id="CmpCotizacionProductoDetalleId"    />
<input type="hidden" name="CmpCotizacionProductoDetalleDescuento"    id="CmpCotizacionProductoDetalleDescuento"    />
<input type="hidden" name="CmpCotizacionProductoDetalleDescuentoUnitario"    id="CmpCotizacionProductoDetalleDescuentoUnitario"    />
<input type="hidden" name="CmpCotizacionProductoDetalleAdicional"    id="CmpCotizacionProductoDetalleAdicional"    />
<input type="hidden" name="CmpCotizacionProductoDetalleAdicionalUnitario"    id="CmpCotizacionProductoDetalleAdicionalUnitario"    />

<input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />

<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />

<input type="hidden" name="CmpProductoValorVenta"    id="CmpProductoValorVenta"    />
<input type="hidden" name="CmpProductoPrecioBruto"    id="CmpProductoPrecioBruto"    />

<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpProductoPrecioAux"    id="CmpProductoPrecioAux"    />
                        
                        </span></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top"><input type="hidden" name="CmpCotizacionProductoDetalleAccion" id="CmpCotizacionProductoDetalleAccion" value="AccCotizacionProductoDetalleRegistrar.php" /></td>
                      <td valign="top">C&oacute;digo Orig.</td>
                      <td valign="top">&nbsp;</td>
                      <td valign="top">C&oacute;digo Alt.</td>
                      <td valign="top">&nbsp;</td>
                      <td valign="top">Nombre : </td>
                      <td valign="top">&nbsp;</td>
                      <td valign="top">&nbsp;</td>
                      <td valign="top">U.M. </td>
                      <td valign="top">Pedido:</td>
                      <td valign="top">Cantidad:</td>
                      <td valign="top">Precio:<br /></td>
                      <td valign="top"> Importe:</td>
                      <td valign="top"><div id="CapProductoBuscar"></div></td>
                      <td valign="top">&nbsp;</td>
                      </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td>
                        <a href="javascript:FncCotizacionProductoDetalleNuevo();">
                          <img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" />
                          </a>
                        
                        </td>
                      <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="8" maxlength="20" /></td>
                      <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                      <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="8" maxlength="20" /></td>
                      <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                      <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="35" /></td>
                      <td><a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a></td>
                      <td>
                        
                        <a id="BtnProductoConsulta" onclick="FncProductoCargarFormulario('Consulta');" href="javascript:void(0)"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" /> </a>
                        
                        </td>
                      <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                      </select></td>
                      <td>
                        
                        <select  class="EstFormularioCombo" name="CmpCotizacionProductoDetalleTipoPedido" id="CmpCotizacionProductoDetalleTipoPedido">
                          <option value="">-</option>
                          <option value="ALMACEN">ALMACEN</option>
                          <option value="NORMAL">NORMAL</option>
                          <option value="URGENTE">URGENTE +10%</option>
                          <option value="IMPORTACION">IMPORT.</option>
                          </select>
                        
                      </td>
                      <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="7" maxlength="10"  /></td>
                      <td><input name="CmpProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoPrecio" size="7" maxlength="10" readonly="readonly"  /></td>
                      <td><input name="CmpProductoImporte" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoImporte" size="7" maxlength="10"  /></td>
                      <td><a href="javascript:FncCotizacionProductoDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                      <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                    </tr><tr>
                      <td>&nbsp;</td>
                      <td align="left"></td>
                      <td colspan="13" align="left"><table>
                        <tr>
                          <td align="left" valign="top" class="EstFormulario">Costo:</td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpProductoCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoCosto" size="5" maxlength="5" readonly="readonly"  /></td>
                          <td align="left" valign="top" class="EstFormulario">Margen:<br />
                            <span class="EstFormularioSubEtiqueta">(%)</span></td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoDetallePorcentajeUtilidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoDetallePorcentajeUtilidad" size="5" maxlength="5" readonly="readonly"  /></td>
                          <td align="left" valign="top" class="EstFormulario">Otros Costos:<br />
                            <span class="EstFormularioSubEtiqueta">(%)</span></td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoDetallePorcentajeOtroCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoDetallePorcentajeOtroCosto" size="5" maxlength="5" readonly="readonly"  /></td>
                          <td align="left" valign="top" class="EstFormulario">Mano de Obra:<br />
                            <span class="EstFormularioSubEtiqueta">(%)</span></td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoDetallePorcentajeManoObra" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoDetallePorcentajeManoObra" size="5" maxlength="5" readonly="readonly"  /></td>
                          <td align="left" valign="top" class="EstFormulario">Adicional:<br />
                            <span class="EstFormularioSubEtiqueta">(%)</span></td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoDetallePorcentajeAdicional" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoDetallePorcentajeAdicional" size="5" maxlength="5" readonly="readonly"  /></td>
                          <td align="left" valign="top" class="EstFormulario">Descuento:<br />
                            <span class="EstFormularioSubEtiqueta">(%)</span></td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoDetallePorcentajeDescuento" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoDetallePorcentajeDescuento" size="5" maxlength="5"  /></td>
                          <td align="left" valign="top" class="EstFormulario">Pedido:<br />
                            <span class="EstFormularioSubEtiqueta">(%)</span></td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoDetallePorcentajePedido" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoDetallePorcentajePedido" size="5" maxlength="5" readonly="readonly"  /></td>
                          <td align="left" valign="top" class="EstFormulario">Valor:
                            
                            </td>
                          <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoDetalleValorVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoDetalleValorVenta" size="5" maxlength="5" readonly="readonly"  /></td>
                          </tr>
                      </table></td>
                      <td align="left">&nbsp;</td>
                      </tr>
                    
                    </table>
                  </div>              </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="50%" align="right">
                    
<a href="javascript:FncCotizacionProductoDetalleListar();">
<img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionProductoDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>

</td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapCotizacionProductoDetalles" class="EstCapCotizacionProductoDetalles" > </div></td>
                    <td><div id="CapCotizacionProductoDetallesResultado"> </div></td>
                  </tr>
                  </table>
                </div></td>
            </tr>
            <tr>
              <td valign="top">
              
              


<div class="EstFormularioArea">
                  
                 <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="6"><span class="EstFormularioSubTitulo">PLANCHADO  </span><span class="EstFormularioSubTitulo">
                          <input type="hidden" name="CmpCotizacionProductoPlanchadoItem" id="CmpCotizacionProductoPlanchadoItem" />
                       <input type="hidden" name="CmpCotizacionProductoPlanchadoId"  class="EstFormularioCaja" id="CmpCotizacionProductoPlanchadoId"  />
                          
                          

                            
                            
                          
                          </span></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="hidden" name="CmpCotizacionProductoPlanchadoAccion" id="CmpCotizacionProductoPlanchadoAccion" value="AccCotizacionProductoPlanchadoRegistrar.php" /></td>
                          <td>Nombre : </td>
                          <td> Importe:</td>
                          <td>Verificado:</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="javascript:FncCotizacionProductoPlanchadoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpCotizacionProductoPlanchadoDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPlanchadoDescripcion" size="60" /></td>
                          <td><input name="CmpCotizacionProductoPlanchadoImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPlanchadoImporte" size="10" maxlength="10"  /></td>
                          <td>
                          
                          <select  class="EstFormularioCombo" name="CmpCotizacionProductoPlanchadoEstado" id="CmpCotizacionProductoPlanchadoEstado">	
                          <option value="0">-</option>
                          <option value="1">Si</option>
                          <option value="2">No</option>
                          </select></td>
                          <td><a href="javascript:FncCotizacionProductoPlanchadoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                          <td>&nbsp;</td>
                        </tr>
                        </table>
                  </div>
                  
                  
              </td>
            </tr>
            <tr>
              <td valign="top">


<div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoPlanchadoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="50%" align="right">
                    
                    <a href="javascript:FncCotizacionProductoPlanchadoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionProductoPlanchadoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                    
                    </td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapCotizacionProductoPlanchados" class="EstCapCotizacionProductoPlanchados" > </div></td>
                    <td><div id="CapCotizacionProductoPlanchadosResultado"> </div></td>
                  </tr>
                  </table>
                </div>
                
                
              </td>
            </tr>
            <tr>
              <td valign="top">
              


<div class="EstFormularioArea">
                  
                 <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="6">
                          
                          <span class="EstFormularioSubTitulo">PINTADO</span>
                          
                          
                       
                          <input type="hidden" name="CmpCotizacionProductoPintadoItem" id="CmpCotizacionProductoPintadoItem" />
                       <input type="hidden" name="CmpCotizacionProductoPintadoId"  class="EstFormularioCaja" id="CmpCotizacionProductoPintadoId"  />
                          
                          

                            
                            
                         </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="hidden" name="CmpCotizacionProductoPintadoAccion" id="CmpCotizacionProductoPintadoAccion" value="AccCotizacionProductoPintadoRegistrar.php" /></td>
                          <td>Nombre : </td>
                          <td> Importe:</td>
                          <td>Verificado:</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="javascript:FncCotizacionProductoPintadoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpCotizacionProductoPintadoDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPintadoDescripcion" size="60" /></td>
                          <td><input name="CmpCotizacionProductoPintadoImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPintadoImporte" size="10" maxlength="10"  /></td>
                          <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoPintadoEstado" id="CmpCotizacionProductoPintadoEstado">
                            <option value="0">-</option>
                            <option value="1">Si</option>
                            <option value="2">No</option>
                          </select></td>
                          <td><a href="javascript:FncCotizacionProductoPintadoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                          <td>&nbsp;</td>
                        </tr>
                        </table>
                  </div>
                  

</td>
            </tr>
            <tr>
              <td valign="top">
              

<div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoPintadoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="50%" align="right">
                    
                    <a href="javascript:FncCotizacionProductoPintadoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionProductoPintadoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                    
                    </td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapCotizacionProductoPintados" class="EstCapCotizacionProductoPintados" > </div></td>
                    <td><div id="CapCotizacionProductoPintadosResultado"> </div></td>
                  </tr>
                  </table>
                </div>
                
              </td>
            </tr>
            <tr>
              <td valign="top">
              
              
              <div class="EstFormularioArea">
                  
                 <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="6">
                          

 <span class="EstFormularioSubTitulo">CENTRADO</span>
                          
                          
                          
                          
                          <input type="hidden" name="CmpCotizacionProductoCentradoItem" id="CmpCotizacionProductoCentradoItem" />
                       <input type="hidden" name="CmpCotizacionProductoCentradoId"  class="EstFormularioCaja" id="CmpCotizacionProductoCentradoId"  />
                          
                          

                            
                        </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="hidden" name="CmpCotizacionProductoCentradoAccion" id="CmpCotizacionProductoCentradoAccion" value="AccCotizacionProductoCentradoRegistrar.php" /></td>
                          <td>Nombre : </td>
                          <td> Importe:</td>
                          <td>Verificado:</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="javascript:FncCotizacionProductoCentradoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpCotizacionProductoCentradoDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoCentradoDescripcion" size="60" /></td>
                          <td><input name="CmpCotizacionProductoCentradoImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoCentradoImporte" size="10" maxlength="10"  /></td>
                          <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoCentradoEstado" id="CmpCotizacionProductoCentradoEstado">
                            <option value="0">-</option>
                            <option value="1">Si</option>
                            <option value="2">No</option>
                          </select></td>
                          <td><a href="javascript:FncCotizacionProductoCentradoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                          <td>&nbsp;</td>
                        </tr>
                        </table>
                  </div>
                  
                  
              </td>
            </tr>
            <tr>
              <td valign="top">
              
              
              <div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoCentradoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="50%" align="right">
                    
                    <a href="javascript:FncCotizacionProductoCentradoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionProductoCentradoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                    
                    </td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapCotizacionProductoCentrados" class="EstCapCotizacionProductoCentrados" > </div></td>
                    <td><div id="CapCotizacionProductoCentradosResultado"> </div></td>
                  </tr>
                  </table>
                </div>
                
                
              </td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea">
                  
                 <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="6">


 <span class="EstFormularioSubTitulo">TAREAS</span>
                          
                          
                         
                          <input type="hidden" name="CmpCotizacionProductoTareaItem" id="CmpCotizacionProductoTareaItem" />
                       <input type="hidden" name="CmpCotizacionProductoTareaId"  class="EstFormularioCaja" id="CmpCotizacionProductoTareaId"  />
                          
                          

                      </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="hidden" name="CmpCotizacionProductoTareaAccion" id="CmpCotizacionProductoTareaAccion" value="AccCotizacionProductoTareaRegistrar.php" /></td>
                          <td>Nombre : </td>
                          <td> Importe:</td>
                          <td>Verificado:</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="javascript:FncCotizacionProductoTareaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpCotizacionProductoTareaDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoTareaDescripcion" size="60" /></td>
                          <td><input name="CmpCotizacionProductoTareaImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoTareaImporte" size="10" maxlength="10"  /></td>
                          <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoTareaEstado" id="CmpCotizacionProductoTareaEstado">
                            <option value="0">-</option>
                            <option value="1">Si</option>
                            <option value="2">No</option>
                          </select></td>
                          <td><a href="javascript:FncCotizacionProductoTareaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                          <td>&nbsp;</td>
                        </tr>
                        </table>
                  </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoTareaAccion">Listo
                      para registrar elementos</div></td>
                    <td width="50%" align="right">
                    
                    <a href="javascript:FncCotizacionProductoTareaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionProductoTareaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                    
                    </td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapCotizacionProductoTareas" class="EstCapCotizacionProductoTareas" > </div></td>
                    <td><div id="CapCotizacionProductoTareasResultado"> </div></td>
                  </tr>
                  </table>
                </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="98%" colspan="2"><div id="CapCotizacionProductoTotals" class="EstCapCotizacionProductoTotals" > </div></td>
                    <td width="1%">&nbsp;</td>
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
		<td width="97%" valign="top">
        
                  <div class="EstFormularioArea">
                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Documentacion Adjunta</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center"></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de Seguro</span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4"><div class="EstFormularioArea" >
                      <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td width="4" align="left" valign="top">&nbsp;</td>
                          <td width="139" align="left" valign="top">&nbsp;</td>
                          <td width="136" align="right" valign="top">
                            
                            <a href="javascript:FncCotizacionProductoFotoListar('A');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                            
                            </td>
                          <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td colspan="2" align="left" valign="top">
                            <div id="fileuploaderA">Escoger Archivos</div>
                            
                            
                            
                            <script type="text/javascript">
		$(document).ready(function(){

				$("#fileuploaderA").uploadFile({
					
				allowedTypes:"png,gif,jpg,jpeg,pdf",
				url:"formularios/CotizacionProducto/acc/AccCotizacionProductoSubirFoto.php",
				formData: {"Identificador":"<?php echo $Identificador;?>","Tipo":"A"},
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
				sizeErrorStr:"Tama�o no permitido",
				uploadErrorStr:"No se pudo subir el archivo",
				
				dragdropWidth: 500,
				
				onSuccess:function(files,data,xhr){
					FncCotizacionProductoFotoListar("A");
				}
	
	});
});
              
            </script>
                            
                            
                            
                            
                            </td>
                          <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td colspan="2" align="left" valign="top"><div class="EstCapCotizacionProductoFotos" id="CapCotizacionProductoFotosA"></div></td>
                          <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td colspan="2" align="left" valign="top">
                            
                            <div id="CapCotizacionProductoFotosAccionA"></div>
                            </td>
                          <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center"></td>
                    <td>&nbsp;</td>
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
	
	
	
  


<!--  -->
  
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del bot�n que  
	});
</script>
<?php
}else{
	echo ERR_GEN_101;
}

if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}




?>
