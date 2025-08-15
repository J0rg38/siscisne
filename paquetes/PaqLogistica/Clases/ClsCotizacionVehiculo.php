<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionVehiculo {

    public $CveId;
	public $CveAno;
	public $CveMes;
	
	public $PerId;
	public $CliId;
	public $CveFecha;
	public $CveFechaVigencia;
	
	public $MonId;
	public $CveTipoCambio;
	
	public $CveIncluyeImpuesto;
	public $CvePorcentajeImpuestoVenta;
	
	public $CveAdicional;
    public $CveObservacion;
	public $CveNota;
	
	public $CveTelefono;
	public $CveCelular;
	public $CveDireccion;
	public $CveEmail;
	public $CveColor;
	
	public $VveId;
	public $EinId;

	public $CveSubTotal;
	public $CveImpuesto;
	public $CveTotal;
	
	public $CveCondicionVentaOtro;
	public $CveObsequioOtro;
	
	
	public $CveAnoFabricacion;
	public $CveAnoModelo;
	
	public $CveEstado;
	public $CveTiempoCreacion;
	public $CveTiempoModificacion;
    public $CveEliminado;
	
	public $CveDiaTranscurridos;

	public $TdoId;
	public $CliNombre;
	public $CliNumeroDocumento;
	public $TdoNombre;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $VtiNombre;
	
	public $MonSimbolo;
	public $MonNombre;
	
	public $VveFoto;
//	public $CotizacionVehiculoObsequio;

    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	public function MtdGenerarCotizacionVehiculoId() {
		
		

		$sql = 'SELECT	
		suc.SucSiglas AS SIGLA,
		MAX(CONVERT(SUBSTR(cve.CveId,17),unsigned)) AS "MAXIMO"
		FROM tblcvecotizacionvehiculo cve
			LEFT JOIN tblsucsucursal suc
			ON cve.SucId = suc.SucId
		WHERE cve.CveAno = '.$this->CveAno.'
		AND cve.CveMes = "'.$this->CveMes.'"
		AND cve.SucId = "'.$this->SucId.'"';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->CveId = "COT-VEH-".$this->CveAno."-".$this->CveMes."-10000-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);
		}else{
			$fila['MAXIMO']++;
			$this->CveId = "COT-VEH-".$this->CveAno."-".$this->CveMes."-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);			
		}

	}
		
    public function MtdObtenerCotizacionVehiculo($oCompleto=true){

        $sql = 'SELECT 
        cve.CveId,
		cve.SucId,
		
		cve.CveAno,
		cve.CveMes,
		
		cve.PerId,
		cve.PerIdReferente,
		
		cve.CliId,
		cve.NpaId,
		
		DATE_FORMAT(cve.CveFecha, "%d/%m/%Y") AS "NCveFecha",
		DATE_FORMAT(cve.CveHora, "%H:%i") AS "NCveHora",
		DATE_FORMAT(cve.CveFechaVigencia, "%d/%m/%Y") AS "NCveFechaVigencia",

		cve.MonId,
		cve.CveTipoCambio,
		
		cve.CveIncluyeImpuesto,
		cve.CvePorcentajeImpuestoVenta,
		
		cve.CveAdicional,
		cve.CveObservacion,
		cve.CveObservacionReporte,
		cve.CveNota,

		cve.CveTelefono,
		cve.CveCelular,
		cve.CveDireccion,
		cve.CveEmail,
		
		
		
		
		
		cve.VveId,
		cve.CveAnoModelo,
		cve.CveAnoFabricacion,
		cve.CveColor,
		cve.EinId,
		
		cve.CveCantidad,
		cve.CvePrecio,
		cve.CveDescuento,
		
		cve.CveSubTotal,
		cve.CveImpuesto,
		cve.CveTotal,
		
		(cve.CveTotal/cve.CveCantidad) AS CveTotalUnitario,

		cve.CveGLP,
		
		
		
		cve.VveId2,
		cve.CveAnoModelo2,
		cve.CveAnoFabricacion2,
		cve.CveColor2,
		cve.EinId2,
		
		cve.CveCantidad2,
		cve.CvePrecio2,
		cve.CveDescuento2,
		
		cve.CveSubTotal2,
		cve.CveImpuesto2,
		cve.CveTotal2,
		
		(cve.CveTotal2/cve.CveCantidad2) AS CveTotalUnitario2,
		
		cve.CveGLP2,
		
		
		
		
		
		cve.VveId3,
		cve.CveAnoModelo3,
		cve.CveAnoFabricacion3,
		cve.CveColor3,
		cve.EinId3,
		
		cve.CveCantidad3,
		cve.CvePrecio3,
		cve.CveDescuento3,
		
		cve.CveSubTotal3,
		cve.CveImpuesto3,
		cve.CveTotal3,
		
		(cve.CveTotal3/cve.CveCantidad3) AS CveTotalUnitario3,
		
		cve.CveGLP3,
		
		
		
		
		
		
		
		
		cve.CveCondicionVentaOtro,

		cve.CveObsequioOtro,
		
		cve.CveNivelInteres,
		cve.CveFoto,

		cve.CveCotizoOtroLugar,
		
		cve.CveStatus,
cve.CveEstado,
		DATE_FORMAT(cve.CveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCveTiempoCreacion",
        DATE_FORMAT(cve.CveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCveTiempoModificacion",

		cli.TdoId,
		CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		cli.CliNumeroDocumento,
		tdo.TdoNombre,
		cli.CliTelefono,
		cli.CliCelular,
		cli.CliEmail,
		cli.TrfId, 
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		vmo.VmaId,
		vma.VmaNombre,

		vve.VmoId,
		vmo.VmoNombre,
		
		vmo.VtiId,
		vti.VtiNombre,
		
		vve.VveNombre,
		
		vve.VveFoto,
		vve.VveFotoLateral,
		vve.VveFotoPosterior,
		vve.VveFotoCaracteristica,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		per.PerTelefono,
		per.PerCelular,
		per.PerEmail,
		per.PerFirma,
		
		per2.PerNombre AS PerNombreReferente,
		per2.PerApellidoPaterno AS PerApellidoPaternoReferente,
		per2.PerApellidoMaterno AS PerApellidoMaternoReferente,
		
		suc.SucSiglas
				
        FROM tblcvecotizacionvehiculo cve
			LEFT JOIN tblclicliente cli
			ON cve.CliId = cli.CliId
				LEFT JOIN tbltdotipodocumento tdo
				ON cli.TdoId = tdo.TdoId
					LEFT JOIN tblmonmoneda mon
					ON cve.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON cve.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									
									
							LEFT JOIN tblvvevehiculoversion vve2
							ON cve.VveId2 = vve2.VveId
							
								LEFT JOIN tblvmovehiculomodelo vmo2
								ON vve2.VmoId = vmo2.VmoId
								
							LEFT JOIN tblvtivehiculotipo vti2
							ON vmo2.VtiId = vti2.VtiId	
							
									LEFT JOIN tblvmavehiculomarca vma2
									ON vmo2.VmaId = vma2.VmaId
									
									
							LEFT JOIN tblvvevehiculoversion vve3
							ON cve.VveId3 = vve3.VveId
							
								LEFT JOIN tblvmovehiculomodelo vmo3
								ON vve3.VmoId = vmo3.VmoId
							LEFT JOIN tblvtivehiculotipo vti3
							ON vmo3.VtiId = vti3.VtiId	
									LEFT JOIN tblvmavehiculomarca vma3
									ON vmo3.VmaId = vma3.VmaId
									
									
									
									
									
									
										LEFT JOIN tblperpersonal per
										ON cve.PerId = per.PerId
											LEFT JOIN tblperpersonal per2
											ON cve.PerIdReferente = per2.PerId
											LEFT JOIN tblsucsucursal suc
											ON cve.SucId = suc.SucId
        WHERE cve.CveId = "'.$this->CveId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			//$InsCotizacionVehiculoObsequio = new ClsCotizacionVehiculoObsequio();
			//$ResCotizacionVehiculoObsequio =  $InsCotizacionVehiculoObsequio->MtdObtenerCotizacionVehiculoObsequios(NULL,NULL,NULL,NULL,NULL,$fila['CveId']);
			
			
			//$InsCotizacionVehiculoObsequio = new ClsCotizacionVehiculoObsequio();
			
			$this->CveId = $fila['CveId'];
			$this->SucId = $fila['SucId'];
			
			$this->CveAno = $fila['CveAno'];
			$this->CveMes = $fila['CveMes'];
			
			$this->PerId = $fila['PerId'];	
			$this->PerIdReferente = $fila['PerIdReferente'];	
				
			$this->CliId = $fila['CliId'];		
			$this->NpaId = $fila['NpaId'];		
			
			$this->CveFecha = $fila['NCveFecha'];
			$this->CveHora = $fila['NCveHora'];
			
			$this->CveFechaVigencia = $fila['NCveFechaVigencia'];

			$this->MonId = $fila['MonId'];
			$this->CveTipoCambio = $fila['CveTipoCambio'];

			$this->CveIncluyeImpuesto = $fila['CveIncluyeImpuesto'];
			$this->CvePorcentajeImpuestoVenta = $fila['CvePorcentajeImpuestoVenta'];
			
			$this->CveAdicional = $fila['CveAdicional'];
			$this->CveObservacion = $fila['CveObservacion'];
			$this->CveObservacionReporte = $fila['CveObservacionReporte'];
			$this->CveNota = $fila['CveNota'];
			
			$this->CveTelefono = $fila['CveTelefono'];
			$this->CveCelular = $fila['CveCelular'];
			$this->CveDireccion = $fila['CveDireccion'];
			$this->CveEmail = $fila['CveEmail'];







			$this->VveId = $fila['VveId'];
			$this->CveAnoModelo = $fila['CveAnoModelo'];
			$this->CveAnoFabricacion = $fila['CveAnoFabricacion'];
			
			$this->CveColor = $fila['CveColor'];
			$this->EinId = $fila['EinId'];

			$this->CveCantidad = $fila['CveCantidad'];
			$this->CvePrecio = $fila['CvePrecio'];
			$this->CveDescuento = $fila['CveDescuento'];
			
			$this->CveSubTotal = $fila['CveSubTotal'];
			$this->CveImpuesto = $fila['CveImpuesto'];
			$this->CveTotal = $fila['CveTotal'];
			$this->CveTotalUnitario = $fila['CveTotalUnitario'];
			
			$this->CveGLP = $fila['CveGLP'];
			
			
			

			$this->VveId2 = $fila['VveId2'];
			$this->CveAnoModelo2 = $fila['CveAnoModelo2'];
			$this->CveAnoFabricacion2 = $fila['CveAnoFabricacion2'];
			
			$this->CveColor2 = $fila['CveColor2'];
			$this->EinId2 = $fila['EinId2'];

			$this->CveCantidad2 = $fila['CveCantidad2'];
			$this->CvePrecio2 = $fila['CvePrecio2'];
			$this->CveDescuento2 = $fila['CveDescuento2'];
			
			$this->CveSubTotal2 = $fila['CveSubTotal2'];
			$this->CveImpuesto2 = $fila['CveImpuesto2'];
			$this->CveTotal2 = $fila['CveTotal2'];
			$this->CveTotalUnitario2 = $fila['CveTotalUnitario2'];
			
			$this->CveGLP2 = $fila['CveGLP2'];
			
			
			
			
			
			$this->VveId3 = $fila['VveId3'];
			$this->CveAnoModelo3 = $fila['CveAnoModelo3'];
			$this->CveAnoFabricacion3 = $fila['CveAnoFabricacion3'];
			
			$this->CveColor3 = $fila['CveColor3'];
			$this->EinId3 = $fila['EinId3'];

			$this->CveCantidad3 = $fila['CveCantidad3'];
			$this->CvePrecio3 = $fila['CvePrecio3'];
			$this->CveDescuento3 = $fila['CveDescuento3'];
			
			$this->CveSubTotal3 = $fila['CveSubTotal3'];
			$this->CveImpuesto3 = $fila['CveImpuesto3'];
			$this->CveTotal3 = $fila['CveTotal3'];
			$this->CveTotalUnitario3 = $fila['CveTotalUnitario3'];
			
			$this->CveGLP3 = $fila['CveGLP3'];
			
			
			
			
			
			
			
			
			$this->CveCondicionVentaOtro = $fila['CveCondicionVentaOtro'];

			$this->CveObsequioOtro = $fila['CveObsequioOtro'];

			$this->CveNivelInteres = $fila['CveNivelInteres'];
			$this->CveFoto = $fila['CveFoto'];
			$this->CveCotizoOtroLugar = $fila['CveCotizoOtroLugar'];
			
			
			$this->CveStatus = $fila['CveStatus'];
			$this->CveEstado = $fila['CveEstado'];
			$this->CveTiempoCreacion = $fila['NCveTiempoCreacion']; 
			$this->CveTiempoModificacion = $fila['NCveTiempoModificacion']; 	
			//$this->CotizacionVehiculoObsequio = 	$ResCotizacionVehiculoObsequio['Datos'];	
			$this->TdoId = $fila['TdoId']; 	
			$this->CliNombreCompleto = $fila['CliNombreCompleto']; 
			$this->CliNombre = $fila['CliNombre']; 
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
			
				
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoNombre = $fila['TdoNombre'];
			
			$this->CliTelefono = $fila['CliTelefono'];
			$this->CliCelular = $fila['CliCelular'];
			$this->CliEmail = $fila['CliEmail'];
			$this->TrfId = $fila['TrfId'];

	
		
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->VmaId = $fila['VmaId'];
			$this->VmaNombre = $fila['VmaNombre'];
			
			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre'];
			
			$this->VveId = $fila['VveId'];
			$this->VveNombre = $fila['VveNombre'];
			$this->VveFoto = $fila['VveFoto'];
			$this->VveFotoLateral = $fila['VveFotoLateral'];
			$this->VveFotoPosterior = $fila['VveFotoPosterior'];
			$this->VveFotoCaracteristica = $fila['VveFotoCaracteristica'];

			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
		
			$this->PerTelefono = $fila['PerTelefono'];
			$this->PerCelular = $fila['PerCelular'];
			$this->PerFax = $fila['PerFax'];
			$this->PerEmail = $fila['PerEmail'];
			$this->PerFirma = $fila['PerFirma'];
			
			$this->PerNombreReferente = $fila['PerNombreReferente'];
			$this->PerApellidoPaternoReferente = $fila['PerApellidoPaternoReferente'];
			$this->PerApellidoMaternoReferente = $fila['PerApellidoMaternoReferente'];
			
			$this->SucSiglas = $fila['SucSiglas'];
			
		
			if($oCompleto){
	
				$InsCotizacionVehiculoCondicionVenta = new ClsCotizacionVehiculoCondicionVenta();
				$ResCotizacionVehiculoCondicionVenta = $InsCotizacionVehiculoCondicionVenta->MtdObtenerCotizacionVehiculoCondicionVentas(NULL,NULL,'CcvId','ASC',NULL,$this->CveId);
				$this->CotizacionVehiculoCondicionVenta = $ResCotizacionVehiculoCondicionVenta['Datos'];
			
					
				$InsCotizacionVehiculoObsequio = new ClsCotizacionVehiculoObsequio();
				$ResCotizacionVehiculoObsequio = $InsCotizacionVehiculoObsequio->MtdObtenerCotizacionVehiculoObsequios(NULL,NULL,'CvoId','ASC',NULL,$this->CveId);
				$this->CotizacionVehiculoObsequio = $ResCotizacionVehiculoObsequio['Datos'];
				
				
				
		//	$ResCotizacionVehiculoObsequio = $InsCotizacionVehiculoObsequio->MtdObtenerCotizacionVehiculoObsequios(NULL,NULL,'CvoId','ASC',NULL,$this->CveId);
//			$this->CotizacionVehiculoObsequio = $ResCotizacionVehiculoObsequio['Datos'];

			$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();
			//MtdObtenerVehiculoVersionCaracteristicas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VvcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oAnoModelo=NULL)
			$ResVehiculoVersionCaracteristica = $InsVehiculoVersionCaracteristica-> MtdObtenerVehiculoVersionCaracteristicas(NULL,NULL,'VvcId','ASC',NULL,$this->VveId,$this->CveAnoModelo);
			$this->VehiculoVersionCaracteristica = $ResVehiculoVersionCaracteristica['Datos'];
			
			///MtdObtenerCotizacionVehiculoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CvfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL)
				$InsCotizacionVehiculoFoto = new ClsCotizacionVehiculoFoto();
				$ResCotizacionVehiculoFoto = $InsCotizacionVehiculoFoto->MtdObtenerCotizacionVehiculoFotos(NULL,NULL,'CvfId','ASC',NULL,$this->CveId);
				$this->CotizacionVehiculoFoto = $ResCotizacionVehiculoFoto['Datos'];
				
				
				$InsCotizacionVehiculoLlamada = new ClsCotizacionVehiculoLlamada();
				$ResCotizacionVehiculoLlamada =  $InsCotizacionVehiculoLlamada->MtdObtenerCotizacionVehiculoLlamadas(NULL,NULL,"CvlId","ASC",NULL,$this->CveId,NULL);
				$this->CotizacionVehiculoLlamada = 	$ResCotizacionVehiculoLlamada['Datos'];	
				
				
				
			
			}
			
			
								
			switch($this->CveEstado){
			
			  case 1:
				  $Estado = "Pendiente";
			  break;
			
			  case 3:
				  $Estado = "Listo";
			  break;	
			  
			    case 6:
				  $Estado = "Anulado";
			  break;	
			
			  default:
				  $Estado = "";
			  break;					
			
			}
			
			$this->CveEstadoDescripcion = $Estado;
			
			switch($this->CveNivelInteres){
			
			  case 1:
				  $NivelInteres = "Normal (Sin Interés)";
			  break;
			  
			   case 11:
				  $NivelInteres = "Poco Interesado";
			  break;
			  
			   case 12:
				  $NivelInteres = "Medianamente Interesado";
			  break;
			  
			  case 2:
				  $NivelInteres = "Interesado";
			  break;
			
			  case 3:
				  $NivelInteres = "Muy Interesado";
			  break;
			  
			  case 4:
				  $NivelInteres = "Venta Concluida";
			  break;	
				
			  default:
				  $NivelInteres = "";
			  break;					
			
			}
			
			$this->CveNivelInteresDescripcion = $NivelInteres;
			
			
			
			
			switch($this->CveStatus){
			
			  case 1:
				  $StatusDescripcion = "Seguimiento";
			  break;
			  
			   case 2:
				  $StatusDescripcion = "Compro Otra Marca";
			  break;
			  
			   case 3:
				  $StatusDescripcion = "Creadito Rechazado";
			  break;
			  
			  case 4:
				  $StatusDescripcion = "Compra a mas de 60 días";
			  break;
			
			  case 5:
				  $StatusDescripcion = "No esta interesado";
			  break;
			  
			  case 6:
				  $StatusDescripcion = "Cotizacion Cerrada";
			  break;	
				
				case 7:
				  $StatusDescripcion = "Vendido";
			  break;	
				
				
			  default:
				  $StatusDescripcion = "";
			  break;					
			
			}
			
			$this->CveStatusDescripcion = $StatusDescripcion;
			
			
			
			
			
			switch($this->CveNivelInteres){
			
			  case 1:
				  $NivelInteres = "#FFFFFF";
			  break;
			  
			  case 2:
				  $NivelInteres = "#FFFF66";
			  break;
			
			  case 3:
				  $NivelInteres = "#FF3300";
			  break;	
			
			  default:
				  $NivelInteres = "";
			  break;					
			
			}
			
			$this->CveNivelColor = $NivelInteres;
			
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCotizacionVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oSucursal=NULL,$oDiasTranscurridos=0,$oStatus=0) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cve.CveFecha)>="'.$oFechaInicio.'" AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cve.CveFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND cve.CveEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND cve.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oPersonal)){
			$personal = ' AND cve.PerId = "'.$oPersonal.'"';
		}
		

		//if(!empty($oNivelInteres)){
//			$ninteres = ' AND cve.CveNivelInteres = '.$oNivelInteres.'';
//		}
		
		if(!empty($oNivelInteres)){

			$elementos = explode(",",$oNivelInteres);

			$i=1;
			$ninteres .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$ninteres .= '  (cve.CveNivelInteres = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$ninteres .= ' OR ';	
				}
			$i++;		
			}

			$ninteres .= ' ) 
			)
			';

		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cve.SucId = "'.$oSucursal.'"';
		}
	
	
		if(!empty($oDiasTranscurridos)){
			
			$dtransc = ' AND (TIMESTAMPDIFF(DAY, cve.CveFecha, NOW() ) ) >= "'.$oDiasTranscurridos.'"';
			
		}
	
	
		if(!empty($oStatus)){
			
			$status = ' AND cve.CveStatus = '.$oStatus.'';
			
		}
	
	
	
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cve.CveId,	
				cve.CveAno,
				cve.CveMes,
							
				cve.PerId,
				cve.PerIdReferente,
				
				cve.CliId,
				cve.NpaId,
				
				DATE_FORMAT(cve.CveFecha, "%d/%m/%Y") AS "NCveFecha",
				DATE_FORMAT(cve.CveHora, "%H:%i") AS "NCveHora",
				DATE_FORMAT(cve.CveFechaVigencia, "%d/%m/%Y") AS "NCveFechaVigencia",
				
				cve.MonId,
				cve.CveTipoCambio,
				
				cve.CveIncluyeImpuesto,
				cve.CvePorcentajeImpuestoVenta,
				
				cve.CveTotal,
				cve.CveAdicional,
				cve.CveObservacion,
				cve.CveObservacionReporte,
				
				cve.CveNota,
				
				cve.CveTelefono,
				cve.CveCelular,
				cve.CveDireccion,
				cve.CveEmail,
		
				cve.VveId,
				cve.CveAnoModelo,
				cve.CveAnoFabricacion,
				cve.CveColor,
				cve.EinId,
				
				cve.CveCantidad,
				cve.CvePrecio,
				cve.CveDescuento,
				
				cve.CveSubTotal,
				cve.CveImpuesto,				
				cve.CveTotal,

				cve.CveCondicionVentaOtro,

				cve.CveObsequioOtro,

				CASE
				WHEN EXISTS (
					SELECT 
					ovv.OvvId
					FROM tblovvordenventavehiculo ovv
					WHERE ovv.CveId = cve.CveId
					AND ovv.OvvEstado <> 6
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CveOrdenVentaVehiculo,
				
				CASE
				WHEN NOT EXISTS (
					SELECT 
					ovv.OvvId
					FROM tblovvordenventavehiculo ovv
					WHERE ovv.CveId = cve.CveId
						AND (ovv.OvvEstado = 3 OR ovv.OvvEstado = 4 OR ovv.OvvEstado = 5)
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CveGenerarOrdenVentaVehiculo,

				cve.CveNivelInteres,
				cve.CveFoto,
				cve.CveCotizoOtroLugar,
				
				cve.CveGLP,
				cve.CveStatus,
cve.CveEstado,
				DATE_FORMAT(cve.CveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCveTiempoCreacion",
	        	DATE_FORMAT(cve.CveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCveTiempoModificacion",
				
				(TIMESTAMPDIFF(DAY, cve.CveFecha, NOW() ) ) AS CveDiaTranscurridos,
				
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				tdo.TdoNombre,
				
				cli.CliTelefono,
				cli.CliCelular,
				
				cli.CliContactoCelular1,
				cli.CliContactoCelular2,
				cli.CliContactoCelular3,
				
				cli.CliEmail,
				
				cli.CliDireccion,
		
				cli.CliDistrito,
				cli.CliProvincia,
				cli.CliDepartamento,
				
				
				
				mon.MonNombre,
				mon.MonSimbolo,

				vmo.VmaId,
				vma.VmaNombre,
		
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre,
				
				vve.VveFoto,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				trf.TrfNombre,
				
				npa.NpaNombre,
				
				suc.SucNombre,
				
				lti.LtiNombre
		
		
				FROM tblcvecotizacionvehiculo cve
					LEFT JOIN tblclicliente cli
					ON cve.CliId = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tblmonmoneda mon
							ON cve.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON cve.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									LEFT JOIN tblperpersonal per
									ON cve.PerId = per.PerId
										LEFT JOIN tbltrftiporeferido trf
										ON cli.TrfId = trf.TrfId
										LEFT JOIN tblnpacondicionpago npa
										ON cve.NpaId = npa.NpaId
										
										LEFT JOIN tblsucsucursal suc
										ON cve.SucId = suc.SucId
										
										LEFT JOIN tbllticlientetipo lti
										ON cli.LtiId = lti.LtiId
										
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$dtransc.$sucursal.$status.$stipo.$estado.$moneda.$personal.$ninteres.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionVehiculo = new $InsCotizacionVehiculo();
                    $CotizacionVehiculo->CveId = $fila['CveId'];
					$CotizacionVehiculo->SucId = $fila['SucId'];
					
					$CotizacionVehiculo->CveAno = $fila['CveAno'];
					$CotizacionVehiculo->CveMes = $fila['CveMes'];
					
					$CotizacionVehiculo->PerId = $fila['PerId'];	
					$CotizacionVehiculo->PerIdReferente = $fila['PerIdReferente'];	
					
					$CotizacionVehiculo->CliId = $fila['CliId'];	
					$CotizacionVehiculo->NpaId = $fila['NpaId'];
					$CotizacionVehiculo->CveFecha = $fila['NCveFecha'];
					$CotizacionVehiculo->CveHora = $fila['NCveHora'];
					
		
					$CotizacionVehiculo->CveFechaVigencia = $fila['NCveFechaVigencia'];
					
					$CotizacionVehiculo->MonId = $fila['MonId'];
					$CotizacionVehiculo->CveTipoCambio = $fila['CveTipoCambio'];
					
					$CotizacionVehiculo->CveIncluyeImpuesto = $fila['CveIncluyeImpuesto'];
					$CotizacionVehiculo->CvePorcentajeImpuestoVenta = $fila['CvePorcentajeImpuestoVenta'];					
					$CotizacionVehiculo->CveObservacion = $fila['CveObservacion'];
					$CotizacionVehiculo->CveObservacionReporte = $fila['CveObservacionReporte'];
					
					$CotizacionVehiculo->CveAdicional = $fila['CveAdicional'];
					$CotizacionVehiculo->CveNota = $fila['CveNota'];
					
					$CotizacionVehiculo->CveTelefono = $fila['CveTelefono'];
					$CotizacionVehiculo->CveCelular = $fila['CveCelular'];
					$CotizacionVehiculo->CveDireccion = $fila['CveDireccion'];
					$CotizacionVehiculo->CveEmail = $fila['CveEmail'];
					
					$CotizacionVehiculo->CliDireccion = $fila['CliDireccion'];
					
					$CotizacionVehiculo->CliDistrito = $fila['CliDistrito'];
					$CotizacionVehiculo->CliProvincia = $fila['CliProvincia'];
					$CotizacionVehiculo->CliDepartamento = $fila['CliDepartamento'];
		
					$CotizacionVehiculo->VveId = $fila['VveId'];
					$CotizacionVehiculo->CveAnoModelo = $fila['CveAnoModelo'];	
					$CotizacionVehiculo->CveAnoFabricacion = $fila['CveAnoFabricacion'];
					
					
					$CotizacionVehiculo->CveColor = $fila['CveColor'];	
					$CotizacionVehiculo->EinId = $fila['EinId'];			

					$CotizacionVehiculo->CveCantidad = $fila['CveCantidad'];
					$CotizacionVehiculo->CvePrecio = $fila['CvePrecio'];			
					$CotizacionVehiculo->CveDescuento = $fila['CveDescuento'];			
				
					$CotizacionVehiculo->CveSubTotal = $fila['CveSubTotal'];			
					$CotizacionVehiculo->CveImpuesto = $fila['CveImpuesto'];
					$CotizacionVehiculo->CveTotal = $fila['CveTotal'];
					
					$CotizacionVehiculo->CveCondicionVentaOtro = $fila['CveCondicionVentaOtro'];
					$CotizacionVehiculo->CveObsequioOtro = $fila['CveObsequioOtro'];
					
					
					$CotizacionVehiculo->CveOrdenVentaVehiculo = $fila['CveOrdenVentaVehiculo'];
					$CotizacionVehiculo->CveGenerarOrdenVentaVehiculo = $fila['CveGenerarOrdenVentaVehiculo'];
										
					$CotizacionVehiculo->CveNivelInteres = $fila['CveNivelInteres'];
					$CotizacionVehiculo->CveFoto = $fila['CveFoto'];
					
					$CotizacionVehiculo->CveCotizoOtroLugar = $fila['CveCotizoOtroLugar'];
					
					
					
					$CotizacionVehiculo->CveStatus = $fila['CveStatus'];
					$CotizacionVehiculo->CveGLP = $fila['CveGLP'];
					$CotizacionVehiculo->CveEstado = $fila['CveEstado'];
					$CotizacionVehiculo->CveTiempoCreacion = $fila['NCveTiempoCreacion'];  
					$CotizacionVehiculo->CveTiempoModificacion = $fila['NCveTiempoModificacion']; 
					
					
					$CotizacionVehiculo->CveDiaTranscurridos = $fila['CveDiaTranscurridos']; 
					
					
					$CotizacionVehiculo->TdoId = $fila['TdoId']; 
					$CotizacionVehiculo->CliNombreCompleto = $fila['CliNombreCompleto']; 
					$CotizacionVehiculo->CliNombre = $fila['CliNombre']; 
					$CotizacionVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$CotizacionVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
					
					$CotizacionVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					
					$CotizacionVehiculo->CliTelefono = $fila['CliTelefono']; 
					$CotizacionVehiculo->CliCelular = $fila['CliCelular']; 
					
					$CotizacionVehiculo->CliContactoCelular1 = $fila['CliContactoCelular1']; 
					$CotizacionVehiculo->CliContactoCelular2 = $fila['CliContactoCelular2']; 
					$CotizacionVehiculo->CliContactoCelular3 = $fila['CliContactoCelular3']; 
					
					
					$CotizacionVehiculo->CliEmail = $fila['CliEmail']; 


					$CotizacionVehiculo->TdoNombre = $fila['TdoNombre']; 
					
					$CotizacionVehiculo->MonNombre = $fila['MonNombre']; 
					$CotizacionVehiculo->MonSimbolo = $fila['MonSimbolo']; 
				
		
					$CotizacionVehiculo->VmaId = $fila['VmaId'];
					$CotizacionVehiculo->VmaNombre = $fila['VmaNombre'];
					
					$CotizacionVehiculo->VmoId = $fila['VmoId'];
					$CotizacionVehiculo->VmoNombre = $fila['VmoNombre'];
					
					$CotizacionVehiculo->VveId = $fila['VveId'];
					$CotizacionVehiculo->VveNombre = $fila['VveNombre'];
					
					$CotizacionVehiculo->VveFoto = $fila['VveFoto'];
					
					$CotizacionVehiculo->PerNombre = $fila['PerNombre'];
					$CotizacionVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$CotizacionVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$CotizacionVehiculo->TrfNombre = $fila['TrfNombre'];
				$CotizacionVehiculo->NpaNombre = $fila['NpaNombre'];
				
				$CotizacionVehiculo->SucNombre = $fila['SucNombre'];
				
				$CotizacionVehiculo->LtiNombre = $fila['LtiNombre'];
				

					switch($CotizacionVehiculo->CveEstado){
					
					  case 1:
						  $Estado = "Pendiente";
					  break;
					
					  case 3:
						  $Estado = "Listo";
					  break;	
					  
					   case 6:
						  $Estado = "Anulado";
					  break;	
					
					  default:
						  $Estado = "";
					  break;					
					
					}
					
			  
					
			switch($CotizacionVehiculo->CveNivelInteres){
			
			  case 1:
				  $NivelInteres = "Normal (Sin Interés)";
			  break;
			  
			   case 11:
				  $NivelInteres = "Poco Interesado";
			  break;
			  
			   case 12:
				  $NivelInteres = "Medianamente Interesado";
			  break;
			  
			  case 2:
				  $NivelInteres = "Interesado";
			  break;
			
			  case 3:
				  $NivelInteres = "Muy Interesado";
			  break;
			  
			  case 4:
				  $NivelInteres = "Venta Concluida";
			  break;	
				
			
			  default:
				  $NivelInteres = "";
			  break;					
			
			}
			
			$CotizacionVehiculo->CveNivelInteresDescripcion = $NivelInteres;
			
			
			
			switch($CotizacionVehiculo->CveStatus){
			
			  case 1:
				  $StatusDescripcion = "Seguimiento";
			  break;
			  
			   case 2:
				  $StatusDescripcion = "Compro Otra Marca";
			  break;
			  
			   case 3:
				  $StatusDescripcion = "Creadito Rechazado";
			  break;
			  
			  case 4:
				  $StatusDescripcion = "Compra a mas de 60 días";
			  break;
			
			  case 5:
				  $StatusDescripcion = "No esta interesado";
			  break;
			  
			  case 6:
				  $StatusDescripcion = "Cotizacion Cerrada";
			  break;	
				
				case 7:
				  $StatusDescripcion = "Vendido";
			  break;	
				
				
			  default:
				  $StatusDescripcion = "";
			  break;					
			
			}
			
			$CotizacionVehiculo->CveStatusDescripcion = $StatusDescripcion;
			
			
			
			
			switch($CotizacionVehiculo->CveNivelInteres){
			
			  case 1:
				  $NivelInteres = "#FFFFFF";
			  break;
			  
			  case 2:
				  $NivelInteres = "#FFFF66";
			  break;
			
			  case 3:
				  $NivelInteres = "#FF3300";
			  break;	
			
			  default:
				  $NivelInteres = "";
			  break;					
			
			}
			
			$CotizacionVehiculo->CveNivelColor = $NivelInteres;
			
			
			
			
					$CotizacionVehiculo->CveEstadoDescripcion = $Estado;
			
                    $CotizacionVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	public function MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cve.CveFecha)>="'.$oFechaInicio.'" AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cve.CveFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';		
			}			
		}

		/*if(!empty($oEstado)){
			$estado = ' AND cve.CveEstado = '.$oEstado;
		}*/
		
		if(!empty($oEstado)){
			
			if(is_array($oEstado)){
				
					
				$i=1;
				$estado .= ' AND (
				(';
				//$elementos = array_filter($elementos);
				foreach($oEstado as $elemento){
					
					 if( !next( $oEstado ) ) {
						 $estado .= '  (cve.CveEstado = "'.($elemento).'" )  ';
					 }else{
						 $estado .= '  (cve.CveEstado = "'.($elemento).'" ) OR';
					 }
				
				$i++;		
				}
	
				$estado .= ' ) 
				)
				';
				
				
			}else{
				
				
					$elementos = explode(",",$oEstado);

					$i=1;
					$estado .= ' AND (';
					$elementos = array_filter($elementos);
					foreach($elementos as $elemento){
							$estado .= '  (cve.CveEstado = "'.($elemento).'")';	
							if($i<>count($elementos)){						
								$estado .= ' OR ';	
							}
					$i++;		
					}
					
					$estado .= ' ) ';
				
			}
			
			
			
		}
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND cve.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND cve.PerId = "'.$oPersonal.'"';
		}
					if(!empty($oVehiculoModelo)){
			$modelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'"';
		}
			
					if(!empty($oMarca)){
			$marca = ' AND vmo.VmaId = "'.$oMarca.'"';
		}
	
		if(!empty($oVehiculoVersion)){
			$version = ' AND cve.VveId = "'.$oVehiculoVersion.'"';
		}




		if(!empty($oNivelInteres)){
			$ninteres = ' AND cve.CveNivelInteres = '.$oNivelInteres.'';
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cve.SucId = "'.$oSucursal.'"';
		}
		
		
		if(!empty($oTipoReferido)){
			$treferido = ' AND cli.TrfId = "'.$oTipoReferido.'" ';
		}
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(cve.CveFecha) = "'.$oAno.'"';
		}
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(cve.CveFecha) = "'.$oMes.'"';
		}
		
			$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
		
				FROM tblcvecotizacionvehiculo cve
					LEFT JOIN tblclicliente cli
					ON cve.CliId = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tblmonmoneda mon
							ON cve.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON cve.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									LEFT JOIN tblperpersonal per
									ON cve.PerId = per.PerId
									
									
				WHERE 1 = 1 '.$filtrar.$fecha.$sucursal.$ano.$mes.$tipo.$stipo.$version.$estado.$marca.$treferido.$moneda.$personal.$ninteres.$modelo.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
					
		}
	
	//Accion eliminar	 
	public function MtdEliminarCotizacionVehiculo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

//		$InsCotizacionVehiculoObsequio = new ClsCotizacionVehiculoObsequio();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					$aux = explode("%",$elemento);	
					
//					$ResCotizacionVehiculoObsequio = $InsCotizacionVehiculoObsequio->MtdObtenerCotizacionVehiculoObsequios(NULL,NULL,'CvdId','Desc',NULL,$aux[0]);
//					$ArrCotizacionVehiculoObsequios = $ResCotizacionVehiculoObsequio['Datos'];
//
//					if(!empty($ArrCotizacionVehiculoObsequios)){
//						$amdetalle = '';
//
//						foreach($ArrCotizacionVehiculoObsequios as $DatCotizacionVehiculoObsequio){
//							$amdetalle .= '#'.$DatCotizacionVehiculoObsequio->CvdId;
//						}
//
//						if(!$InsCotizacionVehiculoObsequio->MtdEliminarCotizacionVehiculoObsequio($amdetalle)){								
//							$error = true;
//						}
//							
//					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblcvecotizacionvehiculo WHERE  (CveId = "'.($aux[0]).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarCotizacionVehiculo(3,"Se elimino la Cotizacion de Vehiculo",$aux);		
						}
					}
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoCotizacionVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
//		$InsCotizacionVehiculoObsequios = new ClsCotizacionVehiculoObsequio();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblcvecotizacionvehiculo SET CveEstado = '.$oEstado.' WHERE CveId = "'.$aux[0].'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarCotizacionVehiculo(2,"Se actualizo el Estado de la Cotizacion de Vehiculo",$aux);
				
					}

					
				}
			$i++;
	
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	//Accion eliminar	 
	public function MtdActualizarNivelInteresCotizacionVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
//		$InsCotizacionVehiculoObsequios = new ClsCotizacionVehiculoObsequio();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblcvecotizacionvehiculo SET CveNivelInteres = '.$oEstado.' WHERE CveId = "'.$aux[0].'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarCotizacionVehiculo(2,"Se actualizo el Nivel de Interes de la Cotizacion de Vehiculo",$aux);
				
					}

					
				}
			$i++;
	
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	
	
	public function MtdRegistrarCotizacionVehiculo() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarCotizacionVehiculoId();
		
		$this->InsMysql->MtdTransaccionIniciar();


		if(empty($this->CliId)){

				/*
				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->LtiId = $this->LtiId;		
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->CveDireccion;
				$InsCliente->CliTelefono = $this->CveTelefono;
				$InsCliente->CliCelular = $this->CveCelular;
				$InsCliente->CliEmail = $this->CprEmail;
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
									
					if(!empty($InsCliente->CliNombre)){

						if(!$InsCliente->MtdRegistrarClienteDeCotizacionVehiculo()){
							$error = true;
							$Resultado.='#ERR_CVE_301';
						}else{
							$this->CliId = $InsCliente->CliId;									
						}		
					
					}*/

			}else{
			
//				if(!empty($this->CveDireccion)){
//					$InsCliente = new ClsCliente($this->InsMysql);
//					$InsCliente->MtdEditarClienteDato("CliDireccion",$this->CveDireccion,$this->CliId);
//				}
				
				if(!empty($this->CveTelefono)){
					$InsCliente = new ClsCliente($this->InsMysql);
					$InsCliente->MtdEditarClienteDato("CliTelefono",$this->CveTelefono,$this->CliId);
				}
				
				if(!empty($this->CveCelular)){
					$InsCliente = new ClsCliente($this->InsMysql);
					$InsCliente->MtdEditarClienteDato("CliCelular",$this->CveCelular,$this->CliId);
				}

				if(!empty($this->CveEmail)){
					$InsCliente = new ClsCliente($this->InsMysql);
					$InsCliente->MtdEditarClienteDato("CliEmail",$this->CveEmail,$this->CliId);
				}

		}
//			if(empty($this->CliId)){
//				$InsCliente = new ClsCliente($this->InsMysql);
//				$InsCliente->CliNombre;
//				$InsCliente->CliNumeroDocumento;
//				$InsCliente->MtdVerificarExisteCliente();
//				if(empty($this->CliId)){
//					$InsCliente->CliEstado = 1;
//					$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
//					$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
//					$InsCliente->CliEliminado = 1;
//
//					if(!$InsCliente->MtdClienteRegistrar2()){
//						$error = true;
//						$Resultado.='#ERR_CLI_101';
//					}
//
//				}else{
//
//					$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
//
//					if(!$InsCliente->MtdEditarCliente2()){
//						$error = true;
//						$Resultado.='#ERR_CLI_102';
//					}
//
//					$this->CliId = $InsCliente->CliId;	
//					
//				}
//			}

			$sql = 'INSERT INTO tblcvecotizacionvehiculo (
			CveId,
			SucId,
			
			CveAno,
			CveMes,	
			
			PerId,	
			PerIdReferente,
					
			CliId,
			NpaId,
			
			CveFecha,
			CveHora,
			
			CveFechaVigencia,
			
			MonId,
			CveTipoCambio,
			
			CveIncluyeImpuesto,
			CvePorcentajeImpuestoVenta,

			CveObservacion,
			CveObservacionReporte,
			
			CveAdicional,
			CveNota,
			
			CveTelefono,
			CveCelular,
			CveDireccion,
			CveEmail,

			VveId,
			CveAnoModelo,
			CveAnoFabricacion,
			CveColor,
			EinId,
			
			CveCantidad,
			CvePrecio,
			CveDescuento,
			
			CveSubTotal,
			CveImpuesto,				
			CveTotal,

			CveCondicionVentaOtro,

			CveObsequioOtro,
			
			CveNivelInteres,
			CveFoto,
			CveCotizoOtroLugar,
			
			
			
			CveGLP,
			CveStatus,
			CveEstado,			
			CveTiempoCreacion,
			CveTiempoModificacion) 
			VALUES (
			"'.($this->CveId).'", 
			"'.($this->SucId).'", 
			'.($this->CveAno).', 
			"'.($this->CveMes).'", 

			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			'.(empty($this->PerIdReferente)?"NULL,":'"'.$this->PerIdReferente.'",').'
			'.(empty($this->CliId)?"NULL,":'"'.$this->CliId.'",').'
			'.(empty($this->NpaId)?"NULL,":'"'.$this->NpaId.'",').'
			"'.($this->CveFecha).'", 
			"'.($this->CveHora).'", 
			'.(empty($this->CveFechaVigencia)?"NULL,":'"'.$this->CveFechaVigencia.'",').'
			
			"'.($this->MonId).'",
			'.(empty($this->CveTipoCambio)?"NULL,":''.$this->CveTipoCambio.',').'
			
			'.($this->CveIncluyeImpuesto).',
			'.($this->CvePorcentajeImpuestoVenta).',

			"'.($this->CveObservacion).'",
			"'.($this->CveObservacionReporte).'",
			"'.($this->CveAdicional).'",
			"'.($this->CveNota).'",
			
			"'.($this->CveTelefono).'",
			"'.($this->CveCelular).'",
			"'.($this->CveDireccion).'",
			"'.($this->CveEmail).'",

			"'.($this->VveId).'",
			"'.($this->CveAnoModelo).'",
			"'.($this->CveAnoFabricacion).'",
			"'.($this->CveColor).'",
			'.(empty($this->EinId)?"NULL,":'"'.$this->EinId.'",').'

			'.($this->CveCantidad).',
			'.($this->CvePrecio).',
			'.($this->CveDescuento).',
			
			'.($this->CveSubTotal).',
			'.($this->CveImpuesto).',
			'.($this->CveTotal).',

			"'.($this->CveCondicionVentaOtro).'",

			"'.($this->CveObsequioOtro).'",
			'.($this->CveNivelInteres).',
			"'.($this->CveFoto).'",
			
			"'.($this->CveCotizoOtroLugar).'",
			
			
			
			"'.($this->CveGLP).'",
			'.($this->CveStatus).',
			'.($this->CveEstado).',
			"'.($this->CveTiempoCreacion).'", 				
			"'.($this->CveTiempoModificacion).'");';			
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
			
						
			if(!$error){			
			
				if (!empty($this->CotizacionVehiculoObsequio)){		
						
					$validar = 0;				
					$InsCotizacionVehiculoObsequio = new ClsCotizacionVehiculoObsequio();		
					
					foreach ($this->CotizacionVehiculoObsequio as $DatCotizacionVehiculoObsequio){
					
						$InsCotizacionVehiculoObsequio->CveId = $this->CveId;
						$InsCotizacionVehiculoObsequio->ObsId = $DatCotizacionVehiculoObsequio->ObsId;
						
						
						$InsCotizacionVehiculoObsequio->CvoAprobado = $DatCotizacionVehiculoObsequio->CvoAprobado;
						
						
						$InsCotizacionVehiculoObsequio->CvoEstado = $DatCotizacionVehiculoObsequio->CvoEstado;
						$InsCotizacionVehiculoObsequio->CvoTiempoCreacion = $DatCotizacionVehiculoObsequio->CvoTiempoCreacion;
						$InsCotizacionVehiculoObsequio->CvoTiempoModificacion = $DatCotizacionVehiculoObsequio->CvoTiempoModificacion;
						
						$InsCotizacionVehiculoObsequio->CvoEliminado = $DatCotizacionVehiculoObsequio->CvoEliminado;
						
						if($InsCotizacionVehiculoObsequio->CvoEliminado == 1){
							if($InsCotizacionVehiculoObsequio->MtdRegistrarCotizacionVehiculoObsequio()){
								$validar++;	
							}else{
								$Resultado.='#ERR_OVV_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
							
						}else{
							$validar++;	
						}
						
					}					
					
					if(count($this->CotizacionVehiculoObsequio) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if(!$error){			
			
			
				if (!empty($this->CotizacionVehiculoCondicionVenta)){		
						
					$validar = 0;				
					$InsCotizacionVehiculoCondicionVenta = new ClsCotizacionVehiculoCondicionVenta();		
					
					foreach ($this->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta){
					
						$InsCotizacionVehiculoCondicionVenta->CveId = $this->CveId;
						$InsCotizacionVehiculoCondicionVenta->CovId = $DatCotizacionVehiculoCondicionVenta->CovId;
						$InsCotizacionVehiculoCondicionVenta->CcvEstado = $DatCotizacionVehiculoCondicionVenta->CcvEstado;
						$InsCotizacionVehiculoCondicionVenta->CcvTiempoCreacion = $DatCotizacionVehiculoCondicionVenta->CcvTiempoCreacion;
						$InsCotizacionVehiculoCondicionVenta->CcvTiempoModificacion = $DatCotizacionVehiculoCondicionVenta->CcvTiempoModificacion;
						
						$InsCotizacionVehiculoCondicionVenta->CcvEliminado = $DatCotizacionVehiculoCondicionVenta->CcvEliminado;
						
						if($InsCotizacionVehiculoCondicionVenta->MtdRegistrarCotizacionVehiculoCondicionVenta()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CVE_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->CotizacionVehiculoCondicionVenta) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
				
			
			if(!$error){			
			
				if (!empty($this->CotizacionVehiculoFoto)){		
						
					$validar = 0;				
					
					
					foreach ($this->CotizacionVehiculoFoto as $DatCotizacionVehiculoFoto){
						
						$InsCotizacionVehiculoFoto = new ClsCotizacionVehiculoFoto();		
						$InsCotizacionVehiculoFoto->CveId = $this->CveId;
						$InsCotizacionVehiculoFoto->CvfArchivo = $DatCotizacionVehiculoFoto->CvfArchivo;								
						$InsCotizacionVehiculoFoto->CvfEstado = $DatCotizacionVehiculoFoto->CvfEstado;								
						$InsCotizacionVehiculoFoto->CvfTiempoCreacion = $DatCotizacionVehiculoFoto->CvfTiempoCreacion;
						$InsCotizacionVehiculoFoto->CvfTiempoModificacion = $DatCotizacionVehiculoFoto->CvfTiempoModificacion;						
						$InsCotizacionVehiculoFoto->CvfEliminado = $DatCotizacionVehiculoFoto->CvfEliminado;
						
						if($InsCotizacionVehiculoFoto->MtdRegistrarCotizacionVehiculoFoto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CVE_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->CotizacionVehiculoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarCotizacionVehiculo(1,"Se registro la Cotizacion de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarCotizacionVehiculo() {

		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		if(empty($this->CliId)){
			
			/*	
				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->LtiId = $this->LtiId;		
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->CveDireccion;
				$InsCliente->CliTelefono = $this->CveTelefono;
				$InsCliente->CliCelular = $this->CveCelular;
				$InsCliente->CliEmail = $this->CprEmail;
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
									
					if(!empty($InsCliente->CliNombre)){

						if(!$InsCliente->MtdRegistrarClienteDeCotizacionVehiculo()){
							$error = true;
							$Resultado.='#ERR_CVE_301';
						}else{
							$this->CliId = $InsCliente->CliId;									
						}		
					
					}
*/
			}else{
			
				//if(!empty($this->CveDireccion)){
//					$InsCliente = new ClsCliente($this->InsMysql);
//					$InsCliente->MtdEditarClienteDato("CliDireccion",$this->CveDireccion,$this->CliId);
//				}
				
				if(!empty($this->CveTelefono)){
					$InsCliente = new ClsCliente($this->InsMysql);
					$InsCliente->MtdEditarClienteDato("CliTelefono",$this->CveTelefono,$this->CliId);
				}
				
				if(!empty($this->CveCelular)){
					$InsCliente = new ClsCliente($this->InsMysql);
					$InsCliente->MtdEditarClienteDato("CliCelular",$this->CveCelular,$this->CliId);
				}

				if(!empty($this->CveEmail)){
					$InsCliente = new ClsCliente($this->InsMysql);
					$InsCliente->MtdEditarClienteDato("CliEmail",$this->CveEmail,$this->CliId);
				}

			}
				
			$sql = 'UPDATE tblcvecotizacionvehiculo SET
			SucId = "'.($this->SucId).'",
		
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->PerIdReferente)?'PerIdReferente = NULL, ':'PerIdReferente = "'.$this->PerIdReferente.'",').'
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->NpaId)?'NpaId = NULL, ':'NpaId = "'.$this->NpaId.'",').'
			
			CveFecha = "'.($this->CveFecha).'",
			CveHora = "'.($this->CveHora).'",
			
			'.(empty($this->CveFechaVigencia)?'CveFechaVigencia = NULL, ':'CveFechaVigencia = "'.$this->CveFechaVigencia.'",').'
			
			MonId = "'.($this->MonId).'",
			
			'.(empty($this->CveTipoCambio)?'CveTipoCambio = NULL, ':'CveTipoCambio = '.$this->CveTipoCambio.',').'
			
			CveIncluyeImpuesto = '.($this->CveIncluyeImpuesto).',
			CvePorcentajeImpuestoVenta = '.($this->CvePorcentajeImpuestoVenta).',	
			CveObservacion = "'.($this->CveObservacion).'",
			CveObservacionReporte = "'.($this->CveObservacionReporte).'",
			CveAdicional = "'.($this->CveAdicional).'",
			
			CveNota = "'.($this->CveNota).'",
			
			
			
			CveTelefono = "'.($this->CveTelefono).'",
			CveCelular = "'.($this->CveCelular).'",
			CveDireccion = "'.($this->CveDireccion).'",
			CveEmail = "'.($this->CveEmail).'",

			VveId = "'.($this->VveId).'",
			CveAnoModelo = "'.($this->CveAnoModelo).'",
			CveAnoFabricacion = "'.($this->CveAnoFabricacion).'",
			CveColor = "'.($this->CveColor).'",			
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'

			CveCantidad = '.($this->CveCantidad).',
			CvePrecio = '.($this->CvePrecio).',
			CveDescuento = '.($this->CveDescuento).',

			CveSubTotal = '.($this->CveSubTotal).',
			CveImpuesto = '.($this->CveImpuesto).',
			CveTotal = '.($this->CveTotal).',			
			
			CveCondicionVentaOtro = "'.($this->CveCondicionVentaOtro).'",

			CveObsequioOtro = "'.($this->CveObsequioOtro).'",
			
			CveFoto = "'.($this->CveFoto).'",
			CveNivelInteres = '.($this->CveNivelInteres).',
			
			CveCotizoOtroLugar = "'.($this->CveCotizoOtroLugar).'",
			CveGLP = "'.($this->CveGLP).'",
			
			
			
			CveStatus = '.($this->CveStatus).',
			CveEstado = '.($this->CveEstado).'
			WHERE CveId = "'.($this->CveId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			
			
			
			if(!$error){
	
				if (!empty($this->CotizacionVehiculoObsequio)){		

					$validar = 0;				
					$InsCotizacionVehiculoObsequio = new ClsCotizacionVehiculoObsequio();
		
					foreach ($this->CotizacionVehiculoObsequio as $DatCotizacionVehiculoObsequio){

						$InsCotizacionVehiculoObsequio->CvoId = $DatCotizacionVehiculoObsequio->CvoId;
						$InsCotizacionVehiculoObsequio->CveId = $this->CveId;
						$InsCotizacionVehiculoObsequio->ObsId = $DatCotizacionVehiculoObsequio->ObsId;
						$InsCotizacionVehiculoObsequio->CvoAprobado = $DatCotizacionVehiculoObsequio->CvoAprobado;
						$InsCotizacionVehiculoObsequio->CvoEstado = $DatCotizacionVehiculoObsequio->CvoEstado;
						$InsCotizacionVehiculoObsequio->CvoTiempoCreacion = $DatCotizacionVehiculoObsequio->CvoTiempoCreacion;
						$InsCotizacionVehiculoObsequio->CvoTiempoModificacion = $DatCotizacionVehiculoObsequio->CvoTiempoModificacion;
						$InsCotizacionVehiculoObsequio->CvoEliminado = $DatCotizacionVehiculoObsequio->CvoEliminado;
						
						
						if(empty($InsCotizacionVehiculoObsequio->CvoId)){
							if($InsCotizacionVehiculoObsequio->CvoEliminado<>2){
								if($InsCotizacionVehiculoObsequio->MtdRegistrarCotizacionVehiculoObsequio()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionVehiculoObsequio->CvoEliminado==2){
								if($InsCotizacionVehiculoObsequio->MtdEliminarCotizacionVehiculoObsequio($InsCotizacionVehiculoObsequio->CvoId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_OVV_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionVehiculoObsequio->MtdEditarCotizacionVehiculoObsequio()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionVehiculoObsequio) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			if(!$error){

				if (!empty($this->CotizacionVehiculoCondicionVenta)){		

					$validar = 0;				
					$InsCotizacionVehiculoCondicionVenta = new ClsCotizacionVehiculoCondicionVenta();
							
					foreach ($this->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta){
										
						$InsCotizacionVehiculoCondicionVenta->CcvId = $DatCotizacionVehiculoCondicionVenta->CcvId;
						$InsCotizacionVehiculoCondicionVenta->CveId = $this->CveId;
						$InsCotizacionVehiculoCondicionVenta->CovId = $DatCotizacionVehiculoCondicionVenta->CovId;
						$InsCotizacionVehiculoCondicionVenta->CcvEstado = $DatCotizacionVehiculoCondicionVenta->CcvEstado;
						$InsCotizacionVehiculoCondicionVenta->CcvTiempoCreacion = $DatCotizacionVehiculoCondicionVenta->CcvTiempoCreacion;
						$InsCotizacionVehiculoCondicionVenta->CcvTiempoModificacion = $DatCotizacionVehiculoCondicionVenta->CcvTiempoModificacion;

						$InsCotizacionVehiculoCondicionVenta->CcvEliminado = $DatCotizacionVehiculoCondicionVenta->CcvEliminado;
						
						if(empty($InsCotizacionVehiculoCondicionVenta->CcvId)){
							if($InsCotizacionVehiculoCondicionVenta->CcvEliminado<>2){
								if($InsCotizacionVehiculoCondicionVenta->MtdRegistrarCotizacionVehiculoCondicionVenta()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVE_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionVehiculoCondicionVenta->CcvEliminado==2){
								if($InsCotizacionVehiculoCondicionVenta->MtdEliminarCotizacionVehiculoCondicionVenta($InsCotizacionVehiculoCondicionVenta->CcvId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CVE_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionVehiculoCondicionVenta->MtdEditarCotizacionVehiculoCondicionVenta()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVE_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionVehiculoCondicionVenta) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			/*
			660  t500  
			785  t700  c alimentador de hojas
			*/
			if(!$error){

				if (!empty($this->CotizacionVehiculoFoto)){		
						
					$validar = 0;	
					foreach ($this->CotizacionVehiculoFoto as $DatCotizacionVehiculoFoto){
						
						$InsCotizacionVehiculoFoto = new ClsCotizacionVehiculoFoto();
						$InsCotizacionVehiculoFoto->CvfId = $DatCotizacionVehiculoFoto->CvfId;
						$InsCotizacionVehiculoFoto->CveId = $this->CveId;
						$InsCotizacionVehiculoFoto->CvfArchivo = $DatCotizacionVehiculoFoto->CvfArchivo;
						$InsCotizacionVehiculoFoto->CvfEstado = $DatCotizacionVehiculoFoto->CvfEstado;
						$InsCotizacionVehiculoFoto->CvfTiempoCreacion = $DatCotizacionVehiculoFoto->CvfTiempoCreacion;
						$InsCotizacionVehiculoFoto->CvfTiempoModificacion = $DatCotizacionVehiculoFoto->CvfTiempoModificacion;
						$InsCotizacionVehiculoFoto->CvfEliminado = $DatCotizacionVehiculoFoto->CvfEliminado;
						
						if(empty($InsCotizacionVehiculoFoto->CvfId)){
							if($InsCotizacionVehiculoFoto->CvfEliminado<>2){
								if($InsCotizacionVehiculoFoto->MtdRegistrarCotizacionVehiculoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVE_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionVehiculoFoto->CvfEliminado==2){
								if($InsCotizacionVehiculoFoto->MtdEliminarCotizacionVehiculoFoto($InsCotizacionVehiculoFoto->CvfId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CVE_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionVehiculoFoto->MtdEditarCotizacionVehiculoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVE_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionVehiculoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarCotizacionVehiculo(2,"Se edito la Cotizacion de Vehiculo",$this);		
				return true;
			}	
				
		}	
		
	
			
			public function MtdEditarCotizacionVehiculoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblcvecotizacionvehiculo SET 
			'.$oCampo.' = "'.($oDato).'",
			CveTiempoModificacion = NOW()
			WHERE CveId = "'.($oId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}

		private function MtdAuditarCotizacionVehiculo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->CveId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		
			public function MtdSeguimientoClienteCotizacionVehiculo($oTransaccion=true) {

		global $Resultado;
		$error = false;
						
			if(!$error){

				if (!empty($this->CotizacionVehiculoLlamada)){		
						
					$validar = 0;				
					
					$InsCotizacionVehiculoLlamada = new ClsCotizacionVehiculoLlamada();

					foreach ($this->CotizacionVehiculoLlamada as $DatCotizacionVehiculoLlamada){

						$InsCotizacionVehiculoLlamada->CvlId = $DatCotizacionVehiculoLlamada->CvlId;
						$InsCotizacionVehiculoLlamada->CveId = $this->CveId;
					
						$InsCotizacionVehiculoLlamada->CvlFecha = $DatCotizacionVehiculoLlamada->CvlFecha;	
						$InsCotizacionVehiculoLlamada->CvlFechaProgramada = $DatCotizacionVehiculoLlamada->CvlFechaProgramada;						
						$InsCotizacionVehiculoLlamada->CvlObservacion = $DatCotizacionVehiculoLlamada->CvlObservacion;						
						$InsCotizacionVehiculoLlamada->CvlEstado = $DatCotizacionVehiculoLlamada->CvlEstado;
						$InsCotizacionVehiculoLlamada->CvlTiempoCreacion = $DatCotizacionVehiculoLlamada->CvlTiempoCreacion;
						$InsCotizacionVehiculoLlamada->CvlTiempoModificacion = $DatCotizacionVehiculoLlamada->CvlTiempoModificacion;
						$InsCotizacionVehiculoLlamada->CvlEliminado = $DatCotizacionVehiculoLlamada->CvlEliminado;
						
						if(empty($InsCotizacionVehiculoLlamada->CvlId)){
							if($InsCotizacionVehiculoLlamada->CvlEliminado<>2){
								if($InsCotizacionVehiculoLlamada->MtdRegistrarCotizacionVehiculoLlamada()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVE_501';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCotizacionVehiculoLlamada->CvlEliminado==2){
								if($InsCotizacionVehiculoLlamada->MtdEliminarCotizacionVehiculoLlamada($InsCotizacionVehiculoLlamada->CvlId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CVE_503';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCotizacionVehiculoLlamada->MtdEditarCotizacionVehiculoLlamada()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVE_502';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CotizacionVehiculoLlamada) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
					
				
			if($error) {		
			
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();					
				}
			
				return false;
			} else {			

				if($oTransaccion){
					$this->InsMysql->MtdTransaccionHacer();
				}

				$this->MtdAuditarCotizacionVehiculo(2,"Se edito el seguimiento de la Cotizacion de Vehiculo",$this);		
				return true;
			}	
				
		}	
		
		
		   public function MtdObtenerCotizacionVehiculoPersonales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cve.CveFecha)>="'.$oFechaInicio.'" AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cve.CveFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oSucursal)){
			$sucursal = ' AND cve.SucId = "'.$oSucursal.'"';
		}
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'"';
		}
		
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND cve.VveId = "'.$oVehiculoVersion.'"';
		}

	
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				DISTINCT 
				cve.PerId,
				per.PerAbreviatura,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerNumeroDocumento
				
				FROM tblcvecotizacionvehiculo cve
				LEFT JOIN tblperpersonal per
				ON cve.PerId = per.PerId
				LEFT JOIN tblvvevehiculoversion vve
				ON cve.VveId = vve.VveId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON vve.VmoId = vmo.VmoId
				LEFT JOIN tblvmavehiculomarca vma
				ON vmo.VmaId = vma.VmaId
				WHERE cve.PerId IS NOT NULL
				AND cve.CveEstado <> 6  '.$filtrar.$fecha.$vmarca.$vmodelo.$vversion.$tipo.$dtransc.$sucursal.$stipo.$estado.$moneda.$personal.$ninteres.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionVehiculo = new $InsCotizacionVehiculo();
                    $CotizacionVehiculo->PerId = $fila['PerId'];
					$CotizacionVehiculo->PerAbreviatura = $fila['PerAbreviatura'];
					
					$CotizacionVehiculo->PerNombre = $fila['PerNombre'];
					$CotizacionVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$CotizacionVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$CotizacionVehiculo->PerNumeroDocumento = $fila['PerNumeroDocumento'];	
					
			
                    $CotizacionVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		


}
?>