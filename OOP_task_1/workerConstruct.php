<?php
/**
Сделайте класс Worker, в котором будут следующие private поля - name (имя), salary (зарплата). Сделайте так,
чтобы эти свойства заполнялись в методе __construct при создании объекта (вот так: new Worker(имя, возраст) ). Сделайте также public методы getName, getSalary.
Создайте объект этого класса 'Дима', возраст 25, зарплата 1000. Выведите на экран произведение его возраста и зарплаты.
*/

class Worker
{

    private $name;  // свойство класса : имя
    private $age;  // свойство класса : имя
    private $salary; // свойство класса : зарплата

    public function __construct($name, $age, $salary)
    {
        $this->name = $name;
        $this->age = $age;
        $this->salary = $salary;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getAge()
    {
        return $this->age;
    }
    public function getSalary()
    {
        return $this->salary;
    }
}

$human = new Worker('Дима', 25, 1000);    // обьект класса с данными в конструктор

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
                    <th>Name</th>
                    <th>Age and Salary are common</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><? echo $human->getName(); ?></td>    <!-- вывод имен работников -->
                    <td><? echo $human->getAge() * $human->getSalary(); ?></td>  <!-- вывод суммы общего возраста -->
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


