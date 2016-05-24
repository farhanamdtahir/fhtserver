<?php
require "Horus.php";

$app = new Horus;
$app->autoload("classes");

$app->set([
    "Access-Control-Allow-Origin" => "*",
    "Access-Control-Allow-Credentials" => "false",
    "Access-Control-Allow-Methods" => "OPTIONS, GET, POST, PUT, DELETE",
    "Access-Control-Allow-Headers" => "Content-Type"
]);

/*
    USER ENDPOINT
    =============
    This endpoint has 4 methods:
    + GET /user             : Retrieve all user data from database
    + POST /user/regiser    : Register User
    + POST /user/login      : Login
    + PUT /user/:id         : Create user in db based on ID
    + DELETE /user/:id      : Delete user in db based on ID
    ------------------------------------------------------------------
    */

    // 1. GET ALL USERS
    $app->on("GET /user", function() {

        // Procedure bila browser pergi ke url /user
        // =========================================
        // 1 - Connect ke database
        $dbh = db::connect();

        // 2 - Query table user
        $sql = "SELECT * from user";
        $query = $dbh->prepare($sql);
        $query->execute($param);
        
        // 3 - Return table user ke browser
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if($result) {
            $this->json(["success"=> true, "data" => $result])->end();
        } else {
             $this->json(["message"=> "No user in database"])->end();
        }
    });


    // 2. LOGIN USER
    $app->on("POST /user/login", function() {

        $dbh = db::connect();
        $sql = "SELECT * from user WHERE email=:email AND password=:password" ;
        $param = [
            ":email"=> $this->body->data->email,
            ":password"=> $this->body->data->password
        ];

        $query = $dbh->prepare($sql);
        $query->execute($param);

        $result = $query->fetch(PDO::FETCH_OBJ);

        if($result) {
            $this->json([
                "success"=> true,
                "data" => $result,
                "debug" => $this->body
            ]
            )->end();
        } else {
            $this->json([
                "message"=> "Wrong username/password",
                "debug" => $this->body
            ])->end();
        }
    });

    // 3. REGISTER USER
    $app->on("POST /user/register", function() {
        
        $dbh = db::connect();
        $sql = "INSERT INTO user (username, `email`, `password`, `height`, `weight`, `bloodtype`, `healthhistory`)
                VALUES           (:username, :email, :password, :height, :weight, :bloodtype, :healthhistory)";
        $param = [
            ":username"     => ($this->body->data->username) ? $this->body->data->username : "Input empty", // Ternary Operator example -- (condition) ? true:false
            ":email"        => ($this->body->data->email) ? $this->body->data->email : "Input empty",
            ":password"     => ($this->body->data->password) ? $this->body->data->password : "Input empty",
            ":height"       => ($this->body->data->height) ? $this->body->data->height : 0,
            ":weight"       => ($this->body->data->weight) ? $this->body->data->weight : 0,
            ":bloodtype"    => ($this->body->data->bloodtype) ? $this->body->data->bloodtype : "Input empty",
            ":healthhistory"=> ($this->body->data->Healthhistory) ? $this->body->data->healthhistory : "Input empty"
        ];

        $query = $dbh->prepare($sql);
        $query->execute($param);

        $result = $query->rowCount();

        if($result) {
            $this->json([
                "success"=> $result,
                "debug" => $
            ]
            )->end();
        } else {
            $this->json([
                "message"=> "Something wrong with registration",
                "debug" => $result,
                "debug_data" => $this->body
            ])->end();
        }
    });


// == panggil localhost healthdata
$app->on("GET /healthdata", function() {

    // Procedure bila browser pergi ke url /healthdata
    // =========================================
    // 1 - Connect ke database
    $dbh = db::connect();

    // 2 - Query table healthdata
    $sql = "SELECT * from healthdata";
    $query = $dbh->prepare($sql);
    $query->execute($param);
    
    // 3 - Return table healthdata ke browser
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if($result) {
        $this->json(["success"=> true, "data" => $result])->end();
    } else {
         $this->json(["message"=> "No healthdata in database"])->end();
    }


    // $this->end("Hello healthdata", 200);
});

// == panggil localhost sickness
$app->on("GET /sickness", function() {

    // Procedure bila browser pergi ke url /sickness
    // =========================================
    // 1 - Connect ke database
    $dbh = db::connect();

    // 2 - Query table sickness
    $sql = "SELECT * from sickness";
    $query = $dbh->prepare($sql);
    $query->execute($param);
    
    // 3 - Return table sickness ke browser
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if($result) {
        $this->json(["success"=> true, "data" => $result])->end();
    } else {
         $this->json(["message"=> "No sickness in database"])->end();
    }


    // $this->end("Hello healthdata", 200);

});

// == panggil localhost groups
$app->on("GET /groups", function() {

    // Procedure bila browser pergi ke url /groups
    // =========================================
    // 1 - Connect ke database
    $dbh = db::connect();

    // 2 - Query table groups
    $sql = "SELECT * from groups";
    $query = $dbh->prepare($sql);
    $query->execute($param);
    
    // 3 - Return table groups ke browser
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if($result) {
        $this->json(["success"=> true, "data" => $result])->end();
    } else {
         $this->json(["message"=> "No groups in database"])->end();
    }


    // $this->end("Hello groups", 200);

});
