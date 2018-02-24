# MySQLiClass
Basic PHP MySQLi class to handle common database queries and operations

## Usage

### Select
```
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
```
$title = $new->sanitize($_POST['title']);
$content = $new->sanitize($_POST['content']);

$data = array(
        'title' => $title,
        'content' => $content,
        );

$insert = $new->insert('blog', $data);
```

### Update
```
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

### Delete
$where = array(
      'id' => $id,
      );

$delete = $new->delete('blog', $where);
```

### If exist
```
$check = array(
      'first_name' => 'John',
      'last_name' => 'Doe'
      );

$column = array('id', 'first_name', 'last_name');

$exists = $new->exists('table', $column, $check);
```
