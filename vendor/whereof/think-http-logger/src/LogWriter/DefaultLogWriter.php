<?php

namespace tp5er\think\HttpLogger\LogWriter;

use think\facade\Log;
use think\file\UploadedFile;
use think\Request;
use tp5er\think\HttpLogger\LogWriter;


class DefaultLogWriter implements LogWriter
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function logRequest(Request $request)
    {
        $message = $this->formatMessage($this->getMessage($request));
        Log::channel(config('http-logger.log_channel'))->info($message);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getMessage(Request $request)
    {
        $files = $this->files($request->file());
        return [
            'method'  => strtoupper($request->method()),
            'uri'     => $request->pathinfo(),
            'body'    => $request->all(),
            'headers' => $request->header(),
            'files'   => $files,
        ];
    }

    /**
     * @param array $message
     * @return string
     */
    protected function formatMessage(array $message)
    {
        $bodyAsJson    = json_encode($message['body']);
        $headersAsJson = json_encode($message['headers']);
        $files         = implode(',', $message['files']);
        return "{$message['method']} {$message['uri']} - Body: {$bodyAsJson} - Headers: {$headersAsJson} - Files: " . $files;
    }


    /**
     * @param $files
     * @return array
     */
    public function files($files)
    {
        if (empty($files)) {
            return [];
        }
        $fs = $this->flatFiles($files);
        $fi = [];
        foreach ($fs as $f) {
            if (is_array($f)) {
                $fi = array_merge($fi, $f);
            } else {
                $fi[] = $f;
            }
        }
        return $fi;
    }

    /**
     * @param $file
     * @return array|string
     */
    public function flatFiles($file)
    {
        if ($file instanceof UploadedFile) {
            return $file->getOriginalName();
        }
        if (is_array($file)) {
            return array_map([$this, 'flatFiles'], $file);
        }
        return (string)$file;
    }
}