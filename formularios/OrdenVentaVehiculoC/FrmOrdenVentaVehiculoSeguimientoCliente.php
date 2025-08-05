<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsOrdenVentaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsOrdenVentaVehiculoLlamadaFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenVentaVehiculo.css');
</style>

<?php
$GET_Id = $_GET['Id'];

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


$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

if (!isset($_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador])){	
	$_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenVentaVehiculoSeguimientoCliente.php');


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
	
	FncOrdenVentaVehiculoLlamadaListar();

});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";



var OrdenVentaVehiculoLlamadaEditar = 1;
var OrdenVentaVehiculoLlamadaEliminar = 1;
</script>





<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">

           
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo"> REGISTRO DE LLAMADAS / ORDEN DE VENTA DE VEHICULO</span></td>
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
                            <td align="left"><div class="EstFormularioArea" >
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Orden
                                      <input type="hidden" name="Guardar" id="Guardar"   />
                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
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
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Codigo Interno:</td>
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenVentaVehiculo->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Orden :<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsOrdenVentaVehiculo->OvvFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">Nombre:</td>
                                  <td align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsOrdenVentaVehiculo->CliNombre;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoPaterno;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly"  /></td>
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
                                    <input type="hidden" name="CmpOrdenVentaVehiculoLlamadaItem" id="CmpOrdenVentaVehiculoLlamadaItem" value="" />
                                    <input type="hidden" name="CmpOrdenVentaVehiculoLlamadaId"  class="EstFormularioCaja" id="CmpOrdenVentaVehiculoLlamadaId" value=""  />
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpOrdenVentaVehiculoLlamadaAccion" id="CmpOrdenVentaVehiculoLlamadaAccion" value="AccOrdenVentaVehiculoLlamadaRegistrar.php" />
                                  </span></td>
                                  <td>Fecha: </td>
                                  <td>Nota:</td>
                                  <td><div id="CapOrdenVentaVehiculoLlamadaBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncOrdenVentaVehiculoLlamadaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="CmpOrdenVentaVehiculoLlamadaFecha" type="text" class="EstFormularioCajaFecha" id="CmpOrdenVentaVehiculoLlamadaFecha" size="9" maxlength="10" />
                                  
                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnOrdenVentaVehiculoLlamadaFecha" name="BtnOrdenVentaVehiculoLlamadaFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                                  
                                  </td>
                                  <td><input name="CmpOrdenVentaVehiculoLlamadaObservacion" type="text" class="EstFormularioCaja" id="CmpOrdenVentaVehiculoLlamadaObservacion" size="45" maxlength="255"  /></td>
                                  <td><a href="javascript:FncOrdenVentaVehiculoLlamadaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                                  <td width="49%"><div class="EstFormularioAccion" id="CapOrdenVentaVehiculoLlamadaAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncOrdenVentaVehiculoLlamadaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenVentaVehiculoLlamadaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapOrdenVentaVehiculoLlamadasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapOrdenVentaVehiculoLlamadas" class="EstCapOrdenVentaVehiculoLlamadas" ></div></td>
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
	inputField : "CmpOrdenVentaVehiculoLlamadaFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnOrdenVentaVehiculoLlamadaFecha"// el id del botón que  
	});

</script>

<?php
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principalC.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}

?>


