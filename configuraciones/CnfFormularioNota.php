<?php
$SucursalId = (empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal']);
/*
SUC-10000	AREQUIPA - PARQUE INDUSTRIAL
SUC-10001	AREQUIPA - PARRA
SUC-10002	AREQUIPA - EJERCITO
SUC-10003	AREQUIPA - MALL PORONGOCHE
SUC-10004	MADRE DE DIOS - PUERTO MALDONADO
SUC-10005	PUNO - JULIACA
SUC-10006	AREQUIPA - UMACOLLO
SUC-10007	AREQUIPA - LOPEZ ROMAÑA
SUC-10008	TACNA - TACNA
SUC-10009	CUSCO - CUSCO
SUC-10010	AREQUIPA - AVIACION
SUC-10011	AREQUIPA - ALM. QUIÑONEZ
SUC-9999	LIMA
*/

$FormularioNotaURLCitas = "https://cisne.com.pe/solicitud-de-servicio-tecnico/";
$FormularioNotaCorreoRespuestaBienvenida = "c.callcenter@cisne.com.pe";
$FormularioNotaCorreoNombreRespuestaBienvenida = "CISNE";

switch($SucursalId){
	
	case "SUC-10000"://SUC-10000	AREQUIPA - PARQUE INDUSTRIAL

		/*
		* ALMACEN
		*/
		
		$FormularioNotaFichaIngresoCita = "Para una mejor atencion comuniquese con nosotros para separar su cita al 054 232741";
		
		
	break;
	
	case "SUC-10001"://SUC-10001	AREQUIPA - PARRA
		
		/*
		* ALMACEN
		*/
		
		$FormularioNotaFichaIngresoCita = "Para una mejor atencion comuniquese con nosotros para separar su cita al 054 232741";
		
		

	break;
	
	case "SUC-10004"://MADRE DE DIOS - PUERTO MALDONADO
		
		/*
		* ALMACEN
		*/
		
		$FormularioNotaFichaIngresoCita = "Para una mejor atencion comuniquese con nosotros para separar su cita al 054 232741";
		
		
		
		

	break;
	
	case "SUC-10005"://SUC-10005	PUNO - JULIACA
		
		/*
		* ALMACEN
		*/
		
		$FormularioNotaFichaIngresoCita = "Para una mejor atencion comuniquese con nosotros para separar su cita al 054 232741";
		
		
		
		
		
		

	break;
	
	case "SUC-10008"://SUC-10008	TACNA - TACNA
		
		/*
		* ALMACEN
		*/
		
	$FormularioNotaFichaIngresoCita = "Para una mejor atencion comuniquese con nosotros para separar su cita al 993292350";
		

	break;
	
	case "SUC-10009"://SUC-10009	CUSCO - CUSCO
		
		/*
		* ALMACEN
		*/
		
		$FormularioNotaFichaIngresoCita = "Para una mejor atencion comuniquese con nosotros para separar su cita al 054 232741";
		
	
		
	break;
	
	case "SUC-10010"://SUC-10010	AREQUIPA - AVIACION
		
		
		/*
		* ALMACEN
		*/
		
		$FormularioNotaFichaIngresoCita = "Para una mejor atencion comuniquese con nosotros para separar su cita al 054 232741";
		
	

	break;
	
	default://
	
	break;

}


?>
