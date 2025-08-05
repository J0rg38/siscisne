<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaDebitoTalonarioFunciones.js"></script>

<?php

$GET_id = $_GET['Id'];
$Registro = false;

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjNotaDebitoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();
$InsSucursal = new ClsSucursal();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaDebitoTalonarioEditar.php');

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>




<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        TALONARIO DE FACTURA</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaDebitoTalonario->NdtTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaDebitoTalonario->NdtTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input  readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsNotaDebitoTalonario->NdtId;?>" size="15" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Sucursal:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsNotaDebitoTalonario->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>N&uacute;mero:</td>
            <td><input class="EstFormularioCaja" name="CmpNumero" type="text" id="CmpNumero" value="<?php echo $InsNotaDebitoTalonario->NdtNumero;?>" size="10" maxlength="5" /></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Inicio:</td>
            <td><input class="EstFormularioCaja" name="CmpInicio" type="text" id="CmpInicio" value="<?php echo $InsNotaDebitoTalonario->NdtInicio;?>" size="20" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Descripcion:</td>
            <td><input class="EstFormularioCaja" name="CmpDescripcion" type="text" id="CmpDescripcion" value="<?php echo $InsNotaDebitoTalonario->NdtDescripcion;?>" size="45" /></td>
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

	
	
	
    

</form>
<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
?>

