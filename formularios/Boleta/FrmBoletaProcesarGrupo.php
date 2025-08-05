<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEditarId = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarId"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
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
<?php $PrivilegioCotizacionVehiculoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionVehiculo","Ver"))?true:false;?>
<?php $PrivilegioOrdenVentaVehiculoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","Ver"))?true:false;?>

<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<?php $PrivilegioClienteEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Editar"))?true:false;?>
<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>
<?php $PrivilegioRegistrarNotaCredito = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCredito","Registrar"))?true:false;?>
<?php $PrivilegioRegistrarNotaDebito = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaDebito","Registrar"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoleta.js"></script>
<?php
/* 
 * To change this teíplate, bhkose Tools | Templates
 * and open the template in the editor.
 .+

/**
 

 * @author 
onathan
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
Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_tal = $_POST['Talonario'];
$POST_Moneda = $_POST['Moneda'];
$POST_npago = $_POST['CondicionPago'];
$POST_Sucursal = $_POST['CmpSucursal'];


if(empty($POST_p)){
	$POST_p = '1';
}
if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'BolTiempoCreacion';
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

//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

include($InsProyecto->MtdFormulariosMsj("Boleta").'MsjBoleta.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');


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
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsBoleta = new ClsBoleta();
$InsBoletaTalonario = new ClsBoletaTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$InsBoleta->UsuId = $_SESSION['SesionId'];
$InsBoleta->SucId = $_SESSION['SesionSucursal'];
	
include($InsProyecto->MtdFormulariosAcc("Boleta").'AccBoleta.php');

//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL) 
$ResBoleta = $InsBoleta->MtdObtenerBoletas("bol.BolId,bta.BtaNumero,cli.CliNombreCompleto,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNumeroDocumento,bol.AmoId,fim.FinId,amo.VdiId,vdi.VdiOrdenCompraNumero,bol.OvvId,bol.BolDatoAdicional8",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal);

$ArrBoletas = $ResBoleta['Datos'];
$BoletasTotal = $ResBoleta['Total'];
$BoletasTotalSeleccionado = $ResBoleta['TotalSeleccionado'];

$ResBoletaTalonario = $InsBoletaTalonario->MtdObtenerBoletaTalonarios(NULL,NULL,"BtaNumero","DESC",NULL,$POST_Sucursal);
$ArrBoletaTalonarios = $ResBoletaTalonario['Datos'];
$ResBoletaTalonario = $InsBoletaTalonario->MtdObtenerBoletaTalonarios(NULL,NULL,"BtaNumero","DESC",NULL,$POST_Sucursal,true);
$ArrBoletaTalonarios = $ResBoletaTalonario['Datos'];


$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

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
<div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/submenu/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
<?php
	}
	?>
            
<?php
if($PrivilegioEditar){
?>            
<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
<img src="imagenes/submenu/pendiente.png" alt="[Act. Pendiente]" title="Actualizar a estado PENDIENTE seleccionados" />Pendiente</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoEntregadoSeleccionados();">
<img src="imagenes/submenu/entregado.png" alt="[Act. Entregado]" title="Actualizar a estado ENTREGADO seleccionados" />Entregado</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
<img src="imagenes/submenu/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>

<!--<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoReservadoSeleccionados();">
<img src="imagenes/submenu/reservado.png" alt="[Act. Reservado]" title="Actualizar a estado RESERVADO seleccionados" />Reservado</a></div>

-->
<?php
}
?>

<?php
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton">
<a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/submenu/eliminar.png" alt="[Eliminar]" title="Eliminar elementos seleccionados" />Eliminar</a>
</div> <?php
}
?>

<?php
if($PrivilegioRegistrarNotaCredito){
?>	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarNotaCreditoSeleccionados();"><img src="imagenes/submenu/ncredito.png" alt="[Generar N. Credito]" title="Generar Nota de Credito con elementos"  />N. Credito</a></div>
    
<?php	
}
?>

<?php
if($PrivilegioRegistrarNotaDebito){
?>	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarNotaDebitoSeleccionados();"><img src="imagenes/submenu/ndebito.png" alt="[Generar N. Debito]" title="Generar Nota de Debito con elementos"  />N. Debito</a></div>
    
<?php	
}
?>
    
<?php
/*if($PrivilegioEditar){
?>       
<div class="EstSubMenuBoton"><a href="javascript:FncGenerarResumenXmlSeleccionados();"><img src="imagenes/submenu/sunat_resumen.png" alt="[Resumen Diario]" title="Resumen Diario"  />Diario</a></div>
<?php
	}*/
	?>
        
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE BOLETAS</span>  </td>
</tr>
<tr>
  <td width="49%">
    Mostrando <b><?php echo $BoletasTotalSeleccionado;?></b> de <b><?php echo $BoletasTotal;?></b> registros.</td>
  <td width="51%" align="right">
    
    <!--<table border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td align="right">SubTotal <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>:</td>
        <td align="right"><div id="CapListadoSubTotal" ></div></td>
        <td align="right">| Impuesto <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>:</td>
        <td align="right"><div id="CapListadoImpuesto" ></div></td>
        <td align="right">| Total <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>:</td>
        <td align="right"><div id="CapListadoTotal" ></div></td>
      </tr>
      </table>-->
      <?php
	  if(!empty($POST_Moneda)){
		  
	  ?>
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="14%" align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="13%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoTotal" ></div></td>
      </tr>
      </table>
      <?php
	  }
	  ?>
      
      </td>
  </tr>
<tr>
<td colspan="2" align="right">

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

Fecha Inicio
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/01/2014";}else{ echo $POST_finicio; }?>" size="10" maxlength="10"/>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="10" maxlength="10"/>
                                      
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
  
  
       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
     <option value="BolId" <?php if($POST_cam=="BolId"){ echo 'selected="selected"';}?>>Id</option>
		<option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
        <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. de Documento</option>
        <option value="BolTotal" <?php if($POST_cam=="BolTotal"){ echo 'selected="selected"';}?>>Total</option>
     </select>-->
		
        Talonario:
        <select class="EstFormularioCombo" name="Talonario" id="Talonario">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrBoletaTalonarios as $DatBoletaTalonario){
			  ?>
                  <option
                  
<?php if($POST_tal == $DatBoletaTalonario->BtaId){ echo 'selected="selected"';}?> value="<?php echo $DatBoletaTalonario->BtaId;?>" ><?php echo $DatBoletaTalonario->BtaNumero;?></option>
                  <?php
			  }
			  ?>
          </select>
                  
                 
        Estado
		<select class="EstFormularioCombo" name="Estado" id="Estado">
		<option value="" >Todos</option>
      	<option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
		<option value="5" <?php if($POST_estado==5){ echo 'selected="selected"';}?>>Entregado</option>
		<option value="6" <?php if($POST_estado==6){ echo 'selected="selected"';}?>>Anulado</option>
		<option value="7" <?php if($POST_estado==7){ echo 'selected="selected"';}?>>Reservado</option>
		</select>
       		 Moneda
                  
                  <select class="EstFormularioCombo" name="Moneda" id="Moneda">
              <option value="">Todos</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_Moneda==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonAbreviacion?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select>
             	<span title="Condicion de Pago">Cond. Pago</span>	
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
        

		
		
        
          <span class="EstFormularioEtiqueta">   Sucursal:
       </span>
       <span class="EstFormularioContenido">  
       <select  <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select>
            </span>
            
            
            <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>

<tr>
<td colspan="2">

<div id="CapListado2" >



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="4%" >
				
				<?php
				if($POST_ord == "BtaNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BtaNumero','ASC');">Serie <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BtaNumero','DESC');"> Serie <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('BtaNumero','ASC');"> Serie </a>
                <?php
				}
				?></th>

                <th width="2%" ><?php
				if($POST_ord == "BolId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "BolFechaEmision"){
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
                <th width="5%" ><?php
				if($POST_ord == "BolFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolFechaEmision','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolFechaEmision','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolFechaEmision','ASC');"> Cliente  </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "BolFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolFechaEmision','ASC');"> Fecha  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolFechaEmision','DESC');"> Fecha  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolFechaEmision','ASC');"> Fecha   </a>
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
                <th width="6%" ><?php
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
				if($POST_ord == "BolTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolTipoCambio','DESC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span></a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "BolObsequio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolObsequio','ASC');"> <span title="Estado">Obs.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolObsequio','DESC');"> <span title="Estado">Obs.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolObsequio','ASC');"> <span title="Estado">Obs.</span></a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "BolEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolEstado','ASC');"> <span title="Estado">Est.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolEstado','DESC');"> <span title="Estado">Est.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolEstado','ASC');"> <span title="Estado">Est.</span>  </a>
                  <?php
				}
				?></th>
                <th width="8%" >Referencias</th>
                <th width="3%" >N. Cre.</th>
                <th width="3%" >N. Deb.</th>
                <th width="4%" >Canc.</th>
                <th width="4%" ><?php
				if($POST_ord == "BolTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolTotalDescuento','ASC');"> Desc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolTotalDescuento','DESC');"> Desc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolTotalDescuento','ASC');"> Desc. </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "BolTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="5%" >Abonos</th>
                <th colspan="2" >SUNAT</th>
                <th width="2%" ><?php
				if($POST_ord == "BolTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolTotalItems','ASC');"> <span title="Items">It.</span> </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "BolTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolTiempoCreacion','DESC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('BolTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> </a>
                <?php
				}
				?></th>
                <th width="6%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="24" align="center">

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

				  <option <?php if($POST_num==$BoletasTotal){ echo 'selected="selected"';}?> value="<?php echo $BoletasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $BoletasTotal;
					//}else{
					//	$tregistros = ($BoletasTotalSeleccionado);
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




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrBoletas as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->BolId."%".$dat->BtaId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->BolId."%".$dat->BtaId; ?>" ticket="<?php echo $dat->BolSunatRespuestaTicket;?>" respuesta="<?php echo $dat->BolSunatRespuestaEnvioCodigo;?>" />				</td>
                <td align="right" valign="middle"   >
				
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->BolId;?>&Ta=<?php echo $dat->BtaId;?>"><?php echo $dat->BtaNumero;  ?></a>
				
				
				</td>

                <td align="right" valign="middle"   >
				
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->BolId;?>&Ta=<?php echo $dat->BtaId;?>"><?php echo $dat->BolId;  ?></a>
				
				</td>
                <td align="right" >
				
				<?php echo ($dat->CliNumeroDocumento);?></td>
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
                <td align="right" ><?php echo ($dat->BolFechaEmision);?></td>
                <td align="right" ><span class="<?php	echo (($dat->NpaNombre=="CREDITO")?"EstImportante1":(($dat->NpaNombre=="CONTADO")?"EstImportante2":""));?>">
                  <?php echo ($dat->NpaNombre);?>
                </span></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->BolTipoCambio);?></td>
                <td align="right" >
                  <?php
				if($dat->BolObsequio==1){
				?><span class="EstImportante3">
                    Tiene Obsequio</span>
                  <?php
				}else{
				?><span class="EstImportante4">
                    No Tiene Obsequio</span>
                  <?php	
				}
				?></td>
                <td align="right" >
                
                <?php echo $dat->BolEstadoDescripcion; ?>
                <?php echo $dat->BolEstadoIcono; ?>
                
                <?php 
//				deb($dat->BolSunatRespuestaEnvioCodigo);
				/*if($dat->BolSunatRespuestaEnvioCodigo=="0001"){
				?>
                <img src="imagenes/estado/sunat.png" width="20" height="20" align="[Procesado]" title="[Procesado]" border="0" />
                <?php	
				}*/
				?>
                
				<?php 
				/*switch($dat->BolEstado){
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
                	<img src="imagenes/reservado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  /> 
                <?php	
					break;
				}*/
				?>                </td>
                <td align="left" >
                  
                  <?php
				  if(!empty($dat->FinId)){
					  ?>
                  OT:
                  <?php
					if($PrivilegioFichaIngresoVer){
					?>
                  <a href="javascript:FncFichaIngresoVistaPreliminar('<?php echo $dat->FinId;?>');"><?php echo $dat->FinId;?></a>
                  <!--
                  <a href="javascript:FncFichaIngresoCargarFormulario('Ver','<?php echo $dat->FinId;?>');"> <?php echo $dat->FinId;?></a>-->
                  <?php	
					}else{
					?>
                  <?php echo $dat->FinId;?>
                  <?php	
					}
					?>
                  
                  <br />
                  <?php
				  }
				  ?>
                  
                  
                  <?php
				  if(!empty($dat->VdiId)){
					  ?>
                  OV:
                  <?php
				 if($PrivilegioVentaDirectaVer){
				?>
                  <a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId;?>');"><?php echo $dat->VdiId;?></a>            
                  
                  <!--<a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId;?> ');"><?php echo $dat->VdiId;?></a>            -->    
                  <?php
				 }else{
				?>
                  <?php echo ($dat->VdiId);?>
                  <?php 
				 }
				 ?>
                  
                  <br />
                  <?php
				  }
				  ?>
                  
                  <?php
				  if(!empty($dat->VdiOrdenCompraNumero)){
					  ?>              
                  REF.:
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
                  <br />
                  <?php	
}
?>                  
                  
                  
                  
                  <?php
				  if(!empty($dat->AmoId)){
					  ?>
                  FICHA:
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
                  <a href="javascript:FncTallerPedidoVistaPreliminar('<?php echo $dat->AmoId;?>');"> <?php echo $dat->AmoId;?></a>
                  <?php		
							break;
							
							
							case "1"://AMS
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
                  <br />
                  <?php
				  }
				  ?>
                  
                  
                  
                  
                  <?php
				  if(!empty($dat->OvvId)){
					  ?>
                  <?php
				 if($PrivilegioOrdenVentaVehiculoVer){
				?>
                  
                  <a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $dat->OvvId;?>');"><?php echo $dat->OvvId;?></a>
                  
                  
                  
                  <!--   <a href="javascript:FncOrdenVentaVehiculoCargarFormulario('Ver','<?php echo $dat->OvvId;?> ');"><?php echo $dat->OvvId;?></a>-->
                  <?php
				 }else{
				?>
                  <?php echo ($dat->OvvId);?>
                  <?php 
				 }
				 ?>
                  <br />
                  <?php 
				 }
				 ?>
                </td>
                <td align="right" ><?php
				if($dat->BolNotaCredito=="Si"){
				?>
                  <a href="javascript:FncBoletaNotaCreditoCargar('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');"> <?php echo ($dat->BolNotaCredito); ?> </a>
                  <?php	
				}else{
				?>
                  <?php echo ($dat->BolNotaCredito); ?>
                  <?php	
				}
				?></td>
                <td align="right" ><?php
				if($dat->BolNotaDebito=="Si"){
				?>
                  <a href="javascript:FncBoletaNotaDebitoCargar('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');"> <?php echo ($dat->BolNotaDebito); ?></a>
                  <?php	
				}else{
				?>
                  <?php echo ($dat->BolNotaDebito); ?>
                  <?php	
				}
				?></td>
                <td align="right" >
                
                
                
                    <?php
				if($dat->BolCancelado==1){
				?>
<!--<a href="javascript:FncClientePagoCargarFormulario('Listado','<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');" ><img src="imagenes/acciones/enlace.gif" alt="" width="18" height="18" border="0" align="Enlace" title="Enlace" />
Si</a>-->
Si
<?php
				}elseif($dat->BolCancelado==2){
				?>
No
<?php	
				}
				?>
                </td>
                <td align="right" >
				<?php //$dat->BolTotalDescuento = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->BolTotalDescuento:($dat->BolTotalDescuento/$dat->BolTipoCambio));?>
                				
				<?php $dat->BolTotalDescuento = (($dat->BolTotalDescuento/(empty($dat->BolTipoCambio)?1:$dat->BolTipoCambio)));?>
                
                  <?php //echo ($dat->MonSimbolo);?> <?php echo number_format($dat->BolTotalDescuento,2); ?></td>
                <td align="right" >
                  
                  <?php //$dat->BolTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->BolTotal:($dat->BolTotal/$dat->BolTipoCambio));?>
                  <?php $dat->BolTotal = (($dat->BolTotal/(empty($dat->BolTipoCambio)?1:$dat->BolTipoCambio)));?>
                  <?php //echo ($dat->MonSimbolo);?>
                  <?php echo number_format($dat->BolTotal,2); ?>                </td>
                <td align="right" >
                  
                  <?php
//if($PrivilegioPagoListado  and $dat->BolTieneAbono == "Si"){
if($PrivilegioPagoListado){
?>
                  
                  <a href="javascript:FncPagoBoletaCargarFormulario('Listado','<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');" >Abonos</a>
                  
                  <?php
}
?>
                  
                  
                  
                  
                  
                </td>
                <td width="6%" align="right" >
                 <a href="javascript:FncBoletaSunatHistorialCargar('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');" >          
    			
		
                <?php
switch($dat->BolSunatUltimaAccion){
	case "ALTA":
?>
		<img width="25" height="25" src="imagenes/estado/sunat_alta.png" alt="Solicitud de alta" title="Solicitud de alta" border="0" />
<?php	
	break;	
	
	case "BAJA":
?>
		<img width="25" height="25" src="imagenes/estado/sunat_baja.png" alt="Solicitud de baja" title="Solicitud de baja" border="0" />
<?php
	break;
	
		case "CONSULTACDR":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_alta.png" alt="Consulta CDR" title="Consulta CDR" border="0" />
                  <?php
	break;
	
	default:
?>
		<img width="25" height="25" src="imagenes/estado/sunat_sin_procesar.png" alt="Sin solicitud" title="Sin solicitud" border="0" />
<?php
	break;
}
?></a>
                </td>
                <td width="3%" align="right" >


<?php
switch($dat->BolSunatUltimaRespuesta){
	case "APROBADO":
?>
		<img width="25" height="25" src="imagenes/estado/sunat_aprobado.png" alt="Aprobado" title="Aprobado" border="0" />
<?php	
	break;	
	
	case "RECHAZO":
?>
		<img width="25" height="25" src="imagenes/estado/sunat_rechazado.png" alt="Rechazado" title="Rechazado" border="0" />
<?php
	break;
	
	case "EXCEPCION":
?>
		<img width="25" height="25" src="imagenes/estado/sunat_excepcion.png" alt="Excepcion" title="Excepcion" border="0" />
<?php
	break;
	
	case "OBSERVADO":
?>
		<img width="25" height="25" src="imagenes/estado/sunat_observado.png" alt="Observado" title="Observado" border="0" />
<?php
	break;
	
	default:
?>
		<img width="25" height="25" src="imagenes/estado/sunat_sin_procesar.png" alt="Sin respuesta" title="Sin respuesta" border="0" />
<?php
	break;
}
?>
                </td>
                <td align="right" ><?php echo ($dat->BolTotalItems);?></td>
                <td align="right" ><?php echo ($dat->BolTiempoCreacion);?></td>
                <td align="center" >

<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->BolId;?>&Ta=<?php echo $dat->BtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>

<?php
if($PrivilegioEliminar and $dat->BolCierre==1 and $dat->BolSunatRespuestaEnvioCodigo==0){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->BolId."%".$dat->BtaId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>




<?php
if($PrivilegioEditar & $dat->BolCierre==1){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->BolId;?>&Ta=<?php echo $dat->BtaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioEditarId & $dat->BolCierre==1){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarId&Id=<?php echo $dat->BolId;?>&Ta=<?php echo $dat->BtaId;?>"><img src="imagenes/editarid.gif" width="19" height="19" border="0" title="Editar Codigo" alt="[ECodigo]"   /></a>
<?php
}
?>


<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->BolId;?>&Ta=<?php echo $dat->BtaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>

<?php
if($PrivilegioPagoRegistrar and $dat->BolEstado <> 6 and $dat->BolCancelado == 2){
?>

<a href="javascript:FncPagoBoletaCargarFormulario('Registrar','<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');" ><img src="imagenes/acciones/pagar.png" alt="[Pagar]" title="Registrar Pago"  width="19" height="19" border="0" /></a>

<?php
}
?>
  
  
  <?php
			if($PrivilegioVistaPreliminar){
			?>
        
		<a href="javascript:FncBoletaVistaPreliminar('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo ($dat->BtaNumero=="200")?'2':'1';?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>

  
  

        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        

      <a href="javascript:FncBoletaImprmir('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo ($dat->BtaNumero=="200")?'2':'1';?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
              
              
			<?php
			}
			?>
            
            <?php
if($PrivilegioGenerarGuiaRemision and !empty($dat->FccId) and ($dat->BolEstado <> 6)){
?>
	<a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=FichaAccion&FccId=<?php echo $dat->FccId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]" /></a>
<?php
}
?>

<?php
if($PrivilegioGenerarGuiaRemision and !empty($dat->OvvId) and ($dat->BolEstado <> 6)){
?>
	<a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=OrdenVentaVehiculo&OvvId=<?php echo $dat->OvvId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]" /></a>
<?php
}
?>

  
             <?php
// deb($PrivilegioGenerarPDF);
if($PrivilegioGenerarPDF ){
?>
	<a href="javascript:FncBoletaGenerarPDF('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');"><img src="imagenes/acciones/pdf.png" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
<?php
}
?>  



             <?php
// deb($PrivilegioGenerarPDF);
if($PrivilegioVer ){
?>

<!--<a href="javascript:FncBoletarConsultarEstadoTicket('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo $dat->BolSunatRespuestaTicket;?>');"><img src="imagenes/acciones/sunat_consulta.png" alt="[Consultar Estado Ticket]" title="Consultar Estado Ticket" width="19" height="19" border="0" /></a>

<a href="javascript:FncBoletarProcesarXML('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo $dat->BolSunatRespuestaTicket;?>');"><img src="imagenes/acciones/sunat_procesar.png" alt="[Procesar]" title="Procesar" width="19" height="19" border="0" /></a>
-->
<!--<a href="javascript:FncBoletaSunatTareas('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo $dat->BolSunatRespuestaTicket;?>');"><img src="imagenes/acciones/sunat_tareas.png" alt="[Tareas SUNAT]" title="Tareas SUNAT" width="19" height="19" border="0" /></a>

-->

<?php
}
?>  



<?php

if($PrivilegioVer ){
?>

<!--<a href="javascript:FncBoletaSunatTareasv2('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo $dat->BolSunatRespuestaTicket;?>');"><img src="imagenes/sunat/tareas_sunat.png" alt="[Tareas SUNAT v2]" title="Tareas SUNAT v2" width="19" height="19" border="0" /></a>
-->



<a href="javascript:FncBoletaSunatTareasv2('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo $dat->BolSunatRespuestaTicket;?>','<?php echo $dat->BolSunatRespuestaEnvioCodigo;?>','<?php echo $dat->BolSunatUltimaRespuesta;?>','<?php echo $dat->BolSunatRespuestaBajaTicket;?>');"><img src="imagenes/sunat/tareas_sunat.png" alt="[Tareas SUNAT v2]" title="Tareas SUNAT v2" width="19" height="19" border="0" /></a>

<!--
<a href="javascript:FncBoletaSunatTareasv3('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>','<?php echo $dat->BolSunatRespuestaTicket;?>','<?php echo $dat->BolSunatRespuestaEnvioCodigo;?>','<?php echo $dat->BolSunatUltimaRespuesta;?>','<?php echo $dat->BolSunatRespuestaBajaTicket;?>');"><img src="imagenes/sunat/tareas_sunat.png" alt="[Tareas SUNAT v3]" title="Tareas SUNAT v3" width="19" height="19" border="0" /></a>
-->
<?php
}
?>  



</td>
              </tr>

              <?php		$f++;
							
							$Total += $dat->BolTotal;
							$SubTotal += $dat->BolSubTotal;
							$Impuesto += $dat->BolImpuesto;
							
									}


									$SubTotal = number_format($SubTotal,2);									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									
									?>
            </tbody>
      </table>
</div></td>
</tr>
</table>
</div>

<input type="hidden" name="CmpListadoSubTotal" id="CmpListadoSubTotal" value="<?php echo $SubTotal;?>" />
<input type="hidden" name="CmpListadoImpuesto" id="CmpListadoImpuesto" value="<?php echo $Impuesto;?>" />
<input type="hidden" name="CmpListadoTotal" id="CmpListadoTotal" value="<?php echo $Total;?>" />
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

