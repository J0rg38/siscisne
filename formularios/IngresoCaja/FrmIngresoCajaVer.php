<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Personal');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Personal');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsIngresoCajaFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssIngresoCaja.css');
</style>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_id = $_GET['Id'];

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

if (isset($_SESSION['InsIngresoComprobante'.$Identificador])){	
	$_SESSION['InsIngresoComprobante'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsIngresoComprobante'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccIngresoCajaEditar.php');

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
var IngresoComprobanteEditar = 2;
var IngresoComprobanteEliminar = 2;

</script>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsIngreso->IngId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        INGRESO A CAJA</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsIngreso->IngTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsIngreso->IngTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
         <br />
    
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
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
                  <td colspan="3" align="left" valign="top"><?php
   /* switch($InsIngreso->IngTipoDestino){
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
    
    
    
<!--                    <select disabled="disabled" class="EstFormularioCombo" name="CmpTipoDestino" id="CmpTipoDestino">
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcTipoDestino1;?> value="1">Proveedor</option>
                      <option <?php echo $OpcTipoDestino2;?> value="2">Cliente</option>
                      <option <?php echo $OpcTipoDestino3;?> value="3">Trabajador</option>
                    </select>
-->

<input disabled="disabled" type="radio" name="CmpTipoDestino" id="CmpTipoDestino1" value="1"  <?php echo $OpcTipoDestino1;?> > Proveedor
<input disabled="disabled" type="radio" name="CmpTipoDestino" id="CmpTipoDestino2" value="2" <?php echo $OpcTipoDestino2;?>> Cliente
   <input disabled="disabled" type="radio" name="CmpTipoDestino" id="CmpTipoDestino3" value="3" <?php echo $OpcTipoDestino3;?>> Trabajador   
   
   
                    </td>
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
                       
                        <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsIngreso->PrvId;?>" size="3" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncProveedorNuevo('','');"></a></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpProveedorNombre" type="text"  class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsIngreso->PrvNombre;?>" size="45" maxlength="255" readonly="readonly" <?php echo (!empty($InsIngreso->PrvId)?'readonly="readonly"':'');?>  />
                              <a href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&amp;width=850" class="thickbox" title="">
                                <!-- [...]-->
                                </a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
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
                    
                    
                    
                    
                    <div id="CapCliente" class="<?php echo ($InsIngreso->IngTipoDestino==2)?'EstTablaMultipleTipoDestinoActivo':'EstTablaMultipleTipoDestinoInactivo';?>">                     
                      
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        Cliente:
                        </div>
                      
                      
                      <div class="EstTablaMultipleTipoDestinoCampo"></div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsIngreso->CliId;?>" size="3" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncClienteNuevo();"></a></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpClienteNombre" type="text"  class="EstFormularioCaja" id="CmpClienteNombre" value="<?php echo $InsIngreso->CliNombre;?> <?php echo $InsIngreso->CliApellidoPaterno;?> <?php echo $InsIngreso->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" <?php echo (!empty($InsIngreso->CliId)?'readonly="readonly"':'');?>  />
                              <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title="">
                                <!-- [...]-->
                                </a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
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
                        
                        
                        <input name="CmpPersonalId" type="hidden" id="CmpPersonalId" value="<?php echo $InsIngreso->PerId;?>" size="3" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncPersonalNuevo();"></a></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpPersonalNombre" type="text"  class="EstFormularioCaja" id="CmpPersonalNombre" value="<?php echo $InsIngreso->PerNombre;?> <?php echo $InsIngreso->PerApellidoPaterno;?> <?php echo $InsIngreso->PerApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" <?php echo (!empty($InsIngreso->PerId)?'readonly="readonly"':'');?>  />
                              <a href="comunes/Personal/FrmPersonalBuscar.php?height=440&amp;width=850" class="thickbox" title="">
                                <!-- [...]-->
                                </a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
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
                    
                  
                  
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Referencia:</td>
                  <td align="left" valign="top"><input name="CmpReferencia" type="text" class="EstFormularioCaja" id="CmpReferencia" value="<?php echo $InsIngreso->IngReferencia;?>" size="40" maxlength="45" readonly="readonly" /></td>
                  <td align="left" valign="top">Fecha de Ingreso: <br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsIngreso->IngFecha)){ echo date("d/m/Y");}else{ echo $InsIngreso->IngFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrMonedas as $DatMoneda){
			?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsIngreso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';} ?> ><?php echo $DatMoneda->MonNombre?> <?php echo $DatMoneda->MonSimbolo?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td align="left" valign="top">Tipo de Cambio: <br />
                    <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                  <td align="left" valign="top"><table>
                    <tr>
                      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsIngreso->IngTipoCambio)){ echo "";}else{ echo $InsIngreso->IngTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td><a href="javascript:FncPagoFacturaEstablecerMoneda();"></a></td>
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
                    <select disabled="disabled"  class="EstFormularioCombo" id="CmpTipo" name="CmpTipo">
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcTipo1;?> value="1">Saldo Inicial</option>
                      <option <?php echo $OpcTipo5;?> value="5">Otros</option>
                    </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Monto:</td>
                  <td align="left" valign="top"><input name="CmpMonto" type="text" class="EstFormularioCaja" id="CmpMonto" value="<?php echo number_format($InsIngreso->IngMonto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
</tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Concepto:</td>
                  <td align="left" valign="top"><textarea name="CmpConcepto" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpConcepto"><?php echo addslashes($InsIngreso->IngConcepto);?></textarea></td>
                  <td align="left" valign="top">Observacion Interna:</td>
                  <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo addslashes($InsIngreso->IngObservacion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top"><?php
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
                    <select disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
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
      </table>
     
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

