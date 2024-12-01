## Usage

### 初始化
```php
add_action('plugins_loaded', fucntion(){
   new \WenpriseSecurity\Deps\Wenprise\SessionManager\Init();
});

```


## 使用方法
```php
$_SESSION['example_key'] = 'ABC123';

print_r($_SESSION['example_key']); // will print "ABC123"
```