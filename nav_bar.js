function loadHTML() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("content").innerHTML = xhr.responseText;
        }
    }
    xhr.open("GET", "/base.html", true);
    xhr.send();
}
window.onload = loadHTML;
