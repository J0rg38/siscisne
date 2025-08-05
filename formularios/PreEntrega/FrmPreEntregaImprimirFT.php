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
$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();

//deb($InsFichaIngreso);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pre-Entrega (PDS) No. <?php echo $InsFichaIngreso->FinId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssPreEntregaImpresion.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPreEntregaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsFichaIngreso->FinId)){?> 
FncPreEntregaImprimir(); 
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
  <td colspan="3" align="left" valign="top"><span class="EstPreEntregaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="28%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" title="Logo" alt="Logo" border="0" /></td>
  <td width="46%" align="center" valign="top">
  
  <span class="EstPlantillaTitulo">FICHA TECNICA</span> <br />
  
  <span class="EstPlantillaTituloCodigo">
  <?php echo $InsFichaIngreso->FinId;?></span>
  
  
  </td>
  <td width="26%" align="right" valign="top">
    <span class="EstPlantillaoDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">

<tr>
    <td width="65%" valign="top">
      
      <div class="EstPreEntregaImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
          <tbody class="EstPreEntregaImprimirTablaBody">
            <tr>
              <td width="14%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Asesor</span></td>
              <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->PerNombreAsesor;?> <?php echo $InsFichaIngreso->PerApellidoPaternoAsesor;?> <?php echo $InsFichaIngreso->PerApellidoMaternoAsesor;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><span class="EstPreEntregaImprimirEtiqueta">Cliente</span></td>
              <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->CliNombre;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Contacto</span></td>
              <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinContacto;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Direccion</span></td>
              <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinDireccion;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Celular</span></td>
              <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinTelefono;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">TECNICO</span></td>
              <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top"><span class="EstPreEntregaImprimirContenido"><?php echo ($InsFichaIngreso->PerNombre);?> <?php echo ($InsFichaIngreso->PerApellidoPaterno);?> <?php echo ($InsFichaIngreso->PerApellidoMaterno);?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Fecha de Cita</span></td>
              <td width="2%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td width="18%" align="left" valign="top"><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinFechaCita;?></span></td>
              <td width="18%" align="left" valign="top"><span class="EstPreEntregaImprimirEtiqueta">Fecha de Entrega:</span></td>
              <td width="18%" align="left" valign="top"><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinFechaEntrega;?></span></td>
              <td width="8%" align="left" valign="top"><span class="EstPreEntregaImprimirEtiqueta">R:</span></td>
              <td width="22%" align="left" valign="top"><span class="EstPreEntregaImprimirContenido">-</span></td>
            </tr>
          </tbody>
        </table>
        
      </div>
      
    </td>
    <td width="35%" valign="top"><div class="EstPreEntregaImprimirCapa">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
        <tbody class="EstPreEntregaImprimirTablaBody">
          <tr>
            <td width="46%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">No. de O/T:</span></td>
            <td width="6%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td width="48%" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinId;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><span class="EstPreEntregaImprimirEtiqueta">Fecha de O/T:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinFecha;?> <?php echo $InsFichaIngreso->FinHora;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">RECEPCION de O/T:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" >
            
            <span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinTiempoTallerRevisando;?> </span>
            
            
            
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta"> TERMINADO  O/T:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" >
            
            <span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinTiempoTrabajoTerminado;?></span>
            
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">No. de Chasis:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->EinVIN;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">No. de Placa:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->EinPlaca;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Modelo/Año:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" >
              
              <span class="EstPreEntregaImprimirContenido">
                <?php echo $InsFichaIngreso->VmaNombre;?>/
                <?php echo $InsFichaIngreso->VmoNombre;?>/
                <?php echo $InsFichaIngreso->VveNombre;?>/
                <?php echo $InsFichaIngreso->EinAnoFabricacion;?></span>
              </td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Kilometraje:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinVehiculoKilometraje;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">&nbsp;</td>
            <td align="left" valign="top" >&nbsp;</td>
            <td align="left" valign="top" >&nbsp;</td>
            </tr>
          </tbody>
        </table>
    </div></td>
  </tr>
  
<tr>
  <td colspan="6" valign="top">
    <div class="EstPreEntregaImprimirCapa">
      <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPreEntregaImprimirTabla">
        <tbody class="EstPreEntregaImprimirTablaBody">
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
				<?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [<?php echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]              
			</td>
			</tr>
            <tr>
              <td align="center" valign="top">PRE - DIAGNOSTICO</td>
              <td align="center" valign="top">TRABAJO REALIZADO</td>
            </tr>
            <tr>
              <td width="50%" height="40" valign="top">
              
              <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
                <thead class="EstPreEntregaImprimirTablaHead">
                  <tr>
                    <th width="5%" align="center" >#</th>
                    <th width="95%" align="center" >&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="EstPreEntregaImprimirTablaBody">
                  <?php
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
?>
                  <?php
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
		?>
                  <?php
        		if($DatFichaAccionTarea->FatEstado == 2){
            ?>
                  <tr>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaAccionTarea->FatDescripcion;?></td>
                    </tr>
                  <?php
				   $i++;
				}
         
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
              
              <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
                <thead class="EstPreEntregaImprimirTablaHead">
                  <tr>
                    <th width="5%" align="center" >#</th>
                    <th width="76%" align="center" >&nbsp;</th>
                    <th width="19%" align="center" >&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="EstPreEntregaImprimirTablaBody">
                  <?php
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
		?>
                  <?php
        		if($DatFichaAccionTarea->FatEstado == 1){
            ?>
                  <tr>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaAccionTarea->FatDescripcion;?></td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php
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
            <td height="100" colspan="2" valign="top">
            
                    
            <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
              <thead class="EstPreEntregaImprimirTablaHead">
                <tr>
                  <th width="2%" align="center" >#</th>
                  <th width="75%" align="center" >Cambios  realizados</th>
                  <th width="11%" align="center" >Actividad</th>
                  <th width="12%" align="center" >Accion</th>
                </tr>
              </thead>
              <tbody class="EstPreEntregaImprimirTablaBody">
        
	<?php
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
		?>
			<tr>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaAccionProducto->ProNombre;?></td>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >Cambiar </td>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php
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
          
		</table>
        
        
        
<?php	
break;

case "MA":
?>


    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td>  
    
    <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [<?php echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]              </td>
    </tr>
    <tr>
    <td height="100" valign="top">
	<?php
	switch($InsFichaIngreso->VmaId){
		
		default:
	?>
      <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
    <thead class="EstPreEntregaImprimirTablaHead">
    <tr>
    <th width="2%" align="center" >#</th>
    <th width="74%" align="center" >Detalle del trabajo a realizado</th>
    <th width="11%" align="center" >Actividad</th>
    <th width="13%" align="center" >Accion</th>
    </tr>
    </thead>
    <tbody class="EstPreEntregaImprimirTablaBody">
    
    
    
    <?php
    
    $i=1;
    if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento)){
    foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
    
    ?>
    
    <?php
    if(($DatFichaAccionMantenimiento->FaaAccion<>"X" and !empty($DatFichaAccionMantenimiento->FaaAccion))){
    ?>
    
    <tr>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaAccionMantenimiento->PmtNombre;?></td>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php
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
    Cambiar
    <?php
    break;
    
    default:
    ?>
    -
    <?php
    break;
    }
    ?></td>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >
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
      <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
    <thead class="EstPreEntregaImprimirTablaHead">
    <tr>
    <th width="2%" align="center" >#</th>
    <th width="74%" align="center" >Detalle del trabajo a realizado</th>
    <th width="11%" align="center" >Actividad</th>
    <th width="13%" align="center" >Accion</th>
    </tr>
    </thead>
    <tbody class="EstPreEntregaImprimirTablaBody">
    
    
    
    <?php
    
    $i=1;
    if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento)){
    foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
    
    ?>
    
    <?php
    if(($DatFichaAccionMantenimiento->FaaAccion<>"X" and !empty($DatFichaAccionMantenimiento->FaaAccion))){
    ?>
    
    <tr>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaAccionMantenimiento->PmtNombre;?></td>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >
	
                    
					
					<?php
    switch($DatFichaAccionMantenimiento->FaaAccion){
    case "R":
    ?>
    Reemplazar
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
    default:
    ?>
    -
    <?php
    break;
    }
    ?></td>
    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >
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
    </table>
			
       
<?php	
break;

case "SI":
?>



    <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
            <td>  
				<?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [<?php echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]              
			</td>
			</tr>
            <tr>
              <td align="center" valign="top">TRABAJO REALIZADO</td>
            </tr>
            
            
            <tr>
              <td width="50%" height="40" valign="top">
                
                <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
                  <thead class="EstPreEntregaImprimirTablaHead">
                    <tr>
                      <th width="5%" align="center" >#</th>
                      <th width="19%" align="center" >&nbsp;</th>
                      <th width="76%" align="center" >&nbsp;</th>
                      </tr>
                    </thead>
                  <tbody class="EstPreEntregaImprimirTablaBody">
                    <?php
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
		?>
                    <?php
        		//if($DatFichaAccionTarea->FatEstado == 1){
            ?>
                    <tr>
                      <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
                      <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php
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
                      <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaAccionTarea->FatDescripcion;?></td>
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
            
                    
            <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
              <thead class="EstPreEntregaImprimirTablaHead">
                <tr>
                  <th width="2%" align="center" >#</th>
                  <th width="75%" align="center" >Cambios  realizados</th>
                  <th width="11%" align="center" >Actividad</th>
                  <th width="12%" align="center" >Accion</th>
                </tr>
              </thead>
              <tbody class="EstPreEntregaImprimirTablaBody">
        
	<?php
		foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
		?>
			<tr>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaAccionProducto->ProNombre;?></td>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >Cambiar </td>
                  <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php
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
//deb($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle);
////$DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle

if(!empty($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle)){
?>
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
            <td>  
				ADICIONALES          
			</td>
			</tr>
            <tr>
            <td valign="top">


<table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
    <thead class="EstPreEntregaImprimirTablaHead">
    <tr>
    <th width="2%" align="center" >#</th>
    <th width="75%" align="center" >Detalle del trabajo a realizado</th>
    <th width="11%" align="center" >Actividad</th>
    <th width="12%" align="center" >Accion</th>
    </tr>
    </thead>
    <tbody class="EstPreEntregaImprimirTablaBody">
    
    
    
    <?php
    $i=1;
    foreach($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
    ?>
    
		<?php
        if(empty($DatTallerPedidoDetalle->FapId) and empty($DatTallerPedidoDetalle->FaaId)){
        ?>
			<tr>
				<td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
				<td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatTallerPedidoDetalle->ProNombre;?></td>
				<td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >Cambiar</td>
				<td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >Realizado</td>
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
  <td colspan="6" valign="top"><div class="EstPreEntregaImprimirCapa">
    <table width="100%" height="63" border="0" cellpadding="3" cellspacing="2" class="EstPreEntregaImprimirTabla">
      <tbody class="EstPreEntregaImprimirTablaBody">
        <tr>
          <td width="24%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">
          
          <span class="EstPreEntregaImprimirEtiqueta">Observacion/Recepcion:</span></td>
          <td width="76%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><?php echo $InsFichaIngreso->FinObservacion;?></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><span class="EstPreEntregaImprimirEtiqueta">
          Observacion/Trabajo Terminado:</span></td>
          <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><?php echo $InsFichaIngreso->FinSalidaObservacion;?></td>
        </tr>
      </tbody>
    </table>
  </div></td>
</tr>
<tr>
  <td colspan="6" valign="top"><div class="EstPreEntregaImprimirCapa">
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPreEntregaImprimirTabla">
      <tbody class="EstPreEntregaImprimirTablaBody">
        <tr>
          <td width="25%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><span class="EstPreEntregaImprimirEtiqueta">Firma del Jefe de Taller:</span></td>
          <td width="25%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><span class="EstPreEntregaImprimirEtiqueta">Firma de conformidad del cliente</span></td>
          </tr>
        <tr>
          <td height="30" align="left" valign="top" >&nbsp;</td>
          <td height="30" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">
          <span class="EstPreEntregaImprimirEtiqueta">Firma de mecanico asignado:</span></td>
          <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">&nbsp;</td>
          </tr>
        <tr>
          <td height="30" align="left" valign="top" >&nbsp;</td>
          <td height="30" align="left" valign="top" >&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </div></td>
</tr>
</table>

</body>
</html>
