<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado")){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php //$PrivilegioImportar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Importar"))?true:false;?>


<?php $PrivilegioVehiculoMarcaEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMarca","Editar"))?true:false;?>
<?php $PrivilegioVehiculoMarcaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMarca","Ver"))?true:false;?>

<?php $PrivilegioVehiculoModeloEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoModelo","Editar"))?true:false;?>
<?php $PrivilegioVehiculoModeloVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoModelo","Ver"))?true:false;?>

<?php $PrivilegioVehiculoVersionEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoVersion","Editar"))?true:false;?><?php $PrivilegioVehiculoVersionVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoVersion","Ver"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngreso.js" ></script>

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

//Nuevo
$POST_VehiculoIngresoTipo = $_POST['CmpVehiculoIngresoTipo'];
$POST_con = $_POST['Con'];
$POST_est = $_POST['Est'];
$POST_EstadoVehicular = $_POST['EstadoVehicular'];
$POST_ConProforma = $_POST['ConProforma'];

$POST_VehiculoMarcaId = $_POST['VehiculoMarca'];
$POST_VehiculoModeloId = $_POST['VehiculoModelo'];
$POST_VehiculoVersionId = $_POST['VehiculoVersion'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_Concesionario = $_POST['CmpConcesionario'];

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
	$POST_Concesionario = $_SESSION['SesionConcesionario'];
}




if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'EinTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_cam)){
	$POST_cam = 'EinVIN';
}

// Variables Extra
if(empty($POST_con)){
	$POST_con = "contiene";
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoIngreso.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsConcesionario.php');


//INSTANCIAS
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsConcesionario = new ClsConcesionario();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngreso.php');
//DATOS
//////MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL)

  
//MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL)

$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("ein.EinId,ein.EinVIN,VmaNombre,VmoNombre,VveNombre,EinAnoFabricacion,EinNumeroMotor,EinPlaca,EinPoliza,EinComprobanteCompraNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,NULL,NULL,"STOCK",$POST_VehiculoMarcaId,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal,$POST_Concesionario);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];
$VehiculoIngresosTotal = $ResVehiculoIngreso['Total'];
$VehiculoIngresosTotalSeleccionado = $ResVehiculoIngreso['TotalSeleccionado'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_Marca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$RepVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,"VveNombre","ASC",NULL);
$ArrVehiculoVersiones = $RepVehiculoVersion['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$ResConcesionario = $InsConcesionario->MtdObtenerConcesionarios(NULL,NULL,'OncNombre',"ASC",NULL,1);
$ArrConcesionarios = $ResConcesionario['Datos'];


//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmVehiculoIngresoListado {
    //put your code here  
}
*/

?>
<script type="text/javascript">

var VehiculoMarcaId = "<?php echo $POST_VehiculoMarcaId;?>";
var VehiculoModeloId = "<?php echo $POST_VehiculoModeloId;?>";
var VehiculoVersionId = "<?php echo $POST_VehiculoVersionId;?>";

</script>

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



</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE STOCK DE  VEHICULOS</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $VehiculoIngresosTotalSeleccionado;?></b> de <b><?php echo $VehiculoIngresosTotal;?></b> registros.</td>
</tr>
<tr>
  <td align="right">
  
<input type="hidden" name="CmpVehiculoIngresoTipo" id="CmpVehiculoIngresoTipo" value="" />
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
       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
         <option value="EinId" <?php if($POST_cam=="EinId"){ echo 'selected="selected"';}?>>Id</option>
         <option value="EinVIN" <?php if($POST_cam=="EinVIN"){ echo 'selected="selected"';}?>>VIN</option>
         <option value="VmaNombre" <?php if($POST_cam=="VmaNombre"){ echo 'selected="selected"';}?>>Marca</option>
         <option value="VmoNombre" <?php if($POST_cam=="VmoNombre"){ echo 'selected="selected"';}?>>Modelo</option>
         <option value="EinAnoFabricacion" <?php if($POST_cam=="EinAnoFabricacion"){ echo 'selected="selected"';}?>>Modelo</option>
         <option value="EinNumeroMotor" <?php if($POST_cam=="EinNumeroMotor"){ echo 'selected="selected"';}?>>Nro. Motor</option>
         <option value="EinPlaca" <?php if($POST_cam=="EinPlaca"){ echo 'selected="selected"';}?>>Placa</option>
         <option value="EinPoliza" <?php if($POST_cam=="EinPoliza"){ echo 'selected="selected"';}?>>Poliza</option>
       </select>-->
            
           
       
       
            
             
            Marca:
            
            <select class="EstFormularioCombo" name="VehiculoMarca" id="VehiculoMarca" >
                <option value="">Escoja una opcion</option>
                <?php
			/*foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$POST_VehiculoMarcaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                <?php
			}*/
			?>
              </select>
            
            Modelo:            
            <select class="EstFormularioCombo" name="VehiculoModelo" id="VehiculoModelo" >
                <option value="">Escoja una opcion</option>
                <?php
			/*foreach($ArrVehiculoModelos as $DatVehiculoModelo){
			?>
                <option <?php echo $DatVehiculoModelo->VmoId;?> <?php echo ($DatVehiculoModelo->VmoId==$POST_VehiculoModeloId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoModelo->VmoId?>"><?php echo $DatVehiculoModelo->VmoNombre?></option>
                <?php
			}*/
			?>
              </select>

            Version:            
           <select class="EstFormularioCombo" name="VehiculoVersion" id="VehiculoVersion" >
                <option value="">Escoja una opcion</option>
                <?php
			/*foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
			?>
                <option <?php echo $DatVehiculoVersion->VveId;?> <?php echo ($DatVehiculoVersion->VveId==$POST_VehiculoVersionId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoVersion->VveId?>"><?php echo $DatVehiculoVersion->VveNombre?></option>
                <?php
			}*/
			?>
              </select>
             
            <!--<select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                <option value="">Escoja una opcion</option>
                <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$POST_VehiculoMarcaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                <?php
			}
			?>
              </select>-->
            
            
      
           
Sucursal:
       
       <select class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
            <option value="">Todos</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select>
            
            
            
            Concesionario: <select class="EstFormularioCombo" name="CmpConcesionario" id="CmpConcesionario" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrConcesionarios as $DatConcesionario){
			?>
              <option <?php echo $DatConcesionario->OncId;?> <?php echo ($DatConcesionario->OncId==$POST_Concesionario)?'selected="selected"':"";?> value="<?php echo $DatConcesionario->OncId?>"><?php echo $DatConcesionario->OncNombre?></option>
              <?php
			}
			?>
            </select>
            
            
            
		<!--<select name="Car" id="Car" class="EstFormularioCombo">
		  <option value=""  <?php if($POST_car==true){ echo 'selected="selected"';}?> >Listado Avanzado</option>
		  <option value="false"  <?php if($POST_car==false){ echo 'selected="selected"';}?>>Listado Simple </option>
	    </select>-->
	  <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
  <td width="87%" valign="top">
    
    
    
    
    
  <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
    
    <thead class="EstTablaListadoHead">
      
      <tr>
        <th width="2%" >#</th>
        <th width="2%" >
          
          <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
        
        <th width="2%" ><?php
				if($POST_ord == "EinId"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{

				?>
          <a href="javascript:FncOrdenar('EinId','ASC');"> Id.  </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "SucNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('SucNombre','ASC');">Ubicacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('SucNombre','DESC');"> Ubicacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('SucNombre','ASC');"> Ubicacion </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinAnoProforma"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinAnoProforma','ASC');"> A&ntilde;o/Prof. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinAnoProforma','DESC');"> A&ntilde;o/Prof. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinAnoProforma','ASC');"> A&ntilde;o/Prof. </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinMesProforma"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinMesProforma','ASC');"> Mes/Prof. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinMesProforma','DESC');"> Mes/Prof. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinMesProforma','ASC');"> Mes/Prof. </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinNumeroProforma"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinNumeroProforma','ASC');"> Num. Prof. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinNumeroProforma','DESC');"> Num. Prof. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinNumeroProforma','ASC');"> Num. Prof. </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "VtiNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VtiNombre','ASC');"> Tipo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VtiNombre','DESC');"> Tipo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('VtiNombre','ASC');"> Tipo </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinVIN"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinVIN','ASC');"> VIN <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinVIN','DESC');"> VIN <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinVIN','ASC');">  VIN </a>
          <?php
				}
				?></th>
        <th width="5%" ><?php
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
        <th width="5%" >
          <?php
				if($POST_ord == "VmoNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VmoNombre','DESC');"> Modelo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo  </a>
          <?php
				}
				?>		</th>
        <th width="5%" ><?php
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
        <th width="3%" ><?php
				if($POST_ord == "EinAnoFabricacion"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinAnoFabricacion','ASC');"> A&ntilde;o Fab. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinAnoFabricacion','DESC');"> A&ntilde;o Fab. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinAnoFabricacion','ASC');"> A&ntilde;o Fab. </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinAnoModelo"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinAnoModelo','ASC');"> A&ntilde;o Mod. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinAnoModelo','DESC');"> A&ntilde;o Mod. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinAnoModelo','ASC');"> A&ntilde;o Mod. </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinNumeroMotor"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinNumeroMotor','ASC');"> Num. Motor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinNumeroMotor','DESC');"> Num. Motor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinNumeroMotor','ASC');"> Num. Motor </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinColor"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinColor','ASC');"> Color <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinColor','DESC');"> Color <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinColor','ASC');"> Color </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinDUA"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinDUA','ASC');"> DUA <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinDUA','DESC');"> DUA <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinDUA','ASC');"> DUA  </a>
          <?php
				}
				?></th>
        <th width="8%" ><?php
				if($POST_ord == "EinUbicacion"){
					if($POST_sen == "EinUbicacion"){
				?>
          <a href="javascript:FncOrdenar('EinUbicacion','ASC');"> Ubicacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinUbicacion','DESC');"> Ubicacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinUbicacion','ASC');"> Ubicacion </a>
          <?php
				}
				?></th>
        <th width="6%" ><?php
				if($POST_ord == "EinComprobanteCompraNumero"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinComprobanteCompraNumero','ASC');"> Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinComprobanteCompraNumero','DESC');"> Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinComprobanteCompraNumero','ASC');"> Comprob. </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinPlaca"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinPlaca','ASC');"> Placa <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinPlaca','DESC');"> Placa <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinPlaca','ASC');"> Placa </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "EinEstado"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('EinEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('EinEstado','ASC');"> Est. </a>
          <?php
				}
				?></th>
        <th width="2%" >Foto Frontal</th>
        <th width="8%" >
          <?php
				if($POST_ord == "EinTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
          
          <a href="javascript:FncOrdenar('EinTiempoCreacion','ASC');">
           Fecha de Creacion
            <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('EinTiempoCreacion','DESC');">
            
           Fecha de Creacion
            <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
          <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('EinTiempoCreacion','ASC');">
           Fecha de Creacion
            </a>
          
          <?php
				}
				?>			    </th>
        <th width="10%" >Acciones</th>
        </tr>
      </thead>
    
    <tfoot class="EstTablaListadoFoot">
      
      <tr>
        
        <td colspan="24" align="center">
          
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
            <option <?php if($POST_num==$VehiculoIngresosTotal){ echo 'selected="selected"';}?> value="<?php echo $VehiculoIngresosTotal;?>">Todos</option>
            </select>
          
          <?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VehiculoIngresosTotal;
					//}else{
					//	$tregistros = ($VehiculoIngresosTotalSeleccionado);
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

								foreach($ArrVehiculoIngresos as $dat){

								?>
    
    
    
    <tr id="Fila_<?php echo $f;?>">
      <td width="2%" align="center"  ><?php echo $f;?></td>
      <td width="2%" align="center"  >
        
        <input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->EinId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->EinId; ?>" />				</td>
      
      <td align="right" valign="middle" width="2%"   >
	  
      
      <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->EinId;?>">
	  <?php echo $dat->EinId;  ?>
      </a>
      
      </td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->SucNombre;  ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->VprAno;  ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo FncConvertirMes($dat->VprMes);  ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->VprCodigo;  ?></a></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->VtiNombre; ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->EinVIN; ?></td>
      <td align="right" valign="middle" width="5%"   >
	  
	  
<?php
if($PrivilegioVehiculoMarcaEditar or $PrivilegioVehiculoMarcaVer){
?>

<a href="javascript:FncVehiculoMarcaCargarFormulario('<?php echo (($PrivilegioVehiculoMarcaEditar)?'Editar':'Ver');?>','<?php echo $dat->VmaId?>');"  > <?php echo $dat->VmaNombre; ?></a>

<?php
}else{
?>
 <?php echo $dat->VmaNombre; ?>
<?php	
}
?>       

	 
      
      
      </td>
      <td align="right" valign="middle" width="5%"   >
	  
<?php
if($PrivilegioVehiculoModeloEditar or $PrivilegioVehiculoModeloVer){
?>

<a href="javascript:FncVehiculoModeloCargarFormulario('<?php echo (($PrivilegioVehiculoModeloEditar)?'Editar':'Ver');?>','<?php echo $dat->VmoId?>');"  ><?php echo $dat->VmoNombre; ?></a>

<?php
}else{
?>
<?php echo $dat->VmoNombre; ?>
<?php	
}
?>  

</td>
      <td  width="5%" align="right" >
	  
<?php
if($PrivilegioVehiculoVersionEditar or $PrivilegioVehiculoVersionVer){
?>

<a href="javascript:FncVehiculoVersionCargarFormulario('<?php echo (($PrivilegioVehiculoVersionEditar)?'Editar':'Ver');?>','<?php echo $dat->VveId?>');"  ><?php echo $dat->VveNombre; ?></a>

<?php
}else{
?>
<?php echo $dat->VveNombre; ?>
<?php	
}
?>  
</td>
      <td  width="3%" align="right" ><?php echo $dat->EinAnoFabricacion; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinAnoModelo; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinNumeroMotor; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinColor; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinDUA; ?></td>
      <td  width="8%" align="right" ><?php echo $dat->EinUbicacion; ?></td>
      <td  width="6%" align="right" ><?php echo $dat->EinComprobanteCompraNumero; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinPlaca; ?></td>
      <td  width="4%" align="right" ><?php
			switch($dat->EinEstado){
				case 1:
			?>
        <img src="imagenes/activo.gif" alt="[Activo]" title="En actividad" width="20" height="20" />
        <?php
				break;
				
				case 2:
			?>
        <img src="imagenes/inactivo.gif" alt="[Inactivo]" title="Sin actividad" width="20" height="20" />
        <?php
				break;

			}
			?></td>
      <td  width="2%" align="right" ><?php            
if(!empty($dat->EinFotoFrontal)){
	
	$extension = strtolower(pathinfo($dat->EinFotoFrontal, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->EinFotoFrontal, '.'.$extension);  
?>
       
        <a target="_blank" href="subidos/ficha_ingreso_fotos/<?php echo $dat->EinFotoFrontal;?>"  title=""><img  src="imagenes/documento.gif" alt="" border="0"  /></a>
        <?php	
}
?></td>
      <td  width="8%" align="right" ><?php echo ($dat->EinTiempoCreacion);?></td>
      <td  width="10%" align="center" >
        
<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->EinId;?>&TipoTabla=v2&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>
      
  <?php
if($PrivilegioEliminar){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->EinId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioEditar){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->EinId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->EinId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?></td>
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

