<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>

<?php $PrivilegioVentaConcretaRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Registrar"))?true:false;?>
<?php $PrivilegioPedidoCompraRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Registrar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletarv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirectaTotalFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFunciones.js" ></script>



<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVentaDirecta.css');
</style>


<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVentaDirecta.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsTipoOperacion = new ClsTipoOperacion();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsCotizacionProducto = new ClsCotizacionProducto();


$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsMoneda = new ClsMoneda();
$InsCondicionPago = new ClsCondicionPago();
$InsPersonal = new ClsPersonal();

$InsAlmacen = new ClsAlmacen();


if (isset($_SESSION['InsVentaDirectaDetalle'.$Identificador])){	
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaDetalle'.$Identificador]);
}


if (isset($_SESSION['InsVentaDirectaPlanchado'.$Identificador])){	
	$_SESSION['InsVentaDirectaPlanchado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaPlanchado'.$Identificador]);
}


if (isset($_SESSION['InsVentaDirectaPintado'.$Identificador])){	
	$_SESSION['InsVentaDirectaPintado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaPintado'.$Identificador]);
}


if (isset($_SESSION['InsVentaDirectaCentrado'.$Identificador])){	
	$_SESSION['InsVentaDirectaCentrado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaCentrado'.$Identificador]);
}


if (isset($_SESSION['InsVentaDirectaTarea'.$Identificador])){	
	$_SESSION['InsVentaDirectaTarea'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaTarea'.$Identificador]);
}

if (!isset($_SESSION['InsVentaDirectaFoto'.$Identificador])){	
	$_SESSION['InsVentaDirectaFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsVentaDirectaFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaDirectaFoto'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVentaDirectaEditar.php');

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];
?>

<?php
//if($InsVentaDirecta->VdiPedidoCompra == "No" and $InsVentaDirecta->VdiVentaConcretada == "No"){
if(1 == 1){	
?>



<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
/*
//Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
//Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpClienteNombre').focus();

	FncVentaDirectaDetalleListar();
	
	FncVentaDirectaPlanchadoListar();
	
	FncVentaDirectaPintadoListar();
	
	FncVentaDirectaCentradoListar();
	
	FncVentaDirectaTareaListar();
	
	FncVentaDirectaFotoListar("A");
	
	FncVentaDirectaFotoListar("G");
	

});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var VentaDirectaDetalleEditar = 1;
var VentaDirectaDetalleEliminar = 1;
var VentaDirectaDetalleVerEstado = 2;

var VentaDirectaPlanchadoEditar = 1;
var VentaDirectaPlanchadoEliminar = 1;

var VentaDirectaPintadoEditar = 1;
var VentaDirectaPintadoEliminar = 1;

var VentaDirectaCentradoEditar = 1;
var VentaDirectaCentradoEliminar = 1;

var VentaDirectaTareaEditar = 1;
var VentaDirectaTareaEliminar = 1;

var UnidadMedidaTipo = 2;

var VentaDirectaFotoEditar = 1;
var VentaDirectaFotoEliminar = 1;
</script>




<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();">

<input type="hidden" name="CmpPedidoCompra" id="CmpPedidoCompra" value="<?php echo $InsVentaDirecta->VdiPedidoCompra;?>" />
<input type="hidden" name="CmpVentaConcretada" id="CmpVentaConcretada" value="<?php echo $InsVentaDirecta->VdiVentaConcretada;?>" />


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
			if($PrivilegioVentaConcretaRegistrar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=VentaConcretada&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&VdiId=<?php echo $InsVentaDirecta->VdiId;?>&Origen=VentaDirecta"><img src="imagenes/generar.jpg" alt="[Generar]" title="Generar" /> Concretada</a></div>
             <?php
			}
			?> 
            


<?php
if($PrivilegioPedidoCompraRegistrar){
?>		                
	<div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=PedidoCompra&Form=Registrar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&VdiId=<?php echo $InsVentaDirecta->VdiId;?>&Origen=VentaDirecta"><img src="imagenes/generar_pedido.png"  border="0" title="Generar Pedido de Compra" alt="[Generar Pedido de Compra]"   /> Pedido</a>                </div>
<?php
}
?>



 
                   	<?php
			if($PrivilegioVer){
			?>           
 <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=VentaDirecta&Form=VerEstado<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVentaDirecta->VdiId;?>"><img src="imagenes/acciones/ver_estado.png" alt="[O.V. Estado]" title="Generar" />  Estado</a></div>
<?php

			}?>

<?php
if($Edito){
?>

	<?php
/*    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsVentaDirecta->VdiId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsVentaDirecta->VdiId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }*/
    ?>

<?php	
}
?>
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        ORDEN DE VENTA  </span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVentaDirecta->VdiTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVentaDirecta->VdiTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1">Orden de Venta  </a></li>
     <li><a href="#tab2">Archivo de Referencia  </a></li>
 

</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        

        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Orden de Venta  
                 
                 
                 
                 
                 
                 
                 
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVentaDirecta->VdiId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Emision:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsVentaDirecta->VdiFecha)){ echo date("d/m/Y");}else{ echo $InsVentaDirecta->VdiFecha; }?>" size="15" maxlength="10" readonly="readonly" />
                 
                 
                 </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del cliente</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente: </td>
               <td colspan="3" align="left" valign="top">
                 
                 
                 <table>
                   <tr>
                     <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsVentaDirecta->CliId;?>" size="3" />
                       <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsVentaDirecta->EinId;?>" size="3" /></td>
                     <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                       <option value="">Escoja una opcion</option>
                       <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                       <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsVentaDirecta->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                       <?php
	}
	?>
                       </select></td>
                     <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td><input <?php if(!empty($InsVentaDirecta->CliId)){ echo 'readonly="readonly"';} ?>  tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsVentaDirecta->CliNumeroDocumento;?>"   /></td>
                     <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td>
                       
                       <span id="sprytextfield2">
                         <label>
                           <input <?php if(!empty($InsVentaDirecta->CliId)){ echo 'readonly="readonly"';} ?>  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsVentaDirecta->CliNombre;?> <?php echo $InsVentaDirecta->CliApellidoPaterno;?> <?php echo $InsVentaDirecta->CliApellidoMaterno;?>"  />
                           </label>
                         <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                         <label></label>
                         </span>
                       <label></label>
                     
                       
                       
                       
                       </td>
                     <td>
                       <a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>   <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                       </td>
                     </tr>
                   </table>
                 
               </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsVentaDirecta->VdiDireccion;?>"  /></td>
               <td align="left" valign="top">Tipo de Cliente:</td>
               <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                 <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsVentaDirecta->LtiId==$DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
                 <?php
			}
			?>
               </select></td>
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
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVentaDirecta->EinId;?>" size="3" />
                 <input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsVentaDirecta->CliId;?>" size="3" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncVehiculoIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVentaDirecta->EinVIN;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Marca:
                 <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsVentaDirecta->VmaId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoMarca" value="<?php echo $InsVentaDirecta->VdiMarca;?>" size="30" maxlength="50" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsVentaDirecta->VmoId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoModelo" value="<?php echo $InsVentaDirecta->VdiModelo;?>" size="30" maxlength="50" /></td>
               <td align="left" valign="top">Placa:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsVentaDirecta->VdiPlaca;?>" size="10" maxlength="10"  /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">A&ntilde;o:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoAnoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoAnoModelo" value="<?php echo $InsVentaDirecta->VdiAnoModelo;?>" size="10" maxlength="4" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Facturacion</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Condicion de Pago:</td>
               <td align="left" valign="top"><span id="spryselect1">
                 <select class="EstFormularioCombo" name="CmpCondicionPago" id="CmpCondicionPago">
                   <option value="">Escoja una opcion</option>
                   <?php
			  foreach($ArrCondicionPagos as $DatCondicionPago){
				?>
                   <option <?php echo ($InsVentaDirecta->NpaId == $DatCondicionPago->NpaId)?'selected="selected"':''; ?> value="<?php echo $DatCondicionPago->NpaId?>"><?php echo $DatCondicionPago->NpaNombre ?></option>
                   <?php
			  }
			  
			  ?>
                   </select>
                 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
               <td align="left" valign="top">Dias de Credito:</td>
               <td align="left" valign="top"><span id="sprytextfield5">
                 <label for="CmpCreditoDias"></label>
                 <input name="CmpCreditoDias" type="text" class="EstFormularioCaja" id="CmpCreditoDias" value="<?php echo number_format($InsVentaDirecta->VdiCantidadDias,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select <?php echo ($InsVentaDirecta->VdiOrigen=="CPR")?'disabled="disabled"':'';?> class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVentaDirecta->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                       <?php
			  }
			  ?>
                       </select>
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
                       
                       <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVentaDirectaDetalleListar();" value="<?php if (empty($InsVentaDirecta->VdiTipoCambio)){ echo "";}else{ echo $InsVentaDirecta->VdiTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
                       
                       </td>
                     <td>
                       
                       <a href="javascript:FncVentaDirectaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                       
                       
                       </td>
                     </tr>
                   </table>
                 
                 </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Margen de Utilidad: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield6">
                 <label for="CmpClienteMargenUtilidad"></label>
                 <input name="CmpClienteMargenUtilidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteMargenUtilidad" value="<?php echo number_format($InsVentaDirecta->VdiMargenUtilidad,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">Otros Costos: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield9">
                 <label for="CmpFletePorcentaje"></label>
                 <input name="CmpFletePorcentaje" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFletePorcentaje" value="<?php echo number_format($InsVentaDirecta->VdiFlete,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mantenimiento: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield9">
                 <label for="CmpMantenimientoPorcentaje"></label>
                 <input name="CmpMantenimientoPorcentaje" type="text" class="EstFormularioCajaDeshabilitada" id="CmpMantenimientoPorcentaje" value="<?php echo number_format($InsVentaDirecta->VdiMantenimiento,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">Descuento: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><span id="sprytextfield8">
                 <label for="CmpPorcentajeDescuento"></label>
                 <input class="EstFormularioCaja" name="CmpPorcentajeDescuento" type="text" id="CmpPorcentajeDescuento" value="<?php echo number_format($InsVentaDirecta->VdiPorcentajeDescuento,2);?>" size="10" maxlength="10" />
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Incluye Impuesto:</td>
               <td align="left" valign="top"><?php
					switch($InsVentaDirecta->VdiIncluyeImpuesto){
						case 1:
							$OpcIncluyeImpuesto1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcIncluyeImpuesto2 = 'selected = "selected"';						
						break;

					}
					?>
                 <select  onchange="FncVentaDirectaDetalleListar();" class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto" <?php echo !empty($InsVentaDirecta->CprId)?'disabled="disabled"':'';?>>
                   <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                   <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                   </select></td>
               <td align="left" valign="top">Impuesto:<br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncVentaDirectaDetalleListar();" value="<?php echo number_format($InsVentaDirecta->VdiPorcentajeImpuestoVenta,2);?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mano de Obra:</td>
               <td align="left" valign="top"><input name="CmpManoObra" type="text" class="EstFormularioCaja" id="CmpManoObra" value="<?php echo number_format($InsVentaDirecta->VdiManoObra,2);?>" size="10" maxlength="10" /></td>
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
               <td>Asesor de Ventas:</td>
               <td><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsVentaDirecta->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
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
               <td align="left" valign="top">Ord. Compra/Referencia:</td>
               <td align="left" valign="top"><input name="CmpOrdenCompraNumero" type="text" class="EstFormularioCaja" id="CmpOrdenCompraNumero"  tabindex="3" value="<?php  echo $InsVentaDirecta->VdiOrdenCompraNumero;?>" size="25" maxlength="25" /></td>
               <td align="left" valign="top">Fecha Ord. Compra/Referencia:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield3">
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpOrdenCompraFecha" type="text" id="CmpOrdenCompraFecha" value="<?php  echo $InsVentaDirecta->VdiOrdenCompraFecha;?>" size="15" maxlength="10" />
                   </label>
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnOrdenCompraFecha" name="BtnOrdenCompraFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cotizacion:</td>
               <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsVentaDirecta->CprId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Seguro:</td>
               <td align="left" valign="top">
                 
                 
                 
                 <input class="EstFormularioCajaDeshabilitada" name="CmpSeguroNombre" type="text" id="CmpSeguroNombre" size="45" maxlength="255" value="<?php echo $InsVentaDirecta->CliNombreSeguro;?> <?php echo $InsVentaDirecta->CliApellidoPaternoSeguro;?> <?php echo $InsVentaDirecta->CliApellidoMaternoSeguro;?>"  />
                 
                 
                 
                 
                 
                 
                 </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top"><?php
				//if(!empty($InsVentaDirecta->CprId)){
				?>
                 Orden de Trabajo:
                 <?php
				//}
					?></td>
               <td align="left" valign="top"><?php
				//if(!empty($InsVentaDirecta->CprId)){
				?>
                 <table>
                   <tr>
                     <td><a href="javascript:FncFichaIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td><input name="CmpFichaIngresoId" id="CmpFichaIngresoId" type="hidden"    value="<?php  echo $InsVentaDirecta->FinId;?>" size="20" maxlength="20" />
                       <input name="CmpFichaIngreso" type="text" class="EstFormularioCaja" id="CmpFichaIngreso"  tabindex="3" value="<?php  echo $InsVentaDirecta->FinId;?>" size="25" maxlength="25" <?php echo (!empty($InsVentaDirecta->FinId)?'readonly="readonly"':'')?>  /></td>
                     <td></td>
                     <td><a href="javascript:FncFichaIngresoBuscar('Id');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td></td>
                     </tr>
                   </table>
                 <?php
				//}
					?></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVentaDirecta->VdiObservacion;?></textarea></td>
               <td align="left" valign="top">Observacion Impresa:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsVentaDirecta->VdiObservacionImpresa;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top">
                 
                 
                 <?php
					switch($InsVentaDirecta->VdiEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 7:
							$OpcEstado7 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   <option <?php echo $OpcEstado7;?> value="7">Completado</option>
                   </select>
                 
               </td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales</span></td>
               <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Orden de Cobro</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top"><input <?php echo (($InsVentaDirecta->VdiNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                 Notificar via email <br />
  <input value="1" checked="checked"  type="checkbox" name="CmpRedondear" id="CmpRedondear" />
                 Redondear los precios </td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top" bgcolor="#CCFFCC">Monto a Cobrar:</td>
               <td align="left" valign="top"><input name="CmpAbono" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAbono" value="<?php echo number_format($InsVentaDirecta->VdiAbono,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">
         
			<?php
			//if($InsVentaDirecta->VdiOrigen <> "CPR"){
			?>
            
           <div class="EstFormularioArea">
             
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="98%">
                   
                   
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="16"><span class="EstFormularioSubTitulo">PRODUCTOS
                         <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpProductoValorVenta"    id="CmpProductoValorVenta"    />
<input type="hidden" name="CmpVentaDirectaDetalleId"  class="EstFormularioCaja" id="CmpVentaDirectaDetalleId"  />
    <input type="hidden" name="CmpProductoPrecioBruto"    id="CmpProductoPrecioBruto"    />                   
                       
                       
                       </span></td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>Estado:</td>
                       <td><div id="CapProductoBuscar"></div></td>
                       <td>C&oacute;digo Orig.</td>
                       <td>&nbsp;</td>
                       <td>C&oacute;digo Alt.</td>
                       <td>&nbsp;</td>
                       <td>Nombre : </td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>U.M.</td>
                       <td>Pedido:</td>
                       <td>Cantidad:</td>
                       <td> Precio:</td>
                       <td> Importe:</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                  
                     <tr>
                       <td>&nbsp;</td>
                       <td><select  class="EstFormularioCombo" name="CmpVentaDirectaDetalleEstado" id="CmpVentaDirectaDetalleEstado">
                         <option value="0">-</option>
                         <option value="1"  selected="selected">Considerar</option>
                         <option value="2">Anulado</option>
                         <option value="3">Interno</option>
                         <option value="4">Devolucion</option>
                         <option value="5">Dañado</option>
                          <option value="7">Facturado</option>
                       </select></td>
                       <td>
                         <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                         <a href="javascript:FncVentaDirectaDetalleNuevo('');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                         <?php
							}
					   ?>
                       </td>
                       <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                       <td>
                       
                                              <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                       <a href="javascript:FncProductoBuscar('CodigoOriginal','');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                         <?php
							}
					   ?>
                       </td>
                       <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                       <td>
                       
                                                                     <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                       <a href="javascript:FncProductoBuscar('CodigoAlternativo','');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                          <?php
							}
					   ?>
                       </td>
                       <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="30" /></td>
                       <td>
                       
                       
                                                                                            <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                       <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                       
                       <?php
							}
					   ?>
                       </td>
                       <td>
                        <a id="BtnProductoConsulta" onclick="FncProductoCargarFormulario('Consulta');" href="javascript:void(0)"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" /> </a>
                        
                       </td>
                       <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                       </select></td>
                       <td>
                         <select  class="EstFormularioCombo" name="CmpVentaDirectaDetalleTipoPedido" id="CmpVentaDirectaDetalleTipoPedido">
                           <option value="">-</option>
                           <option value="ALMACEN">ALMACEN</option>
                           <option value="NORMAL">NORMAL</option>
                           <option value="URGENTE">URGENTE +10%</option>
                           <option value="IMPORTACION">IMPORT.</option>
                           </select>
                       </td>
                       <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="8" maxlength="10"  /></td>
                       <td><input name="CmpProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoPrecio" size="8" maxlength="10"  /></td>
                       <td><input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="8" maxlength="10"  />                   </td>
                       <td><a href="javascript:FncVentaDirectaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                       <td>
                       
                                                <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                            <a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                            
                                                   <?php
							}
                       ?>
                            </td>
                     </tr>
                        <tr>
                       <td>&nbsp;</td>
                       <td colspan="15"><table>
                         <tr>
                           <td>Costo:</td>
                           <td><input name="CmpProductoCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoCosto" size="8" maxlength="10" readonly="readonly"  /></td>
                           <td>&nbsp;</td>
                         </tr>
                       </table></td>
                       <td>&nbsp;</td>
                     </tr>
                     
                     </table>             </td>
                 </tr>
               </table>
             </div>         
             
            <?php
			//}
			?>
            
            
             </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%"><input type="hidden" name="CmpVentaDirectaDetalleAccion" id="CmpVentaDirectaDetalleAccion" value="AccVentaDirectaDetalleRegistrar.php" /></td>
               <td width="50%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVentaDirectaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 
                 <?php
			if($InsVentaDirecta->VdiOrigen <> "CPR"){
			?>
                 
                 <a href="javascript:FncVentaDirectaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                 
                 <?php
			}
			?>
                 
                 </td>
               <td width="0%"><div id="CapVentaDirectaDetallesResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaDetalles" class="EstCapVentaDirectaDetalles" > </div></td>
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
               <td colspan="5"><span class="EstFormularioSubTitulo">PLANCHADO </span><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaPlanchadoItem" id="CmpVentaDirectaPlanchadoItem" />
                 <input type="hidden" name="CmpVentaDirectaPlanchadoId"  class="EstFormularioCaja" id="CmpVentaDirectaPlanchadoId"  />
                 </span></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaPlanchadoAccion" id="CmpVentaDirectaPlanchadoAccion" value="AccVentaDirectaPlanchadoRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaPlanchadoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaPlanchadoDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPlanchadoDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaPlanchadoImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPlanchadoImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaPlanchadoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaPlanchadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaPlanchadoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaPlanchadoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaPlanchados" class="EstCapVentaDirectaPlanchados" > </div></td>
               <td><div id="CapVentaDirectaPlanchadosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5">PINTADO<span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaPintadoItem" id="CmpVentaDirectaPintadoItem" />
                 <input type="hidden" name="CmpVentaDirectaPintadoId"  class="EstFormularioCaja" id="CmpVentaDirectaPintadoId"  />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaPintadoAccion" id="CmpVentaDirectaPintadoAccion" value="AccVentaDirectaPintadoRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaPintadoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaPintadoDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPintadoDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaPintadoImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaPintadoImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaPintadoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaPintadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaPintadoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaPintadoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaPintados" class="EstCapVentaDirectaPintados" > </div></td>
               <td><div id="CapVentaDirectaPintadosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5">CENTRADO<span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaCentradoItem" id="CmpVentaDirectaCentradoItem" />
                 <input type="hidden" name="CmpVentaDirectaCentradoId"  class="EstFormularioCaja" id="CmpVentaDirectaCentradoId"  />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaCentradoAccion" id="CmpVentaDirectaCentradoAccion" value="AccVentaDirectaCentradoRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaCentradoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaCentradoDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaCentradoDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaCentradoImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaCentradoImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaCentradoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaCentradoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaCentradoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaCentradoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaCentrados" class="EstCapVentaDirectaCentrados" > </div></td>
               <td><div id="CapVentaDirectaCentradosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5">TAREAS<span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpVentaDirectaTareaItem" id="CmpVentaDirectaTareaItem" />
                 <input type="hidden" name="CmpVentaDirectaTareaId"  class="EstFormularioCaja" id="CmpVentaDirectaTareaId"  />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpVentaDirectaTareaAccion" id="CmpVentaDirectaTareaAccion" value="AccVentaDirectaTareaRegistrar.php" /></td>
               <td>Nombre : </td>
               <td> Importe:</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncVentaDirectaTareaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpVentaDirectaTareaDescripcion" type="text" class="EstFormularioCaja" id="CmpVentaDirectaTareaDescripcion" size="60" /></td>
               <td><input name="CmpVentaDirectaTareaImporte" type="text" class="EstFormularioCaja" id="CmpVentaDirectaTareaImporte" size="10" maxlength="10"  /></td>
               <td><a href="javascript:FncVentaDirectaTareaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
               <td width="48%"><div class="EstFormularioAccion" id="CapVentaDirectaTareaAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncVentaDirectaTareaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaDirectaTareaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaDirectaTareas" class="EstCapVentaDirectaTareas" > </div></td>
               <td><div id="CapVentaDirectaTareasResultado"> </div></td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">









<div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="98%" colspan="2"><div id="CapVentaDirectaTotals" class="EstCapVentaDirectaTotals" > </div></td>
                    <td width="1%"></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de Referencia</span></td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4">Archivo Ord. Compra Ref.:</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4">
             
             			    <div class="EstFormularioArea" >
                
                <div class="EstCapVentaDirectaFotos">
                
               <iframe src="formularios/VentaDirecta/acc/AccVentaDirectaSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrVentaDirectaSubirArchivo" name="IfrVentaDirectaSubirArchivo" scrolling="Auto"  frameborder="0" width="600" height="200"></iframe>
               </div>
               </div>
               </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de Actas de Entrega</span></td>
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
                             
                             <a href="javascript:FncVentaDirectaFotoListar('A');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                             
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
				url:"formularios/VentaDirecta/acc/AccVentaDirectaSubirFoto.php",
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
					FncVentaDirectaFotoListar("A");
				}
	
	});
});
              
            </script>
                             
                             
                             
                             
                           </td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVentaDirectaFotos" id="CapVentaDirectaFotosA"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">
                             
                             <div id="CapVentaDirectaFotosAccionA"></div>
                             </td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table>
                     </div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de Guias de Remision</span></td>
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
                       
                       <a href="javascript:FncVentaDirectaFotoListar('G');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                       
                       </td>
                     <td width="4" align="left" valign="top">&nbsp;</td>
                     </tr>
                   <tr>
                     <td align="left" valign="top">&nbsp;</td>
                     <td colspan="2" align="left" valign="top">
                       <div id="fileuploaderG">Escoger Archivos</div>
                       
                       
                       
                       <script type="text/javascript">
		$(document).ready(function(){

				$("#fileuploaderG").uploadFile({
					
				allowedTypes:"png,gif,jpg,jpeg,pdf",
				url:"formularios/VentaDirecta/acc/AccVentaDirectaSubirFoto.php",
				formData: {"Identificador":"<?php echo $Identificador;?>","Tipo":"G"},
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
					FncVentaDirectaFotoListar("G");
				}
	
	});
});
              
            </script>
                       
                       
                       
                       
                       </td>
                     <td align="left" valign="top">&nbsp;</td>
                     </tr>
                   <tr>
                     <td align="left" valign="top">&nbsp;</td>
                     <td colspan="2" align="left" valign="top"><div class="EstCapVentaDirectaFotos" id="CapVentaDirectaFotosG"></div></td>
                     <td align="left" valign="top">&nbsp;</td>
                     </tr>
                   <tr>
                     <td align="left" valign="top">&nbsp;</td>
                     <td colspan="2" align="left" valign="top">
                       
                       <div id="CapVentaDirectaFotosAccionG"></div>
                       </td>
                     <td align="left" valign="top">&nbsp;</td>
                     </tr>
                   </table>
                 </div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4">&nbsp;</td>
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
Calendar.setup({ 
	inputField : "CmpOrdenCompraFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnOrdenCompraFecha"// el id del botón que  
	});
</script>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"dd/mm/yyyy"});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
</script>
<?php
}else{
	echo ERR_VDI_121;
}
?>


<?php
}else{
	echo ERR_GEN_101;
}
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

?>
