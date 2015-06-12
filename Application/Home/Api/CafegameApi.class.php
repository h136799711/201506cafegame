<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY 杭州博也网络科技有限公司
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2016, http://www.itboye.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Home\Api;

use Common\Model\CafegameModel;

class CafegameApi extends \Common\Api\Api{
		
	protected function _init(){
		$this->model = new CafegameModel();
	}
	
	public function queryInfo($id){
		$result = $this->model->alias("a ")->join("LEFT JOIN __WXUSER__ as w on w.id = a.uid")->where(array("a.uid"=>$id))->select();
		if($result === false){
			return $this->apiReturnErr($this->model->getDbError());
		}
		
		return $this->apiReturnSuc($result);
	}

	
}
