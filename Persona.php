<?php
class Persona {
    private $nrodoc;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $mensajeoperacion;
    public function __construct(){
		
		$this->nrodoc = 0;
		$this->nombre = "";
		$this->apellido = "";
		$this->email = "";
	}

	public function cargar($NroD,$Nom,$Ape,$ptelefono){		
		$this->setNrodoc($NroD);
		$this->setPNombre($Nom);
		$this->setPApellido($Ape);
		$this->setPTelefono($ptelefono);
    }

    // Getters y setters
    public function getNrodoc() { 
        return $this->nrodoc; 
    }
    public function getPNombre() { 
        return $this->pnombre; 
    }
    public function getPApellido() { 
        return $this->papellido; 
    }
    public function getPTelefono() { 
        return $this->ptelefono; 
    }
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function setNrodoc($nrodoc) { 
        $this->nrodoc = $nrodoc; 
    }
    public function setPNombre($pnombre) { 
        $this->pnombre = $pnombre; 
    }
    public function setpapellido($papellido) { 
        $this->papellido = $papellido; 
    }
    public function setPTelefono($ptelefono) { 
        $this->ptelefono = $ptelefono; 
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consultaPersona="Select * from persona where nrodoc=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setNrodoc($dni);
					$this->setPNombre($row2['nombre']);
					$this->setPApellido($row2['papellido']);
					$this->setPTelefono($row2['ptelefono']);
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
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from persona ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by papellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arregloPersona= array();
				while($row2=$base->Registro()){
					
					$NroDoc=$row2['nrodoc'];
					$pnombre=$row2['pnombre'];
					$papellido=$row2['papellido'];
					$ptelefono=$row2['ptelefono'];
				
					$perso=new Persona();
					$perso->cargar($NroDoc,$pnombre,$papellido,$ptelefono);
					array_push($arregloPersona,$perso);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPersona;
	}		
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO persona(nrodoc, papellido, pnombre,  ptelefono) 
				VALUES (".$this->getNrodoc().",'".$this->getPApellido()."','".$this->getPNombre()."','".$this->getPTelefono()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
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
		$consultaModifica="UPDATE persona SET papellido='".$this->getPApellido()."',nombre='".$this->getPNombre()."'
                           ,ptelefono='".$this->getPTelefono()."' WHERE nrodoc=". $this->getNrodoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM persona WHERE nrodoc=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
    public function __toString(){
	    return "\nNombre: ".$this->getPNombre(). "\n Apellido:".$this->getPApellido()."\n DNI: ".$this->getNrodoc()."\n";
			
	}
}
