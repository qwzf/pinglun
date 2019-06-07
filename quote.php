<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool1.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php', 'onError.gif', '请登录之后再做回复!');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'onError.gif', '您要回复的帖子id参数不合法!');
}
$query="select c.Id,c.title,m.username from content c,member m where c.Id={$_GET['id']} and c.member_id=m.Id";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)!=1){
	skip('index.php', 'onError.gif', '您要回复的帖子不存在!');
}
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);


if(!isset($_GET['reply_id']) || !is_numeric($_GET['reply_id'])){
	skip('index.php', 'onError.gif', '您要引用的回复id参数不合法!');
}
$query="select reply.content,member.username from reply,member where reply.Id={$_GET['reply_id']} and reply.content_id={$_GET['id']} and reply.member_id=member.id";
$result_reply=execute($link, $query);
if(mysqli_num_rows($result_reply)!=1){
	skip('index.php', 'onError.gif', '您要引用的回复不存在!');
}
$data_reply=mysqli_fetch_assoc($result_reply);
$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
if(isset($_POST['submit'])){
	include 'inc/check_reply.inc.php';
	$_POST=escape($link,$_POST);
	$query="insert into reply(content_id,quote_id,content,time,member_id) 
			values(
				{$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$member_id}
			)";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}", 'onCorrect.gif', '回复成功!');
	}else{
		skip($_SERVER['REQUEST_URI'], 'onError.gif', '回复失败,请重试!');
	}
}
$query="select count(*) from reply where content_id={$_GET['id']} and id<={$_GET['reply_id']}";
$floor=num($link,$query);
$template['title']='引用回复页';
$template['css']=array('style/public.css','style/publish.css');
?>
<?php include 'inc/header.inc.php'?>
<div id="publish">
	<div><?php echo $data_content['username']?>: <?php echo $data_content['title']?></div>
	<div class="quote">
		<p class="title">引用<?php echo $floor?>楼 <?php echo $data_reply['username']?> 发表的: </p>
		<?php echo $data_reply['content']?>
	</div>
	<form method="post">
		<textarea name="content" class="content"></textarea>
		<input class="reply" type="submit" name="submit" value="" />
		<div style="clear:both;"></div>
	</form>
</div>
<?php include 'inc/footer.inc.php'?>