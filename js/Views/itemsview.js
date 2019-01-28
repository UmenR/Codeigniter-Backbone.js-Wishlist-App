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

            sessionStorage.wishlistappUserlistcreated = 1;
            sessionStorage.wishlistappUsertitle = values.listtitle;
            sessionStorage.wishlistappUserdesc = values.listdescription;
          }
        });
      });
    }
  },
  events: {
      'submit #form': 'createNewItem',
      'click #sortbypri' : 'sortbyPriority',
      'click #sortbyid' : 'sortbyId',
      'click #sharelinkbtn' : 'shareLink'
  },
  sortbyId: function(){
    this.$('#sortbypri').show();
    this.$('#sortbyid').hide();
    app.itemList.comparator = 'id';
    app.itemList.sort();
    app.itemView.addAll();
  },
  sortbyPriority: function(){
    this.$('#sortbyid').show();
    this.$('#sortbypri').hide();
    app.itemList.comparator = 'priority';
    app.itemList.sort();
    app.itemView.addAll();
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
  shareLink: function(){
    this.$('#sharelink').show();
    document.getElementById("sharelink").value = 'http://localhost:8081/CWK2/share/list/id/'+app.globuserid;
    var copyText = document.getElementById("sharelink");
    copyText.select();
    document.execCommand("copy");
  },
  addOne: function(todo) {
      var view = new app.ItemView({model: todo});
      $('#wish-list').append(view.render().el);
  },
  addAll: function() {
    if(app.itemList.length > 1){
      this.$('#srtbtns').show();
      this.$('#stats').show();
      this.$('#sharelist').show();
      this.$('#noitms').hide();
      this.calculateStats();
    } else if (app.itemList.length > 0) {
      this.$('#srtbtns').hide();
      this.$('#stats').show();
      this.$('#sharelist').show();
      this.$('#noitms').hide();
      this.calculateStats();
    } else {
      this.$('#srtbtns').hide();
      this.$('#stats').hide();
      this.$('#sharelist').hide();
      this.$('#noitms').show();
    }


    this.$('#wish-list').html(''); // clean the todo list
      app.itemList.each(this.addOne, this);
  },
  calculateStats: function(){
    var priceArr = app.itemList.pluck("price");
    var total = 0;
    priceArr.map(function(price){
      var priceFloat = parseFloat(price);
      total += priceFloat;
    });
    this.$('#totprice').text("Total price : $"+total);
    this.$('#totitems').text("Total Items : "+app.itemList.length);
  }
});
app.itemView = new app.ItemsView();