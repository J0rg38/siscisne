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
	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_MSI_".date('d-m-Y').".xls\";");
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

//$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
//$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

//$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"GarFechaEmision";
//$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";
$POST_Mes = empty($_POST['CmpMes'])?date("m"):$_POST['CmpMes'];
$POST_Ano = empty($_POST['CmpAno'])?date("Y"):$_POST['CmpAno'];
$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];


if(empty($POST_VehiculoMarca)){
	die("No ha escogido una marca de vehiculo");
}

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');


$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaAccion = new ClsFichaAccion();
$InsFichaAccionProducto = new ClsFichaAccionProducto();
$InsPersonal = new ClsPersonal();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal->PerId = "PER-10016";
$InsPersonal->MtdObtenerPersonal();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
?>

<?php
if($_GET['P']==2){
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">&nbsp;</td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE GENERAL MOTOR - MSI DEL
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
  <td width="23%" align="right" valign="top">&nbsp;</td>
</tr>
</table>
<?php	
}
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE GENERAL MOTOR - MSI DEL
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
        
        
        
<table class="EstTablaReporte" width="100%">
<tr>
  <td colspan="4" align="center" valign="top"><table width="100%" cellpadding="2" cellspacing="2" class="EstTablaReporte">
    <tbody class="EstTablaReporteBody">
      <tr>
        <td width="16%">
        

		<?php
		if(!empty($InsVehiculoMarca->VmaFoto)){
		?>
		<img src="../../subidos/vehiculo_marca/<?php echo $InsVehiculoMarca->VmaFoto;?>" width="271" height="92" />
		<?php
		}else{
		?>
			-
		<?php	
		}
		?>
        
        
        </td>
        <td width="54%" align="center">INDICADORES MAYORES DE SERVICIO [MSI]&#13;<br>
          Entregable mensual para la Gerencia de Distrito de Posventa</td>
        <td width="9%" align="center">FORM<br>
          MRI1</td>
        <td width="21%" align="right">Mes y a&ntilde;o: <?php echo FncConvertirMes($POST_Mes);?> <?php echo $POST_Ano;?></td>
      </tr>
      </tbody>
    </table></td>
</tr>
<tr>
  <td width="27%" align="center" valign="top">
  
  <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
  <tbody class="EstTablaReporteBody">
  <tr>
    <td colspan="2"><span class="EstTablaReporteSubtitulo">1. Datos del concesionario</span></td>
    </tr>
  <tr>
    <td width="95">Nombre:</td>
    <td width="140">&nbsp;<?php echo $EmpresaNombre;?></td>
  </tr>
  <tr>
    <td>Ubicación:</td>
    <td>&nbsp;<?php echo $EmpresaDireccion;?></td>
  </tr>
  <tr>
    <td>Distrito:</td>
    <td>&nbsp;<?php echo $EmpresaDistrito;?></td>
  </tr>
  <tr>
    <td>Responsable:</td>
    <td>&nbsp;<?php echo $InsPersonal->PerNombre ?> <?php echo $InsPersonal->PerApellidoPaterno ?> <?php echo $InsPersonal->PerApellidoMaterno ?></td>
  </tr>
  <tr>
    <td>Cargo:</td>
    <td>&nbsp;<?php echo $InsPersonal->PtiNombre ?></td>
  </tr>
  <tr>
    <td>Firma:</td>
  <td>&nbsp;
  
	<?php
	if(!empty($InsPersonal->PerFirma)){
	?>
		<img src="../../subidos/personal_firmas/<?php echo $InsPersonal->PerFirma;?>" alt="[-]" />    
    <?php	
	}	
	?>

  
  
  </td>
  </tr>
  </tbody>
  </table>
  
  </td>
  <td width="27%" align="center" valign="top">
    
    <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
      <tbody class="EstTablaReporteBody">
        <tr>
          <td colspan="2"><span class="EstTablaReporteSubtitulo">2. Datos de la instalación</span></td>
          </tr>
        <tr>
          <td width="176">Tipo de    local (2S/3S):</td>
          <td width="112">3S</td>
          </tr>
        <tr>
          <td>Inicio de    operación:</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>Area total de    servicio (m2):</td>
          <td>800 M2</td>
          </tr>
        <tr>
          <td>Puestos de    mantenimiento:</td>
          <td>6</td>
          </tr>
        <tr>
          <td>Elevadores    disponibles:</td>
          <td>5</td>
          </tr>
        <tr>
          <td>Puestos de    reparación:</td>
          <td>2</td>
          </tr>
        <tr>
          <td>Puestos de    lavado/secado:</td>
          <td>1</td>
          </tr>
        <tr>
          <td>Estacionamientos    de clientes:</td>
          <td>4</td>
          </tr>
        <tr>
          <td>Estacionamientos    internos:</td>
          <td>3</td>
          </tr>
  </tbody>
    </table></td>
  <td colspan="2" align="center" valign="top">
    
    
    <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
      <tbody class="EstTablaReporteBody">
        <tr>
          <td colspan="2"><span class="EstTablaReporteSubtitulo">3. Datos del personal</span></td>
          </tr>
        <tr>
          <td colspan="2"> <span class="EstTablaReporteSubtitulo2">Personal de operaciones</span></td>
          </tr>
        <tr>
          <td width="167">Gestor del    área:</td>
          <td width="41">1</td>
          </tr>
        <tr>
          <td>Asesores de    servicio:</td>
          <td>2</td>
          </tr>
        <tr>
          <td>Asistentes    administrativos:</td>
          <td>1</td>
          </tr>
        <tr>
          <td>Otros</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2"> <span class="EstTablaReporteSubtitulo2">Personal técnico</span></td>
          </tr>
        <tr>
          <td width="167">Jefe de    taller:</td>
          <td>1</td>
          </tr>
        <tr>
          <td>Técnicos:</td>
          <td>4</td>
          </tr>
        <tr>
          <td>Otros:</td>
          <td>1</td>
          </tr>
        </tbody>
    </table></td>
</tr>
<tr>
  <td colspan="4">
  
  
  <?php
$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano); // 31
?>

<table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">

<thead class="EstTablaReporteHead">

<tr>
<th>
Categoria/Dia
</th>
<?php
for($i=1;$i<=$CantidadDias;$i++){
?>
<th align="center"><?php echo $i;?></th>
<?php	
}
?>
</tr>
</thead>

<?php
//$FichaIngresoMantenimientoTotalMensual = 0;
//$FichaIngresoMantenimiento50TotalMensual = 0;
//$FichaIngresoReparacionTotalMensual = 0;
//$FichaIngresoTotalInternoMensual = 0;
//$FichaIngresoTotalPlanchadoPintadoMensual = 0;
//$FichaIngresoTotalReingesoMensual = 0;
$FichaIngresoMantenimientoSumaTotal = 0;
$FichaIngresoMantenimiento50SumaTotal = 0;
$FichaIngresoReparacionSumaTotal = 0;
$FichaIngresoTotalInternoSumaTotal = 0;
$FichaIngresoTotalPlanchadoPintadoSumaTotal = 0;
$FichaIngresoTotalReingesoSumaTotal = 0;

?>
<tbody class="EstTablaReporteBody">
<?php
$c = 1;
foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
?>
	<?php
	if($DatKilometro['km']<=50000){
	?>
    <tr>
        <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
            Servicio <?php echo $DatKilometro['km'];?>
        </td>
        <?php
        for($i=1;$i<=$CantidadDias;$i++){
        ?>
            <td align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">

			<?php
			
//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL)

			$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
			?>
			<?php $FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal ?>
            
			<?php echo $FichaIngresoMantenimientoDiarioTotal;?>

            </td>
        <?php	
        }
        ?>
        
    </tr>
    <?php
	}
	?>
<?php	
$c++;
}
?>



<?php
foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
?>
	<?php
	$FichaIngresoMantenimiento50TotalDiario = array();
	?>
	<?php
	if($DatKilometro['km']>50000){
	?>
		<?php
		for($i=1;$i<=$CantidadDias;$i++){
        ?>
        
			<?php
			$FichaIngresoMantenimiento50TotalDiario[$i] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
			?>
            
		 <?php
		}
		?> 
          
    <?php
	}
	?>
 <?php	
}
?>
   
    <tr>
        <td class="EstTablaReporteColumnaEspecial1">
            Servicio >50000
        </td>
        <?php
        for($i=1;$i<=$CantidadDias;$i++){
        ?>
            <td align="center" class="EstTablaReporteColumnaEspecial1">
			
            
            <?php $FichaIngresoMantenimiento50SumaTotal += $FichaIngresoMantenimiento50TotalDiario[$i] ?>
			<?php echo $FichaIngresoMantenimiento50TotalDiario[$i];?>
            
            </td>
        <?php	
        }
        ?>
        
    </tr>



    <tr>
        <td class="EstTablaReporteColumnaEspecial2">
            Reparaciones
        </td>
        <?php
        for($i=1;$i<=$CantidadDias;$i++){
        ?>
            <td align="center" class="EstTablaReporteColumnaEspecial2">
            
			<?php
			$FichaIngresoReparacionTotalDiario = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10003",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
			?>

            <?php $FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionTotalDiario ?>
            <?php echo $FichaIngresoReparacionTotalDiario;?>
            </td>
        <?php	
        }
        ?>
        
    </tr>
   
   
   
    <tr>
        <td class="EstTablaReporteColumnaEspecial3">
            Trabajo Interno
        </td>
        <?php
        for($i=1;$i<=$CantidadDias;$i++){
        ?>
            <td align="center" class="EstTablaReporteColumnaEspecial3">
            
            
             <?php
//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL)
			$FichaIngresoTrabajoInternoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
			?>
            <?php $FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoDiarioTotal ?>
            <?php echo $FichaIngresoTrabajoInternoDiarioTotal;?>
            
            
            </td>
        <?php	
        }
        ?>
        
    </tr>
    
    
    
        <tr>
        <td class="EstTablaReporteColumnaEspecial4">
            Planchado y Pintura
        </td>
        <?php
        for($i=1;$i<=$CantidadDias;$i++){
        ?>
            <td align="center" class="EstTablaReporteColumnaEspecial4">

			<?php
			$FichaIngresoPlanchadoPintadoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10002,MIN-10004",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
			?>
			
			<?php $FichaIngresoPlanchadoPintadoSumaTotal += $FichaIngresoPlanchadoPintadoDiarioTotal ?>
            <?php echo $FichaIngresoPlanchadoPintadoDiarioTotal;?>

            </td>
        <?php	
        }
        ?>
        
    </tr>
    
    
          <tr>
        <td class="EstTablaReporteColumnaEspecial5">
           Reingresos
        </td>
        <?php
        for($i=1;$i<=$CantidadDias;$i++){
        ?>
            <td align="center" class="EstTablaReporteColumnaEspecial5">0</td>
        <?php	
        }
        ?>
        
    </tr>
   

</tbody>
</table>




  </td>
</tr>
<tr>
  <td align="center" valign="top">
  
<?php
$Mantenimiento = $FichaIngresoMantenimientoSumaTotal + $FichaIngresoMantenimiento50SumaTotal;
?>  

<?php
$Reparacion = $FichaIngresoReparacionSumaTotal + $FichaIngresoTotalInternoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalReingesoSumaTotal;
?>

<?php
$TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011,LTI-10010",$POST_VehiculoMarca) ;
?> 

	<table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
	<tbody class="EstTablaReporteBody">
      <tr>
        <td colspan="2"><span class="EstTablaReporteSubtitulo">5. Citas de servicio</span></td>
      </tr>
      <tr>
        <td width="167">Mantenimiento:</td>
        <td width="41">

        
        <?php echo $Mantenimiento;?>
        </td>
      </tr>
      <tr>
        <td>Reparaci&oacute;n:</td>
        <td>

        
        <?php echo $Reparacion;?>       
        
        </td>
      </tr>
      <tr>
        <td>Total VIN:</td>
        <td><?php echo $TotalVIN;?></td>
      </tr>
    </tbody>
  </table></td>
  <td align="center" valign="top">
  
<?php
$TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011",$POST_VehiculoMarca) ;
?>


<?php
$TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10010",$POST_VehiculoMarca) ;
?>
  
  <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
    <tbody class="EstTablaReporteBody">
      <tr>
        <td colspan="2"><span class="EstTablaReporteSubtitulo">6. Tipo de vehículos</span></td>
      </tr>
      <tr>
        <td width="167">Pasajeros:</td>
        <td width="41">
        <?php echo $TipoVehiculoPasajero;?>
        </td>
      </tr>
      <tr>
        <td>Comercial:</td>
        <td><?php echo $TipoVehiculoComercial;?></td>
      </tr>
      </tbody>
  </table>
  
  
  
  </td>
  <td width="22%" align="center" valign="top">
  
  
<?php

//MtdObtenerFichaAccionesTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL)

$ManoObraTallerMecanica = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,ULL,NULL,NULL,false,false,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca);

$ManoObraPlanchadoPintado = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10002,MIN-10004",$POST_VehiculoMarca);

?>
  <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
    <tbody class="EstTablaReporteBody">
      <tr>
        <td colspan="2"><span class="EstTablaReporteSubtitulo">7. Venta mano de obra (Soles inc. IGV)</span></td>
      </tr>
      <tr>
        <td width="167">Taller de Mecánica:</td>
        <td width="41"><?php echo number_format($ManoObraTallerMecanica,2);?></td>
      </tr>
      <tr>
        <td>Planchado y pintura:</td>
        <td><?php echo number_format($ManoObraPlanchadoPintado,2);?></td>
      </tr>
      </tbody>
  </table></td>
  <td width="24%" align="center" valign="top">
  
  
  
  <?php
 
// MtdObtenerFichaAccionProductosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'FapId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oFichaAccionMantenimiento=NULL,$oEstricto=1,$oAccion=NULL,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL)

$VentaRepuestoTallerMecanica = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca,"RTI-10000");

$VentaRepuestoPlanchadoPintura = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10000");

?>
  <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
    <tbody class="EstTablaReporteBody">
      <tr>
        <td colspan="2"><span class="EstTablaReporteSubtitulo">8. Venta de repuestos (Soles inc. IGV)</span></td>
      </tr>
      <tr>
        <td width="167">Taller de mecánica:</td>
        <td width="41">
		<?php echo number_format($VentaRepuestoTallerMecanica,2);?>
        </td>
      </tr>
      <tr>
        <td>Planchado y pintura:</td>
        <td><?php echo number_format($VentaRepuestoPlanchadoPintura,2);?></td>
      </tr>
      </tbody>
  </table></td>
  </tr>
<tr>
<td>


</td>
<td></td>
<td colspan="2"></td>
</tr>
</table>





</body>
</html>