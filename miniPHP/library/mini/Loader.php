<?php
namespace mini;
class 	Loader{

    public static function autoload($class){
        var_dump(self::$namespaceAlias);die;
         // 检测命名空间别名
        if (!empty(self::$namespaceAlias)) {
            $namespace = dirname($class);
            if (isset(self::$namespaceAlias[$namespace])) {
                $original = self::$namespaceAlias[$namespace] . '\\' . basename($class);
                if (class_exists($original)) {
                    return class_alias($original, $class, false);
                }
            }
        }

        if ($file = self::findFile($class)) {
            // 非 Win 环境不严格区分大小写
            if (!IS_WIN || pathinfo($file, PATHINFO_FILENAME) == pathinfo(realpath($file), PATHINFO_FILENAME)) {
                __include_file($file);
                return true;
            }
        }

        return false;
    }
	/**
     * 注册自动加载机制
     * @access public
     * @param  callable $autoload 自动加载处理方法
     * @return void
     */
    public static function register()
    {
        // 注册系统自动加载
        // spl_autoload_register('think\\Loader::autoload', true, true);

        // // Composer 自动加载支持
        // if (is_dir(VENDOR_PATH . 'composer')) {
        //     if (PHP_VERSION_ID >= 50600 && is_file(VENDOR_PATH . 'composer' . DS . 'autoload_static.php')) {
        //         require VENDOR_PATH . 'composer' . DS . 'autoload_static.php';

        //         $declaredClass = get_declared_classes();
        //         $composerClass = array_pop($declaredClass);

        //         foreach (['prefixLengthsPsr4', 'prefixDirsPsr4', 'fallbackDirsPsr4', 'prefixesPsr0', 'fallbackDirsPsr0', 'classMap', 'files'] as $attr) {
        //             if (property_exists($composerClass, $attr)) {
        //                 self::${$attr} = $composerClass::${$attr};
        //             }
        //         }
        //     } else {
        //         self::registerComposerLoader();
        //     }
        // }

        // // 注册命名空间定义
        // self::addNamespace([
        //     'think'    => LIB_PATH . 'think' . DS,
        //     'behavior' => LIB_PATH . 'behavior' . DS,
        //     'traits'   => LIB_PATH . 'traits' . DS,
        // ]);

        // // 加载类库映射文件
        // if (is_file(RUNTIME_PATH . 'classmap' . EXT)) {
        //     self::addClassMap(__include_file(RUNTIME_PATH . 'classmap' . EXT));
        // }

        // self::loadComposerAutoloadFiles();

        // // 自动加载 extend 目录
        // self::$fallbackDirsPsr4[] = rtrim(EXTEND_PATH, DS);
    }
}
