<?php

class FileReader
{
    const ALLOWED_ZONE = ['A', 'B', 'C', 'A-B-C-Corse'];

    public IcsCalendarUnit $calendar;
    private IcsEventUnit $event;
    private array $icsCalendarText;
    private bool $isCalendar = false;
    private bool $isEvent = false;
    private int $eventCounter = 0;

    private function getIcsFileFromUrl($url): void
    {
        try {
            //Initialise session cUrl
            $cUrl = curl_init($url);

            //Dossier de destination + nom de fichier
            $dir = 'icsfiles/';
            $fileName = basename($url);
            $saveFileLocation = $dir . $fileName;

            //Ouvre le fichier
            $fp = fopen($saveFileLocation, 'w');

            //Option cUrl
            curl_setopt($cUrl, CURLOPT_FILE, $fp);
            curl_setopt($cUrl, CURLOPT_HEADER, 0);

            //Execute la session cURL
            curl_exec($cUrl);
            //Ferme la session cUrl
            curl_close($cUrl);
            echo "Fichier:". $fileName . "téléchargé avec succes <br>";
            fclose($fp);
        } catch (Exception $e) {
            echo $e . " Erreur de chargement du fichier <br>";

        }
    }

    public function updateAllCalendars(): void
    {
        $this->getIcsFileFromUrl("https://fr.ftp.opendatasoft.com/openscol/fr-en-calendrier-scolaire/Zone-A.ics");
        $this->getIcsFileFromUrl("https://fr.ftp.opendatasoft.com/openscol/fr-en-calendrier-scolaire/Zone-B.ics");
        $this->getIcsFileFromUrl("https://fr.ftp.opendatasoft.com/openscol/fr-en-calendrier-scolaire/Zone-C.ics");
        $this->getIcsFileFromUrl("https://fr.ftp.opendatasoft.com/openscol/fr-en-calendrier-scolaire/Zone-A-B-C-Corse.ics");
    }

    public function setIcsCalendarText($fileToLoad): void
    {
        $this->icsCalendarText = file($fileToLoad, FILE_IGNORE_NEW_LINES);
    }

    /**
     * @throws Exception
     */
    public function parseIcs(): ?IcsCalendarUnit
    {
        foreach ($this->icsCalendarText as $index => $ligneIcs) {

            $this->evalCalendar($ligneIcs);
            $this->evalEvent($ligneIcs);

            if ($this->isCalendar) {
                $explodedLine = explode(':', $ligneIcs, PHP_INT_MAX);

                if ($this->isEvent) {
                    $this->checkEventStandardKeyValue($explodedLine);
                } else {
                    $this->checkCalendarStandardKeyValue($explodedLine);
                }

            } else {
                throw new Exception("Le fichier chargé n'est pas un calendrier ou n'est pas au bon format! ");
            }
        }
        return $this->calendar;
    }

    private function setIsCalendar($value): void
    {
        $this->isCalendar = $value;
    }

    private function setIsEvent($value): void
    {
        $this->isEvent = $value;
    }

    private function evalCalendar($ligneIcs): void
    {
        if ($ligneIcs === "BEGIN:VCALENDAR") {
            $this->setIsCalendar(true);
            $this->calendar = new IcsCalendarUnit();
        }

    }

    private function evalEvent($ligneIcs): void
    {
        if ($ligneIcs === "BEGIN:VEVENT") {
            $this->setIsEvent(true);
            $this->event = new IcsEventUnit();
            if ($this->isEvent) {
                $this->eventCounter++;
            }
        }
        if ($ligneIcs === "END:VEVENT") {
            $this->calendar->eventArray[] = $this->event;
        }

    }

    private function validateCalendarKeywordName($sourceKeyword, $sourceValue): void
    {
        $keyWords = ["METHOD", "PRODID", "VERSION", "X-WR-CALNAME", "X-WR-CALDESC", "X-WR-TIMEZONE"];
        if (in_array($sourceKeyword, $keyWords)) {
            $this->calendarParser($sourceKeyword, $sourceValue);
        }
    }

    private function validateEventKeywordName($sourceKeyword, $sourceValue): void
    {
        $keyWords = ["UID", "DTSTAMP", "DESCRIPTION", "DTSTART;VALUE=DATE", "DTEND;VALUE=DATE", "SUMMARY", "TRANSP"];
        if (in_array($sourceKeyword, $keyWords)) {
            $this->eventParser($sourceKeyword, $sourceValue);
        }
    }

    private function checkCalendarStandardKeyValue($explodedLine): void
    {
        if (count($explodedLine) == 2) {

            [$sourceKeyword, $sourceValue] = $explodedLine;

            $this->validateCalendarKeywordName($sourceKeyword, $sourceValue);

        }
    }

    private function checkEventStandardKeyValue($explodedLine): void
    {
        if (count($explodedLine) == 2) {
            [$sourceKeyword, $sourceValue] = $explodedLine;
            $this->validateEventKeywordName($sourceKeyword, $sourceValue);
        } else {
            // todo: gerer le cas "LOCATION" sur 2 liges dans le fichier ICS??
        }
    }

    public function dateParser(string $value): DateTime
    {
        $date = new DateTime();
        $year = substr($value, 0, 4);
        $month = substr($value, 4, 2);
        $day = substr($value, 6, 2);

        $date->setDate((int)$year, (int)$month, (int)$day);
        $date->setTime(00, 00, 00);
        return $date;
    }

    public function dateTimeParser(string $value): DateTime
    {
        $date = new DateTime();
        $year = substr($value, 0, 4);
        $month = substr($value, 4, 2);
        $day = substr($value, 6, 2);
        $hours = substr($value, 9, 2);
        $minutes = substr($value, 11, 2);
        $seconds = substr($value, 13, 2);

        $date->setDate((int)$year, (int)$month, (int)$day);
        $date->setTime((int)$hours, (int)$minutes, (int)$seconds);

        return $date;
    }

    private function calendarParser($sourceKeyword, $sourceValue): void
    {
        switch ($sourceKeyword) {
            case "METHOD":
                $this->calendar->method = $sourceValue;
                break;
            case "PRODID":
                $this->calendar->prodId = $sourceValue;
                break;
            case "VERSION":
                $this->calendar->version = $sourceValue;
                break;
            case "X-WR-CALNAME":
                $this->calendar->xwrCalName = $sourceValue;
                break;
            case "X-WR-CALDESC":
                $this->calendar->XwrCalDesc = $sourceValue;
                break;
            case "X-WR-TIMEZONE":
                $this->calendar->XwrTimezone = $sourceValue;
                break;
        }
    }

    private function eventParser($sourceKeyword, $sourceValue): void
    {
        switch ($sourceKeyword) {
            case "UID":
                $this->event->uid = $sourceValue;

                break;
            case "DTSTAMP":
                $this->event->dtStamp = $this->dateTimeParser($sourceValue);

                break;
            case "DTSTART;VALUE=DATE":
                $this->event->dtStart = $this->dateParser($sourceValue);

                break;
            case "DTEND;VALUE=DATE":
                $this->event->dtEnd = $this->dateParser($sourceValue);

                break;
            case "SUMMARY":
                $this->event->summary = $sourceValue;

                break;
            case "TRANSP":
                $this->event->transp = $sourceValue;

                break;
            case "DESCRIPTION":
                $this->event->description = $sourceValue;
                break;
        }
    }

    public function exportCalendarToJson(): bool|string
    {
        return json_encode($this->calendar, JSON_PRETTY_PRINT);
    }


}