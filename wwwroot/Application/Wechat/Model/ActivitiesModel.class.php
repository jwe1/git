<?php
namespace Wechat\Model;
use Think\Model;

/**
 * 活动模型
 */
class ActivitiesModel extends Model{


    protected $_validate = array(
        array('username', 'require', '标题不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        array('activity', 'require', '分类不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_INSERT),
        array('status', 'require', '分类不能为空', self::EXISTS_VALIDATE , 'regex', self::MODEL_UPDATE),
    );


    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );
}

