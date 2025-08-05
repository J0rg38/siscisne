<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

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
	$InsInformeTecnico->IteTiempoCreacion = date("Y-m-d H:i:s");
	$InsInformeTecnico->IteTiempoModificacion = date("Y-m-d H:i:s");
	$InsInformeTecnico->IteEliminado = 1;

	$InsInformeTecnico->EinVIN = $_POST['CmpVehiculoIngresoVIN'];	

	$InsInformeTecnico->MonId = $_POST['CmpMonedaId'];
	$InsInformeTecnico->IteTipoCambio = $_POST['CmpTipoCambio'];


//deb($InsInformeTecnico->IteTipoCambio);

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
			
			//deb($InsInformeTecnicoProducto1->ItpValorUnitario);			
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



	
	
	$ResInformeTecnicoOperacion = $_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]->MtdObtenerSesionObjetos(true);

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

	if($InsInformeTecnico->MtdRegistrarInformeTecnico()){
		$Resultado.='#SAS_ITE_101';
		$Registro = true;
	} else{
		$Resultado.='#ERR_ITE_101';
	}

	$InsInformeTecnico->IteFecha = FncCambiaFechaANormal($InsInformeTecnico->IteFecha);
	$InsInformeTecnico->IteFechaVenta = FncCambiaFechaANormal($InsInformeTecnico->IteFechaVenta,true);

}else{
	
	$InsFichaIngreso->FinId = $GET_FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
	
	unset($_SESSION['InsInformeTecnicoATS3Foto'.$Identificador]);


//	deb('InsInformeTecnicoATS3Producto'.$Identificador);
	
	$_SESSION['InsInformeTecnicoATS3Foto'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador] = new ClsSesionObjeto();
			
	$_SESSION['SesIteFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesIteFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesIteFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesIteFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;
	
	$InsInformeTecnico->FinId = $InsFichaIngreso->FinId;
	$InsInformeTecnico->IteConcesionario = "C & C.SAC";
	$InsInformeTecnico->IteSedeLocal = "TACNA";
	$InsInformeTecnico->IteContactoGM = "ALBERTO GIGLIO";
	
	$InsInformeTecnico->IteFecha = date("d/m/Y");
	$InsInformeTecnico->PerId = $InsFichaIngreso->PerId;
	
	$InsInformeTecnico->EinVIN = $InsFichaIngreso->EinVIN;
	$InsInformeTecnico->ItePlaca = $InsFichaIngreso->EinPlaca;
	$InsInformeTecnico->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
	$InsInformeTecnico->ItePropietario = $InsFichaIngreso->CliNombre." ".$InsFichaIngreso->CliApellidoPaterno." ".$InsFichaIngreso->CliApellidoMaterno;
	
	$InsInformeTecnico->IteFechaVenta = $InsFichaIngreso->EinFechaVenta;
	$InsInformeTecnico->IteModelo = $InsFichaIngreso->VmoNombre." ".$InsFichaIngreso->VveNombre;
	
	$InsInformeTecnico->IteCausa = "";
	$InsInformeTecnico->IteCorreccion = "";
	
	$InsInformeTecnico->IteSolucionSatisfactoria=1;
	
	$InsInformeTecnico->MonId = "MON-10001";

	
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
	  $InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsInformeTecnico->IteTipoCambio = $InsTipoCambio->TcaMontoComercial;
	
	//deb($InsInformeTecnico->IteTipoCambio);
				
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
			
			if($InsFichaAccion->MinSigla == "CA" 
			or $InsFichaAccion->MinSigla == "GA" 
			or $InsFichaAccion->MinSigla == "PO" 
			or $InsFichaAccion->MinSigla == "IF" 
			or $InsFichaAccion->MinSigla == "PP" ){
				
				
			$FichaAccionCausa = strip_tags($InsFichaAccion->FccCausa);
			$FichaAccionSolucion = strip_tags($InsFichaAccion->FccSolucion);
			
			$InsInformeTecnico->IteCausa .= $FichaAccionCausa;
			$InsInformeTecnico->IteCorreccion .= $FichaAccionSolucion;
			
			
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

				
		$CostoHora  = 0;
		$ValorTotal  = 0;
								
		$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
		$InsConfiguracionEmpresa->CemId = "CEM-10000";
		$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	
				
		

				if(!empty($InsFichaAccion->FichaAccionTempario)){
					foreach($InsFichaAccion->FichaAccionTempario as $DatFichaAccionTempario){
						
						$CostoHora = empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;
						$ValorTotal = $CostoHora * $DatFichaAccionTempario->FaeTiempo;
				
						$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$DatFichaAccionTempario->FaeCodigo,
						$DatFichaAccionTempario->FaeTiempo,
						$CostoHora,
						$ValorTotal,
						3,
						
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						$DatFichaAccionTempario->FaeId
						
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
	

				if(!empty($InsFichaAccion->FichaAccionProducto)){
					foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){	


					$InsProductoListaPrecio = new ClsProductoListaPrecio();

					$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatFichaAccionProducto->ProCodigoOriginal, 'PlpId','ASC',"1",1);
					$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
					
					$ValorUnitario = 0;
					$ValorTotal = 0;
					
					if(!empty($ArrProductoListaPrecios)){
						foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
								
							$ValorUnitario = $DatProductoListaPrecio->PlpPrecioReal;
							$ValorTotal = $ValorUnitario * $DatFichaAccionProducto->FapCantidad;
							
							
						}
					}

						//deb('InsInformeTecnicoATS3Producto'.$Identificador);
						$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$DatFichaAccionProducto->ProId,
						$DatFichaAccionProducto->UmeId,
						$DatFichaAccionProducto->FapId,
						$DatFichaAccionProducto->ProNombre,
						$DatFichaAccionProducto->FapCantidad,
						$ValorUnitario,
						$ValorTotal,
						3,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						$DatFichaAccionProducto->UmeNombre,
						$DatFichaAccionProducto->ProCodigoOriginal,
						$DatFichaAccionProducto->ProCodigoAlternativo);
					//	deb($DatFichaAccionProducto->ProCodigoOriginal);

					}
				}			

				
			}
											
											
			
			
				
				
				
		}
	}
	
	
	
}
?>
