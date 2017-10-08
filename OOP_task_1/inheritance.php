<?php
/*
 *  Сделайте класс User, в котором будут следующие protected поля - name (имя), age (возраст), public методы setName, getName, setAge, getAge.
Сделайте класс Worker, который наследует от класса User и вносит дополнительное private поле salary (зарплата), а также методы public getSalary и setSalary.
Создайте объект этого класса 'Иван', возраст 25, зарплата 1000. Создайте второй объект этого класса 'Вася', возраст 26, зарплата 2000. Найдите сумму зарплата Ивана и Васи.
Сделайте класс Student, который наследует от класса User и вносит дополнительные private поля стипендия, курс, а также геттеры и сеттеры для них.
 Сделайте класс Driver (Водитель), который будет наследоваться от класса Worker из предыдущей задачи. Этот метод должен вносить следующие private поля: водительский стаж, категория вождения (A, B, C).
 */

class User {

    protected $name;  // свойство класса : имя
    protected $age;  // свойство класса : имя

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }
}

class Worker extends User {   // класс который наследуется от класса User

    private $salary;

    public function getSalary()
    {
        return $this->salary;
    }

    public  function setSalary($salary)
    {
        $this->salary = $salary;
    }
}

class Student extends User {   // класс который наследуется от класса User

    private $scholarship;
    private $course;

    public function getScholarship()
    {
        return $this->scholarship;
    }

    public  function setScholarship($scholarship)
    {
        $this->scholarship = $scholarship;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }
}

class Driver extends Worker {   // класс который наследуется от класса Worker

    private $experienceDrive;
    private $categorryDriver;

    public function getExperienceDrive()
    {
        return $this->experienceDrive;
    }

    public function setExperienceDrive($experienceDrive)
    {
        $this->experienceDrive = $experienceDrive;
    }

    public function getCategorryDriver()
    {
        return $this->categorryDriver;
    }

    public function setCategorryDriver($categorryDriver)
    {
        $this->categorryDriver = $categorryDriver;
    }
}

$human1 = new Worker();    // обьект класса с данными в конструктор
$human2 = new Worker();    // обьект класса с данными в конструктор
$driver = new Driver();    // обьект класса с данными в конструктор
$student = new Student();    // обьект класса с данными в конструктор

$human1->setName('Иван');
$human1->setAge(25);
$human1->setSalary(1000);

$human2->setName('Вася');
$human2->setAge(26);
$human2->setSalary(2000);

$driver->setName('Никина');
$driver->setAge(45);
$driver->setExperienceDrive(5);
$driver->setCategorryDriver('A,B,C,E');
$driver->setSalary(4000);

$student->setName('Виктор');
$student->setAge(22);
$student->setScholarship(700);
$student->setCourse(3);
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
        <div class="one-half column" style="margin-top: 10%">
            <table class="u-full-width">
                <thead>
                <tr>
                    <th>Names</th>
                    <th>Salary's common</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><? echo $human1->getName() . ' / ' . $human2->getName(); ?></td>    <!-- вывод имен работников -->
                    <td><? echo $human1->getSalary() + $human2->getSalary(); ?></td>    <!-- вывод суммы общей зарплаты -->
                </tr>
                </tbody>
            </table>
        </div>
        <div class="one-half column" style="margin-top: 10%">
            <table class="u-full-width">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Salary</th>
                    <th>Experience Drive</th>
                    <th>Categorries Driver</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><? echo $driver->getName(); ?></td>    <!-- вывод имен работников -->
                    <td><? echo $driver->getAge(); ?></td>    <!-- вывод суммы общей зарплаты -->
                    <td><? echo $driver->getSalary(); ?></td>    <!-- вывод суммы общей зарплаты -->
                    <td><? echo $driver->getExperienceDrive(); ?></td>    <!-- вывод суммы общей зарплаты -->
                    <td><? echo $driver->getCategorryDriver(); ?></td>    <!-- вывод суммы общей зарплаты -->
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="one-half column" style="margin-top: 10%">
            <table class="u-full-width">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Scholarship</th>
                    <th>Course</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><? echo $student->getName(); ?></td>    <!-- вывод имен работников -->
                    <td><? echo $student->getAge(); ?></td>    <!-- вывод суммы общей зарплаты -->
                    <td><? echo $student->getScholarship(); ?></td>    <!-- вывод суммы общей зарплаты -->
                    <td><? echo $student->getCourse(); ?></td>    <!-- вывод суммы общей зарплаты -->
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


