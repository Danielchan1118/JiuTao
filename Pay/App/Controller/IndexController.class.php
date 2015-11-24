<?php 
/**
 * $name APP调用接口
 * @author DanielChan
 */
namespace App\Controller;
class IndexController extends AppController
{
	 
	/**
	 * $name APP统一入口
	 * 
	 */
	public function HandleAction(){
		$rsadarta = $_POST;	//测试阶段暂时用$_REQUEST，正是上市场必须用$_POST	$_REQUEST	
		$action = trim($rsadarta['action']);
		$method = trim($rsadarta['method']);
		if($action && $method){
			$import = import ( "@.MethodData.".$action."");
			if (!$import) {
				$arr['res'] = -1;
				$arr['error'] = '您访问接口出错';
				$res = json_encode($arr);
			}else{
				$way = new $action();
				if (!method_exists($way,$method)) {
					$arr['res'] = -1;
					$arr['error'] = '您访问的方法不存在';
					$res = json_encode($arr);
				}else{
					switch($action){
						/*
						//登陆
						case 'AppLogin':
							$res = $way -> $method($rsadarta);
						break;
						//商品发布和商品显示
						case 'AppIssue':
							$res = $way -> $method($rsadarta);
						break;
						//搜索列表和搜索信息
						case 'AppSeek':
							$res = $way -> $method($rsadarta);
						break;						
						//个人中心资料
						case 'UserCenter':
							$res = $way -> $method($rsadarta);
						break;
						//收藏
						case 'Collect':
							$res = $way -> $method($rsadarta);
							break;
						*/
						
						/**
						 *AppLogin   登陆
						 *AppIssue   商品发布和商品显示
						 *AppSeek    搜索列表和搜索信息
						 *UserCenter 个人中心资料
						 *Collect    收藏
						*/
						case 'test':
							break;
						default:	
							$res = $way -> $method($rsadarta);
						break;	
					}
				}	
			}
		}else{
			$arr['res'] = ERROR;
			$arr['error'] = '数据出错';
			$res = json_encode($arr);
		}
		echo $res;
	}


}



















?>