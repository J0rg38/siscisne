<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoCodigoReemplazoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProducto.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();
$InsUnidadMedida = new ClsUnidadMedida();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();

if (isset($_SESSION['InsProductoCodigoReemplazo'.$Identificador])){	
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsProductoCodigoReemplazo'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProductoEditar.php');

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];


$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


$ResAlmacenMovimientoDetalleEntrada = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','ASC',1,NULL,NULL,3,$InsProducto->ProId);
$ArrAlmacenMovimientoDetalleEntradas = $ResAlmacenMovimientoDetalleEntrada['Datos'];

?>

<script type="text/javascript">



$(document).ready(function (){
	
/*
CARGAS INICIALES
*/	

	FncEstablecerProductoUso();
	//FncEstablecerProductoTipoUnidadMedidaIngreso();
	FncEstablecerProductoTipoUnidadMedidaBase();
	//FncEstablecerProductoTipoUnidadMedidaSalida();
	
/*
AGREGANDO EVENTOS
*/

	$("select#CmpTipo").change(function(){
		//FncEstablecerProductoTipoUnidadMedidaIngreso();
		FncEstablecerProductoTipoUnidadMedidaBase();
		//FncEstablecerProductoTipoUnidadMedidaSalida();
	})

	//$("#CapProductoTipoUnidadMedidaIngresoNuevo").numeric();
	FncProductoCodigoReemplazoListar();
	
});

var ProductoTipoUnidadMedidaIngresoHabilitado = 2;
var ProductoTipoUnidadMedidaBaseHabilitado = 2;

var ProductoCodigoReemplazoEditar = 2;
var ProductoCodigoReemplazoEliminar = 2;

</script>

<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsProducto->ProId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
            
            
            
<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('formularios/Producto/FrmProductoCodigoBarra.php?o=1&t=40&r=1&text=<?php echo ($InsProducto->ProId);?>&f=2&a1=&a2=',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/codigo_barra.png" alt="[GCBarra]" title="Imprimir Codigo de Barras" />Cod. Barra</a></div>


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
        <td width="961" height="25"><span class="EstFormularioTitulo">VER PRODUCTO</span></td>
      </tr>
      <tr>
        <td>
        
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>
        
        
                                <br />



 		
<ul class="tabs">
    <li><a href="#tab1">Producto</a></li>
    <li><a href="#tab5">Unidades de Medida</a></li>
	<li><a href="#tab6">Uso</a></li>
    <li><a href="#tab2">Foto</a></li>
	<li><a href="#tab3">Especificaciones</a></li>
    <li><a href="#tab4">Historial Costos</a></li>
    <li><a href="#tab7">Cod. Reemplazos</a></li>
	
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

    
         <table border="0" cellpadding="2" cellspacing="2">
           <tr>
             <td valign="top">
             <div class="EstFormularioArea" >
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
			<span class="EstFormularioSubTitulo">
			Datos del Producto			
			<input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
			</span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsProducto->ProId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Original:</td>
            <td align="left" valign="top"><input  name="CmpCodigoOriginal" type="text"  class="EstFormularioCaja" id="CmpCodigoOriginal" value="<?php echo $InsProducto->ProCodigoOriginal;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Codigo Alternativo:</td>
            <td align="left" valign="top"><input  name="CmpCodigoAlternativo" type="text"  class="EstFormularioCaja" id="CmpCodigoAlternativo" value="<?php echo $InsProducto->ProCodigoAlternativo;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProducto->ProNombre;?>" size="40" maxlength="200" readonly="readonly"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo de Barras:</td>
            <td align="left" valign="top"><input  name="CmpCodigoBarra" type="text"  class="EstFormularioCaja" id="CmpCodigoBarra" value="<?php echo $InsProducto->ProCodigoBarra;?>" size="30" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Ubicacion:</td>
            <td align="left" valign="top"><input name="CmpUbicacion" type="text" class="EstFormularioCaja" id="CmpUbicacion" value="<?php echo $InsProducto->ProUbicacion;?>" size="40" maxlength="100" readonly="readonly"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Referencia:</td>
            <td align="left" valign="top"><textarea name="CmpReferencia" cols="40" readonly="readonly" class="EstFormularioCaja" id="CmpReferencia"><?php echo $InsProducto->ProReferencia;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo de Bien:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrProductoTipos as $DatProductoTipo){
			?>
              <option <?php echo $DatProductoTipo->RtiId;?> <?php echo ($DatProductoTipo->RtiId==$InsProducto->RtiId)?'selected="selected"':"";?> value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>
              <?php
			}
			?>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Stock Minimo:</td>
            <td align="left" valign="top"><input  name="CmpStockMinimo" type="text" class="EstFormularioCaja" id="CmpStockMinimo" value="<?php if(empty($InsProducto->ProStockMinimo)){ echo "0.00";}else{ echo $InsProducto->ProStockMinimo; }?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Costo (Ingreso):</td>
            <td align="left" valign="top"><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?>
              <input name="CmpCostoIngreso" type="text" class="EstFormularioCaja" id="CmpCostoIngreso" value="<?php if(empty($InsProducto->ProCostoIngreso)){ echo "0.00";}else{ echo $InsProducto->ProCostoIngreso; }?>" size="15" maxlength="10" readonly="readonly" />
            </span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Costo (Base):</td>
            <td align="left" valign="top"><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?>
              <input name="CmpCosto" type="text" class="EstFormularioCaja" id="CmpCosto" value="<?php if(empty($InsProducto->ProCosto)){ echo "0.00";}else{ echo $InsProducto->ProCosto; }?>" size="15" maxlength="10" readonly="readonly" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select  disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">STOCK VERIFICADO:</td>
            <td align="left" valign="top"><?php
			switch($InsProducto->ProStockVerificado){
				case 1:
					$OpcStockVerificado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcStockVerificado2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpStockVerificado" id="CmpStockVerificado" disabled="disabled">
                <option <?php echo $OpcStockVerificado1;?> value="1">Verificado</option>
                <option <?php echo $OpcStockVerificado2;?> value="2">No Verificado</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>
        </td>
           </tr>
		   
		   
		   </table>
		   

        
        
        
   	

           </div>
           
           
           
           
		<div id="tab5" class="tab_content">
        <!--Content-->
        
       <table border="0" cellpadding="2" cellspacing="2">
            <tr>
                <td colspan="2" valign="top">
                    <div class="EstFormularioArea" >

			<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
			<tr>
                <td>&nbsp;</td>
                <td colspan="3">
                  
                  <span class="EstFormularioSubTitulo">
                    Unidades de Medida
                    </span>			
                  
                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">Base (Kardex)</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">Ingreso</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">Salida</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
              
	<input type="hidden" name="CmpUnidadMedidaBaseAux" id="CmpUnidadMedidaBaseAux" value="<?php echo $InsProducto->UmeId;?>"	     />		    
			    
  <fieldset>
 
      <div id="CapProductoTipoUnidadMedidaBase"></div>
    
    
    
  </fieldset>
			    
			    </td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
	<input type="hidden" name="CmpUnidadMedidaIngresoAux" id="CmpUnidadMedidaIngresoAux" value="<?php echo $InsProducto->UmeIdIngreso;?>"	     />		    
  <fieldset>	    
   
      
<div id="CapProductoTipoUnidadMedidaIngreso"></div>
      
   
    
  </fieldset>   
			    </td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
              
              
               <fieldset>	    

      
    <div id="CapProductoTipoUnidadMedidaSalida"></div>
      

    
  </fieldset>         
  
              </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table>

                    </div>
                </td>
            </tr>
		</table>  
        
        </div>
        
            <div id="tab6" class="tab_content">
        <!--Content-->




<table border="0" cellpadding="2" cellspacing="2">
            <tr>
                <td colspan="2" valign="top">
                    <div class="EstFormularioArea" >

			<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
			<tr>
                <td>&nbsp;</td>
                <td>
                  
                  <span class="EstFormularioSubTitulo">
                    Uso</span>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td colspan="3" align="left" valign="top"><input disabled="disabled" type="checkbox" name="CmpValidarUso" id="CmpValidarUso" value="2" <?php echo (($InsProducto->ProValidarUso==2)?'checked="checked"':'');?>  /> Este producto puede ser utilizado por cualquier modelo y a&ntilde;o.			  </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="center" valign="top" bgcolor="#CCCCCC">
			  <div class="CapVehiculoUso">  
			  Marcas y Modelos
			  </div>
			  </td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top" bgcolor="#CCCCCC">
			  <div class="CapVehiculoUso">  
			  Años
			  </div>
			  </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
              
              
              <div class="CapVehiculoUso">  
              
				<table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      
                    <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>
                  
                        <td align="left" valign="top">
                            <?php echo $DatVehiculoMarca->VmaNombre;?>                        </td>
                        <td align="left" valign="top">&nbsp;</td>
                    <?php
                    }
                    ?>
                    </tr>
                  
                    <tr>
                     
                    <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>       
                    <td align="left" valign="top">
    
                        
                            <?php
                            $RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$DatVehiculoMarca->VmaId);
                            $ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
                            ?>
                            
                            
                
                            <?php
                            $i = 1;
                            foreach($ArrVehiculoModelos as $DatVehiculoModelo){
                            ?>
                            
                                
                                <input disabled="disabled" type="checkbox" name="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" id="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" value="<?php echo $DatVehiculoModelo->VmoId?>" /> <?php echo $DatVehiculoModelo->VmoNombre?> 
                               
                                <br />
                         
                         
<?php
$ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,NULL,$DatVehiculoModelo->VmoId);
$ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];
?>
                         
                         
<?php
foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
?>


                <?php
			  	if(is_array($InsProducto->ProductoVehiculoVersion)){	
					foreach($InsProducto->ProductoVehiculoVersion as $DatProductoVehiculoVersion ){
						$aux = '';
						$PvvId = "";
						if($DatProductoVehiculoVersion->VveId==$DatVehiculoVersion->VveId){
							$aux = 'checked="checked"';
							$PvvId = $DatProductoVehiculoVersion->PvvId;						
							break;
						}					
					}
				}				
				?>

                
&nbsp;&nbsp;&nbsp;::: <input disabled="disabled"  <?php echo $aux;?> type="checkbox" name="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" id="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" value="<?php echo $DatVehiculoVersion->VveId?>" />



<input type="hidden" name="CmpProductoVehiculoVersion_<?php echo $DatVehiculoVersion->VveId;?>" id="CmpProductoVehiculoVersion_<?php echo $DatVehiculoVersion->VveId;?>" value="<?php echo $PvvId;?>" /><?php echo $DatVehiculoVersion->VveNombre?>
<br />
<?php	
}
?>
                         <br />
                            <?php
                            $i++;
                            }
                            ?>                    </td>
                     <td align="left" valign="top">&nbsp;</td>
                    <?php
                    }
                    ?>
                    </tr>
				</table>       
				
				</div>
				       </td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
              
			  <div class="CapVehiculoUso">  
			  
			<table border="0" cellpadding="0" cellspacing="0">
            
			<?php
			for($i=date("Y")-25;$i<=(date("Y"));$i++){
			?>
			<tr>
				<td>
                
                
                <?php
			  	if(is_array($InsProducto->ProductoAno)){	
					foreach($InsProducto->ProductoAno as $DatProductoAno ){
						$aux = '';
						$PanId = "";
						if($DatProductoAno->PanAno==$i){
							$aux = 'checked="checked"';		
							$PanId = $DatProductoAno->PanId;					
							break;
						}					
					}
				}				
				?>
                
                
				<input disabled="disabled" <?php echo $aux;?> type="checkbox" name="CmpAno_<?php echo $i;?>" id="CmpAno_<?php echo $i;?>" value="<?php echo $i;?>" />
                
				<input type="hidden" name="CmpProductoAno_<?php echo $i;?>" id="CmpProductoAno_<?php echo $i;?>" value="<?php echo $PanId;?>" />				<?php echo $i;?>				</td>
			</tr>

			<?php
			}			  
			?>
			</table> 
			
			</div>
			             </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table>

                    </div>
                </td>
            </tr>
		</table>

	</div>    
        
	   
	   <div id="tab2" class="tab_content">    
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
	<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="2%">&nbsp;</td>
               <td width="97%"><span class="EstFormularioSubTitulo">Foto de Referencia del Producto</span></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td>
			   
			                  <?php              
              
if(!empty($_SESSION['SesProFoto'.$Identificador])){

	$extension = strtolower(pathinfo($_SESSION['SesProFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesProFoto'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

	<img  src="subidos/producto_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />

<?php	
}else{
?>
No hay FOTO
<?php	
}
?>
			   
			   </td>
               <td>&nbsp;</td>
             </tr>           
             </table>
    
		</div>
	
    </td>
    </tr>
    </table>	
	   
	       </div>   
        
		

	   <div id="tab3" class="tab_content">    
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
	<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="2%">&nbsp;</td>
               <td width="97%"><span class="EstFormularioSubTitulo">Archivo de Especificaciones del Producto</span></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td>
			   
			                  <?php              
              
if(!empty($_SESSION['SesProEspecificacion'.$Identificador])){

	$extension = strtolower(pathinfo($_SESSION['SesProEspecificacion'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesProEspecificacion'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

<a target="_blank" href="subidos/producto_especificaciones/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>


<?php	
}else{
?>
No hay archivo de ESPECIFICACION
<?php	
}
?>
			   
			   </td>
               <td>&nbsp;</td>
             </tr>           
             </table>
    
		</div>
	
    </td>
    </tr>
    </table>	
	   
	       </div>   
           
 	   <div id="tab4" class="tab_content">    
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
	<td width="97%" valign="top">
        
        <div class="EstFormularioArea">    
        
        
        <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="1%" rowspan="2" align="center">#</th>
  <th width="5%" rowspan="2" align="center">Movimiento</th>
  <th width="3%" rowspan="2" align="center">Fecha</th>
  <th width="1%" rowspan="2" align="center">Id</th>
  <th width="13%" rowspan="2" align="center"> Nombre</th>
  <th width="2%" rowspan="2" align="center">Cant.</th>
  <th width="3%" rowspan="2" align="center">Unidad.</th>
  <th width="3%" rowspan="2" align="center">
    
    Valor Unitario</th>
  <th width="3%" rowspan="2" align="center">Valor Total</th>
  <th colspan="12" align="center">Otros Costos Vinculados</th>
  <th width="2%" rowspan="2" align="center">Total Costo</th>
  <th width="3%" rowspan="2" align="center">Costo Unitario</th>
  <th width="4%" rowspan="2" align="center">Costo Anterior </th>
  <th width="4%" rowspan="2" align="center">Costo Promedio</th>
  </tr>
<tr>
  <th width="4%" align="center">Recargo</th>
<th width="4%" align="center">Flete</th>
<th width="5%" align="center">Otro Costo</th>
<th width="4%" align="center"><span >Aduana Inter.</span></th>
<th width="4%" align="center"><span >Transp.</span></th>
<th width="5%" align="center"><span >Desest.</span></th>
<th width="5%" align="center"><span >Almac.</span></th>
<th width="5%" align="center"><span >Ad Valorem</span></th>
<th width="5%" align="center"><span >Aduana Nac.</span></th>
<th width="5%" align="center"><span >Gastos Admin.</span></th>
<th width="4%" align="center"><span >Otros Costos 1</span></th>
<th width="3%" align="center"><span >Otros Costos 2</span></th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$SumaTotalCosto = 0;
$PrimeraVez = true;
foreach($ArrAlmacenMovimientoDetalleEntradas as $DatAlmacenMovimientoDetalle){
	$SumaValorTotal += $DatAlmacenMovimientoDetalle->AmoSubTotal;
	
?>
<tr>
  <td align="right"><?php echo $c;?></td>
  <td align="right">
  
  <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoDetalle->AmoId;?>">
  <?php echo $DatAlmacenMovimientoDetalle->AmoId;?>
  </a>                
  
  
  
  
  </td>
  <td align="right"><?php echo $DatAlmacenMovimientoDetalle->AmoFecha;?></td>
  <td align="right"><?php echo $DatAlmacenMovimientoDetalle->ProId;?></td>
  <td align="right">
  <?php echo $DatAlmacenMovimientoDetalle->ProNombre;?></td>
  <td align="right">
  <?php echo number_format($DatAlmacenMovimientoDetalle->AmdCantidad,2);?>
  </td>
  <td align="right">
  <?php echo $DatAlmacenMovimientoDetalle->UmeNombre;?>
  </td>
  <td align="right"> 
  <?php echo number_format(($DatAlmacenMovimientoDetalle->AmdCosto),2);?>
  </td>
  <td align="right">
  <?php echo number_format($DatAlmacenMovimientoDetalle->AmdImporte,2);?>
  </td>
  <td align="right" bgcolor="#FF0000"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdNacionalTotalRecargo,2);?></td>
  <td align="right" bgcolor="#FF0000"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdNacionalTotalFlete,2);?></td>
  <td align="right" bgcolor="#FF0000"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdNacionalTotalOtroCosto,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduana,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalTransporte,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalDesestiba,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAlmacenaje,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAdValorem,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduanaNacional,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalGastoAdministrativo,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto1,2);?></td>
  <td align="right" bgcolor="#00FF00"><?php echo number_format($DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto2,2);?></td>
  <td align="right">
	<?php 
	$TotalCosto = $DatAlmacenMovimientoDetalle->AmdNacionalTotalRecargo + $DatAlmacenMovimientoDetalle->AmdNacionalTotalFlete + $DatAlmacenMovimientoDetalle->AmdNacionalTotalOtroCosto + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduana + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalTransporte + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalDesestiba + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAlmacenaje + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAdValorem + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalAduanaNacional + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalGastoAdministrativo + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto1 + $DatAlmacenMovimientoDetalle->AmdInternacionalTotalOtroCosto2+   $DatAlmacenMovimientoDetalle->AmdImporte;
	$SumaTotalCosto += round($TotalCosto,2);
	?>
    
    <?php echo number_format($TotalCosto,2);?>
  </td>
  <td align="right">
  <?php $CostoUnitario = round($TotalCosto /$DatAlmacenMovimientoDetalle->AmdCantidad,2);?>
  <?php echo number_format($CostoUnitario,2);?>
  </td>
  <td align="right" bgcolor="#9D9DBD">

<?php
	if($PrimeraVez){
?>
	0.00
<?php
	}else{
		 echo number_format($CostoPromedioAnterior,2);
	}
?>
	<?php ?>
    
  </td>
  <td align="right">
   
    <?php
	if($PrimeraVez){
		$CostoPromedio = round($CostoUnitario,2);
	}else{
		$CostoPromedio = round(($CostoUnitario + $CostoPromedioAnterior)/2,2);
	}

	$CostoPromedioAnterior = $CostoPromedio;
	?>

    <?php echo number_format($CostoPromedio,2);?>
  </td>
</tr>

<?php
	$PrimeraVez = false;
$c++;
}
?>



</tbody>
</table>
        
              
      </div>
	
    </td>
    </tr>
    </table>	
	   
	       </div>      
           
           
           
             <div id="tab7" class="tab_content">    
	   			<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="98%"><span class="EstFormularioSubTitulo">Codigos de Reemplazo</span></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div class="EstFormularioArea" >
                 <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="49%"><div class="EstFormularioAccion" id="CapProductoCodigoReemplazoAccion">Listo
                       para registrar elementos </div></td>
                     <td width="49%" align="right"><a href="javascript:FncProductoCodigoReemplazoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncProductoCodigoReemplazoEliminarTodo();"></a></td>
                     <td width="1%"><div id="CapProductoCodigoReemplazosResultado"> </div></td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><div id="CapProductoCodigoReemplazos" class="EstCapProductoCodigoReemplazos" ></div></td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2">&nbsp;</td>
                     <td>&nbsp;</td>
                     </tr>
                   </table>
                 </div></td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td></td>
               <td>&nbsp;</td>
             </tr>           
             </table>
             
        
	
    
		</div>
	
        
    </td>
    </tr>
    </table>	
	   
	       </div> 
           
             
</div>      
               
             
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
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
