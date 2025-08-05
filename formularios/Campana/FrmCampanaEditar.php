<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoMarcaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCampanaFunciones.js" ></script>

<?php

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}


//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCampana.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsCampana.php');
require_once($InsPoo->MtdPaqActividad().'ClsCampanaVehiculo.php');
//INSTANCIAS
$InsCampana = new ClsCampana();

if (isset($_SESSION['InsCampanaVehiculo'.$Identificador])){	
	$_SESSION['InsCampanaVehiculo'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCampanaVehiculo'.$Identificador]);
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCampanaEditar.php');


?>
<script type="text/javascript" >

var VehiculoMarcaHabilitado = 1;
var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;


$().ready(function() {
	
	FncVehiculoMarcasCargar();
	
});

</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        CAMPAÑA</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCampana->CamTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCampana->CamTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
         <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="Guardar" id="Guardar"   />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCampana->CamId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Campaña:</td>
            <td align="left" valign="top"><input name="CmpCodigo" type="text" class="EstFormularioCaja" id="CmpCodigo" value="<?php echo $InsCampana->CamCodigo;?>" size="20" maxlength="20"/></td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><span id="sprytextfield1">
              <label>
                <input  class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsCampana->CamNombre;?>" size="40" maxlength="250" />
                </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha  Inicio:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield7">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text" id="CmpFechaInicio" value="<?php  echo $InsCampana->CamFechaInicio; ?>" size="15" maxlength="10" />
                </label>
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">Fecha  Fin:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield">
              <input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text" id="CmpFechaFin" value="<?php  echo $InsCampana->CamFechaFin; ?>" size="15" maxlength="10" />
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cod. Operacion:</td>
            <td align="left" valign="top"><input name="CmpOperacionCodigo" type="text" class="EstFormularioCaja" id="CmpOperacionCodigo" value="<?php echo $InsCampana->CamOperacionCodigo;?>" size="20" maxlength="20"/></td>
            <td align="left" valign="top">
            
            Tiempo Operacion:<br />
                    <span class="EstFormularioSubEtiqueta">(hrs)</span>
                    
                    </td>
            <td align="left" valign="top"><input name="CmpOperacionTiempo" type="text" class="EstFormularioCaja" id="CmpOperacionTiempo" value="<?php echo number_format($InsCampana->CamOperacionTiempo,2);?>" size="20" maxlength="20"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Boletin:</td>
            <td align="left" valign="top"><input name="CmpBoletinCodigo" type="text" class="EstFormularioCaja" id="CmpBoletinCodigo" value="<?php echo $InsCampana->CamBoletinCodigo;?>" size="20" maxlength="20"/></td>
            <td align="left" valign="top">Observacion:</td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpObservacion" id="CmpObservacion" cols="45" rows="2"><?php echo $InsCampana->CamObservacion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Marca:
              <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsCampana->VmaId;?>" size="3" /></td>
            <td valign="top"><table>
              <tr>
                <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                  <option value="">Escoja una opcion</option>
                  <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                  <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsCampana->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                  <?php
			}
			?>
                </select></td>
                <td><a id="BtnVehiculoMarcaRegistrar" onclick="FncVehiculoMarcaCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoMarcaEditar" onclick="FncVehiculoMarcaCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
              </tr>
            </table></td>
            <td>Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsCampana->VmoId;?>" size="3" /></td>
            <td><table>
              <tr>
                <td>
                  <select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                  </select>
                 </td>
                <td><a id="BtnVehiculoModeloRegistrar" onclick="FncVehiculoModeloCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoModeloEditar" onclick="FncVehiculoModeloCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" valign="top">Archivo de Listado de Vehiculos:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" valign="top"><iframe src="formularios/Campana/acc/AccCampanaArchivo1Importar.php?Identificador=<?php echo $Identificador;?>" id="IfrCampanaArchivo1Importar" name="IfrCampanaArchivo1Importar" scrolling="Auto"  frameborder="0" width="800" height="300"></iframe></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" valign="top">Archivo de Boletin:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><iframe src="formularios/Campana/acc/AccCampanaBoletinImportar.php?Identificador=<?php echo $Identificador;?>" id="IfrCampanaBoletinImportar" name="IfrCampanaBoletinImportar" scrolling="Auto"  frameborder="0" width="800" height="300"></iframe></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>
	
	
	
    

</form>

<script type="text/javascript">
Calendar.setup({ 
		inputField : "CmpFechaInicio",  // id del campo de texto 
		ifFormat   : "%d/%m/%Y",  //  
		button     : "BtnFechaInicio"// el id del botón que  
	});

	Calendar.setup({ 
		inputField : "CmpFechaFin",  // id del campo de texto 
		ifFormat   : "%d/%m/%Y",  //  
		button     : "BtnFechaFin"// el id del botón que  
	});
	
<!--
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
//-->
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
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

