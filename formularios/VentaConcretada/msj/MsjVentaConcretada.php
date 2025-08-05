<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_VCO_101", "Se registro correctamente la venta concretada.");	
	define("SAS_VCO_102", "Se edito correctamente la venta concretada.");	
	define("SAS_VCO_105", "Se eliminaron correctamente las ventas concretadas.");
	define("SAS_VCO_106", "Se envio correctamente la Solicitud de Facturacion.");

	define("SAS_VCO_108", "Se anularon los las ventas concretadas correctamente.");
	define("SAS_VCO_109", "Se desanularon los las ventas concretadas correctamente.");	

/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_VCO_101", "No se pudo registrar la venta concretada.");	
	define("ERR_VCO_102", "No se pudo editar la venta concretada.");		
	define("ERR_VCO_105", "No se pudieron eliminar las ventas concretadas.");
	define("ERR_VCO_106", "No se pudo enviar Solicitud de Facturacion.");

	define("ERR_VCO_108", "No se pudieron anular las ventas concretadas.");
	define("ERR_VCO_109", "No se pudieron desanular las ventas concretadas.");
	
	define("ERR_VCO_111", "No se pudo registrar la venta concretada, no se encontraron items.");
	define("ERR_VCO_112", "No ha escogido el almacen de origen.");
	
	define("ERR_VCO_201", "No se pudo registrar uno de los items del detalle de la venta concretada.");
	define("ERR_VCO_202", "No se pudo editar uno de los items del detalle de la venta concretada.");
	define("ERR_VCO_203", "No se pudo eliminar uno de los items del detalle de la venta concretada.");
	
	define("ERR_VCO_204", "no se encontro unidad de medida");
	define("ERR_VCO_205", "no se encontro equivalencia");
	define("ERR_VCO_206", "no se identifico el producto");
	define("ERR_VCO_207", "no se ingreso una cantidad");
	define("ERR_VCO_208", "no tiene stock");
	
//	define("ERR_VCO_301", "No se pudo registrar al nuevo CLIENTE de la venta concretada.");
//	define("ERR_VCO_302", "No se pudo editar los datos del CLIENTE de la venta concretada.");

	define("ERR_VCO_400", "No se puede registrar con una fecha posterior a la actual.");	
//	define("ERR_VCO_401", "No se puede editar la venta concretada debido a que ya se cerro caja o ya fue declarado.");	

	//define("ERR_VCO_501", "Uno de los items de la venta concretada se ha quedado sin stock.");	

	define("ERR_VCO_601", "No se puede editar la venta concretada debido a que tiene una FACTURA.");
	define("ERR_VCO_602", "No se puede registrar la venta concretada debido a que no ha escogido una ORDEN DE VENTA DE REPUESTO.");
	

?>