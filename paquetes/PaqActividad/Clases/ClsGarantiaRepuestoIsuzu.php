<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGarantiaRepuestoIsuzu
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGarantiaRepuestoIsuzu {

    public $GriId;
	public $GriAno;
	public $GriMes;
	
	public $FccId;
	public $CliId;
	
	public $GriFechaEmision;
	public $GriFechaSalida;
	
	public $GriCliente;
	public $GriDireccion;
	public $GriCiudad;
	public $GriTelefono;
	public $GriCelular;
	
	public $MonId;
	public $GriTipoCambio;
	
	public $GriVIN;
	

	public $GriKilometraje;
	public $GriPlaca;
	public $GriFichaIngreso;

	public $GriTotalRepuesto;
	public $GriTotalManoObra;
	
	public $GriSubTotal;
	public $GriImpuesto;
	public $GriTotal;
	
	public $GriRepuestos;
	public $GriManoObra;
	public $GriTercerizacion;
	public $GriMateriales;
	public $GriObservacion;
	public $GriObservacionImpresa;
	
	public $GriFichaIngresoFecha;
	public $GriSintomas;
	public $GriHistorialServicio;
	
	public $GriDiagnostico;
	public $GriDetalleReparacion;
	public $GriCausaFalla;
	
	public $GriEstado;
	public $GriTiempoCreacion;
	public $GriTiempoModificacion;
    public $GriEliminado;
	
	
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliNumeroDocumento;
	public $TdoId;
	
	public $EinId;
	public $EinVIN;
	public $FinVehiculoKilometraje;
	public $VmaId;
	public $VmoId;
	public $EinPlaca;

	public $EinAnoFabricacion;
	public $EinNumeroMotor;
	public $EinColor;
	public $EinPoliza;
	
	public $VmaNombre;
	public $VmoNombre;
	
	public $FinId;
	public $MinId;
	
	public $LtiNombre;

	public $FinFecha;
	public $FinTiempoTrabajoTerminado;
				
	public $FccCausa;				
				
	public $GarantiaRepuestoIsuzuDetalle;
	public $GarantiaRepuestoIsuzuManoObra;

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

	public function MtdGenerarGarantiaRepuestoIsuzuId() {

			$sql = 'SELECT	
						MAX(CONVERT(SUBSTR(gri.GriId,11),unsigned)) AS "MAXIMO"
						FROM tblgrigarantiarepuestoisuzu gri
							LEFT JOIN tblfccfichaaccion fcc
							ON gri.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
									LEFT JOIN tblminmodalidadingreso min
									ON fim.MinId = min.MinId
										LEFT JOIN tblfinfichaingreso fin
										ON fim.FinId = fin.FinId
											LEFT JOIN tbleinvehiculoingreso ein
											ON fin.EinId = ein.EinId
			
						WHERE YEAR(gri.GriFechaEmision) = ("'.$this->GriAno.'")
						
			';
						
			
		
	 
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->GriId = "CYC-RG".$this->GriAno."-00001";
			}else{
				$fila['MAXIMO']++;
				$this->GriId = "CYC-RG".$this->GriAno."-".$this->GriMes."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
			}
			
		}
		
		
    public function MtdObtenerGarantiaRepuestoIsuzu($oCompleto=true){

				$sql = 'SELECT 
				gri.GriId,
				gri.FccId,
				gri.CliId,
				
				gri.GriCliente,
				gri.GriDireccion,
				gri.GriCiudad,
				gri.GriTelefono,
				gri.GriCelular,
				
				DATE_FORMAT(gri.GriFechaEmision, "%d/%m/%Y") AS "NGriFechaEmision",
				DATE_FORMAT(gri.GriFechaSalida, "%d/%m/%Y") AS "NGriFechaSalida",
				
				gri.GriVIN,
				gri.GriModelo,
				DATE_FORMAT(gri.GriFechaEntrega, "%d/%m/%Y") AS "NGriFechaEntrega",
				gri.GriKilometraje,
				gri.GriPlaca,
				
				gri.MonId,
				gri.GriTipoCambio,
		
				gri.GriFichaIngreso,
				DATE_FORMAT(gri.GriFichaIngresoFecha, "%d/%m/%Y") AS "NGriFichaIngresoFecha",
				DATE_FORMAT(gri.GriFichaIngresoFechaSalida, "%d/%m/%Y") AS "NGriFichaIngresoFechaSalida",
		
				gri.GriRepuestos,
				gri.GriManoObra,
				gri.GriMateriales,
				gri.GriTercerizacion,
				
				gri.GriSintomas,
				gri.GriHistorialServicio,
				gri.GriDiagnostico,
				gri.GriCausaFalla,
				gri.GriDetalleReparacion,
				
				gri.GriSubTotal,
				gri.GriImpuesto,
				gri.GriTotal,
			
				gri.GriObservacion,
				gri.GriObservacionImpresa,
				
				gri.GriEstado,
				DATE_FORMAT(gri.GriTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGriTiempoCreacion",
				DATE_FORMAT(gri.GriTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGriTiempoModificacion",
		
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				cli.TdoId,
				
				ein.EinId,
				ein.EinVIN,
				fin.FinVehiculoKilometraje,
				
				ein.VmaId,
				ein.VmoId,
				ein.EinPlaca,
				
				ein.EinAnoFabricacion,
				ein.EinNumeroMotor,
				ein.EinColor,
				ein.EinPoliza,

				vma.VmaNombre,
				vmo.VmoNombre,
				
				fin.FinId,
				fim.MinId,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				
				min.MinNombre,
				
				cam.CamBoletinCodigo,
				
				fcc.FccCausa,
				
				fin.FinFotoVIN,
				fin.FinFotoFrontal,
				fin.FinFotoCupon,
				fin.FinFotoMantenimiento,
				
				amo.AmoId
				
				

        FROM tblgrigarantiarepuestoisuzu gri
			LEFT JOIN tblclicliente cli
			ON gri.CliId = cli.CliId
				LEFT JOIN tblfccfichaaccion fcc
				ON gri.FccId = fcc.FccId
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fcc.FimId = fim.FimId
						
						LEFT JOIN tblminmodalidadingreso min
						ON fim.MinId = min.MinId
						
						LEFT JOIN tblfinfichaingreso fin
						ON fim.FinId = fin.FinId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId
									LEFT JOIN tblvmovehiculomodelo vmo
									ON ein.VmoId = vmo.VmoId
										
										LEFT JOIN tblcamcampana cam
										ON fin.CamId = cam.CamId
										
										
										
										
			LEFT JOIN tblperpersonal per
			ON fin.PerId = per.PerId
			
			LEFT JOIN tblmonmoneda mon
			ON gri.MonId = mon.MonId
			
        WHERE gri.GriId = "'.$this->GriId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->GriId = $fila['GriId'];
			$this->FccId = $fila['FccId'];
			$this->CliId = $fila['CliId'];
			
			$this->GriCliente = $fila['GriCliente'];
			$this->GriDireccion = $fila['GriDireccion'];
			$this->GriCiudad = $fila['GriCiudad'];
			$this->GriTelefono = $fila['GriTelefono'];
			$this->GriCelular = $fila['GriCelular'];
			
			$this->GriFechaEmision = $fila['NGriFechaEmision'];
			$this->GriFechaSalida = $fila['NGriFechaSalida'];
			
			$this->GriVIN = $fila['GriVIN'];
			$this->GriModelo = $fila['GriModelo'];
			$this->GriFechaEntrega = $fila['NGriFechaEntrega'];
			$this->GriKilometraje = $fila['GriKilometraje'];
			$this->GriPlaca = $fila['GriPlaca'];
				
			$this->MonId = $fila['MonId'];
			$this->GriTipoCambio = $fila['GriTipoCambio'];

			$this->GriFichaIngreso = $fila['GriFichaIngreso'];
			$this->GriFichaIngresoFecha = $fila['NGriFichaIngresoFecha'];
			$this->GriFichaIngresoFechaSalida = $fila['NGriFichaIngresoFechaSalida'];
			
			$this->GriRepuestos = $fila['GriRepuestos'];
			$this->GriManoObra = $fila['GriManoObra'];
			$this->GriMateriales = $fila['GriMateriales'];
			$this->GriTercerizacion = $fila['GriTercerizacion'];
			$this->GriSintomas = $fila['GriSintomas'];
			$this->GriHistorialServicio = $fila['GriHistorialServicio'];
			
			$this->GriDiagnostico = $fila['GriDiagnostico'];
			$this->GriCausaFalla = $fila['GriCausaFalla'];
			$this->GriDetalleReparacion = $fila['NGriFechaPago'];
			
			$this->GriSubTotal = $fila['GriSubTotal'];
			$this->GriImpuesto = $fila['GriImpuesto'];
			$this->GriTotal = $fila['GriTotal'];
			
		
			$this->GriObservacion = $fila['GriObservacion'];
			$this->GriObservacionImpresa = $fila['GriObservacionImpresa'];
			
			$this->GriEstado = $fila['GriEstado'];
			$this->GriTiempoCreacion = $fila['NGriTiempoCreacion']; 
			$this->GriTiempoModificacion = $fila['NGriTiempoModificacion'];
			
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			
			
			$this->EinId = $fila['EinId'];
			$this->EinVIN = $fila['EinVIN'];
			$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];
			
			$this->VmaId = $fila['VmaId'];
			$this->VmoId = $fila['VmoId'];
			$this->EinPlaca = $fila['EinPlaca'];
			$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$this->EinNumeroMotor = $fila['EinNumeroMotor'];
			$this->EinColor = $fila['EinColor'];
			$this->EinPoliza = $fila['EinPoliza'];
			
			$this->VmaNombre = $fila['VmaNombre'];
			$this->VmoNombre = $fila['VmoNombre'];
			
			$this->FinId = $fila['FinId'];
			$this->MinId = $fila['MinId'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->MonSimbolo = $fila['MonSimbolo'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->FinFecha = $fila['NFinFecha'];
			$this->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			
			$this->MinNombre = $fila['MinNombre'];
			
			$this->CamBoletinCodigo = $fila['CamBoletinCodigo'];
			
			$this->FccCausa = $fila['FccCausa'];	
			
			$this->FinFotoVIN = $fila['FinFotoVIN'];	
			$this->FinFotoFrontal = $fila['FinFotoFrontal'];
			$this->FinFotoCupon = $fila['FinFotoCupon'];
			$this->FinFotoMantenimiento = $fila['FinFotoMantenimiento'];			
			
			$this->AmoId = $fila['AmoId'];	
			
			switch($this->GriEstado){
				
				case 1:
					$this->GriEstadoDescripcion =  "Pendiente";
				break;
				
				case 5:
					$this->GriEstadoDescripcion =  "Entregado";
				break;
				
				case 6:
					$this->GriEstadoDescripcion =  "Anulado";
				break;
                
				case 7:
					$this->GriEstadoDescripcion =  "C/ Transaccion";
				break;
                
				case 8:
					$this->GriEstadoDescripcion =  "Pagado";
				break;
				
				case 9:
					$this->GriEstadoDescripcion =  "Facturado";
				break;
				
			}
                    
			if($oCompleto){
				
				$InsGarantiaRepuestoIsuzuDetalle = new ClsGarantiaRepuestoIsuzuDetalle();
				$ResGarantiaRepuestoIsuzuDetalle =  $InsGarantiaRepuestoIsuzuDetalle->MtdObtenerGarantiaRepuestoIsuzuDetalles(NULL,NULL,"GdiId","ASC",NULL,$this->GriId,NULL,NULL);
				$this->GarantiaRepuestoIsuzuDetalle = 	$ResGarantiaRepuestoIsuzuDetalle['Datos'];	
	
				$InsGarantiaRepuestoIsuzuManoObra = new ClsGarantiaRepuestoIsuzuManoObra();
				$ResGarantiaRepuestoIsuzuManoObra =  $InsGarantiaRepuestoIsuzuManoObra->MtdObtenerGarantiaRepuestoIsuzuManoObraes(NULL,NULL,"GopId","ASC",NULL,$this->GriId,NULL);
				$this->GarantiaRepuestoIsuzuManoObra = 	$ResGarantiaRepuestoIsuzuManoObra['Datos'];	
				
				$InsFichaAccionFoto = new ClsFichaAccionFoto($this->InsMysql);
				$ResFichaAccionFoto = $InsFichaAccionFoto->MtdObtenerFichaAccionFotos(NULL,NULL,'FafId','Desc',NULL,$this->FccId,NULL);
				$this->FichaAccionFoto = $ResFichaAccionFoto['Datos'];
								
				
			}                       
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerGarantiaRepuestoIsuzus($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GriId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oFichaAccion=NULL) {

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
				$fecha = ' AND DATE(gri.GriFechaEmision)>="'.$oFechaInicio.'" AND DATE(gri.GriFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(gri.GriFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gri.GriFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (gri.GriEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}
			
			$estado .= ' ) 
			)
			';

		}
		
		
		//if(!empty($oEstado)){
//			$estado = ' AND gri.GriEstado = '.$oEstado;
//		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND gri.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}	


		if(!empty($oFichaAccion)){
			$faccion = ' AND gri.FccId = "'.$oFichaAccion.'"';
		}	
		
		
		
		
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					  gri.GriId,
						gri.FccId,
						gri.CliId,
						
						gri.GriCliente,
						gri.GriDireccion,
						gri.GriCiudad,
						gri.GriTelefono,
						gri.GriCelular,
						
						DATE_FORMAT(gri.GriFechaEmision, "%d/%m/%Y") AS "NGriFechaEmision",
						DATE_FORMAT(gri.GriFechaSalida, "%d/%m/%Y") AS "NGriFechaSalida",
						
						gri.GriVIN,
						gri.GriModelo,
						DATE_FORMAT(gri.GriFechaEntrega, "%d/%m/%Y") AS "NGriFechaEntrega",
						gri.GriKilometraje,
						gri.GriPlaca,
						
						gri.MonId,
						gri.GriTipoCambio,
				
						gri.GriFichaIngreso,
						DATE_FORMAT(gri.GriFichaIngresoFecha, "%d/%m/%Y") AS "NGriFichaIngresoFecha",
						DATE_FORMAT(gri.GriFichaIngresoFechaSalida, "%d/%m/%Y") AS "NGriFichaIngresoFechaSalida",
				
						gri.GriRepuestos,
						gri.GriManoObra,
						gri.GriMateriales,
						gri.GriTercerizacion,
						
						gri.GriSintomas,
						gri.GriHistorialServicio,
						gri.GriDiagnostico,
						gri.GriCausaFalla,
						gri.GriDetalleReparacion,
						
						gri.GriSubTotal,
						gri.GriImpuesto,
						gri.GriTotal,
					
						gri.GriObservacion,
						gri.GriObservacionImpresa,
					
					gri.GriEstado,
					DATE_FORMAT(gri.GriTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGriTiempoCreacion",
					DATE_FORMAT(gri.GriTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGriTiempoModificacion",
					
					cli.CliNombre,
					cli.CliApellidoPaterno,
					cli.CliApellidoMaterno,
					cli.CliNumeroDocumento,
					cli.TdoId,
					
					ein.EinId,
					ein.EinVIN,
					fin.FinVehiculoKilometraje,
					
					ein.VmaId,
					ein.VmoId,
					ein.EinPlaca,
					
					ein.EinAnoFabricacion,
					ein.EinNumeroMotor,
					ein.EinColor,
					ein.EinPoliza,
					
					vma.VmaNombre,
					vmo.VmoNombre,
					
					fin.FinId,
					
					lti.LtiNombre,
					lti.LtiAbreviatura,
					
					DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
					DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y") AS "NFinTiempoTrabajoTerminado",
					
					cam.CamBoletinCodigo,
					cam.CamNombre,
				
					amo.AmoId
					
					FROM tblgrigarantiarepuestoisuzu gri
					
				LEFT JOIN tblclicliente cli
				ON gri.CliId = cli.CliId
					
					LEFT JOIN tblfccfichaaccion fcc
					ON gri.FccId = fcc.FccId
					
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
						
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblfinfichaingreso fin
							ON fim.FinId = fin.FinId
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
									LEFT JOIN tblvmavehiculomarca vma
									ON ein.VmaId = vma.VmaId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON ein.VmoId = vmo.VmoId
											LEFT JOIN tbllticlientetipo lti
											ON cli.LtiId = lti.LtiId
									
									LEFT JOIN tblcamcampana cam
									ON fin.CamId = cam.CamId
										
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$moneda.$fingreso.$faccion.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGarantiaRepuestoIsuzu = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GarantiaRepuestoIsuzu = new $InsGarantiaRepuestoIsuzu();
                    $GarantiaRepuestoIsuzu->GriId = $fila['GriId'];
					$GarantiaRepuestoIsuzu->FccId = $fila['FccId'];
					$GarantiaRepuestoIsuzu->CliId = $fila['CliId'];
					
					$GarantiaRepuestoIsuzu->GriCliente = $fila['GriCliente'];
					$GarantiaRepuestoIsuzu->GriDireccion = $fila['GriDireccion'];
					$GarantiaRepuestoIsuzu->GriCiudad = $fila['GriCiudad'];
					$GarantiaRepuestoIsuzu->GriTelefono = $fila['GriTelefono'];
					$GarantiaRepuestoIsuzu->GriCelular = $fila['GriCelular'];
					
					$GarantiaRepuestoIsuzu->GriFechaEmision = $fila['NGriFechaEmision'];
					$GarantiaRepuestoIsuzu->GriFechaSalida = $fila['NGriFechaSalida'];
					
					$GarantiaRepuestoIsuzu->GriVIN = $fila['GriVIN'];
					$GarantiaRepuestoIsuzu->GriModelo = $fila['GriModelo'];
					$GarantiaRepuestoIsuzu->GriFechaEntrega = $fila['NGriFechaEntrega'];
					$GarantiaRepuestoIsuzu->GriKilometraje = $fila['GriKilometraje'];
					$GarantiaRepuestoIsuzu->GriPlaca = $fila['GriPlaca'];
					
					$GarantiaRepuestoIsuzu->MonId = $fila['MonId'];
					$GarantiaRepuestoIsuzu->GriTipoCambio = $fila['GriTipoCambio'];
					
					$GarantiaRepuestoIsuzu->GriFichaIngreso = $fila['GriFichaIngreso'];
					$GarantiaRepuestoIsuzu->GriFichaIngresoFecha = $fila['NGriFichaIngresoFecha'];
					$GarantiaRepuestoIsuzu->GriFichaIngresoFechaSalida = $fila['NGriFichaIngresoFechaSalida'];
					$GarantiaRepuestoIsuzu->GriRepuestos = $fila['GriRepuestos'];
					$GarantiaRepuestoIsuzu->GriManoObra = $fila['GriManoObra'];
					$GarantiaRepuestoIsuzu->GriMateriales = $fila['GriMateriales'];
					$GarantiaRepuestoIsuzu->GriTercerizacion = $fila['GriTercerizacion'];
					$GarantiaRepuestoIsuzu->GriSintomas = $fila['GriSintomas'];
					$GarantiaRepuestoIsuzu->GriHistorialServicio = $fila['GriHistorialServicio'];
					$GarantiaRepuestoIsuzu->GriDiagnostico = $fila['GriDiagnostico'];
					$GarantiaRepuestoIsuzu->GriCausaFalla = $fila['GriCausaFalla'];
					$GarantiaRepuestoIsuzu->GriDetalleReparacion = $fila['GriDetalleReparacion'];
					
					$GarantiaRepuestoIsuzu->GriSubTotal = $fila['GriSubTotal'];
					$GarantiaRepuestoIsuzu->GriImpuesto = $fila['GriImpuesto'];
					$GarantiaRepuestoIsuzu->GriTotal = $fila['GriTotal'];
			
					$GarantiaRepuestoIsuzu->GriObservacion = $fila['GriObservacion'];
					$GarantiaRepuestoIsuzu->GriObservacionImpresa = $fila['GriObservacionImpresa'];
					
					$GarantiaRepuestoIsuzu->GriEstado = $fila['GriEstado'];
					$GarantiaRepuestoIsuzu->GriTiempoCreacion = $fila['NGriTiempoCreacion'];  
					$GarantiaRepuestoIsuzu->GriTiempoModificacion = $fila['NGriTiempoModificacion']; 
					
			$GarantiaRepuestoIsuzu->CliNombre = $fila['CliNombre'];
			$GarantiaRepuestoIsuzu->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$GarantiaRepuestoIsuzu->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$GarantiaRepuestoIsuzu->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$GarantiaRepuestoIsuzu->TdoId = $fila['TdoId'];
			
			
			$GarantiaRepuestoIsuzu->EinId = $fila['EinId'];
			$GarantiaRepuestoIsuzu->EinVIN = $fila['EinVIN'];
			$GarantiaRepuestoIsuzu->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];
			
			$GarantiaRepuestoIsuzu->VmaId = $fila['VmaId'];
			$GarantiaRepuestoIsuzu->VmoId = $fila['VmoId'];
			$GarantiaRepuestoIsuzu->EinPlaca = $fila['EinPlaca'];
			
			$GarantiaRepuestoIsuzu->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$GarantiaRepuestoIsuzu->EinNumeroMotor = $fila['EinNumeroMotor'];
			$GarantiaRepuestoIsuzu->EinColor = $fila['EinColor'];
			$GarantiaRepuestoIsuzu->EinPoliza = $fila['EinPoliza'];

				
			$GarantiaRepuestoIsuzu->VmaNombre = $fila['VmaNombre'];
			$GarantiaRepuestoIsuzu->VmoNombre = $fila['VmoNombre'];
			
			$GarantiaRepuestoIsuzu->FinId = $fila['FinId'];
			
			$GarantiaRepuestoIsuzu->LtiNombre = $fila['LtiNombre'];
			$GarantiaRepuestoIsuzu->LtiAbreviatura = $fila['LtiAbreviatura'];
				
			$GarantiaRepuestoIsuzu->FinFecha = $fila['NFinFecha'];
			$GarantiaRepuestoIsuzu->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			
			$GarantiaRepuestoIsuzu->CamBoletinCodigo = $fila['CamBoletinCodigo'];
			$GarantiaRepuestoIsuzu->CamNombre = $fila['CamNombre'];
			
			$GarantiaRepuestoIsuzu->GriTotalLlamadas = $fila['GriTotalLlamadas'];
		 
		 $GarantiaRepuestoIsuzu->AmoId = $fila['AmoId'];
		 
		 
		 
			switch($GarantiaRepuestoIsuzu->GriEstado){
				
				case 1:
					$GarantiaRepuestoIsuzu->GriEstadoDescripcion =  "Pendiente";
				break;
				
				case 5:
					$GarantiaRepuestoIsuzu->GriEstadoDescripcion =  "Entregado";
				break;
				
				case 6:
					$GarantiaRepuestoIsuzu->GriEstadoDescripcion =  "Anulado";
				break;
                
				case 7:
					$GarantiaRepuestoIsuzu->GriEstadoDescripcion =  "C/ Transaccion";
				break;
                
				case 8:
					$GarantiaRepuestoIsuzu->GriEstadoDescripcion =  "Pagado";
				break;
				
				case 9:
					$GarantiaRepuestoIsuzu->GriEstadoDescripcion =  "Facturado";
				break;
				
			}
			
			
                    $GarantiaRepuestoIsuzu->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GarantiaRepuestoIsuzu;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarGarantiaRepuestoIsuzu($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsGarantiaRepuestoIsuzuDetalle = new ClsGarantiaRepuestoIsuzuDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					$aux = explode("%",$elemento);	
					
					$ResGarantiaRepuestoIsuzuDetalle = $InsGarantiaRepuestoIsuzuDetalle->MtdObtenerGarantiaRepuestoIsuzuDetalles(NULL,NULL,'GdiId','Desc',NULL,$aux[0]);
					$ArrGarantiaRepuestoIsuzuDetalles = $ResGarantiaRepuestoIsuzuDetalle['Datos'];

					if(!empty($ArrGarantiaRepuestoIsuzuDetalles)){
						$amdetalle = '';

						foreach($ArrGarantiaRepuestoIsuzuDetalles as $DatGarantiaRepuestoIsuzuDetalle){
							$amdetalle .= '#'.$DatGarantiaRepuestoIsuzuDetalle->GdiId;
						}

						if(!$InsGarantiaRepuestoIsuzuDetalle->MtdEliminarGarantiaRepuestoIsuzuDetalle($amdetalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblgrigarantiarepuestoisuzu WHERE  (GriId = "'.($aux[0]).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarGarantiaRepuestoIsuzu(3,"Se elimino la GarantiaRepuestoIsuzu",$aux);		
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
	public function MtdActualizarEstadoGarantiaRepuestoIsuzu($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tblgrigarantiarepuestoisuzu SET GriEstado = '.$oEstado.' WHERE GriId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
							$Auditoria = "Se actualizo el Estado de la GarantiaRepuestoIsuzu";
						

						$this->GriId = $elemento;						
						$this->MtdAuditarGarantiaRepuestoIsuzu(2,$Auditoria,$elemento);

					}
				}
			$i++;
	
			}

		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	
	
	public function MtdGenerarGarantiaRepuestoIsuzu($oElementos,$oTransaccion = true,$oCambiarEstado = true) {
		
		global $EmpresaImpuestoVenta;
		global $EmpresaMonedaId;
		global $InsConfiguracionEmpresa;
		global $EmpresaProvincia;
		
		$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
		$InsConfiguracionEmpresa->CemId = "CEM-10000";
		$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			if(!empty($elemento)){
					
				$InsFichaIngreso = new ClsFichaIngreso();
				$InsFichaIngreso->FinId = $elemento;
				$InsFichaIngreso->MtdObtenerFichaIngreso();
				$validar = 0;
				
				$modalidades= 0;	
				
				if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
					foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
						$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
						if($InsFichaAccion->MinSigla == "GR"  ){
							
							$modalidades++;
								
						}
						
						
					}
				}
					

			  if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
				  foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
					  
					  $GuardarFichaAccion = true;
					  
					  $InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
					  $InsTallerPedido = $DatFichaIngresoModalidad->FichaAccion->TallerPedido;
					  
						  if(
						  $InsFichaAccion->MinSigla == "GR" 
						  ){
	  
							  $GarantiaRepuestoIsuzuId = $this->MtdVerificarExisteGarantiaRepuestoIsuzu("FccId",$InsFichaAccion->FccId);
						  
							  if(empty($GarantiaRepuestoIsuzuId)){		
							  
								  $InsFichaIngreso = new ClsFichaIngreso();
								  $InsFichaIngreso->FinId = $InsFichaAccion->FinId;
								  $InsFichaIngreso->MtdObtenerFichaIngreso();
	
//								  $this->FinId = $InsFichaIngreso->FinId;
//								  $this->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
//								  
//								  $this->CliId = $InsFichaIngreso->CliId;
//								  $this->CliNombre = $InsFichaIngreso->CliNombre;
//								  $this->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
//								  $this->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
//								  $this->TdoId = $InsFichaIngreso->TdoId;
//								  $this->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
//								 
//								  $this->EinVIN = $InsFichaIngreso->EinVIN;
//								  $this->VmaNombre = $InsFichaIngreso->VmaNombre;
//								  $this->VmoNombre = $InsFichaIngreso->VmaNombre;
//								  $this->GriModelo = $InsFichaIngreso->VmaNombre." ".$InsFichaIngreso->VmoNombre." ".$InsFichaIngreso->VveNombre;
//								  $this->EinPlaca = $InsFichaIngreso->EinPlaca;
							  
//								  $this->VmaId = $InsFichaIngreso->VmaId;
//								  $this->VmoId = $InsFichaIngreso->VmoId;
//								  $this->VmoId = $InsFichaIngreso->VmoId;
//								  $this->FccId = $InsFichaAccion->FccId;
								  
								  $this->GriCliente = $InsFichaIngreso->CliNombre." ".$InsFichaIngreso->CliApellidoPaterno." ".$InsFichaIngreso->CliApellidoMaterno;
								  $this->GriDireccion = $InsFichaIngreso->CliDireccion."".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliProvincia;
								  $this->GriCiudad = $EmpresaProvincia;
								  $this->GriTelefono = $InsFichaIngreso->FinTelefono;
								  $this->GriCelular = $InsFichaIngreso->FinCelular;
								  
								$this->GriFechaEmision = FncCambiaFechaAMysql($InsFichaIngreso->FinFecha);//date("d/m/Y");
								list($this->GriAno,$this->GriMes,$aux) = explode("-",$this->GriFechaEmision);
								$this->GriFechaSalida = FncCambiaFechaAMysql($InsFichaIngreso->FinTiempoTrabajoTerminado);
								
								$this->GriVIN = $InsFichaIngreso->EinVIN;
								$this->GriModelo = $InsFichaIngreso->VmoNombre;
								$this->GriFechaEntrega = $InsFichaIngreso->EinFechaVenta;
								$this->GriKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
								$this->GriPlaca = $InsFichaIngreso->EinPlaca;
								  
								$this->MonId = "MON-10001";
								
								$InsTipoCambio = new ClsTipoCambio();
								$InsTipoCambio->MonId = "MON-10001";
								$InsTipoCambio->TcaFecha = date("Y-m-d");
						  
								$InsTipoCambio->MtdObtenerTipoCambioActual();
						  
								if(empty($InsTipoCambio->TcaId)){
									$InsTipoCambio->MtdObtenerTipoCambioUltimo();
								}
									  
								$this->GriTipoCambio = $InsTipoCambio->TcaMontoComercial;
								  
								$this->GriFichaIngreso = ($InsFichaIngreso->FinId);
								$this->GriFichaIngresoFecha = FncCambiaFechaAMysql($InsFichaIngreso->FinFecha);
								$this->GriFichaIngresoFechaSalida = FncCambiaFechaAMysql($InsFichaIngreso->FinTiempoTrabajoTerminado);
								
								$this->GriRepuestos = $InsTipoCambio->TcaMontoComercial;
								$this->GriManoObra = $InsTipoCambio->TcaMontoComercial;
								$this->GriMateriales = $InsTipoCambio->TcaMontoComercial;
								$this->GriTercerizacion = $InsTipoCambio->TcaMontoComercial;
								 
								  $this->GriVIN = $EmpresaImpuestoVenta;
								  
								  $this->GriObservacion = chr(13).date("d/m/Y H:i:s")." - Garantia Repuesto Isuzu Generada de Ord. Trab.:".$InsFichaIngreso->FinId;
	
								  $this->GriEstado = 1;
								  $this->GriTiempoCreacion = date("Y-m-d H:i:s");
								  $this->GriTiempoModificacion = date("Y-m-d H:i:s");
	  
								  $this->GriManoObra = 0;
								  $this->GriKilometraje = 0;
								  $this->GriPlaca = 0;
								  $this->GriFichaIngreso = 0;
								  
								  $this->GriTotalRepuesto = 0;
								  $this->GriTotalManoObra = 0;
								  
								  $this->GriSubTotal = 0;
								  $this->GriImpuesto = 0;
								  $this->GriTotal = 0;
									  
									  $InsTallerPedido = new ClsTallerPedido($this->InsMysql);
									  
									  $ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
									  $ArrTallerPedidos = $ResTallerPedido['Datos'];
									  
									  if(!empty($ArrTallerPedidos)){	
										  foreach($ArrTallerPedidos as $DatTallerPedido){
							  
											  $InsTallerPedido->AmoId = $DatTallerPedido->AmoId; 
											  $InsTallerPedido->MtdObtenerTallerPedido();	
											  
											  
											  if(!empty($InsTallerPedido->TallerPedidoDetalle)){
												  foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	

													  $ProductoListaPrecio = 0;

													  if(!empty($DatTallerPedidoDetalle->ProCodigoOriginal)){
														  
														  $InsProductoListaPrecio = new ClsProductoListaPrecio();
														  $RepProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatTallerPedidoDetalle->ProCodigoOriginal,"PlpId","ASC","1",NULL);
														  $ArrProductoListaPrecios = $RepProductoListaPrecio['Datos'];
														  
														  foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
															  
															  if($this->MonId <> $EmpresaMonedaId){						
																  if($DatProductoListaPrecio->MonId == $this->MonId){
																	  $ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
																  }else{
																	  $ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$this->GriTipoCambio);
																  }					
															  }else{
																  $ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
															  }
														  }
														  
														  if(empty($ProductoListaPrecio)){
															  
															  $InsListaPrecio = new ClsListaPrecio();//MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL);
															  $ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId', 'ASC',"1",$DatTallerPedidoDetalle->ProId,"LTI-10015",$DatTallerPedidoDetalle->UmeId);
															  $ArrListaPrecios = $ResListaPrecio['Datos'];
															  
															  foreach($ArrListaPrecios as $DatListaPrecio){
																  
																  if($this->MonId == $EmpresaMonedaId){	
																	  
																	  $ProductoListaPrecio = $DatListaPrecio->LprCosto;
																					  
																  }else{
																	  
																	  //deb($DatTallerPedidoDetalle->ProId." - ".$EmpresaMonedaId." - ".$this->MonId);
																	  if($DatListaPrecio->MonId == $this->MonId){
																		  $ProductoListaPrecio = ($DatListaPrecio->LprCosto/$DatListaPrecio->ProTipoCambio);
																	  }else{
																		  $ProductoListaPrecio = ($DatListaPrecio->LprCosto/$this->GriTipoCambio);
																	  }	
																	  
																  }
																  
															  }
														  
														  }
														  
													  }
													  
													  $CostoTotal = $ProductoListaPrecio * $DatTallerPedidoDetalle->AmdCantidad;
													  $MargenUtilidad = empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;

													  $InsGarantiaRepuestoIsuzuDetalle1 = new ClsGarantiaRepuestoIsuzuDetalle();
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiId = NULL;
													  $InsGarantiaRepuestoIsuzuDetalle1->AmdId = $DatTallerPedidoDetalle->AmdId;
													  $InsGarantiaRepuestoIsuzuDetalle1->ProId = $DatTallerPedidoDetalle->ProId;
													  $InsGarantiaRepuestoIsuzuDetalle1->UmeId = $DatTallerPedidoDetalle->UmeId;
													  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiCodigo = $DatTallerPedidoDetalle->ProCodigoOriginal;
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiNombre = $DatTallerPedidoDetalle->ProNombre;
										  
													  if($this->MonId<>$EmpresaMonedaId ){
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCosto = $ProductoListaPrecio * $this->GriTipoCambio;
													  }else{
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCosto = $ProductoListaPrecio;
													  }
										  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiCantidad = $DatTallerPedidoDetalle->AmdCantidad;
													  
													  if($this->MonId<>$EmpresaMonedaId ){
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiValorTotal = $CostoTotal * $this->GriTipoCambio;
													  }else{
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiValorTotal = $CostoTotal;
													  }		
													  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiMargen = $MargenUtilidad;
													  
													  if($this->MonId<>$EmpresaMonedaId ){
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCostoMargen = (( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal) * $this->GriTipoCambio;
													  }else{
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCostoMargen = ( ( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal );
													  }
										  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiEstado = 1;
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiTiempoCreacion = date("Y-m-d H:i:s");
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiTiempoModificacion = date("Y-m-d H:i:s");
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiEliminado = 1;				
													  $InsGarantiaRepuestoIsuzuDetalle1->InsMysql = NULL;
													  
													  $this->GarantiaRepuestoIsuzuDetalle[] = $InsGarantiaRepuestoIsuzuDetalle1;		
													  
													  $this->GriManoObra += $InsGarantiaRepuestoIsuzuDetalle1->GdiValorTotal;	
	  
												  }
											  }
											  
										  }
									  }

									  if(!empty($InsConfiguracionEmpresa->CalId)){
	  
										  if($this->MonId <> $InsConfiguracionEmpresa->MonId){
											  
											  $InsConfiguracionEmpresa->CalCosto = $InsConfiguracionEmpresa->CalCosto / $InsConfiguracionEmpresa->CalTipoCambio;
										  }
	  
									  }
									  
									  if(!empty($InsFichaAccion->FichaAccionTempario)){
										  foreach($InsFichaAccion->FichaAccionTempario as $DatFichaAccionTempario){					
								  
											  $Costo = $InsConfiguracionEmpresa->CalCosto * $DatFichaAccionTempario->FaeTiempo;
											  
											  $InsGarantiaRepuestoIsuzuManoObra1 = new ClsGarantiaRepuestoIsuzuManoObra();
											  $InsGarantiaRepuestoIsuzuManoObra1->GopId = NULL;
											  $InsGarantiaRepuestoIsuzuManoObra1->FaeId = $DatFichaAccionTempario->FaeId;

											  $InsGarantiaRepuestoIsuzuManoObra1->GdmOperacion = $DatFichaAccionTempario->FaeCodigo;
								  
											  if($this->MonId<>$EmpresaMonedaId ){
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmCosto = $Costo * $this->GriTipoCambio;
											  }else{
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmCosto = $Costo;
											  }
											  
											  $InsGarantiaRepuestoIsuzuManoObra1->GdmCodigo = $DatFichaAccionTempario->FaeTiempo;
								  
											  if($this->MonId<>$EmpresaMonedaId ){
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmTiempo = $InsConfiguracionEmpresa->CalCosto * $this->GriTipoCambio;
											  }else{
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmTiempo = $InsConfiguracionEmpresa->CalCosto;
											  }
										  
											  $InsGarantiaRepuestoIsuzuManoObra1->GopEstado = 1;
											  $InsGarantiaRepuestoIsuzuManoObra1->GopTiempoCreacion = date("Y-m-d H:i:s");
											  $InsGarantiaRepuestoIsuzuManoObra1->GopTiempoModificacion = date("Y-m-d H:i:s");
											  $InsGarantiaRepuestoIsuzuManoObra1->GopEliminado = 1;				
											  $InsGarantiaRepuestoIsuzuManoObra1->InsMysql = NULL;
											  
											  $this->GarantiaRepuestoIsuzuManoObra[] = $InsGarantiaRepuestoIsuzuManoObra1;		
														  
											  $this->GriTotalManoObra += $InsGarantiaRepuestoIsuzuManoObra1->GdmCosto;	
											  
										  }
									  }		
									  
									  $this->GriTotalRepuesto = $this->GriManoObra;
									  $this->GriSubTotal = $this->GriTotalRepuesto + $this->GriTotalManoObra;
									  $this->GriImpuesto = $this->GriSubTotal * ($this->GriVIN/100);
									  $this->GriTotal = $this->GriSubTotal + $this->GriImpuesto;
  

								  if($this->MtdRegistrarGarantiaRepuestoIsuzu(false)){
									  
									  if($oCambiarEstado){

										  
									  }
									  
									  $validar++;
									  
								  }
								  
								  
							  }else{
								  
									  $this->GriId = $GarantiaRepuestoIsuzuId;
									  $this->MtdObtenerGarantiaRepuestoIsuzu();
									  
									  if(!empty($this->GarantiaRepuestoIsuzuDetalle)){
										  foreach($this->GarantiaRepuestoIsuzuDetalle as $DatGarantiaRepuestoIsuzuDetalle){										
										  $InsGarantiaRepuestoIsuzuDetalle = new ClsGarantiaRepuestoIsuzuDetalle();
										  $InsGarantiaRepuestoIsuzuDetalle->MtdEliminarGarantiaRepuestoIsuzuDetalle($DatGarantiaRepuestoIsuzuDetalle->GdiId);
											  
										  }
										  
										  $this->GarantiaRepuestoIsuzuDetalle = NULL;
									  }
									  
									  if(!empty($this->GarantiaRepuestoIsuzuManoObra)){
										  foreach($this->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuDetalle){										
										  
											  $InsClsGarantiaRepuestoIsuzuManoObra = new ClsGarantiaRepuestoIsuzuManoObra();
											  $InsClsGarantiaRepuestoIsuzuManoObra->MtdEliminarGarantiaRepuestoIsuzuManoObra($DatGarantiaRepuestoIsuzuDetalle->GopId);
											  
										  }
										  
										  $this->GarantiaRepuestoIsuzuManoObra = NULL;
									  }
									  
									  $InsFichaIngreso = new ClsFichaIngreso();
									  $InsFichaIngreso->FinId = $InsFichaAccion->FinId;
									  $InsFichaIngreso->MtdObtenerFichaIngreso();
	  
	  
									  $this->FinId = $InsFichaIngreso->FinId;
									  $this->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
									  
									  $this->GriFechaEmision = FncCambiaFechaAMysql($InsFichaIngreso->FinFecha);//date("d/m/Y");
									  
									  list($this->GriAno,$this->GriMes,$aux) = explode("-",$this->GriFechaEmision);
									  
									  $this->EinVIN = $InsFichaIngreso->EinVIN;
									  $this->VmaNombre = $InsFichaIngreso->VmaNombre;
									  $this->VmoNombre = $InsFichaIngreso->VmaNombre;
									  $this->GriManoObra = $InsFichaIngreso->VmaNombre." ".$InsFichaIngreso->VmoNombre." ".$InsFichaIngreso->VveNombre;
									  $this->EinPlaca = $InsFichaIngreso->EinPlaca;
								  
									  $this->VmaId = $InsFichaIngreso->VmaId;
									  $this->VmoId = $InsFichaIngreso->VmoId;
									  $this->VmoId = $InsFichaIngreso->VmoId;
									  
									  $this->FccId = $InsFichaAccion->FccId;
									  
									  $this->CliId = $InsFichaIngreso->CliId;
									  $this->CliNombre = $InsFichaIngreso->CliNombre;
									  $this->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
									  $this->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
									  $this->TdoId = $InsFichaIngreso->TdoId;
									  $this->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
									  $this->GriDireccion = $InsFichaIngreso->FinDireccion;
									  $this->GriCiudad = "Tacna";
									  $this->GriTelefono = $InsFichaIngreso->FinTelefono;
									  $this->GriCelular = $InsFichaIngreso->FinCelular;
									  
									  $this->MonId = "MON-10001";
									  $this->GriRepuestos = 50;

									  if($InsFichaAccion->MinSigla == "PP"){

											  $causa = 1;
											  if(!empty($InsFichaAccion->FichaAccionTarea)){
												  foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
													  
													  $this->GriTercerizacion .= " ".$causa.".- ".$DatFichaAccionTarea->FatDescripcion.chr(13);
													  $causa++;
													  
												  }
											  }	
											  
											  $solucion = 1;
											  if(!empty($InsFichaAccion->FichaAccionTarea)){
												  foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
													  
													  
													  switch($DatFichaAccionTarea->FatAccion){
														  case "L":
															  $this->GriMateriales .= "PLANCHADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);											
														  break;
														  
														  case "N":
															  $this->GriMateriales .= "PINTADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);													
														  break;
														  
														  case "E":
																  $this->GriMateriales .= "CENTRADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);																									
														  break;
														  
														  case "Z":
															  $this->GriMateriales .= "REPARACION/".$DatFichaAccionTarea->FatDescripcion.chr(13);												
														  break;
													  }
													  
													  $solucion++;
													  
												  }
											  }	
			  
									  }else{
										  //$this->GriTercerizacion = addslashes($InsFichaAccion->FccCausa);
										  //$this->GriMateriales = addslashes($InsFichaAccion->FccSolucion);	
										  $this->GriTercerizacion = addslashes(strip_tags($InsFichaAccion->FccCausa));
										  $this->GriMateriales = addslashes(strip_tags($InsFichaAccion->FccSolucion));	
//																								
									  }
									  
									  
									  $InsTipoCambio = new ClsTipoCambio();
									  $InsTipoCambio->MonId = "MON-10001";
									  $InsTipoCambio->TcaFecha = date("Y-m-d");
							  
									  $InsTipoCambio->MtdObtenerTipoCambioActual();
							  
									  if(empty($InsTipoCambio->TcaId)){
										  $InsTipoCambio->MtdObtenerTipoCambioUltimo();
									  }
										  
									  $this->GriTipoCambio = $InsTipoCambio->TcaMontoComercial;
									  $this->GriVIN = $EmpresaImpuestoVenta;
									  
									  $this->GriObservacion = chr(13).date("d/m/Y H:i:s")." - Garantia Repuesto Isuzu Generada de Ord. Trab.:".$InsFichaIngreso->FinId;
									  $this->GriEstado = 1;
									  $this->GriTiempoCreacion = date("Y-m-d H:i:s");
									  $this->GriTiempoModificacion = date("Y-m-d H:i:s");

									  $this->GriManoObra = 0;
									  $this->GriKilometraje = 0;
									  $this->GriPlaca = 0;
									  $this->GriFichaIngreso = 0;
									  
									  $this->GriTotalRepuesto = 0;
									  $this->GriTotalManoObra = 0;
									  
									  $this->GriSubTotal = 0;
									  $this->GriImpuesto = 0;
									  $this->GriTotal = 0;
		  
									  
									  
									  $InsTallerPedido = new ClsTallerPedido($this->InsMysql);
									  
									  $ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
									  $ArrTallerPedidos = $ResTallerPedido['Datos'];
									  
									  if(!empty($ArrTallerPedidos)){	
										  foreach($ArrTallerPedidos as $DatTallerPedido){
							  
											  $InsTallerPedido->AmoId = $DatTallerPedido->AmoId; 
											  $InsTallerPedido->MtdObtenerTallerPedido();	
											  
											  //deb($InsTallerPedido->TallerPedidoDetalle);
											  if(!empty($InsTallerPedido->TallerPedidoDetalle)){
												  foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	

													  $ProductoListaPrecio = 0;
										  
													  if(!empty($DatTallerPedidoDetalle->ProCodigoOriginal)){
														  
														  $InsProductoListaPrecio = new ClsProductoListaPrecio();
														  $RepProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatTallerPedidoDetalle->ProCodigoOriginal,"PlpId","ASC","1",NULL);
														  $ArrProductoListaPrecios = $RepProductoListaPrecio['Datos'];

														  foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
															  
															  if($this->MonId <> $EmpresaMonedaId){	
																  
																  if($DatProductoListaPrecio->MonId == $this->MonId){
																	  $ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
																  }else{
																	  $ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$this->GriTipoCambio);
																  }		
															  
															  }else{
																  $ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
															  }
															  
														  }
														  
														  
														  
														  
														  
														  if(empty($ProductoListaPrecio)){
															  
															  $InsListaPrecio = new ClsListaPrecio();//MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL);
															  $ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId', 'ASC',"1",$DatTallerPedidoDetalle->ProId,"LTI-10015",$DatTallerPedidoDetalle->UmeId);
															  $ArrListaPrecios = $ResListaPrecio['Datos'];
															  
															  foreach($ArrListaPrecios as $DatListaPrecio){
																  
																  if($this->MonId == $EmpresaMonedaId){	
																	  
																	  $ProductoListaPrecio = $DatListaPrecio->LprCosto;
																					  
																  }else{
																	  
																	  //deb($DatTallerPedidoDetalle->ProId." - ".$EmpresaMonedaId." - ".$this->MonId);
																	  if($DatListaPrecio->MonId == $this->MonId){
																		  $ProductoListaPrecio = ($DatListaPrecio->LprCosto/$DatListaPrecio->ProTipoCambio);
																	  }else{
																		  $ProductoListaPrecio = ($DatListaPrecio->LprCosto/$this->GriTipoCambio);
																	  }	
																	  
																  }

															  }
														  
														  }
														  
														  
													  }
													  
													  $CostoTotal = $ProductoListaPrecio * $DatTallerPedidoDetalle->AmdCantidad;
													  $MargenUtilidad = empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;
			  
													  $InsGarantiaRepuestoIsuzuDetalle1 = new ClsGarantiaRepuestoIsuzuDetalle();
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiId = NULL;
													  $InsGarantiaRepuestoIsuzuDetalle1->AmdId = $DatTallerPedidoDetalle->AmdId;
													  $InsGarantiaRepuestoIsuzuDetalle1->ProId = $DatTallerPedidoDetalle->ProId;
													  $InsGarantiaRepuestoIsuzuDetalle1->UmeId = $DatTallerPedidoDetalle->UmeId;
													  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiCodigo = $DatTallerPedidoDetalle->ProCodigoOriginal;
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiNombre = $DatTallerPedidoDetalle->ProNombre;
										  
													  if($this->MonId<>$EmpresaMonedaId ){
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCosto = $ProductoListaPrecio * $this->GriTipoCambio;
													  }else{
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCosto = $ProductoListaPrecio;
													  }
										  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiCantidad = $DatTallerPedidoDetalle->AmdCantidad;
													  
													  if($this->MonId<>$EmpresaMonedaId ){
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiValorTotal = $CostoTotal * $this->GriTipoCambio;
													  }else{
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiValorTotal = $CostoTotal;
													  }		
													  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiMargen = $MargenUtilidad;
													  
													  if($this->MonId<>$EmpresaMonedaId ){
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCostoMargen = (( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal) * $this->GriTipoCambio;
													  }else{
														  $InsGarantiaRepuestoIsuzuDetalle1->GdiCostoMargen = ( ( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal );
													  }
										  
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiEstado = 1;
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiTiempoCreacion = date("Y-m-d H:i:s");
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiTiempoModificacion = date("Y-m-d H:i:s");
													  $InsGarantiaRepuestoIsuzuDetalle1->GdiEliminado = 1;				
													  $InsGarantiaRepuestoIsuzuDetalle1->InsMysql = NULL;
													  
													  $this->GarantiaRepuestoIsuzuDetalle[] = $InsGarantiaRepuestoIsuzuDetalle1;		
													  //$this->GriManoObra += $InsGarantiaRepuestoIsuzuDetalle1->GdiCostoMargen;	
													  $this->GriManoObra += $InsGarantiaRepuestoIsuzuDetalle1->GdiValorTotal;	
													  
													  

												  }
											  }
				  
				  
				  
										  }
									  }
									  
									  
									  
									  if(!empty($InsConfiguracionEmpresa->CalId)){
	  
										  if($this->MonId <> $InsConfiguracionEmpresa->MonId){
											  $InsConfiguracionEmpresa->CalCosto = $InsConfiguracionEmpresa->CalCosto / $InsConfiguracionEmpresa->CalTipoCambio;
										  }
	  
									  }
									  
								  
									  if(!empty($InsFichaAccion->FichaAccionTempario)){
										  foreach($InsFichaAccion->FichaAccionTempario as $DatFichaAccionTempario){					
								  
											  $Costo = $InsConfiguracionEmpresa->CalCosto * $DatFichaAccionTempario->FaeTiempo;
											  
											  $InsGarantiaRepuestoIsuzuManoObra1 = new ClsGarantiaRepuestoIsuzuManoObra();
											  $InsGarantiaRepuestoIsuzuManoObra1->GopId = NULL;
											  $InsGarantiaRepuestoIsuzuManoObra1->FaeId = $DatFichaAccionTempario->FaeId;
											  
											  $InsGarantiaRepuestoIsuzuManoObra1->GdmOperacion = $DatFichaAccionTempario->FaeCodigo;
								  
											  if($this->MonId<>$EmpresaMonedaId ){
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmCosto = $Costo * $this->GriTipoCambio;
											  }else{
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmCosto = $Costo;
											  }
											  
											  $InsGarantiaRepuestoIsuzuManoObra1->GdmCodigo = $DatFichaAccionTempario->FaeTiempo;
								  
											  if($this->MonId<>$EmpresaMonedaId ){
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmTiempo = $InsConfiguracionEmpresa->CalCosto * $this->GriTipoCambio;
											  }else{
												  $InsGarantiaRepuestoIsuzuManoObra1->GdmTiempo = $InsConfiguracionEmpresa->CalCosto;
											  }
										  
											  $InsGarantiaRepuestoIsuzuManoObra1->GopEstado = 1;
											  $InsGarantiaRepuestoIsuzuManoObra1->GopTiempoCreacion = date("Y-m-d H:i:s");
											  $InsGarantiaRepuestoIsuzuManoObra1->GopTiempoModificacion = date("Y-m-d H:i:s");
											  $InsGarantiaRepuestoIsuzuManoObra1->GopEliminado = 1;				
											  $InsGarantiaRepuestoIsuzuManoObra1->InsMysql = NULL;
											  
											  $this->GarantiaRepuestoIsuzuManoObra[] = $InsGarantiaRepuestoIsuzuManoObra1;		
														  
											  $this->GriTotalManoObra += $InsGarantiaRepuestoIsuzuManoObra1->GdmCosto;	
												  
										  }
									  }		
									  
									  $this->GriTotalRepuesto = $this->GriManoObra;
									  $this->GriSubTotal = $this->GriTotalRepuesto + $this->GriTotalManoObra;
									  $this->GriImpuesto = $this->GriSubTotal * ($this->GriVIN/100);
									  $this->GriTotal = $this->GriSubTotal + $this->GriImpuesto;
  
									  
									  if($this->MtdEditarGarantiaRepuestoIsuzu(false)){
										  
									  }
							  
								  $validar++;	
							  }
		  
  
							  
						  }
					  
		  
				  }
			  }
							
					
				  
			  if($validar <> $modalidades ){
				  $error = true;
			  }else{
				  
			  }
					
					
		}
	$i++;
	
	}

		//deb($validar." - ".count($InsFichaIngreso->FichaIngresoModalidad));
		
		//if($validar <> count($InsFichaIngreso->FichaIngresoModalidad) ){
//		if($validar <> count($InsFichaIngreso->FichaIngresoModalidad) ){
//		if($validar <> $modalidades ){
//			$error = true;
//		}
					
					
		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	
	public function MtdRegistrarGarantiaRepuestoIsuzu($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarGarantiaRepuestoIsuzuId();
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

//			if(!empty($this->GriFechaSalida)){
//				$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
//				$InsFichaAccion->FccId = $this->FccId;
//				$InsFichaAccion->MtdObtenerFichaAccion();
//				
//				$InsVehiculoIngreso = new ClsVehiculoIngreso();
//				$InsVehiculoIngreso->MtdEditarClienteDato("CliDireccion",$this->GriFechaSalida,$InsFichaAccion->EinId);
//			}

			$sql = 'INSERT INTO tblgrigarantiarepuestoisuzu (
			GriId,
			FccId,
			CliId,
			
			GriCliente,
			GriDireccion,
			GriCiudad,
			GriTelefono,
			GriCelular,
			
			GriFechaEmision,
			GriFechaSalida,
			
			GriVIN,
			GriModelo,
			GriFechaEntrega,
			GriKilometraje,
			GriPlaca,
			
			MonId,
			GriTipoCambio,
			
			GriFichaIngreso,
			GriFichaIngresoFecha,
			GriFichaIngresoFechaSalida,
		
			GriRepuestos,
			GriManoObra,
			GriMateriales,
			GriTercerizacion,
			
			GriSintomas,
			GriHistorialServicio,
			GriDiagnostico,
			GriCausaFalla,
			GriDetalleReparacion,
			
			GriSubTotal,
			GriImpuesto,
			GriTotal,
			
			GriObservacion,
			GriObservacionImpresa,
			
			GriEstado,			
			GriTiempoCreacion,
			GriTiempoModificacion) 
			VALUES (
			"'.($this->GriId).'", 
			"'.($this->FccId).'", 
			"'.($this->CliId).'", 

			"'.($this->GriCliente).'", 
			"'.($this->GriDireccion).'",
			"'.($this->GriCiudad).'",
			"'.($this->GriTelefono).'",
			"'.($this->GriCelular).'",
			
			"'.($this->GriFechaEmision).'",
			"'.($this->GriFechaSalida).'",
			
			"'.($this->GriVIN).'",
			"'.($this->GriModelo).'",
			'.(empty($this->GriFechaEntrega)?"NULL,":'"'.$this->GriFechaEntrega.'",').'
			"'.($this->GriKilometraje).'",
			"'.($this->GriPlaca).',"
			
			"'.($this->MonId).'",
			'.(empty($this->GriTipoCambio)?"GriTipoCambio,":''.$this->GriTipoCambio.',').'

			'.($this->GriFichaIngreso).',
			'.(empty($this->GriFichaIngresoFecha)?"NULL,":'"'.$this->GriFichaIngresoFecha.'",').'
			'.(empty($this->GriFichaIngresoFechaSalida)?"NULL,":'"'.$this->GriFichaIngresoFechaSalida.'",').'

			"'.($this->GriRepuestos).'",
			"'.($this->GriManoObra).'",
			"'.($this->GriMateriales).'",
			"'.($this->GriTercerizacion).'",
			
			"'.($this->GriSintomas).'",
			"'.($this->GriHistorialServicio).'",
			"'.($this->GriDiagnostico).'",
			"'.($this->GriCausaFalla).'",
			"'.($this->GriDetalleReparacion).'",
			
			'.($this->GriSubTotal).',
			'.($this->GriImpuesto).',
			'.($this->GriTotal).',

			"'.($this->GriObservacion).'",
			"'.($this->GriObservacionImpresa).'",

			'.($this->GriEstado).',
			"'.($this->GriTiempoCreacion).'",
			"'.($this->GriTiempoModificacion).'");';			

			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
				if(!$resultado) {							
					$error = true;
				} 
			}

			if(!$error){			
			
				if (!empty($this->GarantiaRepuestoIsuzuDetalle)){		
						
					$validar = 0;				

					foreach ($this->GarantiaRepuestoIsuzuDetalle as $DatGarantiaRepuestoIsuzuDetalle){
						
						$InsGarantiaRepuestoIsuzuDetalle = new ClsGarantiaRepuestoIsuzuDetalle();
						$InsGarantiaRepuestoIsuzuDetalle->GriId = $this->GriId;
						
						$InsGarantiaRepuestoIsuzuDetalle->AmdId = $DatGarantiaRepuestoIsuzuDetalle->AmdId;
						$InsGarantiaRepuestoIsuzuDetalle->ProId = $DatGarantiaRepuestoIsuzuDetalle->ProId;
						$InsGarantiaRepuestoIsuzuDetalle->UmeId = $DatGarantiaRepuestoIsuzuDetalle->UmeId;
						
						$InsGarantiaRepuestoIsuzuDetalle->GdiCodigo = $DatGarantiaRepuestoIsuzuDetalle->GdiCodigo;
						$InsGarantiaRepuestoIsuzuDetalle->GdiNombre = $DatGarantiaRepuestoIsuzuDetalle->GdiNombre;
						
						$InsGarantiaRepuestoIsuzuDetalle->GdiCosto = $DatGarantiaRepuestoIsuzuDetalle->GdiCosto;
						$InsGarantiaRepuestoIsuzuDetalle->GdiCantidad = $DatGarantiaRepuestoIsuzuDetalle->GdiCantidad;
						$InsGarantiaRepuestoIsuzuDetalle->GdiValorTotal = $DatGarantiaRepuestoIsuzuDetalle->GdiValorTotal;
				
						$InsGarantiaRepuestoIsuzuDetalle->GdiEstado = $DatGarantiaRepuestoIsuzuDetalle->GdiEstado;
						$InsGarantiaRepuestoIsuzuDetalle->GdiTiempoCreacion = $DatGarantiaRepuestoIsuzuDetalle->GdiTiempoCreacion;
						$InsGarantiaRepuestoIsuzuDetalle->GdiTiempoModificacion = $DatGarantiaRepuestoIsuzuDetalle->GdiTiempoModificacion;						
						$InsGarantiaRepuestoIsuzuDetalle->GdiEliminado = $DatGarantiaRepuestoIsuzuDetalle->GdiEliminado;

						if($InsGarantiaRepuestoIsuzuDetalle->MtdRegistrarGarantiaRepuestoIsuzuDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_GRI_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->GarantiaRepuestoIsuzuDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			if(!$error){			

				if (!empty($this->GarantiaRepuestoIsuzuManoObra)){		

					$validar = 0;					
					$InsGarantiaRepuestoIsuzuManoObra = new ClsGarantiaRepuestoIsuzuManoObra();		
											
					foreach ($this->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){

						$InsGarantiaRepuestoIsuzuManoObra->GriId = $this->GriId;
						$InsGarantiaRepuestoIsuzuManoObra->FaeId = $DatGarantiaRepuestoIsuzuManoObra->FaeId;
						
						$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion = $DatGarantiaRepuestoIsuzuManoObra->GdmOperacion;
						$InsGarantiaRepuestoIsuzuManoObra->GdmCodigo = $DatGarantiaRepuestoIsuzuManoObra->GdmCodigo;
						$InsGarantiaRepuestoIsuzuManoObra->GdmTiempo = $DatGarantiaRepuestoIsuzuManoObra->GdmTiempo;
						$InsGarantiaRepuestoIsuzuManoObra->GdmCosto = $DatGarantiaRepuestoIsuzuManoObra->GdmCosto;
						
						$InsGarantiaRepuestoIsuzuManoObra->GopEstado = $DatGarantiaRepuestoIsuzuManoObra->GopEstado;							
						$InsGarantiaRepuestoIsuzuManoObra->GopTiempoCreacion = $DatGarantiaRepuestoIsuzuManoObra->GopTiempoCreacion;
						$InsGarantiaRepuestoIsuzuManoObra->GopTiempoModificacion = $DatGarantiaRepuestoIsuzuManoObra->GopTiempoModificacion;						
						$InsGarantiaRepuestoIsuzuManoObra->GopEliminado = $DatGarantiaRepuestoIsuzuManoObra->GopEliminado;
						
						if($InsGarantiaRepuestoIsuzuManoObra->MtdRegistrarGarantiaRepuestoIsuzuManoObra()){
							
							//if(empty($InsGarantiaRepuestoIsuzuManoObra->FaeId)){
//											
//
//
//											$FichaAccionTemparioId = "";
//											
//											$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//
//											$FichaAccionTemparioId = $InsFichaAccionTempario->MtdVerificarExisteFichaAccionTemparios("FaeCodigo",$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion,$this->FccId);
//											
//											if(empty($FichaAccionTemparioId)){
//												
//												$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//												$InsFichaAccionTempario->FccId = $this->FccId;
//												$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion;
//												$InsFichaAccionTempario->FaeTiempo = $InsGarantiaRepuestoIsuzuManoObra->GdmCodigo;
//												$InsFichaAccionTempario->FaeEstado = 3;
//												$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
//												$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
//												$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();
//												
//											}else{
//												
//												$InsGarantiaRepuestoIsuzuManoObra = new ClsGarantiaRepuestoIsuzuManoObra();
//												$InsGarantiaRepuestoIsuzuManoObra->MtdEditarGarantiaRepuestoIsuzuManoObraDato("FaeId",$FichaAccionTemparioId,$InsGarantiaRepuestoIsuzuManoObra->GopId);
//													
//											}
//											
//											
//											
//							}
										
										
							$validar++;	
						}else{
							$Resultado.='#ERR_GRI_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}

					}					
					
					if(count($this->GarantiaRepuestoIsuzuManoObra) <> $validar ){
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
			$this->MtdAuditarGarantiaRepuestoIsuzu(1,"Se registro la GarantiaRepuestoIsuzu",$this);			
			return true;
		}
					
	}
	
	public function MtdEditarGarantiaRepuestoIsuzu($oTransaccion=true) {

		global $Resultado;
		$error = false;
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}
			
//			if(!empty($this->GriFechaSalida)){
//				
//				$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
//				$InsFichaAccion->FccId = $this->FccId;
//				$InsFichaAccion->MtdObtenerFichaAccion();
//				
//				$InsVehiculoIngreso = new ClsVehiculoIngreso();
//				$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFechaVenta",$this->GriFechaSalida,$InsFichaAccion->EinId);
//
//			}
			
			$sql = 'UPDATE tblgrigarantiarepuestoisuzu SET

			'.(empty($this->FccId)?'FccId = NULL, ':'FccId = "'.$this->FccId.'",').'							
			CliId = "'.($this->CliId).'",
						
			GriCliente = "'.($this->GriCliente).'",
			GriDireccion = "'.($this->GriDireccion).'",
			GriCiudad = "'.($this->GriCiudad).'",
			GriTelefono = "'.($this->GriTelefono).'",
			GriCelular = "'.($this->GriCelular).'",
			
			GriFechaEmision = "'.($this->GriFechaEmision).'",
			'.(empty($this->GriFechaSalida)?'GriFechaSalida = NULL, ':'GriFechaSalida = "'.$this->GriFechaSalida.'",').'		
			
			GriVIN = '.($this->GriVIN).',
			GriModelo = '.($this->GriModelo).',
			'.(empty($this->GriFechaEntrega)?'GriFechaEntrega = NULL, ':'GriFechaEntrega = "'.$this->GriFechaEntrega.'",').'	
			GriKilometraje = '.($this->GriKilometraje).',	
			GriPlaca = '.($this->GriPlaca).',	
			
			MonId = "'.($this->MonId).'",			
			'.(empty($this->GriTipoCambio)?'GriTipoCambio = NULL, ':'GriTipoCambio = '.$this->GriTipoCambio.',').'
			
			GriTotalRepuesto = '.($this->GriTotalRepuesto).',	
			GriTotalManoObra = '.($this->GriTotalManoObra).',	
			
			GriFichaIngreso = '.($this->GriFichaIngreso).',
			'.(empty($this->GriFichaIngresoFecha)?'GriFichaIngresoFecha = NULL, ':'GriFichaIngresoFecha = "'.$this->GriFichaIngresoFecha.'",').'
			'.(empty($this->GriFichaIngresoFechaSalida)?'GriFichaIngresoFechaSalida = NULL, ':'GriFichaIngresoFechaSalida = "'.$this->GriFichaIngresoFechaSalida.'",').'
			
			GriRepuestos = "'.($this->GriRepuestos).'",
			GriManoObra = "'.($this->GriManoObra).'",
			GriMateriales = "'.($this->GriMateriales).'",
			GriTercerizacion = "'.($this->GriTercerizacion).'",
			GriSintomas = "'.($this->GriSintomas).'",
			GriHistorialServicio = "'.($this->GriHistorialServicio).'",
			GriDiagnostico = "'.($this->GriDiagnostico).'",
			GriCausaFalla = "'.($this->GriCausaFalla).'",
			GriDetalleReparacion = "'.($this->GriDetalleReparacion).'",
			
			GriSubTotal = '.($this->GriSubTotal).',
			GriImpuesto = '.($this->GriImpuesto).',
			GriTotal = '.($this->GriTotal).',	
		
			GriEstado = '.($this->GriEstado).',
			GriTiempoModificacion = "'.($this->GriTiempoModificacion).'"

			WHERE GriId = "'.($this->GriId).'";';			
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if(!$error){

				if (!empty($this->GarantiaRepuestoIsuzuDetalle)){		
						
					$validar = 0;
					foreach ($this->GarantiaRepuestoIsuzuDetalle as $DatGarantiaRepuestoIsuzuDetalle){
	
						$InsGarantiaRepuestoIsuzuDetalle = new ClsGarantiaRepuestoIsuzuDetalle();
						$InsGarantiaRepuestoIsuzuDetalle->GdiId = $DatGarantiaRepuestoIsuzuDetalle->GdiId;
						$InsGarantiaRepuestoIsuzuDetalle->GriId = $this->GriId;
						
						
						$InsGarantiaRepuestoIsuzuDetalle->AmdId = $DatGarantiaRepuestoIsuzuDetalle->AmdId;
						$InsGarantiaRepuestoIsuzuDetalle->ProId = $DatGarantiaRepuestoIsuzuDetalle->ProId;
						$InsGarantiaRepuestoIsuzuDetalle->UmeId = $DatGarantiaRepuestoIsuzuDetalle->UmeId;
						
						$InsGarantiaRepuestoIsuzuDetalle->GdiCodigo = $DatGarantiaRepuestoIsuzuDetalle->GdiCodigo;
						$InsGarantiaRepuestoIsuzuDetalle->GdiNombre = $DatGarantiaRepuestoIsuzuDetalle->GdiNombre;		
						$InsGarantiaRepuestoIsuzuDetalle->GdiCantidad = $DatGarantiaRepuestoIsuzuDetalle->GdiCantidad;
						$InsGarantiaRepuestoIsuzuDetalle->GdiValorTotal = $DatGarantiaRepuestoIsuzuDetalle->GdiValorTotal;
						
						$InsGarantiaRepuestoIsuzuDetalle->GdiEstado = $DatGarantiaRepuestoIsuzuDetalle->GdiEstado;
						$InsGarantiaRepuestoIsuzuDetalle->GdiTiempoCreacion = $DatGarantiaRepuestoIsuzuDetalle->GdiTiempoCreacion;
						$InsGarantiaRepuestoIsuzuDetalle->GdiTiempoModificacion = $DatGarantiaRepuestoIsuzuDetalle->GdiTiempoModificacion;
						$InsGarantiaRepuestoIsuzuDetalle->GdiEliminado = $DatGarantiaRepuestoIsuzuDetalle->GdiEliminado;

						if(empty($InsGarantiaRepuestoIsuzuDetalle->GdiId)){
							if($InsGarantiaRepuestoIsuzuDetalle->GdiEliminado<>2){
								if($InsGarantiaRepuestoIsuzuDetalle->MtdRegistrarGarantiaRepuestoIsuzuDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_GRI_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
			 				}else{
								$validar++;
							}
						}else{						
							if($InsGarantiaRepuestoIsuzuDetalle->GdiEliminado==2){
								if($InsGarantiaRepuestoIsuzuDetalle->MtdEliminarGarantiaRepuestoIsuzuDetalle($InsGarantiaRepuestoIsuzuDetalle->GdiId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_GRI_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsGarantiaRepuestoIsuzuDetalle->MtdEditarGarantiaRepuestoIsuzuDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_GRI_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->GarantiaRepuestoIsuzuDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if(!$error){

				if (!empty($this->GarantiaRepuestoIsuzuManoObra)){		
						
					$validar = 0;				
					
					$InsGarantiaRepuestoIsuzuManoObra = new ClsGarantiaRepuestoIsuzuManoObra();

					foreach ($this->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){


						$InsGarantiaRepuestoIsuzuManoObra->GopId = $DatGarantiaRepuestoIsuzuManoObra->GopId;
						$InsGarantiaRepuestoIsuzuManoObra->GriId = $this->GriId;
						$InsGarantiaRepuestoIsuzuManoObra->FaeId = $DatGarantiaRepuestoIsuzuManoObra->FaeId;
				
						$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion = $DatGarantiaRepuestoIsuzuManoObra->GdmOperacion;
						$InsGarantiaRepuestoIsuzuManoObra->GdmCodigo = $DatGarantiaRepuestoIsuzuManoObra->GdmCodigo;
						$InsGarantiaRepuestoIsuzuManoObra->GdmTiempo = $DatGarantiaRepuestoIsuzuManoObra->GdmTiempo;
						$InsGarantiaRepuestoIsuzuManoObra->GdmCosto = $DatGarantiaRepuestoIsuzuManoObra->GdmCosto;	
						
						$InsGarantiaRepuestoIsuzuManoObra->GopEstado = $DatGarantiaRepuestoIsuzuManoObra->GopEstado;
						$InsGarantiaRepuestoIsuzuManoObra->GopTiempoCreacion = $DatGarantiaRepuestoIsuzuManoObra->GopTiempoCreacion;
						$InsGarantiaRepuestoIsuzuManoObra->GopTiempoModificacion = $DatGarantiaRepuestoIsuzuManoObra->GopTiempoModificacion;
						$InsGarantiaRepuestoIsuzuManoObra->GopEliminado = $DatGarantiaRepuestoIsuzuManoObra->GopEliminado;
						
						if(empty($InsGarantiaRepuestoIsuzuManoObra->GopId)){
							if($InsGarantiaRepuestoIsuzuManoObra->GopEliminado<>2){
								if($InsGarantiaRepuestoIsuzuManoObra->MtdRegistrarGarantiaRepuestoIsuzuManoObra()){
									
										//if(empty($InsGarantiaRepuestoIsuzuManoObra->FaeId)){
//											
//											$FichaAccionTemparioId = "";
//											
//											$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//
//											$FichaAccionTemparioId = $InsFichaAccionTempario->MtdVerificarExisteFichaAccionTemparios("FaeCodigo",$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion,$this->FccId);
//											
//											if(empty($FichaAccionTemparioId)){
//												
//												$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//												$InsFichaAccionTempario->FccId = $this->FccId;
//												$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion;
//												$InsFichaAccionTempario->FaeTiempo = $InsGarantiaRepuestoIsuzuManoObra->GdmCodigo;
//												$InsFichaAccionTempario->FaeEstado = 3;
//												$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
//												$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
//												$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();
//												
//											}else{
//												
//												$InsGarantiaRepuestoIsuzuManoObra = new ClsGarantiaRepuestoIsuzuManoObra();
//												$InsGarantiaRepuestoIsuzuManoObra->MtdEditarGarantiaRepuestoIsuzuManoObraDato("FaeId",$FichaAccionTemparioId,$InsGarantiaRepuestoIsuzuManoObra->GopId);
//												
//													
//											}
//											
//											
//										}										
										
									$validar++;	
								}else{
									$Resultado.='#ERR_GRI_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsGarantiaRepuestoIsuzuManoObra->GopEliminado==2){
								if($InsGarantiaRepuestoIsuzuManoObra->MtdEliminarGarantiaRepuestoIsuzuManoObra($InsGarantiaRepuestoIsuzuManoObra->GopId)){
									
									
									//if(!empty($InsGarantiaRepuestoIsuzuManoObra->FaeId)){
//									
//										$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//										$InsFichaAccionTempario->MtdEliminarFichaAccionTempario($InsGarantiaRepuestoIsuzuManoObra->FaeId);
//									
//									}
									
									
									
									$validar++;					
								}else{
									$Resultado.='#ERR_GRI_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsGarantiaRepuestoIsuzuManoObra->MtdEditarGarantiaRepuestoIsuzuManoObra()){
									
										//if(!empty($InsGarantiaRepuestoIsuzuManoObra->FaeId)){
//											
//											$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//											$InsFichaAccionTempario->FaeId = $InsGarantiaRepuestoIsuzuManoObra->FaeId;
//											$InsFichaAccionTempario->FaeCodigo = $InsGarantiaRepuestoIsuzuManoObra->GdmOperacion;
//											$InsFichaAccionTempario->FaeTiempo = $InsGarantiaRepuestoIsuzuManoObra->GdmCodigo;
//											$InsFichaAccionTempario->FaeEstado = 3;
//											$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
//											$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
//											$InsFichaAccionTempario->MtdEditarFichaAccionTempario();
//											
//										}else{
//											
//											$FichaAccionTemparioId = "";
//											
//											$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//
//											$FichaAccionTemparioId = $InsFichaAccionTempario->MtdVerificarExisteFichaAccionTemparios("FaeCodigo",$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion,$this->FccId);
//											
//											if(empty($FichaAccionTemparioId)){
//												
//												$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
//												$InsFichaAccionTempario->FccId = $this->FccId;
//												$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaRepuestoIsuzuManoObra->GdmOperacion;
//												$InsFichaAccionTempario->FaeTiempo = $InsGarantiaRepuestoIsuzuManoObra->GdmCodigo;
//												$InsFichaAccionTempario->FaeEstado = 3;
//												$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
//												$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
//												$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();
//												
//											}else{
//												
//												$InsGarantiaRepuestoIsuzuManoObra = new ClsGarantiaRepuestoIsuzuManoObra();
//												$InsGarantiaRepuestoIsuzuManoObra->MtdEditarGarantiaRepuestoIsuzuManoObraDato("FaeId",$FichaAccionTemparioId,$InsGarantiaRepuestoIsuzuManoObra->GopId);
//												
//													
//											}
//							
////											
//										}
										
		
									$validar++;	
								}else{
									$Resultado.='#ERR_GRI_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->GarantiaRepuestoIsuzuManoObra) <> $validar ){
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

				$this->MtdAuditarGarantiaRepuestoIsuzu(2,"Se edito la GarantiaRepuestoIsuzu",$this);		
				return true;
			}	
				
		}	
		
	
	
		private function MtdAuditarGarantiaRepuestoIsuzu($oAccion,$oDescripcion,$oDatos){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->GriId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		public function MtdVerificarExisteGarantiaRepuestoIsuzu($oCampo,$oDato){

		$Respuesta =   NULL;
			
		$sql = 'SELECT 
        GriId
        FROM tblgrigarantiarepuestoisuzu gri
        WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['GriId'])){
				$Respuesta = $fila['GriId'];
			}

		}
        
		return $Respuesta;

    }			
	
		public function MtdEditarGarantiaRepuestoIsuzuDato($oCampo,$oDato,$oId) {
	
		global $Resultado;
		$error = false;		
		
		$sql = 'UPDATE tblgrigarantiarepuestoisuzu SET
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
		GriTiempoModificacion = NOW()
		WHERE GriId = "'.($oId).'";';			
		
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




//
//	public function MtdSeguimientoClienteGarantiaRepuestoIsuzu($oTransaccion=true) {
//
//		global $Resultado;
//		$error = false;
//			
//			
//		
//			
//			if(!$error){
//
//				if (!empty($this->GarantiaRepuestoIsuzuLlamada)){		
//						
//					$validar = 0;				
//					
//					$InsGarantiaRepuestoIsuzuLlamada = new ClsGarantiaRepuestoIsuzuLlamada();
//
//					foreach ($this->GarantiaRepuestoIsuzuLlamada as $DatGarantiaRepuestoIsuzuLlamada){
//
//						$InsGarantiaRepuestoIsuzuLlamada->GllId = $DatGarantiaRepuestoIsuzuLlamada->GllId;
//						$InsGarantiaRepuestoIsuzuLlamada->GriId = $this->GriId;
//					
//						$InsGarantiaRepuestoIsuzuLlamada->GllFecha = $DatGarantiaRepuestoIsuzuLlamada->GllFecha;						
//						$InsGarantiaRepuestoIsuzuLlamada->GllObservacion = $DatGarantiaRepuestoIsuzuLlamada->GllObservacion;						
//						$InsGarantiaRepuestoIsuzuLlamada->GllEstado = $DatGarantiaRepuestoIsuzuLlamada->GllEstado;
//						$InsGarantiaRepuestoIsuzuLlamada->GllTiempoCreacion = $DatGarantiaRepuestoIsuzuLlamada->GllTiempoCreacion;
//						$InsGarantiaRepuestoIsuzuLlamada->GllTiempoModificacion = $DatGarantiaRepuestoIsuzuLlamada->GllTiempoModificacion;
//						$InsGarantiaRepuestoIsuzuLlamada->GllEliminado = $DatGarantiaRepuestoIsuzuLlamada->GllEliminado;
//						
//						if(empty($InsGarantiaRepuestoIsuzuLlamada->GllId)){
//							if($InsGarantiaRepuestoIsuzuLlamada->GllEliminado<>2){
//								if($InsGarantiaRepuestoIsuzuLlamada->MtdRegistrarGarantiaRepuestoIsuzuLlamada()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_GRI_401';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								$validar++;
//							}
//						}else{						
//							if($InsGarantiaRepuestoIsuzuLlamada->GllEliminado==2){
//								if($InsGarantiaRepuestoIsuzuLlamada->MtdEliminarGarantiaRepuestoIsuzuLlamada($InsGarantiaRepuestoIsuzuLlamada->GllId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_GRI_403';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								if($InsGarantiaRepuestoIsuzuLlamada->MtdEditarGarantiaRepuestoIsuzuLlamada()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_GRI_402';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}
//						}									
//					}
//					
//					if(count($this->GarantiaRepuestoIsuzuLlamada) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}	
//					
//				
//			if($error) {		
//			
//				if($oTransaccion){
//					$this->InsMysql->MtdTransaccionDeshacer();					
//				}
//			
//				return false;
//			} else {			
//
//				if($oTransaccion){
//					$this->InsMysql->MtdTransaccionHacer();
//				}
//
//				$this->MtdAuditarGarantiaRepuestoIsuzu(2,"Se edito el seguimiento de la GarantiaRepuestoIsuzu",$this);		
//				return true;
//			}	
//				
//		}	
//		

}
?>