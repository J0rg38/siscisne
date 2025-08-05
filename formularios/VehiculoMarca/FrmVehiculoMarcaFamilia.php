<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoFamilia.css');
</style>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */

//MESAJES

//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
//INSTANCIAS
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
//ACCIONES

//DATOS

//MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas($POST_cam,$POST_fil,$POST_ord,$POST_sen,$POST_pag,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
$VehiculoMarcasTotal = $RepVehiculoMarca['Total'];
$VehiculoMarcasTotalSeleccionado = $RepVehiculoMarca['TotalSeleccionado'];
//ALERTAS


/*
 * interface FrmVehiculoMarcaListado {
    //put your code here  
}
*/

?>



<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">FAMILIAS DE MARCAS DE VEHICULOS - VENTA</span></td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
</tr>

<tr>
  <td width="82%" valign="top">
  
  
  
  
  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      
                    <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>
                  
                        <td align="left" valign="top">
                        
						<a class="EstVehiculoFamiliaMarca" href="principal.php?Mod=VehiculoMarca&Form=Ver&Id=<?php echo $DatVehiculoMarca->VmaId?>">
						<?php echo $DatVehiculoMarca->VmaNombre;?>    
						</a>
                            
                            <?php echo (($DatVehiculoMarca->VmaEstado==2)?'[X]':'');?>
                            
                                         
                        </td>
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
							//MtdObtenerVehiculoModelos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
                            $RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoOrden","ASC",NULL,$DatVehiculoMarca->VmaId,1,NULL);
                            $ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
                            ?>
                            
                            
                
                            <?php
                            $i = 1;
                            foreach($ArrVehiculoModelos as $DatVehiculoModelo){
                            ?>
                            
                                
                            <a class="EstVehiculoFamiliaModelo" href="principal.php?Mod=VehiculoModelo&Form=Ver&Id=<?php echo $DatVehiculoModelo->VmoId?>">
                            <?php echo $DatVehiculoModelo->VmoNombre?> 
                            </a> 
                            
                            <?php
							
							if(!empty($DatVehiculoModelo->VmoNombreComercial)){
							?>
                            <span class="EstVehiculoFamiliaNombreComercial"> (<?php echo $DatVehiculoModelo->VmoNombreComercial?>)</span>
                            <?php
							}
							
							
							?>
                           
                          
                             <?php
							
							if($DatVehiculoModelo->VmoVigenciaVenta=="1"){
							?>
                            <img src="imagenes/estado/vigente_venta.jpg" alt="[V]" title="Vigente de Venta" border="0" width="20" height="20" align="absmiddle" >
                            <?php
							}else{
							?>
                             <img src="imagenes/estado/novigente_venta.jpg" alt="[V]" title="No Vigente de Venta" border="0" width="20" height="20"  align="absmiddle" >
                            <?php	
							}
							?> <?php
							
							if($DatVehiculoModelo->VmoPlanMantenimiento=="Si"){
							?>
                            <img src="imagenes/estado/plan_mantenimiento.png" alt="[P]" title="Tiene Plan Mant." border="0" width="20" height="20" align="absmiddle" >
                            <?php
							}else{
							?>
                            <!-- <img src="imagenes/estado/plan_mantenimiento.png" alt="[P]" title="No tiene Plan Mant." border="0" width="20" height="20" >-->
                            <?php	
							}
							?>
                            
                               <?php //echo (($DatVehiculoModelo->VmoVigenciaVenta==1)?'[V]':'');?>
                               
                               <?php //echo (($DatVehiculoModelo->VmoPlanMantenimiento=="Si")?'[P]':'');?>
                                <br />
                         
                         
<?php
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
$ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,NULL,$DatVehiculoModelo->VmoId,1,NULL);
$ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];
?>
                         
                         
<?php
foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
?>


                <?php
			  	if(is_array($InsProducto->ProductoVehiculoVersion)){	
					foreach($InsProducto->ProductoVehiculoVersion as $DatProductoVehiculoVersion ){
						$aux = '';
						if($DatProductoVehiculoVersion->VveId==$DatVehiculoVersion->VveId){
							$aux = 'checked="checked"';						
							break;
						}					
					}
				}				
				?>
                
&nbsp;&nbsp;&nbsp;:::

    
    <a class="EstVehiculoFamiliaVersion" href="principal.php?Mod=VehiculoVersion&Form=Ver&Id=<?php echo $DatVehiculoVersion->VveId?>">
    <?php echo $DatVehiculoVersion->VveNombre?> 
    </a>
    
	<?php echo (($DatVehiculoVersion->VveEstado==2)?'[X]':'');?>
    
    <?php
    if($DatVehiculoVersion->VveVigenciaVenta=="1"){
    ?>
		<img src="imagenes/estado/vigente_venta.jpg" alt="[V]" title="Vigente de Venta" border="0" width="20" height="20" align="absmiddle" >
    <?php
    }/*else{
    ?>
		<img src="imagenes/estado/novigente_venta.jpg" alt="[V]" title="No Vigente de Venta" border="0" width="20" height="20"  align="absmiddle" >
    <?php	
    }*/
    ?>
    
     <?php
    if(!empty($DatVehiculoVersion->VveFotoCaracteristica)){
    ?>
     <a  class="thickbox" href="subidos/vehiculo_version_fotos/<?php echo $DatVehiculoVersion->VveFotoCaracteristica;?>"  title="">
		<img src="imagenes/estado/vehiculo_caracteristicas.png" alt="[C]" title="Foto Caracteristicas" border="0" width="20" height="20" align="absmiddle" ></a>
        
    <?php
    }/*else{
    ?>
		<img src="imagenes/estado/novigente_venta.jpg" alt="[V]" title="No Vigente de Venta" border="0" width="20" height="20"  align="absmiddle" >
    <?php	
    }*/
    ?>
    
    
      <?php
    if(!empty($DatVehiculoVersion->VveFoto)){
    ?>  <a  class="thickbox" href="subidos/vehiculo_version_fotos/<?php echo $DatVehiculoVersion->VveFoto;?>"  title="">
		<img src="imagenes/estado/vehiculo_foto.png" alt="[F]" title="Foto Principal" border="0" width="20" height="20" align="absmiddle" >
        </a>
    <?php
    }/*else{
    ?>
		<img src="imagenes/estado/novigente_venta.jpg" alt="[V]" title="No Vigente de Venta" border="0" width="20" height="20"  align="absmiddle" >
    <?php	
    }*/
    ?>
							
<br />
<?php	
}
?>
                         <br />
                            <?php
                            $i++;
                            }
                            ?>
       
                            
                            
                    </td>
                     <td align="left" valign="top">&nbsp;</td>
                    <?php
                    }
                    ?>
                    </tr>
		</table>
                
                
  
  </td>
</tr><tr>
  <td align="left">
  
  <img src="imagenes/estado/vigente_venta.jpg" alt="[V]" title="Vigente de Venta" border="0" width="20" height="20" /  align="absmiddle">
  Modelo vigente de venta
  <img src="imagenes/estado/novigente_venta.jpg" alt="[V]" title="No Vigente de Venta" border="0" width="20" height="20" align="absmiddle" />
  Modelo fuera de venta
  <img src="imagenes/estado/plan_mantenimiento.png" alt="[P]" title="Tiene Plan Mant." border="0" width="20" height="20"  align="absmiddle" />
  
  Modelo con Plan de Mant.
  
  </td>
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

