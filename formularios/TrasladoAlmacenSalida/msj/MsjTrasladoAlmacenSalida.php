<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_TAS_101", "Se registro correctamente la transferencia de salida.");	
	define("SAS_TAS_102", "Se edito correctamente la transferencia de salida.");	
	define("SAS_TAS_105", "Se eliminaron correctamente las transferencias de salida.");
	
	define("SAS_TAS_108", "Se actualizaron a estado No Realizado las transferencias de salida correctamente.");
	define("SAS_TAS_109", "Se actualizaron a estado Realizado las transferencias de salida correctamente.");	
/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_TAS_101", "No se pudo registrar la transferencia de salida.");	
	define("ERR_TAS_102", "No se pudo editar la transferencia de salida.");		
	define("ERR_TAS_105", "No se pudieron eliminar las transferencias de salida.");
	
	define("ERR_TAS_108", "No se pudieron actualizar a estado No Realizado las transferencias de salida.");
	define("ERR_TAS_109", "No se pudieron actualizar a estado Realizado las transferencias de salida.");
	
	define("ERR_TAS_111", "No se pudo registrar la transferencia de salida, no se encontraron items.");
	define("ERR_TAS_112", "No ha ingresado el almacen de origen.");
	
	define("ERR_TAS_201", "No se pudo registrar uno de los items del detalle de la transferencia de salida.");
	define("ERR_TAS_202", "No se pudo editar uno de los items del detalle de la transferencia de salida.");
	define("ERR_TAS_203", "No se pudo eliminar uno de los items del detalle de la transferencia de salida.");

	define("ERR_TAS_204", "no se encontro unidad de medida");
	define("ERR_TAS_205", "no se encontro equivalencia");
	define("ERR_TAS_206", "no se identifico el producto");
	define("ERR_TAS_207", "no se ingreso una cantidad");
	define("ERR_TAS_208", "no tiene stock");
	
	define("ERR_TAS_400", "No se puede registrar con una fecha posterior a la actual.");	
	define("ERR_TAS_401", "No se puede editar la transferencia de salida debido a que ya se cerro caja o ya fue declarado.");	

	define("ERR_TAS_501", "Uno de los items la transferencia de salida se ha quedado sin stock.");
	
	define("ERR_TAS_601", "No se puede editar la transferencia de salida debido a que tiene una FACTURA.");
	
?>