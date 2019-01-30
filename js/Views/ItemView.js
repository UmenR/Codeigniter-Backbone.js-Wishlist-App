var app = app || {};


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
    'click #editbtn' : 'edit',
    'submit #editForm' : 'updateOnEnter',
    'click #removebtn': 'remove'
  },
  edit: function(){
    this.$('#removebtn').hide();
    this.$('#editbtn').hide();
    this.$('#idsptitle').prop( "disabled", false );;
    this.$('#dispopt').prop( "disabled", false );;
    this.$('#dispprice').prop( "disabled", false );;
    this.$('#dispurl').prop( "disabled", false );;
    this.$('#savebtn').show();
  },
  updateOnEnter: function(e){
        e.preventDefault();
        var $inputs = this.$('.edit :input');
        var values = {};
        $inputs.each(function() {
        values[this.name] = $(this).val();
        });
        this.model.save({price:values.price,title:values.title,
        url:values.url,priority:values.priority},
        {
          url:'http://localhost:8081/CWK2/items/item/id/'+this.model.get('id'),
          success:function(){
            app.itemList.sort();
            app.itemView.addAll();
          }
        });
   },
   remove: function(){
        var modelToremove = this.model;
        this.model.destroy(
          {url:'http://localhost:8081/CWK2/items/item/id/'+this.model.get('id'),
            headers:{'Authorization':app.globtoken},
            success: function (object, status){
            app.itemList.remove(modelToremove);
            app.itemView.addAll();
        },
        error: function (errorResponse) {
                console.log(errorResponse)
        }
      });
   }       
});