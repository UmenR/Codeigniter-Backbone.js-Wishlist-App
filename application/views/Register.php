<link rel="stylesheet" type="text/css" href="<?php echo(base_url());?>css/register.css">
</head>
<body>
  <div id="form-container">
  <h1 style="text-align: center">Add Details To Register</h1>
  <form class="form-register" id="registerForm">
        <input type="text"  name="username" id="username" class="form-control" placeholder="Username" required> </br>
        <input type="password"  name="password"  id="password" class="form-control" placeholder="Password"required> </br>
        <input type="text"  name="listtitle"  class="form-control" placeholder="List title" id="listtitle"></br>
        <input type="text"  name="listdescription"  class="form-control" placeholder="List description" id="listdescription"></br>
        <input class="btn btn-primary"  style="margin:0 auto; display:block;" type="submit" placeholder="Username" value="register">
        <small class="form-text" style="padding-top: 25px;">
          <a href="http://localhost:8081/CWK2/users/login"> 
          Already have an account?
        </a></small> </br>
    </form>
  </div>
  
  
  <script type="text/javascript">
    $( "#registerForm" ).submit(function( event ) {
        event.preventDefault();
        var $inputs = $('#registerForm :input');
            var values = {};
            $inputs.each(function() {
            values[this.name] = $(this).val();
            });

        if(values.listtitle === "" || values.listdescription === ""){
            var newmodel = new app.User({username:values.username,password:values.password});
        } else {
            var newmodel = new app.User({username:values.username,password:values.password,listtitle:values.listtitle,
            listdescription:values.listdescription});
        }
            $('#registerForm').trigger('reset');    
            newmodel.save({},{
                url:'http://localhost:8081/CWK2/users/user/actiontype/register',
                success: function(){
                    location.href="http://localhost:8081/CWK2/users/login";
                }
            });
    });
  </script>
  <script src="<?php echo(base_url());?>js/Models/UserModel.js" type="text/javascript"></script>
  
</body>
</html>