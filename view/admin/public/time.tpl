<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——时光机</title>
	{$Style}
</head>
<body>


<div class="title">	
	<div class="titleView">
		<h3>时光机</h3>
		<span @click="addTimeViewVisible = true">添加内容</span>
	</div>

	<el-dialog title="添加内容" :visible.sync="addTimeViewVisible">

	  <el-form label-width="80px">

	    <el-form-item label="内容">
	      	<el-input 
	      		v-model="form.content"
				type="textarea"
				maxlength="200"
				show-word-limit
				placeholder="内容"
				:autosize="{ minRows: 3, maxRows: 20}"
	       	></el-input>
	    </el-form-item>

	  </el-form>

	  <div slot="footer" class="dialog-footer">
	    <el-button @click="addTimeViewVisible = false" :disabled="!addTimeBtn">取 消</el-button>
	    <el-button type="primary" @click="postNav" :disabled="!addTimeBtn">添 加</el-button>
	  </div>
	</el-dialog>

</div>
	
<div id="list">
		 <el-table
		    :data="TimeData"
		    stripe
		    border
		    style="width: 98%;">
		    <el-table-column
		      type="index"
		      label="编号"
		      align="center"
		      width="80">
		    </el-table-column>
		    <el-table-column
		      prop="content"
		      label="内容"
		      align="center">
		    </el-table-column>
		    <el-table-column
		      prop="smallDate"
		      label="日期"
		      align="center"
		      width="150">
		    </el-table-column>
		    <el-table-column
		      label="操作"
		      align="center"
		      width="200">
		      <template slot-scope="scope">
		        <el-button @click="handleEdit(scope.row)" type="primary" icon="el-icon-edit" circle></el-button>
		        <el-button type="danger" @click="handleDeleteTime(scope.row.id)" icon="el-icon-delete" circle></el-button>
		      </template>
		    </el-table-column>
		  </el-table>
    	<div class="page">
			<el-pagination
		    	@current-change="handleCurrentChange"
		    	:current-page="{$currentPage}"
		    	:page-size="page.size"
		    	layout="prev, pager, next, jumper"
		    	:total="page.total">
			</el-pagination>
    	</div>
		


<!--修改导航-->

	<el-dialog title="修改内容" :visible.sync="editTimeViewVisible">

	  <el-form label-width="80px">

	    <el-form-item label="内容">
	      	<el-input 
	      		v-model="editForm.content"
				type="textarea"
				maxlength="200"
				show-word-limit
				placeholder="内容"
				:autosize="{ minRows: 3, maxRows: 20}"
	       	></el-input>
	    </el-form-item>
 		</el-form>
	  <div slot="footer" class="dialog-footer">
	    <el-button @click="editTimeViewVisible = false" :disabled="!editTimeBtn">取 消</el-button>
	    <el-button type="primary" @click="editTime" :disabled="!editTimeBtn">修 改</el-button>
	  </div>

	</el-dialog>


</div>


{$Script}

</body>
</html>