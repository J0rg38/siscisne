<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsMarketingDashboardFunciones.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<?php

$POST_finicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");
$POST_Sucursal = $_SESSION['SesionSucursal'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsSucursal = new ClsSucursal();

// MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1,NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
?>


<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">DASHBOARD MARKETING </span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfMarketingDashboard.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
     <form   action="<?php echo $InsProyecto->MtdRutFormularios();?>Marketing/IfrMarketingDashboard.php" target="IfrMarketingDashboard" method="GET" name="FrmMarketingDashboard" id="FrmMarketingDashboard">
     
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"><legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
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
                <td>Marca:</td>
                <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
								?>
                  <option <?php echo (($DatVehiculoMarca->VmaId=="VMA-10017")?'selected="selected"':'');?>  value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
                  <?php	
				}
				?>
                  </select></td>
              </tr>
            </table></td>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo $POST_finicio;?>" size="8" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver"  />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" />           
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
       </form>    </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrMarketingDashboard.php" target="IfrMarketingDashboard" id="IfrMarketingDashboard" name="IfrMarketingDashboard" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
     <!-- <div id="CapMarketingDashboard"></div>
    -->
  <iframe class="EstReporteCapaListado autoheight" target="IfrMarketingDashboard" id="IfrMarketingDashboard" name="IfrMarketingDashboard" scrolling="auto"  frameborder="0" width="100%"></iframe>
  
  
  
  </td>
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

