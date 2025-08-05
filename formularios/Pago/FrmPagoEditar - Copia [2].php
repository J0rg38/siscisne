<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago",$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsCuentaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsTarjetaFunciones.js" ></script>


<?php
//VARIABLES
$GET_id = $_GET['Id'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$Edito = false;
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPago.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTarjeta.php');


//INSTANCIAS
$InsPago = new ClsPago();
$InsMoneda = new ClsMoneda();
$InsCondicionPago = new ClsCondicionPago();
$InsVentaDirecta = new ClsVentaDirecta();
$InsArea = new ClsArea();
$InsTipoDocumento = new ClsTipoDocumento();
$InsFormaPago = new ClsFormaPago();
$InsCuenta = new ClsCuenta();
$InsTarjeta = new ClsTarjeta();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoEditar.php');


$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","Desc",NULL,1);
$ArrAreas = $ResArea['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL);
$ArrFormaPagos = $ResFormaPago['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsPago->MonId);
$ArrCuentas = $ResCuenta['Datos'];

//$InsTarjeta->MtdObtenerTarjetas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TarId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL);

//MtdObtenerTarjetas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TarId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResTarjeta = $InsTarjeta->MtdObtenerTarjetas(NULL,NULL,'TarId','Desc',NULL,NULL);
$ArrTarjetas = $ResTarjeta['Datos'];



?>


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
	
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR ABONO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPago->PagTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPago->PagTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
        
         
         <br />
         


               
<ul class="tabs">
    <li><a href="#tab1">Abono</a></li>
   

</ul>
<div class="tab_container">
    <div id="tab1" class="tab_content">
    <!--Content-->     
    
    
    
    
    
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Abono
              <input type="hidden" name="Guardar" id="Guardar"   />
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
            <td>C&oacute;digo Interno:
              <input name="CmpTipo" type="hidden" id="CmpTipo" value="FAC" />
              <input name="CmpVentaDirectaId" type="hidden" id="CmpVentaDirectaId" value="<?php echo $VentaDirectaId;?>" />
              <input name="CmpVentaDirectaTalonarioId" type="hidden" id="CmpVentaDirectaTalonarioId" value="<?php echo $VentaDirectaTalonarioId;?>" />
              <input name="CmpVentaDirectaTalonarioNumero" type="hidden" id="CmpVentaDirectaTalonarioNumero" value="<?php echo $VentaDirectaTalonarioNumero;?>" /></td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPago->PagId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">Total de la Orden:</td>
            <td align="left" valign="top"><input class="EstFormularioCajaDeshabilitada" name="CmpVentaDirectaTotal" type="text" id="CmpVentaDirectaTotal" value="<?php echo number_format($InsPago->VdiTotal,2);?>" size="10" maxlength="10" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Orden de Venta/Orden Ven. Vehiculo:</td>
            <td align="left" valign="top"><input name="CmpVentaDirecta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirecta" value="<?php echo $VentaDirectaId;?>" size="15" maxlength="20"  readonly="readonly"/>
              /
              <input name="CmpOrdenVentaVehiculo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculo" value="<?php echo $OrdenVentaVehiculoId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>Num. de Recibo:</td>
            <td><input name="CmpNumeroRecibo" type="text"  class="EstFormularioCaja" id="CmpNumeroRecibo" value="<?php echo $InsPago->PagNumeroRecibo;?>" size="30" maxlength="45" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente: </td>
            <td align="left" valign="top"><input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsPago->CliId;?>" />
              <input name="CmpClienteNombre" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre" value="<?php echo $InsPago->CliNombre;?> <?php echo $InsPago->CliApellidoPaterno;?> <?php echo $InsPago->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo Doc.:</td>
            <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
              <option value="">Escoja una opcion</option>
              <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
              <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsPago->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
              <?php
	}
	?>
              </select></td>
            <td align="left" valign="top">Num. Doc.:</td>
            <td align="left" valign="top"><input name="CmpClienteNumeroDocumento" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteNumeroDocumento" value="<?php echo $InsPago->CliNumeroDocumento;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Referencia:</td>
            <td align="left" valign="top"><input name="CmpReferencia" type="text"  class="EstFormularioCaja" id="CmpReferencia" value="<?php echo $InsPago->PagReferencia;?>" size="45" maxlength="255" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield7">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsPago->PagFecha;?>" size="15" maxlength="10" />
                </label>
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">Area Destino:</td>
            <td align="left" valign="top"><span id="spryselect2">
              <select class="EstFormularioCombo" name="CmpAreaId" id="CmpAreaId">
                <option value="">Escoja una opcion</option>
                <?php
			  foreach($ArrAreas as $DatArea){
				?>
                <option <?php echo ($InsPago->AreId == $DatArea->AreId)?'selected="selected"':''; ?>  value="<?php echo $DatArea->AreId?>"><?php echo $DatArea->AreNombre ?></option>
                <?php
			  }
			  
			  ?>
                </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><span id="spryselect3">
                  <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsPago->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                    </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td><div id="CapMonedaBuscar"></div></td>
                </tr>
            </table></td>
            <td align="left" valign="top">Tipo de Cambio: <br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table>
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncPagoDetalleListar();" value="<?php if (empty($InsPago->PagTipoCambio)){ echo "";}else{ echo $InsPago->PagTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                <td><a href="javascript:FncPagoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Forma de Pago:</td>
            <td align="left" valign="top"><span id="spryselect1">
              <select class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago">
                <option value="">Escoja una opcion</option>
                <?php
			  foreach($ArrFormaPagos as $DatFormaPago){
				?>
                <option <?php echo ($InsPago->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
                <?php
			  }
			  
			  ?>
                </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>Tarjeta:</td>
            <td><select class="EstFormularioCombo" name="CmpTarjeta" id="CmpTarjeta">
              <option value="">Escoja una opcion</option>
              <?php
                foreach($ArrTarjetas as $DatTarjeta){
                ?>
              <option <?php echo ($InsPago->TarId == $DatTarjeta->TarId)?'selected="selected"':''; ?>  value="<?php echo $DatTarjeta->TarId?>"><?php echo $DatTarjeta->TarNombre ?></option>
              <?php
                }
                ?>
            </select></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cuenta:</td>
            <td colspan="3"><select class="EstFormularioCombo" name="CmpCuenta" id="CmpCuenta">
              <option value="">Escoja una opcion</option>
              <?php
				foreach($ArrCuentas as $DatCuenta){
				?>
              <option <?php echo ($InsPago->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueId?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?> - <?php echo $DatCuenta->MonNombre; ?></option>
              <?php
				}
				?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Num. de Transaccion:</td>
            <td><input name="CmpNumeroTransaccion" type="text"  class="EstFormularioCaja" id="CmpNumeroTransaccion" value="<?php echo $InsPago->PagNumeroTransaccion;?>" size="30" maxlength="45" /></td>
            <td>Fecha Transaccion:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td><span id="sprytextfield">
            <label>
              <input class="EstFormularioCajaFecha" name="CmpFechaTransaccion" type="text" id="CmpFechaTransaccion" value="<?php  echo $InsPago->PagFechaTransaccion;?>" size="15" maxlength="10" />
            </label>
            <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span>
            
            <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaTransancion" name="BtnFechaTransancion" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
            
            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Monto:</td>
            <td align="left" valign="top"><span id="sprytextfield4">
              <input class="EstFormularioCaja" name="CmpMonto" type="text" id="CmpMonto" value="<?php echo number_format($InsPago->PagMonto,2);?>" size="10" maxlength="10" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observacion Interna:</td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpObservacion" id="CmpObservacion" cols="45" rows="3"><?php echo $InsPago->PagObservacion;?></textarea></td>
            <td align="left" valign="top">Observacion Impresa:</td>
            <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="3" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsPago->PagObservacionImpresa;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2" align="left" valign="top">Concepto (Para imprimir en recibo):</td>
            <td rowspan="2" align="left" valign="top"><textarea name="CmpConcepto" cols="45" rows="4" class="EstFormularioCaja" id="CmpConcepto"><?php echo $InsPago->PagConcepto;?></textarea></td>
            <td colspan="2" align="left" valign="top">Archivo Escaneado:</td>
            <td rowspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top"><iframe src="formularios/Pago/acc/AccPagoSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrPagoSubirArchivo" name="IfrPagoSubirArchivo" scrolling="Auto"  frameborder="0" width="450" height="200"></iframe></td>
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
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
Calendar.setup({ 
	inputField : "CmpFechaTransaccion",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaTransaccion"// el id del botón que  
	});
	
	
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}

?>

