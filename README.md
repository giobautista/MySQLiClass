# MySQLiClass
Basic PHP MySQLi class to handle common database queries and operations

## Usage
Include and call the class

```php
require_once ('class.php');
$run = new MySQLiDB;
```

### runQuery()
```php
$id = $run->sanitize($_POST['id']);

$sqlQuery = "SELECT id, first_name, last_name FROM users WHERE id={$id}";
$result = $run->runQuery($sqlQuery);

if ($result->num_rows > 0 ) {
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
  }
} else {
  echo "0 result";
}
```

### get()
```php
$cols = array('last_name', 'first_name');

$results = $run->get('users', $cols, 'last_name', 'ASC');

foreach ($results as $result){
		echo $result->last_name, ', ',$result->first_name,'<br>';
}
```

### select()
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

### insert()
```php
$title = $run->sanitize($_POST['title']);
$content = $run->sanitize($_POST['content']);

$data = array(
        'title' => $title,
        'content' => $content,
        );

$insert = $run->insert('blog', $data);
```

### update()
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

### delete()
```php
$where = array(
      'id' => $id,
      );

$delete = $run->delete('blog', $where);
```

### exists()
```php
$check = array(
      'first_name' => 'John',
      'last_name' => 'Doe'
      );

$column = array('id', 'first_name', 'last_name');

$exists = $run->exists('table', $column, $check);
```
