<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoPrecioCalculo.js"></script>


<?php

$GET_ProId = $_GET['ProId'];

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsMoneda = new ClsMoneda();
$InsProducto = new ClsProducto();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ProductoId = "";
$ProductoCodigoOriginal = "";

if(!empty($GET_ProId)){
	
	$InsProducto->ProId = $GET_ProId;
	$InsProducto->MtdObtenerProducto(false);
	
	
	$ProductoId = $InsProducto->ProId;
$ProductoCodigoOriginal = $InsProducto->ProCodigoOriginal;
	
}


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
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />


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
    
    <span class="EstFormularioTitulo">CONSULTA DE PRECIO DE PRODUCTO</span>  </td>
  <td width="2%"><a href="formularios/Reporte/inf/InfProductoPrecioCalculo.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Producto/IfrProductoPrecioCalculo.php" target="IfrProductoPrecioCalculo" method="post" name="FrmProductoPrecioCalculo" id="FrmProductoPrecioCalculo">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de FIltro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td align="left" valign="top">Codigo Original: </td>
                <td align="left" valign="top">
                <a href="javascript:FncProductoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                
                
                </td>
                <td align="left" valign="top"><input  name="CmpProductoId" id="CmpProductoId" type="hidden" size="10" maxlength="10" value="<?php echo $ProductoId;?>"/>
                <span id="sprytextfield1">
                <input class="EstFormularioCaja" name="CmpProductoCodigoOriginal" type="text"  id="CmpProductoCodigoOriginal" value="<?php echo $ProductoCodigoOriginal;?>" size="20" maxlength="20"/>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td align="left" valign="top">Moneda:</td>
                <td align="left" valign="top"><span id="spryselect1">
                  <select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option <?php echo (($DatMoneda->MonId=="MON-10001")?'selected="selected"':'');?>  value="<?php echo $DatMoneda->MonId?>"  > <?php echo $DatMoneda->MonSimbolo;?></option>
                    <?php
			  }
			  ?>
                  </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td align="left" valign="top">Impuesto: <br />
                  <span class="EstFormularioSubEtiqueta">(%)</span></td>
                <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" value="<?php echo number_format($EmpresaImpuestoVenta,2);?>" size="5" maxlength="10" /></td>
                <td align="left" valign="top">Margen de Utilidad: <br />
                  <span class="EstFormularioSubEtiqueta">(%)</span></td>
                <td align="left" valign="top"><span id="sprytextfield6">
                <label for="CmpMargenUtilidad"></label>
                <input name="CmpMargenUtilidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpMargenUtilidad" value="<?php echo number_format($EmpresaRepuestoMargenUtilidad,2);?>" size="5" maxlength="10" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td align="left" valign="top">Otros Costos: <br />
                <span class="EstFormularioSubEtiqueta">  (%)</span></td>
                <td align="left" valign="top"><span id="sprytextfield9">
                <label for="CmpFlete"></label>
                <input name="CmpFlete" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFlete" value="<?php echo number_format($EmpresaRepuestoFlete,2);?>" size="5" maxlength="10" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td align="left" valign="top">Mano de Obra: <br />
                  <span class="EstFormularioSubEtiqueta"> (%)</span></td>
                <td align="left" valign="top"><span id="sprytextfield2">
                <label for="CmpManoObra"></label>
                <input name="CmpManoObra" type="text" class="EstFormularioCajaDeshabilitada" id="CmpManoObra" value="<?php echo number_format($EmpresaMantenimientoPorcentajeManoObra,2);?>" size="5" maxlength="10" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td align="left" valign="top">
                
                </td>
              </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
           </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncProductoPrecioCalculoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncProductoPrecioCalculoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Producto/IfrProductoPrecioCalculo.php" target="IfrProductoPrecioCalculo" id="IfrProductoPrecioCalculo" name="IfrProductoPrecioCalculo" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
