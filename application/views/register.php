<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>To-do App</title>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
</head>
<body>
 <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script> -->
 <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
  
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js" type="text/javascript"></script> -->
  <script src="https://underscorejs.org/underscore-min.js" type="text/javascript"></script>
  
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone.js/0.9.2/backbone-min.js" type="text/javascript"></script> -->
  <script src="http://backbonejs.org/backbone-min.js" type="text/javascript"></script>
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone-localstorage.js/1.0/backbone.localStorage-min.js" type="text/javascript"></script>  -->

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
    var User = Backbone.Model.extend({
    // save: function (attributes,options){
    // var model = this;
    //     $.ajax({
    //         url:'http://localhost:8081/CWK2/index.php/userapi/register',
    //         type:'POST',
    //         dataType: 'json',
    //         data: model.toJSON(),
    //         success:function(userid){
    //             location.href="http://localhost:8081/CWK2/index.php/userapi/login";
    //         },
    //         error: function (errorResponse) {
    //                 console.log(errorResponse)
    //             }
    //     });
    // },
    defaults:{
        username:"",
        password:"",
        listcreated:0,
        listtitle:"",
        listdescription:""
    }
    });

    $( "#registerForm" ).submit(function( event ) {
        event.preventDefault();
        var $inputs = $('#registerForm :input');
            var values = {};
            $inputs.each(function() {
            values[this.name] = $(this).val();
            });

        if(values.listtitle === "" || values.listdescription === ""){
            var newmodel = new User({username:values.username,password:values.password});
        } else {
            var newmodel = new User({username:values.username,password:values.password,listtitle:values.listtitle,
            listdescription:values.listdescription});
        }
            $('#registerForm').find("input[type=text]").val("");    
            newmodel.save({},{
                url:'http://localhost:8081/CWK2/users/user/actiontype/register',
                success: function(){
                    location.href="http://localhost:8081/CWK2/users/login";
                }
            });
    });
  </script>
  
</body>
</html>