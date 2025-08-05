<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoProformaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoProformaDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoProforma.css');
</style>

<?php
//VARIABLES
$Edito = false;
$GET_id = $_GET['Id'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}



//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoProforma.php');
include($InsProyecto->MtdFormulariosMsj("VehiculoIngreso").'MsjVehiculoIngreso.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoProforma.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoProformaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
//INSTANCIAS
$InsVehiculoProforma = new ClsVehiculoProforma();
$InsVehiculMarca = new ClsVehiculoMarca();

$InsMoneda = new ClsMoneda();

if (isset($_SESSION['InsVehiculoProformaDetalle'.$Identificador])){	
	$_SESSION['InsVehiculoProformaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoProformaDetalle'.$Identificador]);
}


//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoProformaEditar.php');
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

var VehiculoProformaDetalleEditar = 1;
var VehiculoProformaDetalleEliminar = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;

$().ready(function() {
	
	$("#CmpCodigo").focus();
	
	FncVehiculoProformaDetalleListar();
	
});

</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">



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
        <td width="961" height="25"><span class="EstFormularioTitulo">EDITAR PROFORMA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td>
        
        
                              
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoProforma->VprTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoProforma->VprTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div>
        
          <br />
        

		
		
		
<ul class="tabs">
    <li><a href="#tab1">Proforma</a></li>
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

	   
     
       
       <table border="0" cellpadding="2" cellspacing="2">
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">
              <span class="EstFormularioSubTitulo">
                Datos de la Proforma	del	Vehiculo	</span>			
              
              <input type="hidden" name="Guardar" id="Guardar"   />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoProforma->VprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">Fecha Registro:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield2">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo $InsVehiculoProforma->VprFecha;?>" size="15" maxlength="10" />
                </label>
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">No. Proforma:</td>
            <td align="left" valign="top"><label for="CmpCodigo"></label>
              <input class="EstFormularioCaja" name="CmpCodigo" type="text" id="CmpCodigo" value="<?php echo $InsVehiculoProforma->VprCodigo;?>" size="20" maxlength="45" /></td>
            <td>Año/Mes Proforma</td>
            <td><input value="<?php echo $InsVehiculoProforma->VprAno;?>"  class="EstFormularioCaja"  name="CmpAnoProforma" type="text" id="CmpAnoProforma" size="10" maxlength="4" />
              /
              <?php
			switch($InsVehiculoProforma->VprMes){
				case "01":
					$OptMes1 =  'selected="selected"';
				break;
				case "02":
					$OptMes2 =  'selected="selected"';
				break;
				case "03":
					$OptMes3 =  'selected="selected"';
				break;
				case "04":
					$OptMes4 =  'selected="selected"';
				break;
				case "05":
					$OptMes5 =  'selected="selected"';
				break;
				case "06":
					$OptMes6 =  'selected="selected"';
				break;
				case "07":
					$OptMes7 =  'selected="selected"';
				break;				
				case "08":
					$OptMes8 =  'selected="selected"';
				break;
				case "09":
					$OptMes9 =  'selected="selected"';
				break;
				case "10":
					$OptMes10 =  'selected="selected"';
				break;
				case "11":
					$OptMes11 =  'selected="selected"';
				break;	
				case "12":
					$OptMes12 =  'selected="selected"';
				break;	
				default:
					$OptMes1 =  'selected="selected"';
				break;																																					
			}
			?>
              <select class="EstFormularioCombo" name="CmpMesProforma" id="CmpMesProforma">
                <option <?php echo $OptMes1;?> value="01">Enero</option>
                <option <?php echo $OptMes2;?> value="02">Febrero</option>
                <option <?php echo $OptMes3;?> value="03">Marzo</option>
                <option <?php echo $OptMes4;?> value="04">Abril</option>
                <option <?php echo $OptMes5;?> value="05">Mayo</option>
                <option <?php echo $OptMes6;?> value="06">Junio</option>
                <option <?php echo $OptMes7;?> value="07">Julio</option>
                <option <?php echo $OptMes8;?> value="08">Agosto</option>
                <option <?php echo $OptMes9;?> value="09">Setiembre</option>
                <option <?php echo $OptMes10;?> value="10">Octubre</option>
                <option <?php echo $OptMes11;?> value="11">Noviembre</option>
                <option <?php echo $OptMes12;?> value="12">Diciembre</option>
              </select></td>
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
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoProforma->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                    </select>
                  <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                <td><div id="CapMonedaBuscar"></div></td>
                </tr>
              <tr> </tr>
            </table></td>
            <td align="left" valign="top">Tipo de Cambio:<br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVehiculoProformaDetalleListar();" value="<?php if (empty($InsVehiculoProforma->VprTipoCambio)){ echo "";}else{ echo $InsVehiculoProforma->VprTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                <td><a href="javascript:FncVehiculoProformaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                </tr>
            </table> </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Marca
              <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" size="3" /></td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo (($DatVehiculoMarca->VmaId==$InsVehiculoProforma->VmaId)?'selected="selected"':'');?>  value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Observacion:</td>
            <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo addslashes($InsVehiculoProforma->VprObservacion);?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">¿Proforma Adicional?</td>
            <td align="left" valign="top"><?php
switch($InsVehiculoProforma->VprAdicional){
	
	case 1:
		$OpcVehiculoAdicional1 = 'checked="checked"';
	break;
	
	case 2:
		$OpcVehiculoAdicional2 = 'checked="checked"';
	break;
	
}
?>
              <input <?php echo $OpcVehiculoAdicional1;?> type="radio" name="CmpAdicional" id="CmpAdicional1" value="1" />
              Si
  <input <?php echo $OpcVehiculoAdicional2;?> type="radio" name="CmpAdicional" id="CmpAdicional2" value="2" />
              No </td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsVehiculoProforma->VprEstado){
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
		</div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table width="100%" border="0" cellpadding="0" cellspacing="0">
             <tr>
               <td width="98%"><table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                 <tr>
                   <td>&nbsp;</td>
                   <td align="center">Modelo
                     <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" size="3" /></td>
                   <td align="center">Version
                     <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" size="3" /></td>
                   <td align="center">Color</td>
                   <td align="center"><input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="" size="3" /></td>
                   <td align="center">VIN</td>
                   <td align="center">&nbsp;</td>
                   <td align="center">Motor:</td>
                   <td align="center">
                   
                   <span title="Año Fabricacion">Año Fab.</span></td>
                   <td align="center"> <span title="Año Modelo">Año Mod.</span></td>
                   <td align="center"> <span title="Precio Proformado">Precio Prof.</span></td>
                   <td><span class="EstFormularioSubTitulo">
                     <input type="hidden" name="CmpVehiculoProformaDetalleId"  class="EstFormularioCaja" id="CmpVehiculoProformaDetalleId"  />
                     <input type="hidden" name="CmpVehiculoProformaDetalleItem"  class="EstFormularioCaja" id="CmpVehiculoProformaDetalleItem"  />
                     <input type="hidden" name="CmpVehiculoProformaDetalleAccion" id="CmpVehiculoProformaDetalleAccion" value="AccVehiculoProformaDetalleRegistrar.php" />
                   </span></td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td><a href="javascript:FncVehiculoProformaDetalleNuevo();"></a></td>
                   <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                   </select></td>
                   <td><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                   </select></td>
                   <td><input name="CmpVehiculoIngresoColor" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoColor" size="15" maxlength="45"  /></td>
                   <td><a href="javascript:FncVehiculoProformaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a><a href="javascript:FncVehiculoIngresoNuevo();"></a></td>
                   <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" size="20" maxlength="45"  /></td>
                   <td><a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input name="CmpVehiculoIngresoNumeroMotor" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoNumeroMotor" size="15" maxlength="45"  /></td>
                   <td><input name="CmpVehiculoIngresoAnoFabricacion" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" size="8" maxlength="4"  /></td>
                   <td><input name="CmpVehiculoIngresoAnoModelo" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoModelo" size="8" maxlength="4"  /></td>
                   <td><input name="CmpVehiculoProformaDetalleCosto" type="text" class="EstFormularioCaja" id="CmpVehiculoProformaDetalleCosto" size="15" maxlength="45"  /></td>
                   <td><a href="javascript:FncVehiculoProformaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                   <td></td>
                 </tr>
               </table></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2">
               
               <span class="EstFormularioSubTitulo">
               DETALLE DE LA PROFORMA DE VEHICULOS
               </span>
               </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVehiculoProformaDetalleListar();"> <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoProformaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%"><div id="CapVehiculoProformaDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVehiculoProformaDetalles" class="EstCapVehiculoProformaDetalles" > </div></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top">
         
          
        
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
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});


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

?>

<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy"});
</script>
