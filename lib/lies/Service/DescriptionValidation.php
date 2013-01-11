<?php

namespace Lies\Service;

class DescriptionValidation {
    private $validApi;

    public function __construct ($validApi)
    {
        $this->validApi = $validApi;
    }

    public function validate($description) {

        $result = $this->validApi->postProfanityFilter(array('description' => $description));

        return $result;
    }
}