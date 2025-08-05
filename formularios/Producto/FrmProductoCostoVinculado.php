<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
	$PrivilegioEditar = true;
}else{
	$PrivilegioEditar = false;
}
?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss('Producto');?>CssProducto.css');
</style>
<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj('Producto').'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

$InsProducto = new ClsProducto();
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();

include($InsProyecto->MtdFormulariosAcc('Producto').'AccProductoEditar.php');

$ResAlmacenMovimientoDetalleEntrada = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','ASC',1,NULL,NULL,3,$InsProducto->ProId);
$ArrAlmacenMovimientoDetalleEntradas = $ResAlmacenMovimientoDetalleEntrada['Datos'];


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
            
            
            
<!--<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('formularios/Producto/FrmProductoCodigoBarra.php?o=1&t=40&r=1&text=<?php echo ($InsProducto->ProId);?>&f=2&a1=&a2=',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/codigo_barra.png" alt="[GCBarra]" title="Imprimir Codigo de Barras" />Cod. Barra</a></div>-->



</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER HISTORIA DE COSTOS VINCULADOS DE PRODUCTO</span></td>
      </tr>
      <tr>
        <td>
        
        
<!--        
        <div class="EstFormularioArea">
         
        <table  border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>
       
        
                                <br />

 -->

 		
<ul class="tabs">
	<li><a href="#tab1">Historial</a></li>
</ul>

<div class="tab_container">

	<div id="tab1" class="tab_content">    
	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
	<tr>
	  <td valign="top">Codigo:</td>
	  <td valign="top"><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsProducto->ProId;?>" size="20" maxlength="20" readonly="readonly" /></td>
	  </tr>
	<tr>
	  <td align="left" valign="top" >Codigo Original:</td>
	  <td valign="top"><input  name="CmpCodigoOriginal" type="text"  class="EstFormularioCaja" id="CmpCodigoOriginal" value="<?php echo $InsProducto->ProCodigoOriginal;?>" size="30" maxlength="45" readonly="readonly" /></td>
	  </tr>
	<tr>
	  <td align="left" valign="top" >Codigo Alternativo:</td>
	  <td valign="top"><input  name="CmpCodigoAlternativo" type="text"  class="EstFormularioCaja" id="CmpCodigoAlternativo" value="<?php echo $InsProducto->ProCodigoAlternativo;?>" size="30" maxlength="45" readonly="readonly" /></td>
	  </tr>
	<tr>
	  <td width="9%" valign="top">Nombre:</td>
	  <td width="91%" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProducto->ProNombre;?>" size="40" maxlength="200" readonly="readonly"  /></td>
	  </tr>
	<tr>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  </tr>
	<tr>
	<td colspan="2" valign="top">
        
        <div class="EstFormularioArea">    
        
        

        
        <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="1%" rowspan="2" align="center">#</th>
  <th width="5%" rowspan="2" align="center">Movimiento</th>
  <th width="3%" rowspan="2" align="center">Fecha</th>
  <th width="1%" rowspan="2" align="center">Id</th>
  <th width="13%" rowspan="2" align="center"> Nombre</th>
  <th width="2%" rowspan="2" align="center">Cant.</th>
  <th width="3%" rowspan="2" align="center">Unidad.</th>
  <th width="3%" rowspan="2" align="center">
    
    Valor Unitario</th>
  <th width="3%" rowspan="2" align="center">Valor Total</th>
  <th colspan="12" align="center">Otros Costos Vinculados</th>
  <th width="2%" rowspan="2" align="center">Total Costo</th>
  <th width="3%" rowspan="2" align="center">Costo Unitario</th>
  <th width="4%" rowspan="2" align="center">Costo Anterior </th>
  <th width="4%" rowspan="2" align="center">Costo Promedio</th>
  </tr>
<tr>
  <th width="4%" align="center">Recargo</th>
<th width="4%" align="center">Flete</th>
<th width="5%" align="center">Otro Costo</th>
<th width="4%" align="center"><span >Aduana Inter.</span></th>
<th width="4%" align="center"><span >Transp.</span></th>
<th width="5%" align="center"><span >Desestiba</span></th>
<th width="5%" align="center"><span >Almacenaje</span></th>
<th width="5%" align="center"><span >Ad Valorem</span></th>
<th width="5%" align="center"><span >Aduana Nac.</span></th>
<th width="5%" align="center"><span >Gastos Admin.</span></th>
<th width="4%" align="center"><span >Otros Costos 1</span></th>
<th width="3%" align="center"><span >Otros Costos 2</span></th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$SumaTotalCosto = 0;
$PrimeraVez = true;
foreach($ArrAlmacenMovimientoDetalleEntradas as $DatAlmacenMovimientoDetalle){
	$SumaValorTotal += $DatAlmacenMovimientoDetalle->AmoSubTotal;
	
?>
<tr>
  <td align="right"><?php echo $c;?></td>
  <td align="right">
  
  <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoDetalle->AmoId;?>">
  <?php echo $DatAlmacenMovimientoDetalle->AmoId;?>
  </a>                
  
  
  
  
  </td>
  <td align="right"><?php echo $DatAlmacenMovimientoDetalle->AmoFecha;?></td>
  <td align="right"><?php echo $DatAlmacenMovimientoDetalle->ProId;?></td>
  <td align="right">
  <?php echo $DatAlmacenMovimientoDetalle->ProNombre;?></td>
  <td align="right">
  <?php echo number_format($DatAlmacenMovimientoDetalle->AmdCantidad,2);?>
  </td>
  <td align="right">
  <?php echo $DatAlmacenMovimientoDetalle->UmeNombre;?>
  </td>
  <td align="right"> 
  <?php echo number_format(($DatAlmacenMovimientoDetalle->AmdCosto),2);?>
  </td>
  <td align="right">
  <?php echo number_format($DatAlmacenMovimientoDetalle->AmdImporte,2);?>
  </td>
  <td align="right" bgcolor="#FF0000"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdNacionalTotalRecargo,2);?></td>
  <td align="right" bgcolor="#FF0000"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdNacionalTotalFlete,2);?></td>
  <td align="right" bgcolor="#FF0000"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdNacionalTotalOtroCosto,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduana,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalTransporte,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalDesestiba,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAlmacenaje,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAdValorem,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduanaNacional,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalGastoAdministrativo,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto1,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto2,2);?></td>
  <td align="right">
	<?php 
	$TotalCosto = $DatAlmacenMovimientoDetalle->AmdNacionalTotalRecargo + $DatAlmacenMovimientoDetalle->AmdNacionalTotalFlete + $DatAlmacenMovimientoDetalle->AmdNacionalTotalOtroCosto + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduana + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalTransporte + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalDesestiba + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAlmacenaje + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAdValorem + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduanaNacional + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalGastoAdministrativo + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto1 + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto2+   $DatAlmacenMovimientoDetalle->AmdImporte;
	$SumaTotalCosto += round($TotalCosto,2);
	?>
    
    <?php echo number_format($TotalCosto,2);?>
  </td>
  <td align="right">
  <?php $CostoUnitario = round($TotalCosto /$DatAlmacenMovimientoDetalle->AmdCantidad,2);?>
  <?php echo number_format($CostoUnitario,2);?>
  </td>
  <td align="right" bgcolor="#9D9DBD">

<?php
	if($PrimeraVez){
?>
	0.00
<?php
	}else{
		 echo number_format($CostoPromedioAnterior,2);
	}
?>
	<?php ?>
    
  </td>
  <td align="right">
   
    <?php
	if($PrimeraVez){
		$CostoPromedio = round($CostoUnitario,2);
	}else{
		$CostoPromedio = round(($CostoUnitario + $CostoPromedioAnterior)/2,2);
	}

	$CostoPromedioAnterior = $CostoPromedio;
	?>

    <?php echo number_format($CostoPromedio,2);?>
  </td>
</tr>

<?php
	$PrimeraVez = false;
$c++;
}
?>



</tbody>
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
