<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
        return view('index');
    }
    public function contact(){
        $categories = Category::all();
        return view('contact' , compact('categories'));
    }

    public function confirm(ContactRequest $request){
        $contact = $request->all();
        $category = Category::find($request->category_id);
        return view('confirm', compact('contact', 'category'));
    }

    public function store(ContactRequest $request){
        if ($request->has('back')){
            return redirect('/')->withInput();
        }
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 
            'tel_1', 'tel_2', 'tel_3', 'address', 
            'building', 'category_id', 'detail'
        ]);
        Contact::create($contact);
        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/admin')->withInput();
        }
        $query = Contact::query();
        $query = $this->getSearchQuery($request, $query);
        $contacts = $query->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    private function getSearchQuery($request, $query)
    {
        // キーワード検索（名前やメールアドレス）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', '%' . $keyword . '%')
                ->orWhere('last_name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere(\DB::raw('CONCAT(last_name, first_name)'), 'like', '%' . $keyword . '%');
            });
        }

        // 性別検索
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // お問い合わせ種類検索
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // 日付検索
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        return $query;
    }

    public function destroy(Request $request){
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }
}
