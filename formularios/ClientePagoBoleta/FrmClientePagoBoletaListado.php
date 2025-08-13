<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago",$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Eliminar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClientePagoBoleta.js"></script>
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
$POST_FormaPago = $_POST['CmpFormaPago'];
$POST_Moneda = $_POST['Moneda'];

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

$GET_BolId = $_GET['BolId'];
$GET_BtaId = $_GET['BtaId'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjClientePagoBoleta.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
//INSTANCAS
$InsClientePago = new ClsClientePago();
$InsFormaPago = new ClsFormaPago();
$InsMoneda = new ClsMoneda();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClientePagoBoleta.php');
//DATOS
//MtdObtenerClientePagos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFormaPago=NULL,$oMoneda=NULL,$oCuenta=NULL)
$ResClientePago = $InsClientePago->MtdObtenerClientePagos("CpaId,CpaTransaccionNumero,CueNumero,BanNombre","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_FormaPago,$POST_Moneda,NULL,NULL,NULL,$GET_BolId,$GET_BtaId);

$ArrClientePagos = $ResClientePago['Datos'];
$ClientePagosTotal = $ResClientePago['Total'];
$ClientePagosTotalSeleccionado = $ResClientePago['TotalSeleccionado'];


$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,1);
$ArrFormaPagos = $ResFormaPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE PAGO DE CLIENTES</span></td>
</tr>

<tr>
  <td>
    Mostrando <b><?php echo $ClientePagosTotalSeleccionado;?></b> de <b><?php echo $ClientePagosTotal;?></b> registros.</td>
</tr>
<tr>
<td align="right">

		<input type="hidden" name="Acc" id="Acc" value="" />
        <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
        <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
        <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag;?>" />
        <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
        
        <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
        <input class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
        
        Forma de Pago:
        <select class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrFormaPagos as $DatFormaPago){
				?>
				<option <?php echo ($POST_FormaPago== $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
				<?php
			  }
			  
			  ?>
              </select><span class="EstFormularioEtiqueta">  
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
      	<option value="CpaId" <?php if($POST_cam=="CpaId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="CpaTransaccionNumero" <?php if($POST_cam=="CpaNombre"){ echo 'selected="selected"';}?>>Num. Transaccion</option>
        <option value="CueNumero" <?php if($POST_cam=="CpaNombre"){ echo 'selected="selected"';}?>>Num. Cuenta</option>
        <option value="BanNombre" <?php if($POST_cam=="CpaNombre"){ echo 'selected="selected"';}?>>Banco</option>
        
       </select>-->





		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td>





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
                <th width="5%" ><?php
				if($POST_ord == "BolId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Boleta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolId','DESC');"> Boleta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Boleta  </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
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
                <th width="8%" ><?php
				if($POST_ord == "FpaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FpaNombre','ASC');"> F. Pago <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FpaNombre','DESC');"> F. Pago <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FpaNombre','ASC');"> F. Pago </a>
                <?php
				}
				?></th>
                <th width="14%" ><?php
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
				?></th>
                <th width="14%" ><?php
				if($POST_ord == "CueNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CueNumero','ASC');"> Cuenta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CueNumero','DESC');"> Cuenta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CueNumero','ASC');"> Cuenta </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
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
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "MonNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MonNombre','DESC');"> Moneda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "CpaTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CpaTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CpaTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CpaTipoCambio','ASC');"> T.C. </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
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
                <th width="9%" >
				<?php
				if($POST_ord == "CpaTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>

				<a href="javascript:FncOrdenar('CpaTiempoModificacion','ASC');">
				U.A.
				<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" />				</a>
				<?php
					}else{
				?>
				<a href="javascript:FncOrdenar('CpaTiempoModificacion','DESC');">

				U.A.
				<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" />				</a>
				<?php
					}
				}else{

				?><a href="javascript:FncOrdenar('CpaTiempoModificacion','ASC');">
				U.A.
								</a>

				<?php
				}
				?>			    </th>
                <th width="10%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="14" align="center">

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

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->CpaId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CpaId; ?>" />				</td>

                <td align="right" valign="middle" width="2%"   ><?php echo $dat->CpaId;  ?></td>
                <td align="right" valign="middle" width="5%"   >
				

<?php

				$InsClientePagoComprobante = new ClsClientePagoComprobante();
				$ResClientePagoComprobante =  $InsClientePagoComprobante->MtdObtenerClientePagoComprobantes(NULL,NULL,NULL,NULL,NULL);			
				$ArrClientePagoComprobantes = $ResClientePagoComprobante['Datos'];	

?>


				<?php echo $dat->BtaNumero; ?> - <?php echo $dat->BolId; ?>
                
                
                </td>
                <td  width="8%" align="right" ><?php echo $dat->CpaFecha; ?></td>
                <td  width="8%" align="right" ><?php echo $dat->FpaNombre; ?></td>
                <td  width="14%" align="right" ><?php echo $dat->CpaTransaccionNumero; ?></td>
                <td  width="14%" align="right" ><?php echo $dat->CueNumero; ?></td>
                <td  width="8%" align="right" ><?php echo $dat->BanNombre; ?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->CpaTipoCambio);?></td>
                <td  width="7%" align="right" ><?php echo number_format($dat->CpaMonto,2); ?></td>
                <td  width="9%" align="right" ><?php echo ($dat->CpaTiempoModificacion);?></td>
        <td  width="10%" align="center" >


<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CpaId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
	
    <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->CpaId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&BolId=<?php echo $GET_BolId;?>&BtaId=<?php echo $GET_BtaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
    
<?php
}
?>


<?php
if($PrivilegioVer){
?>
	
    <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CpaId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&BolId=<?php echo $GET_BolId;?>&BtaId=<?php echo $GET_BtaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
    
<?php
}
?>

</td>
              </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table></td>
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

