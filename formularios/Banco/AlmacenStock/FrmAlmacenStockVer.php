<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenStock.css');
</style>


<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenStock = new ClsAlmacenStock();

$InsAlmacenStock->ProId = $GET_id;
$InsAlmacenStock->MtdObtenerAlmacenStock();

//MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL)


$ResAlmacenMovimientoEntradaDetalle = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','DESC',1,NULL,NULL,3,$InsAlmacenStock->ProId);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];

//MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL) 
$ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmoFecha','DESC',NULL,NULL,3,$InsAlmacenStock->ProId);
$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];

//
//$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmoFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL) 
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
          <td>
            
            
            <div class="EstFormularioArea">
              
              <table width="828" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td width="4">&nbsp;</td>
                  <td width="115">&nbsp;</td>
                  <td width="678"><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td width="5">&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>C&oacute;digo:</td>
                  <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacenStock->ProId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Cod. Original:</td>
                  <td><input name="CmpProductoCodigoOriginal" type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" value="<?php echo $InsAlmacenStock->ProCodigoOriginal;?>" size="20" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Nombre:</td>
                  <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" value="<?php echo $InsAlmacenStock->ProNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Stock:</td>
                  <td><input name="CmpAlmaceStock" type="text" class="EstFormularioCaja" id="CmpAlmaceStock" value="<?php echo number_format($InsAlmacenStock->AstStockReal,3);?>" size="10" maxlength="10" readonly="readonly" />
                  
                  
                 <?php
if($InsAlmacenStock->ProStockVerificado == 1){
?>
                  <img src="imagenes/verificado.png" width="15" height="15" alt="Verificado" title="Verificado" />
                  <?php  
}
?> 
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>U.M.:</td>
                  <td><input name="CmpProductoUnidadMedida" type="text" class="EstFormularioCaja" id="CmpProductoUnidadMedida" value="<?php echo $InsAlmacenStock->UmeNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2">INGRESOS:</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2">
                  
                  
                  <div class="EstAlmacenStockMovimientos" > 
                  
                  
                  
                  
                    
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
                          <th>CANTIDAD</th>
                          <th>U.M.</th>
                          
                          </tr>                
                        </thead>
                      <tbody class="EstTablaListadoBody">
                        <?php
						$i=1;
						$TotalIngresos = 0;
				  foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
				?>
                       
                        <tr>
                          <td align="left" valign="top"><?php echo $i;?></td>
                          <td align="left" valign="top">
						  
                          <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>">
						  <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>
                          </a>
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
                          <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmdCantidad?></td>
                          <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->UmeNombre?></td>
                          
                          </tr>                
                        
                       
                        <?php	
						$TotalIngresos+=$DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
						$i++;  
				  }
				   ?>
                    <tr>
                          <td colspan="8" align="right">TOTAL INGRESOS:</td>
                          <td>&nbsp;</td>
                          <td><?php echo number_format($TotalIngresos,2);?></td>
                          <td>&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>    
                    
                  
                  </div>
                    </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2">SALIDAS:</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><div class="EstAlmacenStockMovimientos" >
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
                          <th width="15%">CANTIDAD</th>
                          <th width="8%">U.M.</th>
                        </tr>
                      </thead>
                      <tbody class="EstTablaListadoBody">
                        <?php
						$i=1;
					$TotalSalidas = 0;
				  foreach($ArrAlmacenMovimientoSalidaDetalles as $DatAlmacenMovimientoSalidaDetalle){
				?>
                        
                        <tr>
                          <td align="left" valign="top"><?php echo $i;?></td>
                          <td align="left" valign="top"><a target="_blank" href="principal.php?Mod=AlmacenMovimientoSalida&amp;Form=Ver&amp;Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?>"> <?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?> </a></td>
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
                          <td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdCantidad?></td>
                          <td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->UmeNombre?></td>
                        </tr>
                        <?php	
						$TotalSalidas += $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
						$i++;  
				  }
				   ?>
                   <tr>
                          <td colspan="9" align="right">TOTAL SALIDAS:</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><?php echo number_format($TotalSalidas,2);?></td>
                          <td>&nbsp;</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
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