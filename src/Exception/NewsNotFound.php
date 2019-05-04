<?php

namespace App\Exception;

class NewsNotFound extends \Exception {
    public function __construct(int $id) {
        parent::__construct('News with ID = '.$id.' does not exist');
    }
}
