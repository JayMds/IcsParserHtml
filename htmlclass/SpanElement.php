<?php

class SpanElement extends HtmlElement
{
    public const BALISE = 'span';

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        return $this->afficherElement();
    }
}