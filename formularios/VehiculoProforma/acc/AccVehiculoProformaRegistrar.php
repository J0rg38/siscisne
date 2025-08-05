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
	
	//list($InsVehiculoProforma->VprAno,$InsVehiculoProforma->VprMes,$Dia) = explode("-",$InsVehiculoProforma->VprFecha);

	$InsVehiculoProforma->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoProforma->VprTipoCambio = $_POST['CmpTipoCambio'];	
	
	$InsVehiculoProforma->VprObservacion = addslashes($_POST['CmpObservacion']);	
	$InsVehiculoProforma->VprAdicional = $_POST['CmpAdicional'];	
	
	$InsVehiculoProforma->VprEstado = $_POST['CmpEstado'];	
	$InsVehiculoProforma->VprTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoProforma->VprTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoProforma->VprEliminado = 1;
	
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

	$ResVehiculoProformaDetalle = $_SESSION['InsVehiculoProformaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

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

		if($InsVehiculoProforma->MtdRegistrarVehiculoProforma()){

			$Registro = true;
			FncNuevo();
			$Resultado.='#SAS_VPR_101';

		}else{

			$InsVehiculoProforma->VprFecha = FncCambiaFechaANormal($InsVehiculoProforma->VprFecha);
			$Resultado.='#ERR_VPR_101';

		}	

	}else{
		
		$InsVehiculoProforma->VprFecha = FncCambiaFechaANormal($InsVehiculoProforma->VprFecha);
		
	}

}else{
	
	FncNuevo();
	
}


function FncNuevo(){
	
	global $InsVehiculoProforma;
	
	$InsVehiculoProforma->MonId = "MON-10001";

	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");

	$InsTipoCambio->MtdObtenerTipoCambioActual();

	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}

	$InsVehiculoProforma->VprTipoCambio = $InsTipoCambio->TcaMontoCompra;
	$InsVehiculoProforma->VmaId = "VMA-10017";
	$InsVehiculoProforma->VprAdicional = 2;
	
	$InsVehiculoProforma->VprFecha = date("d/m/Y");
	$InsVehiculoProforma->VprFechaVigencia = date("d/m/Y");
	$InsVehiculoProforma->VprAno = date("Y");
	$InsVehiculoProforma->VprMes = date("m");
	
}
?>