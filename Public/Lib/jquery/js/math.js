define(['myLib'], function(myLib){
function foo(){
return myLib.doSomething();
}
return {
foo : foo
};
});