setTimeout(
  function infobox(){
    $( "#infobox" ).fadeOut(1500, function() {
      $( "#infobox" ).remove();
  });  
}, 5000);