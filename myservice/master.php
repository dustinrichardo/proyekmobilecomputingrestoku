<?php
    include("connection.php");

    $response = array();

    if (isset($_POST["function"])) {
        $func = $_POST["function"];
        if ($func == "login") {
            login($conn);
        } else if ($func == "addmhs") {
            addMahasiswa($conn);
        } else if ($func == "getallmhs") {
            getAllMahasiswa($conn);
        }
    } else {
        $response["code"] = -1;
        $response["message"] = "No function data found";        
        echo json_encode($response);
    }

    function login($conn) {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            if ($username == $password) {
                if ($username == "admin") {
                    $response["code"] = 1;
                    $response["message"] = "Login Successful";
                } else {
                    $sql_query = "SELECT * FROM mahasiswa WHERE nrp = '$username'";
                    $result = mysqli_query($conn, $sql_query);
                    if (mysqli_num_rows($result) > 0) {
                        $response["code"] = 1;
                        $response["message"] = "Login Successful";
                    } else {
                        $response["code"] = -3;
                        $response["message"] = "Invalid Username or Password";
                    }
                }
            } else {
                $response["code"] = -3;
                $response["message"] = "Invalid Username or Password";
            }        
        } else {
            $response["code"] = -2;
            $response["message"] = "Invalid Data";
        }
        echo json_encode($response);
    }

    function addMahasiswa($conn) {
        if (isset($_POST["nrp"]) && isset($_POST["name"]) && isset($_POST["major"]) && isset($_POST["gender"])) {
            $nrp = $_POST["nrp"];
            $name = $_POST["name"];
            $major = $_POST["major"];
            $gender = $_POST["gender"];
            $sql_insert = "INSERT INTO mahasiswa VALUES ($nrp, '$name', '$major', '$gender')";
            $query = mysqli_query($conn, $sql_insert);
            if ($query) {
                $response["code"] = 1;
                $response["message"] = "Data Inserted!";
            } else {
                $response["code"] = -3;
                $response["message"] = "Insert Data Failed!";
            }
        } else {
            $response["code"] = -2;
            $response["message"] = "Invalid Data";
        }
        echo json_encode($response);
    }

    function getAllMahasiswa($conn) {
        $sql_query = "SELECT * FROM mahasiswa";
        $result = mysqli_query($conn, $sql_query);
        if (mysqli_num_rows($result) > 0) {
            $data = array();
            $arrmhs = array();
            $ctr = 0;
            while($row = mysqli_fetch_array($result)) {
                $data["nrp"] = $row["nrp"];
                $data["name"] = $row["name"];
                $data["major"] = $row["major"];
                $data["gender"] = $row["gender"];
                $arrmhs[$ctr] = $data;
                $ctr++;
            }
            mysqli_free_result($result);
            $response["code"] = 1;
            $response["message"] = "Get Data Successful";
            $response["datamhs"] = $arrmhs;
        } else {
            $response["code"] = -3;
            $response["message"] = "No Data";
        }
        echo json_encode($response);
    }

?>