<?php
namespace Admin\Controller;

class RepairController extends AdminController{

    //报修模块
    public function index(){
        //查询出所有帮修信息显示,分页
        $repair = M('Repair');
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $count      = $repair->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数
        //配置显示样式
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show       = $Page->show();// 分页显示输出
        //查询数据
        $lists = $repair->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('lists',$lists);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }


    //后台添加报修
    public function add(){
        if(IS_POST){
            $repair = M('Repair');
            $data = $repair->create();
            $data['create_time'] = time();
            //生成sn
            $data['sn'] = uniqid('SIS_').date('Ymd');
            if($repair->add($data)){
                $this->redirect('index');
            }else{
                $this->redirect('add');
            }
        }
        $this->display();
    }

    //删除报修
    public function del(){
        $id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(M('Repair')->where($map)->delete()){
            //记录行为
            action_log('update_repair', 'repair', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }


    //查看报修详情
    public function detail(){
        $id = I('id',0);
        if (empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $list = M('Repair')->where(['id'=>$id])->find();
        $this->assign('list',$list);
        $this->display();
    }

    //修改报修状态
    public function change_status(){
        if(IS_AJAX){
            $id = I('id',0);
            if (empty($id) ) {
                $this->error('请选择要操作的数据!');
            }
            $data['status'] = 1;
            $result = M('Repair')->where(['id'=>$id])->save($data);
            if($result){
                $this->ajaxReturn(1);//处理成功
            }else{
                $this->ajaxReturn(0);//处理失败
            }
        }
    }



}