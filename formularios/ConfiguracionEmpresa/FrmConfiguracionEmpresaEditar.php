<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsConfiguracionEmpresaFunciones.js" ></script>

<?php

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjConfiguracion.php');

require_once($InsPoo->MtdPaqConfiguracion().'ClsConfiguracionEmpresa.php');
require_once($InsPoo->MtdPaqConfiguracion().'ClsCalificacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
$InsCalificacion = new ClsCalificacion();
$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccConfiguracionEmpresaEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
$MonedasTotal = $ResMoneda['Total'];

$ResCalificacion = $InsCalificacion->MtdObtenerCalificaciones(NULL,NULL,"CalId","ASC",NULL,NULL);
$ArrCalificaciones = $ResCalificacion['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];
?>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />






<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >
<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>
<?php	
}
?>
	 
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        CONFIGURACION DE EMPRESA</span></td>
      </tr>
      <tr>
        <td colspan="2">
    
        
    <!--         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsConfiguracionEmpresa->TiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsConfiguracionEmpresa->TiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        -->
        
        
        
        
<ul class="tabs">
    <li><a href="#tab1">General</a></li>
    <li><a href="#tab2">Impuestos</a></li>
    <li><a href="#tab3">Margenes</a></li>
</ul>



<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Empresa			</span>		
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:
              <input type="hidden" name="CmpId" id="CmpId" value="<?php echo $InsConfiguracionEmpresa->CemId ?>" /></td>
            <td><span id="sprytextfield1">
              <label>
                <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsConfiguracionEmpresa->CemNombre;?>" size="40" maxlength="250" />
                </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Nombre Comercial:</td>
            <td><input class="EstFormularioCaja"   name="CmpNombreComercial" type="text" id="CmpNombreComercial" value="<?php echo $InsConfiguracionEmpresa->CemNombreComercial;?>" size="40" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>R.U.C.:</td>
            <td><label>
              <input name="CmpCodigo" type="text" class="EstFormularioCaja" id="CmpCodigo" value="<?php echo $InsConfiguracionEmpresa->CemCodigo;?>" size="40" maxlength="30" />
              </label></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Representante Legal:</td>
            <td><input name="CmpRepresentanteNombre" type="text" class="EstFormularioCaja" id="CmpRepresentanteNombre" value="<?php echo $InsConfiguracionEmpresa->CemRepresentanteNombre;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Representante Num. Doc.:</td>
            <td><input name="CmpRepresentanteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpRepresentanteNumeroDocumento" value="<?php echo $InsConfiguracionEmpresa->CemRepresentanteNumeroDocumento;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Direccion:</td>
            <td><input name="CmpDireccion" type="text" class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsConfiguracionEmpresa->CemDireccion;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Departamento:</td>
            <td><input name="CmpDepartamento" type="text" class="EstFormularioCaja" id="CmpDepartamento" value="<?php echo $InsConfiguracionEmpresa->CemDepartamento;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Provincia:</td>
            <td><input name="CmpProvincia" type="text" class="EstFormularioCaja" id="CmpProvincia" value="<?php echo $InsConfiguracionEmpresa->CemProvincia;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Distrito:</td>
            <td><input name="CmpDistrito" type="text" class="EstFormularioCaja" id="CmpDistrito" value="<?php echo $InsConfiguracionEmpresa->CemDistrito;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Pais:</td>
            <td><input name="CmpPais" type="text" class="EstFormularioCaja" id="CmpPais" value="<?php echo $InsConfiguracionEmpresa->CemPais;?>" size="40" maxlength="30" />
              <input name="CmpPaisAbreviacion" type="text" class="EstFormularioCaja" id="CmpPaisAbreviacion" value="<?php echo $InsConfiguracionEmpresa->CemPaisAbreviacion;?>" size="5" maxlength="10" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Codigo Ubigeo:</td>
            <td><input name="CmpCodigoUbigeo" type="text" class="EstFormularioCaja" id="CmpCodigoUbigeo" value="<?php echo $InsConfiguracionEmpresa->CemCodigoUbigeo;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Telefono:</td>
            <td><input name="CmpTelefono" type="text" class="EstFormularioCaja" id="CmpTelefono" value="<?php echo $InsConfiguracionEmpresa->CemTelefono;?>" size="40" maxlength="30" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Moneda Principal:</td>
            <td><span id="spryselect1">
             
                <select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda" disabled="disabled">

              <option value="-1">Escoja una opcion</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsConfiguracionEmpresa->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                  </select>
             
              <span class="selectInvalidMsg">Seleccione un elemento válido.</span>               <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span>
              
              
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Calificacion GM:</td>
            <td><span id="spryselect2">
              <select class="EstFormularioCombo" name="CmpCalificacion" id="CmpCalificacion" >
                <option value="">Escoja una opcion</option>
                <?php
			  foreach($ArrCalificaciones as $DatCalificacion){
			  ?>
                <option value="<?php echo $DatCalificacion->CalId?>" <?php if($InsConfiguracionEmpresa->CalId==$DatCalificacion->CalId){ echo 'selected="selected"';}?> ><?php echo $DatCalificacion->CalTipo?> </option>
                <?php
			  }
			  ?>
                </select>
              <span class="selectInvalidMsg">Seleccione un elemento v&aacute;lido.</span> <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Almacen Predeterminado:</td>
            <td>
              
              <select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                <option value="">Escoja una opcion</option>
                <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsConfiguracionEmpresa->AlmId == $DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                <?php
			}
			?>
                </select>
              
              
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
          </div>
          
          
	</div>
        <div id="tab2" class="tab_content">
        <!--Content-->
        
          <div class="EstFormularioArea">
         
       <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">Impuestos </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Impuesto General a las Ventas:<br />
              (%)</td>
            <td align="left" valign="top"><span id="sprytextfield2">
              
              <input class="EstFormularioCaja" name="CmpImpuestoVenta" type="text" id="CmpImpuestoVenta" size="10" maxlength="10" value="<?php  echo number_format($InsConfiguracionEmpresa->CemImpuestoVenta,2);?>" />
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Impuesto Selectivo al Consumo:<br />
              (%)</td>
            <td align="left" valign="top"><span id="sprytextfield5">
              <input class="EstFormularioCaja" name="CmpImpuestoSelectivo" type="text" id="CmpImpuestoSelectivo" size="10" maxlength="10" value="<?php  echo number_format($InsConfiguracionEmpresa->CemImpuestoSelectivo,2);?>" />
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Impuesto a la Renta:<br />
              (%)</td>
            <td align="left" valign="top"><span id="sprytextfield3">
            
            <input  name="CmpImpuestoRenta" type="text" class="EstFormularioCaja" id="CmpImpuestoRenta" value="<?php  echo number_format($InsConfiguracionEmpresa->CemImpuestoRenta,2); ?>" size="10" maxlength="10" />
            <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
         </div>
        
	</div>
    
        <div id="tab3" class="tab_content">
        <!--Content-->
        
          
         
           <div class="EstFormularioArea">
         
        
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">Margenes </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Porcentaje Utilidad:<br />
              (%)</td>
            <td align="left" valign="top"><span id="sprytextfield2">
              
              <input class="EstFormularioCaja" name="CmpRepuestoMargenUtilidad" type="text" id="CmpRepuestoMargenUtilidad" size="10" maxlength="10" value="<?php  echo number_format($InsConfiguracionEmpresa->CemRepuestoMargenUtilidad,2);?>" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Porcentaje Otros Costos (Flete):<br />
              (%)</td>
            <td align="left" valign="top"><span id="sprytextfield3">
            
            <input  name="CmpRepuestoFlete" type="text" class="EstFormularioCaja" id="CmpRepuestoFlete" value="<?php  echo number_format($InsConfiguracionEmpresa->CemRepuestoFlete,2); ?>" size="10" maxlength="10" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Porcentaje de Mano de Obra:<br />
              (%)</td>
            <td><span id="sprytextfield4">
              <input class="EstFormularioCaja" name="CmpMantenimientoPorcentajeManoObra" type="text" id="CmpMantenimientoPorcentajeManoObra" size="10" maxlength="10" value="<?php  echo number_format($InsConfiguracionEmpresa->CemMantenimientoPorcentajeManoObra,2);?>" />
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
         </div>
	</div>
</div>

        
       
       
     



      </tr>
      
      <tr>
        <td colspan="2" align="center">
        
        </td>
        </tr>
    </table>
</div>
	
	
	
    

</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1"});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none");
//-->
</script>


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

