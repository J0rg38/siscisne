<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteFichaIngresoConsolidado.js"></script>



<script type="text/javascript">

var VehiculoModeloHabilitado = 1;
	
</script>


<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
$POST_Sucursal = $_SESSION['SesionSucursal'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsSucursal = new ClsSucursal();

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];



$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];

?>


<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE RESUMEN DE ORDENES DE TRABAJO X MODALIDAD X MODELO</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteFichaIngresoConsolidado.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteFichaIngresoConsolidado.php" target="IfrReporteFichaIngresoConsolidado" method="post" name="FrmReporteFichaIngresoConsolidado" id="FrmReporteFichaIngresoConsolidado">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          
          
          
          
          
          <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td>Sucursal:</td>
      <td><select <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
        <option value="">Todos</option>
        <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
        <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
        <?php
    }
    ?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Modalidad:</td>
      <td><select  class="EstFormularioCombo" name="CmpModalidadIngreso" id="CmpModalidadIngreso">
        <option value="" >Todos</option>
        <?php
    foreach($ArrModalidadIngresos as $DatModalidadIngreso){
    ?>
        <option value="<?php echo $DatModalidadIngreso->MinId?>"><?php echo $DatModalidadIngreso->MinSigla;?> - <?php echo $DatModalidadIngreso->MinNombre;?></option>
        <?php	
    }
    ?>
      </select></td>
      <td>Tipo:</td>
      <td><select  class="EstFormularioCombo" name="CmpFichaIngresoTipo" id="CmpFichaIngresoTipo">
        <option value="" >Todos</option>
        <option  <?php if($POST_Tipo==1){ echo 'selected="selected"';}?> value="1">Ord. Trabajo</option>
        <option  <?php if($POST_Tipo==2){ echo 'selected="selected"';}?> value="2">PDS</option>
      </select></td>
    </tr>
    <tr>
      <td>Marca:</td>
      <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                  <option value="">Escoja una opcion</option>
                  <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                  <option <?php echo $DatVehiculoMarca->VmaId;?>  value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                  <?php
			}
			?>
                </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table></fieldset>
            
          
                            </td>
          
          <td align="left" valign="top">
          
          <fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha"  id="CmpFechaInicio" value="<?php  echo $POST_finicio;?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  </td>
              </tr>
              <tr>
                <td>Fecha Fin:</td>
                <td><input name="CmpFechaFin" type="text" class="EstFormularioCajaFecha"  id="CmpFechaFin" value="<?php  echo $POST_ffin;?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /> </td>
                </tr>
              </table>
          </fieldset>   
          
          
           </td>
          <td align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
					
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
<option value="VmaNombre" >Marca</option>					
<option value="VmoNombre"  >Modelo</option>
<option value="RfcTotal" selected="selected" >Total O.T.</option>
		
					</select>                    
                    
                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
                  <td>
                    <select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                      <option value="ASC">Ascendente</option>
                      <option value="DESC"  selected="selected" >Descendente</option>
                      </select>                    </td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"   />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel"   />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
              </table>          </td>
        </tr>
          </table>
      </form>    </td>
</tr>
<tr>
  <td colspan="2" align="center">
  

  <iframe class="EstReporteCapaListado autoheight" target="IfrReporteFichaIngresoConsolidado" id="IfrReporteFichaIngresoConsolidado" name="IfrReporteFichaIngresoConsolidado" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>
  
  
  </td>
</tr>
</table>
</div>

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del botón que  
	}); 	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del botón que  
	});
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

