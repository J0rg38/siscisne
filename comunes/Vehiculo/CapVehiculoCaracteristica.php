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


$GET_VehiculoModeloId = $_POST['VehiculoModeloId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModeloCaracteristica.php');


$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoCaracteristica = new ClsVehiculoCaracteristica();
$InsVehiculoModeloCaracteristica = new ClsVehiculoModeloCaracteristica();

$InsVehiculoModelo->VmoId = $GET_VehiculoModeloId;
$InsVehiculoModelo->MtdObtenerVehiculoModelo();


$ResVehiculoCaracteristica = $InsVehiculoCaracteristica->MtdObtenerVehiculoCaracteristicas(NULL,NULL,"VcaId","ASC",NULL);
$ArrVehiculoCaracteristicas = $ResVehiculoCaracteristica['Datos'];

?>


<table>

	<?php
			foreach($ArrVehiculoCaracteristicas as $DatVehiculoCaracteristica){
				
			  	if(!empty($InsVehiculoModelo->VehiculoModeloCaracteristica)){	
					foreach($InsVehiculoModelo->VehiculoModeloCaracteristica as $DatVehiculoModeloCaracteristica ){
						$VmcId = '';
						$VmcValor = '';
						if($DatVehiculoModeloCaracteristica->VcaId==$DatVehiculoCaracteristica->VcaId){
							$VmcId = $DatVehiculoModeloCaracteristica->VmcId;
							$VmcValor = $DatVehiculoModeloCaracteristica->VmcValor;			
							break;
						}					
					}
				}	
				
			?>
          <tr>
            <td>&nbsp;</td>
            <td><?php echo $DatVehiculoCaracteristica->VcaNombre?></td>
            <td>
            
<input type="hidden" name="CmpVehiculoModeloCaracteristicaId_<?php echo $DatVehiculoCaracteristica->VcaId?>" id="CmpVehiculoModeloCaracteristicaId_<?php echo $DatVehiculoCaracteristica->VcaId?>" value="<?php echo $VmcId?>" />              
            
<input name="CmpVehiculoModeloCaracteristicaValor_<?php echo $DatVehiculoCaracteristica->VcaId?>" type="text" class="EstFormularioCaja" id="CmpVehiculoModeloCaracteristicaValor_<?php echo $DatVehiculoCaracteristica->VcaId?>" value="<?php echo $VmcValor?>" size="10" maxlength="10" readonly="readonly" />
<?php echo $DatVehiculoCaracteristica->VcaUnidad?>

<input type="hidden" name="CmpVehiculoCaracteristicaId_<?php echo $DatVehiculoCaracteristica->VcaId?>" id="CmpVehiculoCaracteristicaId_<?php echo $DatVehiculoCaracteristica->VcaId?>" value="<?php echo $DatVehiculoCaracteristica->VcaId?>"  />


			</td>
            <td>&nbsp;</td>
          </tr>
            
            <?php
			}
			?>
</table>