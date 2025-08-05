<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}


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




require_once($InsPoo->MtdPaqReporte().'ClsReporteCOS.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFacturacion.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOS.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursalDatoReporte.php');

//$GET_VehiculoMarcaId = (empty($_GET['VehiculoMarcaId'])?"VMA-10017":$_GET['VehiculoMarcaId']);
$GET_Ano = (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);
$GET_Mes = (empty($_GET['Mes'])?date("m"):$_GET['Mes']);
$GET_VehiculoMarca = (empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca']);
$GET_Sucursal = (empty($_GET['Sucursal'])?(($_SESSION['SesionSucursal'])):$_GET['Sucursal']);

if(empty($GET_VehiculoMarca) or empty($GET_Ano) or empty($GET_Mes)){
	die("No se ha especificado el año, mes o marca de vehiculo.");
}


$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsSucursalDatoReporte = new ClsSucursalDatoReporte();
$InsFichaIngreso = new ClsFichaIngreso();

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoMarca->VmaId = $GET_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();





$InsSucursal = new ClsSucursal();
$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

//MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
?>

<form method="get" name="FrmTarea" id="FrmTarea" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>">


Sucursal:
<select name="Sucursal" id="Sucursal">

<?php
if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
?>
	<option <?php echo (($DatSucursal->SucId==$GET_Sucursal)?'selected="selected"':'');?>  value="<?php echo $DatSucursal->SucId;?>"><?php echo $DatSucursal->SucNombre;?></option>
<?php
	}
}
?>
</select>
Marca:
<select name="VehiculoMarca" id="VehiculoMarca">

<?php
if(!empty($ArrVehiculoMarcas)){
	foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
?>
	<option <?php echo (($DatVehiculoMarca->VmaId==$GET_VehiculoMarca)?'selected="selected"':'');?> value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
<?php
	}
}
?>
</select>

Año:

<select class="EstFormularioCombo" name="Ano" id="Ano">
                    <?php
				for($i=2013;$i<=date("Y");$i++){
				?>
                    <option <?php echo ($i==$GET_Ano?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php	
				}
				?>
                    </select>
                    
Mes:
<?php
			switch($GET_Mes){
				case "01":
					$OptMes1 =  'selected="selected"';
				break;
				case "02":
					$OptMes2 =  'selected="selected"';
				break;
				case "03":
					$OptMes3 =  'selected="selected"';
				break;
				case "04":
					$OptMes4 =  'selected="selected"';
				break;
				case "05":
					$OptMes5 =  'selected="selected"';
				break;
				case "06":
					$OptMes6 =  'selected="selected"';
				break;
				case "07":
					$OptMes7 =  'selected="selected"';
				break;				
				case "08":
					$OptMes8 =  'selected="selected"';
				break;
				case "09":
					$OptMes9 =  'selected="selected"';
				break;
				case "10":
					$OptMes10 =  'selected="selected"';
				break;
				case "11":
					$OptMes11 =  'selected="selected"';
				break;	
				case "12":
					$OptMes12 =  'selected="selected"';
				break;	
				default:
					$OptMes1 =  'selected="selected"';
				break;																																					
			}
			?>
            
            
            <select class="EstFormularioCombo" name="Mes" id="Mes">
                  <option <?php echo $OptMes1;?> value="01">Enero</option>
                  <option <?php echo $OptMes2;?> value="02">Febrero</option>
                  <option <?php echo $OptMes3;?> value="03">Marzo</option>
                  <option <?php echo $OptMes4;?> value="04">Abril</option>
                  <option <?php echo $OptMes5;?> value="05">Mayo</option>
                  <option <?php echo $OptMes6;?> value="06">Junio</option>
                  <option <?php echo $OptMes7;?> value="07">Julio</option>
                  <option <?php echo $OptMes8;?> value="08">Agosto</option>
                  <option <?php echo $OptMes9;?> value="09">Setiembre</option>
                  <option <?php echo $OptMes10;?> value="10">Octubre</option>
                  <option <?php echo $OptMes11;?> value="11">Noviembre</option>
                  <option <?php echo $OptMes12;?> value="12">Diciembre</option>
                </select>
                <input type="submit" name="BtnEnviar" id="BtnEnviar" value="Enviar" />
       </form>         
                                
<?php
/*if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
?>


		<a href="<?php echo $_SERVER['PHP_SELF'];?>?Ano=<?php echo $GET_Ano;?>&Mes=<?php echo $GET_Mes;?>&VehiculoMarca=<?php echo $GET_VehiculoMarca;?>&Sucursal=<?php echo $DatSucursal->SucId;?>">
        <?php echo $DatSucursal->SucNombre;?> 
        </a> |
<?php	
		
	}
}*/


$InsSucursal = new ClsSucursal();
$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$GET_Sucursal,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		
		
		//MtdObtenerSucursalDatoReportes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'SdrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oVehiculoMarca=NULL)
		$ResSucursalDatoReporte = $InsSucursalDatoReporte->MtdObtenerSucursalDatoReportes(NULL,NULL,'SdrId','Desc','1',$GET_Sucursal,$GET_VehiculoMarca);
		$ArrSucursalDatoReportes = $ResSucursalDatoReporte['Datos'];
		
		$PersonalAsesoresServicio = 0;
		$PersonalTecnicos = 0;
		$PersonalOtros = 0;
		$TarifaManoObra = 0;
		//deb($ArrSucursalDatoReportes );
		if(!empty($ArrSucursalDatoReportes)){
			foreach($ArrSucursalDatoReportes as $DatSucursalDatoReporte){
				
				$PersonalAsesoresServicio = $DatSucursalDatoReporte->SdrPersonalAsesoresServicio;
				$PersonalTecnicos = $DatSucursalDatoReporte->SdrPersonalTecnicos;
				$PersonalOtros = $DatSucursalDatoReporte->SdrPersonalOtros;
				$TarifaManoObra = $DatSucursalDatoReporte->SdrTarifaManoObra;
				
				
			}
		}
		
		
		echo "<br>";
		echo "<br>";
		
		echo "Sucursal: ".$DatSucursal->SucNombre;		
		echo "<br>";
		
		$InsReporteCOS = new ClsReporteCOS();
		//MtdObtenerReporteCOSs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
		$ResReporteCOS = $InsReporteCOS->MtdObtenerReporteCOSs(NULL,NULL,NULL,'RcoId','Desc','1',$GET_Ano,$GET_Mes,$GET_VehiculoMarca,$DatSucursal->SucId);
		$ArrReporteCOSs = $ResReporteCOS['Datos'];
		
		$ReporteCOSId = "";
		
		if(!empty($ArrReporteCOSs)){
			foreach($ArrReporteCOSs as $DatReporteCOS){
				$ReporteCOSId = $DatReporteCOS->RcoId;
			}
		}
		
		echo "Marca Id: ".$InsVehiculoMarca->VmaNombre;
		echo "<br>";
		echo "Año: ".$GET_Ano;
		echo "<br>";
		echo "Mes: ".$GET_Mes ;
		echo "<br>";	
		echo "Id: ".$ReporteCOSId ;
		echo "<br>";	
				
		/*
		* CONTROL DE UNIDADES INGRESADAS
		*/
		
		$RcoIngresoPrimeraRevision = 0;
		
		$RcoIngresoServicio1000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",1000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio1500 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",1500,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio5000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",5000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio10000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",10000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio15000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",15000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio20000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",20000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio25000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",25000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio30000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",30000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio35000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",35000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio40000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",40000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio45000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",45000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio50000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",50000,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicio50000Mas = 0;
		
		foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                   
			if($DatKilometro['km']>50000){
			
				 for($mes=1;$mes<=$GET_Mes;$mes++){
			   				
////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
					$RcoIngresoServicio50000Mas += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
				  
				}
			   
			}
                       	
        }
         
		
		$RcoIngresoServicioReparaciones = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10003,MIN-10019,MIN-10020,MIN-10021",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,true,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicioPlanchadoPintado = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10004",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,true,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicioTrabajoInterno = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngreseServicioGarantias = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10000",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicioInstalacionAccesorios = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10009",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicioReingresos = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
		
		$RcoIngresoServicioInstalacionGLP = 0;
		
		$RcoIngresoServicioSuperCambio99 = 0;	
		
		//$RcoIngresoServicioReingresos = 0;	
        
		
		$RcoTotalIngresosUnidadesMantenimiento = $RcoIngresoPrimeraRevision 
		
		+ $RcoIngresoServicio1000
		+ $RcoIngresoServicio1500
		
		+ $RcoIngresoServicio5000
		+ $RcoIngresoServicio10000
		+ $RcoIngresoServicio15000
		+ $RcoIngresoServicio20000
		+ $RcoIngresoServicio25000
		+ $RcoIngresoServicio30000
		+ $RcoIngresoServicio35000
		+ $RcoIngresoServicio40000
		+ $RcoIngresoServicio45000
		+ $RcoIngresoServicio50000
		+ $RcoIngresoServicio50000Mas
		
		+ $RcoIngresoServicioReparaciones
		+ $RcoIngresoServicioPlanchadoPintado
		+ $RcoIngresoServicioTrabajoInterno
		+ $RcoIngreseServicioGarantias
		+ $RcoIngresoServicioInstalacionAccesorios
		
		+ $RcoIngresoServicioReingresos
		+ $RcoIngresoServicioInstalacionGLP
		+ $RcoIngresoServicioSuperCambio99
		;
		
		
		/*
		* INGRESO X MODELO
		*/

		$RcoIngresoSparkLite = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10006",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoSparkGT = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10005",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoN300MoveMax = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10063,VMO-10064",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoN300Work = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10065",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoCorsaChevyTaxi = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10028,VMO-10052",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoSail= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10003,VMO-10062",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoOnix = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10102",false,$DatSucursal->SucId,NULL);;
		
		$RcoIngresoPrisma =  $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10096",false,$DatSucursal->SucId,NULL);;
		
		$RcoIngresoNuevoSail= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10087",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoAveo = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10000,VMO-10059",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoOptra= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10002,VMO-10007",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoSonic= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10004,VMO-10060",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoCruze = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10001,VMO-10061",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoSpin = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10094",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoTracker= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10012",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoVivant= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10008",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoOrlando= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10010",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoCaptiva= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10009",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoS10= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10067",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoTrailblazer= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10066",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoTraverse= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10013",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoTahoeSuburban = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10011,VMO-10025",false,$DatSucursal->SucId,NULL);
		
		$FichaIngresoMantenimientoMensualTotalModelo = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,NULL) ;
								//echo "::: ".$FichaIngresoMantenimientoMensualTotalModelo." - ".$TotalIngresoTipoMensualModelo[$mes];
								
				
		
		$RcoIngresoNLR3TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10069,VMO-10077,VMO-10091,VMO-10036,VMO-10017",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoREWARD400DT = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10076",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoREWARD400NMR = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10119",false,$DatSucursal->SucId,NULL);
							
		$RcoIngresoNPR4TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10084",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoREWARD500 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10071",false,$DatSucursal->SucId,NULL);
		
		$RcoIngresoFTR10TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10090",false,$DatSucursal->SucId,NULL);					

		$RcoIngresoFORWARD800 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10072",false,$DatSucursal->SucId,NULL);		
		
		
		$RcoIngresoFORWARD1300 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10074",false,$DatSucursal->SucId,NULL);		
		
		$RcoIngresoFORWARD2000 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$GET_VehiculoMarca,1,NULL,"VMO-10075",false,$DatSucursal->SucId,NULL);		
		
		$TotalIngresoTipoMensualModelo = $RcoIngresoSparkLite 
		+ $RcoIngresoSparkGT 
		+ $RcoIngresoN300MoveMax 
		+ $RcoIngresoN300Work 
		+ $RcoIngresoCorsaChevyTaxi 
		+ $RcoIngresoSail 	
		+ $RcoIngresoOnix 
		+ $RcoIngresoPrisma 
		+ $RcoIngresoNuevoSail 
		+ $RcoIngresoAveo
		+ $RcoIngresoOptra
		+ $RcoIngresoSonic
		+ $RcoIngresoCruze
		+ $RcoIngresoSpin 
		+ $RcoIngresoTracker	
		+ $RcoIngresoVivant
		+ $RcoIngresoOrlando
		+ $RcoIngresoCaptiva
		+ $RcoIngresoS10
		+ $RcoIngresoTrailblazer
		+ $RcoIngresoTraverse
		+ $RcoIngresoTahoeSuburban 


		+ $RcoIngresoNLR3TON
		+ $RcoIngresoREWARD400DT
		+ $RcoIngresoREWARD400NMR
		+ $RcoIngresoNPR4TON
		+ $RcoIngresoREWARD500
		+ $RcoIngresoFTR10TON
		+ $RcoIngresoFORWARD800
		+ $RcoIngresoFORWARD1300
		+ $RcoIngresoFORWARD2000;


		$RcoIngresoOtrasUnidades = $FichaIngresoMantenimientoMensualTotalModelo - $TotalIngresoTipoMensualModelo;
	

		$RcoTotalIngresosUnidades = $TotalIngresoTipoMensualModelo + $RcoIngresoOtrasUnidades;
		
		
		/*
		* CITAS
		*/

																					
		//RcoNumeroCitas
		$InsCita = new ClsCita();
		//MtdObtenerCitasValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oHoraFin=NULL,$oSucursal=NULL) 
		$RcoNumeroCitas = $InsCita->MtdObtenerCitasValor("COUNT","CitId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,"CitId","ASC",NULL,NULL,NULL,NULL,NULL,NULL,"CitFecha",false,NULL,$GET_VehiculoMarca,NULL,NULL,$DatSucursal->SucId);                            
		$RcoNumeroCitas = (empty($RcoNumeroCitas)?0:$RcoNumeroCitas);
		
		$RcoCitasEfectivas = 0;
		
		
		//RcoClientesParticulares
		$InsFichaIngreso = new ClsFichaIngreso();
		//MMtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL)
		$RcoClientesParticulares = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,"LTI-10011",$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId) ;
		$RcoClientesParticulares = (empty($RcoClientesParticulares)?0:$RcoClientesParticulares);
							
		//RcoClientesFlotas
		$InsFichaIngreso = new ClsFichaIngreso();
		//MMtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL)
		$RcoClientesFlotas = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,"LTI-10010",$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId) ;
		$RcoClientesFlotas = (empty($RcoClientesFlotas)?0:$RcoClientesFlotas);
					
		//RcoPromedioPermanencia
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL)
		$RcoPromedioPermanencia = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId);
		$RcoPromedioPermanencia = $RcoPromedioPermanencia/86400;
						
		//RcoParalizados
		$RcoParalizados = 0;
		
		/*
		* 2. UTILIZACION DEL RECURSO HUMANO
		*/
		
		
		//RcoPersonalMecanicos
		$RcoPersonalMecanicos = $PersonalTecnicos;
		
		//RcoPersonalAsesores
		$RcoPersonalAsesores = $PersonalAsesoresServicio;
		
		//RcoPersonalOtros
		$RcoPersonalOtros = $PersonalOtros;
		
		//RcoDiasLaborados
		$CantidadDiasMensual = cal_days_in_month(CAL_GREGORIAN, $GET_Mes, $GET_Ano); // 31
		$RcoDiasLaborados = $CantidadDiasMensual - 6;
		
		//RcoHoraDisponibles
		$RcoHoraDisponibles = $RcoDiasLaborados * 8;
		
		//RcoHoraLaboradas
		//MtdObtenerReporteFichaIngresoPromedioTrabajo($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL) {
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL) 
		$RcoHoraLaboradas = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId);
		$RcoHoraLaboradas = (empty($RcoHoraLaboradas)?0:$RcoHoraLaboradas);
		
		//RcoTarifaMO
		$RcoTarifaMO = $TarifaManoObra;
		
		//RcoHoraMOVendidas
		//MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL)
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL)
		$RcoHoraMOVendidas = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSumaTiempoConcluido($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId);
		$RcoHoraMOVendidas = (empty($RcoHoraMOVendidas)?0:$RcoHoraMOVendidas);
		
		//RcoVentaManoObra
		$InsFichaAccion = new ClsFichaAccion();
		//MtdObtenerFichaAccionesTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
		$RcoVentaManoObra = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,NULL,$GET_VehiculoMarca,$DatSucursal->SucId);
		$RcoVentaManoObra = (empty($RcoVentaManoObra)?0:$RcoVentaManoObra);
		 
		//RcoVentaRepuestos
		$InsReporteFacturacion = new ClsReporteFacturacion();
//MtdObtenerFacturacionTaller($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL)
		$RcoVentaRepuestos = $InsReporteFacturacion->MtdObtenerFacturacionTaller("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10000","MIN-10001,MIN-10003,MIN-10007","fde.FdeId","DESC",NULL,$DatSucursal->SucId) ;
		$RcoVentaRepuestos = (empty($RcoVentaRepuestos)?0:$RcoVentaRepuestos);
		
		
		//$DatSucursal->SucId
		
		//RcoTicketPromedio              
		//$RcoTicketPromedio = ($RcoVentaManoObra + $RcoVentaRepuestos)/$TotalIngresoTipoMensual[$mes];
		
		//RcoTicketPromedio
		$RcoTicketPromedio = 0;
		
		//RcoVentaGarantiaFA
		$RcoVentaGarantiaFA = 0;
		
		$RcoVentaMecanica = 0;
		
		
		
		echo "ReporteCOSId: ".$ReporteCOSId ;
		echo "<br>";	
		
		echo "RcoNumeroCitas: ".$RcoNumeroCitas;
		echo "<br>";	
		
		echo "RcoClientesParticulares: ".$RcoClientesParticulares;
		echo "<br>";	
		
		echo "RcoClientesFlotas: ".$RcoClientesFlotas;
		echo "<br>";	
		
		echo "RcoPromedioPermanencia: ".$RcoPromedioPermanencia;
		echo "<br>";	
		
		echo "RcoParalizados: ".$RcoParalizados;
		echo "<br>";	
		
		
		echo "RcoPersonalMecanicos: ".$RcoPersonalMecanicos;
		echo "<br>";	
		
		echo "RcoPersonalAsesores: ".$RcoPersonalAsesores;
		echo "<br>";	
		
		echo "RcoPersonalOtros: ".$RcoPersonalOtros;
		echo "<br>";	
		
		echo "RcoDiasLaborados: ".$RcoDiasLaborados;
		echo "<br>";	
		
		echo "RcoHoraDisponibles: ".$RcoHoraDisponibles;
		echo "<br>";	
		
		echo "RcoHoraLaboradas: ".$RcoHoraLaboradas;
		echo "<br>";	
		
		echo "RcoTarifaMO: ".$RcoTarifaMO;
		echo "<br>";	
		
		echo "RcoHoraMOVendidas: ".$RcoHoraMOVendidas;
		echo "<br>";	
		
		echo "RcoVentaManoObra: ".$RcoVentaManoObra;
		echo "<br>";	
		
		echo "RcoVentaRepuestos: ".$RcoVentaRepuestos;
		echo "<br>";	
		
		echo "RcoTicketPromedio: ".$RcoTicketPromedio;
		echo "<br>";
		
		echo "RcoVentaGarantiaFA: ".$RcoVentaGarantiaFA;
		echo "<br>";	
		
		echo "RcoNumeroCitas: ".$RcoNumeroCitas;
		echo "<br>";	
		
		echo "RcoCitasEfectivas: ".$RcoCitasEfectivas;
		echo "<br>";	
		
		
		
		
		
		if(empty($ReporteCOSId)){
			
			$InsReporteCOS = new ClsReporteCOS();
			$InsReporteCOS->RcoId = NULL;
			$InsReporteCOS->SucId = $DatSucursal->SucId;			
			
			$InsReporteCOS->VmaId = $GET_VehiculoMarca;
			$InsReporteCOS->RcoMes = $GET_Mes;
			$InsReporteCOS->RcoAno = $GET_Ano;
			
			
			$InsReporteCOS->RcoIngresoSparkLite= (empty($RcoIngresoSparkLite)?0:$RcoIngresoSparkLite);
			$InsReporteCOS->RcoIngresoSparkGT= (empty($RcoIngresoSparkGT)?0:$RcoIngresoSparkGT);
			$InsReporteCOS->RcoIngresoN300MoveMax= (empty($RcoIngresoN300MoveMax)?0:$RcoIngresoN300MoveMax);
			$InsReporteCOS->RcoIngresoN300Work= (empty($RcoIngresoN300Work)?0:$RcoIngresoN300Work);
			$InsReporteCOS->RcoIngresoCorsaChevyTaxi= (empty($RcoIngresoCorsaChevyTaxi)?0:$RcoIngresoCorsaChevyTaxi);
			$InsReporteCOS->RcoIngresoSail= (empty($RcoIngresoSail)?0:$RcoIngresoSail);
			$InsReporteCOS->RcoIngresoOnix= (empty($RcoIngresoOnix)?0:$RcoIngresoOnix);
			$InsReporteCOS->RcoIngresoPrisma= (empty($RcoIngresoPrisma)?0:$RcoIngresoPrisma);
			$InsReporteCOS->RcoIngresoNuevoSail= (empty($RcoIngresoNuevoSail)?0:$RcoIngresoNuevoSail);
			$InsReporteCOS->RcoIngresoAveo= (empty($RcoIngresoAveo)?0:$RcoIngresoAveo);
			$InsReporteCOS->RcoIngresoOptra= (empty($RcoIngresoOptra)?0:$RcoIngresoOptra);
			$InsReporteCOS->RcoIngresoSonic= (empty($RcoIngresoSonic)?0:$RcoIngresoSonic);
			$InsReporteCOS->RcoIngresoCruze= (empty($RcoIngresoCruze)?0:$RcoIngresoCruze);
			$InsReporteCOS->RcoIngresoSpin=(empty($RcoIngresoSpin)?0:$RcoIngresoSpin);
			$InsReporteCOS->RcoIngresoTracker= (empty($RcoIngresoTracker)?0:$RcoIngresoTracker);
			$InsReporteCOS->RcoIngresoVivant= (empty($RcoIngresoVivant)?0:$RcoIngresoVivant);
			$InsReporteCOS->RcoIngresoOrlando= (empty($RcoIngresoOrlando)?0:$RcoIngresoOrlando);
			$InsReporteCOS->RcoIngresoCaptiva= (empty($RcoIngresoCaptiva)?0:$RcoIngresoCaptiva);
			$InsReporteCOS->RcoIngresoS10= (empty($RcoIngresoS10)?0:$RcoIngresoS10);
			$InsReporteCOS->RcoIngresoTrailblazer= (empty($RcoIngresoTrailblazer)?0:$RcoIngresoTrailblazer);
			$InsReporteCOS->RcoIngresoTraverse= (empty($RcoIngresoTraverse)?0:$RcoIngresoTraverse);
			$InsReporteCOS->RcoIngresoTahoeSuburban= (empty($RcoIngresoTahoeSuburban)?0:$RcoIngresoTahoeSuburban);
			
			
			$InsReporteCOS->RcoIngresoNLR3TON= (empty($RcoIngresoNLR3TON)?0:$RcoIngresoNLR3TON);
			$InsReporteCOS->RcoIngresoREWARD400DT= (empty($RcoIngresoREWARD400DT)?0:$RcoIngresoREWARD400DT);
			$InsReporteCOS->RcoIngresoREWARD400NMR= (empty($RcoIngresoREWARD400NMR)?0:$RcoIngresoREWARD400NMR);
			$InsReporteCOS->RcoIngresoNPR4TON= (empty($RcoIngresoNPR4TON)?0:$RcoIngresoNPR4TON);
			$InsReporteCOS->RcoIngresoREWARD500= (empty($RcoIngresoREWARD500)?0:$RcoIngresoREWARD500);
			$InsReporteCOS->RcoIngresoFTR10TON= (empty($RcoIngresoFTR10TON)?0:$RcoIngresoFTR10TON);
			$InsReporteCOS->RcoIngresoFORWARD800= (empty($RcoIngresoFORWARD800)?0:$RcoIngresoFORWARD800);
			$InsReporteCOS->RcoIngresoFORWARD1300= (empty($RcoIngresoFORWARD1300)?0:$RcoIngresoFORWARD1300);
			$InsReporteCOS->RcoIngresoFORWARD2000= (empty($RcoIngresoFORWARD2000)?0:$RcoIngresoFORWARD2000);
			
			$InsReporteCOS->RcoIngresoOtrasUnidades= (empty($RcoIngresoOtrasUnidades)?0:$RcoIngresoOtrasUnidades);
			$InsReporteCOS->RcoTotalIngresosUnidades= (empty($RcoTotalIngresosUnidades)?0:$RcoTotalIngresosUnidades);
			$InsReporteCOS->RcoTotalIngresosUnidadesMantenimiento= (empty($RcoTotalIngresosUnidadesMantenimiento)?0:$RcoTotalIngresosUnidadesMantenimiento);
			
			$InsReporteCOS->RcoIngresoPrimeraRevision= (empty($RcoIngresoPrimeraRevision)?0:$RcoIngresoPrimeraRevision);
			
			$InsReporteCOS->RcoIngresoServicio1000= (empty($RcoIngresoServicio1000)?0:$RcoIngresoServicio1000);
			$InsReporteCOS->RcoIngresoServicio1500= (empty($RcoIngresoServicio1500)?0:$RcoIngresoServicio1500);			
			$InsReporteCOS->RcoIngresoServicio5000= (empty($RcoIngresoServicio5000)?0:$RcoIngresoServicio5000);
			$InsReporteCOS->RcoIngresoServicio10000= (empty($RcoIngresoServicio10000)?0:$RcoIngresoServicio10000);
			$InsReporteCOS->RcoIngresoServicio15000= (empty($RcoIngresoServicio15000)?0:$RcoIngresoServicio15000);
			$InsReporteCOS->RcoIngresoServicio20000= (empty($RcoIngresoServicio20000)?0:$RcoIngresoServicio20000);
			$InsReporteCOS->RcoIngresoServicio25000= (empty($RcoIngresoServicio25000)?0:$RcoIngresoServicio25000);
			$InsReporteCOS->RcoIngresoServicio30000= (empty($RcoIngresoServicio30000)?0:$RcoIngresoServicio30000);
			$InsReporteCOS->RcoIngresoServicio35000= (empty($RcoIngresoServicio35000)?0:$RcoIngresoServicio35000);
			$InsReporteCOS->RcoIngresoServicio40000= (empty($RcoIngresoServicio40000)?0:$RcoIngresoServicio40000);
			$InsReporteCOS->RcoIngresoServicio45000= (empty($RcoIngresoServicio45000)?0:$RcoIngresoServicio45000);
			$InsReporteCOS->RcoIngresoServicio50000= (empty($RcoIngresoServicio50000)?0:$RcoIngresoServicio50000);
			$InsReporteCOS->RcoIngresoServicio50000Mas= (empty($RcoIngresoServicio50000Mas)?0:$RcoIngresoServicio50000Mas);
			
			$InsReporteCOS->RcoIngresoServicioReparaciones= (empty($RcoIngresoServicioReparaciones)?0:$RcoIngresoServicioReparaciones);
			$InsReporteCOS->RcoIngresoServicioPlanchadoPintado= (empty($RcoIngresoServicioPlanchadoPintado)?0:$RcoIngresoServicioPlanchadoPintado);
			$InsReporteCOS->RcoIngresoServicioTrabajoInterno = (empty($RcoIngresoServicioTrabajoInterno)?0:$RcoIngresoServicioTrabajoInterno);
			$InsReporteCOS->RcoIngreseServicioGarantias = (empty($RcoIngreseServicioGarantias)?0:$RcoIngreseServicioGarantias);
			$InsReporteCOS->RcoIngresoServicioInstalacionAccesorios = (empty($RcoIngresoServicioInstalacionAccesorios)?0:$RcoIngresoServicioInstalacionAccesorios);
			$InsReporteCOS->RcoIngresoServicioInstalacionGLP = (empty($RcoIngresoServicioInstalacionGLP)?0:$RcoIngresoServicioInstalacionGLP);
			$InsReporteCOS->RcoIngresoServicioSuperCambio99 = (empty($RcoIngresoServicioSuperCambio99)?0:$RcoIngresoServicioSuperCambio99);
			$InsReporteCOS->RcoIngresoServicioReingresos = (empty($RcoIngresoServicioReingresos)?0:$RcoIngresoServicioReingresos);
			
			
			
			$InsReporteCOS->RcoNumeroCitas = (empty($RcoNumeroCitas)?0:$RcoNumeroCitas);
			$InsReporteCOS->RcoCitasEfectivas = (empty($RcoCitasEfectivas)?0:$RcoCitasEfectivas);			
			$InsReporteCOS->RcoClientesParticulares = (empty($RcoClientesParticulares)?0:$RcoClientesParticulares);
			$InsReporteCOS->RcoClientesFlotas = (empty($RcoClientesFlotas)?0:$RcoClientesFlotas);
			$InsReporteCOS->RcoPromedioPermanencia = (empty($RcoPromedioPermanencia)?0:$RcoPromedioPermanencia);
			$InsReporteCOS->RcoParalizados = (empty($RcoParalizados)?0:$RcoParalizados);
			
			$InsReporteCOS->RcoPersonalMecanicos = (empty($RcoPersonalMecanicos)?0:$RcoPersonalMecanicos);
			$InsReporteCOS->RcoPersonalAsesores = (empty($RcoPersonalAsesores)?0:$RcoPersonalAsesores);
			$InsReporteCOS->RcoPersonalOtros = (empty($RcoPersonalOtros)?0:$RcoPersonalOtros);
			$InsReporteCOS->RcoDiasLaborados = (empty($RcoDiasLaborados)?0:$RcoDiasLaborados);
			$InsReporteCOS->RcoHoraDisponibles = (empty($RcoHoraDisponibles)?0:$RcoHoraDisponibles);
			$InsReporteCOS->RcoHoraLaboradas = (empty($RcoHoraLaboradas)?0:$RcoHoraLaboradas);
			$InsReporteCOS->RcoTarifaMO = (empty($RcoTarifaMO)?0:$RcoTarifaMO);
			
			$InsReporteCOS->RcoHoraMOVendidas = (empty($RcoHoraMOVendidas)?0:$RcoHoraMOVendidas);
			$InsReporteCOS->RcoVentaManoObra = (empty($RcoVentaManoObra)?0:$RcoVentaManoObra);
			$InsReporteCOS->RcoVentaRepuestos = (empty($RcoVentaRepuestos)?0:$RcoVentaRepuestos);
			$InsReporteCOS->RcoTicketPromedio = (empty($RcoTicketPromedio)?0:$RcoTicketPromedio);		
			
			$InsReporteCOS->RcoVentaMecanica = (empty($RcoVentaMecanica)?0:$RcoVentaMecanica);
			$InsReporteCOS->RcoVentaGarantiaFA = (empty($RcoVentaGarantiaFA)?0:$RcoVentaGarantiaFA);
			
			$InsReporteCOS->RcoEstado = 3;
			$InsReporteCOS->RcoTiempoCreacion = date("Y-m-d H:i:s");
			$InsReporteCOS->RcoTiempoModificacion = date("Y-m-d H:i:s");
		
			
			if($InsReporteCOS->MtdRegistrarReporteCOS()){				
				echo "Se registro los archivos COS";	
				echo "<br>";				
			}else {
				echo "No se pudo registrar los archivos COS";	
				echo "<br>";	
			}
			
		}else{
			
			
			
			$InsReporteCOS = new ClsReporteCOS();
			$InsReporteCOS->RcoId = $ReporteCOSId;
			$InsReporteCOS->SucId = $DatSucursal->SucId;			
			
			$InsReporteCOS->VmaId = $GET_VehiculoMarca;
			$InsReporteCOS->RcoMes = $GET_Mes;
			$InsReporteCOS->RcoAno = $GET_Ano;
			
			
			$InsReporteCOS->RcoIngresoSparkLite= (empty($RcoIngresoSparkLite)?0:$RcoIngresoSparkLite);
			$InsReporteCOS->RcoIngresoSparkGT= (empty($RcoIngresoSparkGT)?0:$RcoIngresoSparkGT);
			$InsReporteCOS->RcoIngresoN300MoveMax= (empty($RcoIngresoN300MoveMax)?0:$RcoIngresoN300MoveMax);
			$InsReporteCOS->RcoIngresoN300Work= (empty($RcoIngresoN300Work)?0:$RcoIngresoN300Work);
			$InsReporteCOS->RcoIngresoCorsaChevyTaxi= (empty($RcoIngresoCorsaChevyTaxi)?0:$RcoIngresoCorsaChevyTaxi);
			$InsReporteCOS->RcoIngresoSail= (empty($RcoIngresoSail)?0:$RcoIngresoSail);
			$InsReporteCOS->RcoIngresoOnix= (empty($RcoIngresoOnix)?0:$RcoIngresoOnix);
			$InsReporteCOS->RcoIngresoPrisma= (empty($RcoIngresoPrisma)?0:$RcoIngresoPrisma);
			$InsReporteCOS->RcoIngresoNuevoSail= (empty($RcoIngresoNuevoSail)?0:$RcoIngresoNuevoSail);
			$InsReporteCOS->RcoIngresoAveo= (empty($RcoIngresoAveo)?0:$RcoIngresoAveo);
			$InsReporteCOS->RcoIngresoOptra= (empty($RcoIngresoOptra)?0:$RcoIngresoOptra);
			$InsReporteCOS->RcoIngresoSonic= (empty($RcoIngresoSonic)?0:$RcoIngresoSonic);
			$InsReporteCOS->RcoIngresoCruze= (empty($RcoIngresoCruze)?0:$RcoIngresoCruze);
			$InsReporteCOS->RcoIngresoSpin=(empty($RcoIngresoSpin)?0:$RcoIngresoSpin);
			$InsReporteCOS->RcoIngresoTracker= (empty($RcoIngresoTracker)?0:$RcoIngresoTracker);
			$InsReporteCOS->RcoIngresoVivant= (empty($RcoIngresoVivant)?0:$RcoIngresoVivant);
			$InsReporteCOS->RcoIngresoOrlando= (empty($RcoIngresoOrlando)?0:$RcoIngresoOrlando);
			$InsReporteCOS->RcoIngresoCaptiva= (empty($RcoIngresoCaptiva)?0:$RcoIngresoCaptiva);
			$InsReporteCOS->RcoIngresoS10= (empty($RcoIngresoS10)?0:$RcoIngresoS10);
			$InsReporteCOS->RcoIngresoTrailblazer= (empty($RcoIngresoTrailblazer)?0:$RcoIngresoTrailblazer);
			$InsReporteCOS->RcoIngresoTraverse= (empty($RcoIngresoTraverse)?0:$RcoIngresoTraverse);
			$InsReporteCOS->RcoIngresoTahoeSuburban= (empty($RcoIngresoTahoeSuburban)?0:$RcoIngresoTahoeSuburban);
			
			$InsReporteCOS->RcoIngresoNLR3TON= (empty($RcoIngresoNLR3TON)?0:$RcoIngresoNLR3TON);
			$InsReporteCOS->RcoIngresoREWARD400DT= (empty($RcoIngresoREWARD400DT)?0:$RcoIngresoREWARD400DT);
			$InsReporteCOS->RcoIngresoREWARD400NMR= (empty($RcoIngresoREWARD400NMR)?0:$RcoIngresoREWARD400NMR);
			$InsReporteCOS->RcoIngresoNPR4TON= (empty($RcoIngresoNPR4TON)?0:$RcoIngresoNPR4TON);
			$InsReporteCOS->RcoIngresoREWARD500= (empty($RcoIngresoREWARD500)?0:$RcoIngresoREWARD500);
			$InsReporteCOS->RcoIngresoFTR10TON= (empty($RcoIngresoFTR10TON)?0:$RcoIngresoFTR10TON);
			$InsReporteCOS->RcoIngresoFORWARD800= (empty($RcoIngresoFORWARD800)?0:$RcoIngresoFORWARD800);
			$InsReporteCOS->RcoIngresoFORWARD1300= (empty($RcoIngresoFORWARD1300)?0:$RcoIngresoFORWARD1300);
			$InsReporteCOS->RcoIngresoFORWARD2000= (empty($RcoIngresoFORWARD2000)?0:$RcoIngresoFORWARD2000);
			
			$InsReporteCOS->RcoIngresoOtrasUnidades= (empty($RcoIngresoOtrasUnidades)?0:$RcoIngresoOtrasUnidades);
			$InsReporteCOS->RcoTotalIngresosUnidades= (empty($RcoTotalIngresosUnidades)?0:$RcoTotalIngresosUnidades);
			$InsReporteCOS->RcoTotalIngresosUnidadesMantenimiento= (empty($RcoTotalIngresosUnidadesMantenimiento)?0:$RcoTotalIngresosUnidadesMantenimiento);
			
			
			$InsReporteCOS->RcoIngresoPrimeraRevision= (empty($RcoIngresoPrimeraRevision)?0:$RcoIngresoPrimeraRevision);
			$InsReporteCOS->RcoIngresoServicio1000= (empty($RcoIngresoServicio1000)?0:$RcoIngresoServicio1000);
			$InsReporteCOS->RcoIngresoServicio1500= (empty($RcoIngresoServicio1500)?0:$RcoIngresoServicio1500);
			$InsReporteCOS->RcoIngresoServicio5000= (empty($RcoIngresoServicio5000)?0:$RcoIngresoServicio5000);
			$InsReporteCOS->RcoIngresoServicio10000= (empty($RcoIngresoServicio10000)?0:$RcoIngresoServicio10000);
			$InsReporteCOS->RcoIngresoServicio15000= (empty($RcoIngresoServicio15000)?0:$RcoIngresoServicio15000);
			$InsReporteCOS->RcoIngresoServicio20000= (empty($RcoIngresoServicio20000)?0:$RcoIngresoServicio20000);
			$InsReporteCOS->RcoIngresoServicio25000= (empty($RcoIngresoServicio25000)?0:$RcoIngresoServicio25000);
			$InsReporteCOS->RcoIngresoServicio30000= (empty($RcoIngresoServicio30000)?0:$RcoIngresoServicio30000);
			$InsReporteCOS->RcoIngresoServicio35000= (empty($RcoIngresoServicio35000)?0:$RcoIngresoServicio35000);
			$InsReporteCOS->RcoIngresoServicio40000= (empty($RcoIngresoServicio40000)?0:$RcoIngresoServicio40000);
			$InsReporteCOS->RcoIngresoServicio45000= (empty($RcoIngresoServicio45000)?0:$RcoIngresoServicio45000);
			$InsReporteCOS->RcoIngresoServicio50000= (empty($RcoIngresoServicio50000)?0:$RcoIngresoServicio50000);
			$InsReporteCOS->RcoIngresoServicio50000Mas= (empty($RcoIngresoServicio50000Mas)?0:$RcoIngresoServicio50000Mas);
			
			$InsReporteCOS->RcoIngresoServicioReparaciones= (empty($RcoIngresoServicioReparaciones)?0:$RcoIngresoServicioReparaciones);
			$InsReporteCOS->RcoIngresoServicioPlanchadoPintado= (empty($RcoIngresoServicioPlanchadoPintado)?0:$RcoIngresoServicioPlanchadoPintado);
			$InsReporteCOS->RcoIngresoServicioTrabajoInterno = (empty($RcoIngresoServicioTrabajoInterno)?0:$RcoIngresoServicioTrabajoInterno);
			$InsReporteCOS->RcoIngreseServicioGarantias = (empty($RcoIngreseServicioGarantias)?0:$RcoIngreseServicioGarantias);
			$InsReporteCOS->RcoIngresoServicioInstalacionAccesorios = (empty($RcoIngresoServicioInstalacionAccesorios)?0:$RcoIngresoServicioInstalacionAccesorios);
			$InsReporteCOS->RcoIngresoServicioInstalacionGLP = (empty($RcoIngresoServicioInstalacionGLP)?0:$RcoIngresoServicioInstalacionGLP);
			$InsReporteCOS->RcoIngresoServicioSuperCambio99 = (empty($RcoIngresoServicioSuperCambio99)?0:$RcoIngresoServicioSuperCambio99);
			$InsReporteCOS->RcoIngresoServicioReingresos = (empty($RcoIngresoServicioReingresos)?0:$RcoIngresoServicioReingresos);
			
			
			
			
			$InsReporteCOS->RcoNumeroCitas = (empty($RcoNumeroCitas)?0:$RcoNumeroCitas);
			$InsReporteCOS->RcoCitasEfectivas = (empty($RcoCitasEfectivas)?0:$RcoCitasEfectivas);			
			$InsReporteCOS->RcoClientesParticulares = (empty($RcoClientesParticulares)?0:$RcoClientesParticulares);
			$InsReporteCOS->RcoClientesFlotas = (empty($RcoClientesFlotas)?0:$RcoClientesFlotas);
			$InsReporteCOS->RcoPromedioPermanencia = (empty($RcoPromedioPermanencia)?0:$RcoPromedioPermanencia);
			$InsReporteCOS->RcoParalizados = (empty($RcoParalizados)?0:$RcoParalizados);
			
			$InsReporteCOS->RcoPersonalMecanicos = (empty($RcoPersonalMecanicos)?0:$RcoPersonalMecanicos);
			$InsReporteCOS->RcoPersonalAsesores = (empty($RcoPersonalAsesores)?0:$RcoPersonalAsesores);
			$InsReporteCOS->RcoPersonalOtros = (empty($RcoPersonalOtros)?0:$RcoPersonalOtros);
			$InsReporteCOS->RcoDiasLaborados = (empty($RcoDiasLaborados)?0:$RcoDiasLaborados);
			$InsReporteCOS->RcoHoraDisponibles = (empty($RcoHoraDisponibles)?0:$RcoHoraDisponibles);
			$InsReporteCOS->RcoHoraLaboradas = (empty($RcoHoraLaboradas)?0:$RcoHoraLaboradas);
			$InsReporteCOS->RcoTarifaMO = (empty($RcoTarifaMO)?0:$RcoTarifaMO);
			
			$InsReporteCOS->RcoHoraMOVendidas = (empty($RcoHoraMOVendidas)?0:$RcoHoraMOVendidas);
			$InsReporteCOS->RcoVentaManoObra = (empty($RcoVentaManoObra)?0:$RcoVentaManoObra);
			$InsReporteCOS->RcoVentaRepuestos = (empty($RcoVentaRepuestos)?0:$RcoVentaRepuestos);
			$InsReporteCOS->RcoTicketPromedio = (empty($RcoTicketPromedio)?0:$RcoTicketPromedio);		
			
			$InsReporteCOS->RcoVentaMecanica = (empty($RcoVentaMecanica)?0:$RcoVentaMecanica);
			$InsReporteCOS->RcoVentaGarantiaFA = (empty($RcoVentaGarantiaFA)?0:$RcoVentaGarantiaFA);
			
			$InsReporteCOS->RcoEstado = 3;
			$InsReporteCOS->RcoTiempoCreacion = date("Y-m-d H:i:s");
			$InsReporteCOS->RcoTiempoModificacion = date("Y-m-d H:i:s");
		
			
			if($InsReporteCOS->MtdEditarReporteCOS()){				
				echo "Se edito los archivos COS";	
			echo "<br>";	
					
			}else {
				echo "No se pudo editar los archivos COS";	
				echo "<br>";	
			}
			
			
			
			//$InsReporteCOS = new ClsReporteCOS();
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoNumeroCitas",$RcoNumeroCitas,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoClientesParticulares",$RcoClientesParticulares,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoClientesFlotas",$RcoClientesFlotas,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPromedioPermanencia",$RcoPromedioPermanencia,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoParalizados",$RcoParalizados,$ReporteCOSId);
//			
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPersonalMecanicos",$RcoPersonalMecanicos,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPersonalAsesores",$RcoPersonalAsesores,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPersonalOtros",$RcoPersonalOtros,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoDiasLaborados",$RcoDiasLaborados,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoHoraDisponibles",$RcoHoraDisponibles,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoHoraLaboradas",$RcoHoraLaboradas,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoTarifaMO",$RcoTarifaMO,$ReporteCOSId);
//			
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoHoraMOVendidas",$RcoHoraMOVendidas,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoVentaManoObra",$RcoVentaManoObra,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoVentaRepuestos",$RcoVentaRepuestos,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoTicketPromedio",$RcoTicketPromedio,$ReporteCOSId);
//			$InsReporteCOS->MtdEditarReporteCOSDato("RcoVentaGarantiaFA",$RcoVentaGarantiaFA,$ReporteCOSId);
//			
		}




		
		
	}
}

echo "<hr>";
echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");


?>