<template>

        <!-- 前台右侧区域 -->
        <div id="index_right">

            <!-- 右侧区域一 -->
            <div id="index_main_right1">
                <el-collapse v-model="activeName" accordion>
                <p class="right_title" style="color:#333333">推荐内容</p>

                
                <el-collapse-item v-for="(data,index) in important_list" :key="index" :title="data.title" class="right1_title">
                    <div style="padding:0 1em;cursor: pointer;color:#666;" @click="clickCard(data)">{{ data.content }}</div>
                </el-collapse-item>


                </el-collapse>
            </div>

            <!-- 右侧区域二 -->
            <div id="index_main_right2">
                <el-collapse v-model="activeName2" accordion>
                <p class="right_title" style="color:#333333">热度最高</p>

                <el-collapse-item v-for="(data,index) in hot_list" :key="index" :title="data.title" class="right1_title">
                    <div style="padding:0 1em;cursor: pointer;" @click="clickCard(data)">{{ data.content }}</div>
                </el-collapse-item>

                </el-collapse>
            </div>

            <!-- 右侧写信按钮一 -->
            <el-button type="primary" icon="el-icon-edit" round id="write_button" @click="dialogFormVisible = true">写信</el-button>

            <!-- 写信弹出框 -->
            <el-dialog title="给我写信" center :visible.sync="dialogFormVisible" :close-on-click-modal="false" id="a2" width="750px" :modal="false">
                <el-form :model="form">

                    <!-- 提示与直接写电子信 -->
                    <p style="clear:both;margin-top:-10px;padding-bottom:40px">
                        <el-alert
                            title="你也可以直接向我发送电子邮件。"
                            type="info"
                            style="width:65%;float:left"
                            :closable="false"
                            show-icon>
                        </el-alert>
                        <a href="mailto:guoyumengcn@gmail.com">
                            <el-button style="float:right" type="success" size="medium" plain>guoyumengcn@gmail.com</el-button>
                        </a>
                    </p>

                    <el-form-item label="信件标题" :label-width="formLabelWidth">
                        <el-input v-model="form.title" autocomplete="off"></el-input>
                    </el-form-item>

                    <el-form-item label="类型" :label-width="formLabelWidth">
                        <el-radio v-model="form.class" label="问题反馈">问题反馈</el-radio>
                        <el-radio v-model="form.class" label="新建议">新建议</el-radio>
                        <el-radio v-model="form.class" label="私人交往">私人交往</el-radio>
                    </el-form-item>

                    <el-form-item label="信件内容" :label-width="formLabelWidth">
                        <el-input
                        type="textarea"
                        :rows="2"
                        placeholder="写你想对我说的话吧"
                        :autosize="{ minRows: 4, maxRows: 8}"
                        v-model="form.content">
                        </el-input>
                    </el-form-item>

                    <el-form-item label="你的联系方式" :label-width="formLabelWidth">
                        <el-input v-model="form.email" autocomplete="off" placeholder="你的联系方式及称呼（选填，推荐邮箱）"></el-input>
                    </el-form-item>
                </el-form>

                <!-- 写信弹框底部按钮 -->
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">取 消</el-button>
                    <el-button type="success" @click="send()">发 出</el-button>
                </div>
            </el-dialog>
        </div>

        

</template>

<script>
  export default {
    data() {
      return {
        activeName: '',
        activeName2: '',
        dialogFormVisible: false,
        formLabelWidth: '120px',
        form: {
          title: '',
            class: '问题反馈',
            textarea: '',
            email: '',
        },
        important_list:[],
        hot_list:[],
      };
    },
    methods: {


        // 留言发送站内信
        send(){
            var that = this;
            this.dialogFormVisible = false;

            var parm = {
                title: this.form.title,
                content: this.form.content,
                class: this.form.class,
                email: this.form.email,
            }

            SDK.Ajax('/add_letter.php',parm,data=>{
                if (data == "OK") {
                    this.$message({
                        type: 'success',
                        message: '发送成功，我看到会及时处理！'
                    });
                    this.form = {
                        title: '',
                        class: '问题反馈',
                        textarea: '',
                        email: '',
                    }
                }

            })

        },

        getData(){
            var that = this;

            SDK.Ajax('/main_Get_Article_Important.php',{},data=>{

                if(data.length > 0){
                    for (let i = 0; i < data.length; i++) {
                        data[i].publish_time = data[i].publish_time.substr(0,16);

                        if (data[i].title.length>19) {
                            data[i].title = data[i].title.substr(0,19)+'...'
                        }
                        if (data[i].content.length) {
                            var re1 = new RegExp("<.+?>","g");//匹配html标签的正则表达式，"g"是搜索匹配多个符合的内容
                            var msg = data[i].content.replace(re1,'');//执行替换成空字符
                            data[i].content = msg;
                        }
                        if (data[i].content.length>100) {
                            data[i].content = data[i].content.substr(0,100)+'...'
                        }
                    }
                }
                this.important_list = data;
            })

            SDK.Ajax('/main_Get_Article_Hot.php',{},data=>{
                if(data.length > 0){
                    for (let i = 0; i < data.length; i++) {
                        data[i].publish_time = data[i].publish_time.substr(0,16);

                        
                        if (data[i].content.length) {
                            var re1 = new RegExp("<.+?>","g");//匹配html标签的正则表达式，"g"是搜索匹配多个符合的内容
                            var msg = data[i].content.replace(re1,'');//执行替换成空字符
                            data[i].content = msg;
                        }
                        if (data[i].content.length>100) {
                            data[i].content = data[i].content.substr(0,100)+'...'
                        }
                    }
                }
                this.hot_list = data;
                this.hot_list.reverse();
            })

        },

        clickCard(data){

            window.location.assign("/article/"+data.aid)
        },

        
    },

    mounted(){
        this.getData();

        
    },
}
</script>

<style scoped>
    #write_button{
        position: absolute;
        right:2%;
        bottom:3%;
        transition: all 0.3s;
    }

    #write_button:hover{
        box-shadow: 0 2px 5px 1px #ccc;
    }

    #index_main_right1{
        margin-top: 10px;
        width: 100%;
        float: right;
    }
    #index_main_right2{
        width: 100%;
        margin-top: 10px;

        float: right;
    }

    .right1_title,.right2_title{
        text-indent: 1em;
        
    }

    .right_title{
        text-indent: 1em;
        background-color:#FFFFFF;
        margin:0;
        padding:10px 0;
        border-bottom:1px solid #ebeef5;
        font-weight: bold;
    }

    #a2{
        background-color:rgba(255,255,255,0.8);
    }
     
    

    



</style>
<style>
    #index_right .el-collapse-item__content{
        padding-bottom: 15px !important;
    }
    #index_right .el-collapse-item__header{
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }
</style>