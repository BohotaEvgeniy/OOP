<?php

session_start();
$_SESSION['cities'];
$_SESSION['city'];
$_SESSION['letter'];

?>

<?php
/**
Создать базу городов. Далее участвуют человек и компьютер. Необходимо назвать город, дальше получаем ответ от компьютера с вероятностью в 97.4% название города, чьё название начинается на последнюю букву названного игроком города.
Имена не могут повторяться..
Если вы ввели город, который уже назывался то нужно в ответ вернуть сообщение «Вы проиграли, такой город уже был».

Список городов прикреплен в текстовом файле, вам нужно написать класс, которые считает этот файл, и заполнит таблицу в БД.
Класс Game будет использовать уже таблицу с городами.

Реализовать в ООП стиле. Города нужно хранить в таблице в БД.
Конечный вариант немного упростить.
Финальный вид будет такой:
$game = new Game();
$game->say(‘Днепр’); // вы говорите компьютеру город.
echo $game->answer(); //компьютер в ответ говорит город, который начинается на букву Р.

 */

class DataBase
{
    private $dbHost, $dbLogin, $dbPassword, $dbName; // свойства по БД
    public $link;
    public $resultCreature; // сыойство для проверки на пустоту таблицы

    public function __construct($host, $login, $password) // Конструктор подключения к БД
    {
        $this->dbHost = $host;
        $this->dbLogin = $login;
        $this->dbPassword = $password;

        $this->link = mysqli_connect($this->dbHost, $this->dbLogin, $this->dbPassword);
        $this->createDB();
        $this->connectTable();
        $this->createTable();
        if (!$this->link) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }

    public function __destruct() // Закрытие БД
    {
        mysqli_close($this->link);
    }
    private function createDB() // создание БД
    {
        mysqli_query($this->link, "CREATE DATABASE db_name");
    }
    public function connectTable() // Соединение с таблицей
    {
        mysqli_select_db($this->link,'db_name');
    }
    private function createTable() // создание таблицы
    {
        mysqli_query($this->link, "CREATE Table city (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL)");
    }
    public function checkContentDBTable($nameTable) // проверка на существование содержимого БД;
    {
        $result = mysqli_query($this->link,"SELECT id FROM $nameTable  LIMIT 1");
        return $result;
    }
    public function selectCountInSideTable() // метод выборки количества городов в таблице
    {
        return mysqli_query($this->link, "SELECT id FROM city WHERE 1");
    }
    public function selectRandCity($randNumber) // метод выборки рандомного города и его id
    {
        return mysqli_query($this->link, "SELECT id, name FROM city WHERE id = '$randNumber'");
    }
    public function selectIDWithDb($cityName)  // метод выборки id
    {
        return mysqli_query($this->link, "SELECT id, name FROM city WHERE name = '$cityName'");
    }
    public function selectWithDB($with,$nameRow,$what)  // метод выборки БД
    {
        return mysqli_query($this->link, "SELECT id, name FROM $with WHERE `$nameRow` LIKE '$what%'");
    }
    public function includeInDB($nameTable,$nameRow,$value) // метод вставки в БД
    {
        mysqli_query($this->link, "INSERT INTO `$nameTable` (`$nameRow`) VALUE ('$value')");
    }
    public function sortObj($str) // вывод mysqli_query результата в массиd
    {
        //Отображение результата в виде массива
        while ($row = mysqli_fetch_object($str)) {
            $result = $row;
        }
        return $result;
    }

}

class FileManager {
    public $handle; // свойство fopen
    public $arrFile; // свойство массив городов
    public $fName; // свойство путь к имени файла

    public function __construct($file) // конструктор открытия файла
    {

        if(!fopen($file,'r')){
            echo "Файл не существует или отсутствует или не правильное название";
        } else {
            $this->handle = fopen($file,'r');
            $this->fName = $file;
        }
    }
    public function __destruct() // деструктор закрытия файла
    {
        fclose($this->handle);
    }
    public function getArrayFile() // считываем содержимое файла в массив в нижнем регистре
    {
        $result = file($this->fName);
        foreach ($result as $key => $value) {
            $this->arrFile[$key] = trim(mb_strtolower($value,'UTF-8'));
        }
    }
}

class Game
{
    public function pregMatch($data) // метод проверки диапазона символов
    {
        return preg_match('/^[а-яА-ЯЧч-]{3,}/i', $data);
    }
    public function pregMatchSymbols($data) // метод проверки последнего символа
    {
        $arraySymbols = array('й','ё','ь','ъ','э');
        foreach ($arraySymbols as $v){
            if ($data == $v){
                return true;
            }
        }
    }
    public function mbStrLower($data) // метод нижнего регистра
    {
        return mb_strtolower($data,'UTF-8');
    }
    public function mbSubStr($data,$start,$length) // метод среза символа с кодировкой
    {
        return mb_substr($data,$start,$length,'UTF-8');
    }
    public function checkCities($idCity)
    {
        $result = false;
        foreach($_SESSION['cities'] as $key => $value) {
            if ($key == $idCity){
                $result = true;
            }
        }
        return $result;
    }
    public function checkCitiesWas($city)
    {
        foreach($_SESSION['cities'] as $value) {
            if ($value == $city){
                $result = true;
            }
        }
        return $result;
    }
    public function getRemark($fault)
    {
        if ($_SESSION['count'] == 1){
            $_SESSION['count'] = 0;
            $error = 'Достаточно,у тебя был шанс.Ты проиграл!!!';
            $_SESSION['cities'] = array();
            $_SESSION['city'] = '';
        }  else {
            $_SESSION['count']++;
            $error = "Попробуй еще разок";
        }
        return $error;
    }
}

$objDb = new DataBase('localhost','root','');
$objFile = new FileManager('city.txt');
$objGame = new Game();

if ($_SESSION['checkUser'] == 'PC'){ // проверяем если чекнут первым ПК
    $objFile->getArrayFile(); // выборка городов из файла в массив
    $resultCreature = $objDb->checkContentDBTable('city'); // запрос в БД на существование содержимого
    if(!$resultCreature->num_rows) { // проверяем пустой обьект или нет
        foreach ($objFile->arrFile as $value) { // пробегаем по свойству(массив) и вытягиваем значения массива
            $val = mb_strtolower($value,'UTF-8'); // заносим значения в нижнем регистра и кодировкой UTF-8
            $objDb->includeInDB('city','name',$val); // наполняем таблицу в БД
        }
    }
    $data = $_POST; // заносим метод POST в переменную
    if (isset($data['submit']) ) { // проверяем была ли определена переменная( Кликнута кнопка )

        $errors = array(); // массив ошибок
        if  (empty($data['cityEntered'])){ // проверка на пустую строку
            $errors[] = "Ты ввел пустую строку,а это недопустимо!!! "; // заносим строку в массив ошибок
        } elseif (!$objGame->pregMatch($data['cityEntered'])) { // проверяем на доступные символы
            $errors[] = "Ты ввел символы латиницей или числа со знаками,или недопустимое колличество символов,а это недопустимо.Только кириллица и не меньше 3-х символов!!!"; // заносим строку в массив ошибок
            $errors[] = "Города Украины не могут начинаться на Ы,Ь,Ъ,Ё,Й"; // заносим строку в массив ошибок
        }

        if (empty($errors)) { // проверяем пустой ли массив ошибок
            $city = $objGame->mbStrLower($data['cityEntered']); // конвертируем в нижний регист
            $firstLetterC = $objGame->mbSubStr($city,0,1); // срез первого символа
            $lastLetterC = $objGame->mbSubStr($city,-1,1); // срез второго символа
            $response = in_array($city,$objFile->arrFile); // проверка на присутствие города в массиве
            $creatureCityWas = $objGame->checkCitiesWas($city); // проверка на присутствие города в таблице,который был
            if($objGame->pregMatchSymbols($lastLetterC)){ // проверка на последний символ
                $lastLetterC = $objGame->mbSubStr($city,-2,1); // срезаем предпоследний символ
            }

            if ($response) { // проверка на существование города в таблице
                if ($firstLetterC == $_SESSION['letter']) { // проверка на первый и последний символ города
                    if (!$creatureCityWas) { // проверка на существование города в ctccbb городов которые были
                        $idNameObj = $objDb->sortObj($objDb->selectIDWithDb($city));
                        $_SESSION['cities'][$idNameObj->id] = $idNameObj->name;
                        $arrayFirstLetter = $objDb->selectWithDB('city', 'name', $lastLetterC); // достаем все города на последний символ
                        while ($row = mysqli_fetch_assoc($arrayFirstLetter)) {  // заносим в массив
                            $result[$row['id']] = $row['name'];
                        }
                        if (!empty($result)) { // проверяем массив
                            $res = array_diff($result,$_SESSION['cities']); // смотрим разницу массивов
                            $firstElement = array_shift($res); // вытягиваем первый элемент массива
                            $idNameObj = $objDb->selectIDWithDb($firstElement); // вытягиваем id и город с таблицы
                            while ($row = mysqli_fetch_assoc($idNameObj)) {  // заносим в массив
                                $resultCity = $row;
                            }
                            $_SESSION['cities'][$resultCity['id']] = $resultCity['name'];
                            $_SESSION['city'] = $resultCity['name']; // записываем город в сессию
                            $lastLetter = $objGame->mbSubStr($firstElement,-1,1);
                            $_SESSION['letter'] = $lastLetter;
                        } else {
                            echo 'PC game over';
                            $_SESSION['cities'] = array();
                        }

                    }   else {
                        $replyErr = "Такой город уже был!!!";
                        $error = $objGame->getRemark($_SESSION['count']);
                    }
                } else {
                    $replyErr = 'Твой город начинается не на последнюю букву моего города!!!';
                    $error = $objGame->getRemark($_SESSION['count']);
                }
            } else {
                $replyErr = 'Такого города не существует!!!';
                $error = $objGame->getRemark($_SESSION['count']);
            }

        } else {
            $replyErr = '<div>' . array_shift($errors) . '</div>';
            $error =  $error = "Введи корректные данные!";
        }

    } else {
        $amountCities = $objDb->selectCountInSideTable();
        $randomNumber = rand(0, $amountCities->num_rows); // рандомное число
        $randCity = $objDb->selectRandCity($randomNumber); // Выборка с таблицы города по рандомному id(число) таблицы
        $cityObj = $objDb->sortObj($randCity); // вытягиваем обьект таблицы(id,city)
        $lastLetterC = $objGame->mbSubStr($cityObj->name,-1,1); // срезаем символ
        if($objGame->pregMatchSymbols($lastLetterC)){ // проверка на последний символ
            $lastLetterC = $objGame->mbSubStr($cityObj->name,-2,1); // срезаем предпоследний символ
        }
        $_SESSION['cities'][$cityObj->id] = $cityObj->name; // записываем id и name в массив Сессии
        $_SESSION['city'] = $cityObj->name; // записываем город в сессию,на вывод в форму
        $_SESSION['letter'] = $lastLetterC; // записываем последний символ символ на проверку городов
        $_SESSION['count'] = 0; // ставим счетчик
    }

}




?>

<!--------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Your page title here :)</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <style>
        body{
            text-align: center;
        }
    </style>

</head>
<body>

<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="container">
    <div class="row">
        <div class="twelve columns">
            <? echo $replyErr .'<br>'.$error;?>
        </div>
    </div>
    <div class="row">
        <div class="one-half column" style="margin-top: 25%">
            <form action="" method="post">
                <label for="">Play game?</label>
                <input type="text" autofocus name="cityEntered">
                <input type="submit" name="submit" value="Play">
            </form>
        </div>
        <div class="one-half column" style="margin-top: 25%">
            <form action="" method="get">
                <label for="">My city is</label>
                <input type="text" name="reply" readonly value="<? echo $_SESSION['city'] ;?>">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            Города которые были: <br>
            <?
            foreach($_SESSION['cities'] as $value) {
                echo $value . "<br>";
            }
            ?>
        </div>
    </div>
</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>


