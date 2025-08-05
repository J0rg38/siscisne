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
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="22%" align="left" valign="top"> <img src="../../imagenes/logos/logo_impresion.png" width="150" title="Logo" alt="Logo" border="0" /></td>
  <td width="57%" align="center" valign="top">
  


  <span class="EstPlantillaImprimirEtiqueta">PRE-ENTREGA</span><br />
  <span class="EstPlantillaTituloCodigo"><?php echo $InsFichaIngreso->FinId;?></span> 
  
  
 
  
  </td>
  <td width="21%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">

<tr>
    <td width="75%" align="left" valign="top">
      
      <div class="EstPreEntregaImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
          <tbody class="EstPreEntregaImprimirTablaBody">
            <tr>
              <td width="13%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Asesor</span></td>
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
              <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Fecha de Cita</span></td>
              <td width="2%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
              <td width="20%" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinFechaCita;?></span></td>
              <td width="15%" align="left" valign="top"><span class="EstPreEntregaImprimirEtiqueta">Fecha de Entrega:</span></td>
              <td width="19%" align="left" valign="top"><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinFechaEntrega;?></span></td>
              <td width="8%" align="left" valign="top"><span class="EstPreEntregaImprimirEtiqueta">R:</span></td>
              <td width="23%" align="left" valign="top"><span class="EstPreEntregaImprimirContenido">-</span></td>
            </tr>
          </tbody>
        </table>
        
      </div>
      
    </td>
    <td width="25%" align="left" valign="top"><div class="EstPreEntregaImprimirCapa">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">
        <tbody class="EstPreEntregaImprimirTablaBody">
          <tr>
            <td width="49%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">No. de O/T</span></td>
            <td width="5%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td width="46%" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinId;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo"><span class="EstPreEntregaImprimirEtiqueta">Fecha de O/T</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinFecha;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">No. de Chasis</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->EinVIN;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">No. de Placa</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->EinPlaca;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Modelo/Año</span></td>
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
            <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo" ><span class="EstPreEntregaImprimirEtiqueta">Kilometraje</span></td>
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
        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
            <td height="30">    
			<?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> [<?php echo strtoupper($DatFichaIngresoModalidad->MinSigla);?>]
            </td>
            </tr>
            <tr>
            <td height="100" valign="top">

			<?php
            if($DatFichaIngresoModalidad->MinId <> "MIN-10001"){
				
			?>
            
            
              <table width="100%"  border="1" cellpadding="1" cellspacing="0" class="EstPreEntregaImprimirTabla">
                <thead class="EstPreEntregaImprimirTablaHead">
                  <tr>
                    <th width="2%" align="center" valign="top" >#</th>
                    <th width="76%" align="center" valign="top" >Detalle del trabajo a realizar</th>
                    <th width="12%" align="center" valign="top" >Actividad</th>
                    <th width="10%" align="center" valign="top" >&nbsp;</th>
                    </tr>
                  </thead>
                <tbody class="EstPreEntregaImprimirTablaBody">
                  <?php

	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
		
		
		foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
?>
                  <tr>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaIngresoTarea->FitDescripcion;?></td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php
  switch($DatFichaIngresoTarea->FitAccion){
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
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >
                    
                    
                    <?php
					if($DatFichaIngresoTarea->FatVerificar1==1){
					?>
                    Realizado
                    <?php	
					}
					?>
                    
                    
                    
                    
                    
                    
                    
                    </td>
                    </tr>
<?php	
		
	
		$i++;
		}
		
		
		
		
	} 
	
	
	
	
	
?>
                  </tbody>
                </table>
			
            
            
            <?php	
			}else{
			?>
            
            
              <table width="100%"  border="1" cellpadding="1" cellspacing="0" class="EstPreEntregaImprimirTabla">
                <thead class="EstPreEntregaImprimirTablaHead">
                  <tr>
                    <th width="3%" align="center" valign="top" >#</th>
                    <th width="75%" align="center" valign="top" >Detalle del trabajo a realizar</th>
                   
                    <th width="12%" align="center" valign="top" >Actividad</th>
                     <th width="10%" align="center" valign="top" >ESTADO</th>
                    </tr>
                  </thead>
                <tbody class="EstPreEntregaImprimirTablaBody">
                  <?php

	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaIngresoMantenimiento)){
		foreach($DatFichaIngresoModalidad->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento){
			
			if($DatFichaIngresoMantenimiento->FiaAccion<>"X" and !empty($DatFichaIngresoMantenimiento->FiaAccion)){
				
			
?>
                  <tr>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido"><?php echo $i;?>.-</td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" ><?php echo $DatFichaIngresoMantenimiento->PmtNombre;?></td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >
                    
                    <?php


  switch($DatFichaIngresoMantenimiento->FiaAccion){
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
  ?>
  
                    </td>
                    <td align="right" valign="top" class="EstPreEntregaDetalleImprimirContenido" >
                    
                    
                    <?php
					if($DatFichaIngresoMantenimiento->FaaVerificar1==1){
					?>
                    Realizado
                    <?php	
					}
					?>
                    
                    </td>
                    </tr>
<?php	
		
	
			$i++;
			}
		}
		
		
		
		
	} 
	
	
	
	
	
?>
                  </tbody>
                </table>
			
            
            
            
            <?php	
			}
            ?>
            
            
            </td>
            </tr>
            </table>
			
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
    <table width="100%" height="155" border="0" cellpadding="3" cellspacing="2" class="EstPreEntregaImprimirTabla">
      <tbody class="EstPreEntregaImprimirTablaBody">
        <tr>
          <td colspan="2" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">Vista al rededor del vehiculo e inventario:</td>
          <td width="25%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">Fecha de Inspeccion:</td>
          <td width="25%" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">Firma de conformidad del cliente</td>
          </tr>
        <tr>
          <td width="17%" rowspan="3" align="left" valign="top">
          
          <img src="../../imagenes/orden_trabajo1.png" width="186" height="114" />
          </td>
          <td width="33%" rowspan="3" align="left" valign="top" >
          
		<?php
		if(!empty($InsFichaIngreso->FichaIngresoSevero)){
		?>
        	<table border="0" cellpadding="0" cellspacing="0">
			<?php
			foreach($InsFichaIngreso->FichaIngresoSevero as $DatFichaIngresoSevero){
            ?>
            	<tr>
            	  <td></td>
                <td>
            	<?php echo $DatFichaIngresoSevero->PmtNombre;?>
                </td>
                <td>=&gt;</td>
                <td>
				
                <?php
				switch($DatFichaIngresoSevero->FidAccion){
                
                        case "I":
                ?>
                Inspeccionar
                <?php
                        break;
                        
                        case "C":
				?>
                Cambiar
                <?php
                        break;
                        
                        case "R":
				?>
                Revisar
                <?php
                        break;
                        
                        case "X":
				?>
                -
                <?php
                        break;
                
                    }
				?>
                </td>
                </tr>
            <?php    
			}
            ?>
            </table>
        <?php
		}
		?>
          
          </td>
          <td height="38" align="left" valign="top" >&nbsp;</td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td height="25" align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">Firma de inspector</td>
          <td align="left" valign="top" class="EstPreEntregaImprimirEtiquetaFondo">Condiciones de conformidad</td>
          </tr>
        <tr>
          <td align="left" valign="top" >&nbsp;</td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
      </tbody>
    </table>
  </div></td>
</tr>
</table>

</body>
</html>
