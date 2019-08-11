<template>
    <el-container id="main" style="background-color:#e6ecf0;">

        <el-header style="margin:0;padding:0;position:fixed;width:100%;z-index: 1000;background-color:#fff">
            <el-menu
            default-active="/article"
            class="el-menu-demo"
            mode="horizontal"
            :router="true"
            
            style="width:1000px;margin:0 auto;height:60px;">
            <el-menu-item index="/article" disabled>文章详情</el-menu-item>
            <el-menu-item index="/">回到主站</el-menu-item>


   
            

            <div v-if="username == ''" id="header_login">
                <el-button plain class="login_btn" @click="login()">登录</el-button>
            </div>

            <div v-else id="header_user">
                <el-dropdown style="cursor:pointer">
                    <span class="el-dropdown-link">{{ username }}<i class="el-icon-arrow-down el-icon--right"></i>
                    </span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item disabled>个人中心</el-dropdown-item>
                        <el-dropdown-item disabled>我的收藏</el-dropdown-item>
                        <el-dropdown-item disabled>用户设置</el-dropdown-item>
                        <el-dropdown-item disabled>系统设置</el-dropdown-item>
                        <el-dropdown-item divided @click.native="signOut()">退出登录</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </div>

            </el-menu>


        </el-header>


        <el-main id="index_main" style="padding:10px 0;">
            <router-view></router-view>
        </el-main>


        
    </el-container>
</template>

<script>
  export default {
    data() {
      return {
        username: '',


        
      };
    },
    methods: {

        getcookie(key){
	    	var cookiearr=decodeURIComponent(document.cookie).split('; ');
	    	for(var i=0;i<cookiearr.length;i++){
	    		var newcookiearr=cookiearr[i].split('=');
	    		if(key==newcookiearr[0]){
	    			return newcookiearr[1];
	    		}
	    	}
        },

        check_login(){
            var that = this;
            if (this.getcookie("guoyumeng_blog")) {
                var uid = this.getcookie("guoyumeng_blog");
                var data = new FormData();
                data.append("uid",uid);
                this.axios.post(that._path.php_path+"/php/check_user.php",data).then(res=>{
                    if (res.data.length > 0) {
                        
                        this.username = res.data[0].username;
                    }else{
                        this.username = '';
                    }
                })

            }else{
                this.username = '';
            }
        },

        setcookie(key,value,days) {
            var d = new Date();
            d.setDate(d.getDate() + days);
            document.cookie = key+'='+encodeURIComponent(value)+';expires=' + d + ';path=/';
        },

        signOut(){
            this.setcookie('guoyumeng_blog','1000',-1);
            this.$message('用户已退出。');
            this.check_login();
            window.location.reload();
        },

        login(){
            window.location.assign("/join/")
        }
    },

    mounted(){
        this.check_login();
        
        // 延时调整一次
        window.setTimeout(function() {
            

            if (document.getElementById("main")) {
                
                $("#main").css("min-height",(document.documentElement.clientHeight) + "px")
            }
            
            

        },0)

        window.onresize=function(){
            if (document.getElementById("main")) {
                $("#main").css("min-height",(document.documentElement.clientHeight) + "px")
            }
            
            
        };
        
    }
}
</script>

<style lang="scss" scoped>



    #index_main{
        width:1000px;
        margin: 0 auto;
        margin-top: 60px;

    }

    #header_login{
        height:100%;
        display: block;
        
        line-height: 60px;
        float: right;
        .login_btn{
            background: none;
            color: #409EFF;
            border-color: transparent;
            border-radius: 0;
            transition: all 0.2s;
        }
        .login_btn:hover{
            
            border-color: #409EFF;

        }
    }

    #header_user{
        height:100%;
        display: block;
        
        line-height: 60px;
        float: right;
        span{
            color: #409EFF;
        }
        
    }



    
</style>