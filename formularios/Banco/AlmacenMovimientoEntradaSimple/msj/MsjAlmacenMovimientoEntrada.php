<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_AMO_101", "Se registro correctamente la ENTRADA A ALMACEN.");	
	define("SAS_AMO_102", "Se edito correctamente la ENTRADA A ALMACEN.");	
	define("SAS_AMO_105", "Se eliminaron correctamente las COMPRA/SERVICIOS.");
	
	define("SAS_AMO_106", "Se MARCARON COMO REVISADO correctamente las COMPRA/SERVICIOS.");
	define("SAS_AMO_107", "Se MARCARON COMO NO REVISADO correctamente las COMPRA/SERVICIOS.");
	
/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_AMO_101", "No se pudo registrar la ENTRADA A ALMACEN.");	
	define("ERR_AMO_102", "No se pudo editar la ENTRADA A ALMACEN.");		
	define("ERR_AMO_105", "No se pudieron eliminar las COMPRA/SERVICIOS.");
	
	define("ERR_AMO_106", "No se pudieron MARCAR COMO REVISADO las COMPRA/SERVICIOS.");
	define("ERR_AMO_107", "No se pudieron MARCAR COMO NO REVISADO las COMPRA/SERVICIOS.");
	
	
	define("ERR_AMO_111", "No se pudo REGISTRAR la ENTRADA DE ALMACEN, no se encontraron ITEMS.");
	
	define("ERR_AMO_110", "El valor ingresado no coincide con la suma total de todos los items ingresados");	
	
	define("ERR_AMO_201", "No se pudo REGISTRAR uno de los ITEMS del DETALLE de la MOVIMIENTO DE ALMACEN.");
	define("ERR_AMO_202", "No se pudo EDITAR uno de los ITEMS del DETALLE de la MOVIMIENTO DE ALMACEN.");
	define("ERR_AMO_203", "No se pudo ELIMINAR uno de los ITEMS del DETALLE de la MOVIMIENTO DE ALMACEN.");

	define("ERR_AMO_301", "No se pudo REGISTRAR al nuevo PROVEEDOR de la MOVIMIENTO DE ALMACEN.");
	define("ERR_AMO_302", "No se pudo EDITAR los datos del PROVEEDOR de la MOVIMIENTO DE ALMACEN.");

	define("ERR_AMO_400", "No se puede registrar con una fecha posterior a la actual.");	
	define("ERR_AMO_401", "No se puede editar la ENTRADA A ALMACEN debido a que ya se cerro caja o ya fue declarado.");	

	define("ERR_AMO_600", "No ha encontrado el tipo de cambio.");
	
	define("ERR_AMO_601", "No se pudo REGISTRAR la ENTRADA A ALMACEN, ya que el NUMERO DE COMPRAS/SERVICIOS ya EXISTE.");

?>