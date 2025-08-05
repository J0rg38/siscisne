<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

//deb($_POST);
	$Resultado = '';

	$InsInformeTecnico->IteId = $_POST['CmpId'];
	$InsInformeTecnico->FinId = $_POST['CmpFichaIngresoId'];
	$InsInformeTecnico->PerId = $_POST['CmpPersonal'];
	$InsInformeTecnico->IteCargo = $_POST['CmpPersonalCargo'];
	
	$InsInformeTecnico->IteConcesionario = $_POST['CmpConcesionario'];
	$InsInformeTecnico->IteSedeLocal = $_POST['CmpSedeLocal'];
	$InsInformeTecnico->IteFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsInformeTecnico->IteFechaVenta = FncCambiaFechaAMysql($_POST['CmpFechaVenta'],true);
	$InsInformeTecnico->IteContactoGM = $_POST['CmpContactoGM'];
	
	$InsInformeTecnico->IteModelo = $_POST['CmpModelo'];	
	
	$InsInformeTecnico->ItePlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsInformeTecnico->ItePropietario = $_POST['CmpPropietario'];
	
	$InsInformeTecnico->IteCondicion = addslashes($_POST['CmpCondicion']);
	$InsInformeTecnico->IteCausa = addslashes($_POST['CmpCausa']);
	$InsInformeTecnico->IteCorreccion = addslashes($_POST['CmpCorreccion']);
	$InsInformeTecnico->IteConclusion = addslashes($_POST['CmpConclusion']);

	$InsInformeTecnico->IteSolucionSatisfactoria = $_POST['CmpSolucionSatisfactoria'];			
	$InsInformeTecnico->IteEstado = 1;	
	$InsInformeTecnico->IteTiempoModificacion = date("Y-m-d H:i:s");
	$InsInformeTecnico->IteEliminado = 1;

	$InsInformeTecnico->EinVIN = $_POST['CmpVehiculoIngresoVIN'];	
	

	$InsInformeTecnico->MonId = $_POST['CmpMonedaId'];
	$InsInformeTecnico->IteTipoCambio = $_POST['CmpTipoCambio'];
	
	$ResInformeTecnicoProducto = $_SESSION['InsInformeTecnicoATS3Producto'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResInformeTecnicoProducto['Datos'])){
		foreach($ResInformeTecnicoProducto['Datos'] as $DatSesionObjeto){

//SesionObjeto-InsInformeTecnicoATS3Producto
//Parametro1 = ItpId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = FapId
//Parametro5 = ProNombre
//Parametro6 = ItpCantidad
//Parametro7 = ItpValorUnitario
//Parametro8 = ItpValorTotal	
//Parametro9 = ItpEstado	
//Parametro10 = ItpTiempoCreacion		
//Parametro11 = ItpTiempoModificacion	
//Parametro11 = UmeNombre	
//Parametro12 = ProCodigoOriginal
//Parametro13 = ProCodigoAlternativo

			$InsInformeTecnicoProducto1 = new ClsInformeTecnicoProducto();
			$InsInformeTecnicoProducto1->ItpId = $DatSesionObjeto->Parametro1;

			$InsInformeTecnicoProducto1->ProId = $DatSesionObjeto->Parametro2;
			$InsInformeTecnicoProducto1->UmeId = $DatSesionObjeto->Parametro3;
			$InsInformeTecnicoProducto1->FapId = $DatSesionObjeto->Parametro4;
			
			$InsInformeTecnicoProducto1->ItpCantidad = $DatSesionObjeto->Parametro6;
			
			if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
				$InsInformeTecnicoProducto1->ItpValorUnitario = $DatSesionObjeto->Parametro7 * $InsInformeTecnico->IteTipoCambio;
			}else{
				$InsInformeTecnicoProducto1->ItpValorUnitario = $DatSesionObjeto->Parametro7;
			}

			if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
				$InsInformeTecnicoProducto1->ItpValorTotal = $DatSesionObjeto->Parametro8 * $InsInformeTecnico->IteTipoCambio;
			}else{
				$InsInformeTecnicoProducto1->ItpValorTotal = $DatSesionObjeto->Parametro8;
			}		
			
			$InsInformeTecnicoProducto1->ItpEstado = $DatSesionObjeto->Parametro9;
			$InsInformeTecnicoProducto1->ItpTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10);
			$InsInformeTecnicoProducto1->ItpTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11);
			$InsInformeTecnicoProducto1->ItpEliminado = $DatSesionObjeto->Eliminado;				
			$InsInformeTecnicoProducto1->InsMysql = NULL;
			
			if($InsInformeTecnicoProducto1->ItpEliminado == 1){	
				$InsInformeTecnico->InformeTecnicoProducto[] = $InsInformeTecnicoProducto1;	
			}

		}

	}



	
	
	$ResInformeTecnicoOperacion = $_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResInformeTecnicoOperacion['Datos'])){
		foreach($ResInformeTecnicoOperacion['Datos'] as $DatSesionObjeto){

	
//SesionObjeto-InsInformeTecnicoATS3Operacion
//Parametro1 = ItoId
//Parametro2 = ItoNumero
//Parametro3 = ItoTiempo
//Parametro4 = ItoCostoHora
//Parametro5 = ItoValorTotal
//Parametro6 = ItoEstado
//Parametro7 = ItoTiempoCreacion
//Parametro8 = ItoTiempoModificacion
//Parametro9 = FaeId

			$InsInformeTecnicoOperacion1 = new ClsInformeTecnicoOperacion();
			$InsInformeTecnicoOperacion1->ItoId = $DatSesionObjeto->Parametro1;
			$InsInformeTecnicoOperacion1->FaeId = $DatSesionObjeto->Parametro9;
			
			$InsInformeTecnicoOperacion1->ItoNumero = $DatSesionObjeto->Parametro2;
			$InsInformeTecnicoOperacion1->ItoTiempo = $DatSesionObjeto->Parametro3;
		
			if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
				$InsInformeTecnicoOperacion1->ItoCostoHora = $DatSesionObjeto->Parametro4 * $InsInformeTecnico->IteTipoCambio;
			}else{
				$InsInformeTecnicoOperacion1->ItoCostoHora = $DatSesionObjeto->Parametro4;
			}
			
			if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
				$InsInformeTecnicoOperacion1->ItoValorTotal = $DatSesionObjeto->Parametro5 * $InsInformeTecnico->IteTipoCambio;
			}else{
				$InsInformeTecnicoOperacion1->ItoValorTotal = $DatSesionObjeto->Parametro5;
			}
		
			$InsInformeTecnicoOperacion1->ItoEstado = $DatSesionObjeto->Parametro6;
			$InsInformeTecnicoOperacion1->ItoTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsInformeTecnicoOperacion1->ItoTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsInformeTecnicoOperacion1->ItoEliminado = $DatSesionObjeto->Eliminado;				
			$InsInformeTecnicoOperacion1->InsMysql = NULL;
			
			$InsInformeTecnico->InformeTecnicoOperacion[] = $InsInformeTecnicoOperacion1;		
			
			if($InsInformeTecnicoOperacion1->ItoEliminado==1){					
				
			}

		}

	}
	
	
	if($InsInformeTecnico->MtdEditarInformeTecnico()){		
		$Resultado.='#SAS_ITE_102';
		$Registro = true;
		FncCargarDatos();
	} else{
		$Resultado.='#ERR_ITE_102';
		$InsInformeTecnico->IteFecha = FncCambiaFechaANormal($InsInformeTecnico->IteFecha);
		$InsInformeTecnico->IteFechaVenta = FncCambiaFechaANormal($InsInformeTecnico->IteFechaVenta,true);
	}		
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsInformeTecnico;
	global $InsFichaIngreso;
	
	unset($_SESSION['InsInformeTecnicoATS3Foto'.$Identificador]);
	
	unset($_SESSION['SesIteFotoVIN'.$Identificador]);
	unset($_SESSION['SesIteFotoFrontal'.$Identificador]);
	unset($_SESSION['SesIteFotoCupon'.$Identificador]);
	unset($_SESSION['SesIteFotoMantenimiento'.$Identificador]);

	$_SESSION['InsInformeTecnicoATS3Foto'.$Identificador] = new ClsSesionObjeto();
	
	$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador] = new ClsSesionObjeto();
			

	$InsInformeTecnico = new ClsInformeTecnico();		
	$InsInformeTecnico->IteId = $GET_id;
	$InsInformeTecnico = $InsInformeTecnico->MtdObtenerInformeTecnico();	
	
	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsInformeTecnico->FinId ;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
	
	$_SESSION['SesIteFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesIteFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesIteFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesIteFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;
	
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

			$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;

				if(!empty($InsFichaAccion->FichaAccionFoto)){
					foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						
						$_SESSION['InsInformeTecnicoATS3Foto'.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionFoto->FafId,
						NULL,
						$DatFichaAccionFoto->FafArchivo,
						$DatFichaAccionFoto->FafEstado,
						($DatFichaAccionFoto->FafTiempoCreacion),
						($DatFichaAccionFoto->FafTiempoModificacion)
						);
	
					}
				}	
				
				
				
		}
	}
	
				//SesionObjeto-InsInformeTecnicoATS3Operacion
				//Parametro1 = ItoId
				//Parametro2 = ItoNumero
				//Parametro3 = ItoTiempo
				//Parametro4 = ItoCostoHora
				//Parametro5 = ItoValorTotal
				//Parametro6 = ItoEstado
				//Parametro7 = ItoTiempoCreacion
				//Parametro8 = ItoTiempoModificacion
				//Parametro9 = FaeId
	
				if(!empty($InsInformeTecnico->InformeTecnicoOperacion)){
					foreach($InsInformeTecnico->InformeTecnicoOperacion as $DatInformeTecnicoOperacion){

						if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
			
							$DatInformeTecnicoOperacion->ItoCostoHora = round($DatInformeTecnicoOperacion->ItoCostoHora / $InsInformeTecnico->IteTipoCambio,2);
							$DatInformeTecnicoOperacion->ItoValorTotal = round($DatInformeTecnicoOperacion->ItoValorTotal / $InsInformeTecnico->IteTipoCambio,2);
			
						}
			
						$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatInformeTecnicoOperacion->ItoId,
						$DatInformeTecnicoOperacion->ItoNumero,
						$DatInformeTecnicoOperacion->ItoTiempo,
						$DatInformeTecnicoOperacion->ItoCostoHora,
						$DatInformeTecnicoOperacion->ItoValorTotal,
						$DatInformeTecnicoOperacion->ItoEstado,

						$DatInformeTecnicoOperacion->ItoTiempoCreacion,
						$DatInformeTecnicoOperacion->ItoTiempoModificacion,
						$DatInformeTecnicoOperacion->FaeId
						);

					}
				}
				


//SesionObjeto-InsInformeTecnicoATS3Producto
//Parametro1 = ItpId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = FapId
//Parametro5 = ProNombre
//Parametro6 = ItpCantidad
//Parametro7 = ItpValorUnitario
//Parametro8 = ItpValorTotal	
//Parametro9 = ItpEstado	
//Parametro10 = ItpTiempoCreacion		
//Parametro11 = ItpTiempoModificacion	
//Parametro12 = UmeNombre	
//Parametro13 = ProCodigoOriginal
//Parametro14 = ProCodigoAlternativo
	
//deb($InsInformeTecnico->InformeTecnicoProducto);
		if(!empty($InsInformeTecnico->InformeTecnicoProducto)){
			foreach($InsInformeTecnico->InformeTecnicoProducto as $DatInformeTecnicoProducto){	
			
			
				if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
				
					$DatInformeTecnicoProducto->ItpValorUnitario = round($DatInformeTecnicoProducto->ItpValorUnitario / $InsInformeTecnico->IteTipoCambio,2);
					$DatInformeTecnicoProducto->ItpValorTotal = round($DatInformeTecnicoProducto->ItpValorTotal / $InsInformeTecnico->IteTipoCambio,2);
					
				}
						
				$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador]->MtdAgregarSesionObjeto(1,
				$DatInformeTecnicoProducto->ItpId,
				$DatInformeTecnicoProducto->ProId,
				$DatInformeTecnicoProducto->UmeId,
				$DatInformeTecnicoProducto->FapId,
				$DatInformeTecnicoProducto->ProNombre,
				$DatInformeTecnicoProducto->ItpCantidad,
				$DatInformeTecnicoProducto->ItpValorUnitario,
				$DatInformeTecnicoProducto->ItpValorTotal,
				$DatInformeTecnicoProducto->ItpEstado,
				$DatInformeTecnicoProducto->ItpTiempoCreacion,
				$DatInformeTecnicoProducto->ItpTiempoModificacion,
				$DatInformeTecnicoProducto->UmeNombre,
				$DatInformeTecnicoProducto->ProCodigoOriginal,
				$DatInformeTecnicoProducto->ProCodigoAlternativo);
			//	deb($DatFichaAccionProducto->ProCodigoOriginal);
		
			}
		}			

	
	
}	
?>