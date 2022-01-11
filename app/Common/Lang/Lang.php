<?php
namespace App\Common\Lang;

/**
 * 语言包接口类，如果新增语言包，都要继承这个接口
 * Interface Lang
 * @package App\Common\Lang
 */
interface Lang{

    /**获取语言包
     * @return mixed
     */
    static function getLang();
}