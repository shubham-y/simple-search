<?php

require __DIR__ . '/vendor/autoload.php';
use Elasticsearch\ClientBuilder;

$hosts = [
    'host' => 'localhost',
    'port' => '9200',
    'scheme' => 'http',
];


$client = ClientBuilder::create()->build();

if (isset($_GET['q'])) {

    $q = $_GET['q'];
    try{
    $query = $client->search([
        'body' => [
            "query" => [
                "multi_match" => [
                    "fields" => [
                        "model", "brand", "OS"
                    ],
                    "query" => $q,
                    "fuzziness" => "AUTO:1,5"
                ]
            ]
        ]
    ]);
    }catch(Exception $e){
        $results = array(
            "status" => false,
            "message" => "Error",
            "data" => $e->getMessage()
        );
        echo json_encode($results);
        return;
    }

    // print_r($query);
    if ($query['hits']['total'] >= 1) {
        $results["data"] = $query['hits']['hits'];
        $results["status"] = true;
        $results["message"] = "Success";
    } else {
        $results = array(
            "status" => false,
            "message" => "Error",
            "data" => []
        );
    }
    echo json_encode($results);
}
