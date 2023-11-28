<?php
//kollar om  en post har sket
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredUsername = test_input($_POST["username"]);
    $enteredPassword = test_input($_POST["password"]);

    //specifiserar map och fil väg
    $userDatabaseFolderPath = "userDatabase/$enteredUsername";
    $userDataFilePath = "$userDatabaseFolderPath/userData.txt";

    //kollar om filen finns isåfall finns också en redan någon med det namnet
    if (file_exists($userDatabaseFolderPath)) {
        echo "<h2>Error: Name already exists!</h2>";
    } else {
        //skapa en map men om det inte lyckas så gö det som finns i if
        if (!mkdir($userDatabaseFolderPath, 0700, true)) {
            echo "<h2>Error: Failed to create user folder!</h2>";
            exit;
        }
        //skapa en fil men om det inte lyckas så gö det som finns i if
        if (!mkdir("$userDatabaseFolderPath/imgUploads", 0700, true)) {
            echo "<h2>Error: Failed to create user folder!</h2>";
            exit;
        }

        //skapa info för användare (just nu bara lösen info som också är krypterad)
        $hashedPassword = password_hash($enteredPassword, PASSWORD_DEFAULT);
        $userDataArray = array(
            "password" => $hashedPassword,
        );
        //gö infon till en JSON string
        $jsonEncoded = json_encode($userDataArray, JSON_PRETTY_PRINT);

        //skriver info i data filen och sedan kollar om det gick 
        if (file_put_contents($userDataFilePath, $jsonEncoded) !== false) {
            header("Location: index.php");
            exit;
        } else {
            echo "<h2>Error: Failed to write to file!</h2>";
            exit;
        }
    }
}

//ser till så att inget skadligt skickas in i koden genom formen 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
