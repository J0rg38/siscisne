<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo",$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo","Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo","Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo","GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo","Imprimir"))?true:false;?>

<?php $PrivilegioProveedorVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Proveedor","Ver"))?true:false;?>
<?php $PrivilegioOrdenCompraVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCompra","Ver"))?true:false;?>
<?php $PrivilegioGenerarNotaCredito = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCreditoCompra","Registrar"))?true:false;?>

<?php $PrivilegioGenerarReclamo = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Reclamo","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoSimple.js" ></script>
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
if(empty($POST_ord)){$POST_ord = 'CvhId';}
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
if(empty($POST_TipoFecha)){$POST_TipoFecha = "CvhFecha";}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCompraVehiculoSimple.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsCompraVehiculo = new ClsCompraVehiculo();
$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCompraVehiculoSimple.php');

	
//MtdObtenerCompraVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CvhId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="CvhFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oSubTipo=NULL) {
$ResCompraVehiculo = $InsCompraVehiculo->MtdObtenerCompraVehiculos("CvhId,prv.PrvNombre,prv.PrvApellidoPaterno,prv.PrvApellidoMaterno,CvhComprobanteNumero,CvhGuiaRemisionNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,NULL,"CvhFecha",0,NULL,NULL,$POST_Sucursal,$POST_Almacen,2);
$ArrCompraVehiculos = $ResCompraVehiculo['Datos'];
$CompraVehiculosTotal = $ResCompraVehiculo['Total'];
$CompraVehiculosTotalSeleccionado = $ResCompraVehiculo['TotalSeleccionado'];

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

<div class="EstSubMenuBoton"><a href="javascript:FncMarcarRevisadoSeleccionados();"><img src="imagenes/iconos/revisado.png" alt="[Marcar como Revisado]" title="Marcar como Revisado" />Revisado</a></div> 

<?php
}
?>



</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE INGRESOS DE UNIDADES VEHICULARES</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $CompraVehiculosTotalSeleccionado;?></b> de <b><?php echo $CompraVehiculosTotal;?></b> registros.</td>
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
    
    
     <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    
    <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>
<!--    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="CvhId" <?php if($POST_cam=="CvhId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="PrvNombre" <?php if($POST_cam=="PrvNombre"){ echo 'selected="selected"';}?>>Proveedor</option>      
      <option value="CvhComprobanteNumero" <?php if($POST_cam=="CvhComprobanteNumero"){ echo 'selected="selected"';}?>>Num. Comprobante</option>      
      <option value="CvhGuiaRemisionNumero" <?php if($POST_cam=="CvhGuiaRemisionNumero"){ echo 'selected="selected"';}?>>Num. G. Remision</option>      
      
      
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
    <option value="CvhFecha" <?php if($POST_TipoFecha=="CvhFecha"){ echo 'selected="selected"';}?>>Fecha Ingreso</option>
    <option value="CvhComprobanteFecha" <?php if($POST_TipoFecha=="CvhComprobanteFecha"){ echo 'selected="selected"';}?>>Fecha Comprobante</option>  
    </select>
    
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin; ?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    
    
        Sucursal:
       
       <select class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select>
            
            
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

                <th width="2%" >
                  
                  <?php
				if($POST_ord == "CvhId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CvhId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "CvhFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhFecha','ASC');"> Fec. Ingreso <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhFecha','DESC');"> Fec. Ingreso <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CvhFecha','ASC');"> Fec. Ingreso </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
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
                <th width="7%" > <?php
				if($POST_ord == "CvhComprobanteNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhComprobanteNumero','ASC');"> Num. Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhComprobanteNumero','DESC');"> Num. Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CvhComprobanteNumero','ASC');"> Num. Comprob. </a>
                  <?php
				}
				?></th>
                <th width="7%" > <?php
				if($POST_ord == "CvhComprobanteFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhComprobanteFecha','ASC');"> Fec. Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhComprobanteFecha','DESC');"> Fec. Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CvhComprobanteFecha','ASC');"> Fec. Comprob. </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
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
				if($POST_ord == "CvhTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhTipoCambio','DESC');">  T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CvhTipoCambio','ASC');">  T.C. </a>
                <?php
				}
				?></th>
                <th width="18%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Proveedor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor  </a>
                  <?php
				}
				?></th>
                <th width="4%" >
                  
                  
                  <?php
				if($POST_ord == "CvhNotaCreditoCompra"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhNotaCreditoCompra','ASC');">  N. Cre. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhNotaCreditoCompra','DESC');">  N. Cre. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CvhNotaCreditoCompra','ASC');">  N. Cre.  </a>
                  <?php
				}
				?>
                  
                </th>
                <th width="4%" ><?php
				if($POST_ord == "CvhTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CvhTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "CvhEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CvhEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="2%" >Fac.</th>
                <th width="2%" >G. Rem.</th>
                <th width="2%" ><?php
				if($POST_ord == "CvhTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CvhTotalItems','ASC');"> <span title="Items">It.</span></a>
                  <?php
				}
				?></th>
                <th width="6%" > <?php
				if($POST_ord == "CvhTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CvhTiempoCreacion','ASC');"> Fecha Creacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CvhTiempoCreacion','DESC');"> Fecha Creacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CvhTiempoCreacion','ASC');"> Fecha Creacion </a>
                  <?php
				}
				?></th>
                <th width="2%" >Cierre</th>
                <th width="14%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="19" align="center">

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

				  <option <?php if($POST_num==$CompraVehiculosTotal){ echo 'selected="selected"';}?> value="<?php echo $CompraVehiculosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $CompraVehiculosTotal;
					//}else{
					//	$tregistros = ($CompraVehiculosTotalSeleccionado);
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
								foreach($ArrCompraVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CvhId; ?>" nota_credito_compra="<?php echo $dat->CvhNotaCreditoCompra;?>" cierre="<?php echo $dat->CvhCierre;?>" />				</td>

                <td align="right" valign="middle" width="2%"   >
                  <a href="principal.php?Mod=CompraVehiculo&Form=Ver&Id=<?php echo $dat->CvhId;  ?>">
                  <?php echo $dat->CvhId;  ?>



                  </a>
                </td>
                <td  width="5%" align="right" ><?php echo ($dat->CvhFecha);?></td>
                <td  width="7%" align="right" ><?php echo $dat->CtiNombre;  ?></td>
                <td  width="7%" align="right" >
				
				<?php echo $dat->CvhComprobanteNumero;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->CvhComprobanteFecha;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CvhTipoCambio;  ?></td>
                <td  width="18%" align="right" >
                  
                  
                  <?php
if($PrivilegioProveedorVer){
?>
                  <a href="javascript:FncProveedorCargarFormulario('Ver','<?php echo $dat->PrvId?>');"  ><?php echo ($dat->PrvNombreCompleto);?></a>
  <?php	
}else{
?>
  <?php echo ($dat->PrvNombreCompleto);?>
  <?php	
}
?>
                  
                  
                  
</td>
                <td  width="4%" align="right" >
                  
                  
                  
                  <?php
if($dat->CvhNotaCreditoCompra == "Si"){
?>
                  <!-- class="thickbox"-->
                  <a href="javascript:FncNotaCreditoCompraListado('<?php echo $dat->CvhId?>');" title="">Tiene N. Cred.</a>    
                  
  <?php	
}else{
?>
                  No Tien N. Cred.
                  
                  <?php	
}
?>    
                  
                </td>
                <td  width="4%" align="right" >
                  
                  <?php $dat->CvhTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CvhTotal:($dat->CvhTotal/$dat->CvhTipoCambio));?>                          
                  <?php echo number_format($dat->CvhTotal,2);?>
                  <?php
					$Total += $dat->CvhTotal ;
			
				?>
                </td>
                <td  width="3%" align="right" ><?php echo $dat->CvhEstadoIcono;?> <?php echo $dat->CvhEstadoDescripcion;?>
                  <?php
				/*switch($dat->CvhEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[Transito]" title="En transito" src="imagenes/pendiente.gif" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />
                  <?php							
						break;	

					}*/
				?></td>
                <td  width="2%" align="right" ><?php            
if(!empty($dat->CvhFoto)){
	
	$extension = strtolower(pathinfo($dat->CvhFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->CvhFoto, '.'.$extension);  
?>
                  <a target="_blank" href="subidos/compra_vehiculo_fotos/<?php echo $dat->CvhFoto;?>"  title=""><img  src="imagenes/documento.gif" width="20" height="20" border="0"  /></a>
                <?php	
}
?></td>
                <td  width="2%" align="right" ><?php            
if(!empty($dat->CvhGuiaRemisionFoto)){
	
	$extension = strtolower(pathinfo($dat->CvhGuiaRemisionFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->CvhGuiaRemisionFoto, '.'.$extension);  
?>
                  <a target="_blank" href="subidos/compra_vehiculo_fotos/<?php echo $dat->CvhGuiaRemisionFoto;?>"  title=""><img  src="imagenes/documento.gif" width="20" height="20" border="0"  /></a>
                <?php	
}
?></td>
                <td  width="2%" align="right" ><?php echo ($dat->CvhTotalItems);?></td>
                <td align="right" ><?php echo ($dat->CvhTiempoCreacion);?></td>
                <td  width="2%" align="center" >
                                  
<?php            
if($dat->CvhCierre == "1"){
?>
<img  src="imagenes/estado/cerrado.png" width="18" height="18" border="0" title="Cerrado" align="Cerrado" />
<?php	
}
?>

                </td>
                <td  width="14%" align="center" >
                  
                  <?php
if($PrivilegioAuditoriaVer){
?>
                  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->CvhId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
                  <?php
if($PrivilegioEliminar and $dat->CvhNotaCreditoCompra == "No" and $dat->CvhCierre == "2"){
?>
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CvhId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
                  <?php
}
?>               
                  
                  <?php
if($PrivilegioEditar  and $dat->CvhNotaCreditoCompra == "No" and $dat->CvhCierre == "2"){
?>             
                  
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->CvhId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
                  
                  <?php
}
?>				
                  
                  <?php
if($PrivilegioVer){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CvhId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                  <?php
}
?>
                  
                  
                  
                  
                  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->CvhId;?>');"><img src="imagenes/acciones/preliminar.png" alt="[Vista Preliminar]" title="Vista Preliminar" width="19" height="19" border="0" /></a>
                  
                  
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncImprmir('<?php echo $dat->CvhId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  
                  <?php
			}
			?> 
                  
                  
                  
                  <?php
			if($PrivilegioGenerarNotaCredito  and $dat->CvhNotaCreditoCompra == "No"){
			?>        
                  <a href="principal.php?Mod=NotaCreditoCompra&Form=Registrar&Origen=CompraVehiculo&CvhId=<?php echo $dat->CvhId; ?>"><img src="imagenes/iconos/nota_credito_compra.png" width="19" height="19" border="0" title="Nota de Credito" alt="[Nota de Credito]"   /></a>
                  
                  <?php
			}
			?>
                  
                  
                  
                  <?php
			/*if($PrivilegioGenerarReclamo){
			?>        
                  <a href="principal.php?Mod=Reclamo&Form=Registrar&Origen=CompraVehiculo&CvhId=<?php echo $dat->CvhId; ?>"><img src="imagenes/iconos/reclamo.png" width="19" height="19" border="0" title="Reclamo" alt="[Reclamo]"   /></a>
                  
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