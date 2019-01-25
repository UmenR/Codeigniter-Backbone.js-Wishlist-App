var app = app || {};

app.User = Backbone.Model.extend({
    defaults:{
        username:"",
        password:"",
        listcreated:0,
        listtitle:"",
        listdescription:""
    }
});