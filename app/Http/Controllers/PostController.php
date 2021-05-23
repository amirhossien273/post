<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostResourceCollection
     */
    public function index()
    {
        return new PostResourceCollection(Post::where('user_id', auth()->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
         $user = auth()->user()->id;
        try {
         Post::create([
             'user_id'     => $user,
             'title'       => $request->title,
             'comment'     => $request->comment,
        ]);
        }catch (\Exception $e){
            return response()->json([ 'data' => [ 'error' => true, 'message' => 'فرم شما با خطا مواجه شد لطفا دوباره تلاش کنید.' ]], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
        return response()->json([ 'data' => [ 'success' => true, 'message' => 'اطلاعات شما با موفقیت ثبت شد' ]], Response::HTTP_OK );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function show($id)
    {
        return new PostResource(Post::where([['id', '=', $id],['user_id' , '=' , auth()->user()->id]])->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, $id)
    {
        $user = auth()->user()->id;
        try {
        Post::where( 'id', $id )->update([
            'user_id'     => $user,
            'title'       => $request->title,
            'comment'     => $request->comment,
        ]);
        }catch (\Exception $e){
            return response()->json([ 'data' => [ 'error' => true, 'message' => 'ویرایش شما با خطا مواجه شد لطفا دوباره تلاش کنید' ]], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
        return response()->json([ 'data' => [  'success' => true, 'message' => 'اطلاعات شما با موفقیت ویرایش گردید.' ]], Response::HTTP_OK );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $post = Post::where( 'id', $id )->first();

        $post->delete();
        return response()->json( ['data' => [ 'message' => 'با موفقیت رکورد شما حذف شد.' ]], Response::HTTP_OK );
    }
}
