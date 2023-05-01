<?php

/**
 * Classe permettant de générer des éléments HTML de type <div>
 */
class DivElement extends ContainerElement
{
    /**
     * Constante definissant le type de balise générée
     */
    const BALISE = 'div';

    /**
     * Retourne l'element html sous forme "string" via la fonction render()
     * @return string
     */
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
    private function render(): string
    {
        $this->transformeElementsEnContenu();
        return $this->afficherElement();
    }




}