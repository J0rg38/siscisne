<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEditarId = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarId"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<?php $PrivilegioPagoRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>

<?php $PrivilegioPagoListado = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>



<?php $PrivilegioVentaConcretadaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Ver"))?true:false;?>
<?php $PrivilegioFichaIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Ver"))?true:false;?>
<?php $PrivilegioVentaDirectaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioCotizacionVehiculoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionVehiculo","Ver"))?true:false;?>
<?php $PrivilegioOrdenVentaVehiculoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","Ver"))?true:false;?>

<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaExportacion.js"></script>
<?php
/* 
 * To change this te�plate, bhkose Tools | Templates
 * and open the template in the editor.
 .+

/**
 

 * @author 
onathan
 */

$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = ($_POST['Num']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';

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

if(empty($POST_p)){
	$POST_p = '1';
}
if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'FexTiempoModificacion';
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


include($InsProyecto->MtdFormulariosMsj("FacturaExportacion").'MsjFacturaExportacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionTalonario.php');
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

$InsFacturaExportacion = new ClsFacturaExportacion();
$InsFacturaExportacionTalonario = new ClsFacturaExportacionTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();

$InsFacturaExportacion->UsuId = $_SESSION['SesionId'];
$InsFacturaExportacion->SucId = $_SESSION['SisSucId'];
	
include($InsProyecto->MtdFormulariosAcc("FacturaExportacion").'AccFacturaExportacion.php');

//MtdObtenerFacturaExportaciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FexId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL)



//MtdObtenerFacturaExportaciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FexId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL) {
	
$ResFacturaExportacion = $InsFacturaExportacion->MtdObtenerFacturaExportaciones("FexId,FetNumero,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,bol.AmoId,FinId,amo.VdiId,vdi.VdiOrdenCompraNumero,OvvId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL);

$ArrFacturaExportaciones = $ResFacturaExportacion['Datos'];
$FacturaExportacionesTotal = $ResFacturaExportacion['Total'];
$FacturaExportacionesTotalSeleccionado = $ResFacturaExportacion['TotalSeleccionado'];

$ResFacturaExportacionTalonario = $InsFacturaExportacionTalonario->MtdObtenerFacturaExportacionTalonarios(NULL,NULL,"FetNumero","DESC",NULL,$_SESSION['SisSucId']);
$ArrFacturaExportacionTalonarios = $ResFacturaExportacionTalonario['Datos'];
	
$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


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
<img src="imagenes/iconos/pendiente.png" alt="[Act. Pendiente]" title="Actualizar a estado PENDIENTE seleccionados" />Pendiente</a></div>





<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoEntregadoSeleccionados();">
<img src="imagenes/submenu/entregado.png" alt="[Act. Entregado]" title="Actualizar a estado ENTREGADO seleccionados" />Entregado</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
<img src="imagenes/submenu/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoReservadoSeleccionados();">
<img src="imagenes/iconos/reservado.png" alt="[Act. Reservado]" title="Actualizar a estado RESERVADO seleccionados" />Reservado</a></div>
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
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE FACTURAS DE EXPORTACION</span>  </td>
</tr>
<tr>
  <td width="49%">
    Mostrando <b><?php echo $FacturaExportacionesTotalSeleccionado;?></b> de <b><?php echo $FacturaExportacionesTotal;?></b> registros.</td>
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
      
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="14%" align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="13%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoTotal" ></div></td>
      </tr>
      </table>
      
      
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
        

         <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
        <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>


       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
     <option value="FexId" <?php if($POST_cam=="FexId"){ echo 'selected="selected"';}?>>Id</option>
		<option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
        <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. de Documento</option>
        <option value="FexTotal" <?php if($POST_cam=="FexTotal"){ echo 'selected="selected"';}?>>Total</option>
     </select>-->
		
        Talonario:
        <select class="EstFormularioCombo" name="Talonario" id="Talonario">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrFacturaExportacionTalonarios as $DatFacturaExportacionTalonario){
			  ?>
                  <option
                  
<?php if($POST_tal == $DatFacturaExportacionTalonario->FetId){ echo 'selected="selected"';}?> value="<?php echo $DatFacturaExportacionTalonario->FetId;?>" ><?php echo $DatFacturaExportacionTalonario->FetNumero;?></option>
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
        

		Fecha Inicio
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/01/2014";}else{ echo $POST_finicio; }?>" size="10" maxlength="10"/>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="10" maxlength="10"/>
                                      
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
  
  
		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>

<tr>
<td colspan="2">

<div id="CapListado2" >



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="1%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="2%" >
				
				<?php
				if($POST_ord == "FetNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FetNumero','ASC');">- <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FetNumero','DESC');"> - <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FetNumero','ASC');"> - </a>
                <?php
				}
				?></th>

                <th width="3%" ><?php
				if($POST_ord == "FexId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FexId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "FexFechaEmision"){
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
                <th width="17%" ><?php
				if($POST_ord == "FexFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexFechaEmision','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexFechaEmision','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FexFechaEmision','ASC');"> Cliente  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "FexFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexFechaEmision','ASC');"> Fecha  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexFechaEmision','DESC');"> Fecha  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FexFechaEmision','ASC');"> Fecha   </a>
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
				if($POST_ord == "FexTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexTipoCambio','DESC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FexTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FexObsequio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexObsequio','ASC');"> <span title="Estado">Obs.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexObsequio','DESC');"> <span title="Estado">Obs.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FexObsequio','ASC');"> <span title="Estado">Obs.</span></a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FexEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexEstado','ASC');"> <span title="Estado">Est.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexEstado','DESC');"> <span title="Estado">Est.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FexEstado','ASC');"> <span title="Estado">Est.</span>  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
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
                <th width="2%" >
                  
                  <?php
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
                <th width="2%" >
                  
                  
                  
                  <?php
				if($POST_ord == "VdiOrdenCompraNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','DESC');"> Ref. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> Ref. </a>
                  <?php
				}
				?></th>
                <th width="6%" > <?php
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
                <th width="2%" >Canc.</th>
                <th width="4%" ><?php
				if($POST_ord == "FexTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FexTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="1%" >Abonos</th>
                <th width="2%" ><?php
				if($POST_ord == "FexTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FexTotalItems','ASC');"> <span title="Items">It.</span> </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FexTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FexTiempoModificacion','ASC');"> <span title="Ultima Actualizacion">U.A.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FexTiempoModificacion','DESC');"> <span title="Ultima Actualizacion">U.A.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FexTiempoModificacion','ASC');"> <span title="Ultima Actualizacion">U.A.</span> </a>
                <?php
				}
				?></th>
                <th width="9%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="22" align="center">

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

				  <option <?php if($POST_num==$FacturaExportacionesTotal){ echo 'selected="selected"';}?> value="<?php echo $FacturaExportacionesTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $FacturaExportacionesTotal;
					//}else{
					//	$tregistros = ($FacturaExportacionesTotalSeleccionado);
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

								foreach($ArrFacturaExportaciones as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->FexId."%".$dat->FetId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->FexId."%".$dat->FetId; ?>" />				</td>
                <td align="right" valign="middle"   ><?php echo $dat->FetNumero;  ?></td>

                <td align="right" valign="middle"   ><?php echo $dat->FexId;  ?></td>
                <td align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td align="right" >
		
    
	        <?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?>
			
	              </td>
                <td align="right" ><?php echo ($dat->FexFechaEmision);?></td>
                <td align="right" ><?php echo ($dat->NpaNombre);?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->FexTipoCambio);?></td>
                <td align="right" >
				<?php
				if($dat->FexObsequio==1){
				?>
					Tiene Obsequio
				<?php
				}else{
				?>
					No Tiene Obsequio
				<?php	
				}
				?></td>
                <td align="right" >
                
                <?php echo $dat->FexEstadoDescripcion; ?>
                <?php echo $dat->FexEstadoIcono; ?>
                
				<?php 
				/*switch($dat->FexEstado){
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
                <td align="right" ><?php
				  if(!empty($dat->FinId)){
					  ?>
                  <?php
					if($PrivilegioFichaIngresoVer){
					?>
                  <a href="javascript:FncFichaIngresoCargarFormulario('Ver','<?php echo $dat->FinId;?>');"> <?php echo $dat->FinId;?></a>
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
				 if($PrivilegioVentaDirectaVer){
				?>
                  <a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId;?> ');"><?php echo $dat->VdiId;?></a>                
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
                  
                  <?php //echo ($dat->VdiOrdenCompraNumero);?>
                  
                </td>
                <td align="right" ><?php
				  if(!empty($dat->AmoId)){
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
				  }
				  ?></td>
                <td align="right" >
                
                
                
                    <?php
				if($dat->FexCancelado==1){
				?>
<a href="javascript:FncClientePagoCargarFormulario('Listado','<?php echo $dat->FexId;?>','<?php echo $dat->FetId;?>');" ><img src="imagenes/acciones/enlace.gif" alt="" width="18" height="18" border="0" align="Enlace" title="Enlace" />
Si</a>
<?php
				}elseif($dat->FexCancelado==2){
				?>
No
<?php	
				}
				?>
                </td>
                <td align="right" >
                  
                  <?php $dat->FexTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->FexTotal:($dat->FexTotal/$dat->FexTipoCambio));?>
                  
                  <?php echo number_format($dat->FexTotal,2); ?>                </td>
                <td align="right" >
                  
  <?php
if($PrivilegioPagoListado){
?>
                  
  <a href="javascript:FncPagoFacturaExportacionCargarFormulario('Listado','<?php echo $dat->FexId;?>','<?php echo $dat->FetId;?>');" >Abonos</a>
                  
  <?php
}
?>
                  
                  
                  
                  
                  
                </td>
                <td align="right" ><?php echo ($dat->FexTotalItems);?></td>
                <td align="right" ><?php echo ($dat->FexTiempoModificacion);?></td>
                <td align="center" >

<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->FexId;?>&Ta=<?php echo $dat->FetId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>

<?php
if($PrivilegioEliminar & $dat->FexCierre==1){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->FexId."%".$dat->FetId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>




<?php
if($PrivilegioEditar & $dat->FexCierre==1){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->FexId;?>&Ta=<?php echo $dat->FetId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioEditarId & $dat->FexCierre==1){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarId&Id=<?php echo $dat->FexId;?>&Ta=<?php echo $dat->FetId;?>"><img src="imagenes/editarid.gif" width="19" height="19" border="0" title="Editar Codigo" alt="[ECodigo]"   /></a>
<?php
}
?>


<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->FexId;?>&Ta=<?php echo $dat->FetId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>

<?php
if($PrivilegioPagoRegistrar and $dat->FexEstado <> 6 and $dat->FexCancelado == 2){
?>

<a href="javascript:FncPagoFacturaExportacionCargarFormulario('Registrar','<?php echo $dat->FexId;?>','<?php echo $dat->FetId;?>');" ><img src="imagenes/acciones/pagar.png" alt="[Pagar]" title="Registrar Pago"  width="19" height="19" border="0" /></a>

<?php
}
?>
  
  
  <?php
			if($PrivilegioVistaPreliminar){
			?>
        
		<a href="javascript:FncFacturaExportacionVistaPreliminar('<?php echo $dat->FexId;?>','<?php echo $dat->FetId;?>','<?php echo ($dat->FetNumero=="200")?'2':'1';?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>

  
  

        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        

      <a href="javascript:FncFacturaExportacionImprmir('<?php echo $dat->FexId;?>','<?php echo $dat->FetId;?>','<?php echo ($dat->FetNumero=="200")?'2':'1';?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
              
              
			<?php
			}
			?>
            
            <?php
if($PrivilegioGenerarGuiaRemision and !empty($dat->FccId) and ($dat->FexEstado <> 6)){
?>
	<a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=FichaAccion&FccId=<?php echo $dat->FccId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]" /></a>
<?php
}
?>

<?php
if($PrivilegioGenerarGuiaRemision and !empty($dat->OvvId) and ($dat->FexEstado <> 6)){
?>
	<a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=OrdenVentaVehiculo&OvvId=<?php echo $dat->OvvId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]" /></a>
<?php
}
?>


</td>
              </tr>

              <?php		$f++;
							
							$Total += $dat->FexTotal;
							$SubTotal += $dat->FexSubTotal;
							$Impuesto += $dat->FexImpuesto;
							
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

