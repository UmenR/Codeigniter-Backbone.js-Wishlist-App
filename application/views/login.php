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

  <div id="container">Loading...</div>
  
  
  <script type="text/javascript">
//     var AppView = Backbone.View.extend({
//   el: $('#container'),
//   // template which has the placeholder 'who' to be substitute later
//   template: _.template("<h3>Hello <%= who %></h3>"),
//   initialize: function(){
//     this.render();
//   },
//   render: function(){
//     // render the function using substituting the varible 'who' for 'world!'.
//     this.$el.html(this.template({who: 'world!'}));
//     //***Try putting your name instead of world.
//   }
// });

// var appView = new AppView();
var Todo = Backbone.Model.extend({
  defaults:{
    title:"",
    priority:1,
    price:0,
    id:-1
  }
});


var ToDoListCollection = Backbone.Collection.extend({
        
        mdoel:Todo,
        //Specify REST URL
        url: 'http://localhost:8081/CWK2/index.php/itemapi/items/userid/4',
        
        initialize: function () {
          // this.bind("reset", function (model, options) {
          //   console.log("Inside event");
          //   console.log(model);
            
          // });
          console.log('Initializing')
        }	
      });
      
      var TodoList = new ToDoListCollection();
            
      TodoList.fetch({
        success: function(response,xhr) {
          //  console.log("Inside success");
          //  console.log(response);
           console.log(TodoList.toJSON());

        },
        error: function (errorResponse) {
          console.log('ERROOR');
               console.log(errorResponse)
        }
      });
  </script>
  
</body>
</html>