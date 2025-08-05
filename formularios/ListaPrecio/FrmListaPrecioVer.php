<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsListaPrecioFunciones.js" ></script>

<?php
$GET_id = $_GET['Id'];

//deb($_GET);

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjListaPrecio.php');
include($InsProyecto->MtdFormulariosMsj("Producto").'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();
$InsClienteTipo = new ClsClienteTipo();

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsProducto->ProId = $GET_id;
$InsProducto = $InsProducto->MtdObtenerProducto();		
	
//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$ResProductoTipoUnidadMedidaSalida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,2,$InsProducto->RtiId);
$ArrProductoTipoUnidadMedidaSalidas = $ResProductoTipoUnidadMedidaSalida['Datos'];


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccListaPrecioEditar.php');

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];

$ResProductoTipoUnidadMedidaIngreso = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,1,$InsProducto->RtiId);	
$ArrProductoTipoUnidadMedidaIngresos = $ResProductoTipoUnidadMedidaIngreso['Datos'];

$ResProductoTipoUnidadMedidaBase = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,3,$InsProducto->RtiId);	
$ArrProductoTipoUnidadMedidaBases = $ResProductoTipoUnidadMedidaBase['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript">

$(document).ready(function (){

	
});
</script>

<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsProducto->ProId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="961" height="25"><span class="EstFormularioTitulo">VER PRODUCTO/PRECIO</span></td>
      </tr>
      <tr>
        <td>
        
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>
        
        
                                <br />



 		
<ul class="tabs">
    <li><a href="#tab1">Producto/Precio</a></li>

	
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

    
         <table border="0" cellpadding="2" cellspacing="2">
           <tr>
             <td valign="top">
             <div class="EstFormularioArea" >
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
			<span class="EstFormularioSubTitulo">
			Datos del Producto			
			<input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
			</span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProducto->ProId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Original:</td>
            <td align="left" valign="top"><input  name="CmpCodigoOriginal" type="text"  class="EstFormularioCaja" id="CmpCodigoOriginal" value="<?php echo $InsProducto->ProCodigoOriginal;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Codigo Alternativo:</td>
            <td align="left" valign="top"><input  name="CmpCodigoAlternativo" type="text"  class="EstFormularioCaja" id="CmpCodigoAlternativo" value="<?php echo $InsProducto->ProCodigoAlternativo;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProducto->ProNombre;?>" size="40" maxlength="200" readonly="readonly"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Tipo de Bien:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrProductoTipos as $DatProductoTipo){
			?>
              <option <?php echo $DatProductoTipo->RtiId;?> <?php echo ($DatProductoTipo->RtiId==$InsProducto->RtiId)?'selected="selected"':"";?> value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Impuesto (%):</td>
            <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php  echo $EmpresaImpuestoVenta; ?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Margen Adicional:<br />
              <span class="EstFormularioSubEtiqueta">(%)</span></td>
            <td align="left" valign="top"><span class="EstMonedaSimbolo">
              <input name="CmpPorcentajeAdicional" type="text" class="EstFormularioCaja" id="CmpPorcentajeAdicional" value="<?php if(empty($InsProducto->ProPorcentajeAdicional)){ echo "0.00";}else{ echo $InsProducto->ProPorcentajeAdicional; }?>" size="15" maxlength="10" readonly="readonly" />
            </span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Descuento Adicional:<br />
              <span class="EstFormularioSubEtiqueta">(%)</span></td>
            <td colspan="2" align="left" valign="top"><span class="EstMonedaSimbolo">
              <input name="CmpPorcentajeDescuento" type="text" class="EstFormularioCaja" id="CmpPorcentajeDescuento" value="<?php if(empty($InsProducto->ProPorcentajeDescuento)){ echo "0.00";}else{ echo $InsProducto->ProPorcentajeDescuento; }?>" size="15" maxlength="10" readonly="readonly" />
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Precio Promocion:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProTienePromocion){
				case 1:
					$OpcTienePromocion1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcTienePromocion2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
              <option value="">-</option>
                <option <?php echo $OpcTienePromocion1;?> value="1">Tiene promocion</option>
                <option <?php echo $OpcTienePromocion2;?> value="2">No tiene promocion</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="center" valign="top"><?php
$UnidadMedidaEquivalente = 0;
$ProductoCostoIngreso = 0;

if($InsProducto->UmeId == $InsProducto->UmeIdIngreso){

	$UnidadMedidaEquivalente = 1;

}else{

	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsProducto->UmeIdIngreso,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];

	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$UnidadMedidaEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}

}

$ProductoCostoIngreso = $InsProducto->ProCostoIngreso * $UnidadMedidaEquivalente;

?>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td colspan="6" align="center">Equivalente:
                    <input class="EstFormularioCaja" name="CmpUnidadMedidaEquivalente" type="text" id="CmpUnidadMedidaEquivalente" value="<?php echo $UnidadMedidaEquivalente;?>" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td colspan="2" align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="center">Kardex</td>
                  <td align="center">&nbsp;</td>
                  <td colspan="2" align="center">Ingreso</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">Und. Medida:</td>
                  <td align="left" valign="top"><input type="hidden" name="CmpUnidadMedidaBase" id="CmpUnidadMedidaBase" value="<?php echo $InsProducto->UmeId;?>" />
                    <select name="CmpUnidadMedidaBaseAux" id="CmpUnidadMedidaBaseAux" class="EstFormularioCombo" disabled="disabled">
                      <option value="">Escoja una opcion</option>
                      <?php
								foreach($ArrProductoTipoUnidadMedidaBases as $DatProductoTipoUnidadMedidaBase){
								?>
                      <option value="<?php echo $DatProductoTipoUnidadMedidaBase->UmeId?>" <?php echo ($DatProductoTipoUnidadMedidaBase->UmeId==$InsProducto->UmeId)?'selected="selected"':''; ?> ><?php echo $DatProductoTipoUnidadMedidaBase->UmeNombre;?></option>
                      <?php
								}
								?>
                    </select></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Und. Medida:</td>
                  <td align="left" valign="top"><input type="hidden" name="CmpUnidadMedidaIngreso" id="CmpUnidadMedidaIngreso" value="<?php echo $InsProducto->UmeIdIngreso;?>" />
                    <select name="CmpUnidadMedidaIngresoAux" id="CmpUnidadMedidaIngresoAux" class="EstFormularioCombo" disabled="disabled">
                      <option value="">Escoja una opcion</option>
                      <?php
								foreach($ArrProductoTipoUnidadMedidaIngresos as $DatProductoTipoUnidadMedidaIngreso){
								?>
                      <option value="<?php echo $DatProductoTipoUnidadMedidaIngreso->UmeId?>" <?php echo ($DatProductoTipoUnidadMedidaIngreso->UmeId==$InsProducto->UmeIdIngreso)?'selected="selected"':''; ?> ><?php echo $DatProductoTipoUnidadMedidaIngreso->UmeNombre;?></option>
                      <?php
								}
								?>
                    </select></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">Costo:<br />
                    (Sin IGV)</td>
                  <td align="left" valign="top"><input name="CmpCosto" type="text" class="EstFormularioCaja" id="CmpCosto" value="<?php echo number_format($InsProducto->ProCosto,2);?>" size="8" maxlength="15" readonly="readonly" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Costo:</td>
                  <td align="left" valign="top"><input name="CmpCostoIngreso" type="text" class="EstFormularioCaja" id="CmpCostoIngreso" value="<?php echo number_format($ProductoCostoIngreso,2);?>" size="8" maxlength="15" readonly="readonly" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5" align="left" valign="top">
            
            
            <table border="0" cellpadding="2" cellspacing="2">                  
  
<?php
	$Ubicacion = 1;
	
foreach($ArrClienteTipos as $DatClienteTipo){
?>        
                    
                       
  
    <tr>
      <td align="right" bgcolor="#999999">
        
        <span title="<?php echo $DatClienteTipo->LtiId;?>"><?php echo $DatClienteTipo->LtiNombre;?></span>
        
        
             <span class="EstFormularioSubEtiqueta">
(<?php echo ($DatClienteTipo->LtiId);?>)
</span>

        </td>
      <td>&nbsp;</td>
      
    <?php
    foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){

//		$UnidadMedidaEquivalente = 0;
//		
//		if($InsProducto->UmeId == $DatProductoTipoUnidadMedidaSalida->UmeId){
//			$UnidadMedidaEquivalente = 1;
//		}else{
//			$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$DatProductoTipoUnidadMedidaSalida->UmeId,$InsProducto->UmeId);
//			$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
//		
//			foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
//				$UnidadMedidaEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
//			}
//		}
		
    ?>
		<?php
        //if(!empty($UnidadMedidaEquivalente)){
        ?>
        
          <td>&nbsp;</td>
          <td align="center">
            <span title="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>">
            <?php echo $DatProductoTipoUnidadMedidaSalida->UmeNombre;?>
            </span>
          </td>
          
        <?php	
        //}
        ?>
    <?php
    }
    ?>
      
    </tr>
    <tr>
      <td>Equivalente</td>
      <td>:</td>

    <?php
    foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
	
		//MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL)
		$InsListaPrecio = new ClsListaPrecio();
		$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
		$ArrListaPrecios = $ResListaPrecio['Datos'];
		
		
		$ListaPrecioId = 0;
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioId = $DatListaPrecio->LprId;
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}

    ?>

  
		<td>-</td>
		<td align="center">
        
        
<input type="hidden" name="CmpListaPrecioId_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" id="CmpListaPrecioId_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo $ListaPrecioId;?>" />

<input type="hidden" name="CmpListaPrecioUso_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" id="CmpListaPrecioUso_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo $DatClienteTipo->LtiUso;?>" />

<!--<input etiqueta="equivalente" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" name="CmpListaPrecioEquivalente_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioEquivalente_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php //echo ($UnidadMedidaEquivalente);?>" size="8" maxlength="15" />-->

<input name="CmpListaPrecioEquivalente_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioEquivalente_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo ($ListaPrecioEquivalente);?>" size="8" maxlength="15" readonly="readonly" etiqueta="equivalente" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" />


		</td>

	<?php
	}
	?>
    </tr>
    <tr>
      <td>Costo</td>
      <td>:</td>
<?php
foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>

<?php	
		
		$InsListaPrecio = new ClsListaPrecio();
		$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
		$ArrListaPrecios = $ResListaPrecio['Datos'];
		
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
	
?>

    
<td>-</td>
<td align="center">


<input name="CmpListaPrecioCosto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioCosto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo ($ListaPrecioCosto)?>" size="8" maxlength="15" readonly="readonly" etiqueta="costo" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" />


</td>

<?php
}
?>

    </tr>
    
    
    
    
    
    
    
    
    
    <tr>
      <td>Otros Costos
      
      <span class="EstFormularioSubEtiqueta">
          (<?php echo number_format($DatClienteTipo->LtiPorcentajeOtroCosto,2);?>%)
  </span>
  
  </td>
      <td>:</td>
      
      
      
      
  <?php
foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
      
  <?php
	
		$InsListaPrecio = new ClsListaPrecio();
		$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
		$ArrListaPrecios = $ResListaPrecio['Datos'];
		
		
		$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
		
    ?>        
      
      <td>-</td>
      <td width="160" align="center">

<input name="CmpListaPrecioPorcentajeOtroCosto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="hidden"  id="CmpListaPrecioPorcentajeOtroCosto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo number_format($ListaPrecioPorcentajeOtroCosto,2);?>" size="10" maxlength="10" readonly="readonly"  etiqueta="porcentaje_otro_costo" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" />
        
  <input class="EstFormularioCajaDeshabilitada" name="CmpListaPrecioOtroCosto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" id="CmpListaPrecioOtroCosto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo $ListaPrecioOtroCosto;?>" size="8" maxlength="15" />
        
        
     
        
        </td>
      
      
  <?php
}
?>
      
      
      
    </tr>
    
    <tr>
      <td> Utilidad <span class="EstFormularioSubEtiqueta">
        (<?php echo number_format($DatClienteTipo->LtiPorcentajeMargenUtilidad,2);?>%)
        </span>
        
        
        </td>
      <td>:</td>
      
      
      
      <?php
foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
      
      <?php

	$InsListaPrecio = new ClsListaPrecio();
	$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
	$ArrListaPrecios = $ResListaPrecio['Datos'];
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		$ListaPrecioPorcentajeManoObra = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		$ListaPrecioManoObra = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				$ListaPrecioPorcentajeManoObra = $DatListaPrecio->LprPorcentajeManoObra;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				$ListaPrecioManoObra = $DatListaPrecio->LprManoObra;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
		
    ?>   
      
      <td>-</td>
      <td width="160" align="center">
        
        <input name="CmpListaPrecioPorcentajeUtilidad_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="hidden" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioPorcentajeUtilidad_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo number_format($ListaPrecioPorcentajeUtilidad,2);?>" size="10" maxlength="10" readonly="readonly" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" etiqueta="porcentaje_utilidad" />
        
        
        
        
        <input name="CmpListaPrecioUtilidad_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId; ?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioUtilidad_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId; ?>" value="<?php echo number_format($ListaPrecioUtilidad,2);?>" size="8" maxlength="15" readonly="readonly" />
        
        </td>
      
      <?php
}
?>
      
    </tr>
    <tr>
      <td>Mano Obra <span class="EstFormularioSubEtiqueta"> (<?php echo number_format($DatClienteTipo->LtiPorcentajeManoObra,2);?>%) </span></td>
      <td>&nbsp;</td>
      
      
      
      
      
      
      <?php
foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
      
      <?php

	$InsListaPrecio = new ClsListaPrecio();
	$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
	$ArrListaPrecios = $ResListaPrecio['Datos'];
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		$ListaPrecioPorcentajeManoObra = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		$ListaPrecioManoObra = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				$ListaPrecioPorcentajeManoObra = $DatListaPrecio->LprPorcentajeManoObra;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				$ListaPrecioManoObra = $DatListaPrecio->LprManoObra;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
		
    ?>   
      
    
      <td>&nbsp;</td>
      <td align="center">
      
      
      <input name="CmpListaPrecioPorcentajeManoObra_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="hidden" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioPorcentajeManoObra_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo number_format($ListaPrecioPorcentajeManoObra,2);?>" size="10" maxlength="10" readonly="readonly" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" etiqueta="porcentaje_manoobra" />
        
        
        
        
        <input name="CmpListaPrecioManoObra_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId; ?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioManoObra_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId; ?>" value="<?php echo number_format($ListaPrecioManoObra,2);?>" size="8" maxlength="15" readonly="readonly" />
        
        </td>
      
      <?php
}
?>


    </tr>
    <tr>
      <td>Valor de Venta:</td>
      <td>:</td>
      
      
      <?php
    foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
      
  <?php

		$InsListaPrecio = new ClsListaPrecio();
		$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
		$ArrListaPrecios = $ResListaPrecio['Datos'];
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
    ?> 
      
      
      <td>-</td>
      <td width="160" align="center">
        
  <input  name="CmpListaPrecioValorVenta_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioValorVenta_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo ($ListaPrecioValorVenta);?>" size="8" maxlength="15" readonly="readonly" etiqueta="valor_venta" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" /></td>
      
      <?php
    }
    ?>
      
      
    </tr>
    <tr>
      <td>Impuesto</td>
      <td>:</td>
      
      <?php
    foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
      
  <?php

		$InsListaPrecio = new ClsListaPrecio();
		$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
		$ArrListaPrecios = $ResListaPrecio['Datos'];
		
		$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
	
    ?> 
      
      
      <td>-</td>
      <td width="160" align="center">
        
  <input name="CmpListaPrecioImpuesto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioImpuesto_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo number_format($ListaPrecioImpuesto,2);?>" size="8" maxlength="15" readonly="readonly" />
        
  </td>
      
      <?php
    }
    ?>
      
    </tr>
    <tr>
      <td bgcolor="#F0F0F0">% Adicional</td>
      <td bgcolor="#F0F0F0">:</td>
     
     
       
            
<?php
foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>

<?php

	$InsListaPrecio = new ClsListaPrecio();
	$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
	$ArrListaPrecios = $ResListaPrecio['Datos'];
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
		
    ?>   
                          
   
  
      <td bgcolor="#F0F0F0">&nbsp;</td>
      <td align="center" bgcolor="#F0F0F0">
      
      <input class="EstFormularioCaja" name="CmpListaPrecioPorcentajeAdicional_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" id="CmpListaPrecioPorcentajeAdicional_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo number_format($ListaPrecioPorcentajeAdicional,2);?>" size="8" maxlength="10" readonly="readonly"  cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" etiqueta="porcentaje_adicional" />
      
      </td>
      
<?php
}
?>
      
      
      
      
    </tr>
    <tr>
      <td >Adicional</td>
      <td >:</td>
      
      
        
            
<?php
foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>

<?php

	$InsListaPrecio = new ClsListaPrecio();
	$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
	$ArrListaPrecios = $ResListaPrecio['Datos'];
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
		
    ?>   
                          
   
      <td>&nbsp;</td>
      <td align="center">
      
      <input name="CmpListaPrecioPorcentajeAdicional2_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="hidden" id="CmpListaPrecioPorcentajeAdicional2_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo number_format($ListaPrecioPorcentajeAdicional,2);?>" size="10" maxlength="10" readonly="readonly"  cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>"  />
      
      
      
      
      
      
      
      
      <input name="CmpListaPrecioAdicional_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId; ?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioAdicional_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId; ?>" value="<?php echo number_format($ListaPrecioAdicional,2);?>" size="8" maxlength="15" readonly="readonly" />
      
      
      </td>
      
<?php
}
?>
      
      
      
    </tr>
    <tr>
      <td bgcolor="#F0F0F0">% Descuento</td>
      <td bgcolor="#F0F0F0">:</td>
      
      
            <?php
    foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
      
  <?php

		$InsListaPrecio = new ClsListaPrecio();
		$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
		$ArrListaPrecios = $ResListaPrecio['Datos'];
		
		$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
	
    ?> 
      
      
<td bgcolor="#F0F0F0">-</td>
      <td align="center" bgcolor="#F0F0F0"><input class="EstFormularioCaja"  name="CmpListaPrecioPorcentajeDescuento_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text"  id="CmpListaPrecioPorcentajeDescuento_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo ($ListaPrecioPorcentajeDescuento);?>" size="8" maxlength="10" readonly="readonly" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" etiqueta="porcentaje_descuento"  /></td>
      
      
      <?php
    }
    ?>
      
      
      
      
      
      
      
    </tr>
    <tr>
      <td>Descuento</td>
      <td>:</td>
      
      
      
      <?php
foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
      
  <?php

	$InsListaPrecio = new ClsListaPrecio();
	$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
	$ArrListaPrecios = $ResListaPrecio['Datos'];
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
		
    ?>   
      
      
      <td>-</td>
      <td align="center">
        
        <input  name="CmpListaPrecioPorcentajeDescuento2_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="hidden"  id="CmpListaPrecioPorcentajeDescuento2_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo ($ListaPrecioPorcentajeDescuento);?>" size="10" maxlength="10" readonly="readonly" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>"   />
        
        
        
        
        
        
        
        
        <input  name="CmpListaPrecioDescuento_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpListaPrecioDescuento_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo ($ListaPrecioDescuento);?>" size="8" maxlength="15" readonly="readonly"  />
        
        
        
        </td>
      
  <?php
}
?> 
      
      
      
      
      
      
      
      
    </tr>
    <tr>
      <td>Precio Venta</td>
      <td>:</td>
    <?php

    foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
?>
		
<?php
		$InsListaPrecio = new ClsListaPrecio();
		$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','ASC','1',$InsProducto->ProId,$DatClienteTipo->LtiId,$DatProductoTipoUnidadMedidaSalida->UmeId);
		$ArrListaPrecios = $ResListaPrecio['Datos'];
		
		
			$ListaPrecioEquivalente = 0;
		$ListaPrecioCosto = 0;
		
		$ListaPrecioPorcentajeOtroCosto = 0;
		$ListaPrecioPorcentajeUtilidad = 0;
		$ListaPrecioPorcentajeAdicional = 0;
		$ListaPrecioPorcentajeDescuento = 0;
		
		$ListaPrecioOtroCosto = 0;
		$ListaPrecioUtilidad = 0;
		$ListaPrecioAdicional = 0;
		
		$ListaPrecioValorVenta = 0;
		$ListaPrecioImpuesto = 0;
		$ListaPrecioDescuento = 0;
		$ListaPrecioPrecio = 0;
		
		if(!empty($ArrListaPrecios)){
			foreach($ArrListaPrecios as $DatListaPrecio){
				
				$ListaPrecioEquivalente = $DatListaPrecio->LprEquivalente;
				$ListaPrecioCosto = $DatListaPrecio->LprCosto;
				
				$ListaPrecioPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
				$ListaPrecioPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
				$ListaPrecioPorcentajeAdicional = $DatListaPrecio->LprPorcentajeAdicional;
				$ListaPrecioPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;
				
				$ListaPrecioOtroCosto = $DatListaPrecio->LprOtroCosto;
				$ListaPrecioUtilidad = $DatListaPrecio->LprUtilidad;
				$ListaPrecioAdicional = $DatListaPrecio->LprAdicional;
				
				$ListaPrecioValorVenta = $DatListaPrecio->LprValorVenta;
				$ListaPrecioImpuesto = $DatListaPrecio->LprImpuesto;
				$ListaPrecioDescuento = $DatListaPrecio->LprDescuento;
				$ListaPrecioPrecio = $DatListaPrecio->LprPrecio;
				
			}
		}
		
	
    ?>                            
     
      <td>-</td>
      <td align="center">
      
<input  name="CmpListaPrecioPrecio_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" type="text" class="EstFormularioCaja" id="CmpListaPrecioPrecio_<?php echo $DatClienteTipo->LtiId;?>_<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" value="<?php echo ($ListaPrecioPrecio);//echo number_format($ListaPrecioPrecio,2);?>" size="8" maxlength="15" readonly="readonly" ubicacion="<?php echo $Ubicacion;?>" etiqueta="precio" cliente_tipo="<?php echo $DatClienteTipo->LtiId;?>" unidad_medida="<?php echo $DatProductoTipoUnidadMedidaSalida->UmeId;?>" /></td>

    <?php
		
    }
    ?>                           
      
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    
    <?php
    foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
		
		
    ?>
        
    
      <td>&nbsp;</td>
      <td width="160" align="center">-</td>
      
   
    <?php
    }
    ?>                  
    </tr>
  






<?php
	
	$Ubicacion++;

}
?>  
                        
        </table>
        
        
        </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
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
        <td align="center">&nbsp;</td>
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
