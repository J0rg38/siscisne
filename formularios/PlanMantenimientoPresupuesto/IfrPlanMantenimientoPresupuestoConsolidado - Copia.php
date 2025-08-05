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
	header("Content-Disposition:  filename=\"RESUMEN_PLAN_MANTENIMIENTO_PRESUPUESTO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
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



<!--
Nombre: JQUERY AUTOCOMPLETE
Descripcion: Caja de Autocompletar
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.js"></script>-->
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.ajaxQueue.js'></script>
<!--<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox-compressed.js'></script>-->
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox.css" />-->

	

<script type="text/javascript">

$(function(){
	
	$("<div id='CapAutoCompletar' />").appendTo(document.body);
	
});
	
</script>


<script type="text/javascript" src="js/JsPlanMantenimientoPresupuestoConsolidadoFunciones.js"></script> 

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('css/CssPlanMantenimientoPresupuestoConsolidado.css');
</style>
<?php

$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];
$POST_VehiculoModelo = $_POST['CmpVehiculoModelo'];
$POST_MantenimientoKilometraje = $_POST['CmpMantenimientoKilometraje'];
$POST_ClienteTipo = $_POST['CmpClienteTipo'];

//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
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
if(!empty($POST_VehiculoMarca) and !empty($POST_VehiculoModelo) and !empty($POST_ClienteTipo)){
?>
	
   <form target="_blank" method="post" name="FrmPresupuesto" id="FrmPresupuesto" action="FrmPlanMantenimientoPresupuestoConsolidadoImprimir.php?P=1"> 
    
    <input type="hidden" name="CmpPlanMantenimientoId" id="CmpPlanMantenimientoId" value="<?php echo $InsPlanMantenimiento->PmaId;?>">

<input type="hidden" name="CmpVehiculoMarcaId" id="CmpVehiculoMarcaId" value="<?php echo $InsPlanMantenimiento->VmaId;?>">
<input type="hidden" name="CmpVehiculoModeloId" id="CmpVehiculoModeloId" value="<?php echo $InsPlanMantenimiento->VmoId;?>">
<input type="hidden" name="CmpVehiculoVersionId" id="CmpVehiculoVersionId" value="<?php echo $InsPlanMantenimiento->VveId;?>">


<input type="hidden" name="CmpVehiculoMarca" id="CmpVehiculoMarca" value="<?php echo $POST_VehiculoMarca;?>">
<input type="hidden" name="CmpVehiculoModelo" id="CmpVehiculoModelo" value="<?php echo $POST_VehiculoModelo;?>">

<input type="hidden" name="CmpMantenimientoKilometraje" id="CmpMantenimientoKilometraje" value="<?php echo $POST_MantenimientoKilometraje;?>">
<input type="hidden" name="CmpClienteTipo" id="CmpClienteTipo" value="<?php echo $POST_ClienteTipo;?>">

 
 
     <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                              <tr>
                                <td width="1">&nbsp;</td>
                                <td colspan="7"></td>
                                <td width="5">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="52" align="left" valign="top">Marca:              </td>
                                <td width="17" align="left"><?php echo $InsPlanMantenimiento->VmaNombre;?>
                                </td>
                                <td width="46" align="left">Modelo:</td>
                                <td width="311" align="left"><?php echo $InsPlanMantenimiento->VmoNombre;?> (<?php echo $InsPlanMantenimiento->VmoNombreComercial;?>)</td>
                                <td width="209" align="left" valign="top">&nbsp;</td>
                                <td width="44" colspan="2" align="left">&nbsp;</td>
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
                       // $PresupuestoTotal = 0;	
                        ?>
                      
                        <table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="right">
                            Kilómetros (x1000)
                            </td>
                                
							<?php
                            foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
                            
                                $PresupuestoTotal[$DatKilometroEtiqueta] = 0;	
                            ?>
                                <td colspan="4" align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>                                    
                            <?php	
                            }
                            ?>
                            
                            <td align="center" >-</td>
						</tr>
                                    
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

						   
							$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
							
							$MostrarSeccion = false;	
							foreach( $ArrPlanMantenimientoTareas  as $DatPlanMantenimientoTarea){
		
								foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
								
										$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
										$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesResumen[$POST_MantenimientoKilometraje]['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
										
										if($PlanMantenimientoDetalleAccion == "C" or $PlanMantenimientoDetalleAccion == "U"){
											$MostrarSeccion = true;
											break;
										}
										
									
									
								}
								
							}
						
                    ?>
                        <?php
						if(!empty($ArrPlanMantenimientoTareas) and $MostrarSeccion){						
                        ?>
                    
                            <tr>
                                <td align="left" class="EstPlanMantenimientoSeccion">
									<?php echo $DatPlanMantenimientoSeccion->PmsNombre;?>
								</td>
                                
                                <?php
								foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
								?>
                                <td align="center" class="EstPlanMantenimientoSeccion">Cod. Original</td>
                                <td align="center" class="EstPlanMantenimientoSeccion">U.M.</td>
                                <td align="center" class="EstPlanMantenimientoSeccion">Cantidad</td>
                                <td align="center" class="EstPlanMantenimientoSeccion">Importe</td>
                                <?php	
								}
								?>
                                
                                <td align="left" class="EstPlanMantenimientoSeccion">-</td>
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
                                    $MostrarTarea = false;
                                    
                                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
                                                  
                                         $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                            //$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
                                            
        //MtdObtenerPlanMantenimientoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
                                            $ResPlanMantenimientoDetalle = $InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalles(NULL,NULL,NULL,NULL,NULL,$InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);
                                            $ArrPlanMantenimientoDetalles = $ResPlanMantenimientoDetalle['Datos'];
        
                                            if(!empty($ArrPlanMantenimientoDetalles)){
                                                foreach($ArrPlanMantenimientoDetalles as $DatPlanMantenimientoDetalle){
                                                    
                                                    if($DatPlanMantenimientoDetalle->PmdAccion == "C"){
                                                        $MostrarTarea = true;
                                                        break;
                                                    }
                                                    
                                                }
                                            }
                                                                                            
                                        
                                    }
                                    ?>
                                        
									<?php
                                    if($MostrarTarea){
                                    ?>
                        
                                    <tr>
                                
										<td class="<?php echo (($PlanMantenimientoDetalleAccion=="C" or $PlanMantenimientoDetalleAccion=="U")?'EstPlanMantenimientoTareaActivo':'EstPlanMantenimientoTareaInactivo')?>">
											<?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
										</td>
                                    
                                                <?php
                                                foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
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
                                                        $ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajesResumen[$POST_VehiculoMantenimientoKilometraje]['eq']);
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
																	$ProductoPrecio = $ProductoPrecio*(($EmpresaMantenimientoPorcentajeManoObra/100)+1);
																	$ProductoPrecio = FncRedondearCYC($ProductoPrecio);
																
                                                                }
    
                                                                $ProductoImporte = $ProductoPrecio * $ProductoCantidad;
                                                                
                                                                break;
                                                                
                                                            }
                                                            ?>
                                                            
                                                        <?php
                                                        }
                                                        ?>
                        
										<td align="right"   >
                                                    
                                                    <?php
                                    /*
                                    SesionObjeto-FichaIngresoMantenimiento
                                    Parametro1 = FiaId
                                    Parametro2 = 
                                    Parametro3 = PmtId
                                    Parametro4 = FiaAccion
                                    Parametro5 = FiaTiempoCreacion
                                    Parametro6 = FiaTiempoModificacion
                                    Parametro7 = FiaNivel
                                    Parametro8 = FiaVerificar1
                                    Parametro9 = FiaVerificar2
                                    Parametro10 = FiaEstado
                                    */
                                    
                                    if(!empty($ArrSesionObjetos)){	
                                    
                                        foreach($ArrSesionObjetos as $DatSesionObjeto){
                                                
                                            $PlanMantenimientoDetalleId = '';
											$PlanMantenimientoDetalleAccion = '';
											
											$OpcAccion1 = '';
											$OpcAccion2 = '';
											$OpcAccion3 = '';
											$OpcAccion4 = '';	
                
                                            if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){
                                                
                                                $PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
                                                $PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro4;
                                                
                                                break;
                                            }					
                                        }
                                    }				
                                    ?>
                            
                            <?php
                           // echo $PlanMantenimientoDetalleAccion;
                            ?>
    
    
    
    <?php echo $ProductoCodigoOriginal;?></td>
          <td align="right"   >  <?php
                        $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                        $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
                        ?>
                        
        
                  <?php
                        if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
                        ?>
                        
                            <?php
                            foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                            ?>
                                <?php
                                if($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId){
                                ?>
                                    <?php 
                                    echo $DatProductoTipoUidadMedida->UmeNombre;
                                    ?>
                                <?php	
                                    break;
                                }
                                ?>
                                
                            
                  <?php	
                            }
                            ?>
                  <?php
                        }
                        ?></td>
                                                    <td align="right"   ><?php echo number_format($ProductoCantidad,2);?></td>
                                                    <td align="right"   ><?php echo number_format($ProductoImporte,2);?></td>
                                                <?php	
												 $PresupuestoTotal[$DatKilometroEtiqueta] += $ProductoImporte;
												 
                                                }
                                                ?>
                                    
                                        <td align="left"   >-</td>
                                
                                    </tr>
                                    
                                        <?php
                                       
										
//deb($PresupuestoTotal[$DatKilometroEtiqueta]);
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
                    
                    			 <tr>
                                 
                                 
                                  <td class="Total">TOTALES:</td>
                
                					
                                    <?php
                                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
                                    ?>
                                      <td colspan="4" align="right" class="Total"  >                      
                                      <?php echo number_format($PresupuestoTotal[$DatKilometroEtiqueta],2);?>                      
                                      </td>
                                    <?php	
                                    }
                                    ?>
                                


                                  <td align="left"   >-</td>
                                </tr>
                                
                     </table>
                                
                                
                                
                               
                       
                        <?php
                            break;
                            
                            case "VMA-10018"://ISUZU
                        ?>
                        
                        
                    <?php
                   // $PresupuestoTotal = 0;
                    ?>
                  
                           
                             
<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="right">Kilómetros (x1000)</td>
                                <?php
                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
									
									$PresupuestoTotal[$DatKilometroEtiqueta] = 0;	
                                ?>
                               
                            <td colspan="4" align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>
                               
                                <?php	
                                }
                                ?>
                                <td align="center" >-</td>
                            </tr>
                         
                
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
                    
							$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
							
							$MostrarSeccion = false;	
							foreach( $ArrPlanMantenimientoTareas  as $DatPlanMantenimientoTarea){
		
								foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
								
									
	
										$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
										$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesResumen[$POST_MantenimientoKilometraje]['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
										
										if($PlanMantenimientoDetalleAccion == "R" or $PlanMantenimientoDetalleAccion == "U"){
											$MostrarSeccion = true;
											break;
										}
										
									
								}
								
							}
                    ?>
						
                        <?php
						if(!empty($ArrPlanMantenimientoTareas) and $MostrarSeccion){
						?>
                        <tr>
                            <td align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
                            
                               <?php
                                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
                                                ?>
<td align="center" class="EstPlanMantenimientoSeccion">Cod. Original</td>
<td align="center" class="EstPlanMantenimientoSeccion">U.M.</td>
<td align="center" class="EstPlanMantenimientoSeccion">Cantidad</td>
<td align="center" class="EstPlanMantenimientoSeccion">Importe</td>
<?php
												}
?>
<td align="left" class="EstPlanMantenimientoSeccion">-</td>
                            
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
							$MostrarTarea = false;
							
                            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
                        
								    $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                    $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
									
//MtdObtenerPlanMantenimientoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
									$ResPlanMantenimientoDetalle = $InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalles(NULL,NULL,NULL,NULL,NULL,$InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);
									$ArrPlanMantenimientoDetalles = $ResPlanMantenimientoDetalle['Datos'];

									if(!empty($ArrPlanMantenimientoDetalles)){
										foreach($ArrPlanMantenimientoDetalles as $DatPlanMantenimientoDetalle){
											
											if($DatPlanMantenimientoDetalle->PmdAccion == "R"){
												$MostrarTarea = true;
												break;
											}
											
										}
									}										//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
							
                            }
									
									
                                    ?>
                                       
                                    <?php
									
									if($MostrarTarea){					   
                                    ?>
                                       
                                       
                                        <tr>
                                            <td class="EstPlanMantenimientoTarea">
                                               
                                                <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
                                            </td>
                                    
                                                <?php
                                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
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
                                    $ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajesResumen[$POST_VehiculoMantenimientoKilometraje]['eq']);
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
												$ProductoPrecio = $ProductoPrecio*(($EmpresaMantenimientoPorcentajeManoObra/100)+1);
																$ProductoPrecio = FncRedondearCYC($ProductoPrecio);
																
																
                                                
                                            }
                                    
                                            $ProductoImporte = $ProductoPrecio * $ProductoCantidad;
                                            
                                            break;
                                        }
                                        ?>
                                    
                                    <?php
                                    }
                                    ?>
                                                    
                                                    <td align="right"   >
                           <?php
                                    /*
                                    SesionObjeto-FichaIngresoMantenimiento
                                    Parametro1 = FiaId
                                    Parametro2 = 
                                    Parametro3 = PmtId
                                    Parametro4 = FiaAccion
                                    Parametro5 = FiaTiempoCreacion
                                    Parametro6 = FiaTiempoModificacion
                                    Parametro7 = FiaNivel
                                    Parametro8 = FiaVerificar1
                                    Parametro9 = FiaVerificar2
                                    Parametro10 = FiaEstado
                                    */
                                    
                                    if(!empty($ArrSesionObjetos)){	
                                    
                                        foreach($ArrSesionObjetos as $DatSesionObjeto){
                                                
                                            $PlanMantenimientoDetalleId = '';
											$PlanMantenimientoDetalleAccion = '';
											
											$OpcAccion1 = '';
											$OpcAccion2 = '';
											$OpcAccion3 = '';
											$OpcAccion4 = '';	
                
                                            if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){
                                                
                                                $PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
                                                $PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro4;
                                                
                                                break;
                                            }					
                                        }
                                    }				
                                    ?> 
                            <?php
							//echo $PlanMantenimientoDetalleAccion;
							?>

                                                    
<?php echo $ProductoCodigoOriginal;?></td>
                                                    <td align="right"   >
                                                    
                                                    <?php
                                    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                                    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
                                    ?>
                                                     
                                                        <?php
                                    if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
                                    ?>
                                                        <?php
                                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                                        ?>
                                        
                                        	<?php
											if($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId){
											?>
                                            	<?php echo $DatProductoTipoUidadMedida->UmeNombre?>
                                            <?php	
												break;
											}
											
											?>
                                                        
                                                        <?php	
                                        }
                                        ?>
                                <?php
                                    }
                                    ?>
                                    </td>
                                                    <td align="right"   ><?php echo number_format($ProductoCantidad,2);?></td>
                                                    <td align="right"   ><?php echo number_format($ProductoImporte,2);?></td>
                                                   
                                                    
                                                <?php	
												$PresupuestoTotal[$DatKilometroEtiqueta] += $ProductoImporte;
												
                                                }
                                                ?>
                                    
                                        <td align="left"   >-
                                        
    
    
    </td>
                                        </tr>
                                        
                                        <?php
										
										
                                      
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
                                                 <tr>
                                          <td class="Total">TOTALES:</td>
                                          
<?php
foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
?>
    <td colspan="4" align="right" class="Total"   >
    
    <?php echo number_format($PresupuestoTotal[$DatKilometroEtiqueta],2);?>
    
    </td>
<?php	
}
?>
                                      
                                          <td align="left"   >-</td>
                                        </tr>
                   
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
                            </table>
 
 	</form>

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