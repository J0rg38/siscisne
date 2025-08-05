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

?>
<html>
<head>


<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 


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

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>
<?php



$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];
$POST_VehiculoModelo = $_POST['CmpVehiculoModelo'];
$POST_MantenimientoKilometraje = $_POST['CmpMantenimientoKilometraje'];
$POST_ClienteTipo = $_POST['CmpClienteTipo'];

$POST_MantenimientoTotal = $_POST['CmpMantenimientoTotal'];
$POST_ManoObra = $_POST['CmpManoObra'];
$POST_PresupuestoTotal = $_POST['CmpPresupuestoTotal'];

//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');

//INSTANCIAS
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$InsProducto = new ClsProducto();

//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,'PmaId','ASC',1,NULL,$POST_VehiculoVersion,$POST_VehiculoModelo) ;
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_VehiculoModelo) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

$POST_MantenimientoKilometraje;

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">PRESUPUESTO/PLAN DE MANTENIMIENTO


 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        

            
            
            
            

     
<?php
if(!empty($POST_VehiculoMarca) and !empty($POST_VehiculoModelo) and !empty($POST_MantenimientoKilometraje) and !empty($POST_ClienteTipo)){
?>



     <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                              <tr>
                                <td width="1">&nbsp;</td>
                                <td colspan="7"></td>
                                <td width="4">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="78" align="left" valign="top">Marca:              </td>
                                <td width="214" align="left"><?php echo $InsPlanMantenimiento->VmaNombre;?>
                               </td>
                                <td width="91" align="left">Modelo:              </td>
                                <td width="325" align="left"><?php echo $InsPlanMantenimiento->VmoNombre;?></td>
                                <td width="167" align="left" valign="top">&nbsp;</td>
                                <td colspan="2" align="left">



                                </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="7" valign="top">
     
            <?php
            if(!empty($InsPlanMantenimiento->PmaId)){
            ?>
                    
                  
                        <?php
                        switch($InsPlanMantenimiento->VmaId){
                            //case "VMA-10017"://CHEVROLET
                            default://CHEVROLET
                        ?>
                      
                      
                        <?php
                        $PresupuestoTotal = 0;
                        ?>
                      
                                
                             
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPlanMantenimientoTabla">
                            <tr>
                              <td width="2%" align="right">&nbsp; </td>
                                
                                <?php
                                foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                ?>
                                    <?php if($POST_MantenimientoKilometraje == $DatKilometro['km']){?>
                                        <td colspan="4" align="center" ><i>(<?php echo $DatKilometro['eq'];?> km)</i></td>
                                    <?php	}?>
                                <?php	
                                }
                                ?>
                            </tr>
                                    
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

						   
						$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
						$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
						
						$MostrarSeccion = false;	
						foreach( $ArrPlanMantenimientoTareas  as $DatPlanMantenimientoTarea){
	
							foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
							
								if($POST_MantenimientoKilometraje == $DatKilometro['km']){

									$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
									$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajes[$POST_MantenimientoKilometraje]['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
									
									if($PlanMantenimientoDetalleAccion == "C"){
										$MostrarSeccion = true;
										break;
									}
									
								}
								
							}
							
						}
						
                    ?>
                        <?php
						if(!empty($ArrPlanMantenimientoTareas) and $MostrarSeccion){						
                        ?>
                    
                            <tr>
                                <td align="left" class="EstPlanMantenimientoSeccion"><?php //echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
                                <td width="55%" align="center" class="EstPlanMantenimientoSeccion">Producto</td>
                                <td width="14%" align="center" class="EstPlanMantenimientoSeccion">Cantidad</td>
                                <td width="14%" align="center" class="EstPlanMantenimientoSeccion">Unidad</td>
                                <td width="15%" align="center" class="EstPlanMantenimientoSeccion">Importe</td>
                            </tr>                
                        <?php
                                foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
                                
                                $PlanMantenimientoDetalleId = '';
                                $PlanMantenimientoDetalleAccion = '';
                                
                                $OpcAccion1 = '';
                                $OpcAccion2 = '';
                                $OpcAccion3 = '';
                                $OpcAccion4 = '';	
                        ?>
                        
                        
                            <?php
                            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                        
                                if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                  
								    $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                    $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
									
                                }
                            }
                            ?>
                                        
                            <?php
							if($PlanMantenimientoDetalleAccion == "C"){ 
                            ?>
                    
                                <tr>
                            
                                        <td class="EstPlanMantenimientoTarea">
                                        
                                            <?php //echo $DatPlanMantenimientoTarea->PmtNombre;?>
                                            
                                        </td>
                                
                                            <?php
                                            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                            ?>
                                                <?php
                                                if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                                ?>
                                                
                                                
													<?php
                                                    $ProductoId = "";
                                                    $ProductoCodigoOriginal = "";
                                                    $ProductoNombre = "";
                                                    $ProductoUnidadMedida = "";
                                                    $ProductoUnidadMedidaNombre = "";
                                                    $ProductoUnidadMedidaOrigen = "";
                                                    $ProductoTipo = "";
                                                    
                                                    $ProductoCantidad = 0;
                                                    $ProductoPrecio = 0;		
                                                    $ProductoImporte = 0;
                                                            
                                                    $InsTareaProducto = new ClsTareaProducto();
                                                    $ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajes[$POST_VehiculoMantenimientoKilometraje]['eq']);
                                                    $ArrTareaProductos = $ResTareaProducto['Datos'];
                                                    ?>
                                                    
                                                    <?php
                                                    foreach($ArrTareaProductos as $DatTareaProducto){
                                                    ?>
                                                    
                                                        <?php
                                                        if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId and $DatTareaProducto->TprKilometraje == $DatKilometro['km']){
                                                            
                                                    
                                                            $InsProducto->ProId = $DatTareaProducto->ProId;
                                                            $InsProducto->MtdObtenerProducto(false);
                                                        
                                                            $ProductoId = $DatTareaProducto->ProId;
                                                            $ProductoCodigoOriginal = $DatTareaProducto->ProCodigoOriginal;
                                                            $ProductoNombre = $DatTareaProducto->ProNombre;
                                                            $ProductoUnidadMedida = $DatTareaProducto->UmeId;
                                                            $ProductoUnidadMedidaNombre = $DatTareaProducto->UmeNombre;
                                                            $ProductoUnidadMedidaOrigen = $InsProducto->UmeId;
                                                            $ProductoTipo = $InsProducto->RtiId;
                                                            $ProductoCantidad = $DatTareaProducto->TprCantidad;		
                                                            
                                                            $TareaProductoId = $DatTareaProducto->TprId;		
                                                            
                                                            
                                                            $InsListaPrecio = new ClsListaPrecio();
                                                            $ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$ProductoId,$POST_ClienteTipo,$ProductoUnidadMedida);
                                                            $ArrListaPrecios = $ResListaPrecio['Datos'];
                                
                                                            foreach($ArrListaPrecios as $DatListaPrecio){
                                                    
                                                                $ProductoPrecio = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);
                                
                                                            }

                                                            $ProductoImporte = $ProductoPrecio * $ProductoCantidad;
                                                            
                                                            break;
                                                            
                                                        }
                                                        ?>
                                                        
                                                    <?php
                                                    }
                                                    ?>
                    
                                                <td align="left"   >
                                                  
                                                  
                                                  
                                                  
                                                  <?php
                        

                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "C":
                        ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoNombre'];?>
                                                  <?php
                            break;
                           
                            case "X":
                        ?>
                                                  
                                                  <?php					
                            break;

							case "U":
                         ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoNombre'];?>
                                                  <?php						
                            break;
                        }
                        ?>
                                                  
                                                  
                                                  
                                                  
                                                </td>
                                                <td align="center"   >
												
					<?php
                        

                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "C":
                        ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoCantidad'];?>
                                                  <?php
                            break;
                           
                            case "X":
                        ?>
                                                  <?php					
                            break;

							case "U":
                         ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoCantidad'];?>
                                                  <?php						
                            break;
                        }
                        ?></td>
                                                <td align="center"   >
                                                
                    <?php
                    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
					
					//deb ($ArrProductoTipoUnidadMedidas);
                    ?>
                    
                    
                      <?php
                        
//deb($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]);
//deb($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoUnidadMedidaConvertir']);
                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "C":
                        ?>
                       
					       
                                                  <?php
                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                        ?>
                                                  
							
                            <?php
							if($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoUnidadMedida']==$DatProductoTipoUidadMedida->UmeId){
							?>
                            <?php echo $DatProductoTipoUidadMedida->UmeNombre;?>
                            <?php
							break;
							}
							?>
						<?php	
												  
												  
                        }							
                        ?>
                        
                        <?php
                            break;
                           
                            case "X":
                        ?>
                        
                        <?php					
                            break;

							case "U":
                         ?>
                         
                           
                                                  <?php
                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                        ?>
                                                  
							
                            <?php
							if($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoUnidadMedida']==$DatProductoTipoUidadMedida->UmeId){
							?>
                            <?php echo $DatProductoTipoUidadMedida->UmeNombre;?>
                            <?php
							break;
							}
							?>
						<?php	
												  
												  
                        }							
                        ?>
                        
                         <?php						
                            break;
                        }
                        ?>
                        
					
                    
                       
                   
                    
                    
                  
                    
                  
                    
                    
                    
                    </td>
                                  <td align="right"   >
                                                  
                                                  
                                                  
                                    <?php
                        

                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "C":
                        ?>
                                    <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoImporte'];?>
                                    <?php
                            break;
                           
                            case "X":
                        ?>
                                                  
                                    <?php					
                            break;

							case "U":
                         ?>
                                    <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoImporte'];?>
                                    <?php						
                            break;
                        }
                        ?>
                                                  
                                                  
                                                  
                                  </td>
                                                <?php
                                                }
                                                ?>
                                                
                                            <?php	
                                            }
                                            ?>
                                
                                </tr>
                                
									<?php
                                    $PresupuestoTotal += $ProductoImporte;
                                    ?>
                    
                            <?php
                            }else{
								
								
							}
                            ?>
                            
                            
                                <?php			
                                }
                                ?>
                                    
                        <?php
                        }
                        ?>
                    
                                   
                    <?php
                    }
                    ?>  
                    
                            
                                  </table>
                                
                                
                                
                               
                       
                        <?php
                            break;
                            
                            case "VMA-10018"://ISUZU
                        ?>
                        
                        
                    <?php
                    $PresupuestoTotal = 0;
                    ?>
                  
                                
                             
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPlanMantenimientoTabla">
                            <tr>
                              <td width="17" align="right">&nbsp;</td>
                                <?php
                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                ?>
                                <?php if($POST_MantenimientoKilometraje == $DatKilometro['km']){?>
                                <td colspan="4" align="center" ><i>(<?php echo $DatKilometro['eq'];?> km)</i></td>
                                <?php	}?>
                                <?php	
                                }
                                ?>
                            </tr>
                                    
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
                    



						$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
						$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
						
						$MostrarSeccion = false;	
						foreach( $ArrPlanMantenimientoTareas  as $DatPlanMantenimientoTarea){
	
							foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
							
								if($POST_MantenimientoKilometraje == $DatKilometro['km']){
									
									$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
									$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
									
									if($PlanMantenimientoDetalleAccion == "R"){
										$MostrarSeccion = true;
										break;
									}
								}
								
							}
							
						}
						
						
						

                         
						 
                    ?>
						
                        <?php
						if(!empty($ArrPlanMantenimientoTareas) and $MostrarSeccion){
						?>
                        <tr>
                            <td align="left" class="EstPlanMantenimientoSeccion"><?php //echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
<td width="525" align="center" class="EstPlanMantenimientoSeccion">Producto</td>
<td width="133" align="center" class="EstPlanMantenimientoSeccion">Cantidad</td>
<td width="135" align="center" class="EstPlanMantenimientoSeccion">Unidad</td>
                            <td width="141" align="center" class="EstPlanMantenimientoSeccion">Importe</td>
                           
                        </tr>                
								<?php
                                foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
                                
                                $PlanMantenimientoDetalleId = '';
                                $PlanMantenimientoDetalleAccion = '';
                                
                                $OpcAccion1 = '';
                                $OpcAccion2 = '';
                                $OpcAccion3 = '';
                                $OpcAccion4 = '';	
                                $OpcAccion5 = '';	
                                $OpcAccion6 = '';	
                                ?>
                        
                        
									<?php
                                    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                
                                        if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                            $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                            $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajes[$POST_MantenimientoKilometraje]['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
                                            
                                        }
                                    }
                                    ?>
                                                
                                    <?php
                                    if($PlanMantenimientoDetalleAccion=="R"){
                                    //if(!empty( $PlanMantenimientoDetalleAccion) and $PlanMantenimientoDetalleAccion=="R"){
                                    //if(!empty( $PlanMantenimientoDetalleAccion)){
                                    ?>
                                    <tr>
                                        <td class="EstPlanMantenimientoTarea">
                                            
                                          <?php //echo $DatPlanMantenimientoTarea->PmtNombre;?>
                                        </td>
                                
                                            <?php
                                            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                            ?>
                                                <?php
                                                if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                                ?>
                                                
                                                
               <?php
                                $ProductoId = "";
                                $ProductoCodigoOriginal = "";
                                $ProductoNombre = "";
                                $ProductoUnidadMedida = "";
                                $ProductoUnidadMedidaNombre = "";
                                $ProductoUnidadMedidaOrigen = "";
                                $ProductoTipo = "";
                                
                                $ProductoCantidad = 0;
                                $ProductoPrecio = 0;		
                                $ProductoImporte = 0;
                                        
                                $InsTareaProducto = new ClsTareaProducto();
                                $ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajes[$POST_VehiculoMantenimientoKilometraje]['eq']);
                                $ArrTareaProductos = $ResTareaProducto['Datos'];
                                ?>
                                
                                <?php
                                foreach($ArrTareaProductos as $DatTareaProducto){
                                ?>
                                
                                    <?php
                                   // if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId){
                                    if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId and $DatTareaProducto->TprKilometraje == $DatKilometro['km']){
                                        
                                
                                        $InsProducto->ProId = $DatTareaProducto->ProId;
                                        $InsProducto->MtdObtenerProducto(false);
                                    
                                        $ProductoId = $DatTareaProducto->ProId;
                                        $ProductoCodigoOriginal = $DatTareaProducto->ProCodigoOriginal;
                                        $ProductoNombre = $DatTareaProducto->ProNombre;
                                        $ProductoUnidadMedida = $DatTareaProducto->UmeId;
                                        $ProductoUnidadMedidaNombre = $DatTareaProducto->UmeNombre;
                                        $ProductoUnidadMedidaOrigen = $InsProducto->UmeId;
                                        $ProductoTipo = $InsProducto->RtiId;
                                        $ProductoCantidad = $DatTareaProducto->TprCantidad;		
                                        
                                        
                                        $InsListaPrecio = new ClsListaPrecio();
                                        $ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$ProductoId,$POST_ClienteTipo,$ProductoUnidadMedida);
                                        $ArrListaPrecios = $ResListaPrecio['Datos'];
                                        
                                        foreach($ArrListaPrecios as $DatListaPrecio){
                                
                                            $ProductoPrecio = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);
                                            
                                        }
                                
                                        $ProductoImporte = $ProductoPrecio * $ProductoCantidad;
                                        
                                        break;
                                    }
                                    ?>
                                
                                <?php
                                }
                                ?>
                                                
                                                <td align="left"   >
                                                
                         


                                                <?php
                        

                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "R":
                        ?>
                        <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoNombre'];?>
                        <?php
                            break;
                           
                            case "X":
                        ?>
                        
                        <?php					
                            break;

							case "U":
                         ?>
                          <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoNombre'];?>
                         <?php						
                            break;
                        }
                        ?>



                    
                                                
                                                
                                                
                                                
                                      </td>
                                                <td align="center"   ><?php
                        

                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "R":
                        ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoCantidad'];?>
                                                  <?php
                            break;
                           
                            case "X":
                        ?>
                                                  <?php					
                            break;

							case "U":
                         ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoCantidad'];?>
                                                  <?php						
                            break;
                        }
                        ?></td>
                                                <td align="center"   >
                                                  
                                                  
                                                  
                                                  
                                                  <?php
                    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
                    ?>
                                                  
                                                  
                                                  <?php
                        

                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "R":
                        ?>
                                                  
                                                  <?php
                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                        ?>
                                                  
							
                            <?php
							if($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoUnidadMedida']==$DatProductoTipoUidadMedida->UmeId){
							?>
                            <?php echo $DatProductoTipoUidadMedida->UmeNombre;?>
                            <?php
							break;
							}
							?>
						<?php	
												  
												  
                        }							
                        ?>
                                                  
                                                  <?php
                            break;
                           
                            case "X":
                        ?>
                                                  
                                                  <?php					
                            break;

							case "U":
                         ?>
                               
                                                  <?php
                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                        ?>
                                                  
							
                            <?php
							if($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoUnidadMedida']==$DatProductoTipoUidadMedida->UmeId){
							?>
                            <?php echo $DatProductoTipoUidadMedida->UmeNombre;?>
                            <?php
							break;
							}
							?>
						<?php	
												  
												  
                        }							
                        ?>
                                                  		
                                                  <?php						
                            break;
                        }
                        ?>
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                      </td>
                                                <td align="right"   ><?php
                        

                        switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                        
                            case "R":
                        ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoImporte'];?>
                                                  <?php
                            break;
                           
                            case "X":
                        ?>
                                                  <?php					
                            break;

							case "U":
                         ?>
                                                  <?php echo $_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoImporte'];?>
                                                <?php						
                            break;
                        }
                        ?></td>
                                                <?php
                                                
                                                
                                                }
                                                ?>
                                                
                                            <?php	
                                            }
                                            ?>
                                    </tr>
                                    
									<?php
                                    $PresupuestoTotal += $ProductoImporte;
                                    ?>
                                    
                                    
                                    <?php
                                    }
                                    ?>
                            
                            
                            
                            
                                <?php			
                                }
                                ?>
                            
                            
                            <?php
							}
							?>
                                   
                    <?php
                    }
                    ?>  
                            </table>
                            
                            
                        <?php	
                            break;
                            
                            case "":
                        ?>
                            No se encontro la MARCA DEL VEHICULO
                        <?php	
                            break;
                            
                        }
                        ?>
                    
                              
            <?php
            }else{
            ?>
                No se encontro un plan de mantenimiento
            <?php	
            }
            ?>  
              
  </td>
                                <td valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="4" align="left" valign="top">&nbsp;</td>
                                <td align="right" valign="middle">Total Mantenimiento:</td>
                                <td width="39" align="right" valign="middle">
                                <?php echo number_format($POST_MantenimientoTotal,2);?>
</td>
                                <td width="1" align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="4" rowspan="2" align="left" valign="top">IMPORTANTE:<br>
Los precios contenidos en el presente presupuesto, son referenciales y estan sujetos cambios por parte de la empresa en cualquier momento. Para una mayor informacion por favor acercarse al AREA DE REPUESTOS. </td>
                                <td align="right" valign="middle">Mano de Obra:</td>
                                <td align="right" valign="middle"><?php echo number_format($POST_ManoObra,2);?></td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">Total Presupuesto:</td>
                                <td align="right" valign="middle"><?php echo number_format($POST_PresupuestoTotal,2);?></td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                            </table>
 
 

<?php	
}else if(empty($POST_VehiculoMarca)){
?>
	No ha escogido una Marca
<?php	
}else if(empty($POST_VehiculoModelo)){
?>
	No ha escgido un Modelo
<?php
}else if(empty($POST_ClienteTipo)){
?>
	No ha escogido un tipo de cliente
<?php
}else if(empty($POST_MantenimientoKilometraje)){
?>
	No ha escogido un kilometraje
<?php	
}
?>
            
           


            
            
            





</body>
</html>