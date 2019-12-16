<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    
    static $imageCollectionDefault = 'https://cdn.pixabay.com/photo/2016/07/29/04/21/web-1550385_960_720.png';
    static $imageItemDefault = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSbsxrJfwV-P-F2-ZW9f6-PmB9sBI-UCkv8Cl02sQXR5KBzANDEDA&s';

    protected $fillable = ['name','user_id','category_id' ,'collection_id','item_id' ,'certificate_id',];

    

    public function getUrlPathAtribute(){

        return \Storage::url($this->path);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function collection(){
        return $this->belongsTo(Collection::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function certificate(){
        return $this->belongsTo(Certificate::class);
    }

    public function storeImageCategory($request, $id){

        $newimage = new Image();

        $category = Category::find($id);

        if($category->image) {
            $prevImage = $category->image;
            $prevImage->delete();
        }
        
        $base64_image = $request->image;

        $fileName = $newimage->saveImageDisk($request, $base64_image);

         $newimage->name = $fileName;
         $newimage->category_id = $id;
         $newimage->url = "/storage/" . $fileName;
         $newimage->save();  
    }

    function saveImageDisk($request, $base64_image){

        $pos  = strpos($base64_image, ';');
        
        $type = explode('/', substr($base64_image, 0, $pos))[1];
        if ($type == 'jpeg') {$type = 'jpg';};
        $fileName = 'collect-' . $request->collection_id . '-' . rand( 0, 100000) . '.' . $type;

        $image = substr($base64_image, strpos($base64_image, ',') + 1);
        $image = base64_decode($image);
        
        Storage::disk('public')->put($fileName,  $image);

        return $fileName;
    }
 
    public function storeImageCollection($request, $id){

        $newimage = new Image();

        $collection = Collection::find($id);

        if($collection->image) {
            $prevImage = $collection->image;
            $prevImage->delete();
        }
        
        $base64_image = $request->image;

        $fileName = $newimage->saveImageDisk($request, $base64_image);

         $newimage->name = $fileName;
         $newimage->collection_id = $id;
         $newimage->url = "/storage/" . $fileName;
         $newimage->save();        

    }

    function storeImageItem($request, $id){

        $newimage = new Image();

        $item = Item::find($id);
        
        if($item->image) {
            $prevImage = $item->image;
            $prevImage->delete();
        }
        
        $base64_image = $request->image;

        $fileName = $newimage->saveImageDisk($request, $base64_image);

         $newimage->name = $fileName;
         $newimage->item_id = $id;
         $newimage->url = "/storage/" . $fileName;
         $newimage->save();        

    }


    public function storeImageCertificate($request, $id){

        $newimage = new Image();

        $certificate = Certificate::find($id);
        
        if($certificate->image) {
            $prevImage = $certificate->image;
            $prevImage->delete();
        }
        
        $base64_image = $request->image;

        $fileName = $newimage->saveImageDisk($request, $base64_image);

         $newimage->name = $fileName;
         $newimage->certificate_id = $id;
         $newimage->url = "/storage/" . $fileName;
         $newimage->save(); 
    }

    public function storeImageUser($request, $id){

        $newimage = new Image();

        $user = User::find($id);

        if($user->image) {
            $prevImage = $user->image;
            $prevImage->delete();
        }
        
        $base64_image = $request->image;

        $fileName = $newimage->saveImageDisk($request, $base64_image);

         $newimage->name = $fileName;
         $newimage->user_id = $id;
         $newimage->url = "/storage/" . $fileName;
         $newimage->save();  
    }
}
