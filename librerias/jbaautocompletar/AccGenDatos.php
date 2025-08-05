<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsArticulo.php');

$InsArticulo = new ClsArticulo();

$q = strtolower($_GET["q"]);
if (!$q) return;

$ResArticulo = $InsArticulo->MtdObtenerArticulos("ArtNombreCorto,ArtNombre","contiene",$q,"ArtNombreCorto","DESC",NULL,NULL,1,false,$_GET['Tip'],$_GET['Vst']);
$ArrArticulos = $ResArticulo['Datos'];

$Archivo = "xmldatos.xml";
$cadena = '<?xml version="1.0" encoding="utf-8"?>'.chr(13);
			
	if(empty($ArrArticulos)){
		
	}else{
		$cadena .=	'<bloque>'.	chr(13);
		foreach($ArrArticulos as $DatArticulo){		
			$cadena .=	'<Item>'.	chr(13);
			$cadena .=	'<Parametro1>'.($DatArticulo->ArtId).'</Parametro1>'.chr(13);
			$cadena .=	'<Parametro2>'.($DatArticulo->ArtNombre).'</Parametro2>'.chr(13);
			$cadena .=	'<Parametro3>'.($DatArticulo->ArtUnidadMedida).'</Parametro3>'.chr(13);
			$cadena .=	'<Parametro4>'.($DatArticulo->ArtCosto).'</Parametro4>'.chr(13);
			$cadena .=	'<Parametro5>'.($DatArticulo->ArtPrecio).'</Parametro5>'.chr(13);
			$cadena .=	'<Parametro6>'.($DatArticulo->ArtTipo).'</Parametro6>'.chr(13);
			$cadena .=	'</Item>'.chr(13);
		}
		$cadena .=	'</bloque> ';
	}
		
	$Archivo = fopen($Archivo,"w+");
			
	if(fwrite ($Archivo,$cadena)){
		fclose($Archivo);
	}	
			
?>