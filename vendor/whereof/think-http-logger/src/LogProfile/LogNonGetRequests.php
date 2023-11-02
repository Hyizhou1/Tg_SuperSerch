<?php

namespace tp5er\think\HttpLogger\LogProfile;

use think\Request;
use tp5er\think\HttpLogger\LogProfile;

class LogNonGetRequests  implements LogProfile
{
    /**
     * @param Request $request
     * @return bool
     */
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), ['post', 'put', 'patch', 'delete']);
    }
}