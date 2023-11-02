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