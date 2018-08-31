<?php
// 30-08-2018
// alex
// orm.obj.php

class ClassCompleta {
    public $id = -1;
    public $codi = "";
    public $nom = array("", "", "");

    public function __construct() {}
    public function __destruct() {
        $this->id = null;
        $this->nom = null;
        $this->codi = null;      
    }    
    public function agafPerId($num) {}
    public function desar() {}
    public function esborrar() {}
}

class Autora {
    public $id = -1;
    public $nom = "";
    public $codi = "";
    public $cole = 0;
    public $imgR = "";
    public $biog = "";

    public function __construct() {}
    
    public function __destruct() {
        $this->id = null;
        $this->nom = null;
        $this->codi = null;
        $this->cole = null;
        $this->imgR = null;
        $this->biog = null;        
    }

    private function poblar($v_sql) {
        $this->id = $v_sql[0];
        $this->nom = $v_sql[1];
        $this->codi = $v_sql[2];
        $this->cole = $v_sql[5];
        $this->imgR = $v_sql[3];
        $this->biog = $v_sql[4];                
    }
    
    public function agafPerId($num) {
        if (is_numeric($num)) {
            $v = BaseDades::consVector(Consulta::autor_perId(intval($num)));
            if (count($v) > 0) {
                $this->poblar($v[0]);
                return 1;
            }
        }
        return 0;
    }        
    
    public function agafPerCod($codi) {
        $v = BaseDades::consVector(Consulta::autor($codi));
        if (count($v) > 0) {
            $this->poblar($v[0]);
            return 1;
        }
        return 0;
    }
    
    public function desar() {}
    public function esborrar() {}
}

class Idioma {
    public $id = -1;
    public $nom = "";

    public function __construct() {}
    public function __destruct() {
        $this->id = null;
        $this->nom = null;      
    }
    public function agafPerId($num) {}    
    public function desar() {}
    public function esborrar() {}
}

class Propietari {
    public $id = -1;
    public $nom = "";
    public $codi = "";

    public function __construct() {}
    public function __destruct() {
        $this->id = null;
        $this->nom = null;
        $this->codi = null;        
    }
    public function agafPerId($num) {}
    public function desar() {}
    public function esborrar() {}
}

class Llibre {
    public $id = -1;
    public $num = 0;
    public $nom = "";
    public $categ;
    public $autor;
    public $idiom;
    public $propi;
    public $autSe = array();
    public $edito = "";
    public $nisbn = "";
    public $anyPu = 0;
    public $anyEd = 0;
    public $dataC = "";
    public $dataM = "";
    public $llocC = "";
    public $imatg = "";
    public $numpg = 0;
    public $descr = "";

    public function __construct() {
        $this->idiom = new Idioma();
        $this->categ = new ClassCompleta();
        $this->propi = new Propietari();
        $this->autor = new Autora();
    }

    public function __destruct() {
        $this->id = null;
        $this->num = null;
        $this->nom = null;
        $this->edito = null;
        $this->nisbn = null;
        $this->anyPu = null;
        $this->anyEd = null;
        $this->dataC = null;
        $this->dataM = null;
        $this->llocC = null;
        $this->imatg = null;
        $this->numpg = null;
        $this->descr = null;
        $this->categ->__destruct();
        $this->autor->__destruct();
        $this->idiom->__destruct();
        $this->propi->__destruct();
        for ($i = 0; $i < count($this->autSe); $i++) {
            $this->autSe[$i]->__destruct();
        }
    }

    private function poblar($v_sql) {
        $this->categ->id = intval($v_sql[6]);
        $this->categ->nom = array(descodCad($v_sql[0]), descodCad($v_sql[1]), descodCad($v_sql[2]));
        $this->categ->codi = $v_sql[3] . $v_sql[4] . $v_sql[5];
        $this->autor->id = intval($v_sql[10]);
        $this->autor->nom = descodCad($v_sql[11]);
        $this->autor->codi = $v_sql[12];
        $this->autor->cole = intval($v_sql[13]);
        $this->autor->imgR = $v_sql[14];
        $this->autor->biog = descodCad($v_sql[15]);
        $this->idiom->id = $v_sql[17];
        $this->idiom->nom = descodCad($v_sql[18]);
        $this->propi->id = intval($v_sql[26]);
        $this->propi->nom = $v_sql[28];
        $this->propi->codi = $v_sql[27];
        $this->id = intval($v_sql[7]);
        $this->num = $v_sql[29];
        $this->nom = descodCad($v_sql[8]);
        $this->imatg = $v_sql[9];
        $this->nisbn = $v_sql[16];
        $this->edito = descodCad($v_sql[19]);
        $this->anyEd = intval($v_sql[20]);
        $this->anyPu = intval($v_sql[21]);
        $this->dataC = $v_sql[22];
        $this->llocC = descodCad($v_sql[23]);
        $this->descr = descodCad($v_sql[24]);
        $this->dataM = $v_sql[25];
        $this->numpg = $v_sql[30];
    }

    private function poblarAutores($v_sql) {
        for ($i = 0; $i < count($v_sql); $i++) {
            $secund = new Autora();
            $secund->id = intval($v_sql[$i][1]);
            $secund->nom = descodCad($v_sql[$i][2]);
            $secund->codi = $v_sql[$i][3];
            $secund->cole = intval($v_sql[$i][4]);
            $secund->imgR = $v_sql[$i][5];
            $secund->biog = descodCad($v_sql[$i][6]);
            $this->autSe[] = $secund;
        }       
    }
    
    public function agafPerId($num) {
        if (is_numeric($num)) {
            $v = BaseDades::consVector(Consulta::llibre_perId(intval($num)));
            if (count($v) > 0) {
                $this->poblar($v[0]);
                $a = BaseDades::consVector(Consulta::autorsSec($this->id));
                if (count($a) > 0)
                    $this->poblarAutores($a);                    
                return 1;
            }
        }
        return 0;
    }

    public function agafPerEt($pro, $cla, $aut, $num) {
        $v = BaseDades::consVector(Consulta::llibre_perEtiqueta($pro, $cla, $aut, $num));
        if (count($v) > 0) {
            $this->poblar($v[0]);
            $a = BaseDades::consVector(Consulta::autorsSec($this->id));
            if (count($a) > 0)
                $this->poblarAutores($a);
            return 1;
        }
        return 0;     
    }

    public function etiqueta() {
        if ($this->id != -1)
            return $this->propi->codi . "-" . $this->categ->codi . "-" . $this->autor->codi . "-" . sprintf("%03d", $this->num);
        return "";            
    }
    
    public function desar() {}
    public function esborrar() {}
}