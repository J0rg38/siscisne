<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoListaPrecioDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoListaPrecio.css');
</style>

<?php
$Registro = false;
//VARIABLES
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoListaPrecio.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecioDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


//INSTANCIAS
$InsVehiculoListaPrecio = new ClsVehiculoListaPrecio();
$InsVehiculMarca = new ClsVehiculoMarca();

$InsMoneda = new ClsMoneda();

if (!isset($_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador])){	
	$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]);
}


//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoListaPrecioRegistrar.php');
//DATOS

$RepVehiculoMarca = $InsVehiculMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
//ALERTAS
?>

<script type="text/javascript" >
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
var VehiculoMarcaHabilitado = 1;
var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;

var VehiculoListaPrecioDetalleEditar = 1;
var VehiculoListaPrecioDetalleEliminar = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;

$().ready(function() {
	
	$("#CmpCodigo").focus();
	
	FncVehiculoListaPrecioDetalleListar();
	
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
        <td width="961" height="25"><span class="EstFormularioTitulo">REGISTRAR LISTA DE PRECIO DE VEHICULO</span></td>
      </tr>
      <tr>
        <td>
		
        
        
	
    
<ul class="tabs">
    <li><a href="#tab1">Lista de Precio</a></li>

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
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">
              <span class="EstFormularioSubTitulo">
                Datos de la Lista de Precio	del	Vehiculo	</span>			
              
                 
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoListaPrecio->VlpId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Lista Dealer No.:</td>
            <td align="left" valign="top"><label for="CmpCodigo"></label>
              <input class="EstFormularioCaja" name="CmpCodigo" type="text" id="CmpCodigo" value="<?php echo $InsVehiculoListaPrecio->VlpCodigo;?>" size="20" maxlength="45" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Fecha Registro:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield2">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo $InsVehiculoListaPrecio->VlpFecha;?>" size="15" maxlength="10" />
              </label>
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
              
              <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
              </td>
            <td align="left" valign="top">Fecha (Vigencia):<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield7">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFechaVigencia" type="text" id="CmpFechaVigencia" value="<?php echo $InsVehiculoListaPrecio->VlpFechaVigencia;?>" size="15" maxlength="10" />
              </label>
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaVigencia" name="BtnFechaVigencia" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><span id="spryselect2">
                  <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoListaPrecio->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                    </select>
                  <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                <td><div id="CapMonedaBuscar"></div></td>
                </tr>
            </table></td>
            <td align="left" valign="top">Tipo de Cambio:<br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVehiculoListaPrecioDetalleListar();" value="<?php if (empty($InsVehiculoListaPrecio->VlpTipoCambio)){ echo "";}else{ echo $InsVehiculoListaPrecio->VlpTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                <td><a href="javascript:FncVehiculoListaPrecioEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                </tr>
            </table></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Marca:</td>
            <td align="left" valign="top"><span id="spryselect1">
            <select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoListaPrecio->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td align="left" valign="top">Año Fabricacion:</td>
            <td align="left" valign="top"><span id="sprytextfield1">
              <input class="EstFormularioCaja" name="CmpAnoFabricacion" type="text" id="CmpAnoFabricacion" value="<?php echo $InsVehiculoListaPrecio->VlpAnoFabricacion;?>" size="10" maxlength="4" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Observacion:</td>
            <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo addslashes($InsVehiculoListaPrecio->VlpObservacion);?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsVehiculoListaPrecio->VlpEstado){
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
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
		
        
        </div>
        
        
        
           </td>
         </tr>
         <tr>
           <td colspan="2" valign="top"><div class="EstFormularioArea">
                  
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="98%">
                        
                        
                        
                        
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td width="21">&nbsp;</td>
                            <td width="48" align="center">Modelo</td>
                            <td width="47" align="center">Version</td>
                            <td width="90" align="center">Fuente</td>
                            <td width="67" align="center">Precio Wholesale sin IGV</td>
                            <td width="60" align="center">Precio Cierre c/ IGV</td>
                            <td width="60" align="center">Precio Lista c/ IGV</td>
                            <td width="60" align="center">Bono GM</td>
                            <td width="60" align="center">Bono Dealer</td>
                            <td width="62" align="center">Desc. Comercial</td>
                            <td width="125"><span class="EstFormularioSubTitulo">
                              <input type="hidden" name="CmpVehiculoListaPrecioDetalleId"  class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetalleId"  />
                              <input type="hidden" name="CmpVehiculoListaPrecioDetalleItem"  class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetalleItem"  />
                              <input type="hidden" name="CmpVehiculoListaPrecioDetalleAccion" id="CmpVehiculoListaPrecioDetalleAccion" value="AccVehiculoListaPrecioDetalleRegistrar.php" />
                              </span></td>
                            <td width="4">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                              
  <a href="javascript:FncVehiculoListaPrecioDetalleNuevo();">
  <img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" />
  </a>
                              
                              
                              
                            </td>
                            <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                            </select></td>
                            <td><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                            </select></td>
                            <td>
  <input name="CmpVehiculoListaPrecioDetalleFuente" type="text" class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetalleFuente" size="15" maxlength="45"  /></td>
                            <td>
<input name="CmpVehiculoListaPrecioDetalleCosto" type="text" class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetalleCosto" size="10" maxlength="45"  /></td>
                            <td>
<input name="CmpVehiculoListaPrecioDetallePrecioCierre" type="text" class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetallePrecioCierre" size="10" maxlength="45"  /></td>
                            <td>
<input name="CmpVehiculoListaPrecioDetallePrecioLista" type="text" class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetallePrecioLista" size="10" maxlength="45"  />

							</td>
                            <td><input name="CmpVehiculoListaPrecioDetalleBonoGM" type="text" class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetalleBonoGM" size="10" maxlength="45"  /></td>
                            <td><input name="CmpVehiculoListaPrecioDetalleBonoDealer" type="text" class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetalleBonoDealer" size="10" maxlength="45"  /></td>
                            <td><input name="CmpVehiculoListaPrecioDetalleDescuentoGerencia" type="text" class="EstFormularioCaja" id="CmpVehiculoListaPrecioDetalleDescuentoGerencia" size="10" maxlength="45"  /></td>
                            <td><a href="javascript:FncVehiculoListaPrecioDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a></td>
                          </tr>
                          </table>                      
                          </td>
                      </tr>
                    </table>
                  </div></td>
         </tr>
         <tr>
           <td colspan="2" valign="top">
           
           
           
           
           <div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                    <span class="EstFormularioSubTitulo">
                    DETALLE DE LA LISTA DE PRECIO DE VEHICULOS
                    </span>
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="49%">
                    
                    <div class="EstFormularioAccion" id="CapProductoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right"><a href="javascript:FncVehiculoListaPrecioDetalleListar();">
                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoListaPrecioDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
					

                    
                    </td>
                    <td width="1%"><div id="CapVehiculoListaPrecioDetallesResultado"> </div></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapVehiculoListaPrecioDetalles" class="EstCapVehiculoListaPrecioDetalles" > </div></td>
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
        <td align="center">
        
        

                
                
        </td>
      </tr>
    </table>
    
    
</div>

	
	
    

</form>


<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
	Calendar.setup({ 
	inputField : "CmpFechaVigencia",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaVigencia"// el id del botón que  
	});

</script>


<script type="text/javascript">
<!--
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minChars:4});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
		
}

?>

