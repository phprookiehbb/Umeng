<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/22
 * Time: 13:20
 */

namespace CraspHb\Umeng;


final class Config
{
    const ANDROID_BROADCAST  = 'android_broadcast';
    const ANDROID_GROUPCAST  = 'android_groupcast';
    const ANDROID_LISTCAST   = 'android_listcast';
    const ANDROID_UNICAST    = 'android_unicast';
    const ANDROID_CUSTOMIZEDCAST  = 'android_customizedcast';
    const ANDROID_FILECAST   = 'android_filecast';

    const IOS_BROADCAST      = 'ios_broadcast';
    const IOS_GROUPCAST      = 'ios_groupcast';
    const IOS_LISTCAST       = 'ios_listcast';
    const IOS_UNICAST        = 'ios_unicast';
    const IOS_CUSTOMIZEDCAST      = 'ios_customizedcast';
    const IOS_FILECAST       = 'ios_filecast';
}