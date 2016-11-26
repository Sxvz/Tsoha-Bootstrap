<?php

abstract class BaseModel {

    protected $valitron;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
        $this->valitron = new Valitron\Validator($attributes);
    }

    public function errors() {
        $this->add_valitron_rules();
        $this->valitron->validate();
        
        return $this->valitron->errors();
    }

    abstract protected function add_valitron_rules();
}
