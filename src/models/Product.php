<?php

class Product {
    private $id;
    private $name;
    private $description;
    private $price;
    private $scale;
    private $imageUrl;

    public function __construct($name, $description, $price, $scale, $imageUrl, $id = null) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->scale = $scale;
        $this->imageUrl = $imageUrl;
        $this->id = $id;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getScale() { return $this->scale; }
    public function getImageUrl() { return $this->imageUrl; }
}