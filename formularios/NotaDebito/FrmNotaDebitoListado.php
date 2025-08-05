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
<?php $PrivilegioAnular = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Anular"))?true:false;?>
<?php $PrivilegioEditarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarEspecial"))?true:false;?>
<?php $PrivilegioRegistrarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"RegistrarEspecial"))?true:false;?>

<?php $PrivilegioClienteEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Editar"))?true:false;?>
<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaDebito.js"></script>
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
$POST_npago = $_POST['CondicionPago'];
$POST_Moneda = $_POST['Moneda'];
$POST_ChkMostrarNoProcesados = $_POST['ChkMostrarNoProcesados'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'NdbTiempoCreacion';
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


$MostrarNoProcesados = false;

if($POST_ChkMostrarNoProcesados=="1"){
	$MostrarNoProcesados = true;
}

include($InsProyecto->MtdFormulariosMsj("NotaDebito").'MsjNotaDebito.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsNotaDebito = new ClsNotaDebito();
$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$InsNotaDebito->SucId = $_SESSION['SesionSucursal'];
$InsNotaDebito->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdRutFormularios().'NotaDebito/acc/AccNotaDebito.php');

// MtdObtenerNotaDebitos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {

$ResNotaDebito = $InsNotaDebito->MtdObtenerNotaDebitos("cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,ndb.NdbId","contiene",$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$_SESSION['SesionSucursal'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,$POST_Moneda);
$ArrNotaDebitos = $ResNotaDebito['Datos'];
$NotaDebitosTotal = $ResNotaDebito['Total'];
$NotaDebitosTotalSeleccionado = $ResNotaDebito['TotalSeleccionado'];

$ResNotaDebitoTalonario = $InsNotaDebitoTalonario->MtdObtenerNotaDebitoTalonarios(NULL,NULL,"NdtNumero","DESC",NULL,$POST_Sucursal);
$ArrNotaDebitoTalonarios = $ResNotaDebitoTalonario['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",1,NULL);
$ArrCondicionPagos = $RepCondicionPago['Datos'];
	
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


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


<?php
}
?>

<?php
if($PrivilegioAnular){
?>   

       
<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
<img src="imagenes/submenu/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>

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
    
    
  <span class="EstFormularioTitulo">LISTADO DE NOTAS DE DEBITO</span>  </td>
</tr>
<tr>
  <td width="46%">
    Mostrando <b><?php echo $NotaDebitosTotalSeleccionado;?></b> de <b><?php echo $NotaDebitosTotal;?></b> Notas de Debito.</td>
  <td width="54%" align="right">
    <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="21%" align="right" class="EstTablaTotalesEtiqueta">SUB TOTAL: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="17%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoSubTotal" ></div></td>
        <td width="20%" align="right" class="EstTablaTotalesEtiqueta">IMPUESTO: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="15%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoImpuesto" ></div></td>
        <td width="14%" align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="13%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoTotal" ></div></td>
      </tr>
      </table></td>
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


<!--	<select class="EstFormularioCombo" name="Cam" id="Cam">
	<option value="NdbId" <?php if($POST_cam=="NdbId"){ echo 'selected="selected"';}?>>Id</option>
	<option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
	<option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. de Documento</option>
    <option value="NdbOrdenNumero" <?php if($POST_cam=="NdbOrdenNumero"){ echo 'selected="selected"';}?>>Num. Orden</option>
    <option value="NdbSIAFNumero" <?php if($POST_cam=="NdbSIAFNumero"){ echo 'selected="selected"';}?>>Num. SIAF</option>
     </select>-->
     Talonario
     <select  class="EstFormularioCombo" name="Talonario" id="Talonario">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrNotaDebitoTalonarios as $DatNotaDebitoTalonario){
			  ?>
                  <option <?php if($POST_tal==$DatNotaDebitoTalonario->NdtId){ echo 'selected="selected"';}?> 			  value="<?php echo $DatNotaDebitoTalonario->NdtId;?>" ><?php echo $DatNotaDebitoTalonario->NdtNumero;?></option>
                  <?php
			  }
			  ?>
                  </select>
		Estado
       <select class="EstFormularioCombo" name="Estado" id="Estado">
       <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      	<option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
       <option value="5" <?php if($POST_estado==5){ echo 'selected="selected"';}?>>Entregado</option>
       <option value="6" <?php if($POST_estado==6){ echo 'selected="selected"';}?>>Anulado</option>       
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
            
            Fecha Inicio
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/01/2014";}else{ echo $POST_finicio; }?>" size="10" maxlength="10"/>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="10" maxlength="10"/>
                                      
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


             <input type="checkbox" name="ChkMostrarNoProcesados" id="ChkMostrarNoProcesados" value="1" <?php echo (($POST_ChkMostrarNoProcesados=="1")?'checked="checked"':'');?>  /> Mostrar no procesados
        



		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="4%" ><?php
				if($POST_ord == "SucSiglas"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SucSiglas','ASC');"> Sede <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SucSiglas','DESC');"> Sede <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('SucSiglas','ASC');"> Sede </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "NdtNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdtNumero','ASC');"> Serie <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdtNumero','DESC');"> Serie <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('NdtNumero','ASC');"> Serie </a>
                <?php
				}
				?></th>

                <th width="2%" ><?php
				if($POST_ord == "NdbId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdbId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdbId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('NdbId','ASC');"> Id.  </a>
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
                <th width="9%" ><?php
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
                <th width="5%" ><?php
				if($POST_ord == "NdbFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdbFechaEmision','ASC');"> Fecha  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdbFechaEmision','DESC');"> Fecha  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NdbFechaEmision','ASC');"> Fecha   </a>
                  <?php
				}
				?></th>
                <th width="8%" >
                  
                  Documento
                  
                </th>
                <th width="7%" ><?php
				if($POST_ord == "NdbMotivo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdbMotivo','ASC');"> Motivo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdbMotivo','DESC');"> Motivo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NdbMotivo','ASC');"> Motivo </a>
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
                  <a href="javascript:FncOrdenar('FacTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span></a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "NdbEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdbEstado','ASC');"> <span title="Estado">Est.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdbEstado','DESC');"> <span title="Estado">Est.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NdbEstado','ASC');"> <span title="Estado">Est.</span>  </a>
                  <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "NdbTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdbTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdbTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NdbTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th colspan="2" >SUNAT</th>
                <th width="2%" ><?php
				if($POST_ord == "NdbTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdbTotalItems','ASC');"> It. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdbTotalItems','DESC');"> It. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NdbTotalItems','ASC');"> It. </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "NdbTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NdbTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NdbTiempoCreacion','DESC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('NdbTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span></a>
                  <?php
				}
				?></th>
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

				  <option <?php if($POST_num==$NotaDebitosTotal){ echo 'selected="selected"';}?> value="<?php echo $NotaDebitosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $NotaDebitosTotal;
					//}else{
					//	$tregistros = ($NotaDebitosTotalSeleccionado);
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

								foreach($ArrNotaDebitos as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >
                  
                <!--<input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->NdbId."%".$dat->NdtId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->NdbId."%".$dat->NdtId; ?>" respuesta="<?php echo $dat->NdbSunatRespuestaEnvioCodigo;?>" sunat_ultima_accion="<?php echo $dat->NdbSunatUltimaAccion;?>" sunat_ultima_respuesta="<?php echo $dat->NdbSunatUltimaRespuesta;?>" />-->				
                
                 <input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->NdbId."%".$dat->NdtId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->NdbId."%".$dat->NdtId; ?>" cliente = "<?php echo $dat->CliId;?>" estado="<?php echo $dat->NcrEstado; ?>" respuesta="<?php echo $dat->NcrSunatRespuestaEnvioCodigo;?>" sunat_ultima_accion="<?php echo $dat->NcrSunatUltimaAccion;?>" sunat_ultima_respuesta="<?php echo $dat->NcrSunatUltimaRespuesta;?>" cierre="<?php echo $dat->NcrCierre;?>" />				
                
                
                </td>
                <td align="right" valign="middle"   ><?php echo ($dat->SucSiglas);?></td>
                <td align="right" valign="middle"   >
                  
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->NdbId;?>&Ta=<?php echo $dat->NdtId;?>">
                  <?php echo $dat->NdtNumero;;  ?>
                  </a>
                  
                </td>

                <td align="right" valign="middle"   >
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->NdbId;?>&Ta=<?php echo $dat->NdtId;?>">
				<?php echo $dat->NdbId;  ?>
                </a>
                </td>
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
                   
                
				<?php //echo ($dat->CliNombre);?>
                <?php //echo ($dat->CliApellidoPaterno);?>
                <?php //echo ($dat->CliApellidoMaterno);?>
                
                
                </td>
                <td align="right" ><?php echo ($dat->NdbFechaEmision);?></td>
                <td align="right" >
                  <?php
				
				switch($dat->NdbTipo){
					case 2:
				?>
                  <a href="principal.php?Mod=Factura&Form=Ver&Id=<?php echo $dat->DocId;?>&Ta=<?php echo $dat->DtaId;?>">
                  <?php echo ($dat->DtaNumero);?> - <?php echo ($dat->DocId);?>
                  </a>
                  <?php	
					break;
					
					case 3:
				?>
                  <a href="principal.php?Mod=Boleta&Form=Ver&Id=<?php echo $dat->DocId;?>&Ta=<?php echo $dat->DtaId;?>">
                  <?php echo ($dat->DtaNumero);?> - <?php echo ($dat->DocId);?>
                  </a>
                  <?php	
					break;
					
						case 4:
				?>
                  <a href="principal.php?Mod=NotaCredito&Form=Ver&Id=<?php echo $dat->DocId;?>&Ta=<?php echo $dat->DtaId;?>">
                  <?php echo ($dat->DtaNumero);?> - <?php echo ($dat->DocId);?>
                  </a>
                  <?php	
					break;
				}
				?>
                  
                  
                  
                </td>
                <td align="right" ><?php echo ($dat->NdbMotivo);?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->NdbTipoCambio);?></td>
                <td align="right" >
                  <?php 


				switch($dat->NdbEstado){
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
				}
				?>                </td>
                <td align="right" > 
                  <?php $dat->NdbTotal = (($dat->NdbTotal/(empty($dat->NdbTipoCambio)?1:$dat->NdbTipoCambio)));?>
                  
                  <?php //$dat->NdbTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->NdbTotal:($dat->NdbTotal/$dat->NdbTipoCambio));?>
                <?php echo number_format($dat->NdbTotal,2); ?></td>
                <td width="3%" align="right" >
				
				 <a href="javascript:FncNotaDebitoSunatHistorialCargar('<?php echo $dat->NdbId;?>','<?php echo $dat->NdtId;?>');" >          
    			
		
		<?php
switch($dat->NdbSunatUltimaAccion){
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
	
	default:
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_sin_procesar.png" alt="Sin solicitud" title="Sin solicitud" border="0" />
                  <?php
	break;
}
?></a></td>
                <td width="5%" align="right" ><?php
switch($dat->NdbSunatUltimaRespuesta){
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
?></td>
                <td align="right" ><?php echo ($dat->NdbTotalItems);?></td>
                <td align="right" ><?php echo ($dat->NdbTiempoCreacion);?></td>
                <td align="center" >
                  
  <?php
if($PrivilegioAuditoriaVer){
?>
                  <a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->NdbId;?>&Ta=<?php echo $dat->NdtId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
<?php
if($PrivilegioEliminar & $dat->NdbCierre==2 and $dat->NdbSunatUltimaAccion != "ALTA" and $dat->NdbSunatUltimaRespuesta != "APROBADO"){
?> 

<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->NdbId."%".$dat->NdtId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>

<?php
}
?>             
                 
<?php
if($PrivilegioEditar & $dat->NdbCierre==2  and $dat->NdbSunatUltimaAccion != "ALTA" and $dat->NdbSunatUltimaRespuesta != "APROBADO"){
?> 

	<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->NdbId;?>&Ta=<?php echo $dat->NdtId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>

<?php
}else if($PrivilegioEditarEspecial){
?>

	<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->NdbId;?>&Ta=<?php echo $dat->NdtId;?>"><img src="imagenes/acciones/acc_editar_especial.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>

<?php
}
?>


<?php
/*if($PrivilegioEditarId & $dat->NdbCierre==2){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarId&Id=<?php echo $dat->NdbId;?>&Ta=<?php echo $dat->NdtId;?>"><img src="imagenes/acciones/editarid.gif" width="19" height="19" border="0" title="Editar Codigo" alt="[ECodigo]"   /></a>
                  <?php
}*/
?>

<?php
if($PrivilegioVer){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->NdbId;?>&Ta=<?php echo $dat->NdtId;?>"><img src="imagenes/acciones/ver.gif" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                  <?php
}
?>
                  
                  
                  
                  
                  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->NdbId;?>','<?php echo $dat->NdtId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncImprmir('<?php echo $dat->NdbId;?>','<?php echo $dat->NdtId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  <?php
			}
			?>
                  
                  
                  <?php
// deb($PrivilegioGenerarPDF);
if($PrivilegioGenerarPDF ){
?>
                  <a href="javascript:FncNotaDebitoGenerarPDF('<?php echo $dat->NdbId;?>','<?php echo $dat->NdtId;?>');"><img src="imagenes/acciones/pdf.png" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
  <?php
}
?>  
                  <?php
// deb($PrivilegioGenerarPDF);
if($PrivilegioVer ){
?>
                  
                  
<!--  <a href="javascript:FncNotaDebitoSunatTareas('<?php echo $dat->NdbId;?>','<?php echo $dat->NdtId;?>','<?php echo $dat->NdbSunatRespuestaTicket;?>');"><img src="imagenes/acciones/sunat_tareas.png" alt="[Tareas SUNAT]" title="Tareas SUNAT" width="19" height="19" border="0" /></a>
                  
     -->             
                  
  <?php
}
?>  
   
   
   <?php

if($PrivilegioVer ){
?>

<!--<a href="javascript:FncFacturaSunatTareasv2('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>','<?php echo $dat->FacSunatRespuestaTicket;?>');"><img src="imagenes/sunat/tareas_sunat.png" alt="[Tareas SUNAT v2]" title="Tareas SUNAT v2" width="19" height="19" border="0" /></a>
-->
<a href="javascript:FncNotaDebitoSunatTareasv2('<?php echo $dat->NdbId;?>','<?php echo $dat->NdtId;?>','<?php echo $dat->NdbSunatRespuestaTicket;?>','<?php echo $dat->NdbSunatRespuestaEnvioCodigo;?>','<?php echo $dat->NdbSunatUltimaRespuesta;?>','<?php echo $dat->NdbSunatRespuestaBajaTicket;?>');"><img src="imagenes/sunat/tareas_sunat.png" alt="[Tareas SUNAT v2]" title="Tareas SUNAT v2" width="19" height="19" border="0" /></a>

<?php
}
?>                 
                  
</td>
              </tr>

              <?php		$f++;

							$SumaSubTotal += $dat->NdbSubTotal;
							$SumaImpuesto += $dat->NdbImpuesto;
							$SumaTotal += $dat->NdbTotal;
							
									}

									?>
            </tbody>
      </table></td>
</tr>
</table>
<input type="hidden" name="CmpListadoTotal" id="CmpListadoTotal" value="<?php echo number_format($SumaTotal,2);?>" />
<input type="hidden" name="CmpListadoSubTotal" id="CmpListadoSubTotal" value="<?php echo number_format($SumaSubTotal,2);?>" />
<input type="hidden" name="CmpListadoImpuesto" id="CmpListadoImpuesto" value="<?php echo number_format($SumaImpuesto,2);?>" />
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

$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();

?>
