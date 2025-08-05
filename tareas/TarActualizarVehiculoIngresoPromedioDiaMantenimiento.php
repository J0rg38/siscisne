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




require_once($InsPoo->MtdPaqReporte().'ClsReporteVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoIngresoPredictivo.php');

$InsReporteVehiculoIngreso = new ClsReporteVehiculoIngreso();
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoIngresoPredictivo = new ClsVehiculoIngresoPredictivo();



$ResReporteVehiculoIngreso = $InsReporteVehiculoIngreso->MtdObtenerVehiculoIngresoPromedioDiaMantenimiento(NULL,NULL,NULL ,"fin.FinFecha","ASC","");
$ArrReporteVehiculoIngresos = $ResReporteVehiculoIngreso['Datos'];

$f = 1;

if(!empty($ArrReporteVehiculoIngresos)){
	foreach($ArrReporteVehiculoIngresos as $DatReporteVehiculoIngreso){
		
		echo "COD. VEHICULO INGRESO: ";
		echo $DatReporteVehiculoIngreso->EinId;
		echo "<br>";
		
		echo "Fila: ";
		echo $f;
		echo "<br>";
		
		echo "SucNombre: ";
		echo $DatReporteVehiculoIngreso->SucNombre;
		echo "<br>";
		
			echo "SucId: ";
		echo $DatReporteVehiculoIngreso->SucId;
		echo "<br>";
		
		echo "EinVIN: ";
		echo $DatReporteVehiculoIngreso->EinVIN;
		echo "<br>";
		
		echo "EinFichaIngresoFechaUltimo: ";
		echo $DatReporteVehiculoIngreso->EinFichaIngresoFechaUltimo;
		echo "<br>";
		
		echo "EinFichaIngresoMantenimientoKilometrajeUltimo: ";
		echo $DatReporteVehiculoIngreso->EinFichaIngresoMantenimientoKilometrajeUltimo;
		echo "<br>";
		
		echo "EinFichaIngresoFechaPredecida: ";
		echo $DatReporteVehiculoIngreso->EinFichaIngresoFechaPredecida;
		echo "<br>";
		
		if($DatReporteVehiculoIngreso->EinPromedioDiaMantenimiento>=0){
			
			$SucursalSiglas = $DatReporteVehiculoIngreso->SucSiglas;
			
			$InsVehiculoIngresoPredictivo = new ClsVehiculoIngresoPredictivo();
			$InsVehiculoIngresoPredictivo->EinId = $DatReporteVehiculoIngreso->EinId;
			$InsVehiculoIngresoPredictivo->SucId = $DatReporteVehiculoIngreso->SucId;
			$InsVehiculoIngresoPredictivo->CliId = $DatReporteVehiculoIngreso->CliId;
			
			$InsVehiculoIngresoPredictivo->VipFichaIngresoFechaPredecida = $DatReporteVehiculoIngreso->EinFichaIngresoFechaPredecida;
			$InsVehiculoIngresoPredictivo->VipFichaIngresoFechaUltimo = $DatReporteVehiculoIngreso->EinFichaIngresoFechaUltimo;
			$InsVehiculoIngresoPredictivo->VipFichaIngresoMantenimientoKilometrajeUltimo = $DatReporteVehiculoIngreso->EinFichaIngresoMantenimientoKilometrajeUltimo;
			$InsVehiculoIngresoPredictivo->VipPromedioDiaMantenimiento = $DatReporteVehiculoIngreso->EinPromedioDiaMantenimiento;
			
			$InsVehiculoIngresoPredictivo->VipObservacionImpresa = NULL;
			$InsVehiculoIngresoPredictivo->VipObservacionInterna = "Autogenerado ".date("d/m/Y H:i:s");
			$InsVehiculoIngresoPredictivo->VipEstado = 1;
			$InsVehiculoIngresoPredictivo->VipTiempoCreacion = date("Y-m-d H:i:s");
			$InsVehiculoIngresoPredictivo->VipTiempoModificacion = date("Y-m-d H:i:s");
			
			if($InsVehiculoIngresoPredictivo->MtdRegistrarVehiculoIngresoPredictivo()){
							
				echo " Se actualizo promedio dia mantenimiento correctamente.";
				echo "<br>";
			}else{
				echo " No se pudieron actualizar promedio dia mantenimiento. PROCESO CANCELADO";
				echo "<br>";
			}
			
		}
		
		
		if($InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinPromedioDiaMantenimiento",$DatReporteVehiculoIngreso->EinPromedioDiaMantenimiento,$DatReporteVehiculoIngreso->EinId)){
			
			$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFichaIngresoFechaUltimo",$DatReporteVehiculoIngreso->EinFichaIngresoFechaUltimo,$DatReporteVehiculoIngreso->EinId);
			$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFichaIngresoMantenimientoKilometrajeUltimo",$DatReporteVehiculoIngreso->EinFichaIngresoMantenimientoKilometrajeUltimo,$DatReporteVehiculoIngreso->EinId);
			$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFichaIngresoFechaPredecida",$DatReporteVehiculoIngreso->EinFichaIngresoFechaPredecida,$DatReporteVehiculoIngreso->EinId);
						
			echo " Se actualizo promedio dia mantenimiento correctamente.";
			echo "<br>";
		}else{
			echo " No se pudieron actualizar promedio dia mantenimiento. PROCESO CANCELADO";
			echo "<br>";
		}
		
		$f++;
		echo "<br>";
		
	}
}

echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>