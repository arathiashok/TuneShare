<?php
include('dbconfig.php');
if($_POST['id'])
{
	$id=$_POST['id'];
	
	$stmt = $conn->prepare("SELECT S.* FROM songs S inner join album_contains_song ACS inner join albums A WHERE 
    A.AlbumID = ACS.AlbumID and S.SongID = ACS.SongID and ACS.AlbumID=:id");
	$stmt->execute(array(':id' => $id));
	?><option selected="selected">Select Song :</option><?php
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
		<option value="<?php echo $row['SongID']; ?>"><?php echo $row['Title']; ?></option>
		<?php
	}
}
?>