<?php

namespace App\Illuminate\Foundation;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * @return string
     */
    public function publicPath()
    {
        return (string)realpath($this->basePath('../../'));
    }
}
