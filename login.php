<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "studentiks");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed"]);
    exit();
}

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['email'], $_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $email;

                $response = ["status" => "success"];
            } else {
                $response["message"] = "Incorrect password.";
            }
        } else {
            $response["message"] = "No account found with that email.";
        }

        $stmt->close();
    }
}

document.getElementById("login-form").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        if (data.status === "success") {

                    window.location.href = "index.html"; 

        } else {
            const errorBox = document.getElementById("error-msg");
            if (errorBox) {
                errorBox.textContent = data.message;
            }
        }

    })
    .catch(err => console.error("Error:", err));
});


$conn->close();
echo json_encode($response);
exit();
