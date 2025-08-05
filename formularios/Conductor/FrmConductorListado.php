<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>


<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioImportarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"ImportarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>



<?php $PrivilegioSincronizar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Sincronizar"))?true:false;?>
<?php $PrivilegioResetear = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Resetear"))?true:false;?>
<?php $PrivilegioBloquear = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Bloquear"))?true:false;?>

<?php
//deb($PrivilegioResetear);
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsConductor.js" ></script>



<?php
 /**
 *
 * @Autor: Ing. Jonathan Blanco Alave
 * @Contacto: jba80@ingenieros.com
 */

$POST_Campo = ($_POST['Cam']);
$POST_Filtro = ($_POST['Fil']);

if($_POST){
	$_SESSION[$GET_mod."Filtro"] = $POST_fil;
}else{
	$POST_Filtro = (empty($_POST['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_POST['Fil']);
}


$POST_Orden = ($_POST['Ord']);
$POST_Sentido = ($_POST['Sen']);
$POST_Paginacion = ($_POST['Pag']);
$POST_p = ($_POST['P']);
$POST_num = ($_POST['Num']);
$POST_seleccionados = $_POST['cmp_seleccionados'];
$POST_acc = $_POST['Acc'];

$POST_Estado = $_POST['Estado'];
$POST_Modalidad = $_POST['Modalidad'];
$POST_Turno = $_POST['Turno'];
$POST_ConClave = $_POST['ConClave'];
$POST_ConUnidad = $_POST['ConUnidad'];
$POST_Supervisor = $_POST['Supervisor'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '15';
}
if(empty($POST_Orden)){
	$POST_Orden = 'VehUnidad';
}

if(empty($POST_Sentido)){
	$POST_Sentido = 'ASC';
}

if(empty($POST_Paginacion)){
	$POST_Paginacion = '0,'.$POST_num;
}

if(empty($POST_Campo)){
	$POST_Campo = 'veh.VehUnidad';
}





/*
* Otras variables
*/


/*
if(empty($POST_Estado)){
	$POST_Estado = "1,2";
}*/

//deb($POST_Estado);

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjConductor.php');

require_once($InsProyecto->MtdRutClases().'ClsAuditoria.php');
require_once($InsProyecto->MtdRutClases().'ClsConductor.php');

$InsConductor = new ClsConductor();

$InsConductor->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccConductor.php');


//MtdObtenerConductores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ConId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTurno=NULL,$oNuevo=0,$oRetirado=0,$oConClave=0,$oConAplicacion=0,$oModalidad=NULL,$oConUnidad=0,$oConRetiro=0,$oSupervisor=0)
$ResConductor = $InsConductor->MtdObtenerConductores($POST_Campo,"contiene",$POST_Filtro,$POST_Orden,$POST_Sentido,$POST_Paginacion,$POST_Estado,$POST_Turno,0,0,$POST_ConClave,0,$POST_Modalidad,$POST_ConUnidad,2,$POST_Supervisor);
$ArrConductors = $ResConductor['Datos'];
$ConductorsTotal = $ResConductor['Total'];
$ConductorsTotalSeleccionado = $ResConductor['TotalSeleccionado'];

/*
 * interface FrmConductorListado {
    //put your code here  
}
*/

?>


<script type="text/javascript">
$(function(){

	$('#Fil').focus();


});
	
</script>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<input type="hidden" name="Mod" id="Mod" value="Conductor" />
<input type="hidden" name="Form" id="Form" value="Listado" />

<div class="EstCapMenu">
<?php
if($PrivilegioEliminar){
?>	
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 

<?php
}
?>


<?php
if($PrivilegioBloquear){
?>	
<div class="EstSubMenuBoton"><a href="javascript:FncHabilitarSeleccionados();"><img src="imagenes/iconos/habilitado.png" alt="[Habilitar]" title="Habilitar" />Habilitar</a></div> 
<?php
}
?>


<?php
if($PrivilegioBloquear){
?>	
<div class="EstSubMenuBoton"><a href="javascript:FncDeshabilitarSeleccionados();"><img src="imagenes/iconos/deshabilitado.png" alt="[Deshabilitar]" title="Deshabilitar" />Deshabilitar</a></div> 
<?php
}
?>
</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" align="center"><span class="EstFormularioTitulo">LISTAR CONDUCTORES </span>
  
     (<b><?php echo $ConductorsTotalSeleccionado;?></b> de <b><?php echo $ConductorsTotal;?></b> elementos)     </td>
</tr>

<tr>
<td align="right">

		<input type="hidden" name="Acc" id="Acc" value="" />
        <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_Orden;?>" />
        <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_Sentido;?>" />
        <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_Paginacion;?>" />
        <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
        
        <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
        
        
<label>
        <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCaja" name="Fil" type="text" id="Fil" value="<?php echo $POST_Filtro;?>" size="20" />
</label>


<label>
       <select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="con.ConId" <?php if($POST_Campo=="con.ConId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="ConNumeroDocumento" <?php if($POST_Campo=="ConNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Documento</option>
		<option value="ConNombre" <?php if($POST_Campo=="ConNombre"){ echo 'selected="selected"';}?>>Nombre</option>
        <option value="ConApellido" <?php if($POST_Campo=="ConApellido"){ echo 'selected="selected"';}?>>Apellidos</option>
        <option value="ConDireccion" <?php if($POST_Campo=="ConDireccion"){ echo 'selected="selected"';}?>>Direccion</option>
        <option value="ConTelefono" <?php if($POST_Campo=="ConTelefono"){ echo 'selected="selected"';}?>>Telefono</option>
        <option value="ConCelular" <?php if($POST_Campo=="ConCelular"){ echo 'selected="selected"';}?>>Celular</option>
        <option value="ConNumeroBrevete" <?php if($POST_Campo=="ConNumeroBrevete"){ echo 'selected="selected"';}?>>Num. Brevete</option>        
                <option value="ConSituacion" <?php if($POST_Campo=="ConSituacion"){ echo 'selected="selected"';}?>>Situacion</option>        
                
                
       <option value="veh.VehUnidad" <?php if($POST_Campo=="veh.VehUnidad"){ echo 'selected="selected"';}?>>Unidad</option>  
		<option value="veh.VehColor" <?php if($POST_Campo=="veh.VehColor"){ echo 'selected="selected"';}?>>Color</option>  
        <option value="veh.VehModelo" <?php if($POST_Campo=="veh.VehModelo"){ echo 'selected="selected"';}?>>Modelo</option>      
       </select>
</label>

<label>
        Turno:
		<select class="EstFormularioCombo" name="Turno" id="Turno">
        <option value="" >Todos</option>
        <option value="1" <?php if($POST_Turno=="1"){ echo 'selected="selected"';}?>>DIA</option>
        <option value="2" <?php if($POST_Turno=="2"){ echo 'selected="selected"';}?>>NOCHE</option>        
        <option value="3" <?php if($POST_Turno=="3"){ echo 'selected="selected"';}?>>PUERTA LIBRE</option>        
        </select>
</label>



<label>
       Modalidad:
		<select class="EstFormularioCombo" name="Modalidad" id="Modalidad">
        <option value="" >Todos</option>
        <option value="APP 114" <?php if($POST_Modalidad=="APP 114"){ echo 'selected="selected"';}?>>APP 114</option>
        <option value="RT 114" <?php if($POST_Modalidad=="RT 114"){ echo 'selected="selected"';}?>>RT 114</option>        
        </select>
</label>

<label>
		 Unidad Asignada:
		<select class="EstFormularioCombo" name="ConUnidad" id="ConUnidad">
        <option value="" >Todos</option>
        <option value="1" <?php if($POST_ConUnidad==1){ echo 'selected="selected"';}?>>Si</option>
        <option value="2" <?php if($POST_ConUnidad==2){ echo 'selected="selected"';}?>>No</option>        
        </select>
</label>

<label>
		Estado:
		<select class="EstFormularioCombo" name="Estado" id="Estado">
        <option value="" >Todos</option>
        <option value="1" <?php if($POST_Estado=="1"){ echo 'selected="selected"';}?>>Habilitado</option>
        <option value="2" <?php if($POST_Estado=="2"){ echo 'selected="selected"';}?>>Deshabilitado</option>        
	<!--	<option value="3" <?php if($POST_Estado==3){ echo 'selected="selected"';}?>>Retirado</option>   -->     
        </select>
</label>

<label>
		Con Aplicacion:
		<select class="EstFormularioCombo" name="ConClave" id="ConClave">
        <option value="0" <?php if($POST_ConClave==0){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_ConClave==1){ echo 'selected="selected"';}?>>Si</option>
        <option value="2" <?php if($POST_ConClave==2){ echo 'selected="selected"';}?>>No</option>        
        </select>
</label>

<label>
		Supervisor:
		<select class="EstFormularioCombo" name="Supervisor" id="Supervisor">
        <option value="" <?php if($POST_Supervisor==""){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_Supervisor=="1"){ echo 'selected="selected"';}?>>Si</option>
        <option value="2" <?php if($POST_Supervisor=="2"){ echo 'selected="selected"';}?>>No</option>        
        </select>
</label>



		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="BUSCAR" /></td>
</tr>
<tr>
<td>





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" align="center" >#</th>
                <th width="2%" align="center" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="2%" align="center" ><?php
				if($POST_Orden == "ConId"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('ConId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="7%" align="center" ><?php
				if($POST_Orden == "ConModalidad"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConModalidad','ASC');"> Modalidad <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConModalidad','DESC');"> Modalidad <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConModalidad','ASC');"> Modalidad </a>
                <?php
				}
				?></th>
                <th width="5%" align="center" ><?php
				if($POST_Orden == "VehUnidad"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VehUnidad','ASC');"> Unidad  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VehUnidad','DESC');"> Unidad   <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VehUnidad','ASC');"> Unidad   </a>
                  <?php
				}
				?></th>
                <th width="4%" align="center" ><?php
				if($POST_Orden == "VehPlaca"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VehPlaca','ASC');"> Placa <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VehPlaca','DESC');"> Placa <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VehPlaca','ASC');"> Placa </a>
                  <?php
				}
				?></th>
                <th width="4%" align="center" ><?php
				if($POST_Orden == "VehColor"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VehColor','ASC');"> Color <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VehColor','DESC');"> Color <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VehColor','ASC');"> Color </a>
                  <?php
				}
				?></th>
                <th width="5%" align="center" ><?php
				if($POST_Orden == "VehMarca"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VehMarca','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VehMarca','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{
				?>
                  <a href="javascript:FncOrdenar('VehMarca','ASC');"> Marca </a>
                  <?php
				}
				?></th>
                <th width="5%" align="center" ><?php
				if($POST_Orden == "VehModelo"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VehModelo','ASC');"> Modelo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VehModelo','DESC');"> Modelo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VehModelo','ASC');"> Modelo </a>
                  <?php
				}
				?></th>
                <th width="4%" align="center" ><?php
				if($POST_Orden == "ConNumeroDocumento"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConNumeroDocumento','ASC');">Num. Doc. </a>
                <?php
				}
				?></th>
                <th width="5%" align="center" ><?php
				if($POST_Orden == "ConNombre"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConNombre','ASC');"> Nombre  </a>
                  <?php
				}
				?></th>
                <th width="6%" align="center" ><?php
				if($POST_Orden == "ConApellido"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConApellido','ASC');"> Apellidos <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConApellido','DESC');"> Apellidos <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConApellido','ASC');"> Apellidos </a>
                <?php
				}
				?></th>
                <th width="6%" align="center" ><?php
				if($POST_Orden == "ConTelefono"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConTelefono','ASC');"> Telefono <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConTelefono','DESC');"> Telefono <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConTelefono','ASC');"> Telefono </a>
                <?php
				}
				?></th>
                <th width="5%" align="center" ><?php
				if($POST_Orden == "ConCelular"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConCelular','ASC');"> Celular <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConCelular','DESC');"> Celular <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConCelular','ASC');"> Celular </a>
                <?php
				}
				?></th>
                <th width="6%" align="center" ><?php
				if($POST_Orden == "ConSituacion"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConSituacion','ASC');"> Situacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConSituacion','DESC');"> Situacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConSituacion','ASC');"> Situacion </a>
                  <?php
				}
				?></th>
                <th width="6%" align="center" ><?php
				if($POST_Orden == "ConTurno"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConTurno','ASC');"> Turno <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConTurno','DESC');"> Turno <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConTurno','ASC');"> Turno </a>
                <?php
				}
				?></th>
                <th width="8%" align="center" ><?php
				if($POST_Orden == "ConEstado"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConEstado','ASC');"> Estado <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConEstado','DESC');"> Estado <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConEstado','ASC');"> Estado </a>
                  <?php
				}
				?></th>
                <th width="3%" align="center" ><?php
				if($POST_Orden == "ConFoto"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ConFoto','ASC');"> Foto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConFoto','DESC');"> Foto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ConFoto','ASC');"> Foto </a>
                <?php
				}
				?></th>
                <th width="5%" align="center" >
                  <?php
				if($POST_Orden == "ConTiempoCreacion"){
					if($POST_Sentido == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('ConTiempoCreacion','ASC');">
                  Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ConTiempoCreacion','DESC');">
                    
                  Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('ConTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="10%" align="center" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="20" align="center">



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

				  <option <?php if($POST_num==$ConductorsTotal){ echo 'selected="selected"';}?> value="<?php echo $ConductorsTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_Filtro)){
						$tregistros = $ConductorsTotal;
					//}else{
					//	$tregistros = ($ReclamosTotalSeleccionado);
					//}
					
					$cant_paginas=ceil($tregistros/$numxpag);
					?>



					<?php
					if($POST_p<>"1"){
					?>

					<a class="EPaginacion" href="javascript:FncPaginar('0,<?php echo $numxpag;?>','1');">
					Inicio					</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<=$cant_paginas & $POST_p<>"1"){

					$pagina = explode(",",$POST_Paginacion);

					?>
					<a class="EPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]-$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p-1)?>');">Anterior</a>
					<?php
					}
					?>

					&nbsp;
					<?php
					$num = 0;
					
					for($i=1;$i<=$cant_paginas;$i++){
					?>
						
                        <a class="EPaginacion"  href="javascript:FncPaginar('<?php echo $num?>,<?php echo $numxpag;?>','<?php echo $i?>');" ><?php echo $i?></a>
					<?php
							$num = $num + $numxpag ;
						}
					?>

					&nbsp;
					<?php
					if($POST_p<$cant_paginas){
						$pagina = explode(",",$POST_Paginacion);
					?>
						<a class="EPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]+$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p+1)?>');">Siguiente</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<>$cant_paginas){
					?>
						<a class="EPaginacion"  href="javascript:FncPaginar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Final</a>
					<?php
					}
					?>
					&nbsp;
						Pagina <?php echo $POST_p;?> de <?php echo $cant_paginas;?>                                   </td>
              </tr>
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_Paginacion);
								$f=$pagina[0]+1;

								foreach($ArrConductors as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->ConId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->ConId; ?>" />				</td>

                <td align="left" valign="middle" width="2%"   ><?php echo $dat->ConId;  ?></td>
                <td  width="7%" align="left" ><?php echo $dat->ConModalidad;  ?></td>
                <td align="left" valign="middle" width="5%"   >
                  
                  <?php echo $dat->VehUnidad; ?>
                  
                   <?php
				if(!empty($dat->ConClave)){
			?>
					<img src="imagenes/pedidos/android.png" width="20" height="20" alt="Celular/Android" title="Celular/Android" />
            <?php			
				}
			?>	
             <?php
				if(($dat->ConSupervisor)=="1"){
			?>
					<img src="imagenes/supervisor.png" width="20" height="20" alt="Supervisor" title="Supervisor" />
            <?php			
				}
			?>	
            
            
				<?php
			/*switch($dat->ConAplicacion){
				case 1:
			?>
                  
                  <?php
				break;
				
				case 2:
			?>
                  <?php
				break;

			}*/
			?>
                  
                </td>
                <td width="4%" align="left" valign="middle"   ><?php echo $dat->VehPlaca; ?></td>
                <td width="4%" align="left" valign="middle"   ><?php echo $dat->VehColor; ?></td>
                <td width="5%" align="left" valign="middle"   ><?php echo $dat->VehMarca; ?></td>
                <td width="5%" align="left" valign="middle"   ><?php echo $dat->VehModelo; ?></td>
                <td align="left" valign="middle" width="4%"   ><?php echo $dat->ConNumeroDocumento; ?></td>
                <td align="left" valign="middle" width="5%"   ><?php echo $dat->ConNombre; ?></td>
                <td  width="6%" align="left" ><?php echo $dat->ConApellido; ?></td>
                <td  width="6%" align="left" ><?php echo $dat->ConTelefono; ?></td>
                <td  width="5%" align="left" ><?php echo $dat->ConCelular; ?></td>
                <td  width="6%" align="left" ><?php echo $dat->ConSituacion; ?></td>
                <td  width="6%" align="left" ><?php
			switch($dat->ConTurno){
				case 1:
			?>
                  DIA
                  <?php
				break;
				
				case 2:
			?>
                  NOCHE
                  <?php
				break;
				
				case 3:
			?>
                  PUERTA LIBRE
                <?php
				break;
			}
			?></td>
                <td  width="8%" align="left" ><?php
			switch($dat->ConEstado){
				case 1:
			?>
                  <!--<img src="imagenes/habilitado.gif" alt="[Habilitado]" title="Habilitado" width="20" height="20" />-->
                  Habilitado
                  <?php
				break;
				
				case 2:
			?>
            	Deshabilitado
                  <!--<img src="imagenes/deshabilitado.gif" alt="[Deshabilitado]" title="Deshabilitado" width="20" height="20" />-->
                  <?php
				break;
				
				case 3:
			?>
Retirado
            <?php	
				break;

			}
			?></td>
                <td  width="3%" align="center" >

			<?php
			if(!empty($dat->ConFoto)){
			?>

<!--<a href="subidos/conductor_fotos/<?php echo $dat->ConFoto;?>" target="_blank">
<img src="imagenes/chat.png" width="25" height="25" border="0" />
</a>-->


<a href="javascript:FncConductorMostrarFoto('subidos/conductor_fotos/<?php echo $dat->ConFoto;?>');" >
<img src="imagenes/chat.png" width="25" height="25" border="0" />
</a>


            <?php	
			}			
			?>
                <?php //echo ($dat->ConFoto);?>
               
                </td>
                <td  width="5%" align="right" ><?php echo ($dat->ConTiempoCreacion);?></td>
        <td  width="10%" align="center" >


<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->ConId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>



<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->ConId;?>');"> <img  src="imagenes/acciones/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>


<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->ConId;?>"><img src="imagenes/acciones/editar.gif" width="19" height="19" border="0" title="Modificar" alt="[Modificar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->ConId;?>"><img src="imagenes/acciones/ver.gif" width="19" height="19" border="0" title="Ver" alt="[Visualizar]"   /></a>
<?php
}
?>


 <?php
			if($PrivilegioVistaPreliminar){
			?>
         
         <a href="javascript:FncConductorVistaPreliminar('<?php echo $dat->ConId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
         
         
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
         
<a href="javascript:FncConductorImprmir('<?php echo $dat->ConId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>


			<?php
			}
			?>
            
        	<?php
			if($PrivilegioGenerarExcel){
			?>        
         
<a href="javascript:FncConductorGenerarExcel('<?php echo $dat->ConId;?>');"><img src="imagenes/excel.png" alt="[Generar Excel]" title="Generar Excel" width="19" height="19" border="0" /></a>

			<?php
			}
			?>
            

	
			<?php
				if(!empty($dat->ConClave)){
			?>




<?php
if($PrivilegioSincronizar){
?>
<!--


<a href="tareas/TarConductorCargarSolo.php?ConId=<?php echo $dat->ConId?>" target="_blank"><img src="imagenes/sincronizar.png" width="19" height="19" border="0" title="Sincronizar" alt="[Sincronizar]"   /></a>
-->
<a href="javascript:FncConductorCargarSolo('<?php echo $dat->ConId?>');" ><img src="imagenes/sincronizar.png" width="19" height="19" border="0" title="Sincronizar" alt="[Sincronizar]"   /></a>


<?php
}
?>

<?php

//deb($PrivilegioResetear);
if($PrivilegioResetear){
?>

<!--<a href="tareas/TarConductorResetearSolo.php?ConId=<?php echo $dat->ConId?>" target="_blank"><img src="imagenes/resetear.png" width="19" height="19" border="0" title="Resetear" alt="[Resetear]"   /></a>

-->
<a href="javascript:FncConductorResetearSolo('<?php echo $dat->ConId?>');" ><img src="imagenes/resetear.png" width="19" height="19" border="0" title="Resetear" alt="[Resetear]"   /></a>



<?php
}
?>

<?php
/*if($PrivilegioBloquear){
?>

<a href="tareas/TarCargarConductorBloquear.php?ConId=<?php echo $dat->ConId?>" target="_blank"><img src="imagenes/bloquear.png" width="19" height="19" border="0" title="Bloquear" alt="[Bloquear]"   /></a>

<a href="tareas/TarCargarConductorDesbloquear.php?ConId=<?php echo $dat->ConId?>" target="_blank"><img src="imagenes/desbloquear.png" width="19" height="19" border="0" title="Desbloquear" alt="[Desbloquear]"   /></a>

<?php
}*/
?>


            <?php			
				}
			?>	
			
            

<?php
if($PrivilegioVer){
?>
<!--
	location.href = "http://rt214v2.ddns.net:777/apptaxi114/formularios/Mapa/DiaMapaListado.php";	
    -->
    
                    
<a href="javascript:FncConductorUbicaciones('<?php echo $dat->ConNumeroDocumento?>');"><img src="imagenes/ubicacion.png" width="19" height="19" border="0" title="Ubicaciones" alt="[Ubicaciones]"   /></a>

<?php
}
?>


<?php
if($PrivilegioVer){
?>
<!--
	location.href = "http://rt214v2.ddns.net:777/apptaxi114/formularios/Mapa/DiaMapaListado.php";	
    -->
    
<a href="javascript:FncConductorCalificaciones('<?php echo $dat->ConNumeroDocumento?>');"><img src="imagenes/calificar.png" width="19" height="19" border="0" title="Calificaciones" alt="[Calificaciones]"   /></a>

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
$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();

?>
<?php
}else{
echo ERR_GEN_101;
}
?>