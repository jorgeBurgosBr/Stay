const form = document.querySelector(".typing-area"),
   inputField = document.querySelector(".input-field"),
   sendBtn = form.querySelector("button"),
   chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
   e.preventDefault(); //preventing form from submitting 
}

// sendBtn.onclick = () => {
//       // let's start Ajax
//    let xhr = new XMLHttpRequest(); //creating XML object
//    xhr.open("POST", "php/insert-chat.php", true);
//    xhr.onload = () => {
//       if (xhr.readyState === XMLHttpRequest.DONE) {
//          if (xhr.status === 200) {
//             let data = xhr.data;
//             console.log(data);
//             inputField.value = "";//once message inserted into database then leave blank the input field
//             scrollToBotton();
//          }
//       }
//    }
//    // we have to send the form data through ajax to php
//    let formData = new FormData(form); //creating new formData object
// for (let pair of formData.entries()) {
//     console.log(pair[0] + ': ' + pair[1]);
// }   xhr.send(formData); //sending the form data to php
// }

sendBtn.onclick = () => {
   const formData = new FormData(form);
   fetch('php/insert-chat.php', {
      method: 'POST',
      body: formData,
   })
      .then(response => response.json())
      .then(data => {
         inputField.value = "";//once message inserted into database then leave blank the input field
         scrollToBotton();
      })
}

chatBox.onmouseenter = () => {
   chatBox.classList.add("active");
}
chatBox.onmouseleave = () => {
   chatBox.classList.remove("active");
}
// setInterval(()=> {
//    // let's start Ajax
//    let xhr = new XMLHttpRequest(); //creating XML object
//    xhr.open("POST", "php/get-chat.php", true);
//    xhr.onload = () => {
//       if (xhr.readyState === XMLHttpRequest.DONE) {
//          if (xhr.status === 200) {
//             let data = xhr.response;
//             chatBox.innerHTML = data;
//             if (!chatBox.classList.contains("active")) { //if active class not contains in chatbox the scroll to bottom
//                scrollToBotton();
//             }
//          }
//       }
//    }

//    // we have to send the form data through ajax to php 
//    let formData = new FormData(form); //creating new formData object
//    xhr.send(formData); //sending the form data to php
// }, 500) //this function  will run frequently after 500ms

setInterval(() => {
   const formData = new FormData(form);
   fetch('php/get-chat.php', {
      method: 'POST',
      body: formData,
   })
      .then(response => {
         if (!response.ok) {
            throw new Error('Network response was not ok');
         }
         return response.text(); // assuming the response is text
      })
      .then(data => {
         chatBox.innerHTML = data;
         if (!chatBox.classList.contains("active")) {
            scrollToBotton();
         }
      })
      .catch(error => {
         console.error('There has been a problem with your fetch operation:', error);
      });
}, 500);



function scrollToBotton() {
   chatBox.scrollTop = chatBox.scrollHeight;
}

var backButton = document.getElementById('backButton');
if (backButton) {
   backButton.addEventListener('click', function () {
      window.history.back();
   });
}