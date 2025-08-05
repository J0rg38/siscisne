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
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">

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
<!-- @import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimientoPresupuesto");?>CssPlanMantenimientoPresupuestoConsulta.css');-->
@import url('css/CssPlanMantenimientoPresupuestoImprimir.css');



</style>
<?php



$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];
$POST_VehiculoModelo = $_POST['CmpVehiculoModelo'];
$POST_MantenimientoKilometraje = $_POST['CmpMantenimientoKilometraje'];
$POST_ClienteTipo = $_POST['CmpClienteTipo'];
$POST_ClienteId = $_POST['CmpClienteId'];
//$POST_AdicionalTotal = $_POST['CmpAdicionalTotal'];
//$POST_MantenimientoTotal = $_POST['CmpMantenimientoTotal'];
//$POST_ManoObra = $_POST['CmpManoObra'];
//$POST_PresupuestoTotal = $_POST['CmpPresupuestoTotal'];

$POST_AdicionalTotal = eregi_replace(",","",(empty($_POST['CmpAdicionalTotal'])?0:$_POST['CmpAdicionalTotal']));
$POST_MantenimientoTotal = eregi_replace(",","",(empty($_POST['CmpMantenimientoTotal'])?0:$_POST['CmpMantenimientoTotal']));
$POST_ManoObra = eregi_replace(",","",(empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
$POST_PresupuestoTotal = eregi_replace(",","",(empty($_POST['CmpPresupuestoTotal'])?0:$_POST['CmpPresupuestoTotal']));

//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

//INSTANCIAS
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsCliente = new ClsCliente();

//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,'PmaId','ASC',1,NULL,$POST_VehiculoVersion,$POST_VehiculoModelo) ;
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_VehiculoModelo) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,NULL);	
$ArrUnidadMedidas = $ResUnidadMedida['Datos'];

if(!empty($POST_ClienteId)){
	
	$InsCliente->CliId = $POST_ClienteId;
	$InsCliente->MtdObtenerCliente();	
		$ClienteNombre = $InsCliente->CliNombre." ".$InsCliente->CliApellidoPaterno." ".$InsCliente->CliApellidoMaterno;

}

$Fecha= date("d/m/Y");

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td colspan="3" align="left" valign="top"><img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  /></td>
  </tr>
<tr>
  <td width="23%" align="left" valign="top">&nbsp;</td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">PRESUPUESTO DE PLAN DE MANTENIMIENTO


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



     <table border="0" cellpadding="2" cellspacing="2" class="EstPlanMantenimientoPresupuestoFormulario">
                              <tr>
                                <td width="1">&nbsp;</td>
                                <td colspan="6"></td>
                                <td width="5">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="6" align="left" valign="top"><table width="100%">
                                <tr>
                                  <td width="10%"><span class="EstFormularioImprimirEtiqueta">Cliente:</span></td>
                                  <td colspan="3"><span class="EstFormularioImprimirContenido"><?php echo $ClienteNombre;?></span></td>
                                  <td width="19%"><span class="EstFormularioImprimirEtiqueta">Fecha:</span></td>
                                  <td width="29%"><span class="EstFormularioImprimirContenido"><?php echo $Fecha;?></span></td>
                                </tr>
                                <tr>
                                  <td><span class="EstFormularioImprimirEtiqueta">Marca:</span></td>
                                  <td width="19%"><span class="EstFormularioImprimirContenido"><?php echo $InsPlanMantenimiento->VmaNombre;?></span></td>
                                  <td width="9%"><span class="EstFormularioImprimirEtiqueta">Modelo:</span></td>
                                  <td width="14%"><span class="EstFormularioImprimirContenido"><?php echo $InsPlanMantenimiento->VmoNombre;?></span></td>
                                  <td><span class="EstFormularioImprimirEtiqueta">Kilometraje</span></td>
                                <td><span class="EstFormularioImprimirContenido"><?php echo $POST_MantenimientoKilometraje;?> km</span></td>
                                </tr>
                                </table></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="6" valign="top">
     
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
                                  <td width="2%" align="right">&nbsp;</td>
                                    
                                    <?php
                                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
                                    ?>
                                        <?php if($POST_MantenimientoKilometraje == $DatKilometro['km']){?>
                                            <td colspan="4" align="center" class="EstPlanMantenimientoImprimirKilometrajeSeleccionado" ><i>(<?php echo $DatKilometroEtiqueta;?> km)</i></td>
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
            
                                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
                                    
                                        if($POST_MantenimientoKilometraje == $DatKilometro['km']){
        
                                            $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                            $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
                                            
                                            if( ($PlanMantenimientoDetalleAccion == "C" or $PlanMantenimientoDetalleAccion == "U") and !empty($_POST['CmpProductoId_'.$DatPlanMantenimientoTarea->PmtId])){
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
                                    <td align="left" class="EstPlanMantenimientoImprimirSeccion"><?php //echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
                                    <td width="55%" align="center" class="EstPlanMantenimientoImprimirSeccion">Producto</td>
                                    <td width="14%" align="center" class="EstPlanMantenimientoImprimirSeccion">Cantidad</td>
                                    <td width="16%" align="center" class="EstPlanMantenimientoImprimirSeccion">Unidad</td>
                                    <td width="13%" align="center" class="EstPlanMantenimientoImprimirSeccion">Importe</td>
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
                                foreach($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
                            
                                    if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                      
                                        $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                        $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
                                        
                                    }
    
                                }
                                ?>
                                         
                                <?php
                                //if( $PlanMantenimientoDetalleAccion == "C" 
    //							or $PlanMantenimientoDetalleAccion == "U" 
    //							or !empty($_POST['CmpProductoId_'.$DatPlanMantenimientoTarea->PmtId])){ 
                                if( !empty($_POST['CmpProductoId_'.$DatPlanMantenimientoTarea->PmtId]) ){ 
                                ?>
                        
                                    <tr>
										<td class="EstPlanMantenimientoImprimirTarea">&nbsp;</td>
                                    
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
                                                        $ProductoPrecio = 0;		
                                                        $ProductoImporte = 0;
                                                                
                                                        $InsTareaProducto = new ClsTareaProducto();
                                                        $ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_VehiculoMantenimientoKilometraje]['eq']);
                                                        $ArrTareaProductos = $ResTareaProducto['Datos'];
                                                       
														?>
                                                        
                                                        
                                                        <?php
                                                        foreach($ArrTareaProductos as $DatTareaProducto){
                                                        ?>
                                                        
                                                            <?php
                                                            if(
                                                            $DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId 
                                                            and $DatTareaProducto->TprKilometraje == $DatKilometro['km']
                                                            ){
                                                                
                                                        
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
                        
                                                    <td align="left" class="EstPlanMantenimientoImprimirTarea"  >
                                                      
                                                      
                                                      
                            <?php
                            switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                            
                                case "C":
                            ?>
                                                      <?php echo $_POST['CmpProductoNombre_'.$DatPlanMantenimientoTarea->PmtId];?>
                                                      <?php
                                break;
                               
                                case "X":
                            ?>
                                                      
                                                      <?php					
                                break;
    
                                case "U":
                             ?>
                                                      <?php echo $_POST['CmpProductoNombre_'.$DatPlanMantenimientoTarea->PmtId];?>
                                                      <?php						
                                break;
                            }
                            ?>
                                                      
                                                      
                                                      
                                                      
                                                    </td>
                                                    <td align="center" class="EstPlanMantenimientoImprimirTarea"  >
                                                    
                        <?php
                            
    
                            switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                            
                                case "C":
                            ?>
                                                      <?php echo $_POST['CmpProductoCantidad_'.$DatPlanMantenimientoTarea->PmtId];?>
                            <?php
                                break;
                               
                                case "X":
                                                        ?>
                                                        <?php					
                                break;
    
                                case "U":
                             ?>
                                                      <?php echo $_POST['CmpProductoCantidad_'.$DatPlanMantenimientoTarea->PmtId];?>
                                                      <?php						
                                break;
                            }
                            ?></td>
                                                    <td align="center" class="EstPlanMantenimientoImprimirTarea"  >
                                                    
                       
                        
                            <?php
                            
                            switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                            
                                case "C":
                            ?>
                           
                               
                                <?php
                                foreach($ArrUnidadMedidas as $DatUnidadMedida){
                                ?>
                                                      
                                
                                    <?php
                                    if($_POST['CmpProductoUnidadMedida_'.$DatPlanMantenimientoTarea->PmtId]==$DatUnidadMedida->UmeId){
                                    ?>
                                    
                                    <?php echo $DatUnidadMedida->UmeNombre;?>
                                    
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
                                         foreach($ArrUnidadMedidas as $DatUnidadMedida){
                                    ?> 
                                        <?php
                                        if($_POST['CmpProductoUnidadMedida_'.$DatPlanMantenimientoTarea->PmtId]==$DatUnidadMedida->UmeId){
                                        ?>
                                            <?php echo $DatUnidadMedida->UmeNombre;?>
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
                                      <td align="right" class="EstPlanMantenimientoImprimirTarea"  >
                                                      
                                                      
                              
      <?php
    
    
    switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
    
        case "C":
    ?>
                <?php echo $_POST['CmpProductoImporte_'.$DatPlanMantenimientoTarea->PmtId];?>
                <?php
        break;
       
        case "X":
    ?>
                              
                <?php					
        break;
    
        case "U":
     ?>
                <?php echo $_POST['CmpProductoImporte_'.$DatPlanMantenimientoTarea->PmtId];?>
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
                        
                        
    
    <tr>
                                      <td colspan="5" class="EstPlanMantenimientoImprimirTarea">ADICIONALES:</td>
                              </tr>
    
    
    
       <?php
                           
                           $AdicionalTotal = 0;
                        for($i=1;$i<5;$i++){   
                           ?>
    
                                    
                                    <tr>
                                        <td class="EstPlanMantenimientoImprimirTarea">&nbsp;</td>
                                        <td align="left"   >
                                        
                                        <?php echo $_POST['CmpProductoNombre_'.$i];?>
                                        
                                        
                                        </td>
                                        <td align="center"   >
                                        
                                        <?php echo $_POST['CmpProductoCantidad_'.$i];?>
                                        
                                        
                                        </td>
                                        <td align="center"   >
                                        
                                        <?php
                                         foreach($ArrUnidadMedidas as $DatUnidadMedida){
                                    ?> 
                                        <?php
                                        if($_POST['CmpProductoUnidadMedida_'.$i] == $DatUnidadMedida->UmeId){
                                        ?>
                                            
                                            <?php echo $DatUnidadMedida->UmeNombre;?>
    
                                        <?php
                                        break;
                                        }
                                        ?>
    
                                    <?php	                  
                                    }							
                                    ?>
                                    
                                    
                                        </td>
                                      <td align="right"   ><?php echo $_POST['CmpProductoImporte_'.$i];?></td>
                                    </tr>
                                    
                                    
                                    
    <?php
                                $AdicionalTotal += $_POST['CmpProductoImporte_'.$i];
                                
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
                                  <td width="2%" align="right">&nbsp;</td>
                                    
                                    <?php
                                    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                    ?>
                                        <?php if($POST_MantenimientoKilometraje == $DatKilometro['km']){?>
                                            <td colspan="4" align="center" class="EstPlanMantenimientoImprimirKilometrajeSeleccionado" >(<?php echo $DatKilometroEtiqueta;?> km)</td>
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
            
                                    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                    
                                        if($POST_MantenimientoKilometraje == $DatKilometro['km']){
        
                                            $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                            $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajes[$POST_MantenimientoKilometraje]['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
                                            
											if( ($PlanMantenimientoDetalleAccion == "R" or $PlanMantenimientoDetalleAccion == "U") and !empty($_POST['CmpProductoId_'.$DatPlanMantenimientoTarea->PmtId])){
                                            //if($PlanMantenimientoDetalleAccion == "R" or $PlanMantenimientoDetalleAccion == "U"){
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
                                    <td align="left" class="EstPlanMantenimientoImprimirSeccion"><?php //echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
                                    <td width="55%" align="center" class="EstPlanMantenimientoImprimirSeccion">Producto</td>
                                    <td width="14%" align="center" class="EstPlanMantenimientoImprimirSeccion">Cantidad</td>
                                    <td width="16%" align="center" class="EstPlanMantenimientoImprimirSeccion">Unidad</td>
                                    <td width="13%" align="center" class="EstPlanMantenimientoImprimirSeccion">Importe</td>
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
                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                            
                                    if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                      
                                        $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                                        $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
                                        
                                    }
    
                                }
                                ?>
                                         
                                <?php
                                //if( $PlanMantenimientoDetalleAccion == "C" 
    //							or $PlanMantenimientoDetalleAccion == "U" 
    //							or !empty($_POST['CmpProductoId_'.$DatPlanMantenimientoTarea->PmtId])){ 
                                if( !empty($_POST['CmpProductoId_'.$DatPlanMantenimientoTarea->PmtId]) ){ 
                                ?>
                        
                                    <tr>
										<td class="EstPlanMantenimientoImprimirTarea">&nbsp;</td>
                                    
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
                                                            if(
                                                            $DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId 
                                                            and $DatTareaProducto->TprKilometraje == $DatKilometro['km']
                                                            ){
                                                                
                                                        
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
                        
                                                    <td align="left"  class="EstPlanMantenimientoImprimirTarea"  >
                                                      
                                                      
                                                      
                            <?php
                            switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                            
                                case "R":
                            ?>
                                                      <?php echo $_POST['CmpProductoNombre_'.$DatPlanMantenimientoTarea->PmtId];?>
                                                      <?php
                                break;
                               
                                case "X":
                            ?>
                                                      
                                                      <?php					
                                break;
    
                                case "U":
                             ?>
                                                      <?php echo $_POST['CmpProductoNombre_'.$DatPlanMantenimientoTarea->PmtId];?>
                                                      <?php						
                                break;
                            }
                            ?>
                                                      
                                                      
                                                      
                                                      
                                                    </td>
                                                    <td align="center"  class="EstPlanMantenimientoImprimirTarea"  >
                                                    
                        <?php
                            
    
                            switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                            
                                case "R":
                            ?>
                                                      <?php echo $_POST['CmpProductoCantidad_'.$DatPlanMantenimientoTarea->PmtId];?>
                            <?php
                                break;
                               
                                case "X":
                                                        ?>
                                                        <?php					
                                break;
    
                                case "U":
                             ?>
                                                      <?php echo $_POST['CmpProductoCantidad_'.$DatPlanMantenimientoTarea->PmtId];?>
                                                      <?php						
                                break;
                            }
                            ?></td>
                                                    <td align="center"  class="EstPlanMantenimientoImprimirTarea"  >
                                                    
                       
                        
                            <?php
                            
                            switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
                            
                                case "R":
                            ?>
                           
                               
                                <?php
                                foreach($ArrUnidadMedidas as $DatUnidadMedida){
                                ?>
                                                      
                                
                                    <?php
                                    if($_POST['CmpProductoUnidadMedida_'.$DatPlanMantenimientoTarea->PmtId]==$DatUnidadMedida->UmeId){
                                    ?>
                                    
                                    <?php echo $DatUnidadMedida->UmeNombre;?>
                                    
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
                                         foreach($ArrUnidadMedidas as $DatUnidadMedida){
                                    ?> 
                                        <?php
                                        if($_POST['CmpProductoUnidadMedida_'.$DatPlanMantenimientoTarea->PmtId]==$DatUnidadMedida->UmeId){
                                        ?>
                                            <?php echo $DatUnidadMedida->UmeNombre;?>
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
                                      <td align="right" class="EstPlanMantenimientoImprimirTarea"   >
                                                      
                                                      
                              
      <?php
    
    
    switch($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]){
    
        case "R":
    ?>
                <?php echo $_POST['CmpProductoImporte_'.$DatPlanMantenimientoTarea->PmtId];?>
                <?php
        break;
       
        case "X":
    ?>
                              
                <?php					
        break;
    
        case "U":
     ?>
                <?php echo $_POST['CmpProductoImporte_'.$DatPlanMantenimientoTarea->PmtId];?>
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
                        
                        
    
    <tr>
                                      <td colspan="5" class="EstPlanMantenimientoImprimirTarea">ADICIONALES:</td>
                              </tr>
    
    
    
       <?php
                           
                           $AdicionalTotal = 0;
                        for($i=1;$i<5;$i++){   
                           ?>
    
                                    
                                    <tr>
                                        <td class="EstPlanMantenimientoImprimirTarea">&nbsp;</td>
                                        <td align="left" class="EstPlanMantenimientoImprimirTarea" >
                                        
                                        <?php echo $_POST['CmpProductoNombre_'.$i];?>
                                        
                                        
                                        </td>
                                        <td align="center"  class="EstPlanMantenimientoImprimirTarea" >
                                        
                                        <?php echo $_POST['CmpProductoCantidad_'.$i];?>
                                        
                                        
                                        </td>
                                        <td align="center" class="EstPlanMantenimientoImprimirTarea"  >
                                        
                                        <?php
                                         foreach($ArrUnidadMedidas as $DatUnidadMedida){
                                    ?> 
                                        <?php
                                        if($_POST['CmpProductoUnidadMedida_'.$i] == $DatUnidadMedida->UmeId){
                                        ?>
                                            
                                            <?php echo $DatUnidadMedida->UmeNombre;?>
    
                                        <?php
                                        break;
                                        }
                                        ?>
    
                                    <?php	                  
                                    }							
                                    ?>
                                    
                                    
                                        </td>
                                      <td align="right"  class="EstPlanMantenimientoImprimirTarea" ><?php echo $_POST['CmpProductoImporte_'.$i];?></td>
                                    </tr>
                                    
                                    
                                    
    <?php
                                $AdicionalTotal += $_POST['CmpProductoImporte_'.$i];
                                
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
                                <td width="156" align="right" valign="middle"><span class="EstFormularioImprimirEtiqueta">Total Mantenimiento:</span></td>
                                <td width="103" align="right" valign="middle">
                                <span class="EstFormularioImprimirContenido">
								<?php echo $EmpresaMoneda;?>
								<?php echo number_format($POST_MantenimientoTotal,2);?></span>
</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="4" rowspan="10" align="left" valign="top">
                                
                                
                                <span class="EstFormularioImprimirCabecera">IMPORTANTE:</span>
                                <span class="EstFormularioImprimirContenido">

<!--Los precios contenidos en el presente presupuesto, 
son referenciales y estan sujetos cambios por parte de la empresa 
en cualquier momento. Para una mayor informacion por favor acercarse al AREA DE REPUESTOS. -->
                                Los precios contenidos en el presente
presupuesto son referenciales y están sujetos cambios sin previo aviso. 
Para una mayor informaci&oacute;n por favor acercarse al AREA DE REPUESTOS.
 o escribir al correo aliendo@cyc.com.pe o llamar al número 052-315216 anexo 210
 
                                </span>
                                




                                </td>
                                <td align="right" valign="middle"><span class="EstFormularioImprimirEtiqueta">Total Adicional:</span></td>
                                <td align="right" valign="middle"><span class="EstFormularioImprimirContenido"> <?php echo $EmpresaMoneda;?> <?php echo number_format($POST_AdicionalTotal,2);?> </span></td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle"><span class="EstFormularioImprimirEtiqueta">Mano de Obra:</span></td>
                                <td align="right" valign="middle"><span class="EstFormularioImprimirContenido"> <?php echo $EmpresaMoneda;?> <?php echo number_format($POST_ManoObra,2);?> </span></td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle"><span class="EstFormularioImprimirEtiqueta">Total Presupuesto:</span></td>
                                <td align="right" valign="middle"><span class="EstFormularioImprimirContenido"> <?php echo $EmpresaMoneda;?> <?php echo number_format($POST_PresupuestoTotal,2);?> </span></td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;</td>
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