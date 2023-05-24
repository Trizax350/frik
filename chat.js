document.addEventListener('DOMContentLoaded', function(){
  //Üzenetek betöltése
  function loadMessages(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_messages.php', true);
    xhr.onload = function(){
      if(xhr.status === 200){
        document.getElementById('messages').innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  }

  //Adatbázisba mentés
  document.getElementById('send_message_button').addEventListener('click', function(){
    var email = document.getElementById('email').value;
    var name = document.getElementById('name').value;
    var message = document.getElementById('message').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_message.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function(){
      if(xhr.status === 200){
        document.getElementById('message').value = '';
        loadMessages();
      }
    };
    xhr.send('email=' + encodeURIComponent(email) + '&name=' + encodeURIComponent(name) + '&message=' + encodeURIComponent(message));
  });

  //Frissítés
  setInterval(function(){
    loadMessages();
  }, 1000);
});
