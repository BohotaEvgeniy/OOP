<?php
session_start();
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
    public $resultQueryDB;
    public $resultCreature; // сыойство для проверки на пустоту таблицы

    public function __construct($host, $login, $password, $dbName) // Конструктор подключения к БД
    {
        $this->dbHost = $host;
        $this->dbLogin = $login;
        $this->dbPassword = $password;
        $this->dbName = $dbName;

        $this->link = mysqli_connect($this->dbHost, $this->dbLogin, $this->dbPassword, $this->dbName);
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

    public function checkContentDBTable($nameTable) // проверка на существование содержимого БД;
    {
        $result = mysqli_query($this->link,"SELECT * FROM $nameTable  LIMIT 1");
        $this->resultCreature = $result->num_rows;
    }
    public function selectWithDB($with,$nameRow,$what)  // метод выборки БД
    {
       return mysqli_query($this->link, "SELECT * FROM $with WHERE `$nameRow` LIKE '$what%'");
    }
    public function selectAllWithDB($with)  // метод выборки БД
    {
       return mysqli_query($this->link, "SELECT * FROM $with WHERE 1");
    }
    public function clearTableDB($with)  // чистка таблицы в БД
    {
        mysqli_query($this->link, "DELETE FROM $with WHERE 1");
    }
    public function clearCityDB($with,$what)  // чистка города в БД
    {
        mysqli_query($this->link,"DELETE FROM $with WHERE name='$what'");
    }
    public function includeInDB($nameTable,$nameRow,$value) // метод вставки в БД
    {
         mysqli_query($this->link, "INSERT INTO `$nameTable` (`$nameRow`) VALUE ('$value')");
    }
    public function sortOut($array) // вывод mysqli_query результата в масси
    {
            //Отображение результата в виде массива
            while ($row = mysqli_fetch_assoc($array)) { // заносим в массив БД
                $result[] = $row['name'];
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
            echo "Файл не существует или отсутствует или неправильное название";
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
        return preg_match('/^[а-яА-Я-]/i', $data);
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
}

$objDb = new DataBase('localhost','root','','cities');
$objFile = new FileManager('city.txt');
$objGame = new Game();

if ($_SESSION['checkUser'] == 'PC'){ // если чекнут ПК
    $objFile->getArrayFile(); // получаем массив
    $objDb->checkContentDBTable('city'); // проверяем содержимое
    if(!$objDb->resultCreature) { // если таблица пуста
        foreach ($objFile->arrFile as $value) {
            $value = mb_strtolower($value,'UTF-8');
            $objDb->includeInDB('city','name',$value); // заполняем таблицу
        }
    }
    $data = $_POST;
    if ( isset($data['submit']) ) {

        $errors = array();
        if (!$objGame->pregMatch($data['cityEntered'])) {
            $errors[] = "Ты ввел символы латиницей или числа со знаками,а это недопустимо.Только кириллица!!!";
        } elseif (empty($data['cityEntered'])){
            $errors[] = "Ты ввел пустую строку,а это недопустимо!!! ";
        }

        if (empty($errors)) {
            $city = $objGame->mbStrLower($data['cityEntered']); // конвертируем в нижний регист
            $firstLetterC = $objGame->mbSubStr($city,0,1); // срез первого символа
            $lastLetterC = $objGame->mbSubStr($city,-1,1); // срез второго символа
            $cityCreature = $objDb->selectWithDB('city','name',$city); // проверка на присутствие города в таблице
            $creatureCityWas = $objDb->selectWithDB('cityWas','name',$city); // проверка на присутствие города в таблице,который был

            if($objGame->pregMatchSymbols($lastLetterC)){ // проверка на последний символ
                $lastLetterC = $objGame->mbSubStr($city,-2,1); // срезаем предпоследний символ
            }

            if ($cityCreature->num_rows) { // проверка на существование города в таблице
                if ($firstLetterC == $_SESSION['letter']) { // проверка на первый и последний символ города
                    if (!$creatureCityWas->num_rows) { // проверка на существование города в таблице городов которые были

                        $objDb->includeInDB('cityWas', 'name', $city); // записываем в таблицу городов которые были
                        $objDb->clearCityDB('city',$city); // удаляем город с основной таблицы городов
                        $arrayFirstLetter = $objDb->selectWithDB('city','name',$lastLetterC); // достаем все города на последний символ
                        $response = $objDb->sortOut($arrayFirstLetter);  // выводим в массив
                        if (!empty($response)) { // проверяем массив
                            $randCity = $response[0]; // выводим первый город массива
                            $_SESSION['towns'][$_SESSION['amount']++] = $randCity;
                            $_SESSION['city'] = $randCity; // записываем город в сессию
                            $lastLetter = $objGame->mbSubStr($randCity,-1,1);
                            $_SESSION['letter'] = $lastLetter;
                            $objDb->clearCityDB('city',$randCity);
                            $objDb->includeInDB('cityWas', 'name', $randCity);
                        } else {
                            echo 'PC game over';
                            $cityCopyBd = $objDb->selectAllWithDB('cityWas');
                            $objDb->clearTableDB('cityWas');
                            while ($arrCopyDb = mysqli_fetch_object($cityCopyBd)) {
                                $reply = mb_strtolower($arrCopyDb->name,'UTF-8');
                                $objDb->includeInDB('city','name',$reply);
                            }
                        }

                    }   else {
                        $replyErr = "Такой город уже был!!!";
                        if ($_SESSION['count'] == 1){
                            $cityCopyBd = $objDb->selectAllWithDB('cityWas');
                            $objDb->clearTableDB('cityWas');
                            while ($arrCopyDb = mysqli_fetch_object($cityCopyBd)) {
                                $reply = mb_strtolower($arrCopyDb->name,'UTF-8');
                                $objDb->includeInDB('city','name',$reply);
                            }
                            $_SESSION['count'] = 0;
                            $error = 'Достаточно,у тебя был шанс.Ты проиграл!!!';
                        }  else {
                            $_SESSION['count']++;
                            $error = "Попробуй еще разок";
                        }
                    }
                } else {
                    $replyErr = 'Твой город начинается не на последнюю букву моего города!!!';
                    if ($_SESSION['count'] == 1){
                        $cityCopyBd = $objDb->selectAllWithDB('cityWas');
                        $objDb->clearTableDB('cityWas');
                        while ($arrCopyDb = mysqli_fetch_object($cityCopyBd)) {
                            $reply = mb_strtolower($arrCopyDb->name,'UTF-8');
                            $objDb->includeInDB('city','name',$reply);
                        }
                        $_SESSION['count'] = 0;
                        $error = 'Достаточно,у тебя был шанс.Ты проиграл!!!';
                    }  else {
                        $_SESSION['count']++;
                        $error = "Попробуй еще разок";
                    }
                }
            } else {
                $replyErr = 'Такого города не существует!!!';
                if ($_SESSION['count'] == 1){
                    $cityCopyBd = $objDb->selectAllWithDB('cityWas');
                    $objDb->clearTableDB('cityWas');
                    while ($arrCopyDb = mysqli_fetch_object($cityCopyBd)) {
                        $reply = mb_strtolower($arrCopyDb->name,'UTF-8');
                        $objDb->includeInDB('city','name',$reply);
                    }
                    $_SESSION['count'] = 0;
                    $error = 'Достаточно,у тебя был шанс.Ты проиграл!!!';
                }  else {
                    $_SESSION['count']++;
                    $error = "Попробуй еще разок";
                }
            }

        } else {
            $replyErr = '<div>' . array_shift($errors) . '</div>';
            if ($_SESSION['count'] == 1){
                $cityCopyBd = $objDb->selectAllWithDB('cityWas');
                $objDb->clearTableDB('cityWas');
                while ($arrCopyDb = mysqli_fetch_object($cityCopyBd)) {
                    $reply = mb_strtolower($arrCopyDb->name,'UTF-8');
                    $objDb->includeInDB('city','name',$reply);
                }
                $_SESSION['count'] = 0;
                $error = 'Достаточно,у тебя был шанс.Ты проиграл!!!';
            }  else {
                $_SESSION['count']++;
                $error = "Попробуй еще разок";
            }
        }

    } else {

        $amountCities = count($objFile->arrFile); // количество городов(элементов массива)
        $randCity = $objFile->arrFile[rand(0, $amountCities)];  // рандомный элемент массива с городами
        $objDb->clearCityDB('city',$randCity);  // удаляем город с таблицы в БД

        $lastLetterC = $objGame->mbSubStr($randCity,-1,1); // срезаем символ
        if($objGame->pregMatchSymbols($lastLetterC)){ // проверка на последний символ
            $lastLetterC = $objGame->mbSubStr($randCity,-2,1); // срезаем предпоследний символ
        }
        $objDb->includeInDB('cityWas', 'name', $randCity ); // заносим в таблицу городов,которые уже были
        $_SESSION['towns'][$_SESSION['amount']++] = $randCity;
        $_SESSION['city'] = $randCity; // записываем город в сессию,на вывод в форму
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
            $result = $objDb->sortOut($objDb->selectAllWithDB('cityWas'));
            if (!empty($result)) {
                foreach ($result as $v) {
                    echo $v . "<br>";
                }
            }
        ?>
        </div>
    </div>
</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>


