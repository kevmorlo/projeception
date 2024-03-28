# projeception

Ceci est un projet consistant à concevoir un logiciel permettant de gérer les différents projets d'Open Innovation des étudiants de l'EPSI

### Groupe sur le projet

----------------------------

- Kevin LEBEAU : <https://github.com/kevmorlo>
- Augustin DUVAL : <https://github.com/Flys3r>

### Langages utilisés

----------------------------

- PHP
- HTML
- CSS

### Framework utilisés

- Laravel
- Tailwind
- Vue.Js

## Installation

### Prérequis

- Laravel
- Composer (Laravel)
- Node

### Installation

1. Importez les dépendances Composer du projet avec la commande : 
```bash
composer install
```
2. Installez les dépendances de Node avec la commande : 
```bash
npm install
```
3. Copiez le fichier ```.env.example``` et renommez le ```.env```.
4. Modifiez les données de celui-ci par celles qui correspondent à votre environnement.
5. Lancez le serveur avec artisan et node, pensez à lancer votre environnement web (WAMP, LAMP etc.) : 
```bash
php artisan serve
```
```bash
npm run dev
```
6. Migrez la base de données et lancez les Seeders : 
```bash
php artisan migrate --seed
```