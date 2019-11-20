<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
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

        DB::beginTransaction();
        try{
            //save image

        $newimage = new Image();

        //obtenemos el campo file definido en el formulario
        $image = $request->file('icon');

        //obtenemos el nombre del archivo
        $nombrearchivo = $image->getClientOriginalName();

        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk('local')->put($nombrearchivo,  \File::get($image));

        $newimage->name = $nombrearchivo;
        $newimage->category_id = $id;
        $newimage->save();

        DB::commit();

        return redirect()->back();

        }

        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->with('warning', $e);
        }
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

    static function storeImageItem($request, $id){

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
         $newimage->url = "/storage/" . 'item-' . $fileName;
         $newimage->save();        

    }


    public function storeImageCertificate($request, $id){

        DB::beginTransaction();
        try{
            //save image

        $newimage = new Image();

        //obtenemos el campo file definido en el formulario
        $image = $request->file('image');

        //obtenemos el nombre del archivo
        $nombrearchivo = $image->getClientOriginalName();

        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk('local')->put($nombrearchivo,  \File::get($image));

        $newimage->name = $nombrearchivo;
        $newimage->certificate_id = $id;
        $newimage->save();

        DB::commit();

        return redirect()->back();

        }

        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->with('warning', $e);
        }
    }

    public function storeImageUser($request, $id){

        DB::beginTransaction();
        try{
            //save image

        $newimage = new Image();

        //obtenemos el campo file definido en el formulario
        $image = $request->file('image');

        //obtenemos el nombre del archivo
        $nombrearchivo = $image->getClientOriginalName();

        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk('local')->put($nombrearchivo,  \File::get($image));

        $newimage->name = $nombrearchivo;
        $newimage->user_id = $id;
        $newimage->save();

        DB::commit();

        return redirect()->back();

        }

        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->with('warning', $e);
        }
    }
}
