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
	header("Content-Disposition:  filename=\"ENTREGA_VEHICULO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2 and !empty($_GET['P'])){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<?php if($_GET['P']==1){?> 
<script type="text/javascript">

$().ready(function() {
	setTimeout("window.close();",2500);	
	window.print(); 
});

</script>
<?php }?>
<?php

$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);
$GET_Sucursal = (($_GET['Sucursal']));

require_once($InsPoo->MtdPaqLogistica().'ClsEntregaVentaVehiculo.php');

$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
//MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL)
if(empty($GET_FechaInicio)){
	exit("Ingrese una fecha de inicio");
}

if(empty($GET_FechaFin)){
	exit("Ingrese una fecha de termino");
}

if(empty($GET_Sucursal)){
	exit("Ingrese una sucursal");
}


//$ResEntregaVentaVehiculo = $InsEntregaVentaVehiculo->MtdObtenerEntregaVentaVehiculos(NULL,NULL,NULL,"EvvFechaProgramada","ASC",NULL,NULL,NULL,NULL,NULL,$GET_Sucursal,"EvvFechaProgramada");

$ResEntregaVentaVehiculo = $InsEntregaVentaVehiculo->MtdObtenerEntregaVentaVehiculos(NULL,NULL,NULL,"EvvFechaProgramada","ASC",NULL,FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),1,NULL,$GET_Sucursal,"EvvFechaProgramada");
$ArrEntregaVentaVehiculos = $ResEntregaVentaVehiculo['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
 <img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CALENDARIO DE ENTREGA DE VEHICULOS </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        
        

                
                
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">

        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="95%" align="center">
            
            
            
            <table width="70%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
                <tr>
                  <th width="17" align="center">
                  
                 # 
                  </th>
                  <th width="40" align="center">Fecha Programada</th>
                  <th width="36" align="center">Hora Programada</th>
                  <th width="86" align="center">Cliente</th>
                  <th width="59" align="center">Telf./ Celular</th>
                  <th width="63" align="center">Vehiculo</th>
                  <th width="72" align="center">Asesor de Ventas</th>
                  <th width="138" align="center">Observaciones</th>
                  <th width="60" align="center">Acciones</th>
                </tr>
                </thead>
                 <tbody class="EstTablaReporteBody">
                 <?php
				 if(!empty($ArrEntregaVentaVehiculos)){
					 $c = 1;
					 foreach($ArrEntregaVentaVehiculos as $DatEntregaVentaVehiculo){
				?>
                <tr>
                  <td align="left" valign="top"><?php echo $c;?></td>
                  <td align="left" valign="top"><?php echo $DatEntregaVentaVehiculo->EvvFechaProgramada;?></td>
                  <td align="left" valign="top"><?php echo $DatEntregaVentaVehiculo->EvvHoraProgramada;?></td>
                  <td align="left" valign="top"><?php echo $DatEntregaVentaVehiculo->CliNombre;?> <?php echo $DatEntregaVentaVehiculo->CliApellidoMaterno;?> <?php echo $DatEntregaVentaVehiculo->CliApellidoPaterno;?></td>
                  <td align="left" valign="top"><?php echo $DatEntregaVentaVehiculo->CliTelefono;?>/<?php echo $DatEntregaVentaVehiculo->CliCelular;?></td>
                  <td align="left" valign="top">
				  
				  <?php echo $DatEntregaVentaVehiculo->VmaNombre;?>
                  
				  <?php echo $DatEntregaVentaVehiculo->VmoNombre;?>
                  
                  <?php echo $DatEntregaVentaVehiculo->VveNombre;?>
                  
                  
                  
                  </td>
                  <td align="left" valign="top"><?php echo $DatEntregaVentaVehiculo->PerNombre;?> <?php echo $DatEntregaVentaVehiculo->PerNombreVendedor;?> <?php echo $DatEntregaVentaVehiculo->PerApellidoPaternoVendedor;?> <?php echo $DatEntregaVentaVehiculo->PerApellidoMaternoVendedor;?> </td>
                  <td align="left" valign="top"><?php echo $DatEntregaVentaVehiculo->EvvObservacion;?></td>
                  <td align="center" valign="top">
                  
                  <?php
//if($PrivilegioImprimir){
?>        
 <!-- <a href="principal.php?Mod=FichaIngreso&Form=Registrar&EvvId=<?php echo $DatEntregaVentaVehiculo->EvvId;?>&Origen=EntregaVentaVehiculo"><img src="imagenes/acciones/generar.png" width="19" height="19" border="0" title="Generar O.T." alt="[Generar O.T.]"   /></a>-->
<?php
//}
?>
</td>
                </tr>
               
                <?php		
						$c++; 
					 }	 
				 }
				 ?>
                 
                 
                
              </tbody>
            
            </table>
            
            
            </td>
            <td width="2%" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>