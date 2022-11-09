<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->with(['category', 'user'])->get();

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();

        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:posts,title',
            'thumbnail' => 'required|image|file|max:2000',
            'content' => 'required|min:15'
        ]);

        try {
            DB::beginTransaction();


            $fileName = $request->thumbnail->store('/uploads/posts', 'public');

            $post = Post::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'thumbnail' => $fileName,
                'content' => $request->content
            ]);

            DB::commit();

            if($post) {
                session()->flash('success', 'Postingan berhasil ditambahkan');
                return redirect('/admin/posts');
            } else {
                session()->flash('error', 'Postingan gagal ditambahkan');
                return back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::latest()->get();

        return view('admin.post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',            
            'content' => 'required|min:15'
        ]);
        
        try {
            DB::beginTransaction();
            $post = Post::find($id);
            $fileName = $post->thumbnail;

            if ($request->thumbnail) {
                $path = 'storage/' . $fileName;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $fileName = $request->thumbnail->store('uploads/posts', 'public');
            }

            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->thumbnail = $fileName;
            $post->content = $request->content;

            $post->update();

            DB::commit();

            if($post) {
                session()->flash('success', 'Postingan berhasil diubah');
                return redirect('/admin/posts');
            } else {
                session()->flash('error', 'Postingan gagal diubah');
                return back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $post = Post::find($id);
            $path = 'storage/' . $post->thumbnail;
            if (File::exists($path)) {
                File::delete($path);
            }

            $post->delete();

            DB::commit();

            if($post) {
                session()->flash('success', 'Postingan berhasil dihapus');
                return redirect('/admin/posts');
            } else {
                session()->flash('error', 'Postingan gagal dihapus');
                return back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
            return back();
        }
    }
}
