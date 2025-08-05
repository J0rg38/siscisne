<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsPersonalSistemaPension'.$Identificador])){
	$_SESSION['InsPersonalSistemaPension'.$Identificador] = new ClsSesionObjeto();
}


/*
SesionObjeto-PersonalSistemaPensionListado
Parametro1 = PspId
Parametro2 = SpeId
Parametro3 = Fecha
Parametro4 = CodigoUnico
Parametro5 = SpeNombre

Parametro6 = TiempoCreacion
Parametro7 = TiempoModificacion
*/
	
$_SESSION['InsPersonalSistemaPension'.$Identificador]->MtdAgregarSesionObjeto(1,NULL,$_POST['SistemaPension'],$_POST['Fecha'],$_POST['CodigoUnico'],$_POST['SistemaPensionNombre'],date("d/m/Y H:i:s"),date("d/m/Y H:i:s"));
	


?>