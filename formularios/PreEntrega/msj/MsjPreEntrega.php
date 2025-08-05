<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_FIN_101", "Se registro correctamente la ORDEN DE TRABAJO.");	
	define("SAS_FIN_102", "Se EDITO correctamente las ORDENES DE TRABAJO.");
		
	define("SAS_FIN_103", "Se EDITO correctamente el TECNICO de la ORDEN DE TRABAJO.");	
	define("SAS_FIN_104", "Se EDITO correctamente el INVENTARIO de la ORDEN DE TRABAJO.");	
	
	define("SAS_FIN_105", "Se eliminaron correctamente las ORDENES DE TRABAJO.");
	define("SAS_FIN_106", "Se CORRIGIO correctamente la ORDEN DE TRABAJO.");
	
	define("SAS_FIN_107", "Se ENVIARON las ORDENES DE TRABAJO a TALLER correctamente.");
	define("SAS_FIN_108", "Se REGRESARON las ORDENES DE TRABAJO a RECEPCION correctamente.");

	define("SAS_FIN_109", "Se EDITO correctamente las HERRAMIENTAS de la ORDEN DE TRABAJO.");

/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_FIN_101", "No se pudo registrar la ORDEN DE TRABAJO.");	
	define("ERR_FIN_102", "No se pudo editar la ORDEN DE TRABAJO.");
	define("ERR_FIN_103", "No se pudo editar el TECNICO de la ORDEN DE TRABAJO.");			
	define("ERR_FIN_104", "No se pudo editar el INVENTARIO de la ORDEN DE TRABAJO.");			
	
	define("ERR_FIN_105", "No se pudieron eliminar las ORDENES DE TRABAJO.");
	define("ERR_FIN_106", "No se pudo CORREGIR la ORDEN DE TRABAJO.");
	
	define("ERR_FIN_107", "No se pudieron enviar las ORDENES DE TRABAJO a TALLER.");
	define("ERR_FIN_108", "No se pudieron REGRESAR las ORDENES DE TRABAJO a RECEPCION.");
	
	define("ERR_FIN_109", "No se pudo editar las HERRAMIENTAS de la ORDEN DE TRABAJO.");


	define("ERR_FIN_201", "No se pudo registrar una de las MODALIDADES DE INGRESO de la ORDEN DE TRABAJO.");
	define("ERR_FIN_202", "No se pudo editar una de las MODALIDADES DE INGRESO de la ORDEN DE TRABAJO.");
	define("ERR_FIN_203", "No se pudo eliminar una de las MODALIDADES DE INGRESO la ORDEN DE TRABAJO.");	
	
	define("ERR_FIN_211", "No se pudo registrar una de las HERRAMIENTAS de la ORDEN DE TRABAJO.");
	define("ERR_FIN_212", "No se pudo editar una de las HERRAMIENTAS de la ORDEN DE TRABAJO.");
	define("ERR_FIN_213", "No se pudo eliminar una de las HERRAMIENTAS la ORDEN DE TRABAJO.");	
	
	define("ERR_FIN_214", "No se puede registrar una de los HERRAMIENTAS, no se encontro UNIDAD DE MEDIDA.");
	define("ERR_FIN_215", "No se puede registrar una de los HERRAMIENTAS, no se identifico el PRODUCTO.");
	define("ERR_FIN_216", "No se puede registrar una de los HERRAMIENTAS, no se ingreso una CANTIDAD.");
	define("ERR_FIN_217", "No se puede registrar una de los HERRAMIENTAS, no se encontro EQUIVALENCIA.");
	

	define("ERR_FIN_301", "No se pudo registrar una de las TAREAS DE PRE ENTREGA de la ORDEN DE TRABAJO.");
	define("ERR_FIN_302", "No se pudo editar una de las TAREAS DE PRE ENTREGA de la ORDEN DE TRABAJO.");
	define("ERR_FIN_303", "No se pudo eliminar una de las TAREAS DE PRE ENTREGA la ORDEN DE TRABAJO.");	
	
	
	
	define("ERR_FIN_601", "No se identifico correctamente el VIN, ingrese nuevamente el VIN del VEHICULO.");	
	define("ERR_FIN_602", "No se identifico correctamente al CLIENTE, escoja nuevamente al CLIENTE.");	
	define("ERR_FIN_603", "No se escogio el KILOMETRAJE del PLAN DE MANTENIMIENTO.");
	
	define("ERR_FIN_604", "No se pudo relacionar el VIN con el CLIENTE.");	
	define("ERR_FIN_605", "No se pudo actualizar la PLACA del VEHICULO.");	
	
	define("ERR_FIN_606", "No se pudo encontrar un PLAN DE MANTENIMIENTO.");
	define("ERR_FIN_607", "No ha MARCADO ninguna MODALIDAD DE INGRESO.");

	//define("ERR_FIN_608", "No se puede editar la ORDEN DE TRABAJO, solo se puede EDITAR el tecnico a las ODENES DE TRABAJO en estado:  - RECEPCION [Enviado] - TALLER [Revisando]");
	
	
	define("ERR_FIN_700", "No se puede editar la ORDEN DE TRABAJO, solo se puede EDITAR las ODENES DE TRABAJO en estado: - RECEPCION [Pendiente]");
	define("ERR_FIN_701", "No se puede editar la ORDEN DE TRABAJO, solo se puede EDITAR el TECNICO las ODENES DE TRABAJO en estado: - RECEPCION [Enviado] - TALLER [Revisando]");
	define("ERR_FIN_702", "No se puede editar la ORDEN DE TRABAJO, solo se puede EDITAR el INVENTARIO las ODENES DE TRABAJO en estado: - RECEPCION [Enviado] - TALLER [Revisando]");
	

	define("ERR_FIN_900","Solo pueden ser ENVIADAS a TALLER las ORDENES DE TRABAJO con estado: - RECEPCION [Pendiente]");
	define("ERR_FIN_901","Solo pueden ser ACTUALIZADAS como TALLER [Revisando] las ORDENES DE TRABAJO con estado: - RECEPCION [Enviado]");
	define("ERR_FIN_902","Solo pueden ser ACTUALIZADAS como TALLER [Preparando Pedido] las ORDENES DE TRABAJO con estado: - TALLER [Revisando] - TALLER [Pedido Enviado]");
	define("ERR_FIN_903","Solo pueden ser ACTUALIZADAS como TALLER [Pedido Enviado] las ORDENES DE TRABAJO con estado: - TALLER [Preparando Pedido]");
	define("ERR_FIN_904","Solo pueden ser ACTUALIZADAS como ALMACEN [Revisado Pedido] las ORDENES DE TRABAJO con estado: - TALLER [Pedido Enviado]");
	define("ERR_FIN_905","Solo pueden ser ACTUALIZADAS como ALMACEN [Preparando Pedido] las ORDENES DE TRABAJO con estado: - ALMACEN [Revisado Pedido]");
	define("ERR_FIN_906","Solo pueden ser ACTUALIZADAS como ALMACEN [Pedido Enviado] las ORDENES DE TRABAJO con estado: - ALMACEN [Preparando Pedido] - ALMACEN [Pedido Extornado]");
	define("ERR_FIN_907","Solo pueden ser ACTUALIZADAS como TALLER [Pedido Recibido] las ORDENES DE TRABAJO con estado: - ALMACEN [Pedido Enviado] - TALLER [Trabajo Terminado] - RECEPCIO [Revisando]");
	define("ERR_FIN_908","Solo pueden ser ACTUALIZADAS como ALMACEN [Pedido Extornado] las ORDENES DE TRABAJO con estado: - ALMACEN [Pedido Enviado] - TALLER [Pedido Recibido] - ALMACEN [Pedido Extornado]");
	define("ERR_FIN_909","Solo pueden ser ACTUALIZADAS como TALLER [Trabajo Terminado] las ORDENES DE TRABAJO con estado: - TALLER [Preparando Pedido] - ALMACEN [Pedido Enviado] - TALLER [Pedido Recibido]");
	
	define("ERR_FIN_9090","Solo pueden ser ACTUALIZADAS como TALLER [Trabajo Terminado] las ORDENES DE TRABAJO que no tengan productos a solicitar");
	
	
	define("ERR_FIN_910","Solo pueden ser ACTUALIZADAS como RECEPCION [Revisando] las ORDENES DE TRABAJO con estado: - TALLER [Trabajo Terminado] - RECEPCION [Conforme/Por Facturar]");
	define("ERR_FIN_911","Solo pueden ser ACTUALIZADAS como RECEPCION [Conforme/Por Facturar] las ORDENES DE TRABAJO con estado: - RECEPCION [Revisando] - CONTABILIDAD [Facturado]");
	define("ERR_FIN_912","Solo pueden ser ACTUALIZADAS como CONTABILIDAD [Facturado] las ORDENES DE TRABAJO con estado: - RECEPCION [Conforme/Por Facturar]");
	
	define("ERR_FIN_913","Solo pueden ser ACTUALIZADAS como RECEPCION [Pendiente] las ORDENES DE TRABAJO con estado: - RECEPCION [Enviado]");

?>