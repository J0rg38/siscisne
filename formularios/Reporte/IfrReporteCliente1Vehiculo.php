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
	header("Content-Disposition:  filename=\"REPORTE_CLIENTE_MAS_1_UNIDAD_".date('d-m-Y').".xls\";");
}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_Sucursal = ($_GET['Sucursal']);

//$POST_Personal = ($_GET['Personal']);
$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"RovTotalUnidades";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";
//$POST_Moneda = isset($_GET['Moneda'])?$_GET['Moneda']:"MON-10001";

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');

$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();

//MtdObtenerOrdenVentaVehiculoCliente1Unidad($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculoCliente1Unidad(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_VehiculoMarca,$POST_Sucursal);
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];
//OvvTiempoSolicitudEnvio

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
          <td width="54%" align="center" valign="top">REPORTE DE CLIENTES QUE COMPRAR MAS DE 1 UNIDAD</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		
		?>
                     
                    <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="12%">SUCURSAL</th>
          <th width="10%">NUM. DOC.</th>
          <th width="23%">CLIENTE</th>
          <th width="8%" align="center">TELEFONO</th>
          <th width="7%" align="center">CELULAR</th>
          <th width="11%" align="center">EMAIL</th>
          <th width="17%" align="center">DIRECCION</th>
          <th width="10%" align="center">UNIDADES</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$SumaTotalOrdenVentaVehiculo = 0;
		$SumaTotalOrdenVentaVehiculoInicial = 0;
		$SumaTotalOrdenVentaVehiculoOtroAbono = 0;
		$SumaTotalOrdenVentaVehiculoPendiente = 0;
		
		$c=1;
        foreach($ArrReporteOrdenVentaVehiculos as $DatrReporteOrdenVentaVehiculo){

			if(($DatrReporteOrdenVentaVehiculo->RovTotalUnidades)>1){
				
		
        ?>
                    
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
                  <?php echo ($DatrReporteOrdenVentaVehiculo->SucNombre);?>
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatrReporteOrdenVentaVehiculo->CliNumeroDocumento);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatrReporteOrdenVentaVehiculo->CliNombre);?> <?php echo ($DatrReporteOrdenVentaVehiculo->CliApellidoPaterno);?> <?php echo ($DatrReporteOrdenVentaVehiculo->CliApellidoMaterno);?></td>
                <td align="right" valign="top"  ><?php echo ($DatrReporteOrdenVentaVehiculo->CliTelefono);?></td>
                <td align="right" valign="top"  ><?php echo ($DatrReporteOrdenVentaVehiculo->CliCelular);?></td>
                <td align="right" valign="top"  ><?php echo ($DatrReporteOrdenVentaVehiculo->CliEmail);?></td>
                <td align="right" valign="top"  ><?php echo ($DatrReporteOrdenVentaVehiculo->CliDireccion);?></td>
                <td align="right" valign="top"  ><?php echo ($DatrReporteOrdenVentaVehiculo->RovTotalUnidades);?></td>
          </tr>
	
              
        <?php
		 $c++;
		 	}
        }
        ?>
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
        
        
                  <tr>
                      <td  align="right" valign="middle"   >&nbsp;</td>
                      <td  align="right" valign="top"   >&nbsp;</td>
                      <td  align="right" valign="top"   >&nbsp;</td>
                      <td  align="right" valign="top"   >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
          </tr>
          
		</tfoot>
		</table>
                    
          
       
     

