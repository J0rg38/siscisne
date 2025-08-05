<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsComprobanteRetencion->CrnId = $_POST['CmpId'];
	$InsComprobanteRetencion->CrtId = $_POST['CmpTalonario'];
	$InsComprobanteRetencion->CliId = $_POST['CmpClienteId'];
	
	$InsComprobanteRetencion->UsuId = $_SESSION['SesionId'];
	$InsComprobanteRetencion->UsuUsuario = $_SESSION['SesionUsuario'];
	
	$InsComprobanteRetencion->MonId = $_POST['CmpMonedaId'];
	$InsComprobanteRetencion->CrnTipoCambio = $_POST['CmpTipoCambio'];
		
	$InsComprobanteRetencion->CrnCancelado = $_POST['CmpCancelado'];
	$InsComprobanteRetencion->CrnTipo = 1;
	$InsComprobanteRetencion->CrnEstado = $_POST['CmpEstado'];

	$InsComprobanteRetencion->CrnFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsComprobanteRetencion->CrnObservacion = addslashes($_POST['CmpObservacion']);
	$InsComprobanteRetencion->CrnObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	
		
	$InsComprobanteRetencion->CrnCierre = $_POST['CmpCierre'];
	$InsComprobanteRetencion->CrnTiempoModificacion = date("Y-m-d H:i:s");
	$InsComprobanteRetencion->CrnEliminado = 1;
	
	$InsComprobanteRetencion->CliNombre = $_POST['CmpClienteNombre'];
	$InsComprobanteRetencion->CliNombreCompleto = $_POST['CmpClienteNombre'];
	$InsComprobanteRetencion->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsComprobanteRetencion->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsComprobanteRetencion->TdoId = $_POST['CmpClienteTipoDocumentoId'];
	$InsComprobanteRetencion->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsComprobanteRetencion->CliTelefono = $_POST['CmpClienteTelefono'];
	
	$InsComprobanteRetencion->CliEmail = $_POST['CmpClienteEmail'];
	$InsComprobanteRetencion->CliCelular = $_POST['CmpClienteCelular'];
	$InsComprobanteRetencion->CliFax = $_POST['CmpClienteFax'];
	
	$InsComprobanteRetencion->CrnDireccion = $_POST['CmpClienteDireccion'];
	
	$InsComprobanteRetencion->CrnNotificar = $_POST['CmpNotificar'];
	$InsComprobanteRetencion->CrnProcesar = $_POST['CmpProcesar'];
	$InsComprobanteRetencion->CrnEnviarSUNAT = $_POST['CmpEnviarSUNAT'];
	
	$InsComprobanteRetencion->ComprobanteRetencionDetalle = array();		
	
	if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId){
		if(empty($InsComprobanteRetencion->CrnTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_CRN_600';
		}
	}
	
	if(empty($InsComprobanteRetencion->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_CRN_123';
	}	
	
	

/*
SesionObjeto-ComprobanteRetencionDetalleListado
Parametro1 = CedId
Parametro2 = CedTipoDocumento
Parametro3 = 
Parametro4 = CedRetenido
Parametro5 = CedPagado
Parametro6 = CedTotal
Parametro7 = CedTiempoCreacion
Parametro8 = CedTiempoModificacion
Parametro9 = CedSerie
Parametro10 = CedNumero
Parametro11 = CedPorcentajeRetencion
Parametro12 = CedFechaEmision
Parametro13 = CedEstado
*/

	$InsComprobanteRetencion->CrnTotalBruto = 0;
	$InsComprobanteRetencion->CrnTotalRetenido = 0;
	$InsComprobanteRetencion->CrnTotalPagar= 0;

	$ResComprobanteRetencionDetalle = $_SESSION['InsComprobanteRetencionDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	
	if(!empty($ResComprobanteRetencionDetalle['Datos'])){
		foreach($ResComprobanteRetencionDetalle['Datos'] as $DatSesionObjeto){
				
			//deb($DatSesionObjeto->Parametro13);
			if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId){			
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsComprobanteRetencion->CrnTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsComprobanteRetencion->CrnTipoCambio;
				$DatSesionObjeto->Parametro5 = $DatSesionObjeto->Parametro5 * $InsComprobanteRetencion->CrnTipoCambio;	
			}
			
			
			$InsComprobanteRetencionDetalle1 = new ClsComprobanteRetencionDetalle();
			$InsComprobanteRetencionDetalle1->CedId = $DatSesionObjeto->Parametro1;	
			
			$InsComprobanteRetencionDetalle1->CedTipoDocumento = ((($DatSesionObjeto->Parametro2)));
			$InsComprobanteRetencionDetalle1->CedSerie = $DatSesionObjeto->Parametro9;
			$InsComprobanteRetencionDetalle1->CedNumero = $DatSesionObjeto->Parametro10;
			$InsComprobanteRetencionDetalle1->CedFechaEmision = FncCambiaFechaAMysql($DatSesionObjeto->Parametro12);			
			$InsComprobanteRetencionDetalle1->CedTotal = $DatSesionObjeto->Parametro6;			
			$InsComprobanteRetencionDetalle1->CedPorcentajeRetencion = $DatSesionObjeto->Parametro11;
			$InsComprobanteRetencionDetalle1->CedRetenido = $DatSesionObjeto->Parametro4;
			$InsComprobanteRetencionDetalle1->CedPagado = $DatSesionObjeto->Parametro5;
			$InsComprobanteRetencionDetalle1->CedEstado = $DatSesionObjeto->Parametro13;
			
			$InsComprobanteRetencionDetalle1->CedTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsComprobanteRetencionDetalle1->CedTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsComprobanteRetencionDetalle1->CedEliminado = $DatSesionObjeto->Eliminado;				
			$InsComprobanteRetencionDetalle1->InsMysql = NULL;
			
			$InsComprobanteRetencion->ComprobanteRetencionDetalle[] = $InsComprobanteRetencionDetalle1;	
			
			if($InsComprobanteRetencionDetalle1->CedEliminado==1){		
				
				$InsComprobanteRetencion->CrnTotalRetenido += $InsComprobanteRetencionDetalle1->CedRetenido;
				$InsComprobanteRetencion->CrnTotalPagar += $InsComprobanteRetencionDetalle1->CedPagado;
				$InsComprobanteRetencion->CrnTotalBruto += $InsComprobanteRetencionDetalle1->CedTotal;
				
				
			}
						
		}	

	}
	

	
	if($Guardar){
		if($InsComprobanteRetencion->MtdEditarComprobanteRetencion()){
			
			if($InsComprobanteRetencion->CrnNotificar=="1"){
				$InsComprobanteRetencion->MtdNotificarComprobanteRetencionRegistro($InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId,"jblanco@cyc.com.pe,epilco@cyc.com.pe,gparedes@cyc.com.pe,scanepam@cyc.com.pe,pzapana@cyc.com.pe,pcondori@cyc.com.pe");
			}
			
?>
			<script type="text/javascript">
				$().ready(function() {
				/*
				Configuracion carga de datos y animacion
				*/			
					//FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarXML.php?Id=<?php echo $InsComprobanteRetencion->CrnId;?>&Ta=<?php echo $InsComprobanteRetencion->CrtId;?>&P=1',0,0,1,0,0,1,0,350,150);

				});
			</script>
<?php	
			$Edito = true;		
			$Resultado.='#SAS_CRN_102';
			FncCargarDatos();
			
		} else{
			
			$Resultado.='#ERR_CRN_102';
			$InsComprobanteRetencion->CrnFechaEmision = FncCambiaFechaANormal($InsComprobanteRetencion->CrnFechaEmision);
			
		}
	}else{
		
		$InsComprobanteRetencion->CrnFechaEmision = FncCambiaFechaANormal($InsComprobanteRetencion->CrnFechaEmision);	
			
	}

}else{
	
	FncCargarDatos();
	
}


function FncCargarDatos(){

	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsComprobanteRetencion;
	global $EmpresaMonedaId;

	unset($_SESSION['InsComprobanteRetencionDetalle'.$Identificador]);	

	$_SESSION['InsComprobanteRetencionDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsComprobanteRetencion->CrnId = $GET_id;
	$InsComprobanteRetencion->CrtId = $GET_ta;
	$InsComprobanteRetencion->MtdObtenerComprobanteRetencion();		
	
	if(!empty($InsComprobanteRetencion->ComprobanteRetencionDetalle)){
		foreach($InsComprobanteRetencion->ComprobanteRetencionDetalle as $DatComprobanteRetencionDetalle){
			

/*
SesionObjeto-ComprobanteRetencionDetalleListado
Parametro1 = CedId
Parametro2 = CedTipoDocumento
Parametro3 = 
Parametro4 = CedRetenido
Parametro5 = CedPagado
Parametro6 = CedTotal
Parametro7 = CedTiempoCreacion
Parametro8 = CedTiempoModificacion
Parametro9 = CedSerie
Parametro10 = CedNumero
Parametro11 = CedPorcentajeRetencion
Parametro12 = CedFechaEmision
Parametro13 = CedEstado
*/

			if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId ){

				$DatComprobanteRetencionDetalle->CedRetenido = ($DatComprobanteRetencionDetalle->CedRetenido / $InsComprobanteRetencion->CrnTipoCambio);
				$DatComprobanteRetencionDetalle->CedPagado = ($DatComprobanteRetencionDetalle->CedPagado  / $InsComprobanteRetencion->CrnTipoCambio);
				$DatComprobanteRetencionDetalle->CedTotal = ($DatComprobanteRetencionDetalle->CedTotal  / $InsComprobanteRetencion->CrnTipoCambio);

			}

			$_SESSION['InsComprobanteRetencionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatComprobanteRetencionDetalle->CedId,
			$DatComprobanteRetencionDetalle->CedTipoDocumento,
			NULL,
			($DatComprobanteRetencionDetalle->CedRetenido),
			($DatComprobanteRetencionDetalle->CedPagado),
			($DatComprobanteRetencionDetalle->CedTotal),
			($DatComprobanteRetencionDetalle->CedTiempoCreacion),
			($DatComprobanteRetencionDetalle->CedTiempoModificacion),
			$DatComprobanteRetencionDetalle->CedSerie,
			$DatComprobanteRetencionDetalle->CedNumero,
			$DatComprobanteRetencionDetalle->CedPorcentajeRetencion,
			$DatComprobanteRetencionDetalle->CedFechaEmision,
			$DatComprobanteRetencionDetalle->CedEstado);

		}
	}
	
}

?>