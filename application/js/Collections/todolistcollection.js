console.log('AYYYYY');
var app = app || {};

app.ItemListCollection = Backbone.Collection.extend({
  mdoel:app.Item,
  url: 'http://localhost:8081/CWK2/index.php/itemapi/items/userid/'+ app.globuserid,
});
app.itemList = new app.ItemListCollection();