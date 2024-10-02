<?php

/**
 * -------------------------
 * curl common http request
 * -------------------------
 *
 * Desc: curl common get http request、post request
 *
 * User: liangqi
 * Date: 16/9/4
 * Time: 下午7:06
 */

namespace Daivid\ComposerTest;


class CURLUtil
{
    /**
     * GET HTTP Request By Curl
     *
     * @param $url
     * @param $header
     *
     * @return mixed
     */
    public static function get($url, $header = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        self::makeHeader($curl, $header);
        $r = curl_exec($curl);
        curl_close($curl);
        return $r;
    }

    /**
     * 添加header
     *
     * @param $curl
     * @param $header
     */
    private static function makeHeader($curl, $header)
    {
        //HTTP请求头中"Accept-Encoding: "的值。支持的编码有"identity"，"deflate"和"gzip"。如果为空字符串""，请求头会发送所有支持的编码类型。
        curl_setopt($curl, CURLOPT_ENCODING, '');
        if ($header)
        {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
    }

    /**
     * post request by default format (x-www-form-urlencoded)
     *
     * @param $url
     * @param $data
     * @param $header
     *
     * @return mixed
     */
    public static function post($url, $data, $header = [])
    {
        $curl = curl_init();
        self::makeHeader($curl, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $r = curl_exec($curl);
        curl_close($curl);
        return $r;
    }

    /**
     * post by raw string
     *
     * @param $url
     * @param $data
     * @param array $header
     * @return mixed
     */
    public static function postByRaw($url, $data, $header = [])
    {
        $curl = curl_init();
        self::makeHeader($curl, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        if (!is_string($data))
        {
            $data = json_encode($data);
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $r = curl_exec($curl);
        curl_close($curl);
        return $r;
    }

}