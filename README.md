## Usage

### 初始化
```php
function wprs_init_session(){
    $wp_session_handler = \Wenprise\SessionManager\Manager::initialize();
    
    // 默认使用数据库 Handler
    $wp_session_handler->addHandler( new \Wenprise\SessionManager\Handlers\DatabaseHandlerAbstract() );
    
    // 如果使用了对象缓存，设置对象缓存为 Handler
    if ( wp_using_ext_object_cache() ) {
        $wp_session_handler->addHandler( new \Wenprise\SessionManager\Handlers\CacheHandlerAbstract() );
    }
    
    // 创建 Session 数据表
    DatabaseHandler::createTable();
    
    // 初始化 Session
    new \WenpriseSecurity\Deps\Wenprise\SessionManager\Init();
}


add_action('plugins_loaded', fucntion(){
    wprs_init_session();
});

```


## 使用方法
```php
$_SESSION['example_key'] = 'ABC123';

print_r($_SESSION['example_key']); // will print "ABC123"
```