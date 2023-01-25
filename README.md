# Questionnaire de satisfaction client

Ce qestionnaire de satisfaction a été entièrement réalisé par Johan Goutorbe pour la société Office Center le 25/01/2023.

## Table des Matières

1. [Introduction](#Introduction)
2. [Fonctionnement](#Fonctionnement)
3. [Prérequis](#Prérequis)
4. [Téléchargement](#Téléchargement)
5. [Installation](#Installation)
6. [Utilisation](#Utilisation)
7. [Note](#Note)
8. [Conclusion](#Conclusion)
9. [Remerciement](#Remerciement)
***
## Introduction

Ce projet est un questionnaire de satisfaction client créé en PHP pour enregistrer les informations d'une intervention. Les informations sont récupérées via une méthode GET d'une URL, puis vérifiées pour leur validité avant d'être enregistrées dans une base de données MySQL.
***
## Fonctionnement

Cette page PHP utilise la méthode GET pour récupérer les paramètres d'une URL, qui sont ensuite vérifiés pour leur validité. Ces paramètres comprennent un numéro d'intervention, le nom d'un technicien, une date, un choix de notation et une adresse e-mail. Si tous les paramètres sont valides, une requête est effectuée pour enregistrer les informations dans une base de données MySQL. Sinon, des messages d'erreur sont affichés pour indiquer les paramètres incorrects. La page utilise également la classe PDO pour se connecter à la base de données.
***
## Prérequis

Les prérequis pour exécuter ce code incluent :
* Un serveur web (comme Apache ou Nginx) avec PHP installé.
* Accès à une base de données MySQL avec les informations de connexion correctes (nom d'utilisateur, mot de passe, nom de serveur, nom de base de données) défini dans les constantes USER, PASSWD, SERVER et BASE.
* Les extensions PHP PDO et pdo_mysql activées.
* Une table "client_satisfaction" existante dans la base de données avec des champs appropriés pour enregistrer les informations des paramètres de l'URL.

Il est également préférable de s'assurer que les informations d'erreur sont masquées pour la production, pour éviter de montrer des informations sensibles aux utilisateurs.
***
## Téléchargement

Pour télécharger ce projet, vous avez deux options:

1. Télécharger la dernière version en cliquant sur le bouton "Télécharger" sur la page GitHub du projet.
2. Utiliser Git pour cloner le dépôt en utilisant la commande suivante :
```
$ git clone https://github.com/JohanGoutorbe/satisfatction-surveyV2.git
```
***
## Installation

1. Téléchargez ou clonez ce dépôt sur votre serveur web.
2. Assurez-vous que les informations de connexion à la base de données sont correctes dans le fichier index.php.
3. Créez la table "client_satisfaction" dans votre base de données en utilisant le code SQL suivant :

```
CREATE TABLE client_satisfaction (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    inter INT(10) UNSIGNED NOT NULL,
    tech VARCHAR(50) NOT NULL,
    choice TINYINT UNSIGNED NOT NULL,
    survey_date VARCHAR(10) NOT NULL,
    inter_date VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL
)
```
> Il est important de noter qu'il est préférable de faire une sauvegarde de votre base de données avant toutes modifications, et de vérifier que la syntaxe SQL est correcte avant de l'exécuter, et de vérifier tous les prérequis  et étape mentionnés ci-dessus pour un bon fonctionnement de votre projet.

4. Utilisez une URL de type http://localhost/satisfaction-surveyV2/index.php?inter=564782&tech=goutorbe&date=23/01/2023&choix=5&mail=paul@officecenter.fr pour accéder à la page de questionnaire.
***
## Utilisation

1. Entrez les informations de l'intervention via les paramètres de l'URL.
2. Sélectionnez une note de satisfaction de 1 à 5.
3. Entrez votre adresse email.
4. Soumettez le formulaire pour enregistrer les informations dans la base de données.
***
## Note

Assurez-vous de masquer les informations d'erreur pour la production pour éviter de montrer des informations sensibles aux utilisateurs.
***
## Conclusion

Ce README.md fournit une vue d'ensemble complète des prérequis, de l'installation, de l'utilisation, des remerciements et de la méthode de téléchargement pour ce projet de questionnaire de satisfaction client. Il est important de vérifier que toutes les informations sont à jour et de conserver une logique de présentation pour faciliter la compréhension pour les utilisateurs.
***
## Remerciement

J'aimerais remercier tous ceux qui téléchargent et utilisent ce code pour leur projet. J'espère qu'il répondra à leurs besoins et les aidera à améliorer leur processus de satisfaction client. J'apprécierai vos retours et suggestions pour améliorer ce projet. Merci d'avance pour votre utilisation et votre soutien.