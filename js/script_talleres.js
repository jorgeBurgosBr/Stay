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
   xhr.open("POST", "php/search.php", true);
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