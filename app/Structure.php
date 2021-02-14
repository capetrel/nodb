<?php


namespace App;


use RegexIterator;

class Structure // extends Page
{

    private array $elementsName;

    public function __construct(array $elementsName)
    {
        $this->elementsName = $elementsName;
    }

    public function getStructureElements(RegexIterator $structures): array {
        $commonElements = [];
        foreach ($structures as $element) {
            $element = $element[0];
            $structureElement = new Page($element);
            foreach ($this->elementsName as $name) {
                if(!is_null($structureElement->$name)) {
                    $commonElements[$name] = $structureElement->$name;
                }
            }
            /*if(!is_null($structureElement->menus)) {
                $commonElements['menus'] = $structureElement->menus;
            }
            if(!is_null($structureElement->blocs)) {
                $commonElements['blocs'] = $structureElement->blocs;
            }*/
        }
        return $commonElements;

    }

}