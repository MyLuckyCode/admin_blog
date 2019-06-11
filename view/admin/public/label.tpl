<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——标签</title>
	{$Style}

</head>
<body>

	
<div class="title">	
	<div class="titleView">
		<h3>标签</h3>
		<span @click="addLabelViewVisible = true">添加标签</span>
	</div>

	<el-dialog title="添加标签" :visible.sync="addLabelViewVisible" width="450px">

	  <el-form label-width="80px" @submit.native.prevent>

	    <el-form-item label="导航名称">
	      	<el-input 
	      		type="text"
	      		v-model="form.name"
	      		maxlength="15"
	      		show-word-limit
	      	></el-input>
	    </el-form-item>

	  </el-form>

	  <div slot="footer" class="dialog-footer">
	    <el-button @click="addLabelViewVisible = false" :disabled="!addLabelBtn">取 消</el-button>
	    <el-button type="primary" @click="postLabel" :disabled="!addLabelBtn">添 加</el-button>
	  </div>
	</el-dialog>

</div>
	
<div id="list">

	
	<el-tag
	  v-for="tag in tags"
	  :key="tag.name"
	  closable
	  @close="handleDeleteLabel(tag.id)"
	  @click="handleEdit(tag)"
	  hit
	  :type="tag.type">
	  {{tag.name}}
	</el-tag>


<!--修改标签-->

	<el-dialog title="修改标签" :visible.sync="editLabelViewVisible" width="400px">

	  <el-form label-width="80px">

	    <el-form-item label="标签名称">
	      	<el-input 
	      		type="text"
	      		v-model="editForm.name"
	      		maxlength="15"
	      		show-word-limit
	      	></el-input>
	    </el-form-item>

	  </el-form>

	  <div slot="footer" class="dialog-footer">
	    <el-button @click="editLabelViewVisible = false" :disabled="!editLabelBtn">取 消</el-button>
	    <el-button type="primary" @click="editLabel" :disabled="!editLabelBtn">修 改</el-button>
	  </div>
	</el-dialog>


</div>



{$Script}

</body>
</html>