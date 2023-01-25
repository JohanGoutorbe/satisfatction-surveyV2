# satisfatction-surveyV2

French Satisfaction Survey Made By Johan Goutorbe For The Society Office Center The 01/25/2023

## Table des Matières
1. [Fonctionnement](#Fonctionnement)
2. [Prérequis](#Prérequis)


### Fonctionnement

Cette page PHP utilise la méthode GET pour récupérer les paramètres d'une URL, qui sont ensuite vérifiés pour leur validité. Ces paramètres comprennent un numéro d'intervention, le nom d'un technicien, une date, un choix de notation et une adresse e-mail. Si tous les paramètres sont valides, une requête est effectuée pour enregistrer les informations dans une base de données MySQL. Sinon, des messages d'erreur sont affichés pour indiquer les paramètres incorrects. La page utilise également la classe PDO pour se connecter à la base de données.

### Prérequis
***
Les prérequis pour exécuter ce code incluent :
* Un serveur web (comme Apache ou Nginx) avec PHP installé.
* Accès à une base de données MySQL avec les informations de connexion correctes (nom d'utilisateur, mot de passe, nom de serveur, nom de base de données) défini dans les constantes USER, PASSWD, SERVER et BASE.
* Les extensions PHP PDO et pdo_mysql activées.
* Une table "client_satisfaction" existante dans la base de données avec des champs appropriés pour enregistrer les informations des paramètres de l'URL.

Il est également préférable de s'assurer que les informations d'erreur sont masquées pour la production, pour éviter de montrer des informations sensibles aux utilisateurs.

### Installation

#### Installation locale
```
$ git clone https://github.com/JohanGoutorbe/satisfatction-surveyV2
```
#### Installation Base de Données

Ce serveur