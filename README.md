# Getting Started

![php:8.1](https://img.shields.io/badge/php-%3E%3D8.1-blue "php:8.1")

## But de la mise en oeuvre
🐤Permet de récuperer les données d'un fichier ics (attention toutes les structures de fichiers ics ne sont pas supportées) et de réaliser un affichage des évènements du calendriers au format html.

Cette action est mise en oeuvre grâce a un parser de fichier ics (la structure de fichier fonctionelle actuellement correspond aux calendriers de vacances scolaire disponibles a l'adresse suivante: https://www.data.gouv.fr/fr/datasets/le-calendrier-scolaire/ )


### Configurer le déploiment SSH
Si aucune clée SSH n'est crée sur le système:  
Génerer une paire de clé ssh puis définir la destination du dossier .ssh grâce a la commancde
```shell
ssh-keygen
```

### Etablir la connexion:
ssh [user]@localhost -p [nport hôte]
ex:
```shell
ssh jcm@localhost -p 2222
```

### Lancer Serveur Php depuis la VM/Machine distante:
Depuis le shell de la VM Linux: demarrer le serveur php
```shell
php -S 0.0.0.0:8000
```
Dans un context serveur, 0.0.0.0 signifie: tout les ports Ipv4 de la machine locale

### Deployer les fichiers via SSH:
IDE Intelli J: Cliquer sur "tools" > "deployment" > "configuration" > "+" > "SFTP" puis saisir un nom de domaine (ici localhost)  
Configurer la connexion ssh et le mapping  
Clic droit sur le fichiers a déployer > "deployement" > "upload" ou "upload all"
Acceder via le navigateur au site web via localhost:[portVm] ici monsite.jcm.com:8080.

## Fonctionnement
 Le projet est constitué d'un générateur d'éléments Html et d'un Parser de fichiers .ics

 La mise en forme de la vue utilisateur utilise le générateur d'éléments html afin de présenter les informations extraites du fichier .ics à l'utilisateur.

### Moteur de rendu html



### Auteurs:
![FredM](https://secure.gravatar.com/avatar/155d9315150175b7ab245ad11d4a647b?d=identicon&r=G&s=80, "FredM")