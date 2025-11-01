<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Backup and Restore system</title>
    <style>
        .blogdesire-form{
            margin: 0;
            padding: 0;
            position: fixed;
            top: 0;
            left:0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
        }
        .blogdesire-button{
            margin: 10px;
            border: none;
            padding: 10px 20px;
            color: white;
            /*background: green;*/
        }

    </style>
</head>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<body>
    <h1>Database Backup and Restore system</h1>
    <form method="POST" class="blogdesire-form">
        <button name="backup" class="blogdesire-button btn-sm btn-primary">
            Backup
        </button>
        <!-- <button name="restore" class="blogdesire-button btn-sm btn-success">
            Restore
        </button> -->
        <?php
        $date = date('Ymd-His'); 
        // $con = mysqli_connect("localhost","root","","leave_db");
        $con = mysqli_connect("sql100.infinityfree.com","if0_40290637","NxaTOZQNH28PVR","if0_40290637_leave_db");
        if(isset($_POST['backup'])){
            $tables = array();
            $sql = "SHOW TABLES";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
            $sqlScript = "";
            foreach ($tables as $table) {
                $query = "SHOW CREATE TABLE $table";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_row($result);
                $sqlScript .= "\n\n" . $row[1] . ";\n\n";
                $query = "SELECT * FROM $table";
                $result = mysqli_query($con, $query);
                $columnCount = mysqli_num_fields($result);
                for ($i = 0; $i < $columnCount; $i ++) {
                    while ($row = mysqli_fetch_row($result)) {
                        $sqlScript .= "INSERT INTO $table VALUES(";
                        for ($j = 0; $j < $columnCount; $j ++) {
                            $row[$j] = $row[$j];           
                            if (isset($row[$j])) {
                                $sqlScript .= '"' . mysqli_real_escape_string($con,$row[$j]) . '"';
                            } else {
                                $sqlScript .= '""';
                            }
                            if ($j < ($columnCount - 1)) {
                                $sqlScript .= ',';
                            }
                        }
                        $sqlScript .= ");\n";
                    }
                }   
                $sqlScript .= "\n"; 
            }
            
// $date = date('Ymd-His');
            if(!empty($sqlScript))
            {
// $filename = $backup_path.$database.'_'.$date.'.sql';
                // $backup_file_name =  __DIR__.'/backup_database/backup_'.$date.'.sql';
                $backup_file_name =  __DIR__.'/leave_db_'.$date.'.sql';
                $fileHandler = fopen($backup_file_name, 'w+');
                // $fileHandler = fopen('C:\Users\Default\Downloads\leave_db_'.$date.'.sql', 'w+');
                $number_of_lines = fwrite($fileHandler, $sqlScript);
                fclose($fileHandler);
                $message = "Backup Created Successfully";
            }
        }
        if(isset($_POST['restore'])){
            $sql = '';
            $error = '';
// if (file_exists(__DIR__.'/_backup_.sql'))admin\system_info./admin/database/
            if (file_exists(__DIR__.'/leave_db_'.$date.'.sql')) {
// Deleting starts here
                $query_disable_checks = 'SET foreign_key_checks = 0';
                mysqli_query($con, $query_disable_checks);
                $show_query = 'Show tables';
                $query_result = mysqli_query($con, $show_query);
                $row = mysqli_fetch_array($query_result);
                while ($row) {
                    $query = 'DROP TABLE IF EXISTS ' . $row[0];
                    $query_result = mysqli_query($con, $query);
                    $show_query = 'Show tables';
                    $query_result = mysqli_query($con, $show_query);
                    $row = mysqli_fetch_array($query_result);
                }
                $query_enable_checks = 'SET foreign_key_checks = 1';
                mysqli_query($con, $query_enable_checks);
// Deleting ends here 
                $lines = file(__DIR__.'/backup_database/leave_db.sql');
                foreach ($lines as $line) {
                    if (substr($line, 0, 2) == '--' || $line == '') {
                        continue;
                    }
                    $sql .= $line;
                    if (substr(trim($line), - 1, 1) == ';') {
                        $result = mysqli_query($con, $sql);
                        if (! $result) {
                            $error .= mysqli_error($con) . "\n";
                        }
                        $sql = '';
                    }
                }
                if ($error) {
                    $message = $error;
                } else {
                    $message = "Database restored successfully";
                }
            }else{
                $message = "Uh Oh! No backup file found on the current directory!";
            }
        }
        ?>
        <?php  if(@$message): ?>
            <p><?php echo $message;?></p>
        <?php  endif; ?>
    </form>
</body>
</html>