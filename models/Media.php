<?php

class Media {
    private string $name;
    private string $url;

    public function __construct(string $name, string $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}

