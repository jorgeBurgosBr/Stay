const searchBar = document.querySelector(".users .search input"),
   searchBtn = document.querySelector(".users .search button"),
   userList = document.querySelector(".users .users-list");

searchBtn.onclick = () => {
   searchBar.classList.toggle("active");
   searchBar.focus();
   searchBtn.classList.toggle("active");
   searchBar.value = "";
}

searchBar.onkeyup = () => {
   let searchTerm = searchBar.value;
   if (searchTerm != "") {
      if (searchTerm != "") {
         searchBar.classList.add("active");
      } else {
         searchBar.classList.remove("active");
      }
   // let's start Ajax
   let xhr = new XMLHttpRequest(); //creating XML object
   xhr.open("POST", "php/search_paciente.php", true);
   xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            userList.innerHTML = data;
         }
      }
   }
   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   xhr.send("searchTerm=" + searchTerm);
   }
}

setInterval(()=> {
   // let's start Ajax
   let xhr = new XMLHttpRequest(); //creating XML object
   xhr.open("GET", "php/users_paciente.php", true);
   xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            if (!searchBar.classList.contains("active")) {//if active not contains in search bar then add this data 
               userList.innerHTML = data;
            }
         }
      }
   }
   xhr.send();
}, 500) //this function  will run frequently after 500ms