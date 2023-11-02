<?php

namespace tp5er\think\HttpLogger\LogProfile;

use think\Request;
use tp5er\think\HttpLogger\LogProfile;


class LogRobotRequests implements LogProfile
{

    /**
     * @var array
     */
    public static $spiderSite = [
        "TencentTraveler",
        "Baiduspider+",
        "BaiduGame",
        "Googlebot",
        "msnbot",
        "Sosospider+",
        "Sogou web spider",
        "ia_archiver",
        "Yahoo! Slurp",
        "YoudaoBot",
        "Yahoo Slurp",
        "MSNBot",
        "Java (Often spam bot)",
        "BaiDuSpider",
        "Voila",
        "Yandex bot",
        "BSpider",
        "twiceler",
        "Sogou Spider",
        "Speedy Spider",
        "Google AdSense",
        "Heritrix",
        "Python-urllib",
        "Alexa (IA Archiver)",
        "Ask",
        "Exabot",
        "Custo",
        "OutfoxBot/YodaoBot",
        "yacy",
        "SurveyBot",
        "legs",
        "lwp-trivial",
        "Nutch",
        "StackRambler",
        "The web archive (IA Archiver)",
        "Perl tool",
        "MJ12bot",
        "Netcraft",
        "MSIECrawler",
        "WGet tools",
        "larbin",
        "Fish search",
    ];

    /**
     * @param Request $request
     * @return bool
     */
    public function shouldLogRequest(Request $request): bool
    {
        $agent = $request->header('HTTP_USER_AGENT');
        foreach (self::$spiderSite as $val) {
            $str = strtolower($val);
            if (strpos($agent, $str) !== false) {
                return true;
            }
        }
        return false;
    }
}