<?php
/**
 * Created by PhpStorm.
 * User: lsp
 * Date: 2018/12/26
 * Time: 16:43
 */

namespace app\model;


class Product extends BaseModel
{
    protected $hidden=["delete_time","category_id","main_img_url","from","create_time","update_time","summary","img_id"];
    //关联图片
    public function relatedImage(){
        return self::belongsTo("Image","img_id","id");
    }
    //关联商品详情图片
    public function relatedImageDetail(){
        return self::hasMany("ProductImage","product_id","id");
    }
    //关联商品详情信息
    public function relatedProperty(){
        return self::hasMany("ProductProperty","product_id","id");
    }
    //最近新品方法
    public static function getRecentProducts($count){
       $product  = self::with("relatedImage")->order("create_time desc")->limit($count)->select();
        return $product;
    }
    //通过category_id找到相应商品
    public static function getProductsByCategory($id){
//        $product = self::with("relatedImage")->where("category_id","=",$id)->select();
        $product = self::all(["category_id"=>$id],"relatedImage");
        return $product;
    }
    public static function getProductById($id){
        $product = self::with([
            "relatedImageDetail"=>function($quary){
                $quary->with("relatedProductImg")->order("order","asc");
        }])->with(["relatedImage","relatedProperty"])
            ->where("id","=",$id)
            ->select();
        return $product;
    }
    //通过商品数组ID取得商品信息
    public static function getProductsByIds($ids){
        $products =self::all($ids)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
        return $products;
    }

}