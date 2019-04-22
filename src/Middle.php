<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/22
 * Time: 13:28
 */

namespace CraspHb\Umeng;

use CraspHb\Umeng\Gateways\AndroidGateways;
use CraspHb\Umeng\Gateways\IosGateways;

class Middle
{
    public $instance;

    public static function getInstance($type, $data, $config)
    {
        $device = strtolower(strstr($type,'_', true));
        switch ($device){
            case 'android';
                $instance = new AndroidGateways($type, $config, $data);
                break;
            case 'ios';
                $instance = new IosGateways($type, $config, $data);
                break;
        }
        return $instance;
    }
    public static function run($type, $data, $config)
    {

        return self::getInstance($type, $data, $config)->run();
    }
    public static function set($type, $data = [], $config)
    {
        return self::getInstance($type, $data, $config);
    }
}