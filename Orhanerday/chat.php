<?php
require './OpenAi.php';
require './Url.php';

$open_ai = new OpenAi();

$received = $_POST['input'];

$open_ai = new OpenAi();
$answer = $open_ai->answer([
    "documents" => [
        "WebShop is built by Alex M, Alex B, You Yin and Anurag",
        "Anurag is a frontend web developer and knows a bit of backend, he created the chatbot",
        "Alex Michaud is a backend web developer and knows a bit of frontend, he managed all the databases and relations",
        "Alex Boucher is a frontend web developer and did all the testing and debugging",
        "Yue Yin created the presentations, populated the database and did all the testing",
        "Webshop has a chatbot which can answer questions about our products and services",
        "You can find the source code on GitHub",
        "You can buy books, videogames, clothing, shoes and many more, there are over 50 categories and 100s of products to choose from",
        "You can also buy our services, there are many of them, like shipping, delivery, and more",
        "You can also buy our exclusive products, there are many of them, like laptops, phones, and more",
        "There are currently 100 types of shoes, 95 of them are in stock",
        "Discounts are avalable in the month of April",
        "Delivery is free for orders over $100",
        "if the order total is under 100, delivery is $5",
        "WebShop techstack: HTML5, CSS, Bootstrap, AJAX, PHP, MySQL, JavaScript, JQuery, and more",


    ],
    "question" => $received,
    "search_model" => "ada",
    "model" => "curie",
    "examples_context" => "WebShop is built by Alex M, Alex B, You Yin and Anurag",
    "examples" => [
        ["Who built the webshop?", "WebShop is built by Alex M, Anurag, Yu and Alex B"],
        ["What is your name?", "I am just a bot without a name"],
        ["What is your age?", "I am just a bot without an age"]
    ],
    "max_tokens" => 5,
    "stop" => ["\n", "  "],
]);

$answerdecoded = json_decode($answer, true);

$answer_result = $answerdecoded['answers'][0];

echo $answer_result;
