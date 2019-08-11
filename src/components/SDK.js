window.SDK = {
    Version: "1.5.1",
    Update: "19.0803.2327",
    AjaxPath: "",   // Ajax请求地址
    AjaxCode: {     // Ajax返回代码表示的意义
        '-1':'暂无角色',
        1:'成功',
        2:'pid异常',
        3:'合作暂停',
        4:'游戏id异常',
        5:'游戏服id异常或未到开服时间',
        6:'用户id异常',
        7:'时间戳参数异常',
        8:'订单号已存在',
        9:'充值金额异常',
        10:'请求类型异常',
        11:'sign错误',
        12:'ip不在白名单',
        13:'支付方式异常',
        14:'注册账号不合法',
        15:'账号已存在',
        16:'密码不符合要求',
        17:'手机号不正确',
        18:'邮箱不正确',
        19:'真实姓名错误',
        20:'身份证号错误',
        21:'手机号已被绑定',
        22:'邮箱已被绑定',
        23:'账号不存在',
        24:'绑定手机号不存在',
        25:'绑定邮箱不存在',
        26:'登陆密码错误',
        27:'登陆受限',
        28:'密保问题不存在',
        29:'密保答案不存在',
        30:'来源异常',
        31:'验证码错误',
        32:'口令错误',
        33:'订单号异常',
        34:'请求超时',
        35:'平台币数量异常',
        36:'礼包编号异常或者礼包不存在',
        37:'没有礼包可领取或礼包已领完',
        38:'优惠卷码错误',
        39:'vip等级不满足要求',
        40:'支付密码未设置或错误',
        41:'积分不足,扣除失败',
        42:'游戏接口不存在或异常',
        43:'未登录站点',
        44:'没有此操作的权限',
        45:'没有调用此接口的权限',
        46:'接口未配置,请在后台配置接口',
        47:'账户为空',
        120:'身份令牌离线',
        121:'身份令牌已被顶下线',
        122:'身份令牌为空',
        123:'身份令牌无效',
        124:'设备类型不匹配',
    },
    MailRule: /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/,
    PhoneRule: /^1[3456789]\d{9}$/,
    IdcardRule: /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/,

    // 打开新页面，是否在新页面打开
    OpenLink: function (link,newPage) {
        if (newPage) {
            top.open(link,"_black");
        }else{
            top.open(link,"_self");
        }
    },

    // 自动调整移动端宽度比例
    AutoWidth: function (width) {
        !function(designWidth){
            if (/Android(?:\s+|\/)(\d+\.\d+)?/.test(navigator.userAgent)) {
                var version = parseFloat(RegExp.$1);
                if (version > 2.3) {
                    var phoneScale = parseInt(window.screen.width) / designWidth;
                    $("head").append($('<meta name="viewport" content="width=' + designWidth + ',minimum-scale=' + phoneScale + ',maximum-scale=' + phoneScale + ', target-densitydpi=device-dpi">'));
                } else {
                    $("head").append($('<meta name="viewport" content="width=' + designWidth + ',target-densitydpi=device-dpi">'));
                }
            } else {
                $("head").append($('<meta name="viewport" content="width=' + designWidth + ',user-scalable=no,target-densitydpi=device-dpi,minimal-ui,viewport-fit=cover">'));
            }
        }(width);
    },

    Json:function (url,parm,func) {
        var num = 0;
        var str = "";
        $.each(parm,function (i,v) {
            if (num == 0) {
                str += "?";
            }else{
                str += "&";
            }
            str += (i + "=" + v);
            num++;
        })
        str += "&callback=?";
        
        
        $.getJSON(SDK.AjaxPath+"/php/"+url + str,func)
    },

    // 发起AJAX请求
    Ajax: function (url,parm,func,async) {
        console.log(SDK.AjaxPath+"/php/"+url,parm);
        
        $.ajax({
            url: SDK.AjaxPath+"/php/"+url,
            data: parm,
            dataType: "json",
            async: async == undefined ? true : async,
            type: "post",
            success: function (sjon) {
                if (typeof func == "function") {
                    func(sjon);
                }
            }
        });
    },

    // AJAX提示
    AjaxTips: function (jon) {
        if (jon.code == 0 || jon.code == "-1") {
            if (jon.msg) {
                return jon.msg;
            }else{
                return "服务器未知错误";
            }
        }else{
            var tip = "";
            $.each(SDK.AjaxCode, function (i, v) {
                if (jon.code == i) {
                    tip =  v;
                }
            })
            return tip;
        }
    },

    // 获取地址栏参数
    GetUrlParm: function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    },

    // 检查IE浏览器
    CheckIE: function () {
        var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串  
        var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器  
        var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器  
        var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
        if(isIE) {
            var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
            reIE.test(userAgent);
            var fIEVersion = parseFloat(RegExp["$1"]);
            if(fIEVersion == 7) {
                return 7;
            } else if(fIEVersion == 8) {
                return 8;
            } else if(fIEVersion == 9) {
                return 9;
            } else if(fIEVersion == 10) {
                return 10;
            } else {
                return 6;//IE版本<=7
            }   
        } else if(isEdge) {
            return 'edge';//edge
        } else if(isIE11) {
            return 11; //IE11  
        }else{
            return -1;//不是ie浏览器
        }
    },

    // 检查是否在QQ客户端中打开
    CheckQQ: function () {
        return navigator.userAgent.toLowerCase().match(/\bqq\b/i) == "qq"
    },

    // 检查是否在微信客户端中打开
    CheckWechat: function () {
        return navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == "micromessenger"
    },

    // 检查是否是安卓设备
    CheckAndroid: function () {
        return navigator.userAgent.indexOf("Android") > -1 || navigator.userAgent.indexOf("Linux") > -1
    },

    // 检查是否是苹果设备
    Checkios: function () {
        return !!navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)
    },

    // 检查是否是移动设备
    CheckMobile: function () {
        var userAgent = navigator.userAgent.toLowerCase();
        var agents = ["android", "iphone", "symbianos", "windows phone", "ipad", "ipod"];
        for (var v = 0; v < agents.length; v++) {
            if (userAgent.indexOf(agents[v]) > 0) {
                return true
            }
        }
        return false
    },

    // 设置Cookies
    setCookie:function (name,value){ 
        var Days = 30; 
        var exp = new Date(); 
        exp.setTime(exp.getTime() + Days*24*60*60*1000); 
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString()+";path=/"; 
    },

    // 获取Cookies
    getCookie:function(name) { 
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg)){
            return unescape(arr[2]); 
        }else{
            return null; 
        }
    },

    //删除Cookies 
    delCookie:function(name) { 
        var exp = new Date(); 
        exp.setTime(exp.getTime() - 1); 
        var cval=getCookie(name); 
        if(cval!=null) 
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    },
}