<?php
require_once('../../../proyecto/ClsProyecto.php');
$InsProyecto->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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

$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_IncluyeSelectivo = $_POST['IncluyeSelectivo'];
$POST_PorcentajeImpuestoSelectivo = $_POST['PorcentajeImpuestoSelectivo'];

$POST_PorcentajeDescuento = 0;
$POST_Descuento = (empty($_POST['Descuento'])?0:$_POST['Descuento']);
$POST_Descuento = 0;

$POST_Gratuito = (empty($_POST['Gratuito'])?2:$_POST['Gratuito']);
$POST_Exonerado = (empty($_POST['Exonerado'])?2:$_POST['Exonerado']);

session_start();
if (!isset($_SESSION['InsNotaDebitoDetalle'.$Identificador])){
	$_SESSION['InsNotaDebitoDetalle'.$Identificador] = new ClsSesionObjeto();
}

/*
SesionObjeto-NotaDebitoDetalleListado
Parametro1 = NddId
Parametro2 = NddDescripcion
Parametro3 = 
Parametro4 = NddPrecio
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaId;
Parametro12 = NddTipo

Parametro13 = NddUnidadMedida
Parametro14 = AmdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = NddCodigo
Parametro19 = NddValorVenta
Parametro20 = NddImpuesto
Parametro21 = NddDescuentom
Parametro22 = NddGratuito
Parametro23 = NddExonerado	

Parametro24 = NddIncluyeImpuestoSelectivo
Parametro25 = NddImpuestoSelectivo
*/

$Cantidad = round($_POST['Cantidad'],2);
$Importe = round($_POST['Importe'],2);
$Precio = round(($Importe/$Cantidad),2);
$Descuento = 0;
$ImpuestoSelectivo = 0;

if($POST_IncluyeImpuesto=="1"){
	
	if($POST_Exonerado == "1"){		
	
		$ValorVenta = ($Importe);
		$Descuento = ($POST_Descuento);
		$ValorVenta = $ValorVenta - $Descuento;
		$Impuesto = 0;
		
		if($POST_IncluyeSelectivo=="1"){
			$ImpuestoSelectivo = $ValorVenta * ($POST_PorcentajeImpuestoSelectivo/100);
		}
		
	}else{
		
		if($POST_Gratuito=="1"){
		
			$ValorVenta = ($Importe);
			$Descuento = ($POST_Descuento);
			$ValorVenta = $ValorVenta - $Descuento;
			$Impuesto = 0;	

			if($POST_IncluyeSelectivo=="1"){
				$ImpuestoSelectivo = $ValorVenta * ($POST_PorcentajeImpuestoSelectivo/100);
			}	

		}else{		

			$ValorVenta = ($Importe/(($POST_PorcentajeImpuestoVenta/100)+1));
			$Descuento = ($POST_Descuento);
			$ValorVenta = $ValorVenta - $Descuento;
			$Impuesto = (($ValorVenta)*($POST_PorcentajeImpuestoVenta/100));
			
			if($POST_IncluyeSelectivo=="1"){
				$ImpuestoSelectivo = $ValorVenta * ($POST_PorcentajeImpuestoSelectivo/100);
			}
			
		}

	}

}else{
	
//	if($POST_Exonerado == "1"){//TAL CUAL		
//		$ValorVenta = ($Importe);
//		$Descuento = ($POST_Descuento);
//		$ValorVenta = $ValorVenta - $Descuento;
//		$Impuesto = 0;
//	}else{
//		if($POST_Gratuito==1){			
//			$ValorVenta = ($Importe);
//			$Descuento = ($POST_Descuento);
//			$ValorVenta = $ValorVenta - $Descuento;
//			$Impuesto = 0;
//		}else{			
//			$ValorVenta = ($Importe);
//			$Descuento = ($POST_Descuento);
//			$ValorVenta = $ValorVenta - $Descuento;
//			$Impuesto = ((($ValorVenta)*($POST_PorcentajeImpuestoVenta/100)));		
//		}
//	}
	
}
	
	
$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
addslashes($_POST['Descripcion']),
NULL,
$Precio,
$Cantidad,
$Importe,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),
NULL,
NULL,
NULL,
$_POST['NotaDebitoDetalleTipo'],
$_POST['UnidadMedida'],
NULL,
NULL,
NULL,
NULL,
$_POST['Codigo'],
$ValorVenta,
$Impuesto,
$Descuento,
$POST_Gratuito,
$POST_Exonerado,

$POST_IncluyeSelectivo,
$ImpuestoSelectivo
);

?>