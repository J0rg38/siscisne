<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenProductoStock
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsResumenProductoStock {

    public $RpsId;
	public $RpsEntradas;
	public $RpsSalidas;
	public $RpsStock;
	public $RpsAno;
	public $RpsMes;

	public $RpsTiempoCreacion;
	public $RpsTiempoModificacion;
    public $RpsEliminado;
	
	public $ResumenProductoStockVehiculo;

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

	public function MtdGenerarResumenProductoStockId() {
/*

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(rps.RpsId,13),unsigned)) AS "MAXIMO"
			FROM tmprpsresumenproductostock rps
			WHERE YEAR(rps.RpsFechaInicio) = ("'.$this->RpsAno.'")
			
';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RpsId = "RPS-".$this->RpsAno."-00001";
			
			}else{
				$fila['MAXIMO']++;
				$this->RpsId = "RPS".$this->RpsAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
			}
			*/
			
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(rps.RpsId,5),unsigned)) AS "MAXIMO"
		FROM tmprpsresumenproductostock rps;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->RpsId = "RPS-10000";
		}else{
			$fila['MAXIMO']++;
			$this->RpsId = "RPS-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerResumenProductoStock($oCompleto=true){

        $sql = 'SELECT 
		rps.RpsId,
		rps.RpsEntradas,
		rps.RpsSalidas,
		rps.RpsStock,
		rps.ProId,
		rps.RpsAno,
		rps.RpsMes,
		rps.RpsCosto,
		
		rps.RpsABCInterno,		
		DATE_FORMAT(rps.RpsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRpsTiempoCreacion",
		DATE_FORMAT(rps.RpsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRpsTiempoModificacion"
		
        FROM tmprpsresumenproductostock rps
		
        WHERE rps.RpsId = "'.$this->RpsId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->RpsId = $fila['RpsId'];
			$this->RpsEntradas = $fila['RpsEntradas'];
			$this->RpsSalidas = $fila['RpsSalidas'];
			$this->RpsStock = $fila['RpsStock'];
			$this->RpsAno = $fila['RpsAno'];
			$this->RpsMes = $fila['RpsMes'];
			$this->RpsCosto = $fila['RpsCosto'];
			
			$this->RpsABCInterno = $fila['RpsABCInterno'];
			$this->RpsTiempoCreacion = $fila['NRpsTiempoCreacion'];
			$this->RpsTiempoModificacion = $fila['NRpsTiempoModificacion'];
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdObtenerResumenProductoStockMensual($oAno,$oMes,$oProductoId,$oProductoABC=NULL){
		
		$ResumenProductoStock = NULL;
		$ResumenProductoStockId = "";
		
		$ResResumenProductoStock = $this->MtdObtenerResumenProductoStocks(NULL,NULL,NULL,"RpsTiempoCreacion","DESC","1",$oAno,$oMes,$oProductoId,$oProductoABC);
		$ArrResumenProductoStocks = $ResResumenProductoStock['Datos'];
		
		if(!empty($ArrResumenProductoStocks)){
			foreach($ArrResumenProductoStocks as $DatResumenProductoStock){
				
				$ResumenProductoStockId = $DatResumenProductoStock->RpsId;
				
			}
		}
		
		if(!empty($ResumenProductoStockId)){

			$this->RpsId = $ResumenProductoStockId;
			$ResumenProductoStock = $this->MtdObtenerResumenProductoStock(false);	

		}
		
		return 	$ResumenProductoStock;	
	}

    public function MtdObtenerResumenProductoStocks($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RpsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oProductoId=NULL,$oProductoABC=NULL) {

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
		
		if(!empty($oProductoId)){
			$producto = ' AND rps.ProId = "'.$oProductoId.'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND rps.RpsAno = "'.$oAno.'"';
		}
		
		if(!empty($oMes)){
			$mes = ' AND rps.RpsMes = "'.$oMes.'"';
		}
		
		if(!empty($oProductoABC)){
			$pabc = ' AND rps.RpsABCInterno = "'.$oProductoABC.'"';
		}
			
				$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				rps.RpsId,
				rps.RpsEntradas,
				rps.RpsSalidas,
				rps.RpsStock,
				rps.ProId,
				rps.RpsCosto,
				rps.RpsABCInterno,
				
				DATE_FORMAT(rps.RpsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRpsTiempoCreacion",
				DATE_FORMAT(rps.RpsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRpsTiempoModificacion"

				FROM tmprpsresumenproductostock rps
						
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$pabc.$vmodelo.$producto.$cvin.$ano.$mes.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsResumenProductoStock = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ResumenProductoStock = new $InsResumenProductoStock();
                    $ResumenProductoStock->RpsId = $fila['RpsId'];
					$ResumenProductoStock->RpsEntradas = $fila['RpsEntradas'];
					$ResumenProductoStock->RpsSalidas = $fila['RpsSalidas'];
					$ResumenProductoStock->RpsStock = $fila['RpsStock'];
					
					$ResumenProductoStock->RpsAno = $fila['RpsAno'];
					$ResumenProductoStock->RpsMes = $fila['RpsMes'];
					$ResumenProductoStock->RpsCosto = $fila['RpsCosto'];
					
					$ResumenProductoStock->RpsABCInterno = $fila['RpsABCInterno'];
					$ResumenProductoStock->RpsTiempoCreacion = $fila['NRpsTiempoCreacion'];
					$ResumenProductoStock->RpsTiempoModificacion = $fila['NRpsTiempoModificacion'];
			
                    $ResumenProductoStock->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ResumenProductoStock;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	public function MtdObtenerResumenProductoStocksValor($oFuncion="SUM",$oParametro="RpsId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RpsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoId=NULL,$oProductoABC=NULL) {

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
		
		if(!empty($oProductoId)){
			$producto = ' AND rps.ProId = "'.$oProductoId.'"';
		}
		
		//if(!empty($oAno)){
//			$ano = ' AND rps.RpsAno = "'.$oAno.'"';
//		}
//		
//		if(!empty($oMes)){
//			$mes = ' AND rps.RpsMes = "'.$oMes.'"';
//		}
		
		if(!empty($oProductoABC)){
			$pabc = ' AND rps.RpsABCInterno = "'.$oProductoABC.'"';
		}
			
			
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
	
		if(!empty($oMes)){
			$mes = ' AND (rps.RpsMes) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND (rps.RpsAno) ="'.($oAno).'"';
		}
		
		$sql = 'SELECT
		'.$funcion.' AS "RESULTADO"
		FROM tmprpsresumenproductostock rps
		WHERE 1 = 1 '.$filtrar.$fecha.$estado.$pabc.$vmodelo.$producto.$cvin.$ano.$mes.$orden.$paginacion;
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		settype($fila['RESULTADO'],"float");
		
		return $fila['RESULTADO'];
			
					
	}
		
  public function MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace("*","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			

		}
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		
		if(!empty($oSucursal)){
			$sucursal = ' AND bta.SucId = "'.$oSucursal.'"';
		}
				
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (bol.BolEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
	
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
	
		if(!empty($oMes)){
			$mes = ' AND MONTH(bol.BolFechaEmision) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(bol.BolFechaEmision) ="'.($oAno).'"';
		}
		
		if(!empty($oClienteTipo)){
			$ctipo = ' AND cli.LtiId = "'.$oClienteTipo.'" ';
		}
		
			$sql = 'SELECT

				'.$funcion.' AS "RESULTADO"
				
				FROM tblbolboleta bol
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
						LEFT JOIN tblclicliente cli
						ON bol.CliId = cli.CliId
				
				WHERE 1 = 1
				'.$filtrar.$sucursal.$estado.$fecha.$credito.$regimen.$npago.$vendedor.$moneda.$mes.$ano.$amovimiento.$cliente.$clasificacion.$ctipo.$mkilometraje.$vmarca.$vmodelo.$tecnico.$mingreso.$origen.$orden.$paginacion;

					
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}


	/*
	//Accion eliminar	 
	public function MtdEliminarResumenProductoStock($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsResumenProductoStockVehiculo = new ClsResumenProductoStockVehiculo();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
						$sql = 'DELETE FROM tmprpsresumenproductostock WHERE  (RpsId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
//							//$this->MtdAuditarResumenProductoStock(3,"Se elimino la ResumenProductoStock",$elemento);		
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
	*/
	/*
	//Accion eliminar	 
	public function MtdActualizarEstadoResumenProductoStock($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tmprpsresumenproductostock SET RpsEstado = '.$oEstado.' WHERE RpsId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						$Auditoria = "Se actualizo el Estado de la ResumenProductoStock";

						$this->RpsId = $elemento;						
						//$this->MtdAuditarResumenProductoStock(2,$Auditoria,$elemento);

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
	}*/
	
	
	public function MtdRegistrarResumenProductoStock() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarResumenProductoStockId();
		
		$this->InsMysql->MtdTransaccionIniciar();		
					
			$sql = 'INSERT INTO tmprpsresumenproductostock (
			RpsId,
			ProId,
			
			RpsEntradas,
			RpsSalidas,
			RpsStock,
			
			RpsAno,
			RpsMes,
			RpsCosto,
			
			RpsABCInterno,
			RpsTiempoCreacion,
			RpsTiempoModificacion
			) 
			VALUES (
			"'.($this->RpsId).'", 
			"'.($this->ProId).'", 
			
			'.($this->RpsEntradas).', 
			'.($this->RpsSalidas).', 
			'.($this->RpsStock).',
			
			"'.($this->RpsAno).'",
			"'.($this->RpsMes).'",
			'.($this->RpsCosto).',
			
			"'.($this->RpsABCInterno).'",
			"'.($this->RpsTiempoCreacion).'",
			"'.($this->RpsTiempoModificacion).'");';			

			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
				if(!$resultado) {							
					$error = true;
				} 
			}

		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();		
			//$this->MtdAuditarResumenProductoStock(1,"Se registro la ResumenProductoStock",$this);			
			return true;
		}
					
	}
	
	public function MtdEditarResumenProductoStock() {

		global $Resultado;
		$error = false;
	
			$this->InsMysql->MtdTransaccionIniciar();
	
			$sql = 'UPDATE tmprpsresumenproductostock SET
			ProId = "'.($this->ProId).'",
			RpsEntradas = '.($this->RpsEntradas).',
			RpsSalidas = '.($this->RpsSalidas).',
			RpsStock = '.($this->RpsStock).',
			RpsAno = "'.($this->RpsAno).'",
			RpsMes = "'.($this->RpsMes).'",
			RpsCosto = '.($this->RpsCosto).',
			
			RpsABCInterno = "'.($this->RpsABCInterno).'",
			RpsTiempoModificacion = "'.($this->RpsTiempoModificacion).'"

			WHERE RpsId = "'.($this->RpsId).'";';			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				//$this->MtdAuditarResumenProductoStock(2,"Se edito la ResumenProductoStock",$this);		
				return true;
			}	
				
		}	
		
	
	
	/*	private function MtdAuditarResumenProductoStock($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->RpsId;

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
		
		*/

}
?>