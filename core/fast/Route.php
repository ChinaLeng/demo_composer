<?php
// +----------------------------------------------------------------------
// | 路由处理
// +----------------------------------------------------------------------
// | Blog http://blog.skyczk.cn/
// +----------------------------------------------------------------------
// | Author: 陈政宽 <kuan9531@skyczk.cn>
// +----------------------------------------------------------------------
namespace core\fast;
use core\fast\Conf;

class Route 
{
	public  $moduleName;
	public  $controllerName;
	public  $actionName;
	public function __construct(){
		/**
		解析路由
		**/
		if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/'){
			$url = $_SERVER['REQUEST_URI'];
			//去掉?后面的值
			$newurl = strpos($url, '?');
			$url = $newurl === false?$url:substr($url,0,$newurl);
			// debug($url);die;
			//链接是否存在index.php
			$newurl = strpos($url, 'index.php');
			if($newurl !== false){
				$url = substr($url,$newurl+strlen('index.php'));
			}
			//分割字符
			$path = explode('/',trim($url,'/'));
			//去除空的数组
			$pathArray = array_filter($path);
			if(count($pathArray) == 3){
				$this->moduleName = strtolower($pathArray[0]);
				array_shift($pathArray);
			}else{
				$this->moduleName = Conf::get('default_module');
			}
			//获取控制器名  把首字符大写
			$this->controllerName = ucfirst(strtolower($pathArray?$pathArray[0]:Conf::get('default_controller')));
			//删除第一个控制名
			array_shift($pathArray);
			//获取方法如果无则用默认的
			$this->actionName = $pathArray?$pathArray[0]:Conf::get('default_action');
		}else{
			$this->moduleName     = Conf::get('default_module');
			$this->controllerName = Conf::get('default_controller');
			$this->actionName     = Conf::get('default_action');
		}
		$ctrlClass = str_replace('/', '\\', APP.'controllers\\'. $this->moduleName .'\\' .$this->controllerName);
		//是否存在控制器
		if(class_exists($ctrlClass)){
			$file = new $ctrlClass();
			//是否存在方法
			if(method_exists($ctrlClass,$this->actionName)){
				$action = $this->actionName;
				$file->$action();
			}else{
				throw new \Exception("这个方法不存在".$this->actionName);
			}

		}else{
			throw new \Exception("没有这个控制器".$this->controllerName);
			
		}
	}


}
	
