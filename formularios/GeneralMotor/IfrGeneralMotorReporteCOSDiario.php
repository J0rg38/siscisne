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
$POST_VehiculoMarca = empty($_GET['CmpVehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
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
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOSDiario.php');

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
  <td width="54%" rowspan="2" align="center" valign="top">CONTROL DE OPERACIONES DE SERVICIO COS - MECANICA (DIARIO)</td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
<tr>
  <td align="right" valign="top">A&ntilde;o: <?php echo $POST_Ano;?></td>
</tr>
</table>

<hr class="EstReporteLinea">

<?php }?>
                

                     
  
                    


<!--<table class="EstTablaReporte" width="100%">
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
        </table>-->


 1. Control de unidades ingresadas    
                    
<table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th width="872">
                    Tipo de Servicio</th>
                    <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
						$TotalIngresoTipoMensual[$dia] = 0;
                    ?>
                    <th width="81" align="center"><?php echo ($dia);?></th>
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
                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                        <?php
                        if($DatKilometro['km']<=50000){
                        ?>
                        	<tr>
								
                                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                                    Servicio <?php echo $DatKilometro['km'];?>
                                </td>
                                
                                	<?php
                                    for($dia=1;$dia<=$CantidadDias;$dia++){
                                    ?>
                                        <td width="81" align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                            
                                        <?php
//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                        $FichaIngresoMantenimientoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,$dia) ;
                                     	$TotalIngresoTipoMensual[$dia] += $FichaIngresoMantenimientoMensualTotal;
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
                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                       
                        <?php
                        if($DatKilometro['km']>50000){
                        ?>
                            <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                            
                                <?php
////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
								$FichaIngresoMantenimiento50TotalMensual[$dia] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,$dia) ;
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                                <td width="81" align="center" class="EstTablaReporteColumnaEspecial1">
                                
                                <?php
								$TotalIngresoTipoMensual[$dia] += $FichaIngresoMantenimiento50TotalMensual[$dia];
								?>
                             
                                <?php
                                if(!empty($FichaIngresoMantenimiento50TotalMensual[$dia])){
                                ?>
                                    <?php echo $FichaIngresoMantenimiento50TotalMensual[$dia];?>
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                                <td width="81" align="center" class="EstTablaReporteColumnaEspecial2">
                                
                                <?php
								////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
                                $FichaIngresoReparacionMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10003,MIN-10019,MIN-10020,MIN-10021",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,true,$POST_Sucursal,$dia) ;
                                ?>
                    
                                <?php 
								$FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionMensualTotal;
								$TotalIngresoTipoMensual[$dia] += $FichaIngresoReparacionMensualTotal;
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                                <td width="81" align="center" class="EstTablaReporteColumnaEspecial3">
                                
                                
                              	<?php    
								////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)                
                                $FichaIngresoTrabajoInternoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,$dia) ;
                                ?>
                                <?php 
								$FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoMensualTotal;
								$TotalIngresoTipoMensual[$dia] += $FichaIngresoTrabajoInternoMensualTotal;
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                              <td width="81" align="center" class="EstTablaReporteColumnaEspecial4">
                              
                              
								<?php
								////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)  
                                $FichaIngresoGarantiaMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10000",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,$dia) ;
                               
							   	$FichaIngresoGarantiaSumaTotal += $FichaIngresoGarantiaMensualTotal ;
								
								$TotalIngresoTipoMensual[$dia] += $FichaIngresoGarantiaMensualTotal;
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
                            <td class="EstTablaReporteColumnaEspecial5">
                               Reingresos
                            </td>
                            <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                              <td width="81" align="center" class="EstTablaReporteColumnaEspecial5">
                              
                               <?php
////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)  
                                $FichaIngresoReingresoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,$dia) ;
								
								$FichaIngresoReingresoSumaTotal += $FichaIngresoReingresoMensualTotal ;
								
								$TotalIngresoTipoMensual[$dia] += $FichaIngresoReingresoMensualTotal;
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                              <td align="center" class="EstTablaReporteColumnaEspecial5">
	 <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
							   <?php
                               echo $TotalIngresoTipoMensual[$dia];
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

         
         <?php
		 switch($POST_VehiculoMarca){
			 
			 case "VMA-10017":
		?>
          <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th width="870">
                    Ingreso por modelo</th>
                    <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
						
							$TotalIngresoTipoMensualModelo[$dia] = 0;
                    ?>
                    <th width="83" align="center"><?php echo ($dia);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                 
                    <tbody class="EstTablaReporteBody">
                   
                        <tr>
                          <td >Spark Lite (0.8 y 1.0)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							////if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
								
							?>	
                          	 <?php
							 //////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL) 
                                $FichaIngresoMantenimientoMensualTotalSparkLite = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10006",false,$POST_Sucursal,$dia) ;
								
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalSparkLite ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalSparkLite;
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
                          <td >Spark GT (1.2)</td>
                         
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" > 
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                           <?php
						   
//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL) 
                                $FichaIngresoMantenimientoMensualTotalSparkGT = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10005",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalSparkGT ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalSparkGT;
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
                          <td>N300 (Move y Max 1.2)</td>
                         
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >  
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                            <?php
                                $FichaIngresoMantenimientoMensualTotalN300MoveMax = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10063,VMO-10064",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalN300MoveMax ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalN300MoveMax;
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
                          <td >N300 (Work 1.5)</td>
                          
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" > 
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                            	<?php
                                $FichaIngresoMantenimientoMensualTotalN300Work = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10065",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalN300Work ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalN300Work;
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
                          <td>Corsa y Chevy Taxi (1.4)</td>
                          
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" > 
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                          <?php
                                $FichaIngresoMantenimientoMensualTotalCorsaChevy = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10028,VMO-10052",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalCorsaChevy ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalCorsaChevy;
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
                          <td >Aveo (1.4)</td>
                           
							<?php
                            for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
								<td align="center" > 
                                
                                 <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                                   <?php
                                $FichaIngresoMantenimientoMensualTotalAveo = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10000,VMO-10059",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalAveo ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalAveo;
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
                          <td >Sail (1.4)</td>
                        
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                            <?php
                                $FichaIngresoMantenimientoMensualTotalSail= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10003,VMO-10062",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalSail ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalSail;
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
                          <td >Nuevo Sail (1.5)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >  
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                           <?php
                                $FichaIngresoMantenimientoMensualTotalNuevoSail= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10087",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalNuevoSail ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalNuevoSail;
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
                          <td >Optra (1.6)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                           <?php
                                $FichaIngresoMantenimientoMensualTotalOptra= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10002,VMO-10007",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalOptra ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalOptra;
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
                          <td >Sonic (1.6)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" > 
                           
						    <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
						   <?php
                                $FichaIngresoMantenimientoMensualTotalSonic= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10004,VMO-10060",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalSonic ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalSonic;
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
                          <td >Cruze (1.8)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
							<?php
                            $FichaIngresoMantenimientoMensualTotalCruze= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10001,VMO-10061",false,$POST_Sucursal,$dia) ;
                            $TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalCruze ;
                            ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalCruze;
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
                          <td >Tracker (1.8)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                            <?php
                                $FichaIngresoMantenimientoMensualTotalTracker= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10012",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalTracker ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalTracker;
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
                          <td >Vivant (2.0)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                          
                            <?php
                                $FichaIngresoMantenimientoMensualTotalVivant= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10008",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalVivant ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalVivant;
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
                          <td >Orlando (2.4)</td>
                          
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                           
                            <?php
                                $FichaIngresoMantenimientoMensualTotalOrlando= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10010",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalOrlando ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalOrlando;
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
                          <td >Captiva (2.4)</td>
                          
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" > 
                          
                          	 <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                          <?php
                                $FichaIngresoMantenimientoMensualTotalCaptiva= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10009",false,$POST_Sucursal,$dia) ;
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalCaptiva ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalCaptiva;
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
                          <td >S10 (2.8)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
								<?php
                                $FichaIngresoMantenimientoMensualTotalS10= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10067",false,$POST_Sucursal,$dia) ;
								
								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalS10 ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalS10;
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
                          <td >Trailblazer (3.6)</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >  
                          
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                          
                           <?php
      
								
								   $FichaIngresoMantenimientoMensualTotalTrailblazer= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10066",false,$POST_Sucursal,$dia) ;
								   
								   $TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalTrailblazer ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalTrailblazer;
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
                          <td >Traverse (3.6)</td>
                          
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           
                            <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                           <?php
                                $FichaIngresoMantenimientoMensualTotalTraverse= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10013",false,$POST_Sucursal,$dia) ;
								
								 $TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalTraverse ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalTraverse;
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
                          <td >Tahoe y Suburban</td>
                           
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                            <?php
                                $FichaIngresoMantenimientoMensualTotalTahoeSuburban = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10011,VMO-10025",false,$POST_Sucursal,$dia) ;

								$TotalIngresoTipoMensualModelo[$dia] +=  $FichaIngresoMantenimientoMensualTotalTahoeSuburban ;
                                ?>
                                
                                <?php
								echo $FichaIngresoMantenimientoMensualTotalTahoeSuburban;
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
                          <td  class="EstTablaReporteColumnaEspecial5">Otras unidades Chevrolet</td>
                            
                        <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center"  class="EstTablaReporteColumnaEspecial5" >
                          
						   <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
						  <?php
//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
								$FichaIngresoMantenimientoMensualTotalModelo = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,$dia) ;
								//echo "::: ".$FichaIngresoMantenimientoMensualTotalModelo." - ".$TotalIngresoTipoMensualModelo[$dia];
								$FichaIngresoMantenimientoMensualTotalOtroModelo[$dia] = $FichaIngresoMantenimientoMensualTotalModelo - $TotalIngresoTipoMensualModelo[$dia];
								//echo " = ".$FichaIngresoMantenimientoMensualTotalOtroModelo[$dia];
								$TotalIngresoTipoMensualModelo[$dia] +=   $FichaIngresoMantenimientoMensualTotalOtroModelo[$dia] ;
								//echo "<br><br>";
						?>
                        
                        <?php echo $FichaIngresoMantenimientoMensualTotalOtroModelo[$dia];?>
                          
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" class="EstTablaReporteColumnaEspecial4" > 
                          
                           <?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>	
                                <?php echo $TotalIngresoTipoMensualModelo[$dia];?>
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" >  </td>
                            <?php
                            }
                            ?> 

                        </tr>
                        
                        
                             
                        <?php
					for($dia=1;$dia<=$CantidadDias;$dia++){
					?>
						
						<?php
                        $InsReporteCOSDiario = new ClsReporteCOSDiario();
                        //MtdObtenerReporteCOSDiarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL)
                        $ResReporteCOSDiario = $InsReporteCOSDiario->MtdObtenerReporteCOSDiarios(NULL,NULL,NULL,'RcdId','Desc','1',$POST_Ano,str_pad($POST_Mes,2,"0",STR_PAD_LEFT),$POST_VehiculoMarca,$POST_Sucursal,$dia);
                        $ArrReporteCOSDiarios = $ResReporteCOSDiario['Datos'];
                        
						
						$RcdNumeroCitas[$dia] = 0;
						$RcdClientesParticulares[$dia] = 0;
						$RcdClientesFlotas[$dia] = 0;
						$RcdPromedioPermanencia[$dia] = 0;
						$RcdParalizados[$dia] = 0;
						
                        $RcdPersonalMecanicos[$dia] = 0;
                        $RcdPersonalAsesores[$dia] = 0;
                        $RcdPersonalOtros[$dia] = 0;
                        $RcdDiasLaborados[$dia] = 0;
                        $RcdHoraDisponibles[$dia] = 0;
						$RcdTarifaMO[$dia] = 0;
						
                        $RcdHoraMOVendidas[$dia] = 0;
                        $RcdVentaManoObra[$dia] = 0;
                        $RcdVentaRepuestos[$dia] = 0;
                        $RcdTicketPromedio[$dia] = 0;
                        $RcdVentaGarantiaFA[$dia] = 0;
                            
                        if(!empty($ArrReporteCOSDiarios)){
                            foreach($ArrReporteCOSDiarios as $DatReporteCOS){
                                
								$RcdNumeroCitas[$dia] = $DatReporteCOS->RcdNumeroCitas;
								$RcdClientesParticulares[$dia] = $DatReporteCOS->RcdClientesParticulares;
								$RcdClientesFlotas[$dia] = $DatReporteCOS->RcdClientesFlotas;
								$RcdPromedioPermanencia[$dia] = $DatReporteCOS->RcdPromedioPermanencia;
								$RcdParalizados[$dia] = $DatReporteCOS->RcdParalizados;
								
                                $RcdPersonalMecanicos[$dia] = $DatReporteCOS->RcdPersonalMecanicos;
                                $RcdPersonalAsesores[$dia] = $DatReporteCOS->RcdPersonalAsesores;
                                $RcdPersonalOtros[$dia] =$DatReporteCOS->RcdPersonalOtros;
								
                                $RcdDiasLaborados[$dia] = $DatReporteCOS->RcdDiasLaborados;
                                $RcdHoraDisponibles[$dia] = $DatReporteCOS->RcdHoraDisponibles;
								$RcdHoraLaboradas[$dia] = $DatReporteCOS->RcdHoraLaboradas;
								$RcdTarifaMO[$dia] = $DatReporteCOS->RcdTarifaMO;
							   
                                $RcdHoraMOVendidas[$dia] = $DatReporteCOS->RcdHoraMOVendidas;
                                $RcdVentaManoObra[$dia] = $DatReporteCOS->RcdVentaManoObra;
                                $RcdVentaRepuestos[$dia] = $DatReporteCOS->RcdVentaRepuestos;
                                $RcdTicketPromedio[$dia] =$DatReporteCOS->RcdTicketPromedio;
                                $RcdVentaGarantiaFA[$dia] =$DatReporteCOS->RcdVentaGarantiaFA;
                        
                            }
                        }
                        ?>
                        
                    <?php
					}
                    ?>
                    
                    
                    
                    
                    
                    <tr>
                          <td > Número de citas</td>
                                                   <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
							//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>
                            <?php echo $RcdNumeroCitas[$dia];  ?>
                <?php
							}
							?></td>
                            <?php
                            }
                            ?> 

                        </tr>
                        <tr>
                          <td > Clientes particulares</td>
                          <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                        <?php echo $RcdClientesParticulares[$dia];  ?>
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
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdClientesFlotas[$dia];  ?>
                        <?php
						  }
							?></td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td > Promedio dias permanencia</td>
                          <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
								 
								 $PromedioDiasPermanencia[$dia] = 0;
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdPromedioPermanencia[$dia];  ?>
                        <?php
						  }
							?></td>
                            <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td > Paralizados al cierre de mes</td>
                          <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdParalizados[$dia];  ?>
                        <?php
						  }
							?></td>
                            <?php
                            }
                            ?> 
                        </tr>
                    </tbody>
        </table>
        
        <?PHP	 
			 break;
			 
			  case "VMA-10018":
?>

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
							 //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL) {
								$FichaIngresoMantenimientoMensualTotalNLR3TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10091") ;
								
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
                                $FichaIngresoMantenimientoMensualTotalREWARD400DT = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10076") ;
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
                                $FichaIngresoMantenimientoMensualTotalNPR4TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10084") ;
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
                                $FichaIngresoMantenimientoMensualTotalNREWARD500 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10071") ;
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
                                $FichaIngresoMantenimientoMensualTotalFORWARD800 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10072") ;
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
                                $FichaIngresoMantenimientoMensualTotalFTR10TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10090") ;
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
                                $FichaIngresoMantenimientoMensualTotalFORWARD1300= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10074") ;
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
                                $FichaIngresoMantenimientoMensualTotalFORWARD2000= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10075") ;
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
        
<?php
			  break;
		 }
		 ?>
     
     2. Utilización del recurso humano      
        
        <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th width="870">
                     Datos de mano de obra</th>
                    <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
					//	$TotalIngresoTipoMensual[$dia] = 0;
                    ?>
                    <th width="83" align="center"><?php echo ($dia);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                 
                    <tbody class="EstTablaReporteBody">
                 
                    
                 
                       
                        
                              
                       
                  
                       
                        <tr>
                          <td > Técnicos de servicio</td>
                              <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                            
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							 
							 ?>
                            <?php echo $RcdPersonalMecanicos[$dia];  ?>
                       <?php
							
						  }
						  ?></td>
                               
                                
                             <?php
                            }
                            ?> 
                            
                        </tr>
                        <tr>
                          <td > Asesores y soporte</td>
                            <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							 ?>
                            <?php echo $RcdPersonalAsesores[$dia];  ?>
                         <?php
						
						  }
						  ?></td>
                           <?php
                            }
                            ?> 
                            
                        </tr>
                        <tr>
                          <td > Otros</td>
                           <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						//if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						?>
                            <?php echo $RcdPersonalOtros[$dia];  ?>
                         <?php
						}
						?></td>
                           <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td > Días laborados</td>
                          <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdDiasLaborados[$dia];  ?>
                         <?php
						  }
							?></td>
                           <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >Horas disponibles técnico</td>
                           <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdHoraDisponibles[$dia];  ?>
                         <?php
						  }
                            ?></td>
                          
                           <?php
                            }
                            ?> 
                        </tr>
                        <tr>
                          <td >Horas laboradas técnico</td>
                           <?php
                             for($dia=1;$dia<=$CantidadDias;$dia++){
                            ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdHoraLaboradas[$dia];  ?>
                        <?php
						  }
							?></td>
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
                    for($dia=1;$dia<=$CantidadDias;$dia++){
                    ?>
                    <th width="60" align="center"><?php echo ($dia);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                    <tbody class="EstTablaReporteBody">
                   
             
                       
                        <tr>
                          <td > Tarifa de MO</td>
                             <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
                    ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						
							?>
                            <?php echo $RcdTarifaMO[$dia];  ?>
                         <?php
						  }
						  ?></td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td > Horas de MO vendidas</td>
                         <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
                    ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							?>
                            <?php echo $RcdHoraMOVendidas[$dia];  ?>
                         <?php
							
						  }
						  ?></td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td > Venta de mano de obra</td>
                         <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
					
                    ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdVentaManoObra[$dia];  ?>
                         <?php
						  }
						  ?></td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td > Venta de repuestos</td>
                          <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
						
						$VentaRepuestoTallerMecanica[$dia] = 0;
                    ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						  ?>
                            <?php echo $RcdVentaRepuestos[$dia];  ?>
                         <?php
						  }
						  ?></td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td >Ticket promedio</td>
                         <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
                    ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
							
						?>
                            <?php //echo $RcdTicketPromedio[$dia];  ?>
                            <?php 
								$TicketPromedio[$dia] = ($RcdVentaManoObra[$dia] + $RcdVentaRepuestos[$dia])/(empty($TotalIngresoTipoMensual[$dia])?1:$TotalIngresoTipoMensual[$dia]);
								
								?>
                            <?php echo round($TicketPromedio[$dia],2);?>
                         <?php	
							
						  }
						  ?></td>
                           <?php	
                    }
                    ?>
                        </tr>
                        <tr>
                          <td >Ventas por garantía y FA</td>
                         <?php
                    for($dia=1;$dia<=$CantidadDias;$dia++){
                    ?>
                          <td align="center" ><?php
						  //if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
if(1 == 1 ){
						?>
                            <?php echo $RcdVentaGarantiaFA[$dia];  ?>
                         <?php
						  }
						  ?></td>
                           <?php	
                    }
                    ?>
                        </tr>
                    </tbody>
                    </table>
                             


