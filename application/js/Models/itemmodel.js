var app = app || {};

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