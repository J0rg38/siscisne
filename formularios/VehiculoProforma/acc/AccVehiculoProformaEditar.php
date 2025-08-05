<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsVehiculoProforma->VprId = $_POST['CmpId'];
	$InsVehiculoProforma->VprCodigo = $_POST['CmpCodigo'];
	
	$InsVehiculoProforma->VprAno = $_POST['CmpAnoProforma'];
	$InsVehiculoProforma->VprMes = $_POST['CmpMesProforma'];
	
	$InsVehiculoProforma->VprFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsVehiculoProforma->VmaId = $_POST['CmpVehiculoMarca'];

	$InsVehiculoProforma->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoProforma->VprTipoCambio = $_POST['CmpTipoCambio'];	
	
	$InsVehiculoProforma->VprObservacion = addslashes($_POST['CmpObservacion']);	
	$InsVehiculoProforma->VprAdicional = $_POST['CmpAdicional'];	
	
	$InsVehiculoProforma->VprEstado = $_POST['CmpEstado'];	
	$InsVehiculoProforma->VprTiempoModificacion = date("Y-m-d H:i:s");

	$InsVehiculoProforma->VprTotal = 0;

	if($InsVehiculoProforma->MonId<>$EmpresaMonedaId){
		if(empty($InsVehiculoProforma->VprTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_VPR_600';
		}
	}
	
	
	
	
	
/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VpdId
Parametro2 = EinId
Parametro3 = 
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId

Parametro7 = VpdTiempoCreacion
Parametro8 = VpdTiempoModificacion

Parametro9 = VpdCosto
Parametro10 = 
Parametro11 = 

Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = EinVIN
Parametro16 = EinColor
Parametro17 = EinAnoFabricacion
Parametro18 = EinAnoModelo
Parametro19 = EinNumeroMotor
*/
	$ResVehiculoProformaDetalle = $_SESSION['InsVehiculoProformaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVehiculoProformaDetalle['Datos'])){
		$item = 1;
		foreach($ResVehiculoProformaDetalle['Datos'] as $DatSesionObjeto){
				
			$InsVehiculoProformaDetalle1 = new ClsVehiculoProformaDetalle();
			$InsVehiculoProformaDetalle1->VpdId = $DatSesionObjeto->Parametro1;
			$InsVehiculoProformaDetalle1->EinId = $DatSesionObjeto->Parametro2;		

			$InsVehiculoProformaDetalle1->EinVIN = $DatSesionObjeto->Parametro15;	
			$InsVehiculoProformaDetalle1->EinColor = $DatSesionObjeto->Parametro16;	
			$InsVehiculoProformaDetalle1->EinAnoFabricacion = $DatSesionObjeto->Parametro17;	
			$InsVehiculoProformaDetalle1->EinAnoModelo = $DatSesionObjeto->Parametro18;	
			$InsVehiculoProformaDetalle1->EinNumeroMotor = $DatSesionObjeto->Parametro19;	
			
			$InsVehiculoProformaDetalle1->VmaId = $DatSesionObjeto->Parametro4;
			$InsVehiculoProformaDetalle1->VmoId = $DatSesionObjeto->Parametro5;
			$InsVehiculoProformaDetalle1->VveId = $DatSesionObjeto->Parametro6;
			
			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId ){
				$InsVehiculoProformaDetalle1->VpdCosto = $DatSesionObjeto->Parametro9 * $InsVehiculoProforma->VprTipoCambio;
			}else{
				$InsVehiculoProformaDetalle1->VpdCosto = $DatSesionObjeto->Parametro9;
			}

			$InsVehiculoProformaDetalle1->VpdEstado = 1;

			$InsVehiculoProformaDetalle1->VpdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoProformaDetalle1->VpdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsVehiculoProformaDetalle1->VpdEliminado = $DatSesionObjeto->Eliminado;				
			$InsVehiculoProformaDetalle1->InsMysql = NULL;

			$InsVehiculoProforma->VehiculoProformaDetalle[] = $InsVehiculoProformaDetalle1;		
			
			if($InsVehiculoProformaDetalle1->VpdEliminado==1){					
				$InsVehiculoProforma->VprTotal += $InsVehiculoProformaDetalle1->VpdCosto;	
			}
			
			
			
			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_VPR_111';
	}

	if($Guardar){

		if($InsVehiculoProforma->MtdEditarVehiculoProforma()){					
			$Edito = true;
			$Resultado.='#SAS_VPR_102';	
			FncCargarDatos();		
		}else{			
			$InsVehiculoProforma->VprFecha = FncCambiaFechaANormal($InsVehiculoProforma->VprFecha);
			$Resultado.='#ERR_VPR_102';		
		}	

	}else{
	
		$InsVehiculoProforma->VprFecha = FncCambiaFechaANormal($InsVehiculoProforma->VprFecha);

	}
	
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoProforma;
	global $Identificador;

	$InsVehiculoProforma->VprId = $GET_id;
	$InsVehiculoProforma->MtdObtenerVehiculoProforma();		

	unset($_SESSION['InsVehiculoProformaDetalle'.$Identificador]);

	$_SESSION['InsVehiculoProformaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	//deb($InsVehiculoProforma->VehiculoProformaDetalle);

	if(!empty($InsVehiculoProforma->VehiculoProformaDetalle)){
		foreach($InsVehiculoProforma->VehiculoProformaDetalle as $DatVehiculoProformaDetalle){

			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId){
				$DatVehiculoProformaDetalle->VpdCosto = $DatVehiculoProformaDetalle->VpdCosto / $InsVehiculoProforma->VprTipoCambio;
			}else{
				$DatVehiculoProformaDetalle->VpdCosto = $DatVehiculoProformaDetalle->VpdCosto;
			}

	
/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VpdId
Parametro2 = EinId
Parametro3 = 
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId

Parametro7 = VpdTiempoCreacion
Parametro8 = VpdTiempoModificacion

Parametro9 = VpdCosto
Parametro10 = 
Parametro11 = 

Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = EinVIN
Parametro16 = EinColor
Parametro17 = EinAnoFabricacion
Parametro18 = EinAnoModelo
Parametro19 = EinNumeroMotor
*/

			$_SESSION['InsVehiculoProformaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVehiculoProformaDetalle->VpdId,
			$DatVehiculoProformaDetalle->EinId,
			NULL,
			$DatVehiculoProformaDetalle->VmaId,
			$DatVehiculoProformaDetalle->VmoId,
			$DatVehiculoProformaDetalle->VveId,
			($DatVehiculoProformaDetalle->VpdTiempoCreacion),
			($DatVehiculoProformaDetalle->VpdTiempoModificacion),
			$DatVehiculoProformaDetalle->VpdCosto,
			NULL,
			NULL,
			$DatVehiculoProformaDetalle->VmaNombre,
			$DatVehiculoProformaDetalle->VmoNombre,
			$DatVehiculoProformaDetalle->VveNombre,
			$DatVehiculoProformaDetalle->EinVIN,
			$DatVehiculoProformaDetalle->EinColor,
			
			$DatVehiculoProformaDetalle->EinAnoFabricacion,
			$DatVehiculoProformaDetalle->EinAnoModelo,
			$DatVehiculoProformaDetalle->EinNumeroMotor			
			);
		
		}
	}
	
	
}

?>