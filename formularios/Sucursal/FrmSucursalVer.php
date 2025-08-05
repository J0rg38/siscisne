<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjSucursal.php');
//CLASES
require_once($InsPoo->MtdPaqSucursal().'ClsSucursal.php');
//INSTANCIAS
$InsSucursal = new ClsSucursal();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccSucursalEditar.php');
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsSucursal->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        SUCURSAL</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
                                       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsSucursal->SucTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsSucursal->SucTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div> <br />
        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td><span class="EstFormularioSubTitulo">
              <input type="hidden" name="Guardar" id="Guardar"   />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
            </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsSucursal->SucId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><input value="<?php echo $InsSucursal->SucNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Etiqueta:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpEtiqueta" type="text" id="CmpEtiqueta" value="<?php echo $InsSucursal->SucEtiqueta;?>" size="40" maxlength="250" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Abreviatura:</td>
            <td align="left" valign="top"><input   name="CmpSigla" type="text" class="EstFormularioCaja" id="CmpSigla" value="<?php echo $InsSucursal->SucSigla;?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direccion:</td>
            <td align="left" valign="top"><input  name="CmpDireccion" type="text"  class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsSucursal->SucDireccion;?>" size="40" maxlength="200" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Distrito:</td>
            <td align="left" valign="top"><input  name="CmpDistrito" type="text"  class="EstFormularioCaja" id="CmpDistrito" value="<?php echo $InsSucursal->SucDistrito;?>" size="40" maxlength="200" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Provincia:</td>
            <td align="left" valign="top"><input  name="CmpProvincia" type="text"  class="EstFormularioCaja" id="CmpProvincia" value="<?php echo $InsSucursal->SucProvincia;?>" size="40" maxlength="200" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Departamento:</td>
            <td align="left" valign="top"><input  name="CmpDepartamento" type="text"  class="EstFormularioCaja" id="CmpDepartamento" value="<?php echo $InsSucursal->SucDepartamento;?>" size="40" maxlength="200" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Ubigeo:</td>
            <td align="left" valign="top"><input  name="CmpCodigoUbigeo" type="text"  class="EstFormularioCaja" id="CmpCodigoUbigeo" value="<?php echo $InsSucursal->SucCodigoUbigeo;?>" size="40" maxlength="200" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td><?php
			switch($InsSucursal->SucEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Si</option>
                <option <?php echo $OpcEstado2;?> value="2">No</option>
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

