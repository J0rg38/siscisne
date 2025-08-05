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
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_KPI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_Mes = empty($_GET['Mes'])?date("m"):$_GET['Mes'];
$POST_Ano = empty($_GET['Ano'])?date("Y"):$_GET['Ano'];
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10018":$_GET['VehiculoMarca'];
$POST_Sucursal = empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal'];

//deb($POST_VehiculoMarca);
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFacturacion.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOS.php');

require_once($InsPoo->MtdPaqActividad().'ClsCita.php');

$InsTallerPedido = new ClsTallerPedido();
$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();

$InsVentaConcretada = new ClsVentaConcretada();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();

$InsFichaIngreso = new ClsFichaIngreso();

$InsPersonal = new ClsPersonal();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsFichaAccionProducto = new ClsFichaAccionProducto();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsCita = new ClsCita();
$InsReporteCOS = new ClsReporteCOS();

$InsPersonal->PerId = "PER-10016";
$InsPersonal->MtdObtenerPersonal();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
		

$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano);

$FechaInicio = $POST_Ano."-01-01";
$FechaFin = $POST_Ano."-".$POST_Mes."-".$CantidadDias;

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
  <td width="54%" rowspan="2" align="center" valign="top">CONTROL DE OPERACIONES DE SERVICIO COS - MECANICA</td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
<tr>
  <td align="right" valign="top">A&ntilde;o: <?php echo $POST_Ano;?></td>
</tr>
</table>

<hr class="EstReporteLinea">

<?php }?>
                

                     
  
                    


<table class="EstTablaReporte" width="100%">
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
                              <td>-</td>
                            </tr>
                            <tr>
                              <td>Area total de    almacen (m2):</td>
                              <td>30 M2</td>
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
                      <td width="46%" colspan="2" align="center" valign="top">
                        
                        
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
                    <td>
                    
                    
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                    </tr>
        </table>


 1. Control de unidades ingresadas    
                    
<table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>
                    Tipo de Servicio</th>
                    <?php
                    for($mes=1;$mes<=12;$mes++){
						$TotalIngresoTipoMensual[$mes] = 0;
                    ?>
                    <th width="60" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                    <?php
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
                    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                        <?php
                        if($DatKilometro['km']<=50000){
                        ?>
                        	<tr>
								
                                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                                    Servicio <?php echo $DatKilometro['km'];?>
                                </td>
                                
                                	<?php
                                    for($mes=1;$mes<=$POST_Mes;$mes++){
                                    ?>
                                        <td width="60" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                            
                                        <?php
										//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                        $FichaIngresoMantenimientoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
                                     	$TotalIngresoTipoMensual[$mes] += $FichaIngresoMantenimientoMensualTotal;
                                        ?>
                                        
                                        <?php
                                        if(!empty($FichaIngresoMantenimientoMensualTotal)){
                                        ?>
                                        
                                        <?php echo $FichaIngresoMantenimientoMensualTotal;?>
                                        
                                        <?php
                                        }
                                        ?>
                                      
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
                        $FichaIngresoMantenimiento50TotalMensual = array();
                        ?>
                    <?php
                    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                       
                        <?php
                        if($DatKilometro['km']>50000){
                        ?>
                            <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                            
								<?php
								//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
								$FichaIngresoMantenimiento50TotalMensual[$mes] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
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
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="60" align="center" class="EstTablaReporteColumnaEspecial1">
                                
                                <?php
								$TotalIngresoTipoMensual[$mes] += $FichaIngresoMantenimiento50TotalMensual[$mes];
								?>
                             
                                <?php
                                if(!empty($FichaIngresoMantenimiento50TotalMensual[$mes])){
                                ?>
                                    <?php echo $FichaIngresoMantenimiento50TotalMensual[$mes];?>
                                <?php
                                }
                                ?>
                                
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
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="60" align="center" class="EstTablaReporteColumnaEspecial2">
                                
                              <?php
								//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoReparacionMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10003,MIN-10019,MIN-10020,MIN-10021",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,true,$POST_Sucursal,NULL) ;
                                ?>
                    
                                <?php 
								$FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionMensualTotal;
								$TotalIngresoTipoMensual[$mes] += $FichaIngresoReparacionMensualTotal;
								?>
            
                                <?php
                                if(!empty($FichaIngresoReparacionMensualTotal)){
                                ?>
                                    <?php echo $FichaIngresoReparacionMensualTotal;?>
                                <?php
                                }
                                ?>
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
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="60" align="center" class="EstTablaReporteColumnaEspecial3">
                                
                                
                               <?php               
							   //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)     
                                $FichaIngresoTrabajoInternoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
                                ?>
                                <?php 
								$FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoMensualTotal;
								$TotalIngresoTipoMensual[$mes] += $FichaIngresoTrabajoInternoMensualTotal;
								?>
            
                                
                                <?php
                                if(!empty($FichaIngresoTrabajoInternoMensualTotal)){
                                ?>
                                 <?php echo $FichaIngresoTrabajoInternoMensualTotal;?>                    
                                <?php
                                }
                                ?> 
                                
                  </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                        
                            <tr>
                              <td class="EstTablaReporteColumnaEspecial4">Garantias</td>
                            
                             <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                              <td width="60" align="center" class="EstTablaReporteColumnaEspecial4">
                              
                               <?php
								//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL) 
                                $FichaIngresoGarantiaMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10000",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
                               	 ?>
                                <?php 
								$FichaIngresoGarantiaSumaTotal += $FichaIngresoGarantiaMensualTotal ;
								$TotalIngresoTipoMensual[$mes] += $FichaIngresoGarantiaMensualTotal;
								?>
            
                                <?php
                                if(!empty($FichaIngresoGarantiaMensualTotal)){
                                ?>
                                 <?php echo $FichaIngresoGarantiaMensualTotal;?>                    
                                <?php
                                }
                                ?> 
                              
                              </td>
                            <?php	
                            }
                            ?>
                            
                            
                            </tr>
                            <tr>
                              <td class="EstTablaReporteColumnaEspecial5">Siniestros</td>
                                 <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                              <td align="center" class="EstTablaReporteColumnaEspecial5">
                              
                              
                               <?php
							   ////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoSiniestroMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
								
								 ?>
                                <?php 
								$FichaIngresoSiniestroSumaTotal += $FichaIngresoSiniestroMensualTotal ;
								$TotalIngresoTipoMensual[$mes] += $FichaIngresoSiniestroMensualTotal;
								?>
                                
                                <?php
                                if(!empty($FichaIngresoReingresoMensualTotal)){
                                ?>
                                 <?php echo $FichaIngresoReingresoMensualTotal;?>                    
                                <?php
                                }
                                ?> 
                              
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
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                              <td width="60" align="center" class="EstTablaReporteColumnaEspecial5">
                              
                               <?php
							   ////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoReingresoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
								$FichaIngresoReingresoSumaTotal += $FichaIngresoReingresoMensualTotal ;
								
								$TotalIngresoTipoMensual[$mes] += $FichaIngresoReingresoMensualTotal;
								?>
                                
                                <?php
                                if(!empty($FichaIngresoReingresoMensualTotal)){
                                ?>
                                 <?php echo $FichaIngresoReingresoMensualTotal;?>                    
                                <?php
                                }
                                ?> 
                              
                              </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                            <tr>
                              <td class="EstTablaReporteColumnaEspecial5">Total ingresos por tipo</td>
                             
                              <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                              <td align="center" class="EstTablaReporteColumnaEspecial5">
	 <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
							   <?php
                               echo $TotalIngresoTipoMensual[$mes];
                               ?>
                              <?php
							}
                              ?>
                              </td>
                              
                                <?php	
                            }
                            ?>
                            </tr>
                            
                       
                    
                    </tbody>
                    </table>




<br>

         
         
       <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>
                    Ingreso por modelo</th>
                    <?php
                    for($mes=1;$mes<=12;$mes++){
						
							$TotalIngresoTipoMensualModelo[$mes] = 0;
                    ?>
                    <th width="60" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                 
                    <tbody class="EstTablaReporteBody">
                   
                        <tr>
                          <td >NLR 3 TON</td>
                           
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                          	 <?php
							 //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
								$FichaIngresoMantenimientoMensualTotalNLR3TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10091",false,$POST_Sucursal,NULL) ;
								
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalNLR3TON ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalNLR3TON;
								?>
                                <?php
							}
								?>
                                  </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >REWARD 400DT</td>
                         
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" > 
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                           <?php
						   //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoMantenimientoMensualTotalREWARD400DT = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10076",false,$POST_Sucursal,NULL) ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalREWARD400DT ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalREWARD400DT;
								?>
                                <?php
							}
								?>
                                 </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td>NPR 4 TON</td>
                         
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >  
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                            <?php
							//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoMantenimientoMensualTotalNPR4TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10084",false,$POST_Sucursal,NULL) ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalNPR4TON ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalNPR4TON;
								?>
                                <?php
							}
								?>
                                
                                </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >REWARD 500</td>
                          
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" > 
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                            	<?php
								//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoMantenimientoMensualTotalNREWARD500 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10071",false,$POST_Sucursal,NULL) ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalNREWARD500 ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalNREWARD500;
								?>
                                <?php
							}
								?>
                                 </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td>FORWARD 800</td>
                          
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" > 
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                          <?php
						  //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoMantenimientoMensualTotalFORWARD800 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10072",false,$POST_Sucursal,NULL) ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFORWARD800 ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalFORWARD800;
								?>
                                <?php
							}
								?>
                                
                                 </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >FTR 10 TON</td>
                           
							<?php
                            for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
								<td align="center" > 
                                
                                 <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                                   <?php
								   //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoMantenimientoMensualTotalFTR10TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10090",false,$POST_Sucursal,NULL) ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFTR10TON ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalFTR10TON;
								?>
                                <?php
							}
								?>
                                 </td>
							<?php
                            }
							?> 
                        </tr>
                        <tr>
                          <td >FORWARD 1300</td>
                        
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                            <?php
							
							//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoMantenimientoMensualTotalFORWARD1300= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10074",false,$POST_Sucursal,NULL) ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFORWARD1300 ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalFORWARD1300;
								?>
                                <?php
							}
								?>
                                  </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >FORWARD 2000</td>
                           
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >  
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                           <?php
						   //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoMantenimientoMensualTotalFORWARD2000= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10075",false,$POST_Sucursal,NULL) ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFORWARD2000 ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalFORWARD2000;
								?>
                                
                                <?php
							}
								?>
                                </td>
                            <?php
                            }
                            ?> 
                        </tr>
                 
                    
                        <tr>
                          <td class="EstTablaReporteColumnaEspecial4">Total ingresos por modelo</td>
                        
                        <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" class="EstTablaReporteColumnaEspecial4" > 
                          
                           <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	
                          
                                <?php echo $TotalIngresoTipoMensualModelo[$mes]; ?>
                          <?php
							}
						  ?>
                           </td>
                            <?php
                            }
                            ?> 
                      
                          
                          
                        </tr>
                        <tr>
                          <td >&nbsp;</td>
                         <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >  </td>
                            <?php
                            }
                            ?> 

                        </tr>
                        
                        
                        <?php
					for($mes=1;$mes<=$POST_Mes;$mes++){
					?>
						
						<?php
                        $InsReporteCOS = new ClsReporteCOS();
                        //MtdObtenerReporteCOSs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL) {
                        $ResReporteCOS = $InsReporteCOS->MtdObtenerReporteCOSs(NULL,NULL,NULL,'RcoId','Desc','1',$POST_Ano,str_pad($mes,2,"0",STR_PAD_LEFT),$POST_VehiculoMarca);
                        $ArrReporteCOSs = $ResReporteCOS['Datos'];
                        
						$RcoNumeroCitas[$mes] = 0;
						$RcoClientesParticulares[$mes] = 0;
						$RcoClientesFlotas[$mes] = 0;
						$RcoPromedioPermanencia[$mes] = 0;
						$RcoParalizados[$mes] = 0;
						
                        $RcoPersonalMecanicos[$mes] = 0;
                        $RcoPersonalAsesores[$mes] = 0;
                        $RcoPersonalOtros[$mes] = 0;
                        $RcoDiasLaborados[$mes] = 0;
                        $RcoHoraDisponibles[$mes] = 0;
                        $RcoTarifaMO[$mes] = 0;
						
                        $RcoHoraMOVendidas[$mes] = 0;
                        $RcoVentaManoObra[$mes] = 0;
                        $RcoVentaRepuestos[$mes] = 0;
                        $RcoTicketPromedio[$mes] = 0;
                        $RcoVentaGarantiaFA[$mes] = 0;
                            
                        if(!empty($ArrReporteCOSs)){
                            foreach($ArrReporteCOSs as $DatReporteCOS){
                                
								$RcoNumeroCitas[$mes] = $DatReporteCOS->RcoNumeroCitas;
								$RcoClientesParticulares[$mes] = $DatReporteCOS->RcoClientesParticulares;
								$RcoClientesFlotas[$mes] = $DatReporteCOS->RcoClientesFlotas;
								$RcoPromedioPermanencia[$mes] = $DatReporteCOS->RcoPromedioPermanencia;
								$RcoParalizados[$mes] = $DatReporteCOS->RcoParalizados;
								
                                $RcoPersonalMecanicos[$mes] = $DatReporteCOS->RcoPersonalMecanicos;
                                $RcoPersonalAsesores[$mes] = $DatReporteCOS->RcoPersonalAsesores;
                                $RcoPersonalOtros[$mes] =$DatReporteCOS->RcoPersonalOtros;
								
                                $RcoDiasLaborados[$mes] = $DatReporteCOS->RcoDiasLaborados;
                                $RcoHoraDisponibles[$mes] = $DatReporteCOS->RcoHoraDisponibles;
								$RcoHoraLaboradas[$mes] = $DatReporteCOS->RcoHoraLaboradas;
								$RcoTarifaMO[$mes] = $DatReporteCOS->RcoTarifaMO;
							   
                                $RcoHoraMOVendidas[$mes] = $DatReporteCOS->RcoHoraMOVendidas;
                                $RcoVentaManoObra[$mes] = $DatReporteCOS->RcoVentaManoObra;
                                $RcoVentaRepuestos[$mes] = $DatReporteCOS->RcoVentaRepuestos;
                                $RcoTicketPromedio[$mes] =$DatReporteCOS->RcoTicketPromedio;
                                $RcoVentaGarantiaFA[$mes] =$DatReporteCOS->RcoVentaGarantiaFA;
                        
                            }
                        }
                        ?>
                        
                    <?php
					}
                    ?>
                    
                    
                        <tr>
                          <td > Número de citas</td>
                                                   <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >  
                          
                          <?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>	  
                            
								<?php echo $RcoNumeroCitas[$mes];  ?>
                                
                            <?php
							}
							?>
						  
					
                           </td>
                            <?php
                            }
                            ?> 

                        </tr>
                        <tr>
                          <td > Clientes particulares</td>
                          <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                         
						  <td align="center" >  
						  <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
                           
							<?php echo $RcoClientesParticulares[$mes];  ?>
                            
                           
                            <?php
                            }
                            ?> 
                             </td>
                             <?php
                            }
                            ?> 
                            
                        </tr>
                        <tr>
                          <td > Clientes de flotas</td>
                          <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >  
						  
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
						  <?php echo $RcoClientesFlotas[$mes];  ?>
                          
                            <?php
						  }
							?>
                            
                            </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td > Promedio dias permanencia</td>
                          <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
								
                            ?>
                          <td align="center" > 
                          
                          
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?> 
						 
                           
                              <?php echo $RcoPromedioPermanencia[$mes];  ?>
                              
                              
                            <?php
						  }
							?>
                            </td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td > Paralizados al cierre de mes</td>
                          <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" > 
                          
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
                           
						   
						  <?php echo $RcoParalizados[$mes];  ?>
                            <?php
						  }
							?>
                            
                            </td>
                            <?php
                            }
                            ?> 
                        </tr>
                    </tbody>
        </table>
        
     2. Utilización del recurso humano      
        
<table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>
                     Datos de mano de obra</th>
                    <?php
                    for($mes=1;$mes<=12;$mes++){
                    ?>
						<th width="60" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
					
                    <tbody class="EstTablaReporteBody">
                 
                    
                 
                       
                        
                              
                       
                  
                       
                        <tr>
                          <td > Técnicos de servicio</td>
                              <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                            
                          <td align="center" >
                          
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							 
							 ?>
                             <?php echo $RcoPersonalMecanicos[$mes];  ?>
                             <?php
							
						  }
						  ?>
                          </td>
                               
                                
                             <?php
                            }
                            ?> 
                            
                        </tr>
                        <tr>
                          <td > Asesores y soporte</td>
                            <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							 ?>
                              <?php echo $RcoPersonalAsesores[$mes];  ?>
                             <?php
						
						  }
						  ?>
                          
                          </td>
                           <?php
                            }
                            ?> 
                            
                        </tr>
                        <tr>
                          <td > Otros</td>
                           <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >
                          
						<?php
						if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						?>

							<?php echo $RcoPersonalOtros[$mes];  ?>

						<?php
						}
						?>
                          
                          </td>
                           <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td > Días laborados</td>
                          <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >
                          
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
                        
                          	<?php echo $RcoDiasLaborados[$mes];  ?>
                            
                            <?php
						  }
							?>
                          </td>
                           <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >Horas disponibles técnico</td>
                           <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >
                          
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
                          	<?php echo $RcoHoraDisponibles[$mes];  ?>
                            <?php
						  }
                            ?>
                            
                          </td>
                          
                           <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >Horas laboradas técnico</td>
                           <?php
                             for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                          <td align="center" >  
						  
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
						
                        <?php echo $RcoHoraLaboradas[$mes];  ?>
                            
                            
                            <?php
						  }
							?>
                            
                            
                            </td>
                            <?php
                            }
                            ?> 
                        </tr>
                    </tbody>
                    </table>
                    
    3. Venta de servicio y repuestos
           
           
           <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>
                      Datos de venta</th>
                    <?php
                    for($mes=1;$mes<=12;$mes++){
                    ?>
                    <th width="60" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                    <tbody class="EstTablaReporteBody">
                   
             
                       
                        <tr>
                          <td > Tarifa de MO</td>
                             <?php
                    for($mes=1;$mes<=$POST_Mes;$mes++){
                    ?>
                          <td align="center" >
                          
						  <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						
							?>
                            <?php echo $RcoTarifaMO[$mes];  ?>
                            <?php
						  }
						  ?>
                          </td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td > Horas de MO vendidas</td>
                         <?php
                    for($mes=1;$mes<=$POST_Mes;$mes++){
                    ?>
                          <td align="center" >
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>
							
                            <?php echo $RcoHoraMOVendidas[$mes];  ?>
                            
						
                            <?php
							
						  }
						  ?>
                          </td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td > Venta de mano de obra</td>
                         <?php
                    for($mes=1;$mes<=$POST_Mes;$mes++){
					
                    ?>
                          <td align="center" >
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
                          
                          	  <?php echo $RcoVentaManoObra[$mes];  ?>
                          
                          <?php
						  }
						  ?>
                          </td>
                           <?php	
                    }
                    ?>
					</tr>
				<tr>
                          <td > Venta de repuestos</td>
                          <?php
                    for($mes=1;$mes<=$POST_Mes;$mes++){
						
                    ?>
                          <td align="center" >
                          
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						  ?>
                          
                          <?php echo $RcoVentaRepuestos[$mes];  ?>
                          
                          <?php
						  }
						  ?>
                          </td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td >Ticket promedio</td>
                         <?php
                    for($mes=1;$mes<=$POST_Mes;$mes++){
                    ?>
                          <td align="center" >
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							
						?>
                        
                        <?php //echo $RcoTicketPromedio[$mes];  ?>
                        
                        		<?php 
								$TicketPromedio[$mes] = ($RcoVentaManoObra[$mes] + $RcoVentaRepuestos[$mes])/$TotalIngresoTipoMensual[$mes];
								
								?>
                                <?php echo round($TicketPromedio[$mes],2);?>
                        <?php	
							
						  }
						  ?>
                          </td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td >Ventas por garantía y FA</td>
                         <?php
                    for($mes=1;$mes<=$POST_Mes;$mes++){
                    ?>
                          <td align="center" >
                          <?php
						  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						?>
                        		<?php echo $RcoVentaGarantiaFA[$mes];  ?>
                        <?php
						  }
						  ?>
                          </td>
                           <?php	
                    }
                    ?>
                        </tr>
                    </tbody>
                    </table>
                             
  