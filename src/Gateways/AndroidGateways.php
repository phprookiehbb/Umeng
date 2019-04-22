<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/25
 * Time: 11:19
 */

namespace CraspHb\Umeng\Gateways;


class AndroidGateways extends Gateways
{
    protected $androidPayload = [
        "display_type"  =>  "notification",
        "body"         	=>  [
            "ticker"       =>   NULL,
            "title"        => NULL,
            "text"         => NULL,
            "play_vibrate" => "true",
            "play_lights"  => "true",
            "play_sound"   => "true",
            "after_open"   => NULL
        ]
    ];
    protected $playload_keys = ["display_type"];

    protected $body_keys    = ["ticker", "title", "text", "builder_id", "icon", "largeIcon", "img", "play_vibrate", "play_lights", "play_sound", "after_open", "url",
        "activity", "custom"];

    /**
     * 安装常规的参数设置
     * @param $key
     * @param $value
     * @return $this
     */
    public function setCustomizedField($key, $value)
    {
        if (!is_string($key))
            throw new UmengException("key必须是字符串");
        $this->data["payload"]["extra"][$key] = $value;
        return $this;
    }

    /**
     * 安卓自定义字段设置
     * @param $key
     * @param $value
     * @return $this
     */
    public function setPredefine($key, $value)
    {
        if (!is_string($key))
            throw new UmengException("key必须是字符串");
        if (in_array($key, $this->data_keys)) {
            $this->data[$key] = $value;
        } else if (in_array($key, $this->playload_keys)) {
            $this->data["payload"][$key] = $value;
            if ($key == "display_type" && $value == "message") {
                $this->data["payload"]["body"]["ticker"] = "";
                $this->data["payload"]["body"]["title"] = "";
                $this->data["payload"]["body"]["text"] = "";
                $this->data["payload"]["body"]["after_open"] = "";
                if (!array_key_exists("custom", $this->data["payload"]["body"])) {
                    $this->data["payload"]["body"]["custom"] = NULL;
                }
            }
        } else if (in_array($key, $this->body_keys)) {
            $this->data["payload"]["body"][$key] = $value;
            if ($key == "after_open" && $value == "go_custom" && !array_key_exists("custom", $this->data["payload"]["body"])) {
                $this->data["payload"]["body"]["custom"] = NULL;
            }
        } else if (in_array($key, $this->policy_keys)) {
            $this->data["policy"][$key] = $value;
        } else {
            if ($key == "payload" || $key == "body" || $key == "policy" || $key == "extra") {
                throw new UmengException("你不需要设置${key}的值 , 只需要设置其子类的值即可");
            } else {
                throw new UmengException("错误的key: ${key}");
            }
        }
        return $this;
    }
}