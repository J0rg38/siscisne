<?php
session_start();
$enlace = mysql_connect("localhost:3306","admsistema","fabrica");

mysql_select_db("wwwrjlal_sisca",$enlace);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width"/>
 
<title>EDITAR</title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="../../estilos/CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="../../estilos/CssGeneral.css">
<link rel="stylesheet" type="text/css" href="../../estilos/CssReporte.css">

<!--
Nombre: JQUERY
Descripcion: 
-->
<script type="text/javascript" src="../../librerias/jquery-1.7.2.min.js"></script>

<!--
Funciones Generales
-->
<script type="text/javascript" src="../../funciones/FncGeneral.js"></script>
<script type="text/javascript" src="js/JsLeerCodigoBarra.js"></script>

<!--
Nombre: NUPLOAD
Descripcion: 
-->
<link href="../../librerias/nupload/uploadfile.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../librerias/nupload/jquery.form.js"></script>
<script type="text/javascript" src="../../librerias/nupload/jquery.uploadfile.min.js"></script>



</head>
<body >

<script type="text/javascript">

$(function(){

	$("#CmpCantidad").select();
	
	$("#BtnGuardar").click(function(){
		$("#Form1").submit();
	});
	
	$("#BtnCerrar").click(function(){
		 window.location = "LeerCodigoBarra.php";
	});
	
	FncProductoFotoSoloListar();
});
	
var ProductoFotoSoloEditar = 1;
var ProductoFotoSoloEliminar = 1;

</script>

<?php
$GET_id = $_GET['id'];

//echo "id: ".$GET_id;
//echo "<br>";
$_SESSION['SesProFotoSolo'] = "";

$sql = "
SELECT 
* 
FROM inventario
WHERE id = '".$GET_id."';";
//echo $sql;

$query =  mysql_query($sql,$enlace);


	echo mysql_error($enlace);		
	echo "<br>";
	
$id = "";
$cantidad = "";
$nombre = "";
$ubicacion = "";
$observacion = "";
$foto = "";

while($datos = mysql_fetch_array($query)){
		
	$id = $datos['id'];
	$codigo = $datos['codigo'];
	$cantidad = $datos['cantidad'];
	$nombre = $datos['nombre'];
	$observacion = $datos['observacion'];
	$ubicacion = $datos['ubicacion'];
	$foto = $datos['foto'];
	
}


$_SESSION['SesProFotoSolo'] = $foto;


?>

    
            <hr>
            
  <form id="Form1" action="acc_editar.php" method="POST"  >
  <!--
	Usuario:  <input type="text" name="CmpUsuario" id="CmpUsuario" value="<?php echo $GET_Usuario;?>" /><br />
      --> 
Id: 
<input type="text" name="CmpId" id="CmpId" value="<?php echo $id;?>" />	  <br>

Codigo: <input type="text" name="CmpCodigo" id="CmpCodigo" value="<?php echo $codigo;?>" /><br />
Nombre: <input type="text" name="CmpNombre" id="CmpNombre" value="<?php echo $nombre?>" /><br />
Ubicacion: <input type="text" name="CmpUbicacion" id="CmpUbicacion" value="<?php echo $ubicacion?>" /><br />
Cantidad:  <input type="text" name="CmpCantidad" id="CmpCantidad" value="<?php echo $cantidad?>" /><br />
Observaciones:  
<textarea name="CmpObservacion" cols="30" rows="2" id="CmpObservacion"><?php echo $observacion?></textarea>
<br />



               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncProductoFotoSoloListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncProductoFotoSoloEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapProductoFotoSolosAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadProductoFotoSolo">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
											
											var acodigo = $("#CmpCodigo").val();
											
											$("#fileUploadProductoFotoSolo").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"acc/AccProductoSubirFotoSolo.php",
											formData: {"Identificador":"<?php echo $Identificador;?>","codigo":acodigo},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												alert("La foto subio correctamente");
												FncProductoFotoSoloListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapProductoFotoSolos" id="CapProductoFotoSolos"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapProductoFotoSolosResultado"> </div></td>
             </tr>
             </table>
            
             
                 
  <input type="button"  name="BtnGuardar" id="BtnGuardar" value="Guardar" />
  <input type="button"  name="BtnCerrar" id="BtnCerrar" value="Cerrar" />
  
  </form>
            
            
            
            
    </td>
    </tr>
    </table>



</body>
</html>


