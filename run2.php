<?php
header("Content-Type: text/html; charset=UTF-8");
setlocale(LC_ALL, "ru_RU.UTF-8");

$back = "<p><a href=\"javascript: history.back()\">Вернуться назад</a></p>";

/*подключимся к БД*/
    function query ($sql, $DBlink) /*выполняет sql-запрос*/
    {
        if(!$DBlink->query($sql))
            echo "<p><font color='#ff1493' size='20pt'>ERROR</font>$DBlink->error</p>";
    }

    $conn = new mysqli("localhost","igor_igo4ek","123456","igor_database1");
    if($conn->error)
    {
        echo "<p><font color='#ff1493' size='20pt'>Ошибка при подключении БД: </font>$DBlink->error</p>";
    }
    else echo "<p>Подключение к БД успешно!</p>";


/*Для вывода информации на странице php*/
    $name        = $_POST['name'];
    $mail        = $_POST['mail'];
    $phone       = $_POST['phone'];
    $isErrorFile = $_FILES['uploadedFile']['error'];
    $fileName    = $_FILES['uploadedFile']['name'];
    $fileSize    = $_FILES['uploadedFile']['size'];
    $message     = $_POST['message'];


/*Для проверки на валидность полученных значений*/
    $patterns=array(
        '/^((([А-ЯЁ]{1}[а-яё]{1,13}\s{0,1}){1,5})|(([A-Z]{1}[a-z]{1,13}\s{0,1}){1,5}))$/u',  //for FIO
		'/^[\w-\.]+@[\w-]+\.[a-z]{2,4}$/i', //for e-mail
		'/^[+]{0,1}\d[\d\(\)\ -]{5,15}\d$/'); //for phone

    $isError=false; /*TRUE если не прошли проверку на валидность*/

/*Проверка на валидность +  информация об ошибках*/
    if(!preg_match($patterns[0],$name))
    {
        $name = "<font color='red'>Некорректно введены ФИО. Попробуйте ещё раз</font>";
        $isError=true;
    };
    if(!preg_match($patterns[1],$mail))
    {
        $mail = "<font color='red'>Некорректно введен E-mail. Попробуйте ещё раз</font>";
        $isError=true;
    };
    if(!preg_match($patterns[2],$phone))
    {
        $phone = "<font color='red'>Некорректно введен Номер телефона. </font>";
        $isError=true;
    };
    if($isErrorFile)
    {
        $file = "<font color='black'>Файл не загружен. </font>";
    }
    else
    {
        $file = "<font color='black'> $fileName ($fileSize байт) </font>";
    }
    if($message=="")$message="Пусто.";

/*Сохраним информацию в БД*/
    if(!$isError) /*все данные валидны*/
    {
        $sql = "INSERT INTO peoples(name, phone, mail, fileName, fileSize, message)
                values('$name', '$phone', '$mail', '$fileName', '$fileSize', '$message');";
        query($sql, $conn); /*запускаем запрос*/
    }
    $conn->close();

/* Выводим информацию клиенту*/
    echo "<p>Сервер получил Ваши данные</p>";
    echo "<p>Имя: ".$name."</p>";
    echo "<p>Почта: ".$mail."</p>";
    echo "<p>Телефон: ".$phone."</p>";
    echo "<p>Файл: ".$file." -- "; /*в продолжение этой записи будет -- сохранён ли файл на сервере*/
/* Сохраняем файл на сервер и выводим статус*/
    $tmp_name = $_FILES['uploadedFile']['tmp_name'];
    $upfile = '/home/igor/web/igo4ek.berega.su/public_html/uploads/'.$_FILES['uploadedFile']['name'];
    if(!$isError && move_uploaded_file ($tmp_name, $upfile)) /*если нет ошибки при заполнении полей && файл сохранён*/
       /* echo "Файл успешно сохранён на сервере в папке /uploads</p>";
    else
        echo "Файл не в /uploadedFiles</p>";*/
/* Далее Выводим информацию клиенту*/
    echo "<p>Сообщение: ".$message."</p>";

    if($isError) echo "<p><font color='red'>Попробуйте ещё раз!</font></p>";

/*кнопка возврата*/
    echo $back;

?>