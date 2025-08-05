<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Ver")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoFacturaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>


<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Editar"))?true:false;?>

<?php
//VARIABLES
$GET_id = $_GET['Id'];



//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPago.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');

require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTarjeta.php');

//INSTANCIAS
$InsPago = new ClsPago();
$InsMoneda = new ClsMoneda();
$InsCondicionPago = new ClsCondicionPago();
$InsFactura = new ClsFactura();
$InsArea = new ClsArea();
$InsTipoDocumento = new ClsTipoDocumento();
$InsFormaPago = new ClsFormaPago();
$InsCuenta = new ClsCuenta();
$InsTarjeta = new ClsTarjeta();

//ACCIONES


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoEditar.php');

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","Desc",NULL,1);
$ArrAreas = $ResArea['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,1);
$ArrFormaPagos = $ResFormaPago['Datos'];


$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsPago->MonId);
$ArrCuentas = $ResCuenta['Datos'];

$ResTarjeta = $InsTarjeta->MtdObtenerTarjetas(NULL,NULL,'TarId','Desc',NULL,NULL);
$ArrTarjetas = $ResTarjeta['Datos'];

//MtdObtenerCuentas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CueId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oMoneda=NULL)

?>


<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsPago->PagId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        ABONO</span></td>
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
    <li><a href="#tab2">Archivo</a></li>

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
            <td align="left" valign="top">C&oacute;digo Interno:
              <input name="CmpTipo" type="hidden" id="CmpTipo" value="FAC" /></td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPago->PagId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente: </td>
            <td align="left" valign="top"><input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsPago->CliId;?>" />              <input name="CmpClienteNombre" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre" value="<?php echo $InsPago->CliNombre;?> <?php echo $InsPago->CliApellidoPaterno;?> <?php echo $InsPago->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
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
            <td align="left" valign="top">Fecha de abono:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsPago->PagFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">Area Destino:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAreaId" id="CmpAreaId">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrAreas as $DatArea){
				?>
              <option <?php echo ($InsPago->AreId == $DatArea->AreId)?'selected="selected"':''; ?>  value="<?php echo $DatArea->AreId?>"><?php echo $DatArea->AreNombre ?></option>
              <?php
			  }
			  
			  ?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled" >
                  <option value="">Escoja una opcion</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsPago->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                  </select></td>
                <td><div id="CapMonedaBuscar"></div></td>
                </tr>
              </table></td>
            <td align="left" valign="top">Tipo de Cambio: <br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table>
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncPagoDetalleListar();" value="<?php if (empty($InsPago->PagTipoCambio)){ echo "";}else{ echo $InsPago->PagTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
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
              <option <?php echo ($InsPago->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
              <?php
			  }
			  
			  ?>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Num. de Recibo:</td>
            <td align="left" valign="top"><input name="CmpNumeroRecibo" type="text"  class="EstFormularioCaja" id="CmpNumeroRecibo" value="<?php echo $InsPago->PagNumeroRecibo;?>" size="30" maxlength="45" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Monto a abonar:</td>
            <td align="left" valign="top"><input name="CmpMonto" type="text" class="EstFormularioCaja" id="CmpMonto" value="<?php echo number_format($InsPago->PagMonto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observacion Interna:</td>
            <td align="left" valign="top"><textarea readonly="readonly" class="EstFormularioCaja" name="CmpObservacion" id="CmpObservacion" cols="35" rows="3"><?php echo $InsPago->PagObservacion;?></textarea></td>
            <td align="left" valign="top">Concepto:</td>
            <td align="left" valign="top"><textarea readonly="readonly" class="EstFormularioCaja" name="CmpConcepto" id="CmpConcepto" cols="35" rows="3"><?php echo $InsPago->PagConcepto;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsPago->PagEstado){
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
              <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
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

	</div>
    
    
        <div id="tab2" class="tab_content">
    <!--Content-->     
    
       <!--Content-->
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
    <div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Archivo Escaneado</span></td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4">
               
               
   <?php              
              
if(!empty($_SESSION['SesPagFoto1'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesPagFoto1'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesPagFoto1'.$Identificador], '.'.$extension);  
?>
		        
		        Vista Previa:<br />
		        
		        <img  src="subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  <?php	
}else{
?>
		        No hay FOTO
  <?php	
}
?>        
               
               </td>
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
    
    </div>
    
    
    
</div>

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


