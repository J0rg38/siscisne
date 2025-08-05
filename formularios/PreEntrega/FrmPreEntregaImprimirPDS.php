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

require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');


$InsFichaIngreso = new ClsFichaIngreso();

$InsFichaIngreso->FinId = $GET_id;
$InsFichaIngreso->MtdObtenerFichaIngreso();

//INSTANCIAS
$InsPreEntregaSeccion = new ClsPreEntregaSeccion();
$InsPreEntregaTarea = new ClsPreEntregaTarea();

$RepPreEntregaSeccion = $InsPreEntregaSeccion->MtdObtenerPreEntregaSecciones(NULL,NULL,"PesId","ASC",NULL);
$ArrPreEntregaSecciones = $RepPreEntregaSeccion['Datos'];


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
  <td width="26%" align="left" valign="top"><?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>"  width="140" height="39"/>
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="140" height="39" />
    <?php	
		}
		?></td>
  <td width="47%" align="center" valign="top">
  
  <span class="EstPlantillaTitulo">SERVICIO PRE-ENTREGA DEL VEHICULO - PDS</span><br />
  
  <span class="EstPlantillaTituloCodigo">
  <?php echo $InsFichaIngreso->FinId;?></span>
  
  
  </td>
  <td width="27%" align="right" valign="top">
    <span class="EstPlantillaoDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>


	



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPreEntregaImprimirTabla">

<tr>
  <td width="600" colspan="6" align="center" valign="top"><div class="EstPreEntregaImprimirCapa">
    
    
    
    
    
    <table width="656" border="0" cellpadding="0" cellspacing="0" class="EstInventarioImprimirTabla">
      <thead class="EstInventarioImprimirTablaHead">
        <tr>
          <th width="5" >&nbsp;</th>
          <th width="342" >SECCIONES</th>
          
          
          
          <th width="82"  >
            CONFORME
            </th>
          <th width="65">
            NO CONFORME
            </th>
          <th width="56">
            NO APLICA
            </th>
          
          
          </tr>
        </thead>
      <tbody class="EstInventarioImprimirTablaBody">               
        <?php
	foreach($ArrPreEntregaSecciones as $DatPreEntregaSeccion){

	
		$ResPreEntregaTarea = $InsPreEntregaTarea->MtdObtenerPreEntregaTareas(NULL,NULL,'PetNombre','ASC',NULL,$DatPreEntregaSeccion->PesId);
		$ArrPreEntregaTareas = $ResPreEntregaTarea['Datos'];
?>
        <?php
	if(!empty($ArrPreEntregaTareas)){
	?>
        
        <tr>
          <td colspan="20" align="left" class="EstInventarioImprimirSeccion"><?php echo $DatPreEntregaSeccion->PesNombre;?></td>
          </tr>                
        <?php
            foreach($ArrPreEntregaTareas as $DatPreEntregaTarea){
            
            $PreEntregaDetalleId = '';
            $PreEntregaDetalleAccion = '';
            

    ?>
        
        
        
        
        <tr>
          <td height="15" class="EstInventarioImprimirTarea"><input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" id="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" value="<?php echo $DatPreEntregaTarea->PetId;?>" /></td>
          
          <td height="15" class="EstInventarioImprimirTarea">
            
            
            
            
            <?php echo $DatPreEntregaTarea->PetNombre;?>
            </td>
          
          
          
          <td height="15" align="center"   >
            
            <?php
                                /*
                                SesionObjeto-PreEntregaDetalle
                                Parametro1 = RedId
                                Parametro2 = 
                                Parametro3 = PetId
                                Parametro4 = RedAccion
                                Parametro5 = RedTiempoCreacion
                                */
                                
								$PDSDetalleAccion1 = "";
								$PDSDetalleAccion2 = "";
								$PDSDetalleAccion3 = "";
								
								$PreEntregaDetalleId = '';
								$PreEntregaDetalleAccion = '';

								//$InsFichaIngreso->PreEntregaDetalle()							


                                if(!empty($InsFichaIngreso->PreEntregaDetalle)){	
                                    foreach($InsFichaIngreso->PreEntregaDetalle as $DatPreEntregaDetalle){
                                            
								//$PreEntregaDetalleId = '';
//								$PreEntregaDetalleAccion = '';		
            
                                        if($DatPreEntregaDetalle->PetId == $DatPreEntregaTarea->PetId){
                                            
                                            $PreEntregaDetalleId = $DatPreEntregaDetalle->RedId;
                                            $PreEntregaDetalleAccion = $DatPreEntregaDetalle->RedAccion;
                                            
                                            break;
                                        }					
                                    }
                                }				
                                ?>
            
            
            
            
            <?php
					//deb($PreEntregaDetalleAccion);
					switch($PreEntregaDetalleAccion){
						case "1":
							$PDSDetalleAccion1 = 'checked="checked"';
						break; 
						
						case "2":
							$PDSDetalleAccion2 = 'checked="checked"';
						break;
						
						case "3":
							$PDSDetalleAccion3 = 'checked="checked"';						
						break;
						
						default:
							$PDSDetalleAccion3 = 'checked="checked"';		
						break;
					}
					?>
            
            
            <input size="2" type="hidden" name="CmpPreEntregaDetalleId_<?php echo $DatPreEntregaTarea->PetId;?>" id="CmpPreEntregaDetalleId_<?php echo $DatPreEntregaTarea->PetId;?>" value="<?php echo $PreEntregaDetalleId;?>" />
            
            <input size="2" type="hidden" name="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" id="CmpPreEntregaTareaId_<?php echo $DatPreEntregaTarea->PetId;?>" value="<?php echo $DatPreEntregaTarea->PetId;?>" />
            
            
            
            <?php
			   if($PDSDetalleAccion1=='checked="checked"'){
				?>
            X
            <?php  
			   }
			   ?>
            
            
            </td>
          
          <td height="15" align="center"   >
            
            <?php
			   if($PDSDetalleAccion2=='checked="checked"'){
				?>
            X
            <?php  
			   }
			   ?>
            
            </td>
          <td height="15" align="center">
            <?php
			   if($PDSDetalleAccion3=='checked="checked"'){
				?>
            X
            <?php  
			   }
			   ?>
            
            </td>
          </tr>
        
        
        <?php			
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
    
    
    
    </div></td>
</tr>

<tr>
  <td colspan="6" valign="top"><div class="EstPreEntregaImprimirCapa">
    
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPreEntregaImprimirTabla">
      <tbody class="EstPreEntregaImprimirTablaBody" >
        <tr>
          <td width="11%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">Concesionario</span></td>
          <td width="1%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->OncNombre;?></span></td>
          <td width="7%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">Fecha</span></td>
          <td width="1%" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinFecha;?></span></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">VIN</span></td>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->EinVIN;?></span></td>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">Kilometraje</span></td>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinVehiculoKilometraje;?></span></td>
          </tr>
        <tr>
          <td height="40" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">T&eacute;cnico</span></td>
          <td height="40" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td height="40" align="left" valign="top" ><span class="EstPreEntregaImprimirContenido"><?php echo ($InsFichaIngreso->PerNombre);?> <?php echo ($InsFichaIngreso->PerApellidoPaterno);?> <?php echo ($InsFichaIngreso->PerApellidoMaterno);?></span></td>
          <td height="40" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">Firma</span></td>
          <td height="40" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td height="40" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td height="30" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">Gerente de Servicio</span></td>
          <td height="30" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td width="38%" height="30" align="left" valign="top" >&nbsp;</td>
          <td height="30" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">Firma</span></td>
          <td height="30" align="left" valign="top" ><span class="EstPreEntregaImprimirEtiqueta">:</span></td>
          <td width="42%" height="30" align="left" valign="top" ><p align="center">&nbsp;</p></td>
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
