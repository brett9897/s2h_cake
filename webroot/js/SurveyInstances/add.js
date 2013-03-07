function bindPhoto() {
    var fileName = document.getElementsByClassName("ax-file-name")[0].innerHTML;
    var hiddenField = document.getElementById("photoName"); 
    hiddenField.value = fileName;
}
