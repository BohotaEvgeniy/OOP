<?php

class Worker
{

    public $name;  // свойство класса : имя
    public $age;    // свойство класса : возраст
    public $salary; // свойство класса : зарплата

    private function checkAge($ageWorker)   // дополнительный метод : проверка возраста
    {
        if ($ageWorker > 1 && $ageWorker < 100) {
            return $ageWorker;
        }

    }

    public function setAge($age)    //метод : запись возраста
    {
        $this->age = $this->checkAge($age);
    }
}

$human_1 = new Worker();    // экземпляр класса
$human_2 = new Worker();    // экземпляр класса

$human_1->name = 'Иван';    // присвоение имени
$human_1->setAge(1);   // присвоение возраста
$human_1->salary = '1000';  // присвоение зарплаты

$human_2->name = 'Вася';    // присвоение имени
$human_2->setAge(26);   // присвоение возраста
$human_2->salary = '2000';   // присвоение зарплаты

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

</head>
<body>

<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="container">
    <div class="row">
        <div class="one-half column" style="margin-top: 25%">
            <table class="u-full-width">
                <thead>
                <tr>
                    <th>Names</th>
                    <th>Age's common</th>
                    <th>Salary's common</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><? echo $human_1->name . ' / ' . $human_2->name; ?></td>    <!-- вывод имен работников -->
                    <td><? echo $human_1->age + $human_2->age; ?></td>  <!-- вывод суммы общего возраста -->
                    <td><? echo $human_1->salary + $human_2->salary; ?></td>    <!-- вывод суммы общей зарплаты -->
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

