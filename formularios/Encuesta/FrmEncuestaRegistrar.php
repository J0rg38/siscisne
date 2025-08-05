<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletarv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFuncionesv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsEncuestaFunciones.js" ></script>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<?php
$Registro = false;
$GET_FichaIngresoId = $_GET['FichaIngresoId'];

$GET_Tipo = $_GET['Tipo'];
//deb($GET_Tipo);

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjEncuesta.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPregunta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaRespuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaSeccion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

//CLASES
$InsEncuesta = new ClsEncuesta();
$InsSucursal = new ClsSucursal();

	
	
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccEncuestaRegistrar.php');
	
//MtdObtenerEncuestaPreguntaSecciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL) {
$InsEncuestaPreguntaSeccion = new ClsEncuestaPreguntaSeccion();
$ResEncuestaPreguntaSeccion = $InsEncuestaPreguntaSeccion->MtdObtenerEncuestaPreguntaSecciones(NULL,NULL,NULL,'EpsId','ASC',NULL,3,$InsEncuesta->EncTipo);
$ArrEncuestaPreguntaSecciones = $ResEncuestaPreguntaSeccion['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

//deb($InsEncuesta->EncuestaDetalle);
?>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">	

<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

<!--    <?php
    if($PrivilegioImprimir){
    ?>
		<div class="EstSubMenuBoton"><a href="javascript:FncEncuestaImprmir('<?php echo $GET_FichaIngresoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
	
    <?php
    if($PrivilegioImprimir){
    ?>
		<div class="EstSubMenuBoton"><a href="javascript:FncEncuestaVistaPreliminar('<?php echo $GET_FichaIngresoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>-->
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        ENCUESTA POST VENTA</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
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
            <td align="left" valign="top">C&oacute;digo Interno:</td>
            <td colspan="3" align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsEncuesta->EncId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
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
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td colspan="3" align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsEncuesta->EncFecha;?>" size="10" maxlength="10" />              <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
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
            <td align="left" valign="top">Orden de Trabajo:</td>
            <td colspan="3" align="left" valign="top"><table>
              <tr>
                <td><a href="javascript:FncFichaIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td><input name="CmpFichaIngresoId" id="CmpFichaIngresoId" type="hidden"    value="<?php  echo $InsEncuesta->FinId;?>" size="20" maxlength="20" />
                  <input name="CmpFichaIngreso" type="text" class="EstFormularioCaja" id="CmpFichaIngreso"  tabindex="3" value="<?php  echo $InsEncuesta->FinId;?>" size="25" maxlength="25" /></td>
                <td><!--<a href="javascript:FncFichaIngresoBuscar('Id');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>-->
                
                   <a id="BtnFichaIngresoBuscarLista" href=" comunes/FichaIngreso/FrmFichaIngresoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a>
            
            
                </td>
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
            <td colspan="4" valign="top">
              
              
              
              
              <?php
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
                    
                    <input name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>" type="text" class="EstFormularioCaja"  id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>_<?php echo $DatEncuestaPreguntaRespuesta->EpeId?>" value="<?php echo $respuesta_texto;?>" size="45" maxlength="500"  /> <?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?> &nbsp;&nbsp;&nbsp;
                    
                    
                    <?php						
					}elseif($DatEncuestaPregunta->EprTipo=="3"){
					?>
                    
                    
                    <input type="radio" name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>"  id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>_<?php echo $DatEncuestaPreguntaRespuesta->EpeId?>" value="<?php echo $DatEncuestaPreguntaRespuesta->EpeValor?>" <?php echo $respuesta1?> /> <?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?> &nbsp;&nbsp;&nbsp;<br />
                    
                    <?php	
					}else{
					?>
                    <input type="radio" name="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>"  id="CmpEncuestaDetalleRespuesta_<?php echo $DatEncuestaPregunta->EprId?>_<?php echo $DatEncuestaPreguntaRespuesta->EpeId?>" value="<?php echo $DatEncuestaPreguntaRespuesta->EpeValor?>" <?php echo $respuesta1?> /> <?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?> &nbsp;&nbsp;&nbsp;
                    
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
              
              <!--MtdObtenerEncuestaPreguntas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oTipo=NULL)-->            </td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Verbatines:</td>
            <td colspan="3">
            
            <select name="CmpVerbatin" id="CmpVerbatin" class="EstFormularioCombo">
              <option value="PROMOTOR">PROMOTOR</option>
              <option value="EXPERIENCIA">EXPERIENCIA</option>
              <option value="LEALTAD">LEALTAD</option>
              <option value="CALIDAD DE TRABAJO">CALIDAD DE TRABAJO</option>
              <option value="COMUNICACIÓN">COMUNICACIÓN</option>
              <option value="PUNTUALIDAD">PUNTUALIDAD</option>
              <option value="COMPORTAMIENTO DEL CONSUMIDOR">COMPORTAMIENTO DEL CONSUMIDOR</option>
              <option value="EMPLEADOS">EMPLEADOS</option>
              <option value="INSTALACIONES">INSTALACIONES</option>
              <option value="LAVADO">LAVADO</option>
              <option value="PRECIO">PRECIO</option>
            </select>
            
            </td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Comentarios:</td>
            <td colspan="3">
            
            
            <textarea class="EstFormularioCaja" name="CmpObservacion" id="CmpObservacion" cols="45" rows="4"><?php echo $InsEncuesta->EncObservacion;?></textarea>
            
            
            
            </td>
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
  
	
    

</form>

<script type="text/javascript">

Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
		
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

