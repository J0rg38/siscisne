<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_TRABAJO_MANTENIMIENTO_MODELO_MENSUAL_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_Ano = isset($_POST['CmpAno'])?$_POST['CmpAno']:date("Y");


$POST_VehiculoMarca = isset($_POST['CmpVehiculoMarca'])?$_POST['CmpVehiculoMarca']:"";
$POST_VehiculoModelo = isset($_POST['CmpVehiculoModelo'])?$_POST['CmpVehiculoModelo']:"";

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_ClienteTipo = ($_POST['CmpClienteTipo']);


require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');

require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();

$InsFichaIngreso = new ClsFichaIngreso();
$InsClienteTipo = new ClsClienteTipo();

$InsBoleta = new ClsBoleta();
$InsFactura = new ClsFactura();
//$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
//$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$InsVehiculoModelo->VmoId = $POST_VehiculoModelo;
$InsVehiculoModelo->MtdObtenerVehiculoModelo();

$InsClienteTipo->LtiId = $POST_ClienteTipo ;
$InsClienteTipo->MtdObtenerClienteTipo();
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE CUADRO DE ORDENES DE TRABAJO X MODELO X TIPO CLIENTE X AÑO (MANTENIMIENTOS) DEL
      <?php
  if($POST_finicio == $POST_ffin){
?>
      <?php echo $POST_finicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
      <?php  
  }
?>



 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>


   		<?php	
		//$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_VehiculoMarca,1);
		//$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
		?>
        
        <?php
		//foreach($ArrVehiculoModelos as $DatVehiculoModelo){
		?>
			
			
			
	
            <?php
			echo $InsClienteTipo->LtiNombre;
			?>

		<table border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th colspan="60"><?php echo $InsVehiculoModelo->VmoNombre;?></th>
          </tr>
        <tr>
          <th width="14%" rowspan="2">KILOM.</th>
          <?php
for($i=1;$i<=12;$i++){
?>
<th colspan="4"><?php echo FncConvertirMes($i);?></th>
<?php
}
?>
          </tr>
        <tr>
          
        
                        
<?php
for($i=1;$i<=12;$i++){
?><th width="24%">AUTOS</th>
          <th width="24%">PROM. TICKET</th>
          <th width="24%">VAL. MAX. </th>
          <th width="24%">VAL. MIN.</th>

<?php
}
?>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        

        	<?php
			foreach( $InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
			?>

                <tr   >
                <td  align="right" valign="middle"   >
                
                <?php echo $DatKilometroEtiqueta?> KM 
                
                </td>
                <?php
for($i=1;$i<=12;$i++){
?>
  <td  align="center" bgcolor="#99FF99" >
  
  
<?php
$TotalPersonalModalidadFichaIngreso = 0;


				//MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,
				//$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL) {
$TotalPersonalModalidadFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",$i,$POST_Ano,NULL,NULL,NULL,'fin.FinId','Desc',NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,$POST_ClienteTipo,NULL,0,NULL,NULL,0,NULL,$POST_VehiculoModelo,$DatKilometro['eq']);//CmpClienteTipo

?>

<?php 
if($TotalPersonalModalidadFichaIngreso>0){
?>	
<?php
echo ($TotalPersonalModalidadFichaIngreso);
?>
<?php	
}else{
?>
-
<?php	
}
?>
</td>

                <td  align="center" bgcolor="#FFFF99" >

<?php
$TicketPromedio = 0;
$BoletaPromedio = 0;
$FacturaPromedio = 0;

//  public function MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL) 
$BoletaPromedio = $InsBoleta->MtdObtenerBoletasValor("AVG","BolTotal",$i,$POST_Ano,NULL,NULL,NULL,'BolId','Desc',NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatKilometro['eq'],"MIN-10001",NULL,$POST_VehiculoModelo,$POST_ClienteTipo);


//	public function MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL
$FacturaPromedio = $InsFactura->MtdObtenerFacturasValor("AVG","FacTotal",$i,$POST_Ano,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatKilometro['eq'],"MIN-10001",NULL,$POST_VehiculoModelo,$POST_ClienteTipo);

if($FacturaPromedio>0){
	if($BoletaPromedio>0){
		$TicketPromedio = (( $FacturaPromedio + $BoletaPromedio)/2);
	}else{
		$TicketPromedio = $FacturaPromedio;
	}
}else{
	if($BoletaPromedio>0){
		$TicketPromedio = $BoletaPromedio;
	}else{
		$TicketPromedio =0;
	}
}
?>

<?php
if($TicketPromedio>0){
?>
<?php
echo number_format($TicketPromedio,2);
?>

<?php	
}else{
?>
-
<?php	
	
}
?>
                
                </td>
                <td  align="center" bgcolor="#66CCFF" >

<?php
$TicketMaximo = 0;
$BoletaMaximo = 0;
$FacturaMaximo = 0;


//MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL) {
$BoletaMaximo = $InsBoleta->MtdObtenerBoletasValor("MAX","BolTotal",$i,$POST_Ano,NULL,NULL,NULL,'BolId','Desc',NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatKilometro['eq'],"MIN-10001",NULL,$POST_VehiculoModelo,$POST_ClienteTipo);


//MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL)  {
$FacturaMaximo = $InsFactura->MtdObtenerFacturasValor("MAX","FacTotal",$i,$POST_Ano,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatKilometro['eq'],"MIN-10001",NULL,$POST_VehiculoModelo,$POST_ClienteTipo);


if($BoletaMaximo>0){
	if($FacturaMaximo>0){
		
		if( $BoletaMaximo>$FacturaMaximo ){
			$TicketMaximo = $BoletaMaximo;
		}else{
			$TicketMaximo = $FacturaMaximo;
		}
		
	}else{
		$TicketMaximo = $BoletaMaximo;
	}
}else{
	if($FacturaMaximo>0){
		$TicketMaximo = $FacturaMaximo;
	}else{
		$TicketMaximo = 0;
	}
}

?>
     
<?php
if($TicketMaximo>0){
?>
<?php
echo number_format($TicketMaximo,2);
?>

<?php	
}else{
?>
-
<?php	
	
}
?>  
                </td>
                <td  align="center" >
                

<?php
$TicketMinimo = 0;
$BoletaMinimo = 0;
$FacturaMinimo = 0;


//MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL) {
$BoletaMinimo = $InsBoleta->MtdObtenerBoletasValor("MIN","BolTotal",$i,$POST_Ano,NULL,NULL,NULL,'BolId','Desc',NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatKilometro['eq'],"MIN-10001",NULL,$POST_VehiculoModelo);

//MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL)  {
$FacturaMinimo = $InsFactura->MtdObtenerFacturasValor("MIN","FacTotal",$i,$POST_Ano,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatKilometro['eq'],"MIN-10001",NULL,$POST_VehiculoModelo);


if($BoletaMinimo>0){
	if($FacturaMinimo>0){
		
		if( $BoletaMinimo>$FacturaMinimo ){
			$TicketMinimo = $BoletaMinimo;
		}else{
			$TicketMinimo = $FacturaMinimo;
		}
		
	}else{
		$TicketMinimo = $BoletaMinimo;
	}
}else{
	if($FacturaMinimo>0){
		$TicketMinimo = $FacturaMinimo;
	}else{
		$TicketMinimo = 0;
	}
}



?>

<?php
if($TicketMinimo>0){
?>
<?php
echo number_format($TicketMinimo,2);
?>

<?php	
}else{
?>
-
<?php	
	
}
?>  

                </td>
<?php
}
?>              
                
                </tr>
          
			<?php
			}
			
			?>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
		<?php	
		//}
		?>


</body>
</html>