<?php
/**
 * 默认控制器，方法里面代码可以删除
 */
namespace app\index\controller;
use \miniPHP\library\character\chinesePinyin;
class index {
	public function index(){
		 $title="miniPHP V1";
		 $describe="初心不改 - 你值得信赖的PHP框架";
		 $character=new chinesePinyin;
		 $res=(new chinesePinyin)->TransformWithoutTone('你好');
		 include view();
	}
}