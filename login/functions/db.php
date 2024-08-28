<?php
$con = mysqli_connect('localhost', 'u773789177_buscalife', '%Buscalife2024', 'u773789177_buscalife');
$url = "https://busca.life/";
function createTabel(){
    global $con;
    $query =    "CREATE TABLE tb_usuario(
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                whatsapp VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password TEXT NOT NULL,
                token TEXT NOT NULL,
                activition tinyint(4)  NOT NULL Default 0)";
    $con->query($query);
}
createTabel();

function escape($string)
{
    global $con;
    return mysqli_real_escape_string($con, $string);
}


function row_count($result)
{
    return mysqli_num_rows($result);
}

function query($query)
{
    global $con;
    return mysqli_query($con, $query);
}

function confirm($result)
{
    global $con;
    if (!$result) {
        die("QUERY FAILED " . mysqli_error($con));
    }
}