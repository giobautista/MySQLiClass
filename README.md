# MySQLiClass
Basic PHP MySQLi class to handle common database queries and operations

## Usage
Include and call the class

```php
require_once ('class.php');
$i = new MySQLiDB;
```

### Select
```php
$column = array('id', 'title', 'content', 'dt');

$where = array(
      'id' => $id,
      );

$result = $new->select($column, 'blog', $where, $limit);

if(!$result->num_rows > 0) {
  header('location: index.php');
}
```

### Insert
```php
$title = $new->sanitize($_POST['title']);
$content = $new->sanitize($_POST['content']);

$data = array(
        'title' => $title,
        'content' => $content,
        );

$insert = $new->insert('blog', $data);
```

### Update
```php
$title = $new->sanitize($_POST['title']);
$content = $new->sanitize($_POST['content']);

$data = array(
      'title' => $title,
      'content' => $content,
      );

$where = array(
      'id' => '22',
      );

$update = $new->update('blog', $data, $where);
```

### Delete
```php
$where = array(
      'id' => $id,
      );

$delete = $new->delete('blog', $where);
```

### If exist
```php
$check = array(
      'first_name' => 'John',
      'last_name' => 'Doe'
      );

$column = array('id', 'first_name', 'last_name');

$exists = $new->exists('table', $column, $check);
```
