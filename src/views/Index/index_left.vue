<template>

    <div id="index_main_left">
        <!-- 卡片循环区 -->
        <el-carousel height="200px" class="banner-box">
            <el-carousel-item>
                <div class="banner-item"></div>
            </el-carousel-item>
            <el-carousel-item>
                <div class="banner-item"></div>
            </el-carousel-item>
            <el-carousel-item>
                <div class="banner-item"></div>
            </el-carousel-item>
        </el-carousel>
        <br>
        <el-card class="box-card" v-for="(data,index) in listData" :key="index" shadow="hover">
            <div slot="header" class="clearfix">
                <span style="font-weight:bold;color:#333333;cursor:pointer" @click="clickCard(data)">{{ data.title }}</span>
                <el-tag v-for="(sdata,index2) in data.class" size="medium" :key="index2" style="margin-left: 10px; float:right;cursor:pointer">{{ sdata }}</el-tag>
            </div>
            <div>
                <p style="margin-top:-10px">
                    <span class="el-icon-time" style="color:#606266;font-size:13px">{{`&nbsp;&nbsp;`+data.publish_time }}</span>
                    <el-tag type="info" size="mini" style="margin-left:10px;cursor:pointer">{{ data.author }}</el-tag>
                </p>
                <div @click="clickCard(data)" style="cursor:pointer;display:flex;align-items:flex-start;">
                   
                    <img class="index_card_img" v-if="data.headerPic" :src="data.headerPic">
                    
                    <span style="text-indent:1em;color:#666;">{{ data.content }}</span>
                </div>
                
            </div>
        </el-card>
        <div v-if="goto_top" id="goto_top">
            <i class="iconfont icon-GlogLOGO"></i>
            <span>回到顶部</span>
        </div>
        

    </div>

</template>

<script>
    export default {
		data() {
            return {
                listData: [],
                cid: '',
                goto_top:false,
            }
        },
        methods:{

            clickCard(data){

                window.location.assign("/article/"+data.aid)
            },

            // 获取文章数据
            getData(){
                var that = this;

                if (window.location.pathname == "/") {
                    this.cid = '';
                }else{
                    this.uname = location.pathname.substr(location.pathname.lastIndexOf("/")+1);
                    $.ajax({
                        url:that._path.php_path+'/php/get_class_id.php',//url路径
                        type:'POST', //GET
                        async:false, //或false,是否异步
                        data:{//参数
                            "uname":this.uname,

                        },
                        // timeout:5000, //超时时间
                        dataType:'json', //返回的数据格式：

                        success:function(data){
                            that.cid = data[0].cid;
                        }
                    });
                }

                var parm = {
                    cid:this.cid,
                }

                SDK.Ajax('/main_Get_Article_Data.php',parm,data=>{

                    if(data.length > 0){
                        for (let i = 0; i < data.length; i++) {
                            data[i].publish_time = data[i].publish_time.substr(0,16);
                            if (data[i].class.length > 0) {
                                data[i].class = data[i].class.split(',');
                            }else{
                                data[i].class = [];
                            }
                            if (data[i].content.length) {
                                var re1 = new RegExp("<.+?>","g");//匹配html标签的正则表达式，"g"是搜索匹配多个符合的内容
                                var msg = data[i].content.replace(re1,'');//执行替换成空字符
                                data[i].content = msg;
                            }
                            if (data[i].content.length>130) {
                                data[i].content = data[i].content.substr(0,130)+'......'
                            }
                        }
                    }
                    this.listData = data;

                    for (let i = 0; i < this.listData.length; i++) {
                        for (let v = 0; v < this.listData[i].class.length; v++) {
                            var parm = {
                                cid:this.listData[i].class[v],
                            };
                            SDK.Ajax('/get_class_data.php',parm,data=>{
                                if(data.length > 0){
                                    this.listData[i].class.push(data[0].class_name);
                                    this.listData[i].class.shift();
                                }
                            })

                        }
                    }
                })

            }
        },
        mounted(){
            this.getData();

            $("#goto_top").click(function () {
                
                document.documentElement.scrollTop = 0;
            })

            window.onscroll = () => {
                if (document.documentElement.scrollTop > 1000) {
                    this.goto_top = true;
                }else{
                    this.goto_top = false;
                }
            }
        },
        watch:{
            $route(to,from){
                this.getData();
            }
        },
    };
    
</script>

<style lang="scss" scoped>
  .text {
    font-size: 14px;
  }

    .box-card {
        width: 100%;
        margin-bottom: 10px
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

     #index_main_left{
        width: 66%;
        float: left;
    }

    #goto_top{
        display: flex;
        margin: 10px auto;
        flex-direction:column;
        width: 60px;
        text-align: center;
        cursor: pointer;
        i{
            font-size: 36px;
            color: #409EFF;
        }
        span{
            color: #909399;
            font-size: 12px;
        }
    }

    .index_card_img{
        width:150px;
        height:100px;
        border-radius:5px;
        border:1px solid #eee;
        flex-shrink:0;
        margin-right:10px;
    }

    .banner-box{
        border-radius: 3px;
    }

    .banner-item{
        width: 100%;
        height: 100%;
        background-color: skyblue;
    }
    
    
</style>