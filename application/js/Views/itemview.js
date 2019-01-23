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