<?php
//Table name: note
//Table attributes: id(pri), date_time, note

require_once 'classes/Pdo_methods.php';

class Date_time {

    public function checkSubmit() {
    $output = "";

    if (isset($_POST['addNote'])) {
        $output = $this->addNote();
    }

    if (isset($_POST['getNotes'])) {
        $output = $this->getNotes();
    }

    return $output;
    }


    private function addNote() {
        $pdo = new PdoMethods();

        if (empty($_POST['dateTime']) || empty(trim($_POST['note']))) {
            return "<p class='text-danger'>Please enter a date, time, and note.</p>";
        }

        $timestamp = date("Y-m-d H:i:s", strtotime($_POST['dateTime']));
        $note = trim($_POST['note']);

        $sql = "INSERT INTO note (date_time, note) VALUES (:date_time, :note)";
        $bindings = [
            [':date_time', $timestamp, 'str'],
            [':note', $note, 'str']
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'noerror') {
            return "<p class='text-success'>Note added successfully!</p>";
        } else {
            return "<p class='text-danger'>There was an error adding the note.</p>";
        }
    }

    private function getNotes() {
    $pdo = new PdoMethods();

    if (empty($_POST['begDate']) || empty($_POST['endDate'])) {
        return "Both dates are required.";
    }

    $begDate = $_POST['begDate'] . " 00:00:00";
    $endDate = $_POST['endDate'] . " 23:59:59";

    $sql = "SELECT date_time, note FROM note 
            WHERE date_time BETWEEN :beg AND :end 
            ORDER BY date_time DESC";
    $bindings = [
        [':beg', $begDate, 'str'],
        [':end', $endDate, 'str']
    ];

    $records = $pdo->selectBinded($sql, $bindings);

    if ($records === 'error') {
        return "There was an error retrieving the notes.";
    } elseif (count($records) == 0) {
        return "No notes found for that date range.";
    } else {
        $output = "<table class='table table-striped'>
            <tr><th>Date and Time</th><th>Note</th></tr>";
        foreach ($records as $row) {
            $dateFormatted = date("m/d/Y h:i A", strtotime($row['date_time']));
            $output .= "<tr><td>{$dateFormatted}</td><td>{$row['note']}</td></tr>";
        }
        $output .= "</table>";
        return $output;
    }
    }

}
?>