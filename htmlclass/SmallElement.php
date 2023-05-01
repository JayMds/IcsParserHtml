<?php

class SmallElement extends HtmlElement
{
    const BALISE = 'small';
    /**
     * Retourne l'element html sous forme "string" via la fonction render()
     * @return string
     */
    public function __toString():string
    {
        return $this->render();
    }
    /**
     * @return string
     * Fonction de rendu de l'élément appelé par __toString
     * transforme les elements en contenu -> tranforme le tout en string
     * pour son rendu
     */
    public function render():string
    {
        return $this->afficherElement();
    }


}