<?php
function view($tpl = NULL){
		if(is_null($tpl)){
			$path = APP_TPL_PATH . '/' . ACTION . '/' . METHOD . '.php';
		}else{//用户自己传递
			//获得后缀
			$type = ltrim(strrchr($tpl, '.'),'.');
			//如果后缀为空 默认为.html后缀
			if(empty($type)) $tpl .= '.php';
			$path = APP_TPL_PATH . '/' . ACTION . '/' . $tpl;
		}
		if(!is_file($path)) echo('模板：' . $path . '未找到！):');
		return $path;
		
	}
function config($str){
	$path=CONFIG_PATH;
	$str=explode('.',$str);
	$name='';
	foreach($str as $k=>$v){
		$nesstr=$path.'/'.$v;
		if(is_dir($nesstr)){
			$path=$nesstr;
		}else{
			if(is_file($nesstr.'.php')){
				$path= $nesstr.'.php';
				if($str[$k+1]){
					$name=$str[$k+1];
				}
			}
		}
	}
	$content=include($path);
	if($name){
		return $content[$name];
	}else{
		return $content;
	}
}
function upload($path){
	//重组数组
	$arr = reset_arr();
	//上传
	move_upload($path,$arr);

}
/**
 * [move_upload 上传]
 * @param  [type] $path [description]
 * @param  [type] $arr  [description]
 * @return [type]       [description]
 */
function move_upload($path,$arr){
	foreach ($arr as $v) {
		if(is_uploaded_file($v['tmp_name'])){
			//取得扩展名
			$info = pathinfo($v['name']);
			$type = $info['extension'];
			$filename = time() . mt_rand(0,9999) . '.' . $type;
			//处理上传路径
			$path = change_path($path);
			is_dir($path) || mkdir($path,0777,true);
			//完整路径
			$fullPath = $path . '/' . $filename;
			move_uploaded_file($v['tmp_name'],$fullPath);
			//取得扩展名, destination)
		}
	}
}
function reset_arr(){
	$temp = array();
	foreach ($_FILES as $v) {
		//$v里面的name是数组则是多张上传
		if(is_array($v['name'])){
			foreach ($v['name'] as $key => $value) {
				$temp[] = array(
					'name'	    =>	$value,
					'type'	    =>	$v['type'][$key],
					'tmp_name'	=>	$v['tmp_name'][$key],
					'error'	    =>	$v['error'][$key],
					'size'	    =>	$v['size'][$key],
					);
			}
		}else{//单张上传
			$temp[] = $v;
		}
	}

	return $temp;
}
?>