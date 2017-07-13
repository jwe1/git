<?php
namespace Wechat\Model;

use Think\Model;


class RepairModel extends Model{

    protected $_validate = array(
        array('name', 'require', '姓名不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        array('tel', 'require', '电话不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_INSERT),
        array('address', 'require', '地址不能为空', self::EXISTS_VALIDATE , 'regex', self::MODEL_UPDATE),
        array('title', 'require', '标题不能为空', self::EXISTS_VALIDATE , 'regex', self::MODEL_UPDATE),
        array('content', 'require', '描述不能为空', self::EXISTS_VALIDATE , 'regex', self::MODEL_UPDATE),
    );


    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );
}