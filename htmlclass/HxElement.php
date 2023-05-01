<?php

class HxElement extends HtmlElement
{

    public string $niveau;

    public function __toString(): string
    {
        return $this->render();
    }

    private function setNiveau(string $valNiveau)
    {
        $this->balise = 'h' . $valNiveau;
        $this->niveau = $valNiveau;
    }

    public function setNiveau1()
    {
        $this->setNiveau('1');
    }

    public function setNiveau2()
    {
        $this->setNiveau('2');
    }

    public function setNiveau3()
    {
        $this->setNiveau('3');
    }

    private function render()
    {
        return $this->afficherElement();
    }
}