<template>
    <div>
        <div id="main" class="register">
            <div id="main_top">
                <div>
                    <p>注册 Glog 账号</p>
                    <el-input class="input" v-model="username" size="small" placeholder="用户名"></el-input>
                    <br>
                    <el-input class="input" v-model="password" size="small" show-password placeholder="密码"></el-input>
                    <br>
                    <el-input class="input" v-model="rep_pass" size="small" show-password placeholder="重复密码"></el-input>
                    <br>
                    <span>
                        <el-radio v-model="sex" label="男">男</el-radio>
                        <el-radio v-model="sex" label="女">女</el-radio>
                        <el-radio v-model="sex" label="保密">保密</el-radio>
                    </span>

                    <el-upload
                    class="avatar-uploader"
                    :action="this._path.php_path+'/php/upload/'"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                        <img v-if="imageUrl" :src="imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                    
                    <div>
                        <el-button type="primary" size="medium" round @click="reg()">注册</el-button>
                    </div>
                </div>
            </div>
            <div id="main_bottom">
                <div>
                    <p>已有 Glog 账号? <a href="/login">现在登录 <i class="el-icon-d-arrow-right"></i></a></p>
                    <p>
                        <a href="/read">服务条款</a>
                        <span> 和 隐私政策 暂未修订。</span>    
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
            rep_pass: '',
            sex: '',
            imageUrl: '',
      };
    },
    methods: {

        handleAvatarSuccess(res, file) {
            this.imageUrl = res;
        },
        beforeAvatarUpload(file) {
            
            const isJPG = file.type === 'image/jpeg';
            const isPNG = file.type === 'image/png';
            const isLt2M = file.size / 1024 / 1024 < 2;
            
            if (!isJPG && !isPNG) {
                this.$message.error('上传头像图片只能是 JPG 或者 PNG 格式!');
            }
            if (!isLt2M) {
                this.$message.error('上传头像图片大小不能超过 2MB!');
            }
            return (isJPG || isPNG) && isLt2M;
        },

        setcookie(key,value,days) {
            var d = new Date();
            d.setDate(d.getDate() + days);
            document.cookie = key+'='+encodeURIComponent(value)+';expires=' + d;
        },

        reg(){
            var that = this;
            if (this.username.length <2 || this.username.length >= 10) {
                that.$message({
                    message: '用户名长度需要在 2 至 10 个字符之间。',
                    type: 'error'
                });
            }else if(this.password !== this.rep_pass){
                that.$message({
                    message: '两次密码输入不一致，请重新输入。',
                    type: 'error'
                });
            }else if(this.password.length < 8 || this.password.length > 40){
                that.$message({
                    message: '密码长度需要在 8 至 40 个字符之间。',
                    type: 'error'
                });
            }else{

                SDK.Ajax('/check_user_reg.php',{
                    "username":that.username,
                },data=>{
                    if(data.length !== 0){
                        that.$message({
                            message: '用户名已存在，请重新选择用户名。',
                            type: 'error'
                        });
                    }else{

                        that.sendReg();

                    }
                })

            }
            
        },
        sendReg(){
            var that = this;
            var parm = {
                username: that.username,
                password: that.password,
                sex: that.sex,
                imageUrl: that.imageUrl,
                province: "null",
                city: "null",
                register_ip: "null",
            };
            console.log(parm);
            
            SDK.Ajax('/user_reg.php',parm,data=>{

                that.$message({
                    message: '注册成功！请登录。',
                    type: 'success'
                });
                window.setTimeout(() => {
                    window.location.assign("/login");
                },2000)
            })
        }
        

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
        p {
            a:nth-of-type(1){
                margin-left:0px;
            }
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
                >span{
                    display: block;
                    margin-top: 10px;
                }
            }
        }
        
        #main_bottom{
            
            background-color: #f5f8fa;
            padding:5px 0;
            padding-right: 80px;
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
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 150px;
    height: 150px;
    line-height: 150px;
    text-align: center;
  }
  .avatar {
    width: 150px;
    height: 150px;
    display: block;
  }

  .register .el-input__inner{
        border-radius: 0 !important;
    }
</style>