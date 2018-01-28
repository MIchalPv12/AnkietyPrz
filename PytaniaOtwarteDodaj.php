<html lang="pl">
      <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
	</head>
		<style type="text/css">
			#fixme { 
			margin-left: 40%;
			display:inline-block;
			vertical-align:top;
			position: absolute; 
			left: 0px; 
			top: 0px; 
		}
		#fixmetoo { 
			position: absolute; 
			right: 0px; 
			bottom: 0px; 
		}
		div > div#fixme { position: fixed; }
		div > div#fixmetoo { position: fixed; }
		
		pre.fixit { 
			overflow:auto;
			border-left:1px dashed #000;
			border-right:1px dashed #000;
			padding-left:2px; }
			
			a.tool {
    position: relative;
} 

a.tool::before {
    content: attr(tresc); /*Odbieranie danych z atrybutu 'tresc'*/
    font-size: 14px;
    position: absolute;
    z-index: 999;
    white-space: nowrap;
    bottom: 9999px;
    left: 50%;
    background: gray;
    color: #fff;
    padding: 4px 5px;
    opacity: 0; 

    -webkit-border-radius: 3px; 
    -o-border-radius: 3px;
    -moz-border-radius: 3px; 
    border-radius: 3px;
} 

a.tool:hover::before {
    opacity: 1;
    bottom: -25px;
}

		</style>
		
		
        <title>Ankiety online</title>

        

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <!-- Main Style -->
        <link rel="stylesheet" type="text/css" href="assets/css/main.css">

        <!-- Responsive Style -->
        <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

        <!--Icon Fonts-->
        <link rel="stylesheet" media="screen" href="assets/fonts/font-awesome/font-awesome.min.css" />


        <!-- Extras -->
        <link rel="stylesheet" type="text/css" href="assets/extras/animate.css">
        <link rel="stylesheet" type="text/css" href="assets/extras/lightbox.css">


        <!-- jQuery Load -->
        <script src="assets/js/jquery-min.js"></script>
		<script src="bootstrap-maxlength.js"></script>
		



		
		
<?php
include "funkcje.php";

	if ( is_session_started() === FALSE ) session_start();
	
	//$_SESSION['id'] = 1;
	$_SESSION['idAnkiety'] =  $_GET['id'];;
	
	$_SESSION['pytanie'] = 1;  //do poprawnego wyswietlania echa, czy chodzi o ankiete czy pytanie
	sprawdzLiczbePytan(30);
	
?>

<!-- Tutaj dynamicznie tworze pola do dodawania pytan -->
  <script>
  
  
   var x;
  var scroll;
  $(document).ready(function() {
  
 
  
  var liczbaPytanBaza = document.getElementById("liczbaPytan").value;
	
  
    var max_fields      = 29; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
	 var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
    var add_button      = $(".add_open"); //Add button ID
	// var add_button2      = $(".add_closed"); //Add button ID
	var guziki = $(".guziki");
	
	
	var liczbaPytan = liczbaPytanBaza;
    var x = 1; //initlal text box count
	var scroll = 50;
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(liczbaPytan < max_fields){ //max input box allowed
            x++; //text box increment
			liczbaPytan++;
		
		$(wrapper).append('<p><div>Pytanie nr '+ x +'&nbsp<span class="glyphicon glyphicon-question-sign"></span><input type="text" maxlength="45" required class="form-control" placeholder="Treść pytania"name="mytext[]" /><a href="#" class="remove_field">Usun</a></div></p>' ); //add input box
		window.scrollTo(0,document.body.scrollHeight);
		
		$('input.form-control').maxlength({
    alwaysShow: true,
    threshold: 10,
    warningClass: "label label-info",
    limitReachedClass: "label label-danger",
    placement: 'top',
    preText: ' Wykorzystano ',
    separator: ' z ',
    postText: ' znaków.'
});
        }
		
		else {
		
		alert('Mozna dodac maksymalnie 30 pytan, masz juz '  + liczbaPytanBaza + ' w tej ankiecie');}
    });
	

  
  
	
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); liczbaPytan--;
		
		e.preventDefault(); $(this).parent('p').remove(); 
		$(this).parent('.counter').remove(); 
    }
	
	
	)
	
	
});</script>









<!-- kod html, ktory wyswietlam na stronie -->
<form action="PytaniaOtwarteDodaj_action.php" method="POST">
<div class="input_fields_wrap form-group" id="content">
	<div class="guziki"	id="fixme">
		<button style="fixed"  class="btn btn-success add_open fixed">Dodaj więcej pytań</button>  <!-- przycisk oprogramowany w js, aby dodac kolejen pole -->
		<?php submit(); ?> <!-- przycisk wysylajacy do bazy, z dymkiem o tytule ankiety-->
		
		
		
	
	
	</div>
	<br></br>
	<p>Pytanie nr 1 <span class="glyphicon glyphicon-question-sign"></span></p> <input type="text"  maxlength="45" required class="form-control" placeholder="Treść pytania" name="mytext[]"/></p>
	<script>window.scrollTo(0,document.body.scrollHeight);</script>
	
</div>


</form>



<script>


        
    

$('input.form-control').maxlength({
    alwaysShow: true,
    threshold: 10,
    warningClass: "label label-info",
    limitReachedClass: "label label-danger",
    placement: 'top',
    preText: 'Wykorzystano ',
    separator: ' z ',
    postText: ' znaków.'
});
</script>
</html>





