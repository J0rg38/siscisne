<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsResumenVenta {

    public $RveId;
	public $VmaId;
	
	public $RveVentaTallerMarca;
	public $RveVentaPPMarca;
	
	public $RveVentaMesonMarca;
	public $RveVentaRetailMarca;
	public $RveVentaRetailLubricantes;
	public $RveTotalVentasRetail;
	public $RveAno;
	public $RveMes;

	public $RveMargenAporte;

	public $RveTiempoCreacion;
	public $RveTiempoModificacion;
    public $RveEliminado;
	
	public $ResumenVentaVehiculo;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarResumenVentaId() {
/*

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(rve.RveId,13),unsigned)) AS "MAXIMO"
			FROM tmprveresumenventa rve
			WHERE YEAR(rve.RveFechaInicio) = ("'.$this->RveAno.'")
			
';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RveId = "RVE-".$this->RveAno."-00001";
			
			}else{
				$fila['MAXIMO']++;
				$this->RveId = "RVE".$this->RveAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
			}
			*/
			
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(rve.RveId,5),unsigned)) AS "MAXIMO"
		FROM tmprveresumenventa rve;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->RveId = "RVE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->RveId = "RVE-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerResumenVenta($oCompleto=true){

        $sql = 'SELECT 
		rve.RveId,
		rve.VmaId,
		
		rve.RveVentaTallerMarca,
		rve.RveVentaPPMarca,
		rve.RveVentaMesonMarca,
		rve.RveVentaRetailMarca,
		rve.RveVentaRetailLubricantes,
		rve.RveTotalVentasRetail,
		rve.RveMargenAporte
		
        FROM tmprveresumenventa rve
		
        WHERE rve.RveId = "'.$this->RveId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->RveId = $fila['RveId'];
			$this->VmaId = $fila['VmaId'];
			
			$this->RveVentaTallerMarca = $fila['RveVentaTallerMarca'];
			$this->RveVentaPPMarca = $fila['RveVentaPPMarca'];
			$this->RveVentaMesonMarca = $fila['RveVentaMesonMarca'];
			$this->RveVentaRetailMarca = $fila['RveVentaRetailMarca'];
			$this->RveVentaRetailLubricantes = $fila['RveVentaRetailLubricantes'];
			$this->RveTotalVentasRetail = $fila['RveTotalVentasRetail'];
			$this->RveAno = $fila['RveAno'];
			$this->RveMes = $fila['RveMes'];
			$this->RveMargenAporte = $fila['RveMargenAporte'];

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdObtenerResumenVentaMensual($oAno,$oMes,$oVehiculoMarca=NULL){
		
		$ResumenVenta = NULL;
		$ResumenVentaId = "";
		
		$ResResumenVenta = $this->MtdObtenerResumenVentas(NULL,NULL,NULL,"RveTiempoCreacion","DESC","1",$oAno,$oMes,$oVehiculoMarca);
		$ArrResumenVentas = $ResResumenVenta['Datos'];
		
		if(!empty($ArrResumenVentas)){
			foreach($ArrResumenVentas as $DatResumenVenta){
				
				$ResumenVentaId = $DatResumenVenta->RveId;
				
			}
		}
		
		if(!empty($ResumenVentaId)){

			$this->RveId = $ResumenVentaId;
			$ResumenVenta = $this->MtdObtenerResumenVenta(false);	

		}
		
		return 	$ResumenVenta;	
	}

    public function MtdObtenerResumenVentas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL) {

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
			$ano = ' AND rve.RveAno = "'.$oAno.'"';
		}
		
		if(!empty($oMes)){
			$mes = ' AND rve.RveMes = "'.$oMes.'"';
		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND rve.VmaId = "'.$oVehiculoMarca.'"';
		}
			
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					rve.RveId,
					rve.VmaId,
					
					rve.RveVentaTallerMarca,
					rve.RveVentaPPMarca,
					
					rve.RveVentaMesonMarca,
					rve.RveVentaRetailMarca,
					rve.RveVentaRetailLubricantes,
					rve.RveTotalVentasRetail,
					rve.RveAno,
					rve.RveMes,
					rve.RveMargenAporte,
					DATE_FORMAT(rve.RveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRveTiempoCreacion"

				FROM tmprveresumenventa rve
						
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$vmarca.$vmodelo.$ano.$mes.$cvin.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsResumenVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ResumenVenta = new $InsResumenVenta();
                    $ResumenVenta->RveId = $fila['RveId'];
					$ResumenVenta->VmaId = $fila['VmaId'];
					
					$ResumenVenta->RveVentaTallerMarca = $fila['RveVentaTallerMarca'];
					$ResumenVenta->RveVentaPPMarca = $fila['RveVentaPPMarca'];
					$ResumenVenta->RveVentaMesonMarca = $fila['RveVentaMesonMarca'];
					$ResumenVenta->RveVentaRetailMarca = $fila['RveVentaRetailMarca'];
					$ResumenVenta->RveVentaRetailLubricantes = $fila['RveVentaRetailLubricantes'];
					$ResumenVenta->RveTotalVentasRetail = $fila['RveTotalVentasRetail'];
					$ResumenVenta->RveAno = $fila['RveAno'];
					$ResumenVenta->RveMes = $fila['RveMes'];
					$ResumenVenta->RveMargenAporte = $fila['RveMargenAporte'];
					$ResumenVenta->RveTiempoCreacion = $fila['NRveTiempoCreacion'];
			
                    $ResumenVenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ResumenVenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	/*
	//Accion eliminar	 
	public function MtdEliminarResumenVenta($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsResumenVentaVehiculo = new ClsResumenVentaVehiculo();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
						$sql = 'DELETE FROM tmprveresumenventa WHERE  (RveId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
//							//$this->MtdAuditarResumenVenta(3,"Se elimino la ResumenVenta",$elemento);		
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
	public function MtdActualizarEstadoResumenVenta($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tmprveresumenventa SET RveEstado = '.$oEstado.' WHERE RveId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						$Auditoria = "Se actualizo el Estado de la ResumenVenta";

						$this->RveId = $elemento;						
						//$this->MtdAuditarResumenVenta(2,$Auditoria,$elemento);

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
	
	
	public function MtdRegistrarResumenVenta() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarResumenVentaId();
		
		$this->InsMysql->MtdTransaccionIniciar();		
					
			$sql = 'INSERT INTO tmprveresumenventa (
			RveId,
			VmaId,
			
			RveVentaTallerMarca,
			RveVentaPPMarca,
			RveVentaMesonMarca,
			RveVentaRetailMarca,
			RveVentaRetailLubricantes,
			RveTotalVentasRetail,
			RveMargenAporte,
			RveAno,
			RveMes,
			RveTiempoCreacion
			) 
			VALUES (
			"'.($this->RveId).'", 
			"'.($this->VmaId).'", 
			
			"'.($this->RveVentaTallerMarca).'", 
			"'.($this->RveVentaPPMarca).'", 
			"'.($this->RveVentaMesonMarca).'",
			"'.($this->RveVentaRetailMarca).'",
			"'.($this->RveVentaRetailLubricantes).'",
			"'.($this->RveTotalVentasRetail).'",
			"'.($this->RveMargenAporte).'",
			"'.($this->RveAno).'",
			"'.($this->RveMes).'",
			"'.($this->RveTiempoCreacion).'");';			

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
			//$this->MtdAuditarResumenVenta(1,"Se registro la ResumenVenta",$this);			
			return true;
		}
					
	}
	/*
	public function MtdEditarResumenVenta() {

		global $Resultado;
		$error = false;
	
			$this->InsMysql->MtdTransaccionIniciar();
	
			$sql = 'UPDATE tmprveresumenventa SET
			RveVentaTallerMarca = "'.($this->RveVentaTallerMarca).'",
			RveVentaPPMarca = "'.($this->RveVentaPPMarca).'",
			RveVentaMesonMarca = "'.($this->RveVentaMesonMarca).'",
			RveVentaRetailMarca = "'.($this->RveVentaRetailMarca).'",
			RveVentaRetailLubricantes = "'.($this->RveVentaRetailLubricantes).'",	
			RveTotalVentasRetail = "'.($this->RveTotalVentasRetail).'",	
			RveAno = "'.($this->RveAno).'",
			RveMes = "'.($this->RveMes).'"

			WHERE RveId = "'.($this->RveId).'";';			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				//$this->MtdAuditarResumenVenta(2,"Se edito la ResumenVenta",$this);		
				return true;
			}	
				
		}	
		
	*/
	
	/*	private function MtdAuditarResumenVenta($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->RveId;

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