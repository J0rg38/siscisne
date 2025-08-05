<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProduccionProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProduccionProductoDetalleEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProduccionProductoDetalleSalidaFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProduccionProducto.css');
</style>
<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProduccionProducto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProduccionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProduccionProductoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

//INSTANCIAS
$InsProduccionProducto = new ClsProduccionProducto();
$InsAlmacen = new ClsAlmacen();
$InsPersonal = new ClsPersonal();


if (isset($_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador])){	
	$_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador]);
}

if (isset($_SESSION['InsProduccionProductoDetalleSalida'.$Identificador])){	
	$_SESSION['InsProduccionProductoDetalleSalida'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsProduccionProductoDetalleSalida'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProduccionProductoEditar.php');

$ResAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmId","ASC",NULL,$InsProduccionProducto->SucId);
$ArrAlmacens = $ResAlmacen['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();

/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpFecha').focus();

	FncProduccionProductoDetalleEntradaListar();
	FncProduccionProductoDetalleSalidaListar();
	
});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";


var ProduccionProductoDetalleEntradaEditar = 1;
var ProduccionProductoDetalleEntradaEliminar = 1;

var ProduccionProductoDetalleSalidaEditar = 1;
var ProduccionProductoDetalleSalidaEliminar = 1;
</script>




<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();"> 


<div class="EstCapMenu">

           
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div> 
<?php	
}
?>
	



<?php
if($Edito){
?>

	<?php
  /*  if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsProduccionProducto->PprId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsProduccionProducto->PprId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }*/
    ?>

<?php	
}
?>
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        CONVERSION DE PRODUCTOS</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProduccionProducto->PprTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProduccionProducto->PprTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1">Conversion de Productos</a></li>
 

</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        

        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Conversion de Productos
                 
                 
                 
                 
                 
                 
                 
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>
               <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsProduccionProducto->PprPorcentajeImpuestoVenta; ?>" />
                        
                        <input type="hidden" name="CmpMonedaId" id="CmpMonedaId"  value="<?php echo $InsProduccionProducto->MonId; ?>" />
                                           
<input type="hidden" name="CmpAlmacenMovimientoIdIngreso" id="CmpAlmacenMovimientoIdIngreso"  value="<?php echo $InsProduccionProducto->AmoIdIngreso; ?>" />
<input type="hidden" name="CmpAlmacenMovimientoIdSalida" id="CmpAlmacenMovimientoIdSalida"  value="<?php echo $InsProduccionProducto->AmoIdSalida; ?>" />     
                        
                      
                      
                      </td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProduccionProducto->PprId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Responsable:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsProduccionProducto->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha Salida:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsProduccionProducto->PprFecha;?>" size="10" maxlength="10" readonly="readonly" />
                 
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                 
                 
                 </td>
               <td align="left" valign="top">Almacen Origen:</td>
               <td align="left" valign="top"><span id="spryselect2">
                 <select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                   <option value="">Escoja una opcion</option>
                   <?php
			  foreach($ArrAlmacens as $DatAlmacen){
			  ?>
                   <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsProduccionProducto->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';}elseif($EmpresaAlmacenId==$DatAlmacen->AlmId){  echo 'selected="selected"';}?> ><?php echo $DatAlmacen->AlmNombre?></option>
                   <?php
			  }
			  ?>
                   </select>
                 <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsProduccionProducto->PprObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsProduccionProducto->PprEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled" >
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="11"><span class="EstFormularioSubTitulo"> PRODUCTOS INGRESANTES
                 <input type="hidden" name="CmpProductoIdEntrada"    id="CmpProductoIdEntrada"   />
                 <input type="hidden" name="CmpProductoItemEntrada" id="CmpProductoItemEntrada" />
                 <input type="hidden" name="CmpProductoUnidadMedidaEntrada" id="CmpProductoUnidadMedidaEntrada" />
                 <input type="hidden" name="CmpProductoUnidadMedidaEquivalenteEntrada"   id="CmpProductoUnidadMedidaEquivalenteEntrada"  />
                 <input type="hidden" name="CmpProduccionProductoDetalleIdEntrada"  class="EstFormularioCaja" id="CmpProduccionProductoDetalleIdEntrada"  />
                 <input type="hidden" name="CmpProduccionProductoDetalleEstadoEntrada" id="CmpProduccionProductoDetalleEstadoEntrada" value="3" />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div id="CapProductoBuscarEntrada"></div></td>
               <td>Cod. Orig.</td>
               <td>&nbsp;</td>
               <td>Cod. Alt.</td>
               <td>&nbsp;</td>
               <td>Nombre </td>
               <td>&nbsp;</td>
               <td>U.M. </td>
               <td>Cantidad</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncProduccionProductoDetalleEntradaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpProductoCodigoOriginalEntrada"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginalEntrada" size="10" maxlength="20" /></td>
               <td><a href="javascript:FncProductoBuscarEntrada('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
               <td><input name="CmpProductoCodigoAlternativoEntrada"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativoEntrada" size="10" maxlength="20" /></td>
               <td><a href="javascript:FncProductoBuscarEntrada('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
               <td><input name="CmpProductoNombreEntrada" type="text" class="EstFormularioCaja" id="CmpProductoNombreEntrada" size="40" /></td>
               <td><a id="BtnProductoRegistrarEntrada" onclick="FncProductoCargarFormularioEntrada('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditarEntrada" onclick="FncProductoCargarFormularioEntrada('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
               <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertirEntrada" id="CmpProductoUnidadMedidaConvertirEntrada">
               </select></td>
               <td><input name="CmpProductoCantidadEntrada" type="text"  class="EstFormularioCaja" id="CmpProductoCantidadEntrada" size="7" maxlength="10"  /></td>
               <td><a href="javascript:FncProduccionProductoDetalleEntradaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
               <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccionEntrada">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncProduccionProductoDetalleEntradaListar();">
                 <input type="hidden" name="CmpProduccionProductoDetalleEntradaAccion" id="CmpProduccionProductoDetalleEntradaAccion" value="AccProduccionProductoDetalleEntradaRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProduccionProductoDetalleEntradaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%"><div id="CapProduccionProductoDetalleEntradasResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapProduccionProductoDetalleEntradas" class="EstCapProduccionProductoDetalleEntradas" > </div></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="11"><span class="EstFormularioSubTitulo"> PRODUCTOS SALIENTES
                 <input type="hidden" name="CmpProductoIdSalida"    id="CmpProductoIdSalida"   />
                 <input type="hidden" name="CmpProductoItemSalida" id="CmpProductoItemSalida" />
                 <input type="hidden" name="CmpProductoUnidadMedidaSalida" id="CmpProductoUnidadMedidaSalida" />
                 <input type="hidden" name="CmpProductoUnidadMedidaEquivalenteSalida"   id="CmpProductoUnidadMedidaEquivalenteSalida"  />
                 <input type="hidden" name="CmpProduccionProductoDetalleIdSalida"  class="EstFormularioCaja" id="CmpProduccionProductoDetalleIdSalida"  />
                 <input type="hidden" name="CmpProduccionProductoDetalleEstadoSalida" id="CmpProduccionProductoDetalleEstadoSalida" value="3" />
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div id="CapProductoBuscarSalida"></div></td>
               <td>Cod. Orig.</td>
               <td>&nbsp;</td>
               <td>Cod. Alt.</td>
               <td>&nbsp;</td>
               <td>Nombre </td>
               <td>&nbsp;</td>
               <td>U.M. </td>
               <td>Cantidad</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><a href="javascript:FncProduccionProductoDetalleSalidaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
               <td><input name="CmpProductoCodigoOriginalSalida"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginalSalida" size="10" maxlength="20" /></td>
               <td><a href="javascript:FncProductoBuscarSalida('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
               <td><input name="CmpProductoCodigoAlternativoSalida"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativoSalida" size="10" maxlength="20" /></td>
               <td><a href="javascript:FncProductoBuscarSalida('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
               <td><input name="CmpProductoNombreSalida" type="text" class="EstFormularioCaja" id="CmpProductoNombreSalida" size="40" /></td>
               <td><a id="BtnProductoRegistrarSalida" onclick="FncProductoCargarFormularioSalida('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditarSalida" onclick="FncProductoCargarFormularioSalida('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
               <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertirSalida" id="CmpProductoUnidadMedidaConvertirSalida">
               </select></td>
               <td><input name="CmpProductoCantidadSalida" type="text"  class="EstFormularioCaja" id="CmpProductoCantidadSalida" size="7" maxlength="10"  /></td>
               <td><a href="javascript:FncProduccionProductoDetalleSalidaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
               <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccionSalida">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncProduccionProductoDetalleSalidaListar();">
                 <input type="hidden" name="CmpProduccionProductoDetalleSalidaAccion" id="CmpProduccionProductoDetalleSalidaAccion" value="AccProduccionProductoDetalleSalidaRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProduccionProductoDetalleSalidaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%"><div id="CapProduccionProductoDetalleSalidasResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapProduccionProductoDetalleSalidas" class="EstCapProduccionProductoDetalleSalidas" > </div></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       </table>
         
		

	</div>    

    




    
    
</div>    		 
		
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
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


var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<?php
//}else{
//	echo ERR_PPR_601;
//}
?>


<?php
}else{
	echo ERR_GEN_101;
}



if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}
?>
