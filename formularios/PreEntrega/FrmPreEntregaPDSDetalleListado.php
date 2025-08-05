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
$POST_Eliminar = $_POST['Eliminar'];
$POST_Editar = $_POST['Editar'];

session_start();
if (!isset($_SESSION['InsPreEntregaDetalle'.$Identificador])){
	$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

//SesionObjeto-PreEntregaDetalle
//Parametro1 = FiaId
//Parametro2 = 
//Parametro3 = PetId
//Parametro4 = FiaAccion
//Parametro5 = FiaTiempoCreacion
//Parametro6 = FiaTiempoModificacion
//Parametro7 = FiaNivel
//Parametro8 = FiaVerificar1
//Parametro9 = FiaVerificar2
//Parametro10 = FiaEstado

$RepSesionObjetos = $_SESSION['InsPreEntregaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
//deb($DatSesionObjeto->Parametro3 ." - ".$DatPreEntregaTarea->PetId);
//deb($ArrSesionObjetos);

//VARIABLES
//MENSAJES
?>



<?php
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');

//INSTANCIAS
$InsPreEntregaSeccion = new ClsPreEntregaSeccion();
$InsPreEntregaTarea = new ClsPreEntregaTarea();

$RepPreEntregaSeccion = $InsPreEntregaSeccion->MtdObtenerPreEntregaSecciones(NULL,NULL,"PesId","ASC",NULL);
$ArrPreEntregaSecciones = $RepPreEntregaSeccion['Datos'];


?>


   <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="889" colspan="6">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" valign="top">
            
         
	<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">SECCIONES</td>
			
			
			
            <td align="center" >
            CONFORME
            </td>
            <td>
            NO CONFORME
            </td>
            <td>
            NO APLICA
			</td>
            
            
        </tr>
                
<?php
	foreach($ArrPreEntregaSecciones as $DatPreEntregaSeccion){

	
		$ResPreEntregaTarea = $InsPreEntregaTarea->MtdObtenerPreEntregaTareas(NULL,NULL,'PetNombre','ASC',NULL,$DatPreEntregaSeccion->PesId);
		$ArrPreEntregaTareas = $ResPreEntregaTarea['Datos'];
?>
	<?php
	if(!empty($ArrPreEntregaTareas)){
	?>

        <tr>
            <td colspan="19" align="left" class="EstPreEntregaSeccion"><?php echo $DatPreEntregaSeccion->PesNombre;?></td>
        </tr>                
    <?php
            foreach($ArrPreEntregaTareas as $DatPreEntregaTarea){
            
            $PreEntregaDetalleId = '';
            $PreEntregaDetalleAccion = '';
            

    ?>
    
    


			<tr>
        
                    <td class="EstPreEntregaTarea">
                    
                        <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" id="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" value="<?php echo $DatPreEntregaTarea->PetId;?>" />


                        <?php echo $DatPreEntregaTarea->PetNombre;?>
                    </td>
            

                            
                            <td align="center"   >
                            
                                <?php
                                /*
                                SesionObjeto-PreEntregaDetalle
                                Parametro1 = RedId
                                Parametro2 = 
                                Parametro3 = PetId
                                Parametro4 = RedAccion
                                Parametro5 = RedTiempoCreacion
                                */
                                
								$PDSDetalleAccion1 = "";
								$PDSDetalleAccion2 = "";
								$PDSDetalleAccion3 = "";
								
								$PreEntregaDetalleId = '';
								$PreEntregaDetalleAccion = '';
											
                                if(!empty($ArrSesionObjetos)){	
                                    foreach($ArrSesionObjetos as $DatSesionObjeto){
                                            
								//$PreEntregaDetalleId = '';
//								$PreEntregaDetalleAccion = '';		
            
                                        if($DatSesionObjeto->Parametro3 == $DatPreEntregaTarea->PetId){
                                            
                                            $PreEntregaDetalleId = $DatSesionObjeto->Parametro1;
                                            $PreEntregaDetalleAccion = $DatSesionObjeto->Parametro4;
                                            
                                            break;
                                        }					
                                    }
                                }				
                                ?>
            
            
					
                    
                    <?php
					//deb($PreEntregaDetalleAccion);
					switch($PreEntregaDetalleAccion){
						case "1":
							$PDSDetalleAccion1 = 'checked="checked"';
						break; 
						
						case "2":
							$PDSDetalleAccion2 = 'checked="checked"';
						break;
						
						case "3":
							$PDSDetalleAccion3 = 'checked="checked"';						
						break;
						
						default:
							$PDSDetalleAccion3 = 'checked="checked"';		
						break;
					}
					?>
            

<input size="2" type="hidden" name="CmpPreEntregaDetalleId_<?php echo $DatPreEntregaTarea->PetId;?>" id="CmpPreEntregaDetalleId_<?php echo $DatPreEntregaTarea->PetId;?>" value="<?php echo $PreEntregaDetalleId;?>" />

<input size="2" type="hidden" name="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" id="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" value="<?php echo $DatPreEntregaTarea->PetId;?>" />


                            
               
               <input type="radio" name="CmpPreEntregaDetalleAccion_<?php echo $DatPreEntregaTarea->PetId;?>" value="1" <?php echo $PDSDetalleAccion1; ?> id="CmpPreEntregaDetalleAccion_<?php echo $DatPreEntregaTarea->PetId;?>1" <?php echo ($POST_Editar==2)?'disabled="disabled"':'';?>   > 
            
                            </td>
                            
                <td align="center"   >

					<input type="radio" name="CmpPreEntregaDetalleAccion_<?php echo $DatPreEntregaTarea->PetId;?>" value="2"  <?php echo $PDSDetalleAccion2; ?> id="CmpPreEntregaDetalleAccion_<?php echo $DatPreEntregaTarea->PetId;?>2" <?php echo ($POST_Editar==2)?'disabled="disabled"':'';?> > 

                </td>
              <td align="center">
                	
                <input type="radio" name="CmpPreEntregaDetalleAccion_<?php echo $DatPreEntregaTarea->PetId;?>" value="3"  <?php echo $PDSDetalleAccion3; ?> id="CmpPreEntregaDetalleAccion_<?php echo $DatPreEntregaTarea->PetId;?>3" <?php echo ($POST_Editar==2)?'disabled="disabled"':'';?> > 
                
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
            <td colspan="6" align="center">&nbsp;</td>
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
   

          
