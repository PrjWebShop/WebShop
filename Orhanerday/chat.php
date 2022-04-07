<?php

require './OpenAi.php';
require './Url.php';

$open_ai = new OpenAi();

$answer = $open_ai->answer([
    "documents" => ["WebShop is built by Alex M, Alex B, You Yin and Anurag"],
    "question" => "what can you buy in the webshop?",
    "search_model" => "ada",
    "model" => "curie",
    "examples_context" => "WebShop is built by Alex M, Alex B, You Yin and Anurag",
    "examples" => [["Who built the webshop?", "Alex M"], ["Who is the daddy?", "Anu"]],
    "max_tokens" => 5,
    "stop" => ["\n", "<|endoftext|>"],
]);

echo $answer;

// create an input form for the user to enter a question
// create a button to submit the question

echo '<form action="index.php" method="post">
    <input type="text" name="question" placeholder="Enter your question here">
    <input type="submit" value="Submit">
</form>';
