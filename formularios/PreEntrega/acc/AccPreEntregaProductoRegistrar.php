<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}
/*
SesionObjeto-FichaIngresoProducto
Parametro1 = FidId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = 
Parametro5 = 
Parametro6 = 
Parametro7 = FipTiempoCreacion
Parametro8 = FipTiempoModificacion
*/

$POST_ProductoId = $_POST['ProductoId'];
$POST_ProductoNombre = $_POST['ProductoNombre'];
$POST_ProductoCodigoOriginal = $_POST['ProductoCodigoOriginal'];
$POST_ProductoCodigoAlternativo = $_POST['ProductoCodigoAlternativo'];

if(!empty($POST_ProductoId)){

	$_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$POST_ProductoId,
	(stripslashes($POST_ProductoNombre)),
	$POST_ProductoCodigoOriginal,
	$POST_ProductoCodigoAlternativo,
	NULL,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s")
	);
	
}else{
	echo "No se identifico el PRODUCTO. \n Recuerde escoger el PRODUCTO del LISTADO DESPLEGABLE.";	
}



?>