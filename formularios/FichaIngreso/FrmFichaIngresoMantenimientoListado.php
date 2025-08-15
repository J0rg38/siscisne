<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';



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

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_PlanMantenimientoId = $_POST['PlanMantenimientoId'];

//deb($_POST);
session_start();
if (!isset($_SESSION['InsFichaIngresoMantenimiento'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoMantenimiento'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

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

// Verificar que la clase esté disponible antes de deserializar
if (!class_exists('ClsSesionObjeto')) {
    require_once('../../clases/ClsSesionObjeto.php');
}

// Verificar que el objeto de sesión sea válido
if (isset($_SESSION['InsFichaIngresoMantenimiento'.$ModalidadIngreso.$Identificador]) && 
    is_object($_SESSION['InsFichaIngresoMantenimiento'.$ModalidadIngreso.$Identificador])) {
    
    try {
        $RepSesionObjetos = $_SESSION['InsFichaIngresoMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
        $ArrSesionObjetos = $RepSesionObjetos['Datos'] ?? [];
        $SesionObjetosTotal = $RepSesionObjetos['Total'] ?? 0;
        $SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'] ?? 0;
    } catch (Exception $e) {
        error_log("Error al obtener sesión objetos: " . $e->getMessage());
        $ArrSesionObjetos = [];
        $SesionObjetosTotal = 0;
        $SesionObjetosTotalSeleccionado = 0;
    }
} else {
    $ArrSesionObjetos = [];
    $SesionObjetosTotal = 0;
    $SesionObjetosTotalSeleccionado = 0;
}

//deb($ArrSesionObjetos);

//VARIABLES
$POST_VehiculoVersion = $_POST['VehiculoVersion'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];
$POST_VehiculoKilometraje = $_POST['VehiculoKilometraje'];
$POST_VehiculoMantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
//MENSAJES

//deb($_POST);
?>

<?php
if(empty($POST_VehiculoModelo)){
?>
    No se ha encontrado el modelo de vehiculo
<?php	
}elseif(empty($POST_VehiculoMantenimientoKilometraje)){
?>
	
    No se ha encontrado el kilometraje del plan de mantenimiento
         
<?php	
}elseif(empty($POST_VehiculoVersion)){
?>
	No se ha encontrado la version del vehiculo
<?php	
}else{
?>
        <?php
        //CLASES
        require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
        require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
        require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
        require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');
        
        require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
        
        require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
        
        //INSTANCIAS
        $InsPlanMantenimiento = new ClsPlanMantenimiento();
        $InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
        $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
        $InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
        
        $InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
        
        $RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
			$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
			
 		if(empty($POST_PlanMantenimientoId)){
			
			//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,'PmaId','ASC',1,NULL,$POST_VehiculoVersion,$POST_VehiculoModelo) ;
			$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_VehiculoModelo) ;
			$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
		
			
			$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
			unset($ArrPlanMantenimientos);
			$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
				
		}else{
			
			$InsPlanMantenimiento->PmaId = $POST_PlanMantenimientoId;
			$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
			
		}
		
		
       
		
		        
        $Kilometraje = $POST_VehiculoMantenimientoKilometraje;
        
        $InsProducto = new ClsProducto();
        
        //MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0)
        $ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","contiene","W-","ProCodigoOriginal","ASC",NULL,1,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0);
        $ArrProductos = $ResProducto['Datos'];
        //foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
        //	deb($DatKilometro['eq']);	 
        //}
        //deb($InsPlanMantenimiento->PmaId);
        
        //deb($InsPlanMantenimiento->PmaChevroletKilometrajes);
        ///deb($InsPlanMantenimiento->PmaIsuzuKilometrajes);
        
        
            ?>
            
            <?php
            if(!empty($InsPlanMantenimiento->PmaId)){
				
				//deb($InsPlanMantenimiento->VmaId);
            ?>
            
            <input type="hidden" value="<?php echo $InsPlanMantenimiento->PmaId;?>" name="CmpPlanMantenimientoIdAux" id="CmpPlanMantenimientoIdAux" />
						
            
            
            <a href="javascript:FncPlanMantenimientoVer();">
            [Ver Plan de Mantenimiento]
            </a>
            
            
                <?php
                switch($InsPlanMantenimiento->VmaId){
                    //case "VMA-10017"://CHEVROLET
                    default://CHEVROLET
                ?>
              
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td width="4">&nbsp;</td>
                        <td colspan="6"><input type="hidden" name="CmpPlanMantenimiento" id="CmpPlanMantenimiento" value="<?php echo $InsPlanMantenimiento->PmaId;?>" /></td>
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
                        
                     
                <table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="right">Kilómetros (x1000)</td>
                        <?php
                        foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                        ?>
                        <?php if($Kilometraje == $DatKilometro['km']){?>
                        <td align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>
                        <td align="center" >&nbsp;</td>
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
                    $ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
                    $ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
            ?>
                <?php
                if(!empty($ArrPlanMantenimientoTareas)){
                ?>
            
                    <tr>
                        <td colspan="20" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?>
                        </td>
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
                ?>
                
                
                    <?php
                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                
                        if($Kilometraje==$DatKilometro['km']){
            
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
                                <?php
            //deb($PlanMantenimientoDetalleAccion);
            ?>    
                                    <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
                                    <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
                                    
                                    
                                </td>
                        
                                    <?php
                                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                                    ?>
                                        <?php
                                        if($Kilometraje == $DatKilometro['km']){
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
                                            Parametro10 = FiaEstado,
                                            
                                             Parametro11 = ProId
                                            */
                                            
                                            if(!empty($ArrSesionObjetos)){	
                                                foreach($ArrSesionObjetos as $DatSesionObjeto){
            
            $PlanMantenimientoDetalleId = '';
            $PlanMantenimientoDetalleAccion = '';
            $FichaIngresoMantenimientoProductoId = '';
            
            $OpcAccion1 = '';
            $OpcAccion2 = '';
            $OpcAccion3 = '';
            $OpcAccion4 = '';
            $OpcAccion5 = '';		
            
            
                        
                                                    if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){
                                                        
                                                        $PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
                                                        $PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro4;
                                                        
                                                         $FichaIngresoMantenimientoProductoId = $DatSesionObjeto->Parametro11;
                                                         
                                                         
                                                        
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
                        
                                        <select class="EstFormularioCombo"  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ($_POST['Editar']==2)?'disabled="disabled"':'';?> >
                                            <option value="X" <?php echo $OpcAccion4;?>>X</option>
                                            <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
                                            <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
                                            <option value="R" <?php echo $OpcAccion3;?>>Realizar</option>
                                            <option value="U" <?php echo $OpcAccion5;?>>Agregar</option>
            <option value="P" <?php echo $OpcAccion6;?>>Consultivo</option>
                        </select>
                        
                        
                                        <input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />
                                        
                        
                                        </td>
                                        <td align="left"   >
                                       
                                       <?php
                                       if($DatPlanMantenimientoTarea->PmtId == "PMT-10000"){
                                          ?>
                                              <select class="EstFormularioCombo"  name="CmpFichaIngresoMantenimientoProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaIngresoMantenimientoProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ($_POST['Editar']==2)?'disabled="disabled"':'';?> >
                                           
                                           <option value="">Escoja una opcion</option>
                                           <?php
                                           if(!empty($ArrProductos)){
                                           foreach($ArrProductos as $DatProducto){
                                        ?>
                                            <option <?php echo (($FichaIngresoMantenimientoProductoId==$DatProducto->ProId)?'selected="selected"':'');?>  value="<?php echo $DatProducto->ProId?>"><?php echo $DatProducto->ProCodigoOriginal?> - <?php echo $DatProducto->ProNombre?></option>
                                            
                                        <?php
                                           }
                                           }
                                           ?>
                                           
                                           
                                           
                                           
                                        </select>
                                    <?php 
                                       }
                                       ?> 
                                        
                                    
                                        
                                        
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
                            
                <?php
                }
                ?>
            
                           
            <?php
            }
            ?>  
            
                          
                        </table></td>
                        <td valign="top">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="6" align="center"><b>I:</b> Inspección/ajuste 
                          <b>C:</b> Cambio o reemplazo 
                          <b>R:</b> Realizar 
                          <b>A:</b> Agregar 
                          </td>
                        <td>&nbsp;</td>
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
                    break;
                    
                    case "VMA-10018"://ISUZU
                ?>
                
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td width="4">&nbsp;</td>
                        <td colspan="6"><input type="hidden" name="CmpPlanMantenimiento" id="CmpPlanMantenimiento" value="<?php echo $InsPlanMantenimiento->PmaId;?>" /></td>
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
                        
                     
                <table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="right">Kilómetros (x1000)</td>
                        <?php
                        foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                        ?>
                        <?php if($Kilometraje == $DatKilometro['km']){?>
                        <td align="center" ><?php echo $DatKilometroEtiqueta;?> km <i>(<?php echo $DatKilometro['eq'];?>)</i></td>
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
                    $ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
                    $ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
            ?>
                <tr>
                    <td colspan="19" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
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
                    $OpcAccion7 = '';	
            ?>
            
            
                <?php
                foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            
                    if($Kilometraje==$DatKilometro['km']){
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
                            if($Kilometraje==$DatKilometro['km']){
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
                                        $OpcAccion5 = '';	
                                        $OpcAccion6 = '';	
                                        $OpcAccion7 = '';	
                        
                                        if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){
                                            
                                            $PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
                                            $PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro4;
                                            
                                            break;
                                        }					
                                    }
                                }				
                                ?>
            
            
            
                        <?php
                        
                        //deb($PlanMantenimientoDetalleAccion);
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
            
                                    case "U":
                                        $OpcAccion7 = 'selected="selected"';						
                                    break;
                                    
                            case "X":
                                $OpcAccion4 = 'selected="selected"';						
                            break;
                        }
                        ?>
            
                            <select class="EstFormularioCombo"  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ($_POST['Editar']==2)?'disabled="disabled"':'';?> >
                                <option value="X" <?php echo $OpcAccion4;?>>X</option>
            
                                <option value="R" <?php echo $OpcAccion1;?>>Reemplazar</option>
                                <option value="I" <?php echo $OpcAccion2;?>>Inspeccionar</option>
                                <option value="A" <?php echo $OpcAccion3;?>>Ajustar</option>
                                <option value="T" <?php echo $OpcAccion5;?>>Apretar</option>
                                <option value="L" <?php echo $OpcAccion6;?>>Lubricar</option>
                                <option value="U" <?php echo $OpcAccion7;?>>Agregar</option>
                            </select>
            
            <!--                <input size="2" type="hidden" name="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleNivel;?>" />-->
                            <input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />
                            
            
                            </td>
                            <?php
                            
                            //$PlanMantenimientoDetalleAccion = '';
                            }
                            ?>
                            
                        <?php	
                        }
                        ?>
            
                <td align="left"   >
                    
                    <!--<input <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  type="checkbox" name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"    />-->
                
                
                                
                              <?php
                            if($_SESSION['MysqlDeb'] == 1){
                            ?>
                            
                <span style="color:#F5F5F5">(<?php echo $DatPlanMantenimientoTarea->PmtId;?>) / (<?php echo $PlanMantenimientoDetalleId?>)</span>
            
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
                           
            <?php
            }
            ?>  
            
                          
                        </table></td>
                        <td valign="top">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="6" align="center"><b>R:</b> Reemplazar
                          <b>I:</b>  Inspeccionar , limpiar o reparar según sea necesario
                          <b>A:</b> Ajustar
                          
                          <b>T:</b> Apretar al par de apriete especificado
                           <b>L:</b> Lubricar
                          
                          
                           </td>
                        <td>&nbsp;</td>
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
             
  
           
<?php	
}

?>

 
