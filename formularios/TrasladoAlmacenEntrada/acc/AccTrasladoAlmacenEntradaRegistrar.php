<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsTrasladoAlmacenEntrada->UsuId = $_SESSION['SesionId'];	

	$InsTrasladoAlmacenEntrada->TaeId = $_POST['CmpId'];
	$InsTrasladoAlmacenEntrada->PrvId = $_POST['CmpProveedorId'];
	$InsTrasladoAlmacenEntrada->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsTrasladoAlmacenEntrada->TopId = $_POST['CmpTipoOperacion'];	
	$InsTrasladoAlmacenEntrada->OcoId = $_POST['CmpOrdenCompra'];	
	$InsTrasladoAlmacenEntrada->AlmId = $_POST['CmpAlmacen'];	
	
//	$InsTrasladoAlmacenEntrada->TaePorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsTrasladoAlmacenEntrada->TaePorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsTrasladoAlmacenEntrada->TaeFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoAlmacenEntrada->TaeObservacion = addslashes($_POST['CmpObservacion']);
	$InsTrasladoAlmacenEntrada->TaeDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsTrasladoAlmacenEntrada->TaeComprobanteNumero = $InsTrasladoAlmacenEntrada->TaeComprobanteNumeroSerie."-".$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroNumero;	
	$InsTrasladoAlmacenEntrada->TaeComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	

	$InsTrasladoAlmacenEntrada->MonId = $EmpresaMonedaId;

	$InsTrasladoAlmacenEntrada->TaeTipo = 1;
	$InsTrasladoAlmacenEntrada->TaeSubTipo = 8;
	$InsTrasladoAlmacenEntrada->TaeEstado = $_POST['CmpEstado'];
	
	$InsTrasladoAlmacenEntrada->TaeTiempoCreacion = date("Y-m-d H:i:s");
	$InsTrasladoAlmacenEntrada->TaeTiempoModificacion = date("Y-m-d H:i:s");
	$InsTrasladoAlmacenEntrada->TaeEliminado = 1;
	
	$InsTrasladoAlmacenEntrada->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsTrasladoAlmacenEntrada->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsTrasladoAlmacenEntrada->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsTrasladoAlmacenEntrada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsTrasladoAlmacenEntrada->TaeFoto = $_SESSION['SesAmoFoto'.$Identificador];

	$InsTrasladoAlmacenEntrada->TrasladoAlmacenEntradaDetalle = array();

	
	if(empty($InsTrasladoAlmacenEntrada->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_TAE_602';
	}
		
	

		//	
	//SesionObjeto-TrasladoAlmacenEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado
//Parametro26 = AmdUbicacion


	$ResTrasladoAlmacenEntradaDetalle = $_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	if(!empty($ResTrasladoAlmacenEntradaDetalle['Datos'])){
		foreach($ResTrasladoAlmacenEntradaDetalle['Datos'] as $DatSesionObjeto){

			$InsTrasladoAlmacenEntradaDetalle1 = new ClsTrasladoAlmacenEntradaDetalle();
			$InsTrasladoAlmacenEntradaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoAlmacenEntradaDetalle1->UmeId = $DatSesionObjeto->Parametro10;

			$InsTrasladoAlmacenEntradaDetalle1->TedIdOrigen = $DatSesionObjeto->Parametro20;
		
			$InsTrasladoAlmacenEntradaDetalle1->TedCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoAlmacenEntradaDetalle1->TedCantidadReal = $DatSesionObjeto->Parametro12;
			$InsTrasladoAlmacenEntradaDetalle1->TedUbicacion = $DatSesionObjeto->Parametro26;

			$InsTrasladoAlmacenEntradaDetalle1->TedEstado = $DatSesionObjeto->Parametro25;
			$InsTrasladoAlmacenEntradaDetalle1->TedTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoAlmacenEntradaDetalle1->TedTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsTrasladoAlmacenEntradaDetalle1->TedEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoAlmacenEntradaDetalle1->InsMysql = NULL;

			
			//deb($InsTrasladoAlmacenEntradaDetalle1->TedEliminado);
			if($InsTrasladoAlmacenEntradaDetalle1->TedEliminado==1){					
				$InsTrasladoAlmacenEntrada->TrasladoAlmacenEntradaDetalle[] = $InsTrasladoAlmacenEntradaDetalle1;	
			}
		}		
		
	}
	
	if($Guardar){

		if($InsTrasladoAlmacenEntrada->MtdRegistrarTrasladoAlmacenEntrada()){

				FncNuevo();
		
			$Resultado.='#SAS_TAE_101';
			$Registro = true;
		}else{
			
			$InsTrasladoAlmacenEntrada->TaeFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeFecha);
			$InsTrasladoAlmacenEntrada->TaeComprobanteFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeComprobanteFecha,true);
			

			$Resultado.='#ERR_TAE_101';	
		}
			
	}else{
		
			$InsTrasladoAlmacenEntrada->TaeFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeFecha);
			$InsTrasladoAlmacenEntrada->TaeComprobanteFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeComprobanteFecha,true);
	
	}
	


}else{

	FncNuevo();

//	deb($GET_Ori);
	switch($GET_Ori){
		
		case "TrasladoAlmacenSalida":
			
			$InsTrasladoAlmacenSalida = new ClsTrasladoAlmacenSalida();	
			$InsTrasladoAlmacenSalida->TasId = $GET_TasId;
			$InsTrasladoAlmacenSalida->MtdObtenerTrasladoAlmacenSalida();		
			
//			deb($InsTrasladoAlmacenSalida);
			$InsTrasladoAlmacenEntrada->AlmId = $InsTrasladoAlmacenSalida->AlmIdDestino;
			$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroNumero = $InsTrasladoAlmacenSalida->GreId;
			$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroSerie = $InsTrasladoAlmacenSalida->GrtNumero;
			$InsTrasladoAlmacenEntrada->TaeComprobanteFecha = ($InsTrasladoAlmacenSalida->GreFechaInicioTraslado);
			
			
			$InsTrasladoAlmacenEntrada->PrvId = "PRV-1000";//revisar mas adelante
		
			if(!empty($InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle)){
				foreach($InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle as $DatTrasladoAlmacenSalidaDetalle){
					
					$Guardar = false;
									
					if($DatTrasladoAlmacenSalidaDetalle->TasCantidadPendiente>0){
						$Guardar = true;
					}
					
					
//SesionObjeto-TrasladoAlmacenEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado
//Parametro26 = AmdUbicacion
						
					if($Guardar){
						
						$_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$DatTrasladoAlmacenSalidaDetalle->ProId,
						$DatTrasladoAlmacenSalidaDetalle->ProNombre,
						0,
						$DatTrasladoAlmacenSalidaDetalle->TsdCantidad,
						0,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						$DatTrasladoAlmacenSalidaDetalle->UmeNombre,
						$DatTrasladoAlmacenSalidaDetalle->UmeId,
						$DatTrasladoAlmacenSalidaDetalle->RtiId,
						$DatTrasladoAlmacenSalidaDetalle->TsdCantidadReal,			
						0,
					 	0,
						0,
						0,
						$DatTrasladoAlmacenSalidaDetalle->ProCodigoOriginal,
						$DatTrasladoAlmacenSalidaDetalle->ProCodigoAlternativo,
						$DatTrasladoAlmacenSalidaDetalle->UmeIdOrigen,
						$DatTrasladoAlmacenSalidaDetalle->TsdId,
						NULL,
						NULL,
						NULL,
						NULL,
						3,
						$DatTrasladoAlmacenSalidaDetalle->ProUbicacion);
						
					}
		
						
				
				}
			}
			
			
		break;
		
	}
}



function FncNuevo(){

	global $Identificador;
	global $InsTrasladoAlmacenEntrada;
		
	unset($_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]);
	
	$_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoAlmacenEntrada = new ClsTrasladoAlmacenEntrada();
	
	$InsTrasladoAlmacenEntrada->TaeEstado = 3;
	$InsTrasladoAlmacenEntrada->TaeTipoCambio = $_SESSION['SesionTipoCambioCompra'];
	$InsTrasladoAlmacenEntrada->TopId = "TOP-10010";
	$InsTrasladoAlmacenEntrada->CtiId = "CTI-10006";

}
?> 