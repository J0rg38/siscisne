<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Personal");?>JsPersonalCombo.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteOrdenVentaVehiculoSinEntrega.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<?php

$POST_Sucursal = $_SESSION['SesionSucursal'];
$POST_FechaInicio = "01/".date("m")."/".date("Y");
$POST_FechaFin = date("d/m/Y");
$GET_DiasTranscurridos = "20";

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
// MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1,NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];


$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1,NULL,$POST_Sucursal,NULL,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];
?>


<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE  VEHICULOS SIN FECHA DE ENTREGA</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteOrdenVentaVehiculoSinEntrega.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
<!--    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteOrdenVentaVehiculoSinEntrega.php" target="IfrReporteOrdenVentaVehiculoSinEntrega" method="post" name="FrmReporteOrdenVentaVehiculoSinEntrega" id="FrmReporteOrdenVentaVehiculoSinEntrega">
     --> 
      
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
                <td>Dias Transc.:</td>
                <td><select name="CmpDiasTranscurridos" id="CmpDiasTranscurridos" class="EstFormularioCombo">
                  <option <?php echo (($GET_DiasTranscurridos=="")?'':'');?> value="">Todos</option>
                  <option <?php echo (($GET_DiasTranscurridos=="3")?'selected="selected"':'');?>  value="3">3 dias</option>
                  <option <?php echo (($GET_DiasTranscurridos=="7")?'selected="selected"':'');?>  value="7">7 dias</option>
                  <option <?php echo (($GET_DiasTranscurridos=="15")?'selected="selected"':'');?>  value="15">15 dias</option>
                  <option <?php echo (($GET_DiasTranscurridos=="20")?'selected="selected"':'');?>   value="20">20 dias</option>
                </select></td>
                </tr>
            </table></td>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo $POST_FechaInicio;?>" size="10" maxlength="10"/>
                  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicio" name="BtnFechaInicio" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo $POST_FechaFin;?>" size="10" maxlength="10"/>
                  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" onclick="FncReporteOrdenVentaVehiculoSinEntregaVer();" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteOrdenVentaVehiculoSinEntregaImprimir();" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteOrdenVentaVehiculoSinEntregaGenerarExcel();" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
            </table>          </td>
        </tr>
          </table>
      <!--</form>-->    </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteOrdenVentaVehiculoSinEntrega.php" target="IfrReporteOrdenVentaVehiculoSinEntrega" id="IfrReporteOrdenVentaVehiculoSinEntrega" name="IfrReporteOrdenVentaVehiculoSinEntrega" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
      <div id="CapReporteOrdenVentaVehiculoSinEntrega"></div>
  
  
  
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

