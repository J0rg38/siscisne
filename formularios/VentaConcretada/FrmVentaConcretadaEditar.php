<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaConcretadaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaConcretadaDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVentaConcretada.css');
</style>
   
<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVentaConcretada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
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

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsVentaConcretada = new ClsVentaConcretada();
$InsTipoOperacion = new ClsTipoOperacion();

$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsMoneda = new ClsMoneda();

$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsVentaConcretadaDetalle'.$Identificador])){	
	$_SESSION['InsVentaConcretadaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVentaConcretadaDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVentaConcretadaEditar.php');

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

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsVentaConcretada->SucId);
$ArrAlmacenes = $RepAlmacen['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

//deb($InsVentaConcretada->VcoFactura);
?>


<?php
//if($InsVentaConcretada->VcoFactura=="No"){
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

	$('#CmpFecha').focus();	

	FncVentaConcretadaDetalleListar();
	
	

});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var VentaConcretadaDetalleEditar = 1;
var VentaConcretadaDetalleEliminar = 1;

var UnidadMedidaTipo = 2;
</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" >


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
if($Edito){
?>

	<?php
 /*   if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsVentaConcretada->VcoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsVentaConcretada->VcoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        VENTA CONCRETADA (VENTA X MOSTRADOR)</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVentaConcretada->VcoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVentaConcretada->VcoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1">Venta Concretada</a></li>
 

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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Venta Concretada
                 
                 
                 
                 
                 
                 
                 
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpTipoOperacion" id="CmpTipoOperacion" value="<?php echo $InsVentaConcretada->TopId;?>" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVentaConcretada->VcoId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Salida:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsVentaConcretada->VcoFecha)){ echo date("d/m/Y");}else{ echo $InsVentaConcretada->VcoFecha; }?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                 
                 
                 </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente:
                 <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsVentaConcretada->CliId;?>" size="3" /></td>
               <td colspan="3" align="left" valign="top"><table>
                 <tr>
                   <td>&nbsp;</td>
                   <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento2" id="CmpClienteTipoDocumento2">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
                     <option <?php if($InsVentaConcretada->TdoId==$DatTipoDocumento->TdoId){ echo 'selected="selected"';}?> value="<?php echo $DatTipoDocumento->TdoId; ?>">[<?php echo $DatTipoDocumento->TdoCodigo; ?>] <?php echo $DatTipoDocumento->TdoNombre; ?></option>
                     <?php
			}			
			?>
                     </select></td>
                   <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNumeroDocumento2" type="text" id="CmpClienteNumeroDocumento2" size="20" maxlength="50" value="<?php echo $InsVentaConcretada->CliNumeroDocumento;?>" /></td>
                   <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNombre2" type="text" id="CmpClienteNombre2" size="45" maxlength="255" value="<?php echo $InsVentaConcretada->CliNombre;?> <?php echo $InsVentaConcretada->CliApellidoPaterno;?> <?php echo $InsVentaConcretada->CliApellidoMaterno;?>" /></td>
                   <td>&nbsp;</td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input name="CmpClienteDireccion" type="text" class="EstFormularioCaja" id="CmpClienteDireccion" tabindex="5" value="<?php echo $InsVentaConcretada->VcoDireccion;?>" size="45" maxlength="255" readonly="readonly"  /></td>
               <td align="left" valign="top">Tipo de Cliente:</td>
               <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoAux" id="CmpClienteTipoAux">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                 <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsVentaConcretada->LtiId==$DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
                 <?php
			}
			?>
                 </select>
                 <input type="hidden" name="CmpClienteTipo" id="CmpClienteTipo" value="<?php echo $InsVentaConcretada->LtiId;?>" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled" >
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVentaConcretada->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVentaConcretadaDetalleListar();" value="<?php if (empty($InsVentaConcretada->VcoTipoCambio)){ echo "";}else{ echo $InsVentaConcretada->VcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Incluye Impuesto:</td>
               <td align="left" valign="top"><?php
					switch($InsVentaConcretada->VcoIncluyeImpuesto){
						case 1:
							$OpcIncluyeImpuesto1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcIncluyeImpuesto2 = 'selected = "selected"';						
						break;

					}
					?>
                 <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto" disabled="disabled" >
                   <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                   <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                 </select></td>
               <td align="left" valign="top">Impuesto:<br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncVentaConcretadaDetalleListar();" value="<?php echo number_format($InsVentaConcretada->VcoPorcentajeImpuestoVenta,2);?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mano de Obra:</td>
               <td align="left" valign="top"><input name="CmpManoObra" type="text" class="EstFormularioCaja" id="CmpManoObra" value="<?php echo number_format($InsVentaConcretada->VcoManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Descuento:</td>
               <td align="left" valign="top"><input name="CmpDescuento" type="text" class="EstFormularioCaja" id="CmpDescuento" value="<?php echo number_format($InsVentaConcretada->VcoDescuento,2);?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado:
                 <input type="hidden" name="CmpOrigen" id="CmpOrigen" value="<?php echo $InsVentaConcretada->VcoOrigen;?>" size="3" /></td>
               <td align="left" valign="top"><?php
					switch($InsVentaConcretada->VcoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente/Anulado</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                 </select></td>
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
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVentaConcretada->VcoObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cotizacion:</td>
               <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsVentaConcretada->CprId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Seguro:</td>
               <td align="left" valign="top"><input class="EstFormularioCajaDeshabilitada" name="CmpSeguroNombre" type="text" id="CmpSeguroNombre" size="45" maxlength="255" value="<?php echo $InsVentaConcretada->CliNombreSeguro;?> <?php echo $InsVentaConcretada->CliApellidoPaternoSeguro;?> <?php echo $InsVentaConcretada->CliApellidoMaternoSeguro;?>"  /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Ord. de Venta :</td>
               <td align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsVentaConcretada->VdiId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Almacen Salida:</td>
               <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsVentaConcretada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de despacho</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Empresa de Transportes:</td>
               <td align="left" valign="top"><input name="CmpEmpresaTransporte" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporte" value="<?php echo $InsVentaConcretada->VcoEmpresaTransporte;?>" size="45" maxlength="255" /></td>
               <td align="left" valign="top">Doc. Ref.</td>
               <td align="left" valign="top"><input name="CmpEmpresaTransporteDocumento" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporteDocumento" value="<?php echo $InsVentaConcretada->VcoEmpresaTransporteDocumento;?>" size="45" maxlength="255" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Clave de recepci&oacute;n:</td>
               <td align="left" valign="top"><input name="CmpEmpresaTransporteClave" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporteClave" value="<?php echo $InsVentaConcretada->VcoEmpresaTransporteClave;?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">Fecha de Despacho:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpEmpresaTransporteFecha" type="text" class="EstFormularioCajaFecha" id="CmpEmpresaTransporteFecha" value="<?php echo $InsVentaConcretada->VcoEmpresaTransporteFecha; ?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnEmpresaTransporteFecha" name="BtnEmpresaTransporteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Envio:</td>
               <td align="left" valign="top"><input name="CmpEmpresaTransporteTipoEnvio" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporteTipoEnvio" value="<?php echo $InsVentaConcretada->VcoEmpresaTransporteTipoEnvio;?>" size="20" maxlength="45" /></td>
               <td align="left" valign="top">Destino:</td>
               <td align="left" valign="top"><input name="CmpEmpresaTransporteDestino" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporteDestino" value="<?php echo $InsVentaConcretada->VcoEmpresaTransporteDestino;?>" size="20" maxlength="45" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table width="100%" border="0" cellpadding="0" cellspacing="0">
             <tr>
               <td width="98%"><table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                 <tr>
                   <td>&nbsp;</td>
                   <td colspan="12"><span class="EstFormularioSubTitulo">PRODUCTOS </span><span class="EstFormularioSubTitulo">
                     <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
                     <input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
                     <input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
                     <input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
                     <input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
                       <input type="hidden" name="CmpVentaConcretadaDetalleReingreso"    id="CmpVentaConcretadaDetalleReingreso" value="2"  />
                     
                     
                   </span></td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td><div id="CapProductoBuscar"></div></td>
                   <td>C&oacute;digo Orig.</td>
                   <td>&nbsp;</td>
                   <td>Nombre : </td>
                   <td>&nbsp;</td>
                   <td>U.M.</td>
                   <td>Costo:</td>
                   <td>Cantidad:</td>
                   <td> Precio:</td>
                   <td> Importe:</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td>
  <?php
if(empty($InsVentaConcretada->VdiId) or 1 == 1){
?>
                     
                     <a href="javascript:FncVentaConcretadaDetalleNuevo('');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                     
                     
  <?php	
}
?>
                     
                   </td>
                   <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                   <td>
                     
                     
                     <?php
if(empty($InsVentaConcretada->VdiId) or 1 == 1){
?>
                     <a href="javascript:FncProductoBuscar('CodigoOriginal','');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                     <?php	
}
?>                  
                   </td>
                   <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                   <td>
                   
                                      <?php
if(empty($InsVentaConcretada->VdiId) or 1 == 1){
?>
                   <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                   
     <?php	
}
?>                 
                   </td>
                   <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                   </select></td>
                   <td><input name="CmpProductoCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoCosto" size="10" maxlength="10" readonly="readonly"  /></td>
                   <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10"  /></td>
                   <td><input name="CmpProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoPrecio" size="10" maxlength="10" readonly="readonly"  /></td>
                   <td><input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="10" maxlength="10"  /></td>
                   <td>
                     
                     <a href="javascript:FncVentaConcretadaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                   <td>
                   
                   <?php
if(empty($InsVentaConcretada->VdiId) or 1 == 1){
?>
<a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
<?php
}
?>
</td>
                 </tr>
               </table></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%"><input type="hidden" name="CmpVentaConcretadaDetalleAccion" id="CmpVentaConcretadaDetalleAccion" value="AccVentaConcretadaDetalleRegistrar.php" /></td>
               <td width="50%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right">
               
               
               
               <a href="javascript:FncVentaConcretadaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVentaConcretadaDetalleEliminarTodo();"></a>
               
               
               
               
               </td>
               <td width="0%"><div id="CapVentaConcretadaDetallesResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVentaConcretadaDetalles" class="EstCapVentaConcretadaDetalles" > </div></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
           <tr>
             <td><img src="imagenes/advertencia.png" alt="Producto si stock" width="20" height="20" border="0" title="Producto sin stock" /></td>
             <td> Producto sin stock suficiente </td>
           </tr>
         </table></td>
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
	inputField : "CmpEmpresaTransporteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnEmpresaTransporteFecha"// el id del botón que  
	});
	
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<?php
//}else{
//	echo ERR_VCO_601;
//}
?>


<?php
}else{
	echo ERR_GEN_101;
}


	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
