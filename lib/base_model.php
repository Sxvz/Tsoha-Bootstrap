<?php

abstract class BaseModel {

    protected $valitron;
    //Kertoo sivulla kerralla näytettävien entiteetien lukumäärän.
    protected static $entries_per_page = 10;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        $this->setup_valitron();
        $this->add_valitron_rules();
        $this->valitron->validate();

        return $this->valitron->errors();
    }

    abstract protected function setup_valitron();

    abstract protected function add_valitron_rules();
}
