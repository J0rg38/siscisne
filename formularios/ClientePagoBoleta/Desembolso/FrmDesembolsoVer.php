<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Personal');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Personal');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsDesembolsoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss('Desembolso');?>CssDesembolso.css');
</style>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj('Desembolso').'MsjDesembolso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolsoDestino.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolsoComprobante.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');


$InsDesembolso = new ClsDesembolso();
$InsMoneda = new ClsMoneda();
$InsBanco = new ClsBanco();

$InsCuenta = new ClsCuenta();

$InsTipoDocumento = new ClsTipoDocumento();

if (isset($_SESSION['InsDesembolsoComprobante'.$Identificador])){	
	$_SESSION['InsDesembolsoComprobante'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsDesembolsoComprobante'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc('Desembolso').'AccDesembolsoEditar.php');

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,NULL);
$ArrBancos = $ResBanco['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonNombre","ASC",NULL,NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsDesembolso->MonId);
$ArrCuentas = $ResCuenta['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];
?>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsDesembolso->DesId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        DESEMBOLSO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsDesembolso->DesTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsDesembolso->DesTiempoModificacion;?></span></td>
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
                  <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Desembolso</span>
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
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsDesembolso->DesId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Destino:</td>
                  <td align="left" valign="top"><?php
    switch($InsDesembolso->DesTipoDestino){
		case 1:
			$OpcTipoDestino1 = 'selected="selected"';
		break;
		
		case 2:
			$OpcTipoDestino2 = 'selected="selected"';
		break;
		
			  
		case 3:
			$OpcTipoDestino3 = 'selected="selected"';
		break;
    }
    ?>
                    <select disabled="disabled" class="EstFormularioCombo" name="CmpTipoDestino" id="CmpTipoDestino">
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcTipoDestino1;?> value="1">Proveedor</option>
                      <option <?php echo $OpcTipoDestino2;?> value="2">Cliente</option>
                      <option <?php echo $OpcTipoDestino3;?> value="3">Trabajador</option>
                    </select></td>
                  <td align="left" valign="top">Fecha de Desembolso: <br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsDesembolso->DesFecha)){ echo date("d/m/Y");}else{ echo $InsDesembolso->DesFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4" align="left" valign="top">
                  
                  
                  
                    
                    <div id="CapProveedor" class="<?php echo ($InsDesembolso->DesTipoDestino==1)?'EstTablaMultipleTipoDestinoActivo':'EstTablaMultipleTipoDestinoInactivo';?>">       
                      
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        Proveedor:
                        </div>
                      
                      
                      <div class="EstTablaMultipleTipoDestinoCampo"></div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                       
                        <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsDesembolso->PrvId;?>" size="3" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncProveedorNuevo('','');"></a></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpProveedorNombre" type="text"  class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsDesembolso->PrvNombre;?>" size="45" maxlength="255" readonly="readonly" <?php echo (!empty($InsDesembolso->PrvId)?'readonly="readonly"':'');?>  />
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
                          <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsDesembolso->TdoIdProveedor)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
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
                            <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsDesembolso->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
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
                    
                    
                    
                    
                    <div id="CapCliente" class="<?php echo ($InsDesembolso->DesTipoDestino==2)?'EstTablaMultipleTipoDestinoActivo':'EstTablaMultipleTipoDestinoInactivo';?>">                     
                      
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        Cliente:
                        </div>
                      
                      
                      <div class="EstTablaMultipleTipoDestinoCampo"></div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsDesembolso->CliId;?>" size="3" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncClienteNuevo();"></a></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpClienteNombre" type="text"  class="EstFormularioCaja" id="CmpClienteNombre" value="<?php echo $InsDesembolso->CliNombre;?> <?php echo $InsDesembolso->CliApellidoPaterno;?> <?php echo $InsDesembolso->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" <?php echo (!empty($InsDesembolso->CliId)?'readonly="readonly"':'');?>  />
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
                          <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsDesembolso->TdoIdCliente)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
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
                            <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNumeroDocumento"  value="<?php echo $InsDesembolso->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
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
                    
                    
                    
                    <div id="CapPersonal" class="<?php echo ($InsDesembolso->DesTipoDestino==3)?'EstTablaMultipleTipoDestinoActivo':'EstTablaMultipleTipoDestinoInactivo';?>">                     
                      
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        Trabajador:
                        </div>
                      
                      
                      <div class="EstTablaMultipleTipoDestinoCampo"></div>
                      <div class="EstTablaMultipleTipoDestinoCampo">
                        
                        
                        <input name="CmpPersonalId" type="hidden" id="CmpPersonalId" value="<?php echo $InsDesembolso->PerId;?>" size="3" />
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncPersonalNuevo();"></a></td>
                            <td>&nbsp;</td>
                            <td><input name="CmpPersonalNombre" type="text"  class="EstFormularioCaja" id="CmpPersonalNombre" value="<?php echo $InsDesembolso->PerNombre;?> <?php echo $InsDesembolso->PerApellidoPaterno;?> <?php echo $InsDesembolso->PerApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" <?php echo (!empty($InsDesembolso->PerId)?'readonly="readonly"':'');?>  />
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
                          <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsDesembolso->TdoIdPersonal)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
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
                            <td><input name="CmpPersonalNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPersonalNumeroDocumento"  value="<?php echo $InsDesembolso->PerNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
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
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrMonedas as $DatMoneda){
			?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsDesembolso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';} ?> ><?php echo $DatMoneda->MonNombre?> <?php echo $DatMoneda->MonSimbolo?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td align="left" valign="top">Tipo de Cambio: <br />
                    <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                  <td align="left" valign="top"><table>
                    <tr>
                      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsDesembolso->DesTipoCambio)){ echo "";}else{ echo $InsDesembolso->DesTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td><a href="javascript:FncPagoFacturaEstablecerMoneda();"></a></td>
                    </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Cuenta Afecta:</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpCuenta" id="CmpCuenta">
                    <option value="">Escoja una opcion</option>
                    <?php
				foreach($ArrCuentas as $DatCuenta){
				?>
                    <option <?php echo ($InsDesembolso->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueId?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?> - <?php echo $DatCuenta->MonNombre; ?></option>
                    <?php
				}
				?>
                    </select></td>
                  <td align="left" valign="top">Numero Cheque:</td>
                  <td align="left" valign="top"><span id="sprytextfield1">
                    <label>
                      <input name="CmpNumeroCheque" type="text" class="EstFormularioCaja" id="CmpNumeroCheque" value="<?php echo $InsDesembolso->DesNumeroCheque;?>" size="40" maxlength="45" readonly="readonly" />
                      </label>
                    <span class="textfieldRequiredMsg">Se necesita un valor</span></span></td>
                  <td>&nbsp;</td>
</tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Monto:</td>
                  <td align="left" valign="top"><input name="CmpMonto" type="text" class="EstFormularioCaja" id="CmpMonto" value="<?php echo number_format($InsDesembolso->DesMonto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Concepto:</td>
                  <td align="left" valign="top"><textarea name="CmpConcepto" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpConcepto"><?php echo addslashes($InsDesembolso->DesConcepto);?></textarea></td>
                  <td align="left" valign="top">Observacion Interna:</td>
                  <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo addslashes($InsDesembolso->DesObservacion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top"><?php
			switch($InsDesembolso->DesEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
                    <select disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                      <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                      <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
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

