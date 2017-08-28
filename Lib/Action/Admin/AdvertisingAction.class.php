<?php
/**
 * 后台友情链接控制器
 *
 * @subpackage Admin
 * @package Action
 * @stage 7.0
 * @author lf <liufeng@guanyisoft.com>
 * @date 2013-1-6
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class AdvertisingAction extends AdminAction{
    public function _initialize() {
        parent::_initialize();
        $this->setTitle(' - '.L('MENU1_10'));
    }
    /**
     * 后台商品控制器默认页，需要重定向
     * @author lf <liufeng@guanyisoft.com>
     * @date 2013-01-06
     */
    public function index(){
        $this->redirect(U('Admin/Advertising/pageList'));
    }
    /**
     * 友情链接列表
     * @author lf <liufeng@guanyisoft.com>
     * @date 2013-01-06
     */
    public function pageList(){
    	$linksObj = D('Advertising');
		$page_no = max(1,(int)$this->_get('p','',1));
		$page_size = 10;
		$list = $linksObj->field('s_id,s_name,s_image_path,s_order')
						->order('s_order desc')
						->where('s_status=1')
						->page($page_no,$page_size)
						->select();
        foreach($list as &$val){
                $val['s_image_path'] = D('QnPic')->picToQn($val['s_image_path']);
        }
        $count = $linksObj->where('s_status=1')->count();
		$obj_page = new Page($count, $page_size);
        $page = $obj_page->show();
        $this->assign('list', $list);    //赋值数据集
        $this->assign('page', $page);    //赋值分页输出
        $this->getSubNav(2,10,10);
        $this->display();
    }
    /**
     * 发布友情链接
     */
    public function pageAdd(){
    	$this->getSubNav(2,10,20);
		$this->display();
    }

    public function doAdd(){
		$linksObj = D('Advertising');
		$data = $this->_post();
		if(empty($data['s_name'])){
			$this->error('来源名称不能为空');
		}
		/**
    	if($_FILES['f_imagepath']['name']){
	    	//import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  './Public/Uploads/'.CI_SN.'links/';// 设置附件上传目录
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->error($upload->getErrorMsg());
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
				$data['ul_image_path'] = '/Public/Uploads/'.CI_SN.'/links/' . $info[0]['savename'];
			}
    	}**/
		$data['s_image_path'] = D('ViewGoods')->ReplaceItemPicReal($data['s_image_path']);
		$result = $linksObj->add($data);
		if($result){
			$this->success('操作成功',U('Admin/Advertising/pageList'));
		}else{
			$this->error('新增来源失败');
		}
    }
    /**
     * 编辑友情链接
     */
    public function pageEdit(){
		$this->getSubNav(2,10,20);
    	$ulid = $this->_get('ulid');
    	$linksObj = D('Advertising');
		$ary_where = array('s_status'=>'1');
		$ary_where['s_id'] = $ulid;
    	$linkInfo = $linksObj->where($ary_where)->find();
		$linkInfo['ul_image_path'] = D('QnPic')->picToQn($linkInfo['ul_image_path']);
    	$this->assign('link',$linkInfo);
		$this->display('pageAdd');
    }

    public function doEdit(){
		$linksObj = D('Advertising');
		$data = $this->_post();
		if(empty($data['s_name'])){
			$this->error('来源名称不能为空');
		}
		/**
		if($_FILES['f_imagepath']['name']){
			//import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  './Public/Uploads/'.CI_SN.'/links/';// 设置附件上传目录
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->error($upload->getErrorMsg());
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
				$data['ul_image_path'] = '/Public/Uploads/'.CI_SN.'/links/' . $info[0]['savename'];
			}
    	}	**/
		$data['s_image_path'] = D('ViewGoods')->ReplaceItemPicReal($data['s_image_path']);		
		$result = $linksObj->save($data);
		if($result===false){
			$this->error('修改来源失败');
		}else{
			$this->success('操作成功',U('Admin/Advertising/pageList'));
		}
    }
    
    public function doDel(){
		$ulid = intval($this->_get('s_id'));
		$linksObj = D('Advertising');
		$linksObj->where('s_id='.$ulid)->setField(array('s_status'=>0,'s_update_time'=>date('Y-m-d H:i:s')));
		$this->success('操作成功',U('Admin/Advertising/pageList'));
    }
	
}