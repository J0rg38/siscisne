<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Ver")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoOrdenVentaVehiculoAbonoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Editar"))?true:false;?>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$GET_OvvId = $_GET['OvvId'];
$GET_FtaId = $_GET['FtaId'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPagoOrdenVentaVehiculoAbono.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTarjeta.php');

//INSTANCIAS
$InsPago = new ClsPago();
$InsMoneda = new ClsMoneda();
$InsCondicionPago = new ClsCondicionPago();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsArea = new ClsArea();
$InsTipoDocumento = new ClsTipoDocumento();
$InsFormaPago = new ClsFormaPago();
$InsCuenta = new ClsCuenta();
$InsTarjeta = new ClsTarjeta();

$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);

//ACCIONES
$OrdenVentaVehiculoId = "";

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoOrdenVentaVehiculoAbonoEditar.php');

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","Desc",NULL,1);
$ArrAreas = $ResArea['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,NULL);
//$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,1);
$ArrFormaPagos = $ResFormaPago['Datos'];


$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsPago->MonId);
$ArrCuentas = $ResCuenta['Datos'];

$ResTarjeta = $InsTarjeta->MtdObtenerTarjetas(NULL,NULL,'TarId','Desc',NULL,NULL);
$ArrTarjetas = $ResTarjeta['Datos'];

$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,$GET_OvvId,$POST_CondicionPago,$POST_Moneda);
$ArrPagos = $ResPago['Datos'];

$TotalOriginal = $InsOrdenVentaVehiculo->OvvTotal;

?>
<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=AbonoEditar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsPago->PagId;?>&OvvId=<?php echo $_GET['OvvId'];?>&NMod=<?php echo $GET_NMod;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
    <li><a href="#tab2">Historial</a></li>

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
              <input name="CmpTipo" type="hidden" id="CmpTipo" value="FAC" />
              <input name="CmpOrdenVentaVehiculoId" type="hidden" id="CmpOrdenVentaVehiculoId" value="<?php echo $OrdenVentaVehiculoId;?>" />
              <input name="CmpOrdenVentaVehiculoTalonarioId" type="hidden" id="CmpOrdenVentaVehiculoTalonarioId" value="<?php echo $OrdenVentaVehiculoTalonarioId;?>" />
              <input name="CmpOrdenVentaVehiculoTalonarioNumero" type="hidden" id="CmpOrdenVentaVehiculoTalonarioNumero" value="<?php echo $OrdenVentaVehiculoTalonarioNumero;?>" /></td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPago->PagId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Orden de Venta de Vehiculo:</td>
            <td align="left" valign="top"><input name="CmpOrdenVentaVehiculo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculo" value="<?php echo $OrdenVentaVehiculoId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente: </td>
            <td align="left" valign="top"><input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsPago->CliId;?>" />              <input name="CmpClienteNombre" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre" value="<?php echo $InsPago->CliNombre;?> <?php echo $InsPago->CliApellidoPaterno;?> <?php echo $InsPago->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">Num. de Recibo:</td>
            <td align="left" valign="top"><input name="CmpNumeroRecibo" type="text"  class="EstFormularioCaja" id="CmpNumeroRecibo" value="<?php echo $InsPago->PagNumeroRecibo;?>" size="30" maxlength="45" /></td>
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
            <td align="left" valign="top">Fecha:<br />
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
                <td><a href="javascript:FncPagoOrdenVentaVehiculoEstablecerMoneda();"></a></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Forma de Pago:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrFormaPagos as $DatFormaPago){
				?>
              <option <?php echo ($InsPago->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
              <?php
			  }
			  
			  ?>
            </select></td>
            <td align="left" valign="top">Cantidad de Letras:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCantidadLetras" type="text" id="CmpCantidadLetras" value="<?php echo number_format($InsPago->PagCantidadLetras,2);?>" size="10" maxlength="10" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cuenta:</td>
            <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpCuentaId" id="CmpCuentaId">
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
            <td align="left" valign="top">Num. de Operacion:</td>
            <td align="left" valign="top"><input name="CmpNumeroTransaccion" type="text"  class="EstFormularioCaja" id="CmpNumeroTransaccion" value="<?php echo $InsPago->PagNumeroTransaccion;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">Fecha Transaccion:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFechaTransaccion" type="text" class="EstFormularioCajaFecha" id="CmpFechaTransaccion" value="<?php  echo $InsPago->PagFechaTransaccion;?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Total de la Orden:</td>
            <td align="left" valign="top"><input class="EstFormularioCajaDeshabilitada" name="CmpOrdenVentaVehiculoTotal" type="text" id="CmpOrdenVentaVehiculoTotal" value="<?php echo number_format($InsPago->OvvTotal,2);?>" size="10" maxlength="10" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Monto a abonar:</td>
            <td align="left" valign="top"><input name="CmpMonto" type="text" class="EstFormularioCaja" id="CmpMonto" value="<?php echo number_format($InsPago->PagMonto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td colspan="2" align="left" valign="top">Archivo Escaneado:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observacion Interna:
              <input name="CmpConcepto" type="hidden" id="CmpConcepto" value="<?php echo $InsPago->PagConcepto;?>" /></td>
            <td align="left" valign="top"><textarea name="CmpObservacion" cols="35" rows="3" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsPago->PagObservacion;?></textarea></td>
            <td colspan="2" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesPagFoto1'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesPagFoto1'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesPagFoto1'.$Identificador], '.'.$extension);  
?>
              Vista Previa:<br />
  <img  src="subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  <?php	
}else{
?>
              No hay FOTO
  <?php	
}
?></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Historial de Pagos</span></td>
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
$OtraMonedaSimbolo = "";
foreach($ArrPagos as $DatPago){
	$OtraMonedaSimbolo = $DatPago->MonSimbolo;
	break;
}
?>
               <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
                 <thead class="EstTablaListadoHead">
                   <tr>
                     <th width="5%" >#</th>
                     <th width="6%" >Id</th>
                     <th width="8%" >Ord. Ven. Veh.</th>
                     <th width="12%" >Num. Recibo.</th>
                     <th width="12%" >Num. Operacion</th>
                     <th width="6%" >Fecha Operacion</th>
                     <th width="9%" >Moneda</th>
                     <th width="4%" >T.C.</th>
                     <th width="6%" >Estado</th>
                     <th width="17%" >Monto (<?php echo $InsOrdenVentaVehiculo->MonSimbolo;?>)</th>
                     <th width="15%" bgcolor="#CCCCCC" >Monto (<?php echo $EmpresaMoneda;?>)</th>
                   </tr>
                 </thead>
                 <tfoot class="EstTablaListadoFoot">
                 </tfoot>
                 <tbody class="EstTablaListadoBody">
                   <?php




				
$f= 1;

//				$TotalAbonos = 0;
//				$TotalOrdenCobros = 0;
				
				
				$TotalPagoMonedaOtra = 0;
				$TotalPagoMoneda = 0;
				
				
								foreach($ArrPagos as $dat){

								?>
                   <tr id="Fila_<?php echo $f;?>">
                     <td width="5%" align="center"  ><?php echo $f;?></td>
                     <td align="right" valign="middle" width="6%"   ><?php echo $dat->PagId;  ?></td>
                     <td align="right" valign="middle" width="8%"   ><?php echo $dat->OvvId;  ?></td>
                     <td  width="12%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                     <td  width="12%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                     <td  width="6%" align="right" ><?php echo $dat->PagFechaTransaccion; ?></td>
                     <td align="right" ><?php echo ($dat->MonNombre);?></td>
                     <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                     <td  width="6%" align="right" ><?php echo ($dat->PagEstadoDescripcion);?></td>
                     <td  width="17%" align="right" ><?php $MontoOriginal = $dat->PagMonto;?>
                       <?php $dat->PagMonto = (($EmpresaMonedaId==$InsOrdenVentaVehiculo->MonId)?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                       <?php //$dat->PagMonto = (($EmpresaMonedaId==$dat->MonId or empty($dat->MonId))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                       <?php echo number_format($dat->PagMonto,2); ?></td>
                     <td  width="15%" align="right" bgcolor="#CCCCCC" ><?php //$dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                       <?php echo number_format($MontoOriginal,2); ?></td>
                   </tr>
                   <?php		
			  
			  
			    
//			  if($dat->PagEstado == 1){
//				  $TotalOrdenCobros += $dat->PagMonto;
//			  }
//			  
//			  if($dat->PagEstado == 3){
//				  $TotalAbonos += $dat->PagMonto;
//			  }
			  
			  $TotalPagoMonedaOtra += $dat->PagMonto;
			  $TotalPagoMoneda += $MontoOriginal;
			  
			  $f++;

									}

									?>

<?php

$SaldoOtraMoneda = $InsPago->OvvTotal - $TotalPagoMonedaOtra;


$SaldoMoneda = $TotalOriginal - $TotalPagoMoneda;

?>
                   <tr>
                     <td colspan="9" align="right"  >TOTAL:</td>
                     <td align="right" ><?php echo $InsOrdenVentaVehiculo->MonSimbolo;?> <?php echo number_format($TotalPagoMonedaOtra,2);?></td>
                     <td align="right" bgcolor="#CCCCCC" ><?php echo $EmpresaMoneda;?> <?php echo number_format($TotalPagoMoneda,2);?></td>
                   </tr>
                   <tr>
                     <td colspan="9" align="right"  >TOTAL DE LA ORDEN:</td>
                     <td align="right" >
					 
					 <?php echo $InsOrdenVentaVehiculo->MonSimbolo;?> <?php echo number_format($InsPago->OvvTotal,2);?></td>
                     <td align="right" bgcolor="#CCCCCC" >
                       <?php echo $EmpresaMoneda;?>
                       <?php echo number_format($TotalOriginal,2);?>
                     </td>
                   </tr>
                   <tr>
                     <td colspan="9" align="right"  >SALDO:</td>
                     <td align="right" >

<?php echo $InsOrdenVentaVehiculo->MonSimbolo;?> <?php echo number_format($SaldoOtraMoneda,2);?>

</td>
                     <td align="right" bgcolor="#CCCCCC" >  <?php echo $EmpresaMoneda;?>                       <?php
					 echo number_format($SaldoMoneda,2);
					 ?></td>
                   </tr>
                   <tr>
                     <td colspan="9" align="right"  >&nbsp;</td>
                     <td align="right" >&nbsp;</td>
                     <td align="right" >&nbsp;</td>
                   </tr>
                 </tbody>
               </table></td>
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


