var app = app || {};

app.ItemListCollection = Backbone.Collection.extend({
  mdoel:app.Item,
  url: 'http://localhost:8081/CWK2/items/allitems/userid/'+ app.globuserid,
});
app.itemList = new app.ItemListCollection();