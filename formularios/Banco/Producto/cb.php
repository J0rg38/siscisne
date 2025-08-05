<?php
	header('Content: image/png');
/*
*Archivos de Sistema
*/
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta='../../';
$InsProyecto->Ruta='../../';

define('IN_CB',true);
	
require($InsProyecto->MtdRutLibrerias().'/barcode_generator/class/index.php');
require($InsProyecto->MtdRutLibrerias().'/barcode_generator/class/FColor.php');
require($InsProyecto->MtdRutLibrerias().'/barcode_generator/class/BarCode.php');
require($InsProyecto->MtdRutLibrerias().'/barcode_generator/class/FDrawing.php');
require($InsProyecto->MtdRutLibrerias().'/barcode_generator/class/code128.barcode.php');



if(isset($_GET['t']) && isset($_GET['r']) && isset($_GET['text']) && isset($_GET['f']) && isset($_GET['o'])){

//if(isset($_GET['t']) && isset($_GET['r']) && isset($_GET['text']) && isset($_GET['f']) && isset($_GET['o']) && isset($_GET['a1']) && isset($_GET['a2'])){
	
		$color_black = new FColor(0,0,0);
		$color_white = new FColor(255,255,255);
		

		
		//$code_generated = new code128($_GET['t'],$color_black,$color_white,$_GET['r'],$_GET['text'],$_GET['f'],"B","*","LUCARO INK");
		
		$code_generated = new code128($_GET['t'],$color_black,$color_white,$_GET['r'],$_GET['text'],$_GET['f'],"B","*","");
				
		$drawing = new FDrawing(1024,1024,'',$color_white);
		$drawing->init();
		$drawing->add_barcode($code_generated);
		$drawing->draw_all();
		
		$im = $drawing->get_im();
		$im2 = imagecreate($code_generated->lastX,$code_generated->lastY);
		imagecopyresized($im2, $im, 0, 0, 0, 0, $code_generated->lastX, $code_generated->lastY, $code_generated->lastX, $code_generated->lastY);
		$drawing->set_im($im2);
		$drawing->finish($_GET['o']);


}
else{
	readfile('error.png');
}
?>