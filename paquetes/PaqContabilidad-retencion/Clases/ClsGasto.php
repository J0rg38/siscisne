<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGasto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGasto {

    public $GasId;

	public $PrvId;
	public $CtiId;
	public $TopId;
	
	public $NpaId;
	public $GasCantidadDia;
	
	public $GasFecha;

	public $GasComprobanteNumero;
	public $GasComprobanteNumeroSerie;
	public $GasComprobanteNumeroNumero;
	public $GasComprobanteFecha;

	public $MonId;
	public $GasTipoCambio;

	public $GasIncluyeImpuesto;
	public $GasPorcentajeImpuestoVenta;
	
	public $GasFoto;
    public $GasObservacion;
	
	public $GasSubTotal;
	public $GasImpuesto;
	public $GasTotal;
	
	public $GasEstado;
	public $GasTiempoCreacion;
	public $GasTiempoModificacion;
    public $GasEliminado;

    public $InsMysql;

    public function __construct(){
		
		$this->InsMysql = new ClsMysql();
		
		$this->GasId = "";
		$this->PrvId = "";		
		$this->CtiId = "";
		$this->TopId = "";	
		
		$this->NpaId  = "";
		$this->GasCantidadDia = 0;
		
		$this->GasFecha = "";
		
		$this->GasComprobanteNumero = "";
		$this->GasComprobanteNumeroSerie = "";
		$this->GasComprobanteNumeroNumero = "";
		$this->GasComprobanteFecha = "";
		
		$this->MonId = "";
		$this->GasTipoCambio = NULL;
		
		$this->GasIncluyeImpuesto = 0;
		$this->GasPorcentajeImpuestoVenta = 0;
		
		$this->GasFoto = "";
		
		
		$this->GasConcepto = "";
		$this->GasObservacion = "";
		
		$this->GasSubTotal = 0;
		$this->GasImpuesto = 0;
		$this->GasTotal = 0;
		
		$this->GasValorTotal = 0;
		
		$this->GasCancelado = 0;
		$this->GasRevisado = 0;
		$this->GasEstado = 0;
		$this->GasTiempoCreacion = "";
		$this->GasTiempoModificacion = ""; 	
		
		$this->CtiNombre = "";
		
		$this->PrvNombreCompleto = "";
		$this->PrvNombre = "";
		$this->PrvApellidoPaterno = "";
		$this->PrvApellidoMaterno = "";	
		
		$this->PrvNumeroDocumento = "";
		$this->TdoId = "";	
		$this->TdoNombre = "";
		
		$this->MonSimbolo = "";
			
    }
	
	public function __destruct(){

	}

	public function MtdGenerarGastoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(gas.GasId,5),unsigned)) AS "MAXIMO"
		FROM tblgasgasto gas
		';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->GasId = "GAS-10000";
		}else{
			$fila['MAXIMO']++;
			$this->GasId = "GAS-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerGasto(){

        $sql = 'SELECT 
        gas.GasId,  
		gas.SucId,
		
		gas.PrvId,
		gas.CtiId,
		gas.TopId,
		
		gas.NpaId,
		gas.GasCantidadDia,
		
		DATE_FORMAT(gas.GasFecha, "%d/%m/%Y") AS "NGasFecha",
	
		gas.GasComprobanteNumero,
		DATE_FORMAT(gas.GasComprobanteFecha, "%d/%m/%Y") AS "NGasComprobanteFecha",
		
		gas.MonId,
		gas.GasTipoCambio,
		
		gas.GasIncluyeImpuesto,
		gas.GasPorcentajeImpuestoVenta,
	
		gas.GasFoto,
		
		gas.GasConcepto,
		gas.GasObservacion,

		gas.GasSubTotal,
		gas.GasImpuesto,
		gas.GasTotal,
		
		gas.GasCancelado,
		gas.GasRevisado,
		gas.GasEstado,
		DATE_FORMAT(gas.GasTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGasTiempoCreacion",
        DATE_FORMAT(gas.GasTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGasTiempoModificacion",
		
		cti.CtiNombre,
		
		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		
		prv.PrvNumeroDocumento,
		prv.TdoId,
				
		mon.MonSimbolo,
		mon.MonNombre
		
        FROM tblgasgasto gas
			LEFT JOIN tblcticomprobantetipo cti
			ON gas.CtiId = cti.CtiId
				LEFT JOIN tblprvproveedor prv
				ON gas.PrvId = prv.PrvId
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
						LEFT JOIN tblmonmoneda mon
						ON gas.MonId = mon.MonId		
						
        WHERE gas.GasId = "'.$this->GasId.'" ;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->GasId = $fila['GasId'];
			$this->SucId = $fila['SucId'];
			
			$this->PrvId = $fila['PrvId'];		
			$this->CtiId = $fila['CtiId'];		
			$this->TopId = $fila['TopId'];		
			
			$this->NpaId = $fila['NpaId'];
			$this->GasCantidadDia = $fila['GasCantidadDia'];

			$this->GasFecha = $fila['NGasFecha'];

			$this->GasComprobanteNumero = $fila['GasComprobanteNumero'];
			list($this->GasComprobanteNumeroSerie,$this->GasComprobanteNumeroNumero) = explode("-",$this->GasComprobanteNumero);
			$this->GasComprobanteFecha = $fila['NGasComprobanteFecha'];

			$this->MonId = $fila['MonId'];
			$this->GasTipoCambio = $fila['GasTipoCambio'];
			
			$this->GasIncluyeImpuesto = $fila['GasIncluyeImpuesto'];
			$this->GasPorcentajeImpuestoVenta = $fila['GasPorcentajeImpuestoVenta'];
			
			$this->GasFoto = $fila['GasFoto'];
			
			$this->GasConcepto = $fila['GasConcepto'];
			$this->GasObservacion = $fila['GasObservacion'];

			$this->GasSubTotal = $fila['GasSubTotal'];
			$this->GasImpuesto = $fila['GasImpuesto'];
			$this->GasTotal = $fila['GasTotal'];
		
			$this->GasCancelado = $fila['GasCancelado'];
			$this->GasRevisado = $fila['GasRevisado'];
			$this->GasEstado = $fila['GasEstado'];
			$this->GasTiempoCreacion = $fila['NGasTiempoCreacion']; 
			$this->GasTiempoModificacion = $fila['NGasTiempoModificacion']; 	
			
			$this->CtiNombre = $fila['CtiNombre']; 	

			$this->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
			$this->PrvNombre = $fila['PrvNombre']; 	
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId']; 	
			$this->TdoNombre = $fila['TdoNombre'];

			$this->MonSimbolo = $fila['MonSimbolo']; 
			$this->MonNombre = $fila['MonNombre'];	
		
			switch($this->GasEstado){
			
				case 1:
					$Estado = "Pendiente";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	

				default:
					$Estado = "";
				break;
			
			}
				
			$this->GasEstadoDescripcion = $Estado;
			
			
			switch($this->GasEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/realizado.gif" />';						
				break;	
				
				default:
					$Estado = "";
				break;
			
			}
				
			$this->GasEstadoIcono = $Estado;




		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerGastos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GasId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFecha="GasFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL) {

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
				
				

				$filtrar .= '   ';
					
									
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
				$fecha = ' AND DATE(gas.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(gas.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(gas.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gas.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		


		if(!empty($oEstado)){
			$estado = ' AND gas.GasEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND gas.MonId = "'.$oMoneda.'"';
		}
		
		if($oCancelado){
			$cancelado = ' AND gas.GasCancelado = '.$oCancelado;
		}
		
		if(!empty($oProveedor)){
			$proveedor = ' AND gas.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oCondicionPago)){
			$cpago = ' AND gas.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND gas.SucId = "'.$oSucursal.'"';
		}
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				gas.GasId,				
				gas.SucId,
				
				
				gas.PrvId,
				gas.CtiId,
				gas.TopId,
				
				gas.NpaId,	
				gas.GasCantidadDia,	
								
				DATE_FORMAT(gas.GasFecha, "%d/%m/%Y") AS "NGasFecha",
							
				gas.GasComprobanteNumero,
				DATE_FORMAT(gas.GasComprobanteFecha, "%d/%m/%Y") AS "NGasComprobanteFecha",
				
				gas.MonId,
				gas.GasTipoCambio,
				gas.GasIncluyeImpuesto,
				gas.GasPorcentajeImpuestoVenta,
			
				gas.GasFoto,
			  gas.GasConcepto,
				gas.GasObservacion,
				
				gas.GasSubTotal,
				gas.GasImpuesto,				
				gas.GasTotal,
									
				gas.GasCancelado,
				gas.GasRevisado,
				gas.GasEstado,
				DATE_FORMAT(gas.GasTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGasTiempoCreacion",
	        	DATE_FORMAT(gas.GasTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGasTiempoModificacion",
				
				DATE_FORMAT(adddate(gas.GasComprobanteFecha,gas.GasCantidadDia), "%d/%m/%Y") AS GasFechaVencimiento,
				DATEDIFF(DATE(NOW()),gas.GasComprobanteFecha) AS GasDiaTranscurrido,

				
				cti.CtiNombre,
				
				prv.TdoId,

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre,
				
				mon.MonSimbolo,
				
				npa.NpaNombre

				FROM tblgasgasto gas
					
					LEFT JOIN tblnpacondicionpago npa
					ON gas.NpaId = npa.NpaId
						
					LEFT JOIN tblcticomprobantetipo cti
					ON gas.CtiId = cti.CtiId
						LEFT JOIN tblprvproveedor prv
						ON gas.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
								LEFT JOIN tblmonmoneda mon
								ON gas.MonId = mon.MonId
	
						
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$sucursal.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$proveedor.$vdirecta.$cpago.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGasto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Gasto = new $InsGasto();
                    $Gasto->GasId = $fila['GasId'];
					$Gasto->SucId = $fila['SucId'];
					
					$Gasto->PrvId = $fila['PrvId'];		
					$Gasto->CtiId = $fila['CtiId'];	
					$Gasto->TopId = $fila['TopId'];	
				
					$Gasto->NpaId = $fila['NpaId'];
					$Gasto->GasCantidadDia = $fila['GasCantidadDia'];							
					
				
					$Gasto->GasFecha = $fila['NGasFecha'];
				
					
					$Gasto->GasComprobanteNumero = $fila['GasComprobanteNumero'];
					list($Gasto->GasComprobanteNumeroSerie,$Gasto->GasComprobanteNumeroNumero) = explode("-",$Gasto->GasComprobanteNumero);					
					$Gasto->GasComprobanteFecha = $fila['NGasComprobanteFecha'];
					
					$Gasto->MonId = $fila['MonId'];
					$Gasto->GasTipoCambio = $fila['GasTipoCambio'];
					$Gasto->GasIncluyeImpuesto = $fila['GasIncluyeImpuesto'];
					$Gasto->GasPorcentajeImpuestoVenta = $fila['GasPorcentajeImpuestoVenta'];
					
					$Gasto->GasFoto = $fila['GasFoto'];
					
					
					$Gasto->GasConcepto = $fila['GasConcepto'];
					$Gasto->GasObservacion = $fila['GasObservacion'];
		
					$Gasto->GasSubTotal = $fila['GasSubTotal'];			
					$Gasto->GasImpuesto = $fila['GasImpuesto'];
					$Gasto->GasTotal = $fila['GasTotal'];
					
					$Gasto->GasCancelado = $fila['GasCancelado'];	
					$Gasto->GasRevisado = $fila['GasRevisado'];							
					$Gasto->GasEstado = $fila['GasEstado'];
					$Gasto->GasTiempoCreacion = $fila['NGasTiempoCreacion'];  
					$Gasto->GasTiempoModificacion = $fila['NGasTiempoModificacion']; 

					$Gasto->GasFechaVencimiento = $fila['GasFechaVencimiento']; 
					$Gasto->GasDiaTranscurrido = $fila['GasDiaTranscurrido']; 

					$Gasto->CtiNombre = $fila['CtiNombre']; 
					
					$Gasto->TdoId = $fila['TdoId']; 
					
				
					$Gasto->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$Gasto->PrvNombre = $fila['PrvNombre']; 
					$Gasto->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$Gasto->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					
					$Gasto->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					
					$Gasto->TdoNombre = $fila['TdoNombre']; 

					$Gasto->MonSimbolo = $fila['MonSimbolo']; 
					
					$Gasto->NpaNombre = $fila['NpaNombre']; 
					
				
		
					switch($Gasto->GasEstado){
					
						case 1:
							$Estado = "Pendiente";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
						
					$Gasto->GasEstadoDescripcion = $Estado;
					
					
					switch($Gasto->GasEstado){
					
						case 1:
							$Estado = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />';
						break;
					
						case 3:
							$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/realizado.gif" />';						
						break;	
						
						default:
							$Estado = "";
						break;
					
					}
						
						
						


					switch($Gasto->GasRevisado){
					
						case 1:
							$Revisado = "Revisado";
						break;
					
						case 3:
							$Revisado = "No Revisado";						
						break;	
		
						default:
							$Revisado = "";
						break;
					
					}
						
					$Gasto->GasRevisadoDescripcion = $Revisado;
					
					
					switch($Gasto->GasRevisado){
					
						case 1:
							$Revisado = '<img width="15" height="15" alt="[Revisado]" title="Pendiente" src="imagenes/iconos/revisado.png" />';
						break;
					
						case 3:
							$Revisado = '<img width="15" height="15" alt="[No Revisado]" title="Enviado" src="imagenes/iconos/norevisado.png" />';						
						break;	
						
						default:
							$Revisado = "";
						break;
					
					}
						
						
						
					$Gasto->GasRevisadoIcono = $Revisado;




                    $Gasto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Gasto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarGasto($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

	
		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){

					if(!$error) {		
					
						$sql = 'DELETE FROM tblgasgasto WHERE  (GasId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{																					
							$this->MtdAuditarGasto(3,"Se elimino el Gasto",$aux);		
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
	public function MtdActualizarEstadoGasto($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsGasto = new ClsGasto();
		//$InsGastoDetalles = new ClsGastoDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblgasgasto SET GasEstado = '.$oEstado.' WHERE GasId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarGasto(2,"Se actualizo el Estado del Gasto",$elemento);
				
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
	
	
	
	public function MtdActualizarRevisadoGasto($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tblgasgasto SET GasRevisado = '.$oRevisado.' WHERE GasId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
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
	
	public function MtdVerificarExisteGasto($oCampo,$oDato,$oProveedor=NULL){
			
		$Respuesta =   NULL;

		if($oProveedor){
			$proveedor = ' AND gas.PrvId = "'.$oProveedor.'"';
		}
			
			$sql = 'SELECT 
			GasId
			FROM tblgasgasto
			WHERE '.$oCampo.' = "'.$oDato.'" '.$proveedor.' LIMIT 1;';
	
			$resultado = $this->InsMysql->MtdConsultar($sql);
	
			if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
				
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);
				//$this->EinId = $fila['EinId'];
				$Respuesta = $fila['GasId'];
	
			}
			
			return $Respuesta;
	
		}
	
	
	
	public function MtdRegistrarGasto() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarGastoId();
			
			/*if(empty($this->PrvId)){
				$InsProveedor = new ClsProveedor();
				$InsProveedor->TdoId = $this->TdoId;
				$InsProveedor->PrvNombre = $this->PrvNombre;
				$InsProveedor->PrvNumeroDocumento = $this->PrvNumeroDocumento;
				
				$InsProveedor->MtdVerificarExisteProveedor();
				if(empty($this->PrvId)){
					$InsProveedor->PrvEstado = 1;
					$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvEliminado = 1;

					if(!$InsProveedor->MtdRegistrarProveedor2()){
						$error = true;
						$Resultado.='#ERR_PRV_101';
					}

				}else{

					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");

					if(!$InsProveedor->MtdEditarProveedor2()){
						$error = true;
						$Resultado.='#ERR_PRV_102';
					}

					$this->PrvId = $InsProveedor->PrvId;	
					
				}
			}*/

			
			
			
			
			$sql = 'INSERT INTO tblgasgasto (
			GasId,	
			SucId,
			
			PrvId,
			CtiId,
			TopId,
			
			NpaId,
			GasCantidadDia,

			GasFecha,
		
			GasComprobanteNumero,
			GasComprobanteFecha,
			MonId,
			GasTipoCambio,
			GasIncluyeImpuesto,
			GasPorcentajeImpuestoVenta,
				
			GasFoto,
			GasConcepto,
			GasObservacion,
			
			GasSubTotal,
			GasImpuesto,				
			GasTotal,
				
			GasCancelado,
			GasRevisado,
			GasEstado,			
			GasTiempoCreacion,
			GasTiempoModificacion) 
			VALUES (
			"'.($this->GasId).'", 
			"'.($this->SucId).'",
			
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'NULL, ':'"'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
						
			"'.($this->NpaId).'", 
			'.($this->GasCantidadDia).',
			
			"'.($this->GasFecha).'", 
			
			"'.($this->GasComprobanteNumero).'", 
			'.(empty($this->GasComprobanteFecha)?'NULL, ':'"'.$this->GasComprobanteFecha.'",').'
			"'.($this->MonId).'",
			'.($this->GasTipoCambio).',
			'.($this->GasIncluyeImpuesto).',
			'.($this->GasPorcentajeImpuestoVenta).',

			"'.($this->GasFoto).'",
			
			"'.($this->GasConcepto).'",
			"'.($this->GasObservacion).'",

			'.($this->GasSubTotal).',
			'.($this->GasImpuesto).',
			'.($this->GasTotal).',
			
			
			2,
			2,
			'.($this->GasEstado).',
			"'.($this->GasTiempoCreacion).'", 				
								
			"'.($this->GasTiempoModificacion).'");';			
		
			
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
				
			
			
			if(!$resultado) {							
				$error = true;
			} 


			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarGasto(1,"Se registro el Gasto",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarGasto() {

		global $Resultado;
		$error = false;

			/*if(empty($this->PrvId)){
				
				$InsProveedor = new ClsProveedor();
				$InsProveedor->TdoId = $this->TdoId;
				$InsProveedor->PrvNombre;
				$InsProveedor->PrvNumeroDocumento;
				$InsProveedor->MtdVerificarExisteProveedor();
				
				if(empty($this->PrvId)){
					
					$InsProveedor->PrvEstado = 1;
					$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvEliminado = 1;

					if(!$InsProveedor->MtdRegistrarProveedor2()){
						$error = true;
						$Resultado.='#ERR_PRV_101';
					}

				}else{

					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");

					if(!$InsProveedor->MtdEditarProveedor2()){
						$error = true;
						$Resultado.='#ERR_PRV_102';
					}

					$this->PrvId = $InsProveedor->PrvId;	
					
				}
			}*/
			
			$sql = 'UPDATE tblgasgasto SET
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
			
			NpaId = "'.($this->NpaId).'",
			GasCantidadDia = '.($this->GasCantidadDia).',
			
			GasFecha = "'.($this->GasFecha).'",
			
			GasComprobanteNumero = "'.($this->GasComprobanteNumero).'",
			'.(empty($this->GasComprobanteFecha)?'GasComprobanteFecha = NULL, ':'GasComprobanteFecha = "'.$this->GasComprobanteFecha.'",').'
			MonId = "'.($this->MonId).'",
			GasTipoCambio = '.($this->GasTipoCambio).',
			
			GasIncluyeImpuesto = '.($this->GasIncluyeImpuesto).',
			GasPorcentajeImpuestoVenta = '.($this->GasPorcentajeImpuestoVenta).',						

			GasFoto = "'.($this->GasFoto).'",
			
			GasConcepto = "'.($this->GasConcepto).'",
			GasObservacion = "'.($this->GasObservacion).'",
			GasSubTotal = '.($this->GasSubTotal).',
			GasImpuesto = '.($this->GasImpuesto).',
			GasTotal = '.($this->GasTotal).',
			
			GasEstado = '.($this->GasEstado).'
			WHERE GasId = "'.($this->GasId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarGasto(2,"Se edito el Gasto",$this);		
				return true;
			}	
				
		}
		
		public function MtdEditarGastoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblgasgasto SET 
			'.$oCampo.' = "'.($oDato).'",
			GasTiempoModificacion = NOW()
			WHERE GasId = "'.($oId).'";';
			
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



		private function MtdAuditarGasto($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->GasId;

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
		
		
		
		
		
}
?>