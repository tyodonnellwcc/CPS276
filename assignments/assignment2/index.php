<?php
    $numbers = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50];

    $evenNumbers = foreach ($numbers as $number) {
        if ($number == 1 || 3 || 5 || 7 || 9 || 11 || 13 || 15 || 17 || 19 || 21 || 23 || 25 || 27 || 29 || 31 || 33 || 35 || 37 || 39 || 41 || 43 || 45 || 47 || 49) {
            continue;
        }
        if ($number == 50) {
            echo $number;
        } else {
            echo "$number - ";
        }
    };

    $form = <<<EOD
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        EOD;

    function createTable($rows, $columns) {
        $table = "";
        for ($i = 1; $i <= 8; $i++) {
            $table .= "";
        for ($j = 1; $j <= 6; $j++) {
            $table .= "";
        }
        $table .= "";
    }
    $table .= "Row $i, Col $j";
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <?php
    echo $evenNumbers;
    echo $form;
    echo createTable(8, 6);
    ?>
  </body>
</html>