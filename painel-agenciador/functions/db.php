<?php
$con = mysqli_connect('localhost', 'leoharley', '150150', 'bqf_db');
$url = "http://localhost/";

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