<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsVehiculoListaPrecio->VlpId = $_POST['CmpId'];
	$InsVehiculoListaPrecio->VlpCodigo = $_POST['CmpCodigo'];
	
	$InsVehiculoListaPrecio->VmaId = $_POST['CmpVehiculoMarca'];
	
	$InsVehiculoListaPrecio->VlpFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsVehiculoListaPrecio->VlpFechaVigencia = FncCambiaFechaAMysql($_POST['CmpFechaVigencia'],true);
	
	list($InsVehiculoListaPrecio->VlpAno,$InsVehiculoListaPrecio->VlpMes,$Dia) = explode("-",$InsVehiculoListaPrecio->VlpFecha);

	$InsVehiculoListaPrecio->VlpAnoFabricacion = $_POST['CmpAnoFabricacion'];

	$InsVehiculoListaPrecio->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoListaPrecio->VlpTipoCambio = $_POST['CmpTipoCambio'];	
	
	$InsVehiculoListaPrecio->VlpObservacion = addslashes($_POST['CmpObservacion']);	
	$InsVehiculoListaPrecio->VlpEstado = $_POST['CmpEstado'];	
	$InsVehiculoListaPrecio->VlpTiempoModificacion = date("Y-m-d H:i:s");

	if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId){
		if(empty($InsVehiculoListaPrecio->VlpTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_VLP_600';
		}
	}
	
	
/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VldId
Parametro2 = 
Parametro3 = VldFuente
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId
Parametro7 = VldTiempoCreacion
Parametro8 = VldTiempoModificacion
Parametro9 = VldCosto
Parametro10 = VldPrecioCierre
Parametro11 = VldPrecioLista
Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = VldTexto

Parametro16 = VldBonoGM
Parametro17 = VldBonoDealer
Parametro18 = VldDescuentoGerencia

*/	
	$ResVehiculoListaPrecioDetalle = $_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVehiculoListaPrecioDetalle['Datos'])){
		$item = 1;
		foreach($ResVehiculoListaPrecioDetalle['Datos'] as $DatSesionObjeto){
				
			$InsVehiculoListaPrecioDetalle1 = new ClsVehiculoListaPrecioDetalle();
			$InsVehiculoListaPrecioDetalle1->VldId = $DatSesionObjeto->Parametro1;
			$InsVehiculoListaPrecioDetalle1->VldFuente = $DatSesionObjeto->Parametro3;
			
			$InsVehiculoListaPrecioDetalle1->VmaId = $DatSesionObjeto->Parametro4;		
			$InsVehiculoListaPrecioDetalle1->VmoId =  $DatSesionObjeto->Parametro5;
			$InsVehiculoListaPrecioDetalle1->VveId =  $DatSesionObjeto->Parametro6;

			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$InsVehiculoListaPrecioDetalle1->VldCosto = $DatSesionObjeto->Parametro9 * $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$InsVehiculoListaPrecioDetalle1->VldCosto = $DatSesionObjeto->Parametro9;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$InsVehiculoListaPrecioDetalle1->VldPrecioCierre = $DatSesionObjeto->Parametro10 * $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$InsVehiculoListaPrecioDetalle1->VldPrecioCierre = $DatSesionObjeto->Parametro10;
			}

			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$InsVehiculoListaPrecioDetalle1->VldPrecioLista = $DatSesionObjeto->Parametro11 * $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$InsVehiculoListaPrecioDetalle1->VldPrecioLista = $DatSesionObjeto->Parametro11;
			}
			
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$InsVehiculoListaPrecioDetalle1->VldBonoGM = $DatSesionObjeto->Parametro16 * $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$InsVehiculoListaPrecioDetalle1->VldBonoGM = $DatSesionObjeto->Parametro16;
			}

			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$InsVehiculoListaPrecioDetalle1->VldBonoDealer = $DatSesionObjeto->Parametro17 * $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$InsVehiculoListaPrecioDetalle1->VldBonoDealer = $DatSesionObjeto->Parametro17;
			}

			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$InsVehiculoListaPrecioDetalle1->VldDescuentoGerencia = $DatSesionObjeto->Parametro18 * $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$InsVehiculoListaPrecioDetalle1->VldDescuentoGerencia = $DatSesionObjeto->Parametro18;
			}
			
			
			$InsVehiculoListaPrecioDetalle1->VldEstado = 1;

			$InsVehiculoListaPrecioDetalle1->VldTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoListaPrecioDetalle1->VldTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsVehiculoListaPrecioDetalle1->VldEliminado = $DatSesionObjeto->Eliminado;				
			$InsVehiculoListaPrecioDetalle1->InsMysql = NULL;

			$InsVehiculoListaPrecio->VehiculoListaPrecioDetalle[] = $InsVehiculoListaPrecioDetalle1;		
			
			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_VLP_111';
	}

	if($Guardar){

		if($InsVehiculoListaPrecio->MtdEditarVehiculoListaPrecio()){					
			$Edito = true;
			$Resultado.='#SAS_VLP_102';	
			FncCargarDatos();		
		}else{			
			$InsVehiculoListaPrecio->VlpFecha = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFecha);
			$InsVehiculoListaPrecio->VlpFechaVigencia = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFechaVigencia,true);
			$Resultado.='#ERR_VLP_102';		
		}	

	}else{
	
		$InsVehiculoListaPrecio->VlpFecha = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFecha);
		$InsVehiculoListaPrecio->VlpFechaVigencia = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFechaVigencia,true);		
	}
	
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoListaPrecio;
	global $Identificador;

	$InsVehiculoListaPrecio->VlpId = $GET_id;
	$InsVehiculoListaPrecio->MtdObtenerVehiculoListaPrecio();		

	unset($_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]);

	$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador] = new ClsSesionObjeto();
	

	if(!empty($InsVehiculoListaPrecio->VehiculoListaPrecioDetalle)){
		foreach($InsVehiculoListaPrecio->VehiculoListaPrecioDetalle as $DatVehiculoListaPrecioDetalle){

				
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId){
				$DatVehiculoListaPrecioDetalle->VldCosto = $DatVehiculoListaPrecioDetalle->VldCosto / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldCosto = $DatVehiculoListaPrecioDetalle->VldCosto;
			}

			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldPrecioCierre = $DatVehiculoListaPrecioDetalle->VldPrecioCierre / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldPrecioCierre = $DatVehiculoListaPrecioDetalle->VldPrecioCierre;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldPrecioLista = $DatVehiculoListaPrecioDetalle->VldPrecioLista / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldPrecioLista = $DatVehiculoListaPrecioDetalle->VldPrecioLista;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldBonoGM = $DatVehiculoListaPrecioDetalle->VldBonoGM / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldBonoGM = $DatVehiculoListaPrecioDetalle->VldBonoGM;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldBonoDealer = $DatVehiculoListaPrecioDetalle->VldBonoDealer / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldBonoDealer = $DatVehiculoListaPrecioDetalle->VldBonoDealer;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldDescuentoGerencia = $DatVehiculoListaPrecioDetalle->VldDescuentoGerencia / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldDescuentoGerencia = $DatVehiculoListaPrecioDetalle->VldDescuentoGerencia;
			}
			
/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VldId
Parametro2 = 
Parametro3 = VldFuente
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId
Parametro7 = VldTiempoCreacion
Parametro8 = VldTiempoModificacion
Parametro9 = VldCosto
Parametro10 = VldPrecioCierre
Parametro11 = VldPrecioLista
Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = VldTexto

Parametro16 = VldBonoGM
Parametro17 = VldBonoDealer
Parametro18 = VldDescuentoGerencia

*/
			$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVehiculoListaPrecioDetalle->VldId,
			NULL,
			$DatVehiculoListaPrecioDetalle->VldFuente,
			$DatVehiculoListaPrecioDetalle->VmaId,
			$DatVehiculoListaPrecioDetalle->VmoId,
			$DatVehiculoListaPrecioDetalle->VveId,
			($DatVehiculoListaPrecioDetalle->VldTiempoCreacion),
			($DatVehiculoListaPrecioDetalle->VldTiempoModificacion),
			$DatVehiculoListaPrecioDetalle->VldCosto,
			$DatVehiculoListaPrecioDetalle->VldPrecioCierre,
			$DatVehiculoListaPrecioDetalle->VldPrecioLista,
			$DatVehiculoListaPrecioDetalle->VmaNombre,
			$DatVehiculoListaPrecioDetalle->VmoNombre,
			$DatVehiculoListaPrecioDetalle->VveNombre,
			$DatVehiculoListaPrecioDetalle->VldTexto,
			
			$DatVehiculoListaPrecioDetalle->VldBonoGM,
			$DatVehiculoListaPrecioDetalle->VldBonoDealer,
			$DatVehiculoListaPrecioDetalle->VldDescuentoGerencia
			
			);
		
		}
	}
	
	
}

?>