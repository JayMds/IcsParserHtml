<?php

/**
 * Classe mère des elements html generable
 */
abstract class HtmlElement
{
    /**
     * Constante definissant le type de balise
     */
    const BALISE = '';

    /**
     * @var string contient le type de balise de l'instance
     */
    public string $balise;

    /**
     * @var string contient le texte de la balise
     */
    public string $contenu = "Veuillez saisir un contenu";

    public array $htmlAttributs;

    public string $strHtmlAttr = "";

    /**
     * @param string $strHtmlAttributs
     * Setter HtmlAttributs sous forme string
     */
    private function setStrHtmlAttr(): void
    {
        $this->strHtmlAttr = $this->transformHtmlAttributeToString();
    }



    /**
     * @return void
     * Transforme le tableau d'attribut html en string pour
     * injection dans les balises
     */
    private function transformHtmlAttributeToString()
    {
        $str = "";
        foreach ($this->htmlAttributs as $key => $value) {
            $str .= $key . "=" . '"' . $value . '"' . " ";
        }

        return $str;
    }

    /**
     * le constructeur "injecte" le type de balise instancié
     * correspondant à l'instance crée
     */
    public function __construct()
    {
        $this->balise = static::BALISE;
    }

    /**
     * @return string
     * fonction d'affichage de l'element html
     * injecte le type de balise correspondant et le contenu
     * retourne l'element au format string
     * cette fonction est est appelée par la fonction render() des
     * classe enfants
     */
    public function afficherElement(): string
    {
        return "<$this->balise $this->strHtmlAttr>{$this->contenu}</$this->balise>";
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     * Ajoute un attribut html dans le tableau de l'instance
     */
    public function addHtmlAttributs(string $key, string $value)
    {
        $this->htmlAttributs[$key] = $value;
        $this->setStrHtmlAttr();
    }

    /**
     * @param string $val
     * @return void
     * permet de définir le texte contenu dans l'element html
     * ex: <element> contenu </element>
     */
    public function setContenu(string $val): void
    {
        $this->contenu = $val;
    }


}