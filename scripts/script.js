function myFunction() {
  document.getElementById("myDropdown")
    .classList.toggle("show");
  document.getElementById("menu-link")
    .removeAttribute("href");
}

window.onclick = function (event) {
  if(!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for(i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if(openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

function onSelectChangeMac() {
  document.getElementById('mac')
    .submit();
}

function onSelectChangeCli() {
  document.getElementById('cli')
    .submit();
}