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
$POST_AvisoObservacion = $_POST['AvisoObservacion'];

require_once($InsPoo->MtdPaqLogistica().'ClsAviso.php');

?>
<input type="hidden" name="CmpVehiculoIngresoId" id="CmpVehiculoIngresoId" value="<?php echo $POST_VehiculoIngresoId;?>" />

<div class="EstNuevoFormularioContenedor">

	<div class="EstNuevoFormularioEtiqueta">Observacion:</div>
    <div class="EstNuevoFormularioContenido">
      <textarea name="CmpAvisoObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpAvisoObservacion"></textarea>
    </div>

	<div class="EstNuevoFormularioBoton">
    <input class="EstFormularioBoton" type="button" name="BtnAvisoGuardar" id="BtnAvisoGuardar" value="Guardar" />
     <input class="EstFormularioBoton" type="button" name="BtnAvisoCancelar" id="BtnAvisoCancelar" value="Cancelar" />
    </div>
   
	
</div>
<div id="CapAvisoEstado"></div>

