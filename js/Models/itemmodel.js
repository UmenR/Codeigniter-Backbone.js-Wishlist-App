var app = app || {};

app.Item = Backbone.Model.extend({
    defaults:{
        title:"",
        priority:1,
        price:0,
        userid:4
    }
});