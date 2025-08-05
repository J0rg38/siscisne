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
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
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
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_ProductoCodigoOriginal = $_POST['CmpProductoCodigoOriginal'];
$POST_TipoCambio = 1;

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProducto = new ClsProducto();
$InsMoneda = new ClsMoneda();
$InsClienteListaPrecio = new ClsClienteListaPrecio();

//MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 


//MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL)

if(empty($POST_ProductoCodigoOriginal)){
	exit("Ingres un codigo orignal de repuesto");
}

$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$POST_ProductoCodigoOriginal,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrProductos = $ResProducto['Datos'];

$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$POST_ProductoCodigoOriginal ,"PdiId","ASC","1",1);
$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];



$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$POST_ProductoCodigoOriginal ,"PlpId","ASC","1",1);
$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];

$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$POST_ProductoCodigoOriginal ,"PreId","ASC",NULL,1);
$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

//MtdObtenerClienteListaPrecioClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ClpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
$ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecioClientes(NULL,NULL,NULL,'CliNombre','ASC',NULL);
$ArrClientes = $ResClienteListaPrecio['Datos'];

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
                  <th colspan="2" align="center">
                  
                  PRODUCTO: <?php echo $POST_ProductoCodigoOriginal;?>
                  
                  </th>
                </tr>
                </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td align="left" valign="top">Registrado en Sistema:</td>
                  <td align="left" valign="top">
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
						Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
						Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto GM:</td>
                  <td align="left" valign="top">
				  &nbsp;
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
							<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatProductoListaPrecio->PlpPrecioReal,2);?>                    	<?php
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
                    
                    

                    
                    <span class="EstTablaReporteEspecial1">
                    
                    Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> 
                    Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?>
                    
                    </span>
                    
                  <?php
					}
				?>
                
                <?php
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php	
				}
				?></td>
                </tr>
                
                <?php
				foreach($ArrClientes as $DatCliente){
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
				}
				?>
                <tr>
                  <td align="left" valign="top">Codigos de Reemplazo:</td>
                  <td align="left" valign="top">&nbsp;
				
				</td>
                </tr>
                <tr>
                  <td colspan="2" align="center">
                  
                  <?php
				if(!empty($ArrProductoReemplazos)){
				?>
                CODIGOS DE REEMPLAZO: 
             
				<?php
				}
				?>
                
                
                </td>
                </tr>
                <tr>
                  <td colspan="2" align="center">
                  
                  
               
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
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo1 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo1,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
                          $ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$DatProductoReemplazo->PreCodigo1, 'ClpId','ASC',"1",NULL,$DatCliente->CliId);
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
					if(!empty($DatProductoReemplazo->PreCodigo2) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo2){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo2,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo2 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo2,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
					if(!empty($DatProductoReemplazo->PreCodigo3) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo3){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo3,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo3 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo3,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
					if(!empty($DatProductoReemplazo->PreCodigo4) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo4){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo4,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo4 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo4,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
					if(!empty($DatProductoReemplazo->PreCodigo5) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo5){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo5,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo5 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo5,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="22%" align="left" valign="top">Producto Disponible:</td>
                  <td width="78%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo6 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo6,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
					if(!empty($DatProductoReemplazo->PreCodigo7) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo7){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo7,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo7 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo7,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
					if(!empty($DatProductoReemplazo->PreCodigo8) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo8){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo8,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo8 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo8,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="21%" align="left" valign="top">Producto Disponible:</td>
                  <td width="79%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
					if(!empty($DatProductoReemplazo->PreCodigo9) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo9){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo9,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo9 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo9,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="20%" align="left" valign="top">Producto Disponible:</td>
                  <td width="80%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
					if(!empty($DatProductoReemplazo->PreCodigo10) and $POST_ProductoCodigoOriginal <> $DatProductoReemplazo->PreCodigo10){
					?>

						<?php
                        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$DatProductoReemplazo->PreCodigo10,'ProId','ASC',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
                        $ArrProductos = $ResProducto['Datos'];
                        
                        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProductoReemplazo->PreCodigo10 ,"PdiId","ASC","1",1);
                        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
                        
                        $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatProductoReemplazo->PreCodigo10,"PlpId","ASC","1",1);
                        $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
                        ?>


<table width="80%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
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
				
				&nbsp;
				<?php
				if(!empty($ArrProductos)){
				?>
                SI 
                <?php
					foreach($ArrProductos as $DatProducto){
				?>
				
                     <span class="EstTablaReporteEspecial1">
                     Cod. Sistema: <a target="_parent" href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $DatProducto->ProId;?>"><?php echo $DatProducto->ProId;?></a>
                     
                     Nombre: <?php echo $DatProducto->ProNombre;?>
                     Actualizado al: <?php echo $DatProducto->ProTiempoModificacion;?>
                     </span>
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
                  <td width="20%" align="left" valign="top">Producto Disponible:</td>
                  <td width="80%" align="left" valign="top">
				  &nbsp;
				  
				<?php
				if(!empty($ArrProductoDisponibilidades)){
				?>
               
					<?php
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					?>
					
                    
					<span title="<?php echo $DatProductoDisponibilidad->PdiId;?> - <?php echo $DatProductoDisponibilidad->PdiCodigo;?>">
					
					<?php echo ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';?> </span>
                    
                    
                     <span class="EstTablaReporteEspecial1">
                     
                      Nombre: <?php echo $DatProductoDisponibilidad->PdiNombre;?>
                     Actualizdo al: <?php echo ($DatProductoDisponibilidad->PdiTiempoCreacion);?></span>
                     
                     
					<?php
					}
					?>
                
                <?php	
				}else{
				?>
                	NO EXISTE EN LISTADO
                <?php
				}
				?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">Precio del Producto:</td>
                  <td align="left" valign="top">&nbsp;
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
                    <span class="EstTablaReporteEspecial1"> Nombre: <?php echo ($DatProductoListaPrecio->PlpNombre);?> Actualizado al: <?php echo ($DatProductoListaPrecio->PlpTiempoCreacion);?> </span>
                    <?php
					}
				}else{
				?>
NO EXISTE EN LISTADO
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
				}
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