<?php
    $numbers = range(1, 50);

    $evenNumbers = "Even numbers: ";
    foreach ($numbers as $number) {
        if ($number % 2 !== 0) continue;
            $evenNumbers .= ($number == 50) ? $number : "$number - ";
        }

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
        $table = "<table class='table table-bordered'>";
        for ($i = 1; $i <= $rows; $i++) {
            $table .= "<tr>";
        for ($j = 1; $j <= $columns; $j++) {
            $table .= "<td>Row $i, Col $j</td>";
        }
        $table .= "</tr>";
    }
    $table .= "</table>";
    return $table;
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