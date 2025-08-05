<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
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


<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoMarca->VmaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">VER
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
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoMarca->VmaId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><input value="<?php echo $InsVehiculoMarca->VmaNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
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
              <select disabled="disabled" class="EstFormularioCombo" name="CmpVigenciaVenta" id="CmpVigenciaVenta">
                <option <?php echo $OpcVigenciaVenta1;?> value="1">Si</option>
                <option <?php echo $OpcVigenciaVenta2;?> value="2">No</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Logo</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">		        <?php              
              
if(!empty($_SESSION['SesVmaFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesVmaFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesVmaFoto'.$Identificador], '.'.$extension);  
?>
		        
		       Archivo Adjunto:<br />
		       
    <a target="_blank" href="subidos/vehiculo_marca/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>
    
     
		       
		        <?php	
}else{
?>
		        No hay ARCHIVO ADJUNTO
		        <?php	
}
?></td>
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

