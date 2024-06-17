<?php
class ResponsableV extends Persona{
    private $rnumeroempleado;
    private $rnumerolicencia;
    public function __construct() {
        parent::__construct();
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
    }
    public function cargar($NroD,$Nom,$Ape,$ptelefono,$rnumeroempleado=null,$rnumerolicencia=null){
        
        parent::cargar($NroD,$Nom,$Ape,$ptelefono);
        $this->setRnumeroempleado($rnumeroempleado);
        $this->setRnumerolicencia($rnumerolicencia);
    }
    // Getters y setters

    public function getRnumeroempleado() {
        return $this->rnumeroempleado;

    }
    public function getRnumerolicencia() {
        return $this->rnumerolicencia;
    }

    public function setRnumeroempleado($rnumeroempleado) {
        $this->rnumeroempleado = $rnumeroempleado;
    }
    public function setRnumerolicencia($rnumerolicencia) {
        $this->rnumerolicencia = $rnumerolicencia;
    }
    public function Buscar($dni){
		$base=new BaseDatos();
		$consulta = "SELECT * FROM responsableV WHERE nrodoc = " . $dni;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($dni);
				    $this->setRnumeroempleado($row2['rnumeroempleado']);
				    $this->setRnumerolicencia($row2['rnumerolicencia']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    public  function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from responsableV ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by rnumeroempleado";
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ResponsableV();
					$obj->Buscar($row2['nrodoc']);
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}	
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		
		$consultaInsertar = "INSERT INTO responsableV (nrodoc, rnumeroempleado, rnumerolicencia)
							 VALUES ('" . $this->getNrodoc() . "','" . $this->getRnumeroempleado() . "','" . $this->getRnumerolicencia() . "')";
	
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaInsertar)) {
				$resp = true;
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
	
		return $resp;
	}
	
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
	    if(parent::modificar()){
	        $consultaModifica="UPDATE responsableV SET rnumeroempleado='".$this->getRnumeroempleado()."', rnumerolicencia='".$this->getRnumerolicencia()."' WHERE nrodoc=". $this->getNrodoc();
	        if($base->Iniciar()){
	            if($base->Ejecutar($consultaModifica)){
	                $resp=  true;
	            }else{
	                $this->setmensajeoperacion($base->getError());
	                
	            }
	        }else{
	            $this->setmensajeoperacion($base->getError());
	            
	        }
	    }
		
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsableV WHERE nrodoc=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $resp=  true;
				    }
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
    public function __toString(){
        $resp= parent::__toString();
        $resp=$resp."Numero de Empleado: ".$this->getRnumeroempleado()."\n"."Numero de Licencia: ".$this->getRnumerolicencia()."\n";
	    return $resp;
			
	}
}