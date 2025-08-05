<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteFichaIngresoMantenimientoCuadro.js"></script>

<?php

$POST_Sucursal = $_SESSION['SesionSucursal'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsClienteTipo = new ClsClienteTipo();
$InsSucursal = new ClsSucursal();


//MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_VehiculoMarca,1);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];


 
$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];


?>
<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo"> CUADRO DE ORDENES DE TRABAJO X MODELO X AÑO (MANTENIMIENTO)</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteFichaIngresoMantenimientoCuadro.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
   <!-- <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteFichaIngresoMantenimientoCuadro.php" target="IfrReporteFichaIngresoMantenimientoCuadro" method="post" name="FrmReporteFichaIngresoMantenimientoCuadro" id="FrmReporteFichaIngresoMantenimientoCuadro">
     --> 
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">      
          
            <fieldset class="EstFormularioContenedor">
        <legend>Opciones de Filtrado</legend>
             
<table border="0" cellpadding="2" cellspacing="2">
<tr>
  <td>Sucursal:</td>
  <td><select <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
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
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="left">Marca:</td>
  <td align="left"><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
    <option value="">Escoja una opcion</option>
    <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
    <option <?php echo $DatVehiculoMarca->VmaId;?>  value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
    <?php
			}
			?>
    </select></td>
  <td>Modelo:</td>
  <td>
    <select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
      </select>
    </td>
</tr>
</table>
            </fieldset> 
          
        
        
            
            
            </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td class="EstFormulario">Año:</td>
                <td class="EstFormulario"><select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                  <?php
				for($i=2013;$i<=date("Y");$i++){
				?>
                  <option <?php echo ($i==date("Y")?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                  <?php	
				}
				?>
                  </select></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>    </td>
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
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
            </table>          </td>
        </tr>
        </table>
    <!--  </form>  -->  </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
<!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteFichaIngresoMantenimientoCuadro.php" target="IfrReporteFichaIngresoMantenimientoCuadro" id="IfrReporteFichaIngresoMantenimientoCuadro" name="IfrReporteFichaIngresoMantenimientoCuadro" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
-->
<!--<iframe class="autoHeight"  src="" target="IfrReporteFichaIngresoMantenimientoCuadro" id="IfrReporteFichaIngresoMantenimientoCuadro" name="IfrReporteFichaIngresoMantenimientoCuadro" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->


<div id="CapReporteFichaIngresoMantenimientoCuadro"></div>
</td>


  
</tr>
</table>
</div>

<script type="text/javascript">
//Calendar.setup({ 
//	inputField : "CmpFechaInicio",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaInicio"// el id del botón que  
//	}); 	
//	
//	Calendar.setup({ 
//	inputField : "CmpFechaFin",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaFin"// el id del botón que  
//	});

</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

