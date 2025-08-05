<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEditarId = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarId"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Especial"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>

<?php $PrivilegioPagoRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>
<?php $PrivilegioPagoListado = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>


<?php $PrivilegioVentaConcretadaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Ver"))?true:false;?>
<?php $PrivilegioFichaIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Ver"))?true:false;?>

<?php $PrivilegioVentaDirectaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioCotizacionProductoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","Ver"))?true:false;?>

<?php $PrivilegioCotizacionVehiculoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionVehiculo","Ver"))?true:false;?>
<?php $PrivilegioOrdenVentaVehiculoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","Ver"))?true:false;?>

<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>
<?php $PrivilegioRegistrarNotaCredito = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCredito","Registrar"))?true:false;?>


<?php $PrivilegioClienteEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Editar"))?true:false;?>
<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFactura.js"></script>



<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */

$POST_cam = ($_POST['Cam']);
$POST_fil = ($_POST['Fil']);

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord']);
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag']);
$POST_p = ($_POST['P']);
$POST_num = ($_POST['Num']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'];
$POST_acc = $_POST['Acc'];

/*
* Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_tal = $_POST['Talonario'];
$POST_Moneda = $_POST['Moneda'];
$POST_npago = $_POST['CondicionPago'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'FacTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

/*
* Otras variables
*/

if(empty($POST_finicio)){
$POST_finicio =  "01/01/".date("Y");
}

if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_estado)){
	$POST_estado = 0;
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFactura.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

$InsFactura = new ClsFactura();
$InsFacturaTalonario = new ClsFacturaTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();

$InsFactura->SucId = $_SESSION['SesionSucursal'];
$InsFactura->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFactura.php');

/*<select class="EstFormularioCombo" name="Cam" id="Cam">
	<option value="" <?php if($POST_cam=="FacId"){ echo 'selected="selected"';}?>>Id</option>
	<option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
	<option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>><span title="Numero de Documento">Num. Doc.</span> de Cliente</option>
    <option value="FacOrdenNumero" <?php if($POST_cam=="FacOrdenNumero"){ echo 'selected="selected"';}?>>Num. Orden</option>
    <option value="FacSIAFNumero" <?php if($POST_cam=="FacSIAFNumero"){ echo 'selected="selected"';}?>>Num. SIAF</option>
    <option value="FacTotal" <?php if($POST_cam=="FacTotal"){ echo 'selected="selected"';}?>>Total</option>
     </select>*/
     
$ResFactura = $InsFactura->MtdObtenerFacturas("Ftanumero,FacId,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,FacOrdenNumero,FacSIAFNumero,FacTotal,fac.AmoId,FinId,amo.VdiId,vdi.VdiOrdenCompraNumero,fac.OvvId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$_SESSION['SesionSucursal'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda);
     
//$ResFactura = $InsFactura->MtdObtenerFacturas($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$_SESSION['SesionSucursal'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda);
$ArrFacturas = $ResFactura['Datos'];
$FacturasTotal = $ResFactura['Total'];
$FacturasTotalSeleccionado = $ResFactura['TotalSeleccionado'];

$ResFacturaTalonario = $InsFacturaTalonario->MtdObtenerFacturaTalonarios(NULL,NULL,"FtaNumero","DESC",NULL,$_SESSION['SesionSucursal']);
$ArrFacturaTalonarios = $ResFacturaTalonario['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL);
$ArrCondicionPagos = $RepCondicionPago['Datos'];
	
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    


<div class="EstCapMenu">
<?php
if($PrivilegioGenerarExcel){
?>
	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 
<?php	  
}
?>

<?php
if($PrivilegioImprimir){
?>
	<div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
    <img src="imagenes/iconos/pendiente.png" alt="[Act. Pendiente]" title="Actualizar a estado PENDIENTE seleccionados" />Pendiente</a></div> 
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoEntregadoSeleccionados();">
    <img src="imagenes/iconos/entregado.png" alt="[Act. Entregado]" title="Actualizar a estado ENTREGADO seleccionados" />Entregado</a></div>
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/iconos/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoReservadoSeleccionados();">
    <img src="imagenes/iconos/reservado.png" alt="[Act. Reservado]" title="Actualizar a estado RESERVADO seleccionados" />Reservado</a></div>
<?php
}
?>

<?php
if($PrivilegioEliminar){
?>
	<div class="EstSubMenuBoton">
<a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar]" title="Eliminar elementos seleccionados" />Eliminar</a>
</div> <?php
}
?>

<?php
/*if($PrivilegioGenerarGuiaRemision){
?>
	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarGuiaRemisionSeleccionados();"><img src="imagenes/iconos/guiaremision.png" alt="[Generar Guia de Remision]"  title="Generar guia de remision con elementos seleccionados" />G. Rem.</a></div>
<?php
}
?>
<?php
if($PrivilegioRegistrarNotaCredito){
?>
	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarNotaCreditoSeleccionados();"><img src="imagenes/iconos/ncredito.png" alt="[Generar N. Credito]" title="Generar Nota de Credito con elementos"  />N. Credito</a></div>
    
<?php	
}*/
?>

</div>

<div class="EstCapContenido">



<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE FACTURAS</span>  </td>
</tr>
<tr>
  <td width="46%">
    Mostrando <b><?php echo $FacturasTotalSeleccionado;?></b> de <b><?php echo $FacturasTotal;?></b> registros.</td>
  <td width="54%" align="right">
  
  
    <!--<table border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td align="right">SubTotal <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></td>
        <td align="right"><div id="CapListadoSubTotal" ></div></td>
        <td align="right">| Impuesto <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></td>
        <td align="right"><div id="CapListadoImpuesto" ></div></td>
        <td align="right">| Total <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> </td>
        <td align="right"><div id="CapListadoTotal" > </div></td>
      </tr>
      </table>-->
      
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="21%" align="right" class="EstTablaTotalesEtiqueta">SUB TOTAL: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="17%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoSubTotal" ></div></td>
        <td width="19%" align="right" class="EstTablaTotalesEtiqueta">IMPUESTO: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="16%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoImpuesto" ></div></td>
        <td width="14%" align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="13%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoTotal" ></div></td>
      </tr>
      </table>
      
      </td>
  </tr>
<tr>
<td colspan="2" align="left">

		<input type="hidden" name="Acc" id="Acc" value="" />
        <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
        <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
        <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag;?>" />
        <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
        
        <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
        

          <span class="EstFormularioEtiqueta">Buscar:</span>

 <span class="EstFormularioContenido">  
     <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    </span>
    
        <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>


	<!--<select class="EstFormularioCombo" name="Cam" id="Cam">
	<option value="FacId" <?php if($POST_cam=="FacId"){ echo 'selected="selected"';}?>>Id</option>
	<option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
	<option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>><span title="Numero de Documento">Num. Doc.</span> de Cliente</option>
    <option value="FacOrdenNumero" <?php if($POST_cam=="FacOrdenNumero"){ echo 'selected="selected"';}?>>Num. Orden</option>
    <option value="FacSIAFNumero" <?php if($POST_cam=="FacSIAFNumero"){ echo 'selected="selected"';}?>>Num. SIAF</option>
    <option value="FacTotal" <?php if($POST_cam=="FacTotal"){ echo 'selected="selected"';}?>>Total</option>
     </select>--> <span class="EstFormularioEtiqueta">  
      Fecha Inicio:
      </span>
        <span class="EstFormularioContenido">  
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="8" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
  </span>
		  <span class="EstFormularioEtiqueta">  
    Fecha Fin:
    </span>
     <span class="EstFormularioContenido">  
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="8" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />	
</span>



<!--<br />-->
     Talonario:
     <select  class="EstFormularioCombo" name="Talonario" id="Talonario">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrFacturaTalonarios as $DatFacturaTalonario){
			  ?>
                  <option <?php if($POST_tal==$DatFacturaTalonario->FtaId){ echo 'selected="selected"';}?> 			  value="<?php echo $DatFacturaTalonario->FtaId;?>" ><?php echo $DatFacturaTalonario->FtaNumero;?></option>
                  <?php
			  }
			  ?>
          </select>
		Estado:
		<select class="EstFormularioCombo" name="Estado" id="Estado">
		<option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      	<option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
		<option value="5" <?php if($POST_estado==5){ echo 'selected="selected"';}?>>Entregado</option>
		<option value="6" <?php if($POST_estado==6){ echo 'selected="selected"';}?>>Anulado</option>
		<option value="7" <?php if($POST_estado==7){ echo 'selected="selected"';}?>>Reservado</option>       
		</select>
                  Moneda:
                  
                  <select class="EstFormularioCombo" name="Moneda" id="Moneda">
              <option value="">Todos</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_Moneda==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select>
       	<span title="Condicion de Pago">Cond. Pago:</span>	
		<select name="CondicionPago" id="CondicionPago" class="EstFormularioCombo" >
		<option value="">Todos</option>
		<?php
		foreach($ArrCondicionPagos as $DatCondicionPago){
		?>
		<option <?php if($POST_npago==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
		<?php  
		}
		?>
		</select>
		
       

		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>

<tr>
<td colspan="2">





<!--<div id="CapListado" >-->

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="1%" ><?php
				if($POST_ord == "FtaNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FtaNumero','ASC');"> - <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FtaNumero','DESC');"> - <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FtaNumero','ASC');"> - </a>
                <?php
				}
				?></th>

                <th width="2%" ><?php
				if($POST_ord == "FacId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FacId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> <span title="Numero de Documento">Num. Doc.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> <span title="Numero de Documento">Num. Doc.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> <span title="Numero de Documento">Num. Doc.</span> </a>
                <?php
				}
				?></th>
                <th width="11%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "FacFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacFechaEmision','ASC');"> Fecha  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacFechaEmision','DESC');"> Fecha  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FacFechaEmision','ASC');"> Fecha   </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "NpaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NpaNombre','ASC');"> <span title="Condicion de Pago">Cond. Pago</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NpaNombre','DESC');"> <span title="Condicion de Pago">Cond. Pago</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NpaNombre','ASC');"> <span title="Condicion de Pago">Cond. Pago</span> </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "MonNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MonNombre','DESC');"> Moneda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FacTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacTipoCambio','DESC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FacTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> </a>
                <?php
				}
				?></th>
                <th width="2%" ><?php
				if($POST_ord == "FacEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacEstado','ASC');"> <span title="Estado">Est.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacEstado','DESC');"> <span title="Estado">Est.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FacEstado','ASC');"> <span title="Estado">Est.</span>  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "FinId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> Ord. Trab./PDS <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinId','DESC');"> Ord. Trab./PDS <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> Ord. Trab./PDS </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "CprId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprId','ASC');"> Cot. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprId','DESC');"> Cot. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CprId','ASC');"> Cot. </a>
                <?php
				}
				?></th>
                <th width="1%" ><?php
				if($POST_ord == "VdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Ven. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiId','DESC');"> Ord. Ven. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Ven. </a>
                <?php
				}
				?></th>
                <th width="1%" ><?php
				if($POST_ord == "VdiOrdenCompraNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','DESC');"> Ref.  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> Ref.  </a>
                <?php
				}
				?></th>
                <th width="4%" > <?php
				if($POST_ord == "AmoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Mov. Alm. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoId','DESC');"> Mov. Alm. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Mov. Alm. </a>
                  <?php
				}
				?>
                </th>
                <th width="3%" ><?php
				if($POST_ord == "CveId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveId','ASC');"> Prof. Veh. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveId','DESC');"> Prof. Veh. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CveId','ASC');"> Prof. Veh. </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "OvvId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Ven. Veh. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvId','DESC');"> Ord. Ven. Veh. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Ven. Veh. </a>
                <?php
				}
				?></th>
                <th width="3%" >N. Cre.</th>
                <th width="3%" >Canc.</th>
                <th width="3%" ><?php
				if($POST_ord == "FacTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FacTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="1%" >Abonos</th>
                <th width="1%" ><?php
				if($POST_ord == "FacTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FacTotalItems','ASC');"> <span title="Items">It.</span> </a>
                <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "FacTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacTiempoCreacion','DESC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FacTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> </a>
                <?php
				}
				?></th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="25" align="center">

				Mostrar de
				<select class="EstFormularioCombo" onChange="javascript:FncListar(this.value);" name="Num" id="Num">
				  <option <?php if($POST_num=="5"){ echo 'selected="selected"';}?> value="5">5</option>
				  <option <?php if($POST_num=="10"){ echo 'selected="selected"';}?> value="10">10</option>
				  <option <?php if($POST_num=="15"){ echo 'selected="selected"';}?> value="15">15</option>
				  <option <?php if($POST_num=="20"){ echo 'selected="selected"';}?> value="20">20</option>
				  <option <?php if($POST_num=="25"){ echo 'selected="selected"';}?> value="25">25</option>
				  <option <?php if($POST_num=="30"){ echo 'selected="selected"';}?> value="30">30</option>
				  <option <?php if($POST_num=="50"){ echo 'selected="selected"';}?> value="50">50</option>
				  <option <?php if($POST_num=="100"){ echo 'selected="selected"';}?> value="100">100</option>
<option <?php if($POST_num=="125"){ echo 'selected="selected"';}?> value="125">125</option>
<option <?php if($POST_num=="150"){ echo 'selected="selected"';}?> value="150">150</option>

				  <option <?php if($POST_num==$FacturasTotal){ echo 'selected="selected"';}?> value="<?php echo $FacturasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $FacturasTotal;
					//}else{
					//	$tregistros = ($FacturasTotalSeleccionado);
					//}
					
					$cant_paginas=ceil($tregistros/$numxpag);
					?>



					<?php
					if($POST_p<>"1"){
					?>

					<a class="EstPaginacion" href="javascript:FncPaginar('0,<?php echo $numxpag;?>','1');">
					Inicio					</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<=$cant_paginas & $POST_p<>"1"){

					$pagina = explode(",",$POST_pag);

					?>
					<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]-$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p-1)?>');">Anterior</a>
					<?php
					}
					?>

					&nbsp;
					<?php
					$xpag =10;
					
					$inicio = 0;
					$fin = 0;
					
					if($POST_p-$xpag>0){
						$inicio = $POST_p-$xpag;
					}else{
						$inicio = $POST_p-($POST_p-$xpag*-1);
					}

					if($POST_p+$xpag<$cant_paginas){
						$fin = $POST_p+$xpag;
					}else{
						$fin = $POST_p+($POST_p-$xpag*-1);
					}
					?>
					<?php
					$num = 0;
					
					for($i=1;$i<=$cant_paginas;$i++){
					?>
						
                        <?php
						if($i>=$inicio and $i<=$fin){
						?>	
                        
                        <?php
						if($POST_p==$i){
						?>
                        <span class="EstPaginaActual"><?php echo $i;?></span>
                        <?php	
						}else{
						?>
	<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo $num?>,<?php echo $numxpag;?>','<?php echo $i?>');" ><?php echo $i?></a>                        
                        <?php	
						}
						?>

    					<?php
						}
						?>
					
					<?php
							$num = $num + $numxpag ;
					}
					?>

					&nbsp;
					<?php
					if($POST_p<$cant_paginas){
						$pagina = explode(",",$POST_pag);
					?>
						<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]+$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p+1)?>');">Siguiente</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<>$cant_paginas){
					?>
						<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Final</a>
					<?php
					}
					?>
					&nbsp;
						Pagina <?php echo $POST_p;?> de <?php echo $cant_paginas;?>                    </td>
              </tr>
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php


							$SumaSubTotal = 0;;
							$SumaImpuesto = 0;
							$SumaTotal = 0;


								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrFacturas as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->FacId."%".$dat->FtaId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->FacId."%".$dat->FtaId; ?>" cliente = "<?php echo $dat->CliId;?>" estado="<?php echo $dat->FacEstado; ?>" nota_credito="<?php echo $dat->FacNotaCredito;?>" />				</td>
                <td align="right" valign="middle"   ><?php echo $dat->FtaNumero;;  ?></td>

                <td align="right" valign="middle"   ><?php echo $dat->FacId;  ?></td>
                <td align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td align="right" >
				
                      
                     
     <?php
    if($PrivilegioClienteEditar or $PrivilegioClienteVer){
    ?>
                      <a href="javascript:FncClienteCargarFormulario('<?php echo (($PrivilegioClienteEditar)?'Editar':'Ver');?>','<?php echo $dat->CliId?>');"  ><?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?></a>
                      <?php
    }else{
    ?>
                      <?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?>
                      <?php	
    }
    ?>
                   
                
        
        
                
                </td>
                <td align="right" ><?php echo ($dat->FacFechaEmision);?></td>
                <td align="right" >
				
<span class="<?php	echo (($dat->NpaNombre=="CREDITO")?"EstImportante1":(($dat->NpaNombre=="CONTADO")?"EstImportante2":""));?>">
				<?php echo ($dat->NpaNombre);?>
                </span>
                
                </td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->FacTipoCambio);?></td>
                <td align="right" >
                  
                  <?php echo $dat->FacEstadoIcono; ?>
                  <?php echo $dat->FacEstadoDescripcion; ?>
                  
                  <?php 


				/*switch($dat->FacEstado){
					case 1:
				?>
                  <img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />
                  <?php	
				
				break;
										
					case 5:
				?>
                  
                  <img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />                
                  <?php	
					break;
					
					case 6:
				?>
                  
                  <img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />                
                  <?php	
					break;
					
					case 7:
				?>
                  
                  <img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />                
                <?php	
					break;
					
					
				}*/
				?>                </td>
                <td align="right" >
				
				
				<?php
				  if(!empty($dat->FinId)){
					  ?>
                      
                      
					<?php
					if($PrivilegioFichaIngresoVer){
					?>

                  <a href="javascript:FncFichaIngresoVistaPreliminar('<?php echo $dat->FinId;?>');"><?php echo $dat->FinId;?></a>            
                  <!--<a href="javascript:FncFichaIngresoCargarFormulario('Ver','<?php echo $dat->FinId;?>');"> <?php echo $dat->FinId;?> </a>          -->          
                    <?php	
					}else{
					?>
                    <?php echo $dat->FinId;?>
                    <?php	
					}
					?>

                  <?php
				  }else{
					?>
                  -
  <?php  
				  }
				  ?></td>
                <td align="right" >
				
				
				<?php
				 if($PrivilegioCotizacionProductoVer){
				?>
                  <!--<a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo $dat->CprId;?> ');"><?php echo $dat->CprId;?></a>-->
                  
                  <a href="javascript:FncCotizacionProductoVistaPreliminar('<?php echo $dat->CprId;?>');"><?php echo $dat->CprId;?></a>            
                  
                  <?php
				 }else{
				?>
                  <?php echo ($dat->CprId);?>
                  <?php 
				 }
				 ?>
				
				<?php
				/* if($PrivilegioCotizacionProductoVer){
				?>
                  <a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo $dat->CprId;?> ');"><?php echo $dat->CprId;?></a>
                  <?php
				 }else{
				?>
                  <?php echo ($dat->CprId);?>
                <?php 
				 }*/
				 ?></td>
                <td align="right" >
                  
                  <?php
				 if($PrivilegioVentaDirectaVer){
				?>
                
                 <a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId;?>');"><?php echo $dat->VdiId;?></a>            
                
                
                
                <!--
                  <a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId;?> ');"><?php echo $dat->VdiId;?></a>      -->          
                  <?php
				 }else{
				?>
                  <?php echo ($dat->VdiId);?>
                  <?php 
				 }
				 ?>
                  
                  
                  
                  
                </td>
                <td align="right" >
                  
                  
  <?php            
if(!empty($dat->VdiArchivo)){
	
	$extension = strtolower(pathinfo($dat->VdiArchivo, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->VdiArchivo, '.'.$extension);  
?>
                  
                  
  <a href="subidos/venta_directa/<?php echo $dat->VdiArchivo;?>" target="_blank" title="">
    <?php echo ($dat->VdiOrdenCompraNumero);?>
  </a>
                  
                  
  <?php	
}else{
?>
                  <?php echo ($dat->VdiOrdenCompraNumero);?>
  <?php	
}
?>
                  
                  
                  
                  
                  
                  
                  
                </td>
                <td align="right" >
				
				
                <?php
				  if(!empty($dat->AmoId)){
					  ?>
                  <?php
				 if($PrivilegioVentaConcretadaVer){
				?>
                
                	<?php
					if($dat->AmoTipo == 2){
						
						switch($dat->AmoSubTipo){
							case "3"://VCO
						?>
                        <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $dat->AmoId;?>');"> <?php echo $dat->AmoId;?></a>
                        <?php		
							break;
							
							case "2"://AMS
						?>
                        <a href="javascript:FncAlmacenMovimientoSalidaVistaPreliminar('<?php echo $dat->AmoId;?>');"> <?php echo $dat->AmoId;?></a>
                        <?php		
							break;
							
							default:
						?>
                     	   <?php echo $dat->AmoId;?> *
                        <?php	
							break;
						}
						
					}
					
					?>
                  
                  
                  <?php
				 }else{
				?>
                  <?php echo $dat->AmoId;?>
                  <?php 
				 }
				 ?>
                  <?php
				  }else{
					?>
                  -
                  <?php  
				  }
				  ?>
                  
                  
				
				<?php
				 /* if(!empty($dat->AmoId)){
					  ?>
                  <?php
				 if($PrivilegioVentaConcretadaVer){
				?>
                  <a href="javascript:FncVentaConcretadaCargarFormulario('Ver','<?php echo $dat->AmoId;?> ');"> <?php echo $dat->AmoId;?></a>
                  <?php
				 }else{
				?>
                  <?php echo $dat->AmoId;?>
                  <?php 
				 }
				 ?>
                  <?php
				  }else{
					?>
                  -
  <?php  
				  }*/
				  ?>
                  
                  
                  
                  
                </td>
                <td align="right" ><?php
				 if($PrivilegioCotizacionVehiculoVer){
				?>
                
                <a href="javascript:FncCotizacionVehiculoVistaPreliminar('<?php echo $dat->CveId;?>');"><?php echo $dat->CveId;?></a>
                
                
                  <!--<a href="javascript:FncCotizacionVehiculoCargarFormulario('Ver','<?php echo $dat->CveId;?> ');"><?php echo $dat->CveId;?></a>-->
                  <?php
				 }else{
				?>
                  <?php echo ($dat->CveId);?>
                <?php 
				 }
				 ?></td>
                <td align="right" ><?php
				 if($PrivilegioOrdenVentaVehiculoVer){
				?>
                
                  <a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $dat->OvvId;?>');"><?php echo $dat->OvvId;?></a>
                  
                  
                 <!-- <a href="javascript:FncOrdenVentaVehiculoCargarFormulario('Ver','<?php echo $dat->OvvId;?> ');"><?php echo $dat->OvvId;?></a>-->
                  <?php
				 }else{
				?>
                  <?php echo ($dat->OvvId);?>
                <?php 
				 }
				 ?></td>
                <td align="right" >
                  
                  
                  
                  <?php
				if($dat->FacNotaCredito=="Si"){
				?>
                  <a href="#" onmouseover="ajax_showTooltip(window.event,'<?php echo $InsProyecto->MtdRutComunes();?>FacturaVenta/TipFacturaNotaCredito.php?DocId=<?php echo $dat->FacId;?>&DtaId=<?php echo $dat->FtaId;?>',this);return false" >
                  <?php echo ($dat->FacNotaCredito); ?>                
                  </a>
                  <?php	
				}else{
				?>
                  <?php echo ($dat->FacNotaCredito); ?>
                  <?php	
				}
				?>    
                  
                  
                  
                </td>
                <td align="right" > 
                  
                  
                  
                  
                  <?php
				if($dat->FacCancelado==1){
				?>
                  
                  <a href="javascript:FncClientePagoCargarFormulario('Listado','<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');" ><img src="imagenes/acciones/enlace.gif" align="Enlace" title="Enlace" border="0" width="18" height="18" />Si  </a>              
                  <?php
				}elseif($dat->FacCancelado==2){
				?>
                  No
                <?php	
				}
				?>                </td>
                <td align="right" > 
                  
                  <?php $dat->FacTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->FacTotal:($dat->FacTotal/$dat->FacTipoCambio));?>
                  
                <?php echo number_format($dat->FacTotal,2); ?></td>
                <td align="right" >
                  
                  <?php
    if($PrivilegioPagoListado and $dat->FacTieneAbono == "Si"){
?>
                  
                  <a href="javascript:FncPagoFacturaCargarFormulario('Listado','<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');" >Abonos</a>              
                  
                  <?php
	}
?>
                  
                </td>
                <td align="right" ><?php echo ($dat->FacTotalItems);?></td>
                <td align="right" ><?php echo ($dat->FacTiempoCreacion);?></td>
                <td align="center" >

<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->FacId;?>&Ta=<?php echo $dat->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>

<?php
if($PrivilegioEliminar & $dat->FacCierre==1 & $dat->FacNotaCredito=="No"){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->FacId."%".$dat->FtaId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>



<?php
if($PrivilegioEditar & $dat->FacCierre==1 & $dat->FacNotaCredito=="No"){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->FacId;?>&Ta=<?php echo $dat->FtaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>
<?php
if($PrivilegioEditarId & $dat->FacCierre==1 & $dat->FacNotaCredito=="No"){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarId&Id=<?php echo $dat->FacId;?>&Ta=<?php echo $dat->FtaId;?>"><img src="imagenes/editarid.gif" width="19" height="19" border="0" title="Editar Codigo" alt="[ECodigo]"   /></a>
<?php
}
?>
<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->FacId;?>&Ta=<?php echo $dat->FtaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>



<?php
if($PrivilegioPagoRegistrar and $dat->FacEstado <> 6 and $dat->FacCancelado == 2){
?>

<a href="javascript:FncPagoFacturaCargarFormulario('Registrar','<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');" ><img src="imagenes/acciones/pagar.png" alt="[Pagar]" title="Registrar Pago"  width="19" height="19" border="0" /></a>

<?php
}
?>


<?php
/*if($PrivilegioPagoRegistrar and $dat->FacEstado <> 6 and $dat->FacCancelado == 2){
?>

<a href="javascript:FncClientePagoCargarFormulario('Registrar','<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');" ><img src="imagenes/acciones/pagar.png" alt="[Pagar]" title="Registrar Pago"  width="19" height="19" border="0" /></a>

<?php
}*/
?>


<?php
/*if($PrivilegioListadoClientePago){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncClientePagoCargarFormulario('Listado','<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');" ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>   



<?php
}*/
?>


<?php
			if($PrivilegioVistaPreliminar){
			?>
            
            <a href="javascript:FncFacturaVistaPreliminar('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
            
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
     <a href="javascript:FncFacturaImprmir('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
     
			<?php
			}
			?>
    

<?php
if($PrivilegioGenerarGuiaRemision and !empty($dat->FccId) and ($dat->FacEstado <> 6)){
?>
	<a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=FichaAccion&FccId=<?php echo $dat->FccId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]" /></a>
<?php
}
?>

<?php
if($PrivilegioGenerarGuiaRemision and !empty($dat->OvvId) and ($dat->FacEstado <> 6)){
?>
	<a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=OrdenVentaVehiculo&OvvId=<?php echo $dat->OvvId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]" /></a>
<?php
}
?>

<?php
if($PrivilegioRegistrarNotaCredito  and ($dat->FacEstado <> 6)){
?>
	<a href="principal.php?Mod=NotaCredito&Form=Registrar&Ori=Factura&FacId=<?php echo $dat->FacId;?>&FtaId=<?php echo $dat->FtaId;?>"><img src="imagenes/acciones/nota_credito.png" width="19" height="19" border="0" title="Generar Nota de Credito" alt="[Generar Nota de Credito]" /></a>
<?php
}
?>


      
<?php
			//if($PrivilegioVistaPreliminar){
			?>
<!--            
            <a href="javascript:FncFacturaGenerarXML('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><img src="imagenes/acciones/generar_xml.gif" alt="[Generar XML]" title="Generar XML" width="19" height="19" border="0" /></a>
            
            
            <a href="javascript:FncFacturaProcesarXML('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><img src="imagenes/acciones/procesar_xml.gif" alt="[Procesar XML]" title="Procesar XML" width="19" height="19" border="0" /></a>
            -->
        	<?php
			//}
			?>   
            
    <!--        
             <a href="javascript:FncFacturaFirmarXML('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><img src="imagenes/acciones/firmar_xml.gif" alt="[Firmar XML]" title="Firmar XML" width="19" height="19" border="0" /></a>
            
                <a href="javascript:FncFacturaEnviarXML('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><img src="imagenes/acciones/firmar_xml.gif" alt="[Enviar XML]" title="Enviar XML" width="19" height="19" border="0" /></a>
            
            -->
            
             <?php
// deb($PrivilegioGenerarPDF);
if($PrivilegioGenerarPDF ){
?>
	<a href="javascript:FncFacturaGenerarPDF('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><img src="imagenes/acciones/pdf.png" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
<?php
}
?>  
             <?php
// deb($PrivilegioGenerarPDF);
if($PrivilegioVer ){
?>
<a href="javascript:FncFacturarConsultarEstadoTicket('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>','<?php echo $dat->FacSunatRespuestaTicket;?>');"><img src="imagenes/acciones/sunat_consulta.png" alt="[Consultar Estado Ticket]" title="Consultar Estado Ticket" width="19" height="19" border="0" /></a>
<?php
}
?>  

            </td>
              </tr>

              <?php		$f++;

							$SumaSubTotal += $dat->FacSubTotal;
							$SumaImpuesto += $dat->FacImpuesto;
							$SumaTotal += $dat->FacTotal;
							
									}

									?>
            </tbody>
      </table>
      
<!--</div>--></td>
</tr>
</table>
<input type="hidden" name="CmpListadoSubTotal" id="CmpListadoSubTotal" value="<?php echo number_format($SumaSubTotal,2);?>" />
<input type="hidden" name="CmpListadoImpuesto" id="CmpListadoImpuesto" value="<?php echo number_format($SumaImpuesto,2);?>" />
<input type="hidden" name="CmpListadoTotal" id="CmpListadoTotal" value="<?php echo number_format($SumaTotal,2);?>" />
</div>

</form>


<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "FechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "FechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	}); 
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
