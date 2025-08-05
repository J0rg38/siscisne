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
$POST_Sucursal = $_GET['Sucursal'];

$POST_TipoCambio = 1;

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoVenta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoCompra.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProducto = new ClsProducto();
$InsMoneda = new ClsMoneda();
$InsClienteListaPrecio = new ClsClienteListaPrecio();
$InsReporteProductoVenta = new ClsReporteProductoVenta();
$InsReporteProductoCompra = new ClsReporteProductoCompra();

//MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 


//MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL)

if(empty($POST_ProductoCodigoOriginal)){
	exit("Ingrese un codigo orignal de repuesto");
}

$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$POST_ProductoCodigoOriginal,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrProductos = $ResProducto['Datos'];

if(!empty($ArrProductos)){
	
	$InsProducto->ProId = $ArrProductos[0]->ProId;
	$InsProducto->MtdObtenerProducto(false);
	
}

$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$POST_ProductoCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];



$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$POST_ProductoCodigoOriginal ,"PlpId","ASC","1",1);
$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];

$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$POST_ProductoCodigoOriginal ,"PreId","ASC",NULL,1);
$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

////MtdObtenerClienteListaPrecioClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ClpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
//$ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecioClientes(NULL,NULL,NULL,'CliNombre','ASC',NULL);
//$ArrClientes = $ResClienteListaPrecio['Datos'];

$InsMoneda->MonId = "MON-10001";
$InsMoneda->MtdObtenerMoneda();
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
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
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="95%" align="center">
            
            
            
            <table width="70%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="4" align="center">
                  
                  PRODUCTO: <?php echo $POST_ProductoCodigoOriginal;?>
                  
                  </th>
                </tr>
                </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top"><span class="EstTablaReporteEtiqueta">Registrado en Sistema:</span></td>
                  <td width="31%" align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
				}else{
				?>
                NO 
                <?php	
				}
				?>
                  </td>
                  <td width="23%" align="left" valign="top"><span class="EstTablaReporteEtiqueta">Nombre:</span></td>
                  <td width="28%" align="left" valign="top">
				  
				  
				  <?php
				if(!empty($ArrProductos)){
				?>

					<a  href="javascript:FncProductoCargarFormulario('Ver','<?php echo $InsProducto->ProId;?>');"> 
					<?php echo $InsProducto->ProNombre;?></a>
    
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
				if(!empty($ProductoCodigo)){
				?>
<a target="_blank" href="principal.php?Mod=Producto&Form=Registrar&ProductoCodigoOriginal=<?php echo $ProductoCodigo;?>&ProductoNombre=<?php echo $ProductoNombre;?>&ProductoUnidadMedida=UME-10007">Registrar Ahora</a>
<?php	
				}
				?>
<?php	
				}
				?>
                
                </td>
                </tr>
                <tr>
                  <td width="18%" align="left" valign="top"><span class="EstTablaReporteEtiqueta">Producto Disponible:</span></td>
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
                  <td align="left" valign="top"><span class="EstTablaReporteEtiqueta">Precio del Producto GM:</span></td>
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
                <?php
				/*foreach($ArrClientes as $DatCliente){
				?>
                <tr>
                  <td align="left" valign="top">
				  Precio p/ Cliente:
				  <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                  <td align="left" valign="top">
                  
                  <?php
				  $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$POST_ProductoCodigoOriginal, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
				  $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
				  ?>
                  
                  <?php
                  foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
				?>
                
                
                 <?php
					if($InsMoneda->MonId <> $EmpresaMonedaId){
						
						if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
						?>
							<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
						}else{
							
							$DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
						?>
                    		<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                    	<?php
						}
						?>
                    
                    <?php	
					}else{
					?>
					
                    	<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                    
					<?php	
					}
					?>
                    
                    
                      <span class="EstTablaReporteEspecial1">
                    
                    Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                    Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                    
                    </span>
                    
                    
                <?php
					  
				  }
                  ?>
                 
                 
                 
                  </td>
                </tr>
                <?php
				}*/
				?>
                <tr>
                  <td align="left" valign="top"><span class="EstTablaReporteEtiqueta">Disponible en Almacen:</span></td>
                  <td colspan="3" align="left" valign="top">
                  
					<span><?php echo ($InsProducto->ProStockReal>0)?'SI':'NO';?> </span>
                    
                  
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span class="EstTablaReporteEtiqueta">Codigos de Reemplazo:</span></td>
                  <td colspan="3" align="left" valign="top">
                  
                  
                  <?php
				if(!empty($ArrProductoReemplazos)){
				?>            
            
                  <?php
                  foreach($ArrProductoReemplazos as $DatProductoReemplazo){
                  ?>


					<?php
					if(!empty($DatProductoReemplazo->PreCodigo1) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo1){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo1,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo1 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo1,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo1;?>
                  
                  </th>
                </tr>
                </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                   <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                    
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
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
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
                
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>   
            
            
            
            
            
            
            
            
       <?php
					if(!empty($DatProductoReemplazo->PreCodigo2) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo2){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo2,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo2 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo2,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo2;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                      <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
                 <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo2, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>        
            
            
            
            
            
            
            
            




<?php
					if(!empty($DatProductoReemplazo->PreCodigo3) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo3){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo3,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo3 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo3,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo3;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
                 <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo3, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>        
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <?php
					if(!empty($DatProductoReemplazo->PreCodigo4) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo4){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo4,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo4 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo4,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo4;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
               
               
               <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo4, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                
                
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>        
            
            
            
            
            
            <?php
					if(!empty($DatProductoReemplazo->PreCodigo5) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo5){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo5,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo5 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo5,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo5;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
               <?php
				if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo5, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                             <!-- <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            -->
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}
				?>
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>        
            
            
            
            
   <?php
					if(!empty($DatProductoReemplazo->PreCodigo6) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo6){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo6,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo6 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo6,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo6;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
               <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo6, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>                 
            
            
            
             <?php
					if(!empty($DatProductoReemplazo->PreCodigo7) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo7){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo7,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo7 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo7,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo7;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
                <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo7, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>             
            
              <?php
					if(!empty($DatProductoReemplazo->PreCodigo8) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo8){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo8,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo8 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo8,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo8;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
               <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo8, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>    
            
             <?php
					if(!empty($DatProductoReemplazo->PreCodigo9) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo9){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo9,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo9 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo9,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo9;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
                <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo9, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                </tbody>
              <tfoot class="EstTablaReporteFoot">
              </tfoot>
            </table>
            
         <hr>

					<?php
					}
					
					?>    
            
              <?php
					if(!empty($DatProductoReemplazo->PreCodigo10) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo10){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo10,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo10 ,"PdiTiempoCreacion","DESC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo10,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $DatProductoReemplazo->PreCodigo10;?>
                  
                  </th>
                </tr>
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <!-- <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>-->
				<?php
					}
				}else{
				?>
                NO
                <?php	
				}
				?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">Producto Disponible:</td>
                  <td align="left" valign="top">
				
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <!--<span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
-->
                     
                     
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
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">
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
                    <!-- <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>-->
                    <?php
					}
				}else{
				?>
                	NO
                <?php
				}
				?></td>
                </tr>
               <?php
				/*if(!empty($ArrClientes)){
				?>
				
				
						<?php
                        foreach($ArrClientes as $DatCliente){
                        ?>
                        <tr>
                          <td align="left" valign="top">
                          Precio p/ Cliente:
                          <span class="EstTablaReporteEspecial1"><?php echo $DatCliente->CliNombreCompleto;?></span></td>
                          <td align="left" valign="top">
                          
                          <?php
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo10, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
                          $ArrClienteListaPrecio = $ResClienteListaPrecio['Datos'];
                          ?>
                          
                          <?php
                          foreach($ArrClienteListaPrecio as $DatClienteListaPrecio){
                        ?>
                        
                        
                         <?php
                            if($InsMoneda->MonId <> $EmpresaMonedaId){
                                
                                if($InsMoneda->MonId == $DatClienteListaPrecio->MonId){
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecioReal,2);?>                    	<?php
                                }else{
                                    
                                    $DatClienteListaPrecio->ClpPrecio = ($DatProductoListaPrecio->PlpPrecio / $POST_TipoCambio);
                                ?>
                                    <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>
                                <?php
                                }
                                ?>
                            
                            <?php	
                            }else{
                            ?>
                            
                                <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatClienteListaPrecio->ClpPrecio,2);?>                     
                            
                            <?php	
                            }
                            ?>
                            
                            
                              <span class="EstTablaReporteEspecial1">
                            
                            Nombre: <?php echo ($DatClienteListaPrecio->ClpNombre);?> 
                            Actualizado al: <?php echo ($DatClienteListaPrecio->ClpTiempoCreacion);?>
                            
                            </span>
                            
                            
                        <?php
                              
                          }
                          ?>
                         
                         
                         
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                
                
                <?php	
				}*/
				?>
                </tbody>
          
            </table>
            
         <hr>

					<?php
					}
					
					?>    
            
                              
                  <?php
                  }
				  ?>

            
            
            
            
            
            
            
            
            
            
            
            <?php
				}
			?>
            
            
                  
             
                
                
                  
				
				</td>
                </tr>
                
                <?php
				if(!empty($InsProducto->ProId)){
				?>
                 <tr>
                  <td colspan="4" align="center"><span class="EstReporteTitulo">HISTORIAL DE VENTAS </span></td>
                </tr>
                <tr>
                  <td colspan="4" align="center">
                Historia de los ultimos 3 años<br>
                <?php
				$ano_hoy = date("Y");
				$ano_inicio = $ano_hoy-2;
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
//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
					$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentas($InsProducto->ProId,NULL,NULL,$ano,$mes,"ProNombre","ASC","1",NULL,$POST_Sucursal);
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
                  <td colspan="4" align="center"><span class="EstReporteTitulo">HISTORIAL DE PRECIOS</span></td>
                </tr>
                <tr>
                  <td colspan="4" align="center">
                  
<?php


//MtdObtenerReporteProductoHistoriaPrecios($oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oMoneda=NULL,$oSucursal=NULL) {
$ResReporteProductoVenta = $InsReporteProductoVenta->MtdObtenerReporteProductoHistoriaPrecios($InsProducto->ProId,NULL,date("Y-m-d"),"amo.AmoFecha","DESC","5",NULL,$POST_Sucursal);
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
       
        <span class="EstReporteLeyenda">
                 Los precios no incluye impuesto.
                  </span>
<?php		
}else{
?>
No se encontro historial de precios.
<?php	
}
?>
                  
                  
                  
                  </td>
                </tr>
                
                 <?php	
				}
				?>
               
                
                   <?php
				if(!empty($InsProducto->ProId)){
				?>
                <tr>
                  <td colspan="4" align="center"><span class="EstReporteTitulo">HISTORIAL DE COSTOS</span></td>
                </tr>
                <tr>
                  <td colspan="4" align="center">
                  
                  
                  <?php

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
           <span class="EstReporteLeyenda">
                 Los precios no incluye impuesto.
                  </span>
<?php		
}else{
?>
No se encontro historial de costos.
<?php	
}
?>
                  
                  
                  
                  
                  
                  </td>
                </tr>
                  <?php	
				}
				?>
                
                
                <tr>
                  <td colspan="4" align="center"><!--<span class="EstReporteTitulo">ACCIONES</span>--></td>
                  </tr>
                  <tr>
                  <td colspan="4" align="center">
                  

<!--<a target="_blank" class="EstBotonIcono" href="principal.php?Mod=CotizacionProducto&Form=Registrar&Origen=ConsultaProducto&ProId=<?php echo $InsProducto->ProId?>"><img src="imagenes/nicono/cotizacion_repuesto.png" alt="[Registrar]" title="Registrar" border="0" align="absmiddle" width="40" height="40" /> Registrar Cotizacion</a> 

-->
                  </td>
                </tr>
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