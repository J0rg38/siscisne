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
$GET_Tipo = $_GET['Tipo'];
$GET_FichaIngresoId = $_GET['FichaIngresoId'];
$GET_OrdenVentaVehiculoId = $_GET['OrdenVentaVehiculoId'];

//if(!empty($GET_OrdenVentaVehiculoId)){
//	$Tipo = "VENTA";
//}else{
//	$Tipo = "POSTVENTA";
//}


require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPregunta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaRespuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaSeccion.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsEncuesta = new ClsEncuesta();
$InsFichaIngreso = new ClsFichaIngreso();

//$InsFichaIngreso->FinId = $GET_FichaIngresoId;
//$InsFichaIngreso->MtdObtenerFichaIngreso(false);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ENCUESTA</title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssEncuestaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsEncuestaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/CssEncuestaImprimir.css"/>


<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 ){?> 
FncEncuestaImprimir(); 
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
  <td colspan="3" align="left" valign="top"><span class="EstEncuestaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="37%" align="left" valign="top"> <img src="../../imagenes/logos/logo_impresion.png" width="150" title="Logo" alt="Logo" border="0" /></td>
  <td width="26%" align="center" valign="top">
  
  <span class="EstPlantillaTitulo">ENCUESTA POST  VENTA</span><br />
  
  <span class="EstPlantillaTituloCodigo">
  <?php echo $InsEncuesta->FinId;?></span>
  
  
  </td>
  <td width="37%" align="right" valign="top">
   <!-- <span class="EstPlantillaoDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?>
    <br />
    <?php echo $InsFichaIngreso->FinId;?>
    </span>--></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstEncuestaImprimirTabla">

<tr>
  <td colspan="6" valign="top">
  
  
  <div class="EstEncuestaImprimirCapa">
                       
            <?php

            //MtdObtenerEncuestaPreguntaSeccions($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 
            $InsEncuestaPreguntaSeccion = new ClsEncuestaPreguntaSeccion();
            $ResEncuestaPreguntaSeccion = $InsEncuestaPreguntaSeccion->MtdObtenerEncuestaPreguntaSecciones(NULL,NULL,NULL,'EpsId','ASC',NULL,3,$GET_Tipo);
            $ArrEncuestaPreguntaSecciones = $ResEncuestaPreguntaSeccion['Datos'];
            ?>
              
<?php
if(!empty($ArrEncuestaPreguntaSecciones)){
	foreach($ArrEncuestaPreguntaSecciones as $DatEncuestaPreguntaSeccion){
?>
              
              
			<?php echo strtoupper($DatEncuestaPreguntaSeccion->EpsNombre);?>
                          
            <?php
            $InsEncuestaPregunta = new ClsEncuestaPregunta();
            //MtdObtenerEncuestaPreguntas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oTipo=NULL,$oSeccion=NULL)
            $ResEncuestaPregunta = $InsEncuestaPregunta->MtdObtenerEncuestaPreguntas(NULL,NULL,NULL,'EprOrden','ASC',NULL,3,0,0,$DatEncuestaPreguntaSeccion->EpsId);
            $ArrEncuestaPreguntas = $ResEncuestaPregunta['Datos'];
            ?>
              
              
              <table width="100%" border="0" cellpadding="2" cellspacing="2">               
                
                <?php
	if(!empty($ArrEncuestaPreguntas)){
		foreach($ArrEncuestaPreguntas as $DatEncuestaPregunta){
			
			  $respuesta1 = "";
                                $iddetalle = "";
?>
                
                <tr>
                  <td width="51%" align="left" valign="top">&nbsp;- <?php  echo $DatEncuestaPregunta->EprNombre;?></td>
                  <td width="49%" align="left" valign="top">
                    
                    <?php //deb("PREGUNTA: ".$DatEncuestaPregunta->EprId);?>
                    
                    <?php
                        
							$InsEncuestaPreguntaRespuesta = new ClsEncuestaPreguntaRespuesta();
							//  MtdObtenerEncuestaPreguntaRespuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuestaPregunta=NULL) 
							$ResEncuestaPreguntaRespuesta = $InsEncuestaPreguntaRespuesta->MtdObtenerEncuestaPreguntaRespuestas(NULL,NULL,NULL,'EpeId','ASC',NULL,3,$DatEncuestaPregunta->EprId);
							$ArrEncuestaPreguntaRespuestas = $ResEncuestaPreguntaRespuesta['Datos'];
						
							$iddetalle = "";
							
							if(!empty($InsEncuesta->EncuestaDetalle)){
								foreach($InsEncuesta->EncuestaDetalle as $DatEncuestaDetalle){
										
									if($DatEncuestaDetalle->EprId == $DatEncuestaPregunta->EprId){
	
										//if($DatEncuestaDetalle->EdeRespuesta == $DatEncuestaPreguntaRespuesta->EpeValor){
											
											$iddetalle = $DatEncuestaDetalle->EdeId;
											break 1;	
											
										//}	
										
											
									}
										
								}
							}
							
                        ?>
                    
                    <?php
						
                        if(!empty($ArrEncuestaPreguntaRespuestas)){
                            foreach($ArrEncuestaPreguntaRespuestas as $DatEncuestaPreguntaRespuesta){
						
								$respuesta1 = "";
								//$iddetalle = "";
                                if(!empty($InsEncuesta->EncuestaDetalle)){
                                    foreach($InsEncuesta->EncuestaDetalle as $DatEncuestaDetalle){
										//$respuesta1 = "";
                        				//$iddetalle = "";
										//if(empty($respuesta1 )){
											//deb("PREG-DETALLE: ".$DatEncuestaDetalle->EprId." - ".$DatEncuestaPregunta->EprId);
											if($DatEncuestaDetalle->EprId == $DatEncuestaPregunta->EprId){
	//deb($DatEncuestaDetalle->EprId." - ".$DatEncuestaDetalle->EdeRespuesta." - ".$DatEncuestaPreguntaRespuesta->EpeValor);
	//if(!empty($DatEncuestaDetalle->EdeRespuesta)){
	//deb("AAA: ".$DatEncuestaDetalle->EdeRespuesta." - ".$DatEncuestaPreguntaRespuesta->EpeValor);
												if($DatEncuestaDetalle->EdeRespuesta == $DatEncuestaPreguntaRespuesta->EpeValor){
													//$iddetalle = $DatEncuestaDetalle->EdeId;
													$respuesta1 = 'checked="checked"'; 
													//deb("PREG-RESPUESTA: ".$DatEncuestaDetalle->EdeRespuesta." - ".$iddetalle);
													break 1;	
												}	
												break 1;
											}
											
										//}
                                    }
                                }
								
								
								//deb("     PREG-RESPUESTA2: - ".$iddetalle);
								//$respuesta1 = "";
								//$iddetalle = "";
                                
                        ?>
                    
                    <!--<input type="radio" name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>"  id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>_<?php echo $DatEncuestaPreguntaRespuesta->EpeId?>" value="<?php echo $DatEncuestaPreguntaRespuesta->EpeValor?>" <?php echo $respuesta1?> />
                    -->
                    
                    <?php
					if($DatEncuestaPregunta->EprTipo=="2"){
					?>


                  <textarea class="EstFormularioCaja" name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>" id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>" cols="45" rows="4"></textarea>
                    <?php
					}else{
					?>
                      [__]
                    
                    <?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?> &nbsp;&nbsp;&nbsp;
                    <?php	
					}
					?>
                  
                    
                    <?php
                               
                            }
                        }
                        ?> 
                    
                    
                    
                    
                    <input name="CmpEncuestaDetalleId_<?php echo $DatEncuestaPregunta->EprId?>" type="hidden"  id="CmpEncuestaDetalleId_<?php echo $DatEncuestaPregunta->EprId?>" value="<?php echo $iddetalle;?>" size="10" />
                    
                    <br />
                    <!-- ------------------>
                    </td>
                  </tr>	
                
                
                <?php
		}
	}
?> 
                </table>               
              
              
              
              <br />        
              
              <?php	
	}	
}
?>    
       
  
  
  
   </div>
   
   </td>
</tr>


</table>

</body>
</html>
