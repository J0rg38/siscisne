<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"ORDEN_TRABAJO_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$POST_Todos = ($_GET['Todos']);


$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';

/*
* Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Prioridad = $_POST['Prioridad'];
$POST_Modalidad = $_POST['Modalidad'];
$POST_ConCampana = $_POST['ConCampana'];
$POST_Personal = $_POST['CmpPersonal'];
$POST_Asesor = $_POST['CmpAsesor'];
$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];
$POST_CodigoOriginal = $_POST['CodigoOriginal'];

$POST_Sucursal = $_SESSION['SesionSucursal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}


if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if($POST_Todos=="Si"){
	$POST_pag = "";
}else{

	if(empty($POST_pag)){
		$POST_pag = '0,'.$POST_num;
	}
	
}


/*
* Otras variables
*/

if(empty($POST_finicio)){
	$POST_finicio = "01/01/".date("Y");
	
	
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

if(empty($POST_ord)){
	$POST_ord = "FinTiempoCreacion";
}

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');


require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPersonal = new ClsPersonal();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();


//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oVehiculoMarca=NULL,$oCodigoOriginal=NULL) {
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId,EinVIN,EinPlaca,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,FinConductor,VmaNombre,VmoNombre,VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Prioridad,$POST_Modalidad,NULL,NULL,$POST_Personal,0,NULL,NULL,1,0,$POST_ConCampana,NULL,0,NULL,$POST_Asesor,$POST_VehiculoMarca,$POST_CodigoOriginal,$POST_Sucursal);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];
$FichaIngresosTotal = $ResFichaIngreso['Total'];
$FichaIngresosTotalSeleccionado = $ResFichaIngreso['TotalSeleccionado'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL) 
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,1,NULL,NULL,NULL,$POST_Sucursal,NULL,NULL);
$ArrTecnicos = $ResPersonal['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL) 
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1,NULL,NULL,$POST_Sucursal,NULL,NULL);
$ArrAsesores = $ResPersonal['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >&nbsp;</th>
                <th width="2%" >ID</th>
                <th width="8%" >AVANCE</th>
                <th width="8%" >MODALIDADES</th>
                <th width="4%" >FECHA Y HORA </th>
                <th width="5%" >FECHA ENTREGA ESTIMADA</th>
                <th width="3%" >FECHA GARANTIA</th>
                <th width="3%" >CLIENTE</th>
                <th width="3%" >OTROS PROPIETARIOS</th>
                <th width="3%" >CELULAR</th>
                <th width="3%" >TELEFONO</th>
                <th width="3%" >VIN</th>
                <th width="3%" >MARCA</th>
                <th width="3%" >MODELO</th>
                <th width="3%" >VERSION</th>
                <th width="3%" >COLOR</th>
                <th width="3%" >PLACA</th>
                <th width="3%" >TECNICO</th>
                <th width="3%" >KILOM-</th>
                <th width="3%" >ESTADO</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="21" align="center">&nbsp;</td>
              </tr>
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrFichaIngresos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center" bgcolor="<?php echo $dat->FinPrioridadColor;?>" ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   ><?php

if(!empty($dat->CprSeguroFoto)){
	
	$extension = strtolower(pathinfo($dat->CprSeguroFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->CprSeguroFoto, '.'.$extension);  
?>
  <?php echo $dat->CprSeguro;?>
  <?php
}
?></td>
                <td align="right" valign="middle" width="2%"   >
                  
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><span class="EstTablaListadoCodigo">
                        <?php echo $dat->FinId;  ?>
                      </span>
                      
                      <?php 
				
				 /*if(!empty($dat->OvvId)){
				?>
                
                
                  <a href="javascript:FncOrdenVentaVehiculoVerPlan('<?php echo $dat->OvvId;?>','<?php echo $dat->FinCantidadMantenimientos;?>');"><img src="imagenes/iconos/promocion.png" alt="Promocion" title="Vehiculo con promocion" border="0" width="25" height="25"/></a>
                  
				  
				  <?php	 
				 }*//*else{
				?>
                No Tiene Promocion
                <?php 
				 }*/
				 ?>
                 
				<?php 
				
				 if(!empty($dat->ObsId)){
				?>
                
					<?php
                    if(!empty($dat->ObsFoto)){
                    ?>
                    	

                        Promocion
                    <?php	
                    }else{
                    ?>
                   
                    Promocion
                    <?php	
                    }
                    ?>
                    
                 
				  <?php	 
				 }
				 ?>
                 
				<?php
                if(!empty($dat->OvmId)){
                ?>
                
                
                    Mant. Gratuito
                
                
                <?php  
                }
                ?>
                 
                 </td>
                    </tr>
                  </table>
                  
                  
                  
                  
                  
                </td>
                <td  width="8%" align="left" ><?php
$porcentaje = 0;
	switch($dat->FinEstado){
		
		case 1:
			$porcentaje = 3.75;

		break;
		
		case 11:
			$porcentaje = 3.75 + 3.75;
		break;
		
		case 2:
			$porcentaje = 3.75 + 3.75 + 12;
		break;
		
		case 3:
			$porcentaje = 3.75 + 3.75 + 12 + 12;
		break;
		
		case 4:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12;
		break;
		
		case 5:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667;
		break;
		
		case 6:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667;
		break;
		
		case 7:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667;
		break;
		
		case 71:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12;
		break;
		
		case 72:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12;
		break;
		
		case 73:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12;
		break;
		
		case 74:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75;
		break;
		
		case 75:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75 + 3.75;
		break;
		
		case 9:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75 + 3.75 +5;
		break;
	}

?>
                  <?php
				$clase = "";
				if($porcentaje >= 0 and $porcentaje < 11){
					$clase = "EstFichaIngresoNivel1";
				}else if($porcentaje >= 11 and $porcentaje < 21){
					$clase = "EstFichaIngresoNivel2";
				}else if($porcentaje >= 21 and $porcentaje < 31){
					$clase = "EstFichaIngresoNivel3";
				}else if($porcentaje >= 31 and $porcentaje < 41){
					$clase = "EstFichaIngresoNivel4";
				}else if($porcentaje >= 41 and $porcentaje < 51){
					$clase = "EstFichaIngresoNivel5";
				}else if($porcentaje >= 51 and $porcentaje < 61){
					$clase = "EstFichaIngresoNivel6";
				}else if($porcentaje >= 61 and $porcentaje < 71){
					$clase = "EstFichaIngresoNivel7";
				}else if($porcentaje >= 71 and $porcentaje < 81){
					$clase = "EstFichaIngresoNivel8";
				}else if($porcentaje >= 81 and $porcentaje < 91){
					$clase = "EstFichaIngresoNivel9";
				}else if($porcentaje >= 91 and $porcentaje < 101){
					$clase = "EstFichaIngresoNivel10";
				}
				?>
                <div class="<?php echo $clase ?>" > <?php echo number_format($porcentaje,2); ?> % </div></td>
                <td  width="8%" align="left" >
                  
                  <?php
		  $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
		  
		  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
		  $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$dat->FinId,NULL);
		  $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
		  ?>
                  
                  <?php
		foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
		?>
                  -<?php echo $DatFichaIngresoModalidad->MinNombre?><br>
                  <?php
		}
		?>
                </td>
                <td  width="4%" align="right" ><?php echo $dat->FinFecha;  ?> <?php echo $dat->FinHora;  ?></td>
                <td  width="5%" align="right" bgcolor="#AEE3AE" ><?php echo (empty($dat->FinFechaEntrega)?'':$dat->FinFechaEntrega);?> <?php echo ((empty($dat->FinHoraEntrega) or $dat->FinHoraEntrega == "00:00:00")?'':$dat->FinHoraEntrega);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->FinFechaGarantia);?>
                  <?php if(!empty($dat->FinGarantiaDiaTranscurrido)){?>
(<?php echo $dat->FinGarantiaDiaTranscurrido;?>)
<?php }?></td>
                <td  width="3%" align="left" valign="top" ><span class="EstTablaListadoContenido">
  
                  <?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?>
          
                </span>
                  <?php

/*if($dat->CliCSIIncluir == "2"){
?>
                  <img src="imagenes/avisos/retirado.gif" alt="" width="15" height="15" border="0" align="Excluido CSI" title="Excluido CSI" />
                <?php	
}*/
?>
                <?php
$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
$ResVehiculoIngresoCliente =  $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,"VicId","ASC",NULL,$dat->EinId);
				$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
				
?>
                <?php
	if(!empty($ArrVehiculoIngresoClientes)){
	?></td>
                <td  width="3%" align="left" valign="top" >
                  <?php
    	foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
	?>
                  <?php
		if($dat->CliId<>$DatVehiculoIngresoCliente->CliId){
		?>
- <span class="EstTablaListadoContenido">
<?php
            if($PrivilegioClienteEditar or $PrivilegioClienteVer){
            ?>
<!--<a href="javascript:FncClienteCargarFormulario('<?php echo (($PrivilegioClienteEditar)?'Editar':'Ver');?>','<?php echo $DatVehiculoIngresoCliente->CliId?>');"  >-->
<?php echo ($DatVehiculoIngresoCliente->CliNombre);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoPaterno);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoMaterno);?>
<!--</a>-->
<?php
            }else{
            ?>
<?php echo ($DatVehiculoIngresoCliente->CliNombre);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoPaterno);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoMaterno);?>
<?php	
            }
            ?>
</span> <br />
<?php
		}
		?>
<?php	
		}
	}
    ?></td>
                <td  width="3%" align="right" valign="top" >
				
				<?php echo ($dat->CliCelular);?></td>
                <td  width="3%" align="right" valign="top" ><?php echo ($dat->CliTelefono);?></td>
                <td  width="3%" align="left" valign="top" ><span class="EstTablaListadoContenido">
   
                <?php echo ($dat->EinVIN);?>
  
                </span>
                  <?php
/*	if($dat->FinTieneNota == "Si"){
?>
                  <a href="javascript:FncAvisoCargarFormulario('<?php echo $dat->EinId?>');"  > <img src="imagenes/estado/notas.png" border="0" alt="Notas" title="Notas" width="25" height="25" /></a>
                  <?php
	}*/
?>
                  <?php
	  
/*	if(!empty($dat->VreId)){
?>
                  <a href="javascript:FncVehiculoRecepcionVistaPreliminar('<?php echo $dat->VreId?>');"  > <img src="imagenes/avisos/alerta.gif" border="0" alt="Reclamo" title="Reclamo" width="15" height="15" /></a>
                <?php
	}*/
?></td>
                <td  width="3%" align="left" valign="top" ><span class="EstTablaListadoContenido"><?php echo ($dat->VmaNombre);?></span></td>
                <td  width="3%" align="left" valign="top" ><span class="EstTablaListadoContenido"><?php echo ($dat->VmoNombre);?></span></td>
                <td  width="3%" align="left" valign="top" ><span class="EstTablaListadoContenido"><?php echo ($dat->VveNombre);?></span></td>
                <td  width="3%" align="left" valign="top" ><span class="EstTablaListadoContenido"><?php echo ($dat->EinColor);?></span></td>
                <td  width="3%" align="left" valign="top" ><span class="EstTablaListadoContenido"><?php echo ($dat->EinPlaca);?></span></td>
                <td  width="3%" align="left" valign="top" ><?php echo ($dat->PerNombre);?> <?php echo ($dat->PerApellidoPaterno);?>
                <?php  echo ($dat->PerApellidoMaterno);?></td>
                <td  width="3%" align="left" valign="top" ><?php echo ($dat->FinVehiculoKilometraje);?></td>
                <td  width="3%" align="right" >
                  
               
                    <?php echo $dat->FinEstadoDescripcion;?>
                 
                </td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
		

									?>
            </tbody>
      </table>
