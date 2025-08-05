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
	header("Content-Disposition:  filename=\"REPORTE_CUADRO_ORDEN_TRABAJO_ANUAL_".date('d-m-Y').".xls\";");
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

$POST_Ano = empty($_POST['CmpAno'])?date("Y"):$_POST['CmpAno'];
$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];
$POST_ModalidadIngreso = $_POST['CmpModalidadIngreso'];

$POST_IgnorarPrimerMantenimiento = $_POST['ChkIgnorarPrimerMantenimiento'];
$POST_IgnorarReparacionesSinCosto = $_POST['ChkIgnorarReparacionesSinCosto'];

$IgnorarPrimerMantenimiento = false;
$IgnorarReparacionesSinCosto = false;

//deb($POST_IgnorarPrimerMantenimiento);
//deb($POST_IgnorarReparacionesSinCosto);

if($POST_IgnorarPrimerMantenimiento=="1"){
	$IgnorarPrimerMantenimiento = true;
}

if($POST_IgnorarReparacionesSinCosto=="1"){
	$IgnorarReparacionesSinCosto = true;
}



if(empty($POST_VehiculoMarca)){
	die("No ha escogido una marca de vehiculo");
}

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaAccion = new ClsFichaAccion();
$InsFichaAccionProducto = new ClsFichaAccionProducto();
$InsPersonal = new ClsPersonal();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsModalidadIngreso = new ClsModalidadIngreso();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$InsModalidadIngreso->MinId = $POST_ModalidadIngreso;
$InsModalidadIngreso->MtdObtenerModalidadIngreso();

?>


<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
		<?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
		<img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
		<?php
		}else{
		?>
			<img src="../../imagenes/logotipo.png" width="243" height="59" />
		<?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE CUADRO DE ORDENES DE TRABAJO X MODALIDAD X AÑO </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">

<?php }?>
        
        
        
<table class="EstTablaReporte" width="100%">
<tr>
  <td colspan="4" align="center">
    
    
<?php
$TotalAnual = 0;
?>
    
    <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
      
      <thead class="EstTablaReporteHead">
        
       
        <tr>
          <th>&nbsp;</th>
          <th align="center" colspan="<?php echo count($ArrVehiculoModelos);?>">
AÑO          <?php echo $POST_Ano?>
          </th>
         
        </tr>
        <tr>
          <th>
            MESES</th>
          <?php
//for($i=1;$i<=$CantidadDias;$i++){
foreach($ArrVehiculoModelos as $DatVehiculoModelo){
?>

<?php	
	$MostrarModelo[$DatVehiculoModelo->VmoId] = false;
	
	for($i=1;$i<=12;$i++){
		  

		//MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oIgnorarPrimerMantenimiento=false,$oIgnorarReparacionesSinCosto=false) {
		$TotalAuxiliar = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",$i,$POST_Ano,NULL,NULL,NULL,'fin.FinId','Desc',NULL,NULL,NULL,NULL,NULL,$POST_ModalidadIngreso,NULL,NULL,NULL,0,NULL,NULL,1,0,NULL,NULL,0,NULL,$DatVehiculoModelo->VmoId,NULL,NULL,NULL,$IgnorarPrimerMantenimiento,$IgnorarReparacionesSinCosto);
		
		if($TotalAuxiliar>0){
			$MostrarModelo[$DatVehiculoModelo->VmoId] = true;
			break;
		}

	}
?>

			<?php
			if($MostrarModelo[$DatVehiculoModelo->VmoId]){
			?>
				<th align="center"> <?php echo strtoupper($DatVehiculoModelo->VmoNombre);?></th>
			<?php
			}
			?>
<?php	
}
?>
			<th>
            TOTALES</th>
          </tr>
        </thead>
      

      <tbody class="EstTablaReporteBody">

		<?php
	
		for($i=1;$i<=12;$i++){
		?>
        <tr>
         <td align="right" >
         	<?php echo FncConvertirMes($i);?>
         </td>
            <?php
			$TotalMensual[$i] = 0;
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){
			//$TotalModeloAnual[$DatVehiculoModelo->VmoId] = 0;
			?>
            	<?php
				if($MostrarModelo[$DatVehiculoModelo->VmoId]){
				?>
                
                    <td  class="<?php echo ($i%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="center" >
                  
                    <?php            
                    $TotalModeloMensual[$DatVehiculoModelo->VmoId] = 0;
                    //MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL) 
                                    
					//MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oIgnorarPrimerMantenimiento=false,$oIgnorarReparacionesSinCosto=false)
                    //$TotalModeloMensual[$DatVehiculoModelo->VmoId] = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",$i,$POST_Ano,NULL,NULL,NULL,'fin.FinId','Desc',NULL,NULL,NULL,NULL,NULL,$POST_ModalidadIngreso,NULL,NULL,NULL,0,NULL,NULL,1,0,NULL,NULL,0,NULL,$DatVehiculoModelo->VmoId,NULL,NULL,NULL,true);//CmpClienteTipo
					$TotalModeloMensual[$DatVehiculoModelo->VmoId] = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",$i,$POST_Ano,NULL,NULL,NULL,'fin.FinId','Desc',NULL,NULL,NULL,NULL,NULL,$POST_ModalidadIngreso,NULL,NULL,NULL,0,NULL,NULL,1,0,NULL,NULL,0,NULL,$DatVehiculoModelo->VmoId,NULL,NULL,NULL,$IgnorarPrimerMantenimiento,$IgnorarReparacionesSinCosto);//CmpClienteTipo
                                
                    $TotalModeloAnual[$DatVehiculoModelo->VmoId] += $TotalModeloMensual[$DatVehiculoModelo->VmoId];
                    $TotalMensual[$i] += $TotalModeloMensual[$DatVehiculoModelo->VmoId];
                    $TotalAnual +=$TotalModeloMensual[$DatVehiculoModelo->VmoId];
                    ?>
        
                    <?php
                    if($TotalModeloMensual[$DatVehiculoModelo->VmoId]>0){
                    ?>
                        <?php echo number_format($TotalModeloMensual[$DatVehiculoModelo->VmoId],2);	?>
                    <?php
                    
                    }else{
                    ?>-
                    
                    <?php
                    }
                    ?>
                    
                    </td>
                
                <?php
				}
				?>

            <?php
			}
			?>
            <td align="right" > <?php echo number_format($TotalMensual[$i],2);?>
			</td>
        </tr>
        <?php
		}
		?>
		
        
        <tr>
         <td align="right" class="Total" >
         	TOTAL <?php echo strtoupper($InsModalidadIngreso->MinNombre);?>:
         </td>

		<?php
        foreach($ArrVehiculoModelos as $DatVehiculoModelo){
        ?>
        
        <?php
				if($MostrarModelo[$DatVehiculoModelo->VmoId]){
				?>
        <td align="right" > <?php echo number_format($TotalModeloAnual[$DatVehiculoModelo->VmoId],2);?>
        </td>
        	<?php
				}
			?>
        <?php
        }
        ?>
            
            <td align="right" ><?php echo number_format($TotalAnual,2);?></td>
        </tr>
           <tr>
             <td align="right" class="Total" >PROM. MENSUAL  <?php echo strtoupper($InsModalidadIngreso->MinNombre);?>:</td>.
             <?php
        foreach($ArrVehiculoModelos as $DatVehiculoModelo){
        ?>
        
        	<?php
				if($MostrarModelo[$DatVehiculoModelo->VmoId]){
				?>
             <td align="right" >
             
				<?php $PromedioModeloMensual[$DatVehiculoModelo->VmoId] = ($TotalModeloAnual[$DatVehiculoModelo->VmoId]/12)?>
				<?php echo number_format($PromedioModeloMensual[$DatVehiculoModelo->VmoId],2);?>
             
             </td>
             
             <?php
				}
			 ?>
        <?php
        }
        ?>
             <td align="right" >
             
             <?php
			 $PromedioAnual =0;
			 $PromedioAnual = ($TotalAnual/12);
			 ?>
             <?php echo number_format($PromedioAnual,2);?>
             
             </td>
           </tr>
        </tbody>
      </table>
    
    
    
    
    </td>
</tr>
<tr>
  <td width="27%">
    
    
  </td>
  <td width="27%"></td>
  <td width="46%" colspan="2"></td>
</tr>
</table>





</body>
</html>