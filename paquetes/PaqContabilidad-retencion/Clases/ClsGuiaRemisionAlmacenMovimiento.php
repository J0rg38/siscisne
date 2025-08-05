<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGuiaRemisionAlmacenMovimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGuiaRemisionAlmacenMovimiento {

    public $GamId;
    public $GreId;
	public $GrtId;
	public $AmoId;	
	
	
	public $AmoFecha;	
	public $AmoObservacion;	
	
	public $VdiId;	
	public $VdiFecha;	
	public $VdiObservacion;	
				
    public $GamEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarGuiaRemisionAlmacenMovimientoId() {

			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(GamId,5),unsigned)) AS "MAXIMO"
			FROM tblgamguiaremisionalmacenmovimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->GamId = "GAM-10000";
			}else{
				$fila['MAXIMO']++;
				$this->GamId = "GAM-".$fila['MAXIMO'];					
			}
			
					
		}


    public function MtdObtenerGuiaRemisionAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGuiaRemision=NULL,$oTalonario=NULL,$oTipo=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oGuiaRemision) and !empty($oTalonario)){
			$guiaremision = ' AND gam.GreId = "'.$oGuiaRemision.'" AND gam.GrtId = "'.$oTalonario.'" ';
		}
		
		
		
		if(!empty($oTipo)){
			
			switch($oTipo){
				case 1:
					$tipo = ' AND gam.AmoId IS NOT NULL ';
				break;
				
				case  2:
					$tipo = ' AND gam.VmvId IS NOT NULL ';
				break;;
			}
			
		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				gam.GamId,
				gam.GreId,
				gam.GrtId,
				
				gam.AmoId,
				gam.VmvId,
				
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.AmoSubTipo,
				amo.AmoObservacion,
				
				DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
				vmv.VmvSubTipo,

				amo.VdiId,
				DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
				vdi.VdiObservacion,
				
				cli.CliNumeroDocumento,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNombreCompleto
				
				FROM tblgamguiaremisionalmacenmovimiento gam
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON gam.AmoId = amo.AmoId
				
						LEFT JOIN tblvmvvehiculomovimiento vmv
						ON gam.VmvId = vmv.VmvId
						
						LEFT JOIn tblvdiventadirecta vdi
						ON amo.VdiId = vdi.VdiId
							
							LEFT JOIN tblclicliente cli
							ON (vmv.CliId = cli.CliId OR amo.CliId = cli.CliId)
							
						
														
				WHERE 1 = 1 '.$filtrar.$guiaremision.$tipo.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGuiaRemisionAlmacenMovimiento = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GuiaRemisionAlmacenMovimiento = new $InsGuiaRemisionAlmacenMovimiento();
                    $GuiaRemisionAlmacenMovimiento->GamId = $fila['GamId'];
					$GuiaRemisionAlmacenMovimiento->GreId = (($fila['GreId']));	
                    $GuiaRemisionAlmacenMovimiento->GrtId = $fila['GrtId'];
					
					$GuiaRemisionAlmacenMovimiento->AmoId = $fila['AmoId'];	
					$GuiaRemisionAlmacenMovimiento->VmvId = $fila['VmvId'];	
					$GuiaRemisionAlmacenMovimiento->TalId = $fila['TalId'];
					
					$GuiaRemisionAlmacenMovimiento->AmoFecha = $fila['NAmoFecha'];	
					$GuiaRemisionAlmacenMovimiento->AmoSubTipo = $fila['AmoSubTipo'];	
					$GuiaRemisionAlmacenMovimiento->AmoObservacion = $fila['AmoObservacion'];	
					
					$GuiaRemisionAlmacenMovimiento->VmvFecha = $fila['NVmvFecha'];	
					$GuiaRemisionAlmacenMovimiento->VmvSubTipo = $fila['VmvSubTipo'];	
					
					$GuiaRemisionAlmacenMovimiento->VdiId = $fila['VdiId'];	
					$GuiaRemisionAlmacenMovimiento->VdiFecha = $fila['NVdiFecha'];	
					$GuiaRemisionAlmacenMovimiento->VdiObservacion = $fila['VdiObservacion'];	
					
					
					$GuiaRemisionAlmacenMovimiento->CliNumeroDocumento = $fila['CliNumeroDocumento'];	
					$GuiaRemisionAlmacenMovimiento->CliNombre = $fila['CliNombre'];	
					$GuiaRemisionAlmacenMovimiento->CliApellidoPaterno = $fila['CliApellidoPaterno'];	
					$GuiaRemisionAlmacenMovimiento->CliApellidoMaterno = $fila['CliApellidoMaterno'];	
					$GuiaRemisionAlmacenMovimiento->CliNombreCompleto = $fila['CliNombreCompleto'];	
					
					
				
					$GuiaRemisionAlmacenMovimiento->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GuiaRemisionAlmacenMovimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	
	//Accion eliminar	 
	
	public function MtdEliminarGuiaRemisionAlmacenMovimiento($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (GamId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GamId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM tblgamguiaremisionalmacenmovimiento 
			WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarGuiaRemisionAlmacenMovimiento() {
	
			$this->MtdGenerarGuiaRemisionAlmacenMovimientoId();
		
			$sql = 'INSERT INTO tblgamguiaremisionalmacenmovimiento (
			GamId,
			AmoId,
			VmvId,
			TalId,
			
			GreId,		
			GrtId) 
			VALUES (
			"'.($this->GamId).'", 
			'.(empty($this->AmoId)?'NULL, ':'"'.$this->AmoId.'",').'
			'.(empty($this->VmvId)?'NULL, ':'"'.$this->VmvId.'",').'
			'.(empty($this->TalId)?'NULL, ':'"'.$this->TalId.'",').'
			
			"'.($this->GreId).'", 				
			"'.($this->GrtId).'");';

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
	
	public function MtdEditarGuiaRemisionAlmacenMovimiento() {
		
			$sql = 'UPDATE tblgamguiaremisionalmacenmovimiento SET
			
			'.(empty($this->AmoId)?'AmoId = NULL, ':'AmoId = "'.$this->AmoId.'", ').'
			'.(empty($this->VmvId)?'VmvId = NULL, ':'VmvId = "'.$this->VmvId.'", ').'
			
			'.(empty($this->TalId)?'TalId = NULL ':'TalId = "'.$this->TalId.'" ').'
			
			 WHERE GamId = "'.($this->GamId).'";';
					
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
		
	
}
?>