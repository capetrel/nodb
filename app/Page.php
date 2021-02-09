<?php


namespace App;


use cebe\markdown\GithubMarkdown;

class Page
{

    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function __get($property)
    {
        if(!property_exists($this, $property)) {
            $this->$property = $this->get($property);
        }
        return $this->$property;
    }

    public function getUrl() {
        $path = str_replace(CONTENT_PATH, '', $this->path);
        $path = current(explode('.', $path));
        $path = str_replace('index', '', $path);
        $path = str_replace('\\', '/', $path);
        return $path;
    }

    public function render() {
        $page = $this;
        ob_start();
        require LAYOUTS_PATH . DIRECTORY_SEPARATOR . 'default.php';
        return ob_get_contents();
    }

    public function get($key) {
        $document = (new \Webuni\FrontMatter\FrontMatter())->parse(file_get_contents($this->path));
        if ($key === 'content') {
            $filenameParts = explode('.', pathinfo($this->path, PATHINFO_FILENAME));
            $type = end($filenameParts);
            $method = "parse".ucfirst($type);
            return $this->$method($document->getContent());
        }
        return $document->getDataWithContent()[$key];
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