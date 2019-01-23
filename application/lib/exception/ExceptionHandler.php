<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/25
 * Time: 16:57
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    protected $code;
    protected $msg;
    protected $errorCode;
    public function render(Exception $e)
    {
        if($e instanceof BaseException){
            $this->code=$e->code;
            $this->msg=$e->msg;
            $this->errorCode=$e->errorCode;
        }else{
            if(config("app_debug")){
               return parent::render($e);
            }else{
                $this->code=500;
                $this->msg="服务器内部错误，不想告诉你";
                $this->errorCode=999;
                $this->seveErrorLog($e);
            }
        }
        $request = Request::instance();
        $result=[
            "msg" =>$this->msg,
            "errorCode" =>$this->errorCode,
            "url" =>$request->url()
        ];
//        echo $e->code;
//        exit();
        return json($result,$this->code);
    }
    public function seveErrorLog(Exception $e){
        Log::init([
            'type'  => 'File',
            // 日志保存目录
            'path'  => LOG_PATH,
            // 日志记录级别
            'level' => [],
        ]);
        Log::record($e->getMessage(),"error");
    }



}