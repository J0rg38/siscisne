<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Producto","Listado")){
?>


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
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
//INSTANCIAS
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
//ACCIONES

//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas($POST_cam,$POST_fil,$POST_ord,$POST_sen,$POST_pag);
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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE FAMILIAS DE MARCAS DE VEHICULO</span></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td width="82%" valign="top">
  
  
  
  
  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      
                    <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>
                  
                        <td align="left" valign="top">
                        
						<a href="principal.php?Mod=VehiculoMarca&Form=Ver&Id=<?php echo $DatVehiculoMarca->VmaId?>">
						<?php echo $DatVehiculoMarca->VmaNombre;?>   
						</a>
                            
                            
                            
                                         
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
                            $RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$DatVehiculoMarca->VmaId);
                            $ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
                            ?>
                            
                            
                
                            <?php
                            $i = 1;
                            foreach($ArrVehiculoModelos as $DatVehiculoModelo){
                            ?>
                            
                                
                            <a href="principal.php?Mod=VehiculoModelo&Form=Ver&Id=<?php echo $DatVehiculoModelo->VmoId?>">
                            <?php echo $DatVehiculoModelo->VmoNombre?>
                            </a>
                               
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
						if($DatProductoVehiculoVersion->VveId==$DatVehiculoVersion->VveId){
							$aux = 'checked="checked"';						
							break;
						}					
					}
				}				
				?>
                
                
                
&nbsp;&nbsp;&nbsp;::: 

                            <a href="principal.php?Mod=VehiculoVersion&Form=Ver&Id=<?php echo $DatVehiculoVersion->VveId?>">
                            <?php echo $DatVehiculoVersion->VveNombre?>
                            </a>
							
							
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

