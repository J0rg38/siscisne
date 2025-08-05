<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_FAC_101", "Se REGISTRO correctamente la FACTURA.");	
	define("SAS_FAC_102", "Se EDITO correctamente la FACTURA.");	

	define("SAS_FAC_105", "Se eliminaron correctamente las FACTURAS.");	

	define("SAS_FAC_107", "Se actualizaron a estado PENDIENTE correctamente las FACTURAS.");
	define("SAS_FAC_108", "Se actualizaron a estado ENTREGADO correctamente las FACTURAS.");
	define("SAS_FAC_109", "Se actualizaron a estado ANULADO correctamente las FACTURAS.");
	define("SAS_FAC_110", "Se actualizaron a estado RESERVADO correctamente las FACTURAS.");

	define("SAS_FAC_601", "Se EDITO correctamente el Id de la FACTURA.");
	define("SAS_FAC_602", "Se ESTABLECIO correctamente el REGIMEN de la FACTURA.");


	
/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_FAC_101", "No se pudo REGISTRAR la FACTURA.");	
	define("ERR_FAC_102", "No se pudo EDITAR la FACTURA.");		
	define("ERR_FAC_105", "No se pudieron ELIMINAR las FACTURAS.");			
	
	define("ERR_FAC_107", "No se pudieron ACTUALIZAR a estado PENDIENTE las FACTURAS.");
	define("ERR_FAC_108", "No se pudieron ACTUALIZAR a estado ENTREGADO las FACTURAS.");
	define("ERR_FAC_109", "No se pudieron ACTUALIZAR a estado ANULADO las FACTURAS.");
	define("ERR_FAC_110", "No se pudieron ACTUALIZAR a estado RESERVADO las FACTURAS.");
	
	define("ERR_FAC_201", "No se pudo REGISTRAR uno de los ITEMS del DETALLE de la FACTURA.");
	define("ERR_FAC_202", "No se pudo EDITAR uno de los ITEMS del DETALLE de la FACTURA.");
	define("ERR_FAC_203", "No se pudo ELIMINAR uno de los ITEMS del DETALLE de la FACTURA.");

	define("ERR_FAC_211", "No se pudo REGISTRAR uno de las NOTAS DE SERVICIO relacionada con la FACTURA.");
	define("ERR_FAC_213", "No se pudo ELIMINAR uno de las NOTAS DE SERVICIO relacionada con la FACTURA.");
	
	define("ERR_FAC_221", "No se pudo REGISTRAR uno de las NOTAS DE ENTREGA relacionada con la FACTURA.");
	define("ERR_FAC_223", "No se pudo ELIMINAR uno de las NOTAS DE ENTREGA relacionada con la FACTURA.");
	
	define("ERR_FAC_231", "No se pudo REGISTRAR uno de los ITEMS de las LETRAS de la FACTURA.");
	define("ERR_FAC_232", "No se pudo EDITAR uno de los ITEMS de las LETRAS de la FACTURA.");
	define("ERR_FAC_233", "No se pudo ELIMINAR uno de los ITEMS de las LETRAS de la FACTURA.");

	define("ERR_FAC_301", "No se pudo REGISTRAR al nuevo CLIENTE de la FACTURA.");
	define("ERR_FAC_302", "No se pudo EDITAR los datos del CLIENTE de la FACTURA.");

//	define("ERR_FAC_311", "No se pudo REGISTRAR la nueva DIRECCION de CLIENTE de la FACTURA.");
//	define("ERR_FAC_312", "No se pudo EDITAR la DIRECCION del CLIENTE de la FACTURA.");
	
	define("ERR_FAC_400", "No se puede registrar con una fecha posterior a la actual.");	
	define("ERR_FAC_401", "No se puede editar la FACTURA debido a que ya se cerro caja.");
	define("ERR_FAC_402", "El CODIGO de la FACTURA ya EXISTE.");
	define("ERR_FAC_403", "No se puede editar la FACTURA debido a que tiene una NOTA DE CREDITO.");					
	
	define("ERR_FAC_600", "No ha encontrado el tipo de cambio.");
	define("ERR_FAC_601", "No se pudo EDITAR el Id de la FACTURA.");	
	define("ERR_FAC_602", "No se pudo ESTABLECER el REGIMEN de la FACTURA.");	
	define("ERR_FAC_603", "No se pudo REGISTRAR la FACTURA, no se encontraron ITEMS.");
	define("ERR_FAC_604", "No se pudo REGISTRAR la FACTURA, ya existe una factura con el CODIGO DE MOVIMIENTO DE SALIDA DE ALMACEN actual.");
?>