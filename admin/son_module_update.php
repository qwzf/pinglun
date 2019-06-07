<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$template['title']='子版块修改页';
$link=connect();
include_once 'inc/is_manage_login.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('son_module.php','onError.gif','id参数错误！');
}
$query="select * from son_module where id={$_GET['id']}";
$result=execute($link,$query);
if(!mysqli_num_rows($result)){
	skip('son_module.php','onError.gif','这条子版块信息不存在！');
}
$data=mysqli_fetch_assoc($result);
if(isset($_POST['submit'])){
	//验证
	$check_flag='update';
	include 'inc/check_son_module.inc.php';
	$query="update son_module set father_module_id={$_POST['father_module_id']},module_name='{$_POST['module_name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id={$_GET['id']}";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('son_module.php','onCorrect.gif','修改成功！');
	}else{
		skip('son_module.php','onError.gif','修改失败,请重试！');
	}
}
?>
<?php
include_once 'inc/header.inc.php';//top
include_once 'inc/sidebar.inc.php';//sidebar
?>
<div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="father_module.php">父板块列表</a><span class="crumb-step">&gt;</span><span class="crumb-name">添加子版块</span></div>
        </div>
		<form method="post">
		<div class="result-content">
                    <table class="result-tab" width="80%">
						<tr>
                            <th class="tc" width="7%"><input class="allChoose" type="checkbox"></th>
							<td>所属父版块</td>
							<td>
								<select name="father_module_id">
									<option value="0">===请选择一个父版块===</option>
									<?php
									$query="select*from father_module";
									$result_father=execute($link,$query);
									while ($data_father=mysqli_fetch_assoc($result_father)){
										if($data['father_module_id']==$data_father['Id']){
											echo "<option value='{$data_father['Id']}' selected='selected'>{$data_father['module_name']}</option>";
										}else{
											echo "<option value='{$data_father['Id']}'>{$data_father['module_name']}</option>";
										}
									}
									?>
								</select>
							</td>
							<td>*请选择一个父版块</td>
						</tr>
                        <tr>
                            <th class="tc" width="7%"><input class="allChoose" type="checkbox"></th>
							<td>版块名称</td>
							<td><input type="text" name="module_name" value="<?php echo $data['module_name']?>" class="common-text" /></td>
							<td>版块名称不能为空，最多不超过40个字符</td>
						</tr>
						<tr>
                            <th class="tc" width="7%"><input class="allChoose" type="checkbox"></th>
							<td>版块简介</td>
							<td>
								<textarea name="info" id="txtCon" rows="6" cols="50"><?php echo $data['info']?></textarea>
							</td>
							<td>版块名称不能为空，最多不超过300个字符</td>
						</tr>
						<tr>
                            <th class="tc" width="7%"><input class="allChoose" type="checkbox"></th>
							<td>版主</td>
							<td>
								<select name="member_id">
									<option value="0">===请选择一个会员作为版主===</option>
								</select>
							</td>
							<td>可以选择一个会员作为版主</td>
						</tr>
						<tr>
							<th class="tc" width="7%"><input class="allChoose" type="checkbox"></th>
                            <td>排序</td>
							<td><input type="text" name="sort" class="common-text" value="<?php echo $data['sort']?>"/></td>
							<td>填入一个数字即可</td>
                        </tr>
					</table>
					<br />
					<input class="btn btn-primary btn6 mr10" type="submit" name="submit" value="修改" />
		</div>
		</form>
  </div>
</div>
<?php include 'inc/footer.inc.php'?>