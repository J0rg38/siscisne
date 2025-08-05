<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoConsulta.js"></script>

<?php

$GET_ProCodigoOriginal = $_GET['ProCodigoOriginal'];

$POST_Sucursal = $_SESSION['SesionSucursal'];

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsSucursal = new ClsSucursal();

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
?>

<script type="text/javascript">
/*
//Desactivando tecla ENTER
*/

/*
//Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpProductoCodigoOriginal').focus();

});

/*
Configuracion Formulario
*/

</script>

<div class="EstCapMenu">
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
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">CONSULTA DE PRODUCTO </span>  </td>
  <td width="2%"><a href="formularios/Reporte/inf/InfProductoConsulta.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
  <!--  <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Producto/IfrProductoConsulta.php" target="IfrProductoConsulta" method="post" name="FrmProductoConsulta" id="FrmProductoConsulta">
      -->
        <fieldset  class="EstFormularioContenedor">
          <legend>Opciones de Filtro</legend>
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top">
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
                <td>Codigo Original: </td>
                <td>
                <a href="javascript:FncProductoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                
                
                </td>
                <td>
                
                <input  name="CmpProductoId" type="hidden"  id="CmpProductoId" value="" size="10" maxlength="10"/>
                <span id="sprytextfield1">
                <input class="EstFormularioCaja" name="CmpProductoCodigoOriginal" type="text"  id="CmpProductoCodigoOriginal" value="<?php echo $GET_ProCodigoOriginal;?>" size="20" maxlength="20"/>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
              </tr>
              </table>
           </td>
          <td align="left" valign="top">
           </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" onclick="FncProductoConsultaVer('');" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncProductoConsultaImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncProductoConsultaGenerarExcel('');" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
              </table>          </td>
        </tr>
          </table>
          
          </fieldset>
      <!--</form>  -->  </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <div  class="EstReporteCapaListado autoheight" id="CapProductoConsulta"></div>
  
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Producto/IfrProductoConsulta.php" target="IfrProductoConsulta" id="IfrProductoConsulta" name="IfrProductoConsulta" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
  </td>
</tr>
</table>
</div>


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
