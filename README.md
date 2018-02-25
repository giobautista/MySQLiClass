# MySQLiClass
Basic PHP MySQLi class to handle common database queries and operations

## Usage
Include and call the class

```php
require_once ('class.php');
$run = new MySQLiDB;
```

### Get
```php
$cols = array('last_name', 'first_name');

$results = $run->get('users', $cols, 'last_name', 'ASC');

foreach ($results as $result){
		echo $result->last_name, ', ',$result->first_name,'<br>';
}
```

### Select
```php
$column = array('id', 'title', 'content', 'dt');

$where = array(
      'id' => $id,
      );

$result = $run->select($column, 'blog', $where, $limit);

if(!$result->num_rows > 0) {
  header('location: index.php');
}
```

### Insert
```php
$title = $run->sanitize($_POST['title']);
$content = $run->sanitize($_POST['content']);

$data = array(
        'title' => $title,
        'content' => $content,
        );

$insert = $run->insert('blog', $data);
```

### Update
```php
$title = $run->sanitize($_POST['title']);
$content = $run->sanitize($_POST['content']);

$data = array(
      'title' => $title,
      'content' => $content,
      );

$where = array(
      'id' => '22',
      );

$update = $run->update('blog', $data, $where);
```

### Delete
```php
$where = array(
      'id' => $id,
      );

$delete = $run->delete('blog', $where);
```

### If exist
```php
$check = array(
      'first_name' => 'John',
      'last_name' => 'Doe'
      );

$column = array('id', 'first_name', 'last_name');

$exists = $run->exists('table', $column, $check);
```
