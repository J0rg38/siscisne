<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago",$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Imprimir"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoBoleta.js"></script>
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
$POST_CondicionPago = $_POST['CmpCondicionPago'];
$POST_Moneda = $_POST['CmpMoneda'];

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

$GET_BolId = $_GET['BolId'];
$GET_BtaId = $_GET['BtaId'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPagoBoleta.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

//INSTANCAS
$InsPago = new ClsPago();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsBoleta = new ClsBoleta();

$InsBoleta->BolId = $GET_BolId;
$InsBoleta->BtaId = $GET_BtaId;
$InsBoleta->MtdObtenerBoleta(false);

$POST_Moneda = $InsBoleta->MonId;

$InsPago->UsuId = $_SESSION['SesionId'];
//deb($InsBoleta)//;

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoBoleta.php');
//DATOS
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL)

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL) 
$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,BolId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,$GET_BolId,$GET_BtaId);

$ArrPagos = $ResPago['Datos'];
$PagosTotal = $ResPago['Total'];
$PagosTotalSeleccionado = $ResPago['TotalSeleccionado'];

//MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
 
$ResCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaId","ASC",NULL,1);
$ArrCondicionPagos = $ResCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


//deb($InsBoleta->VdiId);
?>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    


<div class="EstCapMenu">
<?php
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}
?>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2"><span class="EstFormularioTitulo">LISTADO DE ABONOS DE  BOLETA: <?php echo $InsBoleta->BtaNumero;?> - <?php echo $InsBoleta->BolId;?> / <?php echo $InsBoleta->VdiId;?> <?php echo $InsBoleta->OvvId;?></span></td>
</tr>

<tr>
  <td width="51%">
    Mostrando <b><?php echo $PagosTotalSeleccionado;?></b> de <b><?php echo $PagosTotal;?></b> registros.</td>
  <td width="49%">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="right"><?php $InsBoleta->BolTotal = (($EmpresaMonedaId==$InsBoleta->MonId or empty($InsBoleta->MonId))?$InsBoleta->BolTotal:($InsBoleta->BolTotal/$InsBoleta->BolTipoCambio));?>
    <?php $InsBoleta->BolSaldo = (($EmpresaMonedaId==$InsBoleta->MonId or empty($InsBoleta->MonId))?$InsBoleta->BolSaldo:($InsBoleta->BolSaldo/$InsBoleta->BolTipoCambio));?>
    <!--<table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"> <?php echo $InsBoleta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><?php echo number_format($InsBoleta->BolTotal,2);?></td>
        <td align="right" class="EstTablaTotalesEtiqueta">POR COBRAR: <span class="EstMonedaSimbolo"> <?php echo $InsBoleta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><div id="CapTotalOrdenCobros" ></div></td>
        <td align="right" class="EstTablaTotalesEtiqueta">ABONADO: <span class="EstMonedaSimbolo"> <?php echo $InsBoleta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><div id="CapTotalAbonos" ></div></td>
        <td align="right" class="EstTablaTotalesEtiqueta">SALDO: <span class="EstMonedaSimbolo"><?php echo $InsBoleta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><?php echo number_format($InsBoleta->BolSaldo,2);?></td>
      </tr>
    </table>--></td>
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
    
        
        <!--Condicion de Pago:
        <select class="EstFormularioCombo" name="CmpCondicionPago" id="CmpCondicionPago">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrCondicionPagos as $DatCondicionPago){
				?>
				<option <?php echo ($POST_CondicionPago== $DatCondicionPago->NpaId)?'selected="selected"':''; ?>  value="<?php echo $DatCondicionPago->NpaId?>"><?php echo $DatCondicionPago->NpaNombre ?></option>
				<?php
			  }
			  
			  ?>
              </select>--><span class="EstFormularioEtiqueta">  
       Moneda:</span><span class="EstFormularioContenido">  
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
      </span><!--       <select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="PagId" <?php if($POST_cam=="PagId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="PagNumeroTranssaccion" <?php if($POST_cam=="PagNombre"){ echo 'selected="selected"';}?>>Num. Transaccion</option>
        <option value="CueNumero" <?php if($POST_cam=="PagNombre"){ echo 'selected="selected"';}?>>Num. Cuenta</option>
        <option value="BanNombre" <?php if($POST_cam=="PagNombre"){ echo 'selected="selected"';}?>>Banco</option>
        
       </select>-->





		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>

<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="3%" >#</th>
                <th width="3%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="9%" ><?php
				if($POST_ord == "PagId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "BolId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Boleta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolId','DESC');"> Boleta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Boleta </a>
                  <?php
				}
				?></th>
                <th width="10%" ><?php
				if($POST_ord == "PagNumeroRecibo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagNumeroRecibo','ASC');"> Num. Recibo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagNumeroRecibo','DESC');"> Num. Recibo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagNumeroRecibo','ASC');"> Num. Recibo </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "PagFechaTranssaccion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagFechaTranssaccion','ASC');"> Fecha Transac. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagFechaTranssaccion','DESC');"> Fecha Transac <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagFechaTranssaccion','ASC');"> Fecha Transac. </a>
                  <?php
				}
				?></th>
                <th width="10%" ><?php
				if($POST_ord == "PagNumeroTranssaccion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagNumeroTranssaccion','ASC');"> Num. Transac. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagNumeroTranssaccion','DESC');"> Num. Transac <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagNumeroTranssaccion','ASC');"> Num. Transac </a>
                <?php
				}
				?></th>
                <th width="10%" ><?php
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
                <th width="10%" ><?php
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
                <th width="7%" ><?php
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
                <th width="6%" ><?php
				if($POST_ord == "PagEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagEstado','ASC');"> Estado <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagEstado','DESC');"> Estado <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PagEstado','ASC');"> Estado </a>
                  <?php
				}
				?></th>
                <th width="13%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="13" align="center">

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

				$TotalAbonos = 0;
				$TotalOrdenCobros = 0;
				
								foreach($ArrPagos as $dat){

								?>

              <tr id="Fila_<?php echo $f;?>">
                <td width="3%" align="center"  ><?php echo $f;?></td>
                <td width="3%" align="center"  >

				<input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->PagId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->PagId; ?>" />				</td>

                <td align="right" valign="middle" width="9%"   ><?php echo $dat->PagId;  ?></td>
                <td align="right" valign="middle" width="6%"   >
				
				<?php echo $dat->BtaNumero;  ?>-<?php echo $dat->BolId;  ?></td>
                <td  width="10%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                <td  width="8%" align="right" ><?php echo $dat->PagFechaTransaccion;  ?></td>
                <td  width="10%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                <td  width="10%" align="right" ><?php echo $dat->PagFecha; ?></td>
                <td align="right" ><?php echo ($dat->MonNombre);?></td>
                <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                <td  width="7%" align="right" ><?php $dat->PagMonto = (($dat->PagMonto/(empty($dat->PagTipoCambio)?1:$dat->PagTipoCambio)));?>
                <?php echo number_format($dat->PagMonto,2); ?></td>
                <td  width="6%" align="right" ><?php echo ($dat->PagEstadoDescripcion);?></td>
                <td  width="13%" align="center" >
                  
                  
                  <?php
if($PrivilegioEliminar){
?> 
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->PagId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
                  <?php
}
?>
                  
                  <?php
if($PrivilegioEditar){
?>
                  
                  <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=PagoBoleta&Form=Editar&Id=<?php echo $dat->PagId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&BolId=<?php echo $GET_BolId;?>&BtaId=<?php echo $GET_BtaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
                  
                  <?php
}
?>
                  
                  
                  <?php
if($PrivilegioVer){
?>
                  
                  <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=PagoBoleta&Form=Ver&Id=<?php echo $dat->PagId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&BolId=<?php echo $GET_BolId;?>&BtaId=<?php echo $GET_BtaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                  
                  <?php
}
?>
                  
                  
                  
  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  <a href="javascript:FncPagoVistaPreliminar('<?php echo $dat->PagId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncPagoImprmir('<?php echo $dat->PagId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  <?php
			}
			?>
                  
                  
</td>
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
      
<input type="hidden" name="CmpTotalAbonos" id="CmpTotalAbonos" value="<?php echo number_format($TotalAbonos,2);?>" />
<input type="hidden" name="CmpTotalOrdenCobros" id="CmpTotalOrdenCobros" value="<?php echo number_format($TotalOrdenCobros,2);?>" />

      </td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="center"><span class="EstFormularioTitulo">OTROS ABONOS RELACIONADOS</span></td>
</tr>
<tr>
  <td colspan="2">
  
<?php
//deb($InsBoleta->VdiId);
?>
 
  <?php
//deb($InsBoleta->VdiId);
if(!empty($InsBoleta->OvvId)){
?>
ORDENES DE VENTA DE VEHICULO
<?php	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $InsBoleta->OvvId;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);
	
	
		$InsPago = new ClsPago();
		$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,$POST_CondicionPago,$POST_Moneda);
		
		$ArrPagos = $ResPago['Datos'];
?>
    <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
      <thead class="EstTablaListadoHead">
        <tr>
          <th width="2%" >#</th>
          <th width="4%" >ID</th>
          <th width="8%" >ORD. VEN. VEH.</th>
          <th width="10%" >NUM. RECIBO</th>
          <th width="13%" >NUM. TRANSAC.</th>
          <th width="10%" >FECHA</th>
          <th width="11%" >MONEDA</th>
          <th width="5%" >T.C.</th>
          <th width="8%" >MONTO</th>
          <th width="7%" >COM. PAG.</th>
          <th width="7%" >ESTADO</th>
          <th width="4%" >ACC</th>
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
          <td width="2%" align="center"  ><?php echo $f;?></td>
          <td align="right" valign="middle" width="4%"   ><?php echo $dat->PagId;  ?></td>
          <td align="right" valign="middle" width="8%"   ><?php echo $dat->OvvId;  ?></td>
          <td  width="10%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
          <td  width="13%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
          <td  width="10%" align="right" ><?php echo $dat->PagFecha; ?></td>
          <td align="right" ><?php echo ($dat->MonNombre);?></td>
          <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
          <td  width="8%" align="right" ><?php $dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
            <?php echo number_format($dat->PagMonto,2); ?></td>
          <td  width="7%" align="right" >
          
             <h2>
                <?php echo $dat->PagComprobanteVenta;  ?>
                </h2>
                
                </td>
          <td  width="7%" align="right" ><?php echo ($dat->PagEstadoDescripcion);?></td>
          <td  width="4%" align="right" >
          
                            
  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  <a href="javascript:FncPagoVistaPreliminar('<?php echo $dat->PagId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncPagoImprmir('<?php echo $dat->PagId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  <?php
			}
			?>
            
            </td>
          </tr>
        <?php		
			  
			  
			    
			 
			  
			  
			  
			  $f++;

									}

									?>
        </tbody>
      </table>
    <?php

	
}else if($InsBoleta->VdiId){
?>

ORDENES DE VENTA (VENTAS X MOSTRADOR) 

<?php

$InsVentaDirecta = new ClsVentaDirecta();
$InsVentaDirecta->VdiId = $InsBoleta->VdiId;
$InsVentaDirecta->MtdObtenerVentaDirecta(false);

$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,"",$InsVentaDirecta->VdiId,NULL,$POST_CondicionPago,$POST_Moneda);
$ArrPagos = $ResPago['Datos'];
	
?>


<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="4%" >ID</th>
                <th width="8%" >ORD. VEN. </th>
                <th width="10%" >NUM. RECIBO</th>
                <th width="13%" >NUM. TRANSAC.</th>
                <th width="10%" >FECHA</th>
                <th width="11%" >MONEDA</th>
                <th width="5%" >T.C.</th>
                <th width="8%" >MONTO</th>
                <th width="7%" >COM. PAG.</th>
                <th width="7%" >ESTADO</th>
                <th width="4%" >ACC</th>
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
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->PagId;  ?></td>
                <td align="right" valign="middle" width="8%"   ><?php echo $dat->VdiId;  ?></td>
                <td  width="10%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                <td  width="13%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                <td  width="10%" align="right" ><?php echo $dat->PagFecha; ?></td>
                <td align="right" ><?php echo ($dat->MonNombre);?></td>
                <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                <td  width="8%" align="right" >
                  
                  
  <?php $dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                  
                  
                <?php echo number_format($dat->PagMonto,2); ?></td>
                <td  width="7%" align="right" >
                
                
                   <h2>
                <?php echo $dat->PagComprobanteVenta;  ?>
                </h2>
                
                
                
                </td>
                <td  width="7%" align="right" ><?php echo ($dat->PagEstadoDescripcion);?></td>
                <td  width="4%" align="right" ><?php
			if($PrivilegioVistaPreliminar){
			?>
                  <a href="javascript:FncPagoVistaPreliminar('<?php echo $dat->PagId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  <?php
			}
			?>
                  <?php
			if($PrivilegioImprimir){
			?>
                  <a href="javascript:FncPagoImprmir('<?php echo $dat->PagId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                <?php
			}
			?></td>
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


?></td>
</tr>
</table>
</div>



</form>
<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

