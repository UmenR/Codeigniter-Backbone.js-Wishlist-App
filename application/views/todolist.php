<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>To-do App</title>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">

  <style type="text/css">
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
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script> -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
  
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js" type="text/javascript"></script> -->
  <script src="https://underscorejs.org/underscore-min.js" type="text/javascript"></script>
  
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone.js/0.9.2/backbone-min.js" type="text/javascript"></script> -->
  <script src="http://backbonejs.org/backbone-min.js" type="text/javascript"></script>
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone-localstorage.js/1.0/backbone.localStorage-min.js" type="text/javascript"></script>  -->

  <!-- <div id="container"></div> -->
  
  <h3 id="loggedinuser"></h3>
  <h4 id="titlelist"></h4>
  <h4 id="descriptionlist"></h4>

  <div id="nolist" hidden>
  <h3>Create a List to add items!</h3>
  <form id="nolistForm">
  title:<input type="text" name="listtitle" id="listtitle" required> </br>
  description:<input type="text" name="listdescription" id="listdescription" required> </br>
  <input type="hidden" name="listuserid" id="listuserid" value=""></br>
  <input type="submit" value="submit">
  </form>
  </div>



  <section id="AppView" hidden>
    <form id="form">
    title:<input type="text" name="title" id="title" required> </br>
    priority:<input type="text" name="priority" id="priority" required> </br>
    url:<input type="text" name="url" id="url" required></br>
    price:<input type="text" name="price" id="price" required></br>
    <input type="hidden" name="userid" id="mainuserid" value="" required></br>
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
        title:<input type="text"  name="title" value="<%= title%>" id="title" required> </br>
        priority:<input type="text"  name="priority" value="<%= priority%>" id="priority" required> </br>
        price:<input type="text"  name="price" value="<%= price%>" id="price" required></br>
        <input type="hidden"  name="url" id="url" value="changedurl" required></br>
        <input type="hidden"  name="userid" id="edituserid" value="" required></br>
        <input type="submit" value="save">
    </form>
    
  </script>

<script type="text/javascript">
var app ={};

app.globuserid = sessionStorage.todoappUserid;
app.globusername = sessionStorage.todoappUsername;
app.globlistcreated = sessionStorage.todoappUserlistcreated;
app.globlisttitle = sessionStorage.todoappUsertitle;
app.globlistdescription = sessionStorage.todoappUserdesc;

if(app.globuserid){
document.getElementById("mainuserid").value = app.globuserid;
document.getElementById("loggedinuser").innerHTML = "Welcome! "+app.globusername;
document.getElementById("titlelist").innerHTML = app.globlisttitle;
document.getElementById("descriptionlist").innerHTML = app.globlistdescription;
} else {
  location.href="http://localhost:8081/CWK2/index.php/userapi/login";
}



app.Item = Backbone.Model.extend({
    save: function (attributes,options){
    var model = this;
    if (model.isNew()){
        $.ajax({
            url:'http://localhost:8081/CWK2/index.php/itemapi/item',
            type:'POST',
            dataType: 'json',
            data: model.toJSON(),
            success: function (inserid, status){
            model.set({id:inserid});
            model.fetch({
                    url:'http://localhost:8081/CWK2/index.php/itemapi/item/id/'+model.get('id'),
                    success:function(){
                      app.itemList.add(model);
                      app.itemView.addAll();
                    }
                });
            },
            error: function (errorResponse) {
                    console.log(errorResponse)
                }
        });
    } else {
      $.ajax({
            url:'http://localhost:8081/CWK2/index.php/itemapi/item/id/'+model.get('id'),
            type:'PUT',
            dataType: 'json',
            data: attributes,
            success: function (inserid, status){
            model.fetch({
                    url:'http://localhost:8081/CWK2/index.php/itemapi/item/id/'+model.get('id'),
                    success:function(){
                      app.itemView.addAll();
                    }
                });
            },
            error: function (errorResponse) {
                    console.log(errorResponse)
                }
        });
    }
    },
    defaults:{
        title:"",
        priority:1,
        price:0,
        userid:4
    }
});

app.ItemView = Backbone.View.extend({
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
        'click .remove': 'remove'
      },
      edit: function(){
        this.$el.addClass('editing');
        this.editForm.focus();
      },
      updateOnEnter: function(e){
            e.preventDefault();
            var $inputs = this.$('.edit :input');
            var values = {};
            $inputs.each(function() {
            values[this.name] = $(this).val();
            });
            // TODO validations
            
            this.model.save({price:values.price,title:values.title,
            url:values.url,priority:values.priority},
            {url:'http://localhost:8081/CWK2/index.php/itemapi/item/id/'+this.model.get('id')});
            this.$el.removeClass('editing');
       },
       remove: function(){
            var modelToremove = this.model;
            this.model.destroy({url:'http://localhost:8081/CWK2/index.php/itemapi/item/id/'+this.model.get('id'),
                success: function (object, status){
                app.itemList.remove(modelToremove);
                app.itemView.addAll();
            },
            error: function (errorResponse) {
                    console.log(errorResponse)
            }});
       }       
    });


app.ItemListCollection = Backbone.Collection.extend({
        mdoel:app.Item,
        url: 'http://localhost:8081/CWK2/index.php/itemapi/items/userid/'+ app.globuserid,
      });
app.itemList = new app.ItemListCollection();
            
      app.ItemsView = Backbone.View.extend({
        el: '#AppView',
        initialize: function(){
          if(app.globlistcreated == 1) {
            document.getElementById("AppView").hidden = false;
            this.form = this.$('#form');
            app.itemList.fetch().then(
              function(){
                app.itemView.addAll();
              });
          } else if (app.globuserid) {
            document.getElementById("nolist").hidden = false;
            document.getElementById("AppView").hidden = true;
            $( "#nolistForm" ).submit(function( event ) {
              event.preventDefault();
              var $inputs = $('#nolistForm :input');
              var values = {};
              $inputs.each(function() {
              values[this.name] = $(this).val();
              });
              $.ajax({
                url:'http://localhost:8081/CWK2/index.php/userapi/user/id/'+ app.globuserid,
                type:'PUT',
                dataType: 'json',
                data: values,
                success:function(userid){
                  document.getElementById("nolist").hidden = true;
                  document.getElementById("AppView").hidden = false;
                  document.getElementById("titlelist").innerHTML = values.listtitle;
                  document.getElementById("descriptionlist").innerHTML = values.listdescription;

                  sessionStorage.todoappUserlistcreated = 1;
                  sessionStorage.todoappUsertitle = values.listtitle;
                  sessionStorage.todoappUserdesc = values.listdescription;
                },
                error: function (errorResponse) {
                        console.log(errorResponse)
                    }
            });
            });
          }
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

            var newmodel = new app.Item({price:values.price,title:values.title,userid:values.userid,
            url:values.url,priority:values.priority});
            $('#form').find("input[type=text]").val("");    
            newmodel.save();
        },
        addOne: function(todo) {
            var view = new app.ItemView({model: todo});
            $('#todo-list').append(view.render().el);
        },
        addAll: function() {
            this.$('#todo-list').html(''); // clean the todo list
            app.itemList.each(this.addOne, this);
        },
    });
    app.itemView = new app.ItemsView();
      
  </script>
  
</body>
</html>

 