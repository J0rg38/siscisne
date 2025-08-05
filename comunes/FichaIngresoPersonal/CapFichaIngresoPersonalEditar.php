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

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


$POST_FichaIngresoId = $_POST['FichaIngresoId'];
$POST_PersonalId = $_POST['PersonalId'];

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsPersonal = new ClsPersonal();
$InsFichaIngreso = new ClsfichaIngreso();

$InsFichaIngreso->FinId = $POST_FichaIngresoId;
$InsFichaIngreso->MtdObtenerFichaIngreso(false);

////MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,1,NULL,NULL,NULL,$InsFichaIngreso->SucId,NULL,NULL,true);
$ArrTecnicos = $ResPersonal['Datos'];

?>

<div class="EstNuevoFormularioContenedor">
	<div class="EstNuevoFormularioEtiqueta">
    
        <select  class="EstFormularioCombo" name="CmpFichaIngresoPersonal_<?php echo $POST_FichaIngresoId;?>" id="CmpFichaIngresoPersonal_<?php echo $POST_FichaIngresoId;?>" >
        <option selected="selected" value="">Escoja una opcion</option>
        <?php
        foreach($ArrTecnicos as $DatTecnico){
        ?>
        <option <?php echo (($DatTecnico->PerId==$POST_PersonalId)?'selected="selected"':'')?>  value="<?php echo $DatTecnico->PerId;?>"><?php echo $DatTecnico->PerNombre ?> <?php echo $DatTecnico->PerApellidoPaterno; ?> <?php echo $DatTecnico->PerApellidoMaterno; ?></option>
        <?php
        }
        ?>
        </select>
        
	</div>
	<div class="EstNuevoFormularioBoton">
		<input id="BtnFichaIngresoPersonalGuardar_<?php echo $POST_FichaIngresoId;?>"  name="BtnFichaIngresoPersonalGuardar_<?php echo $POST_FichaIngresoId;?>" type="button" value="Guardar"  />
        <input id="BtnFichaIngresoPersonalCancelar_<?php echo $POST_FichaIngresoId;?>"  name="BtnFichaIngresoPersonalCancelar_<?php echo $POST_FichaIngresoId;?>" type="button" value="Cancelar"  />
	</div>
</div>
<div id="CapFichaIngresoPersonalEstado"></div>