<?php
    if(!empty($_GET)){
     $student = array();
     $int = 0;
     $txtfile = "student.txt";
     if (file_exists($txtfile)) {
         $fgc = file_get_contents($txtfile);
         $expl = explode("[".$int."] => Array", $fgc);
         while (count($expl) > 1) {
             $expl2 = (count($expl) > 1) ?  explode("[".($int+1)."] => Array", $expl[1])[0] : $expl[1];
             $m = preg_match_all("@\\[([\d\w]+)\\] => ([^\n]*)@imus", $expl2, $matches);
             if ($m == 0) { break; }
             foreach ($matches[1] as $key => $val) {
                 $student[$int][$val] = $matches[2][$key];
             }
             $int++;
             $expl = explode("[".$int."] => Array", $fgc);
         }
     }
     $student[$int]['name'] = $_GET['name'];
     $student[$int]['subject'] = $_GET['subject'];
     $student[$int]['age'] = $_GET['age'];
     $str = print_r($student, true);
     file_put_contents('student.txt', $str);

     print_r($student);
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="GET">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">

        <label for="name">Subject:</label>
        <input type="text" name="subject" id="subject">

        <label for="name">Age:</label>
        <input type="number" name="age" id="age">

        <input type="submit" name="submitButton">
    </form>
</body>
</html>