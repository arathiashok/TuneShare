<?php
include_once 'dbconfig.php';
?>

<!DOCTYPE html>

<html>

<head>

<title>Spotify QR Generation</title>

<script type="text/javascript" src="jquery-1.4.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
{
	$(".artist").change(function()
	{
		var id=$(this).val();
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "get_album.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".album").html(html);
			} 
		});
	});
	
	
	$(".album").change(function()
	{
		var id=$(this).val();
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "get_song.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".song").html(html);
			} 
		});
	});

    $(".song").change(function() {
        var id = $(this).val();
        var dataString = 'id=' + id;

        $.ajax({
            type: "POST",
            url: "generate_qr.php",
            data: dataString,
            cache: false,
            success: function(response) {
                // Handle the response from generate_qr.php if needed
                $('#imgBox').html('<img src="' + response + '" />');
                $('#imgBox').addClass('show-img');
                console.log("Song dropdown changed");
            }
        });
    });

});
</script>

<style type="text/css">
label {
	font-weight: bold;
    padding: 10px;
    font-size: 20px;
    font-family: cursive;
    color: blue;
}
div {
	margin-top:100px;
}
select {
	width: 220px;
    height: 35px;
    border: blue 1px solid;
    font-size: 18px;
    border-radius: 5px;
    font-family: cursive;
}

#imgBox {
    width: 250px;
    border-radius:5px;
    max-height: 0;
    overflow: hidden;
}

#imgBox img{
    width: 90%;
    padding: 10px;
}

#imgBox.show-img{
    max-height: 350px;
    margin: 10px auto;
    border: 1px solid #d1d1d1;
}

</style>

</head>

<body>

<center>
<div>
<label>Artist :</label> 
<select name="Artist" class="artist">
<option selected="selected">--Select Artist--</option>
<?php
	$stmt = $conn->prepare("SELECT * FROM artists");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
        <option value="<?php echo $row['ArtistID']; ?>"><?php echo $row['Name']; ?></option>
        <?php
	} 
?>
</select>

<label>Album :</label>
<select name="Album" class="album">
<option selected="selected">--Select Album--</option>
</select>

<label>Song :</label>
<select name="Song" class="song">
<option selected="selected">--Select Song--</option>
</select>

<br/>
<br/>
</div>
<div id="imgBox"></div>

<br />
</center>

</body>

</html>
