<?php

class LinkElement extends HtmlElement
{
    /**
     * Type de balise crée a l'instanciation
     */
    const BALISE = 'a';

    public function __toString(): string
    {
       return $this->render();
    }

    /**
     * @return string
     * Fonction de rendu de l'élément appelé par __toString
     * transforme les elements en contenu -> tranforme le tout en string
     * pour son rendu
     */
    public function render()
    {
        return $this->afficherElement();
    }


}