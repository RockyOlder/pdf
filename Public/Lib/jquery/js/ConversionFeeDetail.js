require.config( {
        paths: {                    //如果某个前缀的依赖不是按照baseUrl拼接这么简单，就需要在这里指出
            payment: 'payment/payment'
        }
//        shim: {                     //引入没有使用requirejs模块写法的类库
//
//            payment: {
//               init:function (){
//                   return { payment:payment}
//               }
//            }
//        }
    });
require(['jquery','payment','common','xcConfirm','tool'], function($,send,common,xcConfirm,tool) {
    //console.log(payment)
    send.init();
//    setInterval(function(){tool.ShowCountDown()},1000);
    tool.ActivityStatistics();
    
});