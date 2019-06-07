<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$template['title']='子版块添加页';
$link=connect();
include_once 'inc/is_manage_login.inc.php';
if(isset($_POST['submit'])){
	//验证用户填写的信息
	$check_flag='add';
	include 'inc/check_son_module.inc.php';
	$query="insert into son_module(father_module_id,module_name,info,member_id,sort) values({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('son_module.php','onCorrect.gif','恭喜你，添加成功！');
	}else{
		skip('son_module_add.php','onError.gif','对不起，添加失败，请重试！');
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
									while($data_father=mysqli_fetch_assoc($result_father)){
										echo "<option value='{$data_father['Id']}'>{$data_father['module_name']}</option>";
									}
									?>
								</select>
							</td>
							<td>*请选择一个父版块</td>
						</tr>
                        <tr>
                            <th class="tc" width="7%"><input class="allChoose" type="checkbox"></th>
							<td>版块名称</td>
							<td><input type="text" name="module_name" class="common-text" /></td>
							<td>版块名称不能为空，最多不超过40个字符</td>
						</tr>
						<tr>
                            <th class="tc" width="7%"><input class="allChoose" type="checkbox"></th>
							<td>版块简介</td>
							<td>
								<textarea name="info" id="txtCon" rows="6" cols="50"></textarea>
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
							<td><input type="text" name="sort" class="common-text" /></td>
							<td>填入一个数字即可</td>
                        </tr>
					</table>
					<br />
					<input class="btn btn-primary btn6 mr10" type="submit" name="submit" value="添加" />
		</div>
		</form>
  </div>
</div>
<?php include 'inc/footer.inc.php'?>