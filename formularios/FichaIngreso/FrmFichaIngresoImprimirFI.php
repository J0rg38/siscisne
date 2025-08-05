<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

$GET_id = $_GET['Id'];

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


$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->FinId = $GET_id;
$InsFichaIngreso->MtdObtenerFichaIngreso();

//deb($InsFichaIngreso);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsFichaIngreso->FinId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssFichaIngreso.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsFichaIngresoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsFichaIngreso->FinId)){?> 
FncFichaIngresoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left" valign="top"><span class="EstFichaIngresoCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="28%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" title="Logo" alt="Logo" border="0" /></td>
  <td width="46%" align="center" valign="top">
  
  <span class="EstPlantillaTitulo">FICHA INTERNA</span> <br />
  
  <span class="EstPlantillaTituloCodigo">
  <?php echo $InsFichaIngreso->FinId;?></span>
  
  
  </td>
  <td width="26%" align="right" valign="top">
    <span class="EstPlantillaoDatosImpresion">
	
	<?php //echo date("d/m/Y");?> 
	<?php //echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span>
    
    </td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">

<tr>
    <td width="63%" valign="top">
      
      <div class="EstFichaIngresoImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
          <tbody class="EstFichaIngresoImprimirTablaBody">
            <tr>
              <td width="14%" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Asesor</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="3" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->PerNombreAsesor;?> <?php echo $InsFichaIngreso->PerApellidoPaternoAsesor;?> <?php echo $InsFichaIngreso->PerApellidoMaternoAsesor;?></span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">Contacto:</span></td>
              <td align="left" valign="top" >
              
              <?php echo $InsFichaIngreso->PerEmailAsesor;?>
              /
              <?php echo $InsFichaIngreso->PerCelularAsesor;?>
              
              
              </td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Cliente</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->CliNombre;?> <?php echo $InsFichaIngreso->CliApellidoPaterno;?> <?php echo $InsFichaIngreso->CliApellidoMaterno;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Contacto</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinContacto;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Direccion</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinDireccion;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Celular</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinTelefono;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">TECNICO</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top"><span class="EstFichaIngresoImprimirContenido"><?php echo ($InsFichaIngreso->PerNombre);?> <?php echo ($InsFichaIngreso->PerApellidoPaterno);?> <?php echo ($InsFichaIngreso->PerApellidoMaterno);?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Fecha de Cita</span></td>
              <td width="2%" align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td width="18%" align="left" valign="top"><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinFechaCita;?></span></td>
              <td width="18%" align="left" valign="top"><span class="EstFichaIngresoImprimirEtiqueta">Fecha de Entrega:</span></td>
              <td width="18%" align="left" valign="top"><span class="EstFichaIngresoImprimirContenido">
			  
			  <?php echo $InsFichaIngreso->FinFechaEntrega;?> <?php echo $InsFichaIngreso->FinHoraEntrega;?></span></td>
              <td width="8%" align="left" valign="top"><span class="EstFichaIngresoImprimirEtiqueta">R:</span></td>
              <td width="22%" align="left" valign="top"><span class="EstFichaIngresoImprimirContenido">-</span></td>
            </tr>
          </tbody>
        </table>
        
      </div>
      
    </td>
    <td width="37%" valign="top"><div class="EstFichaIngresoImprimirCapa">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
        <tbody class="EstFichaIngresoImprimirTablaBody">
          <tr>
            <td width="46%" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">No. de O/T:</span></td>
            <td width="6%" align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td width="48%" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinId;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Fecha de O/T:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinFecha;?> <?php echo $InsFichaIngreso->FinHora;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">RECEPCION de O/T:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" >
            
            <span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinTiempoTallerRevisando;?> </span>
            
            
            
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta"> TERMINADO  O/T:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" >
            
            <span class="EstFichaIngresoImprimirContenido">
			<?php echo $InsFichaIngreso->FinTiempoTallerConcluido;?>
            </span>
            
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">No. de Chasis:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->EinVIN;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">No. de Placa:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->EinPlaca;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Modelo/Año:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" >
              
              <span class="EstFichaIngresoImprimirContenido">
                <?php echo $InsFichaIngreso->VmaNombre;?>/
                <?php echo $InsFichaIngreso->VmoNombre;?>/
                <?php echo $InsFichaIngreso->VveNombre;?>/
                <?php echo $InsFichaIngreso->EinAnoFabricacion;?></span>
              </td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Kilometraje:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinVehiculoKilometraje;?></span></td>
          </tr>
          </tbody>
        </table>
    </div></td>
  </tr>
  
<tr>
  <td colspan="6" valign="top">
    <div class="EstFichaIngresoImprimirCapa">
      <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstFichaIngresoImprimirTabla">
        <tbody class="EstFichaIngresoImprimirTablaBody">
          <tr>
            <td height="247" align="left" valign="top">
              
		
			<?php
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			?>
            
     
     
<?php

switch($DatFichaIngresoModalidad->MinSigla){

default:
?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
            <td colspan="2">  
				
<span class="EstFichaIngresoImprimirCabecera"				>
<?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [<?php echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]              
                </span>
                
                <?php
				if($DatFichaIngresoModalidad->MinSigla = "CA"){
				?>
                <span class="EstFichaIngresoImprimirSubcabecera"				>
                
					<?php echo $InsFichaIngreso->CamCodigo;?>
                     - 
                    <?php echo $InsFichaIngreso->CamNombre;?>
                    
                    		</span>
        
                <?php	
				}
				?>
                
			</td>
			</tr>
            <tr>
              <td align="center" valign="top">PRE - DIAGNOSTICO</td>
              <td align="center" valign="top">TRABAJO REALIZADO</td>
            </tr>
            <tr>
              <td width="50%" valign="top">
              
              <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
                <thead class="EstFichaIngresoImprimirTablaHead">
                  <tr>
                    <th width="5%" align="center" >#</th>
                    <th width="95%" align="center" >&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="EstFichaIngresoImprimirTablaBody">
                
                <!--if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
				foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
					
					//echo 'InsFichaIngresoTarea'.$DatFichaIngresoTarea->MinSigla.$Identificador;
					
					if(!empty($DatFichaIngresoTarea->MinSigla)){ //AUX
						$_SESSION['InsFichaIngresoTarea'.$DatFichaIngresoTarea->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaIngresoTarea->FitId,
						NULL,
						$DatFichaIngresoTarea->FitDescripcion,
						NULL,
						NULL,
						$DatFichaIngresoTarea->FitAccion,
						($DatFichaIngresoTarea->FitTiempoCreacion),
						($DatFichaIngresoTarea->FitTiempoModificacion),
						NULL);
						
					}
					
					
				}
			}-->
            
            
                  <?php
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
?>
                  <?php
		foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
			
			//deb($DatFichaIngresoTarea->FatEstado);
		?>
                  <?php
        		//if($DatFichaIngresoTarea->FatEstado == 2){
            ?>
                  <tr>
                    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaIngresoTarea->FitDescripcion;?></td>
                    </tr>
                  <?php
				   $i++;
				//}
         
            ?>
                  <?php	
					
		}
		?>
                  <?php		
	} 
?>
                 
                </tbody>
              </table>
              
              </td>
              <td width="50%" valign="top">
              
              <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
                <thead class="EstFichaIngresoImprimirTablaHead">
                  <tr>
                    <th width="5%" align="center" >#</th>
                    <th width="76%" align="center" >&nbsp;</th>
                    <th width="19%" align="center" >&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="EstFichaIngresoImprimirTablaBody">
                  <?php
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
		?>
                  <?php
        		if($DatFichaAccionTarea->FatEstado == 1){
            ?>
                  <tr>
                    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionTarea->FatDescripcion;?></td>
                    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php
      switch($DatFichaAccionTarea->FatAccion){
        case "I":
    ?>
                      Inspeccionar
                      <?php	
        break;
        
        case "R":
    ?>
                      Realizar
                      <?php
        break;
        default:
    ?>
                      -
                      <?php
        break;
      }
      ?></td>
                    </tr>
                  <?php
				  $i++;
				}
         
            ?>
            
<?php	
					 
		}
	} 
?>
               
                </tbody>
              </table>
              
              
              
              </td>
            </tr>
           
            
   <?php
   	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto)){
   ?> 
    <tr>
      <td colspan="2" valign="top"><table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
              <thead class="EstFichaIngresoImprimirTablaHead">
                <tr>
                  <th width="2%" align="center" >#</th>
                  <th width="75%" align="center" >Cambios  realizados</th>
                  <th width="11%" align="center" >Actividad</th>
                  <th width="12%" align="center" >Accion</th>
                </tr>
              </thead>
              <tbody class="EstFichaIngresoImprimirTablaBody">
        
	<?php
	$i = 1;
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
		?>
			<tr>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionProducto->ProNombre;?></td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >Cambiar </td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php
	switch($DatFichaAccionProducto->FapVerificar1){
		case 1:
?>
                    Realizado
                    <?php	
		break;
	
		case 2:
?>
                    No Realizado
                    <?php
		break;
	
		default:
?>
                    -
                    <?php
	break;
  }
  ?></td>
			</tr>
		<?php
		 $i++;	
		
		}
?>

              </tbody>
            </table></td>
    </tr>
    
    
    
    
<?php
if(!empty($DatFichaIngresoModalidad->FichaAccion->FccCausa)){
?>   
    <tr>
      <td colspan="2" valign="top">
      CAUSAS DEL PROBLEMA
      </td>
    </tr>
    <tr>
            <td colspan="2" valign="top">
   
<?php
echo $DatFichaIngresoModalidad->FichaAccion->FccCausa;
?>       
            
    </td>
            </tr>     
            
<?php
}
?>          
	  
            
            
                 
<?php
	} 
?>
            
        <tr>
      <td colspan="2" valign="top">FOTOS</td>
    </tr>
 
 <tr>
            <td colspan="2" valign="top">
            
            <?php
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						


?>

<img src="../../subidos/ficha_accion_fotos/<?php echo $DatFichaAccionFoto->FafArchivo;?>" alt="<?php echo $DatFichaAccionFoto->FafArchivo;?>" title="<?php echo $DatFichaAccionFoto->FafArchivo;?>" height="180" border="0" />

<?php
					}
}
?>  
            
            </td>
            </tr>     
                 
            
          
		</table>
<?php	
break;

case "MA":
?>


    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td>  
    
    <span class="EstFichaIngresoImprimirCabecera"				>
    <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [MA<?php //echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]              
    </span>
    
    </td>
    </tr>
    <tr>
    <td height="100" valign="top">
	<?php
	switch($InsFichaIngreso->VmaId){
		
		default:
	?>
      <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
    <thead class="EstFichaIngresoImprimirTablaHead">
    <tr>
    <th width="2%" align="center" >#</th>
    <th width="74%" align="center" >Detalle del trabajo a realizado</th>
    <th width="11%" align="center" >Actividad</th>
    <th width="13%" align="center" >Accion</th>
    </tr>
    </thead>
    <tbody class="EstFichaIngresoImprimirTablaBody">
    
    
    
    <?php
    
    $i=1;
    if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento)){
    foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
    
    ?>
    
    <?php
    if(($DatFichaAccionMantenimiento->FaaAccion<>"X" and !empty($DatFichaAccionMantenimiento->FaaAccion))){
    ?>
    
    <tr>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionMantenimiento->PmtNombre;?></td>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php
    switch($DatFichaAccionMantenimiento->FaaAccion){
    case "I":
    ?>
    Inspeccionar
    <?php	
    break;
    
    case "R":
    ?>
    Realizar
    <?php
    break;
    
    case "C":
    ?>
    <b>Cambiar</b>
    <?php
    break;
	case "U":
    ?>
	
     <b>Agregar</b>
    <?php
    break;
    

	case "P":
    ?>
	
    Consultivo
    <?php
    break;

    default:
    ?>
    -
    <?php
    break;
    }
    ?></td>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >
    
	<?php
    switch($DatFichaAccionMantenimiento->FaaVerificar1){
	
	    case 1:
    ?>
    Realizado
    
    <?php	
    break;
    
    	case 2:
    ?>
    No Realizado
    <?php
    	break;
    
    	default:
    ?>
    -
    <?php
    	break;
    }
    ?>
    
    </td>
    </tr>
    
    
    
    <?php
    $i++;
    }
    ?>
    <?php	
    
    
    
    }
    
    
    } 
    
    
    
    
    
    ?>
    </tbody>
    </table>

    <?php
		break;
		
		case "VMA-10018":
	?>
      <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
    <thead class="EstFichaIngresoImprimirTablaHead">
    <tr>
    <th width="2%" align="center" >#</th>
    <th width="74%" align="center" >Detalle del trabajo a realizado</th>
    <th width="11%" align="center" >Actividad</th>
    <th width="13%" align="center" >Accion</th>
    </tr>
    </thead>
    <tbody class="EstFichaIngresoImprimirTablaBody">
    
    
    
    <?php
    
    $i=1;
    if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento)){
    foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
    
    ?>
    
    <?php
    if(($DatFichaAccionMantenimiento->FaaAccion<>"X" and !empty($DatFichaAccionMantenimiento->FaaAccion)) ){
    ?>
    
    <tr>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionMantenimiento->PmtNombre;?></td>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >
	
                    
					
					<?php
    switch($DatFichaAccionMantenimiento->FaaAccion){
    case "R":
    ?>
    
    
     <b>Reemplazar</b>
    <?php	
    break;
    
    case "I":
    ?>
    Inspeccionar
    <?php
    break;
    
    case "A":
    ?>
    Ajustar
    <?php
    break;
	
	    case "T":
    ?>
    Apretar
    <?php
    break;
	    case "L":
    ?>
    Lubricar
    <?php
    break;  
	case "U":
    ?>
	
     <b>Agregar</b>
    <?php
    break;
    

	case "P":
    ?>
	
    Consultivo
    <?php
    break;

    default:
    ?>
    -
    <?php
    break;
    }
    ?></td>
    <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >
    <?php
    switch($DatFichaAccionMantenimiento->FaaVerificar1){
    case 1:
    ?>
    Realizado
    
    <?php	
    break;
    
    case 2:
    ?>
    No Realizado
    <?php
    break;
    
    default:
    ?>
    -
    <?php
    break;
    }
    ?>
    
    </td>
    </tr>
    
    
    
    <?php
    $i++;
    }
    ?>
    <?php	
    
    
    
    }
    
    
    } 
    
    
    
    
    
    ?>
    </tbody>
    </table>
    <?php	
		break;
	}
	?>
  
    </td>
    </tr>
    
    
     <tr>
      <td colspan="2" valign="top">FOTOS</td>
    </tr>
 
 <tr>
            <td colspan="2" valign="top">
            
            <?php
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						


?>

<img src="../../subidos/ficha_accion_fotos/<?php echo $DatFichaAccionFoto->FafArchivo;?>" alt="<?php echo $DatFichaAccionFoto->FafArchivo;?>" title="<?php echo $DatFichaAccionFoto->FafArchivo;?>" width="50" height="50" border="0" />

<?php
					}
}
?>  
            
            </td>
            </tr>     
            
            
            
    </table>
			
       
<?php	
break;



case "LI":
?>

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
            <td>  
            
            <span class="EstFichaIngresoImprimirCabecera"				>
				<?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [LI<?php //echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]              
                
                </span>
			</td>
			</tr>
            <tr>
              <td align="center" valign="top">TRABAJO REALIZADO</td>
            </tr>
            
            
            <tr>
              <td width="50%" height="40" valign="top">
                
                <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
                  <thead class="EstFichaIngresoImprimirTablaHead">
                    <tr>
                      <th width="5%" align="center" >#</th>
                      <th width="19%" align="center" >&nbsp;</th>
                      <th width="76%" align="center" >&nbsp;</th>
                      </tr>
                    </thead>
                  <tbody class="EstFichaIngresoImprimirTablaBody">
                    <?php
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
		?>
                    <?php
        		//if($DatFichaAccionTarea->FatEstado == 1){
            ?>
                    <tr>
                      <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                      <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php
      switch($DatFichaAccionTarea->FatAccion){
        case "L":
    ?>
                        Planchado
                        <?php	
        break;
        
        case "N":
    ?>
                        Pintado
                        <?php
        break;
		
		case "E":
					?>
                        Centrado
                        <?php
		break;
		
		case "Z":
					?>
                        Tarea/Reparacion
                        <?php
		break;
		
        default:
    ?>
                        -
                        <?php
        break;
      }
      ?></td>
                      <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionTarea->FatDescripcion;?></td>
                      </tr>
                    <?php
				  $i++;
				//}
         
            ?>
                    
  <?php	
					 
		}
	} 
?>
                    
                    </tbody>
                  </table>
                
                
                
              </td>
            </tr>
           
            
   <?php
   	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto)){
   ?> 
    <tr>
            <td height="100" valign="top">
            
                    
            <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
              <thead class="EstFichaIngresoImprimirTablaHead">
                <tr>
                  <th width="2%" align="center" >#</th>
                  <th width="75%" align="center" >Cambios  realizados</th>
                  <th width="11%" align="center" >Actividad</th>
                  <th width="12%" align="center" >Accion</th>
                </tr>
              </thead>
              <tbody class="EstFichaIngresoImprimirTablaBody">
        
	<?php
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
		?>
			<tr>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionProducto->ProNombre;?></td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >Cambiar </td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php
	switch($DatFichaAccionProducto->FapVerificar1){
		case 1:
?>
                    Realizado
                    <?php	
		break;
	
		case 2:
?>
                    No Realizado
                    <?php
		break;
	
		default:
?>
                    -
                    <?php
	break;
  }
  ?></td>
			</tr>
		<?php
		 $i++;	
		
		}
?>

              </tbody>
            </table>
    </td>
            </tr>          
<?php
	} 
?>
            
             <?php
if(!empty($DatFichaIngresoModalidad->FichaAccion->FccCausa)){
?>   
    <tr>
      <td colspan="2" valign="top">
      CAUSAS DEL PROBLEMA
      </td>
    </tr>
    <tr>
            <td colspan="2" valign="top">
   
<?php
echo $DatFichaIngresoModalidad->FichaAccion->FccCausa;
?>       
            
    </td>
            </tr>     
            
<?php
}
?>  
          
 <tr>
      <td colspan="2" valign="top">FOTOS</td>
    </tr>
 
 <tr>
            <td colspan="2" valign="top">
            
            <?php
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						


?>

<img src="../../subidos/ficha_accion_fotos/<?php echo $DatFichaAccionFoto->FafArchivo;?>" alt="<?php echo $DatFichaAccionFoto->FafArchivo;?>" title="<?php echo $DatFichaAccionFoto->FafArchivo;?>" width="50" height="50" border="0" />

<?php
					}
}
?>  
            
            </td>
            </tr>     
            
          
		</table>


<?php	
break;


case "SI":
?>

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
            <td>  
            
            <span class="EstFichaIngresoImprimirCabecera"				>
				<?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [SI<?php //echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]              
                
                </span>
			</td>
			</tr>
            <tr>
              <td align="center" valign="top">TRABAJO REALIZADO</td>
            </tr>
            
            
            <tr>
              <td width="50%" height="40" valign="top">
                
                <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
                  <thead class="EstFichaIngresoImprimirTablaHead">
                    <tr>
                      <th width="5%" align="center" >#</th>
                      <th width="19%" align="center" >&nbsp;</th>
                      <th width="76%" align="center" >&nbsp;</th>
                      </tr>
                    </thead>
                  <tbody class="EstFichaIngresoImprimirTablaBody">
                    <?php
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
		?>
                    <?php
        		//if($DatFichaAccionTarea->FatEstado == 1){
            ?>
                    <tr>
                      <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                      <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php
      switch($DatFichaAccionTarea->FatAccion){
        case "L":
    ?>
                        Planchado
                        <?php	
        break;
        
        case "N":
    ?>
                        Pintado
                        <?php
        break;
		
		case "E":
					?>
                        Centrado
                        <?php
		break;
		
		case "Z":
					?>
                        Tarea/Reparacion
                        <?php
		break;
		
        default:
    ?>
                        -
                        <?php
        break;
      }
      ?></td>
                      <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionTarea->FatDescripcion;?></td>
                      </tr>
                    <?php
				  $i++;
				//}
         
            ?>
                    
  <?php	
					 
		}
	} 
?>
                    
                    </tbody>
                  </table>
                
                
                
              </td>
            </tr>
           
            
   <?php
   	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto)){
   ?> 
    <tr>
            <td height="100" valign="top">
            
                    
            <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
              <thead class="EstFichaIngresoImprimirTablaHead">
                <tr>
                  <th width="2%" align="center" >#</th>
                  <th width="75%" align="center" >Cambios  realizados</th>
                  <th width="11%" align="center" >Actividad</th>
                  <th width="12%" align="center" >Accion</th>
                </tr>
              </thead>
              <tbody class="EstFichaIngresoImprimirTablaBody">
        
	<?php
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
		?>
			<tr>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaAccionProducto->ProNombre;?></td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >Cambiar </td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php
	switch($DatFichaAccionProducto->FapVerificar1){
		case 1:
?>
                    Realizado
                    <?php	
		break;
	
		case 2:
?>
                    No Realizado
                    <?php
		break;
	
		default:
?>
                    -
                    <?php
	break;
  }
  ?></td>
			</tr>
		<?php
		 $i++;	
		
		}
?>

              </tbody>
            </table>
    </td>
            </tr>          
<?php
	} 
?>
      
      
                   <?php
if(!empty($DatFichaIngresoModalidad->FichaAccion->FccPedido)){
?>   
    <tr>
      <td colspan="2" valign="top">
     PEDIDO DE TALLER 
      </td>
    </tr>
    <tr>
            <td colspan="2" valign="top">
   
<?php
echo $DatFichaIngresoModalidad->FichaAccion->FccPedido;
?>       
            
    </td>
            </tr>     
            
<?php
}
?>  

      
             <?php
if(!empty($DatFichaIngresoModalidad->FichaAccion->FccCausa)){
?>   
    <tr>
      <td colspan="2" valign="top">
      CAUSAS DEL PROBLEMA
      </td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><?php
echo $DatFichaIngresoModalidad->FichaAccion->FccCausa;
?></td>
    </tr>

    
    
    
            
<?php
}
?>  
           
     <tr>
      <td colspan="2" valign="top">FOTOS</td>
    </tr>
 
 <tr>
            <td colspan="2" valign="top">
            
            <?php
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						


?>

<img src="../../subidos/ficha_accion_fotos/<?php echo $DatFichaAccionFoto->FafArchivo;?>" alt="<?php echo $DatFichaAccionFoto->FafArchivo;?>" title="<?php echo $DatFichaAccionFoto->FafArchivo;?>" width="50" height="50" border="0" />

<?php
					}
}
?>  
            
            </td>
            </tr>     
            
            
            
                     
		</table>


<?php	
break;

}

?>


<?php
/*if($DatFichaIngresoModalidad->MinId == "MIN-10001"){
?>
     
<?php	
}else{
?>
    
			
<?php	
}*/
?>   
            

<?php


$Adicional = false;
if(!empty($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle)){
	foreach($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
		if(empty($DatTallerPedidoDetalle->FapId) and empty($DatTallerPedidoDetalle->FaaId)){
			$Adicional = true;
		break;
		}
	}
}



//deb($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle);
////$DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle

//if(!empty($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle)){
if($Adicional){
?>
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
            <td>  
				ADICIONALES          
			</td>
			</tr>
            <tr>
            <td valign="top">


<table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
    <thead class="EstFichaIngresoImprimirTablaHead">
    <tr>
    <th width="2%" align="center" >#</th>
    <th width="75%" align="center" >Detalle del trabajo a realizado</th>
    <th width="11%" align="center" >Actividad</th>
    <th width="12%" align="center" >Accion</th>
    </tr>
    </thead>
    <tbody class="EstFichaIngresoImprimirTablaBody">
    
    
    
    <?php
    $i=1;
    foreach($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
    ?>
    
		<?php
        if(empty($DatTallerPedidoDetalle->FapId) and empty($DatTallerPedidoDetalle->FaaId)){
        ?>
			<tr>
				<td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
				<td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatTallerPedidoDetalle->ProNombre;?></td>
				<td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >Cambiar</td>
				<td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" >Realizado</td>
			</tr>
        <?php	
        }
        ?>
    
    <?php	
	$i++;
    }
	?>
    
    </tbody>
    </table>

    

			</td>
		</tr>
		</table>
        
<?php
}
?>		
            
			<?php
			}
			?>             
              
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </td>
</tr>
<tr>
  <td colspan="6" valign="top"><div class="EstFichaIngresoImprimirCapa">
    <table width="100%" height="254" border="0" cellpadding="3" cellspacing="2" class="EstFichaIngresoImprimirTabla">
      
      <tbody class="EstFichaIngresoImprimirTablaBody"><tr>
        <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Notas:</span></td>
        <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><?php echo $InsFichaIngreso->FinNota;?></td>
      </tr>
      <tr>
        <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Indicaciones para el Tecnico:</span></td>
        <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><?php echo $InsFichaIngreso->FinIndicacionTecnico;?></td>
      </tr>
        <tr>
          <td width="24%" height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo">
            
            <span class="EstFichaIngresoImprimirEtiqueta">Observacion/Recepcion:</span></td>
          <td width="76%" height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><?php echo $InsFichaIngreso->FinObservacion;?></td>
        </tr>
        <tr>
          <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Observacion/Trabajo Terminado:</span></td>
          <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><?php echo $InsFichaIngreso->FinSalidaObservacion;?></td>
        </tr>
        <tr>
          <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Observacion INTERNA:</span></td>
          <td height="40" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><?php echo $InsFichaIngreso->FinSalidaObservacionInterna;?></td>
        </tr>
        </tbody>
    </table>
  </div></td>
</tr>
<tr>
  <td colspan="6" valign="top"><div class="EstFichaIngresoImprimirCapa">
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstFichaIngresoImprimirTabla">
      <tbody class="EstFichaIngresoImprimirTablaBody">
        <tr>
          <td width="25%" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Firma del Jefe de Taller:</span></td>
          <td width="25%" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Firma de mecanico asignado:</span></td>
          </tr>
        <tr>
          <td height="30" align="left" valign="top" >&nbsp;</td>
          <td height="30" align="left" valign="top" >&nbsp;</td>
        </tr>
        </tbody>
      </table>
    </div></td>
</tr>

<tr>
  <td colspan="6" valign="top">&nbsp;</td>
</tr>

</table>

</body>
</html>
