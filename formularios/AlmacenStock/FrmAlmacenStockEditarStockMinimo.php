<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenStock.css');
</style>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenStockEditarStockMinimoFunciones.js" ></script>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
$GET_id = $_GET['Id'];
$GET_Sucursal = $_GET['Sucursal'];
$GET_Almacen = $_GET['Almacen'];
$GET_Ano = $_GET['Ano'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenStock = new ClsAlmacenStock();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenStockEditarStockMinimo.php');



//MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL)


//$ResAlmacenMovimientoEntradaDetalle = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,NULL,NULL,3,$InsAlmacenStock->ProId,"2015-01-01");
//$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];
//
////MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL) 
//
////MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
//$ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',NULL,NULL,3,$InsAlmacenStock->ProId,NULL,NULL,NULL,"2015-01-01");
//$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];
//
////
////$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmoFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL) 

//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno)


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"SucNombre","ASC",NULL,$GET_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];

//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',s$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno) 
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"AstStock","DESC",NULL,"1",NULL,$GET_Ano."-01-01",date("Y-m-d"),NULL,NULL,NULL,$InsAlmacenStock->ProId,NULL,NULL,false,$GET_Sucursal,$GET_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

$StockReal = 0;

if(!empty($ArrAlmacenStocks)){
	foreach($ArrAlmacenStocks as $DatAlmacenStock){
		$StockReal = $DatAlmacenStock->AstStockReal;
	}
}

?>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">


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
	
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR STOCK MINIMO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       

         <br />
    
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td><div class="EstFormularioArea">
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td width="1">&nbsp;</td>
                  <td width="110">&nbsp;</td>
                  <td colspan="3"><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td width="1">&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>C&oacute;digo:</td>
                  <td width="240" align="left"><input name="CmpProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoId" value="<?php echo $InsAlmacenStock->ProId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td width="107" align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Cod. Original:</td>
                  <td align="left"><input name="CmpProductoCodigoOriginal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoCodigoOriginal" value="<?php echo $InsAlmacenStock->ProCodigoOriginal;?>" size="20" maxlength="20" readonly="readonly" /></td>
                  <td>Sucursal:</td>
                  <td align="left"><select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                    <option value="">Escoja una opcion</option>
                    <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                    <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsAlmacenStock->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                    <?php
    }
    ?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Nombre:</td>
                  <td align="left"><input name="CmpProductoNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoNombre" value="<?php echo $InsAlmacenStock->ProNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>Referencia:</td>
                  <td align="left"><input name="CmpProductoReferencia" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoReferencia" value="<?php echo $InsAlmacenStock->ProReferencia;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>U.M.:</td>
                  <td align="left"><input name="CmpProductoUnidadMedida" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoUnidadMedida" value="<?php echo $InsAlmacenStock->UmeNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td align="left">Prom. Mensual.</td>
                  <td align="left"><input name="CmpProductoPromedioMensual" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoPromedioMensual" value="<?php echo $InsAlmacenStock->ProPromedioMensual;?>" size="15" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left">Dias Inmovilizado:<br />
                    <span class="EstFormularioSubEtiqueta">(Año <?php echo date("Y");?>)</span></td>
                  <td align="left"><input name="CmpProductoPromedioMensual" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoPromedioMensual" value="<?php echo $InsAlmacenStock->ProDiasInmovilizado;?>" size="15" maxlength="15" readonly="readonly" /></td>
                  <td align="left">Fecha Ult. Salida:</td>
                  <td align="left"><input name="CmpFechaUltimaSalida" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFechaUltimaSalida" value="<?php echo $InsAlmacenStock->ProFechaUltimaSalida;?>" size="15" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Almacen: </td>
                  <td align="left"><select class="EstFormularioCombo" name="CmpAlmacenId" id="CmpAlmacenId" <?php echo (!empty($GET_Almacen)?'disabled="disabled"':'');?> >
                    <option value="">Escoja una opcion</option>
                    <?php
foreach($ArrAlmacenes as $DatAlmacen){
?>
                    <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsAlmacenStock->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->SucNombre;?> - <?php echo $DatAlmacen->AlmNombre;?></option>
                    <?php
}
?>
                    </select></td>
                  <td>Ubicacion:</td>
                  <td align="left"><input name="CmpProductoUbicacion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoUbicacion" value="<?php echo $InsAlmacenStock->AstUbicacion;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Stock Minimo:</td>
                  <td align="left"><input name="CmpStockMinimo" type="text" class="EstFormularioCaja" id="CmpStockMinimo" value="<?php echo $InsAlmacenStock->AstStockMinimo;?>" size="15" maxlength="15" /></td>
                  <td>Stock Maximo:</td>
                  <td align="left"><input name="CmpStockMaximo" type="text" class="EstFormularioCaja" id="CmpStockMaximo" value="<?php echo $InsAlmacenStock->AstStockMaximo;?>" size="15" maxlength="15" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Observaciones:</td>
                  <td align="left"><textarea name="CmpObservacion" cols="40" rows="4" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAlmacenStock->AstObservacion;?></textarea></td>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                </table>
              
            </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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
	
  <?php
}else{
	echo ERR_GEN_101;
}

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>