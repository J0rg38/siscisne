<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_AMO_101", "Se registro correctamente el ingreso de almacen x concepto.");	
	define("SAS_AMO_102", "Se edito correctamente el ingreso de almacen x concepto.");	
	define("SAS_AMO_105", "Se eliminaron correctamente los ingresos a almacen x otro concepto.");
	
	define("SAS_AMO_106", "Se marcaron como revisado correctamente los ingresos a almacen x otro concepto.");
	define("SAS_AMO_107", "Se marcaron como no revisado correctamente los ingresos a almacen x otro concepto.");
	define("SAS_AMO_108", "Se actualizaron a estado No Realizado los ingresos a almcen x otro concepto correctamente.");
	define("SAS_AMO_109", "Se actualizaron a estado Realizado los ingresos a almcen x otro concepto correctamente.");	
/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_AMO_101", "No se pudo registrar el ingreso de almacen x concepto.");	
	define("ERR_AMO_102", "No se pudo editar el ingreso de almacen x concepto.");		
	define("ERR_AMO_105", "No se pudieron eliminar los ingresos a almacen x otro concepto.");
	
	define("ERR_AMO_106", "No se pudieron marcar como revisado los ingresos a almacen x otro concepto.");
	define("ERR_AMO_107", "No se pudieron marcar como no revisado los ingresos a almacen x otro concepto.");
	define("ERR_AMO_108", "No se pudieron actualizar a estado No Realizado los ingresos a almacen x otro concepto.");
	define("ERR_AMO_109", "No se pudieron actualizar a estado Realizado los ingresos a almacen x otro concepto.");
	
	define("ERR_AMO_111", "No se pudo registrar el ingreso a almacen x concepto, no se encontraron items.");
	
	define("ERR_AMO_110", "El valor ingresado no coincide con la suma total de todos los items ingresados");	
	
	define("ERR_AMO_201", "No se pudo registrar uno de los items del Detalle del ingreso a almacen x otro concepto.");
	define("ERR_AMO_202", "No se pudo editar uno de los items del Detalle del ingreso a almacen x otro concepto.");
	define("ERR_AMO_203", "No se pudo eliminar uno de los items del Detalle del ingreso a almacen x otro concepto.");

	define("ERR_AMO_301", "No se pudo registrar al nuevo Proveedor del ingreso a almacen x otro concepto.");
	define("ERR_AMO_302", "No se pudo editar los datos del Proveedor del ingreso a almacen x otro concepto.");

	define("ERR_AMO_400", "No se puede registrar con una fecha posterior a la actual.");	
	define("ERR_AMO_401", "No se puede editar el ingreso de almacen x concepto debido a que ya se cerro caja o ya fue declarado.");	

	define("ERR_AMO_600", "No ha encontrado el tipo de cambio.");
	define("ERR_AMO_601", "No se pudo registrar el ingreso de almacen x concepto, ya que el NUMERO DE COMPRAS/SERVICIOS ya EXISTE.");
	define("ERR_AMO_602", "No ha escogido un Almacen Destino.");
		define("ERR_AMO_603", "No se pudo registrar el ingreso a almacen x compra, ya que la fecha se encuentra con Cierre.");
	
?>