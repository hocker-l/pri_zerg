<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2019/1/17
 * Time: 14:33
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\model\User;
use app\model\UserAddress as addressModel;
use app\service\Token;
use app\validate\AddressNow;

class Address extends BaseController
{
    protected $beforeActionList=[
        "checkPrimaryScope" =>["only"=>"getUserAddress,createOrUpdateAddress"]
    ];

    public function getUserAddress(){
        $uid =Token::getCurrentUid();
        $addressModel =new addressModel();
        $userAddress= $addressModel->getAddressByUid($uid);
        return $userAddress;
    }
    /**
     * 更新或者创建用户收获地址
     */
    public function createOrUpdateAddress(){
        $validate =new AddressNow();
        $validate->goCheck();
        $uid =Token::getCurrentUid();
        $user =User::get($uid);
        if(!$user){
            throw new UserException([
                'code' => 404,
                'msg' => '用户收获地址不存在',
                'errorCode' => 60001
            ]);
        }
        $data =$validate->getDataByRule(input("post."));
        $address = $user->relatedUserAddress;
        if(!$address){
            $user->relatedUserAddress()
                ->save($data);
        }else{
            $user->relatedUserAddress
                ->save($data);
        }
        throw new SuccessMessage();
    }

}