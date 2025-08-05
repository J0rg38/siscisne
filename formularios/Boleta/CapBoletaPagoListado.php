<?php

session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();

?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado")){
?>

 
 
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */
 
$GET_BolId = $_POST['BolId'];
$GET_BtaId = $_POST['BtaId'];


$GET_VdiId = $_POST['VentaDirectaId'];
$GET_OvvId = $_POST['OrdenVentaVehiculoId'];
$GET_PagId = $_POST['PagoId'];
$GET_FinId = $_POST['FichaIngresoId'];

		 
if(empty($GET_BolId) and empty($GET_BtaId) and empty($GET_VdiId) and empty($GET_OvvId) and empty($GET_PagId) and empty($GET_FinId)){
	die("No se encontro datos del comprobante u orden");
}

//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

//INSTANCAS
$InsPago = new ClsPago();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsBoleta = new ClsBoleta();


//MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
 
$ResCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaId","ASC",NULL,1);
$ArrCondicionPagos = $ResCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


//deb($InsBoleta->VdiId);
?> 
<!-- <span class="EstFormularioTitulo">OTROS ABONOS RELACIONADOS</span> 
 -->
 
  <?php
//deb($InsBoleta->VdiId);
if(!empty($GET_BolId) and !empty($GET_BtaId)){
		
	$InsBoleta->BolId = $GET_BolId;
	$InsBoleta->BtaId = $GET_BtaId;
	$InsBoleta->MtdObtenerBoleta(false);
	
	$POST_Moneda = $InsBoleta->MonId;
	
	$InsPago->UsuId = $_SESSION['SesionId'];
	//deb($InsBoleta)//;
	
	//DATOS
	//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL)
	
	//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL) 
	$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,BolId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,$GET_BolId,$GET_BtaId);
	$ArrPagos = $ResPago['Datos'];
	
	$PagosTotal = $ResPago['Total'];
	$PagosTotalSeleccionado = $ResPago['TotalSeleccionado'];
	
?>
<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th  >FECHA</th>
                <th  >REF</th>
                <th  >MONTO</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="4" align="center">

			    </td>
              </tr>
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

				$TotalAbonos = 0;
				$TotalOrdenCobros = 0;
				
								foreach($ArrPagos as $dat){

								?>

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"    ><?php echo $dat->PagFecha; ?></td>
                <td align="right" valign="middle"    ><?php echo $dat->PagNumeroRecibo;  ?>
				
				<a href="javascript:FncPagoVistaPreliminar('<?php echo $dat->PagId;?>','<?php echo $dat->PagTipo;?>');">
				
				<?php echo $dat->PagId;  ?></a></td>
                <td    align="right" ><?php echo ($dat->MonSimbolo);?>
                  <?php $dat->PagMonto = (($dat->PagMonto/(empty($dat->PagTipoCambio)?1:$dat->PagTipoCambio)));?>
                <?php echo number_format($dat->PagMonto,2); ?></td>
              </tr>

              <?php		
			  
			  if($dat->PagEstado == 1){
				  $TotalOrdenCobros += $dat->PagMonto;
			  }
			  
			  if($dat->PagEstado == 3){
				  $TotalAbonos += $dat->PagMonto;
			  }
			  
			  
			  $f++;

									}

									?>
                                    
		
  </tbody>
      </table>
      


<?php
}
?> 

<?php
if(!empty($GET_FinId) and empty($GET_VdiId)){
	
	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $GET_FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso(false);
	
	$InsVentaDirecta = new ClsVentaDirecta();
	//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oFichaIngreso=NULL,$oTieneGenerarVentaConcretada=false,$oPersonal=NULL,$oConCodigoExterno=0,$oSucursal=NULL)
	$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,"VdiTiempoCreacion","DESC","10",NULL,NULL,$POST_estado,0,NULL,NULL,$POST_Moneda,NULL,NULL,$POST_PedidoCompra,$POST_VentaConcretada,NULL,NULL,NULL,false,NULL,NULL,NULL,NULL,$GET_FinId,false,$POST_Personal,0,$POST_Sucursal);
	$ArrVentaDirectas = $ResVentaDirecta['Datos'];
	
	if(!empty($ArrVentaDirectas)){
		foreach($ArrVentaDirectas as $DatVentaDirecta){
			
			$GET_VdiId = $DatVentaDirecta->VdiId;
			
		}
	}

}


?>
 
  <?php
//deb($InsBoleta->VdiId);
if(!empty($GET_OvvId)){
?>
<!-- <span class="EstFormularioSubTitulo">ORDENES DE VENTA DE VEHICULO</span>-->
<?php	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $GET_OvvId ;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);
	
	
		$InsPago = new ClsPago();
		$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,$GET_OvvId,$POST_CondicionPago,$POST_Moneda);
		
		$ArrPagos = $ResPago['Datos'];
?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >
      <thead class="EstTablaListadoHead">
        <tr>
          <th >#</th>
          <th  >FECHA</th>
          <th  >REF</th>
          <th  >COMPRBOB.</th>
          <th  >MONTO</th>
          </tr>
        </thead>
      <tfoot class="EstTablaListadoFoot">
        </tfoot>
      <tbody class="EstTablaListadoBody">
        <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;


				$TotalAbonos = 0;
				$TotalOrdenCobros = 0;
				
				
								foreach($ArrPagos as $dat){

								?>
        <tr id="Fila_<?php echo $f;?>2">
          <td align="center"  ><?php echo $f;?></td>
          <td align="right" valign="middle"   ><?php echo $dat->PagFecha; ?></td>
          <td align="right" valign="middle"   ><?php echo $dat->PagNumeroRecibo;  ?>
		  <a href="javascript:FncPagoVistaPreliminar('<?php echo $dat->PagId;?>','<?php echo $dat->PagTipo;?>');">
		  <?php echo $dat->PagId;  ?></a></td>
          <td align="right" ><?php echo $dat->PagComprobanteVenta;  ?></td>
          <td align="right" ><?php echo ($dat->MonSimbolo);?>
            <?php $dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
            <?php echo number_format($dat->PagMonto,2); ?></td>
          </tr>
        <?php		
			  
			  
			    
			 
			  
			  
			  
			  $f++;

									}

									?>
        </tbody>
      </table>
    <?php

	
}else if($GET_VdiId){
?>

<!--
<span class="EstFormularioSubTitulo">ORDENES DE VENTA (VENTAS X MOSTRADOR) </span>-->
<?php

$InsVentaDirecta = new ClsVentaDirecta();
$InsVentaDirecta->VdiId = $GET_VdiId;
$InsVentaDirecta->MtdObtenerVentaDirecta(false);

$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,"",$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda);
$ArrPagos = $ResPago['Datos'];
	
?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th >#</th>
                <th  >FECHA</th>
                <th  >REF</th>
                <th  >COMPRBOB.</th>
                <th  >MONTO</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php


							$pagina = explode(",",$POST_pag);
							$f=$pagina[0]+1;
							
							$TotalAbonos = 0;
							$TotalOrdenCobros = 0;
				
								foreach($ArrPagos as $dat){

								?>

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->PagFecha; ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->PagNumeroRecibo;  ?>
				<a href="javascript:FncPagoVistaPreliminar('<?php echo $dat->PagId;?>','<?php echo $dat->PagTipo;?>');">
				<?php echo $dat->PagId;  ?></a></td>
                <td align="right" ><?php echo $dat->PagComprobanteVenta;  ?></td>
                <td align="right" >
                  
                  
                  <?php echo ($dat->MonSimbolo);?>
                  <?php $dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                  
                  
                <?php echo number_format($dat->PagMonto,2); ?></td>
              </tr>

              <?php		
			  
			  
			    
			 
			  
			  
			  
			  $f++;

									}

									?>
  </tbody>
</table>
      
<?php	
}else{
?>
No se encontraron otros abonos relacionados
<?php	
}
?> 

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

