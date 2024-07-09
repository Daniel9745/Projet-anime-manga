<?php

class Studio {

    private ?int $id;
    private string $name;

    public function __construct(string $name)
    {
        
    }

    // Getter pour $id
    public function getId(): ?int
    {
        return $this->id;
    }

    // Setter pour $id
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    // Getter pour $name
    public function getName(): string
    {
        return $this->name;
    }

    // Setter pour $name
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}