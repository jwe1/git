<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 小区租赁模型
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class SaleModel extends Model {
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('price', 'require', '价格不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('type', 'require', '类型不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('end_time', 'require', '结束时间不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('tel', 'require', '电话不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('type', 'require', '类型不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
       //array('path', 'require', '类型不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('content', 'require', '类型不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('tel','/^1[3|4|5|8][0-9]\d{4,8}$/','手机号码错误！',self::MUST_VALIDATE ,'regex',self::MODEL_BOTH),
        array('danwei', 'require', '单位不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),

    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        //array('update_time', NOW_TIME, self::MODEL_BOTH),
       // array('status', '0', self::MODEL_INSERT),
    );

}
