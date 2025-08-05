<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotificacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotificacion {

    public $NfnId;
	public $UsuId;
	public $UsuIdOrigen;
	
	public $NfnModulo;
	public $NfnFormulario;
	public $NfnIcono;
	public $NfnDescripcion;
	public $NfnEnlace;
	public $NfnEnlaceNombre;

	public $NfnEstado;	
    public $NfnTiempoCreacion;
    public $NfnTiempoModificacion;
    public $NfnEliminado;

	public $InsMysql;

	public $Transaccion;
	
    public function __construct(){

		$this->InsMysql = new ClsMysql();
		$this->Transaccion = true;
		
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarNotificacionId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(NfnId,5),unsigned)) AS "MAXIMO"
			FROM tblnfnnotificacion';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->NfnId = "NOT-10000";

			}else{
				$fila['MAXIMO']++;
				$this->NfnId = "NOT-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerNotificacion(){

        $sql = 'SELECT 
        nfn.NfnId,
		nfn.UsuId,
		nfn.UsuIdOrigen,
		
		nfn.NfnModulo,
		nfn.NfnFormulario,		
		nfn.NfnIcono,
		nfn.NfnDescripcion,
		nfn.NfnEnlace,
		nfn.NfnEnlaceNombre,
		
		nfn.NfnEstado,	
		DATE_FORMAT(nfn.NfnTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNfnTiempoCreacion",
        DATE_FORMAT(nfn.NfnTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNfnTiempoModificacion",
		
		usu.UsuUsuario		
		
        FROM tblnfnnotificacion nfn
			LEFT JOIN tblusuusuario usu
			ON nfn.UsuId = usu.UsuId
									
        WHERE nfn.NfnId = "'.$this->NfnId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->NfnId = $fila['NfnId'];
			$this->UsuId = $fila['UsuId'];
			$this->UsuIdOrigen = $fila['UsuIdOrigen'];
			
			$this->EinId = $fila['EinId'];
			$this->PerId = $fila['PerId'];
			
			$this->NfnModulo = $fila['NfnModulo'];			
			$this->NfnFormulario = $fila['NfnFormulario'];
			$this->NfnIcono = $fila['NfnIcono'];
			$this->NfnDescripcion = $fila['NfnDescripcion'];
			$this->NfnEnlace = $fila['NfnEnlace'];
			$this->NfnEnlaceNombre = $fila['NfnEnlaceNombre'];

			$this->NfnEstado = $fila['NfnEstado'];
			$this->NfnTiempoCreacion = $fila['NNfnTiempoCreacion'];
			$this->NfnTiempoModificacion = $fila['NNfnTiempoModificacion'];
			
			$this->UsuUsuario = $fila['UsuUsuario'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerNotificacions($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NfnId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUsuario=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {


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
			
				
		if(!empty($oEstado)){
			$estado = ' AND nfn.NfnEstado = '.$oEstado;
		}	
		
		if(!empty($oUsuario)){
			$usuario = ' AND nfn.UsuId = "'.$oUsuario.'"';
		}
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(nfn.NfnTiempoCreacion)>="'.$oFechaInicio.'" AND DATE(nfn.NfnTiempoCreacion)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(nfn.NfnTiempoCreacion)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(nfn.NfnTiempoCreacion)<="'.$oFechaFin.'"';		
			}			
		}

		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				 nfn.NfnId,
		nfn.UsuId,
		nfn.UsuIdOrigen,
		
		nfn.NfnModulo,
		nfn.NfnFormulario,		
		nfn.NfnIcono,
		nfn.NfnDescripcion,
		nfn.NfnEnlace,
		nfn.NfnEnlaceNombre,
		
		nfn.NfnEstado,	
		DATE_FORMAT(nfn.NfnTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNfnTiempoCreacion",
        DATE_FORMAT(nfn.NfnTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNfnTiempoModificacion",
		
		usu.UsuUsuario,

		usu2.UsuFoto AS UsuFotoOrigen
		
				
		FROM tblnfnnotificacion nfn
			LEFT JOIN tblusuusuario usu
			ON nfn.UsuId = usu.UsuId
				LEFT JOIN tblusuusuario usu2
				ON nfn.UsuIdOrigen = usu2.UsuId
											
				WHERE 1 = 1 '.$filtrar.$estado.$usuario.$personal.$fecha.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotificacion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Notificacion = new $InsNotificacion();				
					
                    $Notificacion->NfnId = $fila['NfnId'];
					$Notificacion->UsuId = $fila['UsuId'];
					$Notificacion->UsuIdOrigen = $fila['UsuIdOrigen'];

					$Notificacion->NfnModulo= $fila['NfnModulo'];
					$Notificacion->NfnFormulario= $fila['NfnFormulario'];
					$Notificacion->NfnIcono = $fila['NfnIcono'];
					$Notificacion->NfnDescripcion = $fila['NfnDescripcion'];
					$Notificacion->NfnEnlace = $fila['NfnEnlace'];
					$Notificacion->NfnEnlaceNombre = $fila['NfnEnlaceNombre'];

					$Notificacion->NfnEstado = $fila['NfnEstado'];					
                    $Notificacion->NfnTiempoCreacion = $fila['NNfnTiempoCreacion'];
                    $Notificacion->NfnTiempoModificacion = $fila['NNfnTiempoModificacion'];    

					$Notificacion->UsuUsuario = $fila['UsuUsuario'];    
					$Notificacion->UsuFotoOrigen = $fila['UsuFotoOrigen'];    
					 
                    $Notificacion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Notificacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarNotificacion($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (NfnId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (NfnId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblnfnnotificacion WHERE '.$eliminar;
			
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
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoNotificacion($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tblnfnnotificacion SET NfnEstado = '.$oEstado.' WHERE NfnId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
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
	
	
	
	public function MtdRegistrarNotificacion() {
	

		global $Resultado;
		$error = false;
		//
//		$this->MtdVerificarExisteNotificacion();
		
		//if(!empty($this->UsuId)){
//			$error = true;
//			$Resultado.='#ERR_NOT_201';
//		}
			
			
			$this->MtdGenerarNotificacionId();
				
			$sql = 'INSERT INTO tblnfnnotificacion (
			NfnId,
			UsuId,
			UsuIdOrigen,

			NfnModulo,			
			NfnFormulario,
			NfnIcono,
			NfnDescripcion,
			
			NfnEnlace,
			NfnEnlaceNombre,
			NfnPersonalNombreCompleto,
			NfnPersonalFoto,
			NfnEstado,
			NfnTiempoCreacion,
			NfnTiempoModificacion
			) 
			VALUES (
			"'.($this->NfnId).'",
			'.(empty($this->UsuId)?"NULL,":'"'.$this->UsuId.'",').'
			'.(empty($this->UsuIdOrigen)?"NULL,":'"'.$this->UsuIdOrigen.'",').'		
	
			"'.($this->NfnModulo).'",
			"'.($this->NfnFormulario).'",
			"'.($this->NfnIcono).'",
			"'.($this->NfnDescripcion).'",
			
			"'.($this->NfnEnlace).'",
			"'.($this->NfnEnlaceNombre).'",
			"'.($this->NfnPersonalNombreCompleto).'",
			"'.($this->NfnPersonalFoto).'",
			'.($this->NfnEstado).', 
			"'.($this->NfnTiempoCreacion).'", 
			"'.($this->NfnTiempoModificacion).'");';					

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,true);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	
	
	public function MtdEditarNotificacion() {
		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
	
			$sql = 'UPDATE tblnfnnotificacion SET 
			UsuId = "'.($this->UsuId).'",
			UsuIdOrigen = "'.($this->UsuIdOrigen).'",

			NfnModulo = "'.($this->NfnModulo).'",
			NfnFormulario = "'.($this->NfnFormulario).'",
			NfnIcono = "'.($this->NfnIcono).'",
			NfnDescripcion = "'.($this->NfnDescripcion).'",

			NfnEnlace = "'.($this->NfnEnlace).'",
			NfnEnlaceNombre = "'.($this->NfnEnlaceNombre).'",
			NfnEstado = '.($this->NfnEstado).',
			NfnTiempoModificacion = "'.($this->NfnTiempoModificacion).'"
			WHERE NfnId = "'.($this->NfnId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {
//				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();
//				}
				return false;
			} else {				
//				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();
//				}
				return true;
			}					
		}	
		
				
		
				
	
}
?>