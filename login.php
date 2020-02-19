<?php 
	$mysql_database = "mysql:dbname=login_test;host=localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_connecter = new PDO($mysql_database,$mysql_user,$mysql_password);
	//MySQLに接続
	$sql = "select count(*) from user_data where mail = :mail and pass = :pass";
	//パスワードとメールアドレスの組み合わせがあるレコードの数をカウント
	//組み合わせがあると1->True
	//組み合わせがないと0->Falseになるので条件式が簡単になる。
	$stmt = $mysql_connecter->prepare($sql);
	$stmt->bindParam(":mail",$_POST["mail"] ,PDO::PARAM_STR);
	$stmt->bindParam(":pass",$_POST["password"] ,PDO::PARAM_STR);
	//事前にisset等でPOSTが空の場合の処理を作った方がよい
	$stmt->execute();
	//実行
	$result = $stmt->fetch();
	$is_login =  $result["count(*)"];
	if($is_login){
		echo "認証に成功しました。";
		session_start();
		$_SESSION["is_login"] = True;
		//sessionに登録し他のページにアクセスする際にセッションをチェックすればログインができているかどうかがわかる
	}
	else{
		echo "認証に失敗しました";
	}
 ?>