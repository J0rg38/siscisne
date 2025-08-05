<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProduccionProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProduccionProductoDetalleEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProduccionProductoDetalleSalidaFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProduccionProducto.css');
</style>

<?php
$GET_id = $_GET['Id'];

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

$ResAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmId","ASC",NULL);
$ArrAlmacens = $ResAlmacen['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

?>

<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){
	
	FncProduccionProductoDetalleEntradaListar();
	FncProduccionProductoDetalleSalidaListar();
		
});


var ProduccionProductoDetalleEntradaEditar = 2;
var ProduccionProductoDetalleEntradaEliminar = 2;

var ProduccionProductoDetalleSalidaEditar = 2;
var ProduccionProductoDetalleSalidaEliminar = 2;
</script>

<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
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
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsProduccionProducto->PprId;?>&Su=<?php echo $InsProduccionProducto->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER CONVERSION DE PRODUCTOS</span></td>
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
               
               
                                       
<input type="hidden" name="CmpAlmacenMovimientoIdIngreso" id="CmpAlmacenMovimientoIdIngreso"  value="<?php echo $InsProduccionProducto->AmoIdIngreso; ?>" />
<input type="hidden" name="CmpAlmacenMovimientoIdSalida" id="CmpAlmacenMovimientoIdSalida"  value="<?php echo $InsProduccionProducto->AmoIdSalida; ?>" />


</span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="center">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProduccionProducto->PprId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Responsable:</td>
               <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
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
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsProduccionProducto->PprFecha)){ echo date("d/m/Y");}else{ echo $InsProduccionProducto->PprFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Almacen Origen:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                 <option value="">Escoja una opcion</option>
                 <?php
			  foreach($ArrAlmacens as $DatAlmacen){
			  ?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsProduccionProducto->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';}elseif($EmpresaAlmacenId==$DatAlmacen->AlmId){  echo 'selected="selected"';}?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			  }
			  ?>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsProduccionProducto->PprObservacion;?></textarea></td>
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
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
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
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProduccionProductoDetalleEntradaEliminarTodo();"></a></td>
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
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
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
    

    
   
    
    
<div>		
 
 
        
        
        
          
       

           
  
        
        
        
        
        </td>
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
