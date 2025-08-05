<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoCodigoReemplazoFunciones.js" ></script>
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
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCategoria.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();
$InsUnidadMedida = new ClsUnidadMedida();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsProductoCategoria = new ClsProductoCategoria();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProductoEditar.php');


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

<form id="FrmEditar" name="FrmEditar" method="post" target="_blank" action="formularios/Producto/DiaProductoGenerarCodigoBarra.php" enctype="multipart/form-data">

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


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">GENERAR CODIGO DE BARRAS DE PRODUCTO</span></td>
      </tr>
      <tr>
        <td>
        
        
                              
        
      

		
		
		
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
            <td colspan="5">
              <span class="EstFormularioSubTitulo">
                Datos del Producto			</span>			<input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProducto->ProId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Original:</td>
            <td align="left" valign="top"><input  name="CmpCodigoOriginal" type="text"  class="EstFormularioCaja" id="CmpCodigoOriginal" value="<?php echo $InsProducto->ProCodigoOriginal;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Codigo Alternativo:</td>
            <td align="left" valign="top"><input  name="CmpCodigoAlternativo" type="text"  class="EstFormularioCaja" id="CmpCodigoAlternativo" value="<?php echo $InsProducto->ProCodigoAlternativo;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProducto->ProNombre;?>" size="40" maxlength="200" readonly="readonly"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo de Barras:</td>
            <td align="left" valign="top"><input  name="CmpCodigoBarra" type="text"  class="EstFormularioCaja" id="CmpCodigoBarra" value="<?php echo $InsProducto->ProCodigoBarra;?>" size="30" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la etiqueta </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5" align="center" class="EstFormularioTabla">
              
              <table>
                <tr>
                  <td colspan="3" align="center">Arriba</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="center"><input name="CmpArriba"  type="text" class="EstFormularioCaja" id="CmpArriba" value="C &amp; C S.A.C." size="10" maxlength="10" /></td>
                  <td align="center">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top">Izquierda</td>
                  <td rowspan="2" align="center" valign="top">
                    
                    <img src="imagenes/iconos/codigo_barra.png" width="105" height="59" />                    </td>
                  <td align="center" valign="top">Derecha</td>
                  <td align="center">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top"><input name="CmpIzquierda" type="text" class="EstFormularioCaja" id="CmpIzquierda" value="<?php echo date("Y");?>" size="5" maxlength="10" /></td>
                  <td align="center" valign="top"><input name="CmpDerecha"  type="text" class="EstFormularioCaja" id="CmpDerecha" value="<?php echo $InsProducto->ProId;?>" size="5" maxlength="10" /></td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="center"><?php echo $InsProducto->ProCodigoOriginal;?></td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                </table>
              
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cantidad:</td>
            <td align="left" valign="top"><input name="CmpCantidad" type="text" class="EstFormularioCaja" id="CmpCantidad" value="1" size="10" maxlength="10" /></td>
            <td align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5" align="center" valign="top">
            
            
            
            
            <input class="EstFormularioBoton" type="button" name="BtnGenerar" id="BtnGenerar" value="Generar" />
            
            <input class="EstFormularioBoton" type="button" name="BtnImprimir" id="BtnImprimir" value="Imprimir" onclick="FncProductoCodigoBarraImprimir();" />
            
            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
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

