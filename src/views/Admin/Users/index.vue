<template>
  <div id="user">
    <!-- 添加用户按钮 -->
    <el-button type="primary" round @click="add()" style="margin-bottom:20px" id="add_btn">添加用户</el-button>

    <!-- 顶部搜索栏 -->
    <div style="float:right" id="search_input">
      <el-input placeholder="请输入内容" v-model="search_input" class="input-with-select">
        <el-select v-model="select" slot="prepend" placeholder="请选择">
          <el-option label="用户名" value="1"></el-option>
          <el-option label="性别" value="2" disabled></el-option>
          <el-option label="国家" value="3" disabled></el-option>
        </el-select>
        <el-button slot="append" icon="el-icon-search" @click="search_user()"></el-button>
      </el-input>
    </div>

    <!-- 新增用户弹出框 -->
    <el-dialog :title="add_dialog_title" :visible.sync="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="用户名" :label-width="formLabelWidth">
          <el-input v-model="form.username" autocomplete="off"></el-input>
        </el-form-item>

        <el-form-item label="密码" :label-width="formLabelWidth">
          <el-input v-model="form.password" autocomplete="off" type="password"></el-input>
        </el-form-item>

        <el-form-item label="地址" :label-width="formLabelWidth">
          <el-input v-model="form.address" autocomplete="off"></el-input>
        </el-form-item>

        <el-form-item label="性别" :label-width="formLabelWidth">
          <el-radio v-model="form.sex" label="男">男</el-radio>
          <el-radio v-model="form.sex" label="女">女</el-radio>
          <el-radio v-model="form.sex" label="保密">保密</el-radio>
        </el-form-item>

        <el-form-item label="出生日期" :label-width="formLabelWidth">
          <div class="block">
            <el-date-picker
              v-model="form.birthday"
              type="date"
              value-format="timestamp"
              :picker-options="pickerOptions1"
              placeholder="选择日期"
            ></el-date-picker>
          </div>
        </el-form-item>

        <el-form-item label="用户类型" :label-width="formLabelWidth">
          <el-select v-model="form.tag" disabled placeholder="请选择">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button
          type="primary"
          @click="add_user(form)"
          :loading="submit_loading"
        >{{add_loading_title}}</el-button>
      </div>
    </el-dialog>

    <!-- 用户表格主体结构 -->
    <el-table :data="tableData" :row-class-name="tableRowClassName" style="width: 100%">
      <!-- 全部信息列表 -->
      
      <el-table-column type="expand">
        <template slot-scope="props">
          <el-form label-position="left" inline class="demo-table-expand">
            <el-form-item label="唯一ID">
              <span>{{ props.row.uid }}</span>
            </el-form-item>
            <el-form-item label="用户名">
              <span>{{ props.row.username }}</span>
            </el-form-item>
            <el-form-item label="密码">
              <span>{{ props.row.password }}</span>
            </el-form-item>
            <el-form-item label="性别">
              <span>{{ props.row.sex }}</span>
            </el-form-item>
            <el-form-item label="年龄">
              <span>{{ props.row.age }}</span>
            </el-form-item>
            <el-form-item label="生日">
              <span>{{ props.row.birthday2 }}</span>
            </el-form-item>
            <el-form-item label="预留地址">
              <span>{{ props.row.address }}</span>
            </el-form-item>
            <el-form-item label="注册地址">
              <span>{{ props.row.dz }}</span>
            </el-form-item>
            <el-form-item label="注册IP">
              <span>{{ props.row.register_ip }}</span>
            </el-form-item>
            <el-form-item label="注册时间">
              <span>{{ props.row.register_data }}</span>
            </el-form-item>
            <el-form-item label="最后修改时间">
              <span>{{ props.row.update_data }}</span>
            </el-form-item>
            <el-form-item label="最后修改IP">
              <span>{{ props.row.update_ip }}</span>
            </el-form-item>
          </el-form>
        </template>
      </el-table-column>

      <el-table-column prop="uid" label="编号" width="100"></el-table-column>

      <el-table-column label="注册时间" width="200">
        <template slot-scope="props">
          <i class="el-icon-time"></i>
          <span style="margin-left: 10px">{{ props.row.register_data.substr(0,10) }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="username" label="姓名"></el-table-column>

      <el-table-column prop="sex" width="100" label="性别"></el-table-column>

      <el-table-column prop="age" label="年龄"></el-table-column>

      <el-table-column prop="dz" label="注册地址"></el-table-column>

      <el-table-column width="250" label="操作">
        <template slot-scope="props">
          <el-button size="mini" type="primary" @click="handleEdit(props.$index, props.row)">更新</el-button>
          <el-button
            size="mini"
            type="warning"
            v-if="props.row.state == 0"
            @click="handleStop(props.$index, props.row)"
          >停用</el-button>
          <el-button
            size="mini"
            type="success"
            v-if="props.row.state == 1"
            @click="handleStart(props.$index, props.row)"
          >启用</el-button>
          <el-button size="mini" type="danger" @click="handleDelete(props.$index, props.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- 用户分页 -->
    <div class="block">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage1"
        :page-size="pageSize"
        :background="true"
        layout="total, prev, pager, next"
        style="display:flex; justify-content:center; margin-top:20px"
        :total="dataNum"
      ></el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {

      add_loading_title: "提 交",
      submit_loading: false,
      add_dialog_title: "新增用户",
      search_input: "",
      select: "",
      pageSize: 10,
      pageVal: 1,
      dataNum: 0,
      now: "",
      data: {},
      tableData: [],
      dialogFormVisible: false,
      formLabelWidth: "120px",
      currentPage1: 5,
      options: [
        {
          value: "标准用户",
          label: "标准用户"
        }
      ],
      form: {
        username: "",
        tag: "",
        birthday: "",
        password: "",
        sex: "男",
        address: ""
      },
      pickerOptions1: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      }
    };
  },
  methods: {
    // 检查是否停用
    tableRowClassName({ row, rowIndex }) {
      if (row.state == 1) {
        return "warning-row";
      }
      return "";
    },

    // 提交搜索按钮
    search_user() {
      if (this.select == 1) {
        this.getList();
      }
    },

    // 更改每页条数
    handleSizeChange(val) {},

    // 更改页码
    handleCurrentChange(val) {
      this.pageVal = val;
      this.getList();
    },

    // 点击添加按钮
    add() {
      this.dialogFormVisible = true;
      this.add_dialog_title = "新增用户";
      this.now = "add";
    },

    // 获取用户数据列表
    getList() {
      var that = this;
      // 获取数据内容
      var data = new FormData();
      data.append("pageSize", this.pageSize);
      data.append("pageVal", this.pageVal);
      data.append("name", this.search_input);
      this.axios
        .post(that._path.php_path + "/php/getData.php", data)
        .then(res => {
          if (res.data.length > 0) {
            for (let i = 0; i < res.data.length; i++) {
              res.data[i].dz = `${res.data[i].province} ${res.data[i].city}`;
              res.data[i].age =
                Math.floor(
                  (Date.parse(new Date()) / 1000 - res.data[i].birthday) /
                    (60 * 60 * 24 * 365)
                ) + "岁";
              res.data[i].birthday2 = new Date(
                res.data[i].birthday * 1000
              ).Format("yyyy 年 M 月 d 日");
            }
          }
          that.tableData = res.data;
        });
      // 获取数据总量
      var data = new FormData();
      data.append("name", this.search_input);
      this.axios
        .post(that._path.php_path + "/php/getDataNum.php", data)
        .then(res => {
          this.dataNum = res.data;
        });
    },

    // 编辑用户
    handleEdit(index, row) {
      this.now = "edit";
      this.add_dialog_title = "修改用户";
      this.form = {
        uid: row.uid,
        username: row.username,
        tag: "",
        birthday: String(row.birthday * 1000),
        password: row.password,
        sex: row.sex,
        address: row.address
      };
      this.dialogFormVisible = true;
    },

    // 停用用户
    handleStop(index, row) {
      var that = this;
      var data = new FormData();
      data.append("uid", row.uid);
      data.append("state", 1);
      this.axios
        .post(that._path.php_path + "/php/state.php", data)
        .then(res => {
          this.$message({
            type: "success",
            message: "停用成功!"
          });
          this.getList();
        });
    },

    // 启用用户
    handleStart(index, row) {
      var that = this;
      var data = new FormData();
      data.append("uid", row.uid);
      data.append("state", 0);
      this.axios
        .post(that._path.php_path + "/php/state.php", data)
        .then(res => {
          this.$message({
            type: "success",
            message: "启用成功!"
          });
          this.getList();
        });
    },

    // 删除用户处理
    handleDelete(index, row) {
      var that = this;
      var data = new FormData();
      data.append("delete_id", row.uid);

      this.$confirm("此操作将永久删除该用户, 是否继续?", "警告", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "error"
      })
        .then(() => {
          this.axios
            .post(that._path.php_path + "/php/deluser.php", data)
            .then(res => {
              this.$message({
                type: "success",
                message: "删除成功!"
              });
              this.getList();
            });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除"
          });
        });
    },

    // 提交新增/搜索表单
    add_user() {
      var that = this;
      if (this.now == "add") {
        $.ajax({
          url: that._path.php_path + "/php/check_user_reg.php", //url路径
          type: "POST", //GET
          async: false, //或false,是否异步
          dataType: "json", //返回的数据格式：
          data: {
            //参数
            username: this.form.username
          },

          success: function(data) {
            if (data.length !== 0) {
              that.$message({
                message: "用户名已存在，请重新选择用户名。",
                type: "error"
              });
            } else {
              that.add_user_2();
            }
          }
        });
      } else {
        that.add_user_2();
      }
    },

    add_user_2() {
      var that = this;

      that.submit_loading = true;
      var data = new FormData();
      that.add_loading_title = "提交中";
      data.append("username", that.form.username);
      data.append("password", that.form.password);
      data.append("sex", that.form.sex);
      data.append("address", that.form.address);
      data.append("birthday", that.form.birthday);
      data.append("now", that.now);
      data.append("uid", that.form.uid);

      data.append("province", "NULL");
      data.append("city", "NULL");
      data.append("register_ip", "NULL");

      // 将数据提交至服务器
      that.axios
        .post(that._path.php_path + "/php/adduser.php", data)
        .then(res => {
          that.dialogFormVisible = false;
          that.submit_loading = false;
          that.add_loading_title = "提 交";
          that.$message({
            type: "success",
            message: "添加成功!"
          });
          that.form = {
            username: "",
            tag: "",
            birthday: "",
            password: "",
            sex: "男",
            address: ""
          };
          that.getList();
        })
        .catch(res => {
          that.submit_loading = false;
          that.add_loading_title = "提 交";
          that.$message({
            type: "error",
            message: "添加失败!"
          });
        });
    }
  },
  mounted() {
    this.getList();
    // 自动调整搜索框长度
    window.onresize = function() {
      document.getElementById("search_input").style.width =
        document.documentElement.clientWidth -
        document.getElementById("add_btn").offsetWidth -
        70 +
        "px";
    };
    // 延时调整一次
    window.setTimeout(function() {
      document.getElementById("search_input").style.width =
        document.documentElement.clientWidth -
        document.getElementById("add_btn").offsetWidth -
        70 +
        "px";
    }, 0);
  }
};
</script>

<style scoped>
.el-select .el-input {
  width: 130px;
}
.input-with-select .el-input-group__prepend {
  background-color: #fff;
}

.demo-table-expand {
  font-size: 0;
}
.demo-table-expand label {
  width: 100px;
  color: #99a9bf;
}
.demo-table-expand .el-form-item {
  margin-right: 0;
  margin-bottom: 0;
  width: 33.33%;
}

.el-table .warning-row {
  background: oldlace;
  color: #f56c6c;
}
</style>
<style>
#search_input .el-input--suffix {
  width: 100px !important;
}
</style>