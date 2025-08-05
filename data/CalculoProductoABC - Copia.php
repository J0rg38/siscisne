<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$POST_Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);

$POST_Ano =  (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);
$POST_Mes =  (empty($_GET['Mes'])?date("m"):$_GET['Mes']);

$POST_Sucursal = $_GET['Sucursal'];

//$FechaInicio = "01/01/".$POST_Ano;
//$FechaFin = "31/12/".$POST_Ano;
$FechaFin = date("d/m/Y");
$Mes = 10;

list($Dia,$Mes,$Ano) = explode("/",$POST_Fecha);

require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoVenta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsProducto = new ClsProducto();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
 $InsReporteProducto = new ClsReporteProducto();
$InsAlmacenStock = new ClsAlmacenStock();
$InsReporteAlmacenMovimientoEntrada = new ClsReporteAlmacenmovimientoEntrada();
$InsSucursal = new ClsSucursal();

$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

$InventarioFechaInicio = (empty($InsSucursal->SucInventarioFechaInicio)?$SistemaInventarioFecha:$InsSucursal->SucInventarioFechaInicio);

$POST_ProductoTipo = "RTI-10000";

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false,$oReemplazo=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProTiempoCreacion","DESC","500",1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL,false,NULL);
$ArrProductos = $ResProducto['Datos'];

//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oTipo=NULL) {
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentas(NULL,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,"ProTiempoCreacion","DESC","500",$POST_VehiculoMarca,$POST_Sucursal,$POST_ProductoTipo);
$ArrReporteProductos = $ResReporteProducto['Datos'];


?>



<h2>Venta 12 Meses</h2>

<table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%" >#</th>
          <th width="5%">Id</th>
          <th width="31%">Cod. Original</th>
          <th width="17%">Nombre</th>
          <?php
		  for($mes=1;$mes<=12;$mes++){
		  ?>
		  
		  
		  <th width="20%">{<?php echo FncConvertirMes($mes);?>}</th>
		  
		  
          <?php
		  }
		  ?>
          
           <th width="25%">Total Anual</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		
		
		$c=1;
        foreach($ArrReporteProductos as $DatReporteProducto){

			$ProductoAnual12Meses[$DatReporteProducto->ProId] = 0;
			
			$TotalProductoAnual = 0;
			//$PromedioMensual = 0;
        ?>
       
     
                         
                    
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteProducto->ProId);?></td>
                <td  align="right" valign="top"   >
                  <?php echo ($DatReporteProducto->ProCodigoOriginal);?>
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteProducto->ProNombre);?></td>
                <?php
		  for($mes=1;$mes<=12;$mes++){
		  ?>
          
          
           <td  align="right" valign="top"   >
		 	
				<?php
				//$InsReporteProductoVenta = new ClsReporteProductoVenta();
				//MtdObtenerReporteProductoVentaValor($oFuncion="SUM",$oParametro="AmdId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
				//$TotalProductoVentaMensual = $InsReporteProductoVenta->MtdObtenerReporteProductoVentaValor("SUM","AmdCantidad",$mes,$POST_Ano,NULL,NULL,NULL,'AmdId','Desc','1',$POST_Sucursal,NULL,NULL);
				
				$TotalMensual[$DatProducto->ProId][$mes] = $InsReporteProducto->MtdObtenerReporteProductoVentasMensual($DatReporteProducto->ProId,$POST_Ano,$mes,$POST_VehiculoMarca,$POST_Sucursal);
							
				?>
                
                <?php //echo number_format($TotalProductoVentaMensual,2);?>
                 <?php echo number_format($TotalMensual[$DatProducto->ProId][$mes],2);?>
           
           </td>
          
                <?php
				  
				  $TotalProductoAnual += $TotalMensual[$DatProducto->ProId][$mes];
		  }

		   //$PromedioMensual  = ($TotalProductoAnual/12);
		   
		  ?>
          
           <?php
		 // $PromedioMensual  = ($TotalProductoAnual/12);
		  ?> 
           <td align="right">
		 
		   <?php echo number_format($TotalProductoAnual,2);?>
           
           </td>
           
          </tr>
		  
           <?php
		   $ProductoAnual12Meses[$DatProducto->ProId]  = $TotalProductoAnual;
		   ?>
  		
      
      
              
        <?php
		 $c++;
		 	
        }
        ?>
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
        
        </tfoot>
		</table>

<h2>Bases</h2>

<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>#</td>
  <td>Id</td>
  <td>Codigo Original</td>
  <td>Stock</td>
  <td>Venta 12 Meses</td>
  <td>Ventas Mes <?php echo FncConvertirMes($Mes);?></td>
  <td>Costo Unitario</td>
  <td>Costo Total</td>
  <td>Facturacion Total</td>
  <td>Ultima Salida</td>
  <td>Ultima Entrada</td>
  
 
  <td>Marca</td>
</tr>
<?php
$fila = 1;
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
		$ResReporteAlmacenMovimientoEntrada = $InsReporteAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,'500',NULL,3,$DatProducto->ProId,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,0,NULL,NULL,NULL,NULL);
		$ArrReporteAlmacenMovimientoEntradas = $ResReporteAlmacenMovimientoEntrada['Datos'];
		
		$CostoPromedio[$DatProducto->ProId] = 0;
		
		$ProductoStock[$DatProducto->ProId] = 0;
		
		$ProductoFechaUltimaEntrada[$DatProducto->ProId] = "";
		$ProductoFechaUltimaSalida[$DatProducto->ProId] = "";
		
		$ProductoCostoTotal[$DatProducto->ProId] = 0;
		
		$ProductoFacturacionTotal[$DatProducto->ProId] = 0;
		
		$CostoTotal = 0;
		$Registros = 0;
		//$HistorialCostos = "";
		
		if(!empty($ArrReporteAlmacenMovimientoEntradas)){
			foreach($ArrReporteAlmacenMovimientoEntradas as $DatReporteAlmacenMovimientoEntrada){
				
				$CostoTotal += $DatReporteAlmacenMovimientoEntrada->AmdCosto;
				//$HistorialCostos .= " - (".$DatReporteAlmacenMovimientoEntrada->AmoFecha.") ".number_format($DatReporteAlmacenMovimientoEntrada->AmdCosto,2);
						
				$Registros++;
			}
		}
		
		if($Registros>0){
			$CostoPromedio[$DatProducto->ProId] = $CostoTotal / $Registros;
		}else{
			$CostoPromedio[$DatProducto->ProId] = 0;
		}
						
?>

<tr>
  <td><?php echo $fila;?></td>
  <td><?php echo ($DatProducto->ProId);?></td>
  <td><?php echo $DatProducto->ProCodigoOriginal?>
  

  </td>
  <td>
          
        <?php        
        $StockReal = 0;
        //MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
        //$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"),$_SESSION['SesionSucursal']);
        $StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal(NULL,NULL,date("Y"),$DatProducto->ProId);
        
		$ProductoStock[$DatProducto->ProId] = $StockReal;		
        ?>
          
        <?php echo $StockReal;?>
        
  </td>
  <td>
  
  <?php echo   $ProductoAnual12Meses[$DatProducto->ProId] ;?>
  
  </td>
  <td>
    <?php echo   $TotalMensual[$DatProducto->ProId][$Mes];?>
 
  </td>
  <td>
          
        <?php
        echo $CostoPromedio[$DatProducto->ProId];
        ?>
        
  </td>
  <td>
  
<?php

$ProductoCostoTotal[$DatProducto->ProId] = $CostoPromedio[$DatProducto->ProId] * $ProductoStock[$DatProducto->ProId];

?>

  <?php
        echo $ProductoCostoTotal[$DatProducto->ProId];
        ?>
  </td>
  <td>
<?php
$ProductoFacturacionTotal[$DatProducto->ProId]  =  $ProductoAnual12Meses[$DatProducto->ProId]  * $CostoPromedio[$DatProducto->ProId];
?>

  <?php
        echo $ProductoFacturacionTotal[$DatProducto->ProId];
        ?>


  </td>
  <td>
  
		<?php
        if(empty($DatProducto->ProFechaUltimaSalida) or $DatProducto->ProFechaUltimaSalida == "0000-00-00" or $DatProducto->ProFechaUltimaSalida == "00/00/0000"){
        ?>
        -
        <?php
        }else{
			$ProductoFechaUltimaSalida[$DatProducto->ProId] = $DatProducto->ProFechaUltimaSalida;
        ?>							 
			<?php echo $DatProducto->ProFechaUltimaSalida;?>
        <?php 
        }
        ?>

  </td>
  <td>
<?php
if(empty($DatProducto->ProFechaUltimaEntrada) or $DatProducto->ProFechaUltimaEntrada == "0000-00-00" or $DatProducto->ProFechaUltimaEntrada == "00/00/0000"){
?>
-
<?php
}else{
	
	$ProductoFechaUltimaEntrada[$DatProducto->ProId] = $DatProducto->ProFechaUltimaEntrada;
?>							 
	<?php echo $DatProducto->ProFechaUltimaEntrada;?>
<?php 
}
?>
                             
                             
  </td>
 
 <td><?php echo $DatProducto->ProMarcaReferencia;?></td>
</tr>
<?php	
		$fila++;	
	}
}
?>

</table>

<h2>Familias</h2>
<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>#</td>
  <td>Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td>Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
  <td>Marca</td>
</tr>
<?php
$fila = 1;
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
				
				
?>
<tr>
  <td><?php echo $fila;?></td>
  <td><?php echo $DatProducto->ProCodigoOriginal?>
  
 (<?php echo count($ArrProductoCodigoReemplazos);?>)
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td>
 
 <?php
 if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
?>

	<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?>

<?php	 
 }else{
?>
-
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 <td><?php echo $DatProducto->ProMarcaReferencia;?></td>
</tr>
<?php	
		$fila++;	
	}
}
?>

</table>

<h2>STOCK</h2>



<h2>VENTA 12 MESES</h2>



<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td>#</td>
  <td align="center">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
  <td align="center">Marca</td>
</tr>
<?php
$fila = 1;
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
				
				
?>
<tr>
  <td><?php echo $fila;?></td>
  
  <td align="center"><?php echo $DatProducto->ProCodigoOriginal?>
<!--  
 (<?php echo count($ArrProductoCodigoReemplazos);?>)
 -->
 
 <?php
  $ProductoAnual12Meses[$DatProducto->ProId];
 ?>
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center">
 
 <?php
 if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
?>

    
<!-- <small>(<?php echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero; ?>)</small>-->


		<?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>

	<?php
	
	$TotalVenta12 = 0;
	?>
    
    <?php
	if(!empty($ProductoId )){
	?>

        
		<?php
       //
//	    $InsReporteProducto = new ClsReporteProducto();
//        $TotalVenta12 = $InsReporteProducto->MtdObtenerReporteProductoVentasMensual($ProductoId,$POST_Ano,$POST_Mes,NULL,$POST_Sucursal)
//        
        ?>
        
		<?php
        $TotalVenta12 = $ProductoAnual12Meses[$ProductoId];
        ?>

    <?php	
	}
	?>

	<?php
	echo $TotalVenta12;
	?>

<?php	 
 }else{
?>
-
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 <td align="center"><?php echo $DatProducto->ProMarcaReferencia;?></td>
</tr>
<?php	
		$fila++;	
	}
}
?>

</table>



<?php


echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>