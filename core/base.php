<?php
// +----------------------------------------------------------------------
// | 加载应用
// +----------------------------------------------------------------------
// | Blog http://blog.skyczk.cn/
// +----------------------------------------------------------------------
// | Author: 陈政宽 <kuan9531@skyczk.cn>
// +----------------------------------------------------------------------
define('APP', 'app/');
define('APP_DEBUG', true);
define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀
include CORE.'/common/function.php';
include CORE.'/fast/App.php';
//加载EVN文件配置
if(is_file(APP_PATH.'/.env')){
	$env = parse_ini_file(APP_PATH.'/.env',true);
	    foreach ($env as $key => $val) {
        $name = ENV_PREFIX . strtoupper($key);

        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $item = $name . '_' . strtoupper($k);
                putenv("$item=$v");
            }
        } else {
            putenv("$name=$val");
        }
    }
}
\core\fast\APP::run();