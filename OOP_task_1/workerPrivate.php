<?php

/*
 Сделайте класс Worker, в котором будут следующие private поля - name (имя), age (возраст), salary (зарплата) и следующие public методы setName, getName, setAge, getAge, setSalary, getSalary.
Создайте 2 объекта этого класса: 'Иван', возраст 25, зарплата 1000 и 'Вася', возраст 26, зарплата 2000.
Выведите на экран сумму зарплат Ивана и Васи. Выведите на экран сумму возрастов Ивана и Васи.

 */
class Worker
{

    private $name;  // свойство класса : имя
    private $age;    // свойство класса : возраст
    private $salary;    // свойство класса : зарплата

    public function setName($sName)   // метод класса : запись имени
    {
       $this->name = $sName;
    }
    public function getName()   // метод класса : получение имени
    {
        return $this->name;
    }
    public function setAge($sAge)    // метод класса : запись возраста
    {
        $this->age = $sAge;
    }
    public function getAge()    // метод класса : получение возраста
    {
        return $this->age;
    }
    public function setSalary($sSalary)    // метод класса : запись зарплаты
    {
        $this->salary = $sSalary;
    }
    public function getSalary()    // метод класса : получение зарплаты
    {
       return $this->salary;
    }
}

$human_1 = new Worker();    // экземпляр класса
$human_2 = new Worker();    // экземпляр класса

$human_1->setName('Иван');    // присвоение имени
$human_1->setAge(25);   // присвоение возраста
$human_1->setSalary(1000);  // присвоение зарплаты

$human_2->setName('Вася');    // присвоение имени
$human_2->setAge(26);   // присвоение возраста
$human_2->setSalary(2000);  // присвоение зарплаты

?>

<!---------------------------------------------------------------------------------->

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
                    <td><? echo $human_1->getName() . ' / ' . $human_2->getName(); ?></td>  <!-- вывод имен работников -->
                    <td><? echo $human_1->getAge() + $human_2->getAge(); ?></td>    <!-- вывод суммы общего возраста -->
                    <td><? echo $human_1->getSalary() + $human_2->getSalary(); ?></td>  <!-- вывод суммы общей зарплаты -->
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

