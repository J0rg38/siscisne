<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoListaPrecio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoListaPrecio {

    public $VlpId;
	public $VlpAno;
	public $VlpMes;
	public $VlpAnoFabricacion;
	
	public $VlpCodigo;
	public $VlpFecha;
	public $VlpFechaVigencia;
	
  	public $MonId;
	public $VlpTipoCambio;
	public $VlpObservacion;
	
	public $VlpEstado;
    public $VlpTiempoCreacion;
    public $VlpTiempoModificacion;
    public $VlpEliminado;
	
	public $MonSimbolo;
	public $MonNombre;
	
	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarVehiculoListaPrecioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VlpId,5),unsigned)) AS "MAXIMO"
			FROM tblvlpvehiculolistaprecio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VlpId ="VLP-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VlpId = "VLP-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerVehiculoListaPrecio($oCompleto=true){

        $sql = 'SELECT 
        vlp.VlpId,
		vlp.VlpAno,
		vlp.VlpMes,
	  	vlp.VmaId,
	  
		vlp.VlpAnoFabricacion,
		
		vlp.VlpCodigo,
		
		DATE_FORMAT(vlp.VlpFecha, "%d/%m/%Y") AS "NVlpFecha",
		DATE_FORMAT(vlp.VlpFechaVigencia, "%d/%m/%Y") AS "NVlpFechaVigencia",
		
		vlp.MonId,
		vlp.VlpTipoCambio,
		
		vlp.VlpObservacion,
		
		vlp.VlpEstado,
		DATE_FORMAT(vlp.VlpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVlpTiempoCreacion",
        DATE_FORMAT(vlp.VlpTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVlpTiempoModificacion",
		vma.VmaNombre
		
        FROM tblvlpvehiculolistaprecio vlp
			LEFT JOIN tblvmavehiculomarca vma
			ON vlp.VmaId = vma.VmaId
			
        WHERE vlp.VlpId = "'.$this->VlpId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VlpId = $fila['VlpId'];
			$this->VlpAno = $fila['VlpAno'];
			$this->VlpMes = $fila['VlpMes'];
			
			$this->VmaId = $fila['VmaId'];
			
			
			$this->VlpAnoFabricacion = $fila['VlpAnoFabricacion'];			
			$this->VlpCodigo = $fila['VlpCodigo'];
			
			$this->VlpFecha = $fila['NVlpFecha'];
			$this->VlpFechaVigencia = $fila['NVlpFechaVigencia'];
			
			$this->MonId = $fila['MonId'];
			$this->VlpTipoCambio = $fila['VlpTipoCambio'];
			
			$this->VlpObservacion = $fila['VlpObservacion'];

			$this->VlpEstado = $fila['VlpEstado'];
			$this->VlpTiempoCreacion = $fila['NVlpTiempoCreacion'];
			$this->VlpTiempoModificacion = $fila['NVlpTiempoModificacion']; 
			
			$this->VmaNombre = $fila['VmaNombre']; 
			
			if($oCompleto){
				$InsVehiculoListaPrecioDetalle = new ClsVehiculoListaPrecioDetalle();	
				$ResVehiculoListaPrecioDetalle = $InsVehiculoListaPrecioDetalle->MtdObtenerVehiculoListaPrecioDetalles(NULL,NULL,'VldId','ASC',NULL,$this->VlpId);	
				$this->VehiculoListaPrecioDetalle = $ResVehiculoListaPrecioDetalle['Datos'];
			}
			
			
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;

    }

    public function MtdObtenerVehiculoListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VlpId',$oSentido = 'Desc',$oPaginacion = '0,10') {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
		
		
	
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vlp.VlpId,
				vlp.VlpAno,
				vlp.VlpMes,
				vlp.VlpAnoFabricacion,
				vlp.VlpCodigo,

				DATE_FORMAT(vlp.VlpFecha, "%d/%m/%Y") AS "NVlpFecha",
				DATE_FORMAT(vlp.VlpFechaVigencia, "%d/%m/%Y") AS "NVlpFechaVigencia",
				vlp.MonId,
				vlp.VlpTipoCambio,
				
				vlp.VlpObservacion,
				vlp.VlpEstado,
				DATE_FORMAT(vlp.VlpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVlpTiempoCreacion",
                DATE_FORMAT(vlp.VlpTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVlpTiempoModificacion",
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				vma.VmaNombre
				
				FROM tblvlpvehiculolistaprecio vlp
					LEFT JOIN tblmonmoneda mon
					ON vlp.MonId = mon.MonId
					
						LEFT JOIN tblvmavehiculomarca vma
						ON vlp.VmaId = vma.VmaId
					
				WHERE 1 = 1'.$filtrar.$vversion.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsVehiculoListaPrecio = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoListaPrecio = new $InsVehiculoListaPrecio();
					$VehiculoListaPrecio->VlpId = $fila['VlpId'];
					$VehiculoListaPrecio->VlpAno = $fila['VlpAno'];
					$VehiculoListaPrecio->VlpMes = $fila['VlpMes'];
					$VehiculoListaPrecio->VlpAnoFabricacion = $fila['VlpAnoFabricacion'];				
					$VehiculoListaPrecio->VlpCodigo = $fila['VlpCodigo'];
					
					$VehiculoListaPrecio->VlpFecha = $fila['NVlpFecha'];
					$VehiculoListaPrecio->VlpFechaVigencia = $fila['NVlpFechaVigencia'];
										
					$VehiculoListaPrecio->MonId = $fila['MonId'];
					$VehiculoListaPrecio->VlpTipoCambio = $fila['VlpTipoCambio'];
					
					$VehiculoListaPrecio->VlpObservacion = $fila['VlpObservacion'];					
					$VehiculoListaPrecio->VlpEstado = $fila['VlpEstado'];
                    $VehiculoListaPrecio->VlpTiempoCreacion = $fila['NVlpTiempoCreacion'];
                    $VehiculoListaPrecio->VlpTiempoModificacion = $fila['NVlpTiempoModificacion'];
					
					$VehiculoListaPrecio->MonNombre = $fila['MonNombre'];
					$VehiculoListaPrecio->MonSimbolo = $fila['MonSimbolo'];     
					              
					$VehiculoListaPrecio->VmaNombre = $fila['VmaNombre']; 
			
					$Respuesta['Datos'][]= $VehiculoListaPrecio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoListaPrecio($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VlpId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VlpId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblvlpvehiculolistaprecio WHERE '.$eliminar;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarVehiculoListaPrecio() {
	
		$this->MtdGenerarVehiculoListaPrecioId();
			
			$this->InsMysql->MtdTransaccionIniciar();
			
		
			$sql = 'INSERT INTO tblvlpvehiculolistaprecio (
			VlpId,
			VlpAno,
			VlpMes,
			VmaId,
			
			VlpAnoFabricacion,
			VlpCodigo,

			VlpFecha,
			VlpFechaVigencia,
			
			MonId,
			VlpTipoCambio,
			
			VlpObservacion,
			VlpEstado,
			VlpTiempoCreacion,
			VlpTiempoModificacion
			) 
			VALUES (
			"'.($this->VlpId).'", 
			"'.($this->VlpAno).'", 
			"'.($this->VlpMes).'",
			"'.($this->VmaId).'",
			
			"'.($this->VlpAnoFabricacion).'",
			"'.($this->VlpCodigo).'", 
			
			"'.($this->VlpFecha).'", 
			'.(empty($this->VlpFechaVigencia)?'NULL, ':'"'.$this->VlpFechaVigencia.'",').'
						
			"'.($this->MonId).'", 			
			'.(empty($this->VlpTipoCambio)?'NULL, ':''.$this->VlpTipoCambio.',').'
			
			"'.($this->VlpObservacion).'", 
			'.($this->VlpEstado).', 
			"'.($this->VlpTiempoCreacion).'", 
			"'.($this->VlpTiempoModificacion).'");';	
				
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			
			if(!$error){			
			
				if (!empty($this->VehiculoListaPrecioDetalle)){		
						
					$validar = 0;				
					$InsVehiculoListaPrecioDetalle = new ClsVehiculoListaPrecioDetalle();		
					
					foreach ($this->VehiculoListaPrecioDetalle as $DatVehiculoListaPrecioDetalle){
					
						$InsVehiculoListaPrecioDetalle->VlpId = $this->VlpId;
						$InsVehiculoListaPrecioDetalle->VveId = $DatVehiculoListaPrecioDetalle->VveId;

						$InsVehiculoListaPrecioDetalle->VldFuente = $DatVehiculoListaPrecioDetalle->VldFuente;
						$InsVehiculoListaPrecioDetalle->VldCosto = $DatVehiculoListaPrecioDetalle->VldCosto;
						
						$InsVehiculoListaPrecioDetalle->VldPrecioCierre = $DatVehiculoListaPrecioDetalle->VldPrecioCierre;
						$InsVehiculoListaPrecioDetalle->VldPrecioLista = $DatVehiculoListaPrecioDetalle->VldPrecioLista;
						
						$InsVehiculoListaPrecioDetalle->VldBonoGM = $DatVehiculoListaPrecioDetalle->VldBonoGM;
						$InsVehiculoListaPrecioDetalle->VldBonoDealer = $DatVehiculoListaPrecioDetalle->VldBonoDealer;
						$InsVehiculoListaPrecioDetalle->VldDescuentoGerencia = $DatVehiculoListaPrecioDetalle->VldDescuentoGerencia;
						
				
						$InsVehiculoListaPrecioDetalle->VldEstado = $DatVehiculoListaPrecioDetalle->VldEstado;						
						$InsVehiculoListaPrecioDetalle->VldTiempoCreacion = $DatVehiculoListaPrecioDetalle->VldTiempoCreacion;
						$InsVehiculoListaPrecioDetalle->VldTiempoModificacion = $DatVehiculoListaPrecioDetalle->VldTiempoModificacion;						
						$InsVehiculoListaPrecioDetalle->VldEliminado = $DatVehiculoListaPrecioDetalle->VldEliminado;
						
						if($InsVehiculoListaPrecioDetalle->MtdRegistrarVehiculoListaPrecioDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VLP_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoListaPrecioDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarVehiculoListaPrecio(1,"Se registro la Lista de Precio de Vehiculos",$this);			
				return true;
			}			
			
	}
	
	public function MtdEditarVehiculoListaPrecio() {

	
		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblvlpvehiculolistaprecio SET 
		VlpAno = "'.($this->VlpAno).'",
		VlpMes = "'.($this->VlpMes).'",
		VmaId = "'.($this->VmaId).'",
		
		VlpAnoFabricacion = "'.($this->VlpAnoFabricacion).'",		
		VlpCodigo = "'.($this->VlpCodigo).'",

		VlpFecha = "'.($this->VlpFecha).'",
		'.(empty($this->VlpFechaVigencia)?'VlpFechaVigencia = NULL, ':'VlpFechaVigencia = "'.$this->VlpFechaVigencia.'",').'

		MonId = "'.($this->MonId).'",
		'.(empty($this->VlpTipoCambio)?'VlpTipoCambio = NULL, ':'VlpTipoCambio = "'.$this->VlpTipoCambio.'",').'

		VlpObservacion = "'.($this->VlpObservacion).'",
		VlpEstado = '.($this->VlpEstado).',
		VlpTiempoModificacion = "'.($this->VlpTiempoModificacion).'"
		WHERE VlpId = "'.($this->VlpId).'";';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {						
			$error = true;
		} 		


		if(!$error){
			
				if (!empty($this->VehiculoListaPrecioDetalle)){	
						
					$validar = 0;				
					$InsVehiculoListaPrecioDetalle = new ClsVehiculoListaPrecioDetalle();
							
					foreach ($this->VehiculoListaPrecioDetalle as $DatVehiculoListaPrecioDetalle){
										
						$InsVehiculoListaPrecioDetalle->VldId = $DatVehiculoListaPrecioDetalle->VldId;
						$InsVehiculoListaPrecioDetalle->VlpId = $this->VlpId;
						$InsVehiculoListaPrecioDetalle->VveId = $DatVehiculoListaPrecioDetalle->VveId;
						$InsVehiculoListaPrecioDetalle->VldFuente = $DatVehiculoListaPrecioDetalle->VldFuente;
						$InsVehiculoListaPrecioDetalle->VldCosto = $DatVehiculoListaPrecioDetalle->VldCosto;

						$InsVehiculoListaPrecioDetalle->VldPrecioCierre = $DatVehiculoListaPrecioDetalle->VldPrecioCierre;
						$InsVehiculoListaPrecioDetalle->VldPrecioLista = $DatVehiculoListaPrecioDetalle->VldPrecioLista;

						$InsVehiculoListaPrecioDetalle->VldBonoGM = $DatVehiculoListaPrecioDetalle->VldBonoGM;
						$InsVehiculoListaPrecioDetalle->VldBonoDealer = $DatVehiculoListaPrecioDetalle->VldBonoDealer;
						$InsVehiculoListaPrecioDetalle->VldDescuentoGerencia = $DatVehiculoListaPrecioDetalle->VldDescuentoGerencia;

						$InsVehiculoListaPrecioDetalle->VldEstado = $DatVehiculoListaPrecioDetalle->VldEstado;
						$InsVehiculoListaPrecioDetalle->VldTiempoCreacion = $DatVehiculoListaPrecioDetalle->VldTiempoCreacion;
						$InsVehiculoListaPrecioDetalle->VldTiempoModificacion = $DatVehiculoListaPrecioDetalle->VldTiempoModificacion;
						$InsVehiculoListaPrecioDetalle->VldEliminado = $DatVehiculoListaPrecioDetalle->VldEliminado;
						
						if(empty($InsVehiculoListaPrecioDetalle->VldId)){
							if($InsVehiculoListaPrecioDetalle->VldEliminado<>2){
								if($InsVehiculoListaPrecioDetalle->MtdRegistrarVehiculoListaPrecioDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VLP_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoListaPrecioDetalle->VldEliminado==2){
								if($InsVehiculoListaPrecioDetalle->MtdEliminarVehiculoListaPrecioDetalle($InsVehiculoListaPrecioDetalle->VldId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VLP_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoListaPrecioDetalle->MtdEditarVehiculoListaPrecioDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VLP_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoListaPrecioDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarVehiculoListaPrecio(1,"Se edito la Lista de Precio de Vehiculos",$this);			
				return true;
			}	
	}	
	
	
	
	private function MtdAuditarVehiculoListaPrecio($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->VlpId;

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