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
	header("Content-Disposition:  filename=\"PREDICTIVO_MANTENIMIENTOS_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

</head>
<body>

<?php

$POST_finicio = isset($_POST['FechaInicio'])?$_POST['FechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['FechaFin'])?$_POST['FechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['Orden'])?$_POST['Orden']:"EinFichaIngresoFechaPredecida";
$POST_sen = isset($_POST['Sentido'])?$_POST['Sentido']:"DESC";

$POST_VehiculoMarca = isset($_POST['VehiculoMarca'])?$_POST['VehiculoMarca']:"";
$POST_Sucursal = isset($_POST['Sucursal'])?$_POST['Sucursal']:"";

//deb($_POST);
require_once($InsPoo->MtdPaqReporte().'ClsReportePredictivoMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoIngresoPredictivo.php');

$InsReportePredictivoMantenimiento = new ClsReportePredictivoMantenimiento();
$InsVehiculoIngresoPredictivo = new ClsVehiculoIngresoPredictivo();

//MtdObtenerReportePredictivoMantenimientos($oFechaInicio=NULL,$oFechaFin=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL){
	   
$ResReportePredictivoMantenimiento = $InsReportePredictivoMantenimiento->MtdObtenerReportePredictivoMantenimientos(FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ord,$POST_sen,NULL,$POST_VehiculoMarca,NULL,$POST_Sucursal);
$ArrReportePredictivoMantenimientos = $ResReportePredictivoMantenimiento['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">PREDICTIVO DE MANTENIMIENTOS DEL
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
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="8%">SUCURSAL</th>
          <th width="10%">VIN</th>
          <th width="5%">PLACA</th>
          <th width="6%">MARCA</th>
          <th width="7%">MODELO</th>
          <th width="7%">FECHA OT UTL.</th>
          <th width="5%">KM. OT ULT.</th>
          <th width="14%">PROX. FECHA ESTIMADA</th>
          <th width="12%">PROX. KM ESTIMADO</th>
          <th width="7%">CLIENTE</th>
          <th width="11%">CONTACTO</th>
          <th width="6%">ACCIONES</th>
          <th width="6%">NOTAS</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReportePredictivoMantenimientos as $DatReportePredictivoMantenimiento){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   >
		  
		  
		  <?php echo $c;?>
          <input  type="checkbox" name="CmpVehiculoIngresoId_<?php echo $DatReportePredictivoMantenimiento->EinId; ?>" id="CmpVehiculoIngresoId_<?php echo $DatReportePredictivoMantenimiento->EinId; ?>" value="<?php echo $DatReportePredictivoMantenimiento->EinId; ?>" etiqueta="cliente" style="visibility:hidden;" >
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   >
          
          
          
          
          <?php echo ($DatReportePredictivoMantenimiento->SucNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   >
		  
		<?php echo ($DatReportePredictivoMantenimiento->EinVIN);?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   ><?php echo ($DatReportePredictivoMantenimiento->EinPlaca);?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReportePredictivoMantenimiento->VmaNombre;  ?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReportePredictivoMantenimiento->VmoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReportePredictivoMantenimiento->EinFichaIngresoFechaUltimo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReportePredictivoMantenimiento->EinVIN;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReportePredictivoMantenimiento->EinFichaIngresoFechaPredecida;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReportePredictivoMantenimiento->EinFichaIngresoProximoMantenimientoKilometraje;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReportePredictivoMantenimiento->CliNombreCompleto;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReportePredictivoMantenimiento->CliCelular;  ?></td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
            <a href="javascript:FncVehiculoMantenimientoResumenListado('<?php echo $DatReportePredictivoMantenimiento->EinId;;?>');">Ver Mantenimientos</a>
                         
                         
                         
                         </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          <input name="CmpPredictivoObservacion_<?php echo $DatReportePredictivoMantenimiento->EinId?>"  type="text" class="EstFormularioCaja"  id="CmpPredictivoObservacion_<?php echo $DatReportePredictivoMantenimiento->EinId?>" value="<?php echo $DatReportePredictivoMantenimiento->EinPredictivoObservacion?>" size="25" maxlength="255">
          
          
          </td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>