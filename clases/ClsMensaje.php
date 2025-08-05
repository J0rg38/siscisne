<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSeguridad
 *
 * @author Ing. Jonathan Blanco Alave
 */
class ClsMensaje {
    //put your code here
	
	public $MenResultado;
	public $MenRedireccionar;
	
	  public function __construct(){
		
		$this->MenRedireccionar = true;
			
	}
	
	public function MtdImprimirResultado($oEstilo="Avanzado"){
	
		if(!empty($this->MenResultado)){
			
			
			if($oEstilo == "Normal"){
?>


<script type="text/javascript">
 var msj = '';;
<?php

	$a_errores = explode("#",$this->MenResultado);
	foreach($a_errores as $er){
		if(!empty($er)){
				
			if(substr($er,0,3)=="ERR"){
?>
				msj = msj + "<?php  eval("echo $er;");?> \n";
<?php
			}elseif(substr($er,0,3)=="SAS"){
?>
				msj = msj + "<?php  eval("echo $er;");?> \n";
<?php	
			}else{
?>
				msj = msj + "<?php  echo $er;?> \n";
<?php	
			}
?>
	
<?php		
		}
	}
?>

$(function(){
	alert(msj);
});
</script>
                    
                    
<?php			
			}else{
?>

					<script type="text/javascript">
                     var msj = '';;
                    <?php
                    
                        $a_errores = explode("#",$this->MenResultado);
						
						$mensaje = "";
                        foreach($a_errores as $er){
                    
					        if(!empty($er)){

                                if(substr($er,0,3)=="ERR" and !empty($er)){
                    ?>
                                    msj = msj + "<?php  eval("echo $er;");?> ";
                    <?php	
                                }elseif(substr($er,0,3)=="SAS" and !empty($er)){
                    ?>
                                    msj = msj + "<?php  eval("echo $er;");?> ";
                    <?php			
								 }else if( strlen($er)>0 ){
                    ?>
                                    msj = msj + "<?php  echo $er;?> ";
                    <?php	
                             	}

								$mensaje .= '';
                            }

                        }
                    ?>
                     
					//dhtmlx.message({ type:"info", text:"<?php echo $mensaje;?>", expire:-3 });
					//dhtmlx.message({ type:"info", text:""+msj+"", expire:-3 });
					
					dhtmlx.alert({
						
						title:"Aviso",
					 	//type:"alert-error",
						text:"<div class='EstMensajeAlerta'>"+msj+"</div>"
						
					});
					
					
					
					
					 
                    </script>


<?php	
			}
?>

<?php
		}
	
	
	}
	
	
	public function MtdRedireccionar($oUrl,$oRealizar=false,$oTiempo=2000,$oReproducirAudio=false){
		
		
		if($oRealizar){
			
			if($oReproducirAudio){
				$this->MtdReproducirAudio("guardar_si");
			}
			
?>
			<script type="text/javascript">
            
            $(function(){

            setTimeout(function(){ window.location = "<?php echo $oUrl;?>"; },<?php echo $oTiempo;?>);

            //$(location).attr('href','<?php echo $oUrl;?>'); 
            });
            
            
            </script>
<?php		
		}else{

			if($oReproducirAudio){
				$this->MtdReproducirAudio("guardar_no");
			}

		}
		
	}
	
	
	public function MtdReproducirAudio($oAudio){
		
		if(empty($oAudio)){
?>
			<script type="text/javascript">
            
            $(function(){
            	$.ionSound.play("<?php echo $oAudio;?>");
            });
            
            
            </script>
<?php
		}

	}
}
?>