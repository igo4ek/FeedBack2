<?php
/**
 * Created by PhpStorm.
 * User: Игга
 * Date: 27.12.2017
 * Time: 18:53
 */
header("Content-Type: text/html; charset=UTF-8");

function query ($sql, $DBlink)
{
    if($DBlink->query($sql))echo"<p>OK</p>";
    else echo "<p><font color='#ff1493' size='20pt'>ERROR</font>$DBlink->error</p>";
}

$conn = new mysqli("localhost","igor_igo4ek","123456","igor_database1");
if($conn->error)
{
    echo "<p><font color='#ff1493' size='20pt'>Ошибка при подключении БД: </font>$DBlink->error</p>";
}
else echo "Законнектились!";
$sql = "DROP TABLE IF EXISTS peoples;";
query($sql, $conn);
$sql ="CREATE TABLE peoples(
id          INTEGER PRIMARY KEY AUTO_INCREMENT,
name        VARCHAR(100) CHARACTER SET utf8 UNIQUE,
phone       VARCHAR(20),
mail        VARCHAR(100) CHARACTER SET utf8,
fileName    VARCHAR(100) CHARACTER SET utf8,
fileSize    INTEGER ,
message     LONGTEXT CHARACTER SET utf8
)ENGINE innoDB;";
query($sql, $conn);
$conn->close();
