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



$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];

require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsReporteProducto = new ClsReporteProducto();
$InsProducto = new ClsProducto();

//MtdObtenerReporteProductoVentasPromedio($oProductoId,$oFecha=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oDiasAtras=365)
//$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentasPromedio(NULL,NULL,"RprPromedioMensual","ASC",NULL,NULL,365);
//$ArrReporteProductos = $ResReporteProducto['Datos'];

//MtdObtenerReporteProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL) {
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductos("ProCodigoOriginal","esigual",$GET_ProductoCodigoOriginal,"ProNombre","ASC","",NULL,NULL);
$ArrReporteProductos = $ResReporteProducto['Datos'];

//MtdObtenerReporteProductoMaximo
$SalidaTotalAnualMaximo = $InsReporteProducto->MtdObtenerReporteProductoMaximo("pro.ProSalidaTotalAnual",NULL,NULL);
$SalidaTotalAnualMaximo = (empty($SalidaTotalAnualMaximo)?0:$SalidaTotalAnualMaximo);

echo "<b>SalidaTotalAnualMaximo:</b>";
echo $SalidaTotalAnualMaximo;
echo "<br>";

$LimiteA = (($SalidaTotalAnualMaximo * 1)/100);
$LimiteB = (($SalidaTotalAnualMaximo * 3)/100);
$LimiteC = (($SalidaTotalAnualMaximo * 5)/100);
$LimiteD = (($SalidaTotalAnualMaximo * 91)/100);

echo "<b>LimiteA:</b>";
echo $LimiteA;
echo "<br>";

echo "<b>LimiteB:</b>";
echo $LimiteB;
echo "<br>";

echo "<b>LimiteC:</b>";
echo $LimiteC;
echo "<br>";

echo "<b>LimiteD:</b>";
echo $LimiteD;
echo "<br>";
echo "<br>";


echo "<b>CAT A: </b>";
echo "VARIABLE > ".$LimiteC." Y VARIABLE <= ".$SalidaTotalAnualMaximo;
echo "<br>";

echo "<b>CAT B :</b>";
echo "VARIABLE > ".$LimiteB." Y VARIABLE <= ".$LimiteC;
echo "<br>";

echo "<b>CAT C: </b>";
echo "VARIABLE > ".$LimiteA." Y VARIABLE <= ".$LimiteB;
echo "<br>";

echo "<b>CAT D: </b>";
echo "VARIABLE >0 Y VARIABLE <= ".$LimiteA;
echo "<br>";
echo "<br>";




////1000  100
////x    40
//400
//300
//100
//50

//$TotalVentas = 0;
//
//if(!empty($ArrReporteProductos)){
//	foreach($ArrReporteProductos as $DatReporteProducto){
//		
//		//$TotalVentas += $DatReporteProducto->ProSalidaTotalAnualMonto;
//		$TotalVentas += $DatReporteProducto->ProSalidaTotalAnual;
//
//	}
//}

if(!empty($ArrReporteProductos)){
	foreach($ArrReporteProductos as $DatReporteProducto){
		
		echo "<b>COD. ORIGNAL:</b> ";
		echo $DatReporteProducto->ProCodigoOriginal;
		echo "<br>";
	
			
			echo "<b>SALIDA ANUAL:</b> ";
			echo $DatReporteProducto->ProSalidaTotalAnual;
			echo "<br>";
			
//			echo "<b>SALIDA SEMESTRAL:</b> ";
//			echo $DatReporteProducto->ProSalidaTotalSemestral;
//			echo "<br>";
//			
//			echo "<b>SALIDA TRIMESTRAL:</b> ";
//			echo $DatReporteProducto->ProSalidaTotalTrimestral;
//			echo "<br>";
//			
//			echo "<b>SALIDA MENSUAL:</b> ";
//			echo $DatReporteProducto->ProSalidaTotalMensual;
//			echo "<br>";
			
	//		echo "<b>SALIDA ANUAL MONTO:</b> ";
	//		echo $DatReporteProducto->ProSalidaTotalAnualMonto;
	//		echo "<br>";
		
		$PromedioABC = "";
		$Porcentaje = 0;
		
		if($DatReporteProducto->ProSalidaTotalAnual>0){

//			$LimiteA = ($SalidaTotalAnualMaximo * 40)/100;
//			$LimiteB = ($SalidaTotalAnualMaximo * 30)/100;
//			$LimiteC = ($SalidaTotalAnualMaximo * 10)/100;
//			$LimiteD = ($SalidaTotalAnualMaximo * 5)/100;
			
//			//1000  100
//			//x    40
//			
//			400
//			300
//			100
//			50



//echo "<b>CAT A: </b>";
//echo $DatReporteProducto->ProSalidaTotalAnual." > ".$LimiteC." AND ".$DatReporteProducto->ProSalidaTotalAnual." <= ".$SalidaTotalAnualMaximo;
//echo "<br>";
//
//echo "<b>CAT B :</b>";
//echo $DatReporteProducto->ProSalidaTotalAnual." > ".$LimiteB." AND ".$DatReporteProducto->ProSalidaTotalAnual." <= ".$LimiteC;
//echo "<br>";
//
//echo "<b>CAT C: </b>";
//echo $DatReporteProducto->ProSalidaTotalAnual." > ".$LimiteA." AND ".$DatReporteProducto->ProSalidaTotalAnual." <= ".$LimiteB;
//echo "<br>";
//
//echo "<b>CAT D: </b>";
//echo $DatReporteProducto->ProSalidaTotalAnual." >0 Y ".$DatReporteProducto->ProSalidaTotalAnual." <= ".$LimiteA;
//echo "<br>";
//echo "<br>";


			if($DatReporteProducto->ProSalidaTotalAnual==0){

				$PromedioABC = "D";
				
				
			}else if($DatReporteProducto->ProSalidaTotalAnual<=1){
				
				$PromedioABC = "C";
				
			}else if($DatReporteProducto->ProSalidaTotalAnual>2 and $DatReporteProducto->ProSalidaTotalAnual<=3){
			
				$PromedioABC = "B";
				
			}else if ($DatReporteProducto->ProSalidaTotalAnual>3){
			
				$PromedioABC = "A";
			}else{
					$PromedioABC = "X";
			}
			

//			if($DatReporteProducto->ProSalidaTotalAnual>$LimiteC and $DatReporteProducto->ProSalidaTotalAnual<=$SalidaTotalAnualMaximo){
//
//				$PromedioABC = "A";
//				
//				
//			}else if($DatReporteProducto->ProSalidaTotalAnual>$LimiteB and $DatReporteProducto->ProSalidaTotalAnual<=$LimiteC){
//
//				$PromedioABC = "B";
//				
//
//			}else if($DatReporteProducto->ProSalidaTotalAnual>$LimiteA and $DatReporteProducto->ProSalidaTotalAnual<=$LimiteB){
//
//				$PromedioABC = "C";
//				
//
//			}else if($DatReporteProducto->ProSalidaTotalAnual>=0 and $DatReporteProducto->ProSalidaTotalAnual<=$LimiteA){
//
//				$PromedioABC = "D";
//				
//
//			}
			
//			
//			echo "VARIABLE > ".$LimiteC." Y VARIABLE <= ".$SalidaTotalAnualMaximo;
//echo "<br>";
//echo "VARIABLE > ".$LimiteB." Y VARIABLE <= ".$LimiteC;
//echo "<br>";
//echo "VARIABLE > ".$LimiteA." Y VARIABLE <= ".$LimiteB;
//echo "<br>";
//echo "VARIABLE >0 Y VARIABLE <= ".$LimiteA;
//echo "<br>";
//echo "<br>";



			//$Porcentaje = ($DatReporteProducto->ProSalidaTotalAnual / $TotalVentas);
//			$Porcentaje = $Porcentaje * 100;
//			$Porcentaje = round($Porcentaje,2);
//						
//			if($Porcentaje>40){
//				$PromedioABC = "A";
//			}else if($Porcentaje>30){
//				$PromedioABC = "B";
//			}else if($Porcentaje>20){
//				$PromedioABC = "C";
//			}else if($Porcentaje>0){
//				$PromedioABC = "D";
//			}
			
		}else{
			$PromedioABC = "O";
		}
		
		$InsProducto->MtdEditarProductoDato("ProABCInterno",$PromedioABC,$DatReporteProducto->ProId);
		
		echo "<b>TOTAL SALIDAS GENERAL:</b> ";
		echo $TotalVentas;
		echo "<br>";
		
		echo "<b>PORCENTAJE:</b> ";
		echo $Porcentaje ;
		echo "<br>";
			
		echo "<b>PROMABC:</b> ";
		echo $PromedioABC;
		echo "<br>";
	
		echo "<br>";
		
	}
}

echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>