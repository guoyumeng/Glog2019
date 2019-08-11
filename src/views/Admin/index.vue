<template>
  <div>
		<el-container id="wrapper">
			<el-header id="header">
				<el-menu 
				:default-active="$route.path"
				class="el-menu-demo" 
				mode="horizontal" 
				:router="true">
					<el-menu-item index="/admin/home">系统概览</el-menu-item>
					<el-menu-item index="/admin/user">用户管理</el-menu-item>
					<el-menu-item index="/admin/class">分类管理</el-menu-item>
					<el-menu-item index="/admin/Article">文章管理</el-menu-item>
					
					<el-menu-item index="/">进入主站</el-menu-item>
				</el-menu>
			</el-header>
			<el-main>

				<router-view></router-view>
			</el-main>

			<el-footer id="footer">
				<a href="#">帮助</a>
				<a href="#">数据统计</a>
				<a href="#">网站地图</a>
				<a href="#">返回主站</a>
			</el-footer>
		</el-container>
  </div>
</template>

<script>
	export default {
		data() {
			return {

			}
		},
		methods:{
			getcookie(key){
				var cookiearr=decodeURIComponent(document.cookie).split('; ');
				for(var i=0;i<cookiearr.length;i++){
					var newcookiearr=cookiearr[i].split('=');
					if(key==newcookiearr[0]){
						return newcookiearr[1];
					}
				}
			},

			setcookie(key,value,days) {
                var d = new Date();
                d.setDate(d.getDate() + days);
                document.cookie = key+'='+encodeURIComponent(value)+';expires=' + d + ';path=/';
            },

			check_login(){
				var that = this;
				if (this.getcookie("glog_admin")) {
					var auid = this.getcookie("glog_admin");

                    
					$.ajax({
						url:that._path.php_path+'/php/check_admin.php',//url路径
						type:'POST', //GET
						async:false, //或false,是否异步
						data:{//参数
							"auid":auid,
						},
						// timeout:5000, //超时时间
						dataType:'json', //返回的数据格式：

						success:function(data){
							if(data.length == 0){
								that.setcookie("glog_admin",'0',-1)
								window.location.assign("/admin/");
							}
						}
					})
				}else{
					window.location.assign("/admin/");
				}
			},
		},
		mounted(){
            this.check_login();
            
            
		}
	}
</script>
<style lang="scss">
html,body{
		height: 100%;
	}
    #app{
        height: 100%;
        >div{
            height:100%;
        }
    }
</style>
<style scoped>
#wrapper{
    height:100%;
}
	html,body{
		margin:0;
		padding: 0;
	}

	#header *{
		text-decoration: none;
	}
	
	.active{
		font-weight: bold;
		color: #409EFF;
	}

	#footer{
		background-color:#eee;
		border-top:1px solid #ddd;
		height: 40px !important;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        justify-content: flex-start;
        align-items: center;
	}

	#footer a{
		color:#909399;
		font-size:13px;
		text-decoration: none;
		margin-left: 10px;
	}
</style>