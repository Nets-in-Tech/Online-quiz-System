<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <button id="toggleDarkMode" class="btnt">Toggle Dark Mode</button>

    <script>
    document.getElementById("toggleDarkMode").addEventListener("click", function() {
        document.body.classList.toggle("dark-mode");
        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }
    });

    window.onload = function() {
        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark-mode");
        }
    };
    </script>
