<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsConductor->UsuId = $_SESSION['SesionId'];

	$InsConductor->ConId = $_POST['CmpId'];	
	$InsConductor->ConOtroCodigo = $_POST['CmpOtroCodigo'];
	$InsConductor->ConModalidad = $_POST['CmpModalidad'];
	
	$InsConductor->ConCredencialTaxi = $_POST['CmpCredencialTaxi'];
	$InsConductor->ConCredencialTaxiFecha = FncCambiaFechaAMysql($_POST['CmpCredencialTaxiFecha'],true);
	
	$InsConductor->VehId = $_POST['CmpVehiculoId'];		
	$InsConductor->VehUnidad = $_POST['CmpVehiculoUnidad'];		
	$InsConductor->VehPlaca = $_POST['CmpVehiculoPlaca'];		
	$InsConductor->VehColor = $_POST['CmpVehiculoColor'];		
	
	$InsConductor->VehMarca = $_POST['CmpVehiculoMarca'];
	$InsConductor->VehModelo = $_POST['CmpVehiculoModelo'];
	$InsConductor->VehAno = $_POST['CmpVehiculoAno'];
	
	$InsConductor->VehCodigoMunicipal = $_POST['CmpVehiculoCodigoMunicipal'];
	$InsConductor->VehSOATFecha = FncCambiaFechaAMysql($_POST['CmpVehiculoSOATFecha'],true);
	$InsConductor->VehRevisionTecnicaFecha = FncCambiaFechaAMysql($_POST['CmpVehiculoRevisionTecnicaFecha'],true);

	$InsConductor->ConNumeroDocumento = $_POST['CmpNumeroDocumento'];	
	$InsConductor->ConNombre = $_POST['CmpNombre'];
	$InsConductor->ConApellido = $_POST['CmpApellido'];
	$InsConductor->ConDireccion = ($_POST['CmpDireccion']);
	$InsConductor->ConTelefono = ($_POST['CmpTelefono']);
	$InsConductor->ConCelular = ($_POST['CmpCelular']);
	$InsConductor->ConNumeroBrevete = ($_POST['CmpNumeroBrevete']);
	$InsConductor->ConBreveteFechaExpiracion = FncCambiaFechaAMysql($_POST['CmpBreveteFechaExpiracion'],true);	
	$InsConductor->ConCuota = ($_POST['CmpCuota']);
	$InsConductor->ConTurno = ($_POST['CmpTurno']);	
//	$InsConductor->ConAplicacion = $_POST['CmpAplicacion'];
	$InsConductor->ConAplicacion = empty($_POST['CmpAplicacion'])?2:$_POST['CmpAplicacion'];
	$InsConductor->ConResetear = empty($_POST['CmpResetear'])?2:$_POST['CmpResetear'];
	
	$InsConductor->ConEmail = $_POST['CmpEmail'];
	$InsConductor->ConClave = $_POST['CmpClave'];	
	$InsConductor->ConIdentificador = $_POST['CmpIdentificador'];
	
	$InsConductor->ConEquipoModelo = $_POST['CmpEquipoModelo'];	
	$InsConductor->ConObservacion = addslashes($_POST['CmpObservacion']);	
	$InsConductor->ConSupervisor = $_POST['CmpSupervisor'];
	$InsConductor->ConSupervisorNivel = $_POST['CmpSupervisorNivel'];
		$InsConductor->ConSituacion = $_POST['CmpSituacion'];
	$InsConductor->ConEstado = $_POST['CmpEstado'];
	$InsConductor->ConTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsConductor->ConFoto = $_SESSION['SesConFoto'.$Identificador];
	
	$InsConductor->ConFechaInicio = FncCambiaFechaAMysql($_POST['CmpFechaInicio'],true);
	$InsConductor->ConFechaFin = FncCambiaFechaAMysql($_POST['CmpFechaFin'],true);		
	
	$InsConductor->ConRetiro = $_POST['CmpRetiro'];
	
	
	$InsConductor->ProId = $_POST['CmpPropietarioId'];
	$InsConductor->ProNumeroDocumento = $_POST['CmpPropietarioNumeroDocumento'];
	$InsConductor->ProNombre = $_POST['CmpPropietarioNombre'];
	$InsConductor->ProApellido = $_POST['CmpPropietarioApellido'];
	$InsConductor->ProDireccion = ($_POST['CmpPropietarioDireccion']);
	$InsConductor->ProTelefono = ($_POST['CmpPropietarioTelefono']);
	$InsConductor->ProCelular = ($_POST['CmpPropietarioCelular']);
	
	if(empty($InsConductor->ProId)){
		
		if(!empty($InsConductor->ProNumeroDocumento)){
			
			
		$InsPropietario = new ClsPropietario();
		$InsPropietario->MtdIdentificarPropietario("ProNumeroDocumento",$InsConductor->ProNumeroDocumento);
		
		if(!empty($InsPropietario->ProId)){
			
			$InsConductor->ProId = $InsPropietario->ProId;
			
			$InsPropietario = new ClsPropietario();
			$InsPropietario->MtdEditarPropietarioDato("ProNombre",$InsConductor->ProNombre,$InsPropietario->ProId);
			$InsPropietario->MtdEditarPropietarioDato("ProApellido",$InsConductor->ProApellido,$InsPropietario->ProId);			
			$InsPropietario->MtdEditarPropietarioDato("ProDireccion",$InsConductor->ProDireccion,$InsPropietario->ProId);
			$InsPropietario->MtdEditarPropietarioDato("ProTelefono",$InsConductor->ProTelefono,$InsPropietario->ProId);
			$InsPropietario->MtdEditarPropietarioDato("ProCelular",$InsConductor->ProCelular,$InsPropietario->ProId);
			
		}else{
			
			$InsPropietario = new ClsPropietario();
			$InsPropietario->ProId = "";
			$InsPropietario->ProOtroCodigo = "";	
			$InsPropietario->ProNumeroDocumento = $InsConductor->ProNumeroDocumento ;	
			$InsPropietario->ProNombre = $InsConductor->ProNombre;
			$InsPropietario->ProApellido = $InsConductor->ProApellido;
			$InsPropietario->ProDireccion = $InsConductor->ProDireccion;
			$InsPropietario->ProTelefono = $InsConductor->ProTelefono ;
			$InsPropietario->ProCelular = $InsConductor->ProCelular;	
			$InsPropietario->ProGarantia = "";
			$InsPropietario->ProDeudaPendiente = "";	
			$InsPropietario->ProFechaRecibo = NULL;
			$InsPropietario->ProFechaReingreso = NULL;
			$InsPropietario->ProEstado = 1;
			$InsPropietario->ProTiempoCreacion = date("Y-m-d H:i:s");
			$InsPropietario->ProTiempoModificacion = date("Y-m-d H:i:s");
			$InsPropietario->ProEliminado = 1;
			$InsPropietario->ProFoto = "default.jpg";
		
			if($InsPropietario->MtdRegistrarPropietario()){
				$InsConductor->ProId = $InsPropietario->ProId;
			}
			
			}	
			
		}
		
		
		
	}else{
		
		$InsPropietario = new ClsPropietario();
		$InsPropietario->MtdEditarPropietarioDato("ProNombre",$InsConductor->ProNombre,$InsConductor->ProId);
		$InsPropietario->MtdEditarPropietarioDato("ProApellido",$InsConductor->ProApellido,$InsConductor->ProId);			
		$InsPropietario->MtdEditarPropietarioDato("ProDireccion",$InsConductor->ProDireccion,$InsConductor->ProId);
		$InsPropietario->MtdEditarPropietarioDato("ProTelefono",$InsConductor->ProTelefono,$InsConductor->ProId);
		$InsPropietario->MtdEditarPropietarioDato("ProCelular",$InsConductor->ProCelular,$InsConductor->ProId);
	
	}
	
	
	
	
	
	
	
	if(empty($InsConductor->VehId)){
		
		if(!empty($InsConductor->VehUnidad)){
				
			$InsVehiculo = new ClsVehiculo();
			$InsVehiculo->MtdIdentificarVehiculo("VehUnidad",$InsConductor->VehUnidad);
			
			if(!empty($InsConductor->VehId)){
					
				$InsConductor->VehId = $InsVehiculo->VehId;
												
				$InsVehiculo = new ClsVehiculo();
				$InsVehiculo->MtdEditarVehiculoDato("VehUnidad",$InsConductor->VehUnidad,$InsVehiculo->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehPlaca",$InsConductor->VehPlaca,$InsVehiculo->VehId);							
				$InsVehiculo->MtdEditarVehiculoDato("VehMarca",$InsConductor->VehMarca,$InsVehiculo->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehModelo",$InsConductor->VehModelo,$InsVehiculo->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehAno",$InsConductor->VehAno,$InsVehiculo->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehColor",$InsConductor->VehColor,$InsVehiculo->VehId);
				
				$InsVehiculo->MtdEditarVehiculoDato("VehCodigoMunicipal",$InsConductor->VehCodigoMunicipal,$InsVehiculo->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehSOATFecha",$InsConductor->VehSOATFecha,$InsVehiculo->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehRevisionTecnicaFecha",$InsConductor->VehRevisionTecnicaFecha,$InsVehiculo->VehId);
				
			}
				
		}
		
	}else{
		
				$InsVehiculo = new ClsVehiculo();
				$InsVehiculo->MtdEditarVehiculoDato("VehUnidad",$InsConductor->VehUnidad,$InsConductor->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehPlaca",$InsConductor->VehPlaca,$InsConductor->VehId);							
				$InsVehiculo->MtdEditarVehiculoDato("VehMarca",$InsConductor->VehMarca,$InsConductor->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehModelo",$InsConductor->VehModelo,$InsConductor->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehAno",$InsConductor->VehAno,$InsConductor->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehColor",$InsConductor->VehColor,$InsConductor->VehId);
				
				$InsVehiculo->MtdEditarVehiculoDato("VehCodigoMunicipal",$InsConductor->VehCodigoMunicipal,$InsConductor->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehSOATFecha",$InsConductor->VehSOATFecha,$InsConductor->VehId);
				$InsVehiculo->MtdEditarVehiculoDato("VehRevisionTecnicaFecha",$InsConductor->VehRevisionTecnicaFecha,$InsConductor->VehId);
		
	}
	
	
	
	
	if(!empty($InsConductor->ConRetiro)){
		$InsConductor->ConFechaInicio = NULL;
	}

	if($InsConductor->MtdEditarConductor()){	
	
		if(!empty($InsConductor->VehId)){
			
			//MtdObtenerVehiculos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oConductor=NULL,$oSocio=NULL,$oConductor2=NULL,$oConductor3=NULL)
			$VehiculoId = "";
			
			$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos(NULL,NULL,'VehId','Desc','1',NULL,$InsConductor->ConId,NULL,NULL,NULL);
			$ArrVehiculos = $ResVehiculo['Datos'];
			
			if(!empty($ArrVehiculos)){
				foreach($ArrVehiculos as $DatVehiculo){
					$VehiculoId = $DatVehiculo->VehId;		
				}
			}
					
			if(!empty($VehiculoId)){
				$InsVehiculo->MtdEditarVehiculoDato("ConId",NULL,$VehiculoId);
			}
			
			//deb($VehiculoId);
			
			$VehiculoId2 = "";
			
			$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos(NULL,NULL,'VehId','Desc','1',NULL,NULL,NULL,$InsConductor->ConId,NULL);
			$ArrVehiculos = $ResVehiculo['Datos'];
			
			if(!empty($ArrVehiculos)){
				foreach($ArrVehiculos as $DatVehiculo){
					$VehiculoId2 = $DatVehiculo->VehId;		
				}
			}
					
			if(!empty($VehiculoId2)){
				$InsVehiculo->MtdEditarVehiculoDato("ConId2",NULL,$VehiculoId2);	
			}
			
			//deb($VehiculoId2);
			
			$VehiculoId3 = "";
			
			$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos(NULL,NULL,'VehId','Desc','1',NULL,NULL,NULL,NULL,$InsConductor->ConId);
			$ArrVehiculos = $ResVehiculo['Datos'];
			
			if(!empty($ArrVehiculos)){
				foreach($ArrVehiculos as $DatVehiculo){
					$VehiculoId3 = $DatVehiculo->VehId;		
				}
			}
					
			if(!empty($VehiculoId3)){
				$InsVehiculo->MtdEditarVehiculoDato("ConId3",NULL,$VehiculoId3);	
			}			

		//	deb($VehiculoId3);
			
			switch($InsConductor->ConTurno){
				case 1://DIA
					$InsVehiculo->MtdEditarVehiculoDato("ConId",$InsConductor->ConId,$InsConductor->VehId);					
				break;
				
				case 2://NOCHE
					$InsVehiculo->MtdEditarVehiculoDato("ConId2",$InsConductor->ConId,$InsConductor->VehId);
					
				break;
				
				case 3://PUERTA LIBRE
				  $InsVehiculo->MtdEditarVehiculoDato("ConId3",$InsConductor->ConId,$InsConductor->VehId);
				  
				break;
			}
			
			$InsVehiculo->MtdEditarVehiculoDato("VehPlaca",$InsConductor->VehPlaca,$InsConductor->VehId);
			$InsVehiculo->MtdEditarVehiculoDato("VehColor",$InsConductor->VehColor,$InsConductor->VehId);

			$InsVehiculo->MtdEditarVehiculoDato("VehMarca",$InsConductor->VehMarca,$InsConductor->VehId);
			$InsVehiculo->MtdEditarVehiculoDato("VehModelo",$InsConductor->VehModelo,$InsConductor->VehId);
			$InsVehiculo->MtdEditarVehiculoDato("VehAno",$InsConductor->VehAno,$InsConductor->VehId);

			$InsVehiculo->MtdEditarVehiculoDato("VehCodigoMunicipal",$InsConductor->VehCodigoMunicipal,$InsConductor->VehId);
			$InsVehiculo->MtdEditarVehiculoDato("VehSOATFecha",$InsConductor->VehSOATFecha,$InsConductor->VehId);
			$InsVehiculo->MtdEditarVehiculoDato("VehRevisionTecnicaFecha",$InsConductor->VehRevisionTecnicaFecha,$InsConductor->VehId);
			
			$InsVehiculo->MtdEditarVehiculoDato("ProId",$InsConductor->ProId,$InsConductor->VehId);
			
			
			
		}
		
  		/*
		* SINCRONIZANDO CON SERVIDIOR - INICIO
		*/           
		
		if($InsConductor->ConAplicacion == "1"){
			/*
			$wsdl = 'http://www.radiotaxi114.com/app114/webservice/WsConductor.php?wsdl';
			//$wsdl = 'http://localhost/SISTEMAS/SISTAXI114/radiotaxi114.com/app114/webservice/WsConductor.php?wsdl';
			
			$l_oClient = new nusoap_client($wsdl,'wsdl');
			$l_oProxy = $l_oClient->getProxy();
				
			$err = $l_oClient->getError();
			
			if ($err) {
				echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			}
			
				$Conductor['ConId'] = $InsConductor->ConId;
				$Conductor['VehId'] = $InsConductor->VehId;
				
				$Conductor['ConNumeroDocumento'] = $InsConductor->ConNumeroDocumento;
				$Conductor['ConNombre'] = $InsConductor->ConNombre." ".$DatConductor->ConApellido;
				$Conductor['ConTelefono'] = $InsConductor->ConTelefono;
				$Conductor['ConCelular'] = $InsConductor->ConCelular;
				$Conductor['ConVehiculoUnidad'] = $InsConductor->VehUnidad;
				$Conductor['ConVehiculoPlaca'] = $InsConductor->VehPlaca;
				$Conductor['ConVehiculoColor'] = $InsConductor->VehColor;
				$Conductor['ConClave'] = $InsConductor->ConClave;
				
				if(!empty($InsConductor->ConFoto)){
					
					$extension = strtolower(pathinfo($InsConductor->ConFoto, PATHINFO_EXTENSION));
					$nombre_base = basename($InsConductor->ConFoto, '.'.$extension);  
					
					$DatConductor->ConFoto = $nombre_base.'_thumb.'.$extension;
					
				}
				
				$Conductor['ConFoto'] = "http://".$_SERVER['SERVER_NAME']."/sistaxi114/subidos/conductor_fotos/".(empty($InsConductor->ConFoto)?'default.jpg':$InsConductor->ConFoto);

				$Conductor['ConEstado'] = $InsConductor->ConEstado;
				$Conductor['ConTiempoCreacion'] = date("Y-m-d H:i:s");
				$Conductor['ConTiempoModificacion'] = date("Y-m-d H:i:s");

				$l_stResult = $l_oProxy->MtdEditarConductor(json_encode($Conductor));


	*/
		}
		
		/*
		* SINCRINIZANDO CON SERVIDOR - FIN
		*/
		$Registro = true;
		$Resultado.='#SAS_CON_102';			
		FncCargarDatos();
		
	}else{			
	
		$Resultado.='#ERR_CON_102';		
		$InsConductor->ConBreveteFechaExpiracion = FncCambiaFechaANormal($InsConductor->ConBreveteFechaExpiracion,true);
		$InsConductor->ConFechaInicio = FncCambiaFechaANormal($InsConductor->ConFechaInicio,true);
		$InsConductor->ConFechaFin = FncCambiaFechaANormal($InsConductor->ConFechaFin,true);
		$InsConductor->ConCredencialTaxiFecha = FncCambiaFechaANormal($InsConductor->ConCredencialTaxiFecha,true);
		
		$InsConductor->VehSOATFecha = FncCambiaFechaANormal($InsConductor->VehSOATFecha,true);
		$InsConductor->VehRevisionTecnicaFecha = FncCambiaFechaANormal($InsConductor->VehRevisionTecnicaFecha,true);
			
	}				

}else{
	FncCargarDatos();
}

function FncCargarDatos(){

	global $GET_id;
	global $InsConductor;
	global $Identificador;
	
	$InsConductor->ConId = $GET_id;
	$InsConductor = $InsConductor->MtdObtenerConductor();	
	
	$_SESSION['SesConFoto'.$Identificador] = $InsConductor->ConFoto;
	
}

?>