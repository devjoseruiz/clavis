<?php

class Person
{
  // private = can only be used within the owner class
  // protected = can be used by the owner class and its children, but not from outside
  // public = can be used from outside the class, within the owner class and its children

  private $possible_genders = ['m', 'f'];
  private $possible_names_m = ['Anthony', 'Joseph', 'Francis', 'John', 'Emmanuel', 'Peter', 'Jesus', 'Michael', 'Xavier', 'David'];
  private $possible_names_f = ['Mary', 'Josephine', 'Elizabeth', 'Frances', 'Lucy', 'Dolores', 'Anna', 'Martha', 'Carla', 'Pilar'];
  private $possible_surnames = ['Garcia', 'Martinez', 'Gomez', 'Moreno', 'Orozco', 'Aviles', 'Diaz', 'Serrano', 'Ortega', 'Munoz', 'Romero', 'Castillo'];

  public $person;
  public $names;
  public $surnames;
  public $gender;

  public function __construct($name = null)
  {
    echo 'I am the Person constructor....<br>';
    if ($name !== null) {
      echo sprintf('Passing the name %s inside our class constructor...<br>', $name);
    }
  }

  // Method to create a random person
  public function create_person()
  {
    $this->gender = $this->possible_genders[rand(0, 1)];
    $this->names = $this->get_name();
    $this->surnames = $this->get_surname() . ' ' . $this->get_surname();
    $this->person = $this->names . ' ' . $this->surnames;
    return $this->person . '<br>';
  }

  // Method to select a name from the array
  private function get_name()
  {
    if ($this->gender === 'm') {
      return $this->possible_names_m[rand(0, count($this->possible_names_m) - 1)];
    }

    return $this->possible_names_f[rand(0, count($this->possible_names_f) - 1)];
  }

  // Method to select a surname from the array
  private function get_surname()
  {
    return $this->possible_surnames[rand(0, count($this->possible_surnames) - 1)];
  }

  // Static method to create a person
  public static function create()
  {
    $person = new self();
    return $person->create_person();
  }
}