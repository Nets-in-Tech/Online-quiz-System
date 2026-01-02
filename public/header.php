<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <button id="toggleDarkMode" class="btnt">Toggle Dark Mode</button>

    <script>
document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggleDarkMode");
    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
            localStorage.setItem("theme",
                document.body.classList.contains("dark-mode") ? "dark" : "light"
            );
        });
    }

    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
    }
});
</script>

