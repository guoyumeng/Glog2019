<template>
    <el-container id="wrapper" style="background-color:#e6ecf0">
        <!-- 前台头部区域 -->
        <el-header style="margin:0;padding:0;position:fixed;background-color:#545c64;width:100%;z-index:100">
            
            <el-menu
            :default-active="$route.path"
            class="el-menu-demo"
            mode="horizontal"
            @select="handleSelect"
            :router="true"
            style="width:95%; margin:0 auto;height:60px"
            background-color="#545c64"
            text-color="#fff"
            active-text-color="#ffd04b">
            <el-menu-item index="/">主站</el-menu-item>
            
            <el-submenu index="/">
                <template slot="title">分类内容</template>

                <el-menu-item v-for="(data,index) in class_list" :key="index" :index='"/class/"+data.url_name'>{{ data.class_name }}</el-menu-item>

            </el-submenu>

            <el-menu-item index="3" disabled>图片故事</el-menu-item>
            <el-menu-item index="4" disabled>冬日暖阳</el-menu-item>


            


            <div v-if="username == ''" id="header_login">
                <el-button plain class="login_btn" @click="login()">登录</el-button>
            </div>

            <div v-else id="header_user">
                <el-dropdown style="cursor:pointer">
                    <span class="el-dropdown-link">{{ username }}

                        <i class="lv-tag">LV1</i>
                        <b class="vip-tag" v-if="vip == 'v'">VIP</b>
                        <b class="vip-tag" v-if="vip == 'v1'">VIP1</b>
                        <b class="vip-tag" v-if="vip == 'v2'">VIP2</b>
                        <b class="vip-tag" v-if="vip == 'v3'">VIP3</b>
                        <b class="vip-tag" v-if="vip == 'v4'">VIP4</b>
                        <b class="vip-tag" v-if="vip == 'v5'">VIP5</b>
                        <b class="svip-tag" v-if="vip == 's'">SVIP</b>
                        <b class="svip-tag" v-if="vip == 's1'">SVIP1</b>
                        <b class="svip-tag" v-if="vip == 's2'">SVIP2</b>
                        <b class="svip-tag" v-if="vip == 's3'">SVIP3</b>
                        <b class="svip-tag" v-if="vip == 's4'">SVIP4</b>
                        <b class="svip-tag" v-if="vip == 's5'">SVIP5</b>
                        <b class="aut-tag" v-if="vip == 'aut'">AUT</b>

                        <i class="el-icon-arrow-down el-icon--right"></i>
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


            <div id="top_search" style="margin-top: 14px;float:right;margin-right:20px">
                <el-input placeholder="请输入搜索标题" v-model="search_input" size="small">
                    <el-button slot="append" icon="el-icon-search" @click="search()"></el-button>
                </el-input>

            </div>

            <i id="header_logo" class="iconfont icon-GlogLOGO" title="Welcome to Glog"></i>
            
            </el-menu>


        </el-header>

        <!-- 前台左侧区域 -->
        <el-main id="index_main" style="padding:10px 0;">
            <router-view name="index_left"></router-view>
            
        </el-main>

        <!-- 前台右侧区域 -->
        <div id="right">
        <div id="write_email">
            <router-view name="index_right"></router-view>
            
        </div>
        </div>
        
    </el-container>
</template>

<script>
  export default {

    data() {
      return {
        username: '',
        vip:'',
        activeIndex: '1',
        activeIndex2: '1',
        search_input: '',
        class_list: [],
        
      };
    },
    methods: {

        // 多选项选择事件
        handleSelect(key, keyPath) {

        },

        search(){
            alert("功能开发中！")
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

        check_login(){
            var that = this;
            if (this.getcookie("guoyumeng_blog")) {
                var uid = this.getcookie("guoyumeng_blog");
                var data = new FormData();
                data.append("uid",uid);
                this.axios.post(that._path.php_path+"/php/check_user.php",data).then(res=>{
                    this.username = res.data[0].username;
                    this.vip = res.data[0].vip;
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
        },

        login(){
            window.location.assign("/join/")
        },

        getclass(){
            var that = this;
            this.tableData = [];
            var data = new FormData();
            data.append("cid",0);
            this.axios.post(that._path.php_path+'/php/get_class_data.php',data).then(res=>{
                this.class_list = res.data;
            })
            
        },


        add_visit(){
            var that = this;
            var data = new FormData();
            
            data.append("province",'NULL');
            data.append("city",'NULL');
            data.append("ip",'NULL');
            
            
            // 将数据提交至服务器
            SDK.Json("add_visit.php",{
                province: "null",
                city: "null",
                ip: "null",
            },function (jon) {
                console.log(jon);
                
            })
            // this.axios.post(that._path.php_path+"/php/add_visit.php",data)
                
        },

    },

    mounted(){
        this.check_login();
        this.getclass();
        this.add_visit()
        
        $("#top_search_input").blur(function(){
            $("#top_search_input").css("background-color","rgba(255, 255, 255, 0.1)");
            $("#top_search_input").css("border-color","#dcdfe6");
            if ($("#top_search_input").val() == '') {
                $("#top_search_title").css("display","block");
            }else{
                $("#top_search_title").css("display","none");
            }
        });
        $("#top_search_input").focus(function(){
            $("#top_search_input").css("background-color","transparent");
            $("#top_search_input").css("border-color","#409EFF");
            $("#top_search_title").css("display","none");
        });

        $("#wrapper").css("min-height",(document.documentElement.clientHeight) + "px");

    }
}
</script>

<style lang="scss" scoped>

    .vip-tag{
        color:red;
        margin: 0 5px;
    }
    .svip-tag{
        color:gold;
        margin: 0 5px;
    }
    .aut-tag{
        color:deepskyblue;
        margin: 0 5px;
    }
    .lv-tag{
        font-style: normal;
        margin: 0 5px;
        font-size: 12px;
        border: 1px solid rgba(255,255,255,0.5);
        padding: 0 3px;
    }

    #index_main{
        width:95%;
        margin: 0 auto;
        margin-top: 60px;

    }

    #right{
            width: 31.5%;
            height: 90%;
            position: fixed;
            left: 66%;
            margin-top: 60px;
            margin-left: 0;
            z-index: 10;

    }
    #write_email{
        float: right;
        height:100%;
        width:100%;
        
    }

    

    

    #header_user{
        height:100%;
        display: block;
        
        line-height: 60px;
        float: right;
        span{
            color: #FFFFFF;
        }
        
    }

    #header_login{
        height:100%;
        display: block;
        
        line-height: 60px;
        float: right;
        .login_btn{
            background: none;
            color: #FFFFFF;
            border-color: transparent;
            border-radius: 0;
            transition: all 0.2s;
        }
        .login_btn:hover{
            color: #409EFF;
            border-color: #409EFF;

        }
    }

    #header_logo{
        width: 40px;
        position:absolute;
        left:50%;
        color: #FFFFFF;
        margin-left: -20px;
        font-size: 30px;
        text-align: center;
        line-height: 60px;
        outline: none;
    }

</style>