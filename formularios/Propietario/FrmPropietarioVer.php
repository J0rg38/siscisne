<?php
$GET_id = $_GET['Id'];
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<?php
include($InsProyecto->MtdFormulariosMsj("Propietario").'MsjPropietario.php');

require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');

$InsPropietario = new ClsPropietario();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPropietarioEditar.php');

?>


<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $InsPropietario->ProId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" /></a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2" align="center"><span class="EstFormularioTitulo">VISUALIZAR
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
        
        </div>    <br />
        
        
		<div class="EstFormularioArea">
        
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input readonly="readonly"  class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsPropietario->ProId;?>" size="15" maxlength="20" /></td>
            <td>&nbsp;</td>
            <td rowspan="12">
              
              
              <?php
if(!empty($_SESSION['SesProFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesProFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesProFoto'.$Identificador], '.'.$extension);  
?>
              
              Vista Previa:<br />
              
              
              <img  src="subidos/propietario_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  <?php	
}else{
?>
              No hay FOTO
  <?php	
}
?>            </td>
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
            <td><input value="<?php echo $InsPropietario->ProNombre;?>"  class="EstFormularioCaja"  name="CmpPropietario" type="text" id="CmpPropietario" size="40" maxlength="255"  readonly="readonly"/></td>
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
            <td><input name="CmpDireccion" type="text" class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsPropietario->ProDireccion;?>" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Telefono:</td>
            <td><input name="CmpTelefono" type="text" class="EstFormularioCaja" id="CmpTelefono" value="<?php echo $InsPropietario->ProTelefono;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Celular:</td>
            <td><input name="CmpCelular" type="text" class="EstFormularioCaja" id="CmpCelular" value="<?php echo $InsPropietario->ProCelular;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Garantia:</td>
            <td><input name="CmpGarantia" type="text" class="EstFormularioCaja" id="CmpGarantia" value="<?php echo $InsPropietario->ProGarantia;?>" size="40" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Deuda Pendiente:</td>
            <td><input name="CmpDeudaPendiente" type="text" class="EstFormularioCaja" id="CmpDeudaPendiente" value="<?php echo $InsPropietario->ProDeudaPendiente;?>" size="40" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha Recibo:</td>
            <td><input name="CmpFechaRecibo" type="text" class="EstFormularioCajaFecha" id="CmpFechaRecibo" value="<?php echo $InsPropietario->ProFechaRecibo; ?>" size="15" maxlength="10" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha Reingreso:</td>
            <td><input name="CmpFechaReingreso" type="text" class="EstFormularioCajaFecha" id="CmpFechaReingreso" value="<?php echo $InsPropietario->ProFechaReingreso; ?>" size="15" maxlength="10" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td>
              
              
              <?php
			switch($InsPropietario->ProEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                <option <?php echo $OpcEstado1;?> value="1">Habilitado</option>
                <option <?php echo $OpcEstado2;?> value="2">Deshabilitado</option>
                </select>			</td>
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



	
	
	
    
<?php
$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>

<?php
}else{
echo ERR_GEN_101;
}
?>