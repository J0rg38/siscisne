<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoCodigoReemplazoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoFotoSoloFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProducto.css');
</style>

<?php
$Registro = false;

$GET_ProductoCodigo = $_GET['ProductoCodigo'];
$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
$GET_ProductoNombre = $_GET['ProductoNombre'];
$GET_ProductoUnidadMedida = $_GET['ProductoUnidadMedida'];
$GET_ProductoCodigoAlternativo = $_GET['ProductoCodigoAlternativo'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCategoria.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPromocion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();
$InsUnidadMedida = new ClsUnidadMedida();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsProductoCategoria = new ClsProductoCategoria();
$InsClienteTipo = new ClsClienteTipo();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsVehiculoMarca = new ClsVehiculoMarca();

if (!isset($_SESSION['InsProductoCodigoReemplazo'.$Identificador])){	
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsProductoCodigoReemplazo'.$Identificador]);
}

if (!isset($_SESSION['InsProductoFoto'.$Identificador])){	
	$_SESSION['InsProductoFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsProductoFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsProductoFoto'.$Identificador]);
}

$ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,NULL,NULL);
$ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProductoRegistrar.php');

//DATOS
$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];


$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaOrden","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

//MtdObtenerProductoCategorias($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) 
$RepProductoCategoria = $InsProductoCategoria->MtdObtenerProductoCategorias(NULL,NULL,"PcaNombre","ASC",NULL,NULL);
$ArrProductoCategorias = $RepProductoCategoria['Datos'];

//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,2);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,NULL,NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
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

	FncEstablecerProductoUso();
	//FncEstablecerProductoTipoUnidadMedidaIngreso();
	FncEstablecerProductoTipoUnidadMedidaBase();
	//FncEstablecerProductoTipoUnidadMedidaSalida();
	
/*
AGREGANDO EVENTOS
*/

	$("select#CmpTipo").change(function(){

		FncEstablecerProductoTipoUnidadMedidaBase();

	})

	FncProductoCodigoReemplazoListar();
		
	FncProductoFotoSoloListar();
	
	FncProductoFotoListar("F");
	
	FncProductoFotoListar("E");
	
});

var ProductoTipoUnidadMedidaIngresoHabilitado = 1;
var ProductoTipoUnidadMedidaBaseHabilitado = 1;

var ProductoCodigoReemplazoEditar = 1;
var ProductoCodigoReemplazoEliminar = 1;

var ProductoFotoEditar = 1;
var ProductoFotoEliminar = 1;

var ProductoFotoSoloEditar = 1;
var ProductoFotoSoloEliminar = 1;

</script>






<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">

	
    
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
        <td width="961" height="25"><span class="EstFormularioTitulo">REGISTRAR PRODUCTO</span></td>
      </tr>
      <tr>
        <td>
		
        
        
	
    
<ul class="tabs">
    <li><a href="#tab1">Producto</a></li>
    
	<li><a href="#tab4">Unidades de Medida</a></li>
    <li><a href="#tab5">Uso</a></li>
    
	<li><a href="#tab2">Fotos</a></li>
	<li><a href="#tab3">Costos y Precios</a></li>
	<li><a href="#tab7">Cod. Reemplazos</a></li>
</ul>

<div class="tab_container">


    <div id="tab1" class="tab_content">
        <!--Content-->

		
		 
		
     
        
	   
       
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
           <div class="EstFormularioArea" >
         
         
          
 

              
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
			<span class="EstFormularioSubTitulo">
			Datos del Producto			</span>			
            <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProducto->ProId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Marca:</td>
            <td align="left" valign="top"><input name="CmpMarca" type="text" class="EstFormularioCaja" id="CmpMarca" value="<?php echo $InsProducto->ProMarca;?>" size="40" maxlength="100"  /></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Original:</td>
            <td align="left" valign="top"><input value="<?php echo $InsProducto->ProCodigoOriginal;?>"  class="EstFormularioCaja"  name="CmpCodigoOriginal" type="text" id="CmpCodigoOriginal" size="30" maxlength="45" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Codigo Alternativo:</td>
            <td align="left" valign="top"><input value="<?php echo $InsProducto->ProCodigoAlternativo;?>"  class="EstFormularioCaja"  name="CmpCodigoAlternativo" type="text" id="CmpCodigoAlternativo" size="30" maxlength="45" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProducto->ProNombre;?>" size="40" maxlength="200"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo de Barras:</td>
            <td align="left" valign="top"><input value="<?php echo $InsProducto->ProCodigoBarra;?>"  class="EstFormularioCaja"  name="CmpCodigoBarra" type="text" id="CmpCodigoBarra" size="30" maxlength="50" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Procedencia:</td>
            <td align="left" valign="top"><input name="CmpProcedencia" type="text" class="EstFormularioCaja" id="CmpProcedencia" value="<?php echo $InsProducto->ProProcedencia;?>" size="20" maxlength="100"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Nivel Rotacion:</td>
            <td align="left" valign="top"><input name="CmpRotacion" type="text" class="EstFormularioCaja" id="CmpRotacion" value="<?php echo $InsProducto->ProRotacion;?>" size="10" maxlength="100"  /></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Ubicacion:</td>
            <td align="left" valign="top"><input name="CmpUbicacion" type="text" class="EstFormularioCaja" id="CmpUbicacion" value="<?php echo $InsProducto->ProUbicacion;?>" size="40" maxlength="100"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Referencia:</td>
            <td align="left" valign="top"><textarea name="CmpReferencia" cols="40" class="EstFormularioCaja" id="CmpReferencia"><?php echo $InsProducto->ProReferencia;?></textarea></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Peso:</td>
            <td align="left" valign="top"><input name="CmpPeso" type="text" class="EstFormularioCaja" id="CmpPeso" value="<?php echo $InsProducto->ProPeso;?>" size="30" maxlength="16"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Dimensiones (Largo x Ancho x Alto)</td>
            <td align="left" valign="top"><input name="CmpLargo" type="text" class="EstFormularioCaja" id="CmpLargo" value="<?php echo $InsProducto->ProLargo;?>" size="5" maxlength="10"  />
              x
              <input name="CmpAncho" type="text" class="EstFormularioCaja" id="CmpAncho" value="<?php echo $InsProducto->ProAncho;?>" size="5" maxlength="10"  />
              x
              <input name="CmpAlto" type="text" class="EstFormularioCaja" id="CmpAlto" value="<?php echo $InsProducto->ProAlto;?>" size="5" maxlength="10"  /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo de Bien:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrProductoTipos as $DatProductoTipo){
			?>
              <option <?php echo $DatProductoTipo->RtiId;?> <?php echo ($DatProductoTipo->RtiId==$InsProducto->RtiId)?'selected="selected"':"";?> value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Categoria:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpProductoCategoria" id="CmpProductoCategoria">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrProductoCategorias as $DatProductoCategoria){
			?>
              <option <?php echo $DatProductoCategoria->PcaId;?> <?php echo ($DatProductoCategoria->PcaId==$InsProducto->PcaId)?'selected="selected"':"";?> value="<?php echo $DatProductoCategoria->PcaId?>"><?php echo $DatProductoCategoria->PcaNombre?></option>
              <?php
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Stock Minimo:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpStockMinimo" type="text" id="CmpStockMinimo" value="<?php if(empty($InsProducto->ProStockMinimo)){ echo "0.00";}else{ echo $InsProducto->ProStockMinimo; }?>" size="15" maxlength="10" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Validar Stock:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProValidarStock){
				case 1:
					$OpcValidarStock1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcValidarStock2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpValidarStock" id="CmpValidarStock">
                <option <?php echo $OpcValidarStock1;?> value="1">Si</option>
                <option <?php echo $OpcValidarStock2;?> value="2">No</option>
              </select></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Critico:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProCritico){
				case "1":
					$critico1 = 'checked="checked"';
				break;
				
				case "2":
					$critico2 = 'checked="checked"';
				break;
				
				default:
				
				break;
				
			}
			?>
              <input type="radio" name="CmpCritico" id="CmpCritico1" <?php echo $critico1;?>  value="1" />
              Si
  <input type="radio" name="CmpCritico" id="CmpCritico2" <?php echo $critico2;?> value="2" />
              No </td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Descontinuado:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProDescontinuado){
				case "1":
					$descontinuado1 = 'checked="checked"';
				break;
				
				case "2":
					$descontinuado2 = 'checked="checked"';
				break;
				
				default:
				
				break;
				
			}
			?>
              <input type="radio" name="CmpDescontinuado" id="CmpDescontinuado1" <?php echo $descontinuado1;?> value="1"  />
              Si
  <input type="radio" name="CmpDescontinuado" id="CmpDescontinuado2" <?php echo $descontinuado2;?> value="2"/>
              No </td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Notas:</td>
            <td align="left" valign="top"><textarea name="CmpNota" cols="40" class="EstFormularioCaja" id="CmpNota"><?php echo $InsProducto->ProNota;?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Marca Ref.:</td>
            <td align="left" valign="top"><input type="hidden"  name="CmpVehiculoMarca" id="CmpVehiculoMarca" value="<?php echo $InsProducto->VmaId;?>" />
              <!-- <select  class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
              <option value="">Escoja una opcion</option>
              <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
				
				?>
              <option <?php echo (($InsProducto->VmaId==$DatVehiculoMarca->VmaId)?'selected="selected"':'');?>  value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
              <?php	
				}
				?>
            </select>-->
              <select  class="EstFormularioCombo" name="CmpMarcaReferencia" id="CmpMarcaReferencia">
                <option value="">Escoja una opcion</option>
                <option <?php echo (($InsProducto->ProMarcaReferencia=="CHEVROLET")?'selected="selected"':'');?>  value="CHEVROLET">CHEVROLET</option>
                <option <?php echo (($InsProducto->ProMarcaReferencia=="ISUZU")?'selected="selected"':'');?>  value="ISUZU">ISUZU</option>
                <option <?php echo (($InsProducto->ProMarcaReferencia=="SERVICIOS")?'selected="selected"':'');?>  value="SERVICIOS">SERVICIOS</option>
                <option <?php echo (($InsProducto->ProMarcaReferencia=="OTROS")?'selected="selected"':'');?>  value="OTROS">OTROS</option>
              </select></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          </table>
		
        
        </div>
        
        
           </td>
         </tr>
		 
		 
		 
		 </table> 
		 

         
		
        
        
        
        </div>
        
        
        
	<div id="tab4" class="tab_content">
        <!--Content-->
		<table border="0" cellpadding="2" cellspacing="2">
            <tr>
                <td colspan="2" valign="top">
                    <div class="EstFormularioArea" >

			<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
			<tr>
			  <td>&nbsp;</td>
			  <td colspan="3">
			    
			    <span class="EstFormularioSubTitulo">
			      Unidades de Medida
			      </span>			
			    
			    
			    <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">Base (Kardex)</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">Ingreso</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">Salida</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
			    
  <input type="hidden" name="CmpUnidadMedidaBaseAux" id="CmpUnidadMedidaBaseAux" value="<?php echo $InsProducto->UmeId;?>"	     />
			    <fieldset>
			   
			        <div id="CapProductoTipoUnidadMedidaBase"></div>
			       
			      
			      </fieldset>
			    
			    </td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			    
			    <input type="hidden" name="CmpUnidadMedidaIngresoAux" id="CmpUnidadMedidaIngresoAux" value="<?php echo $InsProducto->UmeIdIngreso;?>"	     />
			    
			    <fieldset>	    
			     
			        
			        <div id="CapProductoTipoUnidadMedidaIngreso"></div>
			        
			      
			      </fieldset>   
			    </td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			    <fieldset>	    
			      
			      
			      <div id="CapProductoTipoUnidadMedidaSalida"></div>
			      
			      
			      
			      </fieldset>         
			    
			    
			    </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
              </table>

                    </div>
                </td>
            </tr>
		</table> 
	</div>
	
    
    
    <div id="tab5" class="tab_content">
        <!--Content-->

<table border="0" cellpadding="2" cellspacing="2">
            <tr>
                <td colspan="2" valign="top">
                    <div class="EstFormularioArea" >

			<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
			<tr>
                <td>&nbsp;</td>
                <td>
                  
                  <span class="EstFormularioSubTitulo">
                    Uso</span>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td colspan="3" align="left" valign="top" bgcolor="#CCCCCC"><input type="checkbox" name="CmpValidarUso" id="CmpValidarUso" value="2" <?php echo (($InsProducto->ProValidarUso==2)?'checked="checked"':'');?>>
Este producto puede ser utilizado por cualquier modelo y a&ntilde;o. </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="center" valign="top" bgcolor="#CCCCCC">
			  <div class="CapVehiculoUso">  
			  Marcas y Modelos
			  </div>
			  </td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top" bgcolor="#CCCCCC">
			  <div class="CapVehiculoUso">  
			  Años
			  </div>
			  </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
			  <div class="CapVehiculoUso">  
			  <input type="checkbox" name="CmpVehiculoVersionMarcarTodo" id="CmpVehiculoVersionMarcarTodo" value="1" onclick="FncVehiculoVersionMarcarTodo();" />
Marcar Todos los Modelos
</div>
</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			  <div class="CapVehiculoUso">  
			  <input type="checkbox" name="CmpVehiculoAnoMarcarTodo" id="CmpVehiculoAnoMarcarTodo" value="1" onclick="FncVehiculoAnoMarcarTodo();" />
Marcar Todos los Años
</div>
</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
			    
			    
			    
			    <div class="CapVehiculoUso">  
			      <table border="0" cellpadding="0" cellspacing="0">
			        <tr>
			          
			          <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>
			          
			          <td align="left" valign="top">
			            <?php echo $DatVehiculoMarca->VmaNombre;?>                        </td>
			          <td align="left" valign="top">&nbsp;</td>
			          <?php
                    }
                    ?>
			          </tr>
			        
			        <tr>
			          
			          <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>       
			          <td align="left" valign="top">
			            
			            
			            <?php
                            $RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoOrden","ASC",NULL,$DatVehiculoMarca->VmaId);
                            $ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
                            ?>
			            
			            
			            
			            <?php
                            $i = 1;
                            foreach($ArrVehiculoModelos as $DatVehiculoModelo){
                            ?>
			            
			            
			            <input type="checkbox" name="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" id="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" value="<?php echo $DatVehiculoModelo->VmoId?>" onclick="FncSeleccionarVehiculoVersiones('<?php echo $DatVehiculoModelo->VmoId;?>');" /> <?php echo $DatVehiculoModelo->VmoNombre?> 
			            
			            <?php
								if(!empty($DatVehiculoModelo->VmoNombreComercial)){
								?>
			            (<small><?php echo $DatVehiculoModelo->VmoNombreComercial;?></small>)
			            <?php	
								}
								?>
			            
			            <br />
			            
			            
  <?php
$ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,NULL,$DatVehiculoModelo->VmoId);
$ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];
?>
			            
			            
  <?php
foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
?>
			            
			            
			            <?php
			  	if(is_array($InsProducto->ProductoVehiculoVersion)){	
					foreach($InsProducto->ProductoVehiculoVersion as $DatProductoVehiculoVersion ){
						$aux = '';
						if($DatProductoVehiculoVersion->VveId==$DatVehiculoVersion->VveId){
							$aux = 'checked="checked"';						
							break;
						}					
					}
				}				
				?>
			            
			            
			            
  &nbsp;&nbsp;&nbsp;::: <input  <?php echo $aux;?> type="checkbox" name="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" id="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" value="<?php echo $DatVehiculoVersion->VveId?>" tipo = "vve"modelo = "<?php echo $DatVehiculoVersion->VmoId?>" /> <?php echo $DatVehiculoVersion->VveNombre?>
  <br />
  <?php	
}
?>
			            <br />
			            <?php
                            $i++;
                            }
                            ?>                    </td>
			          <td align="left" valign="top">&nbsp;</td>
			          <?php
                    }
                    ?>
			          </tr>
			        </table>           
			      
			      
			      </div>
			    
			    </td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			    
			    
  <div class="CapVehiculoUso">  
    
    
    <?php
			for($i=date("Y")-25;$i<=(date("Y"));$i++){
			?>
    
    
    <?php
			  	if(is_array($InsProducto->ProductoAno)){	
					foreach($InsProducto->ProductoAno as $DatProductoAno ){
						$aux = '';
						if($DatProductoAno->PanAno==$i){
							$aux = 'checked="checked"';						
							break;
						}					
					}
				}				
				?>
    
    <input tipo="ano" <?php echo $aux;?> type="checkbox" name="CmpAno_<?php echo $i;?>" id="CmpAno_<?php echo $i;?>" value="<?php echo $i;?>" /> <?php echo $i;?>
    <br />
    
    
    
    <?php
			}			  
			?>              
    
    </div>
			    
			    
			    </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table>

                    </div>
                </td>
            </tr>
		</table> 

	</div>    
    
    
	   
<div id="tab2" class="tab_content">    
	   			<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="98%"><span class="EstFormularioSubTitulo">Foto de Referencia del Producto</span></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>
               <div class="EstFormularioArea" > 
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncProductoFotoSoloListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProductoFotoSoloEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapProductoFotoSolosAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadProductoFotoSolo">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadProductoFotoSolo").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/Producto/acc/AccProductoSubirFotoSolo.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncProductoFotoSoloListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapProductoFotoSolos" id="CapProductoFotoSolos"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapProductoFotoSolosResultado"> </div></td>
             </tr>
             </table>
             </div>
             
             </td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
                 <td>&nbsp;</td>
                 <td>Fotos Adicionales</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td><div class="EstFormularioArea" > 
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncProductoFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProductoFotoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapProductoFotosAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                     <tr>
                       <td width="275" colspan="2" align="left" valign="top">
                         <div id="fileuploaderF">Escoger Archivos</div>
                         
                         
                         
                         <script type="text/javascript">
                                $(document).ready(function(){
                        
                                    $("#fileuploaderF").uploadFile({
                                            
                                        allowedTypes:"png,gif,jpg,jpeg,pdf",
                                        url:"formularios/Producto/acc/AccProductoSubirFoto.php",
                                        formData: {"Identificador":"<?php echo $Identificador;?>","Tipo":"F"},
                                        multiple:true,
                                        autoSubmit:true,
                                        fileName:"Filedata",
                                        showStatusAfterSuccess:false,
                                        dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
                                        abortStr:"Abortar",
                                        cancelStr:"Cancelar",
                                        doneStr:"Hecho",
                                        multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
                                        extErrorStr:"Extension de archivo no permitido",
                                        sizeErrorStr:"Tamaño no permitido",
                                        uploadErrorStr:"No se pudo subir el archivo",
                                        
                                        dragdropWidth: 500,
                                        
                                        onSuccess:function(files,data,xhr){
                                            FncProductoFotoListar("F");
                                        }
                            
                            });
                        });
                        </script>
                         
                         
                         
                         
                         </td>
                       <td width="4" align="left" valign="top">&nbsp;</td>
                     </tr>
                     <tr>
                       <td colspan="2" align="left" valign="top"><div class="EstCapProductoFotos" id="CapProductoFotos"></div></td>
                       <td align="left" valign="top">&nbsp;</td>
                     </tr>
                     </table></td>
               <td><div id="CapProductoFotosResultado"> </div></td>
             </tr>
             </table>   
                 </div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               </table>
             
        
	
    
		</div>
	
        
    </td>
    </tr>
    </table>	
	   
	       </div>   
		   
  <div id="tab3" class="tab_content">    
	   			<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">Costos</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Costo (Ingreso):</td>
               <td align="left" valign="top"><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?>
                 <input name="CmpCostoIngreso" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCostoIngreso" value="<?php if(empty($InsProducto->ProCostoIngreso)){ echo "0.00";}else{ echo $InsProducto->ProCostoIngreso; }?>" size="15" maxlength="10" readonly="readonly" />
               </span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Costo (Base):</td>
               <td align="left" valign="top"><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?>
                 <input name="CmpCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCosto" value="<?php if(empty($InsProducto->ProCosto)){ echo "0.00";}else{ echo $InsProducto->ProCosto; }?>" size="15" maxlength="10" readonly="readonly" />
               </span></td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">Precios</span></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Tipo de Cliente:</td>
                 <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                   <option <?php echo $DatClienteTipo->LtiId;?> <?php echo ($DatClienteTipo->LtiId==$InsProducto->LtiId)?'selected="selected"':"";?> value="<?php echo $DatClienteTipo->LtiId?>"><?php echo $DatClienteTipo->VmaNombre;?> - <?php echo $DatClienteTipo->LtiNombre?></option>
                   <?php
			}
			?>
                 </select></td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">Calculo Automatico:</td>
                 <td align="left" valign="top"><?php
			switch($InsProducto->ProCalcularPrecio){
				case 1:
					$OpCalcularPrecio1 = 'checked="checked"';
				break;
				
				case 2:
					$OpcCalcularPrecio2 = 'checked="checked"';
				break;

			}
			?>
                   <input  type="radio" <?php echo $OpCalcularPrecio1;?> name="CmpCalcularPrecio" id="CmpCalcularPrecio1" value="1" />
                   Si
                   <input type="radio" <?php echo $OpcCalcularPrecio2;?> name="CmpCalcularPrecio" id="CmpCalcularPrecio2" value="2" />
                   No </td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Margen Adicional:<br />
                   <span class="EstFormularioSubEtiqueta">(%)</span></td>
                 <td align="left" valign="top"><span class="EstMonedaSimbolo">
                   <input name="CmpPorcentajeAdicional" type="text" class="EstFormularioCaja" id="CmpPorcentajeAdicional" value="<?php if(empty($InsProducto->ProPorcentajeAdicional)){ echo "0.00";}else{ echo $InsProducto->ProPorcentajeAdicional; }?>" size="15" maxlength="10" />
                 </span></td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">Descuento Adicional:<br />
                   <span class="EstFormularioSubEtiqueta">(%)</span></td>
                 <td align="left" valign="top">Descuento Adicional:<br />
                   (%)</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Precio Promocion: </td>
                 <td align="left" valign="top"><?php
			switch($InsProducto->ProTienePromocion){
				case 1:
					$OpcTienePromocion1 = 'checked="checked"';
				break;
				
				case 2:
					$OpcTienePromocion2 = 'checked="checked"';
				break;

			}
			?>
                   <input  type="radio" <?php echo $OpcTienePromocion1;?> name="CmpTienePromocion" id="CmpTienePromocion1" value="1" />
                   Si
                   <input type="radio" <?php echo $OpcTienePromocion2;?> name="CmpTienePromocion" id="CmpTienePromocion2" value="2" />
                   No </td>
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
           
           
           
  <div id="tab7" class="tab_content">    
	   			<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="98%"><span class="EstFormularioSubTitulo">Codigos de Reemplazo</span></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div class="EstFormularioArea">
                 <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="4"><span class="EstFormularioSubTitulo">CODIGOS</span><span cmpgarantiaoperacionid="EstFormularioSubTitulo">
                       <input type="hidden" name="CmpProductoCodigoReemplazoItem" id="CmpProductoCodigoReemplazoItem" value="" />
                       <input type="hidden" name="CmpProductoCodigoReemplazoId"  class="EstFormularioCaja" id="CmpProductoCodigoReemplazoId" value=""  />
                     </span></td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td><span class="EstFormularioAccion">
                       <input type="hidden" name="CmpProductoCodigoReemplazoAccion" id="CmpProductoCodigoReemplazoAccion" value="AccProductoCodigoReemplazoRegistrar.php" />
                     </span></td>
                     <td>Numero:</td>
                     <td><div id="CapProductoCodigoReemplazoBuscar"></div></td>
                     <td>&nbsp;</td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td><a href="javascript:FncProductoCodigoReemplazoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td><input name="CmpProductoCodigoReemplazoNumero" type="text" class="EstFormularioCaja" id="CmpProductoCodigoReemplazoNumero" size="20" maxlength="20" /></td>
                     <td><a href="javascript:FncProductoCodigoReemplazoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                     <td>&nbsp;</td>
                   </tr>
                 </table>
               </div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div class="EstFormularioArea" >
                 <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="38%"><div class="EstFormularioAccion" id="CapProductoCodigoReemplazoAccion">Listo
                       para registrar elementos </div></td>
                     <td width="60%" align="right"><a href="javascript:FncProductoCodigoReemplazoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProductoCodigoReemplazoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                     <td width="1%"><div id="CapProductoCodigoReemplazosResultado"> </div></td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><div id="CapProductoCodigoReemplazos" class="EstCapProductoCodigoReemplazos" ></div></td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2">&nbsp;</td>
                     <td>&nbsp;</td>
                     </tr>
                   </table>
                 </div></td>
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
        <td align="center">&nbsp;</td>
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
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

