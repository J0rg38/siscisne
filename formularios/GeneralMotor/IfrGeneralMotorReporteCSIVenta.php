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
        


$POST_finicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_GET['FechaFin'])?$_GET['FechaFin']:"15/".date("m/Y");

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"CliNombre";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"ASC";
$POST_VehiculoMarca = ($_GET['VehiculoMarca']);
$POST_Sucursal = ($_GET['Sucursal']);

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');


$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();

//MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL) 
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoClientes(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_VehiculoMarca,$POST_Sucursal);
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];

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
          <td colspan="4" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
        </tr>
        <tr>
          <td width="23%" rowspan="2" align="left" valign="top"><?php
                if(!empty($InsVehiculoMarca->VmaFoto)){
                ?>
            <img src="../../subidos/vehiculo_marca/<?php echo $InsVehiculoMarca->VmaFoto;?>" width="271" height="92" />
            <?php
                }else{
                ?>
        -
        <?php	
                }
                ?></td>
          <td width="54%" rowspan="2" align="center" valign="top">CSI VENTAS
      </td>
          <td width="23%" rowspan="2" align="right" valign="top">&nbsp;</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        <tr>
          <td align="right" valign="top">Mes y a&ntilde;o: <?php echo FncConvertirMes($POST_Mes);?> <?php echo $POST_Ano;?></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		
                     
                    <table class="EstTablaReporte" width="100%">
                    <tr>
                      <td colspan="4" align="center" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="4">
                      
                      
                
                    <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                      <th width="80" align="center">#</th>
                      <th width="80" align="center">Pais</th>
                      <th width="80" align="center">Marca</th>
                      <th width="80" align="center"><strong>N°  Factura</strong></th>
                      <th width="80" align="center">Dealer  BAC</th>
                      <th width="80" align="center"><strong>Dealer   SAP Code</strong></th>
                    <th width="80" align="center">Dealer Nombre</th>
                    <th width="80" align="center">Dealer Distrcit/City</th>
                    <th width="80" align="center">Fecha de Entrega</th>
                    <th width="80" align="center">Chasis/VIN</th>
                    <th width="80" align="center">Cliente Nombre</th>
                    <th width="80" align="center">Cliente Apellido</th>
                    <th width="80" align="center"><strong>Tipo  de Evento</strong></th>
                    <th width="80" align="center">Codigo Modelo</th>
                    <th width="80" align="center">Modelo</th>
                    <th width="80" align="center">Descripcion Modelo</th>
                    <th width="80" align="center">E-Mail</th>
                    <th width="80" align="center"><strong>Nº  Teléfono Residencia</strong></th>
                    <th width="80" align="center"><strong>Nº  Teléfono Celular</strong></th>
                    <th width="80" align="center"><strong>Dirección  del Comprador</strong></th>
                    <th width="80" align="center"><strong>Dirección  del Comprador 2</strong></th>
                    <th width="80" align="center">Ciudad</th>
                    <th width="80" align="center">Provincia</th>
                    <th width="80" align="center">DNI Vendedor</th>
                    <th width="80" align="center">Nombre Vendedor</th>
                    <th width="80" align="center">Apellido Vendedor</th>
                    <th width="80" align="center">Region</th>
                  
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                       <?php
		$c=1;
        foreach($ArrReporteOrdenVentaVehiculos as $DatReporteOrdenVentaVehiculo){
        ?>
                        <tr>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $c ; ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $EmpresaPais ; ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->VmaNombre;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->OvvFacturaNumero?> <?php echo $DatReporteOrdenVentaVehiculo->OvvBoletaNumero?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">-</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">-</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $EmpresaNombre ; ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->SucDepartamento;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->OvvFechaEntrega;  ?></td>
                            <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteOrdenVentaVehiculo->EinVIN);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteOrdenVentaVehiculo->CliNombre);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteOrdenVentaVehiculo->CliApellidoPaterno);?> <?php echo ($DatReporteOrdenVentaVehiculo->CliApellidoMaterno);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">-</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">-</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->VmoNombre;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">-</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  


<?php
if(!empty($DatReporteOrdenVentaVehiculo->CliEmail)){
?>
	<?php echo ($DatReporteOrdenVentaVehiculo->CliEmail);?>
<?php	
}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoEmail1)){
?>
	<?php echo ($DatReporteOrdenVentaVehiculo->CliContactoEmail1);?>
<?php	
}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoEmail2)){
?>
	<?php echo ($DatReporteOrdenVentaVehiculo->CliContactoEmail2);?>
<?php	
}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoEmail3)){
?>
	<?php echo ($DatReporteOrdenVentaVehiculo->CliContactoEmail3);?>    
<?php	
}else if(!empty($DatReporteOrdenVentaVehiculo->CliEmailFacturacion)){
?>
	<?php echo ($DatReporteOrdenVentaVehiculo->CliEmailFacturacion);?>    
<?php	
}
?>



</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->CliTelefono;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
	
								<?php
                                if(!empty($DatReporteOrdenVentaVehiculo->CliCelular)){
                                ?>
                                    <?php echo ($DatReporteOrdenVentaVehiculo->CliCelular);?>
                                <?php	
                                }else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoCelular1)){
                                ?>
                                    <?php echo ($DatReporteOrdenVentaVehiculo->CliContactoCelular1);?>
                                <?php	
                                }else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoCelular2)){
                                ?>
                                    <?php echo ($DatReporteOrdenVentaVehiculo->CliContactoCelular2);?>
                                <?php	
                                }else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoCelular3)){
                                ?>
                                    <?php echo ($DatReporteOrdenVentaVehiculo->CliContactoCelular3);?>  
                                <?php	
                                }
                                ?>
                                
                          </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteOrdenVentaVehiculo->CliDireccion);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">-</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->CliDepartamento;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->CliProvincia;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->PerNumeroDocumento;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->PerNombre;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteOrdenVentaVehiculo->PerApellidoPaterno;  ?> <?php echo $DatReporteOrdenVentaVehiculo->PerApellidoMaterno;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">&nbsp;</td>
                          
                            
                        </tr>
                       <?php
					   $c++;
		}
					   ?>
                      </tbody>
                    </table>
                    
                    
                    
                    
                      </td>
                    </tr>
                    <tr>
                    <td width="27%">
                    
                    
                    </td>
                    <td width="27%"></td>
                    <td colspan="2"></td>
                    </tr>
                    </table>
                    
          
       
     

