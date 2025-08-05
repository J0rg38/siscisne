<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"SolicitudDesembolso",$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("ServicioRepuesto");?>JsServicioRepuestoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("ServicioRepuesto");?>JsServicioRepuestoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsSolicitudDesembolsoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssSolicitudDesembolso.css');
</style>

<?php
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjSolicitudDesembolso.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoGasto.php');

//INSTANCIAS
$InsSolicitudDesembolso = new ClsSolicitudDesembolso();
$InsMoneda = new ClsMoneda();
$InsPersonal = new ClsPersonal();
$InsArea = new ClsArea();
$InsTipoGasto = new ClsTipoGasto();

if (!isset($_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador])){	
	$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]);
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccSolicitudDesembolsoRegistrar.php');
//DATOS
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

//MtdObtenerAreas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {
$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreNombre","ASC",NULL,NULL);
$ArrAreas = $ResArea['Datos'];

$ResTipoGasto = $InsTipoGasto->MtdObtenerTipoGastos(NULL,NULL,"TgaNombre","ASC",NULL,NULL,NULL);
$ArrTipoGastos = $ResTipoGasto['Datos'];



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

	$('#CmpCliente').focus();


});

/*
Configuracion Formulario
*/
var Formulario = "FrmRegistrar";


</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" >

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
if($Registro){
?>

	<?php
/*    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsSolicitudDesembolso->SdsId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsSolicitudDesembolso->SdsId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }*/
    ?>
    
<?php	
}
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        SOLICITUD DE DESEMBOLSO</span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
          
	<ul class="tabs">
		<li><a href="#tab1">Solicitud de Desembolso</a></li>
		
        
	</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->


<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
           
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4">
                        <span class="EstFormularioSubTitulo">Datos del Solicitud de Desembolso
                          <input type="hidden" name="Guardar" id="Guardar"   />
                          <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                          </span></td>
                      <td>&nbsp;</td>
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
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitado" id="CmpId" value="<?php echo $InsSolicitudDesembolso->SdsId;?>" size="15" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsSolicitudDesembolso->SdsFecha)){ echo date("d/m/Y");}else{ echo $InsSolicitudDesembolso->SdsFecha; }?>" size="15" maxlength="10" />                        <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                      </td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Moneda:</td>
                      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                            <option value="">Escoja una opcion</option>
                            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsSolicitudDesembolso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                            <?php
			  }
			  ?>
                            </select></td>
                          <td><div id="CapMonedaBuscar"></div></td>
                          </tr>
                        </table></td>
                      <td align="left" valign="top">Tipo de Cambio:<br />
                        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                      <td align="left" valign="top">
                        
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
                              
                              <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitado" id="CmpTipoCambio" onchange="FncSolicitudDesembolsoDetalleListar();" value="<?php if (empty($InsSolicitudDesembolso->SdsTipoCambio)){ echo "";}else{ echo $InsSolicitudDesembolso->SdsTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />                      </td>
                            <td><a href="javascript:FncSolicitudDesembolsoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                            </tr>
                          </table>                      </td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Tipo:</td>
                      <td align="left" valign="top">
                      
                      <select  class="EstFormularioCombo" name="CmpTipoGasto" id="CmpTipoGasto" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrTipoGastos as $DatTipoGasto){
					?>
                        <option <?php echo ($DatTipoGasto->TgaId==$InsSolicitudDesembolso->TgaId)?'selected="selected"':'';?>  value="<?php echo $DatTipoGasto->TgaId;?>"><?php echo $DatTipoGasto->TgaNombre;?></option>
                        <?php
					}
					?>
                      </select></td>
                      <td align="left" valign="top">Area:</td>
                      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpArea" id="CmpArea" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrAreas as $DatArea){
					?>
                        <option <?php echo ($DatArea->AreId==$InsSolicitudDesembolso->AreId)?'selected="selected"':'';?>  value="<?php echo $DatArea->AreId;?>"><?php echo $DatArea->AreNombre;?></option>
                        <?php
					}
					?>
                      </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Cliente(s) Referencia:</td>
                      <td align="left" valign="top"><input name="CmpCliente" type="text" class="EstFormularioCaja" id="CmpCliente" value="<?php echo $InsSolicitudDesembolso->SdsCliente;?>" size="45" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">VIN:</td>
                      <td align="left" valign="top"><input name="CmpVIN" type="text" class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsSolicitudDesembolso->SdsVIN;?>" size="25" maxlength="25" /></td>
                      <td align="left" valign="top">Placa:</td>
                      <td align="left" valign="top"><input name="CmpPlaca" type="text" class="EstFormularioCaja" id="CmpPlaca" value="<?php echo $InsSolicitudDesembolso->SdsPlaca;?>" size="25" maxlength="25" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Se requiere:</td>
                      <td align="left" valign="top"><textarea name="CmpDescripcion" cols="45" rows="2" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsSolicitudDesembolso->SdsDescripcion;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Monto:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpMonto" type="text" id="CmpMonto" value="<?php echo number_format($InsSolicitudDesembolso->SdsMonto,2);?>" size="10" maxlength="10" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsSolicitudDesembolso->SdsEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                        <!--<select  class="EstFormularioCombo" name="CmpEstadoAux" id="CmpEstadoAux" disabled="disabled">
                          <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                          <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                        </select>-->
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled" >
                          <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                          <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                          </select>
                        <!-- <input type="hidden" name="CmpEstado" id="CmpEstado" value="<?php echo $InsSolicitudDesembolso->SdsEstado;?>" />
                       --></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                      <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">A solicitud de:</td>
                      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                        <option <?php echo ($DatPersonal->PerId==$InsSolicitudDesembolso->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                        <?php
					}
					?>
                        </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion Interna:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsSolicitudDesembolso->SdsObservacion;?></textarea></td>
                      <td align="left" valign="top">Observacion Impresa:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsSolicitudDesembolso->SdsObservacionImpresa;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    </table>
                  </div>     
                </td>
            </tr>
            
             <tr>
               <td valign="top">
               
               <div class="EstFormularioArea">
                  
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="98%">
                        
                        
                        
                        
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="8"><span class="EstFormularioSubTitulo">PRODUCTOS </span><span class="EstFormularioSubTitulo">
  <input type="hidden" name="CmpServicioRepuestoId"    id="CmpServicioRepuestoId"   />
  <input type="hidden" name="CmpServicioRepuestoItem" id="CmpServicioRepuestoItem" />
  <input type="hidden" name="CmpServicioRepuestoUnidadMedida" id="CmpServicioRepuestoUnidadMedida" />
  <input type="hidden" name="CmpServicioRepuestoUnidadMedidaEquivalente"   id="CmpServicioRepuestoUnidadMedidaEquivalente"  />
  <input type="hidden" name="CmpServicioRepuestoCostoAux"    id="CmpServicioRepuestoCostoAux"    />
  <input type="hidden" name="CmpServicioRepuestoValorVenta"    id="CmpServicioRepuestoValorVenta"    />
      <input type="hidden" name="CmpServicioRepuestoPrecioBruto"    id="CmpServicioRepuestoPrecioBruto"    />                          
                              </span></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>Nombre : </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>Cantidad:</td>
                            
                            <td>
                              Precio:</td>
                            <td>
                              Importe:</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                        
                          <tr>
                            <td>&nbsp;</td>
                            <td><input name="CmpServicioRepuestoNombre" type="text" class="EstFormularioCaja" id="CmpServicioRepuestoNombre" size="30" /></td>
                            <td>
                              
                              <?php
							if(empty($InsVentaDirecta->CprId) or 1 == 1){
							?>
                              <a id="BtnServicioRepuestoRegistrar" onclick="FncServicioRepuestoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnServicioRepuestoEditar" onclick="FncServicioRepuestoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                              
                              <?php
							}
							?>
                              </td>
                            <td> <a id="BtnServicioRepuestoConsulta" onclick="FncServicioRepuestoCargarFormulario('Consulta');" href="javascript:void(0)"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" /> </a></td>
                            <td>
                              
                              <input name="CmpServicioRepuestoCantidad" type="text" class="EstFormularioCaja" id="CmpServicioRepuestoCantidad" size="8" maxlength="10"  />                            </td>
                            <td><input name="CmpServicioRepuestoPrecio" type="text" class="EstFormularioCajaDeshabilitado" id="CmpServicioRepuestoPrecio" size="8" maxlength="10"  />                            </td>
                            <td>
                              
                              <input name="CmpServicioRepuestoImporte" type="text" class="EstFormularioCaja" id="CmpServicioRepuestoImporte" size="8" maxlength="10"  />                            </td>
                            <td><a href="javascript:FncVentaDirectaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td>
                              
                              
                           
                              <a href="comunes/ServicioRepuesto/FrmServicioRepuestoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                           
                              
                              </td>
                          </tr>
                            </table>                      
                        </td>
                      </tr>
                    </table>
                  </div>
                  
                  </td>
             </tr>
             <tr>
               <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%"><input type="hidden" name="CmpVentaDirectaDetalleAccion" id="CmpVentaDirectaDetalleAccion" value="AccVentaDirectaDetalleRegistrar.php" /></td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapServicioRepuestoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right">
                      
                      <a href="javascript:FncVentaDirectaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                      
                      <?php
if($InsVentaDirecta->VdiOrigen <> "CPR"){
?>
                      <a href="javascript:FncVentaDirectaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                      <?php
}
?>        
                      
                      
                      </td>
                    <td width="1%"><div id="CapVentaDirectaDetallesResultado"> </div></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapVentaDirectaDetalles" class="EstCapVentaDirectaDetalles" > </div></td>
                    <td>&nbsp;</td>
                    </tr>
                  </table>
                </div></td>
             </tr>
             <tr>
              <td valign="top">&nbsp;</td>
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
	
	
	
  


<!--  -->
  
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


?>
