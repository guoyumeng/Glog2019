<template>
	<div>
		<!-- 用户表格主体结构 -->
		<el-table
			:data="comment_data"
            :default-sort = "{prop: 'coid', order: 'ascending'}"
            :row-class-name="tableRowClassName"
			style="width: 100%">

			<el-table-column
                key="coid"
				prop="coid"
				label="评论编号"
				width="100">
			</el-table-column>

			<el-table-column
				prop="username"
                width="200"
				label="评论人">
			</el-table-column>

			<el-table-column
				prop="content"
				label="评论内容">
			</el-table-column>

			<el-table-column
				prop="time"
                width="200"
				label="评论时间">
			</el-table-column>

			<el-table-column
				prop="yes"
                width="100"
				label="赞同数">
			</el-table-column>

			<el-table-column
				prop="no"
                width="100"
				label="反对数">
			</el-table-column>

            <el-table-column
				width="200"
				label="操作">
				<template slot-scope="props">
                    <el-button-group>

                    <el-button
						size="mini"
						type="info"
                        v-if="props.row.state == 1"
						@click="handleStop(props.$index, props.row)">隐藏</el-button>
                    <el-button
						size="mini"
						type="success"
                        v-else
						@click="handleStart(props.$index, props.row)">显示</el-button>

					<el-button
						size="mini"
						type="danger"
						@click="handleDelete(props.$index, props.row)">删除</el-button>
                    </el-button-group>
				</template>
			</el-table-column>
			
			

		</el-table>

		
	</div>
	
</template>



<script>
	
  export default {
		data() {
			return {
				data: {},
				tableData: [],
                dialogVisible: false,
                class_name: '',
                url_name: '',
                cid: '',

                comment_data: [],
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
			


			// 获取用户数据列表
			getList(){
				var that = this;
                // 获取数据内容
                var aid = location.pathname.substr(location.pathname.lastIndexOf("/")+1);
                
                var data = new FormData();
                data.append("of_article",aid);
                this.axios.post(that._path.php_path+'/php/admin_get_comment.php',data).then(res=>{

                    for (let i = 0; i < res.data.length; i++) {
                        $.ajax({
                            url:that._path.php_path+'/php/check_user.php',//url路径
                            type:'POST', //GET
                            async:false, //或false,是否异步
                            dataType:'json', //返回的数据格式：
                            data:{//参数
                                "uid":res.data[i].user_id,
                            },
                        
                            success:function(data){
                                if (data.length > 0) {
									res.data[i].username = data[0].username;
								}else{
									res.data[i].username = "用户已注销";
								}
                            }
                        })
                        
                    }
                    this.comment_data = res.data;
                })

                
                

			},

            handleDelete(index, row){
				var that = this;
                this.$confirm('确认删除这条评论吗？你还可以选择隐藏但保留评论内容。', '评论删除确认', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    var data = new FormData();
                    data.append("coid",row.coid);
                    this.axios.post(that._path.php_path+'/php/del_comment.php',data).then(res=>{
                        this.getList();
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });          
                });
            },

			

            // 停用用户
			handleStop(index, row) {
                var that = this;
				var data = new FormData();
				data.append("coid",row.coid);
				data.append("state",0);
				this.axios.post(that._path.php_path+"/php/state_comment.php",data).then(res=>{
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
				data.append("coid",row.coid);
				data.append("state",1);
				this.axios.post(that._path.php_path+"/php/state_comment.php",data).then(res=>{
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