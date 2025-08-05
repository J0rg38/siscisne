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

session_start();
if (!isset($_SESSION['InsTallerPedidoMantenimiento'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoMantenimiento'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

//	SesionObjeto-AlmacenMovimientoSalidaDetalle/InsTallerPedidoDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

$RepSesionObjetos = $_SESSION['InsTallerPedidoMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//deb($ArrSesionObjetos);
//VARIABLES
$POST_VehiculoVersion = $_POST['VehiculoVersion'];
$POST_VehiculoKilometraje = $_POST['VehiculoKilometraje'];
$POST_VehiculoMantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
//MENSAJES

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
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,$POST_VehiculoVersion) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

//deb($ArrPlanMantenimientos);
$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

$Kilometraje = $POST_VehiculoMantenimientoKilometraje;

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
            

<?php
//deb($InsPlanMantenimiento->PmaChevroletKilometrajes);	

//foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $i => $Kilometro){
//	echo $Kilometro;
//	echo "-";
//	echo $i;
//	echo "<br>";	
//}
?>
            
	<table class="EstPlanMantenimientoTabla" border="1" cellpadding="0" cellspacing="2">
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
    //$PlanMantenimientoDetalleId = '';
    $PlanMantenimientoDetalleAccion = '';
    $PlanMantenimientoDetalleNivel = '';
    $PlanMantenimientoDetalleVerificar1 = '';
    
    //$TallerPedidoProductoId = '';
    
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
					
//	SesionObjeto-AlmacenMovimientoSalidaDetalle/InsTallerPedidoDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1

//SesionObjeto-TallerPedidoMantenimiento
//Parametro1 = FaaId
//Parametro2 = 
//Parametro3 = PmtId
//Parametro4 = FaaAccion
//Parametro5 = FaaTiempoCreacion
//Parametro6 = FaaTiempoModificacion
//Parametro7 = FaaNivel
//Parametro8 = FaaVerificar1
//Parametro9 = FaaVerificar2
//Parametro10 = FaaEstado
//Parametro11 = FapId
//Parametro12 = ProId
//Parametro13 = ProNombre
//Parametro14 = FapVerificar1
//Parametro15 = FapVerificar2
//Parametro16 = UmeId
//Parametro17 = FapTiempoCreacion
//Parametro18 = FapTiempoModificacion
//Parametro19 = FapCantidad
//Parametro20 = FapCantidadReal	
//Parametro21 = RtiId
//Parametro22 = UmeNombre
//Parametro23 = UmeIdOrigen
//Parametro24 = FapEstado

                    if(!empty($ArrSesionObjetos)){	
					
                        foreach($ArrSesionObjetos as $DatSesionObjeto){
                            //$PlanMantenimientoDetalleId = '';
							$PlanMantenimientoDetalleAccion = '';
							$PlanMantenimientoDetalleNivel = '';
							$PlanMantenimientoDetalleVerificar1 = '';
							
							//$TallerPedidoProductoId = '';
							
							$ProductoId = '';
							$ProductoCantidad = '';
							$ProductoUnidadMedida = '';
							$ProductoNombre = '';
							$ProductoTipoId = '';
							
							if($DatSesionObjeto->Parametro21 == $DatPlanMantenimientoTarea->PmtId){
								
								//deb($PlanMantenimientoDetalleAccion);
								//$PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
								$PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro22;//
								$PlanMantenimientoDetalleNivel = $DatSesionObjeto->Parametro23;//
								$PlanMantenimientoDetalleVerificar1 = $DatSesionObjeto->Parametro24;//
								
								//$TallerPedidoProductoId = $DatSesionObjeto->Parametro11;
								
								$ProductoId = $DatSesionObjeto->Parametro2;//
								$ProductoCantidad = $DatSesionObjeto->Parametro5;//
								$ProductoUnidadMedida = $DatSesionObjeto->Parametro10;//
								$ProductoNombre = $DatSesionObjeto->Parametro3;//
								$ProductoTipoId = $DatSesionObjeto->Parametro11;//
								
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

<select disabled="disabled" name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>Aux" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>Aux" >
    <option value="X" <?php echo $OpcAccion4;?>>X</option>
    <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
    <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
    <option value="R" <?php echo $OpcAccion3;?>>Revisar</option>
</select>
    
<input type="hidden" name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleAccion;?>" />


<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleNivel;?>" />
<!--<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />-->

<?php
if($_POST['MecanicoAccion']==1){
?>	
	<?php
    if(($PlanMantenimientoDetalleAccion<>"X")){
    ?>
        <input <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  type="checkbox" name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"    />
    <?php	
    }else{
	?>
	<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="2"    />    
    <?php	
	}
    ?>
<?php
}else{
?>
	<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleVerificar1;?>"    />
<?php	
}
?>


                </td>
                <td align="right"   >

<?php
if($PlanMantenimientoDetalleAccion=="C"){
?>
	<a href="javascript:FncTallerPedidoProductoNuevo('<?php echo $DatPlanMantenimientoTarea->PmtId?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
<?php
}
?>



</td>
                <td align="right"   >
                
<?php
//if($PlanMantenimientoDetalleAccion=="C"){
?>
	<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion=="C")?'EstFormularioCaja':'EstFormularioCajaDeshabilitada'?>"  <?php echo ($PlanMantenimientoDetalleAccion<>"C")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="40" value="<?php echo $ProductoNombre;?>" />
<?php
//}
?>

</td>
                <td align="right"   >
<?php
//if($PlanMantenimientoDetalleAccion=="C"){
?>
    
    <?php
    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
    ?>
    
    <select  class="EstFormularioCombo" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir">
    <?php
    if(!empty($ProductoTipoId)){
    ?>
        <?php
        foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
        ?>
            <option <?php echo (($ProductoTipoId==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>
        <?php	
        }
        ?>
    <?php
    }
    ?>
    </select>
    
<?php
//}
?>
                </td>
                <td align="right"   >

<?php
///if($PlanMantenimientoDetalleAccion=="C"){
?>


<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoCantidad" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion=="C")?'EstFormularioCaja':'EstFormularioCajaDeshabilitada'?>"  <?php echo ($PlanMantenimientoDetalleAccion<>"C")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="10" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" value="<?php echo $ProductoUnidadMedida;?>" />
<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente" value=""  />
<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $ProductoId;?>"   />
<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" value="" />

<!--<input type="hidden" name="CmpTallerPedido<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"  class="EstFormularioCaja" id="CmpTallerPedido<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $TallerPedidoProductoId;?>"  />-->

                <div id="Cap<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar"></div>
<?php
//}
?>
                
                
                </td>
                <td align="right"   >
<?php
if($PlanMantenimientoDetalleAccion=="C"){
?>
	<a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatPlanMantenimientoTarea->PmtId?>" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
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
        
 
