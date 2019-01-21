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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js" type="text/javascript"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone.js/0.9.2/backbone-min.js" type="text/javascript"></script>
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone-localstorage.js/1.0/backbone.localStorage-min.js" type="text/javascript"></script>  -->



<form id="form">
    <!-- Form input fields here (do not forget your name attributes). -->
    title:<input type="text" name="title" id="title"> </br>
    priority:<input type="text" name="priority" id="priority"> </br>
    url:<input type="text" name="url" id="url"></br>
    price:<input type="text" name="price" id="price"></br>
    <input type="hidden" name="userid" id="userid" value=4></br>
    <input type="submit" value="submit">
</form>





  <div id="container">Loading...</div>
  
  <script type="text/template" id="view-tempate">
  <ol>
    <% _.each(this.collection.toJSON(),function(model){ %>
       <li> <p>Title: <%= model.title%></p> </br>
            <p>Priority:<%= model.priority%></p> </br>
            <p>Price:<%= model.price%></p> </br>
            <button>Clickme</button>
        </li> 
    <%}) %>
  </ol>
  </script>

  <script type="text/javascript">

  //
    $("form").submit(function(e){
    e.preventDefault();
    var $inputs = $('#form :input');
    var values = {};
    $inputs.each(function() {
        values[this.name] = $(this).val();
    });
    // console.log(values);
    // TODO validations

    var newmodel = new Todo({price:values.price,title:values.title,userid:values.userid,
        url:values.url,priority:values.priority});
    newmodel.save();
    });


var Todo = Backbone.Model.extend({
    save: function (options){
  var model = this;
  $.ajax({
    url:'http://localhost:8081/CWK2/index.php/itemapi/item',
    type:'POST',
    dataType: 'json',
    data: model.toJSON(),
    success: function (object, status){
      console.log('Hooo');
      TodoList.fetch({
        success: function(response,xhr) {
            // _.each(response)
            // console.log(response);
            toDoView.render();
        },
        error: function (errorResponse) {
               console.log(errorResponse)
        }
      });
    },
    error: function (errorResponse) {
        console.log('ERRR');
               console.log(errorResponse)
        }
})
},
  defaults:{
    title:"",
    priority:1,
    price:0,
    userid:4
  }
});



var ToDoListCollection = Backbone.Collection.extend({
        
        mdoel:Todo,
        url: 'http://localhost:8081/CWK2/index.php/itemapi/items/userid/4',
        
        initialize: function () {
          // this.bind("reset", function (model, options) {
          //   console.log("Inside event");
          //   console.log(model);
            
          // });
        //   console.log('Initializing')
        }	
      });
      
      var TodoList = new ToDoListCollection();
            
      TodoList.fetch({
        success: function(response,xhr) {
            // _.each(response)
            // console.log(response);
            toDoView.render();
        },
        error: function (errorResponse) {
               console.log(errorResponse)
        }
      });

      var TodoView = Backbone.View.extend({
        el: $('#container'),
        collection:TodoList,
        template: _.template($("#view-tempate").html()),
        initialize: function(){
            this.render();
            
        },
        render: function(){
            this.$el.html(this.template({
                collection:this.collection.toJSON()
            }));
            console.log(this.collection.toJSON());
        }
    });
    var toDoView = new TodoView();
      
  </script>
  
</body>
</html>