<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');






$Destinatarios = "j.blanco@cisne.com.pe";
$Destinatarios = $TarNotificarCotizacionVehiculoResumen;
//$Destinatarios = "j.blanco@cisne.com.pe";

//$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Vista = ($_GET['Vista']);
$POST_Personal = ($_GET['Personal']);

$ArrFechaFin = explode("/",$POST_FechaFin);

list($DiaActual,$MesActual,$AnoActual) = explode("/",$POST_FechaFin);


if($ArrFechaFin[1]=="01"){
	$NuevoMes = 12;
	$NuevoAno = $AnoActual - 1;		
}else{
	$NuevoMes = $MesActual - 1;		
	$NuevoAno = $AnoActual;
	$NuevoMes  = str_pad($NuevoMes,2,0,STR_PAD_LEFT);
}

//$MesActual = $ArrFechaFin[1];
//$AnoActual = $ArrFechaFin[2];

$AnoAnterior = $AnoActual-1;
$AnoTrasAnterior = $AnoActual-2;

$FechaActualInicio = "01/".$MesActual."/".$AnoActual;

$FechaFinComparativoInicio = "01/".$NuevoMes."/".$NuevoAno;
$FechaFinComparativo =$DiaActual."/".$NuevoMes."/".$NuevoAno;

//$FechaFinComparativoAnterior = $DiaActual."/".$NuevoMes."/".$AnoAnterior;

$FechaFinComparativoAnoAnteriorInicio = "01/".$MesActual."/".$AnoAnterior;
$FechaFinComparativoAnoAnteriorFin = $DiaActual."/".$MesActual."/".$AnoAnterior;

$FechaFinComparativoTrasAnoTrasAnteriorInicio = "01/".$MesActual."/".$AnoTrasAnterior;
$FechaFinComparativoTrasAnoTrasAnteriorFin = $DiaActual."/".$MesActual."/".$AnoTrasAnterior;


//deb($POST_Mes);
if(empty($POST_VehiculoMarca)){
die("No ha escogido una marca de vehiculo");
} 




require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');


$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();



$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];



$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];


$Titulo = "";

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();

$Titulo =  " - ".$InsVehiculoMarca->VmaNombre;

echo "POST_FechaFin: ";
echo $POST_FechaFin ;
echo "<br>";
echo "<br>";

$ColorFondoCabecera = "#336699";
$ColorCabeceraTexto = "";

$mensaje .= "<style type='text/css'>";
$mensaje .= ".EstNegativo{	color:#F00;}";	
$mensaje .= ".EstCabecera{ background-color:#336699;	color:#FFFFFF;}";	
$mensaje .= "</style>";	


$mensaje .= "<b><u>RESUMEN DE COTIZACIONES DIARIO</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";

$mensaje .= "<b>Descripcion:</b> Resumen de cotizaciones de vehiculos por sucursal, por asesor y detallado por modelo";
$mensaje .= "<br>";	

$mensaje .= "<hr>";
$mensaje .= "<br>";
  

		
$TotalActual = 0;
$TotalAnterior = 0;
		
		
		
		$mensaje .= "<h2>";
		$mensaje .= "COTIZACIONES SOLO DEL DIA";
		$mensaje .= "</h2>";	
		
		
				
$mensaje .= "<table border='1' cellspacing='0' cellpadding='5'>";

$mensaje .= "<thead>";

$mensaje .= "<tr>";
$mensaje .= "<th class='EstCabecera' width='250'>";
$mensaje .= "SUCURSAL";
$mensaje .= "</th>";

$mensaje .= "<th class='EstCabecera' width='150'>";
$mensaje .= $FechaFinComparativo;
$mensaje .= "</th>";

$mensaje .= "<th class='EstCabecera' width='150'>";
$mensaje .= $POST_FechaFin;
$mensaje .= "</th>";

$mensaje .= "</tr>";

$mensaje .= "</thead>";

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		
		
	
		
		$CotizacionVehiculoTotal2 = 0;
		$CotizacionVehiculoAnteriorTotal2 = 0;
		
		if(!empty($ArrVehiculoModelos)){
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){
	
				//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL)
				$CotizacionVehiculoTotal2 += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaFin),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
				
				$CotizacionVehiculoAnteriorTotal2 += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativo),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
				 
			}
		}
		
		$mensaje .= "<tr>";		
				
		$mensaje .= "<td>";
		$mensaje .= $DatSucursal->SucNombre.":";
		$mensaje .= "</td>";   
		
		$TotalAnterior += $CotizacionVehiculoAnteriorTotal2;
		 
		$mensaje .= "<td align='center'>";
		$mensaje .= ($CotizacionVehiculoAnteriorTotal2);
		$mensaje .= "</td>";  
		
		 $TotalActual += $CotizacionVehiculoTotal2;
		 
		$mensaje .= "<td align='center'>";
		$mensaje .= ($CotizacionVehiculoTotal2);
		$mensaje .= "</td>";   
		
		
		$mensaje .= "</tr>";  	
	
	
	 
	
	}
}
	

					$mensaje .= "<tr>";  
					$mensaje .= "<td>";  
					
					$mensaje .= "<b>";  
					$mensaje .= "TOTAL:";
					$mensaje .= "</b>";  
					  
					$mensaje .= "</td>"; 
					
					$mensaje .= "<td align='center'>";
					$mensaje .= "<b>";  
					$mensaje .= $TotalAnterior; 
					$mensaje .= "</b>";  
					 
					$mensaje .= "</td>"; 
					
					$mensaje .= "<td align='center'>";
					$mensaje .= "<b>";  
					$mensaje .= $TotalActual;  
					$mensaje .= "</b>";  
					$mensaje .= "</td>"; 
	$mensaje .= "</table>";
					
					$mensaje .= "<br>";
					$mensaje .= "<br>";
					$mensaje .= "</hr>";
	

$mensaje .= "<hr>";






	
		
		$mensaje .= "<h2>";
		$mensaje .= "RESUMEN GENERAL";
		$mensaje .= "</h2>";	
		
		
		
		
$TotalActual = 0;
$TotalAnterior = 0;
		
		
		
$mensaje .= "<table border='1' cellspacing='0' cellpadding='5'>";

$mensaje .= "<thead>";

$mensaje .= "<tr>";
$mensaje .= "<th class='EstCabecera' width='250'>";
$mensaje .= "SUCURSAL";
$mensaje .= "</th>";

$mensaje .= "<th class='EstCabecera' width='150'>";
$mensaje .= $FechaFinComparativo;
$mensaje .= "</th>";

$mensaje .= "<th class='EstCabecera' width='150'>";
$mensaje .= $POST_FechaFin;
$mensaje .= "</th>";

$mensaje .= "</tr>";

$mensaje .= "</thead>";

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		
		
	
		
		$CotizacionVehiculoTotal = 0;
		$CotizacionVehiculoAnteriorTotal = 0;
		
		if(!empty($ArrVehiculoModelos)){
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){
	
				$CotizacionVehiculoTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
				
				$CotizacionVehiculoAnteriorTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
				 
			}
		}
		
		$mensaje .= "<tr>";		
				
		$mensaje .= "<td>";
		$mensaje .= $DatSucursal->SucNombre;
		$mensaje .= "</td>";   
		
		$TotalAnterior += $CotizacionVehiculoAnteriorTotal;
		 
		$mensaje .= "<td align='center'>";
		$mensaje .= ($CotizacionVehiculoAnteriorTotal);
		$mensaje .= "</td>";  
		
		 $TotalActual += $CotizacionVehiculoTotal;
		 
		$mensaje .= "<td align='center'>";
		$mensaje .= ($CotizacionVehiculoTotal);
		$mensaje .= "</td>";   
		
		
		$mensaje .= "</tr>";  	
	
	
	 
	
	}
}
	

					$mensaje .= "<tr>";  
					$mensaje .= "<td>";  
					
					$mensaje .= "<b>";  
					$mensaje .= "TOTAL:";
					$mensaje .= "</b>";  
					  
					$mensaje .= "</td>"; 
					
					$mensaje .= "<td align='center'>";
					$mensaje .= "<b>";  
					$mensaje .= $TotalAnterior; 
					$mensaje .= "</b>";  
					 
					$mensaje .= "</td>"; 
					
					$mensaje .= "<td align='center'>";
					$mensaje .= "<b>";  
					$mensaje .= $TotalActual;  
					$mensaje .= "</b>";  
					$mensaje .= "</td>"; 
	$mensaje .= "</table>";
					
					$mensaje .= "<br>";
					$mensaje .= "<br>";
					$mensaje .= "</hr>";
	

$mensaje .= "<hr>";


		
$mensaje .= "<br>";
//MtdObtenerCotizacionVehiculoPersonales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL) 
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculoPersonales(NULL,NULL,NULL,'PerNombre','ASC','',FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,$POST_VehiculoMarca);
$ArrCotizacionVehiculoPersonales = $ResCotizacionVehiculo['Datos'];


			$mensaje .= "<table border='1' cellspacing='0' cellpadding='5'>";
			
			$mensaje .= "<thead>";
			
			$mensaje .= "<tr>";
			$mensaje .= "<th class='EstCabecera' width='250'>";
			$mensaje .= "ASESOR DE VENTAS";
			$mensaje .= "</th>";
		
			$mensaje .= "<th class='EstCabecera' width='150'>";
			$mensaje .= $FechaFinComparativo;
			$mensaje .= "</th>";
			
			$mensaje .= "<th class='EstCabecera' width='150'>";
			$mensaje .= $POST_FechaFin;
			$mensaje .= "</th>";
			
			$mensaje .= "</tr>";
			
			$mensaje .= "</thead>";
			
			
			$TotalActual = 0;
			$TotalAnterior = 0;
			
			if(!empty($ArrCotizacionVehiculoPersonales)){
				foreach($ArrCotizacionVehiculoPersonales as $DatCotizacionVehiculoPersonal){
						
					$CotizacionVehiculoTotal = 0;
					$CotizacionVehiculoAnteriorTotal = 0;	
					
					if(!empty($ArrSucursales)){
						foreach($ArrSucursales as $DatSucursal){
//		
							if(!empty($ArrVehiculoModelos)){
								foreach($ArrVehiculoModelos as $DatVehiculoModelo){
									
									//Valor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
									$CotizacionVehiculoTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
									
									$CotizacionVehiculoAnteriorTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
								
									
								}
							}
//						
						}
					}
					  
					  $mensaje .= "<tr>";		
			
						$mensaje .= "<td>";
						$mensaje .= $DatCotizacionVehiculoPersonal->PerNombre." ".$DatCotizacionVehiculoPersonal->PerApellidoPaterno." ".$DatCotizacionVehiculoPersonal->PerApellidoMaterno;
						$mensaje .= "</td>";   
						
						 $TotalAnterior += $CotizacionVehiculoAnteriorTotal;
						 
						$mensaje .= "<td align='center'>";
						$mensaje .= ($CotizacionVehiculoAnteriorTotal);
						$mensaje .= "</td>";  
						
						 $TotalActual += $CotizacionVehiculoTotal;
						 
						$mensaje .= "<td align='center'>";
						$mensaje .= ($CotizacionVehiculoTotal);
						$mensaje .= "</td>";   
						  
					$mensaje .= "</tr>";  	
											
				
				}
			}

	
		  
			$mensaje .= "<tr>";  
			$mensaje .= "<td>";  
			
			$mensaje .= "<b>";  
			$mensaje .= "TOTAL:";
			$mensaje .= "</b>";  
			  
			$mensaje .= "</td>"; 
			
			$mensaje .= "<td align='center'>";
			$mensaje .= "<b>";  
			$mensaje .= $TotalAnterior; 
			$mensaje .= "</b>";  
			 
			$mensaje .= "</td>"; 
			
			$mensaje .= "<td align='center'>";
			$mensaje .= "<b>";  
			$mensaje .= $TotalActual;  
			$mensaje .= "</b>";  
			$mensaje .= "</td>"; 
			
			$mensaje .= "</tr>";  	
							 
			
			$mensaje .= "</table>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "</hr>";

	



$mensaje .= "<hr>";


if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		
		$mensaje .= "<h2>";
		$mensaje .= "SUCURSAL: ".$DatSucursal->SucNombre;
		$mensaje .= "</h2>";
		
		//$mensaje .= "<br>";
		$mensaje .= "<br>";
		//MtdObtenerCotizacionVehiculoPersonales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL) 
		$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculoPersonales(NULL,NULL,NULL,'PerNombre','ASC','',FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($POST_FechaFin),$DatSucursal->SucId,$POST_VehiculoMarca);
		$ArrCotizacionVehiculoPersonales = $ResCotizacionVehiculo['Datos'];
		
		//deb($ArrCotizacionVehiculoPersonales );
		
		if(!empty($ArrCotizacionVehiculoPersonales)){
			foreach($ArrCotizacionVehiculoPersonales as $DatCotizacionVehiculoPersonal){
					
				$mensaje .= "<h3>";
				$mensaje .= "Asesor de Ventas: ".$DatCotizacionVehiculoPersonal->PerNombre." ".$DatCotizacionVehiculoPersonal->PerApellidoPaterno." ".$DatCotizacionVehiculoPersonal->PerApellidoMaterno;
				$mensaje .= "</h3>";
				
				//$mensaje .= "<br>";
					
					
						//$TotalSucursalActual = 0;
					//$TotalSucursalAnterior = 0;
					//$TotalSucursalActual = array();
					//$TotalSucursalAnterior = array();
					//$CotizacionVehiculoSumaTotal = array();
					
					//$CotizacionVehiculoVersionAnteriorSumaTotal = array();
					//$CotizacionVehiculoVersionSumaTotal = array();
						 
					
					
					$mensaje .= "<table border='1' cellspacing='0' cellpadding='5'>";
					
					$mensaje .= "<thead>";
					
					$mensaje .= "<tr>";
					$mensaje .= "<th class='EstCabecera' width='250'>";
					$mensaje .= "MODELO";
					$mensaje .= "</th>";
				
					$mensaje .= "<th class='EstCabecera' width='150'>";
					$mensaje .= $FechaFinComparativo;
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera' width='150'>";
					$mensaje .= $POST_FechaFin;
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera' width='100'>";
					$mensaje .= "VAR Q";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera' width='100'>";
					$mensaje .= "VAR %";
					$mensaje .= "</th>";
					
					$mensaje .= "</tr>";
					
					$mensaje .= "</thead>";
					
					$TotalActual = 0;
					$TotalAnterior = 0;
					
					if(!empty($ArrVehiculoModelos)){
						foreach($ArrVehiculoModelos as $DatVehiculoModelo){
				
		//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL)
							
							//deb("F1: ".$FechaActualInicio." ".$POST_FechaFin);
							//deb("F2: ".$FechaFinComparativoInicio." ".$FechaFinComparativo);
							//deb($DatVehiculoModelo->VmoId." - ".$DatSucursal->SucId." - ".$DatCotizacionVehiculoPersonal->PerId,NULL);
							
							$CotizacionVehiculoTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
							
							$CotizacionVehiculoAnteriorTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
							 
							 
							 //$TotalSucursalActual[$DatSucursal->SucId] += $CotizacionVehiculoTotal;
							 //$TotalSucursalAnterior[$DatSucursal->SucId] += $CotizacionVehiculoAnteriorTotal;
							 							 
							 //$CotizacionVehiculoSumaTotal[$DatSucursal->SucId] += $CotizacionVehiculoTotal;
							 
							//$CotizacionVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId] += $CotizacionVehiculoTotal;
							//$CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId] += $CotizacionVehiculoAnteriorTotal;
											 

							//if($CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]>0 || $CotizacionVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId]>0){
								if($CotizacionVehiculoTotal>0 || $CotizacionVehiculoAnteriorTotal>0){
					
							
							$mensaje .= "<tr>";		
							
								$mensaje .= "<td>";
								$mensaje .= $DatVehiculoModelo->VmoNombre;
								$mensaje .= "</td>";   
								
								 $TotalAnterior += $CotizacionVehiculoAnteriorTotal;
								 
								$mensaje .= "<td align='center'>";
								$mensaje .= ($CotizacionVehiculoAnteriorTotal);
								$mensaje .= "</td>";  
								
								 $TotalActual += $CotizacionVehiculoTotal;
								 
								$mensaje .= "<td align='center'>";
								$mensaje .= ($CotizacionVehiculoTotal);
								$mensaje .= "</td>";   
								  
								 $Diferencia = $CotizacionVehiculoTotal - $CotizacionVehiculoAnteriorTotal;
									 
									 if($CotizacionVehiculoAnteriorTotal>0){
										 
										 $PorcentajeVariacion = (($CotizacionVehiculoTotal - $CotizacionVehiculoAnteriorTotal) / $CotizacionVehiculoAnteriorTotal);
										$PorcentajeVariacion = $PorcentajeVariacion * 100;
										 $PorcentajeVariacion = round($PorcentajeVariacion,2);
										 
									 }else{
										  $PorcentajeVariacion = 0;
									 }
								
								$mensaje .= "<td align='right'>";
									 
									  if($Diferencia>0){
										
										
										 
									$mensaje .= "<b>";  	
								$mensaje .= $Diferencia;
								$mensaje .= "</b>"; 
									
									
									 }elseif($Diferencia<0){
										
										
										 $mensaje .= "<span class='EstNegativo'>";
									$mensaje .= "<b>";  	
								$mensaje .= $Diferencia;
								$mensaje .= "</b>"; 
									$mensaje .= "</span>";
									
									
									
									
									 }
									 
								
								$mensaje .= "</td>";  
							
								
										$mensaje .= "<td align='right'>";
									 
									 if($PorcentajeVariacion>0){
									
										//$mensaje .= ">>>";	
										$mensaje .= $PorcentajeVariacion." %";
										
									 }elseif($PorcentajeVariacion<0){
										 
										//$mensaje .= "<<<";	
										//$mensaje .= $PorcentajeVariacion." %";
										
										
											$mensaje .= "<span class='EstNegativo'>";
										$mensaje .= $PorcentajeVariacion." %";
										$mensaje .= "</span>";
										
										
									 }else{
										
									 }
								
								$mensaje .= "</td>";  
								
							$mensaje .= "</tr>";  	
									 
					
							}
							
						}
					}
				  
					$mensaje .= "<tr>";  
					$mensaje .= "<td>";  
					
					$mensaje .= "<b>";  
					$mensaje .= "TOTAL:";
					$mensaje .= "</b>";  
					  
					$mensaje .= "</td>"; 
					
					$mensaje .= "<td align='center'>";
					$mensaje .= "<b>";  
					$mensaje .= $TotalAnterior; 
					$mensaje .= "</b>";  
					 
					$mensaje .= "</td>"; 
					
					$mensaje .= "<td align='center'>";
					$mensaje .= "<b>";  
					$mensaje .= $TotalActual;  
					$mensaje .= "</b>";  
					$mensaje .= "</td>"; 
					
					
									 $Diferencia = $TotalActual - $TotalAnterior;
									 
									 if($TotalAnterior>0){
										 
										 $PorcentajeVariacion = (($TotalActual - $TotalAnterior) / $TotalAnterior);
										$PorcentajeVariacion = $PorcentajeVariacion * 100;
										 $PorcentajeVariacion = round($PorcentajeVariacion,2);
										 
									 }else{
										  $PorcentajeVariacion = 0;
									 }
									 
									 
				$mensaje .= "<td align='right'>";
									 
									  if($Diferencia>0){
										
										
									$mensaje .= "<b>";  	
								$mensaje .= $Diferencia;
								$mensaje .= "</b>"; 
								
										
									 }elseif($Diferencia<0){
										 $mensaje .= "<span class='EstNegativo'>";
									$mensaje .= "<b>";  	
								$mensaje .= $Diferencia;
								$mensaje .= "</b>"; 
									$mensaje .= "</span>";
										
									 }
								
										
								$mensaje .= "</td>";  
								
								
						$mensaje .= "<td align='right' >";
									 $mensaje .= "<b>";  
									 if($PorcentajeVariacion>0){
									
										//$mensaje .= ">>> ";	
										$mensaje .= $PorcentajeVariacion." %";
										
									 }elseif($PorcentajeVariacion<0){
										 
										//$mensaje .= "<<< ";	
										
										$mensaje .= "<span class='EstNegativo'>";
										$mensaje .= $PorcentajeVariacion." %";
										$mensaje .= "</span>";
									
									 }else{
										
									 }
								$mensaje .= "</b>";  
								$mensaje .= "</td>";  
								
							$mensaje .= "</tr>";  	
									 
					
					$mensaje .= "</table>";
					
					$mensaje .= "<br>";
					$mensaje .= "<br>";
					$mensaje .= "</hr>";
	
			}
		}
	
	
	}
}
	

  
  $mensaje .= "<br>";
  $mensaje .= "<br>";
  $mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
  
  echo $mensaje;
  
 $Enviar = true;
//	$Enviar = false;
//	echo "NOTIFICACION: RESUMEN DE COTIZACIONES DE VEHICULOS DIARIO ".$Titulo;
	
  if($Enviar){
	  
	  $InsCorreo = new ClsCorreo();	
	 $InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: RESUMEN DE COTIZACIONES DE VEHICULOS DIARIO ".$Titulo,$mensaje);
	  
  }
				
				
	
	
	
?>