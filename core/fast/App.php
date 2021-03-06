<?php
// +----------------------------------------------------------------------
// | 核心目录
// +----------------------------------------------------------------------
// | Blog http://blog.skyczk.cn/
// +----------------------------------------------------------------------
// | Author: 陈政宽 <kuan9531@skyczk.cn>
// +----------------------------------------------------------------------
namespace core\fast;
use core\fast\Conf;

class App 
{
	public static $classArray =[];
	public function __construct()
	{
		# code...
	}
	public static function run( ){ 
    	include APP_PATH.'/vendor/autoload.php';
		spl_autoload_register('self::loadClass');
		self::setReporting();
		//加载路由类 自己手写路由类
		// new \core\fast\route();
		//使用了noahbuscher/macaw 加载路由
		require APP_PATH. '/' . APP.'Routs.php';
	}
	//自动加载
	public static function loadClass($className){
		if(isset(self::$classArray[$className])){
			return true;
		}else {
			 	$class = APP_PATH . '/'.str_replace('\\', '/', $className) . '.php';
				if(is_file($class)){
				include $class;
				self::$classArray[$className] = $className;
				}else{
					return false;
				}
		}
	}

	// 检测开发环境
    public static function setReporting()
    {
        if (APP_DEBUG === true) {
        	$whoops = new \Whoops\Run;
			$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
			$whoops->register();
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
        }
    }
}