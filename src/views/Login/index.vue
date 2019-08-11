<template>
    <div style="height:100%;display:flex;flex-direction: column;">

        <div id="main">
            <div id="main_left">
                <i class="iconfont icon-GlogLOGO" id="logo_bg"></i>
                <div class="center_box center_box1">
                    <p><i class="el-icon-date"></i>记录工作与生活。</p>
                    <p><i class="el-icon-cpu"></i>讨论科技前沿技术。</p>
                    <p><i class="el-icon-film"></i>查看分享的影集。</p>

                </div>
            </div>
            <div id="main_right">
                <div class="header_box">
                    <el-input v-model="username" placeholder="用户名"></el-input>
                    <el-input v-model="password"  show-password placeholder="密码"></el-input>
                    <el-button class="btn" type="primary" round plain @click="login()">登录</el-button>
                </div>
                <div class="center_box center_box2">
                    <i class="iconfont icon-GlogLOGO"></i>
                    <p>看看我分享的新鲜事</p>
                    <p>现在就加入 Glog。</p>
                    <el-button class="btn" type="primary" round @click="reg_btn()">注册</el-button>
                    <el-button class="btn" type="primary" round plain @click="login_btn()">登录</el-button>
                </div>
            </div>
        </div>
        <div id="footer">
            <p>
                <a href="#">关于</a>
                <a href="#">帮助中心</a>
                <a href="#">博客</a>
                <a href="#">状态</a>
                <a href="#">条款</a>
                <a href="#">隐私政策</a>
                <a href="#">Cookies</a>
                <a href="/">主站</a>
                <a href="#">应用</a>
                <a href="#">广告</a>
                <a href="/admin/">后台管理</a>
                <a href="#">目录</a>
                <a href="#">设置</a>
                <a>© 2019 Glog</a>
            </p>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
          password: '',
          username: '',

      };
    },
    methods: {
        
        login(){
            var that = this;
            var data = new FormData();
            data.append("username",this.username);
            data.append("password",this.password);
            this.axios.post(that._path.php_path+"/php/login.php",data).then(res=>{
                if(res.data.length > 0 && res.data[0].state == 0){
                    
                    this.setcookie("guoyumeng_blog",res.data[0].uid,7);
                    this.$message({
                        message: '登陆成功！正在为你跳转至首页。',
                        type: 'success'
                    });
                    window.location.assign("/")
                }else if(res.data.length > 0){
                    this.$message({
                        message: '用户已被停用，请联系管理员或重新注册。',
                        type: 'error'
                    });
                }else{
                    this.$message({
                        message: '用户名或密码错误，如果忘记密码请重新注册或联系管理员。',
                        type: 'error'
                    });
                }
                
            })
        },

        setcookie(key,value,days) {
            var d = new Date();
            d.setDate(d.getDate() + days);
            document.cookie = key+'='+encodeURIComponent(value)+';expires=' + d + ";path=/";
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

        reg_btn(){
            window.location.assign("/register");
        },

        login_btn(){
            window.location.assign("/login");
        },
    },
    mounted(){
        
        // 延时调整一次
        window.setTimeout(function() {

            document.getElementById("main").style.height = (document.documentElement.clientHeight) * 14/15 + "px";

            $("#logo_bg").css("line-height",(document.documentElement.clientHeight) * 14/15 + "px");
            $("#logo_bg").css("font-size",(document.documentElement.clientHeight) * 17/15 + "px");
            
            document.getElementById("footer").style.height = document.documentElement.clientHeight * 1/15 + "px";

        },0)

        window.onresize=function(){
            document.getElementById("main").style.height = (document.documentElement.clientHeight) * 14/15 + "px";
            $("#logo_bg").css("line-height",(document.documentElement.clientHeight) * 14/15 + "px");
            $("#logo_bg").css("font-size",(document.documentElement.clientHeight) * 17/15 + "px");
            document.getElementById("footer").style.height = document.documentElement.clientHeight * 1/15 + "px";
            
        };
    }
}
</script>

<style lang="scss" scoped>

    #main{
        display: flex;
        width:100%;
        flex-grow: 1;
    }

    #main_left{
        position: relative;
        background-color: #409EFF;
        width:50%;
        height: 100%;
        overflow: hidden;
        height: 100%;

        #logo_bg{
            display: block;

            width: 100%;
            text-align: center;
            position: absolute;
            left: 50%;
            margin-left: -180px;
            color: rgba($color: #000000, $alpha: 0.1)
        }
    }

    #main_right{
        position: relative;
        background-color: #FFFFFF;
        width:50%;
        height: 100%;
    }

    .center_box{
        height:280px;
        width:260px;
        position: absolute;
        left:50%;
        top:50%;
        margin-left: -130px;
        margin-top: -140px;
    }

    .center_box1{
        display: flex;
        flex-direction:column;
        justify-content:space-around;
        p{
            color:white;
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items:center;
            i{
                font-size: 30px;
                font-weight: normal;
                margin-right: 15px;
            }
        }
    }

    .center_box2{
        display: flex;
        flex-direction:column;
        justify-content:space-between;
        .el-button{
            margin:0
        }
        i{
            color: #409EFF;
            font-size: 40px;
        }
        p:nth-of-type(1){
            font-size: 26px;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 30px
        }
        p:nth-of-type(2){
            font-size: 17px;
            font-weight: bold;
        }
        .btn:nth-of-type(1){
            font-weight: bold
        }
        .btn:nth-of-type(2){
            font-weight: bold;

        }
    }

    .header_box{
        display: flex;
        width: 500px;
        justify-content:space-between;
        position: absolute;
        left:50%;
        margin-left:-250px;
        margin-top: 30px;
        >*{
            margin: 0 5px
        }
        .btn{
            width:150px;
            padding: 0;
            font-weight: bold;
        }
    }

    #footer{
        width: 100%;
        box-sizing: border-box;
        border-top:1px solid #eee;
        display: flex;
        justify-content:center;
        align-items:center;
        overflow: hidden;
        height: 40px !important;
        p{
            display: flex;
            justify-content:center;
            align-items: center;
            height:100%;
            a{
                margin: 0 15px;
                text-decoration: none;
                color: #909399;
                font-size: 12px;
                
            }
            a:hover{
                text-decoration: underline;
            }
            a:nth-last-of-type(1):hover{
                text-decoration: none;
            }
        }
    }
    
</style>