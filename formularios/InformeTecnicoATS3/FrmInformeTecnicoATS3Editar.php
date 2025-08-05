<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico",$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Imprimir"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsInformeTecnicoATS3Funciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsInformeTecnicoATS3ProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsInformeTecnicoATS3OperacionFunciones.js" ></script>




<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssInformeTecnicoATS3.css');
</style>
<?php
$GET_id = $_GET['Id'];
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjInformeTecnicoATS3.php');


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

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnico.php');
require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnicoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnicoOperacion.php');


require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsInformeTecnico = new ClsInformeTecnico();
$InsPersonal = new ClsPersonal();


if (!isset($_SESSION['InsInformeTecnicoATS3Foto'.$Identificador])){	
	$_SESSION['InsInformeTecnicoATS3Foto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsInformeTecnicoATS3Foto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsInformeTecnicoATS3Foto'.$Identificador]);
}

if (!isset($_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador])){	
	$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsInformeTecnicoATS3Operacion'.$Identificador]);
}

if (!isset($_SESSION['InsInformeTecnicoATS3Producto'.$Identificador])){	
	$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsInformeTecnicoATS3Producto'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccInformeTecnicoATS3Editar.php');


$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
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

	FncInformeTecnicoATS3OperacionListar();
	FncInformeTecnicoATS3ProductoListar();
		
});

/*
Configuracion Formulario
*/

var InformeTecnicoATS3OperacionEditar = 1;
var InformeTecnicoATS3OperacionEliminar = 1;

var InformeTecnicoATS3ProductoEditar = 1;
var InformeTecnicoATS3ProductoEliminar = 1;

</script>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">


<div class="EstCapMenu">

           
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	



<?php
if($Edito){
?>    

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsInformeTecnico->FinId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    <?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsInformeTecnico->FinId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR INFORME TECNICO ATS3</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsInformeTecnico->IteTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsInformeTecnico->IteTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
<br />
               
<ul class="tabs">
	<li><a href="#tab1">Informe Tecnico ATS3</a></li>
	<li><a href="#tab2">Foto</a></li>
    <li><a href="#tab3">Repuestos y MO</a></li>
	
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
      
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td valign="top">
            <div class="EstFormularioArea">
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Informe Tecnico ATS3
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                  </span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Codigo:</td>
                  <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsInformeTecnico->IteId;?>" size="15" maxlength="20" /></td>
                  <td align="left" valign="top">Concesionario:</td>
                  <td align="left" valign="top"><input  name="CmpConcesionario" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpConcesionario" value="<?php echo $InsInformeTecnico->IteConcesionario;?>" size="30" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Sede del Local:</td>
                  <td align="left" valign="top"><input  name="CmpSedeLocal" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpSedeLocal" value="<?php echo $InsInformeTecnico->IteSedeLocal;?>" size="30" maxlength="50" readonly="readonly" /></td>
                  <td align="left" valign="top">Fecha de Emision:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><span id="sprytextfield7">
                    <label>
                      <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo ($InsInformeTecnico->IteFecha);?>" size="15" maxlength="10" />
                    </label>
                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Contacto GM:</td>
                  <td align="left" valign="top"><input  name="CmpContactoGM" type="text"  class="EstFormularioCaja" id="CmpContactoGM" value="<?php echo $InsInformeTecnico->IteContactoGM;?>" size="30" maxlength="50" readonly="readonly" /></td>
                  <td align="left" valign="top">Fecha de Venta:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><span id="sprytextfield">
                    <label>
                      <input class="EstFormularioCajaFecha" name="CmpFechaVenta" type="text" id="CmpFechaVenta" value="<?php echo $InsInformeTecnico->IteFechaVenta;?>" size="15" maxlength="10" />
                    </label>
                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaVenta" name="BtnFechaVenta" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Codigo de VIN:</td>
                  <td align="left" valign="top"><input  name="CmpVehiculoIngresoVIN" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVIN" value="<?php echo $InsInformeTecnico->EinVIN;?>" size="30" maxlength="50" readonly="readonly" /></td>
                  <td align="left" valign="top">Placa o Serie:</td>
                  <td align="left" valign="top"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsInformeTecnico->EinPlaca;?>" size="30" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Modelo:</td>
                  <td align="left" valign="top"><input  name="CmpModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpModelo" value="<?php echo $InsInformeTecnico->VmaNombre;?> <?php echo $InsInformeTecnico->VmoNombre;?> <?php echo $InsInformeTecnico->VveNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
                  <td align="left" valign="top">Kilometraje:</td>
                  <td align="left" valign="top"><input  name="CmpKilometraje" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpKilometraje" value="<?php echo $InsInformeTecnico->FinVehiculoKilometraje;?>" size="30" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Propietario:</td>
                  <td align="left" valign="top"><input  name="CmpPropietario" type="text"  class="EstFormularioCaja" id="CmpPropietario" value="<?php echo $InsInformeTecnico->ItePropietario;?>" size="30" maxlength="50" /></td>
                  <td align="left" valign="top">Ord. de Trabajo:</td>
                  <td align="left" valign="top"><input readonly="readonly" name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId" value="<?php echo $InsInformeTecnico->FinId;?>" size="15" maxlength="20" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left"><input name="CmpMonedaId" type="hidden" id="CmpMonedaId" value="<?php echo $InsInformeTecnico->MonId;?>" size="3" />
                    <input name="CmpTipoCambio" type="hidden" id="CmpTipoCambio" value="<?php echo $InsInformeTecnico->IteTipoCambio;?>" size="3" /></td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top">1. Condici&oacute;n (explicar en que consiste la falla y las condiciones en que se presenta)</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top"><textarea name="CmpCondicion" cols="60" rows="2" class="EstFormularioCaja" id="CmpCondicion"><?php echo stripslashes($InsInformeTecnico->IteCondicion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top">2. Causa (an&aacute;lisis y verificaci&oacute;n de causa raiz de la falla)</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top"><textarea name="CmpCausa" cols="60" rows="2" class="EstFormularioCaja" id="CmpCausa"><?php echo stripslashes($InsInformeTecnico->IteCausa);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top">3. Correcci&oacute;n (explicar que soluci&oacute;n es la propuesta para corregir la causa raiz)</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top"><textarea name="CmpCorreccion" cols="60" rows="2" class="EstFormularioCaja" id="CmpCorreccion"><?php echo stripslashes($InsInformeTecnico->IteCorreccion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top">4. Conclusiones (especificar conclusiones que ayuden a prevenir la falla)</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top"><textarea name="CmpConclusion" cols="60" rows="2" class="EstFormularioCaja" id="CmpConclusion"><?php echo stripslashes($InsInformeTecnico->IteConclusion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="left" valign="top">5. &iquest;Ha sido la soluci&oacute;n satisfactoria?</td>
                  <td colspan="2" align="left"><span id="spryradio1">
                    <input <?php echo ($InsInformeTecnico->IteSolucionSatisfactoria==1)?'checked="checked"':'';?> type="radio" name="CmpSolucionSatisfactoria" value="1" id="CmpSolucionSatisfactoria1" />
                    Si
                    <input <?php echo ($InsInformeTecnico->IteSolucionSatisfactoria==2)?'checked="checked"':'';?> type="radio" name="CmpSolucionSatisfactoria" value="2" id="CmpSolucionSatisfactoria2" />
                    No <span class="radioRequiredMsg">Realice una selecci&oacute;n.</span></span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Emitido por:</td>
                  <td colspan="3" align="left"><span id="spryselect2">
                    <select name="CmpPersonal" id="CmpPersonal" class="EstFormularioCombo" >
                      <option value="">Escoja una opcion</option>
                      <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                      <option <?php if($InsInformeTecnico->PerId==$DatPersonal->PerId){ echo 'selected="selected"';}?> value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre;?> <?php echo $DatPersonal->PerApellidoPaterno;?> <?php echo $DatPersonal->PerApellidoMaterno;?></option>
                      <?php  
					}
					?>
                    </select>
                    <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Cargo:</td>
                  <td colspan="3" align="left"><input  name="CmpPersonalCargo" type="text"  class="EstFormularioCaja" id="CmpPersonalCargo" value="<?php echo $InsInformeTecnico->IteCargo;?>" size="30" maxlength="50" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
              
            
          </div>
          
          </td>
        </tr>

 
       </table>
         
		

    </div>    
    

<div id="tab2" class="tab_content">
    <!--Content-->
    
    
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
    
    <tr>
    <td width="53%" valign="top">
    
    
    <div class="EstFormularioArea">
    
    <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto VIN</span></td>
                      </tr>
                    <tr>
                      <td>
                        
                        
                        
                        
                        
                        <div class="EstFormularioArea" >
                          <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                            <tr>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                              <td width="261" colspan="2" align="left" valign="top">
                                
                                
                                <?php              
              
if(!empty($_SESSION['SesIteFotoVIN'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesIteFotoVIN'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesIteFotoVIN'.$Identificador], '.'.$extension);  
?>
                                
                                Vista Previa:<br />
                                <a target="_blank" href="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>">
                                  <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" height="150" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
                                
                                
                                <?php	
}else{
?>
                                No hay FOTO
                                <?php	
}
?>
                                
                                
                                
                                
                                
                                
                                
                                </td>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td colspan="2" align="left" valign="top">
                                
                                <span class="EstFormularioNota">* Fotos del VIN del vehiculo </span>
                                
                                </td>
                              <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table>
                          </div>
                        
                        
                        <!--<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/FichaAccion/acc/AccFichaAccionSubirFotoVIN.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoVin" name="IfrFichaAccionSubirFotoVin" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>--></td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Frontal</span></td>
                    </tr>
                    <tr>
                      <td>
                        
                        
                        
                        <div class="EstFormularioArea" >
                          <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                            <tr>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                              <td width="261" colspan="2" align="left" valign="top">
                                
                                
                                
                                <?php              
              
if(!empty($_SESSION['SesIteFotoFrontal'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesIteFotoFrontal'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesIteFotoFrontal'.$Identificador], '.'.$extension);  
?>
                                
                                Vista Previa:<br />
                                
                                <a target="_blank" href="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>"> <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" height="150" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
                                <?php	
}else{
?>
                                No hay FOTO
                                <?php	
}
?>
                                
                                
                                
                                
                                </td>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td colspan="2" align="left" valign="top">
                                
                                <span class="EstFormularioNota">* Fotos de la Delantera del vehiculo </span>
                                
                                </td>
                              <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table>
                          </div>
                        
                        
                        
                      
                        </td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Cupon</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            <td width="275" colspan="2" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesIteFotoCupon'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesIteFotoCupon'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesIteFotoCupon'.$Identificador], '.'.$extension);  
?>
                              
                              Vista Previa:<br />
                              
                              <a target="_blank" href="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>"> <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" height="150" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
                              <?php	
}else{
?>
                              No hay FOTO
                              <?php	
}
?>
                              </td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    </table>
                    
                    
    </div>
    
    
    </td>
    <td width="47%" valign="top">
    <div class="EstFormularioArea">
    <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="261" colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Otras Fotos</span></td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapInformeTecnicoATS3Fotos" id="CapInformeTecnicoATS3<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos">

<?php

//session_start();
if (!isset($_SESSION['InsInformeTecnicoATS3Foto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsInformeTecnicoATS3Foto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

$RepSesionObjetos = $_SESSION['InsInformeTecnicoATS3Foto'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];

?>

<table class="EstTablaListado" cellpadding="0" cellspacing="0" border="0">
   
    <tbody class="EstTablaListadoBody">
    <tr>
    <?php
    $c = 1;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
    ?>
    
    <td align="left" valign="top">
      
	<a target="_blank" href="subidos/ficha_accion_fotos/<?php echo $DatSesionObjeto->Parametro3;?>">
      <img src="subidos/ficha_accion_fotos/<?php echo $DatSesionObjeto->Parametro3;?>" alt="<?php echo $DatSesionObjeto->Parametro3;?>" title="<?php echo $DatSesionObjeto->Parametro3;?>" width="50" height="50" border="0" /></a>
   
    </td>
    
    <?php
	if($c%5==0){
	?>
    </tr><tr>
    <?php
	}
	?>
   
    <?php
            $c++;
  
       
    }
    ?> </tr>
    </tbody>
    </table>
    
    
                                  </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
         </div>
                          
	</td>
    </tr>
    
    
    
    </table>
    
    
    </div>
    
    
        <div id="tab3" class="tab_content">
    <!--Content-->
    
    
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
    
    <tr>
    <td width="53%" valign="top">
      
      
      <div class="EstFormularioArea">
        
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td align="left" valign="top"><div class="EstFormularioArea">
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="7"><span class="EstFormularioSubTitulo">DETALLE MANO DE OBRA</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                    <input type="hidden" name="CmpInformeTecnicoATS3OperacionItem" id="CmpInformeTecnicoATS3OperacionItem" value="" />
                    <input type="hidden" name="CmpInformeTecnicoATS3OperacionId"  class="EstFormularioCaja" id="CmpInformeTecnicoATS3OperacionId" value=""  />
                  </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><span class="EstFormularioAccion">
                    <input type="hidden" name="CmpInformeTecnicoATS3OperacionAccion" id="CmpInformeTecnicoATS3OperacionAccion" value="AccInformeTecnicoOperacionRegistrar.php" />
                  </span></td>
                  <td>Codigo MO:</td>
                  <td>Tiempo: </td>
                  <td>Costo x Hora:</td>
                  <td>Valor Total:</td>
                  <td><div id="CapInformeTecnicoATS3OperacionBuscar"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><a href="javascript:FncInformeTecnicoATS3OperacionNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  <td><input name="CmpInformeTecnicoATS3OperacionNumero" type="text" class="EstFormularioCaja" id="CmpInformeTecnicoATS3OperacionNumero" size="20" maxlength="20" /></td>
                  <td><input name="CmpInformeTecnicoATS3OperacionTiempo" type="text" class="EstFormularioCaja EstFormularioSoloNumero" id="CmpInformeTecnicoATS3OperacionTiempo" size="7" maxlength="10" /></td>
                  <td><input name="CmpInformeTecnicoATS3OperacionCostoHora" type="text" class="EstFormularioCaja" id="CmpInformeTecnicoATS3OperacionCostoHora" size="7" maxlength="10"  /></td>
                  <td><input name="CmpInformeTecnicoATS3OperacionValorTotal" type="text" class="EstFormularioCaja" id="CmpInformeTecnicoATS3OperacionValorTotal" size="7" maxlength="10"  /></td>
                  <td><a href="javascript:FncInformeTecnicoATS3OperacionGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                  <td width="49%"><div class="EstFormularioAccion" id="CapInformeTecnicoATS3OperacionAccion">Listo
                    para registrar elementos </div></td>
                  <td width="49%" align="right"><a href="javascript:FncInformeTecnicoATS3OperacionListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncInformeTecnicoATS3OperacionEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                  <td width="1%"><div id="CapInformeTecnicoATS3OperacionesResultado"> </div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><div id="CapInformeTecnicoATS3Operaciones" class="EstCapInformeTecnicoATS3Operaciones" ></div></td>
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
            <td align="left"><div class="EstFormularioArea">
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="8"><span class="EstFormularioSubTitulo">DETALLE REPUESTOS</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                    <input type="hidden" name="CmpInformeTecnicoATS3ProductoItem" id="CmpInformeTecnicoATS3ProductoItem" value="" />
                    <input type="hidden" name="CmpProductoId"  class="EstFormularioCaja" id="CmpProductoId" value=""  />
                  </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><span class="EstFormularioAccion">
                    <input type="hidden" name="CmpInformeTecnicoATS3ProductoAccion" id="CmpInformeTecnicoATS3ProductoAccion" value="AccInformeTecnicoProductoRegistrar.php" />
                  </span></td>
                  <td>P/N:</td>
                  <td>Descripcion: </td>
                  <td>Cantidad:</td>
                  <td>Valor Unit.:</td>
                  <td>Valor Total:</td>
                  <td><div id="CapInformeTecnicoATS3ProductoBuscar"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><a href="javascript:FncInformeTecnicoATS3ProductoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  <td><input name="CmpProductoCodigoOriginal" type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                  <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="45" maxlength="500" /></td>
                  <td><input name="CmpInformeTecnicoATS3ProductoCantidad" type="text" class="EstFormularioCaja" id="CmpInformeTecnicoATS3ProductoCantidad" size="7" maxlength="10"  /></td>
                  <td><input name="CmpInformeTecnicoATS3ProductoValorUnitario" type="text" class="EstFormularioCajaDeshabilitada" id="CmpInformeTecnicoATS3ProductoValorUnitario" size="7" maxlength="10" readonly="readonly"  /></td>
                  <td><input name="CmpInformeTecnicoATS3ProductoValorTotal" type="text" class="EstFormularioCaja" id="CmpInformeTecnicoATS3ProductoValorTotal" size="7" maxlength="10"  /></td>
                  <td><a href="javascript:FncInformeTecnicoATS3ProductoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td align="left"><div class="EstFormularioArea" >
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td width="1%">&nbsp;</td>
                  <td width="49%"><div class="EstFormularioAccion" id="CapInformeTecnicoProductoAccion">Listo
                    para registrar elementos </div></td>
                  <td width="49%" align="right"><a href="javascript:FncInformeTecnicoATS3ProductoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncInformeTecnicoATS3ProductoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                  <td width="1%"><div id="CapInformeTecnicoATS3ProductosResultado"> </div></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><div id="CapInformeTecnicoATS3Productos" class="EstCapInformeTecnicoATS3Productos" ></div></td>
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
            <td>&nbsp;</td>
          </tr>
          </table>
        
        
        </div>
      
      
    </td>
    </tr>
    
    
    
    </table>
    
    
    </div>

    
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

Calendar.setup({ 
	inputField : "CmpFechaVenta",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaVenta"// el id del botón que  
	});
	
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1");
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
}

?>
