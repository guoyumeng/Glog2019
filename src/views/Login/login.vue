<template>
    <div>
        <div id="main" class="login">
            <div id="main_top">
                <div>
                    <p>登录 Glog</p>
                    <el-input class="input" v-model="username" size="small" placeholder="用户名"></el-input>
                    <br>
                    <el-input class="input" v-model="password" size="small" show-password placeholder="密码"></el-input>
                    <div>
                        <el-button type="primary" size="medium" round @click="login()">登录</el-button>
                        <a href="#" disabled>忘记密码？</a>
                    </div>
                </div>
            </div>
            <div id="main_bottom">
                <div>
                    <p>首次来到 Glog 吗?<a href="/register">现在注册 <i class="el-icon-d-arrow-right"></i></a></p>
                    <p style="display:flex;align-items:center;">
                        <span>登录遇到问题?</span>
                        <a target="_black" href="http://wpa.qq.com/msgrd?v=3&uin=2893918670&site=qq&menu=yes">联系网站管理员 <i class="el-icon-d-arrow-right"></i></a>
                        <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=d9ffa131cc1e35cfbf00a2bbb1e18cefcd180e31f3f05d311dc89084ca891c7f"><img style="display:block" border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="格洛格工作室" title="格洛格工作室"></a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

  export default {
    data() {
      return {
          username: '',
          password: '',
      };
    },
    methods: {

        setcookie(key,value,days) {
            var d = new Date();
            d.setDate(d.getDate() + days);
            document.cookie = key+'='+encodeURIComponent(value)+';expires=' + d;
        },

        login(){
            var that = this;
            var data = new FormData();
            data.append("username",this.username);
            data.append("password",this.password);

            SDK.Ajax('/login.php',{
                username: username,
                password: password,
            },data=>{
                if(data.length > 0 && data[0].state == 0){
                    
                    this.setcookie("guoyumeng_blog",data[0].uid,7);
                    this.$message({
                        message: '登陆成功！正在为你跳转至首页。',
                        type: 'success'
                    });
                    window.location.assign("/")
                }else if(data.length > 0){
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

        

    },

    mounted(){
        
        
        
    }
}
</script>

<style lang="scss" scoped>



    #main{
        width:100%;
        border:1px solid #ddd;
        box-sizing: border-box;
        
        a{
            text-decoration: none;
            font-size: 14px;
            color: #409EFF;
            margin-left: 10px;
        }
        #main_top{
            background-color: #fff;
            padding-top: 30px;
            padding-bottom: 15px;
            >div{

                margin-left: 100px;
                >p{
                    font-size: 20px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                >.input{
         
                    margin:7px 0;
                    width: 300px;
                    font-size: 14px;
                }
                >div{
                    margin-top: 20px;

                }
            }
        }
        #main_bottom{

            background-color: #f5f8fa;
            padding:5px 0;
            >div{

                margin-left: 100px;
                p{
                    color: #606266;
                    font-size: 14px;
                }
            } 
        }
    }


    
</style>
<style>
    .login .el-input__inner{
        border-radius: 0 !important;
    }
</style>