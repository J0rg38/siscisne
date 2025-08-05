<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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



require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');


$GET_VehiculoVersionId = $_POST['VehiculoVersionId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');


$InsVehiculoVersion = new ClsVehiculoVersion();
$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();

$InsVehiculoVersion->VveId = $GET_VehiculoVersionId;
$InsVehiculoVersion->MtdObtenerVehiculoVersion();

$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];

?>
<table>
<?php

if(!empty($ArrVehiculoCaracteristicaSecciones)){
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
?>



		  <tr>
			<td>&nbsp;</td>
			<td colspan="2" class="EstFormularioResaltarSeccion"><?php echo $DatVehiculoCaracteristicaSeccion->VcsNombre?></td>
			<td>&nbsp;</td>
		  </tr>



			<?php
				if(!empty($InsVehiculoVersion->VehiculoVersionCaracteristica)){	
					foreach($InsVehiculoVersion->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){
			?>

						<?php		
						if($DatVehiculoCaracteristicaSeccion->VcsId == $DatVehiculoVersionCaracteristica->VcsId){
						?>            
                        
                          <tr>
                            <td>&nbsp;</td>
                            <td>

                            	<?php echo $DatVehiculoVersionCaracteristica->VvcDescripcion;?>

							</td>
                            <td>

								<?php echo $DatVehiculoVersionCaracteristica->VvcValor;?>

                            </td>
                            <td>&nbsp;</td>
                          </tr>
            		<?php
						}
					?>
            <?php
				}
			}
			?>


<?php
	}
}
?>
</table>