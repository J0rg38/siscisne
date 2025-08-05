<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsConfiguracionEmpresaFunciones.js" ></script>

<?php
$GET_id = $_GET['Id'];

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

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];
?>
<div class="EstCapMenu">
 <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsConfiguracion->ConId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        CONFIGURACION DE EMPRESA</span></td>
      </tr>
      <tr>
        <td colspan="2">
        <br />
        
        
<!--             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsConfiguracion->ConTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsConfiguracion->ConTiempoModificacion;?></span></td>
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
            <td colspan="2"><span class="EstFormularioSubTitulo">Empresa </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:
              <input type="hidden" name="CmpId" id="CmpId" value="<?php echo $InsConfiguracionEmpresa->CemId ?>" /></td>
            <td><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsConfiguracionEmpresa->CemNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Nombre Comercial:</td>
            <td><input   name="CmpNombreComercial" type="text" class="EstFormularioCaja" id="CmpNombreComercial" value="<?php echo $InsConfiguracionEmpresa->CemNombreComercial;?>" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>R.U.C.:</td>
            <td><label>
              <input name="CmpCodigo" type="text" class="EstFormularioCaja" id="CmpCodigo" value="<?php echo $InsConfiguracionEmpresa->CemCodigo;?>" size="40" maxlength="30" readonly="readonly" />
            </label></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Representante Legal:</td>
            <td><input name="CmpRepresentanteNombre" type="text" class="EstFormularioCaja" id="CmpRepresentanteNombre" value="<?php echo $InsConfiguracionEmpresa->CemRepresentanteNombre;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Representante Num. Doc.:</td>
            <td><input name="CmpRepresentanteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpRepresentanteNumeroDocumento" value="<?php echo $InsConfiguracionEmpresa->CemRepresentanteNumeroDocumento;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Direccion:</td>
            <td><input name="CmpDireccion" type="text" class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsConfiguracionEmpresa->CemDireccion;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Departamento:</td>
            <td><input name="CmpDepartamento" type="text" class="EstFormularioCaja" id="CmpDepartamento" value="<?php echo $InsConfiguracionEmpresa->CemDepartamento;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Provincia:</td>
            <td><input name="CmpProvincia" type="text" class="EstFormularioCaja" id="CmpProvincia" value="<?php echo $InsConfiguracionEmpresa->CemProvincia;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Distrito:</td>
            <td><input name="CmpDistrito" type="text" class="EstFormularioCaja" id="CmpDistrito" value="<?php echo $InsConfiguracionEmpresa->CemDistrito;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Pais:</td>
            <td><input name="CmpPais" type="text" class="EstFormularioCaja" id="CmpPais" value="<?php echo $InsConfiguracionEmpresa->CemPais;?>" size="40" maxlength="30" readonly="readonly" />
              <input name="CmpPaisAbreviacion" type="text" class="EstFormularioCaja" id="CmpPaisAbreviacion" value="<?php echo $InsConfiguracionEmpresa->CemPaisAbreviacion;?>" size="5" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Codigo Ubigeo:</td>
            <td><input name="CmpCodigoUbigeo" type="text" class="EstFormularioCaja" id="CmpCodigoUbigeo" value="<?php echo $InsConfiguracionEmpresa->CemCodigoUbigeo;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Telefono:</td>
            <td><input name="CmpTelefono" type="text" class="EstFormularioCaja" id="CmpTelefono" value="<?php echo $InsConfiguracionEmpresa->CemTelefono;?>" size="40" maxlength="30" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Moneda Principal:</td>
            <td>
              
              <select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda" disabled="disabled">
                <option value="-1">Escoja una opcion</option>
                <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsConfiguracion->EmpresaMoneda==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                <?php
			  }
			  ?>
                </select>
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Calificacion GM:</td>
            <td><select class="EstFormularioCombo" name="CmpCalificacion" id="CmpCalificacion" >
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrCalificaciones as $DatCalificacion){
			  ?>
              <option value="<?php echo $DatCalificacion->CalId?>" <?php if($InsConfiguracionEmpresa->CalId==$DatCalificacion->CalId){ echo 'selected="selected"';}?> ><?php echo $DatCalificacion->CalTipo?></option>
              <?php
			  }
			  ?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Almacen Predeterminado:</td>
            <td><select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
              <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsConfiguracionEmpresa->AlmId == $DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
              <?php
			}
			?>
              </select></td>
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
            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Impuestos </span></td>
            <td>&nbsp;</td>
          </tr>
          

          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Impuesto General a las Ventas:<br />
              (%)</td>
            <td align="left" valign="top">
              
              
              <input class="EstFormularioCaja" name="CmpImpuestoVenta" type="text" id="CmpImpuestoVenta" size="10" maxlength="10" value="<?php if(empty($InsConfiguracion->EmpresaImpuestoVenta)){ echo "0.00";}else{ echo $InsConfiguracion->EmpresaImpuestoVenta;}?>" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Impuesto Selectivo al Consumo:<br />
              (%)</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpImpuestoSelectivo" type="text" id="CmpImpuestoSelectivo" size="10" maxlength="10" value="<?php  echo number_format($InsConfiguracionEmpresa->CemImpuestoSelectivo,2);?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Impuesto a la Renta:<br />
              (%)</td>
            <td align="left" valign="top">
              
              
              <input class="EstFormularioCaja" name="CmpImpuestoRenta" type="text" id="CmpImpuestoRenta" size="10" maxlength="10" value="<?php if(empty($InsConfiguracion->EmpresaImpuestoRenta)){ echo "0.00";}else{ echo $InsConfiguracion->EmpresaImpuestoRenta;}  ?>" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
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
            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Margenes </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Porcentaje Utilidad:<br />
              (%)</td>
            <td align="left" valign="top"><span id="sprytextfield2">
              
              <input name="CmpRepuestoMargenUtilidad" type="text" class="EstFormularioCaja" id="CmpRepuestoMargenUtilidad" value="<?php  echo number_format($InsConfiguracionEmpresa->CemRepuestoMargenUtilidad,2);?>" size="10" maxlength="10" readonly="readonly" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Porcentaje Otros Costos (Flete):<br />
              (%)</td>
            <td align="left" valign="top"><span id="sprytextfield3">
              
              <input  name="CmpRepuestoFlete" type="text" class="EstFormularioCaja" id="CmpRepuestoFlete" value="<?php  echo number_format($InsConfiguracionEmpresa->CemRepuestoFlete,2); ?>" size="10" maxlength="10" readonly="readonly" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Porcentaje de Mano de Obra:<br />(%)</td>
            <td><input name="CmpMantenimientoPorcentajeManoObra" type="text" class="EstFormularioCaja" id="CmpMantenimientoPorcentajeManoObra" value="<?php  echo number_format($InsConfiguracionEmpresa->CemMantenimientoPorcentajeManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
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

