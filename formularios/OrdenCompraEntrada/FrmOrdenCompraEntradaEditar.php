<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada",$GET_form)){
?>

<?php //$PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php //$PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php //$PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
         
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraEntradaPedidoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCompraEntrada.css');
</style>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCompraEntrada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsOrdenCompraEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsOrdenCompraEntradaDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

$InsOrdenCompraEntrada = new ClsOrdenCompraEntrada();
$InsOrdenCompra = new ClsOrdenCompra();
$InsMoneda = new ClsMoneda();

$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();


$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsTipoDocumento = new ClsTipoDocumento();


$InsOrdenCompra->OcoId = $GET_id;
$InsOrdenCompra->MtdObtenerOrdenCompra();

if (isset($_SESSION['InsOrdenCompraEntradaPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraEntradaPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraEntradaPedido'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador])){	
	$_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCompraEntradaEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];


$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];
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

	$('#CmpTipo').focus();	

	FncOrdenCompraEntradaPedidoListar();
	
	FncOrdenCompraEntradaEstablecerMoneda();


});

/*
Configuracion Formulario
*/
var OrdenCompraEntradaPedidoEditar = 1;
var OrdenCompraEntradaPedidoEliminar = 1;
</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">

<?php
if($Edito){
?>

	<?php
/*    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    
    <?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
          
        
    <?php
    if($PrivilegioGenerarExcel){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 
    
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
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>
<?php	
}
?>
	

            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR ENTRADA A ALMACEN c/ ORDEN COMPRA </span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Orden de Compra</a></li>

</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCompra->OcoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCompra->OcoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="8"><span class="EstFormularioSubTitulo">Datos de la Orden de Compra
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="-1">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpOrdenCompraId" type="text" class="EstFormularioCaja" id="CmpOrdenCompraId" value="<?php echo $InsOrdenCompra->OcoId;?>" size="25" maxlength="25" /></td>
               <td colspan="-1" align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td colspan="-1" align="left" valign="top"><input name="CmpOrdenCompraFecha" type="text" class="EstFormularioCajaFecha" id="CmpOrdenCompraFecha" value="<?php if(empty($InsOrdenCompraEntrada->OcoFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCompraEntrada->OcoFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpOrdenCompraMonedaIdAux" id="CmpOrdenCompraMonedaIdAux" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                   </select>
                     <input type="hidden" name="CmpOrdenCompraMonedaId" id="CmpOrdenCompraMonedaId" value="<?php echo $InsOrdenCompra->MonId; ?>" /></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                 </tr>
               </table></td>
               <td colspan="-1" align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td colspan="-1" align="left" valign="top"><input name="CmpOrdenCompraTipoCambio" type="text"  class="EstFormularioCaja" id="CmpOrdenCompraTipoCambio" onchange="FncOrdenCompraEntradaPedidoListar();" value="<?php if (empty($InsOrdenCompra->OcoTipoCambio)){ echo "";}else{ echo $InsOrdenCompra->OcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="-1">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="6"><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input readonly="readonly" name="CmpId" type="hidden" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsOrdenCompraEntrada->OceId;?>" size="20" maxlength="20" /></td>
               <td>&nbsp;</td>
               <td colspan="-1">&nbsp;</td>
               <td colspan="-1"></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha de Ingreso: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield1">
                 <?php
//			 deb($InsOrdenCompraEntrada->OceFecha);
			 ?>
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo $InsOrdenCompraEntrada->OceFecha; ?>" size="15" maxlength="10" />
                   </label>
                 <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">Tipo de Comprobante:</td>
               <td align="left" valign="top"><span id="spryselect3">
                 <select class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                   <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsOrdenCompraEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                   <?php
			}
			?>
                   </select>
                 <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento"  /></span></span></td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top"><span id="spryselect">
                 <select class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                   <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsOrdenCompraEntrada->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                   <?php
			}
			?>
                   </select>
                 <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento"  /></span></span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpProveedorTipoDocumentoAux" id="CmpProveedorTipoDocumentoAux" disabled="disabled">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                 <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsOrdenCompraEntrada->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                 <?php
			}
			?>
               </select>
                 <input type="hidden" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" value="<?php echo $InsOrdenCompraEntrada->TdoId;?>" />
:
<input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsOrdenCompraEntrada->PrvId;?>" size="3" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsOrdenCompraEntrada->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                   <td><div id="CapProveedorBuscar"></div></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">Proveedor:</td>
               <td colspan="3" align="left" valign="top"><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsOrdenCompraEntrada->PrvNombre;?>" size="45" maxlength="255" readonly="readonly"  /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero de Comprobante:</td>
               <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsOrdenCompraEntrada->OceComprobanteNumeroSerie;?>" size="10" maxlength="50" />
                 -
                 <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsOrdenCompraEntrada->OceComprobanteNumeroNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top">Fecha de Comprobante: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield7">
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsOrdenCompraEntrada->OceComprobanteFecha;?>" size="15" maxlength="10" />
                   </label>
                 <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span> <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero Guia de Remisi&oacute;n:</td>
               <td align="left" valign="top"><input name="CmpGuiaRemisionNumeroSerie" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroSerie" value="<?php echo $InsOrdenCompraEntrada->OceGuiaRemisionNumeroSerie;?>" size="10" maxlength="50" />
                 -
                 <input name="CmpGuiaRemisionNumeroNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroNumero" value="<?php echo $InsOrdenCompraEntrada->OceGuiaRemisionNumeroNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top">Fecha de Guia de Remision: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield8">
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpGuiaRemisionFecha" type="text" id="CmpGuiaRemisionFecha" value="<?php echo $InsOrdenCompraEntrada->OceGuiaRemisionFecha; ?>" size="15" maxlength="10" />
                 </label>
                 <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span> <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnGuiaRemisionFecha" name="BtnGuiaRemisionFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td colspan="3" align="left" valign="top"><textarea name="CmpObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenCompraEntrada->OceObservacion;?></textarea></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="-1">&nbsp;</td>
               <td colspan="-1"></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table>
           <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr> </tr>
             <tr> </tr>
             <tr> </tr>
             <tr> </tr>
           </table>
         </div>
                  </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="2%"><input type="hidden" name="CmpOrdenCompraPedidoAccion" id="CmpOrdenCompraPedidoAccion" value="AccOrdenCompraDetalleRegistrar.php" /></td>
               <td width="48%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncOrdenCompraEntradaPedidoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/></a><a href="javascript:FncOrdenCompraPedidoEliminarTodo();"></a></td>
               <td width="1%"><div id="CapOrdenCompraPedidosResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapOrdenCompraEntradaPedidos" class="EstCapOrdenCompraEntradaPedidos" > </div></td>
               <td>&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
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
	inputField : "CmpComprobanteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteFecha"// el id del botón que  
	});
	
Calendar.setup({ 
	inputField : "CmpGuiaRemisionFecha",  // id del campo de texto 

	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnGuiaRemisionFecha"// el id del botón que  
	});
	
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var spryselect = new Spry.Widget.ValidationSelect("spryselect");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
<?php

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();


}else{
	echo ERR_GEN_101;
}
?>
