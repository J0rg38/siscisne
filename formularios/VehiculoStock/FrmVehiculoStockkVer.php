<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenStock.css');
</style>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenStockFunciones.js" ></script>

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

$InsAlmacenStock->ProId = $GET_id;
$InsAlmacenStock->MtdObtenerAlmacenStock();
$InsAlmacenStock->SucId = $GET_Sucursal;

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

//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno) 
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"AstStock","DESC",NULL,"1",NULL,$GET_Ano."-01-01",date("Y-m-d"),NULL,NULL,NULL,$InsAlmacenStock->ProId,NULL,NULL,false,$GET_Sucursal,$GET_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

$StockReal = 0;

if(!empty($ArrAlmacenStocks)){
	foreach($ArrAlmacenStocks as $DatAlmacenStock){
		$StockReal = $DatAlmacenStock->AstStockReal;
	}
}

?>

<div class="EstCapMenu">
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        STOCK </span></td>
      </tr>
      <tr>
        <td colspan="2">
       

         <br />
    
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td><div class="EstFormularioArea">
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="3"><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>C&oacute;digo:</td>
                  <td align="left"><input name="CmpProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProductoId" value="<?php echo $InsAlmacenStock->ProId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td align="left">&nbsp;</td>
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
                  <td align="left"><select class="EstFormularioCombo" name="CmpAlmacenId" id="CmpAlmacenId">
                    <option value="">Escoja una opcion</option>
                    <?php
foreach($ArrAlmacenes as $DatAlmacen){
?>
                    <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($GET_Almacen==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->SucNombre;?> - <?php echo $DatAlmacen->AlmNombre;?></option>
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
                  <td>A&ntilde;o:</td>
                  <td align="left"><select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                    <?php
//for($ano=2014;$ano<=date("Y");$ano++){
for( $ano=2014;$ano<=date("Y");$ano++){
?>
                    <option value="<?php echo $ano;?>" <?php echo (($ano == $GET_Ano)?'selected="selected"':'')?>  ><?php echo $ano;?></option>
                    <?php	
}
?>
                  </select></td>
                  <td>Stock:</td>
                  <td align="left"><input name="CmpStock" type="text" class="EstFormularioCajaDeshabilitada" id="CmpStock" value="<?php echo number_format($StockReal,3)?>" size="10" readonly="readonly"            /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="3" align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4"><h1>ENTRADAS:</h1></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">
                   <div id="CapAlmacenStockEntradaAccion"           ></div>
                  
                  
                  
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">
                    
                    
                    
                    
                    <div class="EstAlmacenStockMovimientos" id="CapAlmacenStockEntradas"           ></div>
  <?php
/*for($ano=2014;$ano<=date("Y");$ano++){
?>


<table>
    <tr>
      <td>
      
<?php echo $ano;?> 
-

       
    <a href="javascript:FncMostrarEntradas('<?php echo $ano;?>')">
Mostrar
</a>

<a href="javascript:FncOcultarEntradas('<?php echo $ano;?>')">
Ocultar
</a>
</td>
    <td>
   
    </td>
    </tr>
    </table>
    
 
        
	<div id="EstAlmacenStockMovimientoEntradas<?php echo $ano;?>" class="EstAlmacenStockMovimientos" > 	
                          

        
        <?php
    //MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL)
        $ResAlmacenMovimientoEntradaDetalle = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,NULL,NULL,3,$InsAlmacenStock->ProId,$ano."-01-01",$ano."-12-31");
        $ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];
        ?>
        
    
                 
                        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th>#</th>
                              <th>CODIGO</th>
                              <th>OPERACION</th>
                              <th>FEC. INGRESO</th>
                              <th>NUM. DOC.</th>
                              <th>PROVEEDOR</th>
                              <th>NUM. COMPROB.</th>
                              <th>FEC. COMPROB.</th>
                              <th>ORD. COMP.</th>
                              <th>U.M.</th>
                              <th>CANTIDAD</th>
                              <th>CANT. UNI. BASE.</th>
                              </tr>                
                            </thead>
                          <tbody class="EstTablaListadoBody">
                <?php
                            $i=1;
                            $TotalIngresos = 0;
							$TotalIngresosReal = 0;
                      foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
                    ?>
                           
                        
    <tr>
                              <td align="left" valign="top"><?php echo $i;?></td>
                              <td align="left" valign="top">
                              
                              
                              
                              <?php 
							  switch($DatAlmacenMovimientoEntradaDetalle->AmoSubTipo){
								  case "2":
							?>
                           <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntradaSimple&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>">
                              <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>
                              </a> 	
                            <?php  
								  break;
								  
								  default:
							?>
                            <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>">
                              <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>
                              </a>
                              
                            <?php	  
								  break;
							  }
							  
							   ;
							   
							   
							   ?>
                              
                              
                              
                              
                              
                              
                              
                              </td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->TopNombre?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoFecha?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->PrvNumeroDocumento?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->PrvNombreCompleto;?>
                              <?php echo $DatAlmacenMovimientoEntradaDetalle->PrvApellidoPaterno;?>
                              <?php echo $DatAlmacenMovimientoEntradaDetalle->PrvApellidoMaterno;?>
                              </td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteNumero?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteFecha?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->OcoId?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->UmeNombre?></td>
                              <td align="left" valign="top"><?php echo number_format($DatAlmacenMovimientoEntradaDetalle->AmdCantidad,2);?></td>
                              <td align="left" valign="top" bgcolor="#FFFF66"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal?></td>
                              </tr>
                              
                                        
                            
                            <?php
							$TotalIngresosReal += $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;
                            $TotalIngresos += $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
                            $i++;  
                      }
                       ?>
                        <tr>
                              <td colspan="9" align="right">TOTAL INGRESOS:</td>
                              <td>&nbsp;</td>
                              <td><?php echo number_format($TotalIngresos,2);?></td>
                              <td><?php echo number_format($TotalIngresosReal,6);?></td>
                            </tr>
                            </tbody>
                        </table>    
                        
                        
    </div>                 

<?php	
}*/
?>
                    
                    
                    
                    
                    
                    
                    
                    </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4"><h1>SALIDAS:</h1></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4"><div id="CapAlmacenStockSalidaAccion"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">
                  
                  
            <div class="EstAlmacenStockMovimientos"  id="CapAlmacenStockSalidas"           ></div>       
                  
                  
                  
                  
<?php
/*for($ano=2014;$ano<=date("Y");$ano++){
?>                  
	
    <table>
    <tr>
      <td>
      
<?php echo $ano;?> 
-
<a href="javascript:FncMostrarSalidas('<?php echo $ano;?>')">
Mostrar
</a>
/
<a href="javascript:FncOcultarSalidas('<?php echo $ano;?>')">
Ocultar
</a></td>
    <td>
   
    </td>
    </tr>
    </table>
	 


	<div id="EstAlmacenStockMovimientoSalidas<?php echo $ano;?>" class="EstAlmacenStockMovimientos" >

              
 
    
        <?php
    ////MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
        $ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',NULL,NULL,3,$InsAlmacenStock->ProId,NULL,NULL,NULL,$ano."-01-01",$ano."-12-31");
        $ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];
        ?>
        
        
        
           
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#</th>
                              <th width="8%">CODIGO</th>
                              <th width="12%">OPERACION</th>
                              <th width="12%">FEC. SALIDA</th>
                              <th width="10%">NUM. DOC.</th>
                              <th width="33%">CLIENTE</th>
                              <th width="15%">ORD. VEN.</th>
                              <th width="15%">ORD. TRAB.</th>
                              <th width="15%">MODALIDAD</th>
                              <th width="15%">NUM. COMPROB.</th>
                              <th width="15%">FEC. COMPROB.</th>
                              <th width="8%">U.M.</th>
                              <th width="15%">CANTIDAD</th>
                              <th width="8%">CANT. UNI. BASE.</th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaListadoBody">
                            <?php
                            $i=1;
                        $TotalSalidas = 0;
						$TotalSalidasReal = 0;
						
                      foreach($ArrAlmacenMovimientoSalidaDetalles as $DatAlmacenMovimientoSalidaDetalle){
                    ?>
                            
                            <tr>
                              <td align="left" valign="top"><?php echo $i;?></td>
                              <td align="left" valign="top">
                              
                              
                              
                      <?php 
							  switch($DatAlmacenMovimientoEntradaDetalle->AmoSubTipo){
								  case "4":
							?>
                           <a target="_blank" href="principal.php?Mod=AlmacenMovimientoSalidaSimple&Form=Ver&Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?>"> <?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?> </a>
                              
                            <?php  
								  break;
								  
								  default:
							?>
                             <a target="_blank" href="principal.php?Mod=AlmacenMovimientoSalida&amp;Form=Ver&amp;Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?>"> <?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?> </a>
                              
                              
                            <?php	  
								  break;
							  }
							  
							   ;
							   
							   
							   ?>
                              
                                          
                              
                            
                              
                              
                              </td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->TopNombre?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->AmoFecha?></td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->CliNumeroDocumento?></td>
                              <td align="left" valign="top">
                              
                              <?php echo $DatAlmacenMovimientoSalidaDetalle->CliNombre;?> 
                              <?php echo $DatAlmacenMovimientoSalidaDetalle->CliApellidoPaterno;?> 
                              <?php echo $DatAlmacenMovimientoSalidaDetalle->CliApellidoMaterno;?> 
                              
                              </td>
                              <td align="left" valign="top"><a target="_blank" href="principal.php?Mod=VentaDirecta&amp;Form=Ver&amp;Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->VdiId;?>"><?php echo $DatAlmacenMovimientoSalidaDetalle->VdiId;?></a></td>
                              <td align="left" valign="top">
                              
                              <a target="_blank" href="principal.php?Mod=FichaIngreso&amp;Form=Ver&amp;Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->FinId;?>">
                              <?php echo $DatAlmacenMovimientoSalidaDetalle->FinId;?></a>
                             
                              
                              </td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->MinNombre;?></td>
                              <td align="left" valign="top">
                              
                              <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFactura;?>
                              <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdBoleta;?>
                              
                              </td>
                              <td align="left" valign="top">
    
                                <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFacturaFechaEmision;?>
                                <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdBoletaFechaEmision;?>
    
                              </td>
                              <td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->UmeNombre?></td>
                              <td align="left" valign="top"><?php echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdCantidad,2);?></td>
                              <td align="left" valign="top" bgcolor="#FFFF66"><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal?></td>
                            </tr>
                            <?php	
							$TotalSalidasReal += $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal;
                            $TotalSalidas += $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
                            $i++;  
                      }
                       ?>
                       <tr>
                              <td colspan="10" align="right">TOTAL SALIDAS:</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td><?php echo number_format($TotalSalidas,2);?></td>
                              <td><?php echo number_format($TotalSalidasReal,6);?></td>
                            </tr>
                            
                          </tbody>
                        </table>

	</div>

<?php	
}*/
?>
                
                  
                  
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                </table>
              
            </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            
            
            
            
            </td>
        </tr>
      </table>
     
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

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>