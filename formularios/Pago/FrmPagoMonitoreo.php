<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") ){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarFactura = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Registrar"))?true:false;?>
<?php $PrivilegioGenerarBoleta = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Boleta","Registrar"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPago.js" ></script>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
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
* Otras variables
*/
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Estado = $_POST['Estado'];

//$POST_Area = $_POST['Area'];
//$POST_Moneda = $_POST['Moneda'];
$POST_Origen = $_POST['Origen'];
$POST_Sucursal = $_POST['CmpSucursal'];

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'PagTiempoCreacion';
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

if(empty($POST_con)){
	$POST_con = "contiene";
}

if(empty($POST_Estado)){
	$POST_Estado = 1;
}


if($_POST){
   $_SESSION[$GET_mod."Area"] = $POST_Area;
}else{
	$POST_Area = (empty($_GET['Area'])?$_SESSION[$GET_mod."Area"]:$_GET['Area']);
}

 
if($_POST){
   $_SESSION[$GET_mod."Origen"] = $POST_Origen;
}else{
	$POST_Origen = (empty($_GET['Origen'])?$_SESSION[$GET_mod."Origen"]:$_GET['Origen']);
}  

if($_POST){
   $_SESSION[$GET_mod."Moneda"] = $POST_Moneda;
}else{
	//$POST_Moneda = (empty($_GET['Moneda'])?$_SESSION[$GET_mod."Moneda"]:$_GET['Moneda']);
}  

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsPago = new ClsPago();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsArea = new ClsArea();
$InsSucursal = new ClsSucursal();


//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0,$oNoTieneComprobante=false)
$ResPago = $InsPago->MtdObtenerPagos("PagId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,1,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,$POST_Area,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"PagFecha",$POST_Origen,NULL,$POST_Sucursal,NULL,NULL,NULL,0,true,false);

$ArrPagos = $ResPago['Datos'];
$PagosTotal = $ResPago['Total'];
$PagosTotalSeleccionado = $ResPago['TotalSeleccionado'];


 
$ResCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaId","ASC",NULL,1);
$ArrCondicionPagos = $ResCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

//MtdObtenerAreas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","ASC",NULL,NULL);
$ArrAreas = $ResArea['Datos'];



$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


?>


<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">




</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">MONITOREO  DE ORDENES DE COBRO</span></td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $PagosTotalSeleccionado;?></b> de <b><?php echo $PagosTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
   
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="65%" align="right">&nbsp;</td>
        <td width="35%" align="right">&nbsp;</td>
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
      <option value="AmoId" <?php if($POST_cam=="AmoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CprId" <?php if($POST_cam=="CprId"){ echo 'selected="selected"';}?>>Cot. de Repuesto</option>
      </select>-->
<!--    Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_Estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
      <option value="3" <?php if($POST_Estado==3){ echo 'selected="selected"';}?>>Realizado</option> 
      <option value="6" <?php if($POST_Estado==6){ echo 'selected="selected"';}?>>Anulado</option>  
      </select>-->
      
      
      
      Area:
	<select class="EstFormularioCombo" name="Area" id="Area">
    <option value="">Todos</option>
   
    <?php
			  foreach($ArrAreas as $DatArea){
			  ?>
    <option value="<?php echo $DatArea->AreId?>" <?php if($POST_Area==$DatArea->AreId){ echo 'selected="selected"';}?> ><?php echo $DatArea->AreNombre?></option>
    <?php
			  }
			  ?>
  </select>
  
      Origen
    <select class="EstFormularioCombo" name="Origen" id="Origen">
      <option value="" >Todos</option>
      <option value="REPUESTOS" <?php if($POST_Origen=="REPUESTOS"){ echo 'selected="selected"';}?>>Repuestos</option>
      <option value="VEHICULOS" <?php if($POST_Origen=="VEHICULOS"){ echo 'selected="selected"';}?>>Vehiculos</option> 

      </select>      
         Moneda:   
              <select class="EstFormularioCombo" name="Moneda" id="Moneda" >
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_Moneda==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                  </select> 
                  
      Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php  echo $POST_ffin; ?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />	  <span class="EstFormularioEtiqueta">   Sucursal:
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
                <th width="2%" >#</th>
                <th width="2%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="3%" ><?php
				if($POST_ord == "PagId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagId','ASC');"> Id. </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "PagFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagFecha','ASC');"> Fecha </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Venta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiId','DESC');"> Ord. Venta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Venta </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "OvvId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Venta Veh. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvId','DESC');"> Ord. Venta Veh. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Venta Veh. </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "TdoNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','DESC');"> Tipo Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc. </a>
                  <?php
				}
				?></th>
                <th width="19%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente </a>
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
                <th width="5%" ><?php
				if($POST_ord == "PagTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PagTipoCambio','ASC');"> T.C. </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "PagMonto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagMonto','ASC');"> Monto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagMonto','DESC');"> Monto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PagMonto','ASC');"> Monto </a>
                  <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Cotizador <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> Cotizador <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Cotizador </a>
                  <?php
				}
				?></th>
                <th width="8%" >
                  <?php
				if($POST_ord == "AmoTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');">
                  Fecha  Registro
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','DESC');">
                    
                 Fecha  Registro
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');">
                  Fecha  Registro
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="8%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="15" align="center">

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

				  <option <?php if($POST_num==$PagosTotal){ echo 'selected="selected"';}?> value="<?php echo $PagosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $PagosTotal;
					//}else{
					//	$tregistros = ($PagosTotalSeleccionado);
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

				foreach($ArrPagos as $dat){
				?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >
                  
                <input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->AmoId; ?>" />				</td>
                <td width="3%" align="right" valign="middle"   ><?php echo $dat->PagId;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->PagFecha; ?></td>
                <td align="right" valign="middle"   ><a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId?>');" > <?php echo $dat->VdiId;  ?> </a></td>
                <td align="right" ><a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $dat->OvvId?>');" > <?php echo $dat->OvvId;  ?> </a></td>
                <td  width="3%" align="right" ><?php echo $dat->TdoNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CliNumeroDocumento;  ?></td>
                <td  width="19%" align="right" ><?php echo $dat->CliNombre;  ?> <?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                <td  width="8%" align="right" >
				<?php $dat->PagMonto = (($dat->PagMonto/(empty($dat->PagTipoCambio)?1:$dat->PagTipoCambio)));?>

            
				<?php echo number_format($dat->PagMonto,2); ?>
                
                
                </td>
                <td  width="9%" align="right" ><?php echo $dat->PerNombre;  ?>
                  <?php //echo $dat->PerApellidoPaterno;  ?>
                  <?php //echo $dat->PerApellidoMaterno;  ?></td>
                <td  width="8%" align="right" ><?php echo ($dat->PagTiempoCreacion);?></td>
        <td  width="8%" align="center" >
		
	
 <?php
if($PrivilegioEditar){
?>
	
    <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=AtenderOrdenCobro&Id=<?php echo $dat->PagId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&VdiId=<?php echo $GET_VdiId;?>">
    
    
    <img src="imagenes/generar.jpg" width="19" height="19" border="0" title="Atender Orden de Cobro" alt="[Atender Orden de Cobro]"   />
    
    
   </a>
    
<?php
}
?>
    
    
	
	<?php
    if($PrivilegioGenerarFactura){
    ?>
    
<a href="principal.php?Mod=Factura&Form=Registrar&Ori=Pago&PagId=<?php echo $dat->PagId;?>"><img src="imagenes/generar_factura.png" width="25" height="25" border="0" title="Generar Factura" alt="[Generar Factura]"   /></a>

        
    <?php
    }
    ?>
    
    <?php
    if($PrivilegioGenerarBoleta){
    ?>
        <a href="principal.php?Mod=Boleta&Form=Registrar&Ori=Pago&PagId=<?php echo $dat->PagId;?>"><img src="imagenes/generar_boleta.png" width="25" height="25" border="0" title="Generar Boleta" alt="[Generar Boleta]"   /></a>
    <?php
    }
    ?>    
        
<?php
/*if($PrivilegioVistaPreliminar){
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
}*/
?>
            
            </td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									

									?>
            </tbody>
      </table>

</td>
</tr>
</table>
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

