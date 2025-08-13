<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClienteNota",$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClienteNota","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClienteNota","Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClienteNota","Eliminar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteNota.js"></script>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */
//deb($_GET);
$GET_CliId = $_GET['CliId'];

$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Cno']);
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';
$POST_CondicionClienteNota = $_POST['CmpCondicionClienteNota'];
$POST_Cliente = $_POST['CmpCliente'];
$POST_Estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CnoTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_finicio)){
$POST_finicio =  "01/01/".date("Y");
}

if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjClienteNota.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsClienteNota.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');


//INSTANCAS
$InsClienteNota = new ClsClienteNota();
$InsCliente = new ClsCliente();

$InsClienteNota->UsuId = $_SESSION['SesionId'];
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClienteNota.php');
//DATOS
//MtdObtenerClienteNotas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CnoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oClienteId=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
$ResClienteNota = $InsClienteNota->MtdObtenerClienteNotas("cno.CnoId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cno.CnoDescripcion","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_Estado,$GET_CliId,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
$ArrClienteNotas = $ResClienteNota['Datos'];
$ClienteNotasTotal = $ResClienteNota['Total'];
$ClienteNotasTotalSeleccionado = $ResClienteNota['TotalSeleccionado'];

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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE NOTAS DE CLIENTE</span></td>
</tr>

<tr>
  <td>
    Mostrando <b><?php echo $ClienteNotasTotalSeleccionado;?></b> de <b><?php echo $ClienteNotasTotal;?></b> registros.</td>
</tr>
<tr>
  <td align="right"><!--<table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstClienteSimbolo"> <?php echo $InsVentaDirecta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><?php echo number_format($InsVentaDirecta->VdiTotal,2);?></td>
        <td align="right" class="EstTablaTotalesEtiqueta">POR COBRAR: <span class="EstClienteSimbolo"> <?php echo $InsVentaDirecta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><div id="CapTotalOrdenCobros" ></div></td>
        <td align="right" class="EstTablaTotalesEtiqueta">ABONADO: <span class="EstClienteSimbolo"> <?php echo $InsVentaDirecta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><div id="CapTotalAbonos" ></div></td>
        <td align="right" class="EstTablaTotalesEtiqueta">SALDO: <span class="EstClienteSimbolo"><?php echo $InsVentaDirecta->MonSimbolo;?></span></td>
        <td align="right" class="EstTablaTotalesContenido"><?php echo number_format($InsVentaDirecta->VdiSaldo,2);?></td>
      </tr>
    </table>-->
    
    
    
    </td>
</tr>
<tr>
<td align="right">

		<input type="hidden" name="Acc" id="Acc" value="" />
        <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
        <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
        <input type="hidden" name="Cno" id="Cno" value="<?php echo $POST_pag;?>" />
        <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
        
        <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />

          <span class="EstFormularioEtiqueta">Buscar:</span>

 <span class="EstFormularioContenido">  
     <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    </span> <span class="EstFormularioEtiqueta">  
      Fecha Inicio:
      </span>
        <span class="EstFormularioContenido">  
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="8" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
  </span>
		  <span class="EstFormularioEtiqueta">  
    Fecha Fin:
    </span>
     <span class="EstFormularioContenido">  
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="8" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />	
</span>




Estado:
		<select class="EstFormularioCombo" name="Estado" id="Estado">
		<option value="0" <?php if($POST_Estado==0){ echo 'selected="selected"';}?>>Todos</option>
      	<option value="1" <?php if($POST_Estado==1){ echo 'selected="selected"';}?>>Expirado</option>
		<option value="3" <?php if($POST_Estado==3){ echo 'selected="selected"';}?>>Vigente</option>
		</select>
        
        


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

                <th width="6%" ><?php
				if($POST_ord == "CnoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CnoId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CnoId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CnoId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="10%" ><?php
				if($POST_ord == "CnoFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CnoFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CnoFecha','DESC');"> Fecha<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CnoFecha','ASC');"> Fecha </a>
                <?php
				}
				?></th>
                <th width="30%" ><?php
				if($POST_ord == "MonNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MonNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Cliente </a>
                  <?php
				}
				?></th>
                <th width="25%" ><?php
				if($POST_ord == "CnoDescripcion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CnoDescripcion','ASC');"> Contenido <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CnoDescripcion','DESC');"> Contenido<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CnoDescripcion','ASC');"> Contenido </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "CnoEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CnoEstado','ASC');"> Estado <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CnoEstado','DESC');"> Estado <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CnoEstado','ASC');"> Estado </a>
                <?php
				}
				?></th>
                <th width="8%" >
                  <?php
				if($POST_ord == "CnoTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('CnoTiempoCreacion','ASC');">
                  Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CnoTiempoCreacion','DESC');">
                    
                  Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('CnoTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="10%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="9" align="center">

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

				  <option <?php if($POST_num==$ClienteNotasTotal){ echo 'selected="selected"';}?> value="<?php echo $ClienteNotasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ClienteNotasTotal;
					//}else{
					//	$tregistros = ($ClienteNotasTotalSeleccionado);
					//}
					
					$cant_paginas=ceil($tregistros/$numxpag);
					?>



					<?php
					if($POST_p<>"1"){
					?>

					<a class="EstCnoinacion" href="javascript:FncCnoinar('0,<?php echo $numxpag;?>','1');">
					Inicio					</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<=$cant_paginas & $POST_p<>"1"){

					$pagina = explode(",",$POST_pag);

					?>
					<a class="EstCnoinacion"  href="javascript:FncCnoinar('<?php echo ($pagina[0]-$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p-1)?>');">Anterior</a>
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
                        <span class="EstCnoinaActual"><?php echo $i;?></span>
                        <?php	
						}else{
						?>
	<a class="EstCnoinacion"  href="javascript:FncCnoinar('<?php echo $num?>,<?php echo $numxpag;?>','<?php echo $i?>');" ><?php echo $i?></a>                        
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
						<a class="EstCnoinacion"  href="javascript:FncCnoinar('<?php echo ($pagina[0]+$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p+1)?>');">Siguiente</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<>$cant_paginas){
					?>
						<a class="EstCnoinacion"  href="javascript:FncCnoinar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Final</a>
					<?php
					}
					?>
					&nbsp;
						Cnoina <?php echo $POST_p;?> de <?php echo $cant_paginas;?>                    </td>
              </tr>
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;


				$TotalAbonos = 0;
				$TotalOrdenCobros = 0;
				
				
								foreach($ArrClienteNotas as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->CnoId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CnoId; ?>" />				</td>

                <td align="right" valign="middle" width="6%"   ><?php echo $dat->CnoId;  ?></td>
                <td align="right" ><?php echo $dat->CnoFecha;  ?></td>
                <td align="right" ><?php echo ($dat->CliNombre);?>
                <?php echo ($dat->CliApellidPaterno);?>
                <?php echo ($dat->CliApellidMaterno);?></td>
                <td  width="25%" align="right" ><?php echo $dat->CnoDescripcion;  ?></td>
                <td  width="7%" align="right" ><?php echo ($dat->CnoEstadoDescripcion);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->CnoTiempoCreacion);?></td>
        <td  width="10%" align="center" >


<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CnoId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>

<?php
if($PrivilegioEditar){
?>

    <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=ClienteNota&Form=Editar&Id=<?php echo $dat->CnoId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&CliId=<?php echo $GET_CliId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
    
<?php
}
?>

<?php
if($PrivilegioVer){
?>
	
    <a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=ClienteNota&Form=Ver&Id=<?php echo $dat->CnoId;?><?php echo (!empty($GET_dia)?'&Dia=1':'');?>&CliId=<?php echo $GET_CliId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
    
<?php
}
?>

</td>
              </tr>

              <?php		
			  
			  
			    
			  if($dat->CnoEstado == 1){
				  $TotalOrdenCobros += $dat->CnoMonto;
			  }
			  
			  if($dat->CnoEstado == 3){
				  $TotalAbonos += $dat->CnoMonto;
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

