<?php
$GET_id = $_GET['Id'];
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)   ){
?>

<?php
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj("Propietario").'MsjPropietario.php');

require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');

$InsPropietario = new ClsPropietario();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPropietarioEditar.php');

$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/iconos/guardar.png" width="50" height="50" alt="[Guardar]" title="Guardar" />
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2" align="center"><span class="EstFormularioTitulo">MODIFICAR
        PROPIETARIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPropietario->ProTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPropietario->ProTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
        <br />
		<div class="EstFormularioArea">
        
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input readonly="readonly"  class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsPropietario->ProId;?>" size="15" maxlength="20" /></td>
            <td>&nbsp;</td>
            <td rowspan="18"><iframe src="formularios/Propietario/acc/AccPropietarioSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrPropietarioSubirArchivo" name="IfrPropietarioSubirArchivo" scrolling="Auto"  frameborder="0" width="400" height="500"></iframe></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Num. Documento:</td>
            <td><input class="EstFormularioCaja" name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" value="<?php echo $InsPropietario->ProNumeroDocumento;?>" size="20" maxlength="20" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><span id="sprytextfield1">
              <label>
                <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsPropietario->ProNombre;?>" size="40" maxlength="250" />
                </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Apellidos:</td>
            <td><input class="EstFormularioCaja" name="CmpApellido" type="text" id="CmpApellido" value="<?php echo $InsPropietario->ProApellido;?>" size="40" maxlength="250" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Direccion:</td>
            <td><input class="EstFormularioCaja" name="CmpDireccion" type="text" id="CmpDireccion" value="<?php echo $InsPropietario->ProDireccion;?>" size="40" maxlength="250" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Telefono:</td>
            <td><input class="EstFormularioCaja" name="CmpTelefono" type="text" id="CmpTelefono" value="<?php echo $InsPropietario->ProTelefono;?>" size="20" maxlength="45" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Celular:</td>
            <td><input class="EstFormularioCaja" name="CmpCelular" type="text" id="CmpCelular" value="<?php echo $InsPropietario->ProCelular;?>" size="20" maxlength="45" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Garantia:</td>
            <td><input class="EstFormularioCaja" name="CmpGarantia" type="text" id="CmpGarantia" value="<?php echo $InsPropietario->ProGarantia;?>" size="40" maxlength="45" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Deuda Pendiente:</td>
            <td><input class="EstFormularioCaja" name="CmpDeudaPendiente" type="text" id="CmpDeudaPendiente" value="<?php echo $InsPropietario->ProDeudaPendiente;?>" size="40" maxlength="45" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha Recibo:</td>
            <td><span id="sprytextfield5">
            <label>
              <input name="CmpFechaRecibo" type="text" class="EstFormularioCajaFecha" id="CmpFechaRecibo" value="<?php echo $InsPropietario->ProFechaRecibo; ?>" size="15" maxlength="10" />
            </label>
            <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Formato no valido"  /></span></span>
            
            <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaRecibo" name="BtnFechaRecibo" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
                      
                      
                      dd/mm/yyyy 
                      
                      
                      
                      </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha Reingreso:</td>
            <td><span id="sprytextfield2">
            <label>
              <input name="CmpFechaReingreso" type="text" class="EstFormularioCajaFecha" id="CmpFechaReingreso" value="<?php echo $InsPropietario->ProFechaReingreso; ?>" size="15" maxlength="10" />
            </label>
            <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Formato no valido"  /></span></span>
            
            <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaReingreso" name="BtnFechaReingreso" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
                      
                      dd/mm/yyyy 
                      
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td><?php
			switch($InsPropietario->ProEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Habilitado</option>
                <option <?php echo $OpcEstado2;?> value="2">Deshabilitado</option>
              </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", isRequired:false});
//-->
</script>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaRecibo",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaRecibo"// el id del botón que  
	});

Calendar.setup({ 
	inputField : "CmpFechaReingreso",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaReingreso"// el id del botón que  
	});
</script>
<?php

}else{
echo ERR_GEN_101;
}
?>