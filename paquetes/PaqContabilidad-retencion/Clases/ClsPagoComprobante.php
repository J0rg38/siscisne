<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPagoComprobante
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPagoComprobante {

    public $PacId;
    public $PagId;
	public $OvvId;
	public $VdiId;
	
	public $FacId;
	public $FtaId;
	
	public $BolId;
	public $BtaId;
	
	public $FexId;
	public $FetId;
	
	public $PacEstado;	
    public $PacTiempoCreacion;
    public $PacTiempoModificacion;
    public $PacEliminado;
    public $InsMysql;

	public $FtaNumero;
	
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

	public function MtdGenerarPagoComprobanteId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PacId,5),unsigned)) AS "MAXIMO"
			FROM tblpacpagocomprobante';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PacId = "PAC-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PacId = "PAC-".$fila['MAXIMO'];					
			}
			
				
		}
		
    public function MtdObtenerPagoComprobante(){

        $sql = 'SELECT 
        pac.PacId,
        pac.PagId,
		pac.OvvId,
		pac.VdiId,
		
		pac.FacId,
		pac.FtaId,
		
		pac.BolId,
		pac.BtaId,
		
		pac.FexId,
		pac.FetId,
		
		pac.PacEstado,
		DATE_FORMAT(pac.PacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPacTiempoCreacion",
		DATE_FORMAT(pac.PacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPacTiempoModificacion"		
        FROM tblpacpagocomprobante pac
        WHERE PacId = "'.$this->PacId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PacId = $fila['PacId'];
            $this->PagId = $fila['PagId'];
			$this->OvvId = $fila['OvvId'];
			$this->VdiId = $fila['VdiId'];
			
			$this->FacId = $fila['FacId'];
			$this->FtaId = $fila['FtaId'];
			
			$this->BolId = $fila['BolId'];
			$this->BtaId = $fila['BtaId'];
			
			$this->FexId = $fila['FexId'];
			$this->FetId = $fila['FetId'];
			
			$this->PacEstado = $fila['PacEstado']; 
			$this->PacTiempoCreacion = $fila['NPacTiempoCreacion']; 
			$this->PacTiempoModificacion = $fila['NPacTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPago=NULL) {

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
		
		if(!empty($oPago)){
			$ocobro = ' AND pac.PagId = "'.$oPago.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pac.PacId,
				pac.PagId,
				pac.OvvId,
				pac.VdiId,
				
				pac.FacId,
				pac.FtaId,
				
				pac.BolId,
				pac.BtaId,
				
				pac.FexId,
				pac.FetId,
				
				pac.PacEstado,
				DATE_FORMAT(pac.PacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPacTiempoCreacion",
				DATE_FORMAT(pac.PacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPacTiempoModificacion",
				
				
				IFNULL(cli.CliNumeroDocumento,IFNULL(cli2.CliNumeroDocumento,IFNULL(cli3.CliNumeroDocumento,IFNULL(cli4.CliNumeroDocumento,"")))) AS CliNumeroDocumento,
				
				
				IFNULL(cli.CliNombre,IFNULL(cli2.CliNombre,IFNULL(cli3.CliNombre,IFNULL(cli4.CliNombre,"")))) AS CliNombre,
				IFNULL(cli.CliApellidoMaterno,IFNULL(cli2.CliApellidoMaterno,IFNULL(cli3.CliApellidoMaterno,IFNULL(cli4.CliApellidoMaterno,"")))) AS CliApellidoMaterno,
				IFNULL(cli.CliApellidoPaterno,IFNULL(cli2.CliApellidoPaterno,IFNULL(cli3.CliApellidoPaterno,IFNULL(cli4.CliApellidoPaterno,"")))) AS CliApellidoPaterno
					
				FROM tblpacpagocomprobante pac
				
					LEFT JOIN tblfacfactura fac
					ON pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
							
							LEFT JOIN tblbolboleta bol
							ON pac.BolId = bol.BolId AND pac.BtaId = bol.BtaId
								
								LEFT JOIN tblvdiventadirecta vdi
								ON pac.VdiId = vdi.VdiId
									
									LEFT JOIN tblovvordenventavehiculo ovv
									ON pac.OvvId = ovv.OvvId
						
						
				LEFT JOIN tblclicliente cli
				ON fac.CliId = cli.CliId
					
					LEFT JOIN tblclicliente cli2
					ON bol.CliId = cli2.CliId
					
						LEFT JOIN tblclicliente cli3
						ON vdi.CliId = cli3.CliId
							
							LEFT JOIN tblclicliente cli4
							ON ovv.CliId = cli4.CliId

					
				WHERE  1 = 1 '.$filtrar.$ocobro.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPagoComprobante = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$PagoComprobante = new $InsPagoComprobante();
                    $PagoComprobante->PacId = $fila['PacId'];
                    $PagoComprobante->PagId = $fila['PagId'];
					$PagoComprobante->OvvId = $fila['OvvId'];
					$PagoComprobante->VdiId = $fila['VdiId'];
					
					$PagoComprobante->FacId = $fila['FacId'];
					$PagoComprobante->FtaId = $fila['FtaId'];
					
					$PagoComprobante->BolId = $fila['BolId'];
					$PagoComprobante->BtaId = $fila['BtaId'];
					
					$PagoComprobante->FexId = $fila['FexId'];
					$PagoComprobante->FetId = $fila['FetId'];

					$PagoComprobante->PacEstado = $fila['PacEstado'];
					$PagoComprobante->PacTiempoCreacion = $fila['NPacTiempoCreacion'];
					$PagoComprobante->PacTiempoModificacion = $fila['NPacTiempoModificacion'];
					
					
					$PagoComprobante->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					
					$PagoComprobante->CliNombre = $fila['CliNombre'];
					$PagoComprobante->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$PagoComprobante->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					
					

                    $PagoComprobante->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PagoComprobante;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		

	
	//Accion eliminar	 
	
	public function MtdEliminarPagoComprobante($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PacId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PacId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
			
			$sql = 'DELETE FROM tblpacpagocomprobante WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarPagoComprobante() {
	
			$this->MtdGenerarPagoComprobanteId();
			
			$sql = 'INSERT INTO tblpacpagocomprobante (
			PacId,
			PagId,
		  	OvvId,
			VdiId,
			
			FacId,
			FtaId,
			
			BolId,
			BtaId,
			
			FexId,
			FetId,
			
			PacEstado,
			PacTiempoCreacion,
			PacTiempoModificacion
			) 
			VALUES (
			"'.($this->PacId).'",
			"'.($this->PagId).'", 
			
			'.(empty($this->OvvId)?'NULL, ':'"'.$this->OvvId.'",').'
			'.(empty($this->VdiId)?'NULL, ':'"'.$this->VdiId.'",').'
			
			'.(empty($this->FacId)?'NULL, ':'"'.$this->FacId.'",').'
			'.(empty($this->FtaId)?'NULL, ':'"'.$this->FtaId.'",').'
			
			'.(empty($this->BolId)?'NULL, ':'"'.$this->BolId.'",').'
			'.(empty($this->BtaId)?'NULL, ':'"'.$this->BtaId.'",').'
			
			'.(empty($this->FexId)?'NULL, ':'"'.$this->FexId.'",').'
			'.(empty($this->FetId)?'NULL, ':'"'.$this->FetId.'",').'

			'.($this->PacEstado).', 
			"'.($this->PacTiempoCreacion).'", 
			"'.($this->PacTiempoModificacion).'");';					

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
	
	public function MtdEditarPagoComprobante() {
		
			$sql = 'UPDATE tblpacpagocomprobante SET 
			 PagId = "'.($this->PagId).'",

			 '.(empty($this->OvvId)?'OvvId = NULL, ':'OvvId = "'.$this->OvvId.'",').'
			 '.(empty($this->VdiId)?'VdiId = NULL, ':'VdiId = "'.$this->VdiId.'",').'

			 '.(empty($this->FacId)?'FacId = NULL, ':'FacId = "'.$this->FacId.'",').'
			 '.(empty($this->FtaId)?'FtaId = NULL, ':'FtaId = "'.$this->FtaId.'",').'

			 '.(empty($this->BolId)?'BolId = NULL, ':'BolId = "'.$this->BolId.'",').'
			 '.(empty($this->BtaId)?'BtaId = NULL, ':'BtaId = "'.$this->BtaId.'",').'
			 
			  '.(empty($this->FexId)?'FexId = NULL, ':'FexId = "'.$this->FexId.'",').'
			 '.(empty($this->FetId)?'FetId = NULL, ':'FetId = "'.$this->FetId.'",').'

			 PacEstado = '.($this->PacEstado).',
			 PacTiempoCreacion = "'.($this->PacTiempoCreacion).'",
			 PacTiempoModificacion = "'.($this->PacTiempoModificacion).'"
			 
			 WHERE PacId = "'.($this->PacId).'";';
			
		
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