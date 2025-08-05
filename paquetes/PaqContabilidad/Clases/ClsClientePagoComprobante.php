<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsClientePagoComprobante
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsClientePagoComprobante {

    public $CpcId;

    public $CpaId;

	public $FacId;
	public $FtaId;
	public $BolId;
	public $BtaId;
	public $FexId;
	public $FetId;
	
    public $CpcTiempoCreacion;
    public $CpcTiempoModificacion;
    public $CpcEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarClientePagoComprobanteId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CpcId,5),unsigned)) AS "MAXIMO"
			FROM tblcpcclientepagocomprobante';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CpcId = "CPC-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CpcId = "CPC-".$fila['MAXIMO'];					
			}
			
				
		}
		
    public function MtdObtenerClientePagoComprobante(){

        $sql = 'SELECT 
        CpcId,
	
        CpaId,
		
		FacId,
		FtaId,
		BolId,
		BtaId
		FexId,
		FetId

        FROM tblcpcclientepagocomprobante
        WHERE CpcId = "'.$this->CpcId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CpcId = $fila['CpcId'];
			
            $this->CpaId = $fila['CpaId'];
			
			$this->FacId = $fila['FacId'];
			$this->FtaId = $fila['FtaId'];
			
			$this->BolId = $fila['BolId']; 
			$this->BtaId = $fila['BtaId']; 
			
				$this->FexId = $fila['FexId']; 
			$this->FetId = $fila['FetId']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerClientePagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CpcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oClientePago=NULL) {

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
		
		if(!empty($oClientePago)){
			$cpago = ' AND cpc.CpaId = "'.$oClientePago.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cpc.CpcId,
			
				cpc.CpaId,
				
				cpc.FacId,
				cpc.FtaId,
				cpc.BolId,
				cpc.BtaId,
				
				cpc.FexId,
				cpc.FetId,
		
				fta.FtaNumero,
				bta.BtaNumero,
				fet.FetNumero
					
				FROM tblcpcclientepagocomprobante cpc
					LEFT JOIN tblfacfactura fac
					ON (cpc.FacId = fac.FacId AND cpc.FtaId = fac.FtaId)
					
						LEFT JOIN tblftafacturatalonario fta
						ON cpc.FtaId = fta.FtaId
						
							LEFT JOIN tblbolboleta bol
							ON (cpc.BolId = bol.BolId AND cpc.BtaId = bol.BtaId)			
							
								LEFT JOIN tblbtaboletatalonario bta
								ON cpc.BtaId = bta.BtaId
									
									LEFT JOIN tblfexfacturaexportacion fex
									ON (cpc.FexId = fex.FexId AND cpc.FetId = fex.FetId)
									
										LEFT JOIN tblfetfacturaexportaciontalonario fet
										ON cpc.FetId = fet.FetId
						
				WHERE  1 = 1 '.$filtrar.$cpago.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsClientePagoComprobante = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ClientePagoComprobante = new $InsClientePagoComprobante();
                    $ClientePagoComprobante->CpcId = $fila['CpcId'];
					
                    $ClientePagoComprobante->CpaId = $fila['CpaId'];
					$ClientePagoComprobante->FacId = $fila['FacId'];
					$ClientePagoComprobante->FtaId = $fila['FtaId'];
					
					$ClientePagoComprobante->BolId = $fila['BolId'];
					$ClientePagoComprobante->FacId = $fila['FacId'];
					
					$ClientePagoComprobante->FexId = $fila['FexId'];
					$ClientePagoComprobante->FetId = $fila['FetId'];
					
					$ClientePagoComprobante->FtaNumero = $fila['FtaNumero'];
					$ClientePagoComprobante->BtaNumero = $fila['BtaNumero'];
					$ClientePagoComprobante->FetNumero = $fila['FetNumero'];
					
                    $ClientePagoComprobante->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ClientePagoComprobante;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		

	
	//Accion eliminar	 
	
	public function MtdEliminarClientePagoComprobante($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CpcId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CpcId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
			
			$sql = 'DELETE FROM tblcpcclientepagocomprobante WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarClientePagoComprobante() {
	
			$this->MtdGenerarClientePagoComprobanteId();
		
			$sql = 'INSERT INTO tblcpcclientepagocomprobante (
			CpcId,
			
			CpaId,
		  	FacId,
			FtaId,
			
			FexId,
			FetId,
			
			BolId,
			BtaId
			
			) 
			VALUES (
			"'.($this->CpcId).'", 
				
			"'.($this->CpaId).'", 
			
			'.(empty($this->FacId)?'NULL, ':'"'.$this->FacId.'",').'
			'.(empty($this->FtaId)?'NULL, ':'"'.$this->FtaId.'",').'
			
			'.(empty($this->FexId)?'NULL, ':'"'.$this->FexId.'",').'
			'.(empty($this->FetId)?'NULL, ':'"'.$this->FetId.'",').'
			
			'.(empty($this->BolId)?'NULL, ':'"'.$this->BolId.'",').'
			'.(empty($this->BtaId)?'NULL ':'"'.$this->BtaId.'"').');';					

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
	
	public function MtdEditarClientePagoComprobante() {
		
			$sql = 'UPDATE tblcpcclientepagocomprobante SET 
			 CpaId = "'.($this->CpaId).'",
			 
			 '.(empty($this->FacId)?'FacId = NULL, ':'FacId = "'.$this->FacId.'",').'
			 '.(empty($this->FtaId)?'FtaId = NULL, ':'FtaId = "'.$this->FtaId.'",').'
			 
			 '.(empty($this->FexId)?'FexId = NULL, ':'FexId = "'.$this->FexId.'",').'
			 '.(empty($this->FetId)?'FetId = NULL, ':'FetId = "'.$this->FetId.'",').'
			 
			 '.(empty($this->BolId)?'BolId = NULL, ':'BolId = "'.$this->BolId.'",').'
			 '.(empty($this->BtaId)?'BtaId = NULL ':'BtaId = "'.$this->BtaId.'"').'
			
			 WHERE CpcId = "'.($this->CpcId).'";';
			
		
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