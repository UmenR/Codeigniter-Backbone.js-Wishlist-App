var app = app || {};

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
        var loginUser = new app.User();
        loginUser.set({
          id:app.globuserid,
          listtitle:values.listtitle,
          listdescription:values.listdescription
        });

        loginUser.save({},{
          url:'http://localhost:8081/CWK2/users/user/id/'+ app.globuserid,
          success:function(userid){
            document.getElementById("nolist").hidden = true;
            document.getElementById("AppView").hidden = false;
            document.getElementById("titlelist").innerHTML = values.listtitle;
            document.getElementById("descriptionlist").innerHTML = values.listdescription;

            sessionStorage.todoappUserlistcreated = 1;
            sessionStorage.todoappUsertitle = values.listtitle;
            sessionStorage.todoappUserdesc = values.listdescription;
          }
        });
      });
    }
  },
  events: {
      'submit #form': 'createNewItem'
  },
  createNewItem: function(e){
      
      e.preventDefault();
      var $inputs = $('#form :input');
      var values = {};
      $inputs.each(function() {
      values[this.name] = $(this).val();
      });
      var newmodel = new app.Item();
      $('#form').trigger('reset');    
      newmodel.save({price:values.price,title:values.title,userid:values.userid,
      url:values.url,priority:values.priority},{
        url:'http://localhost:8081/CWK2/items/item',
        success: function (updatedmodel){
          app.itemList.add(updatedmodel);
          app.itemView.addAll();
      }
      });
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