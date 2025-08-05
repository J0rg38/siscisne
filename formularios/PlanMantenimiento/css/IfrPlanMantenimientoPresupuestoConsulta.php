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







<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CONSULTA DE PRODUCTO


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
                                <td width="4">&nbsp;</td>
                                <td colspan="6"></td>
                                <td width="4">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="75" align="left" valign="top">Marca:              </td>
                                <td width="172" align="left"><?php echo $InsPlanMantenimiento->VmaNombre;?></td>
                                <td width="79" align="left">Modelo:              </td>
                                <td width="211" align="left"><?php echo $InsPlanMantenimiento->VmoNombre;?></td>
                                <td width="75" align="left" valign="top">&nbsp;</td>
                                <td width="277" align="left">&nbsp;</td>
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
                      
                                
                             
                        <table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="right">Kilómetros (x1000)</td>
                                
                                <?php
                                foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                ?>
                                    <?php if($POST_MantenimientoKilometraje == $DatKilometro['km']){?>
                                        <td align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>
                                        <td align="center" >Nombre</td>
                                        <td align="center" >U.M.</td>
                                        <td align="center" >Cantidad</td>
                                        <td align="center" >Precio</td>
                                        <td align="center" >Importe</td>
                                    <?php	}?>
                                <?php	
                                }
                                ?><td align="center" >&nbsp;</td>
                            </tr>
                                    
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
                    
                    //		$PlanMantenimientoDetalleId = '';
                    //		$PlanMantenimientoDetalleAccion = '';
                    //		$OpcAccion1 = '';
                    //		$OpcAccion2 = '';
                    //		$OpcAccion3 = '';
                    //		$OpcAccion4 = '';
                            $ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
                            $ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
                    ?>
                        <?php
                        if(!empty($ArrPlanMantenimientoTareas)){
                        ?>
                    
                    
                            <tr>
                                <td colspan="24" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
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
                            if(!empty( $PlanMantenimientoDetalleAccion) and $PlanMantenimientoDetalleAccion=="C"){
                            ?>
                    
                                <tr>
                            
                                        <td class="EstPlanMantenimientoTarea">
                                            <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
                                            <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
                                        </td>
                                
                                            <?php
                                            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                            ?>
                                                <?php
                                                if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                                ?>
                                                
                                                <td align="right"   >
                                                
                                                    
                                            <?php
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
                                            }
                                            ?>
                                
                                                <select  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  disabled="disabled" >
                                                    <option value="X" <?php echo $OpcAccion4;?>>X</option>
                                                    <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
                                                    <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
                                                    <option value="R" <?php echo $OpcAccion3;?>>Realizar</option>
                                                </select>
                                
                                
                                                <input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />
                                                
                                
                                                </td>
                                                <td align="left"   >
                    
                                             
                    <?php
                    
                    $ProductoId = "";
                    $ProductoNombre = "";
                    $ProductoUnidadMedida = "";
                    $ProductoUnidadMedidaNombre = "";
                    $ProductoUnidadMedidaOrigen = "";
                    $ProductoTipo = "";
                    
                    $ProductoCantidad = 0;
                    $ProductoPrecio = 0;		
                    $ProductoImporte = 0;
                            
                    $InsTareaProducto = new ClsTareaProducto();
                    $ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$POST_VehiculoMantenimientoKilometraje);
                    $ArrTareaProductos = $ResTareaProducto['Datos'];
                    ?>
                    
                    <?php
                    foreach($ArrTareaProductos as $DatTareaProducto){
                    ?>
                    
                        <?php
                        if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId){
                            
                    
                            $InsProducto->ProId = $DatTareaProducto->ProId;
                            $InsProducto->MtdObtenerProducto(false);
                        
                            $ProductoId = $DatTareaProducto->ProId;
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
                            
                        }
                        ?>
                        
                    <?php
                    }
                    ?>
                    
                      <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text" class="EstFormularioCajaDeshabilitada"  readonly="readonly"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="40" value="<?php echo $ProductoNombre;?>" />
                    
                                                </td>
                                                <td align="left"   >
                                                
                                                
                    <?php
                    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
                    ?>
                    
                    <select  class="EstFormularioCombo" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" disabled="disabled" >
                    
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
                    
                    
                    
                    </td>
                                                <td align="left"   >
                                                
                    <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoCantidad" type="text" class="EstFormularioCajaDeshabilitada" readonly="readonly" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="5" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  />
                    
                    </td>
                                                <td align="left"   >
                                                
                                                <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" readonly="readonly" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoPrecio" size="5" maxlength="10" value="<?php echo number_format($ProductoPrecio,2);?>"  />
                                                
                                                </td>
                                  <td align="left"   >
                                  
                                  <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoImporte" type="text" class="EstFormularioCajaDeshabilitada" readonly="readonly" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoImporte" size="5" maxlength="10" value="<?php echo number_format($ProductoImporte,2);?>"  />
                                  
                                  
                                  </td>
                                                <?php
                                                }
                                                ?>
                                                
                                            <?php	
                                            }
                                            ?>
                                
                                    <td align="left"   >
                                    <span style="color:#F5F5F5">(<?php echo $DatPlanMantenimientoTarea->PmtId;?>) / (<?php echo $PlanMantenimientoDetalleId?>)</span>
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
                              <td align="left" >&nbsp;</td>
                              <td align="left" >&nbsp;</td>
                              <td align="left" >&nbsp;</td>
                              <td align="left" >&nbsp;</td>
                              <td align="left" >&nbsp;</td>
                              <td align="left" >Total:</td>
                              <td align="right" >
                              <?php echo number_format($PresupuestoTotal,2);?>
                              </td>
                              <td align="left" >&nbsp;</td>
                    
                              
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
                                <td align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>
                                <td align="center" >Nombre</td>
                                <td align="center" >U.M.</td>
                                <td align="center" >Cantidad</td>
                                <td align="center" >Precio</td>
                                <td align="center" >Importe</td>
                                <?php	}?>
                                <?php	
                                }
                                ?><td align="center" >&nbsp;</td>
                            </tr>
                                    
                    <?php
                        foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
                    
                    
                            $ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
                            $ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
                    ?>
                        
                        <tr>
                            <td colspan="24" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
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
                                $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
                                
                            }
                        }
                        ?>
                                    
                        <?php
                        if(!empty( $PlanMantenimientoDetalleAccion)){
                        ?>
                        <tr>
                            <td class="EstPlanMantenimientoTarea">
                                <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
                                <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
                            </td>
                    
                                <?php
                                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                ?>
                                    <?php
                                    if($POST_MantenimientoKilometraje==$DatKilometro['km']){
                                    ?>
                                    
                                    <td align="right"   >

                                    
                                      
                    
                                <?php
                                
                                //echo "<br>";
                                //echo $PlanMantenimientoDetalleAccion;
                                //echo "<br>";
                                
                                switch($PlanMantenimientoDetalleAccion){
                                
                                    case "R":
                                        $OpcAccion1 = 'selected="selected"';
                                    break;
                                    
                                    case "I":
                                        $OpcAccion2 = 'selected="selected"';
                                    break;
                                    
                                    case "A":
                                        $OpcAccion3 = 'selected="selected"';					
                                    break;
                                    
                                    case "T":
                                        $OpcAccion5 = 'selected="selected"';						
                                    break;
                                    
                                    case "L":
                                        $OpcAccion6 = 'selected="selected"';						
                                    break;
                                    
                                    case "X":
                                        $OpcAccion4 = 'selected="selected"';						
                                    break;
                                }
                                ?>
                    
                                    <select  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  disabled="disabled" >
                                        <option value="X" <?php echo $OpcAccion4;?>>X</option>
                    
                                        <option value="R" <?php echo $OpcAccion1;?>>Reemplazar</option>
                                        <option value="I" <?php echo $OpcAccion2;?>>Inspeccionar</option>
                                        <option value="A" <?php echo $OpcAccion3;?>>Ajustar</option>
                                        <option value="T" <?php echo $OpcAccion5;?>>Apretar</option>
                                        <option value="L" <?php echo $OpcAccion6;?>>Lubricar</option>
                    
                                    </select>
                    
                    <!--                <input size="2" type="hidden" name="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleNivel;?>" />-->
                                    <input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />
                                    
                    
                                    </td>
                                    <td align="left"   >
                                    
                    <?php
                    $ProductoId = "";
                    $ProductoNombre = "";
                    $ProductoUnidadMedida = "";
                    $ProductoUnidadMedidaNombre = "";
                    $ProductoUnidadMedidaOrigen = "";
                    $ProductoTipo = "";
                    
                    $ProductoCantidad = 0;
                    $ProductoPrecio = 0;		
                    $ProductoImporte = 0;
                            
                    $InsTareaProducto = new ClsTareaProducto();
                    $ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$POST_VehiculoMantenimientoKilometraje);
                    $ArrTareaProductos = $ResTareaProducto['Datos'];
                    ?>
                    
                    <?php
                    foreach($ArrTareaProductos as $DatTareaProducto){
                    ?>
                    
                        <?php
                        if($DatTareaProducto->PmtId == $DatPlanMantenimientoTarea->PmtId){
                            
                    
                            $InsProducto->ProId = $DatTareaProducto->ProId;
                            $InsProducto->MtdObtenerProducto(false);
                        
                            $ProductoId = $DatTareaProducto->ProId;
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
                    
                        }
                        ?>
                    
                    <?php
                    }
                    ?>
                                    <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text" class="EstFormularioCajaDeshabilitada"  readonly="readonly"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="40" value="<?php echo $ProductoNombre;?>" />
                                    
                                    
                                    
                                    </td>
                                    <td align="left"   ><?php
                    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
                    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
                    ?>
                                      <select  class="EstFormularioCombo" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" disabled="disabled" >
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
                                    </select></td>
                                    <td align="left"   ><input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" type="text" class="EstFormularioCajaDeshabilitada" readonly="readonly" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="5" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  /></td>
                                    <td align="left"   ><input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" readonly="readonly" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoPrecio" size="5" maxlength="10" value="<?php echo number_format($ProductoPrecio,2);?>"  /></td>
                                    <td align="left"   ><input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoImporte2" type="text" class="EstFormularioCajaDeshabilitada" readonly="readonly" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoImporte" size="5" maxlength="10" value="<?php echo number_format($ProductoImporte,2);?>"  /></td>
                                    <?php
                                    
                                    //$PlanMantenimientoDetalleAccion = '';
                                    }
                                    ?>
                                    
                                <?php	
                                }
                                ?>
                    
                        <td align="left"   >
                            
                            <!--<input <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  type="checkbox" name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"    />-->
                        
                        
                        <span style="color:#F5F5F5">(<?php echo $DatPlanMantenimientoTarea->PmtId;?>) / (<?php echo $PlanMantenimientoDetalleId?>)</span>
                        </td>
                    </tr>
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
                          <td align="left" >&nbsp;</td>
                          <td align="left" >&nbsp;</td>
                          <td align="left" >&nbsp;</td>
                          <td align="left" >&nbsp;</td>
                          <td align="left" >&nbsp;</td>
                          <td align="left" >Total:</td>
                          <td align="right" ><?php echo number_format($PresupuestoTotal,2);?></td>
                          <td align="left" >&nbsp;</td>
                          
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
                                <td colspan="6" align="left" valign="top">
                                
                                <?php echo $InsPlanMantenimiento->PmaNota;?>
                                </td>
                                <td>&nbsp;</td>
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