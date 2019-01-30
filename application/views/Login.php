<link rel="stylesheet" type="text/css" href="<?php echo(base_url());?>css/login.css">
</head>
<body>
  <div id="form-container">
  <h1 style="text-align: center">Please Sign in</h1>
  <form class="form-signin" id="loginForm">
        <input type="text"  name="username" id="username" class="form-control" 
        placeholder="User Name" autofocus required> </br>
        <input type="password"  name="password"  id="password" class="form-control" 
        placeholder="Password" required> </br>
        <small id="validationErrors" class="text-danger form-text" 
        hidden>Invalid credentials please Re-enter</small> </br>
        <input class="btn btn-primary"  style="margin:0 auto; display:block;" type="submit" value="Login"></br>
        <small class="form-text">
          <a href="http://localhost:8081/CWK2/users/register"> 
          Dont have an account?
        </a></small> </br>
  </form>
  </div>
  
  
  <script type="text/javascript">
    var userLoginModel = null;

    $( "#loginForm" ).submit(function( event ) {
        document.getElementById("validationErrors").hidden=true;
        event.preventDefault();
        var $inputs = $('#loginForm :input');
            var values = {};
            $inputs.each(function() {
            values[this.name] = $(this).val();
            });

        var newmodel = new app.User({username:values.username,password:values.password});
            $('#loginForm').trigger('reset');    
            newmodel.save({},{
                url:'http://localhost:8081/CWK2/users/user/actiontype/login',
                success:function(userdata){
                sessionStorage.wishlistappUserid = userdata.attributes.user.id;
                sessionStorage.wishlistappUsername = userdata.attributes.user.username;
                sessionStorage.wishlistappUserlistcreated = userdata.attributes.user.listcreated;
                sessionStorage.wishlistappUsertitle = userdata.attributes.user.listtitle;
                sessionStorage.wishlistappUserdesc = userdata.attributes.user.listdescription;
                sessionStorage.usertoken = userdata.attributes.token;
                location.href="http://localhost:8081/CWK2/items/index";
            },
            error: function (errorResponse) {
                  document.getElementById("validationErrors").hidden=false;
                }
            });
    });
  </script>
  <script src="<?php echo(base_url());?>js/Models/UserModel.js" type="text/javascript"></script>
</body>
</html>