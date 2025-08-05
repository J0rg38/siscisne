<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_FAC_101", "Se registro correctamente la factura.");	
	define("SAS_FAC_102", "Se edito correctamente la factura.");	

	define("SAS_FAC_105", "Se eliminaron correctamente las facturas.");	

	define("SAS_FAC_107", "Se actualizaron a estado pendiente correctamente las facturas.");
	define("SAS_FAC_108", "Se actualizaron a estado entregado correctamente las facturas.");
	define("SAS_FAC_109", "Se actualizaron a estado anulado correctamente las facturas.");
	define("SAS_FAC_110", "Se actualizaron a estado reservado correctamente las facturas.");

	define("SAS_FAC_601", "Se edito correctamente el Id de la factura.");
	define("SAS_FAC_602", "Se ESTABLECIO correctamente el REGIMEN de la factura.");


	
/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_FAC_101", "No se pudo registrar la factura.");	
	define("ERR_FAC_102", "No se pudo editar la factura.");		
	define("ERR_FAC_105", "No se pudieron eliminar las facturas.");			
	
	define("ERR_FAC_107", "No se pudieron ACTUALIZAR a estado pendiente las facturas.");
	define("ERR_FAC_108", "No se pudieron ACTUALIZAR a estado entregado las facturas.");
	define("ERR_FAC_109", "No se pudieron ACTUALIZAR a estado anulado las facturas.");
	define("ERR_FAC_110", "No se pudieron ACTUALIZAR a estado reservado las facturas.");
	
	define("ERR_FAC_123", "Ingrese nuevamente los datos del cliente.");
	define("ERR_FAC_124", "Se debe ingresar un correo electronico.");		
		
	define("ERR_FAC_201", "No se pudo registrar uno de los items del DETALLE de la factura.");
	define("ERR_FAC_202", "No se pudo editar uno de los items del DETALLE de la factura.");
	define("ERR_FAC_203", "No se pudo eliminar uno de los items del DETALLE de la factura.");

	define("ERR_FAC_211", "No se pudo registrar uno de las Fichas de Salida relacionada con la factura.");
	define("ERR_FAC_213", "No se pudo eliminar uno de las Fichas de Salida relacionada con la factura.");
	
	define("ERR_FAC_221", "No se pudo registrar uno de las NOTAS DE ENTREGA relacionada con la factura.");
	define("ERR_FAC_223", "No se pudo eliminar uno de las NOTAS DE ENTREGA relacionada con la factura.");
	
	define("ERR_FAC_231", "No se pudo registrar uno de los items de las LETRAS de la factura.");
	define("ERR_FAC_232", "No se pudo editar uno de los items de las LETRAS de la factura.");
	define("ERR_FAC_233", "No se pudo eliminar uno de los items de las LETRAS de la factura.");

	define("ERR_FAC_301", "No se pudo registrar al nuevo CLIENTE de la factura.");
	define("ERR_FAC_302", "No se pudo editar los datos del CLIENTE de la factura.");

//	define("ERR_FAC_311", "No se pudo registrar la nueva DIRECCION de CLIENTE de la factura.");
//	define("ERR_FAC_312", "No se pudo editar la DIRECCION del CLIENTE de la factura.");
	
	define("ERR_FAC_400", "No se puede registrar con una fecha posterior a la actual.");	
	define("ERR_FAC_401", "No se puede editar la factura debido a que ya se cerro caja.");
	define("ERR_FAC_402", "El CODIGO de la factura ya EXISTE.");
	define("ERR_FAC_403", "No se puede editar la factura debido a que tiene una NOTA DE CREDITO.");					
	
	define("ERR_FAC_600", "No ha encontrado el tipo de cambio.");
	define("ERR_FAC_601", "No se pudo editar el Id de la factura.");	
	define("ERR_FAC_602", "No se pudo ESTABLECER el REGIMEN de la factura.");	
	define("ERR_FAC_603", "No se pudo registrar la factura, no se encontraron items.");
	define("ERR_FAC_604", "No se pudo registrar la factura, ya existe una factura con el CODIGO DE MOVIMIENTO DE SALIDA DE ALMACEN actual.");


	define("ERR_FAC_900", "No se pudo registrar el abono.");
	define("ERR_FAC_901", "No se pudo encontro el tipo de cambio del ABONO.");
?>