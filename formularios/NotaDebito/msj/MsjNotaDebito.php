<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	
	define("SAS_NDB_101", "Se registro correctamente la nota de debito");	
	define("SAS_NDB_102", "Se edito correctamente la nota de debito");	

	define("SAS_NDB_105", "Se eliminaron correctamente las notas de debito.");	

	define("SAS_NDB_107", "Se actualizaron a estado pendiente correctamente las notas de debito.");
	define("SAS_NDB_108", "Se actualizaron a estado entregado correctamente las notas de debito.");
	define("SAS_NDB_109", "Se actualizaron a estado anulado correctamente las notas de debito.");
	
	define("SAS_NDB_601", "Se edito correctamente el Id de la nota de debito");


/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_NDB_101", "No se pudo registrar la nota de debito");	
	define("ERR_NDB_102", "No se pudo editar la nota de debito");		

	define("ERR_NDB_105", "No se pudieron eliminar las notas de debito.");			
	
	define("ERR_NDB_107", "No se pudieron actualizar a estado pendiente las notas de debito.");
	define("ERR_NDB_108", "No se pudieron actualizar a estado entregado las notas de debito.");
	define("ERR_NDB_109", "No se pudieron actualizar a estado anulado las snotas de debito.");
	


	define("ERR_NDB_201", "No se pudo registrar uno de los items del DETALLE de la nota de debito");
	define("ERR_NDB_202", "No se pudo editar uno de los items del DETALLE de la nota de debito");
	define("ERR_NDB_203", "No se pudo eliminar uno de los items del DETALLE de la nota de debito");

	define("ERR_NDB_400", "No se puede registrar con una fecha posterior a la actual.");	
	define("ERR_NDB_401", "No se puede editar la nota de credito debido a que ya se cerro caja.");					
	define("ERR_NDB_402", "El CODIGO de la nota de credito ya EXISTE.");	

	define("ERR_NDB_601", "No se pudo editar el Id de la nota de debito");	
?>