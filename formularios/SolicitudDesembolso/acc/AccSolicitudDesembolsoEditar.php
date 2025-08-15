<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsSolicitudDesembolso->UsuId = $_SESSION['SesionId'];	
	
	$InsSolicitudDesembolso->SdsId = $_POST['CmpId'];
	
	$InsSolicitudDesembolso->PerId = $_POST['CmpPersonal'];
	$InsSolicitudDesembolso->AreId = $_POST['CmpArea'];
	$InsSolicitudDesembolso->FinId = $_POST['CmpFichaIngreso'];
	$InsSolicitudDesembolso->TgaId = $_POST['CmpTipoGasto'];
	
	$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	list($InsSolicitudDesembolso->SdsAno,$Mes,$Dia) = explode("-",$InsSolicitudDesembolso->SdsFecha);

	$InsSolicitudDesembolso->SdsVIN = $_POST['CmpVIN'];
	$InsSolicitudDesembolso->SdsPlaca = $_POST['CmpPlaca'];
	$InsSolicitudDesembolso->SdsCliente = $_POST['CmpCliente'];
	
	$InsSolicitudDesembolso->MonId = $_POST['CmpMonedaId'];
	$InsSolicitudDesembolso->SdsTipoCambio = $_POST['CmpTipoCambio'];
	$InsSolicitudDesembolso->SdsGastoAsumido = $_POST['CmpGastoAsumido'];
	
	$InsSolicitudDesembolso->SdsAsunto = addslashes($_POST['CmpAsunto']);
	$InsSolicitudDesembolso->SdsDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsSolicitudDesembolso->SdsMonto = preg_replace("/,/", "", (empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));

	$InsSolicitudDesembolso->SdsObservacion = addslashes($_POST['CmpObservacion']);
	$InsSolicitudDesembolso->SdsObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsSolicitudDesembolso->SdsObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);

	$InsSolicitudDesembolso->SdsAprobado = $_POST['CmpAprobado'];
	$InsSolicitudDesembolso->SdsEstado = $_POST['CmpEstado'];
	$InsSolicitudDesembolso->SdsTiempoModificacion = date("Y-m-d H:i:s");


	if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId){
		if(empty($InsSolicitudDesembolso->SdsTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_SDS_600';
		}
	}
	
	
	//	SesionObjeto-SolicitudDesembolsoDetalle
//	Parametro1 = SddId
//	Parametro2 = SdsId
//	Parametro3 = SreId
//	Parametro4 = SddDescripcion
//	Parametro5 = SddCantidad
//	Parametro6 = SddImporte
//	Parametro7 = SddTiempoCreacion
//	Parametro8 = SddTiempoModificacion
//	Parametro9 = SddEstado
//	Parametro10 = SreNombre

	$ResSolicitudDesembolsoDetalle = $_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResSolicitudDesembolsoDetalle['Datos'])){
		$item = 1;
		foreach($ResSolicitudDesembolsoDetalle['Datos'] as $DatSesionObjeto){
				
			$InsSolicitudDesembolsoDetalle1 = new ClsSolicitudDesembolsoDetalle();
			$InsSolicitudDesembolsoDetalle1->SddId = $DatSesionObjeto->Parametro1;
			$InsSolicitudDesembolsoDetalle1->SreId = $DatSesionObjeto->Parametro3;
			
			$InsSolicitudDesembolsoDetalle1->SddCantidad = $DatSesionObjeto->Parametro5;
			$InsSolicitudDesembolsoDetalle1->SddImporte = $DatSesionObjeto->Parametro6;
			
			$InsSolicitudDesembolsoDetalle1->SddEstado = $DatSesionObjeto->Parametro9;
			$InsSolicitudDesembolsoDetalle1->SddTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsSolicitudDesembolsoDetalle1->SddTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsSolicitudDesembolsoDetalle1->SddEliminado = $DatSesionObjeto->Eliminado;				
			$InsSolicitudDesembolsoDetalle1->InsMysql = NULL;

			$InsSolicitudDesembolso->SolicitudDesembolsoDetalle[] = $InsSolicitudDesembolsoDetalle1;

			if($InsSolicitudDesembolsoDetalle1->SddEliminado==1){
				$InsSolicitudDesembolso->SdsTotal += $InsSolicitudDesembolsoDetalle1->SddImporte;
			}	
			
					
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_SDS_111';
	}	
	
	$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsTotal;
	
	if( $InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
		$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsMonto * $InsSolicitudDesembolso->SdsTipoCambio;
	}else{
		$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsMonto;
	}
	
	if($Guardar){
		if($InsSolicitudDesembolso->MtdEditarSolicitudDesembolso()){	

			if(!empty($GET_dia)){
?>
				<script type="text/javascript">

				self.parent.tb_remove('<?php echo $GET_mod;?>');
				self.parent.$('#CmpSolicitudDesembolsoId').val("<?php echo $InsSolicitudDesembolso->SdsId;?>");
				self.parent.FncSolicitudDesembolsoBuscar("Id");

				</script>
<?php
			}
			
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_SDS_102';
			
		} else{
			
			$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaANormal($InsSolicitudDesembolso->SdsFecha);
			$Resultado.='#ERR_SDS_102';
			
			if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
				$InsSolicitudDesembolso->SdsMonto = round($InsSolicitudDesembolso->SdsMonto / $InsSolicitudDesembolso->SdsTipoCambio,3);
			}
			
		}	
	}else{
		
		$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaANormal($InsSolicitudDesembolso->SdsFecha);
		
		if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
			$InsSolicitudDesembolso->SdsMonto = round($InsSolicitudDesembolso->SdsMonto / $InsSolicitudDesembolso->SdsTipoCambio,3);
		}
		
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsSolicitudDesembolso;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	
	unset($_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]);
	
	$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsSolicitudDesembolso->SdsId = $GET_id;
	$InsSolicitudDesembolso->MtdObtenerSolicitudDesembolso();		

	if(!empty($InsSolicitudDesembolso->SolicitudDesembolsoDetalle)){
		foreach($InsSolicitudDesembolso->SolicitudDesembolsoDetalle as $DatSolicitudDesembolsoDetalle){
			
			if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
				$DatSolicitudDesembolsoDetalle->SddImporte = round($DatSolicitudDesembolsoDetalle->SddImporte / $InsSolicitudDesembolso->SdsTipoCambio,2);
			}
		
//	SesionObjeto-SolicitudDesembolsoDetalle
//	Parametro1 = SddId
//	Parametro2 = SdsId
//	Parametro3 = SreId
//	Parametro4 = SddDescripcion
//	Parametro5 = SddCantidad
//	Parametro6 = SddImporte
//	Parametro7 = SddTiempoCreacion
//	Parametro8 = SddTiempoModificacion
//	Parametro9 = SddEstado
//	Parametro10 = SreNombre
//	
		
			$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatSolicitudDesembolsoDetalle->SddId,
			$DatSolicitudDesembolsoDetalle->SdsId,
			$DatSolicitudDesembolsoDetalle->SreId,
			$DatSolicitudDesembolsoDetalle->SddDescripcion,
			$DatSolicitudDesembolsoDetalle->SddCantidad,
			$DatSolicitudDesembolsoDetalle->SddImporte,
			($DatSolicitudDesembolsoDetalle->SddTiempoCreacion),
			($DatSolicitudDesembolsoDetalle->SddTiempoModificacion),
			$DatSolicitudDesembolsoDetalle->SddEstado,
			$DatSolicitudDesembolsoDetalle->SreNombre
			);
		
		}
	}
}

?>