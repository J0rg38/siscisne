<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];

$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];


session_start();
if (!isset($_SESSION['InsVehiculoRecepcionDetalle'.$Identificador])){
	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = new ClsSesionObjeto();	
}

$RepSesionObjetos = $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrVehiculoRecepcionDetalles = $RepSesionObjetos['Datos'];

?>
<!--<style type="text/css">

table#miyazaki { 
  margin: 0 auto;
  border-collapse: collapse;
  font-family: Agenda-Light, sans-serif;
  font-weight: 100; 
  background: #333; color: #fff;
  text-rendering: optimizeLegibility;
  border-radius: 5px; 
}
table#miyazaki caption { 
  font-size: 2rem; color: #444;
  margin: 1rem;
  background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/4273/miyazaki.png), url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/4273/miyazaki2.png);
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center left, center right; 
}
table#miyazaki thead th { font-weight: 600; }
table#miyazaki thead th, table#miyazaki tbody td { 
  padding: .8rem; font-size: 1.4rem;
}
table#miyazaki tbody td { 
  padding: .8rem; font-size: 1.4rem;
  color: #444; background: #eee; 
}
table#miyazaki tbody tr:not(:last-child) { 
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;  
}

@media screen and (max-width: 600px) {
  table#miyazaki caption { background-image: none; }
  table#miyazaki thead { display: none; }
  table#miyazaki tbody td { 
    display: block; padding: .6rem; 
  }
  table#miyazaki tbody tr td:first-child { 
    background: #666; color: #fff; 
  }
	table#miyazaki tbody td:before { 
    content: attr(data-th); 
    font-weight: bold;
    display: inline-block;
    width: 6rem;  
  }
}


</style>

<table id="miyazaki">
<caption>The Films of Hayao Miyazaki</caption>
<thead>
<tr><th>Film<th>Year<th>Honor
<tbody>
<tr>
<td>My Neighbor Totoro
<td>1988
<td>Blue Ribbon Award (Special)
<tr>
<td>Princess Mononoke
<td>1997
<td>Nebula Award (Best Script)
<tr>
<td>Spirited Away
<td>2001
<td>Academy Award (Best Animated Feature)
<tr>
<td>Howl's Moving Castle
<td>2004
<td>Hollywood Film Festival (Animation OTY)
</table>-->

<style type="text/css">
/*
#container {
    display: table;
    }

  #row  {
    display: table-row;
    }

  #left, #right, #middle {
    display: table-cell;
    }
	*/
</style>
<!--
<div class="EstNTablaListado">


	<div class="EstNTablaListadoFila">
    
        <div class="EstNTablaListadoCabecera">#</div>        
        <div class="EstNTablaListadoCabecera">Id</div>        
        <div class="EstNTablaListadoCabecera">Zona Comprometida</div>
        <div class="EstNTablaListadoCabecera">Repuesto Detalle</div>
        <div class="EstNTablaListadoCabecera">Solucion</div>
        <div class="EstNTablaListadoCabecera">Observacion</div>
        <div class="EstNTablaListadoCabecera">Cargar Fotos</div>
        <div class="EstNTablaListadoCabecera">Fotos</div>
        <div class="EstNTablaListadoCabecera">Acc.</div>
           
    </div>
    
	<?php
    
//						SesionObjeto-VehiculoRecepcionDetalle
//						Parametro1 = VrdId
//						Parametro2 = VreId
//						Parametro3 = VrdZonaComprometida
//						Parametro4 = VrdRepuestoDetalle
//						Parametro5 = VrdSolucion
//						Parametro6 = VrdObservacion
//						Parametro7 = VrdTiempoCreacion
//						Parametro8 = VrdTiempoModificacion
//						Parametro9 = VrdEstado
    $c = 1;
    foreach($ArrVehiculoRecepcionDetalles as $DatVehiculoRecepcionDetalle){
    ?>
    <div class="EstNTablaListadoFila">
    
        <div class="EstNTablaListadoColumna">
        
                <span title="<?php echo $DatVehiculoRecepcionDetalle->Parametro1;?>">
                <?php echo $c;?>
                </span>
                
        </div>
        
        <div class="EstNTablaListadoColumna">
			<?php echo $DatVehiculoRecepcionDetalle->Parametro1;?>
        </div>
        
        <div class="EstNTablaListadoColumna">
            <?php echo $DatVehiculoRecepcionDetalle->Parametro3;?>
        </div>
        
          
        <div class="EstNTablaListadoColumna">
            <?php echo $DatVehiculoRecepcionDetalle->Parametro4;?>
        </div>
        
          
        <div class="EstNTablaListadoColumna">
            <?php echo $DatVehiculoRecepcionDetalle->Parametro5;?>
        </div>
        
          
        <div class="EstNTablaListadoColumna">
            <?php echo $DatVehiculoRecepcionDetalle->Parametro6;?>
        </div>
        
           
        <div class="EstNTablaListadoColumna">
                   
			<div id="fileuploader<?php echo $DatVehiculoRecepcionDetalle->Item?>">Escoger Archivos</div>
                                    
                                    
                                    <script type="text/javascript">
		$(document).ready(function()
{
	$("#fileuploader<?php echo $DatVehiculoRecepcionDetalle->Item;?>").uploadFile({
		
	allowedTypes:"png,gif,jpg,jpeg",
	url:"formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleFotoSubirArchivo.php",
	formData: {"Identificador":"<?php echo $Identificador;?>","Item":"<?php echo $DatVehiculoRecepcionDetalle->Item;?>"},
	multiple:true,
	autoSubmit:true,
	dragDrop:false,
	fileName:"Filedata",
	showStatusAfterSuccess:false,
	

	abortStr:"Abortar",
	cancelStr:"Cancelar",
	doneStr:"Hecho",

	extErrorStr:"Extension de archivo no permitido",
	sizeErrorStr:"Tamaño no permitido",
	uploadErrorStr:"No se pudo subir el archivo",
	
	
	onSuccess:function(files,data,xhr){
		FncVehiculoRecepcionDetalleFotoListar('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');
	}
	
	});
});
              
            </script>
    
        </div>
        
        
        <div class="EstNTablaListadoColumna">
            
			<div  id="CapVehiculoRecepcionDetalleFotoAccion<?php echo $DatVehiculoRecepcionDetalle->Item;?>"></div>
			<div class="EstCapVehiculoRecepcionDetalleFotos" id="CapVehiculoRecepcionDetalleFotos<?php echo $DatVehiculoRecepcionDetalle->Item;?>"></div>    
                
        </div>
        
         
        <div class="EstNTablaListadoColumna">
            
			
		<?php
        if($POST_Editar==1){
        ?>
          <a class="EstSesionObjetosItem" href="javascript:FncVehiculoRecepcionDetalleEscoger('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          <?php
        }
        ?>
          <?php
        if($POST_Eliminar==1){
        ?>
          <a href="javascript:FncVehiculoRecepcionDetalleEliminar('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?>
                <input style="visibility:hidden;" type="checkbox" etiqueta="detalle" checked="checked"  disabled="disabled" name="CmpVehiculoRecepcionDetalle_<?php echo $DatVehiculoRecepcionDetalle->Item;?>" id="CmpVehiculoRecepcionDetalle_<?php echo $DatFichaAccionProducto->Item;?>" value="<?php echo $DatVehiculoRecepcionDetalle->Item;?>" />
        </div>
           
        
        
        
        
        
        

    </div>
    
    <?php
		$c++;
	}
	?>
</div>

-->
<!--<div class="table-responsive">
  <table class="table">
    ...
  </table>
</div-->
<!--<div class="table-responsive">
-->


<!--<table class="EstTablaListado" >
<thead class="EstTablaListadoHead">
<tr>
  <th>#</th>
  <th>Id</th>
  <th>Zona Comprometida</th>
  <th>Repuesto Detalle</th>
  <th> Solucion</th>
  <th>Observacion</th>
  <th>Cargar Fotos</th>
  <th>Fotos</th>
  <th> Acc.</th>
  <th>-</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">

<?php
if(!empty($ArrVehiculoRecepcionDetalles)){
?>
  <?php
  
//						SesionObjeto-VehiculoRecepcionDetalle
//						Parametro1 = VrdId
//						Parametro2 = VreId
//						Parametro3 = VrdZonaComprometida
//						Parametro4 = VrdRepuestoDetalle
//						Parametro5 = VrdSolucion
//						Parametro6 = VrdObservacion
//						Parametro7 = VrdTiempoCreacion
//						Parametro8 = VrdTiempoModificacion
//						Parametro9 = VrdEstado
  
  $c = 1;
  foreach($ArrVehiculoRecepcionDetalles as $DatVehiculoRecepcionDetalle){
  ?>

      <tr>
      <td align="right" data-label="#">
      
      <span title="<?php echo $DatVehiculoRecepcionDetalle->Parametro1;?>">
      <?php echo $c;?>
      </span>
      </td>
      <td align="right" data-label="Id"><?php echo $DatVehiculoRecepcionDetalle->Parametro1;?>
      
     
      
      </td>
      <td align="right" data-label="Zona Comprometida">
      
      <?php echo $DatVehiculoRecepcionDetalle->Parametro3;?>
      
      </td>
      <td align="right" data-label="Repuesto Detalle"><?php echo $DatVehiculoRecepcionDetalle->Parametro4;?></td>
      <td align="right" data-label="Solucion"><?php echo $DatVehiculoRecepcionDetalle->Parametro5;?></td>
      <td align="right" data-label="Observacion"><?php echo $DatVehiculoRecepcionDetalle->Parametro6;?></td>
      <td align="center" data-label="Cargar Fotos">
      
      
          <div id="fileuploader<?php echo $DatVehiculoRecepcionDetalle->Item?>">Escoger Archivos</div>
                                  
                                  
          <script type="text/javascript">
          
              $(document).ready(function()
              {
              $("#fileuploader<?php echo $DatVehiculoRecepcionDetalle->Item;?>").uploadFile({
              
              allowedTypes:"png,gif,jpg,jpeg",
              url:"formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleFotoSubirArchivo.php",
              formData: {"Identificador":"<?php echo $Identificador;?>","Item":"<?php echo $DatVehiculoRecepcionDetalle->Item;?>"},
              multiple:true,
              autoSubmit:true,
              dragDrop:false,
              fileName:"Filedata",
              showStatusAfterSuccess:false,
              
              
              abortStr:"Abortar",
              cancelStr:"Cancelar",
              doneStr:"Hecho",
              
              extErrorStr:"Extension de archivo no permitido",
              sizeErrorStr:"Tamaño no permitido",
              uploadErrorStr:"No se pudo subir el archivo",
              
              
              onSuccess:function(files,data,xhr){
              FncVehiculoRecepcionDetalleFotoListar('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');
              }
              
              });
              });
              
          </script>
                        
      </td>
      <td align="left" data-label="Fotos">
    
<div  id="CapVehiculoRecepcionDetalleFotoAccion<?php echo $DatVehiculoRecepcionDetalle->Item;?>"></div>
      
      <div class="EstCapVehiculoRecepcionDetalleFotos" id="CapVehiculoRecepcionDetalleFotos<?php echo $DatVehiculoRecepcionDetalle->Item;?>"></div>
      
      </td>
      <td align="center" data-label="Acc.">
      
      <?php
      if($POST_Editar==1){
      ?>
        <a class="EstSesionObjetosItem" href="javascript:FncVehiculoRecepcionDetalleEscoger('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
        <?php
      }
      ?>
        <?php
      if($POST_Eliminar==1){
      ?>
        <a href="javascript:FncVehiculoRecepcionDetalleEliminar('<?php echo $DatVehiculoRecepcionDetalle->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
        <?php
      }
      ?></td>
      <td align="right"  data-label="-"><input style="visibility:hidden;" type="checkbox" etiqueta="detalle" checked="checked"  disabled="disabled" name="CmpVehiculoRecepcionDetalle_<?php echo $DatVehiculoRecepcionDetalle->Item;?>" id="CmpVehiculoRecepcionDetalle_<?php echo $DatFichaAccionProducto->Item;?>" value="<?php echo $DatVehiculoRecepcionDetalle->Item;?>" /></td>
      </tr>

  <?php
      
  $c++;
  }
  ?>

<?php
}
?>


</tbody>
</table>-->

<!--</div>-->