<script src="<?php echo(base_url());?>js/Collections/test.js" type="text/javascript"></script>
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
            '<ol>'
        );
        foreach($items as $item){
          echo(
              '<li>'.
              '<label> item : '.$item->title.'</label> </br>'.
              '<label> price : '.$item->price.'</label> </br>'.
              '<label> url : '.$item->url.'</label> </br>'.
              '<label> priority : '.checkPriority($item->priority).'</label>'.
              '</li>'
          );
        }
        echo(
          '</ol>'
        );
    } else {
        echo(
            '<h3>No items in this users wish list</h3>'
        );
    }
  }

  function checkPriority($priority){
    switch($priority){
    case 1: return 'Must Have';
    break;
    case 2: return 'Nice to Have';
    break;
    case 3: return 'If possible';
    break;
    }
  }
  ?>
</body>
</html>