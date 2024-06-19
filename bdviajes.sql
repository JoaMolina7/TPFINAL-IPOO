
CREATE TABLE empresa(
    idempresa int AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE persona(
    nrodoc int,
    pnombre varchar(150),
    papellido varchar(150),
    ptelefono int,
    PRIMARY KEY (nrodoc)
);

CREATE TABLE responsableV(
    rnumeroempleado int AUTO_INCREMENT,
    rnumerolicencia int,
	nrodoc int,
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (nrodoc) REFERENCES persona (nrodoc) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje int AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa int,
    rnumeroempleado int,
    vimporte int,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (rnumeroempleado) REFERENCES responsableV (rnumeroempleado)
    /* actualice el responsablev a responsableV para no tener error en la foreign key */
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero(
    nrodoc int,
    pasaporte varchar(15),
	idviaje int,
    PRIMARY KEY (pasaporte),
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje),
    FOREIGN KEY (nrodoc) REFERENCES persona (nrodoc) ON UPDATE CASCADE ON DELETE CASCADE	
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
  
