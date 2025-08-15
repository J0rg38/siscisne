<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenFichaIngresoTiempo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsResumenFichaIngresoTiempo {

    public $RftId;
	public $RftMes;
	public $RftAno;
	public $RftPromedioInicioFin;
	
	public $RftTiempoCreacion;
	public $RftTiempoModificacion;
    public $RftEliminado;
	
	public $ResumenFichaIngresoTiempoVehiculo;

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

	public function MtdGenerarResumenFichaIngresoTiempoId() {

			
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(rft.RftId,5),unsigned)) AS "MAXIMO"
		FROM tmprftresumenfichaingresotiempo rft;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->RftId = "RFTE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->RftId = "RFTE-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerResumenFichaIngresoTiempo($oCompleto=true){

        $sql = 'SELECT 
		rft.RftId,
		rft.RftMes,
		rft.RftAno,
		rft.RftPromedioInicioFin,
		DATE_FORMAT(rft.RftTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRftTiempoCreacion"	
        FROM tmprftresumenfichaingresotiempo rft
		
        WHERE rft.RftId = "'.$this->RftId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->RftId = $fila['RftId'];
			$this->RftMes = $fila['RftMes'];
			$this->RftAno = $fila['RftAno'];
			$this->RftPromedioInicioFin = $fila['RftPromedioInicioFin'];
			$this->RftTiempoCreacion = $fila['NRftTiempoCreacion'];

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdObtenerResumenFichaIngresoTiempoMensual($oAno,$oMes){
		
		$ResumenFichaIngresoTiempo = NULL;
		$ResumenFichaIngresoTiempoId = "";
		
		$ResResumenFichaIngresoTiempo = $this->MtdObtenerResumenFichaIngresoTiempos(NULL,NULL,NULL,"RftTiempoCreacion","DESC","1",$oAno,$oMes);
		$ArrResumenFichaIngresoTiempos = $ResResumenFichaIngresoTiempo['Datos'];
		
		if(!empty($ArrResumenFichaIngresoTiempos)){
			foreach($ArrResumenFichaIngresoTiempos as $DatResumenFichaIngresoTiempo){
				
				$ResumenFichaIngresoTiempoId = $DatResumenFichaIngresoTiempo->RftId;
				
			}
		}
		
		if(!empty($ResumenFichaIngresoTiempoId)){

			$this->RftId = $ResumenFichaIngresoTiempoId;
			$ResumenFichaIngresoTiempo = $this->MtdObtenerResumenFichaIngresoTiempo(false);	

		}
		
		return 	$ResumenFichaIngresoTiempo;	
	}

    public function MtdObtenerResumenFichaIngresoTiempos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RftId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL) {

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
			$ano = ' AND rft.RftAno = "'.$oAno.'"';
		}
		
		if(!empty($oMes)){
			$mes = ' AND rft.RftMes = "'.$oMes.'"';
		}
			
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					rft.RftId,
					rft.RftMes,
					rft.RftAno,					
					rft.RftPromedioInicioFin,
					DATE_FORMAT(rft.RftTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRftTiempoCreacion"

				FROM tmprftresumenfichaingresotiempo rft
						
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$vmodelo.$ano.$mes.$cvin.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsResumenFichaIngresoTiempo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ResumenFichaIngresoTiempo = new $InsResumenFichaIngresoTiempo();
                    $ResumenFichaIngresoTiempo->RftId = $fila['RftId'];
					$ResumenFichaIngresoTiempo->RftMes = $fila['RftMes'];
					$ResumenFichaIngresoTiempo->RftAno = $fila['RftAno'];
					$ResumenFichaIngresoTiempo->RftPromedioInicioFin = $fila['RftPromedioInicioFin'];
					$ResumenFichaIngresoTiempo->RftTiempoCreacion = $fila['NRftTiempoCreacion'];
				
                    $ResumenFichaIngresoTiempo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ResumenFichaIngresoTiempo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	/*
	//Accion eliminar	 
	public function MtdEliminarResumenFichaIngresoTiempo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsResumenFichaIngresoTiempoVehiculo = new ClsResumenFichaIngresoTiempoVehiculo();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
						$sql = 'DELETE FROM tmprftresumenfichaingresotiempo WHERE  (RftId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
//							//$this->MtdAuditarResumenFichaIngresoTiempo(3,"Se elimino la ResumenFichaIngresoTiempo",$elemento);		
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
	public function MtdActualizarEstadoResumenFichaIngresoTiempo($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tmprftresumenfichaingresotiempo SET RftEstado = '.$oEstado.' WHERE RftId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						$Auditoria = "Se actualizo el Estado de la ResumenFichaIngresoTiempo";

						$this->RftId = $elemento;						
						//$this->MtdAuditarResumenFichaIngresoTiempo(2,$Auditoria,$elemento);

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
	
	
	public function MtdRegistrarResumenFichaIngresoTiempo() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarResumenFichaIngresoTiempoId();
		
		$this->InsMysql->MtdTransaccionIniciar();		
					
			$sql = 'INSERT INTO tmprftresumenfichaingresotiempo (
			RftId,
			RftMes,
			RftAno,
			RftPromedioInicioFin,
			RftTiempoCreacion,
			RftVentaRetailLubricantes,
			RftTotalVentasRetail,
			RftMargenAporte,
			RftAno,
			RftMes,
			RftTiempoCreacion
			) 
			VALUES (
			"'.($this->RftId).'", 
			"'.($this->RftMes).'", 
			"'.($this->RftAno).'", 
			"'.($this->RftPromedioInicioFin).'",
			"'.($this->RftTiempoCreacion).'",
			"'.($this->RftVentaRetailLubricantes).'",
			"'.($this->RftTotalVentasRetail).'",
			"'.($this->RftMargenAporte).'",
			"'.($this->RftAno).'",
			"'.($this->RftMes).'",
			"'.($this->RftTiempoCreacion).'");';			

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
			//$this->MtdAuditarResumenFichaIngresoTiempo(1,"Se registro la ResumenFichaIngresoTiempo",$this);			
			return true;
		}
					
	}
	/*
	public function MtdEditarResumenFichaIngresoTiempo() {

		global $Resultado;
		$error = false;
	
			$this->InsMysql->MtdTransaccionIniciar();
	
			$sql = 'UPDATE tmprftresumenfichaingresotiempo SET
			RftMes = "'.($this->RftMes).'",
			RftAno = "'.($this->RftAno).'",
			RftPromedioInicioFin = "'.($this->RftPromedioInicioFin).'",
			RftTiempoCreacion = "'.($this->RftTiempoCreacion).'",
			RftVentaRetailLubricantes = "'.($this->RftVentaRetailLubricantes).'",	
			RftTotalVentasRetail = "'.($this->RftTotalVentasRetail).'",	
			RftAno = "'.($this->RftAno).'",
			RftMes = "'.($this->RftMes).'"

			WHERE RftId = "'.($this->RftId).'";';			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				//$this->MtdAuditarResumenFichaIngresoTiempo(2,"Se edito la ResumenFichaIngresoTiempo",$this);		
				return true;
			}	
				
		}	
		
	*/
	
	/*	private function MtdAuditarResumenFichaIngresoTiempo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->RftId;

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