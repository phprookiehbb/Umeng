<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/22
 * Time: 11:35
 */

namespace CraspHb\Umeng;

class Umeng
{
    protected $config = [];

    public function __construct($appkey, $secret)
    {
        if(!$secret || !$secret)
        {
            throw new UmengException("appkey和secret必填");
        }
        $this->config = [
            'appkey' => $appkey,
            'secret' => $secret,
            'timestamp' => strval(time())
        ];
    }
    public function send($type, $data)
    {
        return Middle::run($type, $data, $this->config);
    }
    public function set($type, $data = [])
    {
        return Middle::set($type, $data, $this->config);
    }
}