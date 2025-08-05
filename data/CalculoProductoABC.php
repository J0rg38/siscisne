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
$POST_ProductoTipo = "RTI-10000";

//$FechaInicio = "01/01/".$POST_Ano;
//$FechaFin = "31/12/".$POST_Ano;
//$FechaFin = date("d/m/Y");
$MesActual = 10;

//list($Dia,$Mes,$Ano) = explode("/",$POST_Fecha);

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

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false,$oReemplazo=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProTiempoCreacion","ASC","500",1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL,false,NULL);
$ArrProductos = $ResProducto['Datos'];

//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oTipo=NULL) {
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentas(NULL,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_Fecha),NULL,NULL,"ProTiempoCreacion","ASC","500",$POST_VehiculoMarca,$POST_Sucursal,$POST_ProductoTipo);
$ArrReporteProductos = $ResReporteProducto['Datos'];

?>

<style type="text/css">

.EstNegativo{
	font-weight:bold;
	color:#F00;
	
	
}

.EstPositivo{
		font-weight:bold;
	color:#0C0;
}

</style>
<?php
		
$c=1;

foreach($ArrReporteProductos as $DatReporteProducto){

	$ProductoAnual12Meses[$DatReporteProducto->ProId] = 0;
	
	$TotalProductoAnual = 0;
	
	for($mes=1;$mes<=12;$mes++){
	
		$TotalMensual[$DatReporteProducto->ProId][$mes] = $InsReporteProducto->MtdObtenerReporteProductoVentasMensual($DatReporteProducto->ProId,$POST_Ano,$mes,$POST_VehiculoMarca,$POST_Sucursal);
		
		$TotalProductoAnual += $TotalMensual[$DatReporteProducto->ProId][$mes];
		
	}

	$ProductoAnual12Meses[$DatReporteProducto->ProId]  = $TotalProductoAnual;

$c++;

}
?>
        


<h2>Bases</h2>

<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center">#</td>
  <td align="center">Id</td>
  <td align="center">Codigo Original</td>
  <td align="center">Stock</td>
  <td align="center">Venta 12 Meses</td>
  <td align="center">Ventas Mes <?php echo FncConvertirMes($MesActual);?></td>
  <td align="center">Costo Unitario</td>
  <td align="center">Costo Total</td>
  <td align="center">Facturacion Total</td>
  <td align="center">Ultima Salida</td>
  <td align="center">Ultima Entrada</td>
  
 
  <td align="center">Marca</td>
</tr>
<?php
$fila = 1;
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
		$ResReporteAlmacenMovimientoEntrada = $InsReporteAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,'500',NULL,3,$DatProducto->ProId,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_Fecha),NULL,0,NULL,NULL,NULL,NULL);
		$ArrReporteAlmacenMovimientoEntradas = $ResReporteAlmacenMovimientoEntrada['Datos'];
		
		$CostoPromedio[$DatProducto->ProId] = 0;
		
		$ProductoStock[$DatProducto->ProId] = 0;
		
		$ProductoFechaUltimaEntrada[$DatProducto->ProId] = "";
		$ProductoFechaUltimaSalida[$DatProducto->ProId] = "";
		
		$ProductoCostoTotal[$DatProducto->ProId] = 0;
		
		$ProductoFacturacion[$DatProducto->ProId] = 0;
		
		
		
		
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
  <td align="center"><?php echo $fila;?></td>
  <td align="center"><?php echo ($DatProducto->ProId);?></td>
  <td align="center"><?php echo $DatProducto->ProCodigoOriginal?>
  

  </td>
  <td align="center">
          
        <?php        
        $StockReal = 0;
        //MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
        //$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"),$_SESSION['SesionSucursal']);
        $StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal(NULL,NULL,$POST_Ano,$DatProducto->ProId);
        
		$ProductoStock[$DatProducto->ProId] = $StockReal;		
        ?>

<span class="<?php echo (($StockReal<0)?'EstNegativo':'EstPositivo');?>">
<?php echo $StockReal;?>
</span>
        
  </td>
  <td align="center">
  
  
  <span class="<?php echo (($ProductoAnual12Meses[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
  <?php echo   round($ProductoAnual12Meses[$DatProducto->ProId],2) ;?>
</span>



  
  </td>
  <td align="center">
  
 
  
  <span class="<?php echo (($TotalMensual[$DatProducto->ProId][$MesActual]<0)?'EstNegativo':'EstPositivo');?>">
  <?php echo   round($TotalMensual[$DatProducto->ProId][$MesActual],2);?>
</span>


  </td>
  <td align="center">
          
       
          
  <span class="<?php echo (($CostoPromedio[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
  <?php
        echo round($CostoPromedio[$DatProducto->ProId],2);
        ?>
</span>

  </td>
  <td align="center">
  
<?php

$ProductoCostoTotal[$DatProducto->ProId] = $CostoPromedio[$DatProducto->ProId] * $ProductoStock[$DatProducto->ProId];

?>

 
        
        
      <span class="<?php echo (($ProductoCostoTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
  <?php
        echo round($ProductoCostoTotal[$DatProducto->ProId],2);
        ?>
</span>
  </td>
  <td align="center">
<?php
$ProductoFacturacion[$DatProducto->ProId]  =  $ProductoAnual12Meses[$DatProducto->ProId]  * $CostoPromedio[$DatProducto->ProId];
?>

 
<span class="<?php echo (($ProductoFacturacion[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
  <?php
        echo round($ProductoFacturacion[$DatProducto->ProId],2);
        ?>
</span>

  </td>
  <td align="center">
  
		<?php
        if(empty($DatProducto->ProFechaUltimaSalida) or $DatProducto->ProFechaUltimaSalida == "0000-00-00" or $DatProducto->ProFechaUltimaSalida == "00/00/0000"){
        ?>
        -
        <?php
        }else{
			$ProductoFechaUltimaSalida[$DatProducto->ProId] = FncCambiaFechaAMysql($DatProducto->ProFechaUltimaSalida);
        ?>							 
			<?php echo $DatProducto->ProFechaUltimaSalida;?>
        <?php 
        }
        ?>

  </td>
  <td align="center">
<?php
if(empty($DatProducto->ProFechaUltimaEntrada) or $DatProducto->ProFechaUltimaEntrada == "0000-00-00" or $DatProducto->ProFechaUltimaEntrada == "00/00/0000"){
?>
-
<?php
}else{
	
	$ProductoFechaUltimaEntrada[$DatProducto->ProId] = FncCambiaFechaAMysql($DatProducto->ProFechaUltimaEntrada);
?>							 
	<?php echo $DatProducto->ProFechaUltimaEntrada;?>
<?php 
}
?>
                             
                             
  </td>
 
 <td align="center"><?php echo $DatProducto->ProMarcaReferencia;?></td>
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
  <td align="center" valign="top" bgcolor="#66FF99">#</td>
  <td align="center" valign="top" bgcolor="#66FF99">Alias</td>
  <td align="center" valign="top" bgcolor="#66FF99">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top" bgcolor="#66FF99">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
  <td align="center" valign="top" bgcolor="#66FF99">Marca</td>
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
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">FAMILIAS</td>
  <td align="center" valign="top"><?php echo $DatProducto->ProCodigoOriginal?>
  
<!-- (<?php echo count($ArrProductoCodigoReemplazos);?>)-->
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top">
 
	<?php
    if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
    ?>
    
        <?php
        echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
        ?>
    
    <?php	 
     }else{
    ?>
   <!-- --->
    <?php	 
    }
    ?>
 
 </td>
 
 <?php
 }
 ?>
 <td align="center" valign="top"><?php echo $DatProducto->ProMarcaReferencia;?></td>
</tr>
<?php	
		$fila++;	
	}
}
?>

</table>











<h2>Stock</h2>



<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#99CCCC">#</td>
  <td align="center" valign="top" bgcolor="#99CCCC">Alias</td>
  <td align="center" valign="top" bgcolor="#99CCCC">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top" bgcolor="#99CCCC">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
 <td align="right" valign="top" bgcolor="#99CCCC">Total Stock</td>
 
  </tr>
<?php
$fila = 1;
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
				
$ProductoStockTotal[$DatProducto->ProId] = 0;			
?>
<tr>
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">STOCK</td>
  <td align="center" valign="top">
  
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />

   <span class="<?php echo (($ProductoStock[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
  <?php echo $ProductoStock[$DatProducto->ProId];?>
</span> 
<?php
$ProductoStockTotal[$DatProducto->ProId] += $ProductoStock[$DatProducto->ProId];
?>
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
    <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
       
	<?php
	if(!empty($ProductoId)){
	?>
    
    	
   	  <span class="<?php echo (($ProductoStock[$ProductoId]<0)?'EstNegativo':'EstPositivo');?>">
 <?php echo round($ProductoStock[$ProductoId],2);?>
</span> 


        <?php
		$ProductoStockTotal[$DatProducto->ProId] += $ProductoStock[$ProductoId];
		?>
        
           
    <?php	
	}else{
	?>
    
    0
   <!-- --->
    <?php	
	}
	?>        
    
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 
 <td align="right" valign="top">
 

 
 
   	  <span class="<?php echo (($ProductoStockTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
 <?php echo round($ProductoStockTotal[$DatProducto->ProId],2);?>
</span> 

 </td>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>


<h2>Venta 12 Meses</h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#FFFFCC">#</td>
  <td align="center" valign="top" bgcolor="#FFFFCC">Alias</td>
  <td align="center" valign="top" bgcolor="#FFFFCC">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top" bgcolor="#FFFFCC">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
 <td align="right" bgcolor="#FFFFCC">
  Total
 Ventas</td>
  </tr>
<?php
$fila = 1;

$ProductoAnual12MesesTotalSuma = 0;

if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
				
	$ProductoAnual12MesesTotal[$DatProducto->ProId] = 0;				
?>
<tr>
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">VEN12</td>
  <td align="center" valign="top">
  
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />



  
     	<span class="<?php echo (($ProductoAnual12Meses[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo $ProductoAnual12Meses[$DatProducto->ProId];?>
</span>   
<?php
$ProductoAnual12MesesTotal[$DatProducto->ProId] += $ProductoAnual12Meses[$DatProducto->ProId];
?>
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
    <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
     
	<?php
	if(!empty($ProductoId)){
	?>
    
    	
   	  <span class="<?php echo (($ProductoAnual12Meses[$ProductoId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo $ProductoAnual12Meses[$ProductoId];?>
</span>   
    <?php
	$ProductoAnual12MesesTotal[$DatProducto->ProId] += $ProductoAnual12Meses[$ProductoId];
	?>
    <?php	
	}else{
	?>
	0
    <?php	
	}
	?>        
   
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 
 <td align="right" valign="top">
 

  	
   	  <span class="<?php echo (($ProductoAnual12MesesTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
 <?php echo $ProductoAnual12MesesTotal[$DatProducto->ProId] ;?>
</span>   

<?php

$ProductoAnual12MesesTotalSuma += $ProductoAnual12MesesTotal[$DatProducto->ProId] ;

?>
 </td>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>


<h2>Fecha Ultima Salida</h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#CCCCFF">#</td>
  <td align="center" valign="top" bgcolor="#CCCCFF">Alias</td>
  <td align="center" valign="top" bgcolor="#CCCCFF">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top" bgcolor="#CCCCFF">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
  </tr>
<?php
$fila = 1;
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
				
	$ArrUltimasSalidas[$DatProducto->ProId] = array();
			
?>
<tr>
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">ULT. SAL.</td>
  <td align="center" valign="top">
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />
  
	<b><?php echo $ProductoFechaUltimaSalida[$DatProducto->ProId];?></b>
   
   
   <br />
  		<i><?php
		echo $timestamp = strtotime($ProductoFechaUltimaSalida[$DatProducto->ProId]);
		?></i>
       
<?php
$ArrUltimasSalidas[$DatProducto->ProId][] = $timestamp;
?> 

  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
    <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
        
	<?php
	if(!empty($ProductoId)){
	?>
    
    	<b><?php echo $ProductoFechaUltimaSalida[$ProductoId];?></b>
        
        <br />
  	<i>	<?php
		echo $timestamp = strtotime($ProductoFechaUltimaSalida[$ProductoId]);
		?></i>
        

<?php
$ArrUltimasSalidas[$DatProducto->ProId][] = $timestamp;
?> 



    <?php	
	}else{
	?>
   <!-- 00/00/0000 *-->
    <?php	
	}
	?>        
    
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>

<h2>Fecha Ultima Entrada</h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#FFCC99">#</td>
  <td align="center" valign="top" bgcolor="#FFCC99">Alias</td>
  <td align="center" valign="top" bgcolor="#FFCC99">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top" bgcolor="#FFCC99">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
  </tr>
<?php
$fila = 1;
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
	
	
$ArrUltimasEntradas[$DatProducto->ProId] = array();

			
?>
<tr>
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">ULT.ENT.</td>
  <td align="center" valign="top">
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />
  
	<b><?php echo $ProductoFechaUltimaEntrada[$DatProducto->ProId];?></b>
   
   <br />
   <i>	<?php
		echo $timestamp = strtotime($ProductoFechaUltimaEntrada[$DatProducto->ProId]);
		?></i>
        
       <?php
$ArrUltimasEntradas[$DatProducto->ProId][] = $timestamp;
?>  
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
	  <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
        
	<?php
	if(!empty($ProductoId)){
	?>
    
    	<b><?php echo $ProductoFechaUltimaEntrada[$ProductoId];?></b>

     <br />
   <i>	<?php
		echo $timestamp = strtotime($ProductoFechaUltimaEntrada[$ProductoId]);
		?></i>
        
               
       <?php
$ArrUltimasEntradas[$DatProducto->ProId][] = $timestamp;
?>  
    <?php	
	}else{
	?>
   <!-- 00/00/0000 *-->
    <?php	
	}
	?>        
    
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>




<h2>Ventas <?php echo FncConvertirMes($MesActual);?></h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#99FFFF">#</td>
  <td align="center" valign="top" bgcolor="#99FFFF">Alias</td>
  <td align="center" valign="top" bgcolor="#99FFFF">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top" bgcolor="#99FFFF">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
 <td align="right" bgcolor="#99FFFF">Total Ventas <?php echo FncConvertirMes($MesActual);?></td>
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
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">VENMES</td>
  <td align="center" valign="top">
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />
  
	
     	
   	  <span class="<?php echo (($TotalMensual[$DatProducto->ProId][$MesActual]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo  round($TotalMensual[$DatProducto->ProId][$MesActual],2);?>
</span>   



  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
    <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
         
	<?php
	if(!empty($ProductoId)){
	?>
    
  
    	
   	  <span class="<?php echo (($TotalMensual[$ProductoId][$MesActual]<0)?'EstNegativo':'EstPositivo');?>">
<?php
		 
		 echo $TotalMensual[$ProductoId][$MesActual];
		 
		?> 
</span>   


<?php
$TotalMensualTotal[$DatProducto->ProId] += $TotalMensual[$ProductoId][$MesActual];
?>
    	
    <?php	
	}else{
	?>
    0
   <!-- 00/00/0000 *-->
    <?php	
	}
	?>        
    
  
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 
 <td align="right">
 
<span class="<?php echo (($TotalMensualTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo $TotalMensualTotal[$DatProducto->ProId] ;?>
</span>   

 </td>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>





<h2>Costo Unitario</h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#CCFF66">#</td>
  <td align="center" valign="top" bgcolor="#CCFF66">Alias</td>
  <td align="center" valign="top" bgcolor="#CCFF66">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top" bgcolor="#CCFF66">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
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
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">COS.UNI.</td>
  <td align="center" valign="top">
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />
  

   	  <span class="<?php echo (($CostoPromedio[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo round($CostoPromedio[$DatProducto->ProId],2);?>
</span>   
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
    <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
    
	<?php
	if(!empty($ProductoId)){
	?>
    
    	
   	  <span class="<?php echo (($CostoPromedio[$ProductoId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo round($CostoPromedio[$ProductoId],2);?>
</span>   
    <?php	
	}else{
	?>
    0
   <!-- 00/00/0000 *-->
    <?php	
	}
	?>        
    
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>





<h2>Costo Total</h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#3399FF">#</td>
  <td align="center" valign="top" bgcolor="#3399FF">Alias</td>
  <td align="center" valign="top" bgcolor="#3399FF">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top" bgcolor="#3399FF">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
 <td bgcolor="#3399FF">
 Total Costo Inv.
 </td>
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
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">COS.TOT.</td>
  <td align="center" valign="top">
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />
  
	
      	<span class="<?php echo (($ProductoCostoTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo round($ProductoCostoTotal[$DatProducto->ProId],2);?>
</span>   
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
    <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
        
	<?php
	if(!empty($ProductoId)){
	?>
    
    	
   	  <span class="<?php echo (($ProductoCostoTotal[$ProductoId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo round($ProductoCostoTotal[$ProductoId],2);?>
</span>   

<?php
$ProductoCostoTotalTotal[$DatProducto->ProId] += $ProductoCostoTotal[$ProductoId];
?>
    <?php	
	}else{
	?>
   <!-- 00/00/0000 *-->0
    <?php	
	}
	?>        
   
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 <td align="right">
 
 
 
 
 <span class="<?php echo (($ProductoCostoTotalTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo $ProductoCostoTotalTotal[$DatProducto->ProId] ;?>
</span>   


 
 
 </td>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>






<h2>Facturacion Total</h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top" bgcolor="#33FF99">#</td>
  <td align="center" valign="top" bgcolor="#33FF99">Alias</td>
  <td align="center" valign="top" bgcolor="#33FF99">Base</td>
  
  
  <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="center" valign="top" bgcolor="#33FF99">Codigo <?php echo $cod;?></td>
 <?php
 }
 ?>
 
 <td bgcolor="#33FF99">Total Facturacion</td>
  </tr>
<?php
$fila = 1;

$ProductoFacturacionTotalSuma = 0;

if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
				
				
?>
<tr>
  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">FAC.TOT.</td>
  <td align="center" valign="top">
  
  <small>(<?php echo $DatProducto->ProCodigoOriginal?>)</small><br />
  
	
   	  <span class="<?php echo (($ProductoFacturacion[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
<?php echo round($ProductoFacturacion[$DatProducto->ProId],2);?>
</span>   

  <?php
   $ProductoFacturacionTotal[$DatProducto->ProId] += $ProductoFacturacion[$DatProducto->ProId];
   ?>
  </td>
 
 <?php
 for($cod=1;$cod<=20;$cod++){
 ?>
 <td align="right" valign="top">
 
 <?php
// if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero)){
   if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

	
	
	<small>(<?php
    echo $ArrProductoCodigoReemplazos[$cod]->PcrNumero;
    ?></small>)<br />
    
    <?php
        $ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
        
		 <?php
	if(!empty($ProductoId)){
	?>
        	<span class="<?php echo (($ProductoFacturacion[$ProductoId]<0)?'EstNegativo':'EstPositivo');?>">
 <?php echo round($ProductoFacturacion[$ProductoId],2);?>
</span>   
   
   
   <?php
   $ProductoFacturacionTotal[$DatProducto->ProId] += $ProductoFacturacion[$ProductoId];
   ?>
  
    <?php	
	}else{
	?>
   <!-- 00/00/0000 *-->0
    <?php	
	}
	?>        
    
        

<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 </td>
 
 <?php
 }
 ?>
 
 <td align="right">
 
   	
   	  <span class="<?php echo (($ProductoFacturacionTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
 <?php echo $ProductoFacturacionTotal[$DatProducto->ProId] ;?>
</span>   

<?php
$ProductoFacturacionTotalSuma += $ProductoFacturacionTotal[$DatProducto->ProId] ;
?>

 </td>
 </tr>
<?php	
		$fila++;	
	}
}
?>

</table>






<h2>TOTALES</h2>


<table  border="1" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td colspan="7" align="center" valign="top" bgcolor="#FF99FF">CLASIFICACION INVENTARIO</td>
  <td align="center" valign="top">&nbsp;</td>
  <td colspan="5" align="center" valign="top" bgcolor="#FFCC66">CLASIFICACION ABC</td>
  <td colspan="5" align="center" valign="top" bgcolor="#3399FF">TOTALES</td>
  <td align="center" valign="top">&nbsp;</td>
  </tr>
<tr>
  <td align="center" valign="top">#</td>
  <td align="center" valign="top">Alias</td>
  <td align="center" valign="top">Rotacion Acumulada</td>
  <td align="center" valign="top">Meses de Inventario</td>
  <td align="center" valign="top">Rotacion Diciembre</td>
  <td align="center" valign="top">Reclasificacion 1-5</td>
  <td align="center" valign="top">Status del Stock</td>
  <td align="center" valign="top">Meses Sin Facturacion</td>
  <td align="center" valign="top">Status Final</td>
  <td align="center" valign="top" bgcolor="#FF6633">Costo Total Inventario</td>
  <td align="center" valign="top">ABC QTY</td>
  <td align="center" valign="top">% QTY</td>
  <td align="center" valign="top">ABC Facturacion</td>
  <td align="center" valign="top">Facturacion Total</td>
  <td align="center" valign="top">% Fact.</td>
  <td align="center" valign="top">Stock Total</td>
  <td align="center" valign="top">Ventas Totales</td>
  <td align="center" valign="top">Ult. Fec. Sal.</td>
  <td align="center" valign="top">Ult. Fec. Ent.</td>
  <td align="center" valign="top">Ult. Fec. Val</td>
  <td align="center" valign="top">&nbsp;</td>
  </tr>
<?php
$fila = 1;

	$ProductoFacturacionTotalSuma2 = 0;
	$ProductoAnual12MesesTotalSuma2 = 0;
	
if(!empty($ArrProductos )){
	foreach($ArrProductos as $DatProducto){
		
	$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
	
	//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
	$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrOrden","ASC",NULL,$DatProducto->ProId);
	$ArrProductoCodigoReemplazos = $ResProductoCodigoReemplazo['Datos'];
			
			

				
?>


<tr>

  <td align="center" valign="top"><?php echo $fila;?></td>
  <td align="center" valign="top">
    
    
    TOTALES
    
    <?php
 /* $TotalStock = 0;
  
  $ProductoFacturacion[$DatProducto->ProId];
  ?>
  
  
  
<?php
for($cod=1;$cod<=20;$cod++){
?>

 
<?php
	if(!empty($ArrProductoCodigoReemplazos[$cod]->PcrNumero) and $ArrProductoCodigoReemplazos[$cod]->PcrNumero != $DatProducto->ProCodigoOriginal){
?>

		<?php
		$ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$ArrProductoCodigoReemplazos[$cod]->PcrNumero)
        ?>
        
	<?php
	if(!empty($ProductoId)){
	?>
    
    	<b><?php echo $ProductoFacturacion[$ProductoId];?></b>
  
    <?php	
	}else{
	?>
  
    <?php	
	}
	?>        
    
        
<?php	 
 }else{
?>
<!----->
<?php	 
 }
 ?>
 
 
 
 <?php
 }*/
 ?>
    
    
    
    
  </td>
  <td align="center" valign="top">
  
  <?php
  if($ProductoStockTotal[$DatProducto->ProId]>0){
	?>
    
      <?php
 $RotacionAcumulada[$DatProducto->ProId] = $ProductoAnual12MesesTotal[$DatProducto->ProId]/$ProductoStockTotal[$DatProducto->ProId];
  ?>
    <span class="<?php echo (( $RotacionAcumulada[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
    <?php
echo round( $RotacionAcumulada[$DatProducto->ProId],2);
  ?>
    </span>
    
    
    <?php
  }else{
	  
	 $RotacionAcumulada[$DatProducto->ProId] = 0;
?>

<?php  
  }
  ?>

    
    </td>
  <td align="center" valign="top">
  
  <?php
  if($RotacionAcumulada[$DatProducto->ProId]>0){
	  ?>
        <?php
 $MesesInventario[$DatProducto->ProId] = 12/$RotacionAcumulada[$DatProducto->ProId];
  ?>
    <span class="<?php echo (( $MesesInventario[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
    <?php
echo round( $MesesInventario[$DatProducto->ProId],2);
  ?>
    </span>
    
      <?php
  }else{
	  
	  
	  $MesesInventario[$DatProducto->ProId] = 0;
	?>
    
    <?php  
  }
  ?>

    
    </td>
  <td align="center" valign="top">
  
  
  
  <?php echo $TotalMensualTotal[$DatProducto->ProId] ;?>
  
  
  </td>
  <td align="center" valign="top">
  
  
<?php
//R5 = $RotacionAcumulada[$DatProducto->ProId]
//T5 = $TotalMensualTotal[$DatProducto->ProId]

/*

=SI(R5<1,"Sobrestock",

	SI(T5<1.5,"Rotación = > 1 y < 1.5",
	
		SI(T5<2,"Rotación = > 1.5 y < 2",
		
			SI(T5<2.5,"Rotación = > 2 y < 2.5",
			
				SI(T5<3,"Rotación = > 2.5 y < 3",
				
					SI(T5>=3,"Rotación = > 3","Revisar")
					)
				)
			)
		)
	)
	
*/
?>

<?php
$Reclasificacion15[$DatProducto->ProId] = "";

if($RotacionAcumulada[$DatProducto->ProId]<1){
	
	$Reclasificacion15[$DatProducto->ProId] = "Sobrestock";
	
}else{
	
	if($TotalMensualTotal[$DatProducto->ProId]<1.5){
		
		$Reclasificacion15[$DatProducto->ProId] = "Rotación = > 1 y < 1.5";
		
	}else{
		
		if($TotalMensualTotal[$DatProducto->ProId]<2){
			
			$Reclasificacion15[$DatProducto->ProId] = "Rotación = > 1.5 y < 2";
			
		}else{
			
			if($TotalMensualTotal[$DatProducto->ProId]<2.5){
				
				$Reclasificacion15[$DatProducto->ProId] = "Rotación = > 2 y < 2.5";
				
			}else{
				
				if($TotalMensualTotal[$DatProducto->ProId]<3){
				
					$Reclasificacion15[$DatProducto->ProId] = "Rotación = > 2.5 y < 3";
					
				}else{
					
							
					if($TotalMensualTotal[$DatProducto->ProId]>=3){
					
						$Reclasificacion15[$DatProducto->ProId] = "Rotación = > 3";
					
					}else{
						
						$Reclasificacion15[$DatProducto->ProId] = "Revisar";
						
					}
					
				}
				
			}
			
		}
		
		
	}
}
?>

<?php
echo $Reclasificacion15[$DatProducto->ProId] ;
?>
  </td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">
  
  
  <?php
  if($ProductoAnual12MesesTotalSuma>0){
	  ?>
      
      
      <?php
 $ProductoAnual12MesesTotalPorcentaje[$DatProducto->ProId] = $ProductoAnual12MesesTotal[$DatProducto->ProId]/$ProductoAnual12MesesTotalSuma;
  ?>
  
  <span class="<?php echo (( $ProductoAnual12MesesTotalPorcentaje[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
    <?php
echo round( $ProductoAnual12MesesTotalPorcentaje[$DatProducto->ProId],2);
  ?>
  
  </span>
  
  
      <?php
  }else{
	  
	  $ProductoAnual12MesesTotalPorcentaje[$DatProducto->ProId] = 0;
	?>
    
    <?php  
  }
  ?>
  

  
  
   %</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top"><span class="<?php echo (($ProductoFacturacionTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
    <?php
echo round($ProductoFacturacionTotal[$DatProducto->ProId],2);
  ?>
    </span>
    <?php
   $ProductoFacturacionTotalSuma2  += $ProductoFacturacionTotal[$DatProducto->ProId];
   ?></td>
  <td align="center" valign="top">
  
  
  <?php
  if($ProductoFacturacionTotalSuma>0){
	 ?>
       <?php
 $ProductoFacturacionTotalPorcentaje[$DatProducto->ProId] = $ProductoFacturacionTotal[$DatProducto->ProId]/$ProductoFacturacionTotalSuma;
  ?>
  
  <span class="<?php echo (( $ProductoFacturacionTotalPorcentaje[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>">
    <?php
echo round( $ProductoFacturacionTotalPorcentaje[$DatProducto->ProId],2);
  ?>
    </span>
    
    
     <?php 
  }else{
	  
	  $ProductoFacturacionTotalPorcentaje[$DatProducto->ProId] = 0;
?>

<?php  
  }
  ?>
  

    
    
    
    
     %
  </td>
  <td align="center" valign="top"><span class="<?php echo (($ProductoStockTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>"> <?php echo round($ProductoStockTotal[$DatProducto->ProId],2);?></span></td>
  <td align="center" valign="top">
  
  <span class="<?php echo (($ProductoAnual12MesesTotal[$DatProducto->ProId]<0)?'EstNegativo':'EstPositivo');?>"> 
  <?php echo round( $ProductoAnual12MesesTotal[$DatProducto->ProId],2);?>
  </span>
  
  <?php
  $ProductoAnual12MesesTotalSuma2 += $ProductoAnual12MesesTotal[$DatProducto->ProId];
  ?>
  
  </td>
  <td align="center" valign="top"><?php
$ArrFechaUltimaActividad = array();
?>
    <?php
  
$FechaSalidaMaxima =max($ArrUltimasSalidas[$DatProducto->ProId]);
  
  ?>
    <?php
  echo $FechaSalidaMaxima;
  ?>
    <?php
$ArrFechaUltimaActividad[] = $FechaSalidaMaxima;
  ?></td>
  <td align="center" valign="top"><?php
  
$FechaEntradaMaxima = max($ArrUltimasEntradas[$DatProducto->ProId]);
  
  ?>
    <?php
echo $FechaEntradaMaxima;
  ?>
    <?php
$ArrFechaUltimaActividad[] = $FechaEntradaMaxima;
  ?></td>
  <td align="center" valign="top"><?php
$FechaMaxima = max( $ArrFechaUltimaActividad);
  ?>
    <?php
echo $FechaMaxima;
  ?></td>
  <td align="center" valign="top">&nbsp;</td>

 </tr>
<?php	
		$fila++;	
	}
}
?>


<tr>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top"><?php
  echo round( $ProductoFacturacionTotalSuma2 ,2);
  ?></td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">
  
  
  
  
  <?php
  
  //  echo round( $ProductoAnual12MesesTotalSuma ,2);
	
  
  ?> 
  
   
  <?php
  
    echo round( $ProductoAnual12MesesTotalSuma2 ,2);
	
  
  ?> 
  
  </td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>

 </tr>
</table>







<?php


echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>