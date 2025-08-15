<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProveedor
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProveedor {

    public $PrvId;
	public $TdoId;
	public $PrvTipoDocumentoOtro;
	
	public $PrvNombreCompleto;
    public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;
	public $PrvNumeroDocumento;
	public $PrvDireccion;
	public $PrvDistrito;
	public $PrvProvincia;
	public $PrvDepartamento;
	public $PrvPais;
	
	public $PrvTelefono;
	public $PrvCelular;
	public $PrvEmail;
	public $PrvFechaNacimiento;
	
	public $PrvContactoNombre1;
	public $PrvContactoCelular1;
	public $PrvContactoEmail1;
	
	public $PrvContactoNombre2;
	public $PrvContactoCelular2;
	public $PrvContactoEmail2;
	
	public $PrvContactoNombre3;
	public $PrvContactoCelular3;
	public $PrvContactoEmail3;
	
	public $MonId;
	public $PrvTipoCambio;
	public $PrvTipoCambioFecha;
	public $PrvLineaCredito;
	public $PrvLineaCreditoActual;
	
	public $PrvCalcularCosto;
	public $PrvEstado;	
    public $PrvTiempoCreacion;
    public $PrvTiempoModificacion;
    public $PrvEliminado;

	public $TdoNombre;
	
	public $InsMysql;

	public $ProveedorGenerarCodigo;
	public $Transaccion;
	
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
		
	public function MtdGenerarProveedorId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PrvId,5),unsigned)) AS "MAXIMO"
			FROM tblprvproveedor';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PrvId = "PRV-10000";

			}else{
				$fila['MAXIMO']++;
				$this->PrvId = "PRV-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerProveedor(){

        $sql = 'SELECT 
        prv.PrvId,
		prv.TdoId,
		prv.PrvTipoDocumentoOtro,

		CONCAT(IFNULL(prv.PrvNombre,"")," ",IFNULL(prv.PrvApellidoPaterno,"")," ",IFNULL(prv.PrvApellidoMaterno,"")) AS PrvNombreCompleto,

		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		prv.PrvNumeroDocumento,		
		prv.PrvDireccion,
		prv.PrvDistrito,
		prv.PrvProvincia,
		prv.PrvDepartamento,
		prv.PrvPais,
		
		prv.PrvTelefono,
		prv.PrvCelular,
		prv.PrvEmail,
		
		DATE_FORMAT(prv.PrvFechaNacimiento, "%d/%m/%Y") AS "NPrvFechaNacimiento",
		prv.PrvContactoNombre1,
		prv.PrvContactoCelular1,
		prv.PrvContactoEmail1,
		prv.PrvContactoNombre2,
		prv.PrvContactoCelular2,
		prv.PrvContactoEmail2,
		prv.PrvContactoNombre3,
		prv.PrvContactoCelular3,
		prv.PrvContactoEmail3,
		
		prv.MonId,
		prv.PrvTipoCambio,
		prv.PrvTipoCambioFecha,
		prv.PrvLineaCredito,
		prv.PrvLineaCreditoActual,
		prv.PrvLineaCreditoActiva,
		
		
		prv.PrvCalcularCosto,
		prv.PrvEstado,	
		DATE_FORMAT(prv.PrvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPrvTiempoCreacion",
        DATE_FORMAT(prv.PrvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPrvTiempoModificacion",
		
		tdo.TdoNombre
		
        FROM tblprvproveedor prv
			LEFT JOIN tbltdotipodocumento tdo
			ON prv.TdoId = tdo.TdoId
			
        WHERE prv.PrvId = "'.$this->PrvId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PrvId = $fila['PrvId'];
			$this->TdoId = $fila['TdoId'];
			$this->PrvTipoDocumentoOtro = $fila['PrvTipoDocumentoOtro'];
            $this->PrvNombreCompleto = $fila['PrvNombreCompleto'];
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->PrvDireccion = $fila['PrvDireccion'];
			$this->PrvDistrito = $fila['PrvDistrito'];
			$this->PrvProvincia = $fila['PrvProvincia'];
			$this->PrvDepartamento = $fila['PrvDepartamento'];
			$this->PrvPais = $fila['PrvPais'];
			
			$this->PrvTelefono = $fila['PrvTelefono'];
			$this->PrvCelular = $fila['PrvCelular'];
			$this->PrvEmail = $fila['PrvEmail'];
			$this->PrvFechaNacimiento = $fila['NPrvFechaNacimiento'];

			$this->PrvContactoNombre1 = $fila['PrvContactoNombre1'];
			$this->PrvContactoCelular1 = $fila['PrvContactoCelular1'];
			$this->PrvContactoEmail1 = $fila['PrvContactoEmail1'];
			
			$this->PrvContactoNombre2 = $fila['PrvContactoNombre2'];
			$this->PrvContactoCelular2 = $fila['PrvContactoCelular2'];
			$this->PrvContactoEmail2 = $fila['PrvContactoEmail2'];
			
			$this->PrvContactoNombre3 = $fila['PrvContactoNombre3'];
			$this->PrvContactoCelular3 = $fila['PrvContactoCelular3'];
			$this->PrvContactoEmail3 = $fila['PrvContactoEmail3'];

			$this->MonId = $fila['MonId'];
			$this->PrvTipoCambio = $fila['PrvTipoCambio'];
			$this->PrvTipoCambioFecha = $fila['PrvTipoCambioFecha'];
			$this->PrvLineaCredito = $fila['PrvLineaCredito'];
			$this->PrvLineaCreditoActual = $fila['PrvLineaCreditoActual'];
			$this->PrvLineaCreditoActiva = $fila['PrvLineaCreditoActiva'];
			
			$this->PrvCalcularCosto = $fila['PrvCalcularCosto'];
			$this->PrvEstado = $fila['PrvEstado'];
			$this->PrvTiempoCreacion = $fila['NPrvTiempoCreacion'];
			$this->PrvTiempoModificacion = $fila['NPrvTiempoModificacion'];
			
			$this->TdoNombre = $fila['TdoNombre'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) {

		// Initialize variables with default values to avoid undefined variable warnings
		$filtrar = '';
		$estado = '';
		$uso = '';
		$orden = '';
		$paginacion = '';

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
//		if(!empty($oCampo) && !empty($oFiltro)){
//			$oFiltro = str_replace(" ","%",$oFiltro);
//			switch($oCondicion){
//				case "esigual":
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
//				break;
//
//				case "noesigual":
//					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
//				break;
//				
//				case "comienza":
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//				break;
//				
//				case "termina":
//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
//				break;
//				
//				case "contiene":
//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
//				break;
//				
//				case "nocontiene":
//					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
//				break;
//				
//				default:
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//				break;
//				
//			}
//			
//			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND prv.PrvEstado = '.$oEstado;
		}	
		
		if(!empty($oUso)){
			$uso = ' AND prv.PrvUso = "'.$oUso.'"';
		}	
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				prv.PrvId,
				prv.TdoId,
				prv.PrvTipoDocumentoOtro,
				
				CONCAT(IFNULL(prv.PrvNombre,"")," ",IFNULL(prv.PrvApellidoPaterno,"")," ",IFNULL(prv.PrvApellidoMaterno,"")) AS PrvNombreCompleto,
			
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.PrvDireccion,
				prv.PrvDistrito,
				prv.PrvProvincia,
				prv.PrvDepartamento,
				
				prv.PrvPais,
				
				prv.PrvTelefono,
				prv.PrvCelular,
				prv.PrvEmail,
				
				DATE_FORMAT(prv.PrvFechaNacimiento, "%d/%m/%Y") AS "NPrvFechaNacimiento",
				prv.PrvContactoNombre1,
				prv.PrvContactoCelular1,
				prv.PrvContactoEmail1,
				prv.PrvContactoNombre2,
				prv.PrvContactoCelular2,
				prv.PrvContactoEmail2,
				prv.PrvContactoNombre3,
				prv.PrvContactoCelular3,
				prv.PrvContactoEmail3,
				
				prv.MonId,
				prv.PrvTipoCambio,
				prv.PrvTipoCambioFecha,
				prv.PrvLineaCredito,
				prv.PrvLineaCreditoActual,
				
				prv.PrvCalcularCosto,
				prv.PrvEstado,
				DATE_FORMAT(prv.PrvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPrvTiempoCreacion",
                DATE_FORMAT(prv.PrvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPrvTiempoModificacion",
				tdo.TdoNombre				
				FROM tblprvproveedor prv	
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
				WHERE 1 = 1 '.$filtrar.$estado.$uso.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProveedor = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Proveedor = new $InsProveedor();				
					
                    $Proveedor->PrvId = $fila['PrvId'];
					$Proveedor->TdoId = $fila['TdoId'];
					$Proveedor->PrvTipoDocumentoOtro = $fila['PrvTipoDocumentoOtro'];
					
					
					$Proveedor->PrvNombreCompleto = $fila['PrvNombreCompleto'];
					$Proveedor->PrvNombre = $fila['PrvNombre'];
					$Proveedor->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$Proveedor->PrvApellidoMaterno= $fila['PrvApellidoMaterno'];
					
					$Proveedor->PrvNumeroDocumento= $fila['PrvNumeroDocumento'];
					$Proveedor->PrvDireccion = $fila['PrvDireccion'];
					$Proveedor->PrvDistrito = $fila['PrvDistrito'];
					$Proveedor->PrvProvincia = $fila['PrvProvincia'];
					$Proveedor->PrvDepartamento = $fila['PrvDepartamento'];
					$Proveedor->PrvPais = $fila['PrvPais'];
					
					$Proveedor->PrvTelefono = $fila['PrvTelefono'];
					$Proveedor->PrvCelular = $fila['PrvCelular'];
					$Proveedor->PrvEmail = $fila['PrvEmail'];

					$Proveedor->PrvFechaNacimiento = $fila['NPrvFechaNacimiento'];

					$Proveedor->PrvContactoNombre1 = $fila['PrvContactoNombre1'];
					$Proveedor->PrvContactoCelular1 = $fila['PrvContactoCelular1'];
					$Proveedor->PrvContactoEmail1 = $fila['PrvContactoEmail1'];
					
					$Proveedor->PrvContactoNombre2 = $fila['PrvContactoNombre2'];
					$Proveedor->PrvContactoCelular2 = $fila['PrvContactoCelular2'];
					$Proveedor->PrvContactoEmail2 = $fila['PrvContactoEmail2'];
					
					$Proveedor->PrvContactoNombre3 = $fila['PrvContactoNombre3'];
					$Proveedor->PrvContactoCelular3 = $fila['PrvContactoCelular3'];
					$Proveedor->PrvContactoEmail3 = $fila['PrvContactoEmail3'];

					$Proveedor->MonId = $fila['MonId'];					
					$Proveedor->PrvTipoCambio = $fila['PrvTipoCambio'];					
					$Proveedor->PrvTipoCambioFecha = $fila['PrvTipoCambioFecha'];					
					$Proveedor->PrvLineaCredito = $fila['PrvLineaCredito'];					
					$Proveedor->PrvLineaCreditoActual = $fila['PrvLineaCreditoActual'];					
					
					
					
					$Proveedor->PrvCalcularCosto = $fila['PrvCalcularCosto'];
					$Proveedor->PrvEstado = $fila['PrvEstado'];					
                    $Proveedor->PrvTiempoCreacion = $fila['NPrvTiempoCreacion'];
                    $Proveedor->PrvTiempoModificacion = $fila['NPrvTiempoModificacion'];    

					 $Proveedor->TdoNombre = $fila['TdoNombre'];    
					 
                    $Proveedor->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Proveedor;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarProveedor($oElementos) {
		
		$elementos = explode("#",$oElementos);
		$eliminar = ''; // Initialize variable to avoid undefined variable warning
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PrvId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PrvId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblprvproveedor WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarProveedor() {
	

		global $Resultado;
		$error = false;
		
		$this->MtdVerificarExisteProveedor();
		
		//if(!empty($this->CliId)){
//			$error = true;
//			$Resultado.='#ERR_PRV_201';
//		}
			
			
			$this->MtdGenerarProveedorId();
		
			$sql = 'INSERT INTO tblprvproveedor (
			PrvId,
			TdoId,
			PrvTipoDocumentoOtro,
			PrvNombreCompleto,
			PrvNombre,
			PrvApellidoPaterno,
			PrvApellidoMaterno,
			
			PrvNumeroDocumento,
			PrvDireccion,
			PrvDistrito,
			PrvProvincia,
			PrvDepartamento,
			
			PrvPais,
			
			PrvTelefono,
			PrvCelular,
			PrvEmail,
			
			PrvFechaNacimiento,
			PrvContactoNombre1,
			PrvContactoCelular1,
			PrvContactoEmail1,
			PrvContactoNombre2,
			PrvContactoCelular2,
			PrvContactoEmail2,
			PrvContactoNombre3,
			PrvContactoCelular3,
			PrvContactoEmail3,
			
			MonId,
			PrvTipoCambio,
			PrvTipoCambioFecha,
			PrvLineaCredito,
			PrvLineaCreditoActual,
			
			PrvCalcularCosto,
			PrvEstado,
			PrvTiempoCreacion,
			PrvTiempoModificacion
			) 
			VALUES (
			"'.($this->PrvId).'",
			"'.($this->TdoId).'",
			"'.($this->PrvTipoDocumentoOtro).'",
			"'.($this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno).'",
			"'.($this->PrvNombre).'",
			"'.($this->PrvApellidoPaterno).'",
			"'.($this->PrvApellidoMaterno).'",
			"'.($this->PrvNumeroDocumento).'",
			
			"'.($this->PrvDireccion).'",
			"'.($this->PrvDistrito).'",
			"'.($this->PrvProvincia).'",
			"'.($this->PrvDepartamento).'",
			"'.($this->PrvPais).'", 	
			
			"'.($this->PrvTelefono).'", 
			"'.($this->PrvCelular).'", 
			"'.($this->PrvEmail).'", 
			
			'.(empty($this->PrvFechaNacimiento)?'NULL, ':'"'.$this->PrvFechaNacimiento.'",').'
			"'.($this->PrvContactoNombre1).'", 
			"'.($this->PrvContactoCelular1).'", 
			"'.($this->PrvContactoEmail1).'", 
			
			"'.($this->PrvContactoNombre2).'", 
			"'.($this->PrvContactoCelular2).'", 
			"'.($this->PrvContactoEmail2).'", 

			"'.($this->PrvContactoNombre3).'", 
			"'.($this->PrvContactoCelular3).'", 
			"'.($this->PrvContactoEmail3).'", 
			
			'.(empty($this->MonId)?'NULL, ':'"'.$this->MonId.'",').'
			'.(empty($this->PrvTipoCambio)?'NULL, ':'"'.$this->PrvTipoCambio.'",').'
			'.(empty($this->PrvTipoCambioFecha)?'NULL, ':'"'.$this->PrvTipoCambioFecha.'",').'
			'.(empty($this->PrvLineaCredito)?'NULL, ':'"'.$this->PrvLineaCredito.'",').'
			'.(empty($this->PrvLineaCreditoActual)?'NULL, ':'"'.$this->PrvLineaCreditoActual.'",').'
	
			1,
			'.($this->PrvEstado).', 
			"'.($this->PrvTiempoCreacion).'", 
			"'.($this->PrvTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarProveedor() {
		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
	
			$sql = 'UPDATE tblprvproveedor SET 
			TdoId = "'.($this->TdoId).'",
			PrvTipoDocumentoOtro = "'.($this->PrvTipoDocumentoOtro).'",
			PrvNombreCompleto = "'.($this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno).'",
			PrvNombre = "'.($this->PrvNombre).'",
			PrvApellidoPaterno = "'.($this->PrvApellidoPaterno).'",
			PrvApellidoMaterno = "'.($this->PrvApellidoMaterno).'",
			PrvNumeroDocumento = "'.($this->PrvNumeroDocumento).'",
			PrvDireccion = "'.($this->PrvDireccion).'",
			
			PrvDistrito = "'.($this->PrvDistrito).'",
			PrvProvincia = "'.($this->PrvProvincia).'",
			PrvDepartamento = "'.($this->PrvDepartamento).'",
			PrvPais = "'.($this->PrvPais).'",
			
			PrvTelefono = "'.($this->PrvTelefono).'",
			PrvCelular = "'.($this->PrvCelular).'",
			PrvEmail = "'.($this->PrvEmail).'",
			'.(empty($this->PrvFechaNacimiento)?'PrvFechaNacimiento = NULL, ':'PrvFechaNacimiento = "'.$this->PrvFechaNacimiento.'",').'
			PrvContactoNombre1 = "'.($this->PrvContactoNombre1).'",
			PrvContactoCelular1 = "'.($this->PrvContactoCelular1).'",
			PrvContactoEmail1 = "'.($this->PrvContactoEmail1).'",
			PrvContactoNombre2 = "'.($this->PrvContactoNombre2).'",
			PrvContactoCelular2 = "'.($this->PrvContactoCelular2).'",
			PrvContactoEmail2 = "'.($this->PrvContactoEmail2).'",
			PrvContactoNombre3 = "'.($this->PrvContactoNombre3).'",
			PrvContactoCelular3 = "'.($this->PrvContactoCelular3).'",
			PrvContactoEmail3 = "'.($this->PrvContactoEmail3).'",
		
			PrvEstado = '.($this->PrvEstado).',
			PrvTiempoModificacion = "'.($this->PrvTiempoModificacion).'"
			WHERE PrvId = "'.($this->PrvId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {
//				if($this->Transaccion){
//					$this->InsMysql->MtdTransaccionDeshacer();
//				}
				return false;
			} else {				
//				if($this->Transaccion){
//					$this->InsMysql->MtdTransaccionHacer();
//				}
				return true;
			}					
		}	
		
		
		/*
		public function MtdRegistrarProveedorOrdenCompra() {
	

			$this->MtdGenerarProveedorId();
		
			$sql = 'INSERT INTO tblprvproveedor (
			PrvId,
			TdoId,

			PrvNombreCompleto,
			PrvNombre,
			PrvApellidoPaterno,
			PrvApellidoMaterno,
			
			PrvNumeroDocumento,
			
			MonId,
			PrvTipoCambio,
			PrvTipoCambioFecha,
			PrvLineaCredito,
			PrvLineaCreditoActual,
			
			PrvEstado,
			PrvTiempoCreacion,
			PrvTiempoModificacion
			) 
			VALUES (
			"'.($this->PrvId).'", 
			"'.($this->TdoId).'", 
			
			"'.($this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno).'", 
			"'.($this->PrvNombre).'", 
			"'.($this->PrvApellidoPaterno).'", 
			"'.($this->PrvApellidoMaterno).'", 
			
			"'.($this->PrvNumeroDocumento).'", 	
			
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			
			1, 
			"'.($this->PrvTiempoCreacion).'", 			
			"'.($this->PrvTiempoModificacion).'");';

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
			
	}	*/
	
	
	/*
	
		public function MtdRegistrarProveedor2() {
	

			$this->MtdGenerarProveedorId();
		
			$sql = 'INSERT INTO tblprvproveedor (
			PrvId,
			TdoId,
			
			PrvNombreCompleto,
			PrvNombre,
			PrvApellidoPaterno,
			PrvApellidoMaterno,
			
			PrvNumeroDocumento,
			
			MonId,
			PrvTipoCambio,
			PrvTipoCambioFecha,
			PrvLineaCredito,
			PrvLineaCreditoActual,
					
			PrvEstado,
			PrvTiempoCreacion,
			PrvTiempoModificacion
			) 
			VALUES (
			"'.($this->PrvId).'", 
			"'.($this->TdoId).'", 
			
			"'.($this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno).'", 
			"'.($this->PrvNombre).'", 
			"'.($this->PrvApellidoPaterno).'", 
			"'.($this->PrvApellidoMaterno).'", 
			
			"'.($this->PrvNumeroDocumento).'", 	
			
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			
			'.($this->PrvEstado).', 
			"'.($this->PrvTiempoCreacion).'", 
			
			"'.($this->PrvTiempoModificacion).'");';

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
		public function MtdEditarProveedor2() {
		

	
			$sql = 'UPDATE tblprvproveedor SET 
			PrvNombreCompleto = "'.($this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno).'",
			PrvNombre = "'.($this->PrvNombre).'",
			PrvApellidoPaterno = "'.($this->PrvApellidoPaterno).'",
			PrvApellidoMaterno = "'.($this->PrvApellidoMaterno).'",
			PrvNumeroDocumento = "'.($this->PrvNumeroDocumento).'",
			PrvTiempoModificacion = "'.($this->PrvTiempoModificacion).'"
			WHERE PrvId = "'.($this->PrvId).'";';
			
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
				
		}	*/	
		
	public function MtdVerificarExisteProveedor(){

        $sql = 'SELECT 
        PrvId
        FROM tblprvproveedor
        WHERE PrvNombreCompleto = "'.$this->PrvNombre.'" AND (PrvNumeroDocumento="'.$this->PrvNumeroDocumento.'" ) ;';
				
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->PrvId = $fila['PrvId'];
			if(!empty($this->PrvId )){
            	$this->MtdObtenerProveedor();				
			}

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }





		
		public function MtdEditarProveedorDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblprvproveedor SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			PrvTiempoModificacion = NOW()
			WHERE PrvId = "'.($oId).'";';
			
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


		
	
		public function MtdActualizarProveedorLineaCreditoActual() {
		
			$sql = 'UPDATE tblprvproveedor SET 
			PrvLineaCredito = '.($this->PrvLineaCredito).',
			PrvLineaCreditoActual = '.($this->PrvLineaCreditoActual).',
			
			'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
			'.(empty($this->PrvTipoCambio)?'PrvTipoCambio = NULL, ':'PrvTipoCambio = "'.$this->PrvTipoCambio.'",').'

			PrvTiempoModificacion = "'.($this->PrvTiempoModificacion).'"
			WHERE PrvId = "'.($this->PrvId).'";';
			
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