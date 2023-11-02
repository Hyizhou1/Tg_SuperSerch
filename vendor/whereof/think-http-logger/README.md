这个包添加了一个中间件，可以将传入的请求记录到默认日志中。 如果在用户请求期间出现任何问题，您仍然可以访问该用户发送的原始请求数据。



配置文件`config/http-logger.php`内容：

~~~
<?php
return [
    /*
   * The log profile which determines whether a request should be logged.
   * It should implement `LogProfile`.
   */
    'log_profile' => \tp5er\think\HttpLogger\LogProfile\LogNonGetRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer'  => \tp5er\think\HttpLogger\LogWriter\DefaultLogWriter::class,

    /*
    * The log channel used to write the request.
    */
    'log_channel' => env('LOG_CHANNEL', 'file')
];
~~~



## 控制器中使用

~~~
use tp5er\think\HttpLogger\Middlewares\HttpLogger;
class Index extends BaseController
{
    protected $middleware =[
        HttpLogger::class
    ];
    public function index()
    {
        return 'test HttpLogger';
    }
}
~~~

## 路由中使用

~~~
Route::get('think', function () {
    return 'hello,ThinkPHP6!';
})->middleware(\tp5er\think\HttpLogger\Middlewares\HttpLogger::class);
~~~

## 全局`app/middleware.php`

~~~
<?php
// 全局中间件定义文件
return [
		......
    \tp5er\think\HttpLogger\Middlewares\HttpLogger::class
];
~~~

日志记录
两个类用于处理传入请求的日志记录：`LogProfile` 类将确定是否应记录请求，`LogWriter` 类将请求写入日志。

在这个包中添加了一个默认的日志实现。 它只会记录 `POST`、`PUT`、`PATCH` 和 `DELETE` 请求，并将写入默认的 thinkphp 记录器。

您可以自由实现自己的日志配置文件和/或日志编写器类，并在` config/http-logger.php` 中进行配置。

自定义日志配置文件必须实现` \tp5er\think\HttpLogger\LogProfile`。 这个接口需要你实现 shouldLogRequest。

~~~
// Example implementation from `tp5er\think\HttpLogger\LogNonGetRequests`

public function shouldLogRequest(Request $request): bool
{
   return in_array(strtolower($request->method()), ['post', 'put', 'patch', 'delete']);
}
~~~

自定义日志编写器必须实现 \tp5er\think\HttpLogger\LogWriter。 这个接口需要你实现logRequest。

~~~
// Example implementation from ` \tp5er\think\HttpLogger\DefaultLogWriter`

public function logRequest(Request $request): void
{
    $method = strtoupper($request->method());
    $uri = $request->pathinfo();
    $bodyAsJson = json_encode($request->all());
    $message = "{$method} {$uri} - {$bodyAsJson}";
    Log::channel(config('http-logger.log_channel'))->info($message);
}
~~~
