<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>To-do App</title>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">

  <style type="text/css">
    #todoapp ul {
      list-style-type: none; /* Hides bullet points from todo list */
    }
    #todo-list form.edit {
      display: none; /* Hides input box*/
    }
    #todo-list .editing label {
      display: none; /* Hides label text when .editing*/
    }    
    #todo-list .editing form.edit {
      display: inline; /* Shows input text box when .editing*/
    }    
  </style> 
</head>
<body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js" type="text/javascript"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone.js/0.9.2/backbone-min.js" type="text/javascript"></script>
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone-localstorage.js/1.0/backbone.localStorage-min.js" type="text/javascript"></script>  -->

  <!-- <div id="container">Loading...</div> -->
  
  <section id="view-tempate">
    <form id="form">
    <!-- Form input fields here (do not forget your name attributes). -->
    title:<input type="text" name="title" id="title"> </br>
    priority:<input type="text" name="priority" id="priority"> </br>
    url:<input type="text" name="url" id="url"></br>
    price:<input type="text" name="price" id="price"></br>
    <input type="hidden" name="userid" id="userid" value=4></br>
    <input type="submit" value="submit">
    </form>
    <ol id="todo-list">
    
    </ol>
  </section>

  <script type="text/template" id="item-template">
    <div class="view">
      <label>Title: <%= title%></label> </br>
      <label>Priority:<%= priority%></label> </br>
      <label>Price:<%= price%></label> </br>
      <button class="remove">remove</button>
    </div>
    
    <form class="edit" id="editForm">
        <!-- Form input fields here (do not forget your name attributes). -->
        title:<input type="text"  name="title" value="<%= title%>" id="title"> </br>
        priority:<input type="text"  name="priority" value="<%= priority%>" id="priority"> </br>
        price:<input type="text"  name="price" value="<%= price%>" id="price"></br>
        <input type="hidden"  name="url" id="url" value="changedurl"></br>
        <input type="hidden"  name="userid" id="userid" value=4></br>
        <input type="submit" value="save">
    </form>
    
  </script>

  <script type="text/javascript">

  //
    


var Todo = Backbone.Model.extend({
    save: function (options){
    var model = this;
    // console.log(model.toJSON());
    // console.log(model.isNew())
    if (model.isNew()){
        $.ajax({
            url:'http://localhost:8081/CWK2/index.php/itemapi/item',
            type:'POST',
            dataType: 'json',
            data: model.toJSON(),
            success: function (object, status){
            console.log('Hooo');
            todoList.fetch();
            },
            error: function (errorResponse) {
                console.log('ERRR');
                    console.log(errorResponse)
                }
        });
        // console.log('New');
    } else {
        console.log('Not new');
    }
    },
    defaults:{
        title:"",
        priority:1,
        price:0,
        userid:4
    }
});

TodoitemView = Backbone.View.extend({
      tagName: 'li',
      template: _.template($('#item-template').html()),
      initialize: function(){
        this.model.on('change', this.render, this);
      },
      render: function(){
        this.$el.html(this.template(this.model.toJSON()));
        this.editForm = this.$('#editForm');
        return this; // enable chained calls
      },
      events : {
        'dblclick label' : 'edit',
        'submit #editForm' : 'updateOnEnter',
        'blur .edit' : 'close',
        'click .remove': 'remove'
      },
      edit: function(){
        this.$el.addClass('editing');
        this.editForm.focus();
      },
      close: function(){
        // var value = this.input.val().trim();
        // if(value) {
        //   this.model.save({title: value});
        // }
        this.$el.removeClass('editing');
      },
      updateOnEnter: function(e){
        //   console.log('inupdate');
            e.preventDefault();
            var $inputs = this.$('.edit :input');
            var values = {};
            $inputs.each(function() {
            values[this.name] = $(this).val();
            });
            // TODO validations
            console.log(this.model);
            console.log(values);
            this.model.save({price:values.price,title:values.title,
            url:values.url,priority:values.priority},
            {url:'http://localhost:8081/CWK2/index.php/itemapi/item/id/'+this.model.get('id'),
                success: function (object, status){
                console.log('Hooo');
                todoList.fetch();
            },
            error: function (errorResponse) {
                    console.log('ERRR');
                    console.log(errorResponse)
            }});
            this.$el.removeClass('editing');
       },
       remove: function(){
            this.model.destroy({url:'http://localhost:8081/CWK2/index.php/itemapi/item/id/'+this.model.get('id'),
                success: function (object, status){
                console.log('Hooo');
                todoList.fetch();
            },
            error: function (errorResponse) {
                    console.log('ERRR');
                    console.log(errorResponse)
            }});
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
      
      var todoList = new ToDoListCollection();
            
    //   TodoList.fetch({
    //     success: function(response,xhr) {
    //         // _.each(response)
    //         // console.log(response);
    //         // toDoView.render();
    //     },
    //     error: function (errorResponse) {
    //            console.log(errorResponse)
    //     }
    //   });

      var TodoView = Backbone.View.extend({
        el: '#view-tempate',
        // template: _.template($("#view-tempate").html()),
        initialize: function(){
            this.form = this.$('#form')
            todoList.on('add', this.addAll, this);
            todoList.on('reset', this.addAll, this);
            todoList.fetch();
            
        },
        events: {
            'submit #form': 'createNewTodo'
        },
        createNewTodo: function(e){
            
            e.preventDefault();
            var $inputs = $('#form :input');
            var values = {};
            $inputs.each(function() {
            values[this.name] = $(this).val();
            });
            // TODO validations

            var newmodel = new Todo({price:values.price,title:values.title,userid:values.userid,
            url:values.url,priority:values.priority});
            $('#form').find("input[type=text]").val("");    
            newmodel.save();
        },
        addOne: function(todo) {
            // console.log(todo.isNew());
            var view = new TodoitemView({model: todo});
            $('#todo-list').append(view.render().el);
        },
        addAll: function() {
            this.$('#todo-list').html(''); // clean the todo list
            todoList.each(this.addOne, this);
        }
        // render: function(){
        //     this.$el.html(this.template({
        //         collection:this.collection.toJSON()
        //     }));
        //     console.log(this.collection.toJSON());
        // }
    });
    var toDoView = new TodoView();
      
  </script>
  
</body>
</html>

 