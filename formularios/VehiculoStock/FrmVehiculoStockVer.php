<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoStock.css');
</style>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoStockFunciones.js" ></script>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
$GET_id = $_GET['Id'];
$GET_Sucursal = $_GET['Sucursal'];
$GET_Almacen = $_GET['Almacen'];
$GET_Ano = $_GET['Ano'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVehiculoMovimientoEntradaDetalle = new ClsVehiculoMovimientoEntradaDetalle();
$InsVehiculoMovimientoSalidaDetalle = new ClsVehiculoMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsVehiculoStock = new ClsVehiculoStock();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

$InsVehiculoStock->VehId = $GET_id;
$InsVehiculoStock->MtdObtenerVehiculoStock();
$InsVehiculoStock->SucId = $GET_Sucursal;

//MtdObtenerVehiculoMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoMovimientoEntrada=NULL,$oEstado=NULL,$oVehiculo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL)


//$ResVehiculoMovimientoEntradaDetalle = $InsVehiculoMovimientoEntradaDetalle->MtdObtenerVehiculoMovimientoEntradaDetalles(NULL,NULL,NULL,'VmvFecha','ASC',1,NULL,NULL,3,$InsVehiculoStock->VehId,"2015-01-01");
//$ArrVehiculoMovimientoEntradaDetalles = $ResVehiculoMovimientoEntradaDetalle['Datos'];
//
////MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoSalida=NULL,$oEstado=NULL,$oVehiculo=NULL) 
//
////MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoSalida=NULL,$oEstado=NULL,$oVehiculo=NULL,$oVehiculoMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
//$ResVehiculoMovimientoSalidaDetalle = $InsVehiculoMovimientoSalidaDetalle->MtdObtenerVehiculoMovimientoSalidaDetalles(NULL,NULL,NULL,'VmvFecha','ASC',NULL,NULL,3,$InsVehiculoStock->VehId,NULL,NULL,NULL,"2015-01-01");
//$ArrVehiculoMovimientoSalidaDetalles = $ResVehiculoMovimientoSalidaDetalle['Datos'];
//
////
////$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'VmvFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oVehiculo=NULL) 

//MtdObtenerVehiculoStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oVehiculo=NULL,$oVehiculoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno)


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"SucNombre","ASC",NULL,$GET_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];


////MtdObtenerVehiculoStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VstId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL,$oVehiculo=NULL,$oAno=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) 
$ResVehiculoStock = $InsVehiculoStock->MtdObtenerVehiculoStocks(NULL,NULL,NULL,"VstStock","DESC",NULL,"1",NULL,NULL,NULL,NULL,NULL,NULL, $GET_Sucursal,$GET_id,$GET_Ano,$GET_Ano."-01-01",date("Y-m-d"));
$ArrVehiculoStocks = $ResVehiculoStock['Datos'];

$StockReal = 0;

if(!empty($ArrVehiculoStocks)){
	foreach($ArrVehiculoStocks as $DatVehiculoStock){
		$StockReal = $DatVehiculoStock->VstStockReal;
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
                  <td align="left"><input name="CmpVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoId" value="<?php echo $InsVehiculoStock->VehId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Cod. Unico:</td>
                  <td align="left"><input name="CmpVehiculoCodigoOriginal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoCodigoOriginal" value="<?php echo $InsVehiculoStock->VehCodigoIdentificador;?>" size="20" maxlength="20" readonly="readonly" /></td>
                  <td>Sucursal:</td>
                  <td align="left"><select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                    <option value="">Escoja una opcion</option>
                    <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                    <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsVehiculoStock->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                    <?php
    }
    ?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Nombre:</td>
                  <td align="left"><input name="CmpVehiculoNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoNombre" value="<?php echo $InsVehiculoStock->VehNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>Referencia:</td>
                  <td align="left"><input name="CmpVehiculoReferencia" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoReferencia" value="<?php echo $InsVehiculoStock->VehReferencia;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>U.M.:</td>
                  <td align="left"><input name="CmpVehiculoUnidadMedida" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoUnidadMedida" value="<?php echo $InsVehiculoStock->UmeNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td align="left">Vehm. Mensual.</td>
                  <td align="left"><input name="CmpVehiculoVehmedioMensual" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVehmedioMensual" value="<?php echo $InsVehiculoStock->VehVehmedioMensual;?>" size="15" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left">Dias Inmovilizado:<br />
                    <span class="EstFormularioSubEtiqueta">(Año <?php echo date("Y");?>)</span></td>
                  <td align="left"><input name="CmpVehiculoVehmedioMensual" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVehmedioMensual" value="<?php echo $InsVehiculoStock->VehDiasInmovilizado;?>" size="15" maxlength="15" readonly="readonly" /></td>
                  <td align="left">Fecha Ult. Salida:</td>
                  <td align="left"><input name="CmpFechaUltimaSalida" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFechaUltimaSalida" value="<?php echo $InsVehiculoStock->VehFechaUltimaSalida;?>" size="15" maxlength="15" readonly="readonly" /></td>
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
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
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
                   <div id="CapVehiculoStockEntradaAccion"           ></div>
                  
                  
                  
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">
                    
                    
                    
                    
                    <div class="EstVehiculoStockMovimientos" id="CapVehiculoStockEntradas"           ></div>
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
    
 
        
	<div id="EstVehiculoStockMovimientoEntradas<?php echo $ano;?>" class="EstVehiculoStockMovimientos" > 	
                          

        
        <?php
    //MtdObtenerVehiculoMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoMovimientoEntrada=NULL,$oEstado=NULL,$oVehiculo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL)
        $ResVehiculoMovimientoEntradaDetalle = $InsVehiculoMovimientoEntradaDetalle->MtdObtenerVehiculoMovimientoEntradaDetalles(NULL,NULL,NULL,'VmvFecha','ASC',1,NULL,NULL,3,$InsVehiculoStock->VehId,$ano."-01-01",$ano."-12-31");
        $ArrVehiculoMovimientoEntradaDetalles = $ResVehiculoMovimientoEntradaDetalle['Datos'];
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
                      foreach($ArrVehiculoMovimientoEntradaDetalles as $DatVehiculoMovimientoEntradaDetalle){
                    ?>
                           
                        
    <tr>
                              <td align="left" valign="top"><?php echo $i;?></td>
                              <td align="left" valign="top">
                              
                              
                              
                              <?php 
							  switch($DatVehiculoMovimientoEntradaDetalle->VmvSubTipo){
								  case "2":
							?>
                           <a target="_blank" href="principal.php?Mod=VehiculoMovimientoEntradaSimple&Form=Ver&Id=<?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>">
                              <?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>
                              </a> 	
                            <?php  
								  break;
								  
								  default:
							?>
                            <a target="_blank" href="principal.php?Mod=VehiculoMovimientoEntrada&Form=Ver&Id=<?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>">
                              <?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>
                              </a>
                              
                            <?php	  
								  break;
							  }
							  
							   ;
							   
							   
							   ?>
                              
                              
                              
                              
                              
                              
                              
                              </td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->TopNombre?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->VmvFecha?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->PrvNumeroDocumento?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->PrvNombreCompleto;?>
                              <?php echo $DatVehiculoMovimientoEntradaDetalle->PrvApellidoPaterno;?>
                              <?php echo $DatVehiculoMovimientoEntradaDetalle->PrvApellidoMaterno;?>
                              </td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->VmvComprobanteNumero?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->VmvComprobanteFecha?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->OcoId?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoEntradaDetalle->UmeNombre?></td>
                              <td align="left" valign="top"><?php echo number_format($DatVehiculoMovimientoEntradaDetalle->AmdCantidad,2);?></td>
                              <td align="left" valign="top" bgcolor="#FFFF66"><?php echo $DatVehiculoMovimientoEntradaDetalle->AmdCantidadReal?></td>
                              </tr>
                              
                                        
                            
                            <?php
							$TotalIngresosReal += $DatVehiculoMovimientoEntradaDetalle->AmdCantidadReal;
                            $TotalIngresos += $DatVehiculoMovimientoEntradaDetalle->AmdCantidad;
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
                  <td colspan="4"><div id="CapVehiculoStockSalidaAccion"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">
                  
                  
            <div class="EstVehiculoStockMovimientos"  id="CapVehiculoStockSalidas"           ></div>       
                  
                  
                  
                  
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
	 


	<div id="EstVehiculoStockMovimientoSalidas<?php echo $ano;?>" class="EstVehiculoStockMovimientos" >

              
 
    
        <?php
    ////MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoSalida=NULL,$oEstado=NULL,$oVehiculo=NULL,$oVehiculoMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
        $ResVehiculoMovimientoSalidaDetalle = $InsVehiculoMovimientoSalidaDetalle->MtdObtenerVehiculoMovimientoSalidaDetalles(NULL,NULL,NULL,'VmvFecha','ASC',NULL,NULL,3,$InsVehiculoStock->VehId,NULL,NULL,NULL,$ano."-01-01",$ano."-12-31");
        $ArrVehiculoMovimientoSalidaDetalles = $ResVehiculoMovimientoSalidaDetalle['Datos'];
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
						
                      foreach($ArrVehiculoMovimientoSalidaDetalles as $DatVehiculoMovimientoSalidaDetalle){
                    ?>
                            
                            <tr>
                              <td align="left" valign="top"><?php echo $i;?></td>
                              <td align="left" valign="top">
                              
                              
                              
                      <?php 
							  switch($DatVehiculoMovimientoEntradaDetalle->VmvSubTipo){
								  case "4":
							?>
                           <a target="_blank" href="principal.php?Mod=VehiculoMovimientoSalidaSimple&Form=Ver&Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?>"> <?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?> </a>
                              
                            <?php  
								  break;
								  
								  default:
							?>
                             <a target="_blank" href="principal.php?Mod=VehiculoMovimientoSalida&amp;Form=Ver&amp;Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?>"> <?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?> </a>
                              
                              
                            <?php	  
								  break;
							  }
							  
							   ;
							   
							   
							   ?>
                              
                                          
                              
                            
                              
                              
                              </td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoSalidaDetalle->TopNombre?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoSalidaDetalle->VmvFecha?></td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoSalidaDetalle->CliNumeroDocumento?></td>
                              <td align="left" valign="top">
                              
                              <?php echo $DatVehiculoMovimientoSalidaDetalle->CliNombre;?> 
                              <?php echo $DatVehiculoMovimientoSalidaDetalle->CliApellidoPaterno;?> 
                              <?php echo $DatVehiculoMovimientoSalidaDetalle->CliApellidoMaterno;?> 
                              
                              </td>
                              <td align="left" valign="top"><a target="_blank" href="principal.php?Mod=VentaDirecta&amp;Form=Ver&amp;Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->VdiId;?>"><?php echo $DatVehiculoMovimientoSalidaDetalle->VdiId;?></a></td>
                              <td align="left" valign="top">
                              
                              <a target="_blank" href="principal.php?Mod=FichaIngreso&amp;Form=Ver&amp;Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->FinId;?>">
                              <?php echo $DatVehiculoMovimientoSalidaDetalle->FinId;?></a>
                             
                              
                              </td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoSalidaDetalle->MinNombre;?></td>
                              <td align="left" valign="top">
                              
                              <?php echo $DatVehiculoMovimientoSalidaDetalle->AmdFactura;?>
                              <?php echo $DatVehiculoMovimientoSalidaDetalle->AmdBoleta;?>
                              
                              </td>
                              <td align="left" valign="top">
    
                                <?php echo $DatVehiculoMovimientoSalidaDetalle->AmdFacturaFechaEmision;?>
                                <?php echo $DatVehiculoMovimientoSalidaDetalle->AmdBoletaFechaEmision;?>
    
                              </td>
                              <td align="left" valign="top"><?php echo $DatVehiculoMovimientoSalidaDetalle->UmeNombre?></td>
                              <td align="left" valign="top"><?php echo number_format($DatVehiculoMovimientoSalidaDetalle->AmdCantidad,2);?></td>
                              <td align="left" valign="top" bgcolor="#FFFF66"><?php echo $DatVehiculoMovimientoSalidaDetalle->AmdCantidadReal?></td>
                            </tr>
                            <?php	
							$TotalSalidasReal += $DatVehiculoMovimientoSalidaDetalle->AmdCantidadReal;
                            $TotalSalidas += $DatVehiculoMovimientoSalidaDetalle->AmdCantidad;
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