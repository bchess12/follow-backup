<script>
var index = 0;
var increment = 3;

function setIndex(){
  if(index == 0){
    index = increment;
  }else if (index > 0) {
    index += increment;
  }
  return index;
}

function loadPosts() {
  var index = setIndex();
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("postsDestination").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","includes/feed.inc.php?req="+index,true);
        xmlhttp.send();

    }

function likePost(btnId,state){
  if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
  } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(state == false){
          document.getElementById('likeButton'+btnId).innerHTML = 'unlike';
        }else if (state == true) {
          document.getElementById('likeButton'+btnId).innerHTML = 'like';
        }
      }
  };

  if(state == false){
  xmlhttp.open("GET","includes/likePost.inc.php?req="+btnId,true);
  xmlhttp.send();
}else if (state == true) {
  xmlhttp.open("GET","includes/unlikePost.inc.php?req="+btnId,true);
  xmlhttp.send();
}
}

</script>



<?php
include_once 'header.php';
?>



<div id="postsDestination"></div>

<button onclick="loadPosts()">text</button>
