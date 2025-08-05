<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_VDI_101", "Se registro correctamente la ORDEN DE VENTA.");	
	define("SAS_VDI_102", "Se EDITO correctamente la ORDEN DE VENTA.");	
	define("SAS_VDI_105", "Se eliminaron correctamente las ORDENES DE VENTA.");
	define("SAS_VDI_106", "Se ENVIARON A CONTABILIDAD correctamente las ORDENES DE VENTA.");

	define("SAS_VDI_108", "Se marcaron como PENDIENTE los las ORDENES DE VENTA correctamente.");
	define("SAS_VDI_109", "Se marcaron como REALIZADO las ORDENES DE VENTA correctamente.");	
	define("SAS_VDI_110", "Se marcaron como ANULADO las ORDENES DE VENTA correctamente.");	

/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_VDI_101", "No se pudo registrar la ORDEN DE VENTA.");	
	define("ERR_VDI_102", "No se pudo editar la ORDEN DE VENTA.");		
	define("ERR_VDI_105", "No se pudieron eliminar las ORDENES DE VENTA.");
	define("ERR_VDI_106", "No se pudieron enviar A CONTABILIDAD las ORDENES DE VENTA.");

	define("ERR_VDI_108", "No se pudieron marcar como PENDIENTE las ORDENES DE VENTA.");
	define("ERR_VDI_109", "No se pudieron marcar como REALIZADO las ORDENES DE VENTA.");
	define("ERR_VDI_110", "No se pudieron marcar como ANULADO las ORDENES DE VENTA.");
	define("ERR_VDI_111", "No se pudo registrar la ORDEN DE VENTA, no se encontraron items.");

	define("ERR_VDI_120", "No ha encontrado el tipo de cambio.");
	define("ERR_VDI_121", "No se puede editar la ORDEN DE VENTA debido a que tiene una VENTA CONCRETADA o PEDIDO DE COMPRA.");
	define("ERR_VDI_122", "No se puede registrar la ORDEN DE VENTA debido a que existe una ORDEN DE COMPRA DE REFERENCIA con el mismo numero.");
	define("ERR_VDI_123", "Ingrese nuevamente los datos del cliente.");
	
	
	define("ERR_VDI_201", "No se pudo registrar uno de los items del DETALLE de la ORDEN DE VENTA.");
	define("ERR_VDI_202", "No se pudo editar uno de los items del DETALLE de la ORDEN DE VENTA.");
	define("ERR_VDI_203", "No se pudo eliminar uno de los items del DETALLE de la ORDEN DE VENTA.");

	define("ERR_VDI_301", "No se pudo registrar uno de los items del PLANCHADO de la ORDEN DE VENTA.");
	define("ERR_VDI_302", "No se pudo editar uno de los items del PLANCHADO de la ORDEN DE VENTA.");
	define("ERR_VDI_303", "No se pudo eliminar uno de los items del PLANCHADO de la ORDEN DE VENTA.");
		
	define("ERR_VDI_401", "No se pudo registrar uno de los items del PINTADO de la ORDEN DE VENTA.");
	define("ERR_VDI_402", "No se pudo editar uno de los items del PINTADO de la ORDEN DE VENTA.");
	define("ERR_VDI_403", "No se pudo eliminar uno de los items del PINTADO de la ORDEN DE VENTA.");
		
	define("ERR_VDI_501", "No se pudo registrar uno de los items del PINTADO de la ORDEN DE VENTA.");
	define("ERR_VDI_502", "No se pudo editar uno de los items del PINTADO de la ORDEN DE VENTA.");
	define("ERR_VDI_503", "No se pudo eliminar uno de los items del PINTADO de la ORDEN DE VENTA.");
	
	define("ERR_VDI_601", "No se pudo registrar uno de los items de TAREAS de la ORDEN DE VENTA.");
	define("ERR_VDI_602", "No se pudo editar uno de los items de TAREAS de la ORDEN DE VENTA.");
	define("ERR_VDI_603", "No se pudo eliminar uno de los items de TAREAS de la ORDEN DE VENTA.");
	
	define("ERR_VDI_701", "No se pudo registrar uno de las FOTOS de la ORDEN DE VENTA.");
	define("ERR_VDI_702", "No se pudo editar uno de las FOTOS de la ORDEN DE VENTA.");
	define("ERR_VDI_703", "No se pudo eliminar uno de las FOTOS de la ORDEN DE VENTA.");


//	define("ERR_VDI_301", "No se pudo registrar al nuevo CLIENTE de la ORDEN DE VENTA.");
//	define("ERR_VDI_302", "No se pudo editar los datos del CLIENTE de la ORDEN DE VENTA.");

	//define("ERR_VDI_400", "No se puede registrar con una fecha posterior a la actual.");	
//	define("ERR_VDI_401", "No se puede editar la ORDEN DE VENTA debido a que ya se cerro caja o ya fue declarado.");	
	//define("ERR_VDI_402", "No se puede registrar con una fecha posterior a la actual.");	

	//define("ERR_VDI_501", "Uno de los items de la ORDEN DE VENTA se ha quedado sin stock.");	
	//define("ERR_VDI_500", "No se puede registrar con una fecha posterior a la actual.");

	//define("ERR_VDI_600", "No ha encontrado el tipo de cambio.");
	//define("ERR_VDI_601", "No se puede editar la ORDEN DE VENTA debido a que tiene una VENTA CONCRETADA o PEDIDO DE COMPRA.");
	//define("ERR_VDI_602", "No se puede registrar la ORDEN DE VENTA debido a que existe una ORDEN DE COMPRA DE REFERENCIA con el mismo numero.");

	//define("ERR_VDI_701", "No se encontraron items.");	
//	define("ERR_VDI_702", "No se pudo registrar uno de los items, no se encontro UNIDAD DE MEDIDA.");
//	define("ERR_VDI_703", "No se pudo registrar uno de los items, no se encontro EQUIVALENCIA.");
//	define("ERR_VDI_704", "No se pudo registrar uno de los items, no se identifico el PRODUCTO.");

	define("ERR_VDI_900", "No se pudo registrar el ABONO.");
	define("ERR_VDI_901", "No se pudo encontro el tipo de cambio del ABONO.");

/*
* AUTO GENERAR VENTA CONCRETADAS
*/	
	
	define("ERR_VDI_1000", "No se pudo registrar el ABONO.");
	
	define("ERR_VDI_1001", "No se pudo registrar la venta concretada.");
	define("ERR_VDI_1002", "No se encontraron items para generar venta concretada.");
	define("ERR_VDI_1003", "No se encontro numero de venta directa");
	define("ERR_VDI_1004", "La venta directa tiene observaciones, se tiene que generar la venta concretada manualmente");
	
	
	
	
?>