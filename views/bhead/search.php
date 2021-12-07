<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Webslesson Tutorial</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
 </head>
 <body>
  <div class="container">
   <br />

   <div class="form-group">
    <div class="input-group">
     <span class="input-group-addon">Search</span>
     <input type="text" name="search_text" id="search_text" placeholder="Search by Customer Details" class="form-control" />
     <input type="time" name="search_num" id="search_num" placeholder="Search by Customer Details" class="form-control" />
    </div>
   </div>
   <br />
   <div id="result"></div>
  </div>
 </body>
</html>



<script>
$(document).ready(function(){
    $('#search_text').keyup(function(){
        var txt = $(this).val();
        if(txt != '')
        {
            $.ajax({
                url:"search2.php",
                method:"POST",
                data:{search:txt},
                datatype:"text",
                success:function(data)
                {
                    $('#result').html(data);
                }
            });
        }
        else
        {
            $('#result').html('');  
        }
    });
});
</script>
