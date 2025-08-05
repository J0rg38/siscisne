<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionVehiculoLlamadaFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCotizacionVehiculo.css');
</style>

<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCotizacionVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');


$InsCotizacionVehiculo = new ClsCotizacionVehiculo();

if (!isset($_SESSION['InsCotizacionVehiculoLlamada'.$Identificador])){	
	$_SESSION['InsCotizacionVehiculoLlamada'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsCotizacionVehiculoLlamada'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionVehiculoLlamada'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCotizacionVehiculoSeguimientoCliente.php');


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
	
	FncCotizacionVehiculoLlamadaListar();

});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";



var CotizacionVehiculoLlamadaEditar = 1;
var CotizacionVehiculoLlamadaEliminar = 1;
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo"> SEGUIMIENTO DE COTIZACION DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">

              


     
<!--<ul class="tabs">

	<li><a href="#tab1">CotizacionVehiculo</a></li>

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
                                  <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Cotizacion
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
                                  <td align="left" valign="top"><input  name="CmpId" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCotizacionVehiculo->CveId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top">Fecha de Cotizacion :<br />
                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFecha" value="<?php  echo $InsCotizacionVehiculo->CveFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                  <td align="left" valign="top">Cliente:</td>
                                  <td align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsCotizacionVehiculo->CliNombre;?> <?php echo $InsCotizacionVehiculo->CliApellidoPaterno;?> <?php echo $InsCotizacionVehiculo->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">Telefono:</td>
                                  <td align="left" valign="top"><input name="CmpClienteTelefono" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteTelefono"  tabindex="2" value="<?php echo $InsCotizacionVehiculo->CliTelefono;?>" size="25" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Celular:</td>
                                  <td align="left" valign="top"><input name="CmpClienteCelular" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteCelular"  tabindex="2" value="<?php echo $InsCotizacionVehiculo->CliCelular;?>" size="25" maxlength="255" readonly="readonly"  /></td>
                                  <td align="left" valign="top">Email:</td>
                                  <td align="left" valign="top"><input name="CmpClienteEmail" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteEmail"  tabindex="2" value="<?php echo $InsCotizacionVehiculo->CliEmail;?>" size="45" maxlength="255" readonly="readonly"  /></td>
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
                                  <td colspan="6"><span class="EstFormularioSubTitulo">REGISTRO DE LLAMADAS</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                                    <input type="hidden" name="CmpCotizacionVehiculoLlamadaItem" id="CmpCotizacionVehiculoLlamadaItem" value="" />
                                    <input type="hidden" name="CmpCotizacionVehiculoLlamadaId"  class="EstFormularioCaja" id="CmpCotizacionVehiculoLlamadaId" value=""  />
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpCotizacionVehiculoLlamadaAccion" id="CmpCotizacionVehiculoLlamadaAccion" value="AccCotizacionVehiculoLlamadaRegistrar.php" />
                                  </span></td>
                                  <td>Fecha Llamada: </td>
                                  <td>Fec. Programada:</td>
                                  <td>Nota:</td>
                                  <td><div id="CapCotizacionVehiculoLlamadaBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncCotizacionVehiculoLlamadaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="CmpCotizacionVehiculoLlamadaFecha" type="text" class="EstFormularioCajaFecha" id="CmpCotizacionVehiculoLlamadaFecha" size="9" maxlength="10" value="<?php echo date("d/m/Y");?>" />
                                  
                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnCotizacionVehiculoLlamadaFecha" name="BtnCotizacionVehiculoLlamadaFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                                  
                                  </td>
                                  <td><input name="CmpCotizacionVehiculoLlamadaFechaProgramada" type="text" class="EstFormularioCajaFecha" id="CmpCotizacionVehiculoLlamadaFechaProgramada" size="9" maxlength="10" />
                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnCotizacionVehiculoLlamadaFechaProgramada" name="BtnCotizacionVehiculoLlamadaFechaProgramada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                                  <td><input name="CmpCotizacionVehiculoLlamadaObservacion" type="text" class="EstFormularioCaja" id="CmpCotizacionVehiculoLlamadaObservacion" size="45" maxlength="255"  /></td>
                                  <td><a href="javascript:FncCotizacionVehiculoLlamadaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                                  <td width="49%"><div class="EstFormularioAccion" id="CapCotizacionVehiculoLlamadaAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncCotizacionVehiculoLlamadaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionVehiculoLlamadaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapCotizacionVehiculoLlamadasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapCotizacionVehiculoLlamadas" class="EstCapCotizacionVehiculoLlamadas" ></div></td>
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
	inputField : "CmpCotizacionVehiculoLlamadaFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnCotizacionVehiculoLlamadaFecha"// el id del botón que  
	});
	
	Calendar.setup({ 
	inputField : "CmpCotizacionVehiculoLlamadaFechaProgramada",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnCotizacionVehiculoLlamadaFechaProgramada"// el id del botón que  
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


