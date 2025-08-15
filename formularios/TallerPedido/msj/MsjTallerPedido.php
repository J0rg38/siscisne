<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_TPE_101", "Se registro correctamente el pedido de taller");	
	define("SAS_TPE_102", "Se edito correctamente el pedido de taller");	

	define("SAS_TPE_104", "Se enviarON las O.T. a Facturacion correctamente.");
	define("SAS_TPE_105", "Se eliminaron correctamente los pedidos de taller");
	define("SAS_TPE_106", "Se enviaron correctamente los pedidos de taller");
	
	define("SAS_TPE_107", "Se rechazaron los pedidos de taller correctamente");
	define("SAS_TPE_108", "Se anularon las recepciones de los pedidos de taller correctamente");

	define("SAS_TPE_109", "Se marcaron como trabajo terminado las O.T. correctamente");
	define("SAS_TPE_110", "Se desmarcaron como trabajo terminado las O.T. correctamente");	

	define("SAS_TPE_111", "Se desmarcaron como trabajo concluido las O.T. correctamente");	
	define("SAS_TPE_112", "Se marcaron como cerrada la O.T. correctamente");	
	define("SAS_TPE_113", "Se marcaron como abierto la O.T. correctamente");	
	
	define("SAS_TPE_200", "Se generaron las garantias de las O.T. correctamente");


/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_TPE_101", "No se pudo registrar el pedido de taller");	
	define("ERR_TPE_102", "No se pudo editar el pedido de taller");		
	define("ERR_TPE_104", "No se pudieron enviar las O.T. a Facturacion.");
	define("ERR_TPE_105", "No se pudieron eliminar los pedidos de taller");

	define("ERR_TPE_106", "No se pudieron enviar los pedidos de taller");
	define("ERR_TPE_107", "No se pudieron rechazar los pedidos de taller");
	define("ERR_TPE_108", "No se pudieron anular las recepciones de los pedidos de taller");
	
	define("ERR_TPE_109", "No se pudieron marcar como terminado las O.T.");
	define("ERR_TPE_110", "No se pudieron desmarcar como trabajo terminado las O.T.");
	
	define("ERR_TPE_111", "No se pudieron desmarcar trabajo concluido las O.T.");
	define("ERR_TPE_112", "No se pudieron marcar como cerrada las O.T.");
	define("ERR_TPE_113", "No se pudieron marcar como abierto las O.T.");
	
	
	define("ERR_TPE_200", "No se pudieron generar las garantias de las O.T.");
	
	//detalle DE PEDIDO DE TALLER
	define("ERR_TPE_201", "No se pudo registrar el producto");
	define("ERR_TPE_202", "No se pudo editar el producto");
	define("ERR_TPE_203", "No se pudo eliminar el producto");
	
	define("ERR_TPE_204", "no se encontro unidad de medida");
	define("ERR_TPE_205", "no se encontro equivalencia");
	define("ERR_TPE_206", "no se identifico el producto");
	define("ERR_TPE_207", "no se ingreso una cantidad");
	define("ERR_TPE_208", "no tiene stock");
	define("ERR_TPE_209", "no ha escogido un Almacen");
	define("ERR_TPE_210", "no ha ingresado una fecha valida");
	
	//FICHA ACCION producto
//	define("ERR_TPE_211", "No se pudo registrar uno de los items del SUBDETALLE(FAP) del pedido de taller");
//	define("ERR_TPE_212", "No se pudo editar uno de los items del SUBDETALLE(FAP) del pedido de taller");
//	define("ERR_TPE_213", "No se pudo eliminar uno de los items del SUBDETALLE(FAP) del pedido de taller");
//	
//	define("ERR_TPE_214", "No se puede registrar uno de los items del SUBDETALLE(FAP) del pedido de taller, no se encontro unidad de medida");
//	define("ERR_TPE_215", "No se puede registrar uno de los items del SUBDETALLE(FAP) del pedido de taller, no se encontro equivalencia");
//	define("ERR_TPE_216", "No se puede registrar uno de los items del SUBDETALLE(FAP) del pedido de taller, no se identifico el producto");
//	define("ERR_TPE_217", "No se puede registrar uno de los items del SUBDETALLE(FAP) del pedido de taller, no se ingreso una cantidad");

	define("ERR_TPE_301", "No se puede VOLVER A generar el pedido de taller debido a que ya fue generada");
	
	define("ERR_TPE_704", "No se puede editar la ORDEN DE TRABAJO, solo se puede editar las ODENES DE TRABAJO en estado: - ALMACEN [Revisado Pedido] - ALMACEN [Preparando Pedido]");

	define("ERR_TPE_705", "No se puede EXTORNAR la ORDEN DE TRABAJO, solo se puede EXTORNAR las ODENES DE TRABAJO en estado: - ALMACEN [Pedido Enviado] - TALLER [Pedido Recibido] - ALMACEN [Pedido Extornado]");
?>