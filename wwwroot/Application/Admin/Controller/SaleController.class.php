<?php
namespace Admin\Controller;


/**
 * 报修管理控制器
 * @author huajie <banhuajie@163.com>
 */

class SaleController extends AdminController{

    /**
     * 后物业管理单首页
     * @return none
     */
    public function index(){
        $id = I('get.keywords', 0);
        /* 获取频道列表 */
        //1.构造收索条件
         if(!empty(I('get.keywords',0))){
          $map['title']   =   array('like', '%'.$id.'%');
          $map['username']   =   array('like', '%'.$id.'%');
       }
        $map[]  = array('type' => array('gt', -1));//状态大于-1
        //2.开始分页
        $count      = M('Sale')->where($map)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        //3.分页跳转的时候保证查询条件
        foreach($map as $key=>$val) {
            $Page->parameter[$key]   =   urlencode($val);
        }

        $Page->lastSuffix = false;//最后一页不显示为总页数
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        //4. 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = M('Sale')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        $show       = $Page->show();// 分页显示输出

        //5.分配数据
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->meta_title = '小区租售';
        $this->display();
    }



    /**
     * 添加小区租赁信息
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        if(IS_POST){
            $Sale = D('Sale');
            $data = $Sale->create();//接受数据
            $data['end_time'] = strtotime($data['end_time']);
            if($data){

                $id = $Sale->add($data);
                if($id){
                    $this->success('新增成功', U('index'));
                    //记录行为
                    action_log('update_Sale', 'Sale', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Sale->getError());
            }
        } else {
         /*   $pid = I('get.id', 0);
            //获取父导航
            if(!empty($id)){
                $parent = M('Sale')->where(array('id'=>$id))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('id', $id);*/
            $this->assign('info',null);
            $this->meta_title = '新增租赁信息';
            $this->display('edit');
        }
    }


    /**
     * 删除租赁信息
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del(){
        $id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('Sale')->where($map)->delete()){
            //记录行为
            action_log('update_sale', 'sale', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }


    public function edit($id = 0){
        if(IS_POST){
            $sale = D('Sale');
            $data = $sale->create();
            if($data){
                if($sale->save()){
                    //记录行为
                    action_log('update_sale', 'sale', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($sale->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Sale')->find($id);
            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $this->assign('id', $id);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            $this->display();
        }
    }



    public function status(/*$status = null, $id = null*/)
    {
        $ids = array_unique((array)I('post.id',0));
        $status =   I('post.status');
        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }

        foreach ($ids as $id){
            $map[]  = array('id' => $id);
            $sale = M('Sale')->where($map)->select();
            foreach ($sale as $s){
                $s['status'] = $status;
            }
            $sale->addall();
        }

        echo json_encode(['data'=>'设置成功']);
           // $this->success('设置成功', U('index'));
    }


    function uploadify()
    {
        $ph=M('Upload');
        import('ORG.Net.UploadFile');
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize = 93145728 ;// 设置附件上传大小
        $upload->saveRule =rand(1,9999);
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg','flv','avi','mov');// 设置附件上传类型
        $upload->savePath = './Uploads/';// 设置附件上传目录
        if(!$upload->upload())
        {// 上传错误提示错误信息
            $this->error($upload->getErrorMsg());
        }else{// 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
        }
        for($i=0;$i<count($info);$i++)
        {
            $data['name']=$info[$i]['savename'];
            $data['size']=$info[$i]['size'];
            $data['type']=$info[$i]['extension'];
            echo $info[$i]['savename'];
            $rs=$ph->add($data);
        }
        /*if($rs)
        {
        $this->success("成功");
        }else
        {
        $this->error("失败");
        }*/
    }



}

