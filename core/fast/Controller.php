<?php
// +----------------------------------------------------------------------
// | 控制器基类
// +----------------------------------------------------------------------
// | Blog http://blog.skyczk.cn/
// +----------------------------------------------------------------------
// | Author: 陈政宽 <kuan9531@skyczk.cn>
// +----------------------------------------------------------------------
namespace core\fast;

class Controller extends View
{
/*	public  $_module;
	public  $_controller;
	public  $_action;*/
	//new View的时候传入默认的视图
/*	public function __construct($module='',$controller='',$action='')
	{
		//加载DB类
		new \core\fast\Db();
		$this->_module     = $module;
		$this->_controller = $controller;
		$this->_action     = $action;
		new View($module,$controller,$action);
	}*/
		public function __construct()
	{
		//加载DB类
		new \core\fast\Db();
		parent::__construct();
	}
}