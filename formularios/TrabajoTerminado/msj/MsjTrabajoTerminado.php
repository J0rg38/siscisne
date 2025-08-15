<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_TTE_101", "Se registro correctamente la O.T.");	
	define("SAS_TTE_102", "Se edito correctamente las O.T.");	
	define("SAS_TTE_105", "Se eliminaron correctamente las O.T.");

	define("SAS_TTE_106", "Se enviarON las O.T. a Facturacion correctamente.");
	define("SAS_TTE_107", "Se cancelarON los envios de las O.T. a Facturacion correctamente.");
	
	define("SAS_TTE_108", "Se enviarON las O.T. a Taller correctamente.");
	define("SAS_TTE_109", "Se enviarON las O.T. a Almacen correctamente.");
	
	define("SAS_TTE_110", "Se actualizarON las O.T. como No Facturables correctamente.");
	define("SAS_TTE_111", "Se actualizarON las O.T. como Facturables de las O.T. correctamente");
	
	define("SAS_TTE_112", "Se marcaron como cerrada la O.T. correctamente");	
	define("SAS_TTE_113", "Se marcaron como abierto la O.T. correctamente");	
	
	define("SAS_TTE_200", "Se generaron las garantias de las O.T. correctamente.");
	define("SAS_TTE_201", "Se generaron los Formularios de Reclamo - ISUZU de las O.T. correctamente.");

/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_TTE_101", "No se pudo registrar la O.T.");	
	define("ERR_TTE_102", "No se pudo editar la O.T.");		
	define("ERR_TTE_105", "No se pudieron eliminar las O.T.");

	define("ERR_TTE_106", "No se pudieron enviar las O.T. a Facturacion.");
	define("ERR_TTE_107", "No se pudieron cancelar los envios de las O.T. a Facturacion.");
	
	define("ERR_TTE_108", "No se pudieron enviar las  O.T. a Taller.");	
	define("ERR_TTE_109", "No se pudieron enviar las O.T. a Almacen.");
	
	define("ERR_TTE_110", "No se pudieron actualizar las O.T. como No Facturables.");
	define("ERR_TTE_111", "No se pudieron actualizar las O.T. como Facturables.");
	
	define("ERR_TTE_112", "No se pudieron marcar como cerrada las O.T.");
	define("ERR_TTE_113", "No se pudieron marcar como abierto las O.T.");
	
	define("ERR_TTE_200", "No se pudieron generar las garantias de las O.T.");
	define("ERR_TTE_201", "No se pudieron generar los Formularios de Reclamo - ISUZU de las O.T.");


	define("ERR_TTE_301", "No se puede recepcionar la O.T. debido a que ya fue recepcionada.");
	
	define("ERR_TTE_706", "No se puede editar la O.T., solo se puede EDITAR las O.T. en estado: - Taller [Trabajo Terminado] - RECEPCION [Revisando]");
	
	define("ERR_TTE_707", "No se puede adicionar la O.T., solo se puede adicionar las O.T. en estado: - RECEPCION [Conforme/Por Facturar] - CONTABILIDAD [Facturado]");
	
?>