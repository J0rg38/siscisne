<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php


include($InsProyecto->MtdFormulariosMsj('VehiculoCategoria').'MsjVehiculoCategoria.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCategoria.php');

$InsVehiculoCategoria = new ClsVehiculoCategoria();

include($InsProyecto->MtdFormulariosAcc('VehiculoCategoria').'AccVehiculoCategoriaRegistrar.php');

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript">
$(document).ready(function (){

	/*
	* Arbol 
	*/	
	function tonclick(id) {
    	document.getElementById('CmpCategoriaId').value=id;
    	document.getElementById('CmpCategoriaNombre').value=tree.getItemText(id);
	};

	tree = new dhtmlXTreeObject("treeboxbox_tree", "100%", "100%", 0);
	tree.setOnClickHandler(tonclick);

	tree.setSkin('dhx_skyblue');
	tree.setImagePath("librerias/dhtmlxTree/dhtmlxTree/codebase/imgs/csh_bluebooks/");

	
tree.loadXML("comunes/VehiculoCategoria/XmlVehiculoCategoria.php?s=<?php echo $InsVehiculoCategoria->VcaSubId;?>");
	
});
</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">


<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        CATEGORIA DE CATEGORIAS DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        <div class="EstFormularioArea">

        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Categoria:</td>
            <td valign="top">
              
              <input type="hidden" name="CmpCategoriaId" id="CmpCategoriaId" value="<?php echo $InsVehiculoCategoria->VcaSubId;?>"  />
              
              
              
              <input name="CmpCategoriaNombre" type="text" class="EstFormularioCaja" id="CmpCategoriaNombre" value="<?php echo $InsVehiculoCategoria->VcaSubNombre;?>" size="40" maxlength="40" readonly="readonly"  />
              
  <div id="treeboxbox_tree"></div>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td>
            <span id="sprytextfield1">
              <label>
              <input class="EstFormularioCaja"   name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsVehiculoCategoria->VcaNombre;?>" size="40" maxlength="250" />
              </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span>            </td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>
        </td>
      </tr>
      <tr>
        <td width="150">&nbsp;</td>
        <td width="811">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
    
    
</div>



	
	
	
    

</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

