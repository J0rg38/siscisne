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
	header("Content-Disposition:  filename=\"REPORTE_TIPO_REFERIDO_MODELO_".date('d-m-Y').".xls\";");
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



$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsTipoReferido = new ClsTipoReferido();


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
          <td width="54%" align="center" valign="top">REPORTE DE REFERIDOS X MODELO</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		$SumaTotalTipoReferidoModelo = 0;
		?>
                     
<table width="0%" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                     <th>MODELO</th>
                     
					<?php
                    foreach($ArrTipoReferidos as $DatTipoReferido){
						
						
						 $SumaTotalTipoRefereido[$DatTipoReferido->TrfId] = 0;
						 
                    ?>
                    
						<th width="70"><?php echo $DatTipoReferido->TrfNombre;?></th>
                    
                    <?php	 
                    }
                    ?>
                      
                      <th width="70" align="center">TOTAL</th>
                      </tr>
                      
                      
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                    
                    
                    <?php
					if(!empty($ArrVehiculoModelos)){
					?>
                        
                        <?php
                        foreach($ArrVehiculoModelos as $DatVehiculoModelo){
                            
                            $SumaTotalModelo = 0;
                        ?>
                    
                    
                     <tr>
                      <td>
					  
					  
					  <?php echo $DatVehiculoModelo->VmoNombre;?>
                      
                      
                      <?php
					  if(!empty($DatVehiculoModelo->VmoNombreComercial)){
						 ?>
                         ( <?php echo $DatVehiculoModelo->VmoNombreComercial;?>)
                         <?php 
						  
					  }
					  ?>
                      </td> 
                      
				<?php
                foreach($ArrTipoReferidos as $DatTipoReferido){
                ?>
                      <td width="70" align="center">
                      
                      <?php
					  
					  $InsCotizacionVehiculo = new ClsCotizacionVehiculo();
						//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL) {
					  $TotalModeloTipoReferido = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','Desc','1',FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"1,3",NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$POST_Sucursal,NULL,$DatTipoReferido->TrfId);
					
					  ?>

							<?php
                            echo  $TotalModeloTipoReferido;
                            ?>                      
                      
                      <?php
					  $SumaTotalModelo +=  $TotalModeloTipoReferido;
					  $SumaTotalTipoRefereido[$DatTipoReferido->TrfId] += $TotalModeloTipoReferido;
					  ?>
                      
                      </td>
                      
				<?php
                }
                ?>
                      <?php
                      $SumaTotalTipoReferidoModelo +=  $SumaTotalModelo;
                      ?>
                      <td width="70" align="center">
					  
					  <span class="EstTablaReporteContenidoTotal">
					  <?php echo $SumaTotalModelo;?>
                      </span>
                      </td>
                      </tr>
                 <?php	
					}
					?>
                      <?php	
					}
					?> 
					  <tr>
                        <td class="EstTablaReporteColumnaEspecial4">
                        
                        <span class="EstTablaReporteEtiquetaTotal">
                        Total General:</span>
                        
                        </td>
                       
                        <?php
                    foreach($ArrTipoReferidos as $DatTipoReferido){
                    ?>
                        <td width="70"   align="center" class="EstTablaReporteColumnaEspecial4">
                        
                         <span class="EstTablaReporteContenidoTotal">
                       <?php echo  $SumaTotalTipoRefereido[$DatTipoReferido->TrfId] ;?>
                       </span>
                        </td>
                           <?php
					}
					 ?> 
                        
                        
                        <td width="70" align="center" class="EstTablaReporteColumnaEspecial4">
                        
                        <span class="EstTablaReporteContenidoTotal">
                        <?php echo $SumaTotalTipoReferidoModelo;?>
                        </span>
                        
                        </td>
                        </tr>
                       
                      </tbody>
                    </table>
     

