<?php

class HomeController {
    public function main ()
    {
         return [
                    "template"=>
                        ['folder'=>"home",
                        'file'=>"main",
                        ],
                ];
    }
}