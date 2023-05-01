<?php

class IcsCalendarUnit
{
    public string $method;
    public string $prodId;
    public string $version;
    public string $xwrCalName;
    public string $XwrCalDesc;
    public string $XwrTimezone;
    public array $eventArray;

    public function __toString(): string
    {
        return $this->renderCalendarToHtml();
    }

    /**
     * @param string $title
     * @return HtmlElement
     */
    private function createTitle(string $title): HtmlElement
    {
        $calendarTitle = new HxElement();
        $calendarTitle->setNiveau1();
        $calendarTitle->setContenu($title);
        return $calendarTitle;
    }

    /**
     * @param string $subTitle
     * @return HtmlElement
     * Retourne un element H2 avec string $subTitle
     */
    private function createSubTitle(string $subTitle): HtmlElement
    {
        $calendarSubTitle = new HxElement();
        $calendarSubTitle->setNiveau2();
        $calendarSubTitle->setContenu($subTitle);
        return $calendarSubTitle;
    }

    /**
     * @param string $thirdTitle
     * @return HtmlElement
     * Retourne un element h3 Titre de l'evenement
     */
    private function createEventTitle(string $thirdTitle): HtmlElement
    {
        $calendarEvents = new HxElement();
        $calendarEvents->setNiveau3();
        $calendarEvents->setContenu($thirdTitle);
        return $calendarEvents;
    }

    /**
     * @param string $title
     * @param string $subTitle
     * @param string $thirdTitle
     * @return DivElement
     * Retourne un element <div> avec class .divHeader
     * Présente le nom, timeZone du calendrier
     */
    private function createDivHeader(string $title, string $subTitle): DivElement
    {
        $divContainer = new DivElement();
        $divContainer->addChild($title);
        $divContainer->addChild($subTitle);
        $divContainer->addHtmlAttributs("class", "divHeader");
        return $divContainer;
    }

    /**
     * @param $value
     * @return HtmlElement
     * Retourne un element <p> avec class .pFromCalendar
     * Et le texte entré en $value
     */
    private function createSpanElement($value): HtmlElement
    {
        $pElement = new SpanElement();
        $pElement->addHtmlAttributs("class", "spanFromCalendar");
        $pElement->setContenu($value);
        return $pElement;
    }

    private function populateChildContainerWithSubDivElements(HtmlElement $divChildContainer): void
    {
        foreach ($this->eventArray as $event) {
            //Creer un titre h1 avec la description de l'evenement
            $subDivTitle = $this->createTitle($event->description);
            $subDivTitle->addHtmlAttributs("class", "subDivTitle");

            //Creer la subDiv avec le titre h1 et class .subDiv
            $subDiv = new DivElement();
            $subDiv->addHtmlAttributs("class", "subDiv");
            $subDiv->addChild($subDivTitle);

            //Boucle qui parcours les attributs de chaque evenement pour remplir la subDiv
            $this->populateSubDivWithEventDatas($subDiv, $event);

            //Ajoute la subDiv au childContainer (string|HtmlElement)
            $divChildContainer->addChild($subDiv);
        }
    }

    private function populateSubDivWithEventDatas(HtmlElement $subDiv, IcsEventUnit $event): void
    {
        foreach ($event as $key => $value) {
            if ($key !== "description" && $key !== "transp") {
                //Cas des date: formatage pour affichage $value et creation attribut html data-$key = $value
                if ($key === "dtStamp" || $key === "dtStart" || $key === "dtEnd") {
                    $formatedValue = $value->format("d/m/y");
                    $spanCardLabel = $this->createSpanElement(strtoupper($key . " : "));
                    //ajout de la data sous forme attribut html pour le traitement en js
                    $subDiv->addHtmlAttributs("data-" . $key, $formatedValue);
                    $subDiv->addChild($spanCardLabel . $formatedValue . "<br>");

                    //Autre cas: creation attribut html et affiche $value
                } else {
                    $spanCardLabel = $this->createSpanElement(strtoupper($key . " : "));
                    //ajout de la data sous forme attribut html pour le traitement en js
                    $subDiv->addHtmlAttributs("data-" . $key, $value);
                    $subDiv->addChild($spanCardLabel . $value . "<br>");
                }
            }
        }
    }

    private function renderCalendarToHtml(): DivElement
    {
        //Creer un div container
        $divContainer = new DivElement();
        $divContainer->addHtmlAttributs("class", "divContainer active");
        $divContainer->addHtmlAttributs("id", "divContainer");
        $divContainer->addHtmlAttributs("data-zone", "A-B-C-Corse");

        //Creer un div Contenant les subDiv
        $divChildContainer = new DivElement();
        $divChildContainer->addHtmlAttributs("class", "divChildContainer");
        $divChildContainer->addHtmlAttributs("id", "divChildContainer");

        //Creer un div contenant le titre, et sous titre
        $calendarTitle = $this->createTitle($this->xwrCalName);
        $calendarTitle->addHtmlAttributs("class", "calendarTitle");
        $calendarSubTitle = $this->createSubTitle($this->XwrTimezone);
        $calendarSubTitle->addHtmlAttributs("class", "calendarSubTitle");
        $divHeader = $this->createDivHeader($calendarTitle, $calendarSubTitle);

        //Ajoute le header a la div principale
        $divContainer->addChild($divHeader);

        //Boucle qui parcours Chaque Evenement pour creer les subdivs et remplir la divChildContainer
        $this->populateChildContainerWithSubDivElements($divChildContainer);

        //Ajoute childContainer au div container principal
        $divContainer->addChild($divChildContainer);
        return $divContainer;
    }

//todo petit logo/image en fonction contexte description/summary
}