<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_NCC_101", "Se registro correctamente la NOTA DE CREDITO DE COMPRA.");	
	define("SAS_NCC_102", "Se EDITO correctamente la NOTA DE CREDITO DE COMPRA.");	
	define("SAS_NCC_105", "Se eliminaron correctamente las NOTA DE CREDITO DE COMPRAS.");	

	define("SAS_NCC_601", "Se EDITO correctamente el Id de la NOTA DE CREDITO DE COMPRA.");
	define("SAS_NCC_602", "Se ESTABLECIO correctamente el REGIMEN de la NOTA DE CREDITO DE COMPRA.");

/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_NCC_101", "No se pudo registrar la NOTA DE CREDITO DE COMPRA.");	
	define("ERR_NCC_102", "No se pudo editar la NOTA DE CREDITO DE COMPRA.");		
	define("ERR_NCC_105", "No se pudieron eliminar las NOTA DE CREDITO DE COMPRAS.");			

	define("ERR_NCC_201", "No se pudo registrar uno de los items del DETALLE de la NOTA DE CREDITO DE COMPRA.");
	define("ERR_NCC_202", "No se pudo editar uno de los items del DETALLE de la NOTA DE CREDITO DE COMPRA.");
	define("ERR_NCC_203", "No se pudo eliminar uno de los items del DETALLE de la NOTA DE CREDITO DE COMPRA.");

	define("ERR_NCC_401", "No se puede editar la NOTA DE CREDITO DE COMPRA debido a que ya se cerro caja.");
	
	define("ERR_NCC_600", "No ha encontrado el tipo de cambio.");
	
	define("ERR_NCC_603", "No se pudo registrar la NOTA DE CREDITO DE COMPRA, no se encontraron items.");
	define("ERR_NCC_604", "No se pudo registrar la NOTA DE CREDITO DE COMPRA, ya existe una factura con el CODIGO DE MOVIMIENTO DE ENTRADA DE ALMACEN actual.");
?>