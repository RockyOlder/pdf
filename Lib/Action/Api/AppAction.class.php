<?php

/* 
 * @athour wangpan 2016.07.07
 * App协议、配置相关接口
 * and open the template in the editor.
 */
class AppAction extends CommonAction {
    
    // URL:
    // http://www.xingyun.com:8080/Api/App/user_agreement
    // 请求方式：get
    // 请求参数：
    // Action ：user_agreement   （固定）   
    // 返回html
    public function user_agreement(){//备用，这个与web端一致

    	$html = 'http://'.$_SERVER['HTTP_HOST'].'/content/80-293.html'; 
    	$arr = array();
    	$arr['url'] = $html;
    	output_datas($arr,array('result' =>"0",'error_code' =>0,'desc'=>'null'));

	}


    // http://www.xingyun.com:8080/Api/App/get_config
    // Action : get_config

     
    // 返回data 
	public function get_config(){


        $html = 'http://'.$_SERVER['HTTP_HOST'].'/content/80-293.html';


         $details=array(
        '0' => array( 

                    "category"=>"AndroidApp",               //分类
                    "title"=>"安卓更新_version_115",            //title
                    "link_url"=> "",                         //如果是App的分类则是下载地址
                    "is_red"=>"0",                          //是否强制更新（0 否 1 是）
                    "version"=>"version",                   //版本
                    "version_no"=>"version_no",             //版要号
                    "content"=>"修改bug"                  //更新描述


            ),
        '1' => array( 

                    "category"=> "IphoneApp",
                    "title"=> "Iphone_version_116",
                    "link_url"=> "",
                    "is_red"=> "1",
                    "version"=> "version_116",
                    "version_no"=> "version_no",
                    "content"=>"新版本新功能"

            ),
        '2' => array( 

                    "category"=> "regist_service",
                    "title"=> "服务协议",
                    "link_url"=> $html, //服务协议的网页地址。
                    "is_red"=> "0",
                    "version"=> "app_regist_service",
                    "version_no"=> "感谢您成为行云全球汇的注册用户。 《行云全球汇服务协议》（以下简称“本协议”）由行云全球汇电商平台（包括PC端、移动端及应用程序）的用户（以下简称“用户或您”）与天行云供应链有限公司共同缔结，本协议具有合同效力。为使用行云全球汇电商平台的各项服务，您应当阅读并…",
                    "content"=> ""

            )
        );

        //dump($details);
        $newarr = array();
        $newarr['result'] = '0';
        $newarr['error_code'] = '0';
        $newarr['desc'] = 'null';
        $newarr['data']['app_update'] = $details;

        $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);
        echo $json;

	}
    
    /*
     * desc:移动端下载链接
     * author：zhangdong
     * date：2016.08.12
     * url:http://tianxy.com/Api/App/uploadApp
     * ***/
    public function uploadApp()
    {
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
        $ipad = strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
        $android = strpos($_SERVER['HTTP_USER_AGENT'], 'Android');
        if($iphone||$ipad){
            $url = 'http://fir.im/XingYunGlobal';
        }else{
            $url = 'http://fir.im/XingYunAndroid';
        }
        header("Location:$url");
    }
    
    /*
     * desc:移动端app下载链接
     * author：zhangdong
     * date：2016.10.13
     * url:http://www.xyb2b.com/Api/App/downloadApp
     * ***/
    public function downloadApp()
    {
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
        $ipad = strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
        $android = strpos($_SERVER['HTTP_USER_AGENT'], 'Android');
        if($iphone||$ipad){
            $url = 'https://itunes.apple.com/us/app/xing-yun-quan-qiu-hui/id1146456845?mt=8';
        }else{
            $url = 'http://php.xyb2b.com/appdown/apk/XingYunGlobal.apk';
        }
        header("Location:$url");
    }

}//end of class