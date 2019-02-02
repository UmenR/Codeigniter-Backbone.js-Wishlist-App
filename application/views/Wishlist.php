<link rel="stylesheet" type="text/css" href="<?php echo(base_url());?>css/wishlist.css">
</head>
<body>
<div class=" text-white bg-primary mb-3" style="margin-top:0px; width: 100%;">
  <div class="card-header" >
  <h1 style="text-align: center" id="loggedinuser"></h1>
  </div>
  <div style="display:flex;" class="card-body">
    <div>
      <h3  id="titlelist"></h3>
      <h6  id="descriptionlist"></h6>
    </div>
    <div style="margin-left: auto; order: 2; display:flex">
    <button onclick="app.sharelink()" id="sharelinkbtn" style="height:40px; margin-right:5px;" class="btn btn-secondary" >Get Shareable Link</button>
    <textarea type="text" name="sharelink" id="sharelink" style="height:0px;width:0px;opacity:0"></textarea>
    <button onclick="app.logout()"  style="height:40px" class="btn btn-danger" id="logout" hidden>Logout</button>
    </div>
  </div>
</div>

  <div id="nolist" hidden>
  <h3 class="text-primary" style="text-align: center">Create a List to add items!</h3>
  <form id="nolistForm">
  <input type="text" name="listtitle" id="listtitle" placeholder="List title" class="form-control" required autofocus> </br>
  <input type="text" name="listdescription" id="listdescription" placeholder="List description" class="form-control" required> </br>
  <input type="hidden" name="listuserid" id="listuserid" value=""></br>
  <input type="submit" style="margin:0 auto; display:block;" class="btn btn-success" value="Create List">
  <small id="validationErrorsNoListForm" class="text-danger form-text" style="text-align:center; margin:30px;display:none">Please enter valid names</small> </br>
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

    <input type="url" name="url" id="url" placeholder="Item url" class="form-control" required></br>
    <input type="number" min="1" step="0.01" name="price" id="price" placeholder="Item price" class="form-control" required></br>
    <input type="hidden" name="userid" id="mainuserid" value="" class="form-control" required></br>
    <input type="submit" class="btn btn-success" style="margin:0 auto; margin-top: -40px; margin-bottom: 60px; display:block;" value="Add">
    <small id="validationErrorsForm" class="text-danger form-text" style="display:none">Please enter a valid name</small> </br>
    </form>
    <hr>
    <h5 class="text-info" style="margin:15px; text-align:center" id="noitms">No items in wishlist!</h5>
      <div id="srtbtns" style="display:none;"> 
        <button type="button" id="sortbypri" class="btn btn-info" style="margin:45px">Sort by priority</button>
        <button type="button" id="sortbyid" class="btn btn-info" style="display:none; margin:45px">Sort by item order</button>
      </div>
    <ul style="list-style-type: none;" id="wish-list"></ul>
  

    
  </section>
  <script type="text/template" id="item-template">
    <form class="edit" id="editForm">
        <input type="text"  name="title" value="<%= title%>" id="idsptitle" class="form-control form-control-sm" disabled required> </br>
        <select name="priority" id="dispopt" disabled class="form-control form-control-sm" >
        <%= app.setPriority(priority)%>
        </select> </br>
        <input type="url"  name="url" id="dispurl" value="<%= url%>" class="form-control form-control-sm" disabled required></br>
        <input type="number" step="0.01"  name="price" value="<%= price%>" id="dispprice" class="form-control form-control-sm" disabled required></br>
        <input type="hidden"  name="userid" id="edituserid" value="" class="form-control form-control-sm" disabled required></br>
        <div class="editFormButtons" >
          <button type="submit" class="btn btn-success" id="savebtn" style="display:none"> Save</button>
          <button type="button" style="float:right" class="btn btn-secondary" id="editbtn" class="enable">Edit</button>
          <button type="button"  style="float:right" class="btn btn-danger" id="removebtn">Remove</button>
        </div>
    </form>
  </script>

<script type="text/javascript">
var app = app || {};
app.globuserid = sessionStorage.wishlistappUserid;
app.globusername = sessionStorage.wishlistappUsername;
app.globlistcreated = sessionStorage.wishlistappUserlistcreated;
app.globlisttitle = sessionStorage.wishlistappUsertitle;
app.globlistdescription = sessionStorage.wishlistappUserdesc;
app.globtoken = sessionStorage.usertoken;

if(app.globuserid){
document.getElementById("mainuserid").value = app.globuserid;
document.getElementById("loggedinuser").innerHTML = app.globusername + " 's Wish List";
if(app.globlisttitle != "") {
  document.getElementById("titlelist").innerHTML = app.globlisttitle;
  document.getElementById("descriptionlist").innerHTML = app.globlistdescription;
} 
document.getElementById("logout").hidden = false;

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

app.sharelink = function(){
  swal({
      title: "Link Copied To Clipboard!",
      icon: "success",
      button: "Ok!",
    });
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
<script src="<?php echo(base_url());?>js/Models/UserModel.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Models/ItemModel.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Views/ItemView.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Collections/ItemsCollection.js" type="text/javascript"></script>
<script src="<?php echo(base_url());?>js/Views/ItemsView.js" type="text/javascript"></script>
</body>
</html>