<?php

class PElement extends HtmlElement
{
    public const BALISE = 'p';

    public function __toString():string
    {
        return $this->render();
    }

    public function render(): string
    {
        return $this->afficherElement();
    }
}