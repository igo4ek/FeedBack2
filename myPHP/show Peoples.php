<?php


header("Content-Type: text/html; charset=UTF-8");

/*подключимся к БД*/
$conn = new mysqli("localhost","igor_igo4ek","123456","igor_database1");
if($conn->error)
{
    echo "<p><font color='#ff1493' size='20pt'>Ошибка при подключении БД: </font>$DBlink->error</p>";
}

echo '<title>Список откликнувшихся</title>
<p><font color = #dc143c size = 14pt>Список: </font></p>';



$sql = "SELECT id, name, phone, mail, message FROM peoples;";
$result = $conn->query($sql);
$countCols = $result->field_count;


echo '<style>
      table {
        width: 80%;
        border-collapse: collapse;
        border-radius: 10px;
      }
      th {
      	border:#ccc 1px solid;
	    border-collapse:separate;
        text-align: left;
        padding: 5px;
        background-color: #eaebec;
        color: #666;
      }
      th:hover {
	background-color: snow;
	color: lightseagreen;
}
    </style>';

/* выборка данных и помещение их в массив */
echo'<table >';
while ($row = $result->fetch_row())
{
    echo '<tr>';
    for($i=0;$i<$countCols;$i++)
    {
        echo '<th>'.$row[$i].'</th>';
    }
    /*printf ("%s (%s)\n", $row[0], $row[1]);*/
}
echo '</table>';

$conn->close();


