<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenStock
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsResumenStock {

    public $RstId;
	public $RstStockMarca;
	public $RstStockLubricantes;
	
	public $RstTotalStock;
	public $RstValorRepuestoA;
	public $RstValorRepuestoB;
	public $RstValorRepuestoC;
	public $RstValorRepuestoD;
	
	public $RstRotacionMarca;
	public $RstValorPreObsoletos;
	public $RstValorObsoletos;
	
	
	public $RstAno;
	public $RstMes;


	public $RstTiempoCreacion;
	public $RstTiempoModificacion;
    public $RstEliminado;
	
	public $ResumenStockVehiculo;

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

	public function MtdGenerarResumenStockId() {
/*

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(rst.RstId,13),unsigned)) AS "MAXIMO"
			FROM tmprstresumenstock rst
			WHERE YEAR(rst.RstFechaInicio) = ("'.$this->RstAno.'")
			
';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RstId = "RST-".$this->RstAno."-00001";
			
			}else{
				$fila['MAXIMO']++;
				$this->RstId = "RST".$this->RstAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
			}
			*/
			
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(rst.RstId,5),unsigned)) AS "MAXIMO"
		FROM tmprstresumenstock rst;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->RstId = "RST-10000";
		}else{
			$fila['MAXIMO']++;
			$this->RstId = "RST-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerResumenStock($oCompleto=true){

        $sql = 'SELECT 
		rst.RstId,
		rst.VmaId,
		
		rst.RstStockMarca,
		rst.RstStockLubricantes,
		rst.RstTotalStock,
		rst.RstValorRepuestoA,
		rst.RstValorRepuestoB,
		rst.RstValorRepuestoC,
		rst.RstValorRepuestoD,
		
		rst.RstRotacionMarca,
		rst.RstValorPreObsoletos,
		rst.RstValorObsoletos,
		
		DATE_FORMAT(rst.RstTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRstTiempoCreacion"
		
        FROM tmprstresumenstock rst
		
        WHERE rst.RstId = "'.$this->RstId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->RstId = $fila['RstId'];
			$this->VmaId = $fila['VmaId'];
			
			$this->RstStockMarca = $fila['RstStockMarca'];
			$this->RstStockLubricantes = $fila['RstStockLubricantes'];
			$this->RstTotalStock = $fila['RstTotalStock'];
			$this->RstValorRepuestoA = $fila['RstValorRepuestoA'];
			$this->RstValorRepuestoB = $fila['RstValorRepuestoB'];
			$this->RstValorRepuestoC = $fila['RstValorRepuestoC'];
			$this->RstValorRepuestoD = $fila['RstValorRepuestoD'];
			
			$this->RstRotacionMarca = $fila['RstRotacionMarca'];
			$this->RstValorPreObsoletos = $fila['RstValorPreObsoletos'];
			$this->RstValorObsoletos = $fila['RstValorObsoletos'];
			
			$this->RstTiempoCreacion = $fila['NRstTiempoCreacion'];
			
			$this->RstAno = $fila['RstAno'];
			$this->RstMes = $fila['RstMes'];
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdObtenerResumenStockMensual($oAno,$oMes,$oVehiculoMarca=NULL){
		
		$ResumenStock = NULL;
		$ResumenStockId = "";
		
		$ResResumenStock = $this->MtdObtenerResumenStocks(NULL,NULL,NULL,"RstTiempoCreacion","DESC","1",$oAno,$oMes,$oVehiculoMarca);
		$ArrResumenStocks = $ResResumenStock['Datos'];
		
		if(!empty($ArrResumenStocks)){
			foreach($ArrResumenStocks as $DatResumenStock){
				
				$ResumenStockId = $DatResumenStock->RstId;
				
			}
		}
		
		if(!empty($ResumenStockId)){

			$this->RstId = $ResumenStockId;
			$ResumenStock = $this->MtdObtenerResumenStock(false);	

		}
		
		return 	$ResumenStock;	
	}

    public function MtdObtenerResumenStocks($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RstId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarcaId=NULL) {

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
		
		if(!empty($oAno)){
			$ano = ' AND rst.RstAno = "'.$oAno.'"';
		}
		
		if(!empty($oMes)){
			$mes = ' AND rst.RstMes = "'.$oMes.'"';
		}
			
		if(!empty($oVehiculoMarcaId)){
			$vmarca = ' AND rst.VmaId = "'.$oVehiculoMarcaId.'"';
		}	
			
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					rst.RstId,
					rst.VmaId,
					
					rst.RstStockMarca,
					rst.RstStockLubricantes,
					rst.RstTotalStock,
					rst.RstValorRepuestoA,
					rst.RstValorRepuestoB,
					rst.RstValorRepuestoC,
					rst.RstValorRepuestoD,
					
					rst.RstRotacionMarca,
					rst.RstValorPreObsoletos,
					rst.RstValorObsoletos,
					
					DATE_FORMAT(rst.RstTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRstTiempoCreacion"

				FROM tmprstresumenstock rst
						
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$vmarca.$vmodelo.$cvin.$ano.$mes.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsResumenStock = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ResumenStock = new $InsResumenStock();
                    $ResumenStock->RstId = $fila['RstId'];
					$ResumenStock->VmaId = $fila['VmaId'];
					
					$ResumenStock->RstStockMarca = $fila['RstStockMarca'];
					$ResumenStock->RstStockLubricantes = $fila['RstStockLubricantes'];
					$ResumenStock->RstTotalStock = $fila['RstTotalStock'];
					$ResumenStock->RstValorRepuestoA = $fila['RstValorRepuestoA'];
					$ResumenStock->RstValorRepuestoB = $fila['RstValorRepuestoB'];
					$ResumenStock->RstValorRepuestoC = $fila['RstValorRepuestoC'];
					$ResumenStock->RstValorRepuestoD = $fila['RstValorRepuestoD'];
					
					$ResumenStock->RstRotacionMarca = $fila['RstRotacionMarca'];
					$ResumenStock->RstValorPreObsoletos = $fila['RstValorPreObsoletos'];
					$ResumenStock->RstValorObsoletos = $fila['RstValorObsoletos'];
					
					$ResumenStock->RstAno = $fila['RstAno'];
					$ResumenStock->RstMes = $fila['RstMes'];
					
					$ResumenStock->RstTiempoCreacion = $fila['NRstTiempoCreacion'];
			
                    $ResumenStock->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ResumenStock;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	/*
	//Accion eliminar	 
	public function MtdEliminarResumenStock($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsResumenStockVehiculo = new ClsResumenStockVehiculo();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
						$sql = 'DELETE FROM tmprstresumenstock WHERE  (RstId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
//							//$this->MtdAuditarResumenStock(3,"Se elimino la ResumenStock",$elemento);		
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
	public function MtdActualizarEstadoResumenStock($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tmprstresumenstock SET RstEstado = '.$oEstado.' WHERE RstId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						$Auditoria = "Se actualizo el Estado de la ResumenStock";

						$this->RstId = $elemento;						
						//$this->MtdAuditarResumenStock(2,$Auditoria,$elemento);

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
	
	
	public function MtdRegistrarResumenStock() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarResumenStockId();
		
		$this->InsMysql->MtdTransaccionIniciar();		
					
			$sql = 'INSERT INTO tmprstresumenstock (
			RstId,
			VmaId,
			
			RstStockMarca,
			RstStockLubricantes,
			RstTotalStock,
			RstValorRepuestoA,
			RstValorRepuestoB,
			RstValorRepuestoC,
			RstValorRepuestoD,
			
			RstRotacionMarca,
			RstValorPreObsoletos,
			RstValorObsoletos,
			
			RstAno,
			RstMes,
			RstTiempoCreacion
			) 
			VALUES (
			"'.($this->RstId).'", 
			"'.($this->VmaId).'", 
			
			"'.($this->RstStockMarca).'", 
			"'.($this->RstStockLubricantes).'", 
			"'.($this->RstTotalStock).'",
			"'.($this->RstValorRepuestoA).'",
			"'.($this->RstValorRepuestoB).'",
			"'.($this->RstValorRepuestoC).'",
			"'.($this->RstValorRepuestoD).'",
			
			"'.($this->RstRotacionMarca).'",
			"'.($this->RstValorPreObsoletos).'",
			"'.($this->RstValorObsoletos).'",
			"'.($this->RstAno).'",
			"'.($this->RstMes).'",
			"'.($this->RstTiempoCreacion).'");';			

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
			//$this->MtdAuditarResumenStock(1,"Se registro la ResumenStock",$this);			
			return true;
		}
					
	}
	/*
	public function MtdEditarResumenStock() {

		global $Resultado;
		$error = false;
	
			$this->InsMysql->MtdTransaccionIniciar();
	
			$sql = 'UPDATE tmprstresumenstock SET
			RstStockMarca = "'.($this->RstStockMarca).'",
			RstStockLubricantes = "'.($this->RstStockLubricantes).'",
			RstTotalStock = "'.($this->RstTotalStock).'",
			RstValorRepuestoA = "'.($this->RstValorRepuestoA).'",
			RstValorRepuestoB = "'.($this->RstValorRepuestoB).'",	
			RstValorRepuestoC = "'.($this->RstValorRepuestoC).'",	
			RstAno = "'.($this->RstAno).'",
			RstMes = "'.($this->RstMes).'"

			WHERE RstId = "'.($this->RstId).'";';			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				//$this->MtdAuditarResumenStock(2,"Se edito la ResumenStock",$this);		
				return true;
			}	
				
		}	
		
	*/
	
	/*	private function MtdAuditarResumenStock($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->RstId;

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


	public function MtdObtenerResumenProductoStocksValor($oFuncion="SUM",$oParametro="RpsId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RpsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoId=NULL,$oProductoABC=NULL,$oVehiculoMarca=NULL) {

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
			
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND rps.VmaId = "'.$oVehiculoMarca.'"';
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
		WHERE 1 = 1 '.$filtrar.$fecha.$estado.$pabc.$vmodelo.$vmarca.$producto.$cvin.$ano.$mes.$orden.$paginacion;
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		settype($fila['RESULTADO'],"float");
		
		return $fila['RESULTADO'];
			
					
	}
}
?>