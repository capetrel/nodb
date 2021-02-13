<?php


namespace App;

use cebe\markdown\GithubMarkdown;
use Jenssegers\Blade\Blade;
use Webuni\FrontMatter\FrontMatter;

class Page
{

    private string $path;
    private $parsedData;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Méthode magique pour ne pas avoir à utiliser les getter : $page->get('property'), mais : page->property
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if(!property_exists($this, $property)) {
            try {
                $this->$property = $this->get($property);
            } catch (\Exception $e) {
                echo $e->getMessage();
                $this->$property =  null;
            }

        }
        return $this->$property;
    }

    /**
     * Retourne le contenu de la propriété si elle existe
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        if(is_null($this->parsedData)) {
            $this->parsedData = (new FrontMatter())->parse(file_get_contents($this->path));
        }
        if ($key === 'content') {
            $filenameParts = explode('.', pathinfo($this->path, PATHINFO_FILENAME));
            $type = end($filenameParts);
            $method = "parse".ucfirst($type);
            return $this->$method($this->parsedData->getContent());
        }
        if(!isset($this->parsedData->getDataWithContent()[$key])) {
            // throw new \Exception("La propriété : $key, n'existe pas dans le fichier yaml" . $this->path);
            return null;
        }
        if(is_array($this->parsedData->getDataWithContent()[$key])) {
            return $this->parsedData->getDataWithContent()[$key];
        }
        return nl2br($this->parsedData->getDataWithContent()[$key]);
    }

    /**
     * Convertir un chemin de fichier en URL
     * @return string L'url qui correspond au fichier yaml
     */
    public function getUrl(): string
    {
        $path = str_replace(CONTENT_PATH, '', $this->path);
        $path = current(explode('.', $path));
        $path = str_replace('index', '', $path);
        $path = str_replace('\\', '/', $path);
        return $path;
    }

    public function render(array $structure = null, array $result = null)
    {
        $page = $this;
        if(is_null($page->layout)) {
            $layout = 'default';
        } else {
            $layout = $page->layout;
        }

        $blade = new Blade(VIEWS_PATH, BASE_PATH . DIRECTORY_SEPARATOR. 'cache');
        return $blade->render('pages.'.$layout, compact('page', 'structure','result'));
    }

    private function parseMarkdown ($content) {
        $parser = new GithubMarkdown();
        $parser->enableNewlines = true;
        return $parser->parse($content);
    }


    private function parseHtml ($content) {
        return $content;
    }


}