<?php
	require_once("dbconfig.php");
	$bNo = $_GET['bno'];

	if(!empty($bNo) && empty($_COOKIE['board_free_' . $bNo])) {
		$sql = 'update board_free set b_hit = b_hit + 1 where b_no = ' . $bNo;
		$result = $db->query($sql);
		if(empty($result)) {
			?>
			<script>
				alert('오류가 발생했습니다.');
				history.back();
			</script>
			<?php
		} else {
			setcookie('board_free_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
		}
	}

	$sql = 'select b_title, b_content, b_date, b_hit, b_id from board_free where b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>자유게시판 | GSMBoard</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
	<link rel="stylesheet" href="./css/index.css" />
	<script src="./js/jquery-3.3.1.min.js"></script>
</head>
<body>
	<center>
	<article class="boardArticle">
		<div><h3 style="font-size: 36px"><img src="./image/gsm.PNG" width="200px" align="bottom"/>Board</h3></div>
		<hr style="width: 100%;"/>
		<h3>자유게시판 글쓰기</h3>
		<div id="boardView">
			<div class="info_box">
			<div id="boardInfo">
				<h3 id="boardTitle"><?php echo $row['b_title']?></h3>
				<span id="boardID">작성자: <?php echo $row['b_id']?></span>
				<span id="boardDate">작성일: <?php echo $row['b_date']?></span>
				<span id="boardHit">조회: <?php echo $row['b_hit']?></span>
			</div>
		</div>
		<hr />
			<div id="boardContent"><?php echo $row['b_content']?></div>
			<div class=""
			<div class="btnSet">
				<button type="button" onclick="location.href='./write.php?bno=<?php echo $bNo?>'">수정</button>
				<button type="button" onclick="location.href='./delete.php?bno=<?php echo $bNo?>'">삭제</button>
				<button type="button" onclick="location.href='./'">목록</button>
			</div>
			<br /><br /><br />
		<div id="boardComment">
			<h3>댓글 남기기</h3>
			<?php require_once('./comment.php')?>
		</div>
		</div>
	</article>
</center>
</body>
</html>
