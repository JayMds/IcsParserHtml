<?php

/**
UID:608@education.gouv.fr
DTSTAMP:20190820T144029Z
DESCRIPTION:Prérentrée des enseignants
DTSTART;VALUE=DATE:20190830
LOCATION:Besançon\, Bordeaux\, Clermont-Ferrand\, Dijon\, Grenoble\, Limog
es\, Lyon\, Poitiers
SUMMARY:Prérentrée des enseignants - Zone A
TRANSP:TRANSPARENT
END:VEVENT
 */
class IcsEventUnit
{
    public string $uid;

    public DateTime $dtStamp;

    public string $description;

    public DateTime $dtStart;

    public DateTime $dtEnd;

    public string $summary;

    public string $transp;

    public string $location; // array '\,'


}