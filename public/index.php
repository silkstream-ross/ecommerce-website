<?php
//mysqli_report(MYSQLI_REPORT_ALL);
$mysqli = new mysqli("ecommerce_website_database", "dev_database", "dev_database", "dev_database");

echo $mysqli->host_info . "\n";

//mysqli_query($mysqli, "INSERT INTO categories(name, description) VALUES('Playstation 5', 'Games for the Playstation 5')");
$statement = $mysqli->prepare("SELECT category_id, name, description FROM categories");
//var_dump($statement2);
$statement->execute();
//$addPs5->execute();
$statement->bind_result($category_id, $name, $description);
//$statement->fetch();
//var_dump($category_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
</head>

<body>

<h1>Home</h1>

<table>
    <thead>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>description</th>
    </tr>
    </thead>
    <tbody>
    <?php while($statement->fetch()): ?>
    <tr>
        <td><?=$category_id?></td>
        <td><?=$name?></td>
        <td><?=$description?></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>



</body>
</html>