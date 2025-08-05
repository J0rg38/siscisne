<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFunciones.js" ></script>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$GET_Tipo = $_GET['Tipo'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjEncuesta.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPregunta.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

//INSTANCIAS
$InsEncuesta = new ClsEncuesta();
$InsSucursal = new ClsSucursal();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccEncuestaEditar.php');

$InsEncuestaPreguntaSeccion = new ClsEncuestaPreguntaSeccion();
$ResEncuestaPreguntaSeccion = $InsEncuestaPreguntaSeccion->MtdObtenerEncuestaPreguntaSecciones(NULL,NULL,NULL,'EpsId','ASC',NULL,3,$InsEncuesta->EncTipo);
$ArrEncuestaPreguntaSecciones = $ResEncuestaPreguntaSeccion['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

?>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsEncuesta->EncId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        ENCUESTA POST VENTA</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsEncuesta->EncTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsEncuesta->EncTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">C&oacute;digo Interno:</td>
            <td colspan="3" align="left">
            
            <input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsEncuesta->EncId;?>" size="15" maxlength="20"  readonly="readonly"/>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Sucursal:</td>
            <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsEncuesta->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td colspan="3" align="left"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsEncuesta->EncFecha;?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo:</td>
            <td colspan="3" align="left" valign="top"><?php
			switch($InsEncuesta->EncTipo){
				case "VENTA":
					$OpcTipo1 = 'selected="selected"';
				break;
				
				case "POSTVENTA":
					$OpcTipo2 = 'selected="selected"';
				break;
				
			}
			?>
              <select disabled="disabled"  class="EstFormularioCombo" id="CmpTipo" name="CmpTipo">
                <option <?php echo $OpcTipo1;?> value="VENTA">VENTA</option>
                <option <?php echo $OpcTipo2;?> value="POSTVENTA">POSTVENTA</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Orden de Trabajo:</td>
            <td colspan="3" align="left"><table>
              <tr>
                <td><a href="javascript:FncFichaIngresoNuevo();"></a></td>
                <td><input name="CmpFichaIngresoId" id="CmpFichaIngresoId" type="hidden"    value="<?php  echo $InsEncuesta->FinId;?>" size="20" maxlength="20" />
                  <input name="CmpFichaIngreso" type="text" class="EstFormularioCaja" id="CmpFichaIngreso"  tabindex="3" value="<?php  echo $InsEncuesta->FinId;?>" size="25" maxlength="25" readonly="readonly" /></td>
                <td><!--<a href="javascript:FncFichaIngresoBuscar('Id');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>--></td>
                <td></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente:
              <input name="CmpClienteId" id="CmpClienteId" type="hidden"    value="<?php  echo $InsEncuesta->CliId;?>" size="20" maxlength="20" /></td>
            <td colspan="3" align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre" value="<?php echo $InsEncuesta->CliNombre;?> <?php echo $InsEncuesta->CliApellidoPaterno;?> <?php echo $InsEncuesta->CliApellidoMaterno;?>" size="25" maxlength="255"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">VIN:</td>
            <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVIN" value="<?php echo $InsEncuesta->EinPlaca;?>" size="25" maxlength="255"  readonly="readonly"/></td>
            <td align="left" valign="top">Placa:</td>
            <td align="left" valign="top"><input name="CmpVehiculoIngresoPlaca" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsEncuesta->EinPlaca;?>" size="25" maxlength="255"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Marca:</td>
            <td align="left" valign="top"><input name="CmpVehiculoMarca" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoMarca" value="<?php echo $InsEncuesta->VmaNombre;?>" size="25" maxlength="255"  readonly="readonly"/></td>
            <td align="left" valign="top">Modelo:</td>
            <td align="left" valign="top"><input name="CmpVehiculoModelo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoModelo" value="<?php echo $InsEncuesta->VmoNombre;?>" size="25" maxlength="255"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><?php
//MtdObtenerEncuestaPreguntaSeccions($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 
//$InsEncuestaPreguntaSeccion = new ClsEncuestaPreguntaSeccion();
//$ResEncuestaPreguntaSeccion = $InsEncuestaPreguntaSeccion->MtdObtenerEncuestaPreguntaSecciones(NULL,NULL,NULL,'EpsId','ASC',NULL,3);
//$ArrEncuestaPreguntaSecciones = $ResEncuestaPreguntaSeccion['Datos'];

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
                  <td width="49%" align="left" valign="top"><?php //deb("PREGUNTA: ".$DatEncuestaPregunta->EprId);?>
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
								$respuesta_texto = "";
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
	
												if($DatEncuestaPregunta->EprTipo=="2"){
													$respuesta_texto = $DatEncuestaDetalle->EdeRespuesta; 
												}else{
													
													if($DatEncuestaDetalle->EdeRespuesta == $DatEncuestaPreguntaRespuesta->EpeValor){
														//$iddetalle = $DatEncuestaDetalle->EdeId;
														$respuesta1 = 'checked="checked"'; 
														//deb("PREG-RESPUESTA: ".$DatEncuestaDetalle->EdeRespuesta." - ".$iddetalle);
														break 1;	
													}	
													break 1;
													
												}
												
												
											}
											
										//}
                                    }
                                }
								
								
								//deb("     PREG-RESPUESTA2: - ".$iddetalle);
								//$respuesta1 = "";
								//$iddetalle = "";
                                
                        ?>
                    <?php
					if($DatEncuestaPregunta->EprTipo=="2"){
					?>
                    
                    <input readonly="readonly" name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>" type="text" class="EstFormularioCaja"  id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>_<?php echo $DatEncuestaPreguntaRespuesta->EpeId?>" value="<?php echo $respuesta_texto;?>" size="45" maxlength="500"  /> <?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?> &nbsp;&nbsp;&nbsp;
                    
                    
                    <?php						
					}elseif($DatEncuestaPregunta->EprTipo=="3"){
					?>
                    
                    
                    <input disabled="disabled" type="radio" name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>"  id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>_<?php echo $DatEncuestaPreguntaRespuesta->EpeId?>" value="<?php echo $DatEncuestaPreguntaRespuesta->EpeValor?>" <?php echo $respuesta1?> /> <?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?> &nbsp;&nbsp;&nbsp;<br />
                    
                    <?php	
					}else{
					?>
                    <input disabled="disabled" type="radio" name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>"  id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>_<?php echo $DatEncuestaPreguntaRespuesta->EpeId?>" value="<?php echo $DatEncuestaPreguntaRespuesta->EpeValor?>" <?php echo $respuesta1?> /> <?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?> &nbsp;&nbsp;&nbsp;
                    
                    <?php
					}
					?>
                    
                    
                    <?php
                               
                            }
                        }
                        ?>
                    <input name="CmpEncuestaDetalleId_<?php echo $DatEncuestaPregunta->EprId?>" type="hidden"  id="CmpEncuestaDetalleId_<?php echo $DatEncuestaPregunta->EprId?>" value="<?php echo $iddetalle;?>" size="10" />
                    <br /><!-- ------------------>
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
?>    </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Comentarios:</td>
            <td colspan="3"><textarea name="CmpObservacion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsEncuesta->EncObservacion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>


	
	
	
    <?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>


