<?php

class Player{
    public $name;
    public $cclass;
    public $level;
    public $renown;
    
    function __construct($name, $level, $class, $renown){
        $this->name = $name;
        $this->level = $level;
        $this->cclass = $class;
        $this->renown = $renown;
        
    }
    
    
    
    
}

?>