<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoSeguimientoClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoLlamadaFunciones.js" ></script>



<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFichaIngresoSeguimientoCliente.css');
</style>

<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaIngreso.php');

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

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqActividad().'ClsTipoReparacion.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsTipoDocumento = new ClsTipoDocumento();

if (!isset($_SESSION['InsFichaIngresoLlamada'.$Identificador])){	
	$_SESSION['InsFichaIngresoLlamada'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsFichaIngresoLlamada'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoLlamada'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaIngresoSeguimientoCliente.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];


?>

<?php
if(!empty($InsFichaIngreso->FinTiempoTallerConcluido)){
	list($Fecha,$Hora) = explode(" ",$InsFichaIngreso->FinTiempoTallerConcluido);
	
	if(empty($Fecha)){
		$Fecha = date("d/m/Y");
	}
}
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
	
	$("#CmpFichaIngresoLlamadaFecha").focus();
	
	FncFichaIngresoLlamadaListar();

});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";

var FichaIngresoLlamadaEditar = 1;
var FichaIngresoLlamadaEliminar = 1;
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
        <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    <?php
    if($PrivilegioImprimir){
    ?>
        <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo"> REGISTRO DE LLAMADAS / ORDEN DE TRABAJO</span></td>
      </tr>
      <tr>
        <td colspan="2">

              

<!--
     
<ul class="tabs">

	<li><a href="#tab1">FichaIngreso</a></li>

</ul>
	
<div class="tab_container">





    
    
<div id="tab1" class="tab_content">
    
 -->
 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td align="left"><div class="EstFormularioArea" >
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la orden
                                      <input type="hidden" name="Guardar" id="Guardar"   />
                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                  </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Codigo Interno:</td>
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsFichaIngreso->FinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de O.T.:<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsFichaIngreso->FinFecha; ?>" size="10" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">Cliente:</td>
                                  <td align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsFichaIngreso->CliNombre;?> <?php echo $InsFichaIngreso->CliApellidoPaterno;?> <?php echo $InsFichaIngreso->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Telefono:</td>
                                  <td align="left" valign="top"><input name="CmpClienteTelefono" type="text" class="EstFormularioCaja" id="CmpClienteTelefono"  tabindex="2" value="<?php echo $InsFichaIngreso->CliTelefono;?>" size="25" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Celular:</td>
                                  <td align="left" valign="top"><input name="CmpClienteCelular" type="text" class="EstFormularioCaja" id="CmpClienteCelular"  tabindex="2" value="<?php echo $InsFichaIngreso->CliCelular;?>" size="25" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Cotizacion:</td>
                                  <td align="left" valign="top">
                                  


<?php
				if($InsFichaIngreso->FinCotizacionProducto=="Si"){
				?>
                  <a href="formularios/FichaIngreso/DiaCotizacionProductoListado.php?height=440&amp;width=850&amp;FinId=<?php echo $dat->FinId?>" class="thickbox" title=""><img src="imagenes/acciones/enlace.gif" alt="" width="18" height="18" border="0" align="Enlace" title="Enlace" /> Si</a>
                  <?php
				}else{
				?>
                No
                <?php	
				}
				?>
                
                </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                              
                            </div></td>
                </tr>
                          <tr>
                            <td width="398" align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="5"><span class="EstFormularioSubTitulo">REGISTRO DE LLAMADAS</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                                    <input type="hidden" name="CmpFichaIngresoLlamadaItem" id="CmpFichaIngresoLlamadaItem" value="" />
                                    <input type="hidden" name="CmpFichaIngresoLlamadaId"  class="EstFormularioCaja" id="CmpFichaIngresoLlamadaId" value=""  />
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpFichaIngresoLlamadaAccion" id="CmpFichaIngresoLlamadaAccion" value="AccFichaIngresoLlamadaRegistrar.php" />
                                  </span></td>
                                  <td>Fecha: </td>
                                  <td>Nota:</td>
                                  <td><div id="CapFichaIngresoLlamadaBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaIngresoLlamadaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td align="left" valign="top"><input name="CmpFichaIngresoLlamadaFecha" type="text" class="EstFormularioCajaFecha" id="CmpFichaIngresoLlamadaFecha" size="9" maxlength="10" value="<?php echo $Fecha;?>" />
                                  
                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFichaIngresoLlamadaFecha" name="BtnFichaIngresoLlamadaFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                                  
                                  </td>
                                  <td align="left" valign="top"><textarea name="CmpFichaIngresoLlamadaObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpFichaIngresoLlamadaObservacion">Se realizo llamada al cliente</textarea></td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaIngresoLlamadaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="CapFichaIngresoLlamadaAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaIngresoLlamadaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoLlamadaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapFichaIngresoLlamadasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaIngresoLlamadas" class="EstCapFichaIngresoLlamadas" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                  <td>&nbsp;</td>
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
	inputField : "CmpFichaIngresoLlamadaFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFichaIngresoLlamadaFecha"// el id del botón que  
	});

</script>

<?php
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

?>


