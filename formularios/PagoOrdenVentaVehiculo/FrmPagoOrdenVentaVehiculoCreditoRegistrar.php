<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoOrdenVentaVehiculoCreditoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>


<?php
$GET_OvvId = $_GET['OvvId'];
$GET_FtaId = $_GET['FtaId'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}


$Registro = false;
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPagoOrdenVentaVehiculoCredito.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
//INSTANCIAS
$InsPago = new ClsPago();
$InsMoneda = new ClsMoneda();
$InsCondicionPago = new ClsCondicionPago();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsArea = new ClsArea();
$InsTipoDocumento = new ClsTipoDocumento();
$InsFormaPago = new ClsFormaPago();
$InsBanco = new ClsBanco();
$InsPersonal = new ClsPersonal();

$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);

//ACCIONES
$OrdenVentaVehiculoId = "";

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoOrdenVentaVehiculoCreditoRegistrar.php');

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

//MtdObtenerAreas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","Desc",NULL,1);
$ArrAreas = $ResArea['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

// MtdObtenerFormaPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,NULL);
$ArrFormaPagos = $ResFormaPago['Datos'];

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,NULL);
$ArrBancos = $ResBanco['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,$GET_OvvId,$POST_CondicionPago,$POST_Moneda);
$ArrPagos = $ResPago['Datos'];
?>





<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">	

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
        <td  height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR CREDITO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
       
<ul class="tabs">
    <li><a href="#tab1">Abono</a></li>
   <!-- <li><a href="#tab2">Historial</a></li>-->

</ul>
<div class="tab_container">
    <div id="tab1" class="tab_content">
    <!--Content-->     
    
    
        <div class="EstFormularioArea">
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><span class="EstFormularioSubTitulo">Datos del Credito
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:
              <input name="CmpTipo" type="hidden" id="CmpTipo" value="FAC" />
              <input name="CmpOrdenVentaVehiculoId" type="hidden" id="CmpOrdenVentaVehiculoId" value="<?php echo $OrdenVentaVehiculoId;?>" />
              <input name="CmpOrdenVentaVehiculoTalonarioId" type="hidden" id="CmpOrdenVentaVehiculoTalonarioId" value="<?php echo $OrdenVentaVehiculoTalonarioId;?>" />
              <input name="CmpOrdenVentaVehiculoTalonarioNumero" type="hidden" id="CmpOrdenVentaVehiculoTalonarioNumero" value="<?php echo $OrdenVentaVehiculoTalonarioNumero;?>" /></td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPago->PagId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>Archivo Escaneado:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Orden de Venta de Vehiculo:</td>
            <td align="left" valign="top"><input name="CmpOrdenVentaVehiculo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculo" value="<?php echo $OrdenVentaVehiculoId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td rowspan="12" align="left" valign="top"><iframe src="formularios/PagoOrdenVentaVehiculo/acc/AccPagoOrdenVentaVehiculoSubirArchivo2.php?Identificador=<?php echo $Identificador;?>" id="IfrPagoOrdenVentaVehiculoSubirArchivo2" name="IfrPagoOrdenVentaVehiculoSubirArchivo2" scrolling="auto"  frameborder="0" width="310" height="200"></iframe></td>
            <td rowspan="12" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente:              </td>
            <td align="left" valign="top"><input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsPago->CliId;?>" />              <input name="CmpClienteNombre" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre" value="<?php echo $InsPago->CliNombre;?> <?php echo $InsPago->CliApellidoPaterno;?> <?php echo $InsPago->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" /></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo Doc.:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
              <option value="">Escoja una opcion</option>
              <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
              <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsPago->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
              <?php
	}
	?>
            </select></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Num. Doc.:</td>
            <td align="left" valign="top"><input name="CmpClienteNumeroDocumento" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteNumeroDocumento" value="<?php echo $InsPago->CliNumeroDocumento;?>" size="20" maxlength="20" readonly="readonly" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsPago->PagFecha;?>" size="15" maxlength="10" />              <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
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
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Aprobado por:</td>
            <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
              <option <?php echo ($DatPersonal->PerId==$InsPago->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
              <?php
					}
					?>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Entidad Financiera:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpBanco" id="CmpBanco">
              <option value="">Escoja una opcion</option>
              <?php
				foreach($ArrBancos as $DatBanco){
				?>
              <option <?php echo ($InsPago->BanId == $DatBanco->BanId)?'selected="selected"':''; ?> value="<?php echo $DatBanco->BanId?>"><?php echo $DatBanco->BanNombre; ?></option>
              <?php
				}
				?>
              </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" >
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo de Cambio: <br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table>
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsPago->PagTipoCambio)){ echo "";}else{ echo $InsPago->PagTipoCambio; } ?>" size="10" maxlength="10" /></td>
                <td><a href="javascript:FncPagoOrdenVentaVehiculoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                </tr>
            </table></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Total de la Orden:</td>
            <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoTotal" value="<?php echo number_format($InsPago->OvvTotal,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Observacion Interna:
              <input name="CmpConcepto" type="hidden" id="CmpConcepto" value="<?php echo $InsPago->PagConcepto;?>" /></td>
            <td><textarea class="EstFormularioCaja" name="CmpObservacion" id="CmpObservacion" cols="35" rows="4"><?php echo $InsPago->PagObservacion;?></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>


  
    </div>
    
    <?php
	/*
	?>
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
               
               
               <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="5%" >#</th>
                <th width="6%" >Id</th>
                <th width="8%" >Ord. Ven. Veh.</th>
                <th width="12%" >Num. Recibo.</th>
                <th width="12%" >Num. Operacion</th>
                <th width="6%" >Fecha</th>
                <th width="8%" >Moneda</th>
                <th width="4%" >T.C.</th>
                <th width="10%" >Estado</th>
                <th width="14%" >Monto Otra Moneda</th>
                <th width="15%" >Monto <?php echo $EmpresaMoneda;?></th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
              </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




				$SaldoMoneda = 0;
				$SaldoMonedaOtra = 0;
				
				$TotalPagoMonedaOtra = 0;
				$TotalPagoMoneda = 0;
				
				$f= 1;
								foreach($ArrPagos as $dat){

								?>

            

             
              <tr id="Fila_<?php echo $f;?>">
                <td width="5%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="6%"   ><?php echo $dat->PagId;  ?></td>
                <td align="right" valign="middle" width="8%"   ><?php echo $dat->OvvId;  ?></td>
                <td  width="12%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                <td  width="12%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->PagFecha; ?></td>
                <td align="right" ><?php echo ($dat->MonNombre);?></td>
                <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                <td  width="10%" align="right" ><?php echo ($dat->PagEstadoDescripcion);?></td>
                <td  width="14%" align="right" >
                
                <?php 
				$MontoOriginal = $dat->PagMonto;
				?>
                <?php $dat->PagMonto = (($EmpresaMonedaId==$dat->MonId or empty($dat->MonId))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                  
                  
                  <?php echo number_format($dat->PagMonto,2); ?>
                  
                  
                </td>
                <td  width="15%" align="right" >
                  
                  
                  <?php //$dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                  
                  
                  <?php echo number_format($MontoOriginal,2); ?></td>
                </tr>

              <?php		
			  
			  

			  
			 
				$TotalPagoMoneda += $MontoOriginal;
				$TotalPagoMonedaOtra += $dat->PagMonto;
			   
			  $f++;

									}



				$SaldoMoneda = $TotalOrdenOriginal - $TotalPagoMoneda;
				$SaldoMonedaOtra = $InsOrdenVentaVehiculo->OvvTotal - $TotalPagoMonedaOtra;
				
				
									?>
            
            
              <tr>
                <td colspan="9" align="right"  >TOTAL ABONO/ORD. COBRO:</td>
                <td align="right" > <?php echo number_format($TotalPagoMonedaOtra,2);?></td>
                <td align="right" >
                
				
				<?php echo number_format($TotalPagoMoneda,2);?>
                </td>
              </tr>
              <tr>
                <td colspan="9" align="right"  >TOTAL DE LA ORDEN:</td>
                <td align="right" >
                
                <?php echo number_format($InsPago->OvvTotal,2);?>
                
                </td>
                <td align="right" >&nbsp;</td>
              </tr>
              <tr>
                <td colspan="9" align="right"  >SALDO:</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
              </tr>
              
              </tbody>
      </table>
      
      
      
      
      
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
  <?php
	*/
	?>
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
</script>

<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".(!empty($GET_NMod)?$GET_NMod:$GET_mod)."&Form=Listado",$Registro,1500);
	}
		
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
