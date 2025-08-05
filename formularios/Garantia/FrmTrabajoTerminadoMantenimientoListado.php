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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

session_start();
if (!isset($_SESSION['InsGarantiaMantenimiento'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsGarantiaMantenimiento'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

/*
SesionObjeto-FichaAccionMantenimiento
Parametro1 = FaaId
Parametro2 = 
Parametro3 = PmtId
Parametro4 = FaaAccion
Parametro5 = FaaTiempoCreacion
Parametro6 = FaaTiempoModificacion
Parametro7 = FaaNivel
Parametro8 = FaaVerificar1
Parametro9 = FaaVerificar2
Parametro10 = FaaEstado
*/

$RepSesionObjetos = $_SESSION['InsGarantiaMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//deb($ArrSesionObjetos);

//VARIABLES
$POST_VehiculoVersion = $_POST['VehiculoVersion'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];
$POST_VehiculoKilometraje = $_POST['VehiculoKilometraje'];
$POST_VehiculoMantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
//MENSAJES
?>

<?php
if(!empty($POST_VehiculoModelo) and !empty($POST_VehiculoMantenimientoKilometraje)){
?>



<?php
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
//INSTANCIAS
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();

//MtdObtenerPlanMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoVersion=NULL)
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_VehiculoModelo) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

//deb($ArrPlanMantenimientos);
$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

$Kilometraje = $POST_VehiculoMantenimientoKilometraje;
?>

<?php
if(!empty($InsPlanMantenimiento->PmaId)){
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
            <td width="75" align="left" valign="top">Version:              </td>
            <td width="277" align="left"><?php echo $InsPlanMantenimiento->VveNombre;?></td>
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
            <?php if($Kilometraje==$DatKilometro['km']){?>
            <td align="center" ><?php echo $DatKilometroEtiqueta;?> km</td>
            <td align="center" >&nbsp;</td>
            <td align="center" >Nombre</td>
            <td align="center" >U.M.</td>
            <td align="center" >Cantidad</td>
            <td align="center" >&nbsp;</td>
            <?php	}?>
            <?php	
            }
            ?>
        </tr>
                
<?php
	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
					
		$OpcAccion1 = '';
		$OpcAccion2 = '';
		$OpcAccion3 = '';
		$OpcAccion4 = '';
							
		$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
		$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
					
?>


<tr>
	<td colspan="23" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
</tr>                


    				
<?php
	foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
?>

<?php
$PlanMantenimientoDetalleId = '';
$PlanMantenimientoDetalleAccion = '';
$PlanMantenimientoDetalleNivel = '';
$PlanMantenimientoDetalleVerificar1 = '';

$FichaAccionProductoId = '';

$ProductoId = '';
$ProductoCantidad = '';
$ProductoUnidadMedida = '';
$ProductoNombre = '';
$ProductoTipoId = '';

$OpcAccion1 = '';
$OpcAccion2 = '';
$OpcAccion3 = '';
$OpcAccion4 = '';
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
	    
  <!--		<input etiqueta="tarea" type="hidden" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />-->
	    
	    <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
	    <?php echo $DatPlanMantenimientoTarea->PmtNombre;?></td>
		

			<?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
                <?php
                if($Kilometraje==$DatKilometro['km']){
					
					  
                ?>
                
                <td align="right"   >
                
                
<?php				
/*
SesionObjeto-FichaAccionMantenimiento
Parametro1 = FaaId
Parametro2 = 
Parametro3 = PmtId
Parametro4 = FaaAccion
Parametro5 = FaaTiempoCreacion
Parametro6 = FaaTiempoModificacion
Parametro7 = FaaNivel
Parametro8 = FaaVerificar1
Parametro9 = FaaVerificar2
Parametro10 = FaaEstado

Parametro11 = FapId
Parametro12 = ProId
Parametro13 = ProNombre
Parametro14 = FapVerificar1
Parametro15 = FapVerificar2
Parametro16 = UmeId
Parametro17 = FapTiempoCreacion
Parametro18 = FapTiempoModificacion
Parametro19 = FapCantidad
Parametro20 = FapCantidadReal	
Parametro21 = RtiId
Parametro22 = UmeNombre
Parametro23 = UmeIdOrigen
Parametro24 = FapEstado
*/
                    if(!empty($ArrSesionObjetos)){	
					
                        foreach($ArrSesionObjetos as $DatSesionObjeto){
							
//							deb($DatSesionObjeto);
							
                            $PlanMantenimientoDetalleId = '';
							$PlanMantenimientoDetalleAccion = '';
							$PlanMantenimientoDetalleNivel = '';
							$PlanMantenimientoDetalleVerificar1 = '';
							
							$FichaAccionProductoId = '';
							
							$ProductoId = '';
							$ProductoCantidad = '';
							$ProductoUnidadMedida = '';
							$ProductoNombre = '';
							$ProductoTipoId = '';
							
                            if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){

								$PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
                                $PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro4;
								$PlanMantenimientoDetalleNivel = $DatSesionObjeto->Parametro7;
								$PlanMantenimientoDetalleVerificar1 = $DatSesionObjeto->Parametro8;
								
								$FichaAccionProductoId = $DatSesionObjeto->Parametro11;
								
								$ProductoId = $DatSesionObjeto->Parametro12;
								$ProductoCantidad = $DatSesionObjeto->Parametro19;
								$ProductoUnidadMedida = $DatSesionObjeto->Parametro16;
								$ProductoNombre = $DatSesionObjeto->Parametro13;
								$ProductoTipoId = $DatSesionObjeto->Parametro21;
								
                                break;
                            }					
                        }
                    }
					
                    ?>

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

<?php
	if(empty($PlanMantenimientoDetalleNivel)){
		$PlanMantenimientoDetalleNivel = (!empty($OpcAccion4))?'2':'1';
	}
	
	if(empty($PlanMantenimientoDetalleVerificar1)){
		$PlanMantenimientoDetalleVerificar1 = 2;
	}
?>


<?php
if($_POST['Editar']==2){
?>

<?php //echo ($_POST['Editar']==2)?'disabled="disabled"':'';?>
    <select name="CmpPlanMantenimientoDetalleAccionAux_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccionAux_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" disabled="disabled"  >
    <option value="X" <?php echo $OpcAccion4;?>>X</option>
    <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
    <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
    <option value="R" <?php echo $OpcAccion3;?>>Revisar</option>
    </select>

    <input type="hidden" name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  value="<?php echo $PlanMantenimientoDetalleAccion;?>"  />

<?php
}else{
?>
    <select name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"   >
    <option value="X" <?php echo $OpcAccion4;?>>X</option>
    <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
    <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
    <option value="R" <?php echo $OpcAccion3;?>>Revisar</option>
    </select>

<?php	
}
?>
<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleNivel;?>" />
<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />

                </td>
                <td align="right"   >

<?php
if($POST_Editar==1){
?>
<a href="javascript:FncGarantiaProductoNuevo('<?php echo $DatPlanMantenimientoTarea->PmtId?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
<?php
}
?>
				</td>
                <td align="right"   >
                
 <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion<>"C" or $POST_Editar==2 )?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"   <?php echo ($PlanMantenimientoDetalleAccion<>"C" or $POST_Editar==2 )?'readonly="readonly"':'';?>  id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="40" value="<?php echo $ProductoNombre;?>" />
 
                
<!--<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion=="C")?'EstFormularioCaja':'EstFormularioCajaDeshabilitada'?>"  <?php echo ($PlanMantenimientoDetalleAccion<>"C")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="40" value="<?php echo $ProductoNombre;?>" />-->


</td>
                <td align="right"   >
                
<?php
$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
?>

<select  class="EstFormularioCombo" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir"   <?php echo ($PlanMantenimientoDetalleAccion<>"C" or $POST_Editar==2 )?'disabled="disabled"':'';?> >
<option value="">Escoja una opcion</option>
<?php
if(!empty($ProductoTipoId)){
?>
	<?php
    foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
    ?>
    
    
	<option <?php echo (($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>    
	<!--	<option <?php echo (($ProductoTipoId==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>-->
    <?php	
    }
    ?>
<?php
}
?>
</select>

                
                
                </td>
                <td align="right"   >
                  
  <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoCantidad" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion<>"C" or $POST_Editar==2 )?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"   <?php echo ($PlanMantenimientoDetalleAccion<>"C" or $POST_Editar==2 )?'readonly="readonly"':'';?>  id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="10" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  />
                  
  <!--<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoCantidad" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion=="C")?'EstFormularioCaja':'EstFormularioCajaDeshabilitada'?>"  <?php echo ($PlanMantenimientoDetalleAccion<>"C")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="10" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  />-->
                  
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" value="<?php echo $ProductoUnidadMedida;?>" />
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente" value=""  />
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $ProductoId;?>"   />
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" value="" />
                  
  <input type="hidden" name="CmpFichaAccion<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"  class="EstFormularioCaja" id="CmpFichaAccion<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $FichaAccionProductoId;?>"  />
                  
                  
                <div id="Cap<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar"></div></td>
                <td align="right"   >
                
                <!--<a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatPlanMantenimientoTarea->PmtId?>" class="thickbox" title="">[...]</a>-->
                
                </td>
                <?php
                }
                ?>
                
			<?php	
			}
			?>
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
            <td colspan="6" align="center"><b>I:</b> Inspección/ajuste 
              <b>C:</b> Cambio o reemplazo 
              <b>R:</b> Realizar </td>
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
}else{
?>
	No se encontro un plan de mantenimiento
<?php	
}
?>      
        
<?php	
}if(empty($POST_VehiculoVersion)){
?>
No se ha encontrado el modelo de vehiculo
<?php	
}elseif(empty($POST_VehiculoMantenimientoKilometraje)){
?>
No se ha encontrado el kilometraje del plan de mantenimiento
<?php	
}
?>

 
