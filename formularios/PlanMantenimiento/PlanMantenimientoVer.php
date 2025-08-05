<?php

session_start();
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

?>

<?php

$GET_PlanMantenimientoId = $_GET['PlanMantenimientoId'];
$GET_MantenimientoKilometraje = $_GET['MantenimientoKilometraje'];

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');

//INSTANCIAS
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();


$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
//ALERTAS

$InsPlanMantenimiento->PmaId = $GET_PlanMantenimientoId;
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();


?>

<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">Kilómetros (x1000)</td>
			<?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
           
			   <?php
                if($GET_MantenimientoKilometraje == $DatKilometro){
               ?>
                <td width="30" align="center" ><?php echo $DatKilometroEtiqueta;?> </td>
               <?php
                }
               ?>
            <?php	
            }
            ?>
          
        </tr>
                
<?php
	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

		$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
		$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

?>
	<tr>
		<td colspan="<?php echo count($InsPlanMantenimiento->PmaChevroletKilometrajes)+2;?>" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
	</tr>                
<?php
	foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){

		$PlanMantenimientoDetalleId = '';
		$PlanMantenimientoDetalleAccion = '';
?>


	<?php
    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
		
        if($GET_MantenimientoKilometraje == $DatKilometro){
			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();

			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
		}
    }

    ?>
                
	<?php
	if(!empty( $PlanMantenimientoDetalleAccion)){
	?>
	<tr>
		<td class="EstPlanMantenimientoTarea">
			<?php echo $DatPlanMantenimientoTarea->PmtNombre;?> <span style="color:#CCC;">[<?php echo $DatPlanMantenimientoTarea->PmtId;?>]</span>
		
        </td>

			
			
			
			
			
			
			<?php
			$Kilometrajes = "";
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
            
			<?php
			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
			
			$PlanMantenimientoDetalleId = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleId($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
			?>
				<td align="right"   >
               
<?php
if($PlanMantenimientoDetalleAccion<>"X"){
?>

<?php
$InsTareaProducto = new ClsTareaProducto();
$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoTarea->PmtId);
$ArrTareaProductos = $ResTareaProducto['Datos'];
?>


<?php
$TareaProductoId = "";
$ProductoCodigoOriginal = "";
$ProductoNombre ="";
$UnidadMedidaNombre = "";
$TareaProductoCantidad = 0;

foreach($ArrTareaProductos as $DatTareaProducto){
?>	
	<?php 
    $TareaProductoId = $DatTareaProducto->TprId;
    $ProductoCodigoOriginal = $DatTareaProducto->ProCodigoOriginal;
    $ProductoNombre = $DatTareaProducto->ProNombre;
	$UnidadMedidaNombre = $DatTareaProducto->UmeNombre;
    $TareaProductoCantidad = $DatTareaProducto->TprCantidad;
    ?>
<?php
}
?>  

<div id="CapTareaProducto_<?php echo $PlanMantenimientoDetalleId;?>">
	<span style="font-size:8px;">
	<?php echo $ProductoCodigoOriginal;?><br />
    <?php echo $ProductoNombre;?><br />
    <?php echo $UnidadMedidaNombre;?><br />
    <?php echo $TareaProductoCantidad;?>
	</span>
</div>

    <a   href="javascript:FncTareaProductoCargarFormulario('Editar','<?php echo $TareaProductoId;?>','<?php echo $InsPlanMantenimiento->PmaId;?>','<?php echo $PlanMantenimientoDetalleId;?>','<?php echo $DatPlanMantenimientoTarea->PmtId;?>','<?php echo $DatKilometro['eq'];?>');">
    <?php echo ($PlanMantenimientoDetalleAccion);?>
    </a>

<?php	
}else{
?>

    <a  href="javascript:FncTareaProductoCargarFormulario('Registrar','','<?php echo $InsPlanMantenimiento->PmaId;?>','<?php echo $PlanMantenimientoDetalleId;?>','<?php echo $DatPlanMantenimientoTarea->PmtId;?>','<?php echo $DatKilometro['eq'];?>');">
    -
    </a>

<?php	
}
?>
				</td>
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

              
            </table>