<?php
namespace Wechat\Controller;
use User\Api\UserApi;

/**
 * 用户登录
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/7/7
 * Time: 14:00
 */
class LoginController extends WechatController{


    /* 注册页面 */
    public function register($username = '', $password = '', $repassword = '', $email = '', $verify = ''){
        if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        }
        if(IS_POST){ //注册用户
            /* 检测验证码 */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }

            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            $user = D('user');
            // 自动验证 创建数据集
            if (!$data = $user->create()) {
                // 防止输出中文乱码
                header("Content-type: text/html; charset=utf-8");
                exit($user->getError());
            }
            //插入数据库
            if ($id = $user->add($data)) {
                $this->success('注册成功', U('Login/login'), 2);
            } else {
                $this->error('注册失败');
            }
        } else { //显示注册表单
            $this->display();
        }
    }


    /* 登录页面 */
    public function login($username = '', $password = '', $verify = ''){
        $this->buildHtml("login",'',"");
        if(IS_POST){ //登录验证
            /* 检测验证码 */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }
            // 实例化Login对象
            $login = D('user');
            // 自动验证 创建数据集
            if (!$data = $login->create()) {
                // 防止输出中文乱码
                header("Content-type: text/html; charset=utf-8");
                exit($login->getError());
            }
            // 组合查询条件
            $where = array();
            $where['username'] = $data['username'];
            $result = $login->where($where)->field('password,username')->find();
            // 验证用户名 对比 密码
            if ($result && $password == $result['password']) {
                // 存储session

                session('id', $result['uid']);          // 当前用户id
               // session('nickname', $result['nickname']);   // 当前用户昵称
                session('username', $result['username']);   // 当前用户名
                //session('lastdate', $result['lastdate']);   // 上一次登录时间
               // session('lastip', $result['lastip']);       // 上一次登录ip
                // 更新用户登录信息
                $where['id'] = session('uid');
                M('user')->where($where)->save($data);   // 更新登录时间和登录ip
                $this->success('登录成功,正跳转至首页...', U('Index/my'));
            } else {
                $this->error('登录失败,用户名或密码不正确!');
            }
        } else { //显示登录表单
            $this->display();
        }
    }


    /**
     * 用户注销
     */
    public function logout()
    {
        // 清楚所有session
        session(null);
        redirect(U('Login/login'), 2, '正在退出登录...');
    }



    /* 验证码，用于登录和注册 */
    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }



}