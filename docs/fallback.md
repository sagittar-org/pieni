## フォールバック
フォールバックはファイルの検索パスであり2次ジャグ配列の直積で表す。

### コントローラ
require_once fallback([g('packages'), ['controllers'], [ucfirst($class).'.php', 'crud.php']]);

### ビュー
require fallback([g('packages'), ['views'], [$class, 'crud', ''], ["{$name}.php"]]);

### ヘルパー
require_once fallback([g('packages'), ['helpers'], ["{$name}.php"]]);

### クラス
require_once fallback([g('packages'), ['src'], ["{$class}.php"]]);
