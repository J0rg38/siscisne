<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoEditarCodigoOriginalFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProducto.css');
</style>

<?php

$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCategoria.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

$InsProducto = new ClsProducto();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProductoEditarCodigoOriginal.php');

?>







<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
$(document).ready(function (){
	
/*
CARGAS INICIALES
*/	


/*
AGREGANDO EVENTOS
*/


	
	
});


</script>





<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">



<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        <td width="961" height="25"><span class="EstFormularioTitulo">EDITAR CODIGO ORIGINAL DE PRODUCTO</span></td>
      </tr>
      <tr>
        <td>
        
        
                              
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div>
        
          <br />
        

		
		
		
<ul class="tabs">
    <li><a href="#tab1">Producto</a></li>

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

	   
     
       
       <table border="0" cellpadding="2" cellspacing="2">
       <tr>
         <td valign="top">
         
          <div class="EstFormularioArea" >
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Datos del Producto			</span>			<input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProducto->ProId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Original Anterior:</td>
            <td align="left" valign="top"><input  name="CmpCodigoOriginalAnterior" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpCodigoOriginalAnterior" value="<?php echo $InsProducto->ProCodigoOriginalAnterior;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Original Nuevo:</td>
            <td align="left" valign="top"><input  name="CmpCodigoOriginal" type="text"  class="EstFormularioCaja" id="CmpCodigoOriginal" value="<?php echo $InsProducto->ProCodigoOriginal;?>" size="30" maxlength="45"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table>
		</div>
        
         </td>
       </tr>
	   
	   </table>
	   
	   
	   
	   
	
       
         
		

           </div>
	

           
           
           

        
</div>      
               
        
        
        
        
        
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center"></td>
      </tr>
    </table>
    
    
</div>


	
	
	
    

</form>

<script type="text/javascript">

</script>
<?php
}else{
	echo ERR_GEN_101;
}

if(empty($GET_dia)){
	
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

