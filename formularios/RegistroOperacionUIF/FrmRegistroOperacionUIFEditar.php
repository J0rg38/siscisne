<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsRegistroOperacionUIFFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssRegistroOperacionUIF.css');
</style>
   
<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjRegistroOperacionUIF.php');

require_once($InsPoo->MtdPaqAdministracion().'ClsRegistroOperacionUIF.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


$InsRegistroOperacionUIF = new ClsRegistroOperacionUIF();
$InsTipoOperacion = new ClsTipoOperacion();

$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();

$InsMoneda = new ClsMoneda();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsRegistroOperacionUIFDetalle'.$Identificador])){	
	$_SESSION['InsRegistroOperacionUIFDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsRegistroOperacionUIFDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccRegistroOperacionUIFEditar.php');

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,"PmaNombre","ASC",1,NULL);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];



$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

//deb($InsRegistroOperacionUIF->RouFactura);


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
?>


<?php
//if($InsRegistroOperacionUIF->RouFactura=="No"){
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

	FncRegistroOperacionUIFDetalleListar();
	
});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var RegistroOperacionUIFDetalleEditar = 1;
var RegistroOperacionUIFDetalleEliminar = 1;
var RegistroOperacionUIFDetalleVerEstado = 2;

var UnidadMedidaTipo = 2;
</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();"> 


<div class="EstCapMenu">

           
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div> 
<?php	
}
?>
	



<?php
if($Edito){
?>

	<?php
  /*  if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsRegistroOperacionUIF->RouId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsRegistroOperacionUIF->RouId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        operacion en efectivo (ROP)</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsRegistroOperacionUIF->RouTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsRegistroOperacionUIF->RouTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1">Operacion en Efectivo (Mayor Cuantia)</a></li>
 

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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Operacion en Efectivo (Mayor Cuantia)
                 
                 
                 
                 
                 
                 
                 
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsRegistroOperacionUIF->RouId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsRegistroOperacionUIF->RouFecha)){ echo date("d/m/Y");}else{ echo $InsRegistroOperacionUIF->RouFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Empresa:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoEmpresa" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCodigoEmpresa" value="<?php echo $InsRegistroOperacionUIF->RouCodigoEmpresa;?>" size="25" maxlength="45" /></td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha2" type="text" id="CmpFecha2" value="<?php if(empty($InsRegistroOperacionUIF->RouFecha)){ echo date("d/m/Y");}else{ echo $InsRegistroOperacionUIF->RouFecha; }?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo de Oficial de Cumplimiento:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoOficialCumplimiento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCodigoOficialCumplimiento" value="<?php echo $InsRegistroOperacionUIF->RouCodigoOficialCumplimiento;?>" size="25" maxlength="45" /></td>
               <td align="left" valign="top">Hora:<br />
                 <span class="EstFormularioSubEtiqueta">(hh:mm)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpHora" type="text" id="CmpHora" value="<?php echo $InsRegistroOperacionUIF->RouHora?>" size="15" maxlength="10" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la compra</span></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Transaccion:</td>
               <td align="left" valign="top"><input name="CmpTransaccion" type="text" class="EstFormularioCaja" id="CmpTransaccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTransaccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsRegistroOperacionUIF->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncRegistroOperacionUIFDetalleListar();" value="<?php if (empty($InsRegistroOperacionUIF->RouTipoCambio)){ echo "";}else{ echo $InsRegistroOperacionUIF->RouTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                   <td><a href="javascript:FncRegistroOperacionUIFEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Importe:</td>
               <td align="left" valign="top"><input name="CmpImporte" type="text"  class="EstFormularioCaja" id="CmpImporte"  value="<?php echo number_format($InsRegistroOperacionUIF->RouImporte,2)?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del solicitante</span></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente: </td>
               <td colspan="3" align="left" valign="top"><table>
                 <tr>
                   <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsRegistroOperacionUIF->CliId;?>" size="3" /></td>
                   <td><select <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'disabled="disabled"';} ?>     class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" >
                     <option value="">Escoja una opcion</option>
                     <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsRegistroOperacionUIF->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
	}
	?>
                     </select></td>
                   <td><a href="javascript:FncClienteSimpleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" tabindex="4" value="<?php echo $InsRegistroOperacionUIF->CliNumeroDocumento;?>" size="20" maxlength="50"   /></td>
                   <td><a href="javascript:FncClienteSimpleBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteNombreCompleto" type="text" class="EstFormularioCaja" id="CmpClienteNombreCompleto"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliNombre;?>" size="45" maxlength="255"  />
                     <input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteNombre" type="hidden" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliNombre;?>" size="35" maxlength="255"  />
                     <input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteApellidoPaterno" type="hidden" class="EstFormularioCaja" id="CmpClienteApellidoPaterno"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliApellidoPaterno;?>" size="15" maxlength="255"  />
                     <input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteApellidoMaterno" type="hidden" class="EstFormularioCaja" id="CmpClienteApellidoMaterno"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliApellidoMaterno;?>" size="15" maxlength="255"  />                     <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>                   </td>
                   <td><a id="BtnClienteRegistrar" onclick="FncClienteSimpleCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input name="CmpDireccion" type="text" class="EstFormularioCaja" id="CmpDireccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouDireccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">Pais:</td>
               <td align="left" valign="top"><input name="CmpClientePais" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClientePais"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliPais;?>" size="25" maxlength="45" readonly="readonly"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Telefono:</td>
               <td align="left" valign="top"><input name="CmpTelefono" type="text" class="EstFormularioCaja" id="CmpTelefono"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTelefono;?>" size="25" maxlength="45"  /></td>
               <td align="left" valign="top">Celular:</td>
               <td align="left" valign="top"><input name="CmpCelular" type="text" class="EstFormularioCaja" id="CmpCelular"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouCelular;?>" size="25" maxlength="45"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del ordenante</span></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Nombre:</td>
               <td align="left" valign="top"><input name="CmpOrdenanteNombre" type="text" class="EstFormularioCaja" id="CmpOrdenanteNombre"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouOrdenanteNombre;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">DNI:</td>
               <td align="left" valign="top"><input name="CmpOrdenanteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpOrdenanteNumeroDocumento"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouOrdenanteNumeroDocumento;?>" size="25" maxlength="45"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input name="CmpOrdenanteDireccion" type="text" class="EstFormularioCaja" id="CmpOrdenanteDireccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouOrdenanteDireccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del tramitante</span></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Nombre:</td>
               <td align="left" valign="top"><input name="CmpTramitanteNombre" type="text" class="EstFormularioCaja" id="CmpTramitanteNombre"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTramitanteNombre;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">DNI:</td>
               <td align="left" valign="top"><input name="CmpTramitanteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpTramitanteNumeroDocumento"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTramitanteNumeroDocumento;?>" size="25" maxlength="45"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input name="CmpTramitanteDireccion" type="text" class="EstFormularioCaja" id="CmpTramitanteDireccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTramitanteDireccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Origen de los fondos</span></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Descripcion:</td>
               <td align="left" valign="top"><textarea name="CmpOrigenFondo" cols="45" rows="4" class="EstFormularioCaja" id="CmpOrigenFondo"><?php echo $InsRegistroOperacionUIF->RouOrigenFondo;?></textarea></td>
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
               <td align="left" valign="top">Registrado por:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsRegistroOperacionUIF->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
                 </select></td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsRegistroOperacionUIF->RouEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled" >
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsRegistroOperacionUIF->RouObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             </table>
           </div></td>
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
//Calendar.setup({ 
//	inputField : "CmpFecha",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFecha"// el id del botón que  
//	});
//
</script>
<?php
//}else{
//	echo ERR_ROU_601;
//}
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
?>
