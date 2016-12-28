<?php

class TotalAction extends CommonAction{
  public function lists(){
    $this->display();
  }

  public function ceshi(){
    /*$c = 'CCB';
    $a = M('bank');
    $arr = M('member') -> join('t_bank ON t_bank.fanhui = t_member.return') -> find();
    foreach($arr as $key=>$value){
      $fanhui[$key]=$value;
    }
    $str = $bank['bankaccout'];
    $str1 = substr($str,(strlen($str)-4));
    dump($str1);
    dump($fanhui['name']) ;
    dump($fanhui['photo']);die;*/
    //冒泡排序
    /*arr=array(23,5,26,4,9,85,10,2,55,44,21,39,11,16,55,88,421,226,588);
    $n =count($arr);
    for($h=0;$h<$n-1;$h++){//外层循环n-1

      for($i=0;$i<$n-$h-1;$i++){

        if($arr[$i]>$arr[$i+1]){//判断数组大小，颠倒位置

          $kong=$arr[$i+1];

          $arr[$i+1]=$arr[$i];

          $arr[$i]=$kong;
        }
      }
    }
    dump($arr);*/
    /*$a = '14e1b600b1fd579,f47433b88,e8d85291';
    $str = explode(',', $a);
    foreach($str as $key=>$value){
       $fanhui[$key]=$value;
     }
    dump($str['0']);
    dump($str['1']);
    dump($str);die;*/

  }
}

?>