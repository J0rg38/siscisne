<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionFunciones.js" ></script>

<?php

$Registro = false;
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
$GET_VehiculoMarca = $_GET['VehiculoMarca'];
$GET_VehiculoModelo = $_GET['VehiculoModelo'];


//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoVersion.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

//INSTANCIAS
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoCaracteristica = new ClsVehiculoCaracteristica();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();

//ACCIONES
$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoVersionRegistrar.php');
//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript" >

var VehiculoModeloHabilitado = 1;
var VehiculoModeloId = "<?php echo $InsVehiculoVersion->VmoId;?>";

$().ready(function() {
	
	//FncVehiculoModelosCargar(VehiculoModeloHabilitado,$("#CmpVehiculoMarcaId").val(),$("#CmpVehiculoModeloId").val());
	FncVehiculoModelosCargar();

});

</script>


<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">


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
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        VERSION DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
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
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoVersion->VveId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Marca:</td>
            <td valign="top"><span id="spryselect1">
            
            <select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoVersion->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select>
            
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Modelo
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoVersion->VmoId;?>" size="3" />
              :</td>
            <td valign="top"><span id="spryselect2">


		<select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
              
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
		
        
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td>
              <span id="sprytextfield1">
                <label>
                  <input class="EstFormularioCaja"   name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsVehiculoVersion->VveNombre;?>" size="40" maxlength="250" />
                  </label>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>            </td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Vigencia de Venta:</td>
            <td><?php
			switch($InsVehiculoVersion->VveVigenciaVenta){
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
            <td>Foto:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><iframe src="formularios/VehiculoVersion/acc/AccVehiculoVersionSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrVehiculoMarcaSubirArchivo" name="IfrVehiculoMarcaSubirArchivo" scrolling="Auto"  frameborder="0" width="100%" height="200"></iframe></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>




<?php
for($ano=2013;$ano<=date("Y");$ano++){
?>


<tr>
           
            
                        <td>&nbsp;</td>
            <td colspan="2" bgcolor="#CCCCCC"> Caracteristicas/<?php echo $ano;?> </td>
            <td>&nbsp;</td>
            
          </tr>




<?php
if(!empty($ArrVehiculoCaracteristicaSecciones)){
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
	?>


		  <tr>
			<td>&nbsp;</td>
			<td colspan="2" class="EstFormularioResaltarSeccion"><?php echo $DatVehiculoCaracteristicaSeccion->VcsNombre?></td>
			<td>&nbsp;</td>
		  </tr>

	
			<?php
				if(!empty($InsVehiculoVersion->VehiculoVersionCaracteristica)){	
					foreach($InsVehiculoVersion->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){
			?>
            
			<?php		
						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId and $DatVehiculoVersionCaracteristica->VccAnoModelo == $ano){
					
			?>
            
		  <tr>
			<td>&nbsp;</td>
			<td><input name="CmpVehiculoVersionCaracteristicaDescripcion_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" type="text" class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristicaDescripcion_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" value="<?php echo stripslashes($DatVehiculoVersionCaracteristica->VvcDescripcion);?>" size="60" maxlength="255" /></td>
			<td><input type="hidden" name="CmpVehiculoVersionCaracteristicaId_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" id="CmpVehiculoVersionCaracteristicaId_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" value="<?php echo $VvcId?>" />
              <input type="hidden" name="CmpVehiculoVersionCaracteristicaSeccionId_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" id="CmpVehiculoVersionCaracteristicaSeccionId_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" value="<?php echo $DatVehiculoVersionCaracteristica->VcsId;?>" />
              <input name="CmpVehiculoVersionCaracteristicaValor_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" type="text" class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristicaValor_<?php echo $DatVehiculoVersionCaracteristica->VvcId?>" value="<?php echo stripslashes($DatVehiculoVersionCaracteristica->VvcValor);?>" size="40" maxlength="100" /></td>
			<td>&nbsp;</td>
		  </tr>
		  
            <?php
						}	
			?>
			
			<?php
					}
				}	
							
			?>


		      
	
	<?php
	}
}
?>

          <tr>
            <td>&nbsp;</td>
            <td colspan="2" align="center">---</td>
            <td>&nbsp;</td>
          </tr>
<?php
}
?>





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
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
//-->
</script>
<?php
}else{
	echo ERR_GEN_101;
}



if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
		
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

