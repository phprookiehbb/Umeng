<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/25
 * Time: 11:19
 */

namespace CraspHb\Umeng\Gateways;


class IosGateways extends Gateways
{
    protected $iosPayload = [
        "aps" => [
            "alert" => null
        ]
    ];
    protected $aps_keys    = ["alert", "badge", "sound", "content-available"];
    protected $alert_keys = ["title", "subtitle", "body"];

    /**
     * IOS常规参数设置
     * @param $key
     * @param $value
     * @return $this
     */
    public function setCustomizedField($key, $value)
    {
        if (!is_string($key))
            throw new UmengException("key必须是字符串！");
        $this->data["payload"][$key] = $value;
        return $this;
    }
    public function setPredefine($key, $value)
    {
        if (!is_string($key))
            throw new UmengException("key必须是字符串！");
        if (in_array($key, $this->data_keys)) {
            $this->data[$key] = $value;
        } else if (in_array($key, $this->aps_keys)) {
            $this->data["payload"]["aps"][$key] = $value;
        } else if (in_array($key, $this->alert_keys)) {
            $this->data["payload"]["aps"]["alert"][$key] = $value;
        }else if (in_array($key, $this->policy_keys)) {
            $this->data["policy"][$key] = $value;
        } else {
            if ($key == "payload" || $key == "policy" || $key == "aps") {
                throw new UmengException("你不需要设置${key}的值 , 只需要设置其子类的值即可");
            } else {
                throw new UmengException("错误的key: ${key}");
            }
        }
        return $this;
    }
}