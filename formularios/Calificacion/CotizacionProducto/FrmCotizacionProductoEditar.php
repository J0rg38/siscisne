<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFunciones.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCotizacionProducto.css');
</style>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

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


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsCotizacionProducto = new ClsCotizacionProducto();
$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();

$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();

$InsPersonal = new ClsPersonal();
$InsCliente = new ClsCliente();

$InsCotizacionProducto->UsuId = $_SESSION['SesionId'];	

if (isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){	
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoDetalle'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoPintado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPintado'.$Identificador]);
}


if (isset($_SESSION['InsCotizacionProductoCentrado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoCentrado'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoTarea'.$Identificador])){	
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoTarea'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoFoto'.$Identificador])){	
	$_SESSION['InsCotizacionProductoFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoFoto'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCotizacionProductoEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

$ResSeguro = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,'CliId','Desc',1,NULL,NULL,NULL,"LTI-10016");
$ArrSeguros = $ResSeguro['Datos'];
?>

<?php
if($InsCotizacionProducto->CprEstado==1){
?>

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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




<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();" >


<div class="EstCapMenu">

<?php
if($Edito){
?>

	<?php
  /*  if($PrivilegioVistaPreliminar){
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
    }*/
    ?>
            

<?php
}
?>    

<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        COTIZACION  </span></td>
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
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionProducto->CprTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionProducto->CprTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">
         
         <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="7"><span class="EstFormularioSubTitulo">Datos del Cliente 
                      
                    </span></td>
                    </tr> <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Cliente:</td>
                    <td><table>
               <tr>
                 <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td>
               <span id="sprytextfield5">
                 <label>
                   <input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" value="<?php echo $InsCotizacionProducto->CliNombre;?> <?php echo $InsCotizacionProducto->CliApellidoPaterno;?> <?php echo $InsCotizacionProducto->CliApellidoMaterno;?>" size="45" maxlength="255"  />
                   </label>
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""> [...]</a>
                 
                 
               </td>
               <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a>
               
               </td>
               
               </tr>
               </table></td>
                    <td align="left" valign="top">Tipo Doc.:
                      <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsCotizacionProducto->CliId;?>" size="3" /></td>
                    <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                 <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCotizacionProducto->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                 <?php
			}
			?>
               </select>
                      <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsCotizacionProducto->EinId;?>" size="3" /></td>
                    <td align="left" valign="top">Num. Doc:</td>
                    <td><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  value="<?php echo $InsCotizacionProducto->CliNumeroDocumento;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
                   <td></td>
                   <td><div id="CapClienteBuscar"></div>
                     <a href="javascript:FncClienteBuscar('NumeroDocumento');"></a></td>
                 </tr>
               </table></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Direccion:</td>
                    <td><input class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" value="<?php echo $InsCotizacionProducto->CprDireccion;?>" size="45" maxlength="255"  /></td>
                    <td align="left" valign="top">Celular:</td>
                    <td><input class="EstFormularioCaja" name="CmpClienteCelular" type="text" id="CmpClienteCelular" value="<?php echo $InsCotizacionProducto->CprTelefono;?>" size="20" maxlength="255"  /></td>
                    <td align="left" valign="top">Email:</td>
                    <td><input class="EstFormularioCaja" name="CmpClienteEmail" type="text" id="CmpClienteEmail" value="<?php echo $InsCotizacionProducto->CprEmail;?>" size="45" maxlength="255"  /></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Representante:</td>
                    <td><input class="EstFormularioCaja" name="CmpRepresentante" type="text" id="CmpRepresentante" value="<?php echo $InsCotizacionProducto->CprRepresentante;?>" size="45" maxlength="100"  /></td>
                    <td align="left" valign="top">Tipo de Cliente:</td>
                    <td><select class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                      <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsCotizacionProducto->LtiId==$DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
                      <?php
			}
			?>
                    </select></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Seguro:</td>
                    <td colspan="5"><select class="EstFormularioCombo" name="CmpSeguro" id="CmpSeguro">
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrSeguros as $DatSeguro){
			?>
                      <option  <?php echo ($DatSeguro->CliId==$InsCotizacionProducto->CliIdSeguro)?'selected="selected"':"";?> value="<?php echo $DatSeguro->CliId?>"><?php echo $DatSeguro->CliNombre?> <?php echo $DatSeguro->CliApellidoPaterno?> <?php echo $DatSeguro->CliApellidoMaterno?></option>
                      <?php
			}
			?>
                    </select></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Asegurado:</td>
                    <td><input name="CmpAsegurado" type="text" class="EstFormularioCaja" id="CmpAsegurado" value="<?php echo $InsCotizacionProducto->CprAsegurado;?>" size="45" maxlength="100" readonly="readonly"  /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                    <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Vehiculo 
                      
                    </span></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td align="left" valign="top">VIN:
                       <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsCotizacionProducto->EinId;?>" size="3" />
                       <input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsCotizacionProducto->CliId;?>" size="3" /></td>
                     <td><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncVehiculoIngresoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsCotizacionProducto->EinVIN;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
                   <td><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a></td>
                   </tr>
                 <tr> </tr>
                 <tr> </tr>
               </table></td>
                     <td align="left" valign="top">Marca:
                       <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsCotizacionProducto->VmaId;?>" size="3" /></td>
                     <td><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoMarca" value="<?php echo $InsCotizacionProducto->CprMarca;?>" size="30" maxlength="50" /></td>
                     <td align="left" valign="top">Modelo:
                       <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsCotizacionProducto->VmoId;?>" size="3" /></td>
                     <td><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoModelo" value="<?php echo $InsCotizacionProducto->CprModelo;?>" size="30" maxlength="50" /></td>
                     <td>&nbsp;</td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td align="left" valign="top">Placa:</td>
                     <td><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsCotizacionProducto->CprPlaca;?>" size="30" maxlength="50" /></td>
                     <td align="left" valign="top">A&ntilde;o:</td>
                     <td><input  name="CmpVehiculoIngresoAnoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoAnoModelo" value="<?php echo $InsCotizacionProducto->CprAnoModelo;?>" size="10" maxlength="4" /></td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                   </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Cotizacion  
                   <input type="hidden" name="Guardar" id="Guardar"   />
                   <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCotizacionProducto->CprId;?>" size="20" maxlength="20" /></td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield10">
                 <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsCotizacionProducto->CprFecha)){ echo date("d/m/Y");}else{ echo $InsCotizacionProducto->CprFecha; }?>" size="15" maxlength="10" />
                 <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">OPCIONES ADICIONALES</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cotizador:</td>
               <td colspan="3" align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsCotizacionProducto->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td rowspan="9" align="left" valign="top"><input <?php echo (($InsCotizacionProducto->CprVerificar==1)?'checked="checked"':'');?>  type="checkbox" name="CmpVerificar2" id="CmpVerificar2" value="1" />
                 Requiere ser verificado <span class="EstFormularioSubEtiqueta">(Seguros)</span><br />
                 <input <?php echo (($InsCotizacionProducto->CprFirmaDigital==1)?'checked="checked"':'');?>  type="checkbox" name="CmpFirmaDigital2" id="CmpFirmaDigital2" value="1" />
                 Imprimir Firma Digital del Cotizador <br />
                 <input <?php echo (($InsCotizacionProducto->CprPlanchado=="Si")?'checked="checked"':'');?> value="Si"   type="checkbox" name="CmpPlanchado2" id="CmpPlanchado2" />
                 Incluir Planchado<br />
                 <input <?php echo (($InsCotizacionProducto->CprPintado=="Si")?'checked="checked"':'');?> value="Si"  type="checkbox" name="CmpPintado2" id="CmpPintado2" />
                 Incluir Pintado <br />
                 <input <?php echo (($InsCotizacionProducto->CprCentrado=="Si")?'checked="checked"':'');?> value="Si"  type="checkbox" name="CmpCentrado2" id="CmpCentrado2" />
                 Incluir Centrado <br />
                 <input <?php echo (($InsCotizacionProducto->CprNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar2" id="CmpNotificar2" />
                 Notificar via email (*) <br />
                 
                     <input value="1" checked="checked"  type="checkbox" name="CmpRedondear" id="CmpRedondear" />
                     Calcular precios redondeados         
                      
                      
                      </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:<span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpMonedaIdAnterior" id="CmpMonedaIdAnterior"  value="<?php echo $InsCotizacionProducto->MonIdAnterior;?>" />
               </span></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCotizacionProducto->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                       <?php
			  }
			  ?>
                       </select>
                     <!-- <input type="hidden" name="CmpMonedaId" id="CmpMonedaId" value="<?php echo $InsCotizacionProducto->MonId;?>" />-->
                     <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top">
                 
                 <table>
                   <tr>
                     <td>
                       
                       <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCotizacionProductoDetalleListar();" value="<?php if (empty($InsCotizacionProducto->CprTipoCambio)){ echo "";}else{ echo $InsCotizacionProducto->CprTipoCambio; } ?>" size="10" maxlength="10" />
                       
                       </td>
                     <td>
                       
                       <a href="javascript:FncCotizacionProductoEstablecerMoneda();"><img src="imagenes/recargar.jpg" width="20" height="20" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                       
                       
                       </td>                    
                     </tr>
                   </table>
                 
                 
                 
               </td>
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
               <td align="left" valign="top">Vigencia: <br />
                 <span class="EstFormularioSubEtiqueta"> (dias)</span></td>
               <td align="left" valign="top"><span id="sprytextfield1">
                 <input class="EstFormularioCaja" name="CmpVigencia" type="text" id="CmpVigencia" value="<?php echo $InsCotizacionProducto->CprVigencia;?>" size="10" maxlength="4" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">Tiempo de Entrega: <br />
                 <span class="EstFormularioSubEtiqueta"> (dias)</span></td>
               <td align="left" valign="top"><span id="sprytextfield2"><span id="sprytextfield3">
                 <input class="EstFormularioCaja" name="CmpTiempoEntrega" type="text" id="CmpTiempoEntrega" value="<?php echo $InsCotizacionProducto->CprTiempoEntrega;?>" size="10" maxlength="4" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">e necesita un valor.</span></span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mano de Obra:</td>
               <td align="left" valign="top"><span id="sprytextfield4">
                 <label for="CmpManoObra"></label>
                 <input class="EstFormularioCaja" name="CmpManoObra" type="text" id="CmpManoObra" value="<?php echo number_format($InsCotizacionProducto->CprManoObra,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">Descuento: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield8">
                 <label for="CmpPorcentajeDescuento"></label>
                 <input class="EstFormularioCaja" name="CmpPorcentajeDescuento" type="text" id="CmpPorcentajeDescuento" value="<?php echo number_format($InsCotizacionProducto->CprPorcentajeDescuento,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Margen de Utilidad: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield6">
                 <label for="CmpClienteMargenUtilidad"></label>
                 <input name="CmpClienteMargenUtilidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteMargenUtilidad" value="<?php echo number_format($InsCotizacionProducto->CprMargenUtilidad,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">Otros Costos: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield9">
                 <label for="CmpFlete"></label>
                 <input name="CmpFlete" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFlete" value="<?php echo number_format($InsCotizacionProducto->CprFlete,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><script type="text/javascript">


/*tinymce.init({
	selector: "textarea#CmpObservacion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic",
	width : 400,
	height : 80
});
*/
               </script>
                 <textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsCotizacionProducto->CprObservacion);?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Orden de Trabajo:</td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td><a href="javascript:FncFichaIngresoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input name="CmpFichaIngresoId" id="CmpFichaIngresoId" type="hidden"    value="<?php  echo $InsCotizacionProducto->FinId;?>" size="20" maxlength="20" />
                     <input name="CmpFichaIngreso" type="text" class="EstFormularioCaja" id="CmpFichaIngreso"  value="<?php  echo $InsCotizacionProducto->FinId;?>" size="25" maxlength="25" <?php echo (!empty($InsCotizacionProducto->FinId)?'readonly="readonly"':'')?>  /></td>
                   <td></td>
                   <td><a href="javascript:FncFichaIngresoBuscar('Id');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
                   <td></td>
                 </tr>
               </table>
                 <!--<input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsCotizacionProducto->FinId;?>" size="20" maxlength="20" readonly="readonly" />--></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
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
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"></td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             </table>
             
           </div></td>
       </tr>
       <tr>
         <td valign="top">
           <div class="EstFormularioArea">
             
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="98%"><table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="17">
                     
                     <span class="EstFormularioSubTitulo">PRODUCTOS</span><span class="EstFormularioSubTitulo">

                       <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
                       <input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
                    
                       <input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
                       <input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
                       <input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
                       
                       
<input type="hidden" name="CmpProductoValorVenta"    id="CmpProductoValorVenta"    />
<input type="hidden" name="CmpProductoPrecioBruto"    id="CmpProductoPrecioBruto"    />
				
                <input type="hidden" name="CmpCotizacionProductoDetalleId"    id="CmpCotizacionProductoDetalleId"    />



                     </span>
					
                    </td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td><input type="hidden" name="CmpCotizacionProductoDetalleAccion" id="CmpCotizacionProductoDetalleAccion" value="AccCotizacionProductoDetalleRegistrar.php" /></td>
                     <td>C&oacute;digo Orig.</td>
                     <td>&nbsp;</td>
                     <td>C&oacute;digo Alt.</td>
                     <td>&nbsp;</td>
                     <td>Nombre : </td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>U.M. </td>
                     <td>Costo:</td>
                     <td>Pedido:</td>
                     <td>Cantidad:</td>
                     <td> Precio:</td>
                     <td> Importe:</td>
                     <td>Verificado:</td>
                     <td><div id="CapProductoBuscar"></div></td>
                     <td>&nbsp;</td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td><a href="javascript:FncCotizacionProductoDetalleNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                     <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
                     <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                     <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
                     <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                     <td><a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a></td>
                     <td>
                     
                      <a id="BtnProductoConsulta" onclick="FncProductoCargarFormulario('Consulta');" href="javascript:void(0)"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" /> </a>
                      
                      
                     </td>
                     <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                     </select></td>
                     <td><input name="CmpProductoCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoCosto" size="7" maxlength="10" readonly="readonly"  /></td>
                     <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoDetalleTipoPedido" id="CmpCotizacionProductoDetalleTipoPedido">
                       <option value="">-</option>
						<option value="ALMACEN">ALMACEN</option>
                       <option value="NORMAL">NORMAL</option>
                       <option value="URGENTE">URGENTE +10%</option>
                       <option value="IMPORTACION">IMPORT. +15%</option>
                     </select></td>
                     <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="7" maxlength="10"  /></td>
                     <td><input name="CmpProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoPrecio" size="7" maxlength="10"  /></td>
                     <td><input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="7" maxlength="10"  /></td>
                     <td><select  class="EstFormularioCombo" name="CmpProductoEstado" id="CmpProductoEstado">
                       <option value="0">-</option>
                       <option value="1">Si</option>
                       <option value="2">No</option>
                     </select></td>
                     <td><a href="javascript:FncCotizacionProductoDetalleGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                     <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title="">[...]</a><a href="javascript:FncCotizacionProductoDetalleGuardar();"></a></td>
                   </tr>
                   <tr>
                     <td></td>
                     <td colspan="17">&nbsp;</td>
                   </tr>
                 </table></td>
                 </tr>
               </table>
             </div>         </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="0%">&nbsp;</td>
               <td colspan="2"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncCotizacionProductoDetalleListar();">
<img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar
</a><a href="javascript:FncCotizacionProductoDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%"><div id="CapCotizacionProductoDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="3"><div id="CapCotizacionProductoDetalles" class="EstCapCotizacionProductoDetalles" > </div></td>
               <td>&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="6"><span class="EstFormularioSubTitulo">PLANCHADO </span><span class="EstFormularioSubTitulo">
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
               <td><a href="javascript:FncCotizacionProductoPlanchadoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpCotizacionProductoPlanchadoDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPlanchadoDescripcion" size="60" /></td>
               <td><input name="CmpCotizacionProductoPlanchadoImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPlanchadoImporte" size="10" maxlength="10"  /></td>
               <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoPlanchadoEstado" id="CmpCotizacionProductoPlanchadoEstado">
                 <option value="0">-</option>
                 <option value="1">Si</option>
                 <option value="2">No</option>
               </select></td>
               <td><a href="javascript:FncCotizacionProductoPlanchadoGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoPlanchadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoPlanchadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoPlanchadoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoPlanchados" class="EstCapCotizacionProductoPlanchados" > </div></td>
               <td><div id="CapCotizacionProductoPlanchadosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="6"><span class="EstFormularioSubTitulo">PINTADO
                 <input type="hidden" name="CmpCotizacionProductoPintadoItem" id="CmpCotizacionProductoPintadoItem" />
                 <input type="hidden" name="CmpCotizacionProductoPintadoId"  class="EstFormularioCaja" id="CmpCotizacionProductoPintadoId"  />
               </span></td>
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
               <td><a href="javascript:FncCotizacionProductoPintadoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpCotizacionProductoPintadoDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPintadoDescripcion" size="60" /></td>
               <td><input name="CmpCotizacionProductoPintadoImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoPintadoImporte" size="10" maxlength="10"  /></td>
               <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoPintadoEstado" id="CmpCotizacionProductoPintadoEstado">
                 <option value="0">-</option>
                 <option value="1">Si</option>
                 <option value="2">No</option>
               </select></td>
               <td><a href="javascript:FncCotizacionProductoPintadoGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoPintadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoPintadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoPintadoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoPintados" class="EstCapCotizacionProductoPintados" > </div></td>
               <td><div id="CapCotizacionProductoPintadosResultado"> </div></td>
               </tr>
             </table>
           </div></td>
       </tr>
       
       
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="6"><span class="EstFormularioSubTitulo">CENTRADO
                 <input type="hidden" name="CmpCotizacionProductoCentradoItem" id="CmpCotizacionProductoCentradoItem" />
                 <input type="hidden" name="CmpCotizacionProductoCentradoId"  class="EstFormularioCaja" id="CmpCotizacionProductoCentradoId"  />
               </span></td>
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
               <td><a href="javascript:FncCotizacionProductoCentradoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpCotizacionProductoCentradoDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoCentradoDescripcion" size="60" /></td>
               <td><input name="CmpCotizacionProductoCentradoImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoCentradoImporte" size="10" maxlength="10"  /></td>
               <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoCentradoEstado" id="CmpCotizacionProductoCentradoEstado">
                 <option value="0">-</option>
                 <option value="1">Si</option>
                 <option value="2">No</option>
               </select></td>
               <td><a href="javascript:FncCotizacionProductoCentradoGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoCentradoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoCentradoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoCentradoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoCentrados" class="EstCapCotizacionProductoCentrados" > </div></td>
               <td><div id="CapCotizacionProductoCentradosResultado"> </div></td>
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
               <td colspan="6"><span class="EstFormularioSubTitulo">TAREAS
                 <input type="hidden" name="CmpCotizacionProductoTareaItem" id="CmpCotizacionProductoTareaItem" />
                 <input type="hidden" name="CmpCotizacionProductoTareaId"  class="EstFormularioCaja" id="CmpCotizacionProductoTareaId"  />
               </span></td>
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
               <td><a href="javascript:FncCotizacionProductoTareaNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpCotizacionProductoTareaDescripcion" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoTareaDescripcion" size="60" /></td>
               <td><input name="CmpCotizacionProductoTareaImporte" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoTareaImporte" size="10" maxlength="10"  /></td>
               <td><select  class="EstFormularioCombo" name="CmpCotizacionProductoTareaEstado" id="CmpCotizacionProductoTareaEstado">
                 <option value="0">-</option>
                 <option value="1">Si</option>
                 <option value="2">No</option>
               </select></td>
               <td><a href="javascript:FncCotizacionProductoTareaGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoTareaAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoTareaListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoTareaEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoTareas" class="EstCapCotizacionProductoTareas" > </div></td>
               <td><div id="CapCotizacionProductoTareasResultado"> </div></td>
               </tr>
             </table>
           </div>
         </td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
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
                            
                            <a href="javascript:FncCotizacionProductoFotoListar('A');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a>
                            
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
				sizeErrorStr:"Tamaño no permitido",
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

	
	
	
    
       


     
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	

	

	
</script>

<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "date", {isRequired:false, format:"dd/mm/yyyy"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
</script>


<?php	
}else{
	echo ERR_CPR_602;	
}
?>
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}



//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>
