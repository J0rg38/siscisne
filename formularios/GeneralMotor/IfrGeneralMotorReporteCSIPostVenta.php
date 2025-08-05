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
//$POST_Sucursal = empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal'];
$POST_Sucursal = ($_GET['Sucursal']);

require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
//MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oCSIIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL)
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,"fin.FinId",1,NULL,true,$POST_VehiculoMarca,false,$POST_Sucursal);
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

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
          <td width="54%" rowspan="2" align="center" valign="top">CSI POST VENTAS
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
                    <th width="80" align="center">No. de OT</th>
                    <th width="80" align="center">Dealer Nombre</th>
                    <th width="80" align="center">Dealer Distrcit/City</th>
                    <th width="80" align="center">Fecha_Entrada OT</th>
                    <th width="80" align="center">Fecha de cierre OT</th>
                    <th width="80" align="center">Chasis/VIN</th>
                    <th width="80" align="center">Placa</th>
                    <th width="80" align="center">Cliente _ Nombre</th>
                    <th width="80" align="center">Cliente _ Apellido</th>
                    <th width="80" align="center">DNI</th>
                    <th width="80" align="center">Tipo de Evento</th>
                    <th width="80" align="center">Descripcion Trabajo</th>
                    <th width="80" align="center">Descripción del Modelo</th>
                    <th width="80" align="center">E-mail</th>
                    <th width="80" align="center">Nº Teléfono Residencia</th>
                    <th width="80" align="center">Nº Teléfono Celular</th>
                    <th width="80" align="center">Dirección del Comprador</th>
                    <th width="80" align="center">Ciudad</th>
                    <th width="80" align="center">Provincia</th>
                    <th width="80" align="center">DNI Técnico</th>
                    <th width="80" align="center">Nombre Técnico</th>
                    <th width="80" align="center">Apellido Técnico</th>
                    <th width="80" align="center">Kilometraje</th>
                    <th width="80" align="center">Total facturación repuestos</th>
                    <th width="80" align="center">Total facturación mano de obra</th>
                    <th width="80" align="center">Total facturación lubricantes</th>
                    <th width="80" align="center">Total otros</th>
                    <th width="80" align="center">Total facturado</th>
                  
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                       <?php
		$c=1;
         foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
			 
			 $DatReporteFichaIngreso->CliProvincia = trim($DatReporteFichaIngreso->CliProvincia);
        ?>
                        <tr>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $c?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                          
                        <?php echo $DatReporteFichaIngreso->FinId?>
                        
                          </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $EmpresaNombre ; ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  
						  
						  <?php echo $DatReporteFichaIngreso->SucDepartamento;  ?>
						  <?php //echo $EmpresaDepartamento;?>
                          
                          
                          </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->FinFecha;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->FinTiempoTrabajoTerminado;  ?></td>
                            <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteFichaIngreso->EinVIN);?></td>
                            <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteFichaIngreso->EinPlaca);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteFichaIngreso->CliNombre);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteFichaIngreso->CliApellidoPaterno);?> <?php echo ($DatReporteFichaIngreso->CliApellidoMaterno);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->CliNumeroDocumento;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteFichaIngreso->MinNombre);?> (<?php echo ($DatReporteFichaIngreso->FinMantenimientoKilometraje);?> km)</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->FinNota;  ?> </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->VmoNombre;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  
<?php
if(!empty($DatReporteFichaIngreso->CliEmail)){
?>
	<?php echo ($DatReporteFichaIngreso->CliEmail);?>
<?php	
}else if(!empty($DatReporteFichaIngreso->CliContactoEmail1)){
?>
	<?php echo ($DatReporteFichaIngreso->CliContactoEmail1);?>
<?php	
}else if(!empty($DatReporteFichaIngreso->CliContactoEmail2)){
?>
	<?php echo ($DatReporteFichaIngreso->CliContactoEmail2);?>
<?php	
}else if(!empty($DatReporteFichaIngreso->CliContactoEmail3)){
?>
	<?php echo ($DatReporteFichaIngreso->CliContactoEmail3);?>    
<?php	
}else if(!empty($DatReporteFichaIngreso->CliEmailFacturacion)){
?>
	<?php echo ($DatReporteFichaIngreso->CliEmailFacturacion);?>    
<?php	
}
?>


</td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->CliTelefono;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  
                          
                          <?php
                                if(!empty($DatReporteFichaIngreso->CliCelular)){
                                ?>
                                    <?php echo ($DatReporteFichaIngreso->CliCelular);?>
                                <?php	
                                }else if(!empty($DatReporteFichaIngreso->CliContactoCelular1)){
                                ?>
                                    <?php echo ($DatReporteFichaIngreso->CliContactoCelular1);?>
                                <?php	
                                }else if(!empty($DatReporteFichaIngreso->CliContactoCelular2)){
                                ?>
                                    <?php echo ($DatReporteFichaIngreso->CliContactoCelular2);?>
                                <?php	
                                }else if(!empty($DatReporteFichaIngreso->CliContactoCelular3)){
                                ?>
                                    <?php echo ($DatReporteFichaIngreso->CliContactoCelular3);?>  
                                <?php	
                                }
                                ?>
                                
                                
                                </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteFichaIngreso->CliDireccion);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  
						  <?php echo ( empty($DatReporteFichaIngreso->CliDepartamento)?$DatReporteFichaIngreso->SucDepartamento:$DatReporteFichaIngreso->CliDepartamento);  ?>
                          
                          
                          </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  
						  
						  <?php //echo $DatReporteFichaIngreso->;  ?>
                          
                           <?php echo ( empty($DatReporteFichaIngreso->CliProvincia)?$DatReporteFichaIngreso->SucDepartamento:$DatReporteFichaIngreso->CliDepartamento);  ?>
                          
                          </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->PerNumeroDocumento;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->PerNombre;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatReporteFichaIngreso->PerApellidoPaterno;  ?> <?php echo $DatReporteFichaIngreso->PerApellidoMaterno;  ?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo ($DatReporteFichaIngreso->FinVehiculoKilometraje);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  
						  <?php echo number_format($DatReporteFichaIngreso->RfiRepuestos,2);?> </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($DatReporteFichaIngreso->RfiManoObra,2);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                          
                          
                           <?php echo number_format($DatReporteFichaIngreso->RfiLubricantes,2);?>
                          </td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo number_format($DatReporteFichaIngreso->RfiOtros,2);?></td>
                          <td width="80" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
						  
						  
                           <?php echo number_format($DatReporteFichaIngreso->RfiTotales,2);?>
                           
                           
						  <?php
			/*switch($DatReporteFichaIngreso->FinComprobanteVentaTipo){
				
				case "F":
				
				$FichaIngresoModalidadFacturadoTotal++;
				$TotalFacturado += $DatReporteFichaIngreso->FacTotal;
			?>
                            <?php echo number_format($DatReporteFichaIngreso->FacSubTotal,2);?>
                            <?php	
				break;
				
				case "B":
				
				$FichaIngresoModalidadFacturadoTotal++;
				$TotalFacturado += $DatReporteFichaIngreso->BolTotal;
			?>
                            <?php echo number_format($DatReporteFichaIngreso->BolSubTotal,2);?>
                          <?php	
				break;
				
				default:
					$FichaIngresoModalidadNoFacturadoTotal++;
				break;
				
			}*/
			?></td>
                          
                            
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
                    
          
       
     

