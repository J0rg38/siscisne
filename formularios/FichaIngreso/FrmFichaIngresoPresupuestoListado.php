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
	header("Content-Disposition:  filename=\"CONSULTA_PLAN_MANTENIMIENTO_PRESUPUESTO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

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


<!--
Nombre: JQUERY AUTOCOMPLETE
Descripcion: Caja de Autocompletar
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.js"></script>-->
<!--<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.bgiframe.min.js'></script>-->
<!--<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.ajaxQueue.js'></script>-->
<!--<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox-compressed.js'></script>-->
<!--<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.css" />-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox.css" />-->

	

<!--<script type="text/javascript">

//$(function(){
//	
//	$("<div id='CapAutoCompletar' />").appendTo(document.body);
//	
//});
//	
</script>
-->
<!--
<script type="text/javascript" src="js/JsPlanMantenimientoPresupuestoConsultaFunciones.js"></script> 
-->
<!-- ARCHIVO DE ESTILOS CSS -->
<!--<style type="text/css">
@import url('css/CssPlanMantenimientoPresupuestoConsulta.css');
</style>-->
<?php

$POST_VehiculoMarca = $_POST['VehiculoMarca'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];
$POST_MantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
$POST_ClienteTipo = $_POST['ClienteTipo'];

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

$POST_MantenimientoKilometraje;


deb($POST_MantenimientoKilometraje);

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
	
   <form target="_blank" method="post" name="FrmPresupuesto" id="FrmPresupuesto" action="formularios/PlanMantenimientoPresupuesto/FrmPlanMantenimientoPresupuestoConsultaImprimir.php?P=1"> 
    
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
                                <td width="1">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="55" align="left" valign="top">Marca:              </td>
                                <td width="190" align="left"><?php echo $InsPlanMantenimiento->VmaNombre;?>
                                </td>
                                <td width="64" align="left">Modelo:              </td>
                                <td width="243" align="left"><?php echo $InsPlanMantenimiento->VmoNombre;?></td>
                                <td width="269" align="left" valign="top">&nbsp;</td>
                                <td colspan="2" align="left">&nbsp;</td>
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
                      
                        <table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="94" align="right">Kilómetros (x1000)</td>
                                
                                <?php
                                foreach($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
                                ?>
                                    <?php if($POST_MantenimientoKilometraje == $DatKilometro['km']){?>
                                        <td colspan="9" align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>
                                    <?php	}?>
                                <?php	
                                }
                                ?><td width="83" align="center" >&nbsp;</td>
                            </tr>
                                    
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

						   $MostrarSeccion = false;
						   //MtdObtenerPlanMantenimientoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
						   $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
						   $ResPlanMantenimientoDetalle = $InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalles(NULL,NULL,'PmdId','Desc',NULL,$InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,NULL);
						   $ArrPlanMantenimientoDetalles = $ResPlanMantenimientoDetalle['Datos'];
						   
						   foreach($ArrPlanMantenimientoDetalles as $DatPlanMantenimientoDetalle){
							   if($DatPlanMantenimientoDetalle->PmdAccion == "C" or $DatPlanMantenimientoDetalle->PmdAccion == "U" ){
									$MostrarSeccion = true;
									break;
								}
						   }
						   
						   //
							$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
//							

						
                    ?>
                        <?php
						//if(!empty($ArrPlanMantenimientoTareas) and $MostrarSeccion){						
						if($MostrarSeccion){						
                        ?>
                    
                            <tr>
                                <td align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
                                <td width="106" align="center" class="EstPlanMantenimientoSeccion">&nbsp;</td>
                                <td width="144" align="center" class="EstPlanMantenimientoSeccion">Cod. Original</td>
                                <td width="210" align="center" class="EstPlanMantenimientoSeccion">Nombre</td>
                                <td width="163" align="center" class="EstPlanMantenimientoSeccion">U.M.</td>
                                <td width="55" align="center" class="EstPlanMantenimientoSeccion">Cantidad</td>
                                <td width="39" align="center" class="EstPlanMantenimientoSeccion">Precio</td>
                                <td width="48" align="center" class="EstPlanMantenimientoSeccion">Importe</td>
                                <td align="center" class="EstPlanMantenimientoSeccion">Stock</td>
                                <td align="center" class="EstPlanMantenimientoSeccion">Prom.</td>
                                <td align="left" class="EstPlanMantenimientoSeccion">&nbsp;</td>
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
							
                            foreach($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
                        
                                if($POST_MantenimientoKilometraje == $DatKilometro['km']){
                                  	
								    $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                    $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
									
//MtdObtenerPlanMantenimientoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
									$ResPlanMantenimientoDetalle = $InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalles(NULL,NULL,NULL,NULL,NULL,$InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);
									$ArrPlanMantenimientoDetalles = $ResPlanMantenimientoDetalle['Datos'];

									if(!empty($ArrPlanMantenimientoDetalles)){
										foreach($ArrPlanMantenimientoDetalles as $DatPlanMantenimientoDetalle){
											
											if($DatPlanMantenimientoDetalle->PmdAccion == "C" or $DatPlanMantenimientoDetalle->PmdAccion == "U" ){

												//$PlanMantenimientoDetalleAccion = $DatPlanMantenimientoDetalle->PmdAccion;
												$MostrarTarea = true;
												break;

											}
											
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
                                        
                                        <?php
										//deb($PlanMantenimientoDetalleAccion);
										?>
                                            <input style="visibility:hidden;" checked="checked" etiqueta="tarea2" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
                                            
                                            <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
                                            
                                        </td>
                                
                                            <?php
                                            foreach($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
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
													$ProductoStockReal = 0;
													$ProductoTienePromocion = 2;
                                                    $ProductoPrecio = 0;		
                                                    $ProductoImporte = 0;
                                                            
                                                    $InsTareaProducto = new ClsTareaProducto();
													$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq']);
                                                    $ArrTareaProductos = $ResTareaProducto['Datos'];
                                                    ?>
                                                    
                                                    <?php
                                                    foreach($ArrTareaProductos as $DatTareaProducto){
                                                    ?>
                                                    
                                                        <?php
                                                       // if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId and $DatTareaProducto->TprKilometraje == $DatKilometro['km']){
                                                        if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId and $DatTareaProducto->TprKilometraje ==  $InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq']){
                                                             
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
                                                            $ProductoStockReal = $DatTareaProducto->ProStockReal;	
                                            				$ProductoTienePromocion = $DatTareaProducto->ProTienePromocion;	
											
                                                            $TareaProductoId = $DatTareaProducto->TprId;		
                                                            
                                                            $InsListaPrecio = new ClsListaPrecio();
                                                            $ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$ProductoId,$POST_ClienteTipo,$ProductoUnidadMedida);
                                                            $ArrListaPrecios = $ResListaPrecio['Datos'];
                                
                                                            foreach($ArrListaPrecios as $DatListaPrecio){
                                                    
                                                                $ProductoPrecio = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);									
																//$EmpresaMantenimientoPorcentajeManoObra/100
																//$ProductoPrecio = $ProductoPrecio*1.1;
																//$ProductoPrecio = $ProductoPrecio*(($EmpresaMantenimientoPorcentajeManoObra/100)+1);
																$ProductoPrecio = FncRedondearCYC($ProductoPrecio);
																$ProductoPrecio = round($ProductoPrecio,2);		
																
                                                            }

                                                            $ProductoImporte = ($ProductoPrecio) * $ProductoCantidad;
                                                            
                                                            break;
                                                            
                                                        }
                                                        ?>
                                                        
                                                    <?php
                                                    }
                                                    ?>
                    
                                                	<td align="right"   >
                                                    
                                                    <?php
													//deb($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq']);
													?>
												
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
                        
                        //echo "<br>";
                        //echo $PlanMantenimientoDetalleAccion;
                        //echo "<br>";
                        
                        switch($PlanMantenimientoDetalleAccion){
                        
                            case "I":
                                $OpcAccion1 = 'selected="selected"';
                            break;
                            
                            case "C":
                                $OpcAccion2 = 'selected="selected"';
                            break;
                            
                            case "R":
                                $OpcAccion3 = 'selected="selected"';					
                            break;
                            
                            case "X":
                                $OpcAccion4 = 'selected="selected"';						
                            break;

							case "U":
					$OpcAccion5 = 'selected="selected"';						
				break;

case "P":
					$OpcAccion6 = 'selected="selected"';						
				break;
				
				
            }
                        ?>
                                                  <select class="EstFormularioCombo"  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  >
                                                    <option value="X" <?php echo $OpcAccion4;?>>X</option>
                                                    <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
                                                    <option value="U" <?php echo $OpcAccion5;?>>Agregar</option>
<option value="P" <?php echo $OpcAccion6;?>>Consultivo</option>
            </select></td>
                                                <td align="center"   >


<input name="CmpProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="hidden" class="EstFormularioCaja"  readonly="readonly"   id="CmpProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="15" value="<?php echo $ProductoId;?>" />
                        
<input name="CmpProductoCodigoOriginal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" class="EstFormularioCaja"  readonly="readonly"   id="CmpProductoCodigoOriginal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="10" value="<?php echo $ProductoCodigoOriginal;?>" />


                                                
                                  </td>
                                                <td align="left"   >
                    
                                             
                      <input name="CmpProductoNombre_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" class="EstFormularioCaja"  readonly="readonly"   id="CmpProductoNombre_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="35" value="<?php echo $ProductoNombre;?>" />
                    
                                  </td>
                                                <td align="left"   >
                                                
                    <?php
                    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
                    ?>
                    
                    <select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir_<?php echo $DatPlanMantenimientoTarea->PmtId?>" id="CmpProductoUnidadMedidaConvertir_<?php echo $DatPlanMantenimientoTarea->PmtId?>" disabled="disabled" >
                    
                    <option value="">Escoja una opcion</option>
                    
                    <?php
                    if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
                    ?>
                    
                        <?php
                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                        ?>
                            <option <?php echo (($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>    
                        
                        <?php	
                        }
                        ?>
                    <?php
                    }
                    ?>
                    
                    </select>
<input type="hidden" name="CmpProductoUnidadMedida_<?php echo $DatPlanMantenimientoTarea->PmtId?>" id="CmpProductoUnidadMedida_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="<?php echo $ProductoUnidadMedida;?>">
                    
                    
                    </td>
                                                <td align="center"   >
                                                
                    <input class="EstFormularioCajaDeshabilitada" name="CmpProductoCantidad_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" type="text"  readonly id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="5" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  />
                    
                    </td>
                                                <td align="center"   >
                                                
                                                <input class="EstFormularioCajaDeshabilitada" name="CmpProductoPrecio_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" type="text" readonly id="CmpProductoPrecio_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" value="<?php echo number_format($ProductoPrecio,2);?>"  />
                                                
                                                </td>
                                                <td align="center"   ><input class="EstFormularioCajaDeshabilitada" name="CmpProductoImporte_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" readonly id="CmpProductoImporte_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" value="<?php echo number_format($ProductoImporte,2);?>"   /></td>
                                                <td align="center"   ><input class="EstFormularioCajaDeshabilitada" name="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" readonly id="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" value="<?php echo number_format($ProductoStockReal,2);?>"   /></td>
                                  				<td align="center"   >
                                  
                                  <?php
												$OpcTienePromocion1 = "";
												$OpcTienePromocion2 = "";
												
												//deb($ProductoTienePromocion);
												 switch($ProductoTienePromocion){
                        
                            case "1":
                                $OpcTienePromocion1 = 'selected="selected"';
                            break;
                            
                            case "2":
                                $OpcTienePromocion2 = 'selected="selected"';
                            break;
                            
                           
                        }
												?>
                                                <select  disabled="disabled" class="EstFormularioCombo"  name="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  >
                                                    <option value="1" <?php echo $OpcTienePromocion1;?> >Si</option>
                                                    <option value="2" <?php echo $OpcTienePromocion2;?> >No</option>

                                                </select>
                                  
                                  
                                  					</td>
                                                <?php
                                                }
                                                ?>
                                                
                                            <?php	
                                            }
                                            ?>
                                
                                    <td align="left"   >
                                    
                                                
                <?php
				if($_SESSION['MysqlDeb'] == 1){
				?>
                                    <span style="color:#F5F5F5">(<?php echo $DatPlanMantenimientoTarea->PmtId;?>) / (<?php echo $PlanMantenimientoDetalleId?>)</span>
                                      <span style="color:#F8F8F8;" >(<?php echo $TareaProductoId?>) </span>
                                    <?php
				}
									?>
                                    
                                  
                                    
                                    
                                    </td>
                            
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
                     <tr>
                       <td colspan="11">ADICIONALES:</td>
                       </tr>
                       
                       <?php
					   
					   $AdicionalTotal = 0;
					for($i=1;$i<5;$i++){   
					   ?>
                     <tr>
                       <td><input style="visibility:hidden;" checked="checked" etiqueta="adicional" type="checkbox" name="CmpPresupuestoAdicional_<?php echo $i;?>" id="CmpPresupuestoAdicional_<?php echo $i;?>" value="<?php echo $i;?>" /></td>
                       <td align="right"   >


Item <?php echo $i;?>


                       </td>
                       <td align="left"   >
                       
                       
 
 
 				<table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                  
                  <input name="CmpProductoId_<?php echo $i;?>" type="hidden" class="EstFormularioCaja"  readonly="readonly"   id="CmpProductoId_<?php echo $i;?>" size="5" value="" />
                  
                  <a  id="BtnPlanMantenimientoDetalleNuevo_<?php echo $i;?>" href="javascript:FncPlanMantenimientoDetalleNuevo('<?php echo $i;?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>   
                  
                  
                  </td>
                  <td><input name="CmpProductoCodigoOriginal_<?php echo $i;?>" type="text" class="EstFormularioCaja"   id="CmpProductoCodigoOriginal_<?php echo $i;?>" size="10" value="" /></td>
                <td>
                
                  <a id="BtnProductoBuscar_<?php echo $i;?>" href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $i;?>');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
            
                       
                  </td>
                    </tr>
                    </table>   
                       </td>
                       <td align="left"   >
                       
                       <input name="CmpProductoNombre_<?php echo $i;?>" type="text" class="EstFormularioCaja"   id="CmpProductoNombre_<?php echo $i;?>" size="35" value="" />
                       
                       
                       </td>
                       <td align="left"   ><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir_<?php echo $i;?>" id="CmpProductoUnidadMedidaConvertir_<?php echo $i;?>" disabled="disabled" >
                         <option value="">Escoja una opcion</option>
                         <?php
                    if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
                    ?>
                         <?php
                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                        ?>
                         <option <?php echo (($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>
                         <?php	
                        }
                        ?>
                         <?php
                    }
                    ?>
                       </select>
                       <input type="hidden" name="CmpProductoUnidadMedida_<?php echo $i;?>" id="CmpProductoUnidadMedida_<?php echo $i;?>" value=""></td>
                      
                       <td align="center"   ><input name="CmpProductoCantidad_<?php echo $i;?>" type="text" class="EstFormularioCaja" id="CmpProductoCantidad_<?php echo $i;?>" size="5" maxlength="10" value=""  /></td>
                       
                     
                       <td align="center"   ><input name="CmpProductoPrecio_<?php echo $i;?>" type="text" class="EstFormularioCajaDeshabilitada" readonly id="CmpProductoPrecio_<?php echo $i;?>" size="5" maxlength="10" value="0"  /></td>
                       <td align="center"   ><input name="CmpProductoImporte_<?php echo $i;?>" type="text" class="EstFormularioCajaDeshabilitada" readonly id="CmpProductoImporte_<?php echo $i;?>" size="5" maxlength="10" value=""   /></td>
                       <td align="center"   ><input class="EstFormularioCajaDeshabilitada" name="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" readonly id="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" /></td>
                     
                       <td align="center"   ><select  disabled="disabled" class="EstFormularioCombo"  name="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  >
                                                    <option value="1" <?php echo $OpcTienePromocion1;?> >Si</option>
                                                    <option value="2" <?php echo $OpcTienePromocion2;?> >No</option>

                                                </select></td>
                     
                       <td align="left"   >&nbsp;</td>
                     </tr>
 					<?php
						//$AdicionalTotal += 
					}
					?>
                    
                     <tr>
                                  <td>&nbsp;</td>
                                  <td align="right"   >&nbsp;</td>
                                  <td align="left"   >&nbsp;</td>
                                  <td align="left"   >&nbsp;</td>
                                  <td align="left"   >&nbsp;</td>
                                  <td align="center"   >&nbsp;</td>
                                  <td align="center"   >&nbsp;</td>
                                  <td align="center"   >&nbsp;</td>
                                  <td align="center"   >&nbsp;</td>
                                  <td align="center"   >&nbsp;</td>
                                  <td align="left"   >&nbsp;</td>
                                </tr>
                            
                                  </table>
                                
                                
                                
                               
                       
                        <?php
                            break;
                            
                            case "VMA-10018"://ISUZU
                        ?>
                        
                        
                    <?php
                    $PresupuestoTotal = 0;
                    ?>
                  
                           
                             
<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="right">Kilómetros (x1000)</td>
                                <?php
                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                ?>
                                <?php if($POST_MantenimientoKilometraje == $DatKilometro['km']){?>
                            <td colspan="9" align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>
                                <?php	}?>
                                <?php	
                                }
                                ?><td align="center" >&nbsp;</td>
                            </tr>
                         
                
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
                    
					

							$MostrarSeccion = false;
						   //MtdObtenerPlanMantenimientoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
						   $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
						   $ResPlanMantenimientoDetalle = $InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalles(NULL,NULL,'PmdId','Desc',NULL,$InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,NULL);
						   $ArrPlanMantenimientoDetalles = $ResPlanMantenimientoDetalle['Datos'];
						   
						   foreach($ArrPlanMantenimientoDetalles as $DatPlanMantenimientoDetalle){
							   if($DatPlanMantenimientoDetalle->PmdAccion == "R" or $DatPlanMantenimientoDetalle->PmdAccion == "U" ){
									$MostrarSeccion = true;
									break;
								}
						   }
						   
						   //
							$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
							
							
							//$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
//							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
//							
//							$MostrarSeccion = false;	
//							foreach( $ArrPlanMantenimientoTareas  as $DatPlanMantenimientoTarea){
//		
//								foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
//								
//									if($POST_MantenimientoKilometraje == $DatKilometro['km']){
//	
//										$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
//										$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
//										
//										if($PlanMantenimientoDetalleAccion == "R" or $PlanMantenimientoDetalleAccion == "U"){
//											$MostrarSeccion = true;
//											break;
//										}
//										
//									}
//									
//								}
//								
//							}
                    ?>
						
                        <?php
						//if(!empty($ArrPlanMantenimientoTareas) and $MostrarSeccion){
						if($MostrarSeccion){			
						?>
                        <tr>
                            <td align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
<td align="center" class="EstPlanMantenimientoSeccion">&nbsp;</td>
<td align="center" class="EstPlanMantenimientoSeccion">Cod. Original</td>
                          <td align="center" class="EstPlanMantenimientoSeccion">Nombre</td>
                          <td align="center" class="EstPlanMantenimientoSeccion">U.M.</td>
                          <td align="center" class="EstPlanMantenimientoSeccion">Cantidad</td>
                          <td align="center" class="EstPlanMantenimientoSeccion">Precio</td>
                          <td align="center" class="EstPlanMantenimientoSeccion">Importe</td>
                          <td align="center" class="EstPlanMantenimientoSeccion">Stock</td>
                          <td align="center" class="EstPlanMantenimientoSeccion">Prom.</td>
                          <td align="left" class="EstPlanMantenimientoSeccion">&nbsp;</td>
                            
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
							
                            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                        
                                if($POST_MantenimientoKilometraje == $DatKilometro['km']){
                                  
								    $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                    $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
									
//MtdObtenerPlanMantenimientoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
									$ResPlanMantenimientoDetalle = $InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalles(NULL,NULL,NULL,NULL,NULL,$InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);
									$ArrPlanMantenimientoDetalles = $ResPlanMantenimientoDetalle['Datos'];

									if(!empty($ArrPlanMantenimientoDetalles)){
										foreach($ArrPlanMantenimientoDetalles as $DatPlanMantenimientoDetalle){
											
											if($DatPlanMantenimientoDetalle->PmdAccion == "R" or $DatPlanMantenimientoDetalle->PmdAccion == "U"){
												$MostrarTarea = true;
												break;
											}
											
										}
									}										//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL)
									
                                }
                            }
									
									
                                    ?>
                                       
                                    <?php
									
                                 /*   if(
									$PlanMantenimientoDetalleAccion=="R" 
									or $PlanMantenimientoDetalleAccion=="U"
									){
                                   			*/
									if($MostrarTarea){					   
                                    ?>
                                       
                                        <tr>
                                                                       
<td class="<?php echo (($PlanMantenimientoDetalleAccion=="R" or $PlanMantenimientoDetalleAccion=="U")?'EstPlanMantenimientoTareaActivo':'EstPlanMantenimientoTareaInactivo')?>">
                                                <input style="visibility:hidden;" checked="checked" etiqueta="tarea2" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
                                                <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
                                            </td>
                                    
                                                <?php
                                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                                ?>
                                                    <?php
                                                    if($POST_MantenimientoKilometraje == $DatKilometro['km']){
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
									$ProductoStockReal = 0;
									$ProductoTienePromocion = 2;
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
                                        //if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId and $DatTareaProducto->TprKilometraje == $DatKilometro['km']){
                                        if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId and $DatTareaProducto->TprKilometraje ==  $InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq']){
                                                        
                                    
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
                                            $ProductoStockReal = $DatTareaProducto->ProStockReal;	
                                            $ProductoTienePromocion = $DatTareaProducto->ProTienePromocion;	
											
											
                                            
                                            $InsListaPrecio = new ClsListaPrecio();
                                            $ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$ProductoId,$POST_ClienteTipo,$ProductoUnidadMedida);
                                            $ArrListaPrecios = $ResListaPrecio['Datos'];
                                            
                                            foreach($ArrListaPrecios as $DatListaPrecio){
                                    
                                                $ProductoPrecio = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);
                                             	//$ProductoPrecio = $ProductoPrecio*1.1;
												//$ProductoPrecio = $ProductoPrecio*(($EmpresaMantenimientoPorcentajeManoObra/100)+1);
												$ProductoPrecio = FncRedondearCYC($ProductoPrecio);
												$ProductoPrecio = round($ProductoPrecio,2);		   
                                            }
                                    
                                            $ProductoImporte = ($ProductoPrecio) * $ProductoCantidad;
                                            
                                            break;
                                        }
                                        ?>
                                    
                                    <?php
                                    }
                                    ?>
                                                    
                                                    <td align="right"   ><?php
                            
                            //echo "<br>";
                            //echo $PlanMantenimientoDetalleAccion;
                            //echo "<br>";
                            
                            switch($PlanMantenimientoDetalleAccion){
                            
                                case "R":
                                    $OpcAccion1 = 'selected="selected"';					
                                break;
                                
                                case "X":
                                    $OpcAccion2 = 'selected="selected"';						
                                break;
    
                                case "U":
                                    $OpcAccion3 = 'selected="selected"';						
                                break;
                                
                            }
                            ?>
                                                      <select  class="EstFormularioCombo" name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  >
                                                      <option value="X" <?php echo $OpcAccion2;?>>X</option>
                                                      <option value="R" <?php echo $OpcAccion1;?>>Reemplazar</option>
                                                      <option value="U" <?php echo $OpcAccion3;?>>Agregar</option>
                                                    </select></td>
                                                    <td align="left"   >
                                                    

<input name="CmpProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="hidden" class="EstFormularioCaja"  readonly="readonly"   id="CmpProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="15" value="<?php echo $ProductoId;?>" />

                                                    <input name="CmpProductoCodigoOriginal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" class="EstFormularioCajaDeshabilitada"   id="CmpProductoCodigoOriginal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="<?php echo $ProductoCodigoOriginal;?>" size="10"  readonly="readonly" /></td>
                                                    <td align="left"   >
                                                    
                             
    
                                                    <input name="CmpProductoNombre_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" class="EstFormularioCajaDeshabilitada"   id="CmpProductoNombre_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="<?php echo $ProductoNombre;?>" size="35"  readonly="readonly" />
                                                    
                                                    
                                                    
                      </td>
                                                    <td align="left"   ><?php
                                    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                                    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
                                    ?>
                                                      <select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir_<?php echo $DatPlanMantenimientoTarea->PmtId?>" id="CmpProductoUnidadMedidaConvertir_<?php echo $DatPlanMantenimientoTarea->PmtId?>" disabled="disabled" >
                                                        <option value="">Escoja una opcion</option>
                                                        <?php
                                    if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
                                    ?>
                                                        <?php
                                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                                        ?>
                                                        <option <?php echo (($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>
                                                        <?php	
                                        }
                                        ?>
                                                        <?php
                                    }
                                    ?>
                                                    </select>
                                                    <input type="hidden" name="CmpProductoUnidadMedida_<?php echo $DatPlanMantenimientoTarea->PmtId?>" id="CmpProductoUnidadMedida_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="<?php echo $ProductoUnidadMedida;?>">
                                                    </td>
                                                    <td align="center"   >
                                                    
                                                    <input name="CmpProductoCantidad_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" class="EstFormularioCajaDeshabilitada" readonly id="CmpProductoCantidad_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  /></td>
                                                    <td align="center"   >


                                <input class="EstFormularioCajaDeshabilitada" name="CmpProductoPrecio_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text"  readonly id="CmpProductoPrecio_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" value="<?php echo number_format($ProductoPrecio,2);?>"  /></td>
                                          <td align="center"   ><input name="CmpProductoImporte_<?php echo $DatPlanMantenimientoTarea->PmtId?>2" type="text" class="EstFormularioCajaDeshabilitada" readonly id="CmpProductoImporte_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" value="<?php echo number_format($ProductoImporte,2);?>"  /></td>
                                                    <td align="center"   ><input class="EstFormularioCajaDeshabilitada" name="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" readonly id="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" value="<?php echo number_format($ProductoStockReal,2);?>"   /></td>
                                                    <td align="center"   >
                                                    
                                                    
                                                    <?php
													  $OpcTienePromocion1 = "";
												$OpcTienePromocion2 = "";
												
												 switch($ProductoTienePromocion){
                        
                            case "1":
                                $OpcTienePromocion1 = 'selected="selected"';
                            break;
                            
                            case "2":
                                $OpcTienePromocion2 = 'selected="selected"';
                            break;
                            
                           
                        }
												?>
                                                    
                                                    <select  disabled="disabled" class="EstFormularioCombo"  name="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  >
                                                    <option value="1" <?php echo $OpcTienePromocion1;?> >Si</option>
                                                    <option value="2" <?php echo $OpcTienePromocion2;?> >No</option>

                                                </select>
                                                    
                                                    </td>
                                                    
                                                    
                                                    
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                <?php	
                                                }
                                                ?>
                                    
                                        <td align="left"   >
                                            
                                           
                                        
                                         &nbsp;           
                                <?php
                                if($_SESSION['MysqlDeb'] == 1){
                                ?>
                                    <span style="color:#F5F5F5">(<?php echo $DatPlanMantenimientoTarea->PmtId;?>) / (<?php echo $PlanMantenimientoDetalleId?>)</span>   <span style="color:#F8F8F8;" >(<?php echo $TareaProductoId?>) </span>
                                        
                                <?php
                                }
                        ?>
                                     
    
    
    </td>
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
                    
                     <tr>
                       <td colspan="11" class="EstPlanMantenimientoTarea">ADICIONALES:</td>
                     </tr>
                       <?php
					   $AdicionalTotal = 0;
					for($i=1;$i<5;$i++){   
					   ?>
                     <tr>
                       <td><input style="visibility:hidden;" checked="checked" etiqueta="adicional" type="checkbox" name="CmpPresupuestoAdicional_<?php echo $i;?>" id="CmpPresupuestoAdicional_<?php echo $i;?>" value="<?php echo $i;?>" /></td>
                       <td align="right"   >


Item <?php echo $i;?>


                       </td>
                       <td align="left"   >
                       
                       
 
 
 				<table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                  
                  <input name="CmpProductoId_<?php echo $i;?>" type="hidden" class="EstFormularioCaja"  readonly="readonly"   id="CmpProductoId_<?php echo $i;?>" size="5" value="" />
                  
                  <a  id="BtnPlanMantenimientoDetalleNuevo_<?php echo $i;?>" href="javascript:FncPlanMantenimientoDetalleNuevo('<?php echo $i;?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>   
                  
                  
                  </td>
                  <td><input name="CmpProductoCodigoOriginal_<?php echo $i;?>" type="text" class="EstFormularioCaja"   id="CmpProductoCodigoOriginal_<?php echo $i;?>" size="10" value="" /></td>
                <td>
                
                  <a id="BtnProductoBuscar_<?php echo $i;?>" href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $i;?>');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
            
                       
                  </td>
                    </tr>
                    </table>   
                       </td>
                       <td align="left"   >
                       
                       <input name="CmpProductoNombre_<?php echo $i;?>" type="text" class="EstFormularioCaja"   id="CmpProductoNombre_<?php echo $i;?>" size="35" value="" />
                       
                       
                       </td>
                       <td align="left"   ><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir_<?php echo $i;?>" id="CmpProductoUnidadMedidaConvertir_<?php echo $i;?>" disabled="disabled" >
                         <option value="">Escoja una opcion</option>
                         <?php
                    if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
                    ?>
                         <?php
                        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
                        ?>
                         <option <?php echo (($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>
                         <?php	
                        }
                        ?>
                         <?php
                    }
                    ?>
                       </select>
                       <input type="hidden" name="CmpProductoUnidadMedida<?php echo $i;?>" id="CmpProductoUnidadMedida<?php echo $i;?>" value=""></td>
                      
                       <td align="center"   ><input name="CmpProductoCantidad_<?php echo $i;?>" type="text" class="EstFormularioCaja" id="CmpProductoCantidad_<?php echo $i;?>" size="5" maxlength="10" value=""  /></td>
                       
                     
                       <td align="center"   ><input name="CmpProductoPrecio_<?php echo $i;?>" type="text" class="EstFormularioCajaDeshabilitada" readonly id="CmpProductoPrecio_<?php echo $i;?>" size="5" maxlength="10" value="0"  /></td>
                       <td align="center"   ><input name="CmpProductoImporte_<?php echo $i;?>" type="text" class="EstFormularioCajaDeshabilitada" readonly id="CmpProductoImporte_<?php echo $i;?>" size="5" maxlength="10" value=""   /></td>
                       <td align="center"   ><input class="EstFormularioCajaDeshabilitada" name="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="text" readonly id="CmpProductoStockReal_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="5" maxlength="10" /></td>
                     
                       <td align="center"   ><select disabled="disabled" class="EstFormularioCombo"  name="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpProductoTienePromocion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  >
                                                    <option value="1" <?php echo $OpcTienePromocion1;?> >Si</option>
                                                    <option value="2" <?php echo $OpcTienePromocion2;?> >No</option>

                                                </select></td>
                     
                       <td align="left"   >&nbsp;</td>
                     </tr>
 					<?php
					}
					?>
                     <tr>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
                                          <td class="EstPlanMantenimientoTarea">&nbsp;</td>
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
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">Total Mantenimiento:</td>
                                <td width="50" align="right" valign="middle"><input name="CmpMantenimientoTotal" type="text" class="EstFormularioCaja" readonly id="CmpMantenimientoTotal" size="5" maxlength="10" value="<?php echo number_format($PresupuestoTotal,2);?>"   /></td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">Adicionales:</td>
                                <td align="right" valign="middle">
                                
                                
                                <input name="CmpAdicionalTotal" type="text" class="EstFormularioCaja" readonly id="CmpAdicionalTotal" size="5" maxlength="10" value="<?php echo number_format($AdicionalTotal,2);?>"   />
                                
                                </td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">Mano de Obra:</td>
                                <td align="right" valign="middle"><input name="CmpManoObra" type="text" class="EstFormularioCaja" id="CmpManoObra" size="5" maxlength="10" value="0.00"   /></td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">Total Presupuesto:</td>
                                <td align="right" valign="middle"><input name="CmpPresupuestoTotal" type="text" class="EstFormularioCaja" id="CmpPresupuestoTotal" value="<?php echo number_format($PresupuestoTotal,2);?>" size="5" maxlength="10" readonly   /></td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="6" align="right" valign="middle"><input class="EstFormularioBoton" name="BtnImprimir" type="submit" onClick="javascript:FncImprimir();" id="BtnImprimir" value="Imprimir Presupuesto" /></td>
                                <td width="1" align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
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