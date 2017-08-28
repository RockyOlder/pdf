<?php
define('GYFX', true);
define('APP_DEBUG', true);
//启动thinkphp
define('APP_PATH', dirname(__FILE__).'/../../../../vpdf/');
//设置标志，防止程序启动，只要加载了框架和类就行
define('APP_PHPUNIT', true);
// 引入ThinkPHP入口文件
require_once dirname(__FILE__).'/../../../ThinkPHP/ThinkPHP.php';
C('db_name','v78');
C('db_prefix','fx_');
class ArrayTest extends PHPUnit_Framework_TestCase  
{  
        public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
//    public function testNewArrayIsEmpty()  
//    {  
//        // 创建数组fixture。  
//        $fixture = array();  
//   
//        // 断言数组fixture的尺寸是0。  
//        $this->assertEquals(0, sizeof($fixture));  
//    }  
//    public function testEmpty()
//    {
// 
//        $this->assertEmpty($stack);
//
//        return $stack;
//    }
//    /**
//     * @depends testEmpty
//     */
//    public function testPush(array $stack)
//    {
//        array_push($stack, 'foo');
//        $this->assertEquals('foo', $stack[count($stack)-1]);
//        $this->assertNotEmpty($stack);
//
//        return $stack;
//    }
//
//    /**
//     * @depends testPush
//     */
//    public function testPop(array $stack)
//    {
//        $this->assertEquals('foo', array_pop($stack));
//        $this->assertEmpty($stack);
//    }
//    public function testOne()
//    {
//        $this->assertTrue(false);
//    }
//
//    /**
//     * @depends testOne
//     */
//    public function testTwo()
//    {
//    }
//      public function testProducerFirst()
//    {
//        $this->assertTrue(true);
//        return 'first';
//    }
//
//    public function testProducerSecond()
//    {
//        $this->assertTrue(true);
//        return 'second';
//    }
//
//    /**
//     * @depends testProducerFirst
//     * @depends testProducerSecond
//     */
//    public function testConsumer()
//    {
//        $this->assertEquals(
//            ['first', 'second'],
//            func_get_args()
//        );
//    }
//    public function testGetValue()
//{
//
////$this->assertEmpty($stack);
//}
    /**
     * 单元测试 DataMemberSaveCookie 方法 success
     * @author Rocky
     */
    public function testMemberSaveCookieSuccess() {  
       $actual = D('MemberCookie')->TestDataMemberSaveCookie(array('m_id'=>4),array('key'=>'bd955ff82a24c883f419b1cdf6bf91e2'));
       $this->assertEquals($actual, 1);  
    }  
    /**
     * 单元测试 DataMemberSaveCookie 方法 Fail
     * @author Rocky
     */
    public function testMemberSaveCookieFail() {  
       $actual = D('MemberCookie')->TestDataMemberSaveCookie(array('m_id'=>0),array('key'=>'bd955ff82a24c883f419b1cdf6bf91e2'));
       $this->assertEquals(0, $actual);  
    } 
    /**
     * 单元测试 DataMemberSaveCookie 方法 Fail
     * @author Rocky
     */
    public function testDataMemberAddCookieFail() {  
       $actual = D('MemberCookie')->TestDataMemberAddCookie();
       $this->assertEquals(false, $actual);  
    } 
    /**
     * 单元测试 DataMemberSaveCookie 方法 Fail
     * @author Rocky
     */
    public function testGetModelMemberCookieEnquiries() {  
       $actual = D('MemberCookie')->TestGetModelMemberCookieEnquiries(array('m_id'=>4));
       if(!empty($actual)){
           $data = true;
       } else {
           $data = false;
       }
       $this->assertEquals($data, true);  
    } 
}  
    ?>