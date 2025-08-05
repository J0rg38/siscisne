<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/

	define("SAS_PCO_101", "Se registro correctamente el pedido de compra.");	
	define("SAS_PCO_102", "Se edito correctamente el pedido de compras.");	
	define("SAS_PCO_105", "Se eliminaron correctamente los pedidos de compra.");

	define("SAS_PCO_109", "Se envio correo electronico del pedido de compra correctamente.");
	define("SAS_PCO_110", "Se envio consula ETA del pedido de compra correctamente.");
	
	define("SAS_PCO_112", "Se actualizaron a APROBADO los pedidos de compra.");
	define("SAS_PCO_113", "Se actualizaron a DESAPROBADO los pedidos de compra.");
	
	define("SAS_PCO_114", "Se envio solicitud de autorizacion del pedido de compra correctamente.");

/*
* Mensajes de error
*/	

	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_PCO_101", "No se pudo registrar el pedido de compra.");	
	define("ERR_PCO_102", "No se pudo editar el pedido de compra.");		
	define("ERR_PCO_105", "No se pudieron eliminar llos pedidos de compra.");
	
	define("ERR_PCO_109", "No se pudo enviar correo electronico del pedido de compra.");
	define("ERR_PCO_110", "No se pudo enviar consulta ETA del pedido de compra.");
	
	define("ERR_PCO_112", "No se pudieron actualizar a APROBADO los pedidos de compra.");
	define("ERR_PCO_113", "No se pudieron actualizar a DESAPROBADO los pedidos de compra.");
	
	define("ERR_PCO_114", "No se pudo enviar la solicitud de autorizacion de pedido de compra.");
	
	
	
	
	
	
	define("ERR_PCO_111", "No se pudo registrar el pedido de compra, no se encontraron items.");

	define("ERR_PCO_123", "Ingrese nuevamente los datos del cliente.");
	
	define("ERR_PCO_201", "No se pudo registrar uno de los items del DETALLE de el pedido de compra.");
	define("ERR_PCO_202", "No se pudo editar uno de los items del DETALLE de el pedido de compra.");
	define("ERR_PCO_203", "No se pudo eliminar uno de los items del DETALLE de el pedido de compra.");

	define("ERR_PCO_400", "No se puede registrar con una fecha posterior a la actual.");	
	define("ERR_PCO_401", "No se puede editar el pedido de compra debido a que ya se cerro caja o ya fue declarado.");	

	define("ERR_PCO_600", "No ha encontrado el tipo de cambio.");
		
	define("ERR_PCO_701", "No se encontraron items.");	
	define("ERR_PCO_702", "No se pudo registrar uno de los items, no se encontro UNIDAD DE MEDIDA.");
	define("ERR_PCO_703", "No se pudo registrar uno de los items, no se encontro EQUIVALENCIA.");	
	define("ERR_PCO_704", "No se pudo registrar uno de los items, no se puede PEDIR una cantidad MAYOR a la SOLICITAD en la ORDEN DE VENTA.");	
	
	

	define("ERR_PCO_1000", "No se pudo identificar el CLIENTE, ingreselo nuevamente.");
?>