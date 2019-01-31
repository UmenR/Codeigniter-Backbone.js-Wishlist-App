<link rel="stylesheet" type="text/css" href="<?php echo(base_url());?>css/register.css">
</head>
<body>
  <div id="form-container">
  <h1 style="text-align: center">Add Details To Register</h1>
  <form class="form-register" id="registerForm">
        <input type="text"  name="username" id="username" class="form-control" placeholder="Username" pattern="[^' ']+" required> </br>
        <input type="password"  name="password"  id="password" class="form-control" placeholder="Password"required> </br>
        <input type="password"  name="repwd"  id="repwd" class="form-control" placeholder="Confirm Password"required> </br>
        <input type="text"  name="listtitle"  class="form-control" placeholder="List Title" id="listtitle"></br>
        <input type="text"  name="listdescription"  class="form-control" placeholder="List Description" id="listdescription"></br>
        <small id="validationErrors" class="text-danger form-text" 
        hidden></small> </br>
        <input class="btn btn-primary"  style="margin:0 auto; display:block;" type="submit" value="Register">
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
        
        if(values.password === values.repwd){
            $base_url = 'http://localhost:8081/CWK2/users/isunique/username/';
            $.get($base_url+values.username, function(data, status){
                    if(data){
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
                    }else {
                        document.getElementById("validationErrors").innerHTML = "Username Already Exists!"
                        document.getElementById("validationErrors").hidden=false;
                    }  
                });
        } else {
            document.getElementById("validationErrors").innerHTML = "Passwords do not match!"
            document.getElementById("validationErrors").hidden=false;
        }
    });
  </script>
  <script src="<?php echo(base_url());?>js/Models/UserModel.js" type="text/javascript"></script>
  
</body>
</html>