<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoMarca.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
//INSTANCIAS
$InsVehiculoMarca = new ClsVehiculoMarca();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoMarcaEditar.php');
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


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
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        MARCA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
                                      
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoMarca->VmaTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoMarca->VmaTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div>
          <br />
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
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoMarca->VmaId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td>
              <span id="sprytextfield1">
                <label>
                  <input class="EstFormularioCaja"   name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsVehiculoMarca->VmaNombre;?>" size="40" maxlength="250" />
                  </label>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>            </td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Vigencia de Venta:</td>
            <td><?php
			switch($InsVehiculoMarca->VmaVigenciaVenta){
				case 1:
					$OpcVigenciaVenta1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcVigenciaVenta2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpVigenciaVenta" id="CmpVigenciaVenta">
                <option <?php echo $OpcVigenciaVenta1;?> value="1">Si</option>
                <option <?php echo $OpcVigenciaVenta2;?> value="2">No</option>
                </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Logo:</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><iframe src="formularios/VehiculoMarca/acc/AccVehiculoMarcaSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrVehiculoMarcaSubirArchivo" name="IfrVehiculoMarcaSubirArchivo" scrolling="Auto"  frameborder="0" width="100%" height="200"></iframe></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
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
//-->
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

