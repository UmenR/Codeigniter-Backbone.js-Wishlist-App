var app = app || {};

app.ItemsView = Backbone.View.extend({
    el: '#view-tempate',
    initialize: function(){
      if(app.globlistcreated == 1) {
        this.form = this.$('#form');
        app.itemList.fetch().then(
          function(){
            app.itemView.addAll();
          });
      } else {
        document.getElementById("nolist").hidden = false;
        document.getElementById("form").hidden = true;
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
              document.getElementById("form").hidden = false;
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