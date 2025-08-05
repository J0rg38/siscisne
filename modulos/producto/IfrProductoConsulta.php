<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"CONSULTA_PRODUCTO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2 and !empty($_GET['P'])){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<?php if($_GET['P']==1){?> 
<script type="text/javascript">

$().ready(function() {
	setTimeout("window.close();",2500);	
	window.print(); 
});

</script>
<?php }?>
<?php

$POST_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
$POST_TipoCambio = 1;

$POST_finicio = "";
$POST_ffin = date("d/m/Y");

$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '-120 day' , strtotime ( $fecha ) ) ;
$POST_finicio = date ( 'd/m/Y' , $nuevafecha );

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoVenta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoCompra.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProducto = new ClsProducto();
$InsMoneda = new ClsMoneda();
$InsClienteListaPrecio = new ClsClienteListaPrecio();
$InsReporteProductoVenta = new ClsReporteProductoVenta();
$InsReporteProductoCompra = new ClsReporteProductoCompra();
$InsAlmacen = new ClsAlmacen();
//MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 
//MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL)

if(empty($POST_ProductoCodigoOriginal)){
	exit("Ingrese un codigo orignal de repuesto");
}

$POST_ProductoCodigoOriginal=(string)(int)$POST_ProductoCodigoOriginal;

$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$POST_ProductoCodigoOriginal,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrProductos = $ResProducto['Datos'];

if(!empty($ArrProductos)){
	
	$InsProducto->ProId = $ArrProductos[0]->ProId;
	$InsProducto->MtdObtenerProducto(false);
	
}

$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$POST_ProductoCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];

$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$POST_ProductoCodigoOriginal ,"PlpTiempoCreacion","DESC","1",1);
$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];

$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$POST_ProductoCodigoOriginal,"PreId","ASC",NULL,1);
$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

////MtdObtenerClienteListaPrecioClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ClpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
//$ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecioClientes(NULL,NULL,NULL,'CliNombre','ASC',NULL);
//$ArrClientes = $ResClienteListaPrecio['Datos'];


//if(!empty($POST_ProductoCodigoOriginal)){
	//MtdSeguimientoVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL)
	$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
	$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdSeguimientoVentaDirectaDetalles("ProCodigoOriginal","esigual",$POST_ProductoCodigoOriginal,$POST_ord,$POST_sen,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL);
	$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
//}



$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];


//$InsProductoReemplazo = new ClsProductoReemplazo();
//$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$POST_ProductoCodigoOriginal ,"PreId","ASC",NULL,1);
//$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

$InsMoneda->MonId = "MON-10001";
$InsMoneda->MtdObtenerMoneda();
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CONSULTA DE PRODUCTO


 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        
        


<?php
$ProductoNombre = "";
$ProductoCodigo = "";
if(!empty($ArrProductoListaPrecios)){
?>

	<?php
        foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
    ?>
        
        <?php $ProductoNombre =  trim($DatProductoListaPrecio->PlpNombre);?>
        <?php $ProductoCodigo =  trim($DatProductoListaPrecio->PlpCodigo);?>
    
    <?php
        }
    ?>

<?php
}
?>
                
                
                
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">

        <tbody class="EstTablaReporteBody">
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="95%" align="center">
            
            
            
            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td colspan="3" align="center" valign="top"><span class="EstReporteTitulo">DATOS DEL PRODUCTO</span></td>
                  </tr>
                <tr>
                  <td colspan="3" align="center" valign="top">
                  
                  
                  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                         <tr>
                  <td align="left" valign="top">Codigo:</td>
                  <td width="31%" align="left" valign="top"><?php echo $POST_ProductoCodigoOriginal;?></td>
                  <td width="23%" align="left" valign="top">Nombre:</td>
                  <td width="28%" align="left" valign="top"><?php
				if(!empty($ArrProductos)){
				?>
                    <?php echo $InsProducto->ProNombre;?>
                    <?php
  
					
				}else{
				?>
                    <?php
				if(!empty($ArrProductoListaPrecios)){
				?>
                    <?php
					foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
				?>
                    <?php echo ($DatProductoListaPrecio->PlpNombre);?>
                    <?php
					}
				?>
                    <?php
				}else{
				?>
                    <?php
				}
				?>
                  <?php	
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top"><?php
				if(!empty($ArrProductos)){
				?>
                    SI
                    <?php
					foreach($ArrProductos as $DatProducto){
				?>
                    <?php //echo $DatProducto->ProNombre;?>
                    <?php
					}
				}else{
				?>
                    NO
  <?php	
				}
				?></td>
                  <td align="left" valign="top">Precio  GM:</td>
                  <td align="left" valign="top"><?php
				if(!empty($ArrProductoListaPrecios)){
				?>
                    <?php
					foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
				?>
                    <?php
					if($InsMoneda->MonId <> $EmpresaMonedaId){
						
						if($InsMoneda->MonId == $DatProductoListaPrecio->MonId){
						?>
                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatProductoListaPrecio->PlpPrecioReal,2);?>
                    <?php
						}else{
							
							$DatProductoListaPrecio->PlpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
						?>
                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatProductoListaPrecio->PlpPrecio,2);?>
                    <?php
						}
						?>
                    <?php	
					}else{
					?>
                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatProductoListaPrecio->PlpPrecio,2);?>
                    <?php	
					}
					?>
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				?>
                    <?php
				}else{
				?>
                    NO
  <?php
				}
				?></td>
                  </tr>
                <tr>
                  <td width="18%" align="left" valign="top">Disponibilidad GM:</td>
                  <td align="left" valign="top">
				 
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    

                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO 
                <?php
				}
				?></td>
                  <td align="left" valign="top">Disponibilidad Local:</td>
                  <td align="left" valign="top"><?php echo ($InsProducto->ProStockReal>0)?'SI':'NO';?></td>
                  </tr>
                     </table>
                  
                  </td>
                  </tr>
             
               
                <tr>
                  <td colspan="3" align="center" valign="top"><span class="EstReporteTitulo">CODIGOS DE REEMPLAZO</span></td>
                  </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">
                  
                <?php
				if(!empty($ArrProductoReemplazos)){
					
					$ArrReemplazos = array();
				?>            
            
            	<?php
				
				foreach($ArrProductoReemplazos as $DatProductoReemplazo){
					
					if(!in_array($DatProductoReemplazo->PreCodigo1,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo1)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo1;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo2,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo2)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo2;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo3,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo3)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo3;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo4,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo4)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo4;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo5,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo5)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo5;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo6,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo6)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo6;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo7,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo7)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo7;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo8,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo8)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo8;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo9,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo9)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo9;
					}
					
					if(!in_array($DatProductoReemplazo->PreCodigo10,$ArrReemplazos) and !empty($DatProductoReemplazo->PreCodigo10)){
						$ArrReemplazos[] = $DatProductoReemplazo->PreCodigo10;
					}
					
				}
				
				
				?>
                
                <?php
				}
				?>
                
                <?php
				if(!empty($ArrReemplazos)){
				?>
                <table width="100%" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                  <thead class="EstTablaReporteHead">
                    <tr>
                      <th>REEMPLAZO</th>
                      <th>DISPONIBILIDAD</th>
                      <th>PRECIO GM</th>
                      <th>&nbsp;</th>
                      
                    </tr>
                  </thead>
                  <tbody class="EstTablaReporteBody">
                    <?php
				foreach($ArrReemplazos as $DatReemplazo){
					
						 $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatReemplazo,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatReemplazo,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatReemplazo,"PlpTiempoCreacion","DESC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        
				?>
                    <tr>
                      <td>
                        <?php echo $DatReemplazo;?>
                      </td>
                      <td>
                        
                        <?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
                        
                        <?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
                        
                        
                        <span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
                          
                        <?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                        
                        
                        
                        <?php
					}
					?>
                        
                        <?php	
				}else{
				?>
                        NO
                        <?php
				}
				?>
                        
                      </td>
                      <td>
                        
                        <?php
				if(!empty($ArrProductoListaPrecios)){
				?>
                        <?php
					foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
				?>
                        <?php
					if($InsMoneda->MonId <> $EmpresaMonedaId){
						
						if($InsMoneda->MonId == $DatProductoListaPrecio->MonId){
						?>
                        <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatProductoListaPrecio->PlpPrecioReal,2);?>
                        <?php
						}else{
							
							$DatProductoListaPrecio->PlpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
						?>
                        <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatProductoListaPrecio->PlpPrecio,2);?>
                        <?php
						}
						?>
                        <?php	
					}else{
					?>
                        <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatProductoListaPrecio->PlpPrecio,2);?>
                        <?php	
					}
					?>
                        
                        <?php
					}
				}else{
				?>
                        NO
                        <?php
				}
				?>
                        
                      </td>
                      <td></td>
                      
                    </tr>
                    
                    
                    <?php	
				}
				?>
                  </tbody>
                </table>
      
             <?php
				}else{
				?>
                No se encontraron codigos de reemplazo
                <?php	
				}
			 ?>				</td>
                  </tr>
                
                <?php
				if(!empty($InsProducto->ProId)){
				?>
                 <tr>
                   <td width="47%" align="center"><span class="EstReporteTitulo">MOVIMIENTO</span></td>
                   <td width="53%" align="center"><span class="EstReporteTitulo">STOCK</span></td>
                   </tr>
                 <tr>
                   <td align="center">
                   
                   <!--			pro.ProRotacion,
			
			pro.ProPromedioDiario,
			pro.ProPromedioMensual,
			pro.ProPromedioTrimestral,
			pro.ProPromedioSemestral,
			pro.ProPromedioAnual,
			
			pro.ProSalidaTotalAnual,
			pro.ProSalidaTotalTrimestral,
			pro.ProSalidaTotalSemestral,
			
			DATE_FORMAT(pro.ProFechaUltimaSalida, "%d/%m/%Y") AS "NProFechaUltimaSalida",
			pro.ProDiasInmovilizado,-->
                   
                   
                   <table width="50%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                       <thead class="EstTablaReporteHead">
                         <tr>
                           <th width="353">Ult. 3 meses</th>
                           <th width="353">Ultm. 6m</th>
                         </tr>
                       </thead>
                       <tbody class="EstTablaReporteBody">
                  
                         <tr>
                           <td align="center"><?php echo number_format($InsProducto->ProPromedioTrimestral,2);?></td>
                           <td width="353" align="center"><?php echo number_format($InsProducto->ProPromedioSemestral,2);?></td>
                         </tr>
    
                       </tbody>
                     </table>
                     
                     
                     
                   </td>
                   <td align="center">
                   
                   
                   <table width="100%" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
          <tr>
			<?php
			if(!empty($ArrAlmacenes)){
				foreach($ArrAlmacenes as $DatAlmacen){
			?>
            
           
            <th width="50" align="center" valign="top"><?php echo $DatAlmacen->AlmNombre;?></th>
            <?php		
				}
			}
			?>
            </tr>
            
		</thead>	
        <tbody class="EstTablaReporteBody">
          <tr>
          <?php
			if(!empty($ArrAlmacenes)){
				foreach($ArrAlmacenes as $DatAlmacen){
			?>
            <td width="50" align="center" valign="top">
 
 <?php
 $InsAlmacenStock = new ClsAlmacenStock();
//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false)
 $ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"ProId","ASC",1,"1",NULL,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,$InsProducto->ProId,NULL,$DatAlmacen->AlmId,false);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

 ?>
 
 <?php
 $Stock = 0;
 if(!empty($ArrAlmacenStocks)){
	 foreach($ArrAlmacenStocks as $DatAlmacenStock){
		 $Stock = $DatAlmacenStock->AstStockReal;
	 }
 }
 ?>
 
 <?php
 	echo number_format($Stock,2);
 ?>
 
              </td>
            <?php		
				}
			}
			?>
            </tr>
            </tbody>
          </table>
                   
                   </td>
                   </tr>
                 
                 
                 <tr>
                   <td colspan="3" align="center"><span class="EstReporteTitulo">POSIBLE RESERVACION DE CLIENTES</span></td>
                 </tr>
                 <tr>
                   <td colspan="3" align="center">
                   
                   
                   
                   <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%" rowspan="2">#</th>
          <th width="5%" rowspan="2">ORD. VEN.</th>
          <th width="6%" rowspan="2">FECHA</th>
          <th width="5%" rowspan="2">CANT.</th>
          <th width="8%" rowspan="2">CLIENTE</th>
          <th width="8%" colspan="2">ORD. COMPRA</th>
          <th colspan="2">DESPACHO</th>
          <th colspan="2">FACTURA GM</th>
          <th colspan="2">FICHA SALIDA CYC</th>
          <th colspan="2">FACTURA CYC</th>
          </tr>
        <tr>
          <th width="8%">NUM.</th>
          <th width="8%">FECHA</th>
          <th width="6%">CANT.</th>
          <th width="9%">FECHA</th>
          <th width="5%">NUM.</th>
          <th width="8%">FECHA</th>
          <th width="7%">FICHA.</th>
          <th width="8%">FECHA</th>
          <th width="7%">NUM.</th>
          <th width="5%">FECHA</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        <?php
		
		$c=1;
		if(!empty($ArrVentaDirectaDetalles)){
	        foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
        ?>
        <tr class="EstTablaReporte"  >
          <td align="right" valign="middle"   ><?php echo $c;?></td>
          <td align="right" valign="middle"   >
		  
			<?php echo $DatVentaDirectaDetalle->VdiId;  ?>
                  
				</td>
              <td align="right" ><?php echo ($DatVentaDirectaDetalle->VdiFecha);?></td>
              <td align="right" valign="middle"   ><?php echo number_format($DatVentaDirectaDetalle->VddCantidad,2);  ?></td>
              <td align="right" ><?php echo $DatVentaDirectaDetalle->CliNombre;  ?>
                <?php echo $DatVentaDirectaDetalle->CliApellidoPaterno;  ?>
                
                <?php echo $DatVentaDirectaDetalle->CliApellidoMaterno;  ?> </td>
              <td align="right" >
                

       
       
       
<?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
///MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL)
//$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,NULL);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL)
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	 <?php echo $DatPedidoCompraDetalle->OcoId;?>
	  <?php	
	}	
}
?>         
</td>
              <td align="right" >
			  
			  
<?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
///MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL)
//$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,NULL);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL)
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	  <?php echo $DatPedidoCompraDetalle->OcoFecha;?>
	  <?php	
	}	
}
?></td>
              <td align="right" ><?php echo number_format($DatVentaDirectaDetalle->VddCantidadPorLlegar,2);  ?></td>
              <td align="right" ><?php echo $DatVentaDirectaDetalle->VddFechaPorLlegar;  ?></td>
              <td align="right" >&nbsp;

<?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
											//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatVentaDirectaDetalle->VddId);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];


?>

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>

<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteNumero;?>

	  <?php
	}
}
?>

 
              </td>
              <td align="right" >
              
              <?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
											//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatVentaDirectaDetalle->VddId);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];

?>

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>
	<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteFecha;?>
<?php
	}
}
?>

</td>
              <td align="right" >

<?php
$VentaConcretadaId = "";
$VentaConcretadaFecha = "";
$VentaConcretadaRevisar = false;
?>

<?php
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,3);
$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];

?>
<?php
if(!empty($ArrVentaConcretadaDetalles)){
	foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
?>

	<?php
	$VentaConcretadaId = $DatVentaConcretadaDetalle->AmoId;
	$VentaConcretadaFecha = $DatVentaConcretadaDetalle->AmoFecha;
	?>

<?php
	}
}
?>

	
	<?php echo $VentaConcretadaId;?> 

    
    <?php
	if($VentaConcretadaRevisar){
	?>
	    <span title="Revisar">[R]</span>    
    <?php	
	}
	?>
    
    
              </td>
              <td align="right" ><?php echo $VentaConcretadaFecha;?></td>
              <td align="right" ><?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
?>

    
<?php
$InsFacturaDetalle = new ClsFacturaDetalle();
$ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL,NULL,'FdeId','Desc',NULL,NULL,NULL,NULL,5,$DatVentaDirectaDetalle->VddId);
$ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
?>

<?php
if(!empty($ArrFacturaDetalles)){
	foreach($ArrFacturaDetalles as $DatFacturaDetalle){
?>
		<?php
		$FacturaId = $DatFacturaDetalle->FacId;
		$FacturaTalonarioId = $DatFacturaDetalle->FtaId;
		$FacturaFecha = $DatFacturaDetalle->FacFechaEmision;
		$FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
		?>
        

<?php echo $FacturaTalonarioNumero;?> - <?php echo $FacturaId;?> 



        
<?php
	}
}
?>




<?php
$BoletaId = "";
$BoletaTalonarioId = "";
$BoletaFecha = "";
$BoletaTalonarioNumero = "";
$BoletaRevisar = false;
?>


<?php
$InsBoletaDetalle = new ClsBoletaDetalle();
$ResBoletaDetalle = $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL,NULL,'BdeId','Desc',NULL,NULL,NULL,NULL,5,$DatVentaDirectaDetalle->VddId);
$ArrBoletaDetalles = $ResBoletaDetalle['Datos'];
?>

<?php
if(!empty($ArrBoletaDetalles)){
	foreach($ArrBoletaDetalles as $DatBoletaDetalle){
?>
		<?php
		$BoletaId = $DatBoletaDetalle->BolId;
		$BoletaTalonarioId = $DatBoletaDetalle->BtaId;
		$BoletaFecha = $DatBoletaDetalle->BolFechaEmision;
		$BoletaTalonarioNumero = $DatBoletaDetalle->BtaNumero;
		?>
        
			<?php echo $BoletaTalonarioNumero;?> - <?php echo $BoletaId;?>

<?php
	}
}
?>

		
</td>
              <td align="right" >
                
                
                
                <?php echo $FacturaFecha;?>
                
                <?php echo $BoletaFecha;?>
              </td>
              </tr>
        <?php	
		$c++;
			}
			
        }else{
		?>
			<tr>
                <td colspan="15" align="right">
                  
                  <?php
				if(!empty($ArrProductoReemplazos)){
					
					$reemplazo = "puede intentar con los siguientes codigos de reemplazo: ";
					foreach($ArrProductoReemplazos as $DatProductoReemplazo){
						
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo1;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo2;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo3;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo4;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo5;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo6;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo7;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo8;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo9;
						$reemplazo .= " ".$DatProductoReemplazo->PreCodigo10;
						
					}					
					
				}

				?>
                  
                  No se encontraron resultados <?php echo $reemplazo;?>                </td>
                </tr>
			
        <?php	
		}
        ?>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
        </td>
                 </tr>
                 
                 
                 <tr>
                   <td colspan="3" align="center"><span class="EstReporteTitulo">HISTORIAL DE COSTOS</span></td>
                 </tr>
                 <tr>
                   <td colspan="3" align="center"><?php

$ResReporteProductoCompra = $InsReporteProductoCompra->MtdObtenerReporteProductoHistoriaCostos($InsProducto->ProId,NULL,date("Y-m-d"),"amo.AmoFecha","DESC","5");
$ArrReporteProductoCostos = $ResReporteProductoCompra['Datos'];
?>
                     <?php
if(!empty($ArrReporteProductoCostos)){
?>
                     <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                       <thead class="EstTablaReporteHead">
                         <tr>
                           <th>Fecha</th>
                           <th width="80">Moneda</th>
                           <th width="80">Precio</th>
                         </tr>
                       </thead>
                       <tbody class="EstTablaReporteBody">
                         <?php
	foreach($ArrReporteProductoCostos as $DatReporteProductoCosto){
		
		$Costo = 0;
		
		if( $DatReporteProductoCosto->MonId<>$EmpresaMonedaId ){
			$Costo = ($DatReporteProductoCosto->AmdCosto  / $DatReporteProductoCosto->AmoTipoCambio);
		}else{
			$Costo = ($DatReporteProductoCosto->AmdCosto);
		}	
?>
                         <tr>
                           <td align="right"><?php echo $DatReporteProductoCosto->AmdFecha;?></td>
                           <td width="80" align="center"><?php echo ($DatReporteProductoCosto->MonSimbolo);?></td>
                           <td width="80" align="center"><?php echo number_format($Costo,2);?></td>
                         </tr>
                         <?php
	}
	?>
                       </tbody>
                     </table>
                     <span class="EstReporteLeyenda"> Los precios no incluye impuesto. </span>
                     <?php		
}else{
?>
No se encontro historial de costos.
<?php	
}
?></td>
                 </tr>
               <?php
			   /*
			   ?>  
                 
                 <tr>
                   <td colspan="3" align="center"><span class="EstReporteTitulo">HISTORIAL DE PRECIOS</span></td>
                 </tr>
                 <tr>
                   <td colspan="3" align="center"><?php

$ResReporteProductoVenta = $InsReporteProductoVenta->MtdObtenerReporteProductoHistoriaPrecios($InsProducto->ProId,NULL,date("Y-m-d"),"amo.AmoFecha","DESC","5");
$ArrReporteProductoVentas = $ResReporteProductoVenta['Datos'];
?>
                     <?php
if(!empty($ArrReporteProductoVentas)){
?>
                     <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                       <thead class="EstTablaReporteHead">
                         <tr>
                           <th>Fecha</th>
                           <th width="80">Moneda</th>
                           <th width="80">Precio</th>
                         </tr>
                       </thead>
                       <tbody class="EstTablaReporteBody">
                         <?php
	foreach($ArrReporteProductoVentas as $DatReporteProductoVenta){
		
		$PrecioVenta = 0;
		
		if( $DatReporteProductoVenta->MonId<>$EmpresaMonedaId ){
			$PrecioVenta = ($DatReporteProductoVenta->AmdPrecioVenta  / $DatReporteProductoVenta->AmoTipoCambio);
		}else{
			$PrecioVenta = ($DatReporteProductoVenta->AmdPrecioVenta);
		}	
?>
                         <tr>
                           <td align="right"><?php echo $DatReporteProductoVenta->AmdFecha;?></td>
                           <td width="80" align="center"><?php echo ($DatReporteProductoVenta->MonSimbolo);?></td>
                           <td width="80" align="center"><span title="<?php echo $DatReporteProductoVenta->AmdId;?>"><?php echo number_format($PrecioVenta,2);?></span></td>
                         </tr>
                         <?php
	}
	?>
                       </tbody>
                     </table>
                     <span class="EstReporteLeyenda"> Los precios no incluye impuesto. </span>
                     <?php		
}else{
?>
No se encontro historial de precios.
<?php	
}
?></td>
                 </tr>
                    <?php
			   */
			   ?>
                 
                 
                 <tr>
                  <td colspan="3" align="center"><span class="EstReporteTitulo">HISTORIAL DE VENTAS </span></td>
                </tr>
                <tr>
                  <td colspan="3" align="center">
                Historia de los ultimos 2 años<br>
                <?php
				$ano_hoy = date("Y");
				$ano_inicio = $ano_hoy-1;
				for($ano=$ano_inicio;$ano<=$ano_hoy;$ano++){
				?>
                
                  <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                   <thead class="EstTablaReporteHead">
                  <tr>
                   
               
                    <th rowspan="2">Año <?php echo $ano;?></th>
                    
                         <?php
					for($mes=1;$mes<=12;$mes++){
					?>
                    <th colspan="2"><?php echo FncConvertirMes($mes);?></th>
                      <?php
					}
					?>
                    
                    </tr>
                  <tr>
                    <?php
					for($mes=1;$mes<=12;$mes++){
					?>
                    <th width="50">V</th>
                    <th width="50">OT</th>
                    <?php
					}
					?>
                  </tr>
                  </thead>
                  <tbody class="EstTablaReporteBody">
                  <tr>
                    <td align="right"><?php echo $POST_ProductoCodigoOriginal;?></td>
                   <?php
				   $TotalVentaDirecta = 0;
				   $TotalFichaIngreso = 0;
					for($mes=1;$mes<=12;$mes++){
					?>
                    
                    <?php 
					
					$InsReporteProducto = new ClsReporteProducto();
					//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL)
					$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentas($InsProducto->ProId,NULL,NULL,$ano,$mes,"ProNombre","ASC","1");
					$ArrReporteProductos = $ResReporteProducto['Datos'];
					?>
                    
                    <?php
					$CantidadVentaDirecta = 0;
					$CantidadFichaIngreso = 0;
					if(!empty($ArrReporteProductos)){
						foreach($ArrReporteProductos as $DatReporteProducto){
					?>
                    		<?php $CantidadVentaDirecta = $DatReporteProducto->RprCantidadVentaDirecta;?>
                            <?php $CantidadFichaIngreso = $DatReporteProducto->RprCantidadFichaIngreso;?>
                         
                    <?php		
						}
					}
					?>
                    <td width="50" align="center">
					<?php echo ($CantidadVentaDirecta);?> 
                    </td>
                    <td width="50" align="center">
					<?php echo ($CantidadFichaIngreso);?> 
                    </td>
                    <?php	
						$TotalVentaDirecta += $CantidadVentaDirecta;
						$TotalFichaIngreso += $CantidadFichaIngreso;
					}
					?>
                  </tr>
                  </tbody>
                  </table>
                  
                  
                
                  
                  
                     <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                   <thead class="EstTablaReporteHead">
                  <tr>
                    <th>Año <?php echo $ano;?></th>
                    <th width="80">Anual</th>
                    <th width="80">Prom. Mens.</th>
                  	</tr>
                  </thead>
                   <tbody class="EstTablaReporteBody">
                  <tr>
                    <td align="right">Total Ventas x Mostrador:</td>
                    <td width="80" align="center"><?php echo number_format($TotalVentaDirecta,2);?></td>
                    <td width="80" align="center">
					<?php 
					$PromedioTotalVentaDirecta = $TotalVentaDirecta/12;
					$PromedioTotalFichaIngreso = $TotalFichaIngreso/12;
					 ?>
                    <?php echo number_format($PromedioTotalVentaDirecta,2);?>
                    </td>
                    </tr>
                  <tr>
                    <td align="right">Total Ventas x OT:</td>
                    <td width="80" align="center"><?php echo number_format($TotalFichaIngreso,2);?></td>
                    <td width="80" align="center"><?php echo number_format($PromedioTotalFichaIngreso,2);?></td>
                  	</tr>
</tbody>
                  </table><br><br>
                	
                <?php
				}
				?>  
                  
                    <br>
                  
         <span class="EstReporteLeyenda">
                  V = Ventas por Mostrador
                  OT = Ventas por Ordenes de Trabajo
                  </span>
                  
                  </td>
                </tr>
                <?php	
				}
				?>
               
                
                
                   <?php
				if(!empty($InsProducto->ProId)){
				?>
                
                <tr>
                  <td colspan="3" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="center">&nbsp;</td>
                </tr>
                
                 <?php	
				}
				?>
               
                
                   <?php
				if(!empty($InsProducto->ProId)){
				?>
                <tr>
                  <td colspan="3" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="center">&nbsp;</td>
                </tr>
                  <?php	
				}
				?>
                
                
           
              </tbody>
            
            </table></td>
            <td width="2%" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>