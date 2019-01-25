  
</head>
<body>
  <h3 id="loggedinuser"></h3>
  <h4 id="titlelist"></h4>
  <h4 id="descriptionlist"></h4>
  <button onclick="app.logout()" id="logout" hidden>Logout</button>

  <div id="nolist" hidden>
  <h3>Create a List to add items!</h3>
  <form id="nolistForm">
  title:<input type="text" name="listtitle" id="listtitle" required> </br>
  description:<input type="text" name="listdescription" id="listdescription" required> </br>
  <input type="hidden" name="listuserid" id="listuserid" value=""></br>
  <input type="submit" value="submit">
  </form>
  </div>



  <section id="AppView" hidden>
    <form id="form">
    title:<input type="text" name="title" id="title" required> </br>
    priority: <select name="priority" id="priority" required>
        <option value="1" selected>Must Have</option>
        <option value="2">Nice to Have</option>
        <option value="3">If possible</option>
    </select> </br>
    url:<input type="text" name="url" id="url" required></br>
    price:<input type="text" name="price" id="price" required></br>
    <input type="hidden" name="userid" id="mainuserid" value="" required></br>
    <input type="submit" value="submit">
    </form>
    <ol id="wish-list"></ol>
  </section>

  <script type="text/template" id="item-template">
    <div class="view">
      <label>Title : <%= title%></label> </br>
      <label>Priority : <%= app.setPriority(priority)%></label> </br>
      <label>Url : <%= url%></label> </br>
      <label>Price : <%= price%></label> </br>
      <button class="remove">remove</button>
    </div>
    
    <form class="edit" id="editForm">
        title:<input type="text"  name="title" value="<%= title%>" id="title" required> </br>
        priority:<input type="text"  name="priority" value="<%= priority%>" id="priority" required> </br>
        price:<input type="text"  name="price" value="<%= price%>" id="price" required></br>
        <input type="hidden"  name="url" id="url" value="changedurl" required></br>
        <input type="hidden"  name="userid" id="edituserid" value="" required></br>
        <input type="submit" value="save">
    </form>
  </script>

  <div id="sharelist" hidden>
  <input type="text" id="sharelink" readonly="readonly">
  <button onclick="app.copylink()">Get Shareable Link</button>
  </div>


<script type="text/javascript">
var app = app || {};
app.globuserid = sessionStorage.wishlistappUserid;
app.globusername = sessionStorage.wishlistappUsername;
app.globlistcreated = sessionStorage.wishlistappUserlistcreated;
app.globlisttitle = sessionStorage.wishlistappUsertitle;
app.globlistdescription = sessionStorage.wishlistappUserdesc;

if(app.globuserid){
document.getElementById("mainuserid").value = app.globuserid;
document.getElementById("loggedinuser").innerHTML = "Welcome! "+app.globusername;
document.getElementById("titlelist").innerHTML = app.globlisttitle;
document.getElementById("descriptionlist").innerHTML = app.globlistdescription;
document.getElementById("logout").hidden = false;
document.getElementById("sharelist").hidden = false;
} else {
  location.href="http://localhost:8081/CWK2/users/login";
}

app.logout = function(){
  sessionStorage.clear();
  $.ajax({
            url:'http://localhost:8081/CWK2/users/logout',
            type:'GET',
            success:function(){
              location.href="http://localhost:8081/CWK2/users/login";
            }
  });
}

app.copylink = function() {
  document.getElementById("sharelink").value = 'http://localhost:8081/CWK2/share/list/id/'+app.globuserid;
  var copyText = document.getElementById("sharelink");
  copyText.select();
  document.execCommand("copy");
}

app.setPriority = function(priority){
  switch(priority){
    case "1":
      return 'Must have';
      break;
    case "2":
      return 'Nice to have';
      break;
    case "3":
      return 'If possible';
      break;
  }
}


</script>
<script src="<?php echo(base_url());?>js/Models/usermodel.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Models/itemmodel.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Views/itemview.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Collections/itemscollection.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Views/itemsview.js" type="text/javascript"></script>
</body>
</html>