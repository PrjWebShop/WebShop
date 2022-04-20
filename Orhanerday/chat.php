<?php
require './OpenAi.php';
require './Url.php';

$open_ai = new OpenAi();
$received = $_POST['input'];
$open_ai = new OpenAi();
$answer = $open_ai->answer([
    "documents" => [
        "Introduction: All in one E-commerce Store built with XAMPP stack and OpenAI",
        "Course: Course: 430-DW3-AS",
        "WebShop is built by Alex M, Alex B, You Yin and Anurag",
        "Features:Homepage is the first page of the Website. It introduces the user to the website and the purpose of the website is to show various products, categories and deals
        After logging in user has access to exclusive customized product feed, cart and various categories
        User can add products to cart to save later, we use cookies and store the cart in the database.
        Other features include chatbot, animations and search throughout the list of product
        Website has a responsive design so that it can be accessed on any mobile devices without any issues and have access to all the features
        ",
        "Anurag is a frontend web developer and knows a bit of backend, he created the chatbot",
        "Alex Michaud is a backend web developer and knows a bit of frontend, he managed all the databases and relations",
        "Alex Boucher is a frontend web developer and did all the testing and debugging",
        "Yue Yin created the presentations, populated the database and did all the testing",
        "Webshop has a chatbot which can answer questions about our products and services",
        "You can find the source code on GitHub",
        "You can also buy our services, there are many of them, like shipping, delivery, and more",
        "You can also buy our exclusive products, there are many of them, like laptops, phones, and more",
        "There are currently 100 types of shoes, 95 of them are in stock",
        "Discounts are avalable in the month of April",
        "Delivery is free for orders over $100",
        "if the order total is under 100, delivery is $5",
        "WebShop techstack: HTML5, CSS, Bootstrap, AJAX, PHP, MySQL, JavaScript, JQuery, and more",
        "Available Categories: Electronics, Video Games, Movies and CLothing",
        "Electronics: Laptops, Smartphones, Tablets, and more",
        "Pokemon red version and blue version available 100 quantities. Price is 99.99$.",
        "Simpsons arcade machine: 14 in stock. Price is 799.9$"
    ],
    "question" => $received,
    "search_model" => "davinci",
    "model" => "davinci",
    "examples_context" => "WebShop is built by Alex M, Alex B, You Yin and Anurag",
    "examples" => [
        ["Who built the webshop?", "WebShop is built by Team AAAY"],
        ["What is your name?", "I am just a bot without a name"],
        ["What is your age?", "I am just a bot without an age"],
        ["Is pokemon game available", "Yes, there are 100 pokemon red in stock and price is Price is 99.99$"],
        ["Do you have Simpsons arcade machine in stock?", "Yes, there are 14 Simpsons machine in stock and price is Price is 799.9$"],
        ["Tell me about the web shop", "The webshop is built by Anurag, Alex M, Alex B and Yue. In total it took two sprints to finish, Alex M and Alex B did the Frontend and Backend, Yue did all the testing and Anurag built the bot and some design."]
    ],
    "max_tokens" => 5,
    "stop" => ["\n", "  "],
]);

$answerdecoded = json_decode($answer, true);

$answer_result = $answerdecoded['answers'][0];

echo $answer_result;

// "search_model" => "ada",
//     "model" => "curie",