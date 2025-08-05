<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Personal');?>JsPersonalFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Personal');?>JsPersonalAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsCuentaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsIngresoCajaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsIngresoCajaComprobanteFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssIngresoCaja.css');
</style>

<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$Registro = false;

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjIngresoCaja.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngresoDestino.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngresoComprobante.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');


$InsIngreso = new ClsIngreso();
$InsMoneda = new ClsMoneda();
$InsBanco = new ClsBanco();
$InsCuenta = new ClsCuenta();
$InsTipoDocumento = new ClsTipoDocumento();
$InsFormaPago = new ClsFormaPago();

if (!isset($_SESSION['InsIngresoComprobante'.$Identificador])){	
	$_SESSION['InsIngresoComprobante'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsIngresoComprobante'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsIngresoComprobante'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccIngresoCajaRegistrar.php');

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,NULL);
$ArrBancos = $ResBanco['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonNombre","ASC",NULL,NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsIngreso->MonId);
$ArrCuentas = $ResCuenta['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];



$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,1);
$ArrFormaPagos = $ResFormaPago['Datos'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/


$().ready(function() {
/*
Configuracion carga de datos y animacion
*/	
	$('#CmpFecha').focus();

});

var Contador = 1;
var IngresoComprobanteEditar = 1;
var IngresoComprobanteEliminar = 1;

</script>



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
	
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        INGRESO A CAJA</span></td>
      </tr>
      <tr>
        
        <td colspan="2">
        
        
            
            <div class="EstFormularioArea">
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4"><span class="EstFormularioSubTitulo">Datos del ingreso a caja</span>
                    <input type="hidden" name="Guardar" id="Guardar"   />
                  <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo Interno:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsIngreso->IngId;?>" size="10" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Destino:</td>
                  <td align="left" valign="top">
                    
                    <?php
  /*  switch($InsIngreso->IngTipoDestino){
		case 1:
			$OpcTipoDestino1 = 'selected="selected"';
		break;
		
		case 2:
			$OpcTipoDestino2 = 'selected="selected"';
		break;
		
			  
		case 3:
			$OpcTipoDestino3 = 'selected="selected"';
		break;
    }*/
	  switch($InsIngreso->IngTipoDestino){
		case 1:
			$OpcTipoDestino1 = 'checked="checked"';
		break;
		
		case 2:
			$OpcTipoDestino2 = 'checked="checked"';
		break;
		
		case 3:
			$OpcTipoDestino3 = 'checked="checked"';
		break;
    }
    ?>
                  <!--  <select class="EstFormularioCombo" name="CmpTipoDestino" id="CmpTipoDestino">
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcTipoDestino1;?> value="1">Proveedor</option>
                      <option <?php echo $OpcTipoDestino2;?> value="2">Cliente</option>
                      <option <?php echo $OpcTipoDestino3;?> value="3">Trabajador</option>
                    </select>-->
                    
                    
<input type="radio" name="CmpTipoDestino" id="CmpTipoDestino1" value="1"  <?php echo $OpcTipoDestino1;?> > Proveedor
<input type="radio" name="CmpTipoDestino" id="CmpTipoDestino2" value="2" <?php echo $OpcTipoDestino2;?>> Cliente
   <input type="radio" name="CmpTipoDestino" id="CmpTipoDestino3" value="3" <?php echo $OpcTipoDestino3;?>> Trabajador   
                 
                  </td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top">
                    
                    
                    
                    <div id="CapProveedor" class="<?php echo ($InsIngreso->IngTipoDestino==1)?'EstTablaMultipleTipoDestinoActivo':'EstTablaMultipleTipoDestinoInactivo';?>">       
                      
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        Proveedor:
                        </div>
                      
                      
                      <div class="EstTablaMultipleTipoDestinoCampo"></div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                       
                        <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsIngreso->PrvId;?>" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></a></td>
                            <td>&nbsp;</td>
                            <td><input <?php echo (!empty($InsIngreso->PrvId)?'readonly="readonly"':'');?>  class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsIngreso->PrvNombre;?>" size="45" maxlength="255"  />
                              <a href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&amp;width=850" class="thickbox" title="">
                                <!-- [...]-->
                                </a></td>
                            <td>&nbsp;</td>
                            <td><a id="BtnProveedorRegistrar" href="javascript:FncProveedorCargarFormulario('Registrar','','');" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" href="javascript:FncProveedorCargarFormulario('Editar','','');"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                            </tr>
                          <tr> </tr>
                          <tr> </tr>
                          </table>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo"> Tipo Doc.: </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        <select disabled="disabled" class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
                          <option value="">Escoja una opcion</option>
                          <?php
                foreach($ArrTipoDocumentos as $DatTipoDocumento){
                ?>
                          <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsIngreso->TdoIdProveedor)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                          <?php
                }
                ?>
                          </select>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo"> Num. Doc: </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsIngreso->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                            <td></td>
                            <td>&nbsp;</td>
                            <td><div id="CapProveedorBuscar"></div></td>
                            </tr>
                          <tr> </tr>
                          </table>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        </div>
                      </div>    
                    
                    
                    
                    
                    
                    
                    <!--
                      
                      -->
                    
                    
                    
                    <div id="CapCliente" class="<?php echo ($InsIngreso->IngTipoDestino==2)?'EstTablaMultipleTipoDestinoActivo':'EstTablaMultipleTipoDestinoInactivo';?>">                     
                      
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        Cliente:
                        </div>
                      
                      
                      <div class="EstTablaMultipleTipoDestinoCampo"></div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsIngreso->CliId;?>"  />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td>&nbsp;</td>
                            <td><input <?php echo (!empty($InsIngreso->CliId)?'readonly="readonly"':'');?>  class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" value="<?php echo $InsIngreso->CliNombre;?> <?php echo $InsIngreso->CliApellidoPaterno;?> <?php echo $InsIngreso->CliApellidoMaterno;?>" size="45" maxlength="255"  />
                              <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title="">
                                <!-- [...]-->
                                </a></td>
                            <td>&nbsp;</td>
                            <td><a id="BtnClienteRegistrar" href="javascript:FncClienteCargarFormulario('Registrar');" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" href="javascript:FncClienteCargarFormulario('Editar','','');"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                            </tr>
                          <tr> </tr>
                          <tr> </tr>
                          </table>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo"> Tipo Doc.: </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        <select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                          <option value="">Escoja una opcion</option>
                          <?php
                    foreach($ArrTipoDocumentos as $DatTipoDocumento){
                    ?>
                          <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsIngreso->TdoIdCliente)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                          <?php
                    }
                    ?>
                          </select>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo"> Num. Doc: </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNumeroDocumento"  value="<?php echo $InsIngreso->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                            <td></td>
                            <td>&nbsp;</td>
                            <td><div id="CapClienteBuscar"></div></td>
                            </tr>
                          <tr> </tr>
                          </table>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        </div>
                      </div>
                    
                    
                    
                    <div id="CapPersonal" class="<?php echo ($InsIngreso->IngTipoDestino==3)?'EstTablaMultipleTipoDestinoActivo':'EstTablaMultipleTipoDestinoInactivo';?>">                     
                      
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        Trabajador:
                        </div>
                      
                      
                      <div class="EstTablaMultipleTipoDestinoCampo"></div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        <input name="CmpPersonalId" type="hidden" id="CmpPersonalId" value="<?php echo $InsIngreso->PerId;?>" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncPersonalNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td>&nbsp;</td>
                            <td><input <?php echo (!empty($InsIngreso->PerId)?'readonly="readonly"':'');?>  class="EstFormularioCaja" name="CmpPersonalNombre" type="text" id="CmpPersonalNombre" value="<?php echo $InsIngreso->PerNombre;?> <?php echo $InsIngreso->PerApellidoPaterno;?> <?php echo $InsIngreso->PerApellidoMaterno;?>" size="45" maxlength="255"  />
                              <a href="comunes/Personal/FrmPersonalBuscar.php?height=440&amp;width=850" class="thickbox" title="">
                                <!-- [...]-->
                                </a></td>
                            <td>&nbsp;</td>
                            <td><a id="BtnPersonalRegistrar" href="javascript:FncPersonalCargarFormulario('Registrar');" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnPersonalEditar" href="javascript:FncPersonalCargarFormulario('Editar');"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                            </tr>
                          <tr> </tr>
                          <tr> </tr>
                          </table>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo"> Tipo Doc.: </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        <select disabled="disabled" class="EstFormularioCombo" name="CmpPersonalTipoDocumento" id="CmpPersonalTipoDocumento">
                          <option value="">Escoja una opcion</option>
                          <?php
                    foreach($ArrTipoDocumentos as $DatTipoDocumento){
                    ?>
                          <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsIngreso->TdoIdPersonal)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                          <?php
                    }
                    ?>
                          </select>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo"> Num. Doc: </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpPersonalNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPersonalNumeroDocumento"  value="<?php echo $InsIngreso->PerNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                            <td></td>
                            <td>&nbsp;</td>
                            <td><div id="CapProveedorBuscar"></div></td>
                            </tr>
                          <tr> </tr>
                          </table>
                        </div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        </div>
                      </div>
                    
                    
                    
                    
                    <!--
              
              -->                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Referencia:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpReferencia" type="text" id="CmpReferencia" value="<?php echo $InsIngreso->IngReferencia;?>" size="40" maxlength="45" /></td>
                  <td align="left" valign="top">Fecha de Ingreso: <br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><span id="sprytextfield1">
                    <label>
                      <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsIngreso->IngFecha; ?>" size="10" maxlength="10" />
                    </label>
                    <span class="textfieldRequiredMsg">Se necesita un valor</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/nicono/alerta.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><span id="spryselect">
                    <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrMonedas as $DatMoneda){
			?>
                      <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsIngreso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';} ?> ><?php echo $DatMoneda->MonNombre?> <?php echo $DatMoneda->MonSimbolo?></option>
                      <?php
			}
			?>
                    </select>
                    <span class="selectRequiredMsg">Escoja una opcion</span></span></td>
                  <td align="left" valign="top">Tipo de Cambio: <br />
                    <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                  <td align="left" valign="top"><table>
                    <tr>
                      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsIngreso->IngTipoCambio)){ echo "";}else{ echo $InsIngreso->IngTipoCambio; } ?>" size="10" maxlength="10" /></td>
                      <td><a href="javascript:FncPagoFacturaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                    </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Forma de Pago:</td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago">
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrFormaPagos as $DatFormaPago){
				?>
                    <option <?php echo ($InsIngreso->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
                    <?php
			  }
			  
			  ?>
                  </select></td>
                  <td align="left" valign="top">Tipo:</td>
                  <td align="left" valign="top"><?php
			switch($InsIngreso->IngTipo){
				case 1:
					$OpcTipo1 = 'selected="selected"';
				break;
				
				case 5:
					$OpcTipo5 = 'selected="selected"';
				break;
				
			}
			?>
                    <select  class="EstFormularioCombo" id="CmpTipo" name="CmpTipo">
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcTipo1;?> value="1">Saldo Inicial</option>
                      <option <?php echo $OpcTipo5;?> value="5">Otros</option>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Monto:</td>
                  <td align="left" valign="top"><span id="sprytextfield4">
                    <input class="EstFormularioCaja" name="CmpMonto" type="text" id="CmpMonto" value="<?php echo number_format($InsIngreso->IngMonto,2);?>" size="10" maxlength="10" />
                    <span class="textfieldRequiredMsg">Se necesita un valor</span></span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Concepto:</td>
                  <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpConcepto" id="CmpConcepto" cols="45" rows="4"><?php echo addslashes($InsIngreso->IngConcepto);?></textarea></td>
                  <td align="left" valign="top">Observacion Interna:</td>
                  <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpObservacion" id="CmpObservacion" cols="45" rows="4"><?php echo addslashes($InsIngreso->IngObservacion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top">
	<?php
    switch($InsIngreso->IngEstado){
		case 1:
		 $OpcEstado1 = 'selected="selected"';
		break;
		
		case 3:
			$OpcEstado3 = 'selected="selected"';
		break;
		
			  
		case 6:
			$OpcEstado6 = 'selected="selected"';
		break;
    }
    ?>
                    
                    <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                      <option <?php echo $OpcEstado1;?> value="1">No Realizado</option>
                      <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                      <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                      
                      </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
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
                </table>
              
              
              </div>
            
        
        
        
        </td>
      </tr>
      
      
      
      <?php
/*	  
	  ?>
      <tr>
        <td colspan="2" align="center"><div class="EstFormularioArea">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="98%"><table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="9"><span class="EstFormularioSubTitulo">COMPROBANTES </span><span class="EstFormularioSubTitulo">
                    <input type="hidden" name="CmpGastoId"    id="CmpGastoId"   />
                    <input type="hidden" name="CmpGastoItem" id="CmpGastoItem" />
                    <input type="hidden" name="CmpGastoUnidadMedida" id="CmpGastoUnidadMedida" />
                    <input type="hidden" name="CmpGastoUnidadMedidaEquivalente"   id="CmpGastoUnidadMedidaEquivalente"  />
                    <input type="hidden" name="CmpGastoCostoAux"    id="CmpGastoCostoAux"    />
                  </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><div id="CapGastoBuscar"></div></td>
                  <td>Proveedor:</td>
                  <td>&nbsp;</td>
                  <td>Num. Comprob.:</td>
                  <td>&nbsp;</td>
                  <td>Moneda:</td>
                  <td> Total:</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><a href="javascript:FncIngresoComprobanteNuevo('');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  <td><input name="CmpGastoNombre" type="text" class="EstFormularioCaja" id="CmpGastoNombre" size="40" /></td>
                  <td><a href="javascript:FncGastoBuscar('CodigoOriginal','');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  <td><input name="CmpGastoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpGastoCodigoOriginal" size="10" maxlength="20" /></td>
                  <td><a id="BtnGastoRegistrar" onclick="FncGastoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnGastoEditar" onclick="FncGastoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a><a href="javascript:FncGastoBuscar('CodigoOriginal','');"></a></td>
                  <td><select  class="EstFormularioCombo" name="CmpGastoUnidadMedidaConvertir" id="CmpGastoUnidadMedidaConvertir">
                  </select></td>
                  <td><input name="CmpGastoImporte" type="text" class="EstFormularioCaja" id="CmpGastoImporte" size="10" maxlength="10"  /></td>
                  <td><a href="javascript:FncIngresoComprobanteGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                  <td><a href="comunes/Gasto/FrmGastoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><div class="EstFormularioArea" >
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
            <tr>
              <td>&nbsp;</td>
              <td><input type="hidden" name="CmpIngresoComprobanteAccion2" id="CmpIngresoComprobanteAccion2" value="AccIngresoCajaComprobanteRegistrar.php" /></td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="1%">&nbsp;</td>
              <td width="49%"><div class="EstFormularioAccion" id="CapGastoAccion2">Listo
                para registrar elementos</div></td>
              <td width="49%" align="right"><a href="javascript:FncIngresoComprobanteListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                <?php
if($InsIngreso->VdiOrigen <> "CPR"){
?>
                <a href="javascript:FncIngresoComprobanteEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                <?php
}
?></td>
              <td width="1%"><div id="CapIngresoComprobantesResultado2"> </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2"><div id="CapIngresoComprobantes2" class="EstCapIngresoComprobantes" > </div></td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
      </tr>
        <?php
	  */
	  ?>
      
      
      
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


var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var spryselect = new Spry.Widget.ValidationSelect("spryselect");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}


?>

