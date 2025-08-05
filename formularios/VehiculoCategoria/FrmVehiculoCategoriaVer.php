<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
	$PrivilegioEditar = true;
}else{
	$PrivilegioEditar = false;
}
?>
<?php

$GET_id = $_GET['Id'];
include($InsProyecto->MtdFormulariosMsj('VehiculoCategoria').'MsjVehiculoCategoria.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCategoria.php');

$InsVehiculoCategoria = new ClsVehiculoCategoria();

include($InsProyecto->MtdFormulariosAcc('VehiculoCategoria').'AccVehiculoCategoriaEditar.php');



//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

	

<script type="text/javascript">
$(document).ready(function (){

	/*
	* Arbol 
	*/	

	tree = new dhtmlXTreeObject("treeboxbox_tree", "100%", "100%", 0);

	tree.setSkin('dhx_skyblue');
	tree.setImagePath("librerias/dhtmlxTree/dhtmlxTree/codebase/imgs/csh_bluebooks/");
	
	
tree.loadXML("comunes/VehiculoCategoria/XmlVehiculoCategoria.php?s=<?php echo $InsVehiculoCategoria->VcaSubId;?>");

 tree.lockTree(true);
	
});
</script>



<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoCategoria->VcaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td height="25" colspan="2"><span class="EstFormularioTitulo">VER
        CATEGORIA DE CATEGORIAS DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
                                       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoCategoria->VcaTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoCategoria->VcaTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div> <br />
        
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
            <td>C&oacute;digo:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsVehiculoCategoria->VcaId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Categoria:</td>
            <td valign="top">      
             <input type="hidden" name="CmpCategoriaId" id="CmpCategoriaId" value="<?php echo $InsVehiculoCategoria->VcaSubId;?>"  /><input name="CmpCategoriaNombre" type="text" class="EstFormularioCaja" id="CmpCategoriaNombre" value="<?php echo $InsVehiculoCategoria->VcaSubNombre;?>" size="40" maxlength="40" readonly="readonly"  />
              
              <div id="treeboxbox_tree"></div>
              
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><input value="<?php echo $InsVehiculoCategoria->VcaNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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


	
	
    



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

