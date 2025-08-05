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

//if($_GET['P']==2){
//	header("Content-type: application/vnd.ms-excel");
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_MSI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_Mes = isset($_GET['Mes'])?$_GET['Mes']:date("m");
$POST_Ano = isset($_GET['Ano'])?$_GET['Ano']:date("Y");
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Personal = ($_GET['Personal']);

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
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 
$CantidadDias = FncCantidadDiaMes($POST_Ano,$POST_Mes);




$PersonalNombre = "";

if(!empty($POST_Personal)){
	$InsPersonal->PerId = $POST_Personal;
	$InsPersonal->MtdObtenerPersonal();
	
	$PersonalNombre = $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno;
}


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
          <td width="54%" align="center" valign="top">REPORTE DE VENTA DE VEHICULOS DIARIO</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		
		?>
                     
                    <table class="EstTablaReporte" width="100%">
                  
                    
                    
                      <tr>
                      <td colspan="4" align="center">
                      
<?php
if(!empty($ArrSucursales )){
	foreach($ArrSucursales  as $DatSucursal){
		
?>

Sucursal:	<?php echo $DatSucursal->SucNombre;?>
<?php

$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculoPersonales(NULL,NULL,NULL,'OvvId','Desc','',$POST_Ano."-".$POST_Mes."-01",$POST_Ano."-".$POST_Mes."-".$CantidadDias,$DatSucursal->SucId,$POST_VehiculoMarca);
$ArrOrdenVentaVehiculoPersonales = $ResOrdenVentaVehiculo['Datos'];


?>

    <table class="EstTablaReporte" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th>&nbsp;</th>
          <th colspan="<?php echo ($CantidadDias+1);?>">
          
          MES DE <?php echo strtoupper(FncConvertirMes($POST_Mes));?> - <?php echo $POST_Ano;?>
          
          
          </th>
         
        </tr>
        <tr>
        
     
          <th width="200">ASESOR DE VENTAS</th>
         
         
         <?php
		 for($dia=1; $dia<=$CantidadDias; $dia++){
		 ?>
          <th width="50"><?php echo $dia;?></th>
          <?php
		 }
		  ?>
          
          <th>TOTAL</th>
          </tr>
         
          
        </thead>
        <tbody class="EstTablaReporteBody">
        
        <?php
		$c=1;
		
		$SumaTotalDia = array();
		
		foreach($ArrOrdenVentaVehiculoPersonales as $DatOrdenVentaVehiculoPersonal){
		?>
	
          <tr   >
          <td width="200" align="right" valign="middle" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   >
          
          
		  <?php echo $DatOrdenVentaVehiculoPersonal->PerNombre;?>
		  <?php echo $DatOrdenVentaVehiculoPersonal->PerApellidoPaterno;?>
		  <?php echo $DatOrdenVentaVehiculoPersonal->PerApellidoMaterno;?>
          </td>

			<?php
            $TotalAsesorMensual = 0;
            $TotalDia = 0;
            for($dia=1; $dia<=$CantidadDias; $dia++){
            ?>
                    <td width="50" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
						<?php
                        ////MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL)
                        $TotalDia = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Ano."-".$POST_Mes."-".$dia,$POST_Ano."-".$POST_Mes."-".$dia,array(2,3,4,5),NULL,$DatOrdenVentaVehiculoPersonal->PerId,NULL,$POST_VehiculoMarca,$DatSucursal->SucId);
						
						$SumaTotalDia[$dia] += $TotalDia;
                        ?>
                        
                        <?php echo ($TotalDia);?>
                        
                        <?php
                        $TotalAsesorMensual += $TotalDia;
                        ?>
                    
                    </td>
            <?php
            }
            ?>
<td align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">

<?php echo ($TotalAsesorMensual);
?></td>
          
          </tr>
       <?php
       $c++;
		}
		  ?>
           <tr   >
             <td align="right" valign="middle" class="EstTablaReporteColumnaEspecial4"  >TOTALES:</td>
            
            <?php
$TotalMensual = 0;
for($dia=1; $dia<=$CantidadDias; $dia++){
?>
            
             <td align="right" class="EstTablaReporteColumnaEspecial4" ><?php echo $SumaTotalDia[$dia];?></td>
             
<?php
	$TotalMensual+= $SumaTotalDia[$dia];
}
?>
             
             <td align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $TotalMensual;?></td>
          </tr>
          
        </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
<?php		
	}
}
?>
                
                    
                    
                    
                    </td>
                    </tr>
                    
                      <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                    </table>
                    
          
       
     

