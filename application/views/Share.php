<link rel="stylesheet" type="text/css" href="<?php echo(base_url());?>css/share.css">
<script src="<?php echo(base_url());?>js/Collections/test.js" type="text/javascript"></script>
  <?php 
  if($userdata->listtitle == NULL  || $userdata->listdescription == NULL){
    echo('<h2 class="text-primary">Oh no '.$userdata->username.'  has not created a list yet!!!</h2>');
  } else {
    echo(
        "<h3 class='text-primary' style='text-align: center'>".$userdata->username."'s Wish list</h3>"
    );
    echo(
        '<h4 class="text-primary"> List for: '.$userdata->listtitle.'</h4>'
    );
    echo(
        '<h4 class="text-primary"> Description: '.$userdata->listdescription.'</h4>'
    );
    if(sizeof($items)>0){
        echo(
            '<ol>'
        );
        foreach($items as $item){
          echo(
            '<li>'.
            '<div class="card text-white bg-secondary mb-3" style="max-width: 20rem;">'.
            '<div class="card-header">'.$item->title.'</div>'.
            '<div class="card-body">'.
              '<h6 class="card-title">'.checkPriority($item->priority).'</h6>'.
              '<h6 class="card-title"> $'.$item->price.'</h6>'.
              '<h6 class="card-title">'.$item->url.'</h6>'.
            '</div>'.
          '</div>'.
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