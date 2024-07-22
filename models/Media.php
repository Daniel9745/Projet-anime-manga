<?php

class Media
{
        private ?int $id;

        public function __construct(private string $name, private string $url, private string $alt) {

        }
        
        public function getId(): int
        {
                return $this->id;
        }

        // Setter pour $id
        public function setId(int $id): void
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

        // Getter pour $url
        public function getUrl(): string
        {
                return $this->url;
        }

        // Setter pour $url
        public function setUrl(string $url): void
        {
                $this->url = $url;
        }

        // Getter pour $alt
        public function getAlt(): string
        {
                return $this->alt;
        }

        // Setter pour $alt
        public function setAlt(string $alt): void
        {
                $this->alt = $alt;
        }
}
