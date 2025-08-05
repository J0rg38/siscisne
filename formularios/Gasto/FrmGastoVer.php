<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGastoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGastoDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssGasto.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjGasto.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsGastoDetalle.php');

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



$InsGasto = new ClsGasto();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccGastoEditar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){


	FncGastoEstablecerMoneda

	FncGastoDetalleListar();

});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncGastoDetalleListar";


</script>

<div class="EstCapMenu">
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsGasto->GasId;?>&Su=<?php echo $InsGasto->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER COMPRAS/SERVICIOS</span></td>
      </tr>
      <tr>
        <td colspan="2">
                   <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsGasto->GasTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsGasto->GasTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
        
<ul class="tabs">
	
	<li><a href="#tab1">Comprobante de Pago</a></li>


</ul>        
  <div class="tab_container">
   
    
    <div id="tab1" class="tab_content">
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
		      <td align="left" valign="top">Codigo Interno:</td>
		      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsGasto->GasId;?>" size="15" maxlength="20" /></td>
		      <td align="left" valign="top">Fecha de Ingreso: <br />
		        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsGasto->GasFecha)){ echo date("d/m/Y");}else{ echo $InsGasto->GasFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Tipo Doc.:</td>
		      <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
		        <option value="">Escoja una opcion</option>
		        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
		        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsGasto->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
		        <?php
			}
			?>
		        </select></td>
		      <td align="left" valign="top">Num. Doc.:</td>
		      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
		        <tr>
		          <td>&nbsp;</td>
		          <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsGasto->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
		          <td>&nbsp;</td>
		          <td><div id="CapProveedorBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Proveedor:</td>
		      <td align="left" valign="top"><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsGasto->PrvNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" /></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
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
		        <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsGasto->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
		        <?php
			}
			?>
		        </select></td>
		      <td align="left" valign="top">Tipo de Operacion:</td>
		      <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
		        <option value="">Escoja una opcion</option>
		        <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
		        <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsGasto->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
		        <?php
			}
			?>
		        </select></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Numero de Comprobante:</td>
		      <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsGasto->GasComprobanteNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" />
		        -
		        <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsGasto->GasComprobanteNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
		      <td align="left" valign="top">Fecha de Comprobante: <br />
                <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php echo $InsGasto->GasComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
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
		        <option <?php if($InsGasto->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
		        <?php  
					}
					?>
		        </select></td>
		      <td align="left" valign="top">Cantidad de Dias:</td>
		      <td align="left" valign="top"><input name="CmpCantidadDia" type="text" class="EstFormularioCaja" id="CmpCantidadDia" value="<?php echo $InsGasto->GasCantidadDia;?>" size="10" maxlength="3" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Moneda:
		        <input name="CmpTipoCambio" type="hidden"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncGastoDetalleListar();" value="<?php if (empty($InsGasto->GasTipoCambio)){ echo "";}else{ echo $InsGasto->GasTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
		        <tr>
		          <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
		            <option value="">Escoja una opcion</option>
		            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
		            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsGasto->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
		            <?php
			  }
			  ?>
		            </select></td>
		          <td><div id="CapMonedaBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td align="left" valign="top">Tipo de Cambio: <br />
		        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
		      <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncGastoDetalleListar();" value="<?php if (empty($InsGasto->GasTipoCambio)){ echo "";}else{ echo $InsGasto->GasTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Impuesto (%):</td>
		      <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php echo $InsGasto->GasPorcentajeImpuestoVenta;?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Concepto:</td>
		      <td align="left" valign="top"><textarea name="CmpConcepto" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpConcepto"><?php echo $InsGasto->GasConcepto;?></textarea></td>
		      <td align="left" valign="top">Observacion:</td>
		      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsGasto->GasObservacion;?></textarea></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Total:</td>
		      <td align="left" valign="top"><input name="CmpTotal" type="text" class="EstFormularioCaja" id="CmpTotal" value="<?php echo round($InsGasto->GasTotal,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Estado: </td>
		      <td align="left" valign="top"><?php
					switch($InsGasto->GasEstado){
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
		      <td align="left" valign="top">Comprobante escaneado:</td>
		      <td colspan="3" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesGasFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesGasFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesGasFoto'.$Identificador], '.'.$extension);  
?>
		        Vista Previa:<br />
		        <img  src="subidos/gastos_fotos/<?php echo $nombre_base.".".$extension;?>" width="200" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
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
