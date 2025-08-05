<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Ver")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoVentaDirectaAbonoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsCuentaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsTarjetaFunciones.js" ></script>


<?php
//VARIABLES
$GET_id = $_GET['Id'];
$GET_VdiId = $_GET['VdiId'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$Edito = false;
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPagoVentaDirectaAbono.php');
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

$InsVentaDirecta->VdiId = $GET_VdiId;
$InsVentaDirecta->MtdObtenerVentaDirecta(false);

//ACCIONES
$VentaDirectaId = "";
	
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoVentaDirectaAbonoEditar.php');

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

$ResTarjeta = $InsTarjeta->MtdObtenerTarjetas(NULL,NULL,'TarId','Desc',NULL,NULL,$InsVentaDirecta->MonId);
$ArrTarjetas = $ResTarjeta['Datos'];


//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha") 

$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda);
$ArrPagos = $ResPago['Datos'];
?>

<div class="EstCapMenu">

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">HISTORIAL DE 
        ABONOS</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
               
<ul class="tabs">
   
    <li><a href="#tab2">Historial</a></li>

</ul>
<div class="tab_container">

    
    <div id="tab2" class="tab_content">
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
$OtraMonedaId = "";

foreach($ArrPagos as $DatPago){
	$OtraMonedaSimbolo = $DatPago->MonSimbolo;
	$OtraMonedaId = $DatPago->MonId;
	break;
}
?>
               <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
                 <thead class="EstTablaListadoHead">
                   <tr>
                     <th width="4%" >#</th>
                     <th width="4%" >Id</th>
                     <th width="6%" >Ord. Ven. </th>
                     <th width="5%" >Fecha</th>
                     <th width="9%" >Num. Recibo.</th>
                     <th width="9%" >Num. Operacion</th>
                     <th width="9%" >Fecha Operacion</th>
                     <th width="8%" >Moneda</th>
                     <th width="8%" >T.C.</th>
                     <th width="8%" >Estado</th>
                     
                     
                     <?php
					 if($OtraMonedaId <> $EmpresaMonedaId){
					?>
                     <th width="14%" >Monto (<?php echo $OtraMonedaSimbolo;?>)</th>
                    <?php 
					 }
					 ?>
                     <th width="16%" >Monto (<?php echo $EmpresaMoneda;?>)</th>
                     
                   </tr>
                 </thead>
                 <tfoot class="EstTablaListadoFoot">
                 </tfoot>
                 <tbody class="EstTablaListadoBody">
                   <?php




				
$f= 1;

				$TotalAbonos = 0;
				$TotalOrdenCobros = 0;
				
				
				$TotalPagoMonedaOtra = 0;
				$TotalPagoMoneda = 0;
				
				
								foreach($ArrPagos as $dat){

								?>
                   <tr id="Fila_<?php echo $f;?>">
                     <td width="4%" align="center"  ><?php echo $f;?></td>
                     <td align="right" valign="middle" width="4%"   ><?php echo $dat->PagId;  ?></td>
                     <td align="right" valign="middle" width="6%"   ><?php echo $dat->VdiId;  ?></td>
                     <td  width="5%" align="right" ><?php echo $dat->PagFecha; ?></td>
                     <td  width="9%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                     <td  width="9%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                     <td  width="9%" align="right" ><?php echo $dat->PagFechaTransaccion;  ?></td>
                     <td align="right" ><?php echo ($dat->MonNombre);?></td>
                     <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                     <td  width="8%" align="right" ><?php echo ($dat->PagEstadoDescripcion);?></td>
                    
<?php $MontoOriginal = $dat->PagMonto;?>               
<?php $dat->PagMonto = (($EmpresaMonedaId==$dat->MonId or empty($dat->MonId))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>

                      <?php
					 if($OtraMonedaId <> $EmpresaMonedaId){
					?>
                    
                     <td  width="14%" align="right" >
					 
<?php echo number_format($dat->PagMonto,2); ?>

                       </td>
                       <?php
					 }
					   ?>
                       
                     <td  width="16%" align="right" ><?php //$dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                       <?php echo number_format($MontoOriginal,2); ?></td>
                   </tr>
                   <?php		
			  
			  
			    
			  if($dat->PagEstado == 1){
				  $TotalOrdenCobros += $dat->PagMonto;
			  }
			  
			  if($dat->PagEstado == 3){
				  $TotalAbonos += $dat->PagMonto;
			  }
			  
			  $TotalPagoMonedaOtra += $dat->PagMonto;
			  $TotalPagoMoneda += $MontoOriginal;
			  
			  $f++;

									}

									?>

<?php

$SaldoOtraMoneda = $InsPago->VdiTotal - $TotalPagoMonedaOtra;


$SaldoMoneda = $TotalOriginal - $TotalPagoMoneda;

?>
                   <tr>
                     <td colspan="10" align="right"  >TOTAL:</td>

					<?php
					 if($OtraMonedaId <> $EmpresaMonedaId){
					?>
                     <td align="right" ><?php echo $OtraMonedaSimbolo;?> <?php echo number_format($TotalPagoMonedaOtra,2);?></td>
                     <?php
					 }
					 ?>
                     
                     <td align="right" ><?php echo $EmpresaMoneda;?> <?php echo number_format($TotalPagoMoneda,2);?></td>
                   </tr>
                   <tr>
                     <td colspan="10" align="right"  >TOTAL DE LA ORDEN:</td>
                     
                       <?php
					 if($OtraMonedaId <> $EmpresaMonedaId){
					?>
                     <td align="right" >
                     <?php echo $OtraMonedaSimbolo;?> <?php echo number_format($InsPago->OvvTotal,2);?>
                     
                     
                     </td>
                     <?php
					 }
					 ?>
                     <td align="right" >
                     <?php echo $EmpresaMoneda;?>
                     <?php
					 echo number_format($TotalOriginal,2);
					 ?>
                     </td>
                   </tr>
                   <tr>
                     <td colspan="10" align="right"  >SALDO:</td>

  <?php
					 if($OtraMonedaId <> $EmpresaMonedaId){
					?>
                     <td align="right" ><?php echo $OtraMonedaSimbolo;?> <?php echo number_format($SaldoOtraMoneda,2);?></td>
                     <?php
                     }
                     ?>
                     
                     <td align="right" >  <?php echo $EmpresaMoneda;?>                       <?php
					 echo number_format($SaldoMoneda,2);
					 ?></td>
                   </tr>
                   <tr>
                     <td colspan="10" align="right"  >&nbsp;</td>
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


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".(!empty($GET_NMod)?$GET_NMod:$GET_mod)."&Form=Listado",$Edito,1500);
	}
		
}

?>

