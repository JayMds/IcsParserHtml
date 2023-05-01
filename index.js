class Page {
    //contient toute les subDiv de la page
    #subDivDatas
    //contient les subDiv filtrées par les fonctions getPageDataSetxxxx()
    #pageDataSet
    #elActiveZone
    //Elements html
    #resetButton
    #filterBeforeDateButton
    #filterAtDateButton
    #filterAfterDateButton

    constructor() {
        this.#getSubDivDatas()
        this.applySeasonLogo()
        this.getPageElementsById()
        this.bindPageEventListners()
        this.displayNoneAfterFadeOut()
        this.setActiveZone()
    }
    setActiveZone(){
        let active = this.#elActiveZone.getAttribute('data-zone')
        console.log(active)
        let activeId = 'lienZone' + active;
        let htmlElement = document.getElementById(activeId)
        console.log(htmlElement)
        htmlElement.classList.add('current')
    }

    displayNoneAfterFadeOut() {
        this.#subDivDatas.forEach(function (currentValue) {
            currentValue.addEventListener('transitionend', () => {
                if (currentValue.classList.contains('hide')) {
                    currentValue.classList.add('absolute')
                }
            })
        })
    }

    getPageElementsById() {
        this.#elActiveZone = document.getElementById('zone')
        this.#resetButton = document.getElementById('resetButton')
        this.#filterBeforeDateButton = document.getElementById('filterBeforeDate')
        this.#filterAtDateButton = document.getElementById('filterAtDate')
        this.#filterAfterDateButton = document.getElementById('filterAfterDate')
    }

    bindPageEventListners() {
        this.#resetButton.addEventListener('click', this.#afficheAllEvents.bind(this))
        this.#filterBeforeDateButton.addEventListener('click', this.#getPageDataSetBeforeDate.bind(this))
        this.#filterAtDateButton.addEventListener('click', this.#getPageDatasetAtDate.bind(this))
        this.#filterAfterDateButton.addEventListener('click', this.#getPageDataSetAfterDate.bind(this))
    }

    applySeasonLogo() {
        this.#subDivDatas.forEach(function (currentValue) {
            let currentDivMonth = currentValue.getAttribute('data-dtstart').substring(3, 5);
            let maSaison = '';

            switch (currentDivMonth) {
                case '12':
                case '01':
                case '02':
                    maSaison = 'winter';
                    break;
                case '03':
                case '04':
                case '05':
                    maSaison = 'spring';
                    break;
                case'06':
                case'07':
                case'08':
                    maSaison = 'summer';
                    break;
                case'09':
                case'10':
                case'11':
                    maSaison = 'autumn';
                    break;
            }
            currentValue.classList.add(maSaison)
        })

    }

    /**
     * Récupère toute les subDiv de la page et les range
     * dans #subDivDatas
     */
    #getSubDivDatas() {
        this.#subDivDatas = document.querySelectorAll('.subDiv')
        //console.log(this.#subDivDatas)
    }

    #getPageDatasetAtDate(){
        let value = document.getElementById('dateFilterInput').value
        this.#cacheAllEvents()
        this.#pageDataSet = [...this.#subDivDatas].filter(p => p.getAttribute('data-dtstart').substring(6) === value.substring(2));
        this.#afficheFilteredEvent()
    }

    /**
     * Filtre les subDivs ou dtStart <= année saisie
     * -> récupère la valeur saisie via getElementById
     */
    #getPageDataSetBeforeDate() {
        let value = document.getElementById('dateFilterInput').value
        //console.log('value', value)
        this.#cacheAllEvents()
        this.#pageDataSet = [...this.#subDivDatas].filter(p => p.getAttribute('data-dtstart').substring(6) <= value.substring(2));
        this.#afficheFilteredEvent()
    }

    /**
     * Filtre les subDivs ou dtStart >= année saisie
     * -> récupère la valeur saisie via getElementById
     */
    #getPageDataSetAfterDate() {
        //récupère la valeur de saisie de l'année
        let value = document.getElementById('dateFilterInput').value
        //cache toute les subDiv
        this.#cacheAllEvents()
        //filtre les subDivs ou dt-start année >= année saisie
        this.#pageDataSet = [...this.#subDivDatas].filter(p => p.getAttribute('data-dtstart').substring(6) >= value.substring(2))
        //affiche les éléments filtrés en retirant .hide
        this.#afficheFilteredEvent()
    }

    /**
     * Affiche TOUTE les subDivs en retirant le classe '.hide'
     */
    #afficheAllEvents() {
        this.#subDivDatas.forEach(function (currentValue) {
            //console.log(currentValue);
            currentValue.classList.remove('absolute', 'hide')
            currentValue.classList.add('show')
        })
    }

    /**
     * Cache TOUTE les divs de la page en appliquant la class '.hide'
     */
    #cacheAllEvents() {
        //let divs = document.querySelectorAll('.subDiv')
        // Cache tous les divs de la page
        this.#subDivDatas.forEach(function (currentValue) {
            //console.log(currentValue);
            currentValue.classList.remove('show')
            currentValue.classList.add('hide')
        })
    }

    /**
     * Affiche les subDivs FILTREE en retirant la classe '.hide'
     */
    #afficheFilteredEvent() {
        this.#pageDataSet.forEach(function (currentValue) {
            //console.log(currentValue);
            currentValue.classList.remove('absolute', 'hide')
            currentValue.classList.add('show')
        })
    }

}

let page = new Page();