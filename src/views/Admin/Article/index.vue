<template>
	<div id="article">
		<!-- 添加用户按钮 -->
		<el-button type="primary" round @click="add()" style="margin-bottom:20px" id="add_btn">创建文章</el-button>

		<!-- 顶部搜索栏 -->
		<div style="float:right" id="search_input">
			<el-input placeholder="请输入内容" v-model="search_input" class="input-with-select" >
				<el-select v-model="select" slot="prepend" placeholder="请选择">
					<el-option label="文章标题" value="1"></el-option>
					<el-option label="作者" value="2" disabled></el-option>
					<el-option label="文章内容" value="3" disabled></el-option>
				</el-select>
				<el-button slot="append" icon="el-icon-search" @click="search_user()"></el-button>
			</el-input>
		</div>

		<!-- 新增用户弹出框 -->
		<el-dialog :title="add_dialog_title" :visible.sync="dialogFormVisible" :fullscreen="true" center>
		  <el-form :model="form">

		    <el-form-item label="文章标题" :label-width="formLabelWidth">
		      <el-input v-model="form.title" autocomplete="off"></el-input>
		    </el-form-item>

		    <el-form-item label="作者" :label-width="formLabelWidth">
		      <el-input v-model="form.author" autocomplete="off" style="width:40%" prefix-icon="el-icon-edit"></el-input>
		    </el-form-item>

			<el-form-item label="分类" :label-width="formLabelWidth">
				<el-checkbox-group v-model="form.class" :max="3">
					
					<el-checkbox v-for="(data,index) in classlist" :key="index" :label="data"></el-checkbox>

				</el-checkbox-group>
		    </el-form-item>

			<el-form-item :label-width="formLabelWidth">
				<el-switch
					style="display: inline-block"
					v-model="form.state"
					active-color="#13ce66"
					inactive-color="#ff4949"
					active-text="立即发布"
					inactive-text="暂不发布">
				</el-switch>
				<el-switch
					style="display: inline-block;margin-left:20px"
					v-model="form.important"
					active-text="置顶内容"
					inactive-text="普通内容">
				</el-switch>
		    </el-form-item>

			<el-form-item label="封面" :label-width="formLabelWidth">
		      	<el-upload
                    class="avatar-uploader"
                    :action="this._path.php_path+'/php/upload/'"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
					<img v-if="form.headerPic" :src="form.headerPic" class="avatar">
					<i v-else class="el-icon-plus avatar-uploader-icon"></i>
				</el-upload>
		    </el-form-item>

			<el-form-item label="文章内容" :label-width="formLabelWidth">

				<div>
					<tinymce-editor v-model="form.content"
					:disabled="disabled"
					@onClick="onClick"
					ref="editor"></tinymce-editor>
					<input type="button" @click="clear" value="清空内容">
					<input type="button" @click="disabled = true" value="禁用">
					<input type="button" @click="disabled = false" value="启用">
				</div>


		    </el-form-item>
				

				

		  </el-form>
		  <div slot="footer" class="dialog-footer">
		    <el-button @click="qvxiao()">取 消</el-button>
		    <el-button type="primary" @click="add_user(form)" :loading="submit_loading">{{add_loading_title}}</el-button>
		  </div>
		</el-dialog>

		<!-- 展示用户弹出框 -->
		<el-dialog
			:title="show.title"
			:visible.sync="centerDialogVisible"
			width="80%"
			center>
			<h2 style="font-size:20px;color:#303133">{{ show.title }}</h2>


			<span class="el-icon-time" style="color:#606266">{{`&nbsp;&nbsp;`+show.time }}</span>
			<el-tag type="info" size="small" style="margin-left:10px">{{ show.author }}</el-tag>
			<el-tag v-for="(prop,index) in show.class" :key="index" style="margin-left: 10px;margin-top:-10px; float:right">{{ prop }}</el-tag>
			<hr style="border:none;border-top:1px solid #C0C4CC;margin:10px 0">
			<div style="color:#606266;font-size:14px" id="showContent"></div>

			<span slot="footer" class="dialog-footer">
				<el-button type="primary" @click="centerDialogVisible = false">确 定</el-button>
			</span>
		</el-dialog>

		<!-- 用户表格主体结构 -->
		<el-table
			:data="tableData"
			style="width: 100%">

			<el-table-column
				prop="aid"
				label="编号"
				width="100">
			</el-table-column>

			<el-table-column
				label="发表时间"
				width="200">
				<template slot-scope="props">
				<i class="el-icon-time"></i>
				<span style="margin-left: 10px">{{ props.row.publish_time }}</span>
      	</template>
			</el-table-column>

			<el-table-column	
				prop="author"
				
				label="作者">
			</el-table-column>

			<el-table-column	
				prop="title"
				label="文章标题">
			</el-table-column>

			<el-table-column
				label="标签">
				<template slot-scope="props">

					
					<el-tag v-for="(prop,index) in props.row.class" :key="index" style="margin: 0 3px">{{ prop }}</el-tag>

				</template>
			</el-table-column>

			<el-table-column
				label="上线状态"
				width="100">
				<template slot-scope="props">
					<el-switch
						style="display: block; height: 22px"
						v-model="props.row.state"
						active-color="#13ce66"
						@click.native="change_state(props.$index, props.row)"
						inactive-color="#ff4949">
					</el-switch>
				</template>
			</el-table-column>

			<el-table-column
				width="320"
				label="操作">
				<template slot-scope="props">
						<template v-if="props.row.comment_num > 0">
							<el-badge :value="props.row.comment_num" class="item" type="primary">
								<el-button-group>
								<el-button
								size="mini"
								@click="handleShow(props.$index, props.row)">展示</el-button>
								<el-button
								size="mini"
								type="primary"
								@click="handleEdit(props.$index, props.row)">编辑</el-button>
								<el-button
								size="mini"
								type="danger"
								@click="handleDelete(props.$index, props.row)">删除</el-button>
								<el-button
								size="mini"
								type="success"
								id="ppp"
								@click="toComment(props.row)">管理评论</el-button>
								</el-button-group>
							</el-badge>
						</template>
						<template v-else>

							<el-button-group>
							<el-button
							size="mini"
							@click="handleShow(props.$index, props.row)">展示</el-button>
							<el-button
							size="mini"
							type="primary"
							@click="handleEdit(props.$index, props.row)">编辑</el-button>
							<el-button
							size="mini"
							type="danger"
							@click="handleDelete(props.$index, props.row)">删除</el-button>
							<el-button
							size="mini"
							type="success"
							id="ppp"
							@click="toComment(props.row)">管理评论</el-button>
							</el-button-group>

						</template>
						
						
					
					
				</template>
			</el-table-column>



		</el-table>

		<!-- 用户分页 -->
		<div class="block" >
			<el-pagination
				@size-change="handleSizeChange"
				@current-change="handleCurrentChange"
				:current-page.sync="currentPage1"
				:page-size=pageSize
				:background=true
				layout="total, prev, pager, next"
				style="display:flex; justify-content:center; margin-top:20px"
				:total=dataNum>
			</el-pagination>
		</div>

	</div>
	
</template>



<script>
import TinymceEditor from '../../../components/editor.vue'
  export default {
	  components: {
		TinymceEditor
	},
		data() {
			return {

				disabled:false,

				centerDialogVisible: false,
				add_loading_title: "提 交",
				submit_loading: false,
				add_dialog_title: '创建文章',
				search_input: '',

				newlist: '',
      			select: '',
				pageSize: 10,
				pageVal: 1,
				dataNum: 0,
				now: '',
				data: {},
				classlist: [],
				tableData: [],
				dialogFormVisible: false,
				formLabelWidth: '120px',
				currentPage1: 1,
				options: [{
					value: '标准用户',
					label: '标准用户'
				}],
        		form: {
					title: '',
					state: true,
					content: '',
					author: '',
					important: false,
					class: [],
					headerPic: '',
				},
				show: {
					title: '',
					content: '',
					time: '',
					author: '',
					class: []
				},
				pickerOptions1: {
					disabledDate(time) {
						return time.getTime() > Date.now();
          },
				},
      }
		},
		
		methods:{

			handleAvatarSuccess(res, file) {
            this.form.headerPic = res;
        },
        beforeAvatarUpload(file) {
            
            const isJPG = file.type === 'image/jpeg';
            const isLt2M = file.size / 1024 / 1024 < 2;
            
            if (!isJPG) {
            this.$message.error('上传头像图片只能是 JPG 或者 PNG 格式!');
            }
            if (!isLt2M) {
            this.$message.error('上传头像图片大小不能超过 2MB!');
            }
            return isJPG && isLt2M;
        },

			 onEditorReady(editor) {
      },

			toComment(data){
				window.location.assign("/admin/comment/"+data.aid);
				
			},

			change_state(index, row){
				var that = this;
				var data = new FormData();
				data.append("aid",row.aid);
				data.append("state",Number(row.state));
				this.axios.post(that._path.php_path+"/php/state_article.php",data).then(res=>{
					if (row.state) {
						this.$message({
							type: 'success',
							message: '上线文章成功!'
						});
					}else{
						this.$message({
							type: 'info',
							message: '下线文章成功!'
						});
					}
					
					this.getList();
				})
			},
			
			qvxiao(){
				this.dialogFormVisible = false;
				this.form = {
					title: '',
					state: true,
					content: '',
					author: '',
					class: [],
					important: false,
					headerPic: '',
				}
			},

			
			// 提交搜索按钮
			search_user(){
				if(this.select == 1){
					this.getList();
				}
			},

			// 更改每页条数
			handleSizeChange(val) {
			},
			
			// 更改页码
      		handleCurrentChange(val) {
				
				this.pageVal = val;
				this.getList();
			},
			
			// 点击添加按钮
			add(){
				this.dialogFormVisible = true;
				this.add_dialog_title = "创建文章";
				this.now = 'add';
				this.form = {
					title: '',
					state: true,
					content: '',
					author: '',
					class: [],
					important: false,
					headerPic: '',
				}
			},

			// 获取用户数据列表
			getList(){
				
				// 获取数据内容
				var that = this;
				$.ajax({
					url:that._path.php_path+'/php/getArticleData.php',//url路径
					type:'POST', //GET
					async:false, //或false,是否异步
					data:{//参数
						"pageSize":this.pageSize,
						"pageVal":this.pageVal,
						"title":this.search_input
					},
					// timeout:5000, //超时时间
					dataType:'json', //返回的数据格式：

					success:function(data){
						if(data.length > 0){
							that.tableData = [];
							for (let i = 0; i < data.length; i++) {
								
								if (data[i].class.length > 0) {
									data[i].class = data[i].class.split(',');

									for (let v = 0; v < data[i].class.length; v++) {

										$.ajax({
											url:that._path.php_path+'/php/get_class_data.php',//url路径
											type:'POST', //GET
											async:false, //或false,是否异步
											data:{//参数
												"cid":data[i].class[v],
											},
											// timeout:5000, //超时时间
											dataType:'json', //返回的数据格式：

											success:function(data2){
												if(data2.length > 0){
													data[i].class[v] = data2[0].class_name;
												}
											}
										})
									}
								}else{
									data[i].class = [];
								}

								$.ajax({
									url:that._path.php_path+'/php/get_comment_num.php',//url路径
									type:'POST', //GET
									async:false, //或false,是否异步
									data:{//参数
										"aid":data[i].aid,
									},
									// timeout:5000, //超时时间
									dataType:'json', //返回的数据格式：

									success:function(data3){
										data[i].comment_num = data3;
										
									}
								})

								if (data[i].state == 1) {
									data[i].state = true;
								}else{
									data[i].state = false;
								}

								if (data[i].important == 1) {
									data[i].important = true;
								}else{
									data[i].important = false;
								}
								that.tableData.push(data[i]);

							}	
						}
						
					},
				})

				// 获取数据总量
				var data = new FormData();
				data.append("pageSize",this.pageSize);
				data.append("pageVal",this.pageVal);
				data.append("title",this.search_input);
				this.axios.post(that._path.php_path+'/php/get_Article_DataNum.php',data).then(res=>{
					this.dataNum = res.data;
				})

				var data = new FormData();
				data.append("cid",'0');
				this.axios.post(that._path.php_path+'/php/get_class_data.php',data).then(res=>{
					this.classlist=[];
					for (let i = 0; i < res.data.length; i++) {
						
						this.classlist.push(res.data[i].class_name)
						
					}
				})
				
				
			},

			// 展示文章
			handleShow(index, row) {
				this.centerDialogVisible = true;
				this.show.title = row.title;
				this.show.content = row.content;
				this.show.class = row.class;
				this.show.time = row.publish_time;
				this.show.author = row.author;

				document.getElementById("showContent").innerHTML = this.show.content;
        
			},

			// 编辑用户
			handleEdit(index, row) {
				this.now = 'edit';
				this.add_dialog_title = "编辑文章";
				this.form = {
					aid: row.aid,
					title: row.title,
					content: row.content,
					state: row.state,
					important: row.important,
					class: row.class,
					author: row.author,
					headerPic: row.headerPic,
				}
				this.dialogFormVisible = true;
			},



			// 删除用户处理
			handleDelete(index, row) {
				var that = this;
				var data = new FormData();
				data.append("delete_id",row.aid);

				this.$confirm('此操作将永久删除该文章和评论，如果你只想隐藏文章不在线上显示，请选择下线文章。是否继续?', '警告', {
					confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'error'
        }).then(() => {
					this.axios.post(that._path.php_path+"/php/del_article.php",data).then(res=>{
						this.$message({
							type: 'success',
							message: '删除成功!'
						});
						this.getList();
					})
        }).catch(() => {
					this.$message({
						type: 'info',
            message: '已取消删除'
          });          
        });
			},

			// 提交新增/搜索表单
			add_user(){
				var that = this;
				this.newlist = [];
				var j = 0;
				if (this.form.class.length > 0) {
					for (let i = 0; i < this.form.class.length; i++) {
						var data = new FormData();
						data.append("class_name",this.form.class[i]);
						this.axios.post(that._path.php_path+'/php/get_class_name.php',data).then(res=>{
							this.newlist.push(res.data[0].cid);
							j++;
							if (j == this.form.class.length) {
								this.add_2();
							}
						})
					}
				}else{
					this.add_2();
				}
			},

			add_2(){
				var that = this;

				this.submit_loading = true;
				var data = new FormData();
				this.add_loading_title = "提交中";
				data.append("title",this.form.title);
				data.append("state",Number(this.form.state));
				data.append("important",Number(this.form.important));
				data.append("content",this.form.content);
				data.append("author",this.form.author);
				data.append("class",this.newlist);
				data.append("headerPic",this.form.headerPic);


				data.append("now",this.now);
				data.append("aid",this.form.aid);


					
					// 将数据提交至服务器
					this.axios.post(that._path.php_path+"/php/add_Article.php",data).then(res=>{
						this.dialogFormVisible = false;
						this.submit_loading = false;
						this.add_loading_title = "提 交";
						this.$message({
							type: 'success',
							message: '提交成功!'
						});
						this.form = {
							title: '',
							state: true,
							content: '',
							author: '',
							class: []
						}
						this.getList();
					}).catch(res=>{
						this.submit_loading = false;
						this.add_loading_title = "提 交";
						this.$message({
							type: 'error',
							message: '提交失败!'
						});
					})
			},

			onClick(e, editor) {
			/* 
			console.log(e)
			console.log(editor) */
			//   console.log(this.msg);
			
			},
			//清空内容
			clear() {
			this.$refs.editor.clear()
			},

		},
		mounted(){
			// 自动调整搜索框长度
			window.onresize=function(){
				if (document.getElementById("search_input")) {
					document.getElementById("search_input").style.width = document.documentElement.clientWidth - document.getElementById("add_btn").offsetWidth - 70 + "px";
				}
				
			};
			// 延时调整一次
			window.setTimeout(function() {
				if (document.getElementById("search_input")) {
					document.getElementById("search_input").style.width = document.documentElement.clientWidth - document.getElementById("add_btn").offsetWidth - 70 + "px";
				}
			},0)

			this.getList();
			
			
		
			
		},
		
	}
	
	
</script>

<style scoped>
  .el-select .el-input {
    width: 130px;
  }
  .input-with-select .el-input-group__prepend {
    background-color: #fff;
  }

	.demo-table-expand {
    font-size: 0;
  }
  .demo-table-expand label {
    width: 100px;
    color: #99a9bf;
  }
  .demo-table-expand .el-form-item {
    margin-right: 0;
    margin-bottom: 0;
    width: 33.33%;
  }

	.el-table .warning-row {
    background: oldlace;
		color: #F56C6C;
  }

  .item {
  margin-top: 10px;
  margin-right: 40px;
}

.el-badge__content{
	z-index: 1000;
}

</style>
<style>
	

	.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  #article .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 150px;
    height: 100px;
    line-height: 100px;
    text-align: center;
  }
  #article .avatar {
    width: 150px;
    height: 100px;
    display: block;
  }


	#article .el-input--suffix{
	  width: 100px !important;
  }

</style>