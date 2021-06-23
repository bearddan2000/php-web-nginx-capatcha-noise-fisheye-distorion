<?php
  $title = "PHP Capatcha service";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
  	<title><?= $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
  <nav class="navbar navbar-inverse">
      <div class="container">
          <div class="navbar-header">
              <a class="navbar-brand" href="/"><?= $title ?></a>
          </div>
          <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                  <li class="active"><a href="/">Home</a></li>
              </ul>
          </div>
      </div>
  </nav>


<div class="container">
  <div class="row">
    <div class="col-6">
      <label>Provided Capatcha:</label>
    </div>
    <div class="col-6">
      <img />
    </div>
  </div>
    <input type="hidden" name="mode" value="guess">
    <input type="hidden" id="provided" name="provided" value="">
    <div class="col-3">
      <label>Guess Capatcha:</label>
    </div>
    <div class="col-3">
      <input type="text" id="guess"/>
    </div>
    <div class="col-3">
      <button>Guess</button>
    </div>
    <div class="col-3">
      <span/>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
function getInit() {
  $.get('capatcha-service.php', {mode:'init'}, function (data, textStatus, jqXHR) {
      //$('p').text(data);
      $('#provided').text(data);
      var src = "capatcha-img.php?s=000_FFF_200_200&t=" + data;
      $('img').attr('src', src);
  });
}
// A $( document ).ready() block.
$( document ).ready(function() {
  getInit();

  //hang on event of form with id=myform
  $("button").click(function(e) {
    $('span').empty();
    $.post('capatcha-service.php', {
      mode: 'guess'
      , guess: $('#guess').val()
      , provided: $('#provided').text()
    }, function(data, textStatus, jqXHR) {
      $('span').text(data);
      getInit();
    });
  });
});

</script>
</body>
</html>
