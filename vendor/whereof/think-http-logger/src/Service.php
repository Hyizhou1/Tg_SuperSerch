<?php


namespace tp5er\think\HttpLogger;

use tp5er\think\HttpLogger\Middlewares\HttpLogger;

class Service extends \think\Service
{
    public function register()
    {
        $this->app->bind(LogProfile::class, config('http-logger.log_profile'));
        $this->app->bind(LogWriter::class, config('http-logger.log_writer'));

        $this->app->bind(HttpLogger::class, function () {
            return new HttpLogger($this->app->get(LogProfile::class), $this->app->get(LogWriter::class));
        });
    }
}