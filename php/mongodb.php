<?php

// MongoDB connection information
$mongoClient = new MongoDB\Client("mongodb+srv://tharuntk143143:Tharun143%40@cluster0.7ljxkq2.mongodb.net/
test?retryWrites=true&w=majority");

// Select database and collection
$db = $mongoClient->selectDatabase('test');
$collection = $db->selectCollection('users');

// Example: Inserting a document
$insertResult = $collection->insertOne([
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'age' => 30
]);

echo "Inserted document with ID: " . $insertResult->getInsertedId() . "\n";

// Example: Querying documents
$cursor = $collection->find();

foreach ($cursor as $document) {
    var_dump($document);
}

// Close connection
$mongoClient->close();
?>
