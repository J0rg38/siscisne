<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago",$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsPagoOrdenVentaVehiculo.js"></script>
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
$POST_CondicionPago = $_POST['CmpCondicionPago'];
$POST_Moneda = $_POST['Moneda'];

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

$GET_OvvId = $_GET['OvvId'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPagoOrdenVentaVehiculo.php');
//CLASES
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

//INSTANCAS
$InsPago = new ClsPago();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);

//$POST_Moneda = $InsOrdenVentaVehiculo->MonId;
$InsPago->UsuId = $_SESSION['SesionId'];

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoOrdenVentaVehiculo.php');
//DATOS
// MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL)

$ResPago = $InsPago->MtdObtenerPagos("PagId,OvvId,OvvId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,$GET_OvvId,$POST_CondicionPago,$POST_Moneda);

$ArrPagos = $ResPago['Datos'];
$PagosTotal = $ResPago['Total'];
$PagosTotalSeleccionado = $ResPago['TotalSeleccionado'];

//MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaId","ASC",NULL,1);
$ArrCondicionPagos = $ResCondicionPago['Datos'];

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
	<div class="EstSubMenuBoton"><a href="javascript:tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE ABONOS DE ORDEN DE VENTA DE VEHICULO <?php echo $InsOrdenVentaVehiculo->OvvId;?></span></td>
</tr>

<tr>
  <td>
    Mostrando <b><?php echo $PagosTotalSeleccionado;?></b> de <b><?php echo $PagosTotal;?></b> registros.</td>
</tr>
<tr>
  <td align="left">
  
  <?php $InsOrdenVentaVehiculo->OvvTotal = (($EmpresaMonedaId==$InsOrdenVentaVehiculo->MonId or empty($InsOrdenVentaVehiculo->MonId))?$InsOrdenVentaVehiculo->OvvTotal:($InsOrdenVentaVehiculo->OvvTotal/$InsOrdenVentaVehiculo->OvvTipoCambio));?>
    <?php $InsOrdenVentaVehiculo->OvvSaldo = (($EmpresaMonedaId==$InsOrdenVentaVehiculo->MonId or empty($InsOrdenVentaVehiculo->MonId))?$InsOrdenVentaVehiculo->OvvSaldo:($InsOrdenVentaVehiculo->OvvSaldo/$InsOrdenVentaVehiculo->OvvTipoCambio));?>
    <!--<table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"> <?php echo $InsOrdenVentaVehiculo->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?></td>
        <td align="right" class="EstTablaTotalesEtiqueta">POR COBRAR: <span class="EstMonedaSimbolo"> <?php echo $InsOrdenVentaVehiculo->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><div id="CapTotalOrdenCobros" ></div></td>
        <td align="right" class="EstTablaTotalesEtiqueta">ABONADO: <span class="EstMonedaSimbolo"> <?php echo $InsOrdenVentaVehiculo->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><div id="CapTotalAbonos" ></div></td>
        <td align="right" class="EstTablaTotalesEtiqueta">SALDO: <span class="EstMonedaSimbolo"><?php echo $InsOrdenVentaVehiculo->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><?php echo number_format($InsOrdenVentaVehiculo->OvvSaldo,2);?></td>
      </tr>
    </table>-->
    
    
    
    </td>
</tr>
<tr>
<td align="left">

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
<td>





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="96%" >&nbsp;</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="3" align="center">

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
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->PagId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->PagId; ?>" />				</td>
                <td align="right" valign="middle" width="96%"   >
                  <table width="100%">
                    <tr>
                      <td width="27%">Id:</td>
                      <td width="73%"><?php echo $dat->PagId;  ?></td>
                    </tr>
                    <tr>
                      <td>Ord. Venta:</td>
                      <td><?php echo $dat->OvvId;  ?></td>
                    </tr>
                    <tr>
                      <td>Num. Recibo:</td>
                      <td><?php echo $dat->PagNumeroRecibo;  ?></td>
                    </tr>
                    <tr>
                      <td>Fecha:</td>
                      <td><?php echo $dat->PagFecha; ?></td>
                    </tr>
                    <tr>
                      <td>Fecha Transac.</td>
                      <td><?php echo $dat->PagFechaTransaccion;  ?></td>
                    </tr>
                    <tr>
                      <td>Num Transac.</td>
                      <td><?php echo $dat->PagNumeroTransaccion;  ?></td>
                    </tr>
                    <tr>
                      <td>Moneda:</td>
                      <td><?php echo ($dat->MonNombre);?></td>
                    </tr>
                    <tr>
                      <td>T.C.</td>
                      <td><?php echo ($dat->PagTipoCambio);?></td>
                    </tr>
                    <tr>
                      <td>Monto:</td>
                      <td><?php $dat->PagMonto = (($dat->PagMonto/(empty($dat->PagTipoCambio)?1:$dat->PagTipoCambio)));?>
                      <?php echo number_format($dat->PagMonto,2); ?></td>
                    </tr>
                    <tr>
                      <td>Estado:</td>
                      <td><?php echo ($dat->PagEstadoDescripcion);?></td>
                    </tr>
                    <tr>
                      <td>Doc. Scan.</td>
                      <td><?php            
if(!empty($dat->PagFoto1)){
	
	$extension = strtolower(pathinfo($dat->PagFoto1, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->PagFoto1, '.'.$extension);  
?>
                        <a  target="_blank" href="subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>"  title=""><img border="0"  src="imagenes/documento.gif"  /></a>
                        <?php	
}
?>
                        <?php            
if(!empty($dat->PagFoto2)){
	
	$extension = strtolower(pathinfo($dat->PagFoto2, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->PagFoto2, '.'.$extension);  
?>
                        <!--  class="thickbox"-->
                        <a   target="_blank" href="subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>"  title=""><img border="0"  src="imagenes/documento.gif"  /></a>
                      <?php	
}
?></td>
                    </tr>
                    <tr>
                      <td>Acciones</td>
                      <td><?php
if($PrivilegioEliminar){
?>
                        <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->PagId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="35" height="35" border="0" title="Eliminar completamente"   /></a>
                        <?php
}
?>
                        <?php
if($PrivilegioEditar){
?>
                        <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>C.php?Mod=PagoOrdenVentaVehiculo&amp;Form=<?php echo (($dat->PagEstado==1)?"OrdenCobro":"Abono");?>Editar&amp;Id=<?php echo $dat->PagId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&amp;OvvId=<?php echo $GET_OvvId;?>&amp;FtaId=<?php echo $GET_FtaId;?>"><img src="imagenes/acciones/acc_editar.png" width="35" height="35" border="0" title="Editar" alt="[Editar]"   /></a>
                        <?php
}
?>
                        <?php
if($PrivilegioVer){
?>
                        <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>C.php?Mod=PagoOrdenVentaVehiculo&amp;Form=<?php echo (($dat->PagEstado==1)?"OrdenCobro":"Abono");?>Ver&amp;Id=<?php echo $dat->PagId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&amp;OvvId=<?php echo $GET_OvvId;?>&amp;FtaId=<?php echo $GET_FtaId;?>"><img src="imagenes/acciones/acc_ver.png" width="35" height="35" border="0" title="Ver" alt="[Ver]"   /></a>
                      <?php
}
?></td>
                    </tr>
                  </table>
                  
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

