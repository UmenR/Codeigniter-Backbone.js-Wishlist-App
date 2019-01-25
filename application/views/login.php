  <div id="form-container">
  <form id="loginForm">
        Username:<input type="text"  name="username" id="username" required> </br>
        Password:<input type="password"  name="password"  id="password" required> </br>
        <label id="validationErrors" hidden>Invalid credentials please Re-enter</label> </br>
        <input type="submit" value="register">
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
                sessionStorage.todoappUserid = userdata.attributes.id;
                sessionStorage.todoappUsername = userdata.attributes.username;
                sessionStorage.todoappUserlistcreated = userdata.attributes.listcreated;
                sessionStorage.todoappUsertitle = userdata.attributes.listtitle;
                sessionStorage.todoappUserdesc = userdata.attributes.listdescription;
                location.href="http://localhost:8081/CWK2/items/index";
            },
            error: function (errorResponse) {
                  document.getElementById("validationErrors").hidden=false;
                }
            });
    });
  </script>
  <script src="<?php echo(base_url());?>js/Models/usermodel.js" type="text/javascript"></script>
</body>
</html>