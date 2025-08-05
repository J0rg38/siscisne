<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaCostoVinculadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaAutocompletar.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenMovimientoEntrada.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenMovimientoEntrada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');



require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');



$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador])){	
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenMovimientoEntradaEditar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];

?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){

	FncAlmacenMovimientoEntradaEstablecerDocumentoOrigen();

	FncAlmacenMovimientoEntradaEstablecerMoneda

	FncAlmacenMovimientoEntradaDetalleListar();

	FncAlmacenMovimientoEntradaCostoVinculadoListar();

});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncAlmacenMovimientoEntradaDetalleListar";

var AlmacenMovimientoEntradaDetalleEditar = 2;
var AlmacenMovimientoEntradaDetalleEliminar = 2;

</script>

<div class="EstCapMenu">
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsAlmacenMovimientoEntrada->AmoId;?>&Su=<?php echo $InsAlmacenMovimientoEntrada->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER ENTRADA A ALMACEN</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Entrada a Almacen</a></li>
	<li><a href="#tab2">Comprobante de Pago</a></li>
    <li><a href="#tab3">Costos Vinculados</a></li>

</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoEntrada->AmoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoEntrada->AmoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
   
        
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Entrada a Almacen
                 
                 
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
               <td align="center">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacenMovimientoEntrada->AmoId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Ingreso: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoFecha)){ echo date("d/m/Y");}else{ echo $InsAlmacenMovimientoEntrada->AmoFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsAlmacenMovimientoEntrada->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
                 </select></td>
               <td align="left" valign="top">Ord. Compra:</td>
               <td align="left" valign="top"><input name="CmpOrdenCompra" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpOrdenCompra" value="<?php  echo $InsAlmacenMovimientoEntrada->OcoId;  ?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero Guia de Remisi&oacute;n:</td>
               <td align="left" valign="top"><input name="CmpGuiaRemisionNumeroSerie" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroSerie" value="<?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" />
                 -
                 <input name="CmpGuiaRemisionNumeroNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroNumero" value="<?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Guia de Remision: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpGuiaRemisionFecha" type="text" class="EstFormularioCajaFecha" id="CmpGuiaRemisionFecha" value="<?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Guia Remision Escaneada:</td>
               <td colspan="3" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesAmoGuiaRemisionFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesAmoGuiaRemisionFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesAmoGuiaRemisionFoto'.$Identificador], '.'.$extension);  
?>
		        
		        Vista Previa:<br />
		        
		        <img  src="subidos/almacen_movimiento_entrada_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" height="200" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  <?php	
}else{
?>
		        No hay FOTO
  <?php	
}
?>
		        
		        
  </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAlmacenMovimientoEntrada->AmoObservacion;?></textarea></td>
               <td align="left" valign="top">Almacen Destino:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsAlmacenMovimientoEntrada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsAlmacenMovimientoEntrada->AmoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
					
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
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
               <td width="49%"><span class="EstFormularioSubTitulo">PRODUCTOS	</span></td>
               <td width="49%">&nbsp;</td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td align="right"><a href="javascript:FncAlmacenMovimientoEntradaDetalleListar();">
                 <input type="hidden" name="CmpAlmacenMovimientoEntradaDetalleAccion" id="CmpAlmacenMovimientoEntradaDetalleAccion" value="AccAlmacenMovimientoEntradaDetalleRegistrar.php" />
                 <img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a></td>
               <td><div id="CapAlmacenMovimientoEntradaDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapAlmacenMovimientoEntradaDetalles" class="EstCapAlmacenMovimientoEntradaDetalles" > </div></td>
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
    
    
    <div id="tab2" class="tab_content">
      <!--Content-->
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top"><div class="EstFormularioArea">
		  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago </span></td>
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
		      <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
		        <option value="">Escoja una opcion</option>
		        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
		        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
		        <?php
			}
			?>
		        </select>
		        :</td>
		      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
		        <tr>
		          <td>&nbsp;</td>
		          <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
		          <td>&nbsp;</td>
		          <td><div id="CapProveedorBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td align="left" valign="top">Proveedor:</td>
		      <td align="left" valign="top"><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Tipo de Comprobante:</td>
		      <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
		        <option value="">Escoja una opcion</option>
		        <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
		        <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsAlmacenMovimientoEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
		        <?php
			}
			?>
		        </select></td>
		      <td align="left" valign="top">Origen:</td>
		      <td align="left" valign="top"><?php
					switch($InsAlmacenMovimientoEntrada->AmoDocumentoOrigen){
						case 1:
							$OpcDocumentoOrigen1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcDocumentoOrigen2 = 'selected = "selected"';						
						break;
						
						

					}
					?>
                <select  disabled="disabled" class="EstFormularioCombo" name="CmpDocumentoOrigen" id="CmpDocumentoOrigen">
                        <option <?php echo $OpcDocumentoOrigen1;?> value="1">Nacional</option>
                        <option <?php echo $OpcDocumentoOrigen2;?> value="2">Internacional</option>
                </select></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Numero de Comprobante:</td>
		      <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" />
		        -
		        <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
		      <td align="left" valign="top">Fecha de Comprobante: <br />
                <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Condicion de Pago:</td>
		      <td align="left" valign="top"><select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" disabled="disabled" >
		        <option value="">Escoja una opcion</option>
		        <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
		        <option <?php if($InsAlmacenMovimientoEntrada->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
		        <?php  
					}
					?>
		        </select></td>
		      <td align="left" valign="top">Cantidad de Dias:</td>
		      <td align="left" valign="top"><input name="CmpCantidadDia" type="text" class="EstFormularioCaja" id="CmpCantidadDia" value="<?php echo $InsAlmacenMovimientoEntrada->AmoCantidadDia;?>" size="10" maxlength="3" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Moneda:
		        <input name="CmpTipoCambio" type="hidden"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncAlmacenMovimientoEntradaDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoEntrada->AmoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
		        <tr>
		          <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
		            <option value="">Escoja una opcion</option>
		            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
		            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
		            <?php
			  }
			  ?>
		            </select></td>
		          <td><div id="CapMonedaBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td align="left" valign="top">Tipo de Cambio: <br />
		        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
		      <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncAlmacenMovimientoEntradaDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoEntrada->AmoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Comprobante escaneado:</td>
		      <td colspan="3" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesAmoFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesAmoFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesAmoFoto'.$Identificador], '.'.$extension);  
?>
		        Vista Previa:<br />
		        <img  src="subidos/almacen_movimiento_entrada_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" height="200" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
		        <?php	
}else{
?>
		        No hay FOTO
		        <?php	
}
?></td>
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
		    </table>
		  </div>
        
        
        </td>
    </tr>
    </table>
    </div>
    
    
            <div id="tab3" class="tab_content">
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
                  <div class="EstFormularioArea">
     <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
     <tr>
       <td></td>
       <td colspan="5"><span class="EstFormularioSubTitulo">Costos Vinculados</span></td>
       <td></td>
     </tr>
     <tr>
       <td></td>
       <td align="left">&nbsp;</td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
     </tr>
     <tr>
       <td></td>
       <td colspan="5" align="left">
               <div id="CapCostoInternacionales">
        
			<table border="0" cellpadding="2" cellspacing="2">
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
			<tr>
			  <td>COSTOS INTERNACIONALES</td>
			  <td align="center">Num. Comprob.</td>
			  <td align="center">Monto</td>
			  <td align="center">Moneda</td>
			  <td align="center">Tipo Doc.</td>
			  <td align="center">Num. Documento</td>
			  <td align="center">Proveedor</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Aduana Internacional:</td>
			  <td><input name="CmpInternacionalNumeroComprobante1" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante1" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante1;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalAduana" type="text" class="EstFormularioCaja" id="CmpTotalAduana"  value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId1" id="CmpInternacionalMonedaId1">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento1" id="CmpInternacionalProveedorTipoDocumento1">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional1)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><label for="CmpInternacionalProveedorNumeroDocumento1"></label>
			    <input name="CmpInternacionalProveedorId1" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId1" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional1;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento1" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento1" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional1;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre1" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre1" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional1;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Transporte:</td>
			  <td><input name="CmpInternacionalNumeroComprobante2" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante2" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante2;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalTransporte" type="text" class="EstFormularioCaja" id="CmpTotalTransporte" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId2" id="CmpInternacionalMonedaId2">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento2" id="CmpInternacionalProveedorTipoDocumento2">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional2)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId2" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional2;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento2" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional2;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre2" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional2;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Desestiba:</td>
			  <td><input name="CmpInternacionalNumeroComprobante3" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante3" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante3;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalDesestiba" type="text" class="EstFormularioCaja" id="CmpTotalDesestiba"  value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId3" id="CmpInternacionalMonedaId3">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled" class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento3" id="CmpInternacionalProveedorTipoDocumento3">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional3)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId3" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional3;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento3" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional3;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre3" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional3;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Almacenaje:</td>
			  <td><input name="CmpInternacionalNumeroComprobante4" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante4" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante4;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalAlmacenaje" type="text" class="EstFormularioCaja" id="CmpTotalAlmacenaje"  value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled" class="EstFormularioCombo" name="CmpInternacionalMonedaId4" id="CmpInternacionalMonedaId4">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled" class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento4" id="CmpInternacionalProveedorTipoDocumento4">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional4)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId4" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId4" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional4;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento4" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento4" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional4;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre4" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre4" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional4;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Ad Valorem:</td>
			  <td><input name="CmpInternacionalNumeroComprobante5" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante5" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante5;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalAdValorem" type="text" class="EstFormularioCaja" id="CmpTotalAdValorem" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId5" id="CmpInternacionalMonedaId5">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento5" id="CmpInternacionalProveedorTipoDocumento5">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional5)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId5" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId5" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional5;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento5" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento5" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional5;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre5" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre5" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional5;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Aduana Nacional:</td>
			  <td><input name="CmpInternacionalNumeroComprobante6" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante6" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante6;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalAduanaNacional" type="text" class="EstFormularioCaja" id="CmpTotalAduanaNacional"  value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId6" id="CmpInternacionalMonedaId6">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento6" id="CmpInternacionalProveedorTipoDocumento6">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional6)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId6" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId6" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional6;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento6" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento6" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional6;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre6" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre6" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional6;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Gastos Administrativos:</td>
			  <td><input name="CmpInternacionalNumeroComprobante7" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante7" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante7;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalGastoAdministrativo" type="text" class="EstFormularioCaja" id="CmpTotalGastoAdministrativo" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId7" id="CmpInternacionalMonedaId7">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled" class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento7" id="CmpInternacionalProveedorTipoDocumento7">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional7)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId7" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId7" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional7;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento7" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento7" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional7;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre7" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre7" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional7;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Otros Costos 1:</td>
			  <td><input name="CmpInternacionalNumeroComprobante8" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante8" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante8;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalOtroCosto1" type="text" class="EstFormularioCaja" id="CmpTotalOtroCosto1" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId8" id="CmpInternacionalMonedaId8">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento8" id="CmpInternacionalProveedorTipoDocumento8">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional8)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId8" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId8" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional8;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento8" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento8" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional8;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre8" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre8" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional8;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Otros Costos 2:</td>
			  <td><input name="CmpInternacionalNumeroComprobante9" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante9" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante9;?>" size="20" maxlength="20" readonly="readonly" /></td>
			  <td align="left" class="EstFormulario"><input name="CmpTotalOtroCosto2" type="text" class="EstFormularioCaja" id="CmpTotalOtroCosto2"value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpInternacionalMonedaId9" id="CmpInternacionalMonedaId9">
			    <option value="">Escoja una opcion</option>
			    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
			    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
			    <?php
			  }
			  ?>
			    </select></td>
			  <td><select disabled="disabled" class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento9" id="CmpInternacionalProveedorTipoDocumento9">
			    <option value="">Escoja una opcion</option>
			    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
			    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional9)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
			    <?php
			}
			?>
			    </select></td>
			  <td><input name="CmpInternacionalProveedorId9" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId9" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional9;?>" size="20" maxlength="20" />
			    <input name="CmpInternacionalProveedorNumeroDocumento9" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento9" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional9;?>" size="20" maxlength="20" /></td>
			  <td><input name="CmpInternacionalProveedorNombre9" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre9" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional9;?>" size="50" maxlength="100" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td align="left" class="EstFormulario">Total Importacion:</td>
			  <td class="EstFormulario">&nbsp;</td>
			  <td class="EstFormulario"><input class="EstFormularioCaja" name="CmpTotalImportacion" type="text" id="CmpTotalImportacion" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoTotalImportacion)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoTotalImportacion,2);}?>" size="10" maxlength="5" readonly="readonly" /></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          </tr>
              
              </table>
              
              </div>
       </td>
       <td></td>
     </tr>
     <tr>
       <td></td>
       <td align="left">&nbsp;</td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
     </tr>
     <tr>
       <td></td>
       <td colspan="5" align="left">
       
       <div id="CapCostoNacionales">
           
           
           <table border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td>COSTOS NACIONALES</td>
    <td align="center">Num. Comprob.</td>
    <td align="center">Monto</td>
    <td align="center">Moneda</td>
    <td align="center">Tipo Doc.</td>
    <td align="center">Num. Documento</td>
    <td align="center">Proveedor</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="EstFormulario">Recargo:</td>
    <td align="center">-</td>
    <td align="left" class="EstFormulario"><input name="CmpTotalRecargo" type="text" class="EstFormularioCaja" id="CmpTotalRecargo" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo,2);}?>" size="10" maxlength="10" readonly="readonly" /></td>
    <td align="center">-</td>
    <td align="center">-</td>
    <td align="center">-</td>
    <td align="center">-</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="EstFormulario">Flete:</td>
    <td><input name="CmpNacionalNumeroComprobante2" type="text" class="EstFormularioCaja" id="CmpNacionalNumeroComprobante2" value="<?php echo $InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante2;?>" size="20" maxlength="20" readonly="readonly" /></td>
    <td align="left" class="EstFormulario"><input name="CmpTotalFlete" type="text" class="EstFormularioCaja" id="CmpTotalFlete" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete,2);}?>" size="10" maxlength="10" readonly="readonly" /></td>
    <td><select  disabled="disabled" class="EstFormularioCombo" name="CmpNacionalMonedaId2" id="CmpNacionalMonedaId2">
      <option value="">Escoja una opcion</option>
      <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
      <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
      <?php
			  }
			  ?>
    </select></td>
    <td><select disabled="disabled" class="EstFormularioCombo" name="CmpNacionalProveedorTipoDocumento2" id="CmpNacionalProveedorTipoDocumento2">
      <option value="">Escoja una opcion</option>
      <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
      <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdNacional2)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
      <?php
			}
			?>
    </select></td>
    <td><input name="CmpNacionalProveedorId2" type="hidden" class="EstFormularioCaja" id="CmpNacionalProveedorId2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdNacional2;?>" size="20" maxlength="20" />
      <input name="CmpNacionalProveedorNumeroDocumento2" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNumeroDocumento2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoNacional2;?>" size="20" maxlength="20" readonly="readonly" /></td>
    <td><input name="CmpNacionalProveedorNombre2" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNombre2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreNacional2;?>" size="50" maxlength="100" readonly="readonly" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="53" class="EstFormulario">Otro Costo Nacional:</td>
    <td><input name="CmpNacionalNumeroComprobante3" type="text" class="EstFormularioCaja" id="CmpNacionalNumeroComprobante3" value="<?php echo $InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante3;?>" size="20" maxlength="20" readonly="readonly" /></td>
    <td align="left" class="EstFormulario"><input  name="CmpTotalOtroCosto" type="text" class="EstFormularioCaja" id="CmpTotalOtroCosto" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto,2);}?>" size="10" maxlength="10" readonly="readonly" /></td>
    <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpNacionalMonedaId3" id="CmpNacionalMonedaId3">
      <option value="">Escoja una opcion</option>
      <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
      <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
      <?php
			  }
			  ?>
    </select></td>
    <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpNacionalProveedorTipoDocumento3" id="CmpNacionalProveedorTipoDocumento3">
      <option value="">Escoja una opcion</option>
      <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
      <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdNacional3)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
      <?php
			}
			?>
    </select></td>
    <td><input name="CmpNacionalProveedorId3" type="hidden" class="EstFormularioCaja" id="CmpNacionalProveedorId3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdNacional3;?>" size="20" maxlength="20" />
      <input name="CmpNacionalProveedorNumeroDocumento3" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNumeroDocumento3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoNacional3;?>" size="20" maxlength="20" readonly="readonly" /></td>
    <td><input name="CmpNacionalProveedorNombre3" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNombre3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreNacional3;?>" size="50" maxlength="100" readonly="readonly" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">Flete escaneado:</td>
    <td colspan="3" align="left" valign="top">
    
    <?php              
              
if(!empty($_SESSION['SesAmoNacionalFoto2'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesAmoNacionalFoto2'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesAmoNacionalFoto2'.$Identificador], '.'.$extension);  
?>
		        Vista Previa:<br />
		        <img  src="subidos/almacen_movimiento_entrada_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" height="200" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
		        <?php	
}else{
?>
		        No hay FOTO
		        <?php	
}
?>

</td>
    <td align="left" valign="top">Otro Costo escaneado</td>
    <td colspan="2" align="left" valign="top">
    
      <?php              
              
if(!empty($_SESSION['SesAmoNacionalFoto3'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesAmoNacionalFoto3'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesAmoNacionalFoto3'.$Identificador], '.'.$extension);  
?>
		        Vista Previa:<br />
		        <img  src="subidos/almacen_movimiento_entrada_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" height="200" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
		        <?php	
}else{
?>
		        No hay FOTO
		        <?php	
}
?>


</td>
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
       <td></td>
     </tr>
     <tr>
       <td></td>
       <td align="left">&nbsp;</td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
     </tr>
     <tr>
       <td></td>
       <td colspan="5" align="left"><div class="EstFormularioArea" >
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
           <tr>
             <td>&nbsp;</td>
             <td colspan="2"><div class="EstFormularioAccion" id="CapCostoVinculadoAccion">Listo
               para registrar elementos</div></td>
             <td>&nbsp;</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td><span class="EstFormularioSubTitulo"> Elementos que componen los costos vinculados de la ENTRADA A ALMACEN</span></td>
             <td align="right"><a href="javascript:FncAlmacenMovimientoEntradaCostoVinculadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a></td>
             <td>&nbsp;</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td colspan="2"><div id="CapAlmacenMovimientoEntradaCostoVinculados" class="EstCapAlmacenMovimientoEntradaCostoVinculados" > </div></td>
             <td><div id="CapAlmacenMovimientoEntradaCostoVinculadosResultado"> </div></td>
             </tr>
           </table>
         </div></td>
       <td></td>
     </tr>
     <tr>
       <td></td>
       <td align="left">&nbsp;</td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td>
         
       </td>
     </tr>
     </table>

    </div>
              
		</td>
	</tr>
	</table>
    
    
    </div>
    
    
    
    <div>		
 
 
        
        
        
          
       

           
  
        
        
        
        
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
