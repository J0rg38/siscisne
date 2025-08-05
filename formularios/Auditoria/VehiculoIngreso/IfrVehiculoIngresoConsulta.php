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
	header("Content-Disposition:  filename=\"CONSULTA_PRODUCTO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

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


$POST_VehiculoIngresoId = $_POST['CmpVehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_POST['CmpVehiculoIngresoVIN'];

if(empty($POST_VehiculoIngresoVIN)){
	die( "No ha ingresado un numero de VIN");
}
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();

if(empty($POST_VehiculoIngresoId)){
	
	$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"EinVIN","ASC","1",NULL,NULL,NULL);
	$ArrVehiculosIngresos = $ResVehiculoIngreso['Datos'];
	
	foreach($ArrVehiculosIngresos as $DatVehiculoIngreso){
		$POST_VehiculoIngresoId = $DatVehiculoIngreso->EinId;
	}
}

$InsVehiculoIngreso->EinId = $POST_VehiculoIngresoId;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CONSULTA DE VIN/PLACA


 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        
<?php

if(!empty($POST_VehiculoIngresoVIN)){
	
	?>
    
      <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">

        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="center"><span class="EstReporteTitulo">DATOS DEL VEHICULO</span></td>
          </tr>
          <tr>
            <td width="98%" align="center">
            
            
            
            <table width="70%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
             <thead class="EstTablaReporteHead">
              <tr>
                  <th colspan="6" align="center" valign="top"><span class="EstTablaReporteEtiqueta">VIN :</span>  <?php echo $InsVehiculoIngreso->EinVIN;?>&nbsp;</th>
                  </tr>
               
              </thead>
                 <tbody class="EstTablaReporteBody">
                <tr>
                  <td width="13%" align="left" valign="top"><span class="EstTablaReporteEtiqueta"> Marca: </span></td>
                  <td align="left" valign="top"><?php echo $InsVehiculoIngreso->VmaNombre;?>&nbsp;</td>
                  <td width="19%" align="left" valign="top"><span class="EstTablaReporteEtiqueta"> Modelo: </span></td>
                  <td width="17%" align="left" valign="top"><span class="EstTablaReporteContenido"> <?php echo $InsVehiculoIngreso->VmoNombre;?> </span>&nbsp;</td>
                  <td width="14%" align="left" valign="top"><span class="EstTablaReporteEtiqueta"> Version: </span></td>
                  <td align="left" valign="top"><span class="EstTablaReporteContenido"> <?php echo $InsVehiculoIngreso->VveNombre;?> </span>&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><span class="EstTablaReporteEtiqueta"> Año Fabric.:</span>&nbsp;</td>
                  <td align="left" valign="top"><?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>&nbsp;</td>
                  <td align="left" valign="top"><span class="EstTablaReporteEtiqueta"> Numero de Motor: </span></td>
                  <td align="left" valign="top"><?php echo $InsVehiculoIngreso->EinNumeroMotor;?>&nbsp;</td>
                  <td align="left" valign="top"><span class="EstTablaReporteEtiqueta"> Transmision: </span></td>
                  <td align="left" valign="top"><?php
				  echo $InsVehiculoIngreso->EinTransmision;
				  ?>&nbsp;</td>
                  </tr>
                <tr>
                  <td width="13%" align="left" valign="top">
                  <span class="EstTablaReporteEtiqueta"> 
                  Placa:
                  
                  </span></td>
                  <td width="18%" align="left" valign="top"><?php echo $InsVehiculoIngreso->EinPlaca;?>&nbsp;</td>
                  <td align="left" valign="top"> <span class="EstTablaReporteEtiqueta"> 
               Estado:
                  
                  </span></td>
                  <td align="right" valign="top">
				  
				  
				  <?php echo strtoupper($InsVehiculoIngreso->EinEstadoVehicular);?>
                  
                  
                  </td>
                  <td align="right" valign="top"><span class="EstTablaReporteEtiqueta">Registrado en Sistema:</span></td>
                  <td width="19%" align="left" valign="top"><span class="EstTablaReporteContenido"><?php echo $InsVehiculoIngreso->EinTiempoCreacion?></span>&nbsp;</td>
                </tr>
             
              </tbody>
            
            </table></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><span class="EstReporteTitulo">DATOS DE LA VENTA</span></td>
          </tr>
          <tr>
            <td align="center"><table width="70%" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
              <thead class="EstTablaReporteHead">
                <tr>
                  <th colspan="6" align="center" valign="top"><span class="EstTablaReporteEtiqueta">VIN :</span> <?php echo $InsVehiculoIngreso->EinVIN;?>&nbsp;</th>
                </tr>
              </thead>
              <tbody class="EstTablaReporteBody">
                <tr>
                  <td width="13%" align="left" valign="top"><span class="EstTablaReporteEtiqueta">Comprobante:</span></td>
                  <td width="18%" align="left" valign="top">
                  <?php
				  if(!empty($InsVehiculoIngreso->OvvFactura)){
					 ?>
                     Factura
                     <?php
				  }elseif(!empty($InsVehiculoIngreso->OvvBoleta)){
					  ?>
                      Boleta
                      <?php
				  }else{
					?>
                    Otros
                    <?php  
				  }
				  ?>
                  &nbsp;</td>
                  <td width="19%" align="left" valign="top"><span class="EstTablaReporteEtiqueta">Num. Comprob.</span></td>
                  <td width="17%" align="left" valign="top"><span class="EstTablaReporteContenido"> 
				  <?php echo $InsVehiculoIngreso->OvvFactura;?>
                  <?php echo $InsVehiculoIngreso->OvvBoleta;?>
                  </span>&nbsp;</td>
                  <td width="14%" align="left" valign="top"><span class="EstTablaReporteEtiqueta"> Fecha:</span></td>
                  <td width="19%" align="left" valign="top"><span class="EstTablaReporteContenido"> <?php echo $InsVehiculoIngreso->OvvFacturaFecha;?> <?php echo $InsVehiculoIngreso->OvvBoletaFecha;?></span>&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><span class="EstReporteTitulo">PROPIETARIOS</span></td>
          </tr>
          <tr>
            <td align="center">
              
              
              
              <?php



    //public function MtdObtenerVehiculoIngresoClientes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VicId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL,$oCliente=NULL)
	
	
	$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
	
	$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,"CliNombre","ASC",NULL,$InsVehiculoIngreso->EinId,NULL);
	$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
?>
              
              
              <?php
    if(empty($ArrVehiculoIngresoClientes)){
    ?>
              No se encontraron propietarios para este vehiculo
              <?php
    }else{
    ?>
              
              <table class="EstTablaReporteListado" width="100%" cellpadding="0" cellspacing="0" border="0">
                <thead class="EstTablaReporteListadoHead">
                  <tr>
                    <th width="2%" align="center">#</th>
                    <th width="12%" align="center">Num. Doc.</th>
                    <th width="32%" align="center"> Nombre</th>
                    <th width="16%">Telefono</th>
                    <th width="16%">Celular</th>
                    <th width="22%">Email</th>
                  </tr>
                </thead>
                <tbody class="EstTablaReporteListadoBody">
                  <?php
                $c = 1;
                foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
                ?>
                  <tr>
                    <td align="right" valign="top"><?php echo $c;?></td>
                    <td align="right" valign="top"><?php echo $DatVehiculoIngresoCliente->CliNumeroDocumento;?></td>
                    <td align="right" valign="top">
                      <?php echo $DatVehiculoIngresoCliente->CliNombre;?>
                      <?php echo $DatVehiculoIngresoCliente->CliApellidoPaterno;?>
                      <?php echo $DatVehiculoIngresoCliente->CliApellidoMaterno;?>
                      
                    </td>
                    <td align="right" valign="top"><?php echo $DatVehiculoIngresoCliente->CliTelefono;?>
                      &nbsp;
                      
                      
                    </td>
                    <td align="right" valign="top"><?php echo $DatVehiculoIngresoCliente->CliCelular;?>&nbsp;</td>
                    <td align="right" valign="top"><?php echo $DatVehiculoIngresoCliente->CliEmail;?>&nbsp;</td>
                    </tr>
                  <?php
                    $c++;
                }
                ?>
                </tbody>
              </table>
              <?php
    }
    ?>
              
              
              
            </td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><span class="EstReporteTitulo">ORDENES DE TRABAJO</span></td>
          </tr>
          <tr>
            <td align="center">
              
              
              <?php

	$InsFichaIngreso = new ClsFichaIngreso();
	
	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"FinFecha","DESC",NULL,NULL,NULL,NULL,NULL,NULL);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
?>
              
              
              <?php
    if(empty($ArrFichaIngresos)){
    ?>
              No se encontraron registros de ordenes de trabajo
              <?php
    }else{
    ?>
              
              <table class="EstTablaReporteListado" width="100%" cellpadding="0" cellspacing="0" border="0">
                <thead class="EstTablaReporteListadoHead">
                  <tr>
                    <th width="2%" align="center">#</th>
                    <th width="7%" align="center">O.T.</th>
                    <th width="10%" align="center"> Fecha</th>
                    <th width="33%" align="center">Observaciones</th>
                    <th width="17%">Modalidades</th>
                    <th width="16%">Kilometraje</th>
                    <th width="12%">Plan Mant.</th>
                    <th width="3%" align="center"> Acc.</th>
                  </tr>
                </thead>
                <tbody class="EstTablaReporteListadoBody">
                  <?php
                $c = 1;
                foreach($ArrFichaIngresos as $DatFichaIngreso){
                ?>
                  <tr>
                    <td align="right" valign="top"><?php echo $c;?></td>
                    <td align="right" valign="top"><?php echo $DatFichaIngreso->FinId;?></td>
                    <td align="right" valign="top">
                    <?php echo $DatFichaIngreso->FinFecha;?></td>
                    <td align="right" valign="top"><?php echo $DatFichaIngreso->FinSalidaObservacion;?></td>
                    <td align="right" valign="top">
                      
                      <?php
$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatFichaIngreso->FinId,NULL);
$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
?>
                      
                      <?php
foreach($ArrFichaIngresoModalidades  as $DatFichaIngresoModalidad){
?>
                      <?php echo $DatFichaIngresoModalidad->MinNombre;?> [<?php echo $DatFichaIngresoModalidad->MinSigla;?>]<br />
                      <?php	
}
?>
                      
                    </td>
                    <td align="right" valign="top"><?php echo $DatFichaIngreso->FinVehiculoKilometraje;?>km</td>
                    <td align="right" valign="top">
                      <?php echo $DatFichaIngreso->FinMantenimientoKilometraje;?>km
                      
                      
                      
                    </td>
                    <td align="center">
                      
                      
                      
                      <a href="javascript:FncPopUp('../../formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id=<?php echo $DatFichaIngreso->FinId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img border="0"  align="absmiddle" src="../../imagenes/iconos/ficha_tecnica.png" alt="[Ver]" title="Ver Ficha Tecnica" width="15" height="15"  /></a>
                      
                    </td>
                    </tr>
                  <?php
                    $c++;
                }
                ?>
                </tbody>
              </table>
              <?php
    }
    ?>
              
              
              
              
            </td>
          </tr>
          <tr>
            <td align="center"><span class="EstReporteTitulo">ACCIONES</span></td>
          </tr>
          <tr>
            <td align="center">
            
<a target="_parent" class="EstBotonIcono" href="../../principal.php?Mod=FichaIngreso&Form=Registrar&Origen=ConsultaVIN&EinId=<?php echo $InsVehiculoIngreso->EinId?>"><img src="../../imagenes/nicono/orden_trabajo.png" alt="[Registrar]" title="Registrar" border="0" align="absmiddle" width="40" height="40" /> Registrar Orden de Trabajo</a> 


<a target="_parent" class="EstBotonIcono" href="../../principal.php?Mod=CotizacionProducto&Form=Registrar&Origen=ConsultaVIN&EinId=<?php echo $InsVehiculoIngreso->EinId?>"><img src="../../imagenes/nicono/cotizacion_repuesto.png" alt="[Registrar]" title="Registrar" border="0" align="absmiddle" width="40" height="40" /> Registrar Cotizacion</a> 




</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>



<?php
}else{
?>

No se encontro VIN del vehiculo

<?php	
}

?>
      


</body>
</html>