<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","Listado")){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","Ver"))?true:false;?>
<?php $PrivilegioRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraEntrada.js" ></script>
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
		$POST_fil =  $_SESSION[$GET_mod."Filtro"];	
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


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'OcoTiempoModificacion';
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
$POST_finicio = "01/01/".date("Y");
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


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCompraEntrada.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');

$InsOrdenCompra = new ClsOrdenCompra();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCompraEntrada.php');

////MtdObtenerOrdenCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oTipo=NULL,$oConSaldo=0) {
$ResOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompras($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,"CYC",1);
$ArrOrdenCompras = $ResOrdenCompra['Datos'];
$OrdenComprasTotal = $ResOrdenCompra['Total'];
$OrdenComprasTotalSeleccionado = $ResOrdenCompra['TotalSeleccionado'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

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
/*if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}*/
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE ENTRADAS A ALMACEN c/ ORDEN COMPRA PENDIENTES</span></td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $OrdenComprasTotalSeleccionado;?></b> de <b><?php echo $OrdenComprasTotal;?></b> elementos.</td>
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
    
    
    <input class="EstFormularioCaja" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    
    <select class="EstFormularioOcobo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>
    <select class="EstFormularioOcobo" name="Cam" id="Cam">
      <option value="OcoId" <?php if($POST_cam=="OcoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="PrvNombre" <?php if($POST_cam=="PrvNombre"){ echo 'selected="selected"';}?>>Proveedor</option>      

      
      
      </select>
    Estado
    <select class="EstFormularioOcobo" name="Estado" id="Estado">
      <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>En Transito</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>
      
      Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/".date("m/Y");}else{ echo $POST_finicio; }?>" size="9" maxlength="10"/>
  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicio" name="BtnFechaInicio" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="9" maxlength="10"/>
    
  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
    
    <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="0%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="9%" ><?php
				if($POST_ord == "OcoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoId','ASC');"> Id <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoId','DESC');"> Id <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcoId','ASC');"> Id </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "OcoTipo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoTipo','ASC');"> Tipo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoTipo','DESC');"> Tipo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcoTipo','ASC');"> Tipo </a>
                <?php
				}
				?></th>
                <th width="25%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Proveedor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor </a>
                <?php
				}
				?></th>
                <th width="7%" >
                
                                <?php
				if($POST_ord == "OcoFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcoFecha','ASC');"> Fecha </a>
                  <?php
				}
				?>                </th>
                <th width="9%" ><?php
				if($POST_ord == "OcoHora"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoHora','ASC');"> Hora <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoHora','DESC');"> Hora <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcoHora','ASC');"> Hora </a>
                <?php
				}
				?></th>
                <th width="10%" ><?php
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
                <th width="7%" ><?php
				if($POST_ord == "OcoTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcoTipoCambio','ASC');"> T.C. </a>
                <?php
				}
				?></th>
                <th width="10%" ><?php
				if($POST_ord == "OcoTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OcoTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="9%" >
                  <?php
				if($POST_ord == "OcoTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('OcoTiempoModificacion','ASC');">
                  U.A.
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoTiempoModificacion','DESC');">
                    
                  U.A.
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('OcoTiempoModificacion','ASC');">
                  U.A.
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="6%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="12" align="center">

				Mostrar de
				<select class="EstFormularioOcobo" onChange="javascript:FncListar(this.value);" name="Num" id="Num">
				  <option <?php if($POST_num=="5"){ echo 'selected="selected"';}?> value="5">5</option>
				  <option <?php if($POST_num=="10"){ echo 'selected="selected"';}?> value="10">10</option>
				  <option <?php if($POST_num=="15"){ echo 'selected="selected"';}?> value="15">15</option>
				  <option <?php if($POST_num=="20"){ echo 'selected="selected"';}?> value="20">20</option>
				  <option <?php if($POST_num=="25"){ echo 'selected="selected"';}?> value="25">25</option>
				  <option <?php if($POST_num=="30"){ echo 'selected="selected"';}?> value="30">30</option>
				  <option <?php if($POST_num=="50"){ echo 'selected="selected"';}?> value="50">50</option>
				  <option <?php if($POST_num=="100"){ echo 'selected="selected"';}?> value="100">100</option>
				  <option <?php if($POST_num==$OrdenComprasTotal){ echo 'selected="selected"';}?> value="<?php echo $OrdenComprasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $OrdenComprasTotal;
					//}else{
					//	$tregistros = ($OrdenComprasTotalSeleccionado);
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
								foreach($ArrOrdenCompras as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td width="0%" align="center"  >
                  
                <input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->OcoId; ?>" />				</td>
                <td width="9%" align="right" valign="middle"   ><?php echo $dat->OcoId;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->OcoTipo;  ?></td>
                <td  width="25%" align="right" ><?php echo $dat->PrvNombre;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->OcoFecha;  ?></td>
                <td  width="9%" align="right" ><?php echo $dat->OcoHora;  ?></td>
                <td  width="10%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->OcoTipoCambio;  ?></td>
                <td  width="10%" align="right" >
                  
                  
                  <?php echo number_format($dat->OcoTotal,2);?>
                  <?php
					$Total += $dat->OcoTotal ;
			
				?>
                </td>
                <td  width="9%" align="right" ><?php echo ($dat->OcoTiempoModificacion);?></td>
        <td  width="6%" align="center" >


<?php
if($PrivilegioRegistrar){
?>		                
	<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Registrar&Id=<?php echo $dat->OcoId;?>"><img src="imagenes/generar.jpg" width="19" height="19" border="0" title="Generar Entrada a Almacen" alt="[Generar Entrada a Almacen]"   /></a>                
<?php
}
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

