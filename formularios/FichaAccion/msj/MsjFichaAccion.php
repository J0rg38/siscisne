<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	

	
	define("SAS_FCC_101", "Se registro correctamente O.T..");	
	define("SAS_FCC_102", "Se edito correctamente la O.T..");	
	define("SAS_FCC_105", "Se eliminaron correctamente las O.T.");
	
	define("SAS_FCC_106", "Se enviaron las O.T.s a almacen correctamente.");
	define("SAS_FCC_107", "Se regresaron las O.T.s a taller correctamente.");
	
	
	define("SAS_FCC_108", "Se marcaron como trabajo terminado las O.T.s correctamente.");
	define("SAS_FCC_109", "Se regresaron las O.T.s a recepcion correctamente.");
	define("SAS_FCC_110", "Se desmarcaron como trabajo terminado las O.T.s correctamente.");	
	
	define("SAS_FCC_111", "Se anularon las recepciones de las O.T.s correctamente.");

	define("SAS_FCC_112", "Se marcaron como trabajo concluido las O.T.s correctamente.");	
	define("SAS_FCC_113", "Se desmarcaron como trabajo concluido las O.T.s correctamente.");	





	define("SAS_FCC_114", "Se enviaron las O.T.s a taller externo correctamente.");
	define("SAS_FCC_115", "Se cancelaron los envios de las O.T.s a taller externo correctamente.");
	
	define("SAS_FCC_116", "Se retornaron las O.T.s de taller externo correctamente.");


/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_FCC_101", "No se pudo registrar O.T..");	
	define("ERR_FCC_102", "No se pudo editar la O.T..");		
	define("ERR_FCC_105", "No se pudieron eliminar las SUB O.T.");
	
	define("ERR_FCC_106", "No se pudieron enviaron las O.T.s a almacen.");
	define("ERR_FCC_107", "No se pudieron regresar las O.T.s a taller.");
	
	define("ERR_FCC_108", "No se pudieron marcar como terminado las O.T.");
	define("ERR_FCC_109", "No se pudieron regresar a recepcion los O.T.");	
	define("ERR_FCC_110", "No se pudieron desmarcar como terminado las O.T.");
	
	define("ERR_FCC_111", "No se pudieron anular las recepciones de las O.T.");
	
	define("ERR_FCC_112", "No se pudieron marcar como trabajo concluido las O.T.");
	define("ERR_FCC_113", "No se pudieron desmarcar como trabajo concluido las O.T.");
	
	define("ERR_FCC_114", "No se pudieron enviar las O.T.s a taller externo.");
	define("ERR_FCC_115", "No se pudieron cancelar los envios de las O.T.s a taller externo.");
	
	define("ERR_FCC_116", "No se pudieron retornar las O.T.s de taller externo.");
	
	/*
	201 tareas
	281 mantenimiento
	211 productos
	221 FOTOS
	231 suministros
	241 proveedores SALDIAS EXTERNAS
	251  FOTOS
	271 TEMPARIO
	*/
	
	//tareas
	define("ERR_FCC_201", "No se pudo registrar una de las tareas de la  modalidad de O.T..");
	define("ERR_FCC_202", "No se pudo editar una de las tareas de la  modalidad de O.T..");
	define("ERR_FCC_203", "No se pudo eliminar una de las tareas de la modalidad de O.T..");	

	//mantenimiento
	define("ERR_FCC_281", "No se pudo registrar uno de los items del plan de mantenimiento de la  modalidad de O.T..");
	define("ERR_FCC_282", "No se pudo editar uno de los items del plan de mantenimiento de la  modalidad de O.T..");
	define("ERR_FCC_283", "No se pudo eliminar uno de los items del plan de mantenimiento de la modalidad de O.T..");	

	//productos
	define("ERR_FCC_211", "No se pudo registrar uno de los productos de la  modalidad de O.T..");
	define("ERR_FCC_212", "No se pudo editar uno de los productos de la  modalidad de O.T..");
	define("ERR_FCC_213", "No se pudo eliminar uno de los productos de la modalidad de O.T..");	
	
	define("ERR_FCC_214", "No se puede registrar uno de los productos, no se encontro UNIDAD de MEDIDA.");
	define("ERR_FCC_215", "No se puede registrar uno de los productos, no se encontro EQUIVALENCIA.");
	define("ERR_FCC_216", "No se puede registrar uno de los productos, no se identifico el PRODUCTO.");
	define("ERR_FCC_217", "No se puede registrar uno de los productos, no se ingreso una CANTIDAD.");
		
	//FOTOS
	define("ERR_FCC_221", "No se pudo registrar una de las FOTOS de la  modalidad de O.T..");
	define("ERR_FCC_222", "No se pudo editar una de las FOTOS de la  modalidad de O.T..");
	define("ERR_FCC_223", "No se pudo eliminar una de las FOTOS de la modalidad de O.T..");	
		
	//suministros
	define("ERR_FCC_231", "No se pudo registrar uno de los suministros de la  modalidad de O.T..");
	define("ERR_FCC_232", "No se pudo editar uno de los suministros de la  modalidad de O.T..");
	define("ERR_FCC_233", "No se pudo eliminar uno de los suministros de la modalidad de O.T..");	
	
	define("ERR_FCC_234", "No se puede registrar uno de los suministros, no se encontro UNIDAD de MEDIDA.");
	define("ERR_FCC_235", "No se puede registrar uno de los suministros, no se encontro EQUIVALENCIA.");	
	define("ERR_FCC_236", "No se puede registrar uno de los suministros, no se identifico el PRODUCTO.");
	define("ERR_FCC_237", "No se puede registrar uno de los suministros, no se ingreso una CANTIDAD.");
	
	//SALIDAS EXTERNAS / proveedores
	define("ERR_FCC_241", "No se pudo registrar uno de los proveedores de la  modalidad de O.T..");
	define("ERR_FCC_242", "No se pudo editar uno de los proveedores de la  modalidad de O.T..");
	define("ERR_FCC_243", "No se pudo eliminar uno de los proveedores de la modalidad de O.T..");	

	//FOTOS
//	define("ERR_FCC_251", "No se pudo registrar una de las FOTOS de la  modalidad de O.T..");
//	define("ERR_FCC_252", "No se pudo editar una de las FOTOS de la  modalidad de O.T..");
//	define("ERR_FCC_253", "No se pudo eliminar una de las FOTOS de la modalidad de O.T..");	
	
	//temparios	
	define("ERR_FCC_271", "No se pudo registrar uno de las temparios de la  modalidad de O.T..");
	define("ERR_FCC_272", "No se pudo editar uno de las temparios de la  modalidad de O.T..");
	define("ERR_FCC_273", "No se pudo eliminar uno de las temparios de la modalidad de O.T..");	
	
	define("ERR_FCC_301", "No se puede VOLVER A GENERAR la modalidad de O.T. debido a que ya fue generada.");
	define("ERR_FCC_703", "No se puede editar la O.T., solo se puede editar las OdeNES de trabajo en estado: - taller [Revisando] - taller [Preparando Pedido] - almacen [Pedido Enviado] - taller [Pedido Recibido]");
	


?>