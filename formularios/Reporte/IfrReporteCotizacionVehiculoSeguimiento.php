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
	header("Content-Disposition:  filename=\"REPORTE_COTIZACION_VEHICULO_SEGUIMIENTO_".date('d-m-Y').".xls\";");
}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Vista = ($_GET['Vista']);




//deb($POST_Mes);
if(empty($POST_VehiculoMarca)){
die("No ha escogido una marca de vehiculo");
} 

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoReferido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');



$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsTipoReferido = new ClsTipoReferido();
$InsCotizacionVehiculo = new ClsCotizacionVehiculo();


$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 

$ResTipoReferido = $InsTipoReferido->MtdObtenerTipoReferidos("TrfNombre",$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_Tipo,$POST_Estado);
$ArrTipoReferidos = $ResTipoReferido['Datos'];

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_VehiculoMarca,1);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,$POST_Personal,NULL,$POST_Sucursal);
$ArrCotizacionVehiculos = $ResCotizacionVehiculo['Datos'];

?>


<?php
if($_GET['P']<>2 and !empty($_GET['P'])){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

<?php if($_GET['P']==1){?> 

<script type="text/javascript">

$().ready(function() {
	setTimeout("window.close();",2500);	
	window.print(); 
});

</script>

<?php }?>


        <?php if($_GET['P']==1){?>
        <table cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr>
          <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
        </tr>
        <tr>
          <td width="23%" align="left" valign="top">
		  
		  
		  
            <img src="../../imagenes/logos/logo_reporte.png" width="150"  />
            </td>
          <td width="54%" align="center" valign="top">REPORTE DE SEGUIMIENTO DE COTIZACIONES</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		$SumaTotalTipoReferidoModelo = 0;
		?>
                     
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th>#</th>
          <th>Sucursal</th>
          <th>Fecha</th>
          <th>Num. Doc.</th>
          <th>Cliente</th>
          <th>Asesor</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Ref.</th>
          <th>Departamento</th>
          <th>Distrito</th>
          <th>Telefono</th>
          <th>Celular</th>
          <th>E-mail</th>
          <th>Moneda</th>
          <th>Precio</th>
          <th>Tipo de Cliente</th>
          <th>GLP</th>
          <th>Grado Interes</th>
          <th>Seguimiento</th>
          <th>Contacto I</th>
          <th>Contacto II</th>
          <th>Contacto III</th>
          <th>Recordatorio de Contacto de Cliente</th>
          <th>Status</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        


    
<?php
$i = 1;
foreach($ArrCotizacionVehiculos as $DatCotizacionVehiculo){
?>

   <?php $DatCotizacionVehiculo->CveTotal = (($DatCotizacionVehiculo->CveTotal/(empty($DatCotizacionVehiculo->CveTipoCambio)?1:$DatCotizacionVehiculo->CveTipoCambio)));?>
       
                  <tr>
                    <td  align="right" valign="middle"   ><?php echo $i;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->SucNombre;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveFecha;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliNumeroDocumento;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliNombre;?> <?php echo $DatCotizacionVehiculo->CliApellidoPaterno;?> <?php echo $DatCotizacionVehiculo->CliApellidoMaterno;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->PerNombre;?> <?php echo $DatCotizacionVehiculo->PerApellidoPaterno;?> <?php echo $DatCotizacionVehiculo->PerApellidoMaterno;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->VmaNombre;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->VmoNombre;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->TrfNombre;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliDepartamento;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliDistrito;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliTelefono;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliCelular;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliEmail;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->MonSimbolo;?></td>
                    <td  align="right" valign="top"   ><?php echo number_format($DatCotizacionVehiculo->CveTotal,2);?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->LtiNombre;?></td>
                    <td  align="right" valign="top"   >
                    
                    
                    
                    <?php
                    switch($DatCotizacionVehiculo->CveGLP){
						case "Si":
					?>
                    Si
                    <?php
						break;

						case "No":
?>
No
<?php
						break;
						
						default:
?>
-
<?php
						break;
						
					
					}
					
					
					?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveNivelInteresDescripcion;?></td>
                    <td  align="right" valign="top"   >
                    
                    
                    
                    
<?php
  				  $InsCotizacionVehiculoLlamada = new ClsCotizacionVehiculoLlamada();
				$ResCotizacionVehiculoLlamada =  $InsCotizacionVehiculoLlamada->MtdObtenerCotizacionVehiculoLlamadas(NULL,NULL,"CvlId","ASC",NULL,$DatCotizacionVehiculo->CveId,NULL);
				$ArrCotizacionVehiculoLlamadas = 	$ResCotizacionVehiculoLlamada['Datos'];	
?>

<?php
if(!empty($ArrCotizacionVehiculoLlamadas)){
?>
Si
<?php	
}else{
?>
No
<?php	
}
?>                    
                    
                    </td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliContactoCelular1;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliContactoCelular2;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CliContactoCelular3;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveNota;?></td>
                    <td  align="right" valign="top"   ><?php echo $DatCotizacionVehiculo->CveStatusDescripcion;?></td>
                  </tr>
         
<?php
$i++;
}
?>
      
              
  
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
     

