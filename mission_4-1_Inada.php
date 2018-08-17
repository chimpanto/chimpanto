<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<lang = "ja">
<?php
$dsn = 'mysql:dbname=データベース名;host=localhost;charset=utf8';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
$stmt = $pdo -> query('SET NAMES utf8');

//create table
$sql= "CREATE TABLE mission4"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "name char(32),"
. "comment TEXT,"
. "date DATETIME,"
. "password TEXT"
.");";
$stmt = $pdo->query($sql);


$name = $_POST["name"];
$comment = $_POST["comment"];
$edit_number = $_POST["edit_number"];
$delete = $_POST["delete"];
$edit = $_POST["edit"];
$submit_pass = $_POST["submit_pass"];
$delete_pass = $_POST["delete_pass"];
$edit_pass = $_POST["edit_pass"];


//新規投稿
if(isset($_POST["name"]) && $_POST["name"] != "" && isset($_POST["comment"]) && $_POST["comment"] != "" && empty($_POST["edit_number"]) && isset($_POST["submit_pass"]) && $_POST["submit_pass"]){ 
	$sql = $pdo -> prepare("INSERT INTO mission4 (id, name, comment, date, password) VALUES (null, :name, :comment, :date, :password)"); 
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);  
	$sql -> bindParam(':date', $now, PDO::PARAM_STR); 
	$sql -> bindParam(':password', $submit_pass, PDO::PARAM_STR); 
	$now=date("Y/m/d  H:i:s");
	$sql -> execute();
}


//削除
if(isset($_POST["delete"]) && $_POST["delete"] != "" && isset($_POST["delete_pass"]) && $_POST["delete_pass"]){
	$sql = "SELECT * FROM mission4 where id = $delete";
	$results = $pdo->query($sql);
	
	foreach($results as $row){
		$pass = $row['password'];
		if($delete_pass !== $pass){
			echo "パスワードが間違っています";
		}else{
			$sql = "delete from mission4 where id=$delete";
			$result = $pdo->query($sql);
			header('Location: http://tt-89.99sv-coco.com/mission_4-1_Inada.php/');
		}
	}
}


//編集
if(isset($_POST["edit"]) && $_POST["edit"] != "" && isset($_POST["edit_pass"]) && $_POST["edit_pass"]){ 
	$sql = "SELECT * FROM mission4 where id = $edit";
	$results2 = $pdo->query($sql);

	foreach($results2 as $row){
		$pass2 = $row['password'];
		if($edit_pass !== $pass2){
			echo "パスワードが間違っています";
		}else{
			$EDIT_number = $row['id'];
			$NAME = $row['name'];
			$COMMENT = $row['comment'];
		}
	}
}


//編集2
if(isset($_POST["name"]) && $_POST["name"] != "" && isset($_POST["comment"]) && $_POST["comment"] != "" && !empty($_POST["edit_number"]) && isset($_POST["submit_pass"]) && $_POST["submit_pass"]){ 
	$sql = "SELECT * FROM mission4 where id = $edit_number";
	$results3 = $pdo->query($sql);
	
	foreach($results3 as $row){
		if($row['id'] == $edit_number){
			$now2=date("Y/m/d  H:i:s");
			$sql = "update mission4 set name='$name' , comment='$comment' , date='$now2' , password = '$submit_pass' where id = $edit_number";
			$result = $pdo->query($sql);
			header('Location: http://tt-89.99sv-coco.com/mission_4-1_Inada.php/');
		}
	}
}


?>


<form method = "POST" action="mission_4-1_Inada.php">
	<p><input type="hidden" name="edit_number" value="<?php echo $EDIT_number; ?>">
	<input type="text" name="name" placeholder="名前" value="<?php echo $NAME; ?>"><br>
	<input type="text" name="comment" placeholder="コメント" value="<?php echo $COMMENT; ?>"><br>
	<input type="password" placeholder="パスワード" name="submit_pass">&emsp;<input type="submit" value="送信"><br></p>
	<p><input type="number" name="delete" placeholder="削除対象番号"><br>
	<input type="password" placeholder="パスワード" name="delete_pass">&emsp;<input type="submit" value="削除"><br></p>
	<p><input type="number" name="edit" placeholder="編集対象番号"><br>
	<input type="password" placeholder="パスワード" name="edit_pass">&emsp;<input type="submit" value="編集"><br><br></p>
</form>


<?php
//select
$sql = 'SELECT * FROM mission4 order by id'; 
$results4 = $pdo -> query($sql); 
foreach($results4 as $row){    //$rowの中にはテーブルのカラム名が入る    
	echo $row['id'].' ';    
	echo $row['name'].' ';    
	echo $row['comment'].' ';
	echo $row['date'].'<br>';
}
?>

</body>
</html>