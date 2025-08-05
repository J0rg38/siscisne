<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>




<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClientePago.js"></script>
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
$POST_ord = ($_POST['Ord']);
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag']);
$POST_p = ($_POST['P']);
$POST_num = ($_POST['Num']);
$POST_seleccionados = $_POST['cmp_seleccionados'];
$POST_acc = $_POST['Acc'];

/*
* Otras variables
*/

$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_mon = ($_POST['Mon']);
$POST_estado = $_POST['Estado'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CpaTiempoModificacion';
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
	$POST_finicio = "01/".date("m/Y");
}

if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

if(empty($POST_mon)){
	$POST_mon = $EmpresaMonedaId;
}



include($InsProyecto->MtdFormulariosMsj("ClientePago").'MsjClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsClientePago = new ClsClientePago();
$InsMoneda = new ClsMoneda();

include($InsProyecto->MtdRutFormularios().'ClientePago/acc/AccClientePago.php');

//MtdObtenerClientePagos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CpaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFormaPago=NULL,$oVenta=NULL,$oVentaTalonario=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario,$oNotaEntrega=NULL,$oNotaEntregaTalonario=NULL,$oMoneda=NULL,$oEstado=NULL)


$RepClientePago = $InsClientePago->MtdObtenerClientePagos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$_SESSION['SisSucId'],FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$POST_mon,$POST_estado);

$ArrClientePagos = $RepClientePago['Datos'];
$ClientePagosTotal = $RepClientePago['Total'];
$ClientePagosTotalSeleccionado = $RepClientePago['TotalSeleccionado'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,'MonId','Desc',NULL);
$ArrMonedas = $ResMoneda['Datos'];


$InsMoneda->MonId = $POST_mon;
$InsMoneda = $InsMoneda->MtdObtenerMoneda();

$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();

?>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    


<div class="EstCapMenu">
<?php
/*if($PrivilegioBorrar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncBorrarSeleccionados();">
<img src="imagenes/iconos/borrar.png" alt="[Borrar]"  title="Borrar seleccionados" />Borrar</a></div>
<?php
}*/
?>

<?php
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton">
<a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar]" title="Eliminar elementos seleccionados" />Eliminar</a>
</div> <?php
}
?>
</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2"><span class="EstFormularioTitulo">LISTADO DE PAGOS DE CLIENTE</span></td>
</tr>
<tr>
  <td width="77%">
    Mostrando <b><?php echo $ClientePagosTotalSeleccionado;?></b> de <b><?php echo $ClientePagosTotal;?></b> Pagos de Cliente</td>
  <td width="23%">
  
  <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
    <tr>
      <td width="45%" align="right">Total <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span>:</td>
      <td width="55%" align="right"><div id="CapListadoTotal" > </div></td>
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
        <input class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
        
        <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>
        
        

<select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="cpa.CpaId" <?php if($POST_cam=="cpa.CpaId"){ echo 'selected="selected"';}?>>Id</option>
      	<option value="cli.CliNombre" <?php if($POST_cam=="cli.CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>     
        
                <option value="cpa.VenId" <?php if($POST_cam=="cpa.VenId"){ echo 'selected="selected"';}?>>Venta</option>
        <option value="cpa.FacId" <?php if($POST_cam=="cpa.FacId"){ echo 'selected="selected"';}?>>Factura</option>
        <option value="cpa.BolId" <?php if($POST_cam=="cpa.BolId"){ echo 'selected="selected"';}?>>Boleta</option>
        <option value="cpa.NenId" <?php if($POST_cam=="cpa.NenId"){ echo 'selected="selected"';}?>>Nota de Entrega</option>
        <option value="cpa.VenId" <?php if($POST_cam=="cpa.VenId"){ echo 'selected="selected"';}?>>Venta</option>   
       </select>
     Moneda
             <select class="EstFormularioCombo" id="Mon" name="Mon">
                <?php
			foreach($ArrMonedas as $DatMoneda){				
				
			?>
                <option <?php if($POST_mon == $DatMoneda->MonId){ echo 'selected="selected"';}?> value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?> <?php echo $DatMoneda->MonSimbolo;?></option>
                <?php
			}
			?>
              </select>
	
              
                   Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>
      
      
Fecha Inicio
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/".date("m/Y");}else{ echo $POST_finicio; }?>" size="10" maxlength="10"/>
<img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicio" name="BtnFechaInicio" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="10" maxlength="10"/>
                                      
<img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />



       
       


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

                <th width="2%" ><?php
				if($POST_ord == "CpaId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CpaId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "DocId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('DocId','ASC');"> Documento <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('DocId','DESC');"> Documento <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('DocId','ASC');"> Documento </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "CpaFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaFecha','ASC');"> Fecha </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FpaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FpaNombre','ASC');"> F. Pago <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FpaNombre','DESC');">  F. Pago <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FpaNombre','ASC');">  F. Pago </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "CpaTarjetaNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaTarjetaNumero','ASC');"> Tarj. Num. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaTarjetaNumero','DESC');"> Tarj. Num. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaTarjetaNumero','ASC');"> Tarj. Num. </a>
                  <?php
				}
				?>
                </th>
                <th width="3%" ><?php
				if($POST_ord == "CpaTarjetaTipo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaTarjetaTipo','ASC');"> Tarj. Tipo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaTarjetaTipo','DESC');"> Tarj. Tipo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaTarjetaTipo','ASC');"> Tarj. Tipo </a>
                  <?php
				}
				?>
                </th>
                <th width="5%" ><?php
				if($POST_ord == "TmaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('TmaNombre','ASC');"> Tarj. Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('TmaNombre','DESC');"> Tarj. Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('TmaNombre','ASC');"> Tarj. Marca </a>
                  <?php
				}
				?>
                </th>
                <th width="5%" ><?php
				if($POST_ord == "TenNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('TenNombre','ASC');"> Tarj. Entidad <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('TenNombre','DESC');"> Tarj. Entidad <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('TenNombre','ASC');"> Tarj. Entidad </a>
                  <?php
				}
				?>
                </th>
                <th width="4%" ><?php
				if($POST_ord == "BanNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BanNombre','ASC');"> Banco <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BanNombre','DESC');"> Banco <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BanNombre','ASC');"> Banco </a>
                  <?php
				}
				?>
                </th>
                <th width="5%" ><?php
				if($POST_ord == "BanNombreDepositar"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BanNombreDepositar','ASC');"> Banco Depos. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BanNombreDepositar','DESC');"> Banco Depos. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BanNombreDepositar','ASC');"> Banco Depos. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "CpaChequeNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaChequeNumero','ASC');"> Num. Cheque <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaChequeNumero','DESC');"> Num. Cheque <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaChequeNumero','ASC');"> Num. Cheque </a>
                  <?php
				}
				?>
                </th>
                <th width="6%" ><?php
				if($POST_ord == "CpaTransaccionNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaTransaccionNumero','ASC');"> Num. Transac. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaTransaccionNumero','DESC');"> Num. Transac. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaTransaccionNumero','ASC');"> Num. Transac. </a>
                  <?php
				}
				?>
                </th>
                <th width="4%" ><?php
				if($POST_ord == "CpaEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaEstado','ASC');"><span title="Estado">Est.</span><img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaEstado','DESC');"> <span title="Estado">Est.</span><img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaEstado','ASC');"> <span title="Estado">Est.</span> </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "CpaTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaTipoCambio','DESC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> </a>
                <?php
				}
				?></th>
                <th ><?php
				if($POST_ord == "CpaMonto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaMonto','ASC');"> Monto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaMonto','DESC');"> Monto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaMonto','ASC');"> Monto </a>
                <?php
				}
				?></th>
                <th width="3%" >&nbsp;</th>
                <th width="5%" ><?php
				if($POST_ord == "UsuUsuario"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('UsuUsuario','ASC');"> Usuario <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('UsuUsuario','DESC');"> Usuario <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('UsuUsuario','ASC');"> Usuario </a>
                <?php
				}
				?></th>
                <th width="8%" >
				<?php
				if($POST_ord == "CpaTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>

				<a href="javascript:FncOrdenar('CpaTiempoModificacion','ASC');"> <span title="Ultima Actualizacion">U.A.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" />				</a>
				<?php
					}else{
				?>
				<a href="javascript:FncOrdenar('CpaTiempoModificacion','DESC');"> <span title="Ultima Actualizacion">U.A.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" />				</a>
				<?php
					}
				}else{

				?><a href="javascript:FncOrdenar('CpaTiempoModificacion','ASC');"> <span title="Ultima Actualizacion">U.A.</span> </a>

				<?php
				}
				?>			    </th>
                <th width="1%" >&nbsp;</th>
                <th width="10%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="23" align="center">

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

				  <option <?php if($POST_num==$ClientePagosTotal){ echo 'selected="selected"';}?> value="<?php echo $ClientePagosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ClientePagosTotal;
					//}else{
					//	$tregistros = ($ClientePagosTotalSeleccionado);
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

								foreach($ArrClientePagos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CpaId; ?>" accept="<?php echo $dat->CpaCierre; ?>" />				</td>

                <td align="right" valign="middle" width="2%"   ><?php echo $dat->CpaId;  ?></td>
                <td  width="7%" align="right" >
				
				<?php
				switch($dat->CpaTipo){
					case 1:
				?>
<a href="principal.php?Mod=Venta&Form=Ver&Id=<?php echo $dat->DocId;?>&Ta=<?php echo $dat->DtaId; ?>"><?php echo $dat->DtaNumero; ?> - <?php echo $dat->DocId;?></a>
            
                
                <?php	
					break;
					
					case 2:
				?>	
<a href="principal.php?Mod=Factura&Form=Ver&Id=<?php echo $dat->DocId;?>&Ta=<?php echo $dat->DtaId; ?>"><?php echo $dat->DtaNumero; ?> - <?php echo $dat->DocId;?></a>				
                <?php
        			break;
					
					case 3:
				?>
<a href="principal.php?Mod=Boleta&Form=Ver&Id=<?php echo $dat->DocId;?>&Ta=<?php echo $dat->DtaId; ?>"><?php echo $dat->DtaNumero; ?> - <?php echo $dat->DocId;?></a>                
                <?php
					break;
					
					case 4:
				?>
<a href="principal.php?Mod=NotaEntrega&Form=Ver&Id=<?php echo $dat->DocId;?>&Ta=<?php echo $dat->DtaId; ?>"><?php echo $dat->DtaNumero; ?> - <?php echo $dat->DocId;?></a>
                <?php	
					break;
				}
                ?>


                
                
				
                
                </td>
                <td  width="4%" align="right" ><?php echo $dat->CpaFecha; ?></td>
                <td  width="5%" align="right" ><?php echo $dat->CliNombre; ?></td>
                <td  width="3%" align="right" ><?php echo $dat->FpaNombre; ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CpaTarjetaNumero; ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CpaTarjetaTipo; ?></td>
                <td  width="5%" align="right" ><?php echo $dat->TmaNombre; ?></td>
                <td  width="5%" align="right" ><?php echo $dat->TenNombre; ?></td>
                <td  width="4%" align="right" ><?php echo $dat->BanNombre; ?></td>
                <td  width="5%" align="right" ><?php echo $dat->BanNombreDepositar; ?></td>
                <td  width="5%" align="right" ><?php echo $dat->CpaChequeNumero; ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CpaTransaccionNumero; ?></td>
                <td  width="4%" align="right" ><?php
				switch($dat->CpaEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />
                <?php							
						break;	

					}
				?></td>
                <td  width="3%" align="right" ><?php echo $dat->CpaTipoCambio; ?></td>
                <td  width="5%" align="right" >
                
                
                  <?php
                if($POST_mon == $EmpresaMonedaId){
				?>
                  
                 <!-- <span class="EstMonedaSimbolo"><?php echo ($EmpresaMoneda);?></span>-->
                  <?php echo number_format($dat->CpaMonto,2);?>
                  
                  <?php
					$Total += $dat->CpaMonto;
                }else{
				?>
                  <?php
                    if($dat->MonId<>$EmpresaMonedaId){
						if(!empty($dat->CpaTipoCambio)){
							$ClientePagoMonto = redondear_dos_decimal($dat->CpaMonto/$dat->CpaTipoCambio);
                    ?>
                  <!--<span class="EstMonedaSimbolo"><?php echo ($dat->MonSimbolo);?></span>-->
                  <?php echo number_format(($ClientePagoMonto),2);?>
                  
                  <?php
						$Total += $ClientePagoMonto;
						}else{
					?>
                  No hay tipo de cambio
                  <?php		
						}
                    }
                    ?>
                  <?php	
				}
				?>
                
                
                  
                
                </td>
                <td  width="3%" align="right" >

<?php            
if(!empty($dat->CpaFoto)){
	
	$extension = strtolower(pathinfo($dat->CpaFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->CpaFoto, '.'.$extension);  
?>
                  <a href="subidos/clientepago_fotos/<?php echo $dat->CpaFoto;?>" class="thickbox" title=""><img border="0"  src="imagenes/documento.gif"  /></a>
                <?php	
}
?></td>
                <td  width="5%" align="right" ><?php echo $dat->UsuUsuario; ?></td>
                <td  width="8%" align="right" ><?php echo ($dat->CpaTiempoModificacion);?></td>
                <td  width="1%" align="center" >
                
                
<?php
if($dat->CpaCierre==2){
?> 
        <img src="imagenes/cerrado.png" alt="[Cerrado]" title="Cerrado" border="0" width="15" height="15"  />
        
<?php
}
?>    
                </td>
        <td  width="10%" align="center" >

<?php
/*if($PrivilegioBorrar){
?>
<a href="javascript:FncBorrarSeleccionado('<?php echo $dat->CpaId; ?>');"><img src="imagenes/borrar.gif" width="19" height="19" border="0" title="Borrar" alt="[Borrar]"   /></a>
<?php
}*/
?>

<?php

if($PrivilegioEliminar & $dat->CpaCierre==1){
?>

	<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CpaId; ?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
          <?php
}
?>


<?php
if($PrivilegioEditar & $dat->CpaCierre==1){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->CpaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CpaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>					</td>
              </tr>

              <?php		$f++;

									}

$Total = number_format($Total,2);
									?>
            </tbody>
      </table></td>
</tr>
</table>


</div>
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
?>