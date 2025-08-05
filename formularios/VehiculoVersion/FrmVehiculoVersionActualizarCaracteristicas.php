<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionFunciones.js" ></script>

<?php
//VARIABLES
$Edito = false;
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
$GET_id = $_GET['Id'];
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

$InsVehiculoVersion->VveId = $GET_id;
$InsVehiculoVersion->MtdObtenerVehiculoVersion();		

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoVersionEditar.php');
//DATOS
$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];

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
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">ACTUALIZAR CARACTERISTICAS DE 
        VERSION DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
                                      
        
        <div class="EstFormularioArea"></div>
          <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="136">&nbsp;</td>
            <td width="695">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
			
			<?php
            $AnoEscogido = false;
            $AnoSeleccionado = "";
             
            for($ano=2013;$ano<=date("Y");$ano++){
            ?>
            
                <?php
                if(!empty($InsVehiculoVersion->VehiculoVersionCaracteristica)){	
                    foreach($InsVehiculoVersion->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){
                ?>
                
                        <?php		
                        if($DatVehiculoVersionCaracteristica->VvcAnoModelo == $ano){
                        ?>
                            <?php
                            if(!empty($DatVehiculoVersionCaracteristica->VvcId)){
                                $AnoEscogido = false;
                                $AnoSeleccionado = $ano;
                                break;
							}
                            ?>
						<?php                    
						} 
						?>
                
                <?php		
                    }
                }
                ?>
            
            <?php
            }
            ?>
            
            
			<?php
			if($AnoSeleccionado==date("Y")){
			?>
            
	           Caracteristicas de vehiculos ya se encuentran actualizados
            
            <?php		
			}else{
			?>
            
				<?php
				if(!empty($InsVehiculoVersion->VehiculoVersionCaracteristica)){	
					foreach($InsVehiculoVersion->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){
				?>
                
                		<?php	
						if($DatVehiculoVersionCaracteristica->VvcAnoModelo == $AnoSeleccionado){
    					?>
							<?php
							$InsVehiculoCaracteristica = new ClsVehiculoVersionCaracteristica();
							//MtdObtenerVehiculoVersionCaracteristicas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VvcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oAnoModelo=NULL) {
							$ResVehiculoCaracteristica = $InsVehiculoCaracteristica->MtdObtenerVehiculoVersionCaracteristicas("VvcDescripcion",$DatVehiculoVersionCaracteristica->VvcDescripcion,'VvcId','ASC','1',$DatVehiculoVersionCaracteristica->VveId,$DatVehiculoVersionCaracteristica->VvcAnoModelo);
							$ArrVehiculoCaracteristicas = $ResVehiculoCaracteristica['Datos'];
							
							if(empty($ArrVehiculoCaracteristicas)){
								
								$InsVehiculoCaracteristica = new ClsVehiculoVersionCaracteristica();
								$InsVehiculoCaracteristica->VveId = $DatVehiculoVersionCaracteristica->VveId;
								$InsVehiculoCaracteristica->VcsId = $DatVehiculoVersionCaracteristica->VcsId;
								$InsVehiculoCaracteristica->VvcAnoModelo = $DatVehiculoVersionCaracteristica->VvcAnoModelo;
								$InsVehiculoCaracteristica->VvcDescripcion = $DatVehiculoVersionCaracteristica->VvcDescripcion;
								$InsVehiculoCaracteristica->VvcValor = $DatVehiculoVersionCaracteristica->VvcValor;
								$InsVehiculoCaracteristica->VvcTiempoCreacion = date("Y-m-d H:i:s");
								$InsVehiculoCaracteristica->VvcTiempoModificacion = date("Y-m-d H:i:s");
								
								if($InsVehiculoCaracteristica->MtdRegistrarVehiculoVersionCaracteristica()){
														
								}
								
							}
							?>
                            
                		<?php                    
                        } 
						?>
                
				<?php		
					}
				}
				?>
            
            <?php	
			}
			?>
            
            
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


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

