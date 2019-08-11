<template>
  <div>
    <div id="main" class="register">
      <div id="main_top">
        <h2>Glog用户注册协议</h2>
        <div class="info">
          最后修订时间：
          <span class="el-icon-time"></span> 2019年8月10日
        </div>
        <el-divider></el-divider>
        <div class="protocol">
          <p></p>
          <h4>一、总则</h4>
          <p>1.1 保宝网的所有权和运营权归深圳市永兴元科技有限公司所有。</p>
          <p>1.2 用户在注册之前，应当仔细阅读本协议，并同意遵守本协议后方可成为注册用户。一旦注册成功，则用户与保宝网之间自动形成协议关系，用户应当受本协议的约束。用户在使用特殊的服务或产品时，应当同意接受相关协议后方能使用。</p>
          <p>1.3 本协议则可由保宝网随时更新，用户应当及时关注并同意本站不承担通知义务。本站的通知、公告、声明或其它类似内容是本协议的一部分。</p>
          <h4>二、服务内容</h4>
          <p>2.1 保宝网的具体内容由本站根据实际情况提供。</p>
          <p>2.2 本站仅提供相关的网络服务，除此之外与相关网络服务有关的设备(如个人电脑、手机、及其他与接入互联网或移动网有关的装置)及所需的费用(如为接入互联网而支付的电话费及上网费、为使用移动网而支付的手机费)均应由用户自行负担。</p>
          <h4>三、用户帐号</h4>
          <p>3.1 经本站注册系统完成注册程序并通过身份认证的用户即成为正式用户，可以获得本站规定用户所应享有的一切权限；未经认证仅享有本站规定的部分会员权限。保宝网有权对会员的权限设计进行变更。</p>
          <p>3.2 用户只能按照注册要求使用真实姓名，及身份证号注册。用户有义务保证密码和帐号的安全，用户利用该密码和帐号所进行的一切活动引起的任何损失或损害，由用户自行承担全部责任，本站不承担任何责任。如用户发现帐号遭到未授权的使用或发生其他任何安全问题，应立即修改帐号密码并妥善保管，如有必要，请通知本站。因黑客行为或用户的保管疏忽导致帐号非法使用，本站不承担任何责任。</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {},

  mounted() {}
};
</script>

<style lang="scss" scoped>
#main {
  width: 100%;
  border: 1px solid #ddd;
  box-sizing: border-box;
  a {
    text-decoration: none;
    font-size: 14px;
    color: #409eff;
    margin-left: 10px;
  }
  #main_top {
    background-color: #fff;
    padding: 20px 30px;
    h2 {
      font-size: 22px;
      text-align: center;
    }
    .info {
      margin-top: 20px;
      font-size: 14px;
      color: #999;
    }
    h4{
        font-size: 16px;
        color: #333;
    }
    p {
      font-size: 14px;
      margin: 10px 0;
      color: #333;
      line-height: 1.6em;
      letter-spacing: 0.05em;
      text-indent: 2em;
    }
  }
}
</style>