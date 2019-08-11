<template>
    <div id="home_index" style="display:flex;justify-content:space-around;">
        <div>
            <p>过去24小时访问流量：<el-tag size="medium">{{num}}</el-tag></p>
            <p>过去24小时的访问时间段：</p>
            <div id="progress">
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t0_3" color="#2F2F4F"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t3_6" color="#2F2F4F"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t6_9" color="#67C23A"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t9_12" color="#67C23A"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t12_15" color="#FF7F00"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t15_18" color="#FF7F00"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t18_21" color="#007FFF"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="time_show.t21_24" color="#007FFF"></el-progress>
            </div>
        </div>
        <div>
            <p>过去30天访问流量：<el-tag size="medium">{{all_num}}</el-tag></p>
            <p>过去30天的访问时间段：</p>
            <div id="progress">
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t0_3" color="#2F2F4F"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t3_6" color="#2F2F4F"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t6_9" color="#67C23A"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t9_12" color="#67C23A"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t12_15" color="#FF7F00"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t15_18" color="#FF7F00"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t18_21" color="#007FFF"></el-progress>
                <el-progress :text-inside="true" :stroke-width="18" :percentage="all_time_show.t21_24" color="#007FFF"></el-progress>
            </div>
        </div>

        

    </div>
</template>

<script>
  export default {
    data() {
      return {
          num:0,
          all_num:0,
          time:{
              t0_3:0,
              t3_6:0,
              t6_9:0,
              t9_12:0,
              t12_15:0,
              t15_18:0,
              t18_21:0,
              t21_24:0
          },
          time_show:{},
          all_time:{
              t0_3:0,
              t3_6:0,
              t6_9:0,
              t9_12:0,
              t12_15:0,
              t15_18:0,
              t18_21:0,
              t21_24:0
          },
          all_time_show:{},
      };
    },
    methods: {

        get_visit(){
            var that = this;

            // 将数据提交至服务器
            var data = new FormData();
            data.append("old",0);
            this.axios.post(that._path.php_path+"/php/get_visit.php",data).then(res=>{
                this.all_num = res.data.length;
                
                for (let i = 0; i < res.data.length; i++) {
                    var this_all_time = (((Number(res.data[i].time)+(3600*8))%86400)/3600);
                    if (this_all_time <= 3) {
                        that.all_time.t0_3++;
                    }else if(this_all_time <= 6){
                        that.all_time.t3_6++;
                    }else if(this_all_time <= 9){
                        that.all_time.t6_9++;
                    }else if(this_all_time <= 12){
                        that.all_time.t9_12++;
                    }else if(this_all_time <= 15){
                        that.all_time.t12_15++;
                    }else if(this_all_time <= 18){
                        that.all_time.t15_18++;
                    }else if(this_all_time <= 21){
                        that.all_time.t18_21++;
                    }else if(this_all_time <= 24){
                        that.all_time.t21_24++;
                    } 
                }

                this.all_time_show = {
                    t0_3: Math.round((this.all_time.t0_3/this.all_num)*100),
                    t3_6: Math.round((this.all_time.t3_6/this.all_num)*100),
                    t6_9: Math.round((this.all_time.t6_9/this.all_num)*100),
                    t9_12: Math.round((this.all_time.t9_12/this.all_num)*100),
                    t12_15: Math.round((this.all_time.t12_15/this.all_num)*100),
                    t15_18: Math.round((this.all_time.t15_18/this.all_num)*100),
                    t18_21: Math.round((this.all_time.t18_21/this.all_num)*100),
                    t21_24: Math.round((this.all_time.t21_24/this.all_num)*100),
                }
                

                
            })

            var data = new FormData();
            data.append("old",1);
            this.axios.post(that._path.php_path+"/php/get_visit.php",data).then(res=>{

                this.num = res.data.length;
                for (let i = 0; i < res.data.length; i++) {
                    var this_time = (((Number(res.data[i].time)+(3600*8))%86400)/3600);
                    if (this_time <= 3) {
                        that.time.t0_3++;
                    }else if(this_time <= 6){
                        that.time.t3_6++;
                    }else if(this_time <= 9){
                        that.time.t6_9++;
                    }else if(this_time <= 12){
                        that.time.t9_12++;
                    }else if(this_time <= 15){
                        that.time.t12_15++;
                    }else if(this_time <= 18){
                        that.time.t15_18++;
                    }else if(this_time <= 21){
                        that.time.t18_21++;
                    }else if(this_time <= 24){
                        that.time.t21_24++;
                    }
                }

                this.time_show = {
                    t0_3: Math.round((this.time.t0_3/this.num)*100),
                    t3_6: Math.round((this.time.t3_6/this.num)*100),
                    t6_9: Math.round((this.time.t6_9/this.num)*100),
                    t9_12: Math.round((this.time.t9_12/this.num)*100),
                    t12_15: Math.round((this.time.t12_15/this.num)*100),
                    t15_18: Math.round((this.time.t15_18/this.num)*100),
                    t18_21: Math.round((this.time.t18_21/this.num)*100),
                    t21_24: Math.round((this.time.t21_24/this.num)*100),
                }
           
                
            })
            
        }
    },

    mounted(){

        this.get_visit();


    }
}
</script>

<style lang="scss">

    #progress{
        width: 300px;
        >*{
            margin: 5px 0;
        }

    }
    

    
</style>