<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" >
</script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoSeguimientoLlamadaFunciones.js"></script>
<?php

//$POST_Sucursal = $_SESSION['SesionSucursal'];
$GET_Sucursal = $_GET['Sucursal'];
$GET_DiasTranscurridos = $_GET['DiasTranscurridos'];
$GET_FechaInicio = (empty($_GET['FechaInicio'])?"01/".date("m")."/".date("Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');


$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsClienteTipo = new ClsClienteTipo();
$InsSucursal = new ClsSucursal();
$InsModalidadIngreso = new ClsModalidadIngreso();


//MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_VehiculoMarca,1);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25">
    
    <span class="EstFormularioTitulo">SEGUIMIENTO  DE ORDENES DE VENTA DE VEHICULO - CALLCENTER</span></td>
  <td width="2%"><a href="formularios/OrdenVentaVehiculo/inf/InfOrdenVentaVehiculoSeguimientoLlamada.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
<!--    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>OrdenVentaVehiculo/IfrOrdenVentaVehiculoSeguimientoLlamada.php" target="IfrOrdenVentaVehiculoSeguimientoLlamada" method="post" name="FrmOrdenVentaVehiculoSeguimientoLlamada" id="FrmOrdenVentaVehiculoSeguimientoLlamada">-->
<!--    <form enctype="multipart/form-data"  target="IfrOrdenVentaVehiculoSeguimientoLlamada" method="post" name="FrmOrdenVentaVehiculoSeguimientoLlamada" id="FrmOrdenVentaVehiculoSeguimientoLlamada">-->
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo $GET_FechaInicio;?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  </td>
                </tr>
              <tr>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo $GET_FechaFin;?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /> </td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">     <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Sucursal:</td>
                <td colspan="3"><select  <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                  <option value="">Escoja una opcion</option>
                  <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                  <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                  <?php
    }
    ?>
                </select></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Marca:</td>
                <td colspan="3"><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
				
				?>
                  <option <?php //echo (($DatVehiculoMarca->VmaId=="VMA-10017")?'selected="selected"':'');?>  value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
                  <?php	
				}
				?>
                </select></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Filtro:</td>
                <td><input name="CmpFiltro" type="text" class="EstFormularioCaja" id="CmpFiltro" size="25" maxlength="45" /></td>
                <td width="125">&nbsp;</td>
                <td width="133">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>CSI:</td>
                <td><select name="CmpIncluirCSI" id="CmpIncluirCSI" class="EstFormularioCombo">
                  <option value="">Todos</option>
                  <option value="1">Incluidos</option>
                  <option value="2" >Excluidos</option>
                </select></td>
                <td>Dias Transc.:</td>
                <td><select name="CmpDiasTranscurridos" id="CmpDiasTranscurridos" class="EstFormularioCombo">
                  <option <?php echo (($GET_DiasTranscurridos=="")?'':'');?> value="">Todos</option>
                  <option <?php echo (($GET_DiasTranscurridos=="3")?'selected="selected"':'');?>  value="3">3 dias</option>
                  <option <?php echo (($GET_DiasTranscurridos=="7")?'selected="selected"':'');?>  value="7">7 dias</option>
                  <option <?php echo (($GET_DiasTranscurridos=="15")?'selected="selected"':'');?>  value="15">15 dias</option>
                   <option <?php echo (($GET_DiasTranscurridos=="20")?'selected="selected"':'');?>   value="20">20 dias</option>
                </select></td>
                <td width="5">&nbsp;</td>
              </tr>
              </table>
          </fieldset></td>
          <td align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                      <option value="OvvId" >Cod. de OV</option>
                      <option value="OvvFecha" >Fecha de OV</option>
                      <option value="OvvFechaEntrega" selected="selected">Fecha de Entrega</option>
                      
                      
                      
                      <option value="CliNombre">Cliente</option>
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
                  <td>
						<select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
							<option value="ASC">Ascendente</option>
							<option value="DESC" selected="selected">Descendente</option>
						</select>                    
					</td>
                  </tr>
                </table>
            </fieldset></td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel"  />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
              </table>          </td>
        </tr>
          </table>
     <!-- </form>  -->  </td>
</tr>
<tr>
  <td colspan="2" align="center">
   <div id="CapOrdenVentaVehiculoSeguimientoLlamada"></div>
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>OrdenVentaVehiculo/IfrOrdenVentaVehiculoSeguimientoLlamada.php" target="IfrOrdenVentaVehiculoSeguimientoLlamada" id="IfrOrdenVentaVehiculoSeguimientoLlamada" name="IfrOrdenVentaVehiculoSeguimientoLlamada" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>--></td>
</tr>
</table>
</div>

<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
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

