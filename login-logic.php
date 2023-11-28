<?php
session_start();

//kollar om  en post har sket
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredUsername = test_input($_POST["username"]);
    $enteredPassword = test_input($_POST["password"]);

    //specifiserar map och fil väg
    $userDatabaseFolderPath = "userDatabase/$enteredUsername";
    $userDataFilePath = "$userDatabaseFolderPath/userData.txt";

    //kollar om filen finns
    if (file_exists($userDataFilePath)) {
        $jsonContent = file_get_contents($userDataFilePath);

        //kollar om den lyckades att läsa filen
        if ($jsonContent !== false) {
            $decodedArray = json_decode($jsonContent, true);

            //ser till så att det finns information i decodedArray
            if ($decodedArray === null) {
                logError("Failed to decode JSON content!");
                exit();
            }
        } else {
            logError("Failed to read file content!");
            exit();
        }
    }
    //kollar om decodedArray är vald till något värde
    if (isset($decodedArray)) {
        $storedPassword = $decodedArray["password"];
        //kollar om lösenordet är rätt
        if (password_verify($enteredPassword, $storedPassword)) {
            $_SESSION["username"] = $enteredUsername; //sätter upp session användarnamn
            $_SESSION["password"] = $enteredPassword; //sätter upp session lösenord

            header("Location: homepage.php"); //tar dig till homepage.php
            exit;
        } else {
            logError("Invalid password for user $enteredUsername");
            echo "<h2>Error: Invalid password!</h2>";
        }
    } else {
        logError("User not found: $enteredUsername");
        echo "<h2>Error: User not found!</h2>";
    }
}

//ser till så att inget skadligt skickas in i koden genom formen 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//funktion för att logga fel medelande
function logError($message) {
    error_log($message);
}
?>
