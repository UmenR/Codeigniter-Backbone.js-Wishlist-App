  <div id="form-container">
  <form id="registerForm">
        Username:<input type="text"  name="username" id="username" required> </br>
        Password:<input type="password"  name="password"  id="password" required> </br>
        List Title:<input type="text"  name="listtitle"  id="listtitle"></br>
        List Description:<input type="text"  name="listdescription"  id="listdescription"></br>
        <input type="submit" value="register">
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
  <script src="<?php echo(base_url());?>js/Models/usermodel.js" type="text/javascript"></script>
  
</body>
</html>