<template>
  <div id="admin_login">
		<el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>后台管理系统</span>
            
        </div>
        <div class="text item">
            <el-input class="input" v-model="username" placeholder="输入管理账号"></el-input>
            <el-input class="input" v-model="password" type="password" placeholder="输入管理密码"></el-input>
            <el-button class="button" type="primary" @click="login()">登录后台</el-button>
        </div>
        </el-card>
            
  </div>
</template>

<script>
	export default {
		data() {
			return {
                username: '',
                password: '',
			}
		},
		methods:{
			login(){
                var that = this;
                $.ajax({
					url:that._path.php_path+'/php/admin_login.php',//url路径
					type:'POST', //GET
					async:false, //或false,是否异步
					data:{//参数
						"username":this.username,
						"password":this.password,
					},
					// timeout:5000, //超时时间
					dataType:'json', //返回的数据格式：

					success:function(data){
                        if(data.length > 0){
                            that.setcookie("glog_admin",data[0].auid,1);
                            window.location.assign("/admin/home");
                        }
                    }
                })
            },


            setcookie(key,value,days) {
                var d = new Date();
                d.setDate(d.getDate() + days);
                document.cookie = key+'='+encodeURIComponent(value)+';expires=' + d + ';path=/';
            },

            getcookie(key){
                var cookiearr=decodeURIComponent(document.cookie).split('; ');
                for(var i=0;i<cookiearr.length;i++){
                    var newcookiearr=cookiearr[i].split('=');
                    if(key==newcookiearr[0]){
                        return newcookiearr[1];
                    }
                }
            },
		},
		mounted(){
			if (this.getcookie("glog_admin")) {
                window.location.assign("/admin/home");
            }
		}
	}
</script>
<style>
    #admin_login .input .el-input__inner{
      border-radius: 0;
      margin: 10px 0;
  }
</style>
<style scoped>


	.text {
    font-size: 14px;
  }

  .item {
    margin-bottom: 18px;
  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }
  .clearfix:after {
    clear: both
  }

  .box-card {
    height: 300px;
    width: 400px;
    position: fixed;
    left: 50%;
    top:50%;
    margin-top: -150px;
    margin-left: -200px;
    border-radius: 0;
  }

  
  .button{
      border-radius: 0;
      width: 100%;
      margin-top: 20px;
  }


</style>