<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDepartamentoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsProvinciaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDistritoFunciones.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenFunciones.js" ></script>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacen.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
//INSTANCIAS
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenEditar.php');
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
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

	$("#CmpNumeroDocumento").focus();

	
	FncDepartamentosCargar()
	
});

/*
Configuracion Formulario
*/

</script>


<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsAlmacen->AlmId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        ALMACEN</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
                                       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacen->AlmTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacen->AlmTiempoModificacion;?></span></td>
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
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacen->AlmId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Sucursal:</td>
            <td><select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId?>" <?php if($InsAlmacen->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><input value="<?php echo $InsAlmacen->AlmNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Abreviatura:</td>
            <td align="left" valign="top"><input   name="CmpSigla" type="text" class="EstFormularioCaja" id="CmpSigla" value="<?php echo $InsAlmacen->AlmSigla;?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direccion:</td>
            <td align="left" valign="top"><input  name="CmpDireccion" type="text"  class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsAlmacen->AlmDireccion;?>" size="40" maxlength="200" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Departamento:</td>
            <td align="left" valign="top"><input name="CmpDepartamentoId" type="hidden"  id="CmpDepartamentoId" value="<?php echo $InsAlmacen->AlmDepartamento;?>" size="20" maxlength="10" readonly="readonly" />
              <select disabled="disabled" class="EstFormularioCombo" id="CmpDepartamento" name="CmpDepartamento">
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Provincia:</td>
            <td align="left" valign="top"><input name="CmpProvinciaId" type="hidden"  id="CmpProvinciaId" value="<?php echo $InsAlmacen->AlmProvincia;?>" size="20" maxlength="10" readonly="readonly" />
              <select disabled="disabled" class="EstFormularioCombo" id="CmpProvincia" name="CmpProvincia">
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Distrito:</td>
            <td align="left" valign="top"><input name="CmpDistritoId" type="hidden"  id="CmpDistritoId" value="<?php echo $InsAlmacen->AlmDistrito;?>" size="20" maxlength="10" readonly="readonly" />
              <select  disabled="disabled" class="EstFormularioCombo" id="CmpDistrito" name="CmpDistrito">
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Ubigeo:</td>
            <td align="left" valign="top"><input  name="CmpCodigoUbigeo" type="text"  class="EstFormularioCaja" id="CmpCodigoUbigeo" value="<?php echo $InsAlmacen->AlmCodigoUbigeo;?>" size="40" maxlength="200" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td><?php
			switch($InsAlmacen->AlmEstado){
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

