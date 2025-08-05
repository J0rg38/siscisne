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

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_Limite = $_POST['Limite'];

require_once($InsPoo->MtdPaqLogistica().'ClsAviso.php');

$InsAviso = new ClsAviso();
$ResAviso = $InsAviso->MtdObtenerAvisos(NULL,NULL,NULL,"AviTiempoCreacion","DESC",$POST_Limite,"3",$POST_VehiculoIngresoId);
$ArrAvisos = $ResAviso['Datos'];
?>
<input type="hidden" name="CmpVehiculoIngresoId" id="CmpVehiculoIngresoId" value="<?php echo $POST_VehiculoIngresoId;?>" />

<div class="EstNuevoFormularioContenedor">

<?php
	if(!empty($ArrAvisos)){
?>
<table width="100%" class="EstTablaListado">
	<thead class="EstTablaListadoHead">
    <tr>
    	<th width="2%" align="center">
        #
        </th>
		<th width="5%" align="center">
        Fecha
        </th>
		<th width="84%" align="center">Nota </th> 
        <th width="9%" align="center">Acciones</th>   
	</tr>
 	</thead>
	<tbody class="EstTablaListadoBody">
<?php
		$i=1;
		foreach($ArrAvisos as $DatAviso){
?>
	<tr>
    	<td>
			<?php echo $i;?>.-
        </td>
        <td>
        	<?php echo $DatAviso->AviFecha;?>
        </td>
        <td><?php echo $DatAviso->AviObservacion;?></td>
        <td align="center" valign="middle">
        
      <!--   <a class="AvisoListadoEditar" codigo="<?php echo $DatAviso->AviId;?>" href="#"><img src="imagenes/editar.gif" title="Editar" alt="[Editar]"   width="15" height="15" border="0"  /></a>                 
      -->
      
      <a class="AvisoListadoEliminar" codigo="<?php echo $DatAviso->AviId;?>" href="#"> <img  src="imagenes/eliminar.gif"  title="Eliminar"  alt="[Eliminar]" width="15" height="15" border="0"  /></a>
                  
      
        
        </td>
        
	</tr>
<?php	
			$i++;
		}
?>
	</tbody>
</table>
<?php
	}else{
?>
		No se encontraron avisos
<?php		
	}
?>
   
	
</div>


<div id="CapAvisoEstado"></div>

