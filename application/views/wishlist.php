<link rel="stylesheet" type="text/css" href="<?php echo(base_url());?>css/wishlist.css">
</head>
<body>
  <h1 class="text-primary" style="text-align: center" id="loggedinuser"></h1>
  <h4 class="text-primary" id="titlelist"></h4>
  <h4 class="text-primary" id="descriptionlist"></h4>
  

  <div id="nolist" hidden>
  <h3 class="text-primary">Create a List to add items!</h3>
  <form id="nolistForm">
  <input type="text" name="listtitle" id="listtitle" placeholder="List title" class="form-control" required autofocus> </br>
  <input type="text" name="listdescription" id="listdescription" placeholder="List description" class="form-control" required> </br>
  <input type="hidden" name="listuserid" id="listuserid" value=""></br>
  <input type="submit" class="btn btn-success" value="Create List">
  </form>
  </div>



  <section id="AppView" hidden>
    <form id="form">
    <input type="text" name="title" id="title" placeholder="Item title" class="form-control" required> </br>
    <select name="priority" class="form-control" id="priority" required>
        <option selected disabled hidden value="" required>item priority</option>
        <option value="1">Must Have</option>
        <option value="2">Nice to Have</option>
        <option value="3">If possible</option>
    </select> </br>
    <input type="text" name="url" id="url" placeholder="Item url" class="form-control" required></br>
    <input type="text" name="price" id="price" placeholder="Item price" class="form-control" required></br>
    <input type="hidden" name="userid" id="mainuserid" value="" class="form-control" required></br>
    <input type="submit" value="submit">
    </form>
    <ol id="wish-list"></ol>
  </section>

  <script type="text/template" id="item-template">
    
    
    <form class="edit" id="editForm">
        <input type="text"  name="title" value="<%= title%>" id="title" required> </br>
        <select name="priority" id="dispopt" >
        <%= app.setPriority(priority)%>
        </select> </br>
        <input type="text"  name="price" value="<%= price%>" id="price" required></br>
        <input type="hidden"  name="url" id="url" value="changedurl" required></br>
        <input type="hidden"  name="userid" id="edituserid" value="" required></br>
        <input type="submit" value="save">
    </form>
    <button class="remove" id="removebtn">remove</button>
    <button class="enable">Edit</button>
  </script>

  <div class="sharesection" id="sharelist" hidden>
    <button id="sharelinkbtn" class="btn btn-secondary" onclick="app.copylink()">Get Shareable Link</button>
    <input style="width:500px" type="text" id="sharelink" class="form-control" readonly="readonly" hidden>
  </div>

<button onclick="app.logout()" id="logout" hidden>Logout</button>
<script type="text/javascript">
var app = app || {};
app.globuserid = sessionStorage.wishlistappUserid;
app.globusername = sessionStorage.wishlistappUsername;
app.globlistcreated = sessionStorage.wishlistappUserlistcreated;
app.globlisttitle = sessionStorage.wishlistappUsertitle;
app.globlistdescription = sessionStorage.wishlistappUserdesc;

if(app.globuserid){
document.getElementById("mainuserid").value = app.globuserid;
document.getElementById("loggedinuser").innerHTML = app.globusername + " 's Wish List";
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
  document.getElementById("sharelink").hidden = false;
  document.getElementById("sharelink").value = 'http://localhost:8081/CWK2/share/list/id/'+app.globuserid;
  var copyText = document.getElementById("sharelink");
  copyText.select();
  document.execCommand("copy");
}
app.setPriority = function(priority){
  switch(priority){
    case "1":
    return '<option value="1" selected>Must Have </option> <option value="2">Nice to Have</option><option value="3">If possible</option>';
    break;
    case "2":
    return '<option value="1">Must Have </option> <option value="2" selected>Nice to Have</option><option value="3">If possible</option>';
    break;
    case "3":
    return '<option value="1" >Must Have </option> <option value="2">Nice to Have</option><option value="3" selected>If possible</option>';
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