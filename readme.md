# Site web dynamique sans base de données

Cet outil permet de créer un site web dynamique sans base de donnée. Il n'y a pas d'interface backoffice pour éditer les contenu, mais l'administrateur peu directement écrire le contenu des pages en [HTML](https://developer.mozilla.org/fr/docs/Web/HTML/Reference) ou [Markdown](https://fr.wikipedia.org/wiki/Markdown) et ajouter des variables au format [FrontMatter](https://yaml.org/spec/1.2/spec.html) dans des fichier YAML.


## Comment ça marche
L'application scan récursivement le contenu du dossier "content" et génère à la volé les url accessible via le navigateur. Par example le fichier /content/a-propos.html.yaml sera accessible avec l'URL : http://example.fr/a-propos.

Ainsi on peut créer autant de pages que l'on souhaite, on peut même gérer le multi-langue. Par contre il ne faut pas oublier que cet outils est pertinent pour des simples et/ou sans gros budget, car la lecture de fichiers n'est pas ce qu'il y a de plus performant.

Le contenu des fichiers (sous le FrontMatter) peut être rédigé en Markdown ou en html, le système parsera l'un ou l'autre en fonction de l'extension du fichier : nom-fichier.html.yaml, mon-fichier.markdown.yaml.

Il est très important de noter que LE NOM DES FICHIERS NE DOIT PAS CONTENIR DE CARACTÈRES SPÉCIAUX, D'ACCENT, D'ESPACE, ET DOIT ÊTRE UNIQUE. Pas 2 fichiers dans le même répertoire avec des noms identique, remplacer les espaces par des tirets.

## Configuration
Il y a un peu de configuration à faire avec les variables d'environnemnt. Renommer le fichier .env.example en .env et remplir les clé pour le nom du site, les mails, etc...

## Affichage et variables
L'arborescence de dossier est inspiré de Laravel avec le dossier /resources qui contient les assets à compiler et les vues qui sont au format [Blade](https://github.com/jenssegers/blade). Cette version allégée de Blade permet d'avoir les vues imbriqués, les boucles, les conditions... Par contre certaines fonctions avancées incluse grâce à Laravel ne sont pas disponible, il faudra les créer à la main dans le fichier /app/helpers.php.

### Variables
Toutes les variables déclarées en FrontMatter seront disponible dans le template via l'instance de l'objet Page et la clé qui représente la variable:
```yaml
# yaml
title: Mon titre
header_title: Titre de l'entête
```
```html
<!-- html -->
<title>{{ $page->title }}</title>
<h1>{{ $page->header_title }}</h1>
```
Le contenu du fichier (sous le FrontMatter) s'obtient avec la propriété "content", il faudra penser à échapper les caractères pour que html soit interprété :
```html
<!-- html -->
<div>{!! $page->content !!}</div>
```
Il n'y a pas de variables obligatoires, mais 3 variables seront utilisées si elles existent :
 - layout : pour indiquer qu'elle page utiliser pour le rendu (voir chapitre suivant)
 - meta_description : pour la balise meta description de la page (par défaut : APP_META_DESC du ficher .env)
 - title : pour la balise title de la page (par défaut APP_NAME du fichier .env)
Sinon le créateur du site est libre de créer autant de variables qu'il juge utiles.

### Affichage
Il y a 2 fichiers obligatoires, /resources/views/layouts/site.blade.php et /resources/views/pages/default.blade.php, qu'il ne faut pas renommer, mais dont le contenu est modifiable. le fichier default.blade.php est inclus dans site.blade.php. La variable "layout" dans le YAML permet d'utiliser un autre fichier, dans ce cas le contenu de la variable doit correspondre au nom du fichier sans extension qui est dans le dossier /resources/views/pages/ : example avec index.markdown.yaml qui contient "home" dans "layout" et le fichier /resources/views/pages/home.blade.php.

Le projet de base fournit 2 examples qui propose une solution pour traiter des contenus dynamique de type article de blog. Dans ce cas la page d'accueil affiche une liste de clients et chaque clients à une page.

Il est possible d'ajouter un fichier css et/ou js dans une page spécifique avec la commande spécifique :
```html
@push('css')
 <link rel="stylesheet" href="<?= asset('/css/test.css') ?>">
@endpush
```
Il sera ajouté automatiquement à la place de la commande @stack() dans le fichier site.blade.php

La fonction php asset() dans les fichiers Blade, permet de construire le chemin vers la ressource contenue dans le dossier "/public/". Blade permet d'utiliser les fonctions natives de PHP dans sa syntaxe en plus des fonctions personnalisées.

## Assets
Le projet est livré avec laravel-mix et une configuration prête à être lancé.
```shell
npm install && npm run watch
```
Lance un serveur de développement local avec le "hot reload", le navigateur se met à jours automatiquement dès qu'on modifie un fichier blade, scss, ou js.

Il est évidemment possible d'utiliser n'importe qu'elle autre outils de build.

## TODO
-[ ] Gestion du menu ? Manuellement ? Semi-automatique avec une fonction ? ou Automatique avec la recursivité ?
-[ ] Prévoir erreur sur les noms de fichiers (capturer ? corriger ?)
-[ ] Intégrer un formulaire de contact basique
