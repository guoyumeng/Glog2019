<template>
	<div>
		<!-- 添加用户按钮 -->
		<el-button type="primary" round @click="add()" style="margin-bottom:20px" id="add_btn">创建分类</el-button>

		<!-- 用户表格主体结构 -->
		<el-table
			:data="tableData"
            :default-sort = "{prop: 'cid', order: 'ascending'}"
            :row-class-name="tableRowClassName"
			style="width: 100%">

			<el-table-column
            key="cid"
				prop="cid"
				label="编号"
				width="100">
			</el-table-column>

			<el-table-column
				prop="class_name"
				label="分类名">
			</el-table-column>

			<el-table-column
				prop="state"
				label="状态">
			</el-table-column>

			<el-table-column
				prop="child"
				label="此分类下的文章">
			</el-table-column>

            <el-table-column
				width="300"
				label="操作">
				<template slot-scope="props">
                    <el-button-group>
					<el-button
		                size="mini"
				  	    type="primary"
						@click="handleEdit(props.$index, props.row)">更名</el-button>

                    <el-button
						size="mini"
						type="info"
                        v-if="props.row.state == '启用'"
						@click="handleStop(props.$index, props.row)">停用</el-button>
                    <el-button
						size="mini"
						type="success"
                        v-else
						@click="handleStart(props.$index, props.row)">启用</el-button>

					<el-button
						size="mini"
						type="warning"
                        v-if="props.row.child == '0 篇内容'"
                        disabled
						@click="handleDelete(props.$index, props.row)">移除</el-button>
					<el-button
						size="mini"
						type="warning"
                        v-else
						@click="handleDelete(props.$index, props.row)">移除</el-button>
					<el-button
						size="mini"
						type="danger"
						@click="handleDeleteAll(props.$index, props.row)">删除</el-button>
                    </el-button-group>
				</template>
			</el-table-column>
			
			

		</el-table>

		<el-dialog
        title="提示"
        :visible.sync="dialogVisible"
        width="30%">
        <el-form ref="form" label-width="80px">
            <el-form-item label="分类名称">
                <el-input v-model="class_name"></el-input>
            </el-form-item>
            <el-form-item label="URL路径">
                <el-input v-model="url_name"></el-input>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="add2()">确 定</el-button>
        </span>
        </el-dialog>
	</div>
	
</template>



<script>
	
  export default {
		data() {
			return {
                now: "add",
				data: {},
				tableData: [],
                dialogVisible: false,
                class_name: '',
                url_name: '',
                cid: '',
            }
		},
		
		methods:{

            // 检查是否停用
			tableRowClassName({row, rowIndex}) {
                if (row.state == "停用") {
                    return 'warning-row';
                }
                return '';
			},
			
			// 点击添加按钮
			add(){
                this.now = "add";
                this.dialogVisible = true;
                this.class_name = '';
                this.url_name = '';
				
            },
            
            add2(){
                var that = this;
                var data = new FormData();
                data.append("class_name",this.class_name);
                data.append("url_name",this.url_name);
                data.append("cid",this.cid);
                data.append("now",this.now);
                this.axios.post(that._path.php_path+"/php/add_class.php",data).then(res=>{
                    this.$message({
                        type: 'success',
                        message: '添加成功！'
                    });
                    this.dialogVisible = false;
                    this.getList();
                })
            },

			// 获取用户数据列表
			getList(){
				
                // 获取数据内容
                var that = this;
                this.tableData = [];
                var data = new FormData();
                data.append("cid",0);
				this.axios.post(that._path.php_path+'/php/get_class_data.php',data).then(res=>{
					
					if(res.data.length > 0){
						for (let i = 0; i < res.data.length; i++) {
							if (res.data[i].state == 1) {
								res.data[i].state = "停用";
							}else{
								res.data[i].state = "启用";
                            }

                            res.data[i].cid = Number(res.data[i].cid);
                            
                            var data = new FormData();
                            data.append("cid",res.data[i].cid);
							this.axios.post(that._path.php_path+'/php/get_class_child.php',data).then(res2=>{
                                
                                res.data[i].child = res2.data.length+' 篇内容';
                                res.data[i].child_id = res2.data;
                                this.tableData.push(res.data[i]);
                            })
                        }
					}
					
				})

			},

            handleDeleteAll(index, row){
                this.handleDelete(index, row, "deleteAll")
            },

			// 编辑用户
			handleEdit(index, row) {
                this.now = 'edit';
                this.dialogVisible = true;
                this.class_name = row.class_name;
                this.url_name = row.url_name;
				this.cid = row.cid;
			},


			// 删除用户处理
			handleDelete(index, row, state) {
                var that = this;
                this.$confirm('此操作将会导致所有拥有该标签的文章失去该标签，是否继续?', '警告', {
					confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                    }).then(() => {

                        if (row.child_id.length > 0) {

                        var n3 = 0;
                        for (let i = 0; i < row.child_id.length; i++) {
                            var del_arr = row.child_id[i].class.split(",");
                            var del_index = $.inArray(row.cid,del_arr);
                            del_arr.splice(del_index,1)
                            
                            if (del_arr.length > 0) {
                                var new_arr = del_arr.join(',');
                            }else{
                                var new_arr = '';
                            };

                            
                            
                                $.ajax({
                                    url:that._path.php_path+'/php/del_article_class.php',//url路径
                                    type:'POST', //GET
                                    async:false, //或false,是否异步
                                    data:{//参数
                                        "aid":row.child_id[i].aid,
                                        "class":new_arr,
                                    },
                                    // timeout:5000, //超时时间
                                
                                    success:function(data){
                                        n3++;
                                        setTimeout(() => {
                                            that.$notify({
                                            title: '成功',
                                            message: `文章【${row.child_id[i].title}】已删除【${row.class_name}】标签。`,
                                            type: 'success'
                                        });
                                        },1)
                                        if (n3 == row.child_id.length && state == "deleteAll") {
                                            $.ajax({
                                                url:that._path.php_path+'/php/del_class.php',//url路径
                                                type:'POST', //GET
                                                async:false, //或false,是否异步
                                                data:{//参数
                                                    "cid":row.cid,
                                                },
                                                // timeout:5000, //超时时间
                                            
                                                success:function(data){
                                                    that.$message({
                                                        type: 'success',
                                                        message: '已删除 '+row.class_name
                                                    }); 
                                                }
                                            })
                                        }
                                    }
                                })
                            
                            
                            }
                        }else{
                            if (state == "deleteAll") {
                                this.$confirm('所有文章下的该标签已移除，是否继续删除该标签?', '警告', {
                                confirmButtonText: '确定',
                                cancelButtonText: '取消',
                                type: 'error'
                                }).then(() => {
                                    $.ajax({
                                        url:that._path.php_path+'/php/del_class.php',//url路径
                                        type:'POST', //GET
                                        async:false, //或false,是否异步
                                        data:{//参数
                                            "cid":row.cid,
                                        },
                                        // timeout:5000, //超时时间
                                    
                                        success:function(data){
                                            that.$message({
                                                type: 'success',
                                                message: '已删除 '+row.class_name
                                            });
                                            that.getList();        
                                        }
                                    })
                                })
                                
                            }else{
                                that.$message({
                                    type: 'info',
                                    message: '此标签下无文章。'
                                });
                            }
                        }
                        this.getList();
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
				this.submit_loading = true;
				var data = new FormData();
				this.add_loading_title = "提交中";
				data.append("title",this.form.title);
				data.append("state",Number(this.form.state));
				data.append("content",this.form.content);
				data.append("author",this.form.author);
				data.append("class",this.form.class);

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

            // 停用用户
			handleStop(index, row) {
                var that = this;
				var data = new FormData();
				data.append("cid",row.cid);
				data.append("state",1);
				this.axios.post(that._path.php_path+"/php/state_class.php",data).then(res=>{
					this.$message({
						type: 'success',
						message: '停用成功!'
					});
					this.getList();
				})
            },
            
            // 停用用户
			handleStart(index, row) {
                var that = this;		
				var data = new FormData();
				data.append("cid",row.cid);
				data.append("state",0);
				this.axios.post(that._path.php_path+"/php/state_class.php",data).then(res=>{
					this.$message({
						type: 'success',
						message: '启用成功!'
					});
					this.getList();
				})
			},
		},
		mounted(){
			this.getList();
			
			

		}
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

</style>