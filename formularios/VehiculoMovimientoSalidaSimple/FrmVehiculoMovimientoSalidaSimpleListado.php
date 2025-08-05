<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida",$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","Imprimir"))?true:false;?>

<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>
<?php $PrivilegioOrdenCompraVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCompra","Ver"))?true:false;?>
<?php $PrivilegioGenerarNotaCredito = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCreditoCompra","Registrar"))?true:false;?>

<?php $PrivilegioGenerarReclamo = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Reclamo","Registrar"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMovimientoSalida","Multisucursal"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoSalidaSimple.js" ></script>
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
$POST_origen = $_POST['Origen'];
$POST_TipoFecha = $_POST['TipoFecha'];
$POST_Moneda = $_POST['Moneda'];
$POST_Almacen = $_POST['CmpAlmacen'];
$POST_Sucursal = $_POST['CmpSucursal'];


if(empty($POST_p)){$POST_p = '1';}
if(empty($POST_num)){$POST_num = '10';}
if(empty($POST_ord)){$POST_ord = 'VmvId';}
if(empty($POST_sen)){$POST_sen = 'DESC';}
if(empty($POST_pag)){$POST_pag = '0,'.$POST_num;}

if(empty($POST_Moneda)){$POST_Moneda = $EmpresaMonedaId;}

/*
* Otras variables
*/
if(empty($POST_finicio)){
	$POST_finicio = "01/01/".date("Y");;
}

if(empty($POST_ffin)){$POST_ffin = date("d/m/Y");}
if(empty($POST_estado)){$POST_estado = 0;}
if(empty($POST_con)){$POST_con = "contiene";}
if(empty($POST_TipoFecha)){$POST_TipoFecha = "VmvFecha";}


if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoMovimientoSalidaSimple.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoMovimientoSalidaSimple.php');

	
//MtdObtenerVehiculoMovimientoSalidas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oCancelado=0,$oCliente=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oSubTipo=NULL) {
$ResVehiculoMovimientoSalida = $InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalidas("VmvId,prv.CliNombre,prv.CliApellidoPaterno,prv.CliApellidoMaterno,VmvComprobanteNumero,VmvGuiaRemisionNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,NULL,"VmvFecha",0,NULL,NULL,$POST_Sucursal,$POST_Almacen,2);
$ArrVehiculoMovimientoSalidas = $ResVehiculoMovimientoSalida['Datos'];
$VehiculoMovimientoSalidasTotal = $ResVehiculoMovimientoSalida['Total'];
$VehiculoMovimientoSalidasTotalSeleccionado = $ResVehiculoMovimientoSalida['TotalSeleccionado'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


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
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
<img src="imagenes/estado/no_realizado.png" alt="[Act. No Realizado]" title="Actualizar a estado NO REALIZADO seleccionados" />No/Realizado</a></div>
    
<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoRealizadoSeleccionados();">
<img src="imagenes/estado/realizado.gif" alt="[Act. Realizado]" title="Actualizar a estado REALIZADO seleccionados" />Realizado</a></div>


<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
<img src="imagenes/estado/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>
    

<?php
}
?>


<?php
/*if($PrivilegioEditar){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncMarcarRevisadoSeleccionados();"><img src="imagenes/iconos/revisado.png" alt="[Marcar como Revisado]" title="Marcar como Revisado" />Revisado</a></div> 

<?php
}*/
?>



</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE SALIDAS DE UNIDADES VEHICULARES</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $VehiculoMovimientoSalidasTotalSeleccionado;?></b> de <b><?php echo $VehiculoMovimientoSalidasTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
    <!--<table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td colspan="3" align="center">SubTotal</td>
        <td colspan="3" align="center">Impuesto</td>
        <td colspan="3" align="center">Total</td>
      </tr>
      <tr>
        <td width="16%" align="center"><div id="CapListadoSubTotal2" ></div></td>
        <td width="6%" align="center">/</td>
        <td width="15%" align="center"><div id="CapListadoSubTotal" ></div></td>
        <td width="15%" align="center"><div id="CapListadoImpuesto2" ></div></td>
        <td width="5%" align="center">/</td>
        <td width="14%" align="center"><div id="CapListadoImpuesto" ></div></td>
        <td width="12%" align="center"><div id="CapListadoTotal2" ></div></td>
        <td width="3%" align="center">/</td>
        <td width="14%" align="center"><div id="CapListadoTotal" ></div></td>
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
<!--    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="VmvId" <?php if($POST_cam=="VmvId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>      
      <option value="VmvComprobanteNumero" <?php if($POST_cam=="VmvComprobanteNumero"){ echo 'selected="selected"';}?>>Num. Comprobante</option>      
      <option value="VmvGuiaRemisionNumero" <?php if($POST_cam=="VmvGuiaRemisionNumero"){ echo 'selected="selected"';}?>>Num. G. Remision</option>      
      
      
      </select>-->
    Estado:
	<select class="EstFormularioCombo" name="Estado" id="Estado">
    <option value="" >Todos</option>
    <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>No Realizado</option>
    <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
    </select>
    
    
    Moneda:
    
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
                    <!--  Almacen:
      <select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($POST_Almacen==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
      
      Tipo Fecha:
      
      <select class="EstFormularioCombo" name="TipoFecha" id="TipoFecha">
    <option value="VmvFecha" <?php if($POST_TipoFecha=="VmvFecha"){ echo 'selected="selected"';}?>>Fecha de Salida</option>
    <option value="VmvComprobanteFecha" <?php if($POST_TipoFecha=="VmvComprobanteFecha"){ echo 'selected="selected"';}?>>Fecha Doc. Salida</option>  
    </select>
    
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin; ?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    
    
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





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="2%" >
                  
                  <?php
				if($POST_ord == "VmvId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmvId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VmvFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvFecha','ASC');"> Fec. Salida <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvFecha','DESC');"> Fec. Salida <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmvFecha','ASC');"> Fec. Salida </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "SucNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SucNombre','ASC');"> Sucursal <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SucNombre','DESC');"> Sucursal <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('SucNombre','ASC');"> Sucursal </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "SucNombreDestino"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SucNombreDestino','ASC');"> Destino <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SucNombreDestino','DESC');"> Destino <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('SucNombreDestino','ASC');"> Destino </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "CtiNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CtiNombre','ASC');"> Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CtiNombre','DESC');"> Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CtiNombre','ASC');"> Comprob. </a>
                  <?php
				}
				?></th>
                <th width="4%" > <?php
				if($POST_ord == "VmvComprobanteNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvComprobanteNumero','ASC');"> Num. Doc. Salida <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvComprobanteNumero','DESC');"> Num. Doc. Salida <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmvComprobanteNumero','ASC');"> Num. Doc. Salida </a>
                  <?php
				}
				?></th>
                <th width="4%" > <?php
				if($POST_ord == "VmvComprobanteFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvComprobanteFecha','ASC');"> Fecha Doc Salida <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvComprobanteFecha','DESC');"> Fecha Doc Salida <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmvComprobanteFecha','ASC');"> Fecha Doc Salida </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VmvGuiaRemisionSerie"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvGuiaRemisionSerie','ASC');"> G. Rem. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvGuiaRemisionSerie','DESC');"> G. Rem. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmvGuiaRemisionSerie','ASC');"> G. Rem. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "MonId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MonId','ASC');"> Moneda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MonId','DESC');"> Moneda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('MonId','ASC');"> Moneda </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "VmvTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvTipoCambio','DESC');">  T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmvTipoCambio','ASC');">  T.C. </a>
                <?php
				}
				?></th>
                <th width="20%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente/Destinatario <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');">  Cliente/Destinatario <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente/Destinatario  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "VmvTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VmvTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="2%" ><?php
				if($POST_ord == "VmvEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VmvEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="3%" >Doc. Ref.:</th>
                <th width="2%" ><?php
				if($POST_ord == "VmvTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VmvTotalItems','ASC');"> <span title="Items">It.</span></a>
                  <?php
				}
				?></th>
                <th width="7%" > <?php
				if($POST_ord == "VmvTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmvTiempoCreacion','ASC');"> Fecha Creacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmvTiempoCreacion','DESC');"> Fecha Creacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmvTiempoCreacion','ASC');"> Fecha Creacion </a>
                  <?php
				}
				?></th>
                <th width="4%" >Cierre</th>
                <th width="15%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="20" align="center">

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

				  <option <?php if($POST_num==$VehiculoMovimientoSalidasTotal){ echo 'selected="selected"';}?> value="<?php echo $VehiculoMovimientoSalidasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VehiculoMovimientoSalidasTotal;
					//}else{
					//	$tregistros = ($VehiculoMovimientoSalidasTotalSeleccionado);
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
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrVehiculoMovimientoSalidas as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VmvId; ?>" nota_credito_compra="<?php echo $dat->VmvNotaCreditoCompra;?>" cierre="<?php echo $dat->VmvCierre;?>" />				</td>

                <td align="right" valign="middle" width="2%"   >
                  <a href="principal.php?Mod=VehiculoMovimientoSalida&Form=Ver&Id=<?php echo $dat->VmvId;  ?>">
                  <?php echo $dat->VmvId;  ?>



                  </a>
                </td>
                <td  width="4%" align="right" ><?php echo ($dat->VmvFecha);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->SucNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->SucNombreDestino);?></td>
                <td  width="6%" align="right" ><?php echo $dat->CtiNombre;  ?></td>
                <td  width="4%" align="right" >
				
				<?php echo $dat->VmvComprobanteNumero;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->VmvComprobanteFecha;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->VmvGuiaRemisionSerie;  ?> - <?php echo $dat->VmvGuiaRemisionNumero;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->VmvTipoCambio;  ?></td>
                <td  width="20%" align="right" >
                  
                  
                  <?php
if($PrivilegioClienteVer){
?>
                  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  ><?php echo ($dat->CliNombreCompleto);?></a>
  <?php	
}else{
?>
  <?php echo ($dat->CliNombreCompleto);?>
  <?php	
}
?>
                  
                  
                  
</td>
                <td  width="6%" align="right" >
                  
                  <?php $dat->VmvTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VmvTotal:($dat->VmvTotal/$dat->VmvTipoCambio));?>                          
                  <?php echo number_format($dat->VmvTotal,2);?>
                  <?php
					$Total += $dat->VmvTotal ;
			
				?>
                </td>
                <td  width="2%" align="right" ><?php // echo $dat->VmvEstadoIcono;?> 
                  <?php
				switch($dat->VmvEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/estado/realizado.png" />
                  <?php							
						break;	
						
							case 6:
				?>
                  <img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />
                  <?php							
						break;	

					}
				?> <?php echo $dat->VmvEstadoDescripcion;?></td>
                <td  width="3%" align="right" ><?php            
if(!empty($dat->VmvFoto)){
	
	$extension = strtolower(pathinfo($dat->VmvFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->VmvFoto, '.'.$extension);  
?>
              <!--    <a  class="thickbox" href="subidos/vehiculo_movimiento_fotos/<?php echo $dat->VmvFoto;?>"  title="">-->
                <a   href="javascript:FncVisualizarArchivo('subidos/vehiculo_movimiento_fotos/<?php echo $dat->VmvFoto;?>')">   
                  
                  <img  src="imagenes/documento.gif" width="20" height="20" border="0"  /></a>
                <?php	
}
?></td>
                <td  width="2%" align="right" ><?php echo ($dat->VmvTotalItems);?></td>
                <td align="right" ><?php echo ($dat->VmvTiempoCreacion);?></td>
                <td  width="4%" align="center" >
                                  
<?php            
if($dat->VmvCierre == "1"){
?>
<img  src="imagenes/estado/cerrado.png" width="18" height="18" border="0" title="Cerrado" align="Cerrado" />
<?php	
}
?>

                </td>
                <td  width="15%" align="center" >
                  
                  <?php
if($PrivilegioAuditoriaVer){
?>
                  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->VmvId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
                  <?php
if($PrivilegioEliminar and $dat->VmvNotaCreditoCompra == "No" and $dat->VmvCierre == "2"){
?>
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VmvId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
                  <?php
}
?>               
                  
                  <?php
if($PrivilegioEditar  and $dat->VmvNotaCreditoCompra == "No" and $dat->VmvCierre == "2"){
?>             
                  
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->VmvId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
                  
                  <?php
}
?>				
                  
                  <?php
if($PrivilegioVer){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VmvId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                  <?php
}
?>
                  
                  
                  
                  
                  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->VmvId;?>');"><img src="imagenes/acciones/preliminar.png" alt="[Vista Preliminar]" title="Vista Preliminar" width="19" height="19" border="0" /></a>
                  
                  
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncImprmir('<?php echo $dat->VmvId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  
                  <?php
			}
			?> 
                  
                  
                                    <?php
//	if($PrivilegioGenerarGuiaRemision and $dat->AmoGuiaRemision="No"){
	if($PrivilegioGenerarGuiaRemision ){
    ?>
                  <a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=VehiculoMovimientoSalida&VmvId=<?php echo $dat->VmvId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]"   /></a>
                  <?php
	}
	?>
    
    
                  
                  <?php
			/*if($PrivilegioGenerarNotaCredito  and $dat->VmvNotaCreditoCompra == "No"){
			?>        
                  <a href="principal.php?Mod=NotaCreditoCompra&Form=Registrar&Origen=VehiculoMovimientoSalida&VmvId=<?php echo $dat->VmvId; ?>"><img src="imagenes/iconos/nota_credito_compra.png" width="19" height="19" border="0" title="Nota de Credito" alt="[Nota de Credito]"   /></a>
                  
                  <?php
			}*/
			?>
                  
                  
                  
                  <?php
			/*if($PrivilegioGenerarReclamo){
			?>        
                  <a href="principal.php?Mod=Reclamo&Form=Registrar&Origen=VehiculoMovimientoSalida&VmvId=<?php echo $dat->VmvId; ?>"><img src="imagenes/iconos/reclamo.png" width="19" height="19" border="0" title="Reclamo" alt="[Reclamo]"   /></a>
                  
                  <?php
			}*/
			?>
                  
                  
                </td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									$SubTotal = number_format($SubTotal,2);

									?>
            </tbody>
      </table></td>
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