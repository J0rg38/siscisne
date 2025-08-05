<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsAlmacenCierre->AciId = $_POST['CmpId'];
	$InsAlmacenCierre->PerId = $_POST['CmpPersonal'];
	$InsAlmacenCierre->AciFechaInicio = FncCambiaFechaAMysql($_POST['CmpFechaInicio']);
	$InsAlmacenCierre->AciFechaFin = FncCambiaFechaAMysql($_POST['CmpFechaFin']);
	
	$InsAlmacenCierre->AciEntradasTotalCompras = eregi_replace(",","",(empty($_POST['CmpEntradasTotalCompras'])?0:$_POST['CmpEntradasTotalCompras']));
	$InsAlmacenCierre->AciEntradasTotalOtrasFichas = eregi_replace(",","",(empty($_POST['CmpEntradasTotalOtrasFichas'])?0:$_POST['CmpEntradasTotalOtrasFichas']));
	$InsAlmacenCierre->AciEntradasTotalTransferencias = eregi_replace(",","",(empty($_POST['CmpEntradasTotalTransferencias'])?0:$_POST['CmpEntradasTotalTransferencias']));
	$InsAlmacenCierre->AciEntradasTotalConversiones = eregi_replace(",","",(empty($_POST['CmpEntradasTotalConversiones'])?0:$_POST['CmpEntradasTotalConversiones']));
	
	$InsAlmacenCierre->AciSalidasTotalFichaIngresos = eregi_replace(",","",(empty($_POST['CmpSalidasTotalFichaIngresos'])?0:$_POST['CmpSalidasTotalFichaIngresos']));
	$InsAlmacenCierre->AciSalidasTotalVentaConcretadas = eregi_replace(",","",(empty($_POST['CmpSalidasTotalVentaConcretadas'])?0:$_POST['CmpSalidasTotalVentaConcretadas']));
	$InsAlmacenCierre->AciSalidasTotalOtrasFichas = eregi_replace(",","",(empty($_POST['CmpSalidasTotalOtrasFichas'])?0:$_POST['CmpSalidasTotalOtrasFichas']));
	$InsAlmacenCierre->AciSalidasTotalTransferencias = eregi_replace(",","",(empty($_POST['CmpSalidasTotalTransferencias'])?0:$_POST['CmpSalidasTotalTransferencias']));
	$InsAlmacenCierre->AciSalidasTotalConversiones = eregi_replace(",","",(empty($_POST['CmpSalidasTotalConversiones'])?0:$_POST['CmpSalidasTotalConversiones']));
	
	$InsAlmacenCierre->AciEstado = 3;
	$InsAlmacenCierre->AciObservacion = addslashes($_POST['CmpObservacion']);
	$InsAlmacenCierre->AciTiempoModificacion = date("Y-m-d H:i:s");
				
			
		if($InsAlmacenCierre->MtdEditarAlmacenCierre()){		
			$Edito = true;			
			$Resultado.='#SAS_ACI_102';		
			FncCargarDatos();	
		}else{			
			
			$InsAlmacenCierre->AciFechaInicio = FncCambiaFechaANormal($InsAlmacenCierre->AciFechaInicio);
			$InsAlmacenCierre->AciFechaFin = FncCambiaFechaANormal($InsAlmacenCierre->AciFechaFin);
		
			$Resultado.='#ERR_ACI_102';		
		}			
			
	
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsAlmacenCierre;
	global $Identificador;
		
	$InsAlmacenCierre->AciId = $GET_id;
	$InsAlmacenCierre->MtdObtenerAlmacenCierre();			
	
}
?>