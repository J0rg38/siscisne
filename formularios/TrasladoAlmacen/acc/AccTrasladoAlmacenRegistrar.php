 <?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsTrasladoAlmacen->UsuId = $_SESSION['SesionId'];	
	
	$InsTrasladoAlmacen->PerId = $_POST['CmpPersonal'];
	$InsTrasladoAlmacen->AlmId = $_POST['CmpAlmacen'];
	$InsTrasladoAlmacen->AlmIdDestino = $_POST['CmpAlmacenDestino'];
	
	$InsTrasladoAlmacen->TopId = "TOP-10010";
	$InsTrasladoAlmacen->CtiId = "CTI-10006";
	
	$InsTrasladoAlmacen->CliId = "CLI-1000";
	$InsTrasladoAlmacen->PrvId = "PRV-1000";
		
	$InsTrasladoAlmacen->TalFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoAlmacen->TalFechaLlegada = FncCambiaFechaAMysql($_POST['CmpFechaLlegada'],true);
	
	list($InsTrasladoAlmacen->TalAno,$Mes,$Dia) = explode("-",$InsTrasladoAlmacen->TalFecha);	
	$InsTrasladoAlmacen->TalObservacion = addslashes($_POST['CmpObservacion']);

	$InsTrasladoAlmacen->MonId = $_POST['CmpMonedaId'];
	$InsTrasladoAlmacen->TalTipoCambio = $_POST['CmpTipoCambio'];

	$InsTrasladoAlmacen->TalPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsTrasladoAlmacen->TalIncluyeImpuesto = 1;
	
	$InsTrasladoAlmacen->TalEstado = $_POST['CmpEstado'];
	$InsTrasladoAlmacen->TalTiempoCreacion = date("Y-m-d H:i:s");
	$InsTrasladoAlmacen->TalTiempoModificacion = date("Y-m-d H:i:s");

	$InsTrasladoAlmacen->TalTotal = 0;

/*
SesionObjeto-TrasladoAlmacenDetalle
Parametro1 = TadId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = 
Parametro5 = TadCantidad
Parametro6 = TadCantidadReal
Parametro7 = TadTiempoCreacion
Parametro8 = TadTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = TadEstado
*/

	$ResTrasladoAlmacenDetalle = $_SESSION['InsTrasladoAlmacenDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResTrasladoAlmacenDetalle['Datos'])){
		$item = 1;
		foreach($ResTrasladoAlmacenDetalle['Datos'] as $DatSesionObjeto){
				
			$InsTrasladoAlmacenDetalle1 = new ClsTrasladoAlmacenDetalle();
			$InsTrasladoAlmacenDetalle1->TadId = $DatSesionObjeto->Parametro1;
			$InsTrasladoAlmacenDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoAlmacenDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsTrasladoAlmacenDetalle1->TadCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoAlmacenDetalle1->TadCantidadReal = $DatSesionObjeto->Parametro6;
			$InsTrasladoAlmacenDetalle1->TadCosto = 0;
			$InsTrasladoAlmacenDetalle1->TadImporte = 0;
			$InsTrasladoAlmacenDetalle1->TadEstado = $InsTrasladoAlmacen->TalEstado;
			$InsTrasladoAlmacenDetalle1->TadTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoAlmacenDetalle1->TadTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsTrasladoAlmacenDetalle1->TadEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoAlmacenDetalle1->InsMysql = NULL;

			if($InsTrasladoAlmacenDetalle1->TadEliminado==1){					
				$InsTrasladoAlmacen->TrasladoAlmacenDetalle[] = $InsTrasladoAlmacenDetalle1;		
			}
			
			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_TAL_111';
	}
	
	
	
	if(empty($InsTrasladoAlmacen->AlmId )){
		$Guardar = false;
		$Resultado.='#ERR_TAL_112';		
	}
	
	if(empty($InsTrasladoAlmacen->AlmIdDestino )){
		$Guardar = false;
		$Resultado.='#ERR_TAL_113';		
	}
	
	
	if($InsTrasladoAlmacen->AlmId == $InsTrasladoAlmacen->AlmIdDestino ){
		$Guardar = false;
		$Resultado.='#ERR_TAL_114';		
	}


	if($Guardar){

		if($InsTrasladoAlmacen->MtdRegistrarTrasladoAlmacen()){
			
			unset($InsTrasladoAlmacen);
			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_TAL_101';

		}else{

			$InsTrasladoAlmacen->TalFecha = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFecha);
			$InsTrasladoAlmacen->TalFechaLlegada = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFechaLlegada,true);
			$Resultado.='#ERR_TAL_101';

		}		

	}else{

		$InsTrasladoAlmacen->TalFecha = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFecha);	
		$InsTrasladoAlmacen->TalFechaLlegada = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFechaLlegada,true);

	}

	

}else{
	
	FncNuevo();
	
}

function FncNuevo(){

	global $Identificador;
	global $InsTrasladoAlmacen;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
	global $EmpresaMonedaId;

	unset($_SESSION['InsTrasladoAlmacenDetalle'.$Identificador]);

	$_SESSION['InsTrasladoAlmacenDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsTrasladoAlmacen->TalFecha = date("d/m/Y");
	$InsTrasladoAlmacen->TalFechaLlegada = date("d/m/Y");
	
	$InsTrasladoAlmacen->TalEstado = 3;
	$InsTrasladoAlmacen->AlmId = "ALM-10000";
	
	$InsTrasladoAlmacen->TopId = "TOP-10010";
	$InsTrasladoAlmacen->CtiId = "CTI-10006";
	
	$InsTrasladoAlmacen->MonId = $EmpresaMonedaId;
	$InsTrasladoAlmacen->TalPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	
}
?>