<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ArticleModel;
use App\Models\Users;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Session;

class adminController extends Controller
{
    public function index(){
        return View('adminLayout.index');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect('adminLayout.contents.product');
        }else{
            return view('adminLayout.contents.auth.login');
        }
    }

    public function action_login(Request $request){

        $users = Users::where('username', $request->username)->first();

        if ($users == null) {
            Session::flash('error', 'Username Salah');
            return redirect()->back();
        }

        $db_password = $users->password;
        if ($db_password == $request->password) {
            $request->session()->put('username', $users->username);
            return to_route('dashboard');
        } else {
            Session::flash('error', 'Username / Password Salah');
            return to_route('login');
        }
    }

    public function action_logout()
    {
        Auth::logout();
 
        request()->session()->invalidate();
 
        request()->session()->regenerateToken();
 
        return redirect('login');
    }

    public function dashboard(){
        $dataProduct = ProductModel::all();
        $dataArticle = ArticleModel::all();
        return view('adminLayout.contents.dashboard', [
            'dataProduct' => $dataProduct,
            'dataArticle' => $dataArticle
        ]);
    }

    public function product(){
        $dataProduct = ProductModel::all();
        return view('adminLayout.contents.product', [
            'dataProduct' => $dataProduct
        ]);
    }

    public function article(){
        $dataArticle = ArticleModel::all();
        return view('adminLayout.contents.article', [
            'dataArticle' => $dataArticle
        ]);
    }

    public function create_product(Request $request){
        // Validasi request
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Save Image to directory
        $file = $request->file('image');
        $namaFile = $file->getClientOriginalName();
        $file->move('assets/img/product',$file->getClientOriginalName());

        $product = ProductModel::create([
            'product_name' => $request->product_name,
            'image' => $namaFile,
            'price' => $request->price,
            'discount' => $request->discount,
            'description' => $request->description,
        ]);

        $product->save();

        if ($product) {
            return redirect()->back()
            ->with('flash_message', 'Produk Baru Berhasil Ditambahkan!')
            ->with('flash_type', 'alert alert-success');
        } else {
            return redirect()->back()
            ->with('flash_message', 'Produk Baru Gagal Ditambahkan!')
            ->with('flash_type', 'alert alert-danger');
        }
    }

    public function delete_product($id){
        // Delete file in directory
        $gambar = ProductModel::where('id',$id)->first();
        File::delete('assets/img/product/'.$gambar->image);
     
        // Delete data in database
        $delete_product = ProductModel::where('id',$id)->delete();
     
        if ($delete_product) {
            return redirect()->back()
            ->with('flash_message', 'Produk Berhasil Dihapus!')
            ->with('flash_type', 'alert alert-success');
        } else {
            return redirect()->back()
            ->with('flash_message', 'Produk Gagal Dihapus!')
            ->with('flash_type', 'alert alert-danger');
        }
        return redirect()->back();
    }

    public function update_product($id){
        $dataProduct = ProductModel::where('id',$id)->get();
        return view('adminLayout.contents.edit.editProduct', [
            'dataProduct' => $dataProduct
        ]);
    }

    public function edit_product(Request $request){
        // Validasi request
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Save Image to directory
        $file =  $request->file('image');

        if($request->oldImage){
            File::delete('assets/img/product/'.$request->oldImage);
        }
    
        $namaFile = $file->getClientOriginalName();
        $file->move('assets/img/product',$file->getClientOriginalName());

        $product = ProductModel::where('id',$request->id)->update([
            'product_name' => $request->product_name,
            'image' => $namaFile,
            'price' => $request->price,
            'discount' => $request->discount,
            'description' => $request->description,
        ]);

        if ($product) {
            return redirect('/admin/product')
            ->with('flash_message', 'Produk Berhasil Diubah!')
            ->with('flash_type', 'alert alert-success');
        } else {
            return redirect('/admin/product')
            ->with('flash_message', 'Produk Gagal Diubah!')
            ->with('flash_type', 'alert alert-danger');
        }
    }

    public function create_article(Request $request){
        // Validasi request
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Save Image to directory
        $file = $request->file('image');
        $namaFile = $file->getClientOriginalName();
        $file->move('assets/img/article',$file->getClientOriginalName());

        $article = ArticleModel::create([
            'article_title' => $request->article_title,
            'image' => $namaFile,
            'description' => $request->description,
            'optional_link' => $request->optional_link,
        ]);

        $article->save();

        if ($article) {
            return redirect()->back()
            ->with('flash_message', 'Artikel Baru Berhasil Ditambahkan!')
            ->with('flash_type', 'alert alert-success');
        } else {
            return redirect()->back()
            ->with('flash_message', 'Artikel Baru Gagal Ditambahkan!')
            ->with('flash_type', 'alert alert-danger');
        }
    }

    public function delete_article($id){
        // Delete file in directory
        $gambar = ArticleModel::where('id',$id)->first();
        File::delete('assets/img/article/'.$gambar->image);
     
        // Delete data in database
        $delete_article = ArticleModel::where('id',$id)->delete();
     
        if ($delete_article) {
            return redirect()->back()
            ->with('flash_message', 'Artikel Berhasil Dihapus!')
            ->with('flash_type', 'alert alert-success');
        } else {
            return redirect()->back()
            ->with('flash_message', 'Artikel Gagal Dihapus!')
            ->with('flash_type', 'alert alert-danger');
        }
        return redirect()->back();
    }

    public function update_article($id){
        $dataArticle = ArticleModel::where('id',$id)->get();
        return view('adminLayout.contents.edit.editArticle', [
            'dataArticle' => $dataArticle
        ]);
    }

    public function edit_article(Request $request){
        // Validasi request
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Save Image to directory
        $file =  $request->file('image');

        if($request->oldImage){
            File::delete('assets/img/article/'.$request->oldImage);
        }
    
        $namaFile = $file->getClientOriginalName();
        $file->move('assets/img/article',$file->getClientOriginalName());

        $article = ArticleModel::where('id',$request->id)->update([
            'article_title' => $request->article_title,
            'image' => $namaFile,
            'description' => $request->description,
            'optional_link' => $request->optional_link,
        ]);

        if ($article) {
            return redirect('/admin/article')
            ->with('flash_message', 'Artikel Berhasil Diubah!')
            ->with('flash_type', 'alert alert-success');
        } else {
            return redirect('/admin/article')
            ->with('flash_message', 'Artikel Gagal Diubah!')
            ->with('flash_type', 'alert alert-danger');
        }
    }
}
