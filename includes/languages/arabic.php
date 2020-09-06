<?php


    function lang($phrase){

        static $lang = array(

            'hi' => 'welcome'
        );
        return $lang[$phrase];
    }