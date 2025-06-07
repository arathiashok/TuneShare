<?php
include('dbconfig.php');
if($_POST['id'])
{
	$id=$_POST['id'];
		
	$stmt = $conn->prepare("SELECT * FROM albums Al inner join artist_publishes_album APA inner join artists Ar WHERE 
    Al.AlbumID = APA.AlbumID and Ar.ArtistID = APA.ArtistID and APA.ArtistID=:id");
	$stmt->execute(array(':id' => $id));
	?><option selected="selected">Select Album :</option><?php
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
        <option value="<?php echo $row['AlbumID']; ?>"><?php echo $row['Title']; ?></option>
        <?php
	}
}
?>