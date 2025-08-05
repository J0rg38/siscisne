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
	$InsVehiculoListaPrecio->VlpTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoListaPrecio->VlpTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoListaPrecio->VlpEliminado = 1;


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

	$ResVehiculoListaPrecioDetalle = $_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

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

		if($InsVehiculoListaPrecio->MtdRegistrarVehiculoListaPrecio()){
			
			$Registro = true;
			FncNuevo();
			$Resultado.='#SAS_VLP_101';
			
		} else{
			
			$InsVehiculoListaPrecio->VlpFecha = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFecha);
			$InsVehiculoListaPrecio->VlpFechaVigencia = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFechaVigencia,true);
			$Resultado.='#ERR_VLP_101';
			
		}		
	}else{
		
		$InsVehiculoListaPrecio->VlpFecha = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFecha);
		$InsVehiculoListaPrecio->VlpFechaVigencia = FncCambiaFechaANormal($InsVehiculoListaPrecio->VlpFechaVigencia,true);
	}
	


}else{
	
	FncNuevo();
	
}


function FncNuevo(){
	
	global $Identificador;
	global $InsVehiculoListaPrecio;
	global $InsVehiculoMarca;
	global $InsVehiculoModelo;
	global $InsVehiculoVersion;
	
	unset($_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]);

	$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador] = new ClsSesionObjeto();
	
	
	$InsVehiculoListaPrecio->MonId = "MON-10001";

	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");

	$InsTipoCambio->MtdObtenerTipoCambioActual();

	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}

	$InsVehiculoListaPrecio->VlpTipoCambio = $InsTipoCambio->TcaMontoCompra;
	//$InsVehiculoListaPrecio->VmaId = "VMA-10017";
	
	$InsVehiculoListaPrecio->VlpFecha = date("d/m/Y");
	$InsVehiculoListaPrecio->VlpFechaVigencia = date("d/m/Y");
	
	
	$InsVehiculoMarca = new ClsVehiculoMarca();
	$ResVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,'VmaId','Desc',NULL,1,NULL);
	$ArrVehiculoMarcas = $ResVehiculoMarca['Datos'];
	
	if(!empty($ArrVehiculoMarcas)){
		foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			
			$InsVehiculoModelo = new ClsVehiculoModelo();
			$ResVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoId','Desc',NULL,$DatVehiculoMarca->VmaId,1,NULL);
			$ArrVehiculoModelos = $ResVehiculoModelo['Datos'];
			
			if(!empty($ArrVehiculoModelos)){
				foreach($ArrVehiculoModelos as $DatVehiculoModelo){
					
	
					$InsVehiculoVersion = new ClsVehiculoVersion();
					$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveId','Desc',NULL,NULL,$DatVehiculoModelo->VmoId,1,NULL);
					$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];
	
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
							
							$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							NULL,
							"",
							$DatVehiculoVersion->VmaId,
							$DatVehiculoVersion->VmoId,
							$DatVehiculoVersion->VveId,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							0,
							0,
							0,
							$DatVehiculoVersion->VmaNombre,
							$DatVehiculoVersion->VmoNombre,
							$DatVehiculoVersion->VveNombre,
							NULL,
							
							0,
							0,
							0
							
							);
			
			
						}
					}
					
				}
			}

			
		}	
	}
	
	
			
			
			
}
?>