<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——导航管理</title>
	
	{$Style}
	
</head>
<body>


<div class="title">	
	<div class="titleView">
		<h3>前台导航</h3>
		<span @click="addNavViewVisible = true">添加导航</span>
	</div>

	<el-dialog title="添加导航" :visible.sync="addNavViewVisible">

	  <el-form label-width="80px">

	    <el-form-item label="导航名称">
	      	<el-input 
	      		type="text"
	      		v-model="form.name"
	      		maxlength="15"
	      		show-word-limit
	      	></el-input>
	    </el-form-item>

	    <el-form-item label="导航简介">
	      	<el-input 
	      		v-model="form.info"
				type="textarea"
				maxlength="30"
				show-word-limit
				placeholder="导航的介绍，可不填"
				:autosize="{ minRows: 2, maxRows: 4}"
	       	></el-input>
	    </el-form-item>

		<el-form-item label="是否显示">
			<el-switch
				v-model="form.disabled"
			><el-switch>
	    </el-form-item>

	    <el-form-item label="父级分类">
			<el-radio-group v-model="form.category">
		      	<el-radio label="web">Web前端</el-radio>
		      	<el-radio label="life">生活随笔</el-radio>
		    </el-radio-group>
	    </el-form-item>

	  </el-form>

	  <div slot="footer" class="dialog-footer">
	    <el-button @click="addNavViewVisible = false" :disabled="!addNavBtn">取 消</el-button>
	    <el-button type="primary" @click="postNav" :disabled="!addNavBtn">添 加</el-button>
	  </div>
	</el-dialog>

</div>
	
<div id="list">
	<el-tabs v-model="activeName">
    	<el-tab-pane label="Web前端" name="web">
				 <el-table
				    :data="navDataWeb"
				    stripe
				    border
				    style="width: 931px;">
				    <el-table-column
				      type="index"
				      label="编号"
				      align="center"
				      width="80">
				    </el-table-column>
				    <el-table-column
				      prop="name"
				      label="导航名称"
				      align="center"
				      width="150">
				    </el-table-column>
				    <el-table-column
				      prop="info"
				      label="简介"
				      align="center"
				      width="250">
				    </el-table-column>
				    <el-table-column
				      prop="disabled"
				      label="是否显示"
				      align="center"
				      width="100">
				    </el-table-column>
				    <el-table-column
				      prop="date"
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
				        <el-button type="danger" @click="handleDeleteNav(scope.row.id)" icon="el-icon-delete" circle></el-button>
				      </template>
				    </el-table-column>
				  </el-table>
    	</el-tab-pane>
    	<el-tab-pane label="生活随笔" name="life">
			 <el-table
				    :data="navDataLife"
				    stripe
				    border
				    style="width: 931px;">
				    <el-table-column
				      type="index"
				      label="编号"
				      align="center"
				      width="80">
				    </el-table-column>
				    <el-table-column
				      prop="name"
				      label="导航名称"
				      align="center"
				      width="150">
				    </el-table-column>
				    <el-table-column
				      prop="info"
				      label="简介"
				      align="center"
				      width="250">
				    </el-table-column>
				    <el-table-column
				      prop="disabled"
				      label="是否显示"
				      align="center"
				      width="100">
				    </el-table-column>
				    <el-table-column
				      prop="date"
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
				        <el-button type="danger" @click="handleDeleteNav(scope.row.id)" icon="el-icon-delete" circle></el-button>
				      </template>
				    </el-table-column>
				  </el-table>
    	</el-tab-pane>
  	</el-tabs>



<!--修改导航-->

	<el-dialog title="修改导航" :visible.sync="editNavViewVisible">

	  <el-form label-width="80px">

	    <el-form-item label="导航名称">
	      	<el-input 
	      		type="text"
	      		v-model="editForm.name"
	      		maxlength="15"
	      		show-word-limit
	      	></el-input>
	    </el-form-item>

	    <el-form-item label="导航简介">
	      	<el-input 
	      		v-model="editForm.info"
				type="textarea"
				maxlength="30"
				show-word-limit
				placeholder="导航的介绍，可不填"
				:autosize="{ minRows: 2, maxRows: 4}"
	       	></el-input>
	    </el-form-item>
	
		<el-form-item label="是否显示">
			<el-switch
				v-model="editForm.disabled"
			><el-switch>
	    </el-form-item>

	    <el-form-item label="父级分类">
			<el-radio-group v-model="editForm.category">
		      	<el-radio label="web">Web前端</el-radio>
		      	<el-radio label="life">生活随笔</el-radio>
		    </el-radio-group>
	    </el-form-item>

	  </el-form>

	  <div slot="footer" class="dialog-footer">
	    <el-button @click="editNavViewVisible = false" :disabled="!editNavBtn">取 消</el-button>
	    <el-button type="primary" @click="editNav" :disabled="!editNavBtn">修 改</el-button>
	  </div>
	</el-dialog>


</div>


{$Script}

</body>
</html>