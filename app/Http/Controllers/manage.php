<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
class manage extends Controller
{
    public function index()
    {
        $class = DB::table('book')->get();
        return view('dashboard',compact('class'));
    }
    public function userr()
    {
        $class = DB::table('book')->get();
        return view('indexing',compact('class'));
    }
    public function create(){
        return view('createbook');
    }

    public function store(Request $request){

        $data=array(
            'Book_Name' =>$request->Book_Name,
            'Author_Name'=>$request->Author_Name,
            'Price'=>$request->Price,
            'file_path'=>$request->file_path
        );

        DB::table('book')->insert($data);
        return redirect()->back()->with('success','Successfully inserted!');
}
public function delete($id){
    DB::table('book')->where('id',$id)->delete();
    return redirect()->back()->with('success','Successfully deleted');
}

public function addcart($id){
    $results = DB::table('book')->where('id', $id)->first();

if ($results) {
    $cartItem = DB::table('cart')->where('id', $results->id)->first();

   
    if (!$cartItem) {
    $data = array(
        'id' => $results->id,
        'Book_Name' => $results->Book_Name,
        'Author_Name' => $results->Author_Name,
        'Price' => $results->Price,
        'file_path' => $results->file_path
       
    );
    
    DB::table('cart')->insert($data);
    }
    else{
        DB::table('cart')->where('id', $cartItem->id)->increment('count');
    }
    
} else {
    // Handle the case where no book with the given ID was found
}
    return redirect()->back();
}
public function addcarts($id){
    
    $results = DB::table('book')->where('id', $id)->first();
    $cartItem = DB::table('cart')->where('id', $results->id)->first();
    DB::table('cart')->where('id', $cartItem->id)->increment('count');
    return redirect()->back();
}
public function deletecart($id){
    $cartItem = DB::table('cart')->where('id', $id)->first();
    if ($cartItem->count > 1) {
        DB::table('cart')->where('id', $cartItem->id)->decrement('count');
    } else {
        DB::table('cart')->where('id', $cartItem->id)->delete();
    }
    return redirect()->back();
}
public function book($id){
    $results = DB::table('book')->where('id',$id)->get();
    return view('display', compact('results'));
    
}
public function cartmanage(){
    $results = DB::table('cart')->get();
    return view('cart',compact('results'));
    
}
public function search(Request $request)
{
    $query = $request->input('query');
    $results = DB::table('book')->where('Book_Name', 'like', '%' . $query . '%')->get();

    return view('index', compact('results'));
}
public function search2(Request $request)
{
    $query = $request->input('query');
    $results = DB::table('book')->where('Book_Name', 'like', '%' . $query . '%')->get();

    return view('index2', compact('results'));
}

public function showDashboard()
{
    $userEmail = auth()->user()->email; // Retrieve the user's email
    $class = DB::table('book')->get();

    return view('dashboard',compact('class'))->with('userEmail', $userEmail);
}
public function bkash()
{
    

    return view('bkash');
}
public function storebkash(Request $request)
{
    

   
        // Retrieve data from the cart table
        $cartItems = DB::table('cart')->get();

        // Insert data into the confirmorder table
        foreach ($cartItems as $cartItem) {
            $data=array([
                'Book_Name' => $cartItem->Book_Name,
                'Author_Name' => $cartItem->Author_Name,
                'Price' => $cartItem->Price,
                'file_path' => $cartItem->file_path,
                'count' => $cartItem->count,
                'user' => $request->name,
            ]);
            DB::table('confirmorder')->insert($data);
        }
        DB::table('cart')->truncate();
        return "Your Order Have Been Placed";
}
public function cartmanageadmin(Request $request)
{
    $orders = DB::table('confirmorder')->get();
    $groupedOrders = collect($orders)->groupBy('user');
    return view('cartmanageadmin', compact('groupedOrders'));
    
}
public function avadd(Request $request)
{
}
public function avdelete($id)
{

    $cartItem = DB::table('book')->where('id', $id)->first();
    if ($cartItem->availability > 0) {
        DB::table('book')->where('id', $cartItem->id)->decrement('availability');
    }
    else{}
    return redirect()->back();
}
public function avadds($id){
    $cartItem = DB::table('book')->where('id', $id)->first();
    DB::table('book')->where('id', $cartItem->id)->increment('availability');
    return redirect()->back();
}
}