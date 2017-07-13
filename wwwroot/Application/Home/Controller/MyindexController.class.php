<?php
namespace Home\Controller;

class MyindexController extends HomeController{

    //构造函数
    public function __construct(){
        parent::__construct();
        $this->redirect('Login/login');
    }

    //显示首页
    public function index(){
        $this->buildHtml("index",'',"");
        $this->display();
    }

    //个人中心
    public function center(){
        $this->display();
    }

    //小区通知
    public function notice(){
        $articles = M('document')->select(); //查找出文章显示
        foreach ($articles as $art){
            $pictures = M('picture')->where(['id'=>$art['cover_id']])->select();
            $art['pictures']=$pictures;
        }

        $this->assign('articles',$articles);
        $this->display();
    }

    //关于我们
    public function about(){
        $this->display();
    }

    //调查详情页
    public function diaocha_detail(){
        $this->display();
    }

    //调查问卷
    public function diaochawenjuan(){
        $this->display();
    }

    //发现
    public function faxian(){
        $this->display();
    }

    //服务
    public function fuwu(){
        $this->display();
    }

    //通知详情页
    public function notice_detail(){
        $this->display();
    }

    //在线保修
    public function online(){
        $this->display();
    }

    //帮助信息
    public function service(){
        $this->display();
    }

    //帮助信息详情页
    public function service_detail(){
        $this->display();
    }

    //业主认证
    public function yezhurenzheng(){
        $this->display();
    }

    //租售房源信息
    public function zushou()
    {
        //查询数据库租售信息
        $zu = M('Sale')->where(['type'=>0])->select();
        $shou = M('Sale')->where(['type'=>1])->select();
        $this->assign('zu',$zu);
        $this->assign('shou',$shou);
        $this->display();
    }

    //租售详情页
    public function zushou_detail($id=0){
        $sale = M('Sale')->where(['id'=>1])->find();
        $this->assign('sale',$sale);
        $this->display();
    }

}