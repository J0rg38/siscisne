<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>

<?php $PrivilegioGenerarOrdenVentaVehiculo = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","Registrar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionVehiculo.js" ></script>
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
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

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
$POST_NivelInteres = $_POST['NivelInteres'];
$POST_Moneda = $_POST['Moneda'];	
$POST_Sucursal =$_POST['CmpSucursal']; 
$POST_Personal =$_POST['CmpPersonal']; 


if(!$_POST){
	$POST_Moneda = "MON-10001";
}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

if(!$_POST){
	$POST_Personal = $_SESSION['SesionPersonal'];
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CveTiempoCreacion';
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

if(empty($POST_Moneda)){
	$POST_Moneda = $EmpresaMonedaId;
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCotizacionVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();

$InsCotizacionVehiculo->UsuId = $_SESSION['SesionId'];	

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCotizacionVehiculo.php');

$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"AccesoTotal"))?true:false;

//$POST_Personal
if($PrivilegioAccesoTotal){
									
//MtdObtenerCotizacionVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oSucursal=NULL,$oDiasTranscurridos=0)
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculos("CveId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento,per.PerNombre,per.PerApellidoPaterno,per.PerApellidoMaterno,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,$POST_Personal,$POST_NivelInteres,$POST_Sucursal);									
									
}else{
	//MtdObtenerCotizacionVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oSucursal=NULL)
	$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculos("CveId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento,per.PerNombre,per.PerApellidoPaterno,per.PerApellidoMaterno",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,$POST_Personal,$POST_NivelInteres,$POST_Sucursal);
	
}




$ArrCotizacionVehiculos = $ResCotizacionVehiculo['Datos'];
$CotizacionVehiculosTotal = $ResCotizacionVehiculo['Total'];
$CotizacionVehiculosTotalSeleccionado = $ResCotizacionVehiculo['TotalSeleccionado'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1,NULL,$POST_Sucursal,NULL,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];
//$InsMoneda->MonId = $POST_Moneda;
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
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncActualizarNivelInteresSeleccionados();"><img src="imagenes/submenu/icon_nivel_interes.png" alt="[Actualizar Nivel de Interes seleccionados]" title="Actualizar Nivel de Interes seleccionados" />Niv. Interes</a></div> 


<!--<div class="EstSubMenuBoton"><a href="javascript:FncCotizacionVehiculoActualizarPendienteSeleccionados();"><img src="imagenes/submenu/pendiente.png" alt="[Actualizar a Pendiente]" title="Actualizar a Pendiente" /> Pendiente</a></div>-->

<div class="EstSubMenuBoton"><a href="javascript:FncCotizacionVehiculoActualizarEmitidoSeleccionados();"><img src="imagenes/submenu/realizar.png" alt="[Actualizar a Listo]" title="Actualizar a Listo" /> Listo</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncCotizacionVehiculoActualizarAnuladoSeleccionados();"><img src="imagenes/submenu/anular.png" alt="[Actualizar a Anulado]" title="Actualizar a Anulado" /> Anulado</a></div> 



<?php
}
?>





</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE COTIZACION DE VEHICULOS</span>  </td>
</tr>
<tr>
  <td width="41%">
    Mostrando <b><?php echo $CotizacionVehiculosTotalSeleccionado;?></b> de <b><?php echo $CotizacionVehiculosTotal;?></b> registros.</td>
  <td width="59%" align="right">
    
    
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
            
            
    <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="CveId" <?php if($POST_cam=="CveId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="PrvNombre" <?php if($POST_cam=="PrvNombre"){ echo 'selected="selected"';}?>>Cliente</option>      

      
      
      </select>-->
    Estado:
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Entregado</option>  
        <option value="6" <?php if($POST_estado==6){ echo 'selected="selected"';}?>>Anualdo</option>  
      </select>
      
       Nivel Interes:
    <select class="EstFormularioCombo" name="NivelInteres" id="NivelInteres">
      <option value="0" <?php if($POST_NivelInteres==0){ echo 'selected="selected"';}?>>Todos</option>
      <option value="1" <?php if($POST_NivelInteres==1){ echo 'selected="selected"';}?>>Normal</option>
      <option value="2" <?php if($POST_NivelInteres==2){ echo 'selected="selected"';}?>>Interesado</option>
      <option value="3" <?php if($POST_NivelInteres==3){ echo 'selected="selected"';}?>>Muy Interesado</option>  
      <option value="3" <?php if($POST_NivelInteres==4){ echo 'selected="selected"';}?>>Venta Concluida</option>  
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
      
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    
    
        
        Asesor de Ventas: <select <?php echo (($PrivilegioAccesoTotal)?'':'disabled="disabled"');?>   class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$POST_Personal)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select>	Sucursal:
       
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

                <th width="4%" >
                  
                  <?php
				if($POST_ord == "CveId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CveId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" >
                
                                <?php
				if($POST_ord == "CveFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CveFecha','ASC');"> Fecha </a>
                  <?php
				}
				?>                </th>
                <th width="4%" ><?php
				if($POST_ord == "CveDiaTranscurridos"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveDiaTranscurridos','ASC');"> <span title="Cantidad de Dias Transcurridos">Cant. Dias. Transc.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveDiaTranscurridos','DESC');"> <span title="Cantidad de Dias Transcurridos"> Cant. Dias. Transc. </span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CveDiaTranscurridos','ASC');"> <span title="Cantidad de Dias Transcurridos">Cant. Dias. Transc.</span>  </a>
                <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Documento <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> Num. Documento  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Documento  </a>
                <?php
				}
				?></th>
                <th width="25%" ><?php
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
                <th width="6%" ><?php
				if($POST_ord == "CliCelular"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliCelular','ASC');"> Celular <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliCelular','DESC');"> Celular <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliCelular','ASC');"> Celular </a>
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
                <th width="6%" ><?php
				if($POST_ord == "VmaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmaNombre','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "VmoNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmoNombre','DESC');"> Modelo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "VveNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VveNombre','ASC');"> Version <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VveNombre','DESC');"> Version <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VveNombre','ASC');"> Version </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "CveAnoFabricacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveAnoFabricacion','ASC');"> A&ntilde;o Fab. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveAnoFabricacion','DESC');"> A&ntilde;o Fab. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CveAnoFabricacion','ASC');"> A&ntilde;o Fab. </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "CveAnoModelo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveAnoModelo','ASC');"> A&ntilde;o Mod. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveAnoModelo','DESC');"> A&ntilde;o Mod. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CveAnoModelo','ASC');"> A&ntilde;o Mod. </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "CveColor"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveColor','ASC');"> Color <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveColor','DESC');"> Color <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CveColor','ASC');"> Color </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "CveTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CveTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "CveOrdenVentaVehiculo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveOrdenVentaVehiculo','ASC');"> O. Ven. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveOrdenVentaVehiculo','DESC');"> O. Ven. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CveOrdenVentaVehiculo','ASC');"> O. Ven. </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "CveEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CveEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');">Asesor de Ventas<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> Asesor de Ventas<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Asesor de Ventas</a>
                <?php
				}
				?></th>
                <th width="4%" >
                  <?php
				if($POST_ord == "CveTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('CveTiempoCreacion','ASC');">
                  Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveTiempoCreacion','DESC');">
                    
                 Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('CveTiempoCreacion','ASC');">
                 Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="21" align="center">

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

				  <option <?php if($POST_num==$CotizacionVehiculosTotal){ echo 'selected="selected"';}?> value="<?php echo $CotizacionVehiculosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $CotizacionVehiculosTotal;
					//}else{
					//	$tregistros = ($CotizacionVehiculosTotalSeleccionado);
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
								foreach($ArrCotizacionVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center" bgcolor="<?php //echo $dat->CveNivelColor;?>"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CveId; ?>" orden_venta="<?php echo $dat->OvvId; ?>" estado="<?php echo $dat->OvvEstado; ?>" tiene_orden_venta="<?php echo $dat->CveOrdenVentaVehiculo; ?>" />				</td>

                <td align="left" valign="middle" width="4%"   >
				
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CveId;?>">
				<?php echo $dat->CveId;  ?>
                </a>
                
                <?php 
				switch($dat->CveNivelInteres){
					case 1:
				?>
               
                <?php	
					break;
					
					case 2:
				?>
               <img src="imagenes/estado/icon_nivel3.png" width="25" height="25" align="Nivel 1" title="Nivel 1" />
                <?php	
					break;
					
						case 3:
				?>
               <img src="imagenes/estado/icon_nivel2.png" width="25" height="25" align="Nivel 2" title="Nivel 2" />
                <?php	
					break;
					
						case 4:
				?>
               <img src="imagenes/estado/icon_nivel1.png" width="25" height="25" align="Nivel 3" title="Nivel 3" />
                <?php	
					break;
					
				}
				?>
                
                </td>
                <td  width="5%" align="right" ><?php echo $dat->CveFecha;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CveDiaTranscurridos;  ?> dias</td>
                <td  width="9%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="25%" align="right" ><?php
if($PrivilegioClienteVer){
?>
                  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  ><?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?></a>
                  <?php	
}else{
?>
                  <?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?>
                <?php	
}
?></td>
                <td  width="6%" align="right" ><?php echo $dat->CveCelular;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->VmaNombre;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->VmoNombre;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->VveNombre;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CveAnoFabricacion;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CveAnoModelo;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CveColor;  ?></td>
                <td  width="7%" align="right" >
                  
                  
					<?php $dat->CveTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CveTotal:($dat->CveTotal/$dat->CveTipoCambio));?>
					<?php echo number_format($dat->CveTotal,2);?>
                 
                </td>
                <td  width="6%" align="right" >
                  
                  
                  
                  
                  <?php
if($dat->CveOrdenVentaVehiculo == "Si"){
?>
                  
  <a href="formularios/CotizacionVehiculo/DiaOrdenVentaVehiculoListado.php?height=440&width=850&CveId=<?php echo $dat->CveId?>" class="thickbox" title="">
    
    Tiene Ord.  Venta
  </a> 
                  
  <?php	
}else{
?>
                  No Tiene Ord.  Venta
                  
  <?php	
}
?>
                </td>
                <td  width="6%" align="right" >
				
				<?php
				
					switch($dat->CveEstado){
					
					  case 1:
						?>
                         <img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />
                        <?php
					  break;
					
					  case 3:
						 
						 ?>
                <img width="15" height="15" alt="[Listo]" title="Listo" src="imagenes/estado/realizado.gif" />
                <?php
						 
					  break;	
					  
					  case 6:
				
				?>
					<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />
                <?php
				
				break;
					
					  default:
						  ?>
                          -
                          <?php
					  break;					
					
					}
					
				?>
				
				<?php
				  echo $dat->CveEstadoDescripcion;
				  ?>
                  
                  </td>
                <td  width="4%" align="right" >
				<?php echo $dat->PerNombre;?> <?php echo $dat->PerApellidoPaterno;?> <?php echo $dat->PerApellidoMaterno;?>
                
                </td>
                <td  width="4%" align="right" ><?php echo ($dat->CveTiempoCreacion);?></td>
        <td  width="12%" align="center" >


        
<?php
if($PrivilegioAuditoriaVer){
?>
	<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->CveId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
<?php
}
?>



<?php
if($PrivilegioEliminar){
?>
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CveId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Cotpletamente"   /></a>
<?php
}
?>               
				
<?php
if($PrivilegioEditar  and $dat->CveEstado <> 6){
?>             
                       
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->CveId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
				
<?php
}
?>				
	
<?php
if($PrivilegioVer){
?>		                
            <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CveId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
    

<?php
}
?>



<?php
			if($PrivilegioVistaPreliminar and $dat->CveEstado <> 6){
			?>
         
         	<a href="javascript:FncVistaPreliminar('<?php echo $dat->CveId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>	
                
                <!--<a href="javascript:FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir.php?Id=<?php echo $dat->CveId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>-->
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir and $dat->CveEstado <> 6){
			?>        
     
				<!--<a href="javascript:FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir.php?Id=<?php echo $dat->CveId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>-->
                <a href="javascript:FncImprmir('<?php echo $dat->CveId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                
			<?php
			}
			?> 
            
            
            
   <?php
 
if($PrivilegioGenerarPDF and $dat->CveEstado <> 6 ){
?>
	<a href="javascript:FncGenerarPDF('<?php echo $dat->CveId;?>');"><img src="imagenes/pdf.gif" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
<?php
}
?>  

<?php
//deb($dat->CveGenerarOrdenVentaVehiculo);
//if($PrivilegioGenerarOrdenVentaVehiculo and $dat->CveGenerarOrdenVentaVehiculo == "Si" and $dat->CveEstado <> 6){
	if($PrivilegioGenerarOrdenVentaVehiculo  and $dat->CveEstado <> 6){
?>		  

	<?php
    //if($dat->VdiGenerarOrdenVentaVehiculo == "Si"){
    
    ?>
    <a href="principal.php?Mod=OrdenVentaVehiculo&Form=Registrar&Origen=CotizacionVehiculo&CveId=<?php echo $dat->CveId;?>"><img src="imagenes/iconos/orden_venta.png" width="19" height="19" border="0" title="Generar Orden de Venta" alt="[Generar Orden de Venta]"   /></a>                
    <?php	
    //}
    ?>
             
<?php
}
?>

<?php
if($PrivilegioEditar and $dat->CveEstado <> 6){
?>             

	<a href="javascript:FncCotizacionVehiculoCargarFormulario('<?php echo (($PrivilegioEditar)?'Editar':'Ver');?>Nota','<?php echo $dat->CveId?>');"  ><img src="imagenes/acciones/notas.png" alt="[Notas]" title="Notas" width="19" height="19" border="0" /></a>
			
<?php
}
?>
  <?php
if($PrivilegioEditar and $dat->CveEstado <> 6){
?>	
  <a href="javascript:FncCotizacionVehiculoCargarFormulario('SeguimientoCliente','<?php echo $dat->CveId;?>');"><img src="imagenes/acciones/llamadas.png" alt="[Llamadas]" title="Llamadas" width="19" height="19" border="0" /></a>
  <?php
}
?> 
 

			</td>
              </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->CveSubTotal;
									$Impuesto += $dat->CveImpuesto ;
									$Total += $dat->CveTotal ;
									

									}
									$SubTotal = number_format($SubTotal,2);
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									

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

