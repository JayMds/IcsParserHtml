<?php
class ContainerElement extends HtmlElement
{
    public array $childElements;

    /**
     * @param string $val
     * @return void
     * Override SetContenu HTMLGenerator == addChild
     */
    public function setContenu(string $val): void
    {
        $this->addChild($val);
    }

    /**
     * @param HtmlElement|string $element
     * @return void
     * Permet d'ajouter un élément de type HtmlElement dans le tableau childElements
     */
    public function addChild(HtmlElement|string $element): void
    {
        $this->childElements[] = $element; //ajoute un index + val.$element
    }

    /**
     * @return void
     * Transforme le tableau "childElements" en string
     * pour en faire le contenu de l'element <container>
     * ex:
     * <container>
     * <element1/>
     * <element../>
     * </container>
     */
    protected function transformeElementsEnContenu(): void
    {
        $varContenu = '';
        foreach ($this->childElements as $element) {
            $varContenu .= $element . PHP_EOL;
        }
        $this->contenu =  $varContenu;
    }



}