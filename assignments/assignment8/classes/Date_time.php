<?php
//Table name: note
//Table attributes: id(pri), date_time, note

require_once 'classes/Pdo_methods.php';

class Date_time {

    public function checkSubmit() {
        // Handle Add Note form (index.php)
        if (isset($_POST['addNote'])) {
            return $this->addNote();
        }

        // Handle Display Notes form (display_notes.php)
        if (isset($_POST['getNotes'])) {
            return $this->getNotes();
        }

        // Default empty
        return "";
    }

    private function addNote() {
        $pdo = new PdoMethods();

        // Validate date/time and note fields
        if (empty($_POST['dateTime']) || empty(trim($_POST['note']))) {
            return "<p class='text-danger'>Please enter a date, time, and note.</p>";
        }

        // Convert date/time (from form) to timestamp
        $timestamp = strtotime($_POST['dateTime']);
        $note = trim($_POST['note']);

        // Insert into database
        $sql = "INSERT INTO note (date_time, note) VALUES (:date_time, :note)";
        $bindings = [
            [':date_time', $timestamp, 'int'],
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

        // Validate date inputs
        if (empty($_POST['begDate']) || empty($_POST['endDate'])) {
            return "<p class='text-danger'>No notes found for the date range selected.</p>";
        }

        // Convert dates to timestamps for start and end of day
        $begDate = strtotime($_POST['begDate'] . " 00:00:00");
        $endDate = strtotime($_POST['endDate'] . " 23:59:59");

        $sql = "SELECT date_time, note FROM note WHERE date_time BETWEEN :begDate AND :endDate ORDER BY date_time DESC";
        $bindings = [
            [':begDate', $begDate, 'int'],
            [':endDate', $endDate, 'int']
        ];

        $records = $pdo->selectBinded($sql, $bindings);

        if ($records === 'error' || count($records) === 0) {
            return "<p class='text-danger'>No notes found for the date range selected.</p>";
        }

        // Build HTML table
        $output = "<table class='table table-bordered table-striped'>
                    <thead><tr><th>Date and Time</th><th>Note</th></tr></thead><tbody>";

        foreach ($records as $row) {
            $formattedDate = date("m/d/Y h:i A", $row['date_time']);
            $output .= "<tr><td>{$formattedDate}</td><td>{$row['note']}</td></tr>";
        }

        $output .= "</tbody></table>";
        return $output;
    }
}
?>