<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Share </title>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
  
</head>
<body>
  <?php 
  if($userdata->listtitle == NULL  || $userdata->listdescription == NULL){
    echo('<h2>Oh no '.$userdata->username.'  has not created a list yet!!!</h2>');
  } else {
    echo(
        '<h3>'.$userdata->username.'</h3>'
    );
    echo(
        '<h4> List for: '.$userdata->listtitle.'</h4>'
    );
    echo(
        '<h4> Description: '.$userdata->listdescription.'</h4>'
    );
    if(sizeof($items)>0){
        echo(
            '<ul>'
        );
        foreach($items as $item){
          echo(
              '<li>'.
              '<label> item : '.$item->title.'</label> </br>'.
              '<label> price : '.$item->price.'</label> </br>'.
              '<label> url : '.$item->url.'</label> </br>'.
              '<label> priority : '.$item->priority.'</label>'.
              '</li>'
          );
        }
        echo(
          '</ul>'
        );
    } else {
        echo(
            '<h3>No items in this users wish list</h3>'
        );
    }
  }
  ?>
</body>
</html>