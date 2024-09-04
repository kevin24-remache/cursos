document.addEventListener("DOMContentLoaded", function () {
    // Mostrar el preloader cuando la página comienza a cargarse
    window.onbeforeunload = function () {
        showPreloader();
    };

    // Ocultar el preloader cuando la página ha terminado de cargarse
    window.onload = function () {
        hidePreloader();
    };

    function showPreloader() {
        document.getElementById("preloader").style.display = "flex";
    }

    function hidePreloader() {
        document.getElementById("preloader").style.display = "none";
    }
});