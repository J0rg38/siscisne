<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoLlamadaFunciones.js" ></script>-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoConfirmarEntregaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoFotoActaEntregaFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenVentaVehiculoConfirmarEntrega.css');
</style>

<?php
$GET_Id = $_GET['OvvId'];


$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenVentaVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenVentaVehiculoConfirmarEntrega.php');

?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){
	
	$("#CmpFecha").focus();
	
	FncOrdenVentaVehiculoFotoActaEntregaListar();
	
});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";
var OrdenVentaVehiculoFotoActaEntregaEditar = 1;
var OrdenVentaVehiculoFotoActaEntregaEliminar = 1;


</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

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
	



<?php
if($Registro){
?>    

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
        <div class="EstSubMenuBoton"><a href="javascript:FncOrdenVentaVehiculoConfirmarEntregaVistaPreliminar('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    <?php
    if($PrivilegioImprimir){
    ?>
        <div class="EstSubMenuBoton"><a href="javascript:FncOrdenVentaVehiculoConfirmarEntregaImprimir('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
  
<?php
}
?>            

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo"> CONFIRMAR ENTREGA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">

              


     
<!--<ul class="tabs">

	<li><a href="#tab1">OrdenVentaVehiculo</a></li>

</ul>
	
<div class="tab_container">





    
    
<div id="tab1" class="tab_content">
    -->
 
 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="398" align="left"><div class="EstFormularioArea" >
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Orden
                                      <input type="hidden" name="Guardar" id="Guardar"   />
                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                  <input type="hidden" name="CmpDestinatarios" id="CmpDestinatarios"  value="<?php echo $InsOrdenVentaVehiculo->OvvDestinatarios;?>" />
                                  </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Codigo Interno:</td>
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenVentaVehiculo->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Orden :<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFecha" value="<?php  echo $InsOrdenVentaVehiculo->OvvFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Cliente:</td>
                                  <td align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsOrdenVentaVehiculo->CliNombre;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoPaterno;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td height="61">&nbsp;</td>
                                  <td align="left" valign="top">Fecha de Entrega :<br />
                                  <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <?php $fechahoy = date('Y-m-d'); ?>
                                  <td align="left" valign="top"><input name="CmpFechaEntrega" type="text" class="EstFormularioCajaFecha" id="CmpFechaEntrega" value="" size="15" maxlength="10"/>
                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEntrega" name="BtnFechaEntrega" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td align="left" valign="top">Hora Entrega:<br />
                                    <span class="EstFormularioSubEtiqueta">(00:00)</span></td>
                                  <td align="left" valign="top"><input class="EstFormularioCajaHora" name="CmpHoraEntrega" type="text" id="CmpHoraEntrega" value="<?php  echo $InsOrdenVentaVehiculo->OvvActaEntregaHora;?>" size="15" maxlength="10" />
                                    <!--             <div id="sample1" class="ui-widget-content" style="padding: .5em;">
        <p>
            <label>Start</label><br/>
            <input name="s1Time2" value="" /> <br/>
            <label>End</label><br/>
            <input name="s1Time2" value="" />
        </p>
        <p>Some extra select boxes to show to it works under IE.<br/>
            <select>
                <option>Option 1 here</option>
                <option>Options 2 here</option>
            </select><br /> <br />
            <select>
                <option>Option 1 here</option>
                <option>Options 2 here</option>
            </select>
        </p>
    </div>-->
                                    <!--<a id="BtnCitaCalendario" href="javascript:FncCitaCalendarioCargarFormulario('VerCalendarioFull')"><img src="imagenes/acciones/calendario_full.png" width="25" height="25" border="0" alt="Calendario" title="Calendario" align="absmiddle" /></a>
            --></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Num. de Placa:</td>
                                  <td align="left" valign="top"><input name="CmpPlaca" type="text" class="EstFormularioCaja" id="CmpPlaca"  value="<?php echo $InsOrdenVentaVehiculo->OvvPlaca;?>" size="20" maxlength="20" /></td>
                                  <td align="left" valign="top">Tarjeta:</td>
                                  <td align="left" valign="top"><input name="CmpTarjeta" type="text" class="EstFormularioCaja" id="CmpTarjeta"  value="<?php echo $InsOrdenVentaVehiculo->OvvTarjeta;?>" size="20" maxlength="20" /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Observaciones:</td>
                                  <td colspan="3" align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenVentaVehiculo->OvvActaEntregaDescripcion;?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Documento Escaneado:</td>
                                  <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="48%"><a href="javascript:FncOrdenVentaVehiculoFotoActaEntregaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenVentaVehiculoFotoActaEntregaEliminarTodo();"></a></td>
                            <td width="50%" align="right"><div class="EstFormularioAccion" id="CapOrdenVentaVehiculoFotoActaEntregasAccion">Listo
                              para registrar elementos</div></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                              <tr>
                                <td width="275" colspan="2" align="left" valign="top"><div id="fileUploadOrdenVentaVehiculoFotoActaEntrega">Escoger Archivo</div>
                                  <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadOrdenVentaVehiculoFotoActaEntrega").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoFotoActaEntregaSubir.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:false,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tama&ntilde;o no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncOrdenVentaVehiculoFotoActaEntregaListar ();
											}
							
										});
									});
									  
									</script></td>
                                <td width="4" align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="2" align="left" valign="top"><div class="EstCapOrdenVentaVehiculoFotoActaEntregas" id="CapOrdenVentaVehiculoFotoActaEntregas"></div></td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table></td>
                            <td><div id="CapOrdenVentaVehiculoFotoActaEntregasResultado"> </div></td>
                          </tr>
                        </table>
                      </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><input <?php echo (($InsOrdenVentaVehiculo->OvvNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
Notificar via email </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><br /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                              
                            </div></td>
                </tr>
                          <tr>
                            <td align="left">&nbsp;</td>
                          </tr>
                        </table>
                        
                        
       
    
<!--    </div>

 
 

</div>    		 
		
        -->
        
        
          
       

           
  
        
        
        
        
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
	inputField : "CmpFechaEntrega",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEntrega"// el id del bot�n que  
	});

</script>

 <script type="text/javascript">
        $(document).ready(function(){
  
	  $('#CmpHoraEntrega').timepicker(
	  { 
		'timeFormat': 'H:i' ,
		'minTime': '08:00',
		'maxTime': '18:00'
	  
	  }
	  );
	  
	});
    </script>
<?php
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".(!empty($GET_mod)?$GET_mod:$GET_NMod)."&Form=Listado",$Edito,1500);
	}

?>


