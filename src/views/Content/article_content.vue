<template>
    <div>
        <div id="main">
            <div id="main_top">
                <div>
                    <h1>{{ this.data.title }}</h1>
                    <!-- <el-page-header :content="this.data.title"></el-page-header> -->
                    <p>
                        <span style="color:#606266;font-size:14px;">{{ this.data.author }}</span>
                        <span style="margin-left:20px;color:#606266;font-size:14px;">{{ this.data.publish_time }}</span>
                        
                        <template v-if="data.class != ''">
                            <el-tag v-for="(sdata,index2) in data.class" size="medium" :key="index2" style="margin-left: 10px; float:right;cursor:pointer">{{ sdata }}</el-tag>
                        </template>
                        <span style="margin-left:20px;color:#909399;font-size:14px;">{{ `阅读量：${this.data.read_num}次` }}</span>
                    </p>

                    <el-divider></el-divider>
                    <div id="article_content"></div>
                    <p style="float:right;font-size:12px;color:#909399">原创内容，受版权保护</p>
                </div>
            </div>
            <div id="main_bottom">
                
                <div style="min-height:120px;">
                    <template v-if="this.username == ''">
                        <textarea id="comment_input_dis" rows="3" v-model="user_input" disabled placeholder="要发表评论需要先登录哦"></textarea>
                        
                        
                    </template>
                    <template v-else>
                        <textarea id="comment_input" rows="3" v-model="user_input" placeholder="发表评论内容"></textarea>
                        <el-button @click="publish()" style="float:right;margin:10px 0;" size="small" type="primary">发表评论</el-button>
                    </template>

                    <el-card v-for="(data,index) in comment_data" :key="index" class="box-card" shadow="hover">
                        <div slot="header" class="clearfix user_card">
                            <div style="display:inline-flex">
                                <img class="user_pic" :src="data.headPortrait" alt="头像">
                                <div class="username_box">
                                    <span class="user_name">{{data.username}}</span>
                                    <span class="write_time">{{data.time}}</span>
                                </div>
                            </div>
                            <el-button style="float: right;margin-top:5px;" size="small" plain disabled>查看用户</el-button>
                        </div>
                        <div style="color:#606266;">
                            {{data.content}}
                        </div>
                        <div class="bottom_button_group">
                            <el-button class="bottom_button" disabled type="text">回复</el-button>
                            <template v-if="data.user_id == uid">
                                <el-button class="bottom_button" disabled type="text" title="你不能反对自己的评论。">反对 {{data.no}}</el-button>
                                <el-button class="bottom_button" disabled type="text" title="你不能赞同自己的评论。">赞同 {{data.yes}}</el-button>
                                <el-button class="bottom_button" type="text" @click="delete_comment(data)">删除</el-button>
                            </template>
                            <template v-else>
                                <el-button class="bottom_button" type="text" @click="yesOrNo(data,'no')">反对 {{data.no}}</el-button>
                                <el-button class="bottom_button" type="text" @click="yesOrNo(data,'yes')">赞同 {{data.yes}}</el-button>
                            </template>
                            
                            
                        </div>
                    </el-card>

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
          user_input: '',
          data: {
              read_num:0,
          },
          uid: '',
          comment_data: [],
      };
    },
    methods: {

        publish(){
            var that = this;
            var data = new FormData();
            data.append("user_id",this.uid);
            data.append("content",this.user_input);
            data.append("of_article",this.data.aid);
            this.axios.post(that._path.php_path+'/php/add_comment.php',data).then(res=>{
                this.user_input = '';
                this.$message({
                    message: '评论发表成功！',
                    type: 'success'
                });
                this.getdata();
            })
        },

        yesOrNo(data,item){
            var that = this;
            var data2 = new FormData();
            data2.append("coid",data.coid);
            this.axios.post(that._path.php_path+'/php/get_one_comment.php',data2).then(res=>{
                if (item == "yes") {
                    var data3 = new FormData();
                    data3.append("coid",res.data[0].coid);
                    data3.append("item",item);
                    data3.append("new_num",Number(res.data[0].yes)+1);

                    this.axios.post(that._path.php_path+'/php/set_comment.php',data3).then(res=>{
                        this.getdata();
                        
                    })
                }else if(item == "no"){
                    var data3 = new FormData();
                    data3.append("coid",res.data[0].coid);
                    data3.append("item",item);
                    data3.append("new_num",Number(res.data[0].no)+1);

                    this.axios.post(that._path.php_path+'/php/set_comment.php',data3).then(res=>{
                        this.getdata();
                    })
                }
                
            })
        },

        delete_comment(data){
            var that = this;
            this.$confirm('确认删除这条评论吗?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                var data2 = new FormData();
                data2.append("coid",data.coid);
                this.axios.post(that._path.php_path+'/php/del_comment.php',data2).then(res=>{
                    this.getdata();
                })
            })
            
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
                this.uid = this.getcookie("guoyumeng_blog");
                var data = new FormData();
                data.append("uid",uid);
                this.axios.post(that._path.php_path+"/php/check_user.php",data).then(res=>{
                    this.username = res.data[0].username;
                })

            }else{
                this.username = '';
            }
        },

        getdata(){
            var aid = location.pathname.substr(location.pathname.lastIndexOf("/")+1);
            var that = this;
            var data = new FormData();
            data.append("aid",aid);
            this.axios.post(that._path.php_path+'/php/Get_One_Article_Data.php',data).then(res=>{
                if(res.data.length > 0){

                    this.data = res.data[0];

                    var data = new FormData();
                    data.append("aid",res.data[0].aid);
                    data.append("read_num",Number(res.data[0].read_num)+1);
                    this.axios.post(that._path.php_path+'/php/article_Num.php',data);

                    this.data.class = this.data.class.split(',');
                    for (let v = 0; v < this.data.class.length; v++) {
                        var data = new FormData();
                        data.append("cid",this.data.class[v]);
                        this.axios.post(that._path.php_path+'/php/get_class_data.php',data).then(res2=>{
                            if(res2.data.length > 0){
                                this.data.class.push(res2.data[0].class_name);
                                this.data.class.shift();
                            }
                        })
                    }

                    var data = new FormData();
                    data.append("of_article",this.data.aid);
                    this.axios.post(that._path.php_path+'/php/get_comment.php',data).then(res=>{

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
                                    if (data.length == 0) {
                                        res.data[i].username = "用户已注销"
                                        res.data[i].headPortrait = "/data/pic/user-none.png"
                                    }else if (!data[0].imageUrl){
                                        res.data[i].username = data[0].username;
                                        res.data[i].headPortrait = "/data/pic/user-default.png"
                                    }else{
                                        res.data[i].username = data[0].username;
                                        res.data[i].headPortrait = data[0].imageUrl;
                                    }
                                    
                                    
                                    
                                }
                            })
                            
                        }
                        this.comment_data = res.data;
                    })

                    document.getElementById("article_content").innerHTML = that.data.content;
                }
            })
            
            
            
        }
    },

    mounted(){

        this.getdata();
        this.check_login();
        
        window.setTimeout(function () {
            $("#comment_input").blur(function(){
                $("#comment_input").css("border-color","#DCDFE6");
            });
            $("#comment_input").focus(function(){
                $("#comment_input").css("border-color","#409EFF");
            });
        },100)
        
        
    }
}
</script>

<style lang="scss">
#article_content{
        font-size: 14px;
        line-height: 1.6em;
        p{
            
            margin: 10px 0;
        }
    }
    
</style>

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
            padding-bottom: 100px;
            >div{

                margin-left: 100px;
                margin-right: 100px;
                
            }
        }
        #main_bottom{

            background-color: #f5f8fa;
            padding:5px 0;
            
            >div{

                margin-left: 100px;
                margin-right: 100px;
                p{
                    color: #606266;
                    font-size: 14px;
                }
            } 
        }
    }

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
        width: 100%;
        margin: 10px 0;
        border-radius: 0;
    }

    

    .user_card{
        margin: -5px 0;
        .user_pic{
            height: 40px;
            width: 40px;
            border-radius: 50%;
            vertical-align: middle;
        }
        
    }

    .bottom_button{
        float: right;
        padding: 3px 0;
        margin: 10px 0;
        margin-left: 20px;
        display: block;
    }

    .username_box{
        display: flex;
        flex-direction:column;
        margin-left: 10px;
        justify-content:space-between;
        .write_time{
            font-size: 12px;
            color: #909399;
        }
        .user_name{
            height:auto;
            line-height: 18px;
            font-size: 16px;
            color: #606266;
        }
    }

    #comment_input,#comment_input_dis{
        outline:none;
        width: 100%;
        box-sizing: border-box;
        padding:10px;
        resize:none;
        border-color: #DCDFE6;
        margin-top: -30px;
        font-size: 14px;
    }
    #comment_input_dis{
        background-color: #fcfdfe;
    }

    
    
</style>