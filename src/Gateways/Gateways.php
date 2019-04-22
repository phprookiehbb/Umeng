<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/22
 * Time: 13:33
 */

namespace CraspHb\Umeng\Gateways;


use CraspHb\Umeng\Traits\HttpRequest;
use CraspHb\Umeng\Exceptions\UmengException;

class Gateways
{
    use HttpRequest;
    protected $host = "http://msg.umeng.com";

    protected $uploadPath = "/upload";

    protected $postPath = "/api/send";
    protected $url;

    protected $data_keys    = ["appkey", "timestamp", "type", "device_tokens", "alias", "alias_type", "file_id", "filter", "production_mode",
        "feedback", "description", "thirdparty_id"];
    protected $policy_keys  = ["start_time", "expire_time", "max_send_num"];
    protected $appkey = '';
    protected $secret = '';
    protected $timestrap;
    protected $data;
    protected $type;
    public function __construct($type, $config, $data)
    {
        $this->type = $type;
        $this->secret = $config['secret'];
        unset($config['secret']);
        $this->data = array_merge($data, $config);
        $this->setUrl();
    }
    protected function getType()
    {
        return strtolower(substr($this->type, strpos($this->type,'_') + 1 ));
    }
    protected function setType($type)
    {
        $this->type = $type;
    }
    protected function getSign($url, $data)
    {
        $postBody = json_encode($data);
        $sign = md5("POST" . $url . $postBody . $this->secret);
        return $sign;
    }
    public function setUrl()
    {
        $this->url = $this->host . $this->postPath;
    }
    public function getUrl()
    {
        return $this->url .'?sign=' .$this->getSign($this->url, $this->data);
    }
    public function uploadContents($content)
    {
        $post = [
            "appkey" => $this->data["appkey"],
            "timestamp" => $this->data["timestamp"],
            "content" => $content
        ];
        $url = $this->host . $this->uploadPath;
        $postBody = json_encode($post);
        $url = $url . "?sign=" . $this->getSign($url, $postBody);
        $res = $this->postJson($url,$post);
        if($res['ret'] !== 'SUCCESS'){
            throw new UmengException($res['data']['error_msg'], $res['data']['error_code']);
        }
        return $res;
    }
    public function setPolicy($data)
    {
        $this->data['policy'] = $data;
        return $this;
    }
    public function setFilter($data)
    {
        $this->data['filter']['where']['and'] = [$data];
        return $this;
    }
    public function run()
    {
        $this->data['type'] = $this->getType();
        halt($this->data);
        $res = $this->postJson($this->getUrl(),$this->data);
        if($res['ret'] !== 'SUCCESS'){
            throw new UmengException($res['data']['error_msg'], $res['data']['error_code']);
        }
        return $res;
    }
}