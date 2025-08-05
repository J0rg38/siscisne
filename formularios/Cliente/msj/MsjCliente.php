<?php
/*
* Mensajes de satisfaccion
*/
	
	/*
	* Mantenimiento de datos.
	*/
	define("SAS_CLI_101", "Se registro correctamente el cliente.");	
	define("SAS_CLI_102", "Se edito correctamente el cliente.");	
	define("SAS_CLI_105", "Se eliminaron correctamente los clientes.");	
	
	define("SAS_CLI_106", "Se bloquearon correctamente los clientes.");				
	define("SAS_CLI_107", "Se desbloquearon correctamente los clientes.");		

	define("SAS_CLI_109", "Se actualizo a activo correctamente los clientes.");	
	define("SAS_CLI_110", "Se actualizo a inactivo correctamente los clientes.");	
	
/*
* Mensajes de error
*/	
	/*
	* Mantenimiento de datos.
	*/	
	
	define("ERR_CLI_101", "No se pudo registrar el cliente.");	
	define("ERR_CLI_102", "No se pudo editar el cliente.");		
	define("ERR_CLI_105", "No se pudieron eliminar los clientes.");
	
	define("ERR_CLI_106", "No se pudieron bloquear los clientes.");
	define("ERR_CLI_107", "No se pudieron desbloquear los clientes.");

	define("ERR_CLI_109", "No se pudieron actualizar a activo los clientes.");	
	define("ERR_CLI_110", "No se pudieron actualizar a inactivo los clientes.");	
	
	define("ERR_CLI_201", "No se pudo registrar al cliente, ya que el Nombre y Num. de Documento ya EXISTEN.");
	define("ERR_CLI_202", "No se pudo editar al cliente, ya que el Nombre y Num. de Documento ya EXISTEN.");

//	define("ERR_CLI_106", "No se pudieron cambiar a estado ACTIVADO a las clientes.");				
//	define("ERR_CLI_107", "No se pudieron cambiar a estado DESACTIVADO a las clientes.");	
	define("ERR_CLI_600", "No se ha encontrado el tipo de cambio.");
	
	define("ERR_CLI_601", "El numero de documento debe tener 8 digitos.");
	define("ERR_CLI_602", "El numero de documento debe tener 11 digitos.");
	define("ERR_CLI_603", "El cliente ya se encuentra registrado con este numero de documento.");
?>