<?php
namespace Wechat\Controller;

class IndexController extends WechatController{

    //构造函数,判断登录
 /*   public function __construct(){
        parent::__construct();
            $this->login();
    }*/

    //显示首页
    public function index(){

        $this->buildHtml("index",'',"");
        $this->display();
    }

    //个人中心
    public function my(){
        //查询出个人信息
        $username = session('username');
        $user_info =M('User')->where(['username'=>$username])->find();
        $jifen = $user_info['jifen'];
        $this->assign('username',$username);
        $this->assign('jifen',$jifen);
        $this->display();
    }


    public function my_activity(){
        //查询user_id
        $username = session('username');
        $user_info =M('User')->where(['username'=>$username])->find();
        $user_id = $user_info['id'];
        //查询活动
        $activities = M('activities')->where(['user_id'=>$user_id])->join('__DOCUMENT__ as d on d.id = __ACTIVITIES__.ACTIVITY')->join('____')->select();
        var_dump($activities);exit;
        $this->assign('lists',$activities);
        $this->display();
    }

    //小区通知
    public function notice(){
       // $articles = M('document')->select(); //查找出文章显示
        $cate_id = 2;//文章分类id
        $articles = M('document')->where(['category_id'=>$cate_id])->field('onethink_document.id,description,onethink_document.create_time,title,onethink_picture.path,view')->join('LEFT JOIN onethink_picture on onethink_picture.id=onethink_document.cover_id')->select();
        $this->assign('articles',$articles);
        $this->display();
    }


    //通知详情页
    public function notice_detail(){
        $id = I('get.id',0);
        $notice = M('Document')->where(['id'=>$id])->find();//查找通知

        $content = M('Document_article')->where(['id'=>$notice['id']])->find();//查找内容
        $this->assign('notice',$notice);
        $this->assign('content',$content);
        $this->display();
    }

    //小区活动
    public function xq_activity(){
        //查询活动分类id
        $re =M('category')->where(['name'=>'activities'])->find();
        $category_id = $re['id'];

        //分页开始
        $pagesize = 2;
        $start = I('p') ? (I('p')-1)*$pagesize : 0;

        //查询数据
        $list = M('Document')->where(['category_id'=>$category_id])->field('onethink_document.id,title,title,description,view,path,onethink_document.create_time')->join('left JOIN onethink_document_article ON onethink_document_article.id = onethink_document.id')->join('left JOIN onethink_picture ON onethink_document.cover_id = onethink_picture.id')->limit($start,$pagesize)->select();
       //判断请求方式，返回不同数据
        if(IS_AJAX){
            $this->ajaxReturn($list);
        }else{
            $this->assign('lists',$list);
            $this->display();
        }
    }


    //参加活动
    public function join(){
        //判断登录
        if(!is_login()){
            $this->ajaxReturn('请先登录');
        }

        $id = I('id');
        //查询当前活动是否过期
        $act = M('document')->where(['id'=>$id])->find();
        if($act['deadline'] <= time()){
            $this->ajaxReturn('活动已经结束');
        }
        //判断是否已经参加了当前活动
        $activity = D('Activities');
        $result = $activity->where(['activity'=>$id,'username'=>session('username')])->find();
        if($result){
            $this->ajaxReturn('你已经参加了该活动');
        }

        $data['activity'] = $id;
        $data['status'] = 1;
        $data['username']=  session('username');
        $data['create_time']=  time();
        if( $activity->data($data)->add()){
            $this->ajaxReturn('参加成功');
        }else{
            $this->ajaxReturn('参加失败');
        }
    }


    //活动详情页
    public function xq_activity_detail($id=''){
        //查询活动
        $id = I('id',0);
        $list = M('Document')->where(['id'=>$id])->find();
        $content = M('Document_article')->where(['id'=>$list['id']])->find();//查找内容
        $this->assign('list',$list);
        $this->assign('content',$content);
        $this->display();
    }


    //在线报修
    public function online_repair(){
        if(IS_POST){
            $repair = M('Repair');
            $data = $repair->create();
            $data['create_time'] = time();
            //生成sn
            $data['sn'] = uniqid('SIS_').date('Ymd');
            if($repair->add($data)){
                $this->redirect('my');
            }else{
                $this->redirect('online');
            }
        }
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